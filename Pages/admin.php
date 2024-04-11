<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!isLogged()) { die; }
if(!isAllowedTo('showpanel')) { die('xD &iquest;A donde vas mangas verdes?'); }
define('admin', true);
?>
<div id="cuerpocontainer">
<div class="container228 floatL">
	<div class="box_title">
		<div class="box_txt mis_opciones">Opciones</div>
		<div class="box_rss"/></div>
	</div>
	<div class="box_cuerpo">
    	<? if(isAllowedTo('notes')) { ?><img src="/images/icon-email.png" align="absmiddle" /> <a href="/admin/notas/">Notas</a><? } ?>
        <? if(isAllowedTo('complaints')) { ?><br /><img class="icons admin_denuncias" src="/images/space.gif" align="absmiddle" width="16" height="16" /> <a href="/admin/denuncias/">Denuncias</a><? } ?>
        <? if(isAllowedTo('editsettings')) { ?><br /><img src="/images/icon-editar-opciones.png" align="absmiddle" /> <a href="/admin/configuracion/">Configuraci&oacute;n</a><? } ?>
    <hr />
		<img src="/images/icon-perfil.png" align="absmiddle" /> <b>Usuarios:</b>
		<ul class="menu_cuenta">
        	<? if(isAllowedTo('userlist')) { ?><li> <a href="/admin/lista-usuarios/" class="m-menu">Lista de usuarios</a></li><? } ?>
			<? if(isAllowedTo('changerank')) { ?><li> <a href="/admin/dar-rango/" class="m-menu">Dar rango</a></li><? } ?>
			<? if(isAllowedTo('banlist')) { ?><li> <a href="/admin/lista-bans/" class="m-menu">Lista de baneados</a></li><? } ?>
			<? if(isAllowedTo('ban')) { ?><li> <a href="/admin/banear/" class="m-menu">Banear usuario</a></li><? } ?>
			<? if(isAllowedTo('ban')) { ?><li> <a href="/admin/desbanear/" class="m-menu">Desbanear usuario</a></li><? } ?>
			<? if(isAllowedTo('adminuser')) { ?><li> <a href="/admin/auser/" class="m-menu">Modificar usuario</a></li><? } ?>
			<? if(isAllowedTo('editsettings')) { ?><li> <a href="/admin/controlips/" class="m-menu">Control de IPs</a></li><? } ?>
		</ul>
<? if(isAllowedTo('ranks')) { ?>
    <hr />
		<img src="/images/space.gif" align="absmiddle" class="systemicons rango6" style="display:inline;" /> <b>Rangos:</b>
		<ul class="menu_cuenta">
        	<li> <a href="/admin/lista-rangos/" class="m-menu">Lista de rangos</a></li>
			<li> <a href="/admin/crear-rango/" class="m-menu">Crear rango</a></li>
		</ul>
        <? } ?>
	</div>
</div>
<?php
$sa = (!$_GET['sa'] || !file_exists($_SERVER['DOCUMENT_ROOT'].'/adm/'.$_GET['sa'].'.php') ? 'index' : $_GET['sa']);
?>
		<div id="form_div" class="container702 floatR">
			<div class="box_title">
				<div class="box_txt"><?=$txt['title_'.$sa];?></div>
				<div class="box_rss"></div>
			</div>
			<div class="box_cuerpo" id="admin_content">
				<? include($_SERVER['DOCUMENT_ROOT'].'/adm/'.$sa.'.php'); ?>
			</div>
		</div>
	<div style="clear:both"></div>
    </div><!--Cc-->