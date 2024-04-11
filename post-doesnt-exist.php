<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
?>
<div id="cuerpocontainer">
<div class="post-deleted">
	<h3>Oops! Este post no existe o fue eliminado!</h3>
	Pero no pierdas las esperanzas, no todo esta perdido, la soluci&oacute;n est&aacute; en:
 
	<h4>Post Relacionados</h4>
    <ul><?php include($_SERVER['DOCUMENT_ROOT'].'/related-posts.php'); ?></ul>
	<!--<ul>
				<li class="categoriaPost noticias">
			<a title="La vuelta de Menseguez y el desgarro del Chaco Torres" href="/posts/noticias/4507509/La-vuelta-de-Menseguez-y-el-desgarro-del-Chaco-Torres.html">La vuelta de Menseguez y el desgarro del Chaco Torres</a>
		</li>
		</ul>-->
</div><div style="clear:both"></div>
</div>