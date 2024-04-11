<?php if(!$group) { die; } ?>
<div class="comunidadData<?=($group['official'] == '1' ? ' oficial' : '');?>">
<div class="box_title">
<div class="box_txt post_autor">Comunidad</div>
<div class="box_rss"></div>
</div>
<div class="box_cuerpo">
	<? if($group['official'] == '1') { echo '<img src="/images/riboon_top.png" class="riboon" />'; } ?>
	  <div class="avaComunidad">
    <a href="/comunidades/<?=$group['urlname'];?>/">
      <img class="avatar" src="<?=$group['avatar'];?>" alt="Logo de la comunidad" title="Logo de la comunidad" onerror="error_avatar(this);" />
    </a>
  </div>
<h2><a href="/comunidades/<?=$group['urlname'];?>/"><?=$group['name'];?></a></h2>
 
<hr class="divider" />
<ul>
  <li><a href="/comunidades/<?=$group['urlname'];?>/miembros/"><span id="cont_miembros"><?=mysql_num_rows(mysql_query("SELECT * FROM `group_members` WHERE `group` = '".$group['id']."'"));?></span> Miembros</a></li>
  <li><?=mysql_num_rows(mysql_query("SELECT * FROM `group_posts` WHERE `group` = '".$group['id']."'"));?> Temas</li>
  <li><span id="numf_group"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '3' && who = '".$group['id']."'"));?></span> Seguidores</li>
</ul>
 
	<? if($currentuser['isMember']) { ?><hr class="divider" />
	Mi rango: <b><?=groupRankName($currentuser['group']['rank']);?></b>
    <? } ?>
<hr class="divider" />
<div class="buttons">
	<?php
	if($currentuser['isMember']) {
		echo '<input id="a_susc" class="mBtn btnCancel" onclick="dejar_comunidad('.$group['id'].');return false;" value="Dejar Comunidad" type="button" />';
	} else {
		echo '<input id="a_susc" class="mBtn btnGreen" onclick="participar_comunidad('.$group['id'].', \''.groupRankName($group['default_rank']).'\');return false;" value="Participar" type="button" />';
	}
	$rows = mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '3' && who = '".$group['id']."' && user = '".$currentuser['id']."'"));
    echo '<a id="unfollow_group" style="display:'.($rows ? 'block' : 'none').';" class="btn_g unfollow" href="'.(isLogged() ? '#" onclick="follow(3, '.$group['id'].', $(this).children(\'span\'), this, true);return false;' : '/registro/').'"><span class="icons unfollow">Dejar de seguir</span></a>
								<a id="follow_group" style="display:'.(!$rows ? 'block' : 'none').';" class="btn_g follow" href="'.(isLogged() ? '#" onclick="follow(3, '.$group['id'].', $(this).children(\'span\'), this);return false;' : '/registro/').'"><span class="icons follow">Seguir comunidad</span></a>';
							?>
</div>

</div>
</div>
 <?php
 if(($currentuser['isMember'] && $currentuser['group']['rank'] == 4) || isAllowedTo('edit_groups') || isAllowedTo('delete_groups')) {
	 ?>
<br class="spacer" />
<div class="adminOpt">
  <div class="box_title">
		<div class="box_txt" style="width:142px">Administraci&oacute;n</div>
		<div class="box_rss"></div>
	</div>
	<div class="box_cuerpo">
	  <ul>		
		<?php
		if(($currentuser['isMember'] && $currentuser['group']['rank'] == 4) || isAllowedTo('edit_groups')) {
			echo '<li><input type="button" value="Editar comunidad" onclick="location.href=\'/comunidades/'.$group['urlname'].'/editar/\'" class="mBtn btnYellow" style="width:100%;" /></li>';
		}
		if((($currentuser['isMember'] && $currentuser['group']['rank'] == 4) || isAllowedTo('edit_groups')) && ($group['creator'] == $currentuser['id'] || isAllowedTo('delete_groups'))) { echo '<br />'; }
		if($group['creator'] == $currentuser['id'] || isAllowedTo('delete_groups')) {
			echo '<li><input type="button" value="Borrar comunidad" onclick="delete_group('.$group['id'].');" class="mBtn btnDelete" style="width:100%;" /></li>';
		}
		?>
    </ul>
	</div>
</div>
<? } ?>
<br class="spacer" />