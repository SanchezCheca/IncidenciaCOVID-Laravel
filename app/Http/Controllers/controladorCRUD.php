<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Region;

class controladorCRUD extends Controller {
    //------------------------------ ADMINISTRACIÓN DE USUARIOS

    /**
     * Carga todos los usuarios y los manda a la vista 'crud'
     */
    public function irAAdministrarUsuarios() {
        if (session()->has('usuarioIniciado')) {
            $usu = session()->get('usuarioIniciado');

            if ($usu->isAdmin()) {
                $conj_usuarios = $this->getAllUsers();
                $datos = [
                    'conj_usuarios' => $conj_usuarios,
                    'usuarioIniciado' => $usu
                ];
                Return view('crud', $datos);
            } else {
                $mensaje = 'No tienes permiso para acceder a esta página';
                $datos = [
                    'mensaje' => $mensaje
                ];
                Return view('inicio', $datos);
            }
        } else {
            $mensaje = 'Ha ocurrido algún error.';
            $datos = [
                'mensaje' => $mensaje
            ];
            Return view('inicio', $datos);
        }
    }

    /**
     * Actualiza los datos de un usuario
     * @param Request $req
     */
    public function actualizarUsuario(Request $req) {
        if ($req->has('actualizarUsuario')) {
            /**
             * ACTUALIZA LOS DATOS DE UN USUARIO
             */
            if (session()->has('usuarioIniciado')) {
                $usu = session()->get('usuarioIniciado');

                $id = $req->get('id');
                $nombre = $req->get('nombre');
                $correo = $req->get('correo');

                $admin = false;
                if ($req->has('admin')) {
                    $admin = true;
                }

                $autor = false;
                if ($req->has('autor')) {
                    $autor = true;
                }

                $activo = 0;
                if ($req->has('activo')) {
                    $activo = 1;
                }

                $rolesUsuario = $this->getRolesUsuario($id);
                //Comprueba si es administrador (rol 1)
                $esAdmin = false;
                foreach ($rolesUsuario as $rol) {
                    if ($rol == 1) {
                        $esAdmin = true;
                    }
                }

                //Comprueba si es autor (rol 0)
                $esAutor = false;
                foreach ($rolesUsuario as $rol) {
                    if ($rol == 0) {
                        $esAutor = true;
                    }
                }

                //Comprueba si se ha cambiado el correo del usuario que se está modificando y no se ha repetido en la BD
                if ($this->getCorreoById($id) != $correo && $this->isUsuarioByCorreo($correo)) {
                    $conj_usuarios = $this->getAllUsers();
                    $mensaje = 'ERROR: Este correo ya está siendo utilizado';
                    $datos = [
                        'conj_usuarios' => $conj_usuarios,
                        'mensaje' => $mensaje
                    ];
                    Return view('crud', $datos);
                } else {
                    //Elimina o inserta el rol 1 (administrador)
                    if ($esAdmin && !$admin) {
                        \DB::delete('DELETE FROM usuario_rol WHERE idUsuario=? AND idRol=?', [$id, 1]);
                    } else if (!$esAdmin && $admin) {
                        \DB::insert('INSERT INTO usuario_rol VALUES(?,?)', [$id, 1]);
                    }

                    //Elimina o inserta el rol 0 (autor)
                    if ($esAutor && !$autor) {
                        \DB::delete('DELETE FROM usuario_rol WHERE idUsuario=? AND idRol=?', [$id, 0]);
                    } else if (!$esAutor && $autor) {
                        \DB::insert('INSERT INTO usuario_rol VALUES(?,?)', [$id, 1]);
                    }

                    //Actualiza los datos del usuario
                    \DB::update('UPDATE usuarios SET nombre=?, correo=?, activo=? WHERE id=?', [$nombre, $correo, $activo, $id]);

                    $mensaje = 'Se ha actualizado el usuario con id "' . $id . '".';
                    $conj_usuarios = $this->getAllUsers();
                    $datos = [
                        'mensaje' => $mensaje,
                        'conj_usuarios' => $conj_usuarios
                    ];
                    Return view('crud', $datos);
                }
            } else {
                $mensaje = 'Ha ocurrido algún error, vuelve a iniciar sesión';
                $datos = [
                    'mensaje' => $mensaje
                ];
                Return view('inicio', $datos);
            }
        } else if ($req->has('eliminarUsuario')) {
            /**
             * ELIMINA UN USUARIO
             */
            $id = $req->get('id');
            \DB::delete('DELETE FROM usuarios WHERE id=?', [$id]);
            $mensaje = 'Se ha eliminado al usuario con id ' . $id;
            $conj_usuarios = $this->getAllUsers();
            $datos = [
                'mensaje' => $mensaje,
                'conj_usuarios' => $conj_usuarios
            ];
            Return view('crud', $datos);
        } else {
            $mensaje = 'Ha ocurrido algún error (500)';
            $conj_usuarios = $this->getAllUsers();
            $datos = [
                'mensaje' => $mensaje,
                'conj_usuarios' => $conj_usuarios
            ];
            Return view('crud', $datos);
        }
    }

