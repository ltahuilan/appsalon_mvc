<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">LLena los campos para crear tu cuenta</p>

<?php include_once __DIR__.'/../templates/alertas.php'; ?>

<form method="POST" class="formulario" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Escribe tu nombre" value="<?php echo $usuario->nombre?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" placeholder="Escribe tu Apellido" value="<?php echo $usuario->apellido?>">
    </div>

    <div class="campo">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Escribe tu Teléfono" value="<?php echo $usuario->telefono?>">
    </div>

    <div class="campo">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="Escribe tu E-mail" value="<?php echo $usuario->email?>">
    </div>

    <div class="campo">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Escribe tu Password">
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/olvide-password">Recupera tu contraseña</a>
</div>