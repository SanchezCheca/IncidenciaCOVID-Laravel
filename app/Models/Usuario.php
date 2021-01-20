<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {

    //--------------------ATRIBUTOS
    private $id;
    private $semana;
    private $region;
    private $nInfectados;
    private $nFallecidos;
    private $nAltas;
    private $idAutor;

    //--------------------CONSTRUCTOR
    function __construct($timestamps, $semana, $region, $nInfectados, $nFallecidos, $nAltas, $idAutor) {
        $this->timestamps = $timestamps;
        $this->semana = $semana;
        $this->region = $region;
        $this->nInfectados = $nInfectados;
        $this->nFallecidos = $nFallecidos;
        $this->nAltas = $nAltas;
        $this->idAutor = $idAutor;
    }
    
    //--------------------GETTER
    function getTimestamps() {
        return $this->timestamps;
    }

    function getSemana() {
        return $this->semana;
    }

    function getRegion() {
        return $this->region;
    }

    function getNInfectados() {
        return $this->nInfectados;
    }

    function getNFallecidos() {
        return $this->nFallecidos;
    }

    function getNAltas() {
        return $this->nAltas;
    }

    function getIdAutor() {
        return $this->idAutor;
    }    

}
