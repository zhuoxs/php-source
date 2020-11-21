<?php 
$url = 'http://www.zdic.net/nongli/' . date('Y-n-j') . '.htm';
$week = array();
$week[0] = '日';
$week[1] = '一';
$week[2] = '二';
$week[3] = '三';
$week[4] = '四';
$week[5] = '五';
$week[6] = '六';

$reply = '今天是 ' . date('Y年n月j日') . ' 星期' . $week[date('w')];
$resp = ihttp_get($url);
if ($resp['code'] == 200 && $resp['content']) {
	$content = $resp['content'];
	$reply .= "==================\n";
	if(preg_match('/<td colspan="2" class="l3">(?P<block>.+?)<\/td>/s', $content, $block)) {
		$date = explode('<br>', $block['block']);
		array_pop($date);
		if(count($date) < 4) {
			$shift = array_shift($date);
			$year = substr($shift, -9);
			array_unshift($date, $year);
			array_unshift($date, str_replace($year, '', $shift));
		}
		$reply .= '农历: ' . implode(' ', $date);
	}
	if(preg_match('/<td colspan="2" class="ly2">(?P<block>.+?)<\/td>/s', $content, $block)) {
		if(preg_match_all('/title=\'(?P<line>.+?)\'/', $block['block'], $lines)) {
			$reply .= "==================\n";
			$reply .= "宜: \n";
			foreach($lines['line'] as $l) {
				$reply .= "{$l}\n";
			}
		}
	}
	if(preg_match('/<td colspan="4" class="lj2">(?P<block>.+?)<\/td>/s', $content, $block)) {
		if(preg_match_all('/title=\'(?P<line>.+?)\'/', $block['block'], $lines)) {
			$reply .= "==================\n";
			$reply .= "忌: \n";
			foreach($lines['line'] as $l) {
				$reply .= "{$l}\n";
			}
		}
	}
}
return $this->respText($reply);
