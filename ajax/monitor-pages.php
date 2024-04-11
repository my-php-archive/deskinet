<?php
if($_GET['_']) {
	if(!$_GET['t'] || !preg_match('/^[0-9]+$/', $_GET['t']) || $_GET['t'] < 1 || $_GET['t'] > 5) { die('Error de usuario'); }
	include('../config.php');
	include('../functions.php');
	$monitor_t = $_GET['t'];
}
if($monitor_t == '1') {
	$query = mysql_query("SELECT u.* FROM users AS u, follows AS f WHERE f.what = '2' && f.who = '".$currentuser['id']."' && u.id = f.user ORDER BY f.time DESC");
	if(mysql_num_rows($query)) {
		while($user = mysql_fetch_assoc($query)) {
			$f = mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && who = '".$user['id']."' && user = '".$currentuser['id']."'"));
			echo '<li class="clearfix">
		<div class="listado-content clearfix etd'.$user['id'].'">
			<div class="listado-avatar">
				<a href="/perfil/'.$user['nick'].'/"><img src="/avatares/32/'.$user['avatar'].'" alt="Avatar de '.$user['nick'].'" /></a>
			</div>
			<div class="txt">
				<a href="/perfil/'.$user['nick'].'/">'.$user['nick'].'</a><br />
				<img src="/images/flags/'.numtoabbr($user['country']).'.png" alt="'.numtocname($user['country']).'" /> <span class="grey">'.htmlspecialchars($user['personal_text']).'</span>
			</div>
		</div>
		<div class="action">
			<div id="unfollow_user" class="btn_follow" style="display:'.($f ? 'block' : 'none').';">
				<a onclick="follow(2, '.$author['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), true, \'.etd'.$user['id'].'\');" title="Dejar de seguir"><span class="unfollow"></span></a>
			</div>
			<div id="follow_user" class="btn_follow" style="display:'.(!$f ? 'block' : 'none').';">
				<a onclick="follow(2, '.$author['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), false, \'.etd'.$user['id'].'\');" title="Seguir usuario"><span class="follow"></span></a>
			</div>
		</div>
	</li>';
		}
	} else {
		echo '<div class="emptyData">No tienes seguidores</div>';
	}
} elseif($monitor_t == '2') {
	$query = mysql_query("SELECT u.* FROM users AS u, follows AS f WHERE f.what = '2' && f.user = '".$currentuser['id']."' && u.id = f.who ORDER BY f.time DESC");
	if(mysql_num_rows($query)) {
		while($user = mysql_fetch_assoc($query)) {
			echo '<li class="clearfix">
		<div class="listado-content clearfix etd'.$user['id'].'">
			<div class="listado-avatar">
				<a href="/perfil/'.$user['nick'].'/"><img src="/avatares/32/'.$user['avatar'].'" alt="Avatar de '.$user['nick'].'" /></a>
			</div>
			<div class="txt">
				<a href="/perfil/'.$user['nick'].'/">'.$user['nick'].'</a><br />
				<img src="/images/flags/'.numtoabbr($user['country']).'.png" alt="'.numtocname($user['country']).'" /> <span class="grey">'.htmlspecialchars($user['personal_text']).'</span>
			</div>
		</div>
		<div class="action">
			<div id="unfollow_user" class="btn_follow">
				<a onclick="follow(2, '.$user['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), true, \'.etd'.$user['id'].'\');" title="Dejar de seguir"><span class="unfollow"></span></a>
			</div>
			<div id="follow_user" class="btn_follow" style="display:none;">
				<a onclick="follow(2, '.$user['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), false, \'.etd'.$user['id'].'\');" title="Seguir usuario"><span class="follow"></span></a>
			</div>
		</div>
	</li>';
		}
	} else {
		echo '<div class="emptyData">No sigues usuarios</div>';
	}
} elseif($monitor_t == '3') {
	$query = mysql_query("SELECT u.nick, u.avatar, p.id, p.title, c.name, c.urlname FROM users AS u, follows AS f, posts AS p, categories AS c WHERE f.what = '1' && f.user = '".$currentuser['id']."' && p.id = f.who && u.id = p.author && c.id = p.cat ORDER BY f.time DESC");
	if(mysql_num_rows($query)) {
		while($post = mysql_fetch_assoc($query)) {
			echo '<li class="clearfix">
		<div class="listado-content clearfix etd'.$post['id'].'">
			<div class="listado-avatar">
				<a href="/perfil/'.$post['nick'].'/"><img src="/avatares/32/'.$post['avatar'].'" alt="Avatar de '.$post['nick'].'" /></a>
			</div>
			<div class="txt">
				<a href="/posts/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a><br />
				<span class="categoriaPost '.$post['urlname'].'"></span> <span class="grey">'.$post['name'].'</span>
			</div>
		</div>
		<div class="action">
			<div id="unfollow_post" class="btn_follow">
				<a onclick="follow(1, '.$post['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), true, \'.etd'.$post['id'].'\');" title="Dejar de seguir"><span class="unfollow"></span></a>
			</div>
			<div id="follow_post" class="btn_follow" style="display:none;">
				<a onclick="follow(1, '.$post['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), false, \'.etd'.$post['id'].'\');" title="Seguir post"><span class="follow"></span></a>
			</div>
		</div>
	</li>';
		}
	} else {
		echo '<div class="emptyData">No sigues posts</div>';
	}
} elseif($monitor_t == '4') {
	$query = mysql_query("SELECT g.id, g.avatar, g.name, g.urlname, c.name AS cname, c.urlname AS curlname FROM follows AS f, groups AS g, group_categories AS c WHERE f.what = '3' && f.user = '".$currentuser['id']."' && g.id = f.who && c.id = g.cat ORDER BY f.time DESC");
	if(mysql_num_rows($query)) {
		while($group = mysql_fetch_assoc($query)) {
			echo '<li class="clearfix">
		<div class="listado-content clearfix etd'.$group['id'].'">
			<div class="listado-avatar">
				<a href="/comunidades/'.$group['avatar'].'/"><img src="'.htmlspecialchars($group['avatar']).'" width="32" height="32" onerror="error_avatar(this);" alt="Imagen de la comunidad" /></a>
			</div>
			<div class="txt">
				<a href="/comunidades/'.$group['urlname'].'/">'.htmlspecialchars($group['name']).'</a><br />
				<span class="categoriaCom '.$group['curlname'].'"></span> <span class="grey">'.$group['cname'].'</span>
			</div>
		</div>
		<div class="action">
			<div id="unfollow_group" class="btn_follow">
				<a onclick="follow(3, '.$group['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), true, \'.etd'.$group['id'].'\');" title="Dejar de seguir"><span class="unfollow"></span></a>
			</div>
			<div id="follow_group" class="btn_follow" style="display:none;">
				<a onclick="follow(3, '.$group['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), false, \'.etd'.$group['id'].'\');" title="Seguir comunidad"><span class="follow"></span></a>
			</div>
		</div>
	</li>';
		}
	} else {
		echo '<div class="emptyData">No sigues comunidades</div>';
	}
} elseif($monitor_t == '5') {
	$query = mysql_query("SELECT u.nick, u.avatar, p.title, p.id, g.urlname, g.name, c.name AS cname, c.urlname AS urlname FROM follows AS f, groups AS g, group_categories AS c, group_posts AS p, users AS u WHERE f.what = '4' && f.user = '".$currentuser['id']."' && p.id = f.who && u.id = p.author && g.id = p.group && c.id = g.cat ORDER BY f.time DESC");
	if(mysql_num_rows($query)) {
		while($post = mysql_fetch_assoc($query)) {
			echo '<li class="clearfix">
		<div class="listado-content clearfix etd'.$group['id'].'">
			<div class="listado-avatar">
				<a href="/perfil/'.$post['nick'].'/"><img src="/avatares/32/'.$post['avatar'].'" alt="Avatar de '.$post['nick'].'" /></a>
			</div>
			<div class="txt">
				<a href="/comunidades/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a><br />
				<span class="categoriaCom '.$post['curlname'].'"></span> <a href="/comunidades/'.$post['urlname'].'/">'.htmlspecialchars($post['name']).'</a> <span class="grey">'.$post['cname'].'</span>
			</div>
		</div>
		<div class="action">
			<div id="unfollow_gpost" class="btn_follow">
				<a onclick="follow(4, '.$post['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), true, \'.etd'.$post['id'].'\');" title="Dejar de seguir"><span class="unfollow"></span></a>
			</div>
			<div id="follow_gpost" class="btn_follow" style="display:none;">
				<a onclick="follow(4, '.$post['id'].', $(this).children(\'span\'), $(this).parent(\'div\'), false, \'.etd'.$post['id'].'\');" title="Seguir tema"><span class="follow"></span></a>
			</div>
		</div>
	</li>';
		}
	} else {
		echo '<div class="emptyData">No sigues temas</div>';
	}
}
?>