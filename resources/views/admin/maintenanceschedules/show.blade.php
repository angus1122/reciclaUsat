@extends('adminlte::page')

@section('title', 'Asignacion de Fechas')


@section('content')
    <div class="p-3"></div>
    <div class="card">
        <div class="card-header">
            <div class="">
                <button class="btn btn-success float-right" id="btnNuevo" data-schedule-id={{ $schedule->id }}><i
                        class="fas fa-plus"></i>
                    Agregar</button>
                <h3>Fecha de los horario de Mantenimiento</h3>
            </div>
            <div class="">
                <p for=""><strong>Dia:</strong> {{ $schedule->name }} </p>
                <p for=""><strong>Tipo de mantenimiento:</strong> {{ $schedule->tname }} </p>
                <p for=""><strong>Hora de inicio:</strong> {{ $schedule->time_start }} | <strong>Hora
                        final:</strong> {{ $schedule->time_end }} </p>
                <p for=""><strong>Nombre del mantenimiento:</strong> {{ $schedule->mname }} </p>
                <p for=""><strong>Fecha inicio:</strong> {{ $schedule->startdate }} | <strong>Fecha final:</strong>
                    {{ $schedule->lastdate }}</p>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>FECHA</th>
                        <th>IMAGEN</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ESTADO</th>
                        <th width="10"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.maintenances.show', $schedule->maintenance_id) }}" class="btn btn-danger float-right"><i
                class="fas fa-chevron-left"></i> Retornar</a>
    </div>
    </div>

    <div class="card-footer"></div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar fechas</h5>
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
                "ajax": "{{ route('admin.maintenanceschedules.show', $schedule->id) }}", // La ruta que llama al controlador vía AJAX
                "columns": [
                    {
                        "data": "date",
                    },
                    {
                        "data": "logo",
                        "orderable": false,
                        "searchable": false,
                    },
                    {
                        "data": "description",
                    },
                    {
                        "data": "status",
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
            const scheduleId = $(this).data('schedule-id'); // Asumimos que está en data-attribute

            $.ajax({
                url: "{{ route('admin.schedulesdates.create') }}",
                type: "GET",
                data: {
                    schedule_id: scheduleId
                }, // Pasar el ID de mantenimiento
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Nueva Fecha");
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

        $(document).on('submit', '.frmBaja', function(e) {
            e.preventDefault();
            var form = $(this);
            Swal.fire({
                title: "Está seguro de finalizar mantenimiento?",
                text: "Está acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, finalizar!"
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
