<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, 
    ['class'=>'form-control', 
    'placeholder'=>'Ingrese el nombre del color',
    'required',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('color_code', 'Color') !!}
    <input type="color" name="color_code" id="color_code" class="form-control">
</div>

<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, 
    ['class'=>'form-control', 
    'style' =>'height:100px',
    'placeholder'=>'Ingrese la descripción del color',
    ]) !!}
</div>
