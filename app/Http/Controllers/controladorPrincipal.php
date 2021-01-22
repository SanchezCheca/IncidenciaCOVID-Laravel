<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class controladorPrincipal extends Controller {

    /**
     * Inserta una cuenta
     * @param Request $req
     * @return type
     */
    public function registrarCuenta(Request $req) {
        $nombre = $req->get('nombre');
        $correo = $req->get('correo');
        $pass = $req->get('pass');
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $activo = 0;
        
        \DB::insert('INSERT INTO usuarios VALUES(id,?,?,?,?)', [$nombre, $correo, $pass, $activo]);
        
        $datos = [
            'mensaje' => 'Se ha insertado un usuario'
        ];
        
        Return view('inicio', $datos);
    }
    
    public function iniciarSesion(Request $req) {
        $correo = $req->get('correo');
        $pass = $req->get('pass');
        
        //\DB::select('SELECT * FROM usuarios WHERE correo=?')
    }

}
