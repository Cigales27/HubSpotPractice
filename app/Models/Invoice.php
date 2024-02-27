<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_empresa',
        'id_cliente',
        'id_usuario',
        'nombre_invoice',
        'numero_invoice',
        'fecha_invoice',
        'fecha_vencimiento_invoice',
        'comentario_invoice',
        'subtotal_invoice',
        'impuesto_invoice',
        'total_invoice',
        'activo'
    ];
    protected $table    = 'invoices';

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id');
    }

    public function invoiceDetalle()
    {
        return $this->hasMany(InvoiceDetalle::class, 'id_invoice', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }
}
