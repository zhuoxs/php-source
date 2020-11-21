<?php 
 include('phpqrcode.php'); 
//取得GET参数
$text       = isset($_GET["text"]) ? $_GET["text"] : ''; //二维码内容
$errorLevel = isset($_GET["e"]) ? $_GET["e"] : 'H'; //容错级别 默认L
$PointSize  = isset($_GET["p"]) ? $_GET["p"] : '10.882353'; //二维码尺寸 默认12
$margin     = isset($_GET["m"]) ? $_GET["m"] : '1'; //二维码白边框尺寸 默认2

$w =  isset($_GET["w"]) ? $_GET["w"] : '600'; 

function getqrcode($value,$errorCorrectionLevel,$matrixPointSize,$margin,$w) {
    QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, $margin,false,$w);
}
getqrcode($text, $errorLevel, $PointSize, $margin,$w);

?>