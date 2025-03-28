<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use App\Models\Perpage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class SetorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('setor-index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('setors.index', [
            'setors' => Setor::orderBy('sigla', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) . '/setors'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('setor-create');

        return view('setors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('setor-create');

        $setor = $request->validate([
            'sigla' => 'required|max:6|unique:setors,sigla',
            'descricao' => 'required|max:150',
        ]);

        $new_setor = Setor::create($setor);

        // LOG
        Log::create([
            'model_id' => $new_setor->id,
            'model' => 'Setor',
            'action' => 'store',
            'changes' => json_encode($new_setor),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('setors.edit', $new_setor->id))->with('message','Setor criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setor $setor)
    {
        $this->authorize('setor-show');

        return view('setors.show', compact('setor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setor $setor)
    {
        $this->authorize('setor-edit');

        return view('setors.edit', compact('setor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setor $setor)
    {
        $this->authorize('setor-edit');

        $input = $request->validate([
            'sigla' => 'required|max:6',
            'descricao' => 'required|max:150',
        ]);

        $setor->update($input);

        // LOG
        Log::create([
            'model_id' => $setor->id,
            'model' => 'Setor',
            'action' => 'update',
            'changes' => json_encode($setor->getChanges()),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('setors.edit', $setor->id))->with('message','Setor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setor $setor)
    {
        $this->authorize('setor-delete');

        $setor->delete();

        // LOG
        Log::create([
            'model_id' => $setor->id,
            'model' => 'Setor',
            'action' => 'destroy',
            'changes' => json_encode($setor),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('setors.index'))->with('message','Setor excluído com sucesso!');
    }

    /**
     * Export CSV
     */
    public function exportcsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->authorize('setor-export');

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            ,
            'Content-type' => 'text/csv; charset=UTF-8'
            ,
            'Content-Disposition' => 'attachment; filename=Setores_' . date("Y-m-d H:i:s") . '.csv'
            ,
            'Expires' => '0'
            ,
            'Pragma' => 'public'
        ];

        $setores = Setor::select('sigla', 'descricao')->orderBy('sigla', 'asc');

        $list = $setores->get()->toArray();

        // nota: mostra consulta gerada pelo elloquent
        // dd($distritos->toSql());

        # converte os objetos para uma array
        $list = json_decode(json_encode($list), true);

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            fputs($FH, chr(0xEF) . chr(0xBB) . chr(0xBF));
            foreach ($list as $row) {
                fputcsv($FH, $row, ',');
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
        $this->authorize('setor-export');

        return Pdf::loadView('setors.report', [
            'dataset' => Setor::orderBy('sigla', 'asc')->get()
        ])->download('Setores_' . date("Y-m-d H:i:s") . '.pdf');
    }

    /**
     * Função de autocompletar para ser usada pelo typehead
     *
     * @param
     * @return json
     */
    public function autocomplete(Request $request) : \Illuminate\Http\JsonResponse
    {
        $this->authorize('setor-index'); // verifica se o usuário possui acesso para listar

        $setors = DB::table('setors');

        // select
        $setors = $setors->select('descricao as text', 'id as value', 'sigla as sigla');

        //where
        $setors = $setors->where("descricao","LIKE","%{$request->input('query')}%");
        $setors = $setors->orWhere("sigla","LIKE","%{$request->input('query')}%");

        //get
        $setors = $setors->get();

        return response()->json($setors, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

}
