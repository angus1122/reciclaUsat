@extends('adminlte::page')

@section('title', 'ReciclaUSAT')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-success float-right" id="btnNuevo"><i class="fas fa-plus"></i> Nueva Programación</button>
            <button class="btn btn-primary float-right mr-2 d-none" id="btnBulkEdit"><i class="fas fa-edit"></i> Editar Seleccionados</button>
            <h3>Programación de Rutas</h3>
        </div>
        <!-- Formulario de búsqueda actualizado -->
        <div class="card-body border-bottom">
            <form id="searchForm" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search_type">Búsqueda por:</label>
                        {!! Form::select('search_type', [
                            'vehicle' => 'Vehículo',
                            'route' => 'Ruta'
                        ], null, ['class' => 'form-control select2', 'id' => 'search_type', 'placeholder' => 'Seleccione tipo de búsqueda']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search_value">Seleccione:</label>
                        {!! Form::select('search_value', [], null, ['class' => 'form-control select2', 'id' => 'search_value', 'placeholder' => 'Primero seleccione tipo de búsqueda']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="search_date_start">Fecha Inicio</label>
                        <input type="date" class="form-control" id="search_date_start" name="search_date_start">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="search_date_end">Fecha Fin</label>
                        <input type="date" class="form-control" id="search_date_end" name="search_date_end">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-primary btn-block" id="btnSearch">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>ID</th>
                        <th>VEHÍCULO</th>
                        <th>RUTA</th>
                        <th>FECHA</th>
                        <th>HORA INICIO</th>
                        <th>HORA FIN</th>
                        <th>ESTADO</th>
                        <th width="10"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para edición individual -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario de Programación</h5>
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

    <!-- Modal para edición masiva -->
    <div class="modal fade" id="bulkEditModal" tabindex="-1" role="dialog" aria-labelledby="bulkEditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkEditModalLabel">Edición Masiva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'admin.schedulesdetails.bulkUpdate', 'method' => 'PUT', 'id' => 'bulkEditForm']) !!}
                    <input type="hidden" name="selected_ids" id="selectedIds">
                    
                    <div class="form-group">
                        {!! Form::label('vehicle_id', 'Vehículo') !!}
                        {!! Form::select('vehicle_id', $vehicles, null, ['class' => 'form-control', 'placeholder' => 'Sin cambios']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('start_time', 'Hora de Inicio') !!}
                        {!! Form::time('start_time', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('end_time', 'Hora de Fin') !!}
                        {!! Form::time('end_time', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('status', 'Estado') !!}
                        {!! Form::select('status', ['active' => 'Activo', 'inactive' => 'Inactivo'], null, ['class' => 'form-control', 'placeholder' => 'Sin cambios']) !!}
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Seleccionados</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar Select2
            $('.select2').select2({
                width: '100%'
            });

            // Manejar cambio en el tipo de búsqueda
            $('#search_type').change(function() {
                var searchType = $(this).val();
                var $searchValue = $('#search_value');
                
                // Limpiar el select de valor
                $searchValue.empty().append('<option value="">Seleccione una opción</option>');
                
                if (searchType === 'vehicle') {
                    // Cargar vehículos
                    var vehicles = {!! json_encode($vehicles) !!};
                    $.each(vehicles, function(value, text) {
                        $searchValue.append(new Option(text, value));
                    });
                } else if (searchType === 'route') {
                    // Cargar rutas
                    var routes = {!! json_encode($routes) !!};
                    $.each(routes, function(value, text) {
                        $searchValue.append(new Option(text, value));
                    });
                }
                
                // Refrescar Select2
                $searchValue.trigger('change');
            });

            // Inicializar DataTable
            var table = $('#datatable').DataTable({
                "ajax": {
                    "url": "{{ route('admin.schedulesdetails.index') }}",
                    "data": function(d) {
                        var searchType = $('#search_type').val();
                        var searchValue = $('#search_value').val();
                        
                        // Limpiar búsquedas anteriores
                        delete d.vehicle_id;
                        delete d.route_id;
                        
                        // Asignar valor según el tipo de búsqueda
                        if (searchType === 'vehicle') {
                            d.vehicle_id = searchValue;
                        } else if (searchType === 'route') {
                            d.route_id = searchValue;
                        }
                        
                        d.date_start = $('#search_date_start').val();
                        d.date_end = $('#search_date_end').val();
                    }
                },
                // ... resto de la configuración del DataTable permanece igual ...
                "columns": [
                    {
                        "data": null,
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row) {
                            return '<input type="checkbox" class="schedule-checkbox" value="' + row.id + '">';
                        }
                    },
                    {"data": "id"},
                    {"data": "vehicle"},
                    {"data": "route"},
                    {"data": "programming_date"},
                    {"data": "start_time"},
                    {"data": "end_time"},
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            return data === 'active' 
                                ? '<span class="badge badge-success">Activo</span>' 
                                : '<span class="badge badge-danger">Inactivo</span>';
                        }
                    },
                    {"data": "actions"}
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "order": [[1, 'desc']]
            });

            // Manejo de checkboxes
        $('#selectAll').change(function() {
            $('.schedule-checkbox').prop('checked', $(this).prop('checked'));
            updateBulkEditButton();
        });

        $(document).on('change', '.schedule-checkbox', function() {
            updateBulkEditButton();
        });

        function updateBulkEditButton() {
            var checkedCount = $('.schedule-checkbox:checked').length;
            $('#btnBulkEdit').toggleClass('d-none', checkedCount === 0);
        }

        // Eventos de búsqueda
        $('#btnSearch').click(function() {
            table.ajax.reload();
        });

        // Manejo de edición masiva
        $('#btnBulkEdit').click(function() {
            var selectedIds = $('.schedule-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            $('#selectedIds').val(JSON.stringify(selectedIds));
            $('#bulkEditModal').modal('show');
        });

        

// Reemplaza el evento submit del bulkEditForm con este código
$('#bulkEditForm').on('submit', function(e) {
    e.preventDefault();
    
    // Obtener los datos del formulario
    var formData = new FormData(this);
    
    // Agregar el token CSRF
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');

    $.ajax({
        //url: $(this).attr('action'),
        url: this.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#bulkEditModal').modal('hide');
            table.ajax.reload();
            Swal.fire({
                title: 'Éxito',
                text: response.message,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
            
            // Limpiar checkboxes y formulario
            $('.schedule-checkbox').prop('checked', false);
            $('#selectAll').prop('checked', false);
            $('#bulkEditForm')[0].reset();
            updateBulkEditButton();
        },
        error: function(xhr) {
            let errorMessage = 'Ocurrió un error al procesar la solicitud';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            Swal.fire({
                title: 'Error',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });
});





        // Manejo de edición individual
        $(document).on('click', '.btnEditar', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('admin.schedulesdetails.edit', 'id') }}".replace('id', id),
                type: "GET",
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Modificar Programación");
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");
                }
            });
        });
        
        $(document).on('submit', '.frmEliminar', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var form = $(this);
            var url = form.attr('action');
            
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    table.ajax.reload();
                    Swal.fire(
                        'Eliminado',
                        response.message,
                        'success'
                    );
                },
                error: function(xhr) {
                    let errorMessage = 'Error al eliminar el registro';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire(
                        'Error',
                        errorMessage,
                        'error'
                    );
                }
            });
        }
    });
});

        $(document).on('submit', '#formModal form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#formModal").modal("hide");
                    table.ajax.reload();
                    Swal.fire('Proceso exitoso', response.message, 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.message, 'error');
                }
            });
        });

        // Manejo de nuevo registro
        $('#btnNuevo').click(function() {
            $.ajax({
                url: "{{ route('admin.schedulesdetails.create') }}",
                type: "GET",
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Nuevo Horario");
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");
                }
            });
        });
        });
    </script>
@endsection