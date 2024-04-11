<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303

?>
<div id="cuerpocontainer">
<div class="comunidades">
<?php
if(mysql_num_rows(mysql_query("SELECT * FROM `favorites` WHERE user = '".$currentuser['id']."'"))) {
?>
<div id="izquierda" style="width:170px">
	<div class="categoriaList">
		<ul>
			<li style="margin-bottom: 5px;background:#555555; -moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px"><a href="#" onclick="filtro_favs('categoria', 'all'); return false;" style="color:#FFF"><strong>Categor&iacute;as</strong></a></li>
<?php
$query = mysql_query("SELECT DISTINCT c.name AS name, c.id AS id FROM categories AS c, favorites AS f, posts AS p WHERE f.user = '".$currentuser['id']."' && p.id = f.post && c.id = p.cat");
if(mysql_num_rows($query)) {
	while($fetch = mysql_fetch_array($query)) {
		$rows = mysql_num_rows(mysql_query("SELECT f.id FROM favorites AS f, posts AS p WHERE f.user = '".$currentuser['id']."' && p.cat = '".$fetch['id']."' && f.post = p.id"));
		echo '<li><a href="#" onclick="filtro_favs(\'categoria\', '.$fetch['id'].');return false;">'.$fetch['name'].' ('.$rows.')</a></li>';
	}
}
?>
</ul>
	</div>
</div>
 <script type="text/javascript">var orden_s = 'guardado'; var categoria_s = 'all';</script>
<div id="centroDerecha">
	<div id="resultados">
		<table class="linksList">
			<thead>
				<tr>
					<th></th>
					<th style="text-align:left;width:350px;overflow:hidden;"><a href="#" onclick="filtro_favs('orden', 'titulo', this); return false;" id="orden_e_titulo">T&iacute;tulo</a></th>
					<th><a href="#" onclick="filtro_favs('orden', 'creado', this); return false;" id="orden_e_creado">Creado</a></th>
					<th><a href="#" onclick="filtro_favs('orden', 'guardado', this); return false;" class="here" id="orden_e_guardado">Guardado</a></th>
					<th><a href="#" onclick="filtro_favs('orden', 'puntos', this); return false;" id="orden_e_puntos">Puntos</a></th>
					<th><a href="#" onclick="filtro_favs('orden', 'visitas', this); return false;" id="orden_e_visitas">Visitas</a></th>
					<th></th>
				</tr>
			</thead>
            <?php $shortby = 'guardado'; include('ajax/favorites.php'); ?>
		</table>
	</div>
</div>
<? } else { 
echo '<div class="emptyData">No agregaste ning&uacute;n post a favoritos todav&iacute;a</div>';
}
?>
</div><div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div>