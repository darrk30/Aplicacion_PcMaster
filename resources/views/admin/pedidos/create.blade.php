
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Venta</h1>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span id="card_title">
                        {{ __('Nueva venta') }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pedidos.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="buscarCliente">Buscar Cliente</label>
                            <input id="buscarCliente" class="form-control" type="text" placeholder="Buscar Cliente">
                            <input id="id_cliente" class="form-control" type="hidden" name="id_cliente">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="tel_cliente">Teléfono</label>
                            <input id="tel_cliente" class="form-control" type="text" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="dir_cliente">Direccion</label>
                            <input id="dir_cliente" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    @livewire('admin.pedido-create')

                    <button class="btn btn-primary fixed-button" id="btnVenta" type="submit">Generar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $("#buscarCliente").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('admin.pedidos.cliente') }}",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            if (data.length === 0) {
                                errorCliente.textContent = "No se encontraron resultados.";
                            }
                            response(data);
                        }
                    });
                },
                minLength: 2, // Número mínimo de caracteres para mostrar sugerencias
                select: function(event, ui) {
                    id_cliente.value = ui.item.id;
                    tel_cliente.value = ui.item.telefono,
                        dir_cliente.value = ui.item.direccion
                }
            });

        })
    </script>
@stop
