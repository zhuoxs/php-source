<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require IA_ROOT . '/addons/ewei_shopv2/defines.php';
require EWEI_SHOPV2_INC . '/plugin_processor.php';
class QuickProcessor extends PluginProcessor
{
	public function __construct()
	{
		parent::__construct('quick');
	}

	public function respond($obj = NULL)
	{
		global $_W;
		$message = $obj->message;
		$content = $obj->message['content'];
		$msgtype = strtolower($message['msgtype']);
		$event = strtolower($message['event']);
		if ($msgtype == 'text' || $event == 'click') {
			$quick = pdo_fetch('select * from ' . tablename('ewei_shop_quick') . ' where keyword=:keyword and status=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':keyword' => $content));

			if (empty($quick)) {
				return $this->responseEmpty();
			}

			$resp = array('title' => $quick['enter_title'], 'description' => $quick['enter_desc'], 'picurl' => tomedia($quick['enter_icon']), 'url' => mobileUrl('quick', array('id' => $quick['id'])));
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
