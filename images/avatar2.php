<?php
header('Content-type: image/jpe');
$fimg = imagecreatefromjpeg('a32_'.mt_rand(1, 5).'.jpg');
$img = imagecreatetruecolor(20, 20);
imagecopyresampled($img, $fimg, 0, 0, 0, 0, 20, 20, 32, 32);
imagejpeg($img);
imagedestroy($fimg);
imagedestroy($img);
?>