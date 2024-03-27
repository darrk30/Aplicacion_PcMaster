@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Nuevo Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.clientes.store', 'autocomplete' => 'off', 'files' => true]) !!}            
            @include('admin.clientes.partials.form')

            {!! Form::submit('Crear Cliente', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

