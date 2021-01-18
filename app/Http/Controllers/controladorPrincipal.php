<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class controladorPrincipal extends Controller {

    public function inicioSesion(Request $req) {
        $correo = $req->get('correo');
        $pass = $req->get('pass');
        
    }

}
