<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_usuario',
        'nombre_empresa',
        'url_sitio_web',
        'numero_empresa',
        'correo_electronico',
        'url_logo',
        'direccion',
        'ciudad',
        'estado',
        'codigo_postal',
        'activo'
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'id_empresa', 'id');
    }
}
