@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Nuevo Documento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.documentos.store']) !!}
            <div class="form-group">
                {!! Form::label('nombre', 'Nombre') !!}
                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'ingrese el nombre del Documento']) !!}

                @error('nombre')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('siglas', 'Siglas') !!}
                {!! Form::text('siglas', null, ['class' => 'form-control', 'placeholder' => 'ingrese las Siglas del Documento']) !!}
                @error('siglas')
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
                {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'ingrese el slug del Documento', 'readonly']) !!}
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

            {!! Form::submit('Crear Documento', ['class' => 'btn btn-primary']) !!}
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
