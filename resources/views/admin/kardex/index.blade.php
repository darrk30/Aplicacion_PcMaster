@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <a href="{{ route('admin.Kardex.create') }}" class="btn btn-secondary float-right">Registrar Kardex</a>
    <h1>Registros del Kardex</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo de Transacción</th>
                        <th>Fecha</th>
                        <th>Ubicación</th>
                        <th>Descripción</th>
                        <th>ID del Proveedor</th>
                        <th>ID de la Solicitud de Componente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kardexs as $kardex)
                        <tr>
                            <td>{{ $kardex->id }}</td>
                            <td>{{ $kardex->tipoTransaccion }}</td>
                            <td>{{ $kardex->fecha }}</td>
                            <td>{{ $kardex->ubicacion }}</td>
                            <td>{{ $kardex->descripcion }}</td>
                            <td>{{ $kardex->proveedor_id }}</td>
                            <td>{{ $kardex->solicitud_componente_id }}</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#verComponentes{{ $kardex->id }}">
                                    Ver
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="verComponentes{{ $kardex->id }}" tabindex="-1" role="dialog" aria-labelledby="verComponentes{{ $kardex->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="verComponentes{{ $kardex->id }}Label">Componentes Seleccionados</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @foreach($kardex->componentes as $componente)
                                                    <div>{{ $componente->codigo }} - {{ $componente->descripcion }} {{ $componente->cantidad }})</div>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Fin del modal -->
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
    <script>
        console.log('Hi!');
    </script>
@stop
