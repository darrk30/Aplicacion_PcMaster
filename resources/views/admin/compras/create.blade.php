@extends('adminlte::page')
@section('title', 'Crear Orden de Reposición')

@section('content_header')
    <h1>Crear Orden de Reposición</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.compras.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ uniqid() }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="fechaEntrega">Fecha de Entrega:</label>
                    <input type="date" class="form-control" id="fechaEntrega" name="fechaEntrega" required>
                </div>

                <div class="form-group">
                    <label for="precioTotal">Precio Total:</label>
                    <input type="number" class="form-control" id="precioTotal" name="precioTotal" step="0.01"
                        value="{{ isset($precioTotal) ? $precioTotal : '' }}" required>
                </div>


                <div class="form-group">
                    <label for="proveedor_id">Proveedor:</label>
                    <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="orden_reposicion_id">Orden de Reposición:</label>
                    <input type="text" class="form-control" id="orden_reposicion_id" name="orden_reposicion_id"
                        value="{{ isset($id) ? $id : '' }}" required>
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
