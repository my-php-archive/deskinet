<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('Debes logearte para acceder a esta secci&oacute;n'); }
if($_GET['send']) {
	if(!$_GET['action'] || ($_GET['action'] != '1' && $_GET['action'] != '2' && $_GET['action'] != '3') || !$_GET['user'] || !$_GET['group']) { die('Faltan datos'); }
	if(!mysql_num_rows($q = mysql_query("SELECT id FROM `groups` WHERE id = '".mysql_clean($_GET['group'])."'"))) {
		die('La comunidad no existe');
	}
	$group = mysql_fetch_array($q);
	if(!mysql_num_rows($uq = mysql_query("SELECT id, user, ban FROM `group_members` WHERE user = '".mysql_clean($_GET['user'])."' && `group` = '".$group['id']."'"))) {
		die('No existe el usuario o no es miembro de la comunidad');
	}
	$user = mysql_fetch_array($uq);
	if(!mysql_num_rows($q = mysql_query("SELECT rank FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".$group['id']."' && rank > 2")) && !isAllowedTo('edit_members')) {
		die('Debes ser administrador o moderador de la comunidad');
	}
	$cuser = @mysql_fetch_array($q);
	if($_GET['action'] == '2') {
		if($cuser['rank'] != '4' && !isAllowedTo('groups_changerank')) { die('Debes ser administrador para cambiar el rango a otros usuarios'); }
		if($_GET['rank'] != '1' && $_GET['rank'] != '2' && $_GET['rank'] != '3' && $_GET['rank'] != '4' && $_GET['rank'] != '0') { die('A ver... un rango valido hijo'); }
		mysql_query("UPDATE `group_members` SET rank = '".mysql_clean($_GET['rank'])."' WHERE id = '".$user['id']."'") or die(($currentuser['nick']=='westwest' ? '->'.mysql_error().'<-' : 'error'));
		mysql_query("INSERT INTO `groups_history` (`group`, type, user, `mod`, time, reason) VALUES('".$group['id']."', '2', '".$user['user']."', '".$currentuser['id']."', '".time()."', '".mysql_clean($_GET['rank'])."')");
		die('1');
	} elseif($_GET['action'] == '3') {
		if(!$_GET['reason']) { die('Faltan datos'); }
		mysql_query("UPDATE `group_members` SET ban = '0' WHERE user = '".$user['user']."'");
		mysql_query("INSERT INTO `groups_history` (`group`, type, user, `mod`, time, reason) VALUES('".$group['id']."', '3', '".$user['user']."', '".$currentuser['id']."', '".time()."', '".mysql_clean($_GET['reason'])."')");
		die('1');
	} else {
		if(($_GET['permanent'] != '0' && $_GET['permanent'] != '1') || ($_GET['permanent'] == '0' && !preg_match('/[0-9]+/', $_GET['days'])) || !$_GET['reason']) { die('Faltan datos o son incorrectos'); }
		//mysql_query("INSERT INTO `group_bans` (`group`, user, `mod`, reason, permanent, time, days, end) VALUES('".$group['id']."', '".$user['user']."', '".$currentuser['id']."', '".mysql_clean($_GET['reason'])."', '".mysql_clean($_GET['permanent'])."', '".time()."', '".($_GET['permanent'] == 0 ? '0' : mysql_clean($_GET['days']))."', '".($_GET['permanent'] == 0 ? '0' : (time()+$_GET['days']*64800))."')") or die(mysql_error());
		mysql_query("UPDATE `group_members` SET ban = '1' WHERE user = '".$user['user']."'") or die(mysql_error());
		mysql_query("INSERT INTO `groups_history` (`group`, type, user, `mod`, time, reason, duration) VALUES('".$group['id']."', '1', '".$user['user']."', '".$currentuser['id']."', '".time()."', '".mysql_clean($_GET['reason'])."', '".($_GET['permanent'] == '1' ? '0' : mysql_clean($_GET['days']))."')") or die(mysql_error());
		die('1');
	}
} // send
if(!$_GET['group'] || !$_GET['id']) { die; }
if(!mysql_num_rows($q = mysql_query("SELECT id FROM `groups` WHERE id = '".mysql_clean($_GET['group'])."'"))) {
	die('La comunidad no existe');
}
$group = mysql_fetch_array($q);
if(!mysql_num_rows($q = mysql_query("SELECT rank, ban FROM `group_members` WHERE user = '".mysql_clean($_GET['id'])."' && `group` = '".$group['id']."'"))) {
	die('No existe el usuario o no es miembro de la comunidad');
}
$user = mysql_fetch_array($q);
if(!mysql_num_rows($q = mysql_query("SELECT rank FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".$group['id']."' && rank > 2")) && !isAllowedTo('edit_members')) {
	die('Debes ser administrador o moderador de la comunidad');
}
$cuser = mysql_fetch_array($q);
?>
<form action="javascript:groups_adminusers_submit();" onclick="groups_adminusers_check();" id="gauf">
<input type="hidden" value="<?=$_GET['id'];?>" name="user" />
<input type="hidden" value="<?=$group['id'];?>" name="group" />
<?php
if($user['ban'] == '0') {
?>
<div class="modalForm" onclick="document.getElementById('r_suspender').checked=true;">
  <input type="radio" id="r_suspender" name="r_admin_user" value="1" /><span class="mTitle">Suspender</span>
  <div class="admin_user_center">
    <ul>
      <li class="mBlock">
        <ul>
          <li class="mColLeft">

            Causa:
          </li>
          <li class="mColRight">
            <input class="iTxt" type="text" id="t_causa" name="causa" onkeyup="groups_adminusers_check();" />
          </li>
          <li class="cleaner"></li>
        </ul>
      </li>
      <li class="mBlock">

        <ul>
          <li class="mColLeft">
            Tiempo:
          </li>
          <li class="mColRight">
            <input type="radio" id="r_suspender_dias1" name="r_suspender_dias" onclick="groups_adminusers_check();" value="1" /> <label for="r_suspender_dias1">Permanente</label>
            <hr />
            <input type="radio" id="r_suspender_dias2" name="r_suspender_dias" onclick="groups_adminusers_check();" value="2" /> <input type="text" id="t_suspender" name="i_suspender_dias" class="mDate iTxt" onkeyup="groups_adminusers_check();" /> <label for="r_suspender_dias2">D&iacute;as</label>

          </li>
          <li class="cleaner"></li>
        </ul>
      </li>
    </ul>
  </div>
</div><input type="hidden" id="r_rehabilitar" />
<? } else { ?>
<input type="hidden" id="r_suspender" /><input type="radio" id="r_suspender_dias1" name="r_suspender_dias" onclick="groups_adminusers_check();" value="1" style="display:none;" /><input type="hidden" name="i_suspender_dias" value="0" />
<div class="emptyData">Suspendido <a href="#" onclick="if($('#ver_mas').css('display')=='none'){$('#ver_mas').show('slow');$('#vermas').html('&laquo; Ver menos');return false;}else{$('#ver_mas').hide('slow');$('#vermas').html('Ver m&aacute;s &raquo;');return false;}" id="vermas">Ver m&aacute;s &raquo;</a>
<div id="ver_mas" style="display:none;"><br /><?php
$query = mysql_query("SELECT * FROM `groups_history` WHERE `group` = '".$group['id']."' && user = '".$user['user']."' && type != '2' ORDER BY time DESC LIMIT 5");
while($h = mysql_fetch_array($query)) {
	list($mod) = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$h['mod']."'"));
	list($huser) = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$h['user']."'"));
	if($h['type'] == '2') {
		echo 'Suspendido por <a href="/perfil/'.$mod.'/"><strong>'.$mod.'<strong></a> el d&iacute;a <strong>'.date('j/n/Y H:i:s', $history['time']).'</strong><br />Raz&oacute;<br /><strong style="color:red;">'.htmlspecialchars($h['reason']).'</strong><br />Duraci&oacute;n: <strong>'.($h['duration'] == '0' ? 'Permanente' : $h['duration'].' '.($h['duration'] == '1' ? 'd&iacute;a' : 'd&iacute;as').'</strong> hasta el <strong>'.date('j/n/Y', ($h['time']+($h['duration']*86400)))).'</strong>';
	} else {
		echo 'Rehabilitado por <a href="/perfil/'.$mod.'/"><strong>'.$mod.'</strong></a> el d&iacute;a <strong>'.date('j/n/Y H:i:s', $h['time']).'</strong><br />Raz&oacute;n: <strong style="color:green;">'.htmlspecialchars($h['reason']).'</strong>';
	}
}//while
?></div>
</div>
<br />
<div class="modalForm" onclick="document.getElementById('r_rehabilitar').checked=true;">
  <input type="radio" id="r_rehabilitar" name="r_admin_user" value="3" /><span class="mTitle">Rehabilitar</span>
  <div class="admin_user_center">
    <ul>
      <li class="mBlock">
        <ul>
          <li class="mColLeft">

            Causa:
          </li>
          <li class="mColRight">
            <input class="iTxt" type="text" id="t_causa" name="causa" onkeyup="groups_adminusers_check();" />
          </li>
          <li class="cleaner"></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<?php
}
if($cuser['rank'] == 4 || isAllowedTo('groups_changerank')) {
?>
<div class="modalForm" onclick="document.getElementById('r_rango').checked=true;">
  <input type="radio" id="r_rango" name="r_admin_user" value="2" /> <label for="r_rango" class="mTitle">Cambiar Rango:</label>

  <div class="admin_user_center" onclick="document.getElementById('r_rango').checked=true;">
  <script>var rango_actual = '<?=$user['rank'];?>';</script>  
  <ul>
    <li class="mBlock">
      <ul>
        <li class="mColLeft">
          Rango Actual:
        </li>
        <li class="mColRight">

          <strong class="orange"><?=groupRankName($user['rank']);?></strong>
        </li>
        <li class="cleaner"></li>
      </ul>
    </li>
    <li class="mBlock">
      <ul>
        <li class="mColLeft">

          Rango Nuevo:
        </li>
        <li class="mColRight">
          <select id="s_rango" name="s_rango" onchange="groups_adminusers_check();">
                    <option value="0"<?=($user['rank'] == '0' ? ' selected' : '');?>>Visitante</option>
                    <option value="1"<?=($user['rank'] == '1' ? ' selected' : '');?>>Comentador</option>
                    <option value="2"<?=($user['rank'] == '2' ? ' selected' : '');?>>Posteador</option>
                    <option value="3"<?=($user['rank'] == '3' ? ' selected' : '');?>>Moderador</option>
                    <option value="4"<?=($user['rank'] == '4' ? ' selected' : '');?>>Administrador</option>
                    </select>
        </li>
        <li class="cleaner"></li>
      </ul>
    </li>
  </ul>
  </div>
</div>
<? } ?>
</form>