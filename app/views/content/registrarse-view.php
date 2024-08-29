<link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>app/views/css/registrarse.css">

<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >
		<input type="hidden" name="modulo_usuario" value="registrar">
<div class="card" id="tarjeta">
<p class="h3" id="titulo">Registrarse</p>
    <div class="card-body" id="formulario">
<form>
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
    </div>

    <div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">@</span>
    <input type="email" class="form-control" placeholder="Correo" aria-label="Correo" aria-describedby="basic-addon1" name="usuario_email" maxlength="70" required>
    </div>

    <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Contraseña</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
    </div>

    <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Repita la Contraseña</label>
    <input type="password" class="form-control" id="exampleInputPassword2" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
    </div>

    <button type="submit" class="btn btn-primary" id="boton">Registrarse</button>

</form>
    </div>