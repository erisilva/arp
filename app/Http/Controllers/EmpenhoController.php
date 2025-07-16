<?php

namespace App\Http\Controllers;

use App\Models\Empenho;
use App\Models\Mapa;
use App\Models\Log;
use Illuminate\Http\Request;

class EmpenhoController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('empenho-create');

        $validated = $request->validate([
            'cota_id' => 'required|integer|exists:mapas,cota_id',
            'quantidade' => 'required|numeric|min:1',
        ]);

        if ($validated === false) {
            return redirect()
                ->route('empenhos.show', ['id' => $request->input('cota_id')])
                ->withErrors($request->validator)
                ->withInput();
        }

        $empenho = new Empenho();
        $empenho->cota_id = $request->input('cota_id');
        $empenho->user_id = auth()->id();
        $empenho->quantidade = $request->input('quantidade');
        $empenho->save();

        return view('empenhos.show', [
            'cota' => Mapa::where('cota_id', $request->input('cota_id'))->firstOrFail(),
            'empenhos' => Empenho::where('cota_id', $request->input('cota_id'))
                ->orderBy('created_at', 'desc')->get(),
        ])->with('message', 'Empenho criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //verificar se tem permissão para ver os empenhos
        $this->authorize('empenho-show');

        return view('empenhos.show', [
            'cota' => Mapa::where('cota_id', $id)->firstOrFail(),
            'empenhos' => Empenho::where('cota_id', $id)
                ->orderBy('created_at', 'desc')->get(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->authorize('empenho-create');

        $request->validate([
            'empenho_id_editar' => 'required|integer|exists:empenhos,id',
            'cota_id_editar' => 'required|integer|exists:mapas,cota_id',
            'quantidade_editar' => 'required|numeric|min:1',
        ]);

        $empenho = Empenho::findOrFail($request->input('empenho_id_editar'));

        //LOG
        Log::create([
            'model_id' => $empenho->id,
            'model' => 'Empenho',
            'action' => 'store',
            'changes' => json_encode($empenho), // guardar o valor original no log
            'user_id' => auth()->id(),
        ]);

        $empenho->cota_id = $request->input('cota_id_editar');
        $empenho->quantidade = $request->input('quantidade_editar');
        $empenho->save();

        return view('empenhos.show', [
            'cota' => Mapa::where('cota_id', $request->input('cota_id_editar'))->firstOrFail(),
            'empenhos' => Empenho::where('cota_id', $request->input('cota_id_editar'))
                ->orderBy('created_at', 'desc')->get(),
        ])->with('message', 'Empenho atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('empenho-delete');

        $request->validate([
            'empenho_id_excluir' => 'required|integer|exists:empenhos,id',
            'cota_id_excluir' => 'required|integer|exists:mapas,cota_id',
        ]);

        $empenho = Empenho::findOrFail($request->input('empenho_id_excluir'));

        // Log
        Log::create([
            'model_id' => $empenho->id,
            'model' => 'Empenho',
            'action' => 'destroy',
            'changes' => json_encode($empenho),
            'user_id' => auth()->id(),
        ]);

        $empenho->delete();

        return view('empenhos.show', [
            'cota' => Mapa::where('cota_id', $request->input('cota_id_excluir'))->firstOrFail(),
            'empenhos' => Empenho::where('cota_id', $request->input('cota_id_excluir'))
                ->orderBy('created_at', 'desc')->get(),
        ])->with('message', 'Empenho excluído com sucesso!');


    }
}
