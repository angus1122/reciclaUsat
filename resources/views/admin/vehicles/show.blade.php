@extends('adminlte::page')

@section('title', 'Asignacion de personas')


@section('content')
    <div class="p-3"></div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-success float-right" id="btnNuevo" data-id={{ $vehicle->id }}><i class="fas fa-plus"></i>
                Agregar</button>
            <h3>Ocupantes de Vehículo</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <p for=""><strong>Nombre del vehículo:</strong> {{ $vehicle->name }} </p>
                            <p for=""><strong>Placa:</strong> {{ $vehicle->plate }} </p>
                            <p for=""><strong>Marca:</strong> {{ $vehicle->brand }} </p>
                            <p for=""><strong>Modelo:</strong> {{ $vehicle->model }} </p>
                            <p for=""><strong>Tipo:</strong> {{ $vehicle->vtype }} </p>
                            <p for=""><strong>Capacidad de carga:</strong> {{ $vehicle->load_capacity }} </p>
                            <p for=""><strong>Máximo de ocupantes:</strong> {{ $vehicle->occupant_capacity }} </p>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>TIPO</th>
                                        <th>FECHA ASIGNADA</th>
                                        <th>DAR DE BAJA</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-danger float-right"><i
                    class="fas fa-chevron-left"></i> Retornar</a>
        </div>
    </div>

    <div class="card-footer"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar ocupante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css">  --}}
@stop

@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                "ajax": "{{ route('admin.vehicles.show', $vehicle->id) }}", // La ruta que llama al controlador vía AJAX
                "columns": [{
                        "data": "usernames",
                    },
                    {
                        "data": "usertype",
                    },
                    {
                        "data": "date",
                    },
                    {
                        "data": "actions",
                        "orderable": false,
                        "searchable": false,
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });

        $(document).on("click", "#btnNuevo", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                url: "{{ route('admin.vehicleocuppants.edit', '_id') }}".replace("_id", id),
                type: "GET",
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Agregar ocupante");
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");

                    $("#formModal form").on("submit", function(e) {
                        e.preventDefault();

                        let form = $(this);
                        let formData = new FormData(this);

                        $.ajax({
                            url: form.attr("action"),
                            type: form.attr("method"),
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $("#formModal").modal("hide");
                                refreshTable();
                                Swal.fire("Proceso exitoso", response.message, "success");
                            },
                            error: function(xhr) {
                                let response = xhr.responseJSON;

                                // Manejar el caso de reasignación con estado "warning"
                                if (xhr.status === 400 && response.status ==="warning") {
                                    Swal.fire({
                                        title: "Asignación Activa",
                                        text: response.message,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        cancelButtonColor: "#d33",
                                        confirmButtonText: "Sí, Actualizar",
                                        cancelButtonText: "Cancelar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Confirmar reasignación
                                            $.ajax({
                                                url: "{{ route('admin.vehicleocuppants.confirm') }}",
                                                type: "POST",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    user_id: response.user_id,
                                                    vehicle_id: response.vehicle_id,
                                                    usertype_id: response.usertype_id
                                                },
                                                success: function(response)
                                                {
                                                    refreshTable();
                                                    Swal.fire('Asignado!', response.message, 'success');
                                                    $("#formModal").modal("hide");
                                                },
                                                error: function(xhr) {
                                                    var response = xhr.responseJSON;
                                                    Swal.fire('Error', response.message, 'error');
                                                    $("#formModal").modal("hide");
                                                }
                                            });
                                        }
                                    });
                                } else {
                                    Swal.fire('Error', response.message, 'error');
                                    $("#formModal").modal("hide");
                                }
                            }
                        });
                    });
                },
            });
        });

        $(document).on('submit', '.frmBaja', function(e) {
            e.preventDefault();
            var form = $(this);
            Swal.fire({
                title: "Está seguro de dar de baja?",
                text: "Está acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, dar de baja!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            refreshTable();
                            Swal.fire('Proceso existoso', response.message, 'success');
                        },
                        error: function(xhr) {
                            var response = xhr.responseJSON;
                            Swal.fire('Error', response.message, 'error');
                        }
                    });
                }
            });
        });

        function refreshTable() {
            var table = $('#datatable').DataTable();
            table.ajax.reload(null, false); // Recargar datos sin perder la paginación
        }
    </script>
@stop
