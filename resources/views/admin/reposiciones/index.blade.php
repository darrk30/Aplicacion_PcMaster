@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Órdenes de Reposición</h1>
@stop

@section('content')
    @php
        $precioTotalOrden = 0; // Inicializar la variable para el precio total de la orden
    @endphp
    @foreach ($ordenesReposicion as $orden)
        @foreach ($orden->componentes as $componente)
            @php
                $precioTotalOrden += $componente->pivot->cantidad * $componente->precio; // Sumar al precio total de la orden
            @endphp
        @endforeach
    @endforeach
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card-body">
            @if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Jefe de Almacen'))
                <a href="{{ route('admin.reposiciones.create') }}" class="btn btn-primary mb-2">Crear Orden de Reposición</a>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordenesReposicion as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td>{{ $orden->codigo }}</td>
                            <td>{{ $orden->fecha }}</td>
                            <td>{{ $orden->estado }}</td>
                            <td>
                                @if (isset($orden))
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#verComponentes{{ $orden->id }}">
                                        Ver
                                    </button>
                                    @if (isset($orden))
                                        <div class="modal fade" id="verComponentes{{ $orden->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="verComponentes{{ $orden->id }}Label"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="verComponentes{{ $orden->id }}Label">
                                                            Detalles de la Orden de
                                                            Reposición (Código: {{ $orden->codigo }})</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Código del Componente</th>
                                                                    <th>Nombre del Componente</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Sub Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($orden->componentes as $componente)
                                                                    <tr>
                                                                        <td>{{ $componente->codigo }}</td>
                                                                        <td>{{ $componente->descripcion }}</td>
                                                                        <td>{{ $componente->pivot->cantidad }}</td>
                                                                        <td>{{ $componente->pivot->cantidad * $componente->precio }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if (
                                    (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Jefe de Compras')) &&
                                        $orden->estado == 'Pendiente')
                                    <a href="{{ route('admin.reposiciones.aprobar', $orden->id) }}"
                                        class="btn btn-success">Aprobar</a>
                                @endif

                                @if (
                                    (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Jefe de Compras')) &&
                                        $orden->estado == 'Aprobado')
                                    <a href="{{ route('admin.compras.comprar', ['id' => $orden->id, 'precioTotal' => $precioTotalOrden]) }}"
                                        class="btn btn-success">Comprar</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
