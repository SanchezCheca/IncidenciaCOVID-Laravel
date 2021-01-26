<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>Crear informe - inCOVID</title>

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
        <div class="container-fluid d-flex justify-content-center">
            <div class="row principal rounded">
                <?php
                use App\Models\Informe;
                //Comprueba si se está editando el informe para mostrar la vista adecuada
                if (isset($_REQUEST['editarInforme'])) {
                    ?>
                    <!-- Título de la sección -->
                    <div class="col-12 mt-4 ml-4">
                        <h3 class="h3">Editar informe</h3>
                    </div>

                    <!-- Cuerpo -->
                    <div class="col-12 mt-4 px-4 d-flex justify-content-center">
                        <table class="table table-hover" style="text-align: center">
                            <thead>
                                <tr>
                                    <th scope="col">Semana</th>
                                    <th scope="col">Región</th>
                                    <th scope="col">Nº de infectados</th>
                                    <th scope="col">Nº de fallecidos</th>
                                    <th scope="col">Nº de altas</th>
                                    <th colspan="2" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <form name="editarInforme" action="editarInforme" method="POST">
                                {{ csrf_field() }}
                                <?php
                                if (isset($informe) && isset($nombreAutor)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $informe->getSemana(); ?></td>
                                        <td><?php echo $informe->getRegion(); ?></td>
                                        <td><input type="number" name="nInfectados" value="<?php echo $informe->getNInfectados(); ?>"></td>
                                        <td><input type="number" name="nFallecidos" value="<?php echo $informe->getNFallecidos(); ?>"></td>
                                        <td><input type="number" name="nAltas" value="<?php echo $informe->getNAltas(); ?>"></td>
                                    <input type="hidden" name="id" value="<?php echo $informe->getId(); ?>">
                                    <td><input type="submit" name="actualizarInforme" value="Guardar" class="btn btn-success"></td>
                                </form>
                                <td><a href="inicio"><button class="btn btn-warning">Cancelar</button></a></td>
                                </tr>
                                <?php
                            } else {
                                echo 'Ha ocurrido algún error al cargar el informe.<br>';
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    ?>
                    <!-- Título de la sección -->
                    <div class="col-12 mt-4 ml-4">
                        <h3 class="h3">Ver informe</h3>
                    </div>

                    <!-- Cuerpo -->
                    <div class="col-12 mt-4 px-4 d-flex justify-content-center">
                        <table class="table table-hover w-75" style="text-align: center">
                            <thead>
                                <tr>
                                    <th scope="col">Semana</th>
                                    <th scope="col">Región</th>
                                    <th scope="col">Nº de infectados</th>
                                    <th scope="col">Nº de fallecidos</th>
                                    <th scope="col">Nº de altas</th>
                                    <th scope="col">Autor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($informe) && isset($nombreAutor)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $informe->getSemana(); ?></td>
                                        <td><?php echo $informe->getRegion(); ?></td>
                                        <td><?php echo $informe->getNInfectados(); ?></td>
                                        <td><?php echo $informe->getNFallecidos(); ?></td>
                                        <td><?php echo $informe->getNAltas(); ?></td>
                                        <td><?php echo $nombreAutor; ?></td>
                                    </tr>
                                    <?php
                                } else {
                                    echo 'Ha ocurrido algún error al cargar el informe.<br>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    //Si el usuario iniciado es autor da la opción de editar
                    if (isset($usuarioIniciado) && $usuarioIniciado->isAutor()) {
                        ?>
                        <div class="col-12 d-flex justify-content-center">
                            <form name="editar" action="verInforme" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="<?php echo $informe->getId(); ?>">
                                <input type="submit" class="btn btn-secondary" name="editarInforme" value="EDITAR">
                            </form>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>
                    
            </div>
        </div>        
    </body>
</html>
