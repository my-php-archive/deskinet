<?php
if(!defined('admin')) { header('Location: /index.php'); }
?>
Hola mod/admin, bienvenido al panel de administraci&oacute;n.
<br />
Tal vez seas nuevo en el equipo de moderaci&oacute;n de <?=$config['script_name'];?> y necesites ayuda, as&iacute; que aqu&iacute; puedes ver una breve explicaci&oacute;n de lo que encontrar&aacute;s en el panel de administraci&oacute;n.
<br />
<br />
<b>Notas</b>: Las notas son mensajes que se intercambian entre los mod y admin sobre alg&uacute;n cambio, comentario, etc.
<br />
<b>Denuncias</b>: Es la secci&oacute;n que m&aacute;s usar&aacute;s, sin duda. En ella podr&aacute;s leer las denuncias de los usuarios, ver el post denunciado y aceptar o no la denuncia.
<br />
Si aceptas la denuncia, el post ser&aacute; eliminado y a los usuarios se les sumar&aacute;n unos cuantos puntos; o si la rechazas, se les restar&aacute;n ( >:) ), &iexcl;Y todo con un click!
<br />
<b>Configuraci&oacute;n</b>: Solo tienen acceso los administradores, para cambiar la configuraci&oacute;n de la web (No ser&aacute; obvio, &iquest;no?)
<br />
<b>Usuarios</b>: Varias opciones referidas a los usuarios
<ul class="menu_cuenta">
<li><b>Lista de usuarios</b>: Sirve para ver los usuarios registrados, su rango, etc.</li>
<li><b>Dar rango</b>: Sirve para cocinar macarrones con tomate. (Solo para administradores, los moderadores no comen)</li>
<li><b>Lista de baneados</b>: La lista de baneados incluye desde cuando, hasta cuando, por qu&eacute; ha sido baneado, y por quien.</li>
<li><b>Banear</b>: Puedes banear a un usuario, ingresando su nombre o ID. (Tambi&eacute;n puedes hacerlo desde su perfil *)</li>
<li><b>Desbanear</b>: Puedes desbanear a un usuario, ingresando su nombre o ID. (Tambi&eacute;n desde su perfil... *)</li>
</ul>
<br />
<br />
*: Desde el perfil puedes usar el "baneo r&aacute;pido" donde eliges el n&uacute;mero de d&iacute;as y horas de duraci&oacute;n del baneo, en lugar de la fecha final.