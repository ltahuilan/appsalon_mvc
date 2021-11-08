<?php

$descripcion = 'Hemos enviado un mensaje al correo electrónico: "';
$descripcion .= $email;
$descripcion .= '", encontraras instrucciones para confirmar tu cuenta.';

?>

<h1 class="nombre.pagina">Confirma tu cuenta</h1>
<p class="descripcion-pagina"><?php echo $descripcion; ?></p>

<div class="acciones">
    <a href="/">Iniciar Sesión</a>
</div>