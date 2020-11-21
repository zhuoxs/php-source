<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class SeckillWebPage extends PluginWebPage
{
	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;

		if (!function_exists('redis')) {
			$this->message('请更新到最新版本才能使用秒杀应用', 'exit', 'error');
			exit();
		}

		$redis = redis();

		if (is_error($redis)) {
			$message = '请联系管理员开启 redis 支持，才能使用秒杀应用';

			if ($_W['isfounder']) {
				$message .= '<br/><br/>错误信息: ' . $redis['message'];
			}

			$this->message($message, 'exit', 'error');
			exit();
		}
	}
}

?>
