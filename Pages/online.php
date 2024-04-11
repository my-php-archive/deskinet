<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
?>
<div id="cuerpocontainer">
<div class="container740 floatL">
	
 
	
	<div class="box_title">
		<div class="box_txt usuarios_online">Usuarios online</div>
		<div class="box_rrs"><div class="box_rss"></div></div>
	</div>
	<div class="box_cuerpo">
		<table width="100%" border="0">
			<tr>
				<td width="11%" height="30"><strong>Filtrar:</strong></td>
				<td width="32%">Hombres <input type="radio" name="sexo" id="sexoM" value="m"<?=($_GET['gender'] == 'm' ? ' checked' : '');?> /> Mujeres <input type="radio" name="sexo" id="sexoF" value="f"<?=($_GET['gender'] == 'f' ? ' checked' : '');?> /> Ambos sexos <input name="sexo" type="radio" id="sexoA" value="a"<?=($_GET['gender'] == 'a' || !$_GET['gender'] ? ' checked' : '');?> /></td>
				<td width="14%">S&oacute;lo con fotos<input type="checkbox" name="foto" id="foto"<?=($_GET['images'] ? ' checked' : '');?> /></td>
				<td width="19%"><input type="button"  class="button" value="Filtrar" onclick="location.href='/usuarios-online/0/'+(document.getElementById('sexoM').checked?'m':(document.getElementById('sexoF').checked?'f':'a'))+'/'+(document.getElementById('foto').checked?1:0);" /></td>
			</tr>
		</table>
	</div>
	<br />
		<div class="box_title">
			<div class="box_txt usuarios_registrados_online">Usuarios registrados online: <?=$pstats['reg_users'];?></div>
			<div class="box_rrs"><div class="box_rss"></div></div>
		</div>
		<div class="box_cuerpo">
        <?php
		if($_GET['gender'] == 'a' || !$_GET['gender']) {
			unset($_GET['gender']);
		} else {
			$_GET['gender'] = ($_GET['gender'] == 'm' ? '1' : '2');
		}
		$q = "SELECT u.* FROM connected AS c, users AS u WHERE u.id = c.user";
		if($_GET['gender']) { $q .= " && u.gender = '".$_GET['gender']."'"; }
		if($_GET['images'] && $_GET['images'] == '1') { $q .= " && u.images != ''"; }
		$tp = ceil((mysql_num_rows(mysql_query($q)))/16);
		if(!$_GET['first']) { $min = 0; } else { $min = (int) $_GET['first']; }
		if($min < 0) { $min = 0; }
		if($min > ($tp*16-16)) { $min = $tp; }
		$max = $min+16;
		$cpag = ceil(($min+1)/16);
		$q .= " ORDER BY c.time DESC LIMIT ".$min.",".$max;
		$query = mysql_query($q) or die(mysql_error());
		$i = 0;
		if(!mysql_num_rows($query)) { echo 'No hay usuarios registrados conectados'; } else {
			while($user = mysql_fetch_array($query)) {
				$i++;
				echo '<div class="container340 floatL">
				<a href="/perfil/'.$user['nick'].'">
        <img border="0" src="/avatares/100/'.$user['avatar'].'" width="100" height="100" align="left" hspace="5" onerror="error_avatar(this)">
      </a>
			<a href="/perfil/'.$user['nick'].'"><strong>'.$user['nick'].'</strong></a><br />
			'.htmlspecialchars($user['city_text']).'<br />
			'.($user['gender'] == '1' ? 'Hombre' : 'Mujer').'<br />
			<img src="/images/icon-perfil.png" align="absmiddle" border="0" hspace="3" vspace="2"  /><a href="/perfil/'.$user['nick'].'">Ver Perfil</a><br />';
			if(!empty($user['images'])) { echo '<img src="/images/icon-fotos.png" align="absmiddle" border="0" hspace="3" vspace="2" />Con fotos<br />'; }
			echo '<img src="/images/msg.gif" widht="16" height="16" alt="Escribir un mensaje" title="Escribir un mensaje" align="absmiddle" hspace="3" vspace="2"  border="0"> <a href="/mensajes/para/'.$user['nick'].'">Enviar mensaje</a><br />
		</div>';
				if($i%2 == 0) { echo '<br clear="left" /><hr /><br clear="left" />'; }
			}
		}
		if($i%2 != 0) { echo '<br clear="left" /><hr /><br clear="left" />'; }
		?>
		<center>
        <?php
		if($cpag < 5) {
			$firstp = 1;
			$lastp = 9-$cpag;
		} elseif($cpag == 5) {
			$firstp = 1;
			$lastp = 9;
		} elseif(($cpag+4) >= $tp) {
			$firstp = 9-($tp-($cpag-1));
			$lastp = $tp;
		} else {
			$firstp = $cpag-4;
			$lastp = $cpag+4;
		}
		if($lastp > $tp) { $lastp = $tp; }
		for($i=$firstp;$i<=$lastp;$i++) {
			echo '<a href="/usuarios-online/'.(($i-1)*16).'/'.($_GET['gender'] ? $_GET['gender'] : 'a').'/'.($_GET['images'] ? '1' : '0').'">'.($i == $cpag ? '<b>'.$i.'</b>' : $i).'</a>';
			if($i != $lastp) { echo ' | '; }
		}
		?>		</center>
	</div>
	<br clear="left" />
</div>
<div class="container170 floatR">
	<div class="box_title">
		<div class="box_txt usuarios_online_anunciantes">Anunciantes</div>
			<div class="box_rrs"><div class="box_rss"></div>
		</div>
	</div>
	<div class="box_cuerpo" style="padding-left:0;padding-right:0;"><center><?=advert('160x600');?></center></div>
</div><div style="clear:both"></div>

</div> <!-- cuerpocontainer -->