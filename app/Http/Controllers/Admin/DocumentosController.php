<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documento;
use League\CommonMark\Node\Block\Document;

class DocumentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.documentos.index')->only('index');
        $this->middleware('can:admin.documentos.edit')->only('edit', 'update');
        $this->middleware('can:admin.documentos.create')->only('create', 'store');
        $this->middleware('can:admin.documentos.destroy')->only('destroy');
        
    }

    public function index()
    {
        $documentos = Documento::all();
        return view('admin.documentos.index', compact('documentos'));
    }

    
    public function create()
    {
        return view('admin.documentos.create');
    }

    public function store(Request $request)
    {
               
        $request->validate([
            'nombre' => 'required',
            'siglas' => 'required',
            'cantidadDigitos' => 'required',
            'slug' => 'required|unique:documentos',
            'vigente' => 'required'
        ]);

        $documento = Documento::create($request->all());
        return redirect()->route('admin.documentos.edit', $documento)->with('info', 'El Documento se creo con exto');
    }

    public function edit(Documento $documento)
    {
        return view('admin.documentos.edit', compact('documento'));
    }

    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'nombre' => 'required',
            'siglas' => 'required',
            'slug' => "required|unique:documentos,slug,$documento->id",
            'vigente' => 'required'
        ]);

        $documento->update($request->all());
        return redirect()->route('admin.documentos.edit', $documento)->with('info', 'El documento se actualizo con exito');
    }

    public function destroy(Documento $documento)
    {        
        $documento->delete();
        return redirect()->route('admin.documentos.index')->with('info', 'El documento se elimino con exito');
    }
}
