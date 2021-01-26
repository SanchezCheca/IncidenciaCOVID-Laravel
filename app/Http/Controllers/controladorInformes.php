<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Informe;

class controladorInformes extends Controller {

    /**
     * Carga todas las regiones y devuelve la vista 'crearInforme'
     * Si y sólo si el usuario ha iniciado sesión y es Autor
     */
    public function irACrearInforme() {
        if (session()->has('usuarioIniciado')) {
            $usu = session()->get('usuarioIniciado');

            if ($usu->isAutor()) {
                $regiones = $this->cargarRegiones();
                $datos = [
                    'regiones' => $regiones
                ];
                Return view('crearInforme', $datos);
            } else {
                $datos = [
                    'mensaje' => 'No tienes permiso para acceder a esa página',
                    'usuarioIniciado' => $usu
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

    /**
     * Crea un nuevo informe
     * @param Request $req
     */
    public function crearInforme(Request $req) {
        if (session()->has('usuarioIniciado')) {
            $usu = session()->get('usuarioIniciado');

            $semana = $req->get('semana');
            $region = $req->get('region');
            $nInfectados = $req->get('nInfectados');
            $nFallecidos = $req->get('nFallecidos');
            $nAltas = $req->get('nAltas');

            if (!$this->existeInforme($semana, $region)) {

                \DB::insert('INSERT INTO informes VALUES(id,?,?,?,?,?,?)', [$semana, $region, $nInfectados, $nFallecidos, $nAltas, $usu->getId()]);

                $mensaje = 'Se ha creado un nuevo informe para la semana [' . $semana . '] y la región "' . $region . '".';
                $regiones = $this->cargarRegiones();
                $datos = [
                    'mensaje' => $mensaje,
                    'regiones' => $regiones
                ];
                Return view('crearInforme', $datos);
            } else {
                $mensaje = 'ERROR: Ya existe un informe para esa semana y región.';
                $regiones = $this->cargarRegiones();
                $datos = [
                    'regiones' => $regiones,
                    'mensaje' => $mensaje
                ];
                Return view('crearInforme', $datos);
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
     * Carga el informe en cuestión y el NOMBRE de su autor
     */
    public function verInforme(Request $req) {
        $id = $req->get('id');
        $datos = $this->cargarParaVerInforme($id);
        Return view('verInforme', $datos);
    }
    
    /**
     * Actualiza los datos de un informe
     * @param Request $req
     */
    public function editarInforme(Request $req) {
        $id = $req->get('id');
        $nInfectados = $req->get('nInfectados');
        $nFallecidos = $req->get('nFallecidos');
        $nAltas = $req->get('nAltas');
        
        \DB::update('UPDATE informes SET nInfectados=?, nFallecidos=?, nAltas=? WHERE id=?', [$nInfectados, $nFallecidos, $nAltas, $id]);
        $mensaje = 'Se ha actualizado el informe con id ' . $id;
        $datos = $this->cargarParaVerInforme($id);
        $datos += [
            'mensaje' => $mensaje
        ];
        Return view('verInforme', $datos);
    }

    //--------------------------------------------------MÉTODOS PRIVADOS
    private function cargarParaVerInforme($id) {
        //Recupera el informe completo
        $consulta = \DB::select('SELECT * FROM informes WHERE id=?', [$id]);
        $informe;
        foreach ($consulta as $datos) {
            $semana = $datos->semana;
            $idRegion = $datos->region;
            $nInfectados = $datos->nInfectados;
            $nFallecidos = $datos->nFallecidos;
            $nAltas = $datos->nAltas;
            $idAutor = $datos->idautor;
            
            //Recupera el nombre de la región
            $consultaNombreRegion = \DB::select('SELECT nombre FROM regiones WHERE id=?', [$idRegion]);
            $nombreRegion;
            $nombreRegion = $consultaNombreRegion[0]->nombre;
            
            $informe = new Informe($id, $semana, $nombreRegion, $nInfectados, $nFallecidos, $nAltas, $idAutor);
        }
        
        //Recupera el nombre del autor
        $nombreAutor;
        $consulta = \DB::select('SELECT nombre FROM usuarios WHERE id IN (SELECT idautor FROM informes WHERE id=?)', [$id]);
        foreach ($consulta as $nombre) {
            $nombreAutor = $nombre->nombre;
        }
        
        $datos = [
            'informe' => $informe,
            'nombreAutor' => $nombreAutor
        ];
        
        if (session()->has('usuarioIniciado')) {
            $usuarioIniciado = session()->get('usuarioIniciado');
            $datos += ['usuarioIniciado' => $usuarioIniciado];
        }
        return $datos;
    }
    
    private function cargarRegiones() {
        $consulta = \DB::select('SELECT * FROM regiones');
        $regiones = [];
        foreach ($consulta as $region) {
            $id = $region->id;
            $nombre = $region->nombre;
            $regiones[] = new Region($id, $nombre);
        }
        return $regiones;
    }

    /**
     * Devuelve true si ya existe un informe para esa semana y región
     * @param type $semana
     * @param type $region
     */
    private function existeInforme($semana, $idRegion) {
        $existe = false;
        $consulta = \DB::select('SELECT * FROM informes WHERE semana=? AND region=?', [$semana, $idRegion]);
        foreach ($consulta as $dato) {
            $existe = true;
        }
        return $existe;
    }

}
