@extends('adminlte::page')

@section('title', 'Ocupantes')


@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            {{-- <button class="btn btn-success float-right" id="btnNuevo"><i class="fas fa-eye"></i> Ver Activos</button> --}}
            <h3>Ocupantes asignados</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>OCUPANTE</th>
                        <th>TIPO DE OCUPANTE</th>
                        <th>ESTADO DE OCUPANTE</th>
                        <th>VEHICULO</th>
                        <th>FECHA ASIGNADA</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@stop


@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                "ajax": "{{ route('admin.vehicleocuppants.index') }}", // La ruta que llama al controlador vía AJAX
                "columns": [{
                        "data": "id",
                    },
                    {
                        "data": "uname",
                    },
                    {
                        "data": "utname",
                    },
                    {
                        "data": "status",
                    },
                    {
                        "data": "vname",
                    },
                    {
                        "data": "created_at",
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });

        $('#btnNuevo').click(function() {
            var url = window.location.href = "{{ route('admin.ocuppants.index') }}";

            $.ajax({
                url: url,
                success: function(response) {
                    console.log("Exitoso");
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Hubo un problema al procesar la solicitud.', 'error');
                }
            });
        });
    </script>
@stop
