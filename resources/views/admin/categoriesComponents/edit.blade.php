@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Categoria Componente</h1>
@stop

@section('content')
@if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
<div class="card">
    <div class="card-body">
        {!! Form::model($categoriesComponent, ['route' => ['admin.categoriesComponents.update',  $categoriesComponent], 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('nombre', 'Nombre') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'ingrese el nombre de la categoria']) !!}

            @error('nombre')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            {!! Form::label('slug', 'Slug') !!}
            {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'ingrese el slug de la categoria', 'readonly']) !!}
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

        {!! Form::submit('Actualizar Categoria', ['class' => 'btn btn-primary']) !!}
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
