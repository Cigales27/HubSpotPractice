<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login | Dashboard</title>
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-12 col-xl-10">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center"><h4 class="text-dark mb-4">Hubspot Generador de
                                        Facturas</h4></div>
                                @if(isset($errors) && $errors != [] && $errors != null && $errors != '' && $errors != '[]' && $errors != 'null' && $errors != '')
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors}}
                                    </div>
                                @endif
                                <form class="user" action="/inicia_sesion" method="get">
                                    <div class="mb-3">
                                        <label for="correo" class="form-label">Correo Electronico</label>
                                        <input class="form-control form-control-user" type="email"
                                               id="correo" aria-describedby="emailHelp"
                                               placeholder="Ingrese su correo electronico" name="correo"></div>
                                    <div class="mb-3"><label for="contrasenia" class="form-label">Contraseña</label>
                                        <input class="form-control form-control-user" type="password"
                                               id="contrasenia" placeholder="Ingrese su contraseña"
                                               name="contrasenia"></div>
                                    <div class="mb-3"></div>
                                    <button class="btn btn-primary d-block btn-user w-100" type="submit">Iniciar Sesion
                                    </button>
                                    <hr>
                                    <hr>
                                </form>
                                <div class="text-center"><a class="small" href="/registrar">
                                        Crear Cuenta</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<script>

</script>
</body>
</html>
