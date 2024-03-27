<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnvioPedido;
use App\Models\Pedido;
use Illuminate\Http\Request;

class EnvioPedidoController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:admin.EnvioPedidos.index')->only('index');
        
    }

    public function index()
    {
        $enviosPedidos = EnvioPedido::all();
        return view('admin.EnvioPedidos.index', compact('enviosPedidos'));
    }

    public function create()
    {
        return view('admin.EnvioPedidos.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_pedido' => 'required',
            'fecha_actual' => 'required|date_format:Y-m-d',
            'descripcion' => 'required|string',
        ]);

        // Crear una nueva instancia del modelo EnvioPedido
        $envioPedido = new EnvioPedido();

        // Asignar los valores del formulario a los atributos del modelo
        $envioPedido->pedido_id = $request->id_pedido;
        $envioPedido->fechaEntrega = $request->fecha_actual;
        $envioPedido->descripcion = $request->descripcion;

        // Guardar el nuevo envío del pedido en la base de datos
        $envioPedido->save();

        // Obtener el pedido correspondiente
        $pedido = Pedido::findOrFail($request->id_pedido);

        // Actualizar el estado del pedido a "Listo para su entrega"
        $pedido->estadoPedido = 'Pedido Listo';

        // Guardar el pedido actualizado en la base de datos
        $pedido->save();

        // Redireccionar a una ruta de éxito o mostrar un mensaje de éxito
        return redirect()->route('admin.EnvioPedidos.index')->with('success', 'El envío del pedido se ha registrado correctamente.');
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

    public function BuscarCodigo(Request $request)
    {
        $term = $request->get('term');
        $pedidos = Pedido::where('codigo', 'like', '%' . $term . '%')
            ->where('estadoPedido', 'Pedido Finalizado')
            ->select('id', 'codigo AS label', 'codigo')
            ->limit(10)
            ->get();

        return response()->json($pedidos);
    }
}
