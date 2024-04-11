<?php
if($_GET['_']) {
  if(!$_GET['ob'] || !$_GET['p']) { die; }
  include('../config.php');
  include('../functions.php');
  $orderby = (!$_GET['ob'] || ($_GET['ob'] != 'name' && $_GET['ob'] != 'rank' && $_GET['ob'] != 'members' && $_GET['ob'] != 'posts') ? 'rank' : mysql_clean($_GET['ob']));
  $pag = (!$_GET['p'] || $_GET['p'] < 1 || !ctype_digit($_GET['p']) ? 1 : mysql_clean($_GET['p']));
} elseif(!defined($config['define'])) {
  die;
} else {
  $orderby = 'rank';
  $pag = 1;
}
if(!isLogged()) { die; }
if(!mysql_num_rows($q = mysql_query("SELECT id FROM `group_members` WHERE user = '".$currentuser['id']."'"))) { die; }
$totalGroups = mysql_num_rows($q);
$haveGroups = true;
if($totalGroups == 0) { unset($haveGroups); } else {
$totalPages = ceil($totalGroups/10);
if($pag > $totalPages) { $pag = $totalPages; }
$currentPage = $pag;
$pag--;
$displayStart = ($pag*10);
$displayEnd = $displayStart+10;
$query = "SELECT g.* FROM `groups` AS g, group_members AS m WHERE m.user = '".$currentuser['id']."' && g.id = m.group ORDER BY ";
switch($orderby) {
	case 'name':
		$query .= "g.name ASC ";
	break;
	case 'rank':
		$query .= "m.rank DESC ";
	break;
	case 'members':
		$query .= "g.members DESC ";
	break;
	case 'posts':
		$query .= "g.posts DESC ";
	break;
}
$query .= "LIMIT ".$displayStart.",".$displayEnd;
$query = mysql_query($query);
$displayStart++; // add one to display correctly after (K TAL KEDA EL INGLIS PITINGLIS?)
if($displayEnd > $totalGroups) { $displayEnd = $totalGroups; } // lo mizmo :P
$display = '<ul>';
$i = 0;
while($group = mysql_fetch_array($query)) {
	$i++;
	list($rank) = mysql_fetch_row(mysql_query("SELECT rank FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".$group['id']."'"));
	list($cat) = mysql_fetch_row(mysql_query("SELECT name FROM `group_categories` WHERE id = '".$group['cat']."'"));
	$display .= '<li class="resultBox">
			<h4><a href="/comunidades/'.$group['urlname'].'/">'.htmlspecialchars($group['name']).'</a></h4>
			<div class="floatL avatarBox">
				<a href="/comunidades/'.$group['urlname'].'/"><img src="'.$group['avatar'].'" alt="'.$group['urlname'].'" width="75" height="75" onerror="error_avatar(this);" /></a>
			</div>
			<div class="floatL infoBox">
				<ul>
					<li>Categor&iacute;a: <strong>'.$cat.'</strong></li>
					<li title="'.htmlspecialchars($group['description']).'">'.(strlen($group['description']) > 60 ? substr($group['description'], 0, 100).'...' : $group['description']).'</li>
					<li>Miembros: <strong>'.$group['members'].'</strong> - Temas: <strong>'.$group['posts'].'</strong></li>
					<li>Mi rango: <strong>'.groupRankName($rank).'</strong></li>
				</ul>
			</div>
		</li>';
	if($i%2 == 0 && $i != 10) { $display .= '<br />'; }
}
$display .= '</ul>';
$display .= '<div id="mgp" class="paginadorBuscador" style="float:left;width:700px;">';
if($currentPage > 1) { $display .= '<div class="before floatL"><a href="#" onclick="mygroups_show((currentPage-1));return false;"><b>&laquo; Anterior</b></a></div>'; }
$display .= '<div class="pagesCant">
<ul style="margin:0 auto;">';
$endI = ($pag <= 5 ? $pag : 5);
for($i=1;$i<$endI;$i++) {
	$display .= '<li class="numbers"><a href="#" onclick="mygroups_show('.$i.');return false;">'.$i.'</a></li>';
}
$display .=  '<li class="numbers"><a class="here" href="#" onclick="return false;">'.$currentPage.'</a></li>';
$endI = (($currentPage+5) <= $totalPages ? $currentPage+5 : $totalPages);
for($i=($currentPage+1);$i<=$endI;$i++) {
	$display .= '<li class="numbers"><a href="#" onclick="mygroups_show('.$i.');return false;">'.$i.'</a></li>';
}
$display .= '<div class="clearBoth"></div>
</ul>
</div>';
if($currentPage < $totalPages) { $display .= '<div class="next floatR"><a href="#" onclick="mygroups_show((currentPage+1));return false;"><b>Siguiente &raquo;</b></a></div>'; }
$display .= '</div>';
do{$display = str_replace("\n", '', $display);}while(strpos($display, "\n"));
if($_GET['_']) {
	$a = array(',',':','|','#','%','=','/','{','}','-','_');
	$c = count($a)-1;
	do {
		$sep .= $a[mt_rand(0, $c)];
	} while(strpos($pag, $sep) !== false);
	die(strlen($sep).'.'.$sep.$displayStart.$sep.$displayEnd.$sep.$totalGroups.$sep.$display);
}
} // jab grups
?>