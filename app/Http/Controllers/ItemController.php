<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Log;
use Illuminate\Http\Request;

class ItemController extends Controller
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
        $this->authorize('item-create');

        $item = $request->validate([
            'arp_id' => 'required|int|exists:arps,id',
            'objeto_id' => 'required|int|exists:objetos,id',
        ]);

        $new_item = Item::create($item);

        // LOG
        Log::create([
            'model_id' => $new_item->id,
            'model' => 'Item',
            'action' => 'store',
            'changes' => json_encode($new_item),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('arps.edit', $new_item->arp_id))->with('message','Objeto adicionado ao arp com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('item-delete');

        $input = $request->validate([
            'item_id_item_delete' => 'required|int|exists:items,id',
        ]);

        $item = Item::find($input['item_id_item_delete']);

        $arp_item = $item->arp_id;

        // LOG
        Log::create([
            'model_id' => $item->id,
            'model' => 'Item',
            'action' => 'destroy',
            'changes' => json_encode($item),
            'user_id' => auth()->id(),
        ]);

        if ($item) {
            try {
                $item->delete();
            } catch (\Exception $e) {
                return redirect(route('arps.edit', $arp_item))->with('message','Failed to delete item: ' . $e->getMessage());
            }
        } else {
            return redirect(route('arps.edit', $arp_item))->with('message','Item not found.');
        }

        return redirect(route('arps.edit', $arp_item))->with('message','Objeto removido com sucesso!');

    }
}
