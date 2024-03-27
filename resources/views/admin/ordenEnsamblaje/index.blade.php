@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Orden de Ensamblaje</h1>
@stop

@section('content')
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>pedido</th>
                        <th>fecha</th>
                        <th>estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordenes as $orden)
                        <tr id="orden-{{ $orden->id }}" class="{{ $loop->last ? 'ultima-orden' : '' }}">
                            <td>{{ $orden->id }}</td>
                            <td>{{ $orden->pedido->codigo }}</td>
                            <td>{{ $orden->fecha }}</td>
                            <td id="estado-{{ $orden->id }}">{{ $orden->estado }}</td>
                            @can('admin.ordenEnsamblaje.aprobar_orden')
                            <td>
                                <!-- Agrega un botón "Aprobar Orden" en cada fila -->
                                @if ($orden->estado == 'Pendiente')
                                    <button class="btn btn-primary btn-aprobar-orden"
                                        data-orden-id="{{ $orden->id }}">Aprobar Orden</button>
                                        
                                @endif
                            </td>
                            @endcan

                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Manejar clic en el botón "Aprobar Orden"
            $('.btn-aprobar-orden').click(function() {
                var ordenId = $(this).data('orden-id'); // Obtener el ID de la orden del atributo data

                // Enviar la solicitud AJAX al controlador
                $.ajax({
                    url: "{{ route('admin.ordenEnsamblaje.aprobar_orden') }}",
                    type: 'POST',
                    data: {
                        orden_id: ordenId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Mostrar un mensaje en la pantalla
                        alert('¡Orden de ensamblaje aprobada!');

                        // Actualizar el estado en la tabla
                        $('#estado-' + ordenId).text(response.estado_actualizado);
                    },

                    error: function(xhr, status, error) {
                        // Manejar errores si es necesario
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.detalle-pedido').click(function(e) {
                e.preventDefault();

                var codigoPedido = $(this).data('codigo');

                $.ajax({
                    url: "{{ route('admin.ordenEnsamblaje.detalle_pedido') }}",
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



@stop
