@extends('dashboard.layouts.layout', ['nombre_view' => "Facturas"])
@section('estilos')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>

        @import url(https://fonts.bunny.net/css?family=abeezee:400);

        .carta {
            margin: auto;
            width: 90%;
            max-width: 40em;
            padding: 10px;
            border: 1px solid #ffffff;
            background-color: #f5f5f5;
            box-shadow: 3px 3px 10px #D8CFCD;
            display: grid;
            gap: 10px;
            font-family: 'ABeeZee', sans-serif;
            color: #262626;
        }

        .title {
            margin-left: 0.7em;
            text-align: left;
            font-size: 2em;
            font-weight: bold;
        }

        .information_invoice {
            display: grid;
            gap: 10px;
            padding: 10px;
            border-radius: 5px;
            grid-template-columns: repeat(2, 1fr);
        }

        .imagen {
            width: 10em;
            object-fit: cover;
            border-radius: 5px;
        }

        .fechas {
            text-align: right;
        }

        .fechas input[type="text"] {
            width: 40%;
            text-align: end;
        }

        .tablaProductos {
            padding: 1em;
        }

        .tablaProductos table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px;
        }

        .tablaProductos thead {
            background-color: rgb(66, 91, 118);
            color: white;
            padding: 10px;
            text-align: center;
            height: 3em;
        }

        .tablaProductos tbody {
            text-align: center;
        }

        .tablaProductos tbody tr {
            height: 3em;
        }

        .tablaProductos tbody tr:nth-child(odd) {
            line-break: anywhere;
        }

        input {
            width: 80%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            height: 0.5em;
        }

        input:focus {
            outline: none;
            border: 2px dotted #FE5D39;
        }

        input[type="date"] {
            width: 40%;
        }

        .lastInvoice {
            display: grid;
            gap: 10px;
            padding: 10px;
            border-radius: 5px;
            grid-template-columns: repeat(2, 1fr);
            text-align: right;
        }

        .notas {
            padding: 10px;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 3px 3px 10px #D8CFCD;
            text-align: center;
        }

        .notas label {
            font-size: 1.5em;
        }

        .notas textarea {
            width: 90%;
            height: 90px;
            border-radius: 5px;
            border: none;
            padding: 10px;
            resize: none;
        }

        .notas textarea:focus {
            outline: none;
            border: 2px dotted #FE5D39;
        }

        .notas textarea::placeholder {
            text-align: center;
            font-size: 1em;
            color: #262626;
        }

        .btnAgregar {
            width: 85%;
            padding: 10px;
            border-radius: 5px;
            background-color: #ff532c;
            box-shadow: 3px 3px 10px #ff532c;
            text-align: center;
            color: #ffffff;
            height: 2em;
            margin: auto;
        }

        .guardarFactura {
            background-color: darkgreen;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin: 10px;
            cursor: pointer;
        }

        .logo-container {
            text-align: -webkit-center;
            text-align: -moz-center;
            text-align: center;
            width: 100%;
        }

        .logo-container img {
            width: 100%;
            max-width: 10em; /* Establece el tamaño máximo del logo */
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

        .total div {
            display: flex;
            justify-content: space-between;
        }

        /* Estilo de error */
        .error {
            border: 1px solid red;
        }
    </style>
@endsection
@section('content')
    <div class="carta">
        <h1 class="title">Factura</h1>
        <div class="information_invoice">
            <form>
                <div>
                    <input hidden id="id" name="id" value="{{isset($factura) ? $factura->id : ''}}">
                    <div>
                        <input id="id_empresa" hidden name="id_empresa"
                               value="{{isset($factura) ? $factura->id_empresa : ''}}">
                        <input type="text" id="nombre_empresa" required placeholder="Nombre de la compañia"
                               value="{{isset($factura) ? $factura->empresa->nombre_empresa : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="url_sitio_web" required placeholder="URL del sitio web"
                               value="{{isset($factura) ? $factura->empresa->url_sitio_web : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="numero_empresa" required placeholder="Número de la empresa"
                               value="{{isset($factura) ? $factura->empresa->numero_empresa : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="email" id="correo_electronico" required placeholder="Correo de la empresa"
                               value="{{isset($factura) ? $factura->empresa->correo_electronico : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="direccion" required placeholder="Dirección de la empresa"
                               value="{{isset($factura) ? $factura->empresa->direccion : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="ciudad" required placeholder="Ciudad de la empresa"
                               value="{{isset($factura) ? $factura->empresa->ciudad : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="estado" required placeholder="Estado de la empresa"
                               value="{{isset($factura) ? $factura->empresa->estado : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="codigo_postal" required placeholder="Código postal de la empresa"
                               value="{{isset($factura) ? $factura->empresa->codigo_postal : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input id="id_cliente" hidden name="id_cliente"
                               value="{{isset($factura) ? $factura->id_cliente : ''}}">
                        <input type="text" id="nombre_cliente" required placeholder="Nombre del cliente"
                               value="{{isset($factura) ? $factura->cliente->nombre_cliente : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="numero_cliente" required placeholder="Número del cliente"
                               value="{{isset($factura) ? $factura->cliente->numero_cliente : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="email" id="correo_electronico_cliente" required placeholder="Correo del cliente"
                               value="{{isset($factura) ? $factura->cliente->correo_electronico : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="direccion_cliente" required placeholder="Dirección del cliente"
                               value="{{isset($factura) ? $factura->cliente->direccion : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="ciudad_cliente" required placeholder="Ciudad del cliente"
                               value="{{isset($factura) ? $factura->cliente->ciudad : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="estado_cliente" required placeholder="Estado del cliente"
                               value="{{isset($factura) ? $factura->cliente->estado : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                    <div>
                        <input type="text" id="codigo_postal_cliente" required placeholder="Código postal del cliente"
                               value="{{isset($factura) ? $factura->cliente->codigo_postal : ''}}"
                            {{isset($factura) ? 'disabled' : ''}}
                        >
                    </div>
                </div>
            </form>
            <div>
                <div class="imagen">
                    <div class="logo-container">
                        <div class="drag-drop-area" onclick="triggerFileInput()">
                            <!-- Muestra la imagen si existe, de lo contrario muestra el mensaje -->
                            <img id="logoPreview" src="#" alt="Logo" style="display: none;">
                            <p id="logoPlaceholder">Arrastra y suelta el logo aquí o haz clic para
                                seleccionar</p>
                            <input type="file" id="fileInput" accept="image/*"
                                   onchange="handleFileSelect(event)">
                        </div>
                    </div>
                </div>
                <div class="fechas">
                    <div class="group">
                        <label for="InvoiceNo">Número factura:</label>
                        <input type="text" id="numero_invoice" placeholder="####" name="InvoiceNo" required
                               value="{{isset($factura) ? $factura->numero_invoice : ''}}"
                        >
                    </div>
                    <div class="group">
                        <label for="InvoiceDate">Fecha factura:</label>
                        <input type="date" id="fecha_invoice" name="InvoiceDate" required
                               value="{{isset($factura) ? $factura->fecha_invoice : ''}}"
                        >
                    </div>
                    <div class="group">
                        <label for="DueDate">Fecha vencimiento:</label>
                        <input type="date" id="fecha_vencimiento_invoice" name="DueDate" required
                               value="{{isset($factura) ? $factura->fecha_vencimiento_invoice : ''}}"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div>
            <table id="tablaProductos" class="tablaProductos">
                <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($factura))
                    @foreach($factura->invoiceDetalle as $detalle)
                        <tr>
                            <td>{{$detalle->nombre_producto}}</td>
                            <td>{{$detalle->cantidad}}</td>
                            <td>{{$detalle->precio}}</td>
                            <td><a type="button" onclick="EliminarProducto(this)" class="btnEliminar">Eliminar</a></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <a class="btnAgregar" onclick="AgregarProducto()">Agregar producto</a>
        <div class="lastInvoice">
            <div class="notas">
                <label for="notas">Notes:</label>
                <textarea id="comentario_invoice" name="notas" placeholder="Comentarios extras" required></textarea>
            </div>
            <div class="total">
                <div>
                    <label>SubTotal:</label>
                    <p id="subtotal_invoice" name="subtotal">{{isset($factura) ? $factura->subtotal_invoice : 0}}</p>

                </div>
                <div>
                    <label>IVA:</label>
                    <p type="number" id="impuesto_invoice"
                       name="iva">{{isset($factura) ? $factura->impuesto_invoice : 0}}</p>

                </div>
                <div>
                    <label>Total:</label>
                    <p id="total" name="total">{{isset($factura) ? $factura->total_invoice : 0}}</p>

                </div>
            </div>

        </div>
        @if(isset($factura))
            <a class="guardarFactura" onclick="validarFormularioActualizar()">Actualizar factura</a>
        @else
            <a class="guardarFactura" onclick="validarFormulario()">Guardar factura</a>
        @endif
        @endsection

        @section('scripts')
            <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
            <script type="text/javascript" charset="utf8"
                    src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

            <script>

                const table = new DataTable('#tablaProductos', {
                    dom: 'Bfrtip',
                    order: [[1, 'asc']],
                    searching: false,
                    paging: false,
                    info: false,
                });

                function AgregarProducto() {
                    table.row.add([
                        `Producto ${table.rows().data().length + 1}`,
                        '1',
                        '0',
                        '<a type="button" onclick="EliminarProducto(this)" class="btnEliminar">Eliminar</a>'
                    ]).draw();
                }


                function EliminarProducto(row) {
                    table.row($(row).parents('tr')).remove().draw();
                    CalcularTotal();
                }

                function CalcularTotal() {
                    let total = 0;
                    let iva = 0;
                    let subtotal = 0;

                    let rows = $('#tablaProductos').DataTable().rows().data();
                    for (let i = 0; i < rows.length; i++) {
                        let row = rows[i];
                        let cantidad = row[1];
                        let precio = row[2];
                        subtotal += cantidad * precio;
                    }
                    iva = subtotal * 0.16;
                    total = subtotal + iva;
                    document.getElementById('subtotal_invoice').innerHTML = `$ ${subtotal}`;
                    document.getElementById('impuesto_invoice').innerHTML = `$ ${iva.toFixed(2)}`;
                    document.getElementById('total').innerHTML = `$ ${total}`;
                }


                $('#tablaProductos').on('dblclick', 'td', function () {
                    var value = $(this).text();
                    $(this).html('<input type="text" value="' + value + '">');

                });

                $('#tablaProductos').on('blur', 'input', function () {
                    var value = $(this).val();
                    $(this).parent().html(value);

                    let rows = Array.from(document.querySelectorAll('#tablaProductos tbody tr'));
                    let data = rows.map(row => {
                        let cells = Array.from(row.querySelectorAll('td'));
                        return cells.map(cell => cell.innerText);
                    });
                    table.clear().rows.add(data).draw();
                    let rowsActions = Array.from(document.querySelectorAll('#tablaProductos tbody tr td:last-child'));
                    rowsActions.forEach(row => {
                        row.innerHTML = '<a type="button" onclick="EliminarProducto(this)" class="btnEliminar">Eliminar</a>';
                    });

                    CalcularTotal();
                });

                function handleFileSelect(evt) {
                    var files = evt.target.files;
                    var f = files[0];
                    var reader = new FileReader();
                    reader.onload = (function (theFile) {
                        return function (e) {
                            document.getElementById('logoPreview').style.display = 'block';
                            document.getElementById('logoPlaceholder').style.display = 'none';
                            document.getElementById('logoPreview').src = e.target.result;
                        };
                    })(f);
                    reader.readAsDataURL(f);
                }

                function triggerFileInput() {
                    document.getElementById('fileInput').click();
                }

                //  *** Validaciones ***

                function validarCorreos(correo) {
                    let regex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                    return regex.test(correo);
                }

                function validarTexto(texto) {
                    if (texto.length > 0) {
                        let regex = /^[a-zA-Z\s]*$/;
                        return regex.test(texto);

                    } else {
                        return false;
                    }

                }

                function validarTelefono(numero) {
                    if (numero.length == 10) {
                        let regex = /^[0-9]*$/;
                        return regex.test(numero);
                    } else {
                        return false;
                    }
                }

                function validarURL(url) {
                    let regex = /^(http|https):\/\/[^ "]+$/;
                    return regex.test(url);
                }

                function validarNumeroFactura(numero) {
                    let regex = /^[0-9]*$/;
                    return regex.test(numero);
                }

                function validarFecha(fecha) {
                    let regex = /^\d{4}-\d{2}-\d{2}$/;
                    return regex.test(fecha);
                }

                function validarCodigoPostal(codigo) {
                    // Valida que el código postal sea de 5 dígitos
                    let regex = /^[0-9]{5}$/;
                    return regex.test(codigo);
                }

                function validarFormulario() {

                    validarTexto($('#nombre_empresa').val()) ? $('#nombre_empresa').css('border', '1px solid #ccc') : $('#nombre_empresa').addClass('error');
                    validarTexto($('#nombre_cliente').val()) ? $('#nombre_cliente').css('border', '1px solid #ccc') : $('#nombre_cliente').addClass('error');
                    validarTelefono($('#numero_empresa').val()) ? $('#numero_empresa').css('border', '1px solid #ccc') : $('#numero_empresa').addClass('error');
                    validarTelefono($('#numero_cliente').val()) ? $('#numero_cliente').css('border', '1px solid #ccc') : $('#numero_cliente').addClass('error');
                    validarCorreos($('#correo_electronico').val()) ? $('#correo_electronico').css('border', '1px solid #ccc') : $('#correo_electronico').addClass('error');
                    validarCorreos($('#correo_electronico_cliente').val()) ? $('#correo_electronico_cliente').css('border', '1px solid #ccc') : $('#correo_electronico_cliente').addClass('error');
                    validarTexto($('#direccion').val()) ? $('#direccion').css('border', '1px solid #ccc') : $('#direccion').addClass('error');
                    validarTexto($('#direccion_cliente').val()) ? $('#direccion_cliente').css('border', '1px solid #ccc') : $('#direccion_cliente').addClass('error');
                    validarTexto($('#ciudad').val()) ? $('#ciudad').css('border', '1px solid #ccc') : $('#ciudad').addClass('error');
                    validarTexto($('#ciudad_cliente').val()) ? $('#ciudad_cliente').css('border', '1px solid #ccc') : $('#ciudad_cliente').addClass('error');
                    validarTexto($('#estado').val()) ? $('#estado').css('border', '1px solid #ccc') : $('#estado').addClass('error');
                    validarTexto($('#estado_cliente').val()) ? $('#estado_cliente').css('border', '1px solid #ccc') : $('#estado_cliente').addClass('error');
                    validarCodigoPostal($('#codigo_postal').val()) ? $('#codigo_postal').css('border', '1px solid #ccc') : $('#codigo_postal').addClass('error');
                    validarCodigoPostal($('#codigo_postal_cliente').val()) ? $('#codigo_postal_cliente').css('border', '1px solid #ccc') : $('#codigo_postal_cliente').addClass('error');
                    validarNumeroFactura($('#numero_invoice').val()) ? $('#numero_invoice').css('border', '1px solid #ccc') : $('#numero_invoice').addClass('error');
                    validarFecha($('#fecha_invoice').val()) ? $('#fecha_invoice').css('border', '1px solid #ccc') : $('#fecha_invoice').addClass('error');
                    validarFecha($('#fecha_vencimiento_invoice').val()) ? $('#fecha_vencimiento_invoice').css('border', '1px solid #ccc') : $('#fecha_vencimiento_invoice').addClass('error');
                    validarURL($('#url_sitio_web').val()) ? $('#url_sitio_web').css('border', '1px solid #ccc') : $('#url_sitio_web').addClass('error');


                    if (validarTexto($('#nombre_empresa').val()) && validarTexto($('#nombre_cliente').val()) && validarTelefono($('#numero_empresa').val()) && validarTelefono($('#numero_cliente').val()) && validarCorreos($('#correo_electronico').val()) && validarCorreos($('#correo_electronico_cliente').val()) && validarTexto($('#direccion').val()) && validarTexto($('#direccion_cliente').val()) && validarTexto($('#ciudad').val()) && validarTexto($('#ciudad_cliente').val()) && validarTexto($('#estado').val()) && validarTexto($('#estado_cliente').val()) && validarCodigoPostal($('#codigo_postal').val()) && validarCodigoPostal($('#codigo_postal_cliente').val()) && validarNumeroFactura($('#numero_invoice').val()) && validarFecha($('#fecha_invoice').val()) && validarFecha($('#fecha_vencimiento_invoice').val()) && validarURL($('#url_sitio_web').val()) && $('#logoPreview').attr('src') != '#') {
                        //Crea un objeto con los datos de la tabla para que quede [{"nombre_producto": "Producto 1", "cantidad": "1", "precio": "0"}, {"nombre_producto": "Producto 2", "cantidad": "1", "precio": "0"}, {"nombre_producto": "Producto 3", "cantidad": "1", "precio": "0" }]

                        const detalle = $('#tablaProductos').DataTable().rows().data().toArray();

                        const tablaProductos = detalle.map(item => {
                            return {
                                "nombre_producto": item[0],
                                "cantidad": item[1],
                                "precio": item[2]
                            };
                        });

                        var data = new FormData();
                        data.append('nombre_empresa', $('#nombre_empresa').val());
                        data.append('url_sitio_web', $('#url_sitio_web').val());
                        data.append('numero_empresa', $('#numero_empresa').val());
                        data.append('correo_electronico', $('#correo_electronico').val());
                        data.append('direccion', $('#direccion').val());
                        data.append('ciudad', $('#ciudad').val());
                        data.append('estado', $('#estado').val());
                        data.append('codigo_postal', $('#codigo_postal').val());
                        data.append('nombre_cliente', $('#nombre_cliente').val());
                        data.append('numero_cliente', $('#numero_cliente').val());
                        data.append('correo_electronico_cliente', $('#correo_electronico_cliente').val());
                        data.append('direccion_cliente', $('#direccion_cliente').val());
                        data.append('ciudad_cliente', $('#ciudad_cliente').val());
                        data.append('estado_cliente', $('#estado_cliente').val());
                        data.append('codigo_postal_cliente', $('#codigo_postal_cliente').val());
                        data.append('numero_invoice', $('#numero_invoice').val());
                        data.append('fecha_invoice', $('#fecha_invoice').val());
                        data.append('fecha_vencimiento_invoice', $('#fecha_vencimiento_invoice').val());
                        data.append('detalle', JSON.stringify(tablaProductos));
                        data.append('comentario_invoice', $('#comentario_invoice').val());
                        data.append('subtotal_invoice', $('#subtotal_invoice').text().replace('$', ''));
                        data.append('impuesto_invoice', $('#impuesto_invoice').text().replace('$', ''));
                        data.append('total_invoice', $('#total').text().replace('$', ''));
                        data.append('logo', $('#logoPreview').attr('src'));
                        data.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        var logo = $('#fileInput')[0].files[0];
                        data.append('logo', logo);
                        $.ajax({
                            url: '/api/factura/crear_factura',
                            type: 'post',
                            headers: {
                                'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                            },
                            data: data,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: 'Factura creada correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                });
                                window.location.href = '/facturas';


                            },
                            error: function (error) {
                                console.error(error);
                            }
                        });

                    } else {
                        alert('Favor de llenar todos los campos');
                    }

                }

                function validarFormularioActualizar() {

                    validarTexto($('#nombre_empresa').val()) ? $('#nombre_empresa').css('border', '1px solid #ccc') : $('#nombre_empresa').addClass('error');
                    validarTexto($('#nombre_cliente').val()) ? $('#nombre_cliente').css('border', '1px solid #ccc') : $('#nombre_cliente').addClass('error');
                    validarTelefono($('#numero_empresa').val()) ? $('#numero_empresa').css('border', '1px solid #ccc') : $('#numero_empresa').addClass('error');
                    validarTelefono($('#numero_cliente').val()) ? $('#numero_cliente').css('border', '1px solid #ccc') : $('#numero_cliente').addClass('error');
                    validarCorreos($('#correo_electronico').val()) ? $('#correo_electronico').css('border', '1px solid #ccc') : $('#correo_electronico').addClass('error');
                    validarCorreos($('#correo_electronico_cliente').val()) ? $('#correo_electronico_cliente').css('border', '1px solid #ccc') : $('#correo_electronico_cliente').addClass('error');
                    validarTexto($('#direccion').val()) ? $('#direccion').css('border', '1px solid #ccc') : $('#direccion').addClass('error');
                    validarTexto($('#direccion_cliente').val()) ? $('#direccion_cliente').css('border', '1px solid #ccc') : $('#direccion_cliente').addClass('error');
                    validarTexto($('#ciudad').val()) ? $('#ciudad').css('border', '1px solid #ccc') : $('#ciudad').addClass('error');
                    validarTexto($('#ciudad_cliente').val()) ? $('#ciudad_cliente').css('border', '1px solid #ccc') : $('#ciudad_cliente').addClass('error');
                    validarTexto($('#estado').val()) ? $('#estado').css('border', '1px solid #ccc') : $('#estado').addClass('error');
                    validarTexto($('#estado_cliente').val()) ? $('#estado_cliente').css('border', '1px solid #ccc') : $('#estado_cliente').addClass('error');
                    validarCodigoPostal($('#codigo_postal').val()) ? $('#codigo_postal').css('border', '1px solid #ccc') : $('#codigo_postal').addClass('error');
                    validarCodigoPostal($('#codigo_postal_cliente').val()) ? $('#codigo_postal_cliente').css('border', '1px solid #ccc') : $('#codigo_postal_cliente').addClass('error');
                    validarNumeroFactura($('#numero_invoice').val()) ? $('#numero_invoice').css('border', '1px solid #ccc') : $('#numero_invoice').addClass('error');
                    validarFecha($('#fecha_invoice').val()) ? $('#fecha_invoice').css('border', '1px solid #ccc') : $('#fecha_invoice').addClass('error');
                    validarFecha($('#fecha_vencimiento_invoice').val()) ? $('#fecha_vencimiento_invoice').css('border', '1px solid #ccc') : $('#fecha_vencimiento_invoice').addClass('error');
                    validarURL($('#url_sitio_web').val()) ? $('#url_sitio_web').css('border', '1px solid #ccc') : $('#url_sitio_web').addClass('error');


                    if (validarTexto($('#nombre_empresa').val()) && validarTexto($('#nombre_cliente').val()) && validarTelefono($('#numero_empresa').val()) && validarTelefono($('#numero_cliente').val()) && validarCorreos($('#correo_electronico').val()) && validarCorreos($('#correo_electronico_cliente').val()) && validarTexto($('#direccion').val()) && validarTexto($('#direccion_cliente').val()) && validarTexto($('#ciudad').val()) && validarTexto($('#ciudad_cliente').val()) && validarTexto($('#estado').val()) && validarTexto($('#estado_cliente').val()) && validarCodigoPostal($('#codigo_postal').val()) && validarCodigoPostal($('#codigo_postal_cliente').val()) && validarNumeroFactura($('#numero_invoice').val()) && validarFecha($('#fecha_invoice').val()) && validarFecha($('#fecha_vencimiento_invoice').val()) && validarURL($('#url_sitio_web').val()) && $('#logoPreview').attr('src') != '#') {
                        //Crea un objeto con los datos de la tabla para que quede [{"nombre_producto": "Producto 1", "cantidad": "1", "precio": "0"}, {"nombre_producto": "Producto 2", "cantidad": "1", "precio": "0"}, {"nombre_producto": "Producto 3", "cantidad": "1", "precio": "0" }]

                        const detalle = $('#tablaProductos').DataTable().rows().data().toArray();

                        const tablaProductos = detalle.map(item => {
                            return {
                                "nombre_producto": item[0],
                                "cantidad": item[1],
                                "precio": item[2]
                            };
                        });

                        var data = new FormData();
                        data.append('id', $('#id').val());
                        data.append('id_empresa', $('#id_empresa').val());
                        data.append('id_cliente', $('#id_cliente').val());
                        data.append('nombre_empresa', $('#nombre_empresa').val());
                        data.append('url_sitio_web', $('#url_sitio_web').val());
                        data.append('numero_empresa', $('#numero_empresa').val());
                        data.append('correo_electronico', $('#correo_electronico').val());
                        data.append('direccion', $('#direccion').val());
                        data.append('ciudad', $('#ciudad').val());
                        data.append('estado', $('#estado').val());
                        data.append('codigo_postal', $('#codigo_postal').val());
                        data.append('nombre_cliente', $('#nombre_cliente').val());
                        data.append('numero_cliente', $('#numero_cliente').val());
                        data.append('correo_electronico_cliente', $('#correo_electronico_cliente').val());
                        data.append('direccion_cliente', $('#direccion_cliente').val());
                        data.append('ciudad_cliente', $('#ciudad_cliente').val());
                        data.append('estado_cliente', $('#estado_cliente').val());
                        data.append('codigo_postal_cliente', $('#codigo_postal_cliente').val());
                        data.append('numero_invoice', $('#numero_invoice').val());
                        data.append('fecha_invoice', $('#fecha_invoice').val());
                        data.append('fecha_vencimiento_invoice', $('#fecha_vencimiento_invoice').val());
                        data.append('detalle', JSON.stringify(tablaProductos));
                        data.append('comentario_invoice', $('#comentario_invoice').val());
                        data.append('subtotal_invoice', $('#subtotal_invoice').text().replace('$', ''));
                        data.append('impuesto_invoice', $('#impuesto_invoice').text().replace('$', ''));
                        data.append('total_invoice', $('#total').text().replace('$', ''));
                        if ($('#logoPreview').attr('src') != '#' || $('#logoPreview').attr('src') != '') {
                            data.append('logo', $('#logoPreview').attr('src'));
                        }
                        data.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        var logo = $('#fileInput')[0].files[0];
                        data.append('logo', logo);
                        $.ajax({
                            url: '/api/factura/actualizar_factura',
                            type: 'post',
                            headers: {
                                'Authorization': 'Bearer ' + '{{Session::get('token')}}'
                            },
                            data: data,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: 'Factura actualizada correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                });
                                window.location.href = '/facturas';

                            },
                            error: function (error) {
                                console.error(error);
                            }
                        });

                    } else {
                        alert('Favor de llenar todos los campos');
                    }

                }


            </script>

@endsection

