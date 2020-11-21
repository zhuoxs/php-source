<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/common.php";
class PcMobileLoginPage extends PluginMobileLoginPage 
{
	public function __construct() 
	{
		global $_W;
		global $_GPC;
		m("shop")->checkClose();
		$preview = intval($_GPC['preview']);
		$wap = m('common')->getSysset('wap');
		if ($wap['open'] && !(is_weixin()) && empty($preview)) 
		{
			if ($this instanceof MobileLoginPage || $this instanceof PluginMobileLoginPage) 
			{
				if (empty($_W['openid'])) 
				{
					$_W['openid'] = m('account')->checkOpenid();
					$url = urlencode(base64_encode($_SERVER['QUERY_STRING']));
					if (empty($_W['openid'])) 
					{
						$loginurl = mobileUrl('pc/account/login', array('mid' => $_GPC['mid'], 'backurl' => ($_W['isajax'] ? '' : $url)));
						if ($_W['isajax']) 
						{
							show_json(0, array('url' => $loginurl, 'message' => '请先登录!'));
						}
						header("location: " . $loginurl);
						exit();
					}
				}
			}
			else 
			{
				$_W['openid'] = m('account')->checkOpenid();
			}
		}
		else 
		{
			if ($preview && !(is_weixin())) 
			{
				$_W['openid'] = 'oKnEQuKiZar_U2blvbFwNiI8WoiQ';
			}
			if (EWEI_SHOP_DEBUG) 
			{
				$_W['openid'] = 'oKnEQuKiZar_U2blvbFwNiI8WoiQ';
			}
		}
		$member = m('member')->checkMember();
		$_W['mid'] = ((!(empty($member)) ? $member['id'] : ''));
		$_W['mopenid'] = ((!(empty($member)) ? $member['openid'] : ''));
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if (!(empty($_GPC['merchid'])) && $merch_plugin && $merch_data['is_openmerch']) 
		{
			$this->merch_user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:id limit 1', array(':id' => intval($_GPC['merchid'])));
		}
		$this->model = m('plugin')->loadModel($GLOBALS['_W']['plugin']);
		$this->set = $this->model->getSet();
	}
}
?>