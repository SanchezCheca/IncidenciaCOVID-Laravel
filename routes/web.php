<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controladorPrincipal;
use App\Http\Controllers\controladorCRUD;
use App\Http\Controllers\controladorInformes;
/*
Route::get('/', function () {
    return view('inicio');
});
*/
Route::get('/', [controladorPrincipal::class, 'cargarInicio']);

Route::post('inicio', [controladorPrincipal::class, 'cargarInicio']);

Route::get('registro', function () {
    return view('registro');
});

Route::get('login', function () {
    return view('inicioSesion');
});

Route::get('inicio', [controladorPrincipal::class, 'cargarInicio']);

Route::get('cerrarSesion', [controladorPrincipal::class, 'cerrarSesion']);

Route::post('cerrarSesion', [controladorPrincipal::class, 'cerrarSesion']);

Route::post('formularioRegistro', [controladorPrincipal::class, 'registrarCuenta']);

Route::post('inicioSesion', [controladorPrincipal::class, 'iniciarSesion']);


//-----INFORMES
Route::get('crearInforme', [controladorInformes::class, 'irACrearInforme']);

Route::post('formularioNuevoInforme', [controladorInformes::class, 'crearInforme']);

Route::post('verInforme', [controladorInformes::class, 'verInforme']);

Route::get('verInforme', [controladorInformes::class, 'verInforme']);

Route::post('editarInforme', [controladorInformes::class, 'editarInforme']);

//-----USUARIOS
Route::get('administrarUsuarios', [controladorCRUD::class, 'irAAdministrarUsuarios']);

Route::post('administrarUsuarios', [controladorCRUD::class, 'irAAdministrarUsuarios']);

Route::post('actualizarUsuario', [App\Http\Controllers\controladorCRUD::class, 'actualizarUsuario']);

//----REGIONES
Route::get('administrarRegiones', [controladorCRUD::class, 'irAAdministrarRegiones']);

Route::post('administrarRegiones', [controladorCRUD::class, 'irAAdministrarRegiones']);

Route::post('actualizarRegion', [controladorCRUD::class, 'actualizarRegion']);

Route::post('crearRegion', [controladorCRUD::class, 'crearRegion']);
