<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require IA_ROOT . '/addons/ewei_shopv2/defines.php';
require EWEI_SHOPV2_INC . '/plugin_processor.php';
class ArticleProcessor extends PluginProcessor
{
	public function __construct()
	{
		parent::__construct('article');
	}

	public function respond($obj = NULL)
	{
		global $_W;
		$message = $obj->message;
		$content = $obj->message['content'];
		$msgtype = strtolower($message['msgtype']);
		$event = strtolower($message['event']);
		if ($msgtype == 'text' || $event == 'click') {
			$page = pdo_fetch('select * from ' . tablename('ewei_shop_article') . ' where article_keyword2=:keyword2 and article_state=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':keyword2' => $content));

			if (empty($page)) {
				return $this->responseEmpty();
			}

			$r_title = $page['article_title'];
			$r_desc = $page['resp_desc'];
			$r_img = $page['resp_img'];
			$r_img = tomedia($r_img);
			$news = array(
				array('title' => $r_title, 'picurl' => $r_img, 'description' => $r_desc, 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=article&aid=' . $page['id'])
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
