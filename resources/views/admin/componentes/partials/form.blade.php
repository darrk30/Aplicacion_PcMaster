<div class="form-row">
    <div class="form-group col-md-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Codigo</span>
            </div>
            {!! Form::text('codigo', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el codigo',
                'aria-label' => 'Codigo',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('codigo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-group col-md-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                {!! Form::label('descripcion', 'Descripcion', ['class' => 'input-group-text']) !!}
            </div>
            {!! Form::text('descripcion', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese Descripcion del componente',
            ]) !!}
        </div>
        @error('descripcion')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>


<div class="form-row">

    <div class="form-group col-md-4">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Precio</span>
            </div>
            {!! Form::text('precio', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el precio',
                'aria-label' => 'Precio',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('precio')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Stock</span>
            </div>
            {!! Form::text('stock', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el stock del componente',
                'aria-label' => 'Stock',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('stock')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Stock Minimo</span>
            </div>
            {!! Form::text('stockmin', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el stock min del componente',
                'aria-label' => 'Stock Minimo',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('stockmin')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Categoria</span>
            </div>
            {!! Form::select('category_id', $category, 'null', [
                'class' => 'form-control',
                'aria-label' => 'Categoria',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('category_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Marca</span>
            </div>
            {!! Form::select('marca_id', $marcas, null, [
                'class' => 'form-control',
                'aria-label' => 'Marca',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('marca_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

</div>
<div class="form-group ">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            {!! Form::label('slug', 'Slug', ['class' => 'input-group-text']) !!}
        </div>
        {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el slug', 'readonly']) !!}
        @error('slug')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>


{!! Form::label('file', 'Imagen del Componente') !!}
<div class="image-wrapper">
    @isset ($componente->url)
        <img id="picture" src="{{ $componente->url  }}" alt="Sin Imagen">
    @else
        <img id="picture" src="https://static.vecteezy.com/system/resources/previews/004/141/669/non_2x/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg"
            alt="Sin Imagen">
    @endisset
</div>
<div class="form-group">
    {!! Form::file('file', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}
    @error('file')
        <small class="tenxt-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <p class="font-weight-bold">
        Estado
    </p>
    <label>
        {!! Form::radio('vigente', 1) !!}
        Activo
    </label>
    <label class="ml-3">
        {!! Form::radio('vigente', 0, true) !!}
        No Activo
    </label>
    @error('vigente')
        <small class="tenxt-danger">{{ $message }}</small>
    @enderror
</div>

@section('css')
    <style>
        .image-wrapper img {
            max-width: 200px;
            /* Establece el ancho máximo de la imagen */
            max-height: 200px;
            /* Establece la altura máxima de la imagen */
            border: solid black 1px;
            border-radius: 10px;
            margin-bottom: 5px;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#descripcion").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });

        document.getElementById("file").addEventListener('change', cambiarImagen);

        function cambiarImagen(event) {
            var file = event.target.files[0];

            var reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById("picture").setAttribute('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
    </script>
@stop
