<?php
//QQ63779278
class SnsMobilePage extends PluginMobilePage
{
	public $islogin = 0;

	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;
		$this->islogin = empty($_W['openid']) ? 0 : 1;
		$this->model->checkMember();
	}
}

?>
