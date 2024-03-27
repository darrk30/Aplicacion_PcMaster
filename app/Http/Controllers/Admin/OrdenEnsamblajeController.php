<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Componente;
use App\Models\OrdenEnsamblaje;
use App\Models\Pedido;
use App\Models\solicitud_componente;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenEnsamblajeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.ordenEnsamblaje.index')->only('index');
        $this->middleware('can:admin.ordenEnsamblaje.detalle_pedido')->only('detallePedido');
        $this->middleware('can:admin.ordenEnsamblaje.crear')->only('create', 'store');
        $this->middleware('can:admin.ordenEnsamblaje.aprobar_orden')->only('aprobarOrden');
    }


    public function index()
    {
        $ordenes = OrdenEnsamblaje::all();
        return view('admin.ordenEnsamblaje.index', compact('ordenes'));
    }

    public function create()
    {
    }

    public function crear($idPedido)
    {
        $pedido = Pedido::findOrFail($idPedido);
        $codigoPedido = $pedido->codigo;
        return view('admin.ordenEnsamblaje.create', compact('idPedido', 'codigoPedido'));
    }

    public function store(Request $request)
    {
        try {
            // Intentar crear la orden de ensamblaje
            $ordenEnsamblaje = new OrdenEnsamblaje();
            $ordenEnsamblaje->pedido_id = $request->idPedido;
            $ordenEnsamblaje->estado = $request->estado;
            $fechaHora = Carbon::createFromFormat('Y-m-d\TH:i', $request->fecha);
            $ordenEnsamblaje->fecha = $fechaHora->toDateTimeString();
            $ordenEnsamblaje->save();

            // Actualizar el estado del pedido a "Orden Registrada"
            $pedido = Pedido::findOrFail($ordenEnsamblaje->pedido_id);
            $pedido->estadoPedido = 'Orden de Ensamblaje Registrada';
            $pedido->save();

            return redirect()->route('admin.ordenEnsamblaje.index')->with('success', 'La orden de ensamblaje se registró correctamente.');
        } catch (QueryException $e) {
            // Verificar si la excepción se debe a una violación de la restricción única
            if ($e->errorInfo[1] === 2627) {
                return redirect()->back()->with('error', 'No se pudo registrar la orden de ensamblaje. Ya existe una orden para este pedido.');
            } else {
                // En caso de otros errores, mostrar un mensaje genérico
                return redirect()->back()->with('error', 'No se pudo registrar la orden de ensamblaje.');
            }
        }
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

    public function aprobarOrden(Request $request)
    {
        // Obtener el ID de la orden enviado por AJAX
        $ordenId = $request->input('orden_id');
        // Buscar la orden por su ID
        $orden = OrdenEnsamblaje::findOrFail($ordenId);

        // Cambiar el estado de la orden a "Aprobado"
        $orden->estado = 'Aprobado';
        $orden->save();

        // Registrar en la tabla 'solicitud_componentes'
        $solicitudComponente = new solicitud_componente();
        $solicitudComponente->fecha = now(); // O la fecha que desees registrar
        $solicitudComponente->estado = 'Pendiente';
        $solicitudComponente->orden_ensamblaje_id = $ordenId;
        $solicitudComponente->save();

        // Crear una notificación
        $notificacion = 'Orden de ensamblaje aprobada';

        // Devolver una respuesta JSON con la notificación
        return response()->json(['mensaje' => $notificacion, 'estado_actualizado' => $orden->estado]);
    }


    public function detallePedido(Request $request)
    {
        // Obtener el código del pedido enviado por la solicitud AJAX
        $codigoPedido = $request->codigo;

        // Buscar el pedido por su código
        $pedido = Pedido::where('codigo', $codigoPedido)->first();

        if (!$pedido) {
            return response()->json(['success' => false, 'mensaje' => 'Pedido no encontrado']);
        }

        // Obtener todos los componentes asociados a este pedido
        $componentesPedido = DB::table('pedido_componentes')
            ->join('componentes', 'pedido_componentes.componente_id', '=', 'componentes.id')
            ->select('componentes.descripcion', 'componentes.url', 'pedido_componentes.cantidad')
            ->where('pedido_componentes.pedido_id', $pedido->id)
            ->get();

        return response()->json(['success' => true, 'pedido' => $pedido, 'componentes' => $componentesPedido]);
    }
}
