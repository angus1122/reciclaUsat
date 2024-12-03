@extends('adminlte::page')

@section('title', 'Asignacion de horarios')


@section('content')
    <div class="p-3"></div>
    <div class="card">
        <div class="card-header">
            <div class="">
                <button class="btn btn-success float-right" id="btnNuevo" data-maintenance-id={{ $maintenance->id }}><i
                        class="fas fa-plus"></i>
                    Agregar</button>
                <h3>Horario de Mantenimiento</h3>
            </div>
            <div class="">
                <p for=""><strong>Nombre:</strong> {{ $maintenance->name }} </p>
                <p for=""><strong>Fecha de incio:</strong> {{ $maintenance->startdate }} </p>
                <p for=""><strong>Fecha final:</strong> {{ $maintenance->lastdate }} </p>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>DIA</th>
                        <th>VEHICULO</th>
                        <th>CONDUCTOR</th>
                        <th>TIPO</th>
                        <th>INICIO</th>
                        <th>FIN</th>
                        <th width="25">ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.maintenances.index') }}" class="btn btn-danger float-right"><i
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
                    <h5 class="modal-title" id="exampleModalLabel">Asignar horario</h5>
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
                "ajax": "{{ route('admin.maintenances.show', $maintenance->id) }}", // La ruta que llama al controlador vía AJAX
                "columns": [{
                        "data": "name",
                    },
                    {
                        "data": "vehiclenames",
                    },
                    {
                        "data": "usernames",
                    },
                    {
                        "data": "maintenancetypes",
                    },
                    {
                        "data": "time_start",
                    },
                    {
                        "data": "time_end",
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
            // Obtener el ID de mantenimiento desde un atributo o variable
            const maintenanceId = $(this).data('maintenance-id'); // Asumimos que está en data-attribute

            $.ajax({
                url: "{{ route('admin.maintenanceschedules.create') }}",
                type: "GET",
                data: { maintenance_id: maintenanceId }, // Pasar el ID de mantenimiento
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Nuevo Horario");
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");

                    $("#formModal form").on("submit", function(e) {
                        e.preventDefault();

                        var form = $(this);
                        var formData = new FormData(this);

                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $("#formModal").modal("hide");
                                refreshTable();
                                Swal.fire('Proceso existoso', response.message,
                                    'success');
                            },
                            error: function(xhr) {
                                var response = xhr.responseJSON;
                                Swal.fire('Error', response.message, 'error');
                            }
                        })

                    })

                }
            });
        });

        $(document).on('click', '.btnEditar', function() {
            var id = $(this).attr("id");

            $.ajax({
                url: "{{ route('admin.maintenanceschedules.edit', 'id') }}".replace('id', id),
                type: "GET",
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Modificar Horario");
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");
                    $("#formModal form").on("submit", function(e) {
                        e.preventDefault();

                        var form = $(this);
                        var formData = new FormData(this);

                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $("#formModal").modal("hide");
                                refreshTable();
                                Swal.fire('Proceso existoso', response.message,
                                    'success');
                            },
                            error: function(xhr) {
                                var response = xhr.responseJSON;
                                Swal.fire('Error', response.message, 'error');
                            }
                        })

                    })
                }
            });
        })

        $(document).on('submit', '.frmEliminar', function(e) {
            e.preventDefault();
            var form = $(this);
            Swal.fire({
                title: "Está seguro de eliminar?",
                text: "Está acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
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

        $(document).on('click', '.btnDates', function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            
            if (!id) {
                Swal.fire('Error', 'No se pudo obtener el ID del horario.', 'error');
                return;
            }
            var url = "{{ route('admin.maintenanceschedules.show', 'id') }}".replace('id', id);

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    window.location.href = url;
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    Swal.fire('Error', response.message, 'error');
                }
            });
        });
        
        function refreshTable() {
            var table = $('#datatable').DataTable();
            table.ajax.reload(null, false); // Recargar datos sin perder la paginación
        }
    </script>
@stop
