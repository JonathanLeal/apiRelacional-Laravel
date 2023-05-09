<?php

use App\Http\Controllers\BodegaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/productos/list', [ProductoController::class, 'obtenerProductos']);
Route::get('/productos/list/{id_productos}', [ProductoController::class, 'obtenerProductosId']);
Route::post('/productos/save', [ProductoController::class, 'guardarProducto']);
Route::post('/productos/update/{id_productos}', [ProductoController::class, 'editarProducto']);
Route::delete('/productos/delete/{id_productos}', [ProductoController::class, 'eliminarProducto']);
Route::post('/bodegas/save', [BodegaController::class, 'guardarProductosEnBodega']);
Route::get('/productosEnbodega/list/{nombre_bo}', [BodegaController::class, 'obtenerProductosPorNombreBodega']);