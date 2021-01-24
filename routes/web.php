<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controladorPrincipal;

Route::get('/', function () {
    return view('inicio');
});

Route::get('registro', function () {
    return view('registro');
});

Route::get('login', function () {
    return view('inicioSesion');
});

Route::get('inicio', [controladorPrincipal::class, 'inicio']);

Route::get('cerrarSesion', [controladorPrincipal::class, 'cerrarSesion']);

Route::post('formularioRegistro',[controladorPrincipal::class, 'registrarCuenta']);

Route::post('inicioSesion', [controladorPrincipal::class, 'iniciarSesion']);

Route::get('crearInforme', [controladorPrincipal::class, 'irACrearInforme']);