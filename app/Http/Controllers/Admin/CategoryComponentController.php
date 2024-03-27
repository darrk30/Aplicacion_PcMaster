<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryComponentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.categoriesComponents.index')->only('index');
        $this->middleware('can:admin.categoriesComponents.edit')->only('edit', 'update');
        $this->middleware('can:admin.categoriesComponents.create')->only('create', 'store');
        $this->middleware('can:admin.categoriesComponents.destroy')->only('destroy');
        
    }
    
    public function index()
    {

        $categorias = Category::all();

        return view('admin.categoriesComponents.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categoriesComponents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'slug' => 'required|unique:categories',
            'vigente' => 'required'
        ]);
        
        $categoria = Category::create($request->all());
        return redirect()->route('admin.categoriesComponents.edit', $categoria)->with('info', 'La categoria se creo con exito');
    }

   
    public function edit(Category $categoriesComponent)
    {
        return view('admin.categoriesComponents.edit', compact('categoriesComponent'));
    }


    public function update(Request $request, Category $categoriesComponent)
    {
        $request->validate([
            'nombre' => 'required',
            'slug' => "required|unique:categories,slug,$categoriesComponent->id",
            'vigente' => 'required'
        ]);

        $categoriesComponent->update($request->all());
        return redirect()->route('admin.categoriesComponents.edit', $categoriesComponent)->with('info', 'La categoria se actualizo con exito');
    }

    
    public function destroy(Category $categoriesComponent)
    {
        $categoriesComponent->delete();
        return redirect()->route('admin.categoriesComponents.index')->with('info', 'La categoria se elimino con exito');
    }
}
