<div class="card">
    <div class="card-header form-group">
        <div class="row">
            <!-- Input de búsqueda -->
            <div class="col-md-6">
                <input wire:model="search" class="form-control" placeholder="Buscar Documento">
            </div>
            <!-- Combo para filtrar por marca -->
            <div class="col-md-6">
                <select wire:model="documento_id" class="form-control">
                    <option value="">Seleccionar Documento</option>
                    @foreach ($documentos as $documento)
                        <option value="{{ $documento->id }}">{{ $documento->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Tipo de Documento</th>
                        <th>Numero Documento</th>
                        <th colspan="3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nombres }}</td>
                            <td>{{ $cliente->apellidos }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ optional($cliente->documento)->nombre }}</td>
                            <td>{{ $cliente->numeroDoc }}</td>
                            <td width="5">
                                <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn btn-primary"
                                    title="Editar"><i class="fas fa-edit"></i></a>
                            </td>
                            <td width="5">
                                @if ($cliente->vigente == 1)
                                    <button wire:click="toggleVigente({{ $cliente->id }}, 0)" class="btn btn-success"
                                        title="Activo"><i class="fas fa-check-circle"></i></button>
                                @else
                                    <button wire:click="toggleVigente({{ $cliente->id }}, 1)" class="btn btn-danger"
                                        title="Desactivado"><i class="fas fa-times-circle"></i></button>
                                @endif
                            </td>
                            <td width="5">
                                <form action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit" title="Eliminar"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
