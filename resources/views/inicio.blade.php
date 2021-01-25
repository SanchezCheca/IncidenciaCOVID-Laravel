<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>Inicio1 - inCOVID</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
              integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>


        <!-- Estilos -->
        <link href="{{ asset('css/misEstilos.css') }}" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="containter d-flex justify-content-center">
            <div class="row principal rounded">

                <!-------------------- CABECERA -------------------->
                <?php

                //Carga las clases necesarias
                use App\Models\Usuario;
                ?>


                <a href="login">Iniciar sesión</a>
                <br>
                <a href="cerrarSesion">Cerrar sesión</a>
                <br>
                <a href="crearInforme">Crear informe</a>
                <br>
                <a href="administrarUsuarios">Administrar usuarios</a>
                <br>
                <?php
                if (isset($mensaje)) {
                    echo $mensaje . '<br>';
                }

                if (isset($usuarioIniciado)) {
                    echo 'Hola, ' . $usuarioIniciado->getNombre() . '<br>';
                    echo 'ID: ' . $usuarioIniciado->getId() . '<br>';
                    if (is_array($usuarioIniciado->getRoles())) {
                        foreach ($usuarioIniciado->getRoles() as $rol) {
                            echo 'Rol de usuario: ' . $rol . '<br>';
                        }
                    } else {
                        echo 'No roles?<br>';
                    }
                }
                ?>





                <?php
                if (isset($_REQUEST['filtrar'])) {
                    $filtroRegion = $_REQUEST['filtroRegion'];
                    $filtroSemana = $_REQUEST['filtroSemana'];

                    $informesFiltrados = null;

                    foreach ($informes as $informe) {
                        if (($informe->getSemana() == $filtroSemana || $filtroSemana == 'TODAS') && ($informe->getRegion() == $filtroRegion || $filtroRegion == 'TODAS')) {
                            $informesFiltrados[] = $informe;
                        }
                    }

                    $informes = $informesFiltrados;
                }
                ?>

                <!-- Filtro -->
                <div class="col-2 mt-4 ml-4">
                    <h5 class="h5">Filtrar por:</h5>
                </div>
                <div class="col-8 mt-4">
                    <form name="filtro" action="index.php" method="POST">
                        <div class="form-group">
                            <label for="filtroRegion">Región: </label>
                            <select class="form-control" name="filtroRegion">
                                <option value="TODAS">TODAS</option>

                            </select>
                            <label for="filtroSemana">Semana: </label>
                            <select class="form-control" name="filtroSemana">
                                <option value="TODAS">TODAS</option>

                            </select>
                        </div>


                </div>
                <div class="col-1 mt-5">
                    <input class="btn btn-dark" type="submit" name="filtrar" value="Aplicar">
                    </form>
                </div>



                <!-- Primera seccion -->
                <div class="col-12 mt-4 ml-4">
                    <h4 class="h4">Datos totales</h4>
                </div>

                <div class="col-12 mt-4 px-4 d-flex justify-content-center">
                    <table class="table table-hover w-75">
                        <thead>
                            <tr>
                                <th scope="col">Infectados</th>
                                <th scope="col">Fallecidos</th>
                                <th scope="col">Altas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Título de la sección -->
                <div class="col-12 mt-4 ml-4">
                    <h4 class="h4">Todos los informes</h4>
                </div>

                <!-- Cuerpo -->
                <div class="col-12 mt-4 px-4 d-flex justify-content-center">
                    <table class="table table-hover w-75">
                        <thead>
                            <tr>
                                <th scope="col">Semana</th>
                                <th scope="col">Región</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>


    </body>
</html>
