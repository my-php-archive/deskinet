<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!$_GET['id'] && !$_GET['nick']) { $id = $currentuser['id']; }
if($_GET['id'] && !mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE id = '".mysql_clean($_GET['id'])."'"))) { $id = $currentuser['id']; } else { $id = mysql_clean($_GET['id']); }
if($_GET['nick'] && !mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE nick = '".mysql_clean($_GET['nick'])."'"))) { $nick = $currentuser['nick']; } else { $nick = mysql_clean($_GET['nick']); }
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE ".($id ? 'id' : 'nick')." = '".($id ? $id : $nick)."'"));~
$sl = (!isLogged() ? 3 : 2);
if($currentuser['id'] == $user['id']) { $sl = 0; }
// faltaria para los amigos...

// BLOQUEADOS!
$currentuser['blocked_array'] = (empty($currentuser['blocked']) ? array() : explode(',', $currentuser['blocked']));
?>
<script type="text/javascript">document.title = '<?=$config['script_name'];?> - Perfil de <?=$user['nick'];?>';</script>
<div id="cuerpocontainer">
<div id="perfil">
	<h1><span>Perfil de</span> <?=$user['nick'];?></h1>
	<? if($user['personal_text'] != '') { echo '<h3>'.htmlspecialchars($user['personal_text']).'</h3>'; } ?>
	<div class="contenido">
		<div class="izquierda">
			<div class="dataUser">
				<div class="avaPerfil">
										<img src="<?=$user['avatar'];?>" width="120" height="120" vspace="4" hspace="7" onerror="error_avatar(this);" />
										<div class="sendMsg"><span class="systemicons messages" style="margin-right:5px"></span><a href="/mensajes/para/<?=$user['nick'];?>/" title="Enviar Mensaje Privado">Enviar Mensaje</a></div>
				</div><!-- AVA PERFIL -->
									<?php
									if($currentuser['rank'] == 8 || $currentuser['rank'] == 6) {
										$banned = (mysql_num_rows(mysql_query("SELECT * FROM `bans` WHERE user = '".$user['id']."' && active = '1'")) ? true : false);
										echo '<script type="text/javascript">var currentptime = '.time().';</script><a style="margin-right:80px;display:'.($banned ? 'none' : 'block').';" id="ban_user_1" href="#" onclick="ban_user('.$user['id'].', 1);return false;" class="bloquearU">Banear</a><a style="margin-right:80px;display:'.($banned ? 'block' : 'none').';" id="ban_user_2" href="#" onclick="ban_user('.$user['id'].', 2);return false;" class="desbloquearU">Desbanear</a>';
									}
									if(isLogged() && $currentuser['id'] != $user['id']) {
										echo '<a id="buser_1_'.$user['id'].'" class="bloquearU" href="#" onclick="buser('.$user['id'].', true);return false;" style="display:'.(in_array($user['id'], $currentuser['blocked_array']) ? 'none' : 'block').';">Bloquear</a><a id="buser_2_'.$user['id'].'" class="desbloquearU" href="#" onclick="buser('.$user['id'].', false);return false;" style="display:'.(in_array($user['id'], $currentuser['blocked_array']) ? 'block' : 'none').';">Desbloquear</a>';
									}
									?>
								<ul class="basicData">
										
										<li> <strong> Ciudad:</strong> <span><?=$user['city'];?></span></li>
											<li> <strong>Mensajero:</strong>  <span><?=$user['messenger_type'];?>: <?=$user['messenger'];?></span></li>
										<li><strong>Es usuario desde:</strong> <span><?=udate('Y-m-d H:i:s', $user['reg_time']);?></span></li>
					<li class="moreData" style="display:none;"><a name="mDa"></a>
					<ul>
						<?php
								unset($sm);
								if($user['studies_show'] >= $sl && $user['studies'] != 0) {
									$sm = true;
									echo '<li><strong>Estudios:</strong>  <span>';
									switch($user['studies']) {
										case '1': echo 'Sin estudios'; break;
										case '2': echo 'Primario completo'; break;
										case '3': echo 'Secundario en curso'; break;
										case '4': echo 'Secundario completo'; break;
										case '5': echo 'Terciario en curso'; break;
										case '6': echo 'Terciario completo'; break;
										case '7': echo 'Universitario en curso'; break;
										case '8': echo 'Universitario completo'; break;
										case '9': echo 'Post-grado en curso'; break;
										case '10': echo 'Post-grado completo'; break;
									}
									echo '</span></li><br />';
								}
								if($user['languages_show'] >= $sl && ($user['language_spanish'] != 0 || $user['language_english'] != 0 || $user['language_portuguese'] != 0 || $user['language_italian'] != 0 || $user['language_german'] != 0 || $user['language_other'] != 0)) {
									$sm = true;
									echo '<strong style="color:#FF6600">Idiomas:</strong><hr />';
									$langs = array('spanish' => 'Castellano', 'english' => 'Ingl&eacute;s', 'portuguese' => 'Portugu&eacute;s', 'italian' => 'Italiano', 'german' => 'Alem&aacute;n', 'other' => 'Otro');
									foreach($langs as $key => $value) {
										if($user['language_'.$key] == 0) { continue; }
										echo '<li><strong>'.$value.':</strong>  <span>';
										switch($user['language_'.$key]) {
											case '1': echo 'B&aacute;sico'; break;
											case '2': echo 'Intermedio'; break;
											case '3': echo 'Fluido'; break;
											case '4': echo 'Nativo'; break;
										}
										echo '</span></li><br />';
									}
								}
								if((!empty($user['work']) && $user['work_show'] >= $sl) || (!empty($user['company']) && $user['company_show'] >= $sl) || ($user['income'] != 0 && $user['income_show'] >= $sl) || ($user['work_sector'] != 0 && $user['work_sector_show'] >= $sl) || (!empty($user['work_interests']) && $user['work_interests_show'] >= $sl) || (!empty($user['work_skills']) && $user['work_skills_show'] >= $sl)) {
									$sm = true;																																																																																							
									echo '<strong style="color:#FF6600">Datos profesionales:</strong><hr />';
									if(!empty($user['work']) && $user['work_show'] >= $sl) { echo '<li><strong>Profesi&oacute;n:</strong> <span> '.htmlspecialchars($user['work']).'</span></li>'; }
									if(!empty($user['company']) && $user['company_show'] >= $sl) { echo '<li><strong>Empresa:</strong>  <span>'.htmlspecialchars($user['company']).'</span></li>'; }
									if($user['work_sector'] != '0' && $user['work_sector_show'] >= $sl) {
										echo '<li><strong>Sector:</strong> <span>';
										switch($user['work_sector']) {
											case '1': echo 'Abastecimiento'; break;
											case '2': echo 'Administraci&oacute;n'; break;
											case '3': echo 'Apoderado Aduanal'; break;
											case '4': echo 'Asesor&iacute;a en Comercio Exterior'; break;
											case '5': echo 'Asesor&iacute;a Legal Internacional'; break;
											case '6': echo 'Asistente de Tr&aacute;fico'; break;
											case '7': echo 'Auditor&iacute;a'; break;
											case '8': echo 'Calidad'; break;
											case '9': echo 'Call Center'; break;
											case '10': echo 'Capacitaci&oacute;n Comercio Exterior'; break;
											case '11': echo 'Comercial'; break;
											case '12': echo 'Comercio Exterior'; break;
											case '13': echo 'Compras'; break;
											case '14': echo 'Compras Internacionales/Importaci&oacute;n'; break;
											case '15': echo 'Comunicaci&oacute;n Social'; break;
											case '16': echo 'Comunicaciones Externas'; break;
											case '17': echo 'Comunicaciones Internas'; break;
											case '18': echo 'Consultor&iacute;a'; break;
											case '19': echo 'Consultor&iacute;as Comercio Exterior'; break;
											case '20': echo 'Contabilidad'; break;
											case '21': echo 'Control de Gesti&oacute;n'; break;
											case '22': echo 'Creatividad'; break;
											case '23': echo 'Dise&ntilde;o'; break;
											case '24': echo 'Distribuci&oacute;n'; break;
											case '25': echo 'E-commerce'; break;
											case '26': echo 'Educaci&oacute;n'; break;
											case '27': echo 'Finanzas'; break;
											case '28': echo 'Finanzas Internacionales'; break;
											case '29': echo 'Gerencia / Direcci&oacute;n General'; break;
											case '30': echo 'Impuestos'; break;
											case '31': echo 'Ingenier&iacute;a'; break;
											case '32': echo 'Internet'; break;
											case '33': echo 'Investigaci&oacute;n y Desarrollo'; break;
											case '34': echo 'J&oacute;venes Profesionales'; break;
											case '35': echo 'Legal'; break;
											case '36': echo 'Log&iacute;stica'; break;
											case '37': echo 'Mantenimiento'; break;
											case '38': echo 'Marketing'; break;
											case '39': echo 'Medio Ambiente'; break;
											case '40': echo 'Mercadotecnia Internacional'; break;
											case '41': echo 'Multimedia'; break;
											case '42': echo 'Otra'; break;
											case '43': echo 'Pasant&iacute;as'; break;
											case '44': echo 'Periodismo'; break;
											case '45': echo 'Planeamiento'; break;
											case '46': echo 'Producci&oacute;n'; break;
											case '47': echo 'Producci&oacute;n e Ingenier&iacute;a'; break;
											case '48': echo 'Recursos Humanos'; break;
											case '49': echo 'Relaciones Institucionales / P&uacute;blicas'; break;
											case '50': echo 'Salud'; break;
											case '51': echo 'Seguridad Industrial'; break;
											case '52': echo 'Servicios'; break;
											case '53': echo 'Soporte T&eacute;cnico'; break;
											case '54': echo 'Tecnolog&iacute;a'; break;
											case '55': echo 'Tecnolog&iacute;as de la Informaci&oacute;n'; break;
											case '56': echo 'Telecomunicaciones'; break;
											case '57': echo 'Telemarketing'; break;
											case '58': echo 'Traducci&oacute;n'; break;
											case '59': echo 'Transporte'; break;
											case '60': echo 'Ventas'; break;
											case '61': echo 'Ventas Internacionales/Exportaci&oacute;n'; break;
										}
										echo '</span></li>';
									}
									if($user['income'] != 0 && $user['income_show'] >= $sl) {
										echo '<li><strong>Ingresos:</strong>  <span>';
										switch($user['income']) {
											case '1': echo 'Sin ingresos'; break;
											case '2': echo 'Bajos'; break;
											case '3': echo 'Intermedios'; break;
											case '4': echo 'Altos'; break;
										}
										echo '</span></li>';
									}
									if(!empty($user['work_interests']) && $user['work_interests_show'] >= $sl) { echo '<li><strong>Intereses Profesionales:</strong>  <span>'.htmlspecialchars($user['work_interests']).'</span></li>'; }
									if(!empty($user['work_skills']) && $user['work_skills_show']) { echo '<li><strong>Habilidades Profesionales:</strong>  <span>'.htmlspecialchars($user['work_skills']).'</span></li>'; }			
									echo '<br />';
																																																																																																																						   								}
								if(($user['make_friends'] == 1 || $user['meet_interests'] == 1 || $user['meet_business'] == 1 || $user['find_mate'] == 1 || $user['find_all'] == 1) && $user['meet_show'] >= $sl) {
									$sm = true;
									echo '<strong style="color:#FF6600">Le gustar&iacute;a:</strong><hr />';
									if($user['make_friends'] == 1) { echo 'Conocer amigos<br />'; }
									if($user['meet_interests'] == 1) { echo 'Conocer gente con sus intereses<br />'; }
									if($user['meet_business'] == 1) { echo 'Conocer gente de negocios<br />'; }
									if($user['find_mate'] == 1) { echo 'Encontrar pareja<br />'; }
									if($user['meet_all'] == 1) { echo 'Est&aacute; abierto a todas las opciones<br />'; }
								}
								if((!empty($user['height']) && $user['height_show'] >= $sl) || (!empty($user['weight']) && $user['weight_show'] >= $sl) || ($user['hair_color'] != 0 && $user['hair_color_show'] >= $sl) || ($user['eyes_color'] != 0 && $user['eyes_color_show'] >= $sl) || ($user['constitution'] != 0 && $user['constitution_show'] >= $sl) || (($user['tattos'] == 1 || $user['piercings'] == 1) && $user['tattos_piercings_show'] >= $sl)) {
									$sm = true;
									echo '<strong style="color:#FF6600">&iquest;C&oacute;mo es?</strong><hr />';
									if(!empty($user['height']) && $user['height_show'] >= $sl) { echo '<li><strong>Mide:</strong>  <span>'.$user['height'].' centimetros</span></li>';
									}
									if(!empty($user['weight']) && $user['weight_show'] >= $sl) { echo '<li><strong>Pesa:</strong>  <span>'.$user['weight'].' kilos</span></li>'; }
									if($user['hair_color'] != 0 && $user['hair_color_show'] >= $sl) {
										echo '<li><strong>Su pelo es:</strong>  <span>';
										switch($user['hair_color']) {
											case '1': echo 'Negro'; break;
											case '2': echo 'Casta&ntilde;o oscuro'; break;
											case '3': echo 'Casta&ntilde;o claro'; break;
											case '4': echo 'Rubio'; break;
											case '5': echo 'Pelirrojo'; break;
											case '6': echo 'Gris'; break;
											case '7': echo 'Canoso'; break;
											case '8': echo 'Te&ntilde;ido'; break;
											case '9': echo 'Rapado'; break;
											case '10': echo 'Calvo'; break;
										}
										echo '</span></li>';
									}
									if($user['eyes_color'] != 0 && $user['eyes_color_show'] >= $sl) {
										echo '<li><strong>Sus ojos son::</strong>  <span>';
										switch($user['eyes_color']) {
											case '1': echo 'Negros'; break;
											case '2': echo 'Marrones'; break;
											case '3': echo 'Celestes'; break;
											case '4': echo 'Verdes'; break;
											case '5': echo 'Grises'; break;
										}
										echo '</span></li>';
									}
									if($user['constitution'] != 0 && $user['constitution_show'] >= $sl) {
										echo '<li><strong>Su f&iacute;sico es:</strong>  <span>';
										switch($user['constitution']) {
											case '1': echo 'Delgado'; break;
											case '2': echo 'Atl&eacute;tico'; break;
											case '3': echo 'Normal'; break;
											case '4': echo 'Algunos kilos de m&aacute;s'; break;
											case '5': echo 'Corpulento'; break;
										}
										echo '</span></li>';
									}
									if($user['tattos'] == 1 && $user['tattos_piercings_show'] >= $sl) { echo '<li><strong>Tiene tatuajes</strong></li>'; }
									if($user['piercings'] == 1 && $user ['tattos_piercings_show'] >= $sl) { echo '<li><strong>Tiene piercings</strong></li>'; }						
									echo '<br />';
								}
								if(($user['diet'] != 0 && $user['diet_show'] >= $sl) || ($user['smoke'] != 0 && $user['smoke_show'] >= $sl) || ($user['drink'] != 0 && $user['drink_show'] >= $sl)) {
									$sm = true;
									echo '<strong style="color:#FF6600">Habitos personales</strong><hr />';
									if($user['diet'] != 0 && $user['diet_show'] >= $sl) {
										echo '<li><strong>Mantiene una dieta:</strong>  <span>';
										switch($user['diet']) {
											case '1': echo 'Vegetariana'; break;
											case '2': echo 'Lacto vegetariana'; break;
											case '3': echo 'Org&aacute;nica'; break;
											case '4': echo 'De todo'; break;
											case '5': echo 'Comida basura'; break;
										}
										echo '</span></li>';
									}
									if($user['smoke'] != 0 && $user['smoke_show'] >= $sl) {
										echo '<li><strong>Fuma:</strong>  <span>';
										switch($user['smoke']) {
											case '1': echo 'No'; break;
											case '2': echo 'Casualmente'; break;
											case '3': echo 'Socialmente'; break;
											case '4': echo 'Regularmente'; break;
											case '5': echo 'Mucho'; break;
										}
										echo '</span></li>';
									}
									if($user['drink'] != 0 && $user['drink_show'] >= $sl) {
										echo '<li><strong>Toma alcohol:</strong>  <span>';
										switch($user['drink']) {
											case '1': echo 'No'; break;
											case '2': echo 'Casualmente'; break;
											case '3': echo 'Socialmente'; break;
											case '4': echo 'Regularmente'; break;
											case '5': echo 'Mucho'; break;
										}
										echo '</span></li>';
									}
									echo '<br />';
								}
								$spp = array('my_interests' => 'Intereses', 'my_hobbies' => 'Hobbies', 'tv_shows' => 'Series de TV favoritas', 'favorite_music' => 'M&uacute;sica favorita', 'sports' => 'Deportes y equipos', 'favorite_books' => 'Libros favoritos', 'favorite_films' => 'Pel&iacute;culas favoritas', 'favorite_food' => 'Comida favor&iacute;ta', 'my_heros' => 'Sus heroes son');
								unset($spps);
								foreach($spp as $key => $value) {
									if(!empty($user[$key]) && $user[$key.'_show'] >= $sl) { $spps = true; break; }
								}
								if(isset($spps)) {
									$sm = true;
									echo '<strong style="color:#FF6600">Sus propias palabras</strong><hr />';
									foreach($spp as $key => $value) {
										if(empty($user[$key]) || $user[$key.'_show'] < $sl) { continue; }
										echo '<li><strong>'.$value.':</strong>  <span>'.htmlspecialchars($user[$key]).'</span></li>';
									}
								}
								?>
															</ul>
					</li>
				</ul>
									<? if(isset($sm)) { ?><a class="seeMore" href="#mDa" onclick="$('.moreData').css('display', (mDs == '0' ? 'block' : 'none'));this.innerHTML = (mDs == '0' ? '&laquo; Ver menos' : 'Ver m&aacute;s &raquo;');mDs = (mDs == '0' ? '1' : '0');">Ver m&aacute;s &raquo;</a><? } ?>
								<div style="clear:both"></div>
			</div>
			
		
		<div class="activityData">
			<ul>
				<li class="rango">
	        		<span><?=rankName($user['rank']);?></span>
					<strong>Rango</strong>
				</li>
				<li>
					<span><a href="/posts/buscador/<?=$config['script_name2'];?>/autor/<?=$user['nick'];?>/"><?=mysql_num_rows(mysql_query("SELECT * FROM `posts` WHERE author = '".$user['id']."'"));?></a></span>
					<strong><a href="/posts/buscador/<?=$config['script_name2'];?>/autor/<?=$user['nick'];?>/">Posts</a></strong>
				</li>
				<li>
					<span><?php
				$f = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE user_to = '".$user['id']."'"));
				if(!empty($f['tp'])) {
					echo $f['tp'];
				} else {
					echo '0';
				}
				?></span>
					<strong>Puntos</strong>
				</li>
				<li class="comentarios">
					<span><a href="/comentarios/<?=$user['nick'];?>/"><?=mysql_num_rows(mysql_query("SELECT * FROM `comments` WHERE author = '".$user['id']."'"));?></a></span>
					<strong><a href="/comentarios/<?=$user['nick'];?>/">Comentarios</a></strong>
				</li>
				<li class="tRank">
					<span>
			          Sin	        		</span>
					<strong><?=$config['script_sl'];?> Rank</strong>
				</li>
 
			</ul>
		</div>
			<div class="lastPostsData">
				<h2>&Uacute;ltimos Posts creados</h2>
				<a class="rssP" href="/rss/posts-usuario/<?=$user['nick'];?>/" title="&Uacute;ltimos Posts de <?=$user['nick'];?>"><span class="systemicons sRss" style="position: relative; z-index: 87;"></span></a>
				<div class="clearfix"></div>
									<?php
                                    $pq = mysql_query("SELECT * FROM `posts` WHERE author = '".$user['id']."' ORDER BY time DESC LIMIT 10");
									if(!mysql_num_rows($pq)) {
										echo '<div class="emptyData">No hay posts</div>';
									} else {
										echo '<ul>';
										while($post = mysql_fetch_array($pq)) {
											$f = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE post = '".$post['id']."'"));
											if(empty($f['tp'])) { $f['tp'] = '0'; }
											$cat = mysql_fetch_array(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
											echo '<li class="categoriaPost '.$cat['urlname'].'">
							<a href="/posts/'.$cat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a> <span>'.$f['tp'].' Puntos</span>
						</li>';
										}
										echo '</ul>
					<div class="verTodos">
					<a href="/posts/buscador/'.$config['script_name2'].'/autor/'.$user['nick'].'/">Ver todos</a>
					</div>';

									}
									?>
							</div>
 
			<div class="lastTopicsData">
				<h2>&Uacute;ltimos Temas creados</h2>
				<a href="/rss/perfil/temas/<?=$user['nick'];?>/" class="rssP" title="&Uacute;ltimos Temas de <?=$user['nick'];?>"><span class="systemicons sRss" style="position: relative; z-index: 87;"></span></a>
				<div class="clearfix"></div>
				
									<div class="emptyData">No hay temas</div>
							</div>
 
			<div class="wallData">
			</div>
		</div>
		<div class="derecha">
			<div class="banner300x250">
				<!--<script type="text/javascript"> 
  GA_googleFillSlotWithSize("ca-pub-5717128494977839", "tar_general_300_general", 300, 250);
</script>-->Publicidad 300x250			</div>
 
			
 
			<div class="misComunidades">
				<h2>Sus Comunidades</h2>
				<a href="/rss/perfil/comunidades/<?=$user['nick'];?>/" class="rssP" title="Comunidades de <?=$user['nick'];?>"><span class="systemicons sRss" style="position: relative; z-index: 87;"></span></a>
				<div class="clearfix"></div>
 
									<div class="emptyData">No es miembro de ninguna comunidad</div>
							</div>
 
			<div class="misComunidades">
				<h2>Sus Fotos</h2>
				<div class="clearfix"></div>
 							<?php
							if(empty($user['images'])) {
								echo '<div class="emptyData">No public&oacute; ninguna foto</div>';
							} else {
								$photos = explode('*@', $user['images']);
								foreach($photos as $photo) {
									echo '<div class="photo_small">
											<a href="'.htmlspecialchars($photo).'" target="_blank" title="Abrir en nueva ventana"><img border="0" src="'.htmlspecialchars($photo).'" style="max-width:77px; max-height:77px;" onerror="this.src=\'/images/avatar.gif\';this.parentNode.href=\'/images/avatar.gif\';" /></a>
					</div>';
								}
							}
							?>
						</div>
 
		</div>
	</div>
</div><div style="clear:both"></div>
</div><!--CC-->