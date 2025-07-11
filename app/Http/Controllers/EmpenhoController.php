<?php

namespace App\Http\Controllers;

use App\Models\Empenho;
use App\Models\Mapa;
use Illuminate\Http\Request;

class EmpenhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
     * Show the form for editing the specified resource.
     */
    public function edit(Empenho $empenho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empenho $empenho)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empenho $empenho)
    {
        //
    }
}
