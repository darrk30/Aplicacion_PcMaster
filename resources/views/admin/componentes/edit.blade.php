@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Componente</h1>
@stop

@section('content')
@if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
    <div class="card">
        <div class="card-body">
            {!! Form::model($componente, ['route' => ['admin.componentes.update', $componente], 'autocomplete' => 'off', 'files' => true, 'method' => 'put']) !!}
            
            @include('admin.componentes.partials.form')

            {!! Form::submit('Actualizar Componente', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')	
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
