<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(isset($topt)) {
	//echo '<div class="filterBy">
    //    Filtrar por: <a id="filter_'.$topt.'_Semana" href="#" onclick="TopsTabs(\''.($topt == '1' ? 'posts_' : 'users_').'\',\'Semana\');return false;"'.($topt == '1' ? ' class="here"' : '').'>Semana</a> - <a id="filter_'.$topt.'_Mes" href="#" onclick="TopsTabs(\''.($topt == '1' ? 'posts_' : 'users_').'\',\'Mes\');return false;"'.($topt == '2' ? ' class="here"' : '').'>Mes</a> - <a id="filter_'.$topt.'_Historico" href="#" onclick="TopsTabs(\''.($topt == '1' ? 'posts_' : 'users_').'\',\'Historico\');return false;">Hist&oacute;rico</a>    </div>';
	//$qt[1] = time()-((date('N')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('s')))); // semana
	//$qt[2] = time()-((date('j')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('s')))); // mez
    $qt[1] = time()-(date('H')*3600+date('i')*60+date('s')+86400);
    $qt[2] = time()-(date('H')*3600+date('i')*60+date('s'));
    $qt[3] = time()-(date('w')*86400+date('G')*3600+date('i')*60);
	$qt[4] = time()-((date('j')-1)*86400+date('G')*3600+date('i')*60);
    $qm[1] = time()-(date('H')*3600+date('i')*60+date('s'));
    $qm[2] = time();
    $qm[3] = time();
    $qm[4] = time();
    $qm[5] = time();
	$qt[5] = 0;
    $tt[1] = 'Ayer';
    $tt[2] = 'Hoy';
	$tt[3] = 'Semana';
	$tt[4] = 'Mes';
	$tt[5] = 'Historico';
    $name[1] = 'Usuarios TOPs';
    $name[2] = 'Posts TOPS';
    $name[3] = 'Comunidades Populares';
    $abbr[1] = 'User';
    $abbr[2] = 'Post';
    $abbr[3] = 'Comunidad';
    $low[1] = 'usuarios';
    $low[2] = 'posts';
    $low[3] = 'comunidades';

    ?>
    <div id="tops<?=$abbr[$topt];?>Box">
        <br class="space" />
        <div class="box_title">
            <div class="box_txt tops_<?=$low[$topt];?>"><?=$name[$topt];?> <a href="/top/<?=$low[$topt];?>/" class="size9">(Ver m&aacute;s)</a></div>
            <!--<div class="box_rss">
                <a href="/rss/usuarios-top-mes">
                    <span class="systemicons sRss"></span>
                </a>
            </div>-->
        </div>
        <div class="box_cuerpo" style="padding: 0pt; height: 250px;">
            <div class="filterBy">
                <a id="Ayer<?=$abbr[$topt];?>" href="javascript:TopsTabs('tops<?=$abbr[$topt];?>Box','Ayer<?=$abbr[$topt];?>')">Ayer</a> - <a id="Hoy<?=$abbr[$topt];?>" href="javascript:TopsTabs('tops<?=$abbr[$topt];?>Box','Hoy<?=$abbr[$topt];?>')">Hoy</a> - <a id="Semana<?=$abbr[$topt];?>" href="javascript:TopsTabs('tops<?=$abbr[$topt];?>Box','Semana<?=$abbr[$topt];?>')"<?=($topt != '1' ? ' class="here"' : '');?>>Semana</a> - <a id="Mes<?=$abbr[$topt];?>" href="javascript:TopsTabs('tops<?=$abbr[$topt];?>Box','Mes<?=$abbr[$topt];?>')"<?=($topt == '1' ? ' class="here"' : '');?>>Mes</a> - <a id="Historico<?=$abbr[$topt];?>" href="javascript:TopsTabs('tops<?=$abbr[$topt];?>Box','Historico<?=$abbr[$topt];?>')">Hist&oacute;rico</a>
            </div>
            <?php
            for($i=1;$i<=5;$i++) {
              echo '<ol class="filterBy" id="filterBy'.$tt[$i].$abbr[$topt].'"'.($i == 3 && $topt != '1' ? ' style="display:block;"' : '').($i == 4 && $topt == '1' ? ' style="display:block;"' : '').'>';
              if($topt == '1') {
                $query = mysql_query("SELECT u.nick, SUM(po.pnum) AS points FROM users AS u, points AS po WHERE po.user_to = u.id && po.time >= '".$qt[$i]."' && po.time < '".$qm[$i]."' GROUP BY po.user_to ORDER BY points DESC LIMIT 15");
                while($user = mysql_fetch_assoc($query)) {
                  echo '<li><a href="/perfil/'.htmlspecialchars($user['nick']).'/">'.htmlspecialchars($user['nick']).'</a> ('.$user['points'].')</li>';
                }
              } elseif($topt == '2') {
                $query = mysql_query("SELECT p.id, p.title, c.urlname AS uname, SUM(po.pnum) AS points FROM posts AS p, categories AS c, points AS po WHERE po.post = p.id && c.id = p.cat && po.time >= '".$qt[$i]."' && po.time < '".$qm[$i]."' GROUP BY po.post ORDER BY points DESC LIMIT 15");
                while($post = mysql_fetch_assoc($query)) {
                  echo '<li><a href="/posts/'.$post['uname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.(strlen($post['title']) > 40 ? substr($post['title'], 0, 40).'...' : $post['title']).'</a> ('.$post['points'].')</li>';
                }
              } else {
			    $query = mysql_query("SELECT g.name, g.urlname AS url, COUNT(m.id) AS members FROM groups AS g, group_members AS m WHERE m.group = g.id && m.time >= '".$qt[$i]."' && m.time < '".$qm[$i]."' GROUP BY g.id ORDER BY members DESC LIMIT 15");
                while($group = mysql_fetch_assoc($query)) {
				    echo '<li><a href="/comunidades/'.$group['url'].'/">'.(strlen($group['name']) > 37 ? substr(htmlspecialchars($group['name']), 0, 40).'...' : htmlspecialchars($group['name'])).'</a> ('.$group['members'].')</li>';
			    }
              }
              echo '</ol>';
            }
        ?></div>
    </div>
    <?php
} else { // principal -.-
	switch($_GET['fecha']) {
		default:
		case '0':
			$period = '0';
			$qt = '0';
			$qtm = time();
		break;
		break;
		case '1':
			$period = '1';
			$qt = time()-date('G')*3600-date('i')*60-date('s');
			$qtm = time();
		break;
		case '2':
			$period = '2';
			$qt = time()-date('G')*3600-date('i')*60-date('s')-86400;
			$qtm = time()-date('G')*3600-date('i')*60-date('s');
		break;
		case '3':
			$period = '3';
			$qt = time()-date('G')*3600-date('i')*60-date('s')-518400;
			$qtm = time();
		break;
		case '4':
			$period = '4';
			$qt = time()-date('j')*86400-date('G')*3600-date('i')*60-date('s');
			$qtm = time();
		break;
		case '5':
			$period = '5';
			$qt = time()-date('j')*86400-date('G')*3600-date('i')*60-date('s')-86400*(date('t')=='31' ? (date('n') == '3' ? (date('L')=='1' ? 29 : 28) : 30) : 31);
			$qtm = time()-date('j')*86400-date('G')*3600-date('i')*60-date('s');
		break;
	}
	if($currentTop == 'posts' || $currentTop == 'users') {
		$cq = mysql_query("SELECT id, name FROM `categories` WHERE id = '".mysql_clean($_GET['cat'])."'");
	} else {
		$cq = mysql_query("SELECT id, name FROM `group_categories` WHERE sub = '0' && id = '".mysql_clean($_GET['cat'])."'");
	}
	$cat = (mysql_num_rows($cq) ? mysql_clean($_GET['cat']) : 0);
	$catq = ($cat == '0' ? '' : " && c.id = '".$cat."'");
?>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
	<div class="left" style="float:left;width:150px">
		<div class="boxy">
			<div class="boxy-title">
				<h3>Filtrar</h3>
				<span class="icon-noti"></span>
			</div>
			<div class="boxy-content">
				<h4>Categor&iacute;a</h4>
				<select onchange="location.href='/top/<?=$currentTop2;?>/?fecha=<?=$period;?>&cat='+$(this).val()">
					<option value="0">Todas</option>
					<?php
					if($currentTop == 'posts' || $currentTop == 'users') {
						$query = mysql_query("SELECT id, name FROM `categories` ORDER BY id ASC");
					} else {
						$query = mysql_query("SELECT id, name FROM `group_categories` WHERE sub = '0' ORDER BY id ASC");
					}
					while($cc = mysql_fetch_assoc($query)) {
						echo '<option value="'.$cc['id'].'"'.($cc['id']==$cat ? ' selected' : '').'>'.$cc['name'].'</option>';
					}
					?>
				</select>
				<hr />
				<h4>Per&iacute;odo</h4>
				<ul>
					<li><a href="/top/<?=$currentTop2;?>/?fecha=0&cat=<?=$cat;?>"<?=($period==0 ? ' class="selected"' : '');?>>Todos los tiempos</a></li>
					<li><a href="/top/<?=$currentTop2;?>/?fecha=1&cat=<?=$cat;?>"<?=($period==1 ? ' class="selected"' : '');?>>Hoy</a></li>
					<li><a href="/top/<?=$currentTop2;?>/?fecha=2&cat=<?=$cat;?>"<?=($period==2 ? ' class="selected"' : '');?>>Ayer</a></li>
					<li><a href="/top/<?=$currentTop2;?>/?fecha=3&cat=<?=$cat;?>"<?=($period==3 ? ' class="selected"' : '');?>>&Uacute;ltimos 7 d&iacute;as</a></li>
					<li><a href="/top/<?=$currentTop2;?>/?fecha=4&cat=<?=$cat;?>"<?=($period==4 ? ' class="selected"' : '');?>>Del mes</a></li>
					<li><a href="/top/<?=$currentTop2;?>/?fecha=5&cat=<?=$cat;?>"<?=($period==5 ? ' class="selected"' : '');?>>Mes anterior</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="right" style="float:left;margin-left:10px;width:775px">
 
		<div class="boxy xtralarge">
        <?php
		if($currentTop == 'posts') {
		?>
			<div class="boxy-title">
				<h3>Top post con m&aacute;s puntos</h3>
				<span class="icon-noti puntos-n"></span>
			</div>
			<div class="boxy-content boxyt">
						<ol>
                        <?php
						$query = mysql_query("SELECT p.id, p.title, c.urlname, SUM(po.pnum) AS points FROM posts AS p, categories AS c, points AS po WHERE p.id = po.post && c.id = p.cat && po.time > '".$qt."' && po.time < '".$qtm."'".$catq." GROUP BY p.id ORDER BY points DESC LIMIT 15");
						$height1 = mysql_num_rows($query)*22;
						while($post = mysql_fetch_array($query)) {
							echo '<li class="categoriaPost clearfix '.$post['urlname'].'">
								<a href="/posts/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
								<span>'.$post['points'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Top post m&aacute;s favorito</h3>
				<span class="icon-noti favoritos-n"></span>
			</div>
			<div class="boxy-content boxyt">
						<ol>
						<?php
						$query = mysql_query("SELECT p.id, p.title, c.urlname, COUNT(f.id) AS favs FROM posts AS p, categories AS c, favorites AS f WHERE p.id = f.post && c.id = p.cat && f.time > '".$qt."' && f.time < '".$qtm."'".$catq." GROUP BY p.id ORDER BY favs DESC LIMIT 15");
						$height2 = mysql_num_rows($query)*22;
						while($post = mysql_fetch_array($query)) {
							echo '<li class="categoriaPost clearfix '.$post['urlname'].'">
								<a href="/posts/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
								<span>'.$post['favs'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Top post m&aacute;s comentado</h3>
				<span class="icon-noti comentarios-n"></span>
			</div>
			<div class="boxy-content boxyb">
						<ol>
						<?php
						$query = mysql_query("SELECT p.id, p.title, c.urlname, COUNT(co.id) AS comments FROM posts AS p, categories AS c, comments AS co WHERE p.id = co.post && c.id = p.cat && co.time > '".$qt."' && co.time < '".$qtm."'".$catq." GROUP BY p.id ORDER BY comments DESC LIMIT 15");
						$height3 = mysql_num_rows($query)*22;
						while($post = mysql_fetch_array($query)) {
							echo '<li class="categoriaPost clearfix '.$post['urlname'].'">
								<a href="/posts/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
								<span>'.$post['comments'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Top post con m&aacute;s seguidores</h3>
				<span class="icon-noti follow-n"></span>
			</div>
			<div class="boxy-content boxyb">
						<ol>
						<?php
						$query = mysql_query("SELECT p.id, p.title, c.urlname, COUNT(f.id) AS follows FROM posts AS p, categories AS c, follows AS f WHERE f.what = '1' && f.who = p.id && c.id = p.cat && f.time > '".$qt."' && f.time < '".$qtm."'".$catq." GROUP BY p.id ORDER BY follows DESC LIMIT 15");
						$height4 = mysql_num_rows($query)*22;
						while($post = mysql_fetch_array($query)) {
							echo '<li class="categoriaPost clearfix '.$post['urlname'].'">
								<a href="/posts/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
								<span>'.$post['follows'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 	<? } elseif($currentTop == 'groups') { ?>
    	<div class="boxy-title">
				<h3>Comunidades m&aacute;s populares</h3>
				<span class="icon-noti popular-n"></span>
			</div>
			<div class="boxy-content boxyt">
						<ol>
                        <?php
						$query = mysql_query("SELECT g.name, g.urlname, c.urlname AS cat, COUNT(m.id) AS members FROM groups AS g, group_categories AS c, group_members AS m WHERE g.id = m.group && c.id = g.cat && m.time > '".$qt."' && m.time < '".$qtm."'".$catq." GROUP BY g.id ORDER BY members DESC LIMIT 15");
						$height1 = mysql_num_rows($query)*22;
						while($group = mysql_fetch_array($query)) {
							echo '<li class="categoriaCom clearfix '.$group['cat'].'">
								<a class="titletema" href="/comunidades/'.$group['urlname'].'">'.htmlspecialchars($group['name']).'</a>
								<span>'.$group['members'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Comunidades con m&aacute;s temas</h3>
				<span class="icon-noti comunidades-n"></span>
			</div>
			<div class="boxy-content boxyt">
						<ol>
						<?php
						$query = mysql_query("SELECT g.name, g.urlname, c.urlname AS cat, COUNT(t.id) AS posts FROM groups AS g, group_categories AS c, group_posts AS t WHERE g.id = t.group && c.id = g.cat && t.time > '".$qt."' && t.time < '".$qtm."'".$catq." GROUP BY g.id ORDER BY posts DESC LIMIT 15");
						$height2 = mysql_num_rows($query)*22;
						while($group = mysql_fetch_array($query)) {
							echo '<li class="categoriaCom clearfix '.$group['cat'].'">
								<a class="titletema" href="/comunidades/'.$group['urlname'].'">'.htmlspecialchars($group['name']).'</a>
								<span>'.$group['posts'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Comunidades con m&aacute;s respuestas</h3>
				<span class="icon-noti comentarios-n-g"></span>
			</div>
			<div class="boxy-content boxyb">
						<ol>
						<?php
						$query = mysql_query("SELECT g.name, g.urlname, c.urlname AS cat, COUNT(co.id) AS comments FROM groups AS g, group_categories AS c, group_comments AS co WHERE g.id = co.group && c.id = g.cat && co.time > '".$qt."' && co.time < '".$qtm."'".$catq." GROUP BY g.id ORDER BY comments DESC LIMIT 15");
						$height3 = mysql_num_rows($query)*22;
						while($group = mysql_fetch_array($query)) {
							echo '<li class="categoriaCom clearfix '.$group['cat'].'">
								<a class="titletema" href="/comunidades/'.$group['urlname'].'">'.htmlspecialchars($group['name']).'</a>
								<span>'.$group['comments'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Comunidades con m&aacute;s seguidores</h3>
				<span class="icon-noti follow-n"></span>
			</div>
			<div class="boxy-content boxyb">
						<ol>
						<?php
						$query = mysql_query("SELECT g.name, g.urlname, c.urlname AS cat, COUNT(f.id) AS follows FROM groups AS g, group_categories AS c, follows AS f WHERE f.what = '3' && f.who = g.id && c.id = g.cat && f.time > '".$qt."' && f.time < '".$qtm."'".$catq." GROUP BY g.id ORDER BY follows DESC LIMIT 15");
						$height4 = mysql_num_rows($query)*22;
						while($group = mysql_fetch_array($query)) {
							echo '<li class="categoriaCom clearfix '.$group['cat'].'">
								<a class="titletema" href="/comunidades/'.$group['urlname'].'">'.htmlspecialchars($group['name']).'</a>
								<span>'.$group['follows'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
    <?php } elseif($currentTop == 'group_posts') { ?>
    <div class="boxy-title">
				<h3>Temas m&aacute;s votados</h3>
				<span class="icon-noti votada-n"></span>
			</div>
			<div class="boxy-content boxyt">
						<ol>
                        <?php
						$query = mysql_query("SELECT p.id, g.name, p.title, g.urlname, c.urlname AS cat, COUNT(po.id) AS points FROM group_posts AS p, groups AS g, group_categories AS c, group_points AS po WHERE g.id = p.group && c.id = g.cat && p.id = po.post && po.time > '".$qt."' && po.time < '".$qtm."'".$catq." GROUP BY p.id ORDER BY points DESC LIMIT 15") or die(mysql_error());
						$height1 = mysql_num_rows($query)*22;
						while($post = mysql_fetch_array($query)) {
							echo '<li class="categoriaCom clearfix '.$post['cat'].'">
								<a class="titletema" href="/comunidades/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
								<span>'.$post['points'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Temas m&aacute;s visitados</h3>
				<span class="icon-noti"></span>
			</div>
			<div class="boxy-content boxyt">
						<ol>
						<?php
						$query = mysql_query("SELECT p.id, g.name, p.title, g.urlname, c.urlname AS cat, COUNT(v.id) AS visits FROM group_posts AS p, groups AS g, group_categories AS c, group_visits AS v WHERE g.id = p.group && c.id = g.cat && p.id = v.post &&  v.time > '".$qt."' && v.time < '".$qtm."'".$catq." GROUP BY p.id ORDER BY visits DESC LIMIT 15");
						$height2 = mysql_num_rows($query)*22;
						while($post = mysql_fetch_array($query)) {
							echo '<li class="categoriaCom clearfix '.$post['cat'].'">
								<a class="titletema" href="/comunidades/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
								<span>'.$post['visits'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Temas con m&aacute;s respuestas</h3>
				<span class="icon-noti comentarios-n-g"></span>
			</div>
			<div class="boxy-content boxyb">
						<ol>
						<?php
						$query = mysql_query("SELECT p.id, g.name, p.title, g.urlname, c.urlname AS cat, COUNT(co.id) AS comments FROM group_posts AS p, groups AS g, group_categories AS c, group_comments AS co WHERE g.id = p.group && c.id = g.cat && p.id = co.post && co.time > '".$qt."' && co.time < '".$qtm."'".$catq." GROUP BY p.id ORDER BY comments DESC LIMIT 15");
						$height3 = mysql_num_rows($query)*22;
						while($post = mysql_fetch_array($query)) {
							echo '<li class="categoriaCom clearfix '.$post['cat'].'">
								<a class="titletema" href="/comunidades/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
								<span>'.$post['comments'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Temas con m&aacute;s seguidores</h3>
				<span class="icon-noti follow-n"></span>
			</div>
			<div class="boxy-content boxyb">
						<ol>
						<?php
						$query = mysql_query("SELECT p.id, g.name, p.title, g.urlname, c.urlname AS cat, COUNT(f.id) AS follows FROM group_posts AS p, groups AS g, group_categories AS c, follows AS f WHERE f.what = '4' && f.who = p.id && c.id = g.cat && f.time > '".$qt."' && f.time < '".$qtm."'".$catq." GROUP BY p.id ORDER BY follows DESC LIMIT 15");
						$height4 = mysql_num_rows($query)*22;
						while($post = mysql_fetch_array($query)) {
							echo '<li class="categoriaCom clearfix '.$post['cat'].'">
								<a class="titletema" href="/comunidades/'.$post['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
								<span>'.$post['follows'].'</span>
							</li>';
						}
						?>	
						</ol>
						</div>
		</div>
    <?php } else { ?>
    <div class="boxy-title">
				<h3>Top Usuario m&aacute;s puntuado</h3>
				<span class="icon-noti puntos-n"></span>
			</div>
			<div class="boxy-content boxyt">
						<ol>
                        <?php
						$query = mysql_query("SELECT u.avatar, u.nick, SUM(po.pnum) AS points FROM users AS u, posts AS p, categories AS c, points AS po WHERE u.id = p.author && c.id = p.cat && po.post = p.id && po.time > '".$qt."' && po.time < '".$qtm."'".$catq." GROUP BY u.id ORDER BY points DESC LIMIT 15");
						$height1 = mysql_num_rows($query)*24;
						while($user = mysql_fetch_array($query)) {
							echo '<li class="categoriaUsuario clearfix">
					<img align="absmiddle" src="/avatares/16/'.$user['avatar'].'" width="16" height="16" />
					<a href="/perfil/'.htmlspecialchars($user['nick']).'">'.htmlspecialchars($user['nick']).'</a>
					<span>'.$user['points'].'</span>
				</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Top usuario m&aacute;s seguido</h3>
				<span class="icon-noti follow-n"></span>
			</div>
			<div class="boxy-content boxyt">
						<ol>
						<?php
						$query = mysql_query("SELECT u.avatar, u.nick, COUNT(f.id) AS follows FROM users AS u, follows AS f WHERE f.what = '2' && f.who = u.id && f.time > '".$qt."' && f.time < '".$qtm."'".$catq." GROUP BY u.id ORDER BY follows DESC LIMIT 15")or die(mysql_error());
						$height2 = mysql_num_rows($query)*24;
						while($user = mysql_fetch_array($query)) {
							echo '<li class="categoriaUsuario clearfix">
					<img align="absmiddle" src="/avatares/16/'.$user['avatar'].'" width="16" height="16" />
					<a href="/perfil/'.htmlspecialchars($user['nick']).'">'.htmlspecialchars($user['nick']).'</a>
					<span>'.$user['follows'].'</span>
				</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Top usuario m&aacute;s posteador</h3>
				<span class="icon-noti"></span>
			</div>
			<div class="boxy-content boxyb">
						<ol>
						<?php
						$query = mysql_query("SELECT u.avatar, u.nick, COUNT(p.id) AS posts FROM users AS u, posts AS p, categories AS c WHERE u.id = p.author && c.id = p.cat && p.time > '".$qt."' && p.time < '".$qtm."'".$catq." GROUP BY u.id ORDER BY posts DESC LIMIT 15");
						$height3 = mysql_num_rows($query)*24;
						while($user = mysql_fetch_array($query)) {
							echo '<li class="categoriaUsuario clearfix">
					<img align="absmiddle" src="/avatares/16/'.$user['avatar'].'" width="16" height="16" />
					<a href="/perfil/'.htmlspecialchars($user['nick']).'">'.htmlspecialchars($user['nick']).'</a>
					<span>'.$user['posts'].'</span>
				</li>';
						}
						?>	
						</ol>
						</div>
		</div>
 
		<div class="boxy xtralarge">
			<div class="boxy-title">
				<h3>Top usuario m&aacute;s comentador</h3>
				<span class="icon-noti comentarios-n-b"></span>
			</div>
			<div class="boxy-content boxyb">
						<ol>
						<?php
						$query = mysql_query("SELECT u.avatar, u.nick, COUNT(co.id) AS comments FROM users AS u, posts AS p, categories AS c, comments AS co WHERE u.id = p.author && c.id = p.cat && co.post = p.id && co.time > '".$qt."' && co.time < '".$qtm."'".$catq." GROUP BY u.id ORDER BY comments DESC LIMIT 15") or die(mysql_error());
						$height4 = mysql_num_rows($query)*24;
						while($user = mysql_fetch_array($query)) {
							echo '<li class="categoriaUsuario clearfix">
					<img align="absmiddle" src="/avatares/16/'.$user['avatar'].'" width="16" height="16" />
					<a href="/perfil/'.htmlspecialchars($user['nick']).'">'.htmlspecialchars($user['nick']).'</a>
					<span>'.$user['comments'].'</span>
				</li>';
						}
						?>	
						</ol>
						</div>
		</div>
    <?php
	} // post, groups etcing
	// despues de saber si es posts users ETC
	$css = '';
	if($height1 != $height2) {
		$css = '.boxyt{height:'.max($height1,$height2).'px;}';
	}
	if($height3 != $height4) {
		$css .='.boxyb{height:'.max($height3,$height4).'px;}';
	}
	if($css != ''){echo '<style type="text/css">'.$css.'</style>';}
	?>
	</div>
 
<div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div>
<? } /* MIERDA DE LO DE PRINCIPAL */ ?>