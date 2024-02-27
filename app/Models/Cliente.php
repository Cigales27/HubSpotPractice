<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre_cliente',
        'numero_cliente',
        'correo_electronico',
        'direccion',
        'ciudad',
        'estado',
        'codigo_postal',
        'id_empresa',
        'activo'
    ];
    protected $table    = 'clientes';

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}
