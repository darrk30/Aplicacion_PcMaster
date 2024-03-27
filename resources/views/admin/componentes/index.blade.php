@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    @can('admin.componentes.create')   
    <a href="{{ route('admin.componentes.create') }}" class="btn btn-secondary float-right">Nuevo Componente</a>
    @endcan
    <h1>Lista de Componentes</h1>
@stop


@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @livewire('admin.componente-index')
@stop

@section('js')
@section('js')
    <script>
        $(document).ready(function() {
            $('.btn-ver-detalles').click(function() {
                // Obtener los datos del componente del botón
                var codigo = $(this).data('codigo');
                var imagen = $(this).data('imagen');
                var descripcion = $(this).data('descripcion');
                var precio = $(this).data('precio');
                var stock = $(this).data('stock');
                var stockMin = $(this).data('stock-min');
                var categoria = $(this).data('categoria');
                var marca = $(this).data('marca');
                var vigente = $(this).data('vigente');

                // Actualizar el contenido del modal con los datos del componente
                $('#codigoComponente').html('<b>CÓDIGO:</b> ' + codigo);
                $('#imagenComponente').attr('src', imagen);
                $('#descripcionComponente').html('<b>DESCRIPCIÓN:</b> ' + descripcion);
                $('#precioComponente').html('<b>PRECIO:</b> S/. ' + precio);
                $('#stockComponente').html('<b>STOCK:</b> ' + stock);
                $('#stockMinComponente').html('<b>STOCK MÍNIMO:</b> ' + stockMin);
                $('#categoriaComponente').html('<b>CATEGORÍA:</b> ' + categoria);
                $('#marcaComponente').html('<b>MARCA:</b> ' + marca);
                $('#vigenteComponente').html('<b>ESTADO:</b> ' + (vigente ? 'Activo' : 'No Activo'));

            });
        });
    </script>
@stop

@stop
