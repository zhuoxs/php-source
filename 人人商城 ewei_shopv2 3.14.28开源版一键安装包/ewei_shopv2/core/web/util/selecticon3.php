<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Selecticon3_EweiShopV2Page extends WebPage
{
	public function main()
	{
		$csspath = dirname(__DIR__) . '/../../static/fonts/wxiconx/iconfont.css';
		$list = array();
		$content = file_get_contents($csspath);

		if (!empty($content)) {
			preg_match_all('/.(.*?):before/', $content, $matchs);
			$list = $matchs[1];
		}

		include $this->template();
	}
}

?>
