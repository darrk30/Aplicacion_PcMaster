<div class="card">
    <!-- Encabezado de la tabla -->
    <div class="card-header form-group">
        <div class="row">
            <!-- Input de búsqueda -->
            <div class="col-md-6">
                <input wire:model="search" class="form-control" placeholder="Buscar Documento">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabla de pedidos -->
            <table class="table table-striped">
                <!-- Encabezados de la tabla -->
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Codigo</th>
                        <th>Fecha</th>
                        <th>Fecha de Entrega</th>
                        <th>Estado</th>
                        <th>Monto Total</th>
                        <th>Cliente</th>
                        <th>Numero Documento</th>
                        <th>Vendedor</th>
                        <th colspan="4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->codigo }}</td>
                            <td>{{ $pedido->fechaPedido }}</td>
                            <td>{{ $pedido->fechaEntrega }}</td>
                            <td>{{ $pedido->estadoPedido }}</td>
                            <td>{{ number_format($pedido->montoTotal, 2) }}</td>
                            <td>{{ optional($pedido->cliente)->nombres }}</td>
                            <td>{{ optional($pedido->cliente)->numeroDoc }}</td>
                            <td>{{ $pedido->user->name }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Botones de acción">
                                    @can('admin.pedidos.edit')
                                        <a href="{{ route('admin.pedidos.edit', $pedido) }}" class="btn btn-primary"
                                            title="Editar"><i class="fas fa-edit"></i></a>
                                    @endcan

                                    <a href="#" class="btn btn-info btn-ver-detalles" title="Ver detalles"
                                        data-toggle="modal" data-target="#detallePedidoModal"
                                        data-codigo="{{ $pedido->codigo }}">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    @can('admin.pedidos.edit')
                                        @if ($pedido->vigente == 1)
                                            <button wire:click="toggleVigente({{ $pedido->id }}, 0)"
                                                class="btn btn-success" title="Activo"><i
                                                    class="fas fa-check-circle"></i></button>
                                        @else
                                            <button wire:click="toggleVigente({{ $pedido->id }}, 1)"
                                                class="btn btn-danger" title="Desactivado"><i
                                                    class="fas fa-times-circle"></i></button>
                                        @endif
                                    @endcan

                                </div>
                            </td>
                            <td>
                                @can('admin.pedidos.destroy')
                                    <form action="{{ route('admin.pedidos.destroy', $pedido) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" title="Eliminar"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                @endcan
                            </td>
                            <td>

                                @can('admin.ordenEnsamblaje.crear')
                                    @if ($pedido->estadoPedido == 'confirmado')
                                        <a href="{{ route('admin.ordenEnsamblaje.crear', $pedido->id) }}"
                                            class="btn btn-secondary float-right">Nueva Orden</a>
                                    @endif
                                @endcan
                            </td>
                            <td>
                                @can('admin.pedidos.finalizarPedido')
                                    @if ($pedido->estadoPedido == 'Proceso de Ensamblaje')
                                        <a href="#" class="btn btn-warning btn-finalizar" title="Finalizar Pedido"
                                            data-codigo-pedido="{{ $pedido->id }}">
                                            Finalizar Pedido</a>
                                    @endif
                                @endcan
                            </td>
                            <td>
                                @can('admin.pedidos.entregarPedido')
                                    @if ($pedido->estadoPedido == 'Pedido Listo')
                                        <a href="#" class="btn btn-success btn-entregar-pedido"
                                            title="Entregar Pedido" data-codigo-pedido="{{ $pedido->id }}">
                                            Entregar Pedido</a>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal de detalles del pedido -->
<div class="modal fade" id="detallePedidoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles del Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <!-- Aquí se cargarán los detalles del pedido -->
                <div id="detallePedidoContent"></div>
            </div>
        </div>
    </div>
</div>
