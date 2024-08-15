<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>app/views/css/login.css">
    <title>Login</title>
</head>
<body>

    <section class="login-container"> 
        <form action="<?php echo APP_URL; ?>dashboard/" method="post">
            <input type="text" id="correo" placeholder="Correo">
            <br><br>
            <input type="password" id="contraseña" placeholder="Contraseña">
            <br><br>
        <input type="submit" value="Ingresar" id="boton" src="<?php echo APP_URL; ?>dashboard/">
        </form>
    </section>

</body>
</html>

