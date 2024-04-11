<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
?>
<div id="cuerpocontainer">
<div class="post-denunciado">
	<h3>Oops! El Post se encuentra en revisi&oacute;n por acumulaci&oacute;n de denuncias</h3>
	Pero no pierdas las esperanzas, no todo esta perdido, la soluci&oacute;n est&aacute; en:
 
	<h4>Post Relacionados</h4>
    <ul><?php include($_SERVER['DOCUMENT_ROOT'].'/related-posts.php'); ?></ul>
	<!--<ul>
				<li class="categoriaPost info">
			<a title="Teoría de la relatividad para nabos (parte 2)" href="/posts/info/4500038/Teoría-de-la-relatividad-para-nabos-(parte-2).html">Teoría de la relatividad para nabos (parte 2)</a>
		</li>
        </ul>-->
</div><div style="clear:both"></div>
</div>