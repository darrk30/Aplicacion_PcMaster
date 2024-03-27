<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdenEnsamblaje;
use App\Models\Pedido;
use App\Models\solicitud_componente;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class SolicitudComponentesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.solicitudComponentes.index')->only('index');
        $this->middleware('can:admin.solicitudComponentes.detalle_orden')->only('detalleOrden');
        $this->middleware('can:admin.solicitudComponentes.detalle_pedido')->only('detallePedido');
        $this->middleware('can:admin.solicitudComponentes.generar_pdf')->only('generarPDF');
        $this->middleware('can:admin.solicitudComponentes.CambiarEstadoSolicitud')->only('EstadoSolicitud');
    }

    public function index()
    {
        $solicitudes = solicitud_componente::all();
        return view('admin.solicitudComponentes.index', compact('solicitudes'));
    }

    public function detalleOrden(Request $request)
    {
        $idSolicitud = $request->id;
        // Obtener las órdenes de ensamblaje asociadas a la solicitud
        // Obtener las órdenes de ensamblaje y el código del pedido asociado
        $ordenes = OrdenEnsamblaje::select('orden_ensamblajes.*', 'pedidos.codigo as codigo_pedido')
            ->join('pedidos', 'orden_ensamblajes.pedido_id', '=', 'pedidos.id')
            ->where('orden_ensamblajes.id', $idSolicitud)
            ->get();


        // Verificar si se encontraron órdenes para la solicitud
        if ($ordenes->isEmpty()) {
            return response()->json(['success' => false, 'mensaje' => 'No se encontraron órdenes para la solicitud especificada']);
        }

        // Retornar las órdenes encontradas
        return response()->json(['success' => true, 'ordenes' => $ordenes]);

        // Verificar si se encontraron órdenes para la solicitud
        if ($ordenes->isEmpty()) {
            return response()->json(['success' => false, 'mensaje' => 'No se encontraron órdenes para la solicitud especificada']);
        }

        // Retornar las órdenes encontradas
        return response()->json(['success' => true, 'ordenes' => $ordenes]);
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


    public function generarPDF(Request $request)
    {
        // Obtener los datos de la solicitud
        $solicitud = solicitud_componente::findOrFail($request->id);

        $ordenEnsamblaje = OrdenEnsamblaje::findOrFail($solicitud->orden_ensamblaje_id);
        // Obtener el pedido asociado a la solicitud
        $pedido = Pedido::findOrFail($ordenEnsamblaje->pedido_id);

        // Obtener los detalles de los componentes del pedido
        $detallesComponentes = DB::table('pedido_componentes')
            ->where('pedido_id', $pedido->id)
            ->join('componentes', 'pedido_componentes.componente_id', '=', 'componentes.id')
            ->select('componentes.codigo', 'componentes.descripcion', 'pedido_componentes.cantidad', 'pedido_componentes.cantidad', 'pedido_componentes.subtotal')
            ->get();

        // Configurar DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Construir el contenido HTML del PDF
        $html = view('admin.solicitudcomponentes.solicitud', compact('solicitud', 'pedido', 'detallesComponentes'))->render();

        // Cargar el contenido HTML en DomPDF
        $dompdf->loadHtml($html);

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena base64
        $pdfContent = $dompdf->output();
        $base64Content = base64_encode($pdfContent);

        // Devolver la respuesta JSON con el contenido base64
        return response()->json(['success' => true, 'url' => "data:application/pdf;base64,$base64Content"]);
    }

    public function EstadoSolicitud(Request $request)
    {
        // Obtener los datos de la solicitud desde la solicitud AJAX
        $solicitudId = $request->solicitud_id;
        $tipoSolicitud = $request->solicitud_tipo;

        // Buscar la solicitud correspondiente en la base de datos
        $solicitud = solicitud_componente::findOrFail($solicitudId);
        $ordenEnsamblaje = OrdenEnsamblaje::findOrFail($solicitud->orden_ensamblaje_id);
        // Obtener el pedido asociado a la solicitud
        $pedido = Pedido::findOrFail($ordenEnsamblaje->pedido_id);
        // Actualizar el estado de la solicitud según el tipo
        switch ($tipoSolicitud) {
            case 'Pendiente':
                $solicitud->estado = 'Aprobado';
                break;
            case 'Aprobado':
                $solicitud->estado = 'Componentes Listos';
                break;
            case 'Listos':
                $solicitud->estado = 'Componentes Entregados';
                // Actualizar el estado del pedido a "Proceso de Ensamblaje"
                $pedido = Pedido::findOrFail($pedido->id);
                $pedido->estadoPedido = 'Proceso de Ensamblaje';
                $pedido->save();
                break;
            default:
                // Manejar el caso en que el tipo de solicitud no sea válido
                return response()->json(['error' => 'Tipo de solicitud no válido'], 400);
        }

        // Guardar los cambios en la base de datos
        $solicitud->save();

        // Crear una notificación
        $notificacion = 'Estado de solicitud actualizado correctamente';

        // Devolver una respuesta JSON con la notificación y el nuevo estado
        return response()->json(['mensaje' => $notificacion, 'estado_actualizado' => $solicitud->estado]);
    }
}
