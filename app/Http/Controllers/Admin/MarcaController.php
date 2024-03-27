<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.marcas.index')->only('index');
        $this->middleware('can:admin.marcas.edit')->only('edit', 'update');
        $this->middleware('can:admin.marcas.create')->only('create', 'store');
        $this->middleware('can:admin.marcas.destroy')->only('destroy');
        
    }

    public function index()
    {
        $marcas = Marca::all();
        return view('admin.marcas.index' , compact('marcas'));
    }

    public function create()
    {
        return view('admin.marcas.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'slug' => 'required|unique:marcas',
            'vigente' => 'required'
        ]);
        
        $marca = Marca::create($request->all());
        return redirect()->route('admin.marcas.edit', $marca)->with('info', 'La Marca se creo con exito');
    }

    
    public function show(Marca $marca)
    {
        return view('admin.marcas.show', compact('marca'));
    }

    
    public function edit(Marca $marca)
    {
        return view('admin.marcas.edit', compact('marca'));
    }

    
    public function update(Request $request, Marca $marca)
    {
        $request->validate([
            'nombre' => 'required',
            'slug' => "required|unique:marcas,slug,$marca->id",
            'vigente' => 'required'
        ]);

        $marca->update($request->all());
        return redirect()->route('admin.marcas.edit', $marca)->with('info', 'La Marca se actualizo con exito');
    }

    
    public function destroy(Marca $marca)
    {
        $marca->delete();
        return redirect()->route('admin.marcas.index')->with('info', 'La Marca se elimino con exito');
    }
}
