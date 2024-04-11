<?php
include('config.php');
function bbcode($text, $special = true) {
	global $currentuser;

	$text = nl2br(htmlspecialchars($text));
	
	// GEGEGEGGEEG :D
	$text = preg_replace('/\[url\](.*)\[\/url\]/Usi', '<a href="\\1" rel="nofollow" target="_blank">\\1</a>', $text);
	$text = preg_replace('/\[url=\#([a-z0-9]+)\](.*)\[\/url\]/Usi', '<a href="#\\1">\\2</a>', $text);
	$text = preg_replace('/\[url=(.*)\](.*)\[\/url\]/Usie', '\'<a href="\'.(substr(\'\\1\',0,7)==\'http://\' ? \'\\1\' : \'http://\\1\').\'" rel="nofollow" target="_blank">\\2</a>\'', $text);
	$text = preg_replace('/\[img=(.*)\]/Usi', '<img src="\\1" style="max-width:750px;" />', $text);
	$text = preg_replace('/\[img\](.*)\[\/img\]/Usi', '<img src="\\1" style="max-width:750px;" />', $text);
	$text = preg_replace("/(\]| |^|>|\\n)http:\/\/(.*)((\.[a-z]{2,4}){1,2})(\[| |$|<|\\n)/Usi", '\\1<a href="http://\\2\\3">http://\\2\\3</a>\\5', $text);
	
	// BBCode basicos
	$text = preg_replace('/\[b\](.*)\[\/b\]/Usi', '<b>\\1</b>', $text);
	$text = preg_replace('/\[i\](.*)\[\/i\]/Usi', '<i>\\1</i>', $text);
	$text = preg_replace('/\[u\](.*)\[\/u\]/Usi', '<u>\\1</u>', $text);
	$text = preg_replace('/\[color=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\](.*)\[\/color=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\]/Usie', "text_gradient('\\2', '\\1', '\\3');", $text);
	$text = preg_replace('/\[color=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\](.*)\[\/color\]/Usi', '<span style="color:\\1">\\2</span>', $text);
	$text = preg_replace('/\[color=([a-z]+)\](.*)\[\/color\]/Usi', '<span style="color:\\1">\\2</span>', $text);
	$text = preg_replace('/\[fondo=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\](.*)\[\/fondo=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\]/Usi', '<span style="background: -moz-linear-gradient(left, \\1, \\3);">\\2</span>', $text);
	$text = preg_replace('/\[fondo=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\](.*)\[\/fondo\]/Usi', '<span style="background: \\1;">\\2</span>', $text);
	$text = preg_replace('/\[size=([0-9]+)\](.*)\[\/size\]/Usi', '<span style="font-size:\\1pt;">\\2</span>', $text);
	$text = preg_replace('/\[font="(.*)"\](.*)\[\/font]/Usi', '[font=\\1]\\2[/font]', $text); // k pereza!
	$text = preg_replace('/\[font=(.*)\](.*)\[\/font]/Usi', '<span style="font-family:\\1;">\\2</span>', $text);
	$text = preg_replace('/\[align=center\](.*)\[\/align]/Usi', '<center>\\1</center>', $text);
	$text = preg_replace('/\[align=left\](.*)\[\/align]/Usi', '<span class="floatL">\\1</span><div class="clearBoth"></div>', $text);
	$text = preg_replace('/\[align=right\](.*)\[\/align]/Usi', '<span class="floatR">\\1</span><div class="clearBoth"></div>', $text);
	
	// BBCode avanzados
	//$text = str_replace('[tu]', (isLogged() ? $currentuser['nick'] : 'visitante'), $text);
	$text = preg_replace('/\[a=([a-z0-9]+)\]/Usi', '<a name="\\1"></a>', $text);
	$text = preg_replace('/\[swf=(.*)\]/Usi', '<center><embed src="\\1" quality="high" type="application/x-shockwave-flash" AllowNetworking="internal" AllowScriptAccess="never" wmode="transparent" allowfullscreen="false" width="425" height="350"></embed></center>', $text);
	$text = preg_replace('/\[spoiler=([a-z0-9]+)\|([a-z0-9]+)\](.*)\[\/spoiler\]/Usi', '<div style="text-align: center;"><input type="button" value="\\1" onclick="this.parentNode.getElementsByTagName(\'div\')[0].style.display = (this.parentNode.getElementsByTagName(\'div\')[0].style.display==\'block\' ? \'none\' : \'block\');this.value=(this.parentNode.getElementsByTagName(\'div\')[0].style.display==\'block\' ? \'\\2\' : \'\\1\');" /><div style="display:none;text-align:left;border:1px solid #000;margin:7px;">\\3</div></div>', $text);
	$text = preg_replace('/\[spoiler\](.*)\[\/spoiler\]/Usi', '<div style="text-align: center;"><input type="button" value="Mostrar" onclick="this.parentNode.getElementsByTagName(\'div\')[0].style.display = (this.parentNode.getElementsByTagName(\'div\')[0].style.display==\'block\' ? \'none\' : \'block\');this.value=(this.parentNode.getElementsByTagName(\'div\')[0].style.display==\'block\' ? \'Ocultar\' : \'Mostrar\');" /><div style="display:none;text-align:left;border:1px solid #000;margin:7px;">\\1</div></div>', $text);
	//$text = preg_replace("/\[quote\](.*)\[\/quote\]/Ais", '<blockquote><div class="cita">Cita</div><div class="citacuerpo"><p>\\1</p></div></blockquote><br /><br />', $text);
	//$text = preg_replace("/\[quote=([a-z0-9]+)\](.*)\[\/quote\]/Ais", '<blockquote><div class="cita"><strong>\\1</strong> dijo:</div><div class="citacuerpo"><p>\\2</p></div></blockquote><br /><br />', $text);

	//$text = parseAuthorQuotes($text);
	//$text = parseQuotes($text);
	
	// Emoticonos
	$emoticonos = array(':)' => 'sonrisa', ';)' => 'guino', ':roll:' => 'duda', ':P' => 'lengua', ':D' => 'alegre', ':(' => 'triste', 'X(' => 'odio', ':cry:' => 'llorando', ':twisted:' => 'endiablado', ':|' => 'serio', ':?' => 'duda2', ':cool:' => 'picaro', '^^' => 'sonrizota', ':oops:' => 'timido', '8|' => 'increible', ':F' => 'babas');
	foreach($emoticonos as $code => $name) {
		$text = str_replace($code, '<img src="/images/space.gif" align="absmiddle" class="emoticono '.$name.'" />', $text);
	}
	// aun mas...
	$emoticonos = glob(str_repeat('../', substr_count($_SERVER['SCRIPT_NAME'], '/')-1).'images/smiles/*.gif');
	foreach($emoticonos as $name) {
		$ex = explode('/', $name);
		$ex = $ex[count($ex)-1];
		$ex = explode('.', $ex);
		$ex = $ex[0];
		$text = str_replace(':'.$ex.':', '<img src="/images/smiles/'.$ex.'.gif" align="absmiddle" />', $text);
	}
	
	$bwp = array('/(http:\/\/|www\.|http:\/\/www\.)?taringa\.net/i');
	$text = preg_replace($bwp, '*****', $text);
	$bw = array('taringa');
	$text = str_ireplace($bw, '*****', $text);
	
	if(substr($text, -25) == '</blockquote><br /><br />') { $text = substr($text, 0, (strlen($text)-12)); }
	return $text;
}
list($m) = mysql_fetch_row(mysql_query("SELECT message FROM `posts` WHERE id = '".mysql_real_escape_string($_GET['id'])."'"));
echo '<link rel="stylesheet" src="styles.css" type="text/css" />';
echo bbcode($m);
?>