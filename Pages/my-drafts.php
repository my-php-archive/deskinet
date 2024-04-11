<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!isLogged()) {
	include('./Pages/register.php');
    include('./footer.php');
    die;
}
?>
<div id="cuerpocontainer">
<div id="borradores">
<?php
$query = mysql_query("SELECT * FROM `drafts` WHERE user = '".$currentuser['id']."' ORDER BY time DESC");
$cats = array();
$cats['todas_Ver+todas'] = 0;
$types = array(0, 0, 0);
$orders = array('f' => array(), 't' => array(), 'c' => array());
if(mysql_num_rows($query)) {
	while($draft = mysql_fetch_assoc($query)) {
		$cat = mysql_fetch_assoc(mysql_query("SELECT name, urlname FROM `categories` WHERE id = '".$draft['cat']."'"));
        $cat['urlname2'] = $cat['urlname'];
        $cat['urlname'] = str_replace(' ', '-', $cat['urlname']);
		if($cats[$cat['urlname'].'_'.str_replace(' ', '+', $cat['name'])]) { $cats[$cat['urlname'].'_'.str_replace(' ', '+', $cat['name'])]++; } else { $cats[$cat['urlname'].'_'.str_replace(' ', '+', $cat['name'])] = 1; }
		$cats['todas_Ver+todas']++;
		$type = ($draft['type']=='1' ? 'borradores' : 'eliminados');
		$types[0]++;
		$types[$draft['type']]++;
		$orders['f'][$draft['id']] = $draft['time'];
		$orders['t'][$draft['id']] = $draft['title'];
		$orders['c'][$draft['id']] = $cat['name'];
		$scriptdata .= ',{"id":"'.$draft['id'].'","titulo":"'.str_replace('"', '\"', str_replace('\\', '\\\\', $draft['title'])).'","categoria":"'.$cat['urlname'].'","categoria_name":"'.$cat['name'].'","tipo":"'.$type.'"}';
		$display .= '<li id="borrador_id_'.$draft['id'].'" class="filtro-show cat-show search-show">
			<a title="'.$cat['name'].'" class="categoriaPost '.$cat['urlname2'].' '.$cat['urlname'].' '.$type.'" href="/agregar/'.$draft['id'].'/">'.htmlspecialchars($draft['title']).'</a>'.($type == 'eliminados' ? '<span class="causa">Causa: '.htmlspecialchars($draft['reason']).'</span>' : '').'<span class="gray">&Uacute;ltima vez guardado el '.date('d/m/Y', $draft['time']).'</span> <a style="float:right" href="" onclick="borradores.eliminar('.$draft['id'].', true); return false;"><img src="/images/borrar.png" alt="eliminar" title="Eliminar Borrador" /></a>

			</li>';
            // al link deberia añadirle '.($type == 'eliminados' ? ' onclick="borradores.show_eliminado('.$draft['id'].');"' : '').' ????
	}
	
} else {
	$display = '<div class="emptyData">No tienes ning&uacute;n borrador ni post eliminado</div>';
}
?>

<div class="clearfix">

	<div class="left" style="float:left;width:200px">
		<div class="boxy">
			<div class="boxy-title">
				<h3>Filtrar</h3>
				<span></span>
			</div><!-- boxy-title -->
			<div class="boxy-content">
				<h4>Mostrar</h4>

				<ul class="cat-list" id="borradores-filtros">
					<li id="todos" class="active"><span class="cat-title"><a href="" onclick="borradores.active(this); borradores.filtro = 'todos'; borradores.query(); return false;">Todos</a></span> <span class="count"><?=$types[0];?></span></li>
					<li id="borradores"><span class="cat-title"><a href="" onclick="borradores.active(this); borradores.filtro = 'borradores'; borradores.query(); return false;">Borradores</a></span> <span class="count"><?=$types[1];?></span></li>
					<li id="eliminados"><span class="cat-title"><a href="" onclick="borradores.active(this); borradores.filtro = 'eliminados'; borradores.query(); return false;">Eliminados</a></span> <span class="count"><?=$types[2];?></span></li>
				</ul>
				<h4>Ordenar por</h4>

				<ul id="borradores-orden" class="cat-list">
					<li class="active"><span><a href="#" onclick="borradores.active(this); borradores.orden = 'fecha'; borradores.query(); return false;">Fecha guardado</a></span></li>
					<li><span><a href="#" onclick="borradores.active(this); borradores.orden = 'titulo'; borradores.query(); return false;">T&iacute;tulo</a></span></li>
					<li><span><a href="#" onclick="borradores.active(this); borradores.orden = 'categoria'; borradores.query(); return false;">Categor&iacute;a</a></span></li>
				</ul>
				<h4>Categorias</h4>

				<ul class="cat-list" id="borradores-categorias">
					<!--<li id="todas" class="active"><span class="cat-title active"><a href="" onclick="borradores.active(this); borradores.categoria = 'todas'; borradores.query(); return false;">Ver todas</a></span> <span class="count"><?=$cats[0];?></span></li>-->
                    <?php
					arsort($cats);
					$act = ' class="active"';
                    $counts = "borradores.counts['categorias'] = new Array();\n";
					foreach($cats as $url => $n) {
						$ex = explode('_', $url);
                    	echo '<li id="'.$ex[0].'"'.$act.'><span class="cat-title"><a href="" onclick="borradores.active(this); borradores.categoria = \''.$ex[0].'\'; borradores.query(); return false;">'.str_replace('+', ' ', $ex[1]).'</a></span> <span class="count">'.$n.'</span></li>';
						$counts .= "borradores.counts['categorias']['".$ex[0]."'] = {'name': '".str_replace('+', ' ', $ex[1])."', 'count':".$n."};\n";
						unset($act);
					}
					arsort($orders['f']);
					asort($orders['t']);
					asort($orders['c']);
					foreach($orders as $t => $array) {
						$i = 0;
						foreach($array as $id=>$v) {
							$order .= "borradores.orden_".$t."[".$i++."] = '".$id."';\n";
						}
					}
					echo "<script type=\"text/javascript\">
                    var borradores_data;
					$.getScript('/js/drafts.js', function() {
					borradores.counts['todos'] = ".$types[0].";
					borradores.counts['borradores'] = ".$types[1].";
					borradores.counts['eliminados'] = ".$types[2].";
					".$counts.$order."\n";
					if($scriptdata) {
						echo 'borradores_data = ['.substr($scriptdata, 1).'];';
					}
					echo "});</script>";
					?>
				</ul>
			</div><!-- boxy-content -->
		</div>
	</div><!-- END LEFT -->
	<div class="right" style="float:left;margin-left:10px;width:730px">
		<div class="boxy">

			<div class="boxy-title">
				<h3>Posts</h3>
				<label for="borradores-search" style="color:#999999;float:right;position:absolute;right:135px;top:11px;z-index:5;">Buscar</label><input type="text" id="borradores-search" value="" onKeyUp="borradores.search(this.value, event)" onFocus="borradores.search_focus()" onBlur="borradores.search_blur()" autocomplete="off" />
			</div>
			<div id="res" class="boxy-content">
								<ul id="resultados-borradores">
<?=$display;?>
</ul>
			</div>
		</div>

	</div>
</div>

</div> <!-- #borradores -->
<div style="clear:both"></div>
</div>