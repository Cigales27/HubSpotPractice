<?php

/**
 * ---------------------------------------------------------------------------
 * Rutas de "Invoice"
 *
 * @api {{host}}/api/invoice
 * ---------------------------------------------------------------------------
 */

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/crear_factura', [InvoiceController::class, 'crearFactura']);
    Route::get('/obtener_facturas', [InvoiceController::class, 'obtenerFacturas']);
    Route::get('/obtener_factura/{id}', [InvoiceController::class, 'obtenerFacturaPorId']);
    Route::post('/actualizar_factura', [InvoiceController::class, 'actualizarFactura']);
    Route::delete('/eliminar_factura/{id}', [InvoiceController::class, 'eliminarFactura']);
    Route::delete('/eliminar_factura_permanentemente/{id}', [InvoiceController::class, 'eliminarFacturaPermanente']);
    Route::put('/reactivar/{id}', [InvoiceController::class, 'reactivarFactura']);
});
