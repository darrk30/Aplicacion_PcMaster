<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Componente;
use App\Models\Kardex;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.Kardex.index')->only('index');
    }

    public function index()
    {
        $kardexs = Kardex::all();
        return view('admin.kardex.index', compact('kardexs'));
    }

    public function create()
    {
        $componentes = Componente::all();
        $proveedores = Proveedor::all();
        return view('admin.Kardex.create', compact('proveedores', 'componentes'));
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'fecha' => 'required|date',
            'componentes' => 'required|array|min:1',
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'componentes.required' => 'Debe seleccionar al menos un componente.',
        ]);
        // Validar los datos del formulario si es necesario

        // Crear un nuevo registro de Kardex
        $kardex = new Kardex();
        $kardex->solicitud_componente_id = $request->input('solicitud_componente_id');
        $kardex->tipoTransaccion = $request->input('tipoTransaccion');
        $kardex->fecha = $request->input('fecha');
        $kardex->ubicacion = $request->input('ubicacion');
        $kardex->descripcion = $request->input('descripcion');
        $kardex->proveedor_id = $request->input('proveedor_id');
        $kardex->save();

        // Obtener los datos de los componentes del formulario
        $componentes = $request->input('componentes');

        // Recorrer los datos de los componentes y guardar solo los seleccionados en la tabla muchos a muchos
        foreach ($componentes as $componenteId => $data) {
            // Verificar si el componente ha sido seleccionado
            if (isset($data['id'])) {
                $cantidad = $data['cantidad'];

                // Guardar en la tabla muchos a muchos (componente_kardex) solo si está seleccionado
                $kardex->componentes()->attach($data['id'], ['cantidad' => $cantidad]);

                // Actualizar el stock del componente dependiendo del tipo de transacción
                $componente = Componente::find($data['id']);
                if ($componente) {
                    if ($kardex->tipoTransaccion === 'traslado') {
                        // Disminuir el stock si es un traslado
                        $componente->stock -= $cantidad;
                    } else {
                        // Aumentar el stock si es una compra
                        $componente->stock += $cantidad;
                    }
                    // Guardar el componente actualizado
                    $componente->save();
                }
            }
        }
        return redirect()->route('admin.Kardex.index')->with('info', 'El registro del kardex se realizo con éxito');
        // Redirigir o mostrar un mensaje de éxito
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
