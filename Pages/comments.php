<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!isLogged()) { die(error('OOPS!', 'Para ver el top necesitas autentificarte', 'Ir a la p&aacute;gina principal', '/')); }
if(!$_GET['u'] || !mysql_num_rows($q = mysql_query("SELECT id, nick FROM `users` WHERE nick = '".mysql_clean($_GET['u'])."'"))) { die(error('OOPS!', 'Ese usuario no existe', 'Ir a la p&aacute;gina principal', '/')); }
$user = mysql_fetch_array($q);
$id = $user['id'];
$uname = $user['nick'];
unset($user, $q);
?>
<div id="cuerpocontainer">
<div class="container720 floatL">
  <div class="box_title">
    <span class="box_txt ultimos_comentarios_de">&Uacute;ltimos comentarios de <?=$uname;?></span>
    <span class="box_rss"></span>
  </div>
  <div class="box_cuerpo">
  <?php
  // Por si alguno se le ocurre leer esto... no me quise complicar la vida, asi que lo hice a las malas...
  $posts = array();
  $query = mysql_query("SELECT post FROM `comments` WHERE author = '".$id."' ORDER BY time DESC LIMIT 50") or die(mysql_error());
  if(!mysql_num_rows($query)) { echo 'Este usuario no tiene comentarios'; } else {
  	while($f = mysql_fetch_array($query)) { if(!in_array($f['post'], $posts)) { $posts[] = $f['post']; } }
  	$c = count($posts);
  	for($i=0;$i<$c;$i++) {
		$qpost = mysql_fetch_array(mysql_query("SELECT id, cat, title, time FROM `posts` WHERE id = '".$posts[$i]."'"));
		$cat = mysql_fetch_array(mysql_query("SELECT name, urlname FROM `categories` WHERE id = '".$qpost['cat']."'"));
		echo '<span onmouseover="this.style.backgroundColor = \'transparent\';" class="categoriaPost '.$cat['urlname'].'" alt="'.$cat['name'].'" title="'.$cat['name'].'"></span> <a href="/posts/'.$cat['urlname'].'/'.$qpost['id'].'/'.url($qpost['title']).'.html" title="'.$cat['name'].'"><strong>'.htmlspecialchars($qpost['title']).'</strong></a><br /><div style="clear:both"></div>';
		$comments = mysql_query("SELECT id, message, time FROM `comments` WHERE post = '".$qpost['id']."' && author = '".$id."'");
		while($comment = mysql_fetch_array($comments)) {
			echo '<div class="perfil_comentario">'.udate('d.m.Y H:i:s', $comment['time']).': <a href="/posts/'.$cat['urlname'].'/'.$qpost['id'].'.'.$comment['id'].'/'.url($qpost['title']).'.html#c'.$comment['id'].'">'.$comment['message'].'</a></div>';
		}
		if(($i+1) != $c) { echo '<hr />'; }
	}
  }
	?>
	</div>
</div>
<div class="container208 floatR">
	<div class="box_title">
    <span class="box_txt publicidad_ultimos_comentarios_de">Publicidad</span>
    <span class="box_rss"></span>
	</div>
	<div class="box_cuerpo">
		<center>
			<!-- BEGIN SMOWTION TAG - 728x90 - turinga: p2p - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "160x600";
smowtion_section = "832735";
smowtion_iframe = 1;
//-->
</script>
<script type="text/javascript"
src="http://ads.smowtion.com/ad.js">
</script>
<!-- END SMOWTION TAG - 728x90 - turinga: p2p - DO NOT MODIFY --></center>
	</div>
</div>
<div style="clear:both"></div>
<hr />
<br clear="left" />
<center>
<!-- BEGIN SMOWTION TAG - 728x90 - turinga: p2p - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "728x90";
smowtion_section = "832735";
smowtion_iframe = 1;
//-->
</script>
<script type="text/javascript"
src="http://ads.smowtion.com/ad.js">
</script>
<!-- END SMOWTION TAG - 728x90 - turinga: p2p - DO NOT MODIFY --></center><div style="clear:both"></div>
</div>