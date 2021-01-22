<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controladorPrincipal;

Route::get('/', function () {
    return view('inicio');
});

Route::get('registro', function () {
    return view('registro');
});

Route::post('formularioRegistro',[controladorPrincipal::class, 'registrarCuenta']);
