<div class="modal-body">
    {!! Form::open(['route' => 'admin.routes.store', 'method' => 'POST']) !!}

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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Registrar</button>
        
    </div>

    {!! Form::close() !!}
</div>

<script>
    function initMap() {
        // Obtener la geolocalización del usuario
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            var mapOptions = {
                center: {
                    lat: lat,
                    lng: lng
                },
                zoom: 15
            };

            var map = new google.maps.Map(document.getElementById('map-route'), mapOptions);
            var markers = [];
            var polyline = new google.maps.Polyline({
                path: [],
                strokeColor: 'red',
                strokeWeight: 4,
                map: map
            });

            // Colores para los perímetros
            var colors = ['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF'];

            // Dibujar los perímetros registrados
            var perimeters = @json($perimeter);
            perimeters.forEach(function(perimeter, index) {
                var perimeterCoords = perimeter.coords;
                var color = colors[index % colors.length]; // Obtiene un color de la matriz de colores

                // Crea un objeto de polígono con los puntos del perímetro
                var perimeterPolygon = new google.maps.Polygon({
                    paths: perimeterCoords,
                    strokeColor: color,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.35,
                    map: map // Asigna el mapa al polígono para mostrarlo
                });

                // Manejar clics en el perímetro para añadir marcadores
                google.maps.event.addListener(perimeterPolygon, 'click', function(event) {
                    handleMapClick(event.latLng);
                });
            });

            // Añadir los marcadores si las coordenadas están presentes
            var latStart = parseFloat(document.getElementById('latitude-start').value);
            var lngStart = parseFloat(document.getElementById('longitude-start').value);
            var latEnd = parseFloat(document.getElementById('latitude-final').value);
            var lngEnd = parseFloat(document.getElementById('longitude-final').value);

            if (!isNaN(latStart) && !isNaN(lngStart) && !isNaN(latEnd) && !isNaN(lngEnd)) {
                var startPosition = new google.maps.LatLng(latStart, lngStart);
                var endPosition = new google.maps.LatLng(latEnd, lngEnd);

                var startMarker = new google.maps.Marker({
                    position: startPosition,
                    map: map,
                    draggable: true
                });

                var endMarker = new google.maps.Marker({
                    position: endPosition,
                    map: map,
                    draggable: true
                });

                markers.push(startMarker, endMarker);

                var path = [startPosition, endPosition];
                polyline.setPath(path);

                // Actualizar los campos ocultos cuando los marcadores se muevan
                google.maps.event.addListener(startMarker, 'dragend', function(event) {
                    document.getElementById('latitude-start').value = event.latLng.lat();
                    document.getElementById('longitude-start').value = event.latLng.lng();
                    polyline.setPath([event.latLng, endMarker.getPosition()]);
                });

                google.maps.event.addListener(endMarker, 'dragend', function(event) {
                    document.getElementById('latitude-final').value = event.latLng.lat();
                    document.getElementById('longitude-final').value = event.latLng.lng();
                    polyline.setPath([startMarker.getPosition(), event.latLng]);
                });

                map.panTo(startPosition);
            }

            // Manejar clics en el mapa para añadir marcadores
            google.maps.event.addListener(map, 'click', function(event) {
                handleMapClick(event.latLng);
            });

            function handleMapClick(latLng) {
                if (markers.length >= 2) {
                    markers.forEach(marker => marker.setMap(null));
                    markers = [];
                    polyline.setPath([]); // Limpiar la polilínea previa
                }

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    draggable: true
                });

                markers.push(marker);

                if (markers.length === 2) {
                    var path = [markers[0].getPosition(), markers[1].getPosition()];
                    polyline.setPath(path);

                    document.getElementById('latitude-start').value = path[0].lat();
                    document.getElementById('longitude-start').value = path[0].lng();
                    document.getElementById('latitude-final').value = path[1].lat();
                    document.getElementById('longitude-final').value = path[1].lng();

                    // Añadir listeners para los nuevos marcadores
                    google.maps.event.addListener(markers[0], 'dragend', function(event) {
                        document.getElementById('latitude-start').value = event.latLng.lat();
                        document.getElementById('longitude-start').value = event.latLng.lng();
                        polyline.setPath([event.latLng, markers[1].getPosition()]);
                    });

                    google.maps.event.addListener(markers[1], 'dragend', function(event) {
                        document.getElementById('latitude-final').value = event.latLng.lat();
                        document.getElementById('longitude-final').value = event.latLng.lng();
                        polyline.setPath([markers[0].getPosition(), event.latLng]);
                    });
                }
            }
        }, function(error) {
            console.log("Error al obtener la geolocalización: " + error.message);
        });
    }

    $('#formModal').on('shown.bs.modal', function() {
        // Solo inicializar el mapa cuando el modal se muestra
        initMap();
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
</script>
