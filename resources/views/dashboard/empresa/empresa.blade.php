@extends('dashboard.layouts.layout', ['nombre_view' => "Empresas"])
@section('title_page', 'Empresas')
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
                    <h3 class="card-title">Empresas</h3>
                    <div class="card-tools">
                        <a onclick="crear_empresa_modal()" class="btn btn-success">Agregar Nueva Empresa</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="empresas-table" class="table table-bordered table-hover" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Empresa</th>
                                <th>Sitio Web</th>
                                <th>Correo</th>
                                <th>Dirección</th>
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

    <div class="modal fade" id="modal_logo" tabindex="-1" aria-labelledby="modal_logo" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logo de la empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{--                    Contenedor para la imagen--}}
                    <div id="contenedor_imagen">
                        <img id="imagen_logo" src="" alt="Logo de la empresa" style="width: 100%; height: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    Modal para crear una empresa--}}
    <div class="modal fade" id="modal_crear_empresa" tabindex="-1" aria-labelledby="modal_crear_empresa"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloFormEmpresa">Crear Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_crear_empresa">
                        <input hidden id="id" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre_empresa" class="form-label">Nombre Empresa</label>
                                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="url_sitio_web" class="form-label">Sitio Web</label>
                                <input type="text" class="form-control" id="url_sitio_web" name="url_sitio_web">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="numero_empresa" class="form-label">Numero Empresa</label>
                                <input type="text" class="form-control" id="numero_empresa" name="numero_empresa">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="correo_electronico" class="form-label">Correo Electronico</label>
                                <input type="email" class="form-control" id="correo_electronico"
                                       name="correo_electronico">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <div class="logo-container">
                                    <div class="drag-drop-area" onclick="autoClickFileIInput()">
                                        <!-- Muestra la imagen si existe, de lo contrario muestra el mensaje -->
                                        <img id="logoPreview" src="#" alt="Logo" style="display: none;">
                                        <p id="logoPlaceholder">Arrastra y suelta el logo aquí o haz clic para
                                            seleccionar</p>
                                        <input type="file" id="fileInput" accept="image/*"
                                               onchange="precargarVistaPrevia(event)">
                                    </div>
                                </div>
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
                                <a type="button" class="btn btn-primary" id="guardarEmpresa"
                                   onclick="guardar_empresa()">Guardar</a>
                                <a type="button" class="btn btn-primary d-none" id="actualizarEmpresa"
                                   onclick="actualizar_empresa()">Actualizar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    Modal de pregunta para eliminar la empresa--}}
    <div class="modal fade" id="modal_eliminar_empresa" tabindex="-1" aria-labelledby="modal_eliminar_empresa"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar la empresa?</p>
                    <input hidden id="id_empresa_eliminar">
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" onclick="eliminar_empresa_confirmado()">Eliminar</a>
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
        });
        var empresas = [];

        function obtener_empresas() {
            empresas = [];
            $('#empresas-table').DataTable().destroy();
            $('#empresas-table tbody').empty();
            $.ajax({
                url: '/api/empresa/obtener_empresas',
                type: 'get',
                headers: {
                    'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                },
                success: function (data) {
                    if (data.code == 200) {
                        if (data.data.length > 0) {
                            empresas = data.data;
                            data.data.forEach(function (empresa) {
                                $('#empresas-table tbody').append('<tr>' +
                                    '<td>' + empresa.id + '</td>' +
                                    '<td>' + empresa.nombre_empresa + '</td>' +
                                    '<td>' + empresa.url_sitio_web + '</td>' +
                                    '<td>' + empresa.correo_electronico + '</td>' +
                                    '<td>' + empresa.direccion_completa + '</td>' +
                                    '<td>' + empresa.creacion + '</td>' +
                                    '<td>' + empresa.actualizacion + '</td>' +
                                    '<td>' +
                                    '<a class="btn btn-primary" onclick="editar_empresa(' + empresa.id + ')"><i class="fas fa-edit"></i></a>' +
                                    '<a class="btn btn-danger" onclick="eliminar_empresa(' + empresa.id + ')"><i class="fas fa-trash"></i></a>' +
                                    '<a class="btn btn-info" onclick="ver_logo(' + empresa.id + ')"><i class="fas fa-eye"></i></a>' +
                                    '</td>' +
                                    '</tr>');
                            });
                            $('#empresas-table').DataTable();
                        } else {
                            $('#empresas-table tbody').append('<tr>' +
                                '<td colspan="8">No hay empresas registradas</td>' +
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
                        text: 'Ocurrio un error al obtener las empresas: ' + data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }

        function ver_logo(id) {
            //busca dentro de la lista de empresas, la empresa que tenga el id que se le pasa por parametro
            var empresa = empresas.find(empresa => empresa.id === id);
            //si la empresa existe  y tiene un logo, este vieene en base64, por lo que se le asigna al src de la imagen
            if (empresa && empresa.url_logo) {
                $('#imagen_logo').attr('src', 'data:image/png;base64,' + empresa.url_logo);
                $('#modal_logo').modal('show');
            }
        }

        function crear_empresa_modal() {
            //limpia los campos del formulario
            $('#form_crear_empresa').trigger('reset');
            $('#tituloFormEmpresa').text('Crear Empresa');
            $('#modal_crear_empresa').modal('show');
        }


        function guardar_empresa() {
            var nombre_empresa = $('#nombre_empresa').val();
            var url_sitio_web = $('#url_sitio_web').val();
            var numero_empresa = $('#numero_empresa').val();
            var correo_electronico = $('#correo_electronico').val();
            var logo = $('#fileInput')[0].files[0];
            var direccion = $('#direccion').val();
            var ciudad = $('#ciudad').val();
            var estado = $('#estado').val();
            var codigo_postal = $('#codigo_postal').val();
            //valida que los campos no esten vacios y sean validos
            if (nombre_empresa && url_sitio_web && numero_empresa && correo_electronico && logo && direccion && ciudad && estado && codigo_postal) {
                var formData = new FormData();
                formData.append('nombre_empresa', nombre_empresa);
                formData.append('url_sitio_web', url_sitio_web);
                formData.append('numero_empresa', numero_empresa);
                formData.append('correo_electronico', correo_electronico);
                formData.append('logo', logo);
                formData.append('direccion', direccion);
                formData.append('ciudad', ciudad);
                formData.append('estado', estado);
                formData.append('codigo_postal', codigo_postal);
                formData.append('id_usuario', {{Session::get('usuario')['id']}});
                $.ajax({
                    url: '/api/empresa/crear_empresa',
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
                                text: 'Empresa creada correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                            $('#modal_crear_empresa').modal('hide');
                            obtener_empresas();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al crear la empresa: ' + data,
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
                                text: 'Ocurrió un error al crear la empresa: ' + errorMessage,
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
                                text: 'Ocurrió un error al crear la empresa: ' + jqXHR.responseText,
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

        function actualizar_empresa() {
            var id = $('#id').val();
            var nombre_empresa = $('#nombre_empresa').val();
            var url_sitio_web = $('#url_sitio_web').val();
            var numero_empresa = $('#numero_empresa').val();
            var correo_electronico = $('#correo_electronico').val();
            var logo = $('#fileInput')[0].files[0];
            var direccion = $('#direccion').val();
            var ciudad = $('#ciudad').val();
            var estado = $('#estado').val();
            var codigo_postal = $('#codigo_postal').val();
            if (nombre_empresa && url_sitio_web && numero_empresa && correo_electronico && direccion && ciudad && estado && codigo_postal) {
                var formData = new FormData();
                formData.append('id', id);
                formData.append('nombre_empresa', nombre_empresa);
                formData.append('url_sitio_web', url_sitio_web);
                formData.append('numero_empresa', numero_empresa);
                formData.append('correo_electronico', correo_electronico);
                if (logo) {
                    formData.append('logo', logo);
                }
                formData.append('direccion', direccion);
                formData.append('ciudad', ciudad);
                formData.append('estado', estado);
                formData.append('codigo_postal', codigo_postal);
                formData.append('id_usuario', {{Session::get('usuario')['id']}});
                $.ajax({
                    url: '/api/empresa/actualizar_empresa',
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
                                text: 'Empresa actualizada correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                            $('#modal_crear_empresa').modal('hide');
                            obtener_empresas();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un error al actualizar la empresa: ' + data,
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
                                text: 'Ocurrió un error al actualizar la empresa: ' + errorMessage,
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
                                text: 'Ocurrió un error al actualizar la empresa: ' + jqXHR.responseText,
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

        function editar_empresa(id) {
            var empresa = empresas.find(empresa => empresa.id === id);
            if (empresa) {
                $('#id').val(empresa.id);
                $('#nombre_empresa').val(empresa.nombre_empresa);
                $('#url_sitio_web').val(empresa.url_sitio_web);
                $('#numero_empresa').val(empresa.numero_empresa);
                $('#correo_electronico').val(empresa.correo_electronico);
                $('#direccion').val(empresa.direccion);
                $('#ciudad').val(empresa.ciudad);
                $('#estado').val(empresa.estado);
                $('#codigo_postal').val(empresa.codigo_postal);
                $('#tituloFormEmpresa').text('Editar Empresa');
                $('#guardarEmpresa').addClass('d-none');
                $('#fileInput').val('');
                if (empresa.url_logo) {
                    $('#logoPreview').attr('src', 'data:image/png;base64,' + empresa.url_logo);
                    $('#logoPreview').css('display', 'block');
                    $('#logoPlaceholder').css('display', 'none');
                }
                $('#actualizarEmpresa').removeClass('d-none');
                $('#modal_crear_empresa').modal('show');
            }
        }

        function eliminar_empresa(id) {
            $('#id_empresa_eliminar').val(id);
            $('#modal_eliminar_empresa').modal('show');
        }

        function eliminar_empresa_confirmado() {
            var id = $('#id_empresa_eliminar').val();
            $.ajax({
                url: '/api/empresa/eliminar_empresa/' + id,
                type: 'delete',
                headers: {
                    'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                },
                success: function (data) {
                    if (data.code === 200) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Empresa eliminada correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                        $('#modal_eliminar_empresa').modal('hide');
                        obtener_empresas();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar la empresa: ' + data,
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
                            text: 'Ocurrió un error al eliminar la empresa: ' + errorMessage,
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
                            text: 'Ocurrió un error al eliminar la empresa: ' + jqXHR.responseText,
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
