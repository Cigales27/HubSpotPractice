<?php

namespace App\Http\Requests\Invoice;

use App\Helpers\ValidatorHelper;
use Illuminate\Foundation\Http\FormRequest;

class CrearInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_empresa'                 => ['nullable', 'integer', 'exists:empresas,id'],
            'nombre_empresa'             => ['required_if:id_empresa,null', 'string', 'max:255'],
            'url_sitio_web'              => ['required_if:id_empresa,null', 'string', 'max:255'],
            'numero_empresa'             => ['required_if:id_empresa,null', 'integer', 'max:9999999999'],
            'correo_electronico'         => ['required_if:id_empresa,null', 'string', 'max:255'],
            'logo'                       => ['required_if:id_empresa,null', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'direccion'                  => ['required_if:id_empresa,null', 'string', 'max:255'],
            'ciudad'                     => ['required_if:id_empresa,null', 'string', 'max:255'],
            'estado'                     => ['required_if:id_empresa,null', 'string', 'max:255'],
            'codigo_postal'              => ['required_if:id_empresa,null', 'string', 'max:255'],
            'id_cliente'                 => ['nullable', 'integer', 'exists:clientes,id'],
            'nombre_cliente'             => ['required_if:id_cliente,null', 'string', 'max:255'],
            'numero_cliente'             => ['required_if:id_cliente,null', 'integer', 'max:9999999999'],
            'correo_electronico_cliente' => ['required_if:id_cliente,null', 'string', 'max:255'],
            'direccion_cliente'          => ['required_if:id_cliente,null', 'string', 'max:255'],
            'ciudad_cliente'             => ['required_if:id_cliente,null', 'string', 'max:255'],
            'estado_cliente'             => ['required_if:id_cliente,null', 'string', 'max:255'],
            'codigo_postal_cliente'      => ['required_if:id_cliente,null', 'string', 'max:255'],
            'nombre_invoice'             => ['required', 'string', 'max:255'],
            'numero_invoice'             => ['required', 'integer'],
            'fecha_invoice'              => ['required', 'date'],
            'fecha_vencimiento_invoice'  => ['required', 'date'],
            'comentario_invoice'         => ['nullable', 'string', 'max:255'],
            'subtotal_invoice'           => ['required', 'numeric'],
            'impuesto_invoice'           => ['required', 'numeric'],
            'total_invoice'              => ['required', 'numeric'],
            'detalle'                    => ['required', 'array'],
            'detalle.*.nombre_producto'  => ['required', 'string', 'max:255'],
            'detalle.*.cantidad'         => ['required', 'numeric'],
            'detalle.*.precio'           => ['required', 'numeric'],
            'activo'                     => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id_empresa.required_if'                 => 'El campo id_empresa es requerido',
            'id_empresa.integer'                     => 'El campo id_empresa debe ser un número entero',
            'id_empresa.exists'                      => 'El campo id_empresa no existe en la base de datos',
            'nombre_empresa.required_if'             => 'El campo nombre_empresa es requerido',
            'nombre_empresa.string'                  => 'El campo nombre_empresa debe ser una cadena de caracteres',
            'nombre_empresa.max'                     => 'El campo nombre_empresa debe tener máximo 255 caracteres',
            'url_sitio_web.required_if'              => 'El campo url_sitio_web es requerido',
            'url_sitio_web.string'                   => 'El campo url_sitio_web debe ser una cadena de caracteres',
            'url_sitio_web.max'                      => 'El campo url_sitio_web debe tener máximo 255 caracteres',
            'numero_empresa.required_if'             => 'El campo numero_empresa es requerido',
            'numero_empresa.integer'                 => 'El campo numero_empresa debe ser un número entero',
            'numero_empresa.max'                     => 'El campo numero_empresa debe tener máximo 10 dígitos',
            'correo_electronico.required_if'         => 'El campo correo_electronico es requerido',
            'correo_electronico.string'              => 'El campo correo_electronico debe ser una cadena de caracteres',
            'correo_electronico.max'                 => 'El campo correo_electronico debe tener máximo 255 caracteres',
            'logo.required_if'                       => 'El campo logo es requerido',
            'logo.image'                             => 'El campo logo debe ser una imagen',
            'logo.mimes'                             => 'El campo logo debe ser una imagen de tipo: jpeg, png, jpg',
            'logo.max'                               => 'El campo logo debe tener máximo 2MB',
            'direccion.required_if'                  => 'El campo direccion es requerido',
            'direccion.string'                       => 'El campo direccion debe ser una cadena de caracteres',
            'direccion.max'                          => 'El campo direccion debe tener máximo 255 caracteres',
            'ciudad.required_if'                     => 'El campo ciudad es requerido',
            'ciudad.string'                          => 'El campo ciudad debe ser una cadena de caracteres',
            'ciudad.max'                             => 'El campo ciudad debe tener máximo 255 caracteres',
            'estado.required_if'                     => 'El campo estado es requerido',
            'estado.string'                          => 'El campo estado debe ser una cadena de caracteres',
            'estado.max'                             => 'El campo estado debe tener máximo 255 caracteres',
            'codigo_postal.required_if'              => 'El campo codigo_postal es requerido',
            'codigo_postal.string'                   => 'El campo codigo_postal debe ser una cadena de caracteres',
            'codigo_postal.max'                      => 'El campo codigo_postal debe tener máximo 255 caracteres',
            'id_cliente.required_if'                 => 'El campo id_cliente es requerido',
            'id_cliente.integer'                     => 'El campo id_cliente debe ser un número entero',
            'id_cliente.exists'                      => 'El campo id_cliente no existe en la base de datos',
            'nombre_cliente.required_if'             => 'El campo nombre_cliente es requerido',
            'nombre_cliente.string'                  => 'El campo nombre_cliente debe ser una cadena de caracteres',
            'nombre_cliente.max'                     => 'El campo nombre_cliente debe tener máximo 255 caracteres',
            'numero_cliente.required_if'             => 'El campo numero_cliente es requerido',
            'numero_cliente.integer'                 => 'El campo numero_cliente debe ser un número entero',
            'numero_cliente.max'                     => 'El campo numero_cliente debe tener máximo 10 dígitos',
            'correo_electronico_cliente.required_if' => 'El campo correo_electronico_cliente es requerido',
            'correo_electronico_cliente.string'      => 'El campo correo_electronico_cliente debe ser una cadena de caracteres',
            'correo_electronico_cliente.max'         => 'El campo correo_electronico_cliente debe tener máximo 255 caracteres',
            'direccion_cliente.required_if'          => 'El campo direccion_cliente es requerido',
            'direccion_cliente.string'               => 'El campo direccion_cliente debe ser una cadena de caracteres',
            'direccion_cliente.max'                  => 'El campo direccion_cliente debe tener máximo 255 caracteres',
            'ciudad_cliente.required_if'             => 'El campo ciudad_cliente es requerido',
            'ciudad_cliente.string'                  => 'El campo ciudad_cliente debe ser una cadena de caracteres',
            'ciudad_cliente.max'                     => 'El campo ciudad_cliente debe tener máximo 255 caracteres',
            'estado_cliente.required_if'             => 'El campo estado_cliente es requerido',
            'estado_cliente.string'                  => 'El campo estado_cliente debe ser una cadena de caracteres',
            'estado_cliente.max'                     => 'El campo estado_cliente debe tener máximo 255 caracteres',
            'codigo_postal_cliente.required_if'      => 'El campo codigo_postal_cliente es requerido',
            'codigo_postal_cliente.string'           => 'El campo codigo_postal_cliente debe ser una cadena de caracteres',
            'codigo_postal_cliente.max'              => 'El campo codigo_postal_cliente debe tener máximo 255 caracteres',
            'nombre_invoice.required'                => 'El campo nombre_invoice es requerido',
            'nombre_invoice.string'                  => 'El campo nombre_invoice debe ser una cadena de caracteres',
            'nombre_invoice.max'                     => 'El campo nombre_invoice debe tener máximo 255 caracteres',
            'numero_invoice.required'                => 'El campo numero_invoice es requerido',
            'numero_invoice.integer'                 => 'El campo numero_invoice debe ser un número entero',
            'fecha_invoice.required'                 => 'El campo fecha_invoice es requerido',
            'fecha_invoice.date'                     => 'El campo fecha_invoice debe ser una fecha',
            'fecha_vencimiento_invoice.required'     => 'El campo fecha_vencimiento_invoice es requerido',
            'fecha_vencimiento_invoice.date'         => 'El campo fecha_vencimiento_invoice debe ser una fecha',
            'comentario_invoice.string'              => 'El campo comentario_invoice debe ser una cadena de caracteres',
            'comentario_invoice.max'                 => 'El campo comentario_invoice debe tener máximo 255 caracteres',
            'subtotal_invoice.required'              => 'El campo subtotal_invoice es requerido',
            'subtotal_invoice.numeric'               => 'El campo subtotal_invoice debe ser un número',
            'impuesto_invoice.required'              => 'El campo impuesto_invoice es requerido',
            'impuesto_invoice.numeric'               => 'El campo impuesto_invoice debe ser un número',
            'total_invoice.required'                 => 'El campo total_invoice es requerido',
            'total_invoice.numeric'                  => 'El campo total_invoice debe ser un número',
            'detalle.required'                       => 'El campo detalle es requerido',
            'detalle.array'                          => 'El campo detalle debe ser un arreglo',
            'detalle.*.nombre_producto.required'     => 'El campo nombre_producto es requerido',
            'detalle.*.nombre_producto.string'       => 'El campo nombre_producto debe ser una cadena de caracteres',
            'detalle.*.nombre_producto.max'          => 'El campo nombre_producto debe tener máximo 255 caracteres',
            'detalle.*.cantidad.required'            => 'El campo cantidad es requerido',
            'detalle.*.cantidad.numeric'             => 'El campo cantidad debe ser un número',
            'detalle.*.precio.required'              => 'El campo precio es requerido',
            'detalle.*.precio.numeric'               => 'El campo precio debe ser un número',
            'activo.boolean'                         => 'El campo activo debe ser un booleano',
        ];
    }
}
