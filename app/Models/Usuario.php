<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {

    //--------------------ATRIBUTOS
    private $id;
    private $nombre;
    private $correo;
    private $activo;
    private $roles;

    //--------------------CONSTRUCTOR
    function __construct($id, $nombre, $correo, $activo, $roles) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->activo = $activo;
        $this->x = $roles;
    }

    //--------------------MÉTODOS PÚBLICOS

    /**
     * Devuelve true si el usuario contiene '1' entre sus roles
     */
    public function isAdmin() {
        $resultado = false;
        foreach ($this->roles as $valor) {
            if ($valor == 1) {
                $resultado = true;
            }
        }
        return $resultado;
    }

    /**
     * Devuelve true si el usuario contiene '0' entre sus roles
     */
    public function isAutor() {
        $resultado = false;
        if (is_array($this->roles)) {
            foreach ($this->roles as $rol) {
                if ($rol == 0) {
                    $resultado = true;
                }
            }
        }
        return $resultado;
    }

    //--------------------GETTERs
    function getRoles() {
        return $this->roles;
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getActivo() {
        return $this->activo;
    }

}
