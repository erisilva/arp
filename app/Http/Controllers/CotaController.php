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

        $cota = $request->validate([
            'item_id' => 'required|int|exists:items,id',
            'setor_id' => 'required|int|exists:setors,id',
            'quantidade' => 'required|int|min:1',
        ]);

        $new_cota = Cota::create($cota);

        // LOG
        Log::create([
            'model_id' => $new_cota->id,
            'model' => 'Cota',
            'action' => 'store',
            'changes' => json_encode($new_cota),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('arps.edit', $new_cota->item->arp_id))->with('message','Cota adicionada ao setor com sucesso!');
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
    public function update(Request $request, Cota $cota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Cota $cota)
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

        $cota->delete();

        return redirect(route('arps.edit', $input['arp_id']))->with('message','Cota removida com sucesso!');
    }

}
