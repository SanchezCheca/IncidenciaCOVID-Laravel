<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    private $id;
    private $nombre;
    private $correo;
    private $activo;
    
    function __construct($id, $nombre, $correo, $activo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->activo = $activo;
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
