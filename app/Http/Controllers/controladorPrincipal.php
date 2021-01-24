<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

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

    /**
     * Guarda el usuario en la sesiíon si la combinación correo-pass es correcta
     * @param Request $req
     */
    public function iniciarSesion(Request $req) {
        $usuarioIniciado = null;
        $correo = $req->get('correo');
        $pass = $req->get('pass');

        $consulta = \DB::select('SELECT * FROM usuarios WHERE correo=?', [$correo]);
        $passEncriptada = '';
        foreach ($consulta as $r) {
            $id = $r->id;
            $nombre = $r->nombre;
            $passEncriptada = $r->pass;
            $activo = $r->activo;
        }

        //Comprueba la contraseña
        if (password_verify($pass, $passEncriptada)) {
            $usuarioIniciado = new Usuario($id, $nombre, $correo, $activo);
            session()->put('usuarioIniciado', $usuarioIniciado);
            $mensaje = 'Has iniciado sesión como ' . $nombre;
        } else {
            $mensaje = 'ERROR: Correo y/o contraseña incorrectos';
        }
        $datos = [
            'mensaje' => $mensaje
        ];
        Return view('inicio', $datos);
    }
    
    public function cerrarSesion() {
        session()->remove('usuarioIniciado');
        $mensaje = 'Has cerrado la sesión';
        $datos = [
            'mensaje' => $mensaje
        ];
        Return view('inicio', $datos);
    }

}
