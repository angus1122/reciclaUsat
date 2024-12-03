@extends('adminlte::page')

@section('title', 'Rutas')

@section('content')
<div class="p-2"></div>
<div class="card">
<div class="card-header">
<!--<a href="{{ route('admin.routes.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i> Registrar</a>-->
<button class="btn btn-success float-right" id="btnNuevo"><i class="fas fa-plus-circle"></i> Registrar</button>
<h4>Listado de rutas</h4>
</div>
<div class="card-body">
<table class="table" id="datatable">
<thead>
<tr>
<th>ID</th>
{{-- <th>ZONA</th> --}}
<th>RUTA</th>
<th>ESTADO</th>
<th width=60></th>
<th width=20></th>
<th width=20></th>
</tr>


            </thead>
            <tbody>
                @foreach ($routes as $route)
                    <tr>
                        <td>{{ $route->id }}</td>
                        {{-- <td>{{ $route->zname }}</td> --}}
                        <td>{{ $route->name }}</td>
                        <td>{{ $route->status }}</td>
                        <td>
                            <a href="{{ route('admin.routes.show', $route->id) }}" class="btn btn-secondary btn-sm"><i
                                    class="fas fa-map"></i></a>
                            {{-- https://www.google.com/maps/dir/-6.7743625,-79.8292322/from-6.7702782,-79.7848875 --}}
                            <?php
                            $r = 'https://www.google.com/maps/dir/' . $route->latitud_start . ',' . $route->longitude_start . '/' . $route->latitude_end . ',' . $route->longitude_end;
                            ?>
                            <a href="<?php echo $r; ?>" target="_blank" class="btn btn-secondary btn-sm"><i
                                    class="fas fa-eye"></i></a>
                        </td>
                        <td><!--<a href="{{ route('admin.routes.edit', $route->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>-->
                            <button class="btnEditar btn btn-primary btn-sm" id={{ $route->id }}><i
                                    class="fa fa-edit"></i></button>
                        </td>
                        <td>
                            <form action="{{ route('admin.routes.destroy', $route->id) }}" method="POST"
                                class="fmrEliminar">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        </form>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="card-footer">

    </div>
</div>

<div class="card">
    <div class="card-header">
        Rutas
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de rutas</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $('#datatable').DataTable({


        

    "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    }
    });


    $('#btnNuevo').click(function() {
        $.ajax({
            url: "{{ route('admin.routes.create') }}",
            type: "GET",
            success: function(response) {
                $('#formModal .modal-body').html(response);
                $('#formModal').modal('show');
            }
        })

    })
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
                /*Swal.fire({
                title: "Marca eliminada!",
                text: "Porceso exitoso.",
                icon: "Satisfactorio"
                });*/
            }
        });
    });

    var perimeters = @json($perimeter);
    var routes = @json($routesWithCoords);

    console.log(perimeters);
    console.log(routes);

    function initMap() {
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

            // Dibujar las rutas
            routes.forEach(function(route, index) {
                var routeCoords = [
                    route.start,
                    route.end
                ];
                var color = '#FF0000'; // Color rojo para las rutas

                var routePath = new google.maps.Polyline({
                    path: routeCoords,
                    geodesic: true,
                    strokeColor: color,
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                    map: map
                });
            });
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