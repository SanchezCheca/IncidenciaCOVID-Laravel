<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Informe;
use App\Models\Region;

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

        $datos = $this->cargarDatos();
        $datos += [
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

        //Carga el usuario
        $consulta = \DB::select('SELECT * FROM usuarios WHERE correo=?', [$correo]);
        $passEncriptada = '';
        foreach ($consulta as $r) {
            $id = $r->id;
            $nombre = $r->nombre;
            $passEncriptada = $r->pass;
            $activo = $r->activo;

            $roles = \DB::select('SELECT idRol FROM usuario_rol WHERE idUsuario=?', [$id]);
            $rolesUsuario = [];
            foreach ($roles as $rol) {
                $rolesUsuario[] = $rol->idRol;
            }
        }

        //Comprueba la contraseña y guarda todos los datos
        $datos = $this->cargarDatos();
        if (password_verify($pass, $passEncriptada)) {
            $usuarioIniciado = new Usuario($id, $nombre, $correo, $activo, $rolesUsuario);
            session()->put('usuarioIniciado', $usuarioIniciado);
            $mensaje = 'Has iniciado sesión como ' . $nombre;
            $datos += [
                'usuarioIniciado' => $usuarioIniciado,
                'mensaje' => $mensaje
            ];
        } else {
            $mensaje = 'ERROR: Correo y/o contraseña incorrectos';
            $datos += [
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
        session()->forget('usuarioIniciado');
        $mensaje = 'Has cerrado la sesión';

        $datos = $this->cargarDatos();
        $datos += ['mensaje' => $mensaje];

        Return view('inicio', $datos);
    }
 
    /**
     * Devuelve un vector con los informes registrados y también el usuario iniciado de haberlo
     */
    public function cargarInicio(Request $req) {
        $datos = $this->cargarDatos();
        Return view('inicio', $datos);
    }
    
    //--------------------------------------------------------MÉTODOS PRIVADOS
    /**
     * Carga informes, regiones, semanas y al usuario iniciado (de haberlo)
     */
    private function cargarDatos() {
        //Carga los informes
        $consulta = \DB::select('SELECT * FROM informes');
        $informes = [];
        foreach($consulta as $informe) {
            $id = $informe->id;
            $semana = $informe->semana;
            $consultaRegion = \DB::select('SELECT nombre FROM regiones WHERE id=?', [$informe->region]);
            $region = '';
            foreach($consultaRegion as $posibilidad) {
                $region = $posibilidad->nombre;
            }
            $nInfectados = $informe->nInfectados;
            $nFallecidos = $informe->nFallecidos;
            $nAltas = $informe->nAltas;
            $idAutor = $informe->idautor;
            $informes[] = new Informe($id, $semana, $region, $nInfectados, $nFallecidos, $nAltas, $idAutor);
        }
        
        //Carga las regiones
        $consulta = \DB::select('SELECT * FROM regiones WHERE id IN (SELECT region FROM informes)');
        $regiones = [];
        foreach($consulta as $region) {
            $regiones[] = new Region($region->id, $region->nombre);
        }
        
        //Carga las semanas
        $consulta = \DB::select('SELECT semana FROM informes');
        $semanas = [];
        foreach($consulta as $semana) {
            $semanas[] = $semana->semana;
        }
        
        //Manda datos y devuelve
        $datos = [];
        if (session()->has('usuarioIniciado')) {
            $usu = session()->get('usuarioIniciado');
            $datos = [
                'informes' => $informes,
                'usuarioIniciado' => $usu,
                'regiones' => $regiones,
                'semanas' => $semanas
            ];
        } else {
            $datos = [
                'informes' => $informes,
                'regiones' => $regiones,
                'semanas' => $semanas
            ];
        }
        return $datos;
    }

}
