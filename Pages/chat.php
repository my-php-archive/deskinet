<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!isLogged()) { die(error('OOPS!', 'Debes estar logeado para entrar al chat', 'Ir a la p&aacute;gina principal', '/')); }
?>
<div id="cuerpocontainer">
<div class="container940">
<div class="box_title">
<div class="box_txt">Chat</div>
</div>
<div class="box_cuerpo" id="chat_bc">
<?php
$query = mysql_query("SELECT * FROM `chat` ORDER BY id DESC LIMIT 50");
$r = mysql_num_rows($query);
$i = $r;
while($message = mysql_fetch_array($query)) {
$u = mysql_fetch_array(mysql_query("SELECT nick, rank FROM `users` WHERE id = '".$message['author']."'"));
echo '<div id="m'.$message['id'].'" class="chat_m_'.$i--.'" style="display:inline;">';
if($currentuser['rank'] == 6 || $currentuser['rank'] == 8 || $currentuser['id'] == $message['author']) { echo '<img src="/images/borrar.gif" style="margin-right:2px;display:inline;cursor:pointer;" onclick="chat_delete('.$message['id'].');" />'; }
echo '<img src="/images/space.gif" style="margin-right:2px;display:inline;" class="systemicons rango'.$author['rank'].' alt="'.rankName($author['rank']).'" title="'.rankName($author['rank']).'" /> <a href="/perfil/'.htmlspecialchars($author['rank']).'"><strong>'.htmlspecialchars($author['rank']).'</strong></a> dice <span style="font-size:8pt;">('.date('H:i:s d/m/Y', $message['time']).')</span>: '.htmlspecialchars($message['message']).'<hr /></div>';
}
?>
<br />
<input type="text" id="cm" size="50" maxlength="50" />&nbsp;&nbsp;<input type="button" class="button" value="Enviar" onclick="chat_send();" />
</div>
</div>
</div>
<script type="text/javascript">
setInterval('chat_check();', 5000);
var chat_m_n = <?=$r;?>;
</script>