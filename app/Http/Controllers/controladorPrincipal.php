<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Informe;
use App\Models\Region;

class controladorPrincipal extends Controller {

    /**
     * Lleva a la vista inicio con la información del usuario iniciado de haberla
     */
    public function inicio() {
        if (session()->has('usuarioIniciado')) {
            $usuarioIniciado = session()->get('usuarioIniciado');
        }
        $datos = [
            'usuarioIniciado' => $usuarioIniciado
        ];
        Return view('inicio', $datos);
    }

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

            $roles = \DB::select('SELECT idRol FROM usuario_rol WHERE idUsuario=?', [$id]);
            $rolesUsuario = null;
            foreach ($roles as $rol) {
                $rolesUsuario[] = $rol->idRol;
            }
        }

        //Comprueba la contraseña
        if (password_verify($pass, $passEncriptada)) {
            $usuarioIniciado = new Usuario($id, $nombre, $correo, $activo, $rolesUsuario);
            session()->put('usuarioIniciado', $usuarioIniciado);
            $mensaje = 'Has iniciado sesión como ' . $nombre;
            $datos = [
                'usuarioIniciado' => $usuarioIniciado,
                'mensaje' => $mensaje
            ];
        } else {
            $mensaje = 'ERROR: Correo y/o contraseña incorrectos';
            $datos = [
                'mensaje' => $mensaje
            ];
        }

        Return view('inicio', $datos);
    }

    /**
     * Cierra la sesión
     * @return type
     */
    public function cerrarSesion() {
        session()->remove('usuarioIniciado');
        $mensaje = 'Has cerrado la sesión';

        $datos = [
            'mensaje' => $mensaje
        ];

        Return view('inicio', $datos);
    }

    /**
     * Carga todas las regiones y devuelve la vista 'crearInforme'
     * Si y sólo si el usuario ha iniciado sesión y es Autor
     */
    public function irACrearInforme() {
        if (session()->has('usuarioIniciado')) {
            $usu = session()->get('usuarioIniciado');
            if ($usu->isAutor()) {
                $consulta = \DB::select('SELECT * FROM informes');
                $regiones = [];
                foreach ($consulta as $region) {
                    $id = $region->id;
                    $nombre = $region->nombre;
                    $regiones[] = new Region($id, $nombre);
                }
                $datos = [
                    'regiones' => $regiones
                ];
                Return view('crearInforme', $datos);
            } else {
                $datos = [
                    'mensaje' => 'No tienes permiso para acceder a esa página'
                ];
                Return view('inicio', $datos);
            }
        } else {
            $datos = [
                'mensaje' => 'Ha ocurrido algún error'
            ];
            Return view('inicio', $datos);
        }
    }

}
