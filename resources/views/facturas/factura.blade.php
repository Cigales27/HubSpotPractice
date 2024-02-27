@extends('dashboard.layouts.layout', ['nombre_view' => "Facturas"])
@section('title_page', 'Facturas')
@section('estilos')
    <style>
        .logo-container {
            text-align: -webkit-center;
            text-align: -moz-center;
            text-align: center;
            width: 50%;
        }

        .logo-container img {
            width: 100%;
            max-width: 200px; /* Establece el tamaño máximo del logo */
            height: auto; /* Ajusta automáticamente la altura para mantener la proporción */


        }

        .drag-drop-area {
            border: 2px dashed #c1c1c1;
            text-align: center;
            cursor: pointer;
        }

        #fileInput {
            display: none; /* Ocultar el input de tipo file */
        }
    </style>

@endsection
@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3"><p class="text-primary m-0 fw-bold"></p></div>
            <div class="card-body">
                {{--                Crea una tabla la cual en la parte de arriba tendra un boton de agregar nueva empresa, debajo ya en la tabla, debe tener las columnas id, nombre empresa, sitio web, correo, logo, direccion, creacion, actualizacion y acciones--}}
                <div class="card-header">
                    <h3 class="card-title">Facturas</h3>
                    <div class="card-tools">
                        <a onclick="crear_factura()" class="btn btn-success">Nueva Factura</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="facturas-table" class="table table-bordered table-hover" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Empresa</th>
                                <th>Cliente</th>
                                <th>Nombre Factura</th>
                                <th>Numero Factura</th>
                                <th>Fecha Emision</th>
                                <th>Fecha Vencimiento</th>
                                <th>Comentario</th>
                                <th>Subtotal</th>
                                <th>Impuesto</th>
                                <th>Total</th>
                                <th>Creación</th>
                                <th>Actualización</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{--    Modal de pregunta para eliminar la cliente--}}
    <div class="modal fade" id="modal_eliminar_factura" tabindex="-1" aria-labelledby="modal_eliminar_factura"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar la factura?</p>
                    <input hidden id="id_factura_eliminar">
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" onclick="eliminar_factura_confirmado()">Eliminar</a>
                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            obtener_facturas();
        });
        function obtener_facturas() {
            facturas = [];
            $('#facturas-table').DataTable().destroy();
            $('#facturas-table tbody').empty();
            $.ajax({
                url: '/api/factura/obtener_facturas',
                type: 'get',
                headers: {
                    'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                },
                success: function (data) {
                    if (data.code == 200) {
                        if (data.data.length > 0) {
                            facturas = data.data;
                            data.data.forEach(function (cliente) {
                                $('#facturas-table tbody').append('<tr>' +
                                    '<td>' + cliente.id + '</td>' +
                                    '<td>' + cliente.empresa.nombre_empresa + '</td>' +
                                    '<td>' + cliente.cliente.nombre_cliente + '</td>' +
                                    '<td>' + cliente.nombre_invoice + '</td>' +
                                    '<td>' + cliente.numero_invoice + '</td>' +
                                    '<td>' + cliente.fecha_invoice + '</td>' +
                                    '<td>' + cliente.fecha_vencimiento_invoice + '</td>' +
                                    '<td>' + cliente.comentario_invoice + '</td>' +
                                    '<td>' + cliente.subtotal_invoice + '</td>' +
                                    '<td>' + cliente.impuesto_invoice + '</td>' +
                                    '<td>' + cliente.total_invoice + '</td>' +
                                    '<td>' + cliente.creacion + '</td>' +
                                    '<td>' + cliente.actualizacion + '</td>' +
                                    '<td>' +
                                    '<a class="btn btn-primary" onclick="editar_factura(' + cliente.id + ')"><i class="fas fa-edit"></i></a>' +
                                    '<a class="btn btn-danger" onclick="eliminar_factura(' + cliente.id + ')"><i class="fas fa-trash"></i></a>' +
                                    '</td>' +
                                    '</tr>');
                            });
                            $('#facturas-table').DataTable();
                        } else {
                            $('#facturas-table tbody').append('<tr>' +
                                '<td colspan="8">No hay facturas registradas</td>' +
                                '</tr>');
                        }
                    }
                },
                error: function (data) {
                    // cuando data.message sea a unauthorized, redirigir a la pagina de login
                    if (data.message === 'unauthorized') {
                        swal.fire({
                            title: 'Error',
                            text: 'Vuelve a iniciar sesión',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });

                        window.location.href = '/iniciar_sesion';
                    }
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrio un error al obtener las facturas: ' + data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }

        function crear_factura() {
            window.location.href = '/crear_facturas';
        }

        function editar_factura(id) {
            window.location.href = '/editar_facturas/' + id;
        }

        function eliminar_factura(id){
            $('#id_factura_eliminar').val(id);
            $('#modal_eliminar_factura').modal('show');
        }

        function eliminar_factura_confirmado(){
            $.ajax({
                url: '/api/factura/eliminar_factura/' + $('#id_factura_eliminar').val(),
                type: 'delete',
                headers: {
                    'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                },
                success: function (data) {
                    if (data.code == 200) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Factura eliminada correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                        $('#modal_eliminar_factura').modal('hide');
                        obtener_facturas();
                    }
                },
                error: function (data) {
                    // cuando data.message sea a unauthorized, redirigir a la pagina de login
                    if (data.message === 'unauthorized') {
                        swal.fire({
                            title: 'Error',
                            text: 'Vuelve a iniciar sesión',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });

                        window.location.href = '/iniciar_sesion';
                    }
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrio un error al eliminar la factura: ' + data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    </script>

@endsection
