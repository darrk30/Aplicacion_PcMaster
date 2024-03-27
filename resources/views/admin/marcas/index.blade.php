@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Marcas</h1>
@stop

@section('content')
@if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
    <div class="card">
        <div class="card-header">
            <a href="{{route('admin.marcas.create')}}" class="btn btn-success">Nueva Marca</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Vigente</th>                        
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($marcas as $marca)
                        <tr>
                            <td>{{$marca->id}}</td>
                            <td>{{$marca->nombre}}</td>
                            <td>{{$marca->slug}}</td>
                            <td>{{$marca->vigente}}</td>                       
                            <td width ='10px'>
                                <a href="{{route('admin.marcas.edit', $marca)}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            </td >
                            <td width ='10px'>
                                <form action="{{route('admin.marcas.destroy', $marca)}}" method="POST">
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

