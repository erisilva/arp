<?php

namespace App\Http\Controllers;

use App\Models\Arp;
use App\Models\ArpView;
use App\Models\Item;
use App\Models\Objeto;
use App\Models\Perpage;
use App\Models\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ArpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('arp-index');

        //dd(session()->all());

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('arps.index', [
            'arps' => ArpView::orderBy('arp', 'asc')
                ->orderBy('objeto', 'asc')
                ->filter(request(['arp', 'pac', 'pe', 'vigencia_inicio', 'vigencia_fim', 'vigencia', 'sigma', 'objeto']))
                ->paginate(session('perPage', '5'))
                ->appends(request(['arp', 'pac', 'pe', 'vigencia_inicio', 'vigencia_fim', 'vigencia', 'sigma', 'objeto']))
                ->withPath(env('APP_URL', null) . '/arps'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('arp-create');

        return view('arps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('arp-create');

        $arp = $request->validate([
            'arp' => 'required|max:10|unique:arps,arp',
            'pac' => 'required|max:10',
            'pe' => 'required|max:10',
            'vigenciaInicio' => 'required|date_format:d/m/Y',
            'vigenciaFim' => 'required|date_format:d/m/Y',
            'sigma' => 'required|max:10',
            'objeto' => 'required|max:150',
            'valor' => 'required',
        ]);

        $arp['vigenciaInicio'] = date('Y-m-d', strtotime(str_replace('/', '-', $arp['vigenciaInicio'])));
        $arp['vigenciaFim'] = date('Y-m-d', strtotime(str_replace('/', '-', $arp['vigenciaFim'])));

        $arp['notas'] = $request->notas;

        $new_arp = Arp::create($arp);

        # verifica se o objeto já está cadastrado com o sigma
        $objeto = Objeto::where('sigma', $arp['sigma'])->first();

        if ($objeto) {
            $objeto->update([
                'descricao' => $arp['objeto'],
            ]);
        } else {
            $objeto = Objeto::create([
            'sigma' => $arp['sigma'],
            'descricao' => $arp['objeto'],
            ]);
        }

        # cria um item
        Item::create([
            'arp_id' => $new_arp->id,
            'objeto_id' => $objeto->id,
            'valor' => str_replace(',', '.', str_replace('.', '', $arp['valor']))
        ]);

        // LOG
        Log::create([
            'model_id' => $new_arp->id,
            'model' => 'Arp',
            'action' => 'store',
            'changes' => json_encode($new_arp),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('arps.edit', $new_arp->id))->with('message', 'Arp criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Arp $arp)
    {
        $this->authorize('arp-show');

        return view('arps.show', [
            'arp' => $arp,
            'items' => Item::where('arp_id', $arp->id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arp $arp)
    {
        $this->authorize('arp-edit');

        return view('arps.edit', [
            'arp' => $arp,
            'items' => Item::where('arp_id', $arp->id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Arp $arp)
    {
        $this->authorize('arp-edit');

        $input = $request->validate([
            'arp' => 'required|max:10',
            'pac' => 'required|max:10',
            'pe' => 'required|max:10',
            'vigenciaInicio' => 'required|date_format:d/m/Y',
            'vigenciaFim' => 'required|date_format:d/m/Y',
        ]);

        $input['vigenciaInicio'] = date('Y-m-d', strtotime(str_replace('/', '-', $input['vigenciaInicio'])));
        $input['vigenciaFim'] = date('Y-m-d', strtotime(str_replace('/', '-', $input['vigenciaFim'])));

        $input['notas'] = $request->notas;

        $arp->update($input);

        // LOG
        Log::create([
            'model_id' => $arp->id,
            'model' => 'Arp',
            'action' => 'update',
            'changes' => json_encode($arp->getChanges()),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('arps.edit', $arp->id))->with('message', 'Arp atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Arp $arp)
    {
        $this->authorize('arp-delete');

        // LOG
        Log::create([
            'model_id' => $arp->id,
            'model' => 'Arp',
            'action' => 'destroy',
            'changes' => json_encode($arp),
            'user_id' => auth()->id(),
        ]);

        $arp->delete();

        return redirect(route('arps.index'))->with('message', 'Arp deletado com sucesso!');
    }

    /**
     * Export CSV
     */
    public function exportcsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->authorize('arp-export');

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            ,
            'Content-type' => 'text/csv; charset=UTF-8'
            ,
            'Content-Disposition' => 'attachment; filename=Permissoes_' . date("Y-m-d H:i:s") . '.csv'
            ,
            'Expires' => '0'
            ,
            'Pragma' => 'public'
        ];

        $arps = ArpView::orderBy('arp', 'asc')
            ->filter(request(['arp', 'pac', 'pe', 'vigencia_inicio', 'vigencia_fim', 'vigencia', 'sigma', 'objeto']));

        $list = $arps->get()->toArray();

        // nota: mostra consulta gerada pelo elloquent
        // dd($arps->toSql());

        # converte os objetos para uma array
        $list = json_decode(json_encode($list), true);

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            fputs($FH, chr(0xEF) . chr(0xBB) . chr(0xBF));
            foreach ($list as $row) {
                fputcsv($FH, $row, ';');
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf(): \Illuminate\Http\Response
    {
        $this->authorize('arp-export');

        return Pdf::loadView('arps.report', [
            'dataset' => ArpView::orderBy('arp', 'asc')
                ->filter(request(['arp', 'pac', 'pe', 'vigenciaInicio', 'vigenciaFim']))
                ->get()
        ])->setPaper('a4', 'landscape')->download('Arp' . '_' . date("Y-m-d H:i:s") . '.pdf');
    }
}
