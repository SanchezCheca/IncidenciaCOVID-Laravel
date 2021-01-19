<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

Route::get('iniciarSesion', function () {
    return view('iniciarSesion');
});
