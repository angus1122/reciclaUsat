{!! Form::model($scheduleDetail, ['route' => ['admin.schedulesdetails.update', $scheduleDetail], 'method' => 'put']) !!}
<div class="form-group">
    {!! Form::label('vehicle_id', 'Vehículo') !!}
    {!! Form::select('vehicle_id', $vehicles, null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('route_id', 'Ruta') !!}
    {!! Form::select('route_id', $routes, null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('start_time', 'Hora de Inicio') !!}
    {!! Form::time('start_time', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('end_time', 'Hora de Fin') !!}
    {!! Form::time('end_time', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('status', 'Estado') !!}
    {!! Form::select('status', ['active' => 'Activo', 'inactive' => 'Inactivo'], null, ['class' => 'form-control', 'required']) !!}
</div>

<button type="submit" class="btn btn-success"><i class="fas fa-pen-square"></i> Actualizar</button>
<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Cerrar</button>
{!! Form::close() !!}