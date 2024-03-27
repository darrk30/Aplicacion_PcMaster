@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Pedidos Enviados</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.EnvioPedidos.create') }}" class="btn btn-success">Nuevo Envio Pedido</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo Pedido</th>
                        <th>Fecha</th>
                        <th>Descripcion</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enviosPedidos as $envioPedido)
                        <tr>
                            <td>{{ $envioPedido->id }}</td>
                            <td>{{ $envioPedido->pedido->codigo }}</td>
                            <td>{{ $envioPedido->fechaEntrega }}</td>
                            <td>{{ $envioPedido->descripcion }}</td>
                            <td width ='10px'>
                                <a href="{{ route('admin.EnvioPedidos.edit', $envioPedido) }}" class="btn btn-primary"><i
                                        class="fas fa-edit"></i></a>
                            </td>
                            <td width ='10px'>
                                <form action="{{ route('admin.EnvioPedidos.destroy', $envioPedido) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
