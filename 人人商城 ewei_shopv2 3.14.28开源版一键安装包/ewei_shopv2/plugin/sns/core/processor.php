<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require IA_ROOT . '/addons/ewei_shopv2/defines.php';
require EWEI_SHOPV2_INC . '/plugin_processor.php';
class SnsProcessor extends PluginProcessor
{
	public function __construct()
	{
		parent::__construct('sns');
	}

	public function respond($obj = NULL)
	{
		global $_W;
		$message = $obj->message;
		$content = $obj->message['content'];
		$msgtype = strtolower($message['msgtype']);
		$event = strtolower($message['event']);
		if ($msgtype == 'text' || $event == 'click') {
			$board = pdo_fetch('select id,title,logo,`desc` from ' . tablename('ewei_shop_sns_board') . ' where keyword=:keyword and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':keyword' => $content));

			if (empty($board)) {
				return $this->responseEmpty();
			}

			$r_title = $board['title'];
			$r_desc = $board['desc'];
			$r_img = $board['logo'];
			$r_img = tomedia($r_img);
			$news = array(
				array('title' => $r_title, 'picurl' => $r_img, 'description' => $r_desc, 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=sns.board&id=' . $board['id'])
				);
			return $obj->respNews($news);
		}

		return $this->responseEmpty();
	}

	private function responseEmpty()
	{
		ob_clean();
		ob_start();
		echo '';
		ob_flush();
		ob_end_flush();
		exit(0);
	}
}

?>
