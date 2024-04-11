<?php if(!defined('ok')) { die; } ?>
<div class="perfil-content">
<h2>Usuarios que <?=($user['id'] == $currentuser['id'] ? 'sigues' : $user['nick'].' sigue');?></h2>
<ul class="listado">
<?php
while($user = mysql_fetch_assoc($query)) {
	echo '<li class="clearfix">
		<div class="listado-content clearfix">
			<div class="listado-avatar">
				<a href="/perfil/'.htmlspecialchars($user['nick']).'/"><img src="/avatares/32/'.$user['avatar'].'" alt="" /></a>
			</div>
			<div class="txt">
				<a href="/perfil/'.htmlspecialchars($user['nick']).'/">'.htmlspecialchars($user['nick']).'</a><br />
				<img src="/images/flags/'.numtoabbr($user['country']).'.png" alt="'.numtocname($user['country']).'" title="'.numtocname($user['country']).'" /> <span class="grey">'.htmlspecialchars($user['personal_text']).'</span>
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