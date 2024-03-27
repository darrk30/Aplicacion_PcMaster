@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')    
    <a href="{{ route('admin.clientes.create') }}" class="btn btn-secondary float-right">Nuevo Cliente</a>
    <h1>Lista de Clientes</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @livewire('admin.clientes-index')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
