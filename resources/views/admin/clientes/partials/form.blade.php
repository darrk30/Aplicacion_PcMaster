<div class="form-row">
    <div class="form-group col-md-6">
        <div class="input-group ">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Nombres</span>
            </div>
            {!! Form::text('nombres', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese los nombres del cliente',
                'aria-label' => 'nombres',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('nombres')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    <div class="form-group col-md-6">
        <div class="input-group ">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Apellidos</span>
            </div>
            {!! Form::text('apellidos', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese los Apellidos del cliente',
                'aria-label' => 'Apellidos',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('apellidos')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

</div>




<div class="form-row">
    <div class="form-group col-md-3">
        <div class="input-group ">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Telefono</span>
            </div>
            {!! Form::text('telefono', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el telefono',
                'aria-label' => 'telefono',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('telefono')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Correo</span>
            </div>
            {!! Form::text('correo', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el Correo del Cliente',
                'aria-label' => 'cliente',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('correo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Dirección</span>
            </div>
            {!! Form::text('direccion', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese la Dirección del Cliente',
                'aria-label' => 'direccion',
                'aria-describedby' => 'inputGroup-sizing-default',
            ]) !!}
        </div>
        @error('correo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <div class="input-group ">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Tipo de Documento</span>
            </div>
            {!! Form::select('documento_id', ['' => 'Seleccione el Tipo de Documento'] + $documentos->toArray(), null, [
                'class' => 'form-control',
                'aria-label' => 'documento',
                'aria-describedby' => 'inputGroup-sizing-default',
                'id' => 'documento_id', // Añadimos un ID para referenciarlo en el script
            ]) !!}

        </div>
        @error('documento_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Numero de Documento</span>
            </div>
            {!! Form::text('numeroDoc', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el Numero del Documento',
                'aria-label' => 'Numero Documento',
                'aria-describedby' => 'inputGroup-sizing-default',
                'id' => 'numeroDoc', // Añadimos un ID para referenciarlo en el script
                // 'disabled' => true, // Inicialmente bloqueado
            ]) !!}
        </div>
        @error('numeroDoc')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>





<div class="form-group">
    <p class="font-weight-bold mb-2">
        Estado
    </p>
    <div class="custom-control custom-radio">
        {!! Form::radio('vigente', 1, true, ['class' => 'custom-control-input', 'id' => 'activo']) !!}
        <label class="custom-control-label" for="activo">Activo</label>
    </div>
    <div class="custom-control custom-radio mt-2">
        {!! Form::radio('vigente', 0, null, ['class' => 'custom-control-input', 'id' => 'no-activo']) !!}
        <label class="custom-control-label" for="no-activo">No Activo</label>
    </div>
    @error('vigente')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var numerodocInput = document.getElementById('numeroDoc');
        var documentoSelect = document.getElementById('documento_id');

        // Función para desactivar el input numerodoc
        function desactivarNumerodoc() {
            numerodocInput.disabled = true;
            numerodocInput.value = ""; // Limpiar el valor del input cuando se desactiva
        }

        // Función para activar el input numerodoc
        function activarNumerodoc(cantidadDigitos) {
            numerodocInput.disabled = false;
            numerodocInput.maxLength = cantidadDigitos;
            numerodocInput.value = ""; // Limpiar el valor del input al cambiar la selección
        }

        // Desactivar el input numerodoc al cargar la página si la opción predeterminada está seleccionada
        if (documentoSelect.value === '') {
            desactivarNumerodoc();
        }

        documentoSelect.addEventListener('change', function() {
            var selectedOption = documentoSelect.options[documentoSelect.selectedIndex];

            // Verificar si la opción seleccionada es la predeterminada o no para activar o desactivar el input numerodoc
            if (selectedOption.value === '') {
                desactivarNumerodoc();
            } else {
                var cantidadDigitos = parseInt(selectedOption.textContent.match(/\d+/)[0]);
                activarNumerodoc(cantidadDigitos);
            }
        });

        // Añadir validación para asegurar que solo se ingresen dígitos
        numerodocInput.addEventListener('input', function() {
            var inputText = numerodocInput.value.trim();
            var numericValue = parseInt(inputText);

            // Permitir la entrada solo si es un dígito y no excede la longitud máxima
            if (!isNaN(numericValue) && inputText.length <= numerodocInput.maxLength) {
                numerodocInput.value = inputText;
            } else {
                // Permitir eliminar caracteres incluso si no es un dígito
                numerodocInput.value = inputText.slice(0, -1);
            }
        });
    });
</script>





@stop
