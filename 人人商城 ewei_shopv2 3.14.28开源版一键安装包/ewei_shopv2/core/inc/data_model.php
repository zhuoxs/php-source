<?php
class DataModel
{
	public function read($key = '')
	{
		global $_W;
		global $_GPC;
		return m('cache')->getArray('data_' . $_W['uniacid'] . '_' . $key);
	}

	public function write($key, $data)
	{
		global $_W;
		global $_GPC;
		m('cache')->set('data_' . $_W['uniacid'] . '_' . $key, $data);
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
