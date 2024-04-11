<?php if(!defined('ok')) { die; } ?>
<div class="perfil-content general">
	<div class="widget big-info clearfix">

		<div class="title-w clearfix">
			<h3><?=($currentuser['id'] == $user['id'] ? 'Tu informaci&oacute;n' : 'Informaci&oacute;n de '.htmlspecialchars($user['nick']));?></h3>
		</div>
		<ul>
			<?php
            if($user['name_show'] >= $sl) { echo '<li><label>Nombre</label><strong>'.htmlspecialchars($user['name']).'</strong></li>'; }
            if($user['birth_show'] >= $sl) {
				$age = date('Y')-$user['birth_year'];
				if($user['birth_day'] < date('j') && $user['birth_month'] < date('n')) {
					$age--;
				}
				switch($user['birth_month']) {
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
				echo '<li><label>Edad</label><strong>'.$age.' a&ntilde;os</strong></li>
				<li><label>Fecha de Nacimiento</label><strong>'.$user['birth_day'].' de '.$month.' de '.$user['birth_year'].'</strong></li>';
			}
			echo '<li><label>Pa&iacute;s</label><strong>'.numtocname($user['country']).'</strong></li>';
			if($user['messenger_show'] >= $sl && !empty($user['messenger'])) { echo '<li><label>Mensajero</label><strong>'.$user['messenger_type'].': '.htmlspecialchars($user['messenger']).'</strong></li>'; }
			if(!empty($user['website'])) { echo '<li><label>Sitio Web</label><strong>'.htmlspecialchars($user['website']).'</strong></li>'; }
			switch(date('n', $user['reg_time'])) {
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
            echo '<li><label>Es usuario desde</label><strong>'.date('j', $user['reg_time']).' de '.$month.' de '.date('Y', $user['reg_time']).'</strong></li>';
			if($user['studies_show'] >= $sl && $user['studies'] != 0) {
				echo '<li><label>Estudios</label><strong>';
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
				echo '</strong></li>';
			}
			if($user['languages_show'] >= $sl && ($user['language_spanish'] != 0 || $user['language_english'] != 0 || $user['language_portuguese'] != 0 || $user['language_italian'] != 0 || $user['language_german'] != 0 || $user['language_other'] != 0)) {
	echo '<li class="sep"><h4>Idiomas</h4></li>';
				$langs = array('spanish' => 'Castellano', 'english' => 'Ingl&eacute;s', 'portuguese' => 'Portugu&eacute;s', 'italian' => 'Italiano', 'german' => 'Alem&aacute;n', 'other' => 'Otro');
				foreach($langs as $key => $value) {
					if($user['language_'.$key] == 0) { continue; }
					echo '<li><label>'.$value.'</label><strong>';
					switch($user['language_'.$key]) {
						case '1': echo 'B&aacute;sico'; break;
						case '2': echo 'Intermedio'; break;
						case '3': echo 'Fluido'; break;
						case '4': echo 'Nativo'; break;
					}
					echo '</strong></li>';
				}	
			}
			if((!empty($user['work']) && $user['work_show'] >= $sl) || (!empty($user['company']) && $user['company_show'] >= $sl) || ($user['income'] != 0 && $user['income_show'] >= $sl) || ($user['work_sector'] != 0 && $user['work_sector_show'] >= $sl) || (!empty($user['work_interests']) && $user['work_interests_show'] >= $sl) || (!empty($user['work_skills']) && $user['work_skills_show'] >= $sl)) {																													
		echo '<li class="sep"><h4>Datos profesionales</h4></li>';
				if(!empty($user['work']) && $user['work_show'] >= $sl) { echo '<li><label>Profesi&oacute;n</label><strong> '.htmlspecialchars($user['work']).'</strong></li>'; }
				if(!empty($user['company']) && $user['company_show'] >= $sl) { echo '<li><label>Empresa</label><strong>'.htmlspecialchars($user['company']).'</strong></li>'; }
				if($user['work_sector'] != '0' && $user['work_sector_show'] >= $sl) {
				echo '<li><label>Sector</label><strong>';
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
					echo '</strong></li>';
				}
				if($user['income'] != 0 && $user['income_show'] >= $sl) {
					echo '<li><label>Ingresos</label><strong>';
					switch($user['income']) {
						case '1': echo 'Sin ingresos'; break;
						case '2': echo 'Bajos'; break;
						case '3': echo 'Intermedios'; break;
						case '4': echo 'Altos'; break;
					}
					echo '</strong></li>';
				}
				if(!empty($user['work_interests']) && $user['work_interests_show'] >= $sl) { echo '<li><label>Intereses Profesionales:</label><strong>'.htmlspecialchars($user['work_interests']).'</strong></li>'; }
				if(!empty($user['work_skills']) && $user['work_skills_show']) { echo '<li><label>Habilidades Profesionales:</label><strong>'.htmlspecialchars($user['work_skills']).'</strong></li>'; }	
			}
			if((($user['make_friends'] == 1 || $user['meet_interests'] == 1 || $user['meet_business'] == 1 || $user['find_mate'] == 1 || $user['find_all'] == 1) && $user['meet_show'] >= $sl) || ($user['love_show'] >= $sl && $user['love_state'] != '0') || ($user['children_show'] >= $sl && $user['children'] != '0') || ($user['live_show'] >= $sl && $user['live_with'] != '0')) {
		echo '<li class="sep"><h4>Vida personal</h4></li>';
				if(($user['make_friends'] == 1 || $user['meet_interests'] == 1 || $user['meet_business'] == 1 || $user['find_mate'] == 1 || $user['find_all'] == 1) && $user['meet_show'] >= $sl) {
					if($user['make_friends'] == 1) { $l .= ', Conocer amigos'; }
					if($user['meet_interests'] == 1) { $l .= ', Conocer gente con sus intereses'; }
					if($user['meet_business'] == 1) { $l .= ', Conocer gente de negocios'; }
					if($user['find_mate'] == 1) { $l .= ', Encontrar pareja'; }
					if($user['meet_all'] == 1) { $l .= ', Est&aacute; abierto a todas las opciones'; }
					echo '<li><label>Le gustar&iacute;a</label><strong>'.substr($l, 2).'</strong></li>';
				}
				if($user['love_show'] >= $sl && $user['love_state'] != '0') {
					echo '<li><label>Estado civil</label><strong>';
					$t = ($user['gender'] == '1' ? 'o' : 'a');
					switch($user['love_state']) {
           				case '1': echo 'Solter'.$t; break;
           				case '2': echo 'De novi'.$t; break;
           				case '3': echo 'Casad'.$t; break;
           				case '4': echo 'Divorciad'.$t; break;
           				case '5': echo 'Viud'.$t; break;
           				case '6': echo 'En algo...'; break;
					}
					echo '</strong></li>';
				}
				if($user['children_show'] >= $sl && $user['children'] != '0') {
					echo '<li><label>Hijos</label><strong>';
					switch($user['children']) {
           				case '1': echo 'No tengo'; break;
           				case '2': echo 'Alg&uacute;n d&iacute;a'; break;
           				case '3': echo 'No son lo m&iacute;o'; break;
           				case '4': echo 'Tengo, vivo con ellos'; break;
           				case '5': echo 'Tengo, no vivo con ellos'; break;
					}
					echo '</strong></li>';
				}
				if($user['live_show'] >= $sl && $user['live_with'] != '0') {
					echo '<li><label>Vivo con</label><strong>';
					switch($user['live_with']) {
           				case '1': echo 'S&oacute;lo'; break;
           				case '2': echo 'Con mis padres'; break;
           				case '3': echo 'Con mi pareja'; break;
           				case '4': echo 'Con amigos'; break;
           				case '5': echo 'Otro'; break;
					}
					echo '</strong></li>';
				}
			}
			if((!empty($user['height']) && $user['height_show'] >= $sl) || (!empty($user['weight']) && $user['weight_show'] >= $sl) || ($user['hair_color'] != 0 && $user['hair_color_show'] >= $sl) || ($user['eyes_color'] != 0 && $user['eyes_color_show'] >= $sl) || ($user['constitution'] != 0 && $user['constitution_show'] >= $sl) || (($user['tattos'] == 1 || $user['piercings'] == 1) && $user['tattos_piercings_show'] >= $sl)) {
		echo '<li class="sep"><h4>&iquest;C&oacute;mo es?</h4></li>';
				if(!empty($user['height']) && $user['height_show'] >= $sl) { echo '<li><label>Mide:</label><strong>'.$user['height'].' centimetros</strong></li>'; }
				if(!empty($user['weight']) && $user['weight_show'] >= $sl) { echo '<li><label>Pesa:</label><strong>'.$user['weight'].' kilos</strong></li>'; }
				if($user['hair_color'] != 0 && $user['hair_color_show'] >= $sl) {
					echo '<li><label>Su pelo es</label><strong>';
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
					echo '</strong></li>';
				}
				if($user['eyes_color'] != 0 && $user['eyes_color_show'] >= $sl) {
					echo '<li><label>Sus ojos son</label><strong>';
					switch($user['eyes_color']) {
						case '1': echo 'Negros'; break;
						case '2': echo 'Marrones'; break;
						case '3': echo 'Celestes'; break;
						case '4': echo 'Verdes'; break;
						case '5': echo 'Grises'; break;
					}
					echo '</strong></li>';
				}
				if($user['constitution'] != 0 && $user['constitution_show'] >= $sl) {
					echo '<li><label>Su f&iacute;sico es</label><strong>';
					switch($user['constitution']) {
						case '1': echo 'Delgado'; break;
						case '2': echo 'Atl&eacute;tico'; break;
						case '3': echo 'Normal'; break;
						case '4': echo 'Algunos kilos de m&aacute;s'; break;
						case '5': echo 'Corpulento'; break;
					}
					echo '</strong></li>';
					}
					if($user['tattos'] == 1 && $user['tattos_piercings_show'] >= $sl) { echo '<li><strong>Tiene tatuajes</strong></li>'; }
					if($user['piercings'] == 1 && $user ['tattos_piercings_show'] >= $sl) { echo '<li><strong>Tiene piercings</strong></li>'; }						
					echo '<br />';
			}		
			if(($user['diet'] != 0 && $user['diet_show'] >= $sl) || ($user['smoke'] != 0 && $user['smoke_show'] >= $sl) || ($user['drink'] != 0 && $user['drink_show'] >= $sl)) {
		echo '<li class="sep"><h4>Habitos personales</h4></li>';
				if($user['diet'] != 0 && $user['diet_show'] >= $sl) {
					echo '<li><label>Mantiene una dieta</label><strong>';
					switch($user['diet']) {
						case '1': echo 'Vegetariana'; break;
						case '2': echo 'Lacto vegetariana'; break;
						case '3': echo 'Org&aacute;nica'; break;
						case '4': echo 'De todo'; break;
						case '5': echo 'Comida basura'; break;
					}
					echo '</strong></li>';
				}
				if($user['smoke'] != 0 && $user['smoke_show'] >= $sl) {
					echo '<li><label>Fuma</label><strong>';
					switch($user['smoke']) {
						case '1': echo 'No'; break;
						case '2': echo 'Casualmente'; break;
						case '3': echo 'Socialmente'; break;
						case '4': echo 'Regularmente'; break;
						case '5': echo 'Mucho'; break;
					}
					echo '</strong></li>';
				}
				if($user['drink'] != 0 && $user['drink_show'] >= $sl) {
					echo '<li><label>Toma alcohol</label><strong>';
					switch($user['drink']) {
						case '1': echo 'No'; break;
						case '2': echo 'Casualmente'; break;
						case '3': echo 'Socialmente'; break;
						case '4': echo 'Regularmente'; break;
						case '5': echo 'Mucho'; break;
					}
					echo '</strong></li>';
				}
			}
			$spp = array('my_interests' => 'Intereses', 'my_hobbies' => 'Hobbies', 'tv_shows' => 'Series de TV favoritas', 'favorite_music' => 'M&uacute;sica favorita', 'sports' => 'Deportes y equipos', 'favorite_books' => 'Libros favoritos', 'favorite_films' => 'Pel&iacute;culas favoritas', 'favorite_food' => 'Comida favor&iacute;ta', 'my_heros' => 'Sus heroes son');
			unset($spps);
			foreach($spp as $key => $value) {
				if(!empty($user[$key]) && $user[$key.'_show'] >= $sl) { $spps = true; break; }
			}
			if(isset($spps)) {
				echo '<li class="sep"><h4>Sus propias palabras</h4></li>';
				foreach($spp as $key => $value) {
					if(empty($user[$key]) || $user[$key.'_show'] < $sl) { continue; }
					echo '<li><label>'.$value.'</label><strong>'.htmlspecialchars($user[$key]).'</strong></li>';
				}
			}
			?>
</ul>

</div>
</div>
<div class="perfil-sidebar"><?=advert('300x250');?></div>