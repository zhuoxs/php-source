<?php

header("Content-Type: image/jpeg;text/html; charset=utf-8");

$url = 'http://'.str_replace(array("http://","https://"),"",$_GET['tu']);

// header('Content-type: image/jpeg/png/gif/bmp/jpg/m4a/mp3/mp4');
echo file_get_contents($url);  

?>