@extends('adminlte::page')

@section('title', 'Perímetro de zona')


@section('content')
    <div class="p-3"></div>
    <div class="card">
        <div class="card-header">
            <button class="btnEditar btn btn-success float-right" id={{ $route->id }}><i class="fas fa-plus-circle"></i>
                Agregar Zona a Ruta</button>

            Nombre de la Ruta: {{ $route->name }} <br>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4 card" style="min-height: 50px">
                    <div class="card-body">
                        <label for="">Latitud y Longitud Inicial:</label>
                        {{ $route->latitudestart }} {{ $route->longitudestart }}<br>
                        <label for="">Longitud y longitud Final:</label>
                        {{ $route->latitudefinal }} {{ $route->longitudefinal }}<br>
                    </div>

                </div>
                <div class="col-8 card" style="min-height: 50px">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ZONAS</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routezones as $rz)
                                    <tr>
                                        <td>{{ $rz->id }}</td>
                                        <td>{{ $rz->name }}</td>
                                        <th>
                                            <form action="{{ route('admin.routezones.destroy', $rz->id) }}" method="POST"
                                                class="fmrEliminar">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i></a>
                                            </form>
                                        </th>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>

                </div>
                <div class="row">
                    <div class="card" style="min-height: 50px">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer"></div>
    </div>

    <div class="card">
        <div class="card-header">
            Mapa de la ruta
        </div>
        <div class="card-body">

            <div id="map" style="height:400px">
            </div>
        </div>

        <div class="footer">

        </div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario de Zonas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $('#datatable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });

        $(".btnEditar").click(function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('admin.routes.edit', '_id') }}".replace('_id', id),
                type: "GET",
                success: function(response) {
                    $('#formModal .modal-body').html(response);
                    $('#formModal').modal('show');
                }
            });
        });
        $(".fmrEliminar").submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Seguro de eliminar?",
                text: "Esta accion es irreversible!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        var perimeters = @json($perimeter);
        var route = {
            start: {
                lat: {{ $route->latitudestart }},
                lng: {{ $route->longitudestart }}
            },
            end: {
                lat: {{ $route->latitudefinal }},
                lng: {{ $route->longitudefinal }}
            }
        };

        function initMap() {
            var mapOptions = {
                center: {
                    lat: route.start.lat,
                    lng: route.start.lng
                },
                zoom: 15
            };

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var colors = ['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF'];

            // Dibujar los perímetros
            perimeters.forEach(function(perimeter, index) {
                var perimeterCoords = perimeter.coords;
                var color = colors[index % colors.length];

                var perimeterPolygon = new google.maps.Polygon({
                    paths: perimeterCoords,
                    strokeColor: color,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.35,
                    map: map
                });
            });

            // Dibujar la ruta
            var routeCoords = [route.start, route.end];
            var routePath = new google.maps.Polyline({
                path: routeCoords,
                geodesic: true,
                strokeColor: '#FF0000', // Color rojo para la ruta
                strokeOpacity: 1.0,
                strokeWeight: 2,
                map: map
            });

            // Marcar los puntos de inicio y final de la ruta
            new google.maps.Marker({
                position: route.start,
                map: map,
                title: 'Inicio de la Ruta'
            });

            new google.maps.Marker({
                position: route.end,
                map: map,
                title: 'Final de la Ruta'
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async
        defer></script>



    @if (session('success') !== null)
        <script>
            Swal.fire({
                title: "Proceso Exitoso",
                text: "{{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif

    @if (session('error') !== null)
        <script>
            Swal.fire({
                title: "Error de proceso",
                text: "{{ session('error') }}",
                icon: "error"
            });
        </script>
    @endif
@stop
