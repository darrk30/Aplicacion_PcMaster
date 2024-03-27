@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    @can('admin.pedidos.create')
        <a href="{{ route('admin.pedidos.create') }}" class="btn btn-secondary float-right">Nuevo Pedido</a>
    @endcan
    <h1>Lista de Pedidos</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @livewire('admin.pedido-index')
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(".btn-ver-detalles").click(function() {
                var codigoPedido = $(this).data('codigo');

                $.ajax({
                    url: "{{ route('admin.pedidos.detalles') }}", // URL de la ruta Laravel
                    data: {
                        codigoPedido: codigoPedido
                    }, // Parámetro pasado a través de la data
                    type: "GET",
                    success: function(response) {
                        // Manejo de la respuesta exitosa
                        console.log(response); // Muestra la respuesta en la consola

                        // Limpiar el contenido actual del modal
                        $('#detallePedidoContent').empty();

                        // Construir la tabla para mostrar los detalles
                        var tablaDetalles = '<table class="table table-striped">' +
                            '<thead>' +
                            '<tr>' +
                            '<th>Descripción</th>' +
                            '<th>Cantidad</th>' +
                            '<th>Subtotal</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';

                        // Iterar sobre cada objeto en la respuesta
                        response.forEach(function(detalle) {
                            // Construir una fila de la tabla para cada detalle
                            var filaDetalle = '<tr>' +
                                '<td>' + detalle.descripcion_componente + '</td>' +
                                '<td>' + detalle.cantidad + '</td>' +
                                '<td>' + parseFloat(detalle.subtotal).toFixed(2) +
                                '</td>'


                            '</tr>';

                            // Agregar la fila a la tabla
                            tablaDetalles += filaDetalle;
                        });

                        // Cerrar la etiqueta de tbody y de la tabla
                        tablaDetalles += '</tbody></table>';

                        // Agregar la tabla al contenido del modal
                        $('#detallePedidoContent').html(tablaDetalles);

                        // Mostrar el modal
                        $('#detallePedidoModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        // Manejo de errores
                        console.error(xhr.responseText);
                    }
                });



            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-finalizar').click(function(e) {
                e.preventDefault();

                var pedidoId = $(this).data('codigo-pedido');

                // Realizar la solicitud AJAX para finalizar el pedido
                $.ajax({
                    url: "{{ route('admin.pedidos.finalizarPedido') }}",
                    method: 'POST',
                    data: {
                        id: pedidoId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Mostrar un mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message
                        }).then(function() {
                            // Recargar la tabla para ver el estado actualizado
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores si es necesario
                        console.error(xhr.responseText);
                        alert(
                            'Error al finalizar el pedido. Consulta la consola para más detalles.'
                            );
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('.btn-entregar-pedido').click(function(e) {
            e.preventDefault();

            var pedidoId = $(this).data('codigo-pedido');

            // Realizar la solicitud AJAX para finalizar el pedido
            $.ajax({
                url: "{{ route('admin.pedidos.entregarPedido') }}",
                method: 'POST',
                data: {
                    id: pedidoId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Mostrar un mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    }).then(function() {
                        // Recargar la tabla para ver el estado actualizado
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // Manejar errores si es necesario
                    console.error(xhr.responseText);
                    alert(
                        'Error al entregar el pedido. Consulta la consola para más detalles.'
                        );
                }
            });
        });
    });
</script>
@stop
