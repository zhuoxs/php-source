<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class ComWebPage extends WebPage
{
	public function __construct($_com = '')
	{
		parent::__construct();
		if (com('perm') && !com('perm')->check_com($_com)) {
			$this->message('你没有相应的权限查看');
		}
	}
}

?>
