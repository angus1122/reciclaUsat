{!! Form::open(['route'=>'admin.schedulesdates.store', 'files' => true]) !!}

<p>Horario ID: {{ $schedule_id }}</p>
{!! Form::hidden('schedule_id', $schedule_id) !!}

<p>Mantenimiento ID: {{ $maintenance_id }}</p>
{!! Form::hidden('maintenance_id', $maintenance_id) !!}

@include('admin.schedulesdates.template.form')

<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Registrar</button>
<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Cerrar</button>
{!! Form::close() !!}