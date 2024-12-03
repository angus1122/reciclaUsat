{!! Form::model($route, ['route' => ['admin.routes.update', $route->id], 'method' => 'put']) !!}

<div class="form-row">
    <div class="form-group col-8">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, [
            'class' => 'form-control',
            'placeholder' => 'Ingrese el nombre de la ruta',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-4">
        {!! Form::label('status', 'Seleccione el estado') !!}
        <div class="form-check">
            {!! Form::checkbox('status', 1, null, [
                'class' => 'form-check-input',
                'id' => 'status',
            ]) !!}
            {!! Form::label('status', 'Activo', [
                'class' => 'form-check-label',
            ]) !!}
        </div>
    </div>
</div>

<div id="map-route" style="height: 400px; width:100%; border: 1px solid black;"></div>

{!! Form::hidden('latitud_start', null, ['id' => 'latitude-start']) !!}
{!! Form::hidden('longitude_start', null, ['id' => 'longitude-start']) !!}
{!! Form::hidden('latitude_end', null, ['id' => 'latitude-final']) !!}
{!! Form::hidden('longitude_end', null, ['id' => 'longitude-final']) !!}

<div class="modal-footer">
    <button type="submit" class="btn btn-success"><i class="fas fa-pen-square"></i> Actualizar</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Cerrar</button>
</div>

{!! Form::close() !!}

<script>
    // El mismo script de inicialización del mapa que tienes en form.blade.php
    function initMap() {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = {{ $route->latitud_start ?? 'position.coords.latitude' }};
            var lng = {{ $route->longitude_start ?? 'position.coords.longitude' }};

            var mapOptions = {
                center: { lat: lat, lng: lng },
                zoom: 15
            };

            // ... resto del código del mapa ...
        });
    }

    $('#formModal').on('shown.bs.modal', function() {
        initMap();
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>