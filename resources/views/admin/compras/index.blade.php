@extends('adminlte::page')
@section('title', 'Lista de Compras')

@section('content_header')
    <h1>Lista de Compras</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.compras.create') }}" class="btn btn-primary mb-2">Crear Compra</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Fecha Entrega</th>
                        <th>Proveedor</th>
                        <th>Precio Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ $compra->codigo }}</td>
                            <td>{{ $compra->fecha }}</td>
                            <td>{{ $compra->fechaEntrega }}</td>
                            <td>{{ $compra->proveedor->nombre }}</td>
                            <td>{{ $compra->precioTotal }}</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#verComponentes{{ $compra->id }}">
                                    Ver
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($compras as $compra)
        <div class="modal fade" id="verComponentes{{ $compra->id }}" tabindex="-1" role="dialog"
            aria-labelledby="verComponentes{{ $compra->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verComponentes{{ $compra->id }}Label">Componentes de la Compra (Código: {{ $compra->codigo }})</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compra->ordenReposicion->componentes as $componente)
                                    <tr>
                                        <td>{{ $componente->descripcion }}</td>
                                        <td>{{ $componente->pivot->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@stop

@section('css')

@stop

@section('js')

@stop
