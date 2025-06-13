<?php

namespace App\Http\Controllers;

use App\Models\Mapa;
use Illuminate\Http\Request;

use App\Models\Perpage;
use App\Models\Arp;
use App\Models\Item;


class MapaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('mapa-index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('mapas.index', [
            'mapas' => Mapa::orderBy('arp', 'asc')
                ->orderBy('objeto', 'asc')
                ->filter(request(['arp', 'pac', 'pe', 'vigencia_inicio', 'vigencia_fim', 'vigencia', 'sigma', 'objeto', 'setor']))
                ->paginate(session('perPage', '5'))
                ->appends(request(['arp', 'pac', 'pe', 'vigencia_inicio', 'vigencia_fim', 'vigencia', 'sigma', 'objeto', 'setor']))
                ->withPath(env('APP_URL', null) . '/arps'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Mapa $mapa)
    {
        $this->authorize('mapa-show');

        $arp = Arp::findOrFail($mapa->id);
        if (!$arp) {
            abort(404, 'ARP not found');
        }

        return view('mapas.show', [
            'arp' => $arp,
            'items' => Item::where('arp_id', $arp->id)->get()
        ]);
    }

}
