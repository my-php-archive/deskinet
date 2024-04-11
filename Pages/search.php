<?php
$googlec = '000900742206252249141:y6ubcp5vqsq'; // CODIGO PARA BUSQUEDA GOOGLE
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
/*if($_GET['sq'] && strpos($_GET['sq'], '=') && $_GET['sq']{0} == '?') {
	$ex = explode($_GET['sq'], '=');
	$_GET[substr($ex[0], 1)] = $ex[1];
}*/
$_GET['si'] = strtolower($_GET['si']);
$_GET['sw'] = strtolower($_GET['sw']);
if(!$_GET['si'] || ($_GET['si'] != 'posts' && $_GET['si'] != 'comunidades')) { $si = 'posts'; } else { $si = mysql_clean($_GET['si']); }
if(!$_GET['sw'] || ($_GET['sw'] != 'google' && $_GET['sw'] != $config['script_name2'] && $_GET['sw'] != 'tags')) { $sw = 'google'; } else { $sw = mysql_clean($_GET['sw']); }
if(!$_GET['sort_by']) { $_GET['sort_by'] = '0'; }
if($_GET['sort_by'] != '0' && $_GET['sort_by'] != '1' && $_GET['sort_by'] != '2') { $_GET['sort_by'] = '1'; }
if($sw == 'tags' && $_GET['sort_by'] == '0') { $_GET['sort_by'] = '1'; }
$_GET['q'] = mysql_clean($_GET['q']);
?>
<div id="cuerpocontainer">
<script type="text/javascript"> 
var buscador = {
	tipo: '<?=$sw;?>',
	buscadorLite: false,
	select: function(tipo){
		if(this.tipo==tipo)
			return;
 
		//Cambio de action form
		$('form[name="buscador"]').attr('action', '/posts/buscador/'+tipo+'/');
 
		//Solo hago los cambios visuales si no envia consulta
			//Cambio here en <a />
			$('a#select_' + this.tipo).removeClass('here');
			$('a#select_' + tipo).addClass('here');
 
			//Cambio de logo
			$('img#buscador-logo-'+this.tipo).css('display', 'none');
			$('img#buscador-logo-'+tipo).css('display', 'inline');
 
			//Muestro/oculto el input autor
			if(tipo=='<?=$config['script_name2'];?>') {
				$('span#filtro_autor').show();
			} else {
				$('span#filtro_autor').hide();
			}
 
		this.tipo = tipo;
		//En buscador lite envio consulta
		$('input[name="q"]').focus();
	}
}
<?php
if($sw) { echo "buscador.select('".$sw."');"; } ?>
</script>
<div id="buscador<?=($_GET['q'] || $_GET['autor'] ? 'Lite' : 'Big');?>">
	<ul class="searchTabs">
		<li class="here"><a href="<?=($si == 'posts' ? '' : '/posts/buscador/');?>">Posts</a></li>
		<li><a href="<?=($si == 'comunidades' ? '' : '/comunidades/buscador/');?>">Comunidades</a></li>
		<li class="clearfix"></li>
	</ul>
	<div class="clearBoth"></div>
	<div class="searchCont">
		<form style="padding:0;margin:0" name="buscador" method="GET" action="/posts/buscador/<?=$sw;?>/">
			<div class="searchFil">
				<div style="margin-bottom:5px">
					<div class="logoMotorSearch">
						<img id="buscador-logo-google" src="http://www.google.com/images/poweredby_transparent/poweredby_FFFFFF.gif" alt="google-search-engine" style="display:<?=($sw == 'google' ? 'inline' : 'none');?>;" />
						<img id="buscador-logo-<?=$config['script_name2'];?>" src="/images/taringaFFF.gif" alt="<?=$config['script_name2'];?>-search-engine" style="display:<?=($sw == $config['script_name2'] ? 'inline' : 'none');?>;" />
						<img id="buscador-logo-tags" src="/images/taringaFFF.gif" alt="tags-search-engine" style="display:<?=($sw == 'tags' ? 'inline' : 'none');?>;" />
					</div>
 
					<label class="searchWith">
													<a id="select_google" <?=($sw == 'google' ? 'class="here" ' : '');?>href="javascript:buscador.select('google')">Google</a><span class="sep">|</span>
												<a id="select_<?=$config['script_name2'];?>" <?=($sw == $config['script_name2'] ? 'class="here" ' : '');?>href="javascript:buscador.select('<?=$config['script_name2'];?>')"><?=$config['script_name'];?></a><span class="sep">|</span>
						<a id="select_tags" <?=($sw == 'tags' ? 'class="here" ' : '');?>href="javascript:buscador.select('tags')">Tags</a>
					</label>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			
				<div class="boxBox">
					<div class="searchEngine">
						<input type="text" name="q" size="25" class="searchBar" value="<?=$_GET['q'];?>" />
						<input type="submit" class="mBtn btnOk" value="Buscar" title="Buscar" />
  					<div class="clearfix"></div>
					</div>
					<!-- End Filter -->
					<div class="filterSearch">
					  <strong>Filtrar:</strong>
						<div class="floatL">
							<label>Categoria</label>
							<select name="cat" style="width: 200px">
								<option value="-1">Todas</option>
                                    		<?php
											$query = mysql_query("SELECT name, urlname FROM `categories` ORDER BY name ASC");
											while($cat = mysql_fetch_array($query)) {
												echo '<option'.($_GET['cat'] == $cat['urlname'] ? ' selected' : '').' value="'.$cat['urlname'].'">'.$cat['name'].'</option>';
											}
											?>
                  							</select>
							<span id="filtro_autor" style="display:<?=($sw == $config['script_name2'] ? 'inline' : 'none');?>;">
                            <? if($_GET['q'] || $_GET['autor']) { echo '<br />'; } ?>
								<label>Usuario</label>
								<input type="text" value="<?=$_GET['autor'];?>" name="autor" />
							</span>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- End SearchFill -->
					<div class="clearfix"></div>
					
				</div>
			  <div class="clearfix"></div>
			</div>
			<!-- End SearchFill -->
		<input type="hidden" name="cx" value="<?=$googlec;?>" /><input type="hidden" name="cof" value="FORID:10" /><input type="hidden" name="ie" value="ISO-8859-1" />
		</form>
	</div>
