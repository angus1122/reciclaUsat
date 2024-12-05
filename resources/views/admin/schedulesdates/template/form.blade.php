<div class="form-group">
    {!! Form::label('date', 'Fecha') !!}
    {!! Form::date('date', null, [
        'class' => 'form-control',
        'placeholder' => 'Ingrese la fecha',
        'required',
        'id' => 'date',
        'min' => $startdate->format('Y-m-d'), // Fecha mínima
        'max' => $lastdate->format('Y-m-d'), // Fecha máxima
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción',
    ]) !!}
</div>

<div class="form-row">
    <div class="form-group col-3">
        {!! Form::file('logo', [
            'class' => 'form-control-file d-none', // Oculta el input
            'accept' => 'image/*',
            'id' => 'imageInput',
        ]) !!}
        <button type="button" class="btn btn-primary" id="imageButton"><i class="fas fa-image"></i> Imagen</button>
    </div>
    <div class="form-group col-9">
        <img id="imagePreview" src="#" alt="Vista previa de la imagen"
            style="max-width: 100%; height: auto; display: none;">
    </div>
</div>

<script>
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

    document.addEventListener('DOMContentLoaded', function() {
        const datePicker = document.getElementById('date');
        const allowedDay = {{ $dayNumber ?? 'null' }}; // Día permitido (1 = Lunes, ..., 7 = Domingo)

        if (datePicker && allowedDay) {
            datePicker.addEventListener('input', function() {
                const selectedDate = new Date(this.value);
                const selectedDay = selectedDate.getDay(); // 0 = Domingo, 6 = Sábado

                // Ajustar el día de JavaScript (0 = Domingo, 1 = Lunes, ..., 6 = Sábado)
                const adjustedDay = selectedDay === 0 ? 7 : selectedDay; // Cambiar Domingo (0) por 7

                if (adjustedDay !== allowedDay) {
                    alert(
                        `Solo puedes seleccionar fechas correspondientes al día ${allowedDay} (${['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'][allowedDay - 1]}).`);
                    this.value = ''; // Limpiar el valor inválido
                }
            });
        }
    });
</script>
