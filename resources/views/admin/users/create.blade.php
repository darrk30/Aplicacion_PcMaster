@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Nuevo Trabajador</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.users.store', 'autocomplete' => 'off', 'files' => true]) !!}            
            @include('admin.users.partials.form')
            
            {!! Form::submit('Crear Trabajador', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop



