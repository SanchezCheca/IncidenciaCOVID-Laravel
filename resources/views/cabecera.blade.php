<?php

//Carga los recursos necesarios
use App\Models\Informe;
use App\Models\Region;
use App\Models\Usuario;
?>

<!--Cabecera-->
<nav class = "navbar navbar-expand navbar-light bg-white w-100 rounded-top">
    <a class = "navbar-brand" href = "inicio">
        <img src = "images/logo.png" width = "100" height = "auto" alt = "logo inCOVID">
    </a>
    <div class = "collapse navbar-collapse" id = "navbarNavDropdown">
        <ul class = "navbar-nav">
            <li class = "nav-item">
                <a class = "nav-link" href = "inicio">Informes de incidencia</a>
            </li>
            <?php
            //Muestra el enlace 'Crear informe' si el usuario iniciado es autor
            if (isset($usuarioIniciado) && $usuarioIniciado->isAutor()) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="crearInforme">+Crear informe</a>
                </li>
                <?php
            }
            ?>
        </ul>
        <div class = "dropdown ml-auto">
            <a class = "nav-link dropdown-toggle desplegable" href = "#" id = "navbarDropdownMenuLink" data-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false">
                <?php
                if (isset($usuarioIniciado)) {
                    echo '<i>' . $usuarioIniciado->getNombre() . '</i>';
                } else {
                    echo 'Perfil';
                }
                ?>
            </a>
            <div class = "dropdown-menu" aria-labelledby = "navbarDropdownMenuLink">
                <?php
                if (isset($usuarioIniciado)) {
                    //Ha iniciado sesión, se muestran otras opciones
                    ?>
                    <?php
                    if ($usuarioIniciado->isAdmin()) {
                        ?>
                        <form name="menu" action="administrarUsuarios" method="POST">
                            {{ csrf_field() }}
                            <input type="submit" name="administrarUsuarios" class="dropdown-item" value="Administrar usuarios">
                        </form>
                        <form name="menu" action="administrarRegiones" method="POST">
                            {{ csrf_field() }}
                            <input type="submit" name="administrarRegiones" class="dropdown-item" value="Administrar regiones">
                        </form>
                        <?php
                    }
                    ?>
                    <form action="cerrarSesion" method="POST">
                        {{ csrf_field() }}
                        <input type="submit" name="cerrarSesion" class="dropdown-item" value="Cerrar sesión">
                    </form>
                    <?php
                } else {
                    //No ha iniciado sesión, se muestran la opción de inicio y registro
                    ?>
                    <a class = "dropdown-item" href = "login">Iniciar sesión</a>
                    <a class = "dropdown-item" href = "registro">Crear cuenta</a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<?php
//MUESTRA UN MENSAJE DE ALERTA/ERROR SI LO HUBIERA EN LA SESIÓN
if (isset($mensaje)) {
    ?>
    <div class = "col-12 bg-warning d-flex justify-content-center">
        <?php echo $mensaje; ?>
    </div>
    <?php
}
?>