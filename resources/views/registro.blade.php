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
        <form method="POST" action="formularioRegistro">
             {{ csrf_field() }}
             <input type="text" name="nombre" placeholder="Nombre">
             <br>
             <input type="email" name="correo" placeholder="Correo">
             <br>
             <input type="password" name="pass" placeholder="Contraseña">
             <br>
             <input type="submit" name="registrarUsuario" value="Crear cuenta">
        </form>
    </body>
</html>
