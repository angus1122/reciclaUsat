@extends('adminlte::page')

@section('title', 'Ocupantes')


@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <h3>Historial de asignaciones de ocupantes activos</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
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
        <div class="card-footer">
            <a href="{{ route('admin.vehicleocuppants.index') }}" class="btn btn-danger float-right"><i
                class="fas fa-chevron-left"></i> Retornar</a>
        </div>
    </div>
@stop


@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                "ajax": "{{ route('admin.ocuppants.index') }}", // La ruta que llama al controlador vía AJAX
                "columns": [
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
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop
