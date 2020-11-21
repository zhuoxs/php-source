<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$this->message('请求参数错误！', mobileUrl());
		}
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_universalform_type') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$fields = iunserializer($item['fields']);
		include $this->template();
	}

	public function tranf($universalformdata)
	{
		$temp = array();
		if($universalformdata)
		{
			foreach ($universalformdata as $vv)
			{
				if(is_array($vv))
				{
					foreach ($vv as $v )
					{
						$temp[] = $v;
					}
				}
				else {
					$temp[] = $vv;
				}
			}
		}
		return $temp;
	}
	public function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_universalform_type') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		
		$fields = iunserializer($item['fields']);
		$universalformdata = $_GPC['universalformdata'];
		$insert_data = $this->model->getInsertData( iunserializer($item['fields']), $universalformdata);
		
		
		$insert = array(
				'typeid' => $item['id'],
				'fields' => implode('',$this->tranf($universalformdata)),
				'universalformfields' => $insert_data['data'],
				'uniacid' => $_W['uniacid'],
				'openid'=>$_W['openid']
		);
		
		pdo_insert('ewei_shop_universalform_data', $insert);
		show_json(1, "保存成功");
	}
	
}


?>