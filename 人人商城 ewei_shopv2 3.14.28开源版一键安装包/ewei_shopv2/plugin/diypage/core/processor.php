<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require IA_ROOT . '/addons/ewei_shopv2/defines.php';
require EWEI_SHOPV2_INC . '/plugin_processor.php';
class DiypageProcessor extends PluginProcessor
{
	public function __construct()
	{
		parent::__construct('diypage');
	}

	public function respond($obj = NULL)
	{
		global $_W;
		$message = $obj->message;
		$content = $obj->message['content'];
		$msgtype = strtolower($message['msgtype']);
		$event = strtolower($message['event']);
		if ($msgtype == 'text' || $event == 'click') {
			$page = pdo_fetch('select * from ' . tablename('ewei_shop_diypage') . ' where keyword=:keyword and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':keyword' => $content));
			if (empty($page) || empty($page['data'])) {
				return $this->responseEmpty();
			}

			$page['data'] = base64_decode($page['data']);
			$page['data'] = json_decode($page['data'], true);
			if (empty($page['data']) || !is_array($page['data'])) {
				return $this->responseEmpty();
			}

			$resp = array('title' => $page['data']['page']['title'], 'description' => $page['data']['page']['desc'], 'picurl' => tomedia($page['data']['page']['icon']), 'url' => mobileUrl('diypage', array('id' => $page['id'])));
			return $obj->respNews($resp);
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
