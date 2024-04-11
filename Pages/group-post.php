<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if($groupdie) {
	die(error('OOPS!', 'No existe la comunidad', 'Ir al &iacute;ndice de comunidades', '/comunidades/'));
} elseif($np) {
	die(error('OOPS!', 'No existe el tema', 'Ir al &iacute;ndice de comunidades', '/comunidades/'));
} elseif($gom) {
	die(error('OOPS!', 'Debes ser miembro de la comunidad para ver este post', '&Iacute;ndice de comunidades', '/comunidades/'));
} elseif($gng) {
	die(error('OOPS!', 'Este post no corresponde al grupo indicado', '&Iacute;ndice de comunidades', '/comunidades/'));
}
?>
<div id="cuerpocontainer">
<div class="comunidades">
<div class="breadcrump">
<ul>
<li class="first"><a href="/comunidades/" title="Comunidades">Comunidades</a></li><li><a href="/comunidades/cat/<?=$cat['urlname'];?>/" title="<?=$cat['name'];?>"><?=$cat['name'];?></a></li><li><a href="/comunidades/<?=$group['urlname'];?>/"><?=htmlspecialchars($group['name']);?></a></li><li><?=htmlspecialchars($post['title']);?></li><li class="last"></li>
</ul>
</div>
 
	<div style="clear:both"></div>
 
 
<div id="izquierda">
<?php include('./Pages/groups-left.php');?>
</div>
<div id="centroDerecha">
 
	
 