</div>
<div style="clear:both"></div>
<!--RES-->
<?php
if(($_GET['q'] && !empty($_GET['q'])) || ($_GET['autor'] && !empty($_GET['autor']))) {
if($sw != 'google') {
	//Para no andar cambiando, meto la mierda en el array
	$search = array(); // EING?
	if($si == 'posts') {
		if($_GET['autor'] && !$_GET['q'] && mysql_num_rows($a = mysql_query("SELECT id FROM `users` WHERE nick = '".mysql_clean($_GET['autor'])."'"))) {
				$author = mysql_fetch_array($a);
				$byauthor = true;
				$search['q'] = "SELECT * FROM `posts` WHERE author = '".$author['id']."'";
		}
		if($sw == $config['script_name2'] && !isset($byauthor)) {
			$search['q'] = (substr_count($_GET['q'], ' ') == 0 ? "SELECT *, MATCH(title, message) AGAINST('".$_GET['q']."') AS score FROM `posts` WHERE (title LIKE '%".$_GET['q']."%' OR message LIKE '%".$_GET['q']."%')" : "SELECT *, MATCH(title, message) AGAINST('".$_GET['q']."') AS score FROM `posts` WHERE
MATCH(title, message) AGAINST('".$_GET['q']."')");
			if($_GET['cat'] && $_GET['cat'] != '-1' && $_GET['cat'] != -1 && mysql_num_rows($search['catquery'] = mysql_query("SELECT id FROM `categories` WHERE urlname = '".mysql_clean($_GET['cat'])."'"))) {
				$search['cat'] = mysql_fetch_array($search['catquery']);
				$search['q'] .= " AND cat = '".$search['cat']['id']."'";
			}
			if($_GET['autor'] && mysql_num_rows($a = mysql_query("SELECT id FROM `users` WHERE nick = '".mysql_clean($_GET['autor'])."'"))) {
				$author = mysql_fetch_array($query);
				$search['q'] .= " AND author = '".$author['id']."'";
			}
		} elseif($sw == 'tags' && !isset($byauthor)) {
			$search['q']  = "SELECT * FROM `posts` WHERE tags REGEXP ',?".mysql_clean($_GET['q']).",?'";
		}
	}
	// FALTA HACER LA BUSKEDA DE COMUNIDADES
	$search['query2'] = mysql_query($search['q']);
	$search['totalpages'] = ceil(mysql_num_rows($search['query2'])/50);
	if(!$_GET['p'] || $_GET['p'] < 1 || !ereg('^[0-9]+$', $_GET['p'])) { $search['currentpage'] = 1; } else { $search['currentpage'] = mysql_clean($_GET['p']); }
	if($search['currentpage'] > $search['totalpages']) { $search['currentpage'] = $search['totalpages']; }
	$search['min'] = ($search['currentpage']-1)*50;
	if($search['min'] < 0) { $search['min'] = 0; }
	$search['max'] = $search['min']+50;
	if($_GET['sort_by'] == '0' || $_GET['sort_by'] == 0) {
		if(!$byauthor){$search['q'] .= " ORDER BY score";}else{$search['q'].=" ORDER BY id";}
	} elseif($_GET['sort_by'] == '2' || $_GET['sort_by'] == 2) {
		$search['q'] .= " ORDER BY points2";
	} else {
		$search['q'] .= " ORDER BY time";
	}
	$search['q'] .= " DESC LIMIT ".$search['min'].",".$search['max'];
	$search['query'] = mysql_query($search['q']);
	if(!mysql_num_rows($search['query'])) { echo '<div class="emptyData">No se encontraron resultados</div>'; } else {
	echo '<div id="resultados">
<div id="avisosTop"></div>
 <div id="showResult">
		<table class="linksList">
			<thead>
				<tr>
					<th></th>
					<th style="text-align: left;">Mostrando <strong>'.$search['currentpage'].' - '.($search['currentpage']+49).'</strong> resultados de <strong>'.$search['totalresults'].'</strong></th>
					<th><a'.($_GET['sort_by'] == '1' ? ' class="here"' : '').' href="?q='.$_GET['q'].'&cat='.$_GET['q'].'&autor='.$_GET['autor'].'&sort_by=1">Fecha</a></th>
					<th><a'.($_GET['sort_by'] == '2' ? ' class="here"' : '').' href="?q='.$_GET['q'].'&cat='.$_GET['q'].'&autor='.$_GET['autor'].'&sort_by=2">Puntos</a></th>';
					if($sw != 'tags') { echo '<th><a'.($_GET['sort_by'] == '0' ? ' class="here"' : '').' href="?q='.$_GET['q'].'&cat='.$_GET['q'].'&autor='.$_GET['autor'].'&sort_by=0">Relevancia</a></th>'; }
				echo '</tr>
			</thead>
			<tbody>';
			while($post = mysql_fetch_array($search['query'])) {
				$cat = mysql_fetch_array(mysql_query("SELECT name, urlname FROM `categories` WHERE id = '".$post['cat']."'"));
							echo '<tr id="div_'.$post['id'].'">
					<td title="'.$cat['name'].'"><span class="categoriaPost '.$cat['urlname'].'"></span></td>
					<td style="text-align: left;">
						<a title="'.htmlspecialchars($post['title']).'" href="/posts/'.$cat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html" class="titlePost">'.htmlspecialchars($post['title']).'</a>
					</td>
					<td title="'.udate('d.m.Y', $post['time']).' a las '.udate('H:i', $post['time']).' hs.">'.timefrom($post['time']).'</td>
					<td><span class="color_green">';
                    			$f = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE post = '".$post['id']."'"));
					if(!empty($f['tp'])) {
						echo $f['tp'];
					} else {
						echo '0';
					}
					//$po = (int) $po;
					//$percent = ceil(((mysql_num_rows(mysql_query("SELECT * FROM `visits` WHERE post = '".$post['id']."'"))+$po)*100)/((time()-$post['time'])/(60*60*24)));
					echo '</span></td>';
				if($sw != 'tags') {
					if($byauthor) {
						$post['score'] = (round((time()-$post['time'])/86400)*$post['visits'])/100;
					}
					echo '<td>
					  <div class="relevancia" title="'.round($post['score']).'%">
              <div class="porcentajeRel" style="width:'.round($post['score']).'%;"></div>
            </div>
					</td>';
				}
				echo '</tr>';
				//  style="padding-left:'.round(42-((0.68*round($post['score']))/2)).';" :S
			}
						echo '</tbody>
		</table>
	</div>
 
<!-- Paginado -->
<div id="avisosBot"></div>
<div class="paginadorBuscador">
  <div class="before floatL">';
  if($search['currentpage'] != 1) { echo '<a href="?q='.$_GET['q'].'&cat='.$_GET['q'].'&autor='.$_GET['autor'].'&sort_by='.$_GET['sort_by'].'&p='.($search['currentpage']+1).'"><b>&laquo; Anterior</b></a>'; }
    echo '</div>
  <div class="pagesCant">
    <ul>';
	for($i=($search['currentpage']-1);$i>0;$i--) {
		if($i<($search['currentpage']-4)) { break; }
		echo '<li class="numbers"><a href="?q='.$_GET['q'].'&cat='.$_GET['q'].'&autor='.$_GET['autor'].'&sort_by='.$_GET['sort_by'].'&p='.$i.'">'.$i.'</a></li>';
	}
	echo '<li class="numbers"><a class="here" href="#respuestas">'.$search['currentpage'].'</a></li>';
	for($i=($search['currentpage']+1);$i<=$search['totalpages'];$i++) {
		if($i>($search['currentpage']+4)) { break; }
        echo '<li class="numbers"><a href="?q='.$_GET['q'].'&cat='.$_GET['q'].'&autor='.$_GET['autor'].'&sort_by='.$_GET['sort_by'].'&p='.$i.'">'.$i.'</a></li>';
	}
        	echo '<div class="clearBoth"></div>
	</ul>
  </div>
<div class="floatR next">';
	if($search['currentpage'] != $search['totalpages']) { echo '<a href="?q='.$_GET['q'].'&cat='.$_GET['q'].'&autor='.$_GET['autor'].'&sort_by='.$_GET['sort_by'].'&p='.($search['currentpage']+1).'"><b>Siguiente &raquo;</b></a>'; }
	echo '</div>
	</div></div>';
    } /* ¿num rows? */ } else { /* ELSE DE BUSQUEDA GOOGLE */ ?>
<div id="resultados">

<style type="text/css">@import url(http://www.google.com/cse/api/branding.css);</style>

<div id="cse-search-results"></div>
<script type="text/javascript">
	var googleSearchIframeName = "cse-search-results";
	var googleSearchFormName = "buscador"; <!--cse-search-box-->
	var googleSearchFrameWidth = 930;
	var googleSearchDomain = "www.google.es";
	var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>

</div>
<? } /* BUSQUEDA GOOGLE */ } /* $q */ ?>
    <div style="clear:both"></div>
	</div><!--CC-->