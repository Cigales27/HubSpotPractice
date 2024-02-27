<?php

/**
 * ---------------------------------------------------------------------------
 * Rutas de "Empresa"
 *
 * @api {{host}}/api/empresa
 * ---------------------------------------------------------------------------
 */

use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/crear_empresa', [EmpresaController::class, 'crearEmpresa']);
    Route::get('/obtener_empresas', [EmpresaController::class, 'obtenerEmpresas']);
    Route::get('/obtener_empresa/{id}', [EmpresaController::class, 'obtenerEmpresaPorId']);
    Route::post('/actualizar_empresa', [EmpresaController::class, 'actualizarEmpresa']);
    Route::delete('/eliminar_empresa/{id}', [EmpresaController::class, 'eliminarEmpresa']);
    Route::delete('/eliminar_empresa_permanentemente/{id}', [EmpresaController::class, 'eliminarEmpresaPermanente']);
    Route::put('/reactivar/{id}', [EmpresaController::class, 'reactivarEmpresa']);
});
