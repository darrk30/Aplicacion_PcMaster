<div class="card">
    <div class="card-header form-group">
        <div class="row">
            <!-- Input de búsqueda -->
            <div class="col-md-4">
                <input wire:model="search" class="form-control" placeholder="Buscar Componente">
            </div>
            <!-- Combo para filtrar por marca -->
            <div class="col-md-4">
                <select wire:model="marca_id" class="form-control">
                    <option value="">Seleccionar marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Combo para filtrar por categoría -->
            <div class="col-md-4">
                <select wire:model="categoria_id" class="form-control">
                    <option value="">Seleccionar categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @if ($componentes->count())
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Codigo</th>
                            <th>Imagen</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th colspan="3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($componentes as $componente)
                            <tr>
                                <td>{{ $componente->id }}</td>
                                <td>{{ $componente->codigo }}</td>
                                <td>
                                    @isset($componente->url)
                                        <img id="picture" src="{{ $componente->url }}" alt="Sin Imagen" width="100"
                                            style="border: solid 1px">
                                    @else
                                        <img src="https://static.vecteezy.com/system/resources/previews/004/141/669/non_2x/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg"
                                            alt="Sin Imagen" width="100" style="border: solid 0.5px">
                                    @endisset
                                </td>
                                {{-- <td><img src="{{ $componente->url }}" alt="Imagen de componente" width="100"></td> --}}
                                <td>{{ $componente->descripcion }}</td>
                                <td>S/. {{ round($componente->precio, 2)}}</td>
                                <td>{{ $componente->stock }}</td>

                                <td width="10">
                                    <div class="btn-group" role="group" aria-label="Botones de acción">
                                        @can('admin.componentes.edit')   
                                        <a href="{{ route('admin.componentes.edit', $componente) }}"
                                            class="btn btn-primary" title="Editar"><i class="fas fa-edit"></i></a>
                                        @endcan                                         
                                        <a href="#" class="btn btn-info btn-ver-detalles" title="Ver detalles"
                                            data-toggle="modal" data-target="#detalleComponenteModal"
                                            data-codigo="{{ $componente->codigo }}"
                                            data-imagen="{{ $componente->url }}"
                                            data-descripcion="{{ $componente->descripcion }}"
                                            data-precio="{{ $componente->precio }}"
                                            data-stock="{{ $componente->stock }}"
                                            data-stock-min="{{ $componente->marca->nombre }}"
                                            data-vigente="{{ $componente->vigente }}">
                                            <i class="fas fa-info-circle"></i>
                                        </a>

                                        {{-- <a href="{{ route('admincomponente->stockmin }}"
                                            data-categoria="{{ $componente->category->nombre }}"
                                            data-marca="{{ $.componentes.show', $componente) }}"
                                            class="btn btn-info" title="Ver detalles"><i
                                                class="fas fa-info-circle"></i></a> --}}
                                        @can('admin.componentes.update')
                                        @if ($componente->vigente == 1)
                                            <button wire:click="toggleVigente({{ $componente->id }}, 0)"
                                                class="btn btn-success" title="Activo"><i
                                                    class="fas fa-check-circle"></i></button>
                                        @else
                                            <button wire:click="toggleVigente({{ $componente->id }}, 1)"
                                                class="btn btn-danger" title="Desactivado"><i
                                                    class="fas fa-times-circle"></i></button>
                                        @endif
                                        @endcan
                                    </div>
                                </td>
                                <td width="10">
                                    @can('admin.componentes.destroy')   
                                    <form action="{{ route('admin.componentes.destroy', $componente) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" title="Eliminar"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $componentes->links() }}
        </div>
    @else
        <div class="card-body text-center">
            <strong>No se encontraron registros para <span class="text-red">{{ $search }}</span></strong>
        </div>
    @endif



    <!-- Agrega este modal al final de tu vista -->
    <div class="modal fade" id="detalleComponenteModal" tabindex="-1" aria-labelledby="detalleComponenteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title text-white" id="detalleComponenteModalLabel"><b>DETALLES DEL COMPONENTE</b></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Primera columna: Imagen y Código -->
                    
                    <div class="col-md-4">
                        <img id="imagenComponente" src="" alt="Imagen del Componente"
                            style="width: 250px; height: auto; mb-3">                        
                    </div>
                    <!-- Segunda columna: Descripción, Precio, Stock y Stock Mínimo -->
                    <div class="col-md-4">
                        <div id="codigoComponente" class="input-group mb-3"></div>
                        <div id="descripcionComponente" class="input-group mb-3"></div>
                        <div id="precioComponente" class="input-group mb-3"></div>
                        <div id="stockComponente" class="input-group mb-3"></div>
                        
                    </div>
                    <!-- Tercera columna: Categoría, Marca y Estado -->
                    <div class="col-md-4">
                        <div id="stockMinComponente" class="input-group mb-3"></div>
                        <div id="categoriaComponente" class="input-group mb-3"></div>
                        <div id="marcaComponente" class="input-group mb-3"></div>
                        <div id="vigenteComponente" class="input-group mb-3"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




</div>
