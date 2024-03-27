<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Componente;
use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Category;
use App\Http\Requests\StoreComponenteRequest;
use Illuminate\Support\Facades\Storage;

class ComponentesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.componentes.index')->only('index');
        $this->middleware('can:admin.componentes.edit')->only('edit', 'update');
        $this->middleware('can:admin.componentes.create')->only('create', 'store');
        $this->middleware('can:admin.componentes.destroy')->only('destroy');
        
    }

    public function index()
    {
        return view('admin.componentes.index');
    }


    public function create()
    {
        $marcas = Marca::pluck('nombre', 'id');
        $category = Category::pluck('nombre', 'id');
        return view('admin.componentes.create', compact('marcas', 'category'));
    }


    public function store(StoreComponenteRequest $request)
    {
        // Crear el componente
        $componente = Componente::create($request->all());

        // Guardar la imagen y obtener su ruta
        if ($request->hasFile('file')) {
            $rutaImagen = $request->file('file')->store('public/componentes');
            // Obtener la URL pública de la imagen
            $urlImagen = Storage::url($rutaImagen);

            // Guardar la ruta de la imagen en la base de datos
            $componente->url = $urlImagen;
            $componente->save();
        }

        return redirect()->route('admin.componentes.index', $componente)->with('info', 'El componente se creo con exito');
    }

    public function edit(Componente $componente)
    {
        $marcas = Marca::pluck('nombre', 'id');
        $category = Category::pluck('nombre', 'id');
        return view('admin.componentes.edit', compact('componente', 'marcas', 'category'));
    }

    public function update(StoreComponenteRequest $request, Componente $componente)
    {
        // Actualizar los campos del componente
        $componente->update($request->all());

        // Verificar si se ha enviado una nueva imagen
        if ($request->hasFile('file')) {
            // Obtener la ruta de la imagen anterior
            $rutaAnterior = $componente->url;

            // Guardar la nueva imagen en la carpeta public/componentes
            $rutaImagen = $request->file('file')->store('public/componentes');

            // Obtener la ruta relativa de la imagen (sin el 'public/')
            $rutaRelativa = str_replace('public/', '/storage/', $rutaImagen);

            // Actualizar la ruta relativa de la imagen en la base de datos
            $componente->url = $rutaRelativa;
            $componente->save();

            // Eliminar la imagen anterior si existe
            if ($rutaAnterior) {
                Storage::delete(str_replace('/storage/', 'public/', $rutaAnterior));
            }
        }

        return redirect()->route('admin.componentes.edit', $componente)->with('info', 'El componente se actualizo con exito');
    }





    public function destroy(Componente $componente)
    {
        // Verificar si el componente tiene una imagen asociada
        if ($componente->url) {
            // Obtener la ruta de la imagen almacenada
            $rutaImagen = str_replace('/storage/', 'public/', $componente->url);

            // Eliminar la imagen si existe
            if (Storage::exists($rutaImagen)) {
                Storage::delete($rutaImagen);
            }
        }

        // Eliminar el componente
        $componente->delete();

        // Redireccionar a la página de índice con un mensaje informativo
        return redirect()->route('admin.componentes.index')->with('info', 'El componente se eliminó con éxito');
    }
}
