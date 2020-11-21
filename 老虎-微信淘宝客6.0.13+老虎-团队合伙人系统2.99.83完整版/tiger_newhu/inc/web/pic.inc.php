<?php
	global $_W, $_GPC;
		$sid = $_GPC['sid'];
		$url = pdo_fetchcolumn('select url from '.tablename($this->modulename."_share")." where id='{$sid}'");
		//$img = "temp_qrcode.png";
        $img = IA_ROOT.'/attachment/images/temp_qrcode.png';
		include "phpqrcode.php";/*引入PHP QR库文件*/
		$errorCorrectionLevel = "L";
		$matrixPointSize = "110";
		QRcode::png($url, $img, $errorCorrectionLevel, $matrixPointSize);
		header('Content-type: image/jpeg');
		header("Content-Disposition: attachment; filename='推广二维码.jpg'");
		readfile($img);
		@unlink($img);
?>