@extends('dashboard.layouts.layout', ['nombre_view' => "Clientes"])
@section('title_page', 'Clientes')
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
                <div class="card-header">
                    <h3 class="card-title">Clientes</h3>
                    <div class="card-tools">
                        <a onclick="crear_cliente_modal()" class="btn btn-success">Agregar Nuevo Cliente</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="clientes-table" class="table table-bordered table-hover" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Cliente</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Empresa a la que pertenece</th>
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

    {{--    Modal para crear una cliente--}}
    <div class="modal fade" id="modal_crear_cliente" tabindex="-1" aria-labelledby="modal_crear_cliente"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloFormCliente">Crear Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_crear_cliente">
                        <input hidden id="id" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="empresa" class="form-label">Empresa</label>
                                <select class="form-control" id="empresa" name="empresa">
                                    <option selected>Selecciona una empresa</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre_cliente" class="form-label">Nombre cliente</label>
                                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="numero_cliente" class="form-label">Numero cliente</label>
                                <input type="text" class="form-control" id="numero_cliente" name="numero_cliente">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="correo_electronico" class="form-label">Correo Electronico</label>
                                <input type="email" class="form-control" id="correo_electronico"
                                       name="correo_electronico">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="codigo_postal" class="form-label">Codigo Postal</label>
                                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a type="button" class="btn btn-primary" id="guardarCliente"
                                   onclick="guardar_cliente()">Guardar</a>
                                <a type="button" class="btn btn-primary d-none" id="actualizarCliente"
                                   onclick="actualizar_cliente()">Actualizar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    Modal de pregunta para eliminar la cliente--}}
    <div class="modal fade" id="modal_eliminar_cliente" tabindex="-1" aria-labelledby="modal_eliminar_cliente"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar al cliente?</p>
                    <input hidden id="id_cliente_eliminar">
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" onclick="eliminar_cliente_confirmado()">Eliminar</a>
                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            obtener_empresas();
            obtener_clientes();
        });
        var clientes = [];

        function obtener_clientes() {
            clientes = [];
            $('#clientes-table').DataTable().destroy();
            $('#clientes-table tbody').empty();
            $.ajax({
                url: '/api/cliente/obtener_clientes',
                type: 'get',
                headers: {
                    'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                },
                success: function (data) {
                    if (data.code == 200) {
                        if (data.data.length > 0) {
                            clientes = data.data;
                            data.data.forEach(function (cliente) {
                                $('#clientes-table tbody').append('<tr>' +
                                    '<td>' + cliente.id + '</td>' +
                                    '<td>' + cliente.nombre_cliente + '</td>' +
                                    '<td>' + cliente.correo_electronico + '</td>' +
                                    '<td>' + cliente.direccion_completa + '</td>' +
                                    '<td>' + cliente.empresa.nombre_empresa + '</td>' +
                                    '<td>' + cliente.creacion + '</td>' +
                                    '<td>' + cliente.actualizacion + '</td>' +
                                    '<td>' +
                                    '<a class="btn btn-primary" onclick="editar_cliente(' + cliente.id + ')"><i class="fas fa-edit"></i></a>' +
                                    '<a class="btn btn-danger" onclick="eliminar_cliente(' + cliente.id + ')"><i class="fas fa-trash"></i></a>' +
                                    '</td>' +
                                    '</tr>');
                            });
                            $('#clientes-table').DataTable();
                        } else {
                            $('#clientes-table tbody').append('<tr>' +
                                '<td colspan="8">No hay clientes registradas</td>' +
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
                        text: 'Ocurrio un error al obtener las clientes: ' + data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }


        function crear_cliente_modal() {
            //limpia los campos del formulario
            $('#form_crear_cliente').trigger('reset');
            $('#tituloFormcliente').text('Crear cliente');
            $('#modal_crear_cliente').modal('show');
        }

        function obtener_empresas() {
            $.ajax({
                url: '/api/empresa/obtener_empresas',
                type: 'get',
                headers: {
                    'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                },
                success: function (data) {
                    if (data.code == 200) {
                        if (data.data.length > 0) {
                            data.data.forEach(function (empresa) {
                                $('#empresa').append('<option value="' + empresa.id + '">' + empresa.nombre_empresa + '</option>');
                            });
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
                        text: 'Ocurrio un error al obtener las empresas: ' + data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }


        function guardar_cliente() {
            var nombre_cliente = $('#nombre_cliente').val();
            var numero_cliente = $('#numero_cliente').val();
            var correo_electronico = $('#correo_electronico').val();
            var direccion = $('#direccion').val();
            var id_empresa = $('#empresa').val();
            var ciudad = $('#ciudad').val();
            var estado = $('#estado').val();
            var codigo_postal = $('#codigo_postal').val();
            //valida que los campos no esten vacios y sean validos
            if (nombre_cliente &&  numero_cliente && correo_electronico && direccion && ciudad && estado && codigo_postal) {
                var formData = new FormData();
                formData.append('nombre_cliente', nombre_cliente);
                formData.append('numero_cliente', numero_cliente);
                formData.append('correo_electronico', correo_electronico);
                formData.append('direccion', direccion);
                formData.append('ciudad', ciudad);
                formData.append('id_empresa', id_empresa);
                formData.append('estado', estado);
                formData.append('codigo_postal', codigo_postal);
                formData.append('id_usuario', {{Session::get('usuario')['id']}});
                $.ajax({
                    url: '/api/cliente/crear_cliente',
                    type: 'post',
                    headers: {
                        'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.code === 200) {
                            Swal.fire({
                                title: 'Éxito',
                                text: 'Cliente creada correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                            $('#modal_crear_cliente').modal('hide');
                            obtener_clientes();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al crear el cliente: ' + data,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        if (jqXHR.status) {
                            var errorMessage = jqXHR.responseJSON.message;
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al crear el cliente: ' + errorMessage,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        } else if (jqXHR.responseJSON && jqXHR.responseJSON.message === 'unauthorized') {
                            Swal.fire({
                                title: 'Error',
                                text: 'Vuelve a iniciar sesión',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                            window.location.href = '/iniciar_sesion';
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al crear el cliente: ' + jqXHR.responseText,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Todos los campos son requeridos',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        }

        function actualizar_cliente() {
            var id = $('#id').val();
            var nombre_cliente = $('#nombre_cliente').val();
            var numero_cliente = $('#numero_cliente').val();
            var correo_electronico = $('#correo_electronico').val();
            var direccion = $('#direccion').val();
            var ciudad = $('#ciudad').val();
            var estado = $('#estado').val();
            var id_empresa = $('#empresa').val();
            var codigo_postal = $('#codigo_postal').val();
            if (nombre_cliente && numero_cliente && correo_electronico && direccion && ciudad && estado && codigo_postal) {
                var formData = new FormData();
                formData.append('id', id);
                formData.append('nombre_cliente', nombre_cliente);
                formData.append('numero_cliente', numero_cliente);
                formData.append('correo_electronico', correo_electronico);
                formData.append('id_empresa', id_empresa);
                formData.append('direccion', direccion);
                formData.append('ciudad', ciudad);
                formData.append('estado', estado);
                formData.append('codigo_postal', codigo_postal);
                formData.append('id_usuario', {{Session::get('usuario')['id']}});
                $.ajax({
                    url: '/api/cliente/actualizar_cliente',
                    type: 'post',
                    headers: {
                        'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.code === 200) {
                            Swal.fire({
                                title: 'Éxito',
                                text: 'Cliente actualizada correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                            $('#modal_crear_cliente').modal('hide');
                            obtener_clientes();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al actualizar el cliente: ' + data,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        if (jqXHR.status) {
                            var errorMessage = jqXHR.responseJSON.message;
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al actualizar el cliente: ' + errorMessage,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        } else if (jqXHR.responseJSON && jqXHR.responseJSON.message === 'unauthorized') {
                            Swal.fire({
                                title: 'Error',
                                text: 'Vuelve a iniciar sesión',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                            window.location.href = '/iniciar_sesion';
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al actualizar el cliente: ' + jqXHR.responseText,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Todos los campos son requeridos',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        }

        function editar_cliente(id) {
            var cliente = clientes.find(cliente => cliente.id === id);
            if (cliente) {
                $('#id').val(cliente.id);
                $('#nombre_cliente').val(cliente.nombre_cliente);
                $('#numero_cliente').val(cliente.numero_cliente);
                $('#correo_electronico').val(cliente.correo_electronico);
                $('#direccion').val(cliente.direccion);
                $('#ciudad').val(cliente.ciudad);
                $('#estado').val(cliente.estado);
                $('#empresa').val(cliente.id_empresa);
                $('#codigo_postal').val(cliente.codigo_postal);
                $('#tituloFormcliente').text('Editar cliente');
                $('#guardarcliente').addClass('d-none');
                $('#fileInput').val('');
                $('#actualizarcliente').removeClass('d-none');
                $('#modal_crear_cliente').modal('show');
            }
        }

        function eliminar_cliente(id) {
            $('#id_cliente_eliminar').val(id);
            $('#modal_eliminar_cliente').modal('show');
        }

        function eliminar_cliente_confirmado() {
            var id = $('#id_cliente_eliminar').val();
            $.ajax({
                url: '/api/cliente/eliminar_cliente/' + id,
                type: 'delete',
                headers: {
                    'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                },
                success: function (data) {
                    if (data.code === 200) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Cliente eliminado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                        $('#modal_eliminar_cliente').modal('hide');
                        obtener_clientes();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar el cliente: ' + data,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    if (jqXHR.status) {
                        var errorMessage = jqXHR.responseJSON.message;
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar el cliente: ' + errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    } else if (jqXHR.responseJSON && jqXHR.responseJSON.message === 'unauthorized') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Vuelve a iniciar sesión',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        window.location.href = '/iniciar_sesion';
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar el cliente: ' + jqXHR.responseText,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                }
            });
        }

        function autoClickFileIInput() {
            document.getElementById('fileInput').click();
        }

        function precargarVistaPrevia(event) {
            var input = event.target;
            var preview = document.getElementById('logoPreview');
            var placeholder = document.getElementById('logoPlaceholder');

            var reader = new FileReader();
            reader.onload = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
