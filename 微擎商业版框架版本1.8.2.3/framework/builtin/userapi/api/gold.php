<?php 
$message = $this->message;

preg_match('/(.*)天气/', $message['content'], $match);
$city = $match[1];

$url = 'http://php.weather.sina.com.cn/xml.php?city=%s&password=DJOYnieT8234jlsK&day=0';
$url = sprintf($url, urlencode(iconv('utf-8', 'gb2312', $city)));

$resp = ihttp_get($url);
$response = array();
if ($resp['code'] = 200 && $resp['content']) {
	$obj = simplexml_load_string($resp['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
	$dat = $obj->Weather->city . '今日天气' . PHP_EOL .
							'今天白天'.$obj->Weather->status1.'，'. $obj->Weather->temperature1 . '摄氏度。' . PHP_EOL .
							$obj->Weather->direction1 . '，' . $obj->Weather->power1 . PHP_EOL .
							'今天夜间'.$obj->Weather->status2.'，'. $obj->Weather->temperature2 . '摄氏度。' . PHP_EOL .
							$obj->Weather->direction2 . '，' . $obj->Weather->power2 . PHP_EOL . 
							'==================' . PHP_EOL .
							'【穿衣指数】：' . $obj->Weather->chy_shuoming . PHP_EOL .PHP_EOL .
							'【感冒指数】：' . $obj->Weather->gm_l . $obj->Weather->gm_s . PHP_EOL .PHP_EOL .
							'【空调指数】：' . $obj->Weather->ktk_s . PHP_EOL .PHP_EOL .
							'【污染物扩散条件】：' . $obj->Weather->pollution_l . $obj->Weather->pollution_s . PHP_EOL .PHP_EOL .
							'【洗车指数】：' . $obj->Weather->xcz_l . $obj->Weather->xcz_s . PHP_EOL .PHP_EOL .
							'【运动指数】：' . $obj->Weather->yd_l . $obj->Weather->yd_s . PHP_EOL .PHP_EOL .
							'【紫外线指数】：' . $obj->Weather->zwx_l . $obj->Weather->zwx_s . PHP_EOL .PHP_EOL .
							'【体感度指数】：' . $obj->Weather->ssd_l . $obj->Weather->ssd_s . PHP_EOL ;
	$response = $this->respText($dat);
}
return $response;
