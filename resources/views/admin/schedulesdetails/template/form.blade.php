<div class="form-group">
    {!! Form::label('vehicle_id', 'Vehículo') !!}
    {!! Form::select('vehicle_id', $vehicles, null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('route_id', 'Ruta') !!}
    {!! Form::select('route_id', $routes, null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('start_date', 'Fecha de Inicio') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('end_date', 'Fecha de Fin') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('start_time', 'Hora de Inicio') !!}
    {!! Form::time('start_time', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('end_time', 'Hora de Fin') !!}
    {!! Form::time('end_time', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-check mb-3">
    {!! Form::checkbox('skip_weekends', 1, null, ['class' => 'form-check-input', 'id' => 'skip_weekends']) !!}
    {!! Form::label('skip_weekends', 'Omitir fines de semana', ['class' => 'form-check-label']) !!}
</div>

<div class="form-check mb-3">
    {!! Form::checkbox('alternate_days', 1, null, ['class' => 'form-check-input', 'id' => 'alternate_days']) !!}
    {!! Form::label('alternate_days', 'Días alternados', ['class' => 'form-check-label']) !!}
</div>