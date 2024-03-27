@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Registrar Kardex</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.Kardex.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="tipoTransaccion">Tipo de Transacción:</label>
                    <select class="form-control" id="tipoTransaccion" name="tipoTransaccion">
                        <option value="compra">Compra</option>
                        <option value="traslado">Traslado de Componentes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="solicitud_componente_id">ID de la solicitud:</label>
                    <input type="text" class="form-control" id="solicitud_componente_id" name="solicitud_componente_id">
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                </div>
                <div class="form-group">
                    <label for="ubicacion">Ubicación:</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                </div>               
                <div class="form-group">
                    <label for="proveedor_id">Proveedor:</label>
                    <select class="form-control" id="proveedor_id" name="proveedor_id">
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Componentes:</label>
                    <div class="col-sm-10">
                        <div class="row">
                            @foreach ($componentes as $componente)
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="componentes[{{ $componente->id }}][id]" value="{{ $componente->id }}"
                                            id="componente_{{ $componente->id }}">
                                        <label class="form-check-label" for="componente_{{ $componente->id }}">
                                            {{ $componente->codigo }} - {{ $componente->descripcion }}
                                        </label>
                                        <input type="number" class="form-control mt-1"
                                            name="componentes[{{ $componente->id }}][cantidad]" value="0">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
