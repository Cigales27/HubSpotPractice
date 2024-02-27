<?php

/**
 * ---------------------------------------------------------------------------
 * Rutas de "Auth"
 *
 * @api {{host}}/api/auth
 * ---------------------------------------------------------------------------
 */

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/registrar_usuario', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);
