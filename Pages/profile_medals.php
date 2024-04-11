<?php
	if(!defined('ok')) { die; }
?>
<div class="perfil-content">
<div class="title-w clearfix">
	<h2><?=($user['id'] == $currentuser['id'] ? 'Tus medallas' : 'Medallas de '.$user['nick']);?></h2>
</div>
<ul class="listado">
<?php
	while($medal = mysql_fetch_assoc($query)) {
		switch(date('n', $medal['time'])) {
			case '1': $month = 'Enero'; break;
			case '2': $month = 'Febrero'; break;
			case '3': $month = 'Marzo'; break;
			case '4': $month = 'Abril'; break;
			case '5': $month = 'Mayo'; break;
			case '6': $month = 'Junio'; break;
			case '7': $month = 'Julio'; break;
			case '8': $month = 'Agosto'; break;
			case '9': $month = 'Septiembre'; break;
			case '10': $month = 'Octubre'; break;
			case '11': $month = 'Noviembre'; break;
			case '12': $month = 'Diciembre'; break;
		}
		list(,$type) = explode('-', $medal['type']);
		$type = ucfirst($type);
		echo '<li class="clearfix">
				<div class="listado-content clearfix">
					<div class="medalla '.$medal['type'].'-big" title="'.$type.'">
						<span></span>
					</div>
				<div class="txt">
					<span class="medalla-title">'.$medal['name'].'</span> - <span class="grey">'.date('j', $medal['time']).' de '.$month.' de '.date('Y', $medal['time']).'</span><br />
					<span class="grey">'.(empty($medal['link']) ? '' : '<a href="'.$medal['link'].'" title="'.htmlspecialchars($medal['link_title']).'">'.(strlen($medal['link_title']) > 35 ? htmlspecialchars(substr($medal['link_title'], 0, 32)).'...' : htmlspecialchars($medal['link_title'])).'</a> - ').$medal['desc'].'</span>
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