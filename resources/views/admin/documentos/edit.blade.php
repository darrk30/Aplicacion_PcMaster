@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Documento</h1>
@stop

@section('content')
@if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
<div class="card">
    <div class="card-body">
        {!! Form::model($documento, ['route' => ['admin.documentos.update',  $documento], 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('nombre', 'Nombre') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'ingrese el nombre de la documento']) !!}

            @error('nombre')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            {!! Form::label('siglas', 'Siglas') !!}
            {!! Form::text('siglas', null, ['class' => 'form-control', 'placeholder' => 'ingrese las sigla del documento']) !!}
            @error('slug')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            {!! Form::label('cantidadDigitos', 'Catidad de Dijitos') !!}
            {!! Form::text('cantidadDigitos', null, ['class' => 'form-control', 'placeholder' => 'ingrese la cantidad de Digitos del Documento']) !!}
            @error('cantidadDigitos')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            {!! Form::label('slug', 'Slug') !!}
            {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'ingrese el slug del documento', 'readonly']) !!}
            @error('slug')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            {!! Form::label('vigente', 'Vigente') !!}
            {!! Form::text('vigente', 1, ['class' => 'form-control']) !!}
            @error('vigente')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        {!! Form::submit('Actualizar documento', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('js')
    <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}">        
    </script>
    <script>
        $(document).ready(function() {
            $("#nombre").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });
    </script>
@endsection