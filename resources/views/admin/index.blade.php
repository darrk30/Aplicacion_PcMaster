@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                @if (Auth::user()->hasRole('Vendedor'))
                    <img src="{{ Storage::url('img/venta.png') }}" alt="Venta" class="fullscreen-image">
                @elseif(Auth::user()->hasRole('Jefe de Ensamblaje'))
                    <img src="{{ Storage::url('img/ensamblaje.png') }}" alt="Ensamblaje" class="fullscreen-image">
                @elseif(Auth::user()->hasRole('Jefe de Almacen'))
                    <img src="{{ Storage::url('img/almacen.png') }}" alt="Almacén" class="fullscreen-image">
                @elseif(Auth::user()->hasRole('Administrador'))
                    <img src="{{ Storage::url('img/sistema.png') }}" alt="Sistema" class="fullscreen-image">
                @endif
            </div>


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
