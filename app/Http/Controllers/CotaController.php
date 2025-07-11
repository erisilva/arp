<?php

namespace App\Http\Controllers;

use App\Models\Cota;
use App\Models\Log;
use Illuminate\Http\Request;

class CotaController extends Controller
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
        $this->authorize('cota-create');

        //dd($request->all());

        $input = $request->validate([
            'item_id' => 'required|int|exists:items,id',
            'setor_id' => 'required|int|exists:setors,id',
            'arp_id_criar' => 'required|int|exists:arps,id',
            'quantidade' => 'required|int|min:1',
        ]);

        # verifica se já existe cota cadastrada para esse setor e item
        $existingCota = Cota::where('item_id', $input['item_id'])
            ->where('setor_id', $input['setor_id'])
            ->first();

        if ($existingCota) {
            return redirect(route('arps.edit', $input['arp_id_criar']))->with('message', 'Já existe uma cota cadastrada para este setor e item.');
        }

        $input['empenho'] = 0;
        $new_cota = Cota::create($input);

        // LOG
        Log::create([
            'model_id' => $new_cota->id,
            'model' => 'Cota',
            'action' => 'store',
            'changes' => json_encode($new_cota),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('arps.edit', $input['arp_id_criar']))->with('message','Cota adicionada ao setor com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cota $cota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cota $cota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->authorize('cota-edit');

        $input = $request->validate([
            'arp_id_editar' => 'required|int|exists:arps,id',
            'cota_id_editar' => 'required|int|exists:cotas,id',
            'quantidade_editar' => 'required|int|min:1',

        ]);

        $cota = Cota::find($input['cota_id_editar']);
        $cota->quantidade = $request->quantidade_editar;
        $cota->save();

        // LOG
        Log::create([
            'model_id' => $cota->id,
            'model' => 'Cota',
            'action' => 'update',
            'changes' => json_encode($cota),
            'user_id' => auth()->id(),
        ]);



        return redirect(route('arps.edit', $input['arp_id_editar']))->with('message','Cota atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('cota-delete');

        $input = $request->validate([
            'arp_id' => 'required|int|exists:arps,id',
            'cota_id' => 'required|int|exists:cotas,id'
        ]);

        $cota = Cota::find($input['cota_id']);

        // LOG
        Log::create([
            'model_id' => $cota->id,
            'model' => 'Cota',
            'action' => 'delete',
            'changes' => json_encode($cota),
            'user_id' => auth()->id(),
        ]);

        try {
            // Exclui todos os empenhos relacionados à cota
            $cota->empenhos()->delete();

            // Exclui a cota
            $cota->delete();
        } catch (\Exception $e) {
            return redirect(route('arps.edit', $input['arp_id']))
            ->with('message', 'Erro ao remover cota e seus empenhos: ' . $e->getMessage());
        }

        return redirect(route('arps.edit', $input['arp_id']))->with('message','Cota removida com sucesso!');
    }

}
