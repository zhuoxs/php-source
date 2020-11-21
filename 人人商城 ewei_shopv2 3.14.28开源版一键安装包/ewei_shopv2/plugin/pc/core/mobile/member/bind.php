<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_login_mobile.php";
class Bind_EweiShopV2Page extends PcMobileLoginPage 
{
	protected $member;
	public function __construct() 
	{
		global $_W;
		global $_GPC;
		parent::__construct();
		$this->member = m('member')->getMember($_W['openid']);
	}
	public function main() 
	{
		global $_W;
		global $_GPC;
		$member = $this->member;
		$bind = 0;
		if (!(empty($member['mobile'])) && !(empty($member['mobileverify']))) 
		{
			$bind = 1;
		}
		if ($_W['ispost']) 
		{
			$mobile = trim($_GPC['mobile']);
			$verifycode = trim($_GPC['verifycode']);
			$pwd = trim($_GPC['pwd']);
			$confirm = $_GPC['confirm'];
			@session_start();
			$key = '__ewei_shop_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
			if (!(isset($_SESSION[$key])) || ($_SESSION[$key] !== $verifycode) || !(isset($_SESSION['verifycodesendtime'])) || (($_SESSION['verifycodesendtime'] + 600) < time())) 
			{
				show_json(0, '验证码错误或已过期');
			}
			$member2 = pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid and mobileverify=1 limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
			if (!(empty($bind))) 
			{
				if (!(empty($member2)) && ($member2['id'] != $member['id'])) 
				{
					show_json(0, '此手机号已绑定');
				}
				else if (!(empty($member2)) && ($member2['id'] == $member['id']) && $member['mobileverify']) 
				{
					show_json(0, '此手机号已与当前账号绑定');
				}
			}
			else if (!(empty($member2)) && ($member2['id'] != $member['id']) && empty($confirm)) 
			{
				if (strexists($member2['openid'], 'sns_wx_') || strexists($member2['openid'], 'sns_qq_') || strexists($member2['openid'], 'wap_user_')) 
				{
					show_json(-1, '此手机号已与其他帐号绑定<br>如果继续会将两个帐号信息合并');
				}
				show_json(-1, "此手机号已与其他帐号绑定<br>如果继续将会解绑之前帐号");
			}
			$salt = ((empty($member2) ? '' : $member2['salt']));
			if (empty($salt)) 
			{
				$salt = m('account')->getSalt();
			}
			if (!(empty($member2))) 
			{
				if (strexists($member2['openid'], 'sns_wx_') || strexists($member2['openid'], 'sns_qq_') || strexists($member2['openid'], 'wap_user_')) 
				{
					$tables = pdo_fetchall('SHOW TABLES like \'%_ewei_shop_%\'');
					foreach ($tables as $k => $v ) 
					{
						$v = array_values($v);
						$tablename = str_replace($_W['config']['db']['tablepre'], '', $v[0]);
						if (pdo_fieldexists($tablename, 'openid') && pdo_fieldexists($tablename, 'uniacid')) 
						{
							pdo_update($tablename, array('openid' => $member['openid']), array('uniacid' => $_W['uniacid'], 'openid' => $member2['openid']));
						}
						if (pdo_fieldexists($tablename, 'openid') && pdo_fieldexists($tablename, 'acid')) 
						{
							pdo_update($tablename, array('openid' => $member['openid']), array('acid' => $_W['acid'], 'openid' => $member2['openid']));
						}
					}
					pdo_update("ewei_shop_commission_apply", array("mid" => $member['id']), array('uniacid' => $_W['uniacid'], 'mid' => $member2['id']));
					pdo_update("ewei_shop_order", array("agentid" => $member['id']), array('agentid' => $member2['id']));
					pdo_update("ewei_shop_member", array("agentid" => $member['id']), array('agentid' => $member2['id']));
					if (0 < $member2['credit1']) 
					{
						m('member')->setCredit($member['openid'], 'credit1', abs($member2['credit1']), 'WAP会员数据合并增加积分 +' . $member2['credit1']);
					}
					if (0 < $member2['credit2']) 
					{
						m('member')->setCredit($member['openid'], 'credit2', abs($member2['credit2']), 'WAP会员数据合并增加余额 +' . $member2['credit2']);
					}
					pdo_delete("ewei_shop_member", array("id" => $member2['id'], 'uniacid' => $_W['uniacid']));
					$changeAgentid = false;
					if ($member2['agentid'] != $member['agentid']) 
					{
						if (!(empty($member2['agentid'])) && !(empty($member['agentid']))) 
						{
							if ($member2['childtime'] < $member['childtime']) 
							{
								$changeAgentid = true;
							}
						}
						else if (!(empty($member2['agentid']))) 
						{
							$changeAgentid = true;
						}
					}
					if ($changeAgentid) 
					{
						pdo_update('ewei_shop_member', array('agentid' => $member2['agentid']), array('id' => $member['id']));
					}
					if ($member2['isagent'] && $member2['status']) 
					{
						pdo_update('ewei_shop_member', array('isagent' => 1, 'status' => 1, 'agenttime' => $member2['agenttime']), array('id' => $member['id']));
					}
					else if ($member2['isagent']) 
					{
						if (!($member['isagent']) && !($member['status'])) 
						{
							pdo_update('ewei_shop_member', array('isagent' => 1, 'status' => 0), array('id' => $member['id']));
						}
					}
					$memberid = $member['id'];
					m("account")->setLogin($member['id']);
				}
				else 
				{
					pdo_update("ewei_shop_member", array("pwd" => '', "salt" => '', "mobileverify" => 0), array("id" => $member2['id'], 'uniacid' => $_W['uniacid']));
					$memberid = $member2['id'];
				}
				$createtime = (($member['createtime'] < $member2['createtime'] ? $member['createtime'] : $member2['createtime']));
			}
			else 
			{
				$createtime = $member['createtime'];
			}
			pdo_update("ewei_shop_member", array("mobile" => $mobile, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'mobileverify' => 1, 'createtime' => $createtime), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
			unset($_SESSION[$key]);
			m("account")->setLogin($member['id']);
			show_json(1);
		}
		$sendtime = $_SESSION['verifycodesendtime'];
		if (empty($sendtime) || (($sendtime + 60) < time())) 
		{
			$endtime = 0;
		}
		else 
		{
			$endtime = 60 - time() - $sendtime;
		}
		$ice_menu_array = array( array('menu_key' => 'info', 'menu_name' => '账户信息', 'menu_url' => mobileUrl('pc.member.info')), array('menu_key' => 'index', 'menu_name' => '绑定手机', 'menu_url' => mobileUrl('pc.member.bind')) );
		include $this->template();
	}
}
?>