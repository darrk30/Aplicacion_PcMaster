<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\orden_reposicion;
use Illuminate\Http\Request;

class OrdenReposicionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.reposiciones.index')->only('index');
    }

    public function index()
    {
        $ordenesReposicion = orden_reposicion::all();
        return view('admin.reposiciones.index', compact('ordenesReposicion'));
    }

    public function create()
    {
        $componentes = Componente::all();
        return view('admin.reposiciones.create', compact('componentes'));
    }


    public function store(Request $request)
    {
        // Validar los datos del formulario si es necesario

        // Crear una nueva orden de reposición
        $orden = new orden_reposicion();
        $orden->codigo = $request->codigo;
        $orden->fecha = $request->fecha;
        $orden->estado = $request->estado ?? 'Pendiente'; // Estado por defecto pendiente si no se proporciona
        $orden->save();

        // Obtener los datos de los componentes del formulario
        $componentesIds = $request->input('componentes');

        // Recorrer los datos de los componentes y guardarlos en la tabla intermedia
        foreach ($componentesIds as $componenteId) {
            $cantidad = $request->input('cantidad_' . $componenteId);

            // Guardar en la tabla intermedia (orden_reposicion_componentes)
            $orden->componentes()->attach($componenteId, ['cantidad' => $cantidad]);

            // Puedes realizar otras operaciones necesarias, como actualizar el stock del componente, si es necesario
            $componente = Componente::find($componenteId);
            if ($componente) {
                // Realizar operaciones con el componente si es necesario
            }
        }

        return redirect()->route('admin.reposiciones.index')->with('success', 'Orden de reposición creada correctamente.');
    }

    public function aprobar($id)
{
    $orden = orden_reposicion::findOrFail($id);
    $orden->estado = 'Aprobado';
    $orden->save();

    return redirect()->back()->with('success', 'La orden de reposición ha sido aprobada correctamente.');
}

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
