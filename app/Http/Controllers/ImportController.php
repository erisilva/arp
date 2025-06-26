<?php

namespace App\Http\Controllers;

use App\Models\Import;
use Illuminate\Http\Request;
use Vtiful\Kernel\Excel;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('import-index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('imports.index', [
            'imports' => Import::orderBy('created_at', 'desc')
                ->paginate(session('perPage', '5'))
                ->appends(request(['perpage']))
                ->withPath(env('APP_URL', null) . '/imports'),
            'perpages' => \App\Models\Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('import-create');

        return view('imports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('import-create');


        $request->validate([
            'import_type' => 'required|integer|in:1,2,3,4',
            'arquivo' => 'required|file|mimes:xls,xlsx|max:5120',
            'descricao' => 'required|string|max:255',
        ]);

       // coverter o import_type pata integer
       // $request->merge(['import_type' => (int) $request->input('import_type')]);

        switch ($request->input('import_type')) {
            case 1:
                //return ExcelFacade::download(new \App\Imports\ArpImport,$request->file('file'));
                //ExcelFacade::import(new \App\Imports\ArpImport, $request->file('arquivo'));
                /*

                $path1 = $request->file('mcafile')->store('temp');
                $path=storage_path('app').'/'.$path1;
                $data = \Excel::import(new UsersImport,$path);
                */

                try {
                    $uploadedFile = $request->file('arquivo');
                    ExcelFacade::import(new \App\Imports\ArpImport1, $uploadedFile);
                    // salva na classe import o usuario que fez a importacao e a descricao que ele criou
                    Import::create([
                        'user_id' => auth()->id(),
                        'descricao' => $request->input('descricao'),
                        'resultado' => 'Importação realizada com sucesso (modelo 1)',
                        'data' => json_encode($uploadedFile->getClientOriginalName()),
                    ]);
                    return redirect()->route('imports.index')->with('message', 'Arquivo (modelo 1) importado com sucesso!');
                } catch (\Exception $e) {
                    return back()->withErrors(['arquivo' => 'Erro ao importar o arquivo: ' . $e->getMessage()]);
                }
            case 2:
                try {
                    $uploadedFile = $request->file('arquivo');
                    ExcelFacade::import(new \App\Imports\ArpImport2, $uploadedFile);
                    Import::create([
                        'user_id' => auth()->id(),
                        'descricao' => $request->input('descricao'),
                        'resultado' => 'Importação realizada com sucesso (modelo 2)',
                        'data' => json_encode($uploadedFile->getClientOriginalName()),
                    ]);
                    return redirect()->route('imports.index')->with('message', 'Arquivo (modelo 2) importado com sucesso!');
                } catch (\Exception $e) {
                    return back()->withErrors(['arquivo' => 'Erro ao importar o arquivo: ' . $e->getMessage()]);
                }
            case 3:
                break;
            case 4:
                break;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Import $import)
    {
        //
    }
}
