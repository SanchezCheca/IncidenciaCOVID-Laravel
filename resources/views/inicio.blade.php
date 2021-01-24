<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body>
        <?php
        use App\Models\Usuario;
        ?>
        
        <?php
        echo 'Hola!';

        if (isset($mensaje)) {
            echo '<br>' . $mensaje . '<br>';
        }

        if (session()->get('usuarioIniciado') != null) {
            $usuarioIniciado = session()->get('usuarioIniciado');
            echo '<br>Recogido de sesión: ' . $usuarioIniciado->getNombre() . '<br>';
        }
        ?>
        <a href="registro">Registrarse</a>
        <br>
        <a href="login">Iniciar sesión</a>
        <br>
        <a href="cerrarSesion">Cerrar sesión</a>
    </body>
</html>
