<?php
if(!defined($config['define'])) { header('Location: /index.php'); }
?>
<ul class="avatarList clearbeta">
<style type="text/css">
.avatarList  {
	margin-bottom: 10px;
}
.avatarList li {
	margin: 2px 1px 2px 2px;
}
.avatarList li img {
	float: left;
	border: 1px solid #CCC;
	padding: 1px;
	background: #FFF;
	width: 16px;
	height: 16px;
	display: block;
}
.avatarList li div.userInfo {
	float: left;
	padding: 4px 0 0 5px;
}
.avatarList li div.userInfo span {
	display: block;
	color: #666
}
</style>
	<?php
	$query = mysql_query("SELECT user FROM `group_members` WHERE `group` = '".$group['id']."' ORDER BY time DESC LIMIT 15");
	while($mem = mysql_fetch_array($query)) {
		$u = mysql_fetch_array(mysql_query("SELECT nick, avatar FROM `users` WHERE id = '".$mem['user']."'"));
        $u['nick'] = htmlspecialchars($u['nick']);
        echo '<li>
		    <a href="/perfil/'.$u['nick'].'/">
			    <img src="/avatares/16/'.$u['avatar'].'" alt="'.$u['nick'].'" onerror="error_avatar(this);" />
		    </a>
		    <div class="userInfo">
			    <a href="/perfil/'.$u['nick'].'/">'.$u['nick'].'</a>
		    </div>
		    <div class="clearBoth"></div>
	    </li> ';
	}
	?>
		</ul>