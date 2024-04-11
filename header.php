<?php
if($_GET['page'] == 'post' || ($_GET['page'] == 'search' && $_GET['si'] == 'posts') || $_GET['page'] == 'new-post' || $_GET['page'] == 'default') {
	$tcat = 'posts';
} elseif($_GET['page'] == 'groups' || $_GET['page'] == 'new-group' || ($_GET['page'] == 'search' && $_GET['si'] == 'groups') || $_GET['page'] == 'group-tops' || $_GET['page'] == 'group' || $_GET['page'] == 'group-new-post' || $_GET['page'] == 'group-post' || $_GET['page'] == 'group-members' || $_GET['page'] == 'my-groups' || $_GET['page'] == 'dir') {
	$tcat = 'groups';
} elseif($_GET['page'] == 'register') {
	$tcat = 'register';
} elseif($_GET['page'] == 'admin') {
	$tcat = 'admin';
} elseif($_GET['page'] == 'wideas') {
	$tcat = 'ideas';
} elseif($_GET['page'] == 'tops') {
	$tcat = 'tops';
}

// paginas solo para registrados
$orp = array('new-post', 'pm', 'mod-history', 'monitor', 'monitor-pages', 'my-drafts', 'my-groups', 'account');
?>
<div id="menu">
<ul class="menuTabs">
<li id="tabbedPosts" class="tabbed<?=($tcat == 'posts' ? ' here' : '').($tcat == 'groups' ? ' gT' : '');?>">
<a href="/" title="Ir a Posts">Posts <img src="/images/arrowdown.png" alt="Drop Down" /></a>
</li>
<li class="tabbed<?=($tcat == 'groups' ? ' here' : '').($tcat == 'tops' ? ' gT' : '');?>">
<a href="/comunidades/" title="Ir a Comunidades">Comunidades <img src="/images/arrowdown.png" alt="Drop Down" /></a>
</li>
<li class="tabbed<?=($tcat == 'tops' ? ' here' : '').(($tcat == 'register' && !isLogged()) || ($tcat == 'admin' && isLogged() || $tcat == 'ideas') ? ' gT' : '');?>">
<a href="<?=($tcat == 'groups' ? '/top/comunidades/' : '/top/');?>" tabindex="Ir a TOPs">TOPs <img src="/images/arrowdown.png" alt="Drop Down" /></a>
</li>
<? /*if($tcat == 'ideas') { ?>
<li class="tabbed here">
<a href="/ideas/" title="Ideas">Ideas <img src="/images/arrowdown.png" alt="Drop Down" /></a>
</li>
<? } */?>
<? if(!isLogged()) {
    if(!in_array($_GET['page'], $orp) && $tcat != 'register' && (($_GET['page'] == 'post' && $post['private'] == '0') || $_GET['page'] != 'post')) {
        echo '<li class="tabbed registrate">
<a href="/registro/" onclick="registro_load_form();return false;" title="Registrate">&iexcl;Registrate ahora!</a>
</li>';
    } elseif($tcat == 'register') {
       echo '<li class="tabbed registrate here">
<a href="/registro/" title="Registro">Registro</a>
</li>';
    }
} elseif(isLogged() && isAllowedTo('showpanel')) {
	$query = mysql_query("SELECT DISTINCT post FROM `complaints` GROUP BY post ORDER BY COUNT(*) DESC") or die(mysql_error());
	$rows = mysql_num_rows($query);
	$query = mysql_query("SELECT id FROM `admin_notes` WHERE `read` REGEXP '(^|,)".$currentuser['id']."($|,)' || `edit` REGEXP '(^|,)".$currentuser['id']."($|,)'") or die(mysql_error());
	$rows2 = mysql_num_rows($query);
?>
<li class="tabbed<?=($tcat == 'admin' ? ' here' : '');?>">
<a href="/admin/" title="Panel Admin">Admin <img src="/images/arrowdown.png" alt="Drop Down" /></a>
</li>
<? if($rows && isAllowedTo('complaints')) { ?>
<li>
<a href="/admin/denuncias/">Denuncias <span style="font-size:12px;font-weight:normal;">(<?=$rows;?>)</span> <img src="/images/arrowdown.png" alt="Drop Down" /></a>
</li>
<? } // <- rows
if($rows2 && isAllowedTo('notes')) { ?>
<li>
<a href="/admin/notas/">Notas <span style="font-size:12px;font-weight:normal;">(<?=$rows2;?>)</span> <img src="http://turingax.net/images/arrowdown.png" alt="Drop Down" /></a>
</li>
<? } /* <- rows */ } ?>
<li class="clearBoth"></li>
</ul>
<? if(isLogged()) { ?>
<div class="user_options">
<div class="userInfoLogin">
<ul>
<!--<li>
<a href="/monitor/" title="Monitor de usuario" alt="Monitor de usuario">
<span class="systemicons eye"></span>
</a>
</li>-->
<li style="position: relative" class="monitor">
		<a name="Monitor" title="Monitor de usuario" alt="Monitor de usuario" onclick="noti_showlast();return false;" href="/monitor">
			<span class="systemicons monitor"></span>
		</a>
      <div class="notificaciones-list">
				<div style="padding: 10px 10px 0 10px;font-size:13px">
					<strong onclick="location.href='/monitor'" style="cursor:pointer">Notificaciones</strong>
				</div>
      	<ul>
        <? include('./ajax/lastnotis.php'); ?>
      	</ul>
      	<a class="ver-mas ndt" onclick="document.location='/monitor/';return false;">Ver m&aacute;s notificaciones</a>
      </div>
      <?=($notirows ? '<div class="alertas" style="top: -6px;"><a class="ndt"><span>'.$notirows.'</span></a></div>' : '');?>
</li>
<li>
<a href="/favoritos/" title="Mis Favoritos" alt="Mis Favoritos">
<span class="systemicons favorites"></span>
</a>
</li>
<li>
<a href="/mis-borradores/" title="Mis borradores">
<span class="systemicons borradores"></span>
</a> 
</li>
<li>
<a href="/mensajes/" title="Mensajes" alt="Mensajes">
<?php
$rows = mysql_num_rows(mysql_query("SELECT * FROM `pms` WHERE user_to = '".$currentuser['id']."' && readed_to = '0' && deleted_to = '0'"));
if(!$rows) {
	echo '<span class="systemicons messages2"></span>';
} else {
	echo '<img src="/images/newMsg.png" alt="Mensajes" /><span style="margin-left: 5px;font-size:12px">'.$rows.'</span>'; 
}
?>
</a>
</li>
<li>
<a href="/cuenta/" title="Mi cuenta" alt="Editar mi perfil">
<span class="systemicons myaccount"></span>
</a>
</li>
<li class="usernameMenu">
<a class="username" href="/perfil/<?=$currentuser['nick'];?>" title="Mi Perfil" alt="Mi Perfil"><?=$currentuser['nick'];?></a>
</li>
<li class="logout">
<a title="Salir" alt="Salir" style="vertical-align: middle" href="/salir/">
<span class="systemicons logout"></span>
</a>
</li>
</ul>
<div style="clear:both"></div>
</div>
</div>
<!--?-->
<!--?-->
<? } else { ?>
<div class="user_options anonymous" id="user_options">
<div class="loginb">
	<a class="logina" href="#" onclick="open_login_box();return false;" title="Identificarme">Identificarme</a>
</div>
<div id="login_box">
<div class="login_cuerpo">
  <span class="login_loading" class="gif_loading floatR"></span>
  <div class="login_error"></div>
    <form method="post" action="javascript:login_ajax('#login-tab');" id="login-tab">
      <label>Usuario</label>
      <input maxlength="15" name="nick" class="ilogin" type="text" />
      <label>Contrase&ntilde;a</label>
      <input maxlength="15" name="pass" class="ilogin" type="password" />
      <input class="mBtn btnOk" value="Entrar" title="Entrar" type="submit" />
      <div class="floatR" style="color: #666; padding:5px;font-weight: normal; display:block;">
        <input type="checkbox" name="rememberme" /> &iquest;Recordarme?
      </div>
    </form>
    <div class="login_footer">
      <strong>AYUDA</strong><br />
      <a href="/password/">&iquest;Olvidaste tu contrase&ntilde;a?</a>
      <hr />
      <a href="/registro/" style="color:green;"><strong>Registrate Ahora!</strong></a>
    </div>
  </div>
</div>
</div>
<? } ?>
<div class="clearBoth"></div>
</div><!-- menu -->
<div class="subMenuContent">
<?php
if($tcat == 'posts') {
?>
<div class="subMenu here" id="subMenuPosts">
<ul class="floatL tabsMenu">
<li<?=($_GET['page'] == 'default' && $_GET['cat'] != 'novatos' ? ' class="here"' : '');?>><a href="/" title="Inicio">Inicio</a></li>
<li<?=($_GET['page'] == 'default' && $_GET['cat'] == 'novatos' ? ' class="here"' : '');?>><a href="/posts/novatos/" title="Novatos">Novatos</a></li>
<li<?=($_GET['page'] == 'search' ? ' class="here"' : '');?>><a href="/posts/buscador/" title="Buscador">Buscador</a></li>
<? if(isLogged()) { ?><li<?=($_GET['page'] == 'new-post' ? ' class="here"' : '');?>><a href="/agregar/" title="Agregar Post">Agregar Post</a></li><? } ?>
<? if(isLogged()) { ?><li<?=($_GET['page'] == 'mod-history' ? ' class="here"' : '');?>><a href="/mod-history/" title="Historial">Historial</a></li><? } ?>
<div class="clearBoth"></div>
</ul>
<div class="floatR filterCat">
<span>Filtrar por Categor&iacute;as:</span>
<select onchange="if(this.options[this.selectedIndex].value == 0) { return false; } else if(this.options[this.selectedIndex].value == 'all') { document.location = '/'; } else { document.location = '/posts/' + this.options[this.selectedIndex].value + '/'; }">
<option value="0" selected="selected">Seleccionar categoria</option>
<option value="all">Ver Todas</option>
<option value="0">-----</option>
<?php
$query = mysql_query("SELECT urlname, name FROM `categories` ORDER BY name ASC");
while($fetch = mysql_fetch_array($query)) {
echo '<option value="'.$fetch['urlname'].'">'.$fetch['name'].'</option>';
}
?>
</select>
</div>
<div class="clearBoth"></div>
</div>
<? } elseif($tcat == 'groups') { ?>
<div class="subMenu here" id="subMenuGroups">
<ul class="floatL tabsMenu">
<li<?=($_GET['page'] == 'groups' ? ' class="here"' : '');?>><a href="/comunidades/" title="Inicio">Inicio</a></li>
<? if(isLogged()) { ?><li<?=($_GET['page'] == 'my-groups' ? ' class="here"' : '');?>><a href="/mis-comunidades/" title="Mis Comunidades">Mis Comunidades</a></li><? } ?>
<li<?=($_GET['page'] == 'dir' ? ' class="here"' : '');?>><a href="/comunidades/dir/" title="Directorio">Directorio</a></li>
<li<?=($_GET['page'] == 'search' ? ' class="here"' : '');?>><a href="/comunidades/buscador/" title="Buscador">Buscador</a></li>
<div class="clearBoth"></div>
</ul>
<div class="floatR filterCat">
<span>Filtrar por Categor&iacute;as:</span>
<select onchange="if(this.value == 0) { return false; } else if(this.value == 'all') { document.location = '/comunidades/'; } else { document.location = '/comunidades/cat/' + this.value + '/'; }">
<option value="0" selected="selected">Seleccionar categoria</option>
<option value="all">Ver Todas</option>
<option value="0">-----</option>
<?php
$query = mysql_query("SELECT urlname, name FROM `group_categories` WHERE sub = '0' ORDER BY name ASC");
while($fetch = mysql_fetch_array($query)) {
echo '<option value="'.$fetch['urlname'].'">'.$fetch['name'].'</option>';
}
?>
</select>
</div>
<div class="clearBoth"></div>
</div>
<? } elseif($tcat == 'tops') { ?>
<div class="subMenu here" id="subMenuPosts">
<ul class="floatL tabsMenu">
<li<?=($currentTop == 'posts' ? ' class="here"' : '');?>><a href="/top/posts/">Posts</a></li>
<li<?=($currentTop == 'groups' ? ' class="here"' : '');?>><a href="/top/comunidades/">Comunidades</a></li>
<li<?=($currentTop == 'group_posts' ? ' class="here"' : '');?>><a href="/top/temas/">Temas</a></li>
<li<?=($currentTop == 'users' ? ' class="here"' : '');?>><a href="/top/usuarios/">Usuarios</a></li>
<div class="clearBoth"></div>
</ul>
</div>
<? /* } elseif($tcat == 'ideas') { ?>
<div class="subMenu here" id="subMenuPosts">
<ul class="floatL tabsMenu">
<li><a href="/top/
<div class="clearBoth"></div>
</ul>
</div>
<? */} else { ?>
<div class="subMenu here" id="subMenuPosts">
<ul class="floatL tabsMenu">
<li><a href="/" title="Inicio">Inicio</a></li>
<li><a href="/posts/novatos/" title="Novatos">Novatos</a></li>
<li><a href="/posts/buscador/" title="Buscador">Buscador</a></li>
<? if(isLogged()) { ?><li><a href="/agregar/" title="Agregar Post">Agregar Post</a></li><? } ?>
<? if(isLogged()) { ?><li<?=($_GET['page'] == 'mod-history' ? ' class="here"' : '');?>><a href="/mod-history/" title="Historial">Historial</a></li><? } ?>
<div class="clearBoth"></div>
</ul>
<div class="floatR filterCat">
<span>Filtrar por Categor&iacute;as:</span>
<select onchange="if(this.value == 0) { return false; } else if(this.value = 'all') { document.location = '/'; } else { document.location = '/posts/' + this.value + '/'; }">
<option value="0" selected="selected">Seleccionar categoria</option>
<option value="all">Ver Todas</option>
<option value="0">-----</option>
<?php
$query = mysql_query("SELECT urlname, name FROM `categories` ORDER BY name ASC");
while($fetch = mysql_fetch_array($query)) {
echo '<option value="'.$fetch['urlname'].'">'.$fetch['name'].'</option>';
}
?>
</select>
</div>
<div class="clearBoth"></div>
</div>
<? } ?>
</div>