{!! Form::open(['route'=>'admin.maintenanceschedules.store']) !!}

<p>Mantenimiento ID: {{ $maintenance_id }}</p>
{!! Form::hidden('maintenance_id', $maintenance_id) !!}

@include('admin.maintenanceschedules.template.form')

<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Registrar</button>
<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Cerrar</button>
{!! Form::close() !!}