<div id="temaComunidad">
  <div class="temaBubble">
    <div class="bubbleCont">
      <div class="Container">
        <div class="TemaCont">
          <div class="postBy">
        	  <a href="/perfil/<?=$author['nick'];?>/">
          		<img title="Ver perfil de <?=$author['nick'];?>" alt="Ver perfil de <?=$author['nick'];?>" class="avatar" src="/avatares/100/<?=$author['avatar'];?>" onerror="error_avatar(this);" />
          	</a>
          	<strong>
							<a title="Ver perfil de <?=$author['nick'];?>" href="/perfil/<?=$author['nick'];?>/"><?=$author['nick'];?></a>
          	</strong>
            <br />
            <?php list($group_rank) = mysql_fetch_row(mysql_query("SELECT rank FROM `group_members` WHERE user = '".$author['id']."' && `group` = '".$group['id']."'"));?>
            <span title="Rango en la comunidad"><?=groupRankName($group_rank);?></span>
            <br />
			<span style="position:relative;"><?php
				$query = mysql_query("SELECT time FROM `connected` WHERE user = '".$author['id']."'");
				if(mysql_num_rows($query)) {
					list($oty) = mysql_fetch_row($query);
					$dif = time()-$oty;
					if($dif >= 600) {
						echo '<img src="/images/space.gif" width="16" height="16" style="margin-left:-3px;margin-right:-2px;display:inline;" class="systemicons ocupado" title="Ocupado" />';
					} elseif($dif >= 300) {
						echo '<img src="/images/space.gif" width="16" height="16" style="margin-left:-3px;margin-right:-2px;display:inline;" class="systemicons ausente" title="Ausente" />';
					} else {
						echo '<img src="/images/space.gif" width="16" height="16" style="margin-left:-3px;margin-right:-2px;display:inline;" class="systemicons online" title="Conectado" />';
					}
				} else {
					echo '<img src="/images/space.gif" width="16" height="16" style="margin-left:-3px;margin-right:-2px;display:inline;" class="systemicons offline" title="Desconectado" />';
				}
			?><img src="/images/space.gif" width="16" height="16" style="margin-right:1px;display:inline;" class="systemicons rango<?=$author['rank'];?>" title="<?=rankName($author['rank']);?>" /><img src="/images/space.gif" width="16" height="16" style="margin-right:1px;display:inline;" class="systemicons sexo<?=($author['gender'] == 1 ? 'M' : 'F');?>" title="<?=($author['gender'] == 1 ? 'Hombre' : 'Mujer');?>" /><img src="/images/flags/<?=numtoabbr($author['country']);?>.png" width="16" height="11" style="display:inline;margin-bottom:2px;margin-right:3px;" alt="<?=numtocname($author['country']);?>" title="<?=numtocname($author['country']);?>" /><a href="/mensajes/para/<?=$author['nick'];?>/"><img src="/images/space.gif" width="16" height="16" style="display:inline;margin-right:3px;" class="systemicons messages" title="Enviar mensaje" /></a><?php
            $far = mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && who = '".$author['id']."' && user = '".$currentuser['id']."'"));
			echo '<img id="follow_user" src="/images/space.gif" width="16" height="16" style="display:'.($far ? 'none' : 'inline').';cursor:pointer;" class="systemicons follow" title="Seguir usuario" onclick="follow(2, '.$author['id'].', this, this, false, false, true);" /><img id="unfollow_user" src="/images/space.gif" width="16" height="16" style="display:'.(!$far ? 'none' : 'inline').';cursor:pointer;" class="systemicons unfollow" title="Dejar de seguir" onclick="follow(2, '.$author['id'].', this, this, true, false, true);" />';
			?></span>
        	</div><!-- END postBy -->
        	<div class="temaCont" style="width:600px">
        	  <div class="floatL">
        	    <h1 class="titulopost"><?=htmlspecialchars($post['title']);?></h1>
        	  </div>
              <?php
              if(isAllowedTo('delete_post_groups')) { echo '<script type="text/javascript">var cdp = true;</script>'; }
			  if($currentuser['id'] == $author['id'] || $currentuser['group']['rank'] >= 3 || isAllowedTo('stick_post_groups') || isAllowedTo('delete_post_groups') || isAllowedTo('edit_post_groups')) { ?>
        	  <div class="floatR">
			<? if(isAllowedTo('stick_post_groups') || $currentuser['group']['rank'] >= 3) {
					$fpt = ($post['sticky'] == '0' ? 'Fijar' : 'Desfijar');
					echo '<a class="btnActions" href="#" onclick="groups_fijar_post('.$post['id'].', \''.$fpt.' tema\'); return false;" title="'.$fpt.' Post">
						<img src="/images/fijar.gif" alt="'.$fpt.'" /> '.$fpt.'
					</a>';
				} 
				if(isAllowedTo('delete_post_groups') || $currentuser['id'] == $author['id'] || $currentuser['group']['rank'] >= 3) {
                        echo '<a class="btnActions" href="#" onclick="groups_delete_post('.$post['id'].($currentuser['id'] == $author['id'] ? ', true' : '').');return false;" title="Borrar tema">
          				<img src="/images/borrar.png" alt="Borrar" /> Borrar
          			</a>';
				}
				if(isAllowedTo('edit_post_groups') || $currentuser['id'] == $author['id'] || $currentuser['group']['rank'] >= 3) {
          				echo '<a class="btnActions" href="/comunidades/'.$group['urlname'].'/editar-tema/'.$post['id'].'/" title="Editar tema">
          				<img src="/images/editar.png" alt="Editar" /> Editar
          			</a>';
                         echo '</div>';
				}
			  }
									  ?>
        		<div class="clearBoth"></div>
 
        		<hr />
        		<p>
          	  <?=bbcode($post['message']);?></p>
              
      	</div> <!-- END TemaCont -->
        <?php
		if($post['poll'] == '1') {
            $q = mysql_query("SELECT id, options, name, cvote FROM `polls` WHERE post = '".$post['id']."'");
			$poll = mysql_fetch_assoc($q);
			$vrows = mysql_num_rows($q = mysql_query("SELECT * FROM `poll_votes` WHERE poll = '".$poll['id']."' && user = '".$currentuser['id']."'"));
			if($vrows) {
				$vote = mysql_fetch_assoc($q);
			}
			$options2 = explode('^', htmlspecialchars($poll['options']));
			$options = array();
			foreach($options2 as $op) {
				$e = explode('*', $op);
				$options[$e[0]] = $e[1];
			}
			unset($options2);
		?>
         <div class="postPoll floatL">
        	  <div class="title">Encuesta: <?=htmlspecialchars($poll['name']);?></div>
              <div id="vote" style="display:<?=($vrows && $poll['cvote'] == '0' ? 'none' : 'block');?>;">
              <?php
			foreach($options as $n => $op) {
				echo '<label'.($vrows ? ' class="disabled'.($vote['option']==$n ? ' myVote' : '').'"' : '').'><input type="radio" name="poll" value="'.$n.'"'.($vrows ? ' disabled'.($vote['option']==$n ? ' checked' : '') : '').' /> '.$op.'</label>';
			}
			  ?>
              </div>
              <div id="results" style="display:<?=($vrows && $poll['cvote'] == '0' ? 'block' : 'none');?>;">
              <?php
				$q = mysql_query("SELECT COUNT(*), `option` FROM `poll_votes` WHERE poll = '".$poll['id']."' GROUP BY `option` ORDER BY `option` ASC") or die(mysql_error());
				if(mysql_num_rows($q)) {
					while(list($cv, $op) = mysql_fetch_row($q)) {
						$nvotes[$op] = $cv;
					}
					$c = count($options);
					$tvotes = 0;
					for($i=1;$i<=$c;$i++) {
						if(!$nvotes[$i]) { $nvotes[$i] = 0; }
						$tvotes += $nvotes[$i];
					}
				} else {
					$nvotes = array();
					foreach($options as $n => $op) {
						$nvotes[$n] = 0;
					}
				}
			foreach($options as $n => $op) {
				$percent[$n] = ($tvotes == 0 ? 0 : round($nvotes[$n]*100/$tvotes));
				echo '<label'.($vrows && $vote['option']==$n ? ' class="myVote"' : '').'><p title="'.$percent[$n].'%"><img src="/images/space.gif" style="width:'.($percent[$n]*2).'px;"></p> '.$op.' ('.$nvotes[$n].' votos)</label>';
			}
			  ?>
              </div>
              <script type="text/javascript">var poll_id = <?=$poll['id'];?>;var iVj = <?=($vrows ? 'true' : 'false');?>;var iVn = false;</script>
              <a class="btn_g floatL<?=($vrows ? ' disabled' : '');?>" href="#" onclick="poll_vote(this);return false;">Votar</a><a class="btn_g floatL" style="margin-left:5px;" href="#" onclick="poll_r(this);return false;"><?=($vrows && $poll['cvote'] == '0' ? 'Ver opciones' : 'Ver resultados');?></a><img id="vl" style="margin-left:5px;margin-top:5px;display:none;" src="/images/loading.gif" width="16" height="16" />
        	</div><!-- END postPoll -->
        <? } ?>
        <div class="clearBoth"></div>
        <div class="infoPost floatL">
      		<div class="shareBox" style="width:15%">
      			<strong class="title">Compartir:</strong>
            <a class="delicious socialIcons" title="Delicious" href="http://del.icio.us/post?url=http://<?=$config['script_url'];?>/comunidades/<?=$group['urlname'];?>/<?=$post['id'];?>/<?=url($post['title']);?>.html" rel="nofollow" target="_blank"></a>
            <a class="facebook socialIcons" title="Facebook" href="http://www.facebook.com/share.php?u=http://<?=$config['script_url'];?>/comunidades/<?=$group['urlname'];?>/<?=$post['id'];?>/<?=url($post['title']);?>.html" rel="nofollow" target="_blank"></a>
            <a class="digg socialIcons" title="Digg" href="http://digg.com/submit?phase=2&url=http://<?=$config['script_url'];?>/comunidades/<?=$group['urlname'];?>/<?=$post['id'];?>/<?=url($post['title']);?>.html" rel="nofollow" target="_blank"></a>
            <a class="twitter socialIcons" title="Twitter" href="http://twitter.com/home?status=http://<?=$config['script_url'];?>/comunidades/<?=$group['urlname'];?>/<?=$post['id'];?>/<?=url($post['title']);?>.html" rel="nofollow" target="_blank"></a>
                  		</div><!-- END shareBox -->
      		<div class="rateBox" style="width:15%">
      			<strong class="title">Calificar:</strong>
      	  	<span id="actions">
        			<a href="#" class="thumbs thumbsUp" title="Votar positivo" onclick="groups_vote_post(<?=$post['id'];?>, 1);return false;"></a>
        			<a href="#" class="thumbs thumbsDown" title="Votar negativo" onclick="groups_vote_post(<?=$post['id'];?>, -1);return false;"></a>
        		</span>
      			<span <?=($post['points'] == 0 ? 'style="visibility:hidden;" ' : '');?>id="votos_total" class="color_<?=($post['points'] > 0 ? 'green' : 'red');?>"><?=($post['points'] > 0 ? '+' : '-').$post['points'];?></span>
      		</div><!-- END RateBox -->
      		<div class="ageBox">
      			<strong class="title">Creado</strong>
      			<span style="font-size:11px;" title="<?=timefrom($post['time']);?>"><?=timefrom($post['time']);?></span>
      		</div><!-- END Creadobox -->
      		<div class="metaBox" style="width: 15%">
	    			<strong class="title">Visitas:</strong>
      			<span style="font-size:11px"><?=$post['visits'];?></span>
     			</div><!-- END Visitas -->
     			
     			<div class="metaBox" style="width: 15%">
     				<strong class="title">Seguidores</strong>
     				<span style="font-size:11px" class="tema_notifica_count" id="numf_gpost"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '4' && who = '".$post['id']."'"));?></span>
     				</div><!-- END Visitas -->
     				
     				<div class="followBox">
     				<?php
	$rows = mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '4' && who = '".$post['id']."' && user = '".$currentuser['id']."'"));
    echo '<a id="unfollow_gpost" style="display:'.($rows ? 'block' : 'none').';" class="btn_g unfollow floatR" href="'.(isLogged() ? '#" onclick="follow(4, '.$post['id'].', $(this).children(\'span\'), this, true);return false;' : '/registro/').'"><span class="icons unfollow">Dejar de seguir</span></a>
								<a id="follow_gpost" style="display:'.(!$rows ? 'block' : 'none').';" class="btn_g follow floatR" href="'.(isLogged() ? '#" onclick="follow(4, '.$post['id'].', $(this).children(\'span\'), this);return false;' : '/registro/').'"><span class="icons follow">Seguir tema</span></a>';
							?>
                            </div>
      		<div class="clearBoth"></div>
      		<div class="tagsBox">
      			<strong>Tags:</strong>
      			<ul><?php
					$exp = explode(',', $post['tags']);
					foreach($exp as $tag) {
						$tagsshow .= ', <li>'.htmlspecialchars($tag).'</li>';
					}
					echo substr($tagsshow, 2);
				?></ul>
      		</div><!-- END tagsBox -->
     	</div><!-- END infoPost -->

      	<div class="clearBoth"></div>
        
      	</div>
      </div>
    </div>
  </div>
