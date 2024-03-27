{{-- <div class="row">
    <div class="col-md-4">
        <!-- Aquí va tu formulario -->
        <div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('codigo', 'Código:') !!}
                    {!! Form::text('codigo', $codigoPedido, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('fechaPedido', 'Fecha de Pedido:') !!}
                    {!! Form::datetimeLocal('fechaPedido', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('descripcion', 'Descripción:') !!}
                {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('fechaEntrega', 'Fecha de Entrega:') !!}
                    {!! Form::date('fechaEntrega', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('montoTotal', 'Monto Total:') !!}
                    {!! Form::number('montoTotal', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('estadoPago', 'Estado de Pago:') !!}
                    {!! Form::select('estadoPago', ['pagado' => 'Pagado', 'pendiente' => 'Pendiente'], null, [
                        'class' => 'form-control',
                    ]) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('cliente_id', 'Cliente:') !!}
                    <div class="input-group">
                        {!! Form::text('numeroDoc', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese el numero de documento del cliente',
                            'wire:model.defer' => 'numeroDocumento',
                        ]) !!}
                        <div class="input-group-append">
                            <a href="#" wire:click="buscarCliente" class="btn btn-outline-secondary"
                                type="button">Buscar</a>
                        </div>
                    </div>
                    @if (isset($clienteEncontrado) && $clienteEncontrado)
                        <input type="text" class="form-control mt-2" value="{{ $clienteId }}" readonly hidden>
                        <input type="text" class="form-control mt-2" value="{{ $nombres }}" readonly>
                        <input type="text" class="form-control mt-2" value="{{ $apellidos }}" readonly>
                    @elseif(isset($mostrarMensaje) && $mostrarMensaje)
                        <div class="alert alert-danger mt-2" role="alert" id="mensaje">
                            No se encontró el cliente.
                            <a href="#" wire:click="mostrarCrearCliente" class="btn btn-primary btn-sm ml-2">Crear
                                Cliente</a>
                            <a href="#" onclick="cerrarMensaje()" class="btn btn-secondary btn-sm ml-2"
                                type="button">Cerrar</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('user_id', 'Vendedor:') !!}
                {!! Form::text('user_id', auth()->user()->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('estadoPago', 'Estado del Pedido:') !!}
                {!! Form::select('estadoPago', ['confirmado' => 'Confirmado'], null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('vigente', 'Estado del Pedido:') !!}
                {!! Form::select('vigente', ['1' => 'Vigente', '0' => 'No vigente'], null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <!-- Buscador -->
        <div class="form-group">
            {!! Form::label('codigoComp', 'Buscar por código:') !!}
            <div class="input-group">
                {!! Form::text('codigoComp', null, ['class' => 'form-control', 'wire:model.defer' => 'codigoComp']) !!}
                <div class="input-group-append">
                    <button wire:click.prevent="buscarComponente" class="btn btn-outline-secondary" type="button">Buscar</button>
                </div>
                
            </div>
        </div>

        <!-- Campos de entrada -->
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('cantidad', 'Cantidad:') !!}
                {!! Form::number('cantidad', null, ['class' => 'form-control', 'id' => 'cantidad']) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('des', 'Descripcion:') !!}
                {!! Form::text('des', $descripcionComp, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>

            <div class="form-group col-md-4">
                {!! Form::label('stock', 'Stock:') !!}
                {!! Form::text('stock', $stockComp, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('precio', 'Precio:') !!}
                {!! Form::text('precio', $precioComp, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>
        </div>

        <!-- Botón de agregar -->
        <a href="#" type="button" class="btn btn-primary" id="btnAgregar">Agregar</a>


        <!-- Tabla de componentes agregados -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody id="tablaComponentes">
                <!-- Aquí se agregarán los componentes -->
            </tbody>
        </table>
    </div>

</div> --}}

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">

                <input wire:model.live="search" type="text" placeholder="Buscar componentes..."
                    class="form-control mb-2">

                <div class="row">
                    @foreach ($componentes as $componente)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body card-container">
                                    <div class="img-container overflow-hidden">
                                        <img class="img-thumbnail"
                                            src="{{ $componente->url ? $componente->url : asset('img/default.png') }}"
                                            alt="Imagen del componente">
                                    </div>
                                    <button class="btn btn-primary btn-sm button" type="button"
                                        wire:click="addToCart({{ $componente->id }})">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                    <br />
                                    <h5 class="card-title">{{ $componente->descripcion }}</h5>
                                    <p class="card-text">S/. {{ number_format($componente->precio, 2) }}</p>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                {{ $componentes->links() }}
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <!-- Carrito de compras -->
        <!-- Carrito de compras -->
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['descripcion'] }}</td>
                            <td>
                                <input type="number" wire:model="cartItems.{{ $loop->index }}.qty" class="form-control">
                            </td>
                            <td>S/ {{ number_format($item['precio'], 2) }}</td>
                            <td>
                                <a href="#" wire:click="removeFromCart('{{ $item['id'] }}')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <!-- Agrupar todos los campos ocultos en una sola celda -->
                            <input type="hidden" name="cartItems[{{ $loop->index }}][qty]" value="{{ $item['qty'] }}">
                            <input type="hidden" name="cartItems[{{ $loop->index }}][precio]" value="{{ $item['precio'] }}">
                            <input type="hidden" name="cartItems[{{ $loop->index }}][id]" value="{{ $item['id'] }}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <h5>Total del Carrito: S/ {{ $this->getCartSubtotal() }}</h5>
                <input type="hidden" name="montoTotal" value="{{ $this->getCartSubtotal() }}">
            </div>
        </div>
        
    </div>
</div>
