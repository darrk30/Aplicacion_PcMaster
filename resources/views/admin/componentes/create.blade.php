@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Nuevo Componente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.componentes.store', 'autocomplete' => 'off', 'files' => true]) !!}
            
            @include('admin.componentes.partials.form')

            {!! Form::submit('Crear Componente', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop


