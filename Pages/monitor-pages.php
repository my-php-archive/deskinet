<?php
if(!defined($config['define'])) { die; }
if(!isLogged()) {
	include('./Pages/register.php');
    include('./footer.php');
    die;
}
?>
<div id="cuerpocontainer">
<div class="menu-tabs clearfix">
	<ul>
		<li<?=($monitor_t == '1' ? ' class="selected"' : '');?> id="mpli1"><a href="/monitor/seguidores" onclick="monitor_pages(1);return false;">Seguidores</a></li>
		<li<?=($monitor_t == '2' ? ' class="selected"' : '');?> id="mpli2"><a href="/monitor/siguiendo" onclick="monitor_pages(2);return false;">Siguiendo</a></li>
		<li<?=($monitor_t == '3' ? ' class="selected"' : '');?> id="mpli3"><a href="/monitor/posts" onclick="monitor_pages(3);return false;">Posts</a></li>
		<li<?=($monitor_t == '4' ? ' class="selected"' : '');?> id="mpli4"><a href="/monitor/comunidades" onclick="monitor_pages(4);return false;">Comunidades</a></li>
		<li<?=($monitor_t == '5' ? ' class="selected"' : '');?> id="mpli5"><a href="/monitor/temas" onclick="monitor_pages(5);return false;">Temas</a></li>
	</ul>
    <script type="text/javascript">var mpct = '<?=$monitor_t;?>';</script>
    <img src="/images/loading.gif" width="16" height="16" style="margin-top:9px;display:none;" id="mpli" />
</div>
<ul class="listado" id="mpsr">
<? include('./ajax/monitor-pages.php'); ?>
</ul>
<style type="text/css"> 
.btn_follow a {
	background-image: url('/images/btn_follow.png');
	background-repeat: no-repeat;
	background-position: top left;
display:block;
height:26px;
padding-bottom:0;
padding-left:7px;
padding-right:12px;
padding-top:4px;
width:13px;
}
 
.btn_follow a:hover , .btn_follow a:focus{
	background-position: -33px 0;
}
 
.btn_follow a:active{
	background-position: -66px 0;
}
 
.btn_follow a span {
	display: block;
	width: 19px;
	height: 19px;
	background-image: url('/images/follow_actions.png');
	background-repeat: no-repeat;
}
 /*MOD*/
.btn_follow a span.unfollow {
	background-position: top left;
}
 
.btn_follow a span.follow {
	background-position: 0 -20px;
}
 
.menu-tabs {
	background: #e1e1e1;
	padding: 10px 10px 0 10px ;
}
 
.menu-tabs li {
	float: left;
	margin-right: 10px;
}
 
.menu-tabs li a {
	display: block;
	padding: 10px 15px;
	background: #ebeaea;
	font-size: 14px;
	font-weight: bold;
	color: #2b3ed3!important;
}
 
.menu-tabs li.selected a,.menu-tabs li a:hover {
	background: #fafafa;
	color: #000!important;
}
 
 
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
</style>
<div style="clear:both"></div>
</div>