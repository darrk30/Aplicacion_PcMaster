@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Solicitudes de Componentes</h1>
@stop

@section('content')
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>orden ensamblaje</th>
                        <th>fecha</th>
                        <th>estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->id }}</td>
                            <td><a href="#" class="detalle-orden" data-codigo="{{ $solicitud->orden_ensamblaje_id }}">ver
                                    orden</a></td>
                            <td>{{ $solicitud->fecha }}</td>
                            <td id="estado-{{ $solicitud->id }}">{{ $solicitud->estado }}</td>
                            <td>
                                <button class="btn btn-primary descargar-pdf" data-id="{{ $solicitud->id }}">Descargar
                                    PDF</button>
                                @can('admin.solicitudComponentes.aprobar_solicitud')
                                    @if ($solicitud->estado === 'Pendiente')
                                        <button class="btn btn-warning estado-solicitud" data-solicitud-id="{{ $solicitud->id }}"
                                            data-solicitud-tipo="Pendiente">Aprobar Solicitud</button>
                                    @elseif ($solicitud->estado === 'Aprobado')
                                        <button class="btn btn-info estado-solicitud" data-solicitud-id="{{ $solicitud->id }}"
                                            data-solicitud-tipo="Aprobado">Entregar Componentes</button>
                                    @elseif ($solicitud->estado === 'Componentes Listos')
                                        <button class="btn btn-success estado-solicitud"
                                            data-solicitud-id="{{ $solicitud->id }}" data-solicitud-tipo="Listos">Finalizar
                                            Entrega</button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="detalleOrdenModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detalleOrdenModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallePedidoModalLabel">Detalles Orden de Ensamblaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los detalles del pedido -->
                </div>
            </div>
        </div>
    </div>

    <div id="modalComponentes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalComponentesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalComponentesLabel">Detalles de los Componentes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los detalles de los componentes -->
                </div>
            </div>
        </div>
    </div>


@stop


@section('js')

    <script>
        $(document).ready(function() {
            $('.finalizar-entrega').click(function() {
                var solicitudId = $(this).data('solicitud-id');
                // Realiza la solicitud AJAX para finalizar la entrega de componentes
                // Si la entrega se realiza con éxito, oculta el botón
                $(this).hide();
            });
        });
    </script>


    {{-- detalle orden --}}
    <script>
        $(document).ready(function() {
            $('.detalle-orden').click(function(e) {
                e.preventDefault();

                var idOrden = $(this).data('codigo');

                $.ajax({
                    url: "{{ route('admin.solicitudComponentes.detalle_orden') }}",
                    method: 'GET',
                    data: {
                        id: idOrden
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Construir la tabla de detalles del pedido
                            var tablaDetalle = '<table class="table">';
                            tablaDetalle +=
                                '<thead><tr><th>ID</th><th>Codigo Pedido</th><th>Fecha</th><th>Estado</th></tr></thead>';
                            tablaDetalle += '<tbody>';
                            $.each(response.ordenes, function(index, ordene) {
                                tablaDetalle += '<tr><td>' + ordene.id + '</td>';
                                tablaDetalle +=
                                    '<td><a href="#" class="detalle-componentes" data-codigo="' +
                                    ordene.codigo_pedido +
                                    '">' + ordene.codigo_pedido +
                                    '</a></td>'; // Reemplazar pedido_id por codigo_pedido
                                tablaDetalle += '<td>' + ordene.fecha + '</td>';
                                tablaDetalle += '<td>' + ordene.estado + '</td></tr>';
                            });
                            tablaDetalle += '</tbody></table>';


                            // Mostrar los detalles del pedido en el modal
                            $('#detalleOrdenModal .modal-body').html(tablaDetalle);
                            $('#detalleOrdenModal').modal('show');
                        } else {
                            alert(response.mensaje);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert(
                            'Error al obtener los detalles de la Orden. Consulta la consola para más detalles.'
                        );
                    }
                });
            });
        });
    </script>

    {{-- detalle pedido --}}
    <script>
        $(document).ready(function() {
            $('#detalleOrdenModal').on('click', '.detalle-componentes', function(e) {
                e.preventDefault();

                var codigoPedido = $(this).data('codigo');

                $.ajax({
                    url: "{{ route('admin.solicitudComponentes.detalle_pedido') }}",
                    method: 'GET',
                    data: {
                        codigo: codigoPedido
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Construir la tabla de detalles de los componentes
                            var tablaComponentes = '<table class="table">';
                            tablaComponentes +=
                                '<thead><tr><th>Descripción</th><th>Imagen</th><th>Cantidad</th></tr></thead>';
                            tablaComponentes += '<tbody>';
                            $.each(response.componentes, function(index, componente) {
                                tablaComponentes += '<tr>';
                                tablaComponentes += '<td>' + componente.descripcion +
                                    '</td>';
                                tablaComponentes += '<td><img src="' + componente.url +
                                    '" alt="Imagen" style="max-width: 100px; max-height: 100px;"></td>';
                                tablaComponentes += '<td>' + componente.cantidad +
                                    '</td>';
                                tablaComponentes += '</tr>';
                            });
                            tablaComponentes += '</tbody></table>';

                            // Agregar la tabla de detalles de los componentes al nuevo modal
                            $('#modalComponentes .modal-body').html(tablaComponentes);

                            // Mostrar el nuevo modal con los detalles de los componentes
                            $('#modalComponentes').modal('show');
                        } else {
                            alert(response.mensaje);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert(
                            'Error al obtener los detalles de los componentes. Consulta la consola para más detalles.'
                        );
                    }
                });
            });
        });
    </script>

    {{-- generar PDF --}}
    <script>
        $(document).ready(function() {
            $('.descargar-pdf').click(function(e) {
                e.preventDefault();
                var solicitudId = $(this).data('id');
                // Llama a la función generarPDF pasando el ID de la solicitud
                generarPDF(solicitudId);
            });
        });

        function generarPDF(solicitudId) {
            // Realiza la solicitud AJAX para generar el PDF con el ID de la solicitud
            $.ajax({
                url: "{{ route('admin.solicitudComponentes.generar_pdf') }}",
                method: 'GET',
                data: {
                    id: solicitudId
                },
                success: function(response) {
                    // Si el PDF se generó correctamente, abre una nueva ventana con el contenido base64
                    var pdfWindow = window.open("");
                    pdfWindow.document.write("<iframe width='100%' height='100%' src='" + response.url +
                        "'></iframe>");
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error al generar el PDF. Consulta la consola para más detalles.');
                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            // Manejar clic en el botón "Aprobar Solicitud"
            $('tbody').on('click', '.estado-solicitud', function() {
                var solicitudId = $(this).data(
                'solicitud-id'); // Obtener el ID de la solicitud del atributo data
                var solicitudTipo = $(this).data('solicitud-tipo');

                // Enviar la solicitud AJAX al controlador
                $.ajax({
                    url: "{{ route('admin.solicitudComponentes.actualizarEstado') }}",
                    type: 'GET', // Cambiar el método a GET
                    data: {
                        solicitud_id: solicitudId,
                        solicitud_tipo: solicitudTipo,
                    },
                    success: function(response) {
                        // Mostrar un mensaje en la pantalla
                        alert('Solicitud de Componentes aprobada!');

                        // Actualizar el estado en la tabla
                        $('#estado-' + solicitudId).text(response.estado_actualizado);
                    },

                    error: function(xhr, status, error) {
                        // Manejar errores si es necesario
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>


@stop