</div>
<div class="clearBoth"></div>
<div id="respuestas">
	
	<a name="respuestas"></a>
	<a href="/rss/comunidades/tema-respuestas/<?=$post['id'];?>/" title="&Uacute;ltimas Respuestas"><span class="floatL systemicons sRss" style="position: relative; z-index: 87;margin-right: 5px"></span></a>
	<h1 class="titulorespuestas"><span id="comm_num"><?=mysql_num_rows(mysql_query("SELECT * FROM `group_comments` WHERE post = '".$post['id']."'"));?></span> Respuestas</h1>
	<hr />
    <?php
	if($_GET['comment'] && mysql_num_rows(mysql_query("SELECT id FROM `group_comments` WHERE id = '".mysql_clean($_GET['comment'])."' && post = '".$post['id']."'"))) {
		$cpage = ceil(mysql_num_rows(mysql_query("SELECT id FROM `group_comments` WHERE id <= '".mysql_clean($_GET['comment'])."' && post = '".$post['id']."'"))/20);
	} else {
		$cpage = ceil(mysql_num_rows(mysql_query("SELECT id FROM `group_comments` WHERE  post = '".$post['id']."'"))/20);
	}
	$i = ($cpage-1)*20;
	$tcom = mysql_num_rows(mysql_query("SELECT * FROM `group_comments` WHERE post = '".$post['id']."'"));
	$tcomp = ceil($tcom/20);
	?>
    <script type="text/javascript">var dh = window.location.hash; var comm_currentpage = <?=$cpage;?>; var comm_totalpages = <?=$tcomp;?>; var comm_tcom = <?=$tcom;?>; var post_private = <?=($post['private'] ? 1 : 2);?>; var post_id = <?=$post['id'];?>; var post_author = <?=$author['id'];?>; var group_id = <?=$group['id'];?>;</script>
	<!-- Paginado -->
	<?php
    
	echo '<div class="paginadorCom" id="paginador1" style="display:'.($tcom > 20 ? 'block' : 'none').';">
      <div class="before floatL">
      	      	
      		<a href="#" onclick="comments_goto((comm_currentpage-1), true);return false;" id="comm_b_1"><b>&laquo; Anterior</b></a>
      	      </div>
      <div style="float:left;width: 530px">
        <ul id="comm_ul_1">';
		for($x=1;$x<=$tcomp;$x++) {
           echo '<li class="numbers"><a id="pc_1_'.$x.'" href="#" onclick="comments_goto('.$x.', true);return false;"'.($x == $cpage ? ' class="here"' : '').'>'.$x.'</a></li>';
		}
		echo '</ul>
      </div>
      <div class="floatR next">
                	<a href="#" onclick="comments_goto((comm_currentpage+1), true);return false;" id="comm_n_1" class="desactivado"><b>Siguiente &raquo;</b></a>
              </div>
      <div class="clearBoth"></div>
    </div>
	<div id="comentarios">';
	include('./ajax/group-comments.php');
	
	echo '</div><div class="paginadorCom" id="paginador2" style="display:'.($tcom > 20 ? 'block' : 'none').';">
      <div class="before floatL">
      	      	
      		<a href="#" onclick="comments_goto((comm_currentpage-1), true);return false;" id="comm_b_2"><b>&laquo; Anterior</b></a>
      	      </div>
      <div style="float:left;width: 530px">
        <ul id="comm_ul_2">';
		// NOTA: Se suma 1 a $cpage, porque en ajax/post-comments.php se resta 1!
		$cpage++;
		for($x=1;$x<=$tcomp;$x++) {
           echo '<li class="numbers"><a id="pc_2_'.$x.'" href="#" onclick="comments_goto('.$x.', true);return false;"'.($x == $cpage ? ' class="here"' : '').'>'.$x.'</a></li>';
		}
		echo '</ul>
      </div>
      <div class="floatR next">
                	<a href="#" onclick="comments_goto((comm_currentpage+1), true);return false;" id="comm_n_2" class="desactivado"><b>Siguiente &raquo;</b></a>
              </div>
      <div class="clearBoth"></div>
    </div>';
	?>
    <!--</div>-->
 
