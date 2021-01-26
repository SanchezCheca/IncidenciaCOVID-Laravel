<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model {

    //--------------------ATRIBUTOS
    private $id;
    private $nombre;

    //--------------------CONSTRUCTOR
    function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    //--------------------GET
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

}
