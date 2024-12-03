<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('name', 'Día') !!}
        {!! Form::select(
            'name',
            [
                'Lunes' => 'Lunes',
                'Martes' => 'Martes',
                'Miércoles' => 'Miércoles',
                'Jueves' => 'Jueves',
                'Viernes' => 'Viernes',
                'Sábado' => 'Sábado',
            ],
            null,
            [
                'class' => 'form-control',
                'required',
                'id' => 'name',
                'placeholder' => 'Seleccione un día',
            ],
        ) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('maintenancetype_id', 'Tipo de mantenimiento') !!}
        {!! Form::select('maintenancetype_id', $maintenancetype_id, null, [
            'class' => 'form-control',
            'id' => 'maintenancetype_id',
            'required',
        ]) !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('time_start', 'Hora de Inicio') !!}
        {!! Form::time('time_start', null, [
            'class' => 'form-control',
            'placeholder' => 'Hora de inicio',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('time_end', 'Hora Final') !!}
        {!! Form::time('time_end', null, [
            'class' => 'form-control',
            'placeholder' => 'Hora final',
            'required',
        ]) !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('vehicle_id', 'Vehículo') !!}
        {!! Form::select('vehicle_id', $vehicle_id, null, [
            'class' => 'form-control',
            'id' => 'vehicle_id',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('user_id', 'Personal') !!}
        {!! Form::select('user_id', $user_id, null, [
            'class' => 'form-control',
            'id' => 'user_id',
        ]) !!}
    </div>
</div>
<script>
    // Cuando cambia el vehículo
    $("#vehicle_id").change(function() {
        var vehicle_id = $(this).val();

        if (vehicle_id) {
            $.ajax({
                url: "{{ route('admin.ocuppantsbyvehicle', '_id') }}".replace('_id', vehicle_id),
                type: "GET",
                datatype: "JSON",
                contentType: "application/json",
                success: function(response) {
                    $("#user_id").empty();
                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            $("#user_id").append("<option value='" + value.id + "'>" + value
                                .name + "</option>");
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al cargar ocupantes:', xhr.responseText);
                }
            });
        } else {
            $("#user_id").empty();
            $("#user_id").append("<option value=''>Seleccione un vehículo</option>");
        }
    });

    $(document).ready(function() {
        var vehicle_id = $("#vehicle_id").val();

        if (vehicle_id) {
            $("#vehicle_id").trigger("change");
        }
    });
</script>
