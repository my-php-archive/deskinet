<?php
	if(!defined('ok')) { die; }
?>
<div class="perfil-content general">
	<div class="widget">
    <?php
	while($photo = mysql_fetch_assoc($query)) {
		echo '<div class="photo_small clearfix">
						<a target="_blank" href="'.htmlspecialchars($photo['url']).'"><img class="user_photo_img" title="'.htmlspecialchars($photo['desc']).'" border="0" onerror="error_avatar(this);" src="'.htmlspecialchars($photo['url']).'" alt="'.htmlspecialchars($photo['desc']).'" /></a>
		</div>';
	}
	?>
	</div>
</div>
<div class="perfil-sidebar"><?=advert('300x250');?></div>
<script type="text/javascript">$(document).ready(function(){$('img.user_photo_img').tipsy({'gravity':'s'});});</script>