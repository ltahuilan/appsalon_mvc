
<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Recupera tu password escribiendo el correo electrónico asociado con tu cuenta</p>

<?php include __DIR__.'/../templates/alertas.php'; ?>

<form method="POST" action="olvide-password" class="formulario" >
    <div class="campo">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Escribe tu email">
    </div>

    <input type="submit" value="Enviar instrucciones" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>