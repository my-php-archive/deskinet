<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!$_GET['group'] || !mysql_num_rows($qgroup = mysql_query("SELECT * FROM `groups` WHERE urlname = '".mysql_clean($_GET['group'])."'"))) {
	include('groups.php');
	include('footer.php');
	die;
}
$group = mysql_fetch_array($qgroup);
if($group['private'] == '1' && !isLogged()) { die(error('OOPS!', 'Debes estar logeado para ver esta comunidad', 'P&aacute;gina principal de comunidades', '/comunidades/')); }
$cat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$group['cat']."'"));
$subcat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$group['subcat']."'"));
$creator = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$group['creator']."'"));
if(mysql_num_rows($q = mysql_query("SELECT * FROM `group_members` WHERE `group` = '".$group['id']."' AND user = '".$currentuser['id']."'"))) {
	$currentuser['group'] = mysql_fetch_array($q);
	$currentuser['isMember'] = true;
}
?>
<div id="cuerpocontainer">
<div class="comunidades">
 
<div class="breadcrump">
<ul>
<li class="first"><a href="/comunidades/" title="Comunidades">Comunidades</a></li><li><a href="/comunidades/cat/<?=$cat['urlname'];?>/" title="<?=$cat['name'];?>"><?=$cat['name'];?></a></li><li><a href="/comunidades/<?=$group['urlname'];?>/"><?=htmlspecialchars($group['name']);?></a></li><li>Miembros</li><li class="last"></li>
</ul>
</div>
 
<div class="denunciar"><a href="#" onclick="denuncia_publica();return false;" title="Denunciar">Denunciar</a></div>
	<div style="clear:both"></div>
 
 
<div id="izquierda">
<?php include('./Pages/groups-left.php');?>
</div>
<div id="centro">
<?php
	if($currentuser['group']['rank'] > 2 || isAllowedTo('groups_memberlist')) {
		?>
	<div class="filterBy">
	<div class="floatL">
		<input id="miembros_list_search" class="search-input" type="text" value="" />&nbsp;<input class="mBtn btnOk" value="&raquo;" onclick="groups_miembros_list(document.getElementById('miembros_list_search').value, <?=$group['id'];?>);return false;" type="button" style="padding-left:7px;padding-right:7px;" />
	</div>
  <ul>
    <li id="gml1" class="here"><a href="#" onclick="groups_miembros_list(1, <?=$group['id'];?>);return false;">Miembros</a></li>
    <li id="gml2"><a href="#" onclick="groups_miembros_list(2, <?=$group['id'];?>);return false;">Suspendidos</a></li>
    <li id="gml3"><a href="#" onclick="groups_miembros_list(3, <?=$group['id'];?>);return false;">Historial</a></li>
  </ul>
  <span class="gif_loading floatR" id="gmli"></span>
  <div class="clearBoth"></div>
</div>
<? } ?>
<div id="showResult">
 <? include('./ajax/groups-members-list.php'); ?>
</div>

</div>
<div id="derecha">

	<div class="box_title">
		<div class="box_txt">&Uacute;ltimos Miembros</div>
		<div class="box_rrs"><div class="box_rss"></div></div>
	</div>
	<div class="box_cuerpo">
   <?php include('./ajax/group-lastmembers.php'); ?>
	</div>
</div></div>
<div style="clear:both"></div>
</div> <!-- cuerpocontainer -->