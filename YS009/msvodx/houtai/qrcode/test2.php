<?php 
 include('qrcode.php'); 
// 待生成二维码的字符
$text = 'http://jifen.cqddzx.com/a/0.php?s=i847443084074401840&c=54239';
$text2 = 'http://jifen.cqddzx.com/a/0.php?s=i847443084069975797&c=b44d7';

// 保存路径
// false 为直接输出图片
// ./qrcode.png为把图片保存为当前目录下，名为qrcode.png
$filename = false;

// 像素
$px = 4;

// 图片尺寸
$size = 4;

// 范围从 0（最差质量，文件更小）到 100（最佳质量，文件最大）。默认为 IJG 默认的质量值（大约 75）。
$quality = 85;

//QRcode::png($text, false);
QRcode::png($text2, false);


?>