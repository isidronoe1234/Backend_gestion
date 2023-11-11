<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgremiadoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SolicituController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rutas para los metodos HTTP para la tabla de Agremiados
Route::controller(AgremiadoController::class)->group(function(){
    Route::post('newAgremiado','newAgremiado');
    Route::get('Agremiados','getAgremiados');
    Route::get('Agremiado/{id}','getAgremiadoById');
    //Route::delete('eliminarCategoria/{id}','deleteCategoryById');
});

//Rutas para el login
Route::controller(UserController::class)->group(function(){
    Route::post('loginUser','login');
});

//Rutas para los metodos HTTP para la tabla de Solicitudes
Route::controller(SolicituController::class)->group(function(){
    Route::post('newSolicitud','newSolicitud');
    Route::get('Solicitudes','getSolicitudes');
    Route::get('Solicitud/{NUE}','getSolicitudByNUE');
    Route::get('dowlandArchivo/{ruta_archivo}','getArchivo');
});