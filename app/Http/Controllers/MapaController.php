<?php

namespace App\Http\Controllers;

use App\Models\Mapa;
use Illuminate\Http\Request;

use App\Models\Perpage;


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
        //
    }

}
