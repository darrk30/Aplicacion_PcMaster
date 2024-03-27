@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Documentos</h1>
@stop

@section('content')
@if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
    <div class="card">
        <div class="card-header">
            <a href="{{route('admin.documentos.create')}}" class="btn btn-success">Nuevo Documento</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Siglas</th>
                        <th>Slug</th>
                        <th>Vigente</th>                        
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentos as $documento)
                        <tr>
                            <td>{{$documento->id}}</td>
                            <td>{{$documento->nombre}}</td>
                            <td>{{$documento->siglas}}</td>
                            <td>{{$documento->slug}}</td>
                            <td>{{$documento->vigente}}</td>                        <td width ='10px'>
                                <a href="{{route('admin.documentos.edit', $documento)}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            </td >
                            <td width ='10px'>
                                <form action="{{route('admin.documentos.destroy', $documento)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
@stop

