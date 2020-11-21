<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Tmessage_EweiShopV2ComModel extends ComModel
{
	public function perms()
	{
		return array(
			'tmessage' => array('text' => $this->getName(), 'isplugin' => true, 'view' => '浏览', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log', 'send' => '发送-log')
		);
	}
}

?>
