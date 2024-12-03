<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'placeholder' => 'Nombre del mantenimiento',
        'required']) !!}
</div>

<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('startdate', 'Inicio') !!}
        {!! Form::date('startdate', null, [
            'class' => 'form-control',
            'placeholder' => 'Fecha de inicio',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('lastdate', 'Fin') !!}
        {!! Form::date('lastdate', null, [
            'class' => 'form-control',
            'placeholder' => 'Fecha final',
            'required',
        ]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del mantenimiento',
    ]) !!}
</div>