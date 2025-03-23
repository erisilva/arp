<?php

namespace App\Http\Controllers;

use App\Models\Objeto;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Log;

class ObjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('objeto-index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('objetos.index', [
            'objetos' => Objeto::orderBy('sigma', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) . '/objetos'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('objeto-create');

        return view('objetos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('objeto-create');

        $objeto = $request->validate([
            'sigma' => 'required|max:15|unique:objetos,sigma',
            'descricao' => 'required|max:150',
        ]);

        $new_objeto = Objeto::create($objeto);

        // LOG
        Log::create([
            'model_id' => $new_objeto->id,
            'model' => 'Objeto',
            'action' => 'store',
            'changes' => json_encode($new_objeto),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('objetos.edit', $new_objeto->id))->with('message','Objeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Objeto $objeto)
    {
        $this->authorize('objeto-show');

        return view('objetos.show', compact('objeto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Objeto $objeto)
    {
        $this->authorize('objeto-edit');

        return view('objetos.edit', compact('objeto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Objeto $objeto)
    {
        $this->authorize('objeto-edit');

        $input = $request->validate([
            'sigma' => 'required|max:15',
            'descricao' => 'required|max:150',
        ]);

        $objeto->update($input);

        // LOG
        Log::create([
            'model_id' => $objeto->id,
            'model' => 'Objeto',
            'action' => 'update',
            'changes' => json_encode($objeto->getChanges()),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('objetos.edit', $objeto->id))->with('message','Objeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Objeto $objeto)
    {
        $this->authorize('objeto-delete');

        $objeto->delete();

        // LOG
        Log::create([
            'model_id' => $objeto->id,
            'model' => 'Objeto',
            'action' => 'destroy',
            'changes' => json_encode($objeto),
            'user_id' => auth()->id(),
        ]);

        return redirect(route('objetos.index'))->with('message','Objeto excluído com sucesso!');
    }

    /**
     * Export CSV
     */
    public function exportcsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->authorize('objeto-export');

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            ,
            'Content-type' => 'text/csv; charset=UTF-8'
            ,
            'Content-Disposition' => 'attachment; filename=Objetos_' . date("Y-m-d H:i:s") . '.csv'
            ,
            'Expires' => '0'
            ,
            'Pragma' => 'public'
        ];

        $objetos = Objeto::select('sigma', 'descricao')->orderBy('sigma', 'asc');

        $list = $objetos->get()->toArray();

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
        $this->authorize('objeto-export');

        return Pdf::loadView('objetos.report', [
            'dataset' => Objeto::orderBy('sigma', 'asc')->get()
        ])->download('Objetos_' . date("Y-m-d H:i:s") . '.pdf');
    }
}
