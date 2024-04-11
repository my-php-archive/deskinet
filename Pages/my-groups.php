<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!isLogged()) {
	include('./Pages/register.php');
    include('./footer.php');
    die;
}

include('./ajax/my-groups.php');
/* ANOTACIONEZ IPER CHUPIZ:
DEFINE $haveGroups o no... lla ce zave parra k
$currentPage -> pagina actual
$totalGroups -> numerro jrupos
$totalPages -> num pags
$displayStart -> primerr moztrradoh
$displayEnd -> k zerra...
$display -> lo k ahí k mztrar pipol
*/
// ezto puede serbir gege
// if(!mysql_num_rows($query = mysql_query("SELECT g.id, g.name, g.urlname, g.description, g.cat, g.avatar, m.name AS rank FROM `groups` AS g, group_members AS m WHERE m.user = '".$currentuser['id']."' && g.id = m.group ORDER BY m.rank DESC"))) {

?>
<script type="text/javascript">var currentPage = 1; var totalPages = <?=$totalPages;?>; var orderBy = 'rank';</script>
<div id="cuerpocontainer">
<div class="comunidades">
 
<div class="breadcrump">
<ul>
<li class="first"><a href="/comunidades/" title="Comunidades">Comunidades</a></li><li>Mis comunidades</li><li class="last"></li>
</ul>
</div>
 <?php
 if(!$haveGroups) {
	die('<br /><br /><br /><div class="emptyData">No eres miembro de ninguna comunidad</div></div></div>'.file_get_contents('./footer.php'));
}
$rows = mysql_num_rows($query);
?>
	<div style="clear:both"></div>

<div style="width:200px;float:right;">
<div class="box_title"></div>
<div class="box_cuerpo ads">
<center><?=advert('160x600');?></center>
</div>
</div>
	<div style="width:700px;float:left;">
 
<div class="filterBy">
	<div class="floatL xResults">
		Mostrando <strong id="dstde"><?=$displayStart;?> - <?=$displayEnd;?></strong> resultados de <strong><?=$totalGroups;?></strong>
	</div>
	<ul class="floatR">
		<li class="orderTxt">Ordenar por:</li>
		<li id="mgbname"><a href="#" onclick="mygroups_show(1, 'name');return false;">Nombre</a></li>
		<li class="here" id="mgbrank"><a href="#" onclick="mygroups_show(1, 'rank');return false;">Rango</a></li>
		<li id="mgbmembers"><a href="#" onclick="mygroups_show(1, 'members');return false;">Miembros</a></li>
		<li id="mgbposts"><a href="#" onclick="mygroups_show(1, 'posts');return false;">Temas</a></li>
	</ul>
      <span id="mygroups_loading" class="gif_loading floatR"></span>
	<div class="clearBoth"></div>
</div> <!-- FILTER BY -->
 
<div id="showResult" class="resultFull">
<!--	<ul>
		</ul>
	<div class="clearBoth"></div>-->
    <?=$display;?>
</div>
 
<!-- Paginado -->
<!-- FIN - Paginado -->
 
</div>
 
</div>
<div style="clear:both"></div>
</div> <!--cc-->