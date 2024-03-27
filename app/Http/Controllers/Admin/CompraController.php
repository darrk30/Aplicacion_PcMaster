<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\orden_reposicion;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.compras.index')->only('index');
    }

    public function comprar($id, $precioTotal)
    {        
        $proveedores = Proveedor::all();
        return view('admin.compras.create', compact('id', 'precioTotal', 'proveedores'));
    }

    public function index()
    {
        $compras = Compra::all();
        return view('admin.compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        return view('admin.compras.create', compact('proveedores'));
    }

    public function store(Request $request)
{
    // Crear una nueva compra
    Compra::create($request->all());

    // Obtener la orden de reposición asociada a la compra
    $ordenReposicion = orden_reposicion::findOrFail($request->orden_reposicion_id);

    // Actualizar el estado de la orden de reposición
    $ordenReposicion->estado = 'Orden realizada';
    $ordenReposicion->save();

    // Redirigir con un mensaje de éxito
    return redirect()->route('admin.compras.index')->with('success', '¡Compra creada exitosamente!');
}


    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
