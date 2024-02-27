<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/iniciar_sesion', function () {
    return view('login');
})->name('login');
Route::get('/cerrar_sesion', [AuthController::class, 'logout'])->name('cerrar-sesion');
Route::get('/inicia_sesion', [AuthController::class, 'iniciar_sesion'])->name('inicia-sesion');
Route::get('/registrar', [AuthController::class, 'registrar_vista'])->name('registrar_vista');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/empresas', [EmpresaController::class, 'empresas'])->name('empresas');
    Route::get('/clientes', [ClienteController::class, 'clientes'])->name('clientes');
    Route::get('/facturas', [InvoiceController::class, 'facturas'])->name('facturas');
    Route::get('/crear_facturas', [InvoiceController::class, 'crear_factura'])->name('crear_factura');
    Route::get('/editar_facturas/{id}', [InvoiceController::class, 'editar_factura'])->name('editar_factura');
});