</div><!-- #respuestas -->
<a name="respuestas-abajo"></a>
 
<!-- Paginado -->
<div class="clearBoth"></div>
 <? if($currentuser['isMember'] && $post['comments'] == '1') { ?>
<div class="miRespuesta">
	<div id="procesando"><div id="tema"></div></div>
	<div class="answerInfo">
	   <img src="/avatares/48/<?=$currentuser['avatar'];?>" style="position:relative;z-index:1" class="avatar-48 lazy" width="48" height="48" alt="Avatar de <?=htmlspecialchars($currentuser['nick']);?>" onerror="error_avatar(this);" />
	</div>
	<div class="answerTxt">
	  <div class="Container">
			<div class="add_resp_error"></div>
						<textarea id="body_comm" class="onblur_effect autogrow" tabindex="1" title="Escribir una respuesta" style="resize:none;" onfocus="if(this.value=='Escribir una respuesta'){this.value='';}" onblur="if(this.value==''){this.value='Escribir una respuesta';}">Escribir una respuesta</textarea>
			<div class="buttons floatL">
            <br class="clear" />
				<input type="button" onclick="add_comment(<?=$post['id'];?>, document.getElementById('body_comm').value, <?=$group['id'];?>);" id="button_add_resp" class="mBtn btnOk" value="Responder" tabindex="2" />
			</div>
            <div class="floatR">
            <br class="clear" />
						<a style="font-size:11px" href="javascript:openpopup()">M&aacute;s Emoticones</a>
						<script type="text/javascript">function openpopup(){ var winpops=window.open("/emoticones.php","","width=180px,height=500px,scrollbars,resizable");}</script>
					</div>
					<div id="emoticons" style="float:right;">
            <br class="clear" />
								
					<?php
					$emoticonos = array(':)' => 'sonrisa', ';)' => 'guino', ':roll:' => 'duda', ':P' => 'lengua', ':D' => 'alegre', ':(' => 'triste', 'X(' => 'odio', ':cry:' => 'llorando', ':twisted:' => 'endiablado', ':|' => 'serio', ':?' => 'duda2', ':cool:' => 'picaro', '^^' => 'sonrizota', ':oops:' => 'timido', '8|' => 'increible', ':F' => 'babas');
					foreach($emoticonos as $code => $name) {
						echo '<a href="#" smile="'.$code.'"><img src="/images/space.gif" align="absmiddle" class="emoticono '.$name.'" alt="'.$name.'" title="'.$name.'" style="margin-right:10px;" /></a>';
					}
					?>
					</div>
					<div class="clearfix"></div>
		</div>
	</div>
</div>
<? } elseif(!$currentuser['isMember']) { ?>
<br />
<div class="emptyData">Para poder comentar en la comunidad necesitas <a href="#" onclick="participar_comunidad(<?=$group['id'];?>, <?=groupRankName($group['default_rank']);?>);return false;">unirte</a></div>
<? } ?>
</div>

</div><div style="clear:both"></div>
</div> <!-- cuerpocontainer -->