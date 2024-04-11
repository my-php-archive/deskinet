<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if($_GET['page'] == 'tagscloud') { $direct = true; }
if($_GET['orden'] != 'i' || !$_GET['orden']) { $order = "tag ASC"; } else { $order = "num DESC, id DESC"; }
$tags = array();
$nums = array();
$query = mysql_query("SELECT * FROM `tags` ORDER BY ".$order." LIMIT ".($direct ? '100' : '40')) or die(mysql_error());
$i = 0;
while($tag = mysql_fetch_array($query)) {
	echo $tag['tag'].' => '.$tag['num'].' ; ';
	$tags[$i] = $tag['tag'];
	$nums[$i] = $tag['num'];
	$i++;
}
$max = max($tags);
$min = min($tags);
$dif = $max-$min;
echo $max.'-'.$min;
$count = count($tags);
for($i=0;$i<$count;$i++) {
	$vr = ($direct ? 15 : 10)+round((($num-$min)/$dif)*10);
    $show .= '<a href="/tags/'.$tags[$i].'" title="'.$nums[$i].' posts con el tag '.$tags[$i].'"  style="font-size:'.$vr.'px;padding-right:1.3%;" rel="tag">'.$tags[$i].' ('.$nums[$i].')</a>';
}


if($direct) {
	echo '<div id="cuerpocontainer">
	<div class="container940">
	<div class="box_title">
		<div class="box_txt nube_posts">Nube de Tags</div>
		<div class="box_rrs"><div class="box_rss"></div></div>
	</div>
	<div class="box_cuerpo" style="text-align:center;">
		En esta nube se reflejan los 100 tags m&aacute;s populares. Cuanto m&aacute;s grande es la palabra, mayor cantidad de veces fue utilizada.		<br />
		Ordenar: <a href="?orden=a">alfab&eacute;ticamente</a> | <a href="?orden=i">por importancia</a>
		<br />
		<br />
		<div class="tags_cloud_2">'.$show.'</div><div style="clear:both"></div></div></div></div>';
} else {
	echo $show;
}
?>