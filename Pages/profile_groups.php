<?php
	if(!defined('ok')) { die; }
?>
<div class="perfil-content">
<div class="title-w clearfix">
	<h2>Comunidades en las que participa<?=($user['id'] == $currentuser['id'] ? 's' : ' '.$user['nick']);?></h2>
</div>
<ul class="listado">
<?php
	while($group = mysql_fetch_assoc($query)) {
		$cat = mysql_fetch_assoc(mysql_query("SELECT name, urlname FROM `group_categories` WHERE id = '".$group['cat']."'"));
		echo '<li class="clearfix">
			<div class="listado-content clearfix">
				<div class="listado-avatar">
					<a href="/comunidades/'.$group['urlname'].'/"><img src="'.htmlspecialchars($group['avatar']).'" alt="" onerror="error_avatar(this);" width="32" height="32" /></a>
				</div>
				<div class="txt">
					<a href="/comunidades/'.$group['urlname'].'/">'.htmlspecialchars($group['name']).'</a><br />
					<span class="categoriaCom '.$cat['urlname'].'"></span> <span class="grey">'.$cat['name'].'</span>
				</div>
			</div>
		</li>';
	}
	?>
</ul>
</div>
<div class="perfil-sidebar"><?=advert('300x250');?></div>
<?php
// aki faltan estilos para botones de seguir k no estan, para el menu-tabs ese (k no hay, es menu-tabs-perfil y no MUAHAHAHA) y para el paginador; cuidado!
?>
<style type="text/css">
.listado li {
	border-top: 1px solid #FFF;
	background: #fafafa;
	border-bottom: 1px dotted #CCC;
}
 
.listado li:first-child {
	border-top: none;
}
 
 
 
.listado li:hover {
	background: #EEE;
}
 
.listado a {
	color: #2b3ed3!important;
	font-weight: bold;
}
 
.listado .listado-avatar {
	float:left;
	margin-right: 10px;
}
 
.listado .listado-avatar img {
	padding: 1px;
	background: #FFF;
	border: 1px solid #CCC;	
	width: 32px;
	height: 32px;
}
 
.listado .listado-content {
	padding: 5px;
	float: left;
}
 
.listado .txt  {
	float: left;
	line-height:18px;
}
 
.listado .txt .grey {
	color: #999;
}
 
.listado .action {
	float: right;
	border-left: 1px solid #d6d6d6;
	background: #EEE;
	padding: 8px;
} 
 
/* new clearfix */
.clearfix:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
	}
* html .clearfix             { zoom: 1; } /* IE6 */
*:first-child+html .clearfix { zoom: 1; } /* IE7 */
</style>