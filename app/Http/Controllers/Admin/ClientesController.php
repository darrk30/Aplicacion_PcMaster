<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.clientes.index')->only('index');
        $this->middleware('can:admin.clientes.edit')->only('edit', 'update');
        $this->middleware('can:admin.clientes.create')->only('create', 'store');
        $this->middleware('can:admin.clientes.destroy')->only('destroy');
        
    }


    public function index()
    {
        return view('admin.clientes.index');
    }

    public function create()
    {
        $documentos = Documento::all()->mapWithKeys(function ($documento) {
            return [$documento->id => $documento->nombre . ' (' . $documento->cantidadDigitos . ' dígitos)'];
        });        

        return view('admin.clientes.create', compact('documentos'));
    }
    



    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required',
            'documento_id' => 'required', // Ensuring a document type is selected
            'numeroDoc' => 'required|unique:clientes,numeroDoc', // Ensuring unique document number
            'direccion' => 'required',

        ], [
            'nombres.required' => 'El nombre es requerido.',
            'apellidos.required' => 'Los apellidos son requeridos.',
            'telefono.required' => 'El teléfono es requerido.',
            'documento_id.required' => 'Por favor seleccione un tipo de documento.',
            'numeroDoc.required' => 'El número de documento es requerido.',
            'numeroDoc.unique' => 'El número de documento ya está en uso.',
            'direccion.required' => 'La direccion es necesaria'
        ]);

        $cliente = Cliente::create($request->all());
        return redirect()->route('admin.clientes.index', $cliente)->with('info', 'El Cliente se creó con éxito');
    }


    public function show(Cliente $cliente)
    {
    }

    public function edit(Cliente $cliente)
    {
        $documentos = Documento::all()->mapWithKeys(function ($documento) {
            return [$documento->id => $documento->nombre . ' (' . $documento->cantidadDigitos . ' dígitos)'];
        }); 
        return view('admin.clientes.edit', compact('cliente', 'documentos'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($request->all());
        return redirect()->route('admin.clientes.index', $cliente)->with('info', 'El Cliente se actualizo con exito');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        // Redireccionar a la página de índice con un mensaje informativo
        return redirect()->route('admin.clientes.index')->with('info', 'El Cliente se eliminó con éxito');
    }
}
