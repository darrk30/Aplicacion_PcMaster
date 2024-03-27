@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Envio del Pedido</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('admin.EnvioPedidos.store') }}" method="POST">
            @csrf <!-- Agrega el token CSRF -->
            <div class="form-group">
                <label for="buscarCodigo">Buscar Codigo Pedido</label>
                <input id="buscarCodigo" class="form-control" type="text" placeholder="Buscar Codigo del Pedido">
                <input id="id_pedido" class="form-control" type="hidden" name="id_pedido">
            </div>
            <div class="form-group">
                <label for="fecha_actual">Fecha Actual:</label>
                <input type="date" class="form-control" id="fecha_actual" name="fecha_actual"
                    value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion"
                    placeholder="Ingrese una descripcion">
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $("#buscarCodigo").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('admin.EnvioPedidos.BuscarCodigo') }}",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            console.log(data); // Imprime los datos recibidos en la consola
                            if (data.length === 0) {
                                console.error("No se encontraron resultados.");
                            }
                            response(data);
                        }
                    });
                },
                minLength: 2, // Número mínimo de caracteres para mostrar sugerencias
                select: function(event, ui) {
                    id_pedido.value = ui.item.id;
                }
            });
        });
    </script>
@stop
