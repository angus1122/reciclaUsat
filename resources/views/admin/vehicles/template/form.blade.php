<div class="form-row">
    <div class="form-group col-3">
        {!! Form::label('code', 'Código') !!}
        {!! Form::text('code', null, [
            'class' => 'form-control',
            'placeholder' => 'Código',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-9">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, [
            'class' => 'form-control',
            'placeholder' => 'Nombre del vehículo',
            'required',
        ]) !!}
    </div>

</div>
<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('brand_id', 'Marca') !!}
        {!! Form::select('brand_id', $brands, null, [
            'class' => 'form-control',
            'id' => 'brand_id',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('model_id', 'Modelo') !!}
        {!! Form::select('model_id', $models, null, [
            'class' => 'form-control',
            'id' => 'model_id',
            'required',
        ]) !!}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('type_id', 'Tipo') !!}
        {!! Form::select('type_id', $types, null, [
            'class' => 'form-control',
            'id' => 'type_id',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('color_id', 'Color') !!}
        <div class="d-flex align-items-center">
            {!! Form::select('color_id', $colors, null, [
                'class' => 'form-control mr-2',
                'id' => 'color_id',
                'style' => 'width: 80%;',
                'required',
            ]) !!}
            <input wire:model.live="color_code" type="color" name="color_code" id="color_code" class="form-control"
                style="width: 20%; height: 38px;">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('plate', 'Placa') !!}
        {!! Form::text('plate', null, [
            'class' => 'form-control',
            'placeholder' => 'Placa del vehículo',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('year', 'Año') !!}
        {!! Form::number('year', null, [
            'class' => 'form-control',
            'placeholder' => 'Año del vehículo',
            'required',
        ]) !!}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('occupant_capacity', 'Capacidad de ocupantes') !!}
        {!! Form::number('occupant_capacity', null, [
            'class' => 'form-control',
            'placeholder' => 'Capacidad de ocupantes del vehículo',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('load_capacity', 'Capacidad de carga (TN)') !!}
        {!! Form::number('load_capacity', null, [
            'class' => 'form-control',
            'placeholder' => 'Capacidad de carga del vehículo',
            'required',
        ]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del vehículo',
        'rows' => 5,
    ]) !!}
</div>
<div class="form-check">

    {!! Form::checkbox('status', 1, null, [
        'class' => 'form-check-input',
    ]) !!}
    {!! Form::label('status', 'Activo') !!}
</div>
<div class="form-row">
    <div class="form-group col-3">
        {!! Form::file('image', [
            'class' => 'form-control-file d-none', // Oculta el input
            'accept' => 'image/*',
            'id' => 'imageInput',
        ]) !!}
        <button type="button" class="btn btn-primary" id="imageButton"><i class="fas fa-image"></i> Seleccionar
            Imagen</button>

    </div>
    <div class="form-group col-9">
        <img id="imagePreview" src="#" alt="Vista previa de la imagen"
            style="max-width: 100%; height: auto; display: none;">
    </div>
</div>

<script>
    $("#brand_id").change(function() {
        var id = $(this).val();

        $.ajax({
            url: "{{ route('admin.modelsbybrand', '_id') }}".replace('_id', id),
            type: "GET",
            datatype: "JSON",
            contentype: "application/json",
            success: function(response) {
                $("#model_id").empty();
                $.each(response, function(key, value) {
                    $("#model_id").append("<option value=" + value.id + ">" + value.name +
                        "</option>");
                });
                console.log(response);

            }
        });
    });

    $('#imageInput').change(function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    $('#imageButton').click(function() {
        $('#imageInput').click();
    });
</script>
