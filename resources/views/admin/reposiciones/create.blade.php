@extends('adminlte::page')
@section('title', 'Crear Orden de Reposición')

@section('content_header')
    <h1>Crear Orden de Reposición</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.reposiciones.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ uniqid() }}" readonly>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" readonly>
                </div>
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <input type="text" class="form-control" id="estado" name="estado" value="Pendiente" readonly>
                </div>
                <div class="form-group">
                    <label for="componentes">Componentes:</label>
                    <div class="row">
                        @foreach($componentes as $componente)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="componentes[]" value="{{ $componente->id }}" id="componente_{{ $componente->id }}">
                                    <label class="form-check-label" for="componente_{{ $componente->id }}">
                                        {{ $componente->codigo }} - {{ $componente->descripcion }}
                                    </label>
                                    <input type="number" class="form-control mt-1" name="cantidad_{{ $componente->id }}" value="0" placeholder="Cantidad">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Orden</button>
            </form>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
