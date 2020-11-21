<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
class Verify_EweiShopV2Page extends PluginMobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$logid = intval($_GPC['logid']);
		$verifycode = trim($_GPC['verifycode']);
		$query = array('logid' => $logid, 'verifycode' => $verifycode);
		$url = mobileUrl('creditshop/verify/detail', $query, true);
		$qrcode = m('qrcode')->createQrcode($url);
		include $this->template();
	}
	public function detail() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$logid = intval($_GPC['logid']);
		$data = p('creditshop')->allow($logid);
		if (is_error($data)) 
		{
			$this->message($data['message'], webUrl('creditshop/log/detail', array('id' => $logid)), 'error');
		}
		extract($data);
		include $this->template('creditshop/verifydetail');
	}
	public function qrcode() 
	{
		global $_W;
		global $_GPC;
		$logid = intval($_GPC['logid']);
		$verifycode = $_GPC['verifycode'];
		$query = array('id' => $logid, 'verifycode' => $verifycode);
		$url = mobileUrl('creditshop/verify/detail', $query, true);
		show_json(1, array("url" => m("qrcode")->createQrcode($url)));
	}
	public function select() 
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$verifycode = trim($_GPC['verifycode']);
		if (empty($verifycode) || empty($orderid)) 
		{
			show_json(0);
		}
		$order = pdo_fetch('select id,verifyinfo from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid']));
		if (empty($order)) 
		{
			show_json(0);
		}
		$verifyinfo = iunserializer($order['verifyinfo']);
		foreach ($verifyinfo as &$v ) 
		{
			if ($v['verifycode'] == $verifycode) 
			{
				if (!(empty($v['select']))) 
				{
					$v['select'] = 0;
				}
				else 
				{
					$v['select'] = 1;
				}
			}
		}
		unset($v);
		pdo_update("ewei_shop_order", array("verifyinfo" => iserializer($verifyinfo)), array('id' => $orderid));
		show_json(1);
	}
	public function check() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select id,status,isverify,verifytype,verifynum from ' . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		if (empty($order)) 
		{
			show_json(0);
		}
		if (empty($order['isverify'])) 
		{
			show_json(0);
		}
		if ($order['verifytype'] == 0) 
		{
			show_json(0);
		}
		show_json(1);
	}
	public function complete() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$logid = intval($_GPC['id']);
		$times = intval($_GPC['times']);
		p("creditshop")->verify($logid, $times);
		show_json(1);
	}
	public function success() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['logid']);
		$times = intval($_GPC['times']);
		$this->message(array('title' => '操作完成', 'message' => '您可以退出浏览器了'), 'javascript:WeixinJSBridge.call("closeWindow");', 'success');
	}
}
?>