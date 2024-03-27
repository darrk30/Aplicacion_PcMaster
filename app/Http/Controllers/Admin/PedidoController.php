<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        return view('admin.pedidos.index');
    }

    public function create()
    {

        return view('admin.pedidos.create');
    }

    // public function store(Request $request)
    // {

    //     return $request;
    //     // $userID = auth()->user()->id;
    //     // // Validar los datos del formulario si es necesario
    //     // $request->validate([
    //     //     'fechaPedido' => 'required|date',
    //     //     'descripcion' => 'required|string',
    //     //     'fechaEntrega' => 'required|date',
    //     //     'montoTotal' => 'required|numeric',
    //     //     'estadoPago' => 'required|string',
    //     //     'cliente_id' => 'required|exists:clientes,id',
    //     //     // 'user_id' => 'required|exists:users,id',
    //     //     'estadoPedido' => 'required|string',
    //     //     'vigente' => 'required|boolean',
    //     // ]);

    //     // // Crear una nueva instancia de Pedido con los datos del formulario
    //     // $pedido = new Pedido();
    //     // $pedido->codigo = $request->codigo;
    //     // $pedido->fechaPedido = $request->fechaPedido;
    //     // $pedido->descripcion = $request->descripcion;
    //     // $pedido->fechaEntrega = $request->fechaEntrega;
    //     // $pedido->montoTotal = $request->montoTotal;
    //     // $pedido->estadoPago = $request->estadoPago;
    //     // $pedido->cliente_id = $request->cliente_id;
    //     // $pedido->user_id = $userID;
    //     // $pedido->estadoPedido = $request->estadoPedido;
    //     // $pedido->vigente = $request->vigente;

    //     // // Guardar el pedido en la base de datos
    //     // $pedido->save();

    //     return view('admin.pedidos.create');
    // }

    public function store(Request $request)
    {
        // Validar los datos del formulario según sea necesario

        // Obtener el ID del cliente
        $idCliente = $request->input('id_cliente');
        $userID = auth()->id();

        // Crear el pedido y guardar el ID
        $pedido = new Pedido();
        $pedido->cliente_id = $idCliente;
        $pedido->users_id = $userID;

        // Asignar valores ficticios a los campos restantes
        $pedido->codigo = 'PED-' . uniqid(); // Generar un código único para el pedido
        $pedido->fechaPedido = now(); // Obtener la fecha y hora actual
        $pedido->descripcion = 'Pedido de prueba'; // Descripción del pedido
        $pedido->fechaentrega = now()->addDays(7); // Fecha de entrega: 7 días a partir de hoy
        $pedido->estadoPedido = 'confirmado'; // Estado del pedido: confirmado
        $pedido->estadoPago = 'pendiente'; // Estado de pago: pendiente
        $pedido->vigente = 1; // El pedido está vigente

        // Obtener el monto total del carrito del formulario
        $montoTotal = floatval($request->input('montoTotal'));
        $pedido->montoTotal = $montoTotal;


        // Guardar el pedido en la base de datos
        $pedido->save();

        // Obtener los datos de los componentes del formulario
        $datosComponentes = $request->input('cartItems');

        // Guardar los datos de los componentes en la tabla intermedia
        foreach ($datosComponentes as $datosComponente) {
            // Crear un nuevo registro en la tabla intermedia
            DB::table('pedido_componentes')->insert([
                'pedido_id' => $pedido->id,
                'componente_id' => $datosComponente['id'],
                'cantidad' => $datosComponente['qty'],
                'subtotal' => $datosComponente['qty'] * $datosComponente['precio'],
            ]);
        }

        return view('admin.pedidos.index');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function cliente(Request $request)
    {
        $term = $request->get('term');
        $clients = Cliente::where('numeroDoc', 'LIKE', '%' . $term . '%')
            ->select('id', 'numeroDoc AS label', 'telefono', 'direccion')
            ->limit(10)
            ->get();
        return response()->json($clients);
    }

    public function detalles(Request $request)
    {
        $codigoPedido = $request->get('codigoPedido');
        $pedido = Pedido::where('codigo', $codigoPedido)->first();

        if ($pedido) {
            // Si se encuentra el pedido, obtener los detalles de los componentes asociados a ese pedido
            $detallesPedido = DB::table('pedido_componentes')
                ->where('pedido_id', $pedido->id)
                ->join('componentes', 'pedido_componentes.componente_id', '=', 'componentes.id')
                ->select('componentes.descripcion as descripcion_componente', 'pedido_componentes.cantidad', 'pedido_componentes.subtotal')
                ->get();


            // Retornar los detalles del pedido en formato JSON
            return response()->json($detallesPedido);
        } else {
            // Si no se encuentra el pedido, retornar un mensaje de error
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }
    }

    public function FinalizarPedido(Request $request)
    {
        // Obtener el ID del pedido desde la solicitud AJAX
        $pedidoId = $request->id;

        // Buscar el pedido en la base de datos
        $pedido = Pedido::findOrFail($pedidoId);

        // Actualizar el estado del pedido a "Pedido Finalizado"
        $pedido->estadoPedido = 'Pedido Finalizado';
        $pedido->save();

        // Devolver una respuesta JSON indicando que el pedido se finalizó correctamente
        return response()->json([
            'success' => true,
            'message' => 'El pedido se ha finalizado correctamente.',
            'estado' => $pedido->estadoPedido // Incluir el estado actualizado en la respuesta
        ]);
    }


    public function EntregarPedido(Request $request){
        // Obtener el ID del pedido desde la solicitud AJAX
        $pedidoId = $request->id;

        // Buscar el pedido en la base de datos
        $pedido = Pedido::findOrFail($pedidoId);

        // Actualizar el estado del pedido a "Pedido Finalizado"
        $pedido->estadoPedido = 'Pedido Entregado';
        $pedido->save();

        // Devolver una respuesta JSON indicando que el pedido se finalizó correctamente
        return response()->json([
            'success' => true,
            'message' => 'El pedido se entrego correctamente.',
            'estado' => $pedido->estadoPedido // Incluir el estado actualizado en la respuesta
        ]);
    }
}
