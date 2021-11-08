<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php include __DIR__.'/../templates/alertas.php'; ?>

<form action="/" class="formulario" method="POST">

    <div class="campo">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email">
    </div>

    <div class="campo">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu password">
    </div>

    <input type="submit" value="Iniciar Sesión" class="boton">

</form>

<div class="acciones">
    <a href="/crear-cuenta">¿No tienes una cuenta? Crea una</a>
    <a href="/olvide-password">Recupera tu contraseña</a>
</div>