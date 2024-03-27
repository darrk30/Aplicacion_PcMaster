@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Orden de Ensamblaje</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('admin.ordenEnsamblaje.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="pedido">Pedido:</label>
                    <input type="text" id="pedido" name="pedido" class="form-control" value="{{ $codigoPedido }}"
                        readonly>
                </div>
                <input type="hidden" value="{{ $idPedido }}" id="idPedido" name="idPedido">
                <div class="form-group">
                    <label for="fecha">Fecha y Hora:</label>
                    <input type="datetime-local" id="fecha" name="fecha" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <input type="text" id="estado" name="estado" class="form-control" value="Pendiente" readonly>
                </div>
                <a href="{{ route('admin.pedidos.index') }}" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>





@stop


@section('js')

    <script>
        // Obtener la fecha y hora actual en formato YYYY-MM-DDTHH:MM
        const now = new Date().toISOString().slice(0, 16);
        // Establecer la fecha y hora actual como valor predeterminado en el campo
        document.getElementById("fecha").value = now;
    </script>
@stop
