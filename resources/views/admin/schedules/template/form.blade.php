<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'placeholder' => 'Nombre del horario',
        'required']) !!}
</div>

<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('time_start', 'Inicio') !!}
        {!! Form::time('time_start', null, [
            'class' => 'form-control',
            'placeholder' => 'Hora de inicio',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('time_end', 'Fin') !!}
        {!! Form::time('time_end', null, [
            'class' => 'form-control',
            'placeholder' => 'Hora final',
            'required',
        ]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del horario',
    ]) !!}
</div>