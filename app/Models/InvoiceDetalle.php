<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_invoice',
        'nombre_producto',
        'cantidad',
        'precio',
        'activo'
    ];
    protected $table    = 'invoices_detalle';

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice', 'id');
    }


}
