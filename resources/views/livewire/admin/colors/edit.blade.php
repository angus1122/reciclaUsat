<div>

    {!! Form::model($colors, ['route' => ['admin.colors.update', $colors], 'method' => 'put', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        <input wire:model="name" type="text" name="name" id="name" class="form-control">
    </div>

    <div class="form-group">
        {!! Form::label('color_code', 'Color') !!}
        <input wire:model.live="colorEdit"
            value="{{ $colorEdit }}" type="color" name="color_code"
            id="color_code" class="form-control">
    </div>

    <div class="form-group">
        {!! Form::label('hex_code', 'Código Hexadecimal') !!}
        <input type="text" name="hex_code" id="hex_code" class="form-control" readonly
            value="{{ $colorEdit }}">
    </div>

    <button type="submit" class="btn btn-success"><i class="fas fa-save"> Actualizar</i></button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i>
        Cancelar</button>
    {!! Form::close() !!}

</div>