    //------------------------------ ADMINISTRACIÓN DE REGIONES

    /**
     * Carga todas las regiones y va a la vista 'regiones'
     */
    public function irAAdministrarRegiones() {
        if (session()->has('usuarioIniciado')) {
            $usu = session()->get('usuarioIniciado');
            if ($usu->isAdmin()) {
                $regiones = $this->getAllRegiones();
                $datos = [
                    'regiones' => $regiones,
                    'usuarioIniciado' => $usu
                ];
                Return view('regiones', $datos);
            } else {
                $mensaje = 'No tienes permiso para acceder aqui';
                $datos = [
                    'mensaje' => $mensaje
                ];
                Return view('inicio', $datos);
            }
        } else {
            $mensaje = 'Ha ocurrido alǵun error';
            $datos = [
                'mensaje' => $mensaje
            ];
            Return view('inicio', $datos);
        }
    }

    /**
     * Crea una región
     * @param Request $req
     */
    public function crearRegion(Request $req) {
        $nombre = $req->get('nombre');
        \DB::insert('INSERT INTO regiones VALUES(id, ?)', [$nombre]);
        $mensaje = 'Se ha insertado la región "' . $nombre . '".';
        $regiones = $this->getAllRegiones();
        $datos = [
            'mensaje' => $mensaje,
            'regiones' => $regiones
        ];
        Return view('regiones', $datos);
    }

    /**
     * Actualiza o elimina una región
     * @param Request $req
     */
    public function actualizarRegion(Request $req) {
        if ($req->has('actualizarRegion')) {
            $id = $req->get('id');
            $nombre = $req->get('nombre');
            \DB::update('UPDATE regiones SET nombre=? WHERE id=?', [$nombre, $id]);
            
            $mensaje = 'Se ha actualizado la región "' . $nombre . '"';
            $regiones = $this->getAllRegiones();
            $datos = [
                'mensaje' => $mensaje,
                'regiones' => $regiones
            ];
            Return view('regiones', $datos);
        } else if ($req->has('eliminarRegion')) {
            $id = $req->get('id');
            \DB::delete('DELETE FROM regiones WHERE id=?', [$id]);
            \DB::update('UPDATE informes SET region=0 WHERE region=?', [$id]);
            $mensaje = 'Se ha ELIMINADO la región';
            $regiones = $this->getAllRegiones();
            $datos = [
                'mensaje' => $mensaje,
                'regiones' => $regiones
            ];
            Return view('regiones', $datos);
        } else {
            $mensaje = 'Ha ocurrido alǵun error';
            $datos = [
                'mensaje' => $mensaje
            ];
            Return view('inicio', $datos);
        }
    }

    //------------------------------------------------------ MÉTODOS PRIVADOS

    /**
     * Devuelve todos los usuarios
     */
    private function getAllUsers() {
        $consulta = \DB::select('SELECT * FROM usuarios');
        $usuarios = [];
        foreach ($consulta as $usuario) {
            $id = $usuario->id;
            $nombre = $usuario->nombre;
            $correo = $usuario->correo;
            $activo = $usuario->activo;

            $consultaRoles = \DB::select('SELECT idRol FROM usuario_rol WHERE idUsuario=?', [$id]);
            $rolesUsuario = [];
            foreach ($consultaRoles as $rol) {
                $rolesUsuario[] = $rol->idRol;
            }

            $usuarios[] = new Usuario($id, $nombre, $correo, $activo, $rolesUsuario);
        }
        return $usuarios;
    }

    /**
     * Devuelve un array con los roles de un usuario dado
     * @param type $idUsuario
     */
    private function getRolesUsuario($idUsuario) {
        $roles = \DB::select('SELECT idRol FROM usuario_rol WHERE idUsuario=?', [$idUsuario]);
        $rolesUsuario = [];
        foreach ($roles as $rol) {
            $rolesUsuario[] = $rol->idRol;
        }
        return $rolesUsuario;
    }

    /**
     * Devuelve true si existe un usuario con ese correo en BD
     * @param type $correo
     */
    private function isUsuarioByCorreo($correo) {
        $consulta = \DB::select('SELECT * FROM usuarios WHERE correo=?', [$correo]);
        $existe = false;
        if (is_array($consulta)) {
            $existe = true;
        }
        return $existe;
    }

    /**
     * Recoge el correo de un usuario definido por su id
     * @param type $id
     */
    private function getCorreoById($id) {
        $consulta = \DB::select('SELECT correo FROM usuarios WHERE id=?', [$id]);
        $correo = '';
        foreach ($consulta as $datos) {
            $correo = $datos->correo;
        }
        return $correo;
    }

    /**
     * Devuelve todas las regiones
     */
    private function getAllRegiones() {
        $consulta = \DB::select('SELECT * FROM regiones');
        $regiones = [];
        foreach ($consulta as $region) {
            $regiones[] = new Region($region->id, $region->nombre);
        }
        return $regiones;
    }

}
