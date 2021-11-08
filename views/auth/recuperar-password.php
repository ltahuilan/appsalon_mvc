
<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Captura tu nuevo password</p>

<?php include __DIR__.'/../templates/alertas.php'; ?>

<?php if (!$error) : ?>

<form method="POST" action="" class="formulario" >
    <div class="campo">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Escribe tu password">
    </div>

    <input type="submit" value="Reestablecer" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>

<?php endif; ?>