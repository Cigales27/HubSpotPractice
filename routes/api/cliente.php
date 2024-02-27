<?php

/**
 * ---------------------------------------------------------------------------
 * Rutas de "Cliente"
 *
 * @api {{host}}/api/cliente
 * ---------------------------------------------------------------------------
 */

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/crear_cliente', [ClienteController::class, 'crearCliente']);
    Route::get('/obtener_clientes', [ClienteController::class, 'obtenerClientes']);
    Route::get('/obtener_cliente/{id}', [ClienteController::class, 'obtenerClientePorId']);
    Route::post('/actualizar_cliente', [ClienteController::class, 'actualizarCliente']);
    Route::delete('/eliminar_cliente/{id}', [ClienteController::class, 'eliminarCliente']);
    Route::delete('/eliminar_cliente_permanentemente/{id}', [ClienteController::class, 'eliminarClientePermanente']);
    Route::put('/reactivar/{id}', [ClienteController::class, 'reactivarCliente']);
});
