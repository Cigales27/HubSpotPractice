<?php

namespace App\Http\Requests\Empresa;

use App\Helpers\ValidatorHelper;
use Illuminate\Foundation\Http\FormRequest;

class CrearEmpresaRequest extends FormRequest
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
            "nombre_empresa"     => ["required", "string", "max:255"],
            "url_sitio_web"      => ["required", "string", "max:255"],
            "numero_empresa"     => ["required", "integer", "max:9999999999"],
            "correo_electronico" => ["required", "email", "max:255"],
            "direccion"          => ["required", "string", "max:255"],
            "ciudad"             => ["required", "string", "max:255"],
            "estado"             => ["required", "string", "max:255"],
            "codigo_postal"      => ["required", "integer", "max:99999"],
            "id_usuario"         => ["required", "integer", "exists:users,id"],
            "logo"               => ["required", "file", "mimes:jpeg,png,jpg", "max:2048"],
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
            "nombre_empresa.required"     => "El nombre de la empresa es requerido",
            "nombre_empresa.string"       => "El nombre de la empresa debe ser una cadena de caracteres",
            "nombre_empresa.max"          => "El nombre de la empresa debe tener máximo 255 caracteres",
            "url_sitio_web.required"      => "La url del sitio web es requerida",
            "url_sitio_web.string"        => "La url del sitio web debe ser una cadena de caracteres",
            "url_sitio_web.max"           => "La url del sitio web debe tener máximo 255 caracteres",
            "numero_empresa.required"     => "El número de la empresa es requerido",
            "numero_empresa.integer"      => "El número de la empresa debe ser un número entero",
            "numero_empresa.max"          => "El número de la empresa debe ser a 10 dígitos",
            "correo_electronico.required" => "El correo electrónico es requerido",
            "correo_electronico.email"    => "El correo electrónico debe ser un correo electrónico válido",
            "correo_electronico.max"       => "El correo electrónico debe tener máximo 255 caracteres",
            "direccion.required"          => "La dirección es requerida",
            "direccion.string"            => "La dirección debe ser una cadena de caracteres",
            "direccion.max"               => "La dirección debe tener máximo 255 caracteres",
            "ciudad.required"             => "La ciudad es requerida",
            "ciudad.string"               => "La ciudad debe ser una cadena de caracteres",
            "ciudad.max"                  => "La ciudad debe tener máximo 255 caracteres",
            "estado.required"             => "El estado es requerido",
            "estado.string"               => "El estado debe ser una cadena de caracteres",
            "estado.max"                  => "El estado debe tener máximo 255 caracteres",
            "codigo_postal.required"      => "El código postal es requerido",
            "codigo_postal.integer"       => "El código postal debe ser un número entero",
            "codigo_postal.max"           => "El código postal debe ser a 5 dígitos",
            "id_usuario.required"         => "El id del usuario es requerido",
            "id_usuario.integer"          => "El id del usuario debe ser un número entero",
            "id_usuario.exists"           => "El id del usuario no existe",
            "logo.required"               => "El logo es requerido",
            "logo.file"                   => "El logo debe ser un archivo",
            "logo.mimes"                  => "El logo debe ser de tipo jpeg, png o jpg",
            "logo.max"                    => "El logo debe tener máximo 2048 kilobytes",
        ];
    }
}
