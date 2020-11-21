<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
class Comment_EweiShopV2Page extends PluginMobileLoginPage 
{
	public function __construct() 
	{
		parent::__construct();
		$trade = m('common')->getSysset('trade');
		if (!(empty($trade['closecomment']))) 
		{
			$this->message('不允许评论!', '', 'error');
		}
	}
	public function main() 
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$goodsid = intval($_GPC['goodsid']);
		$logid = intval($_GPC['logid']);
		$log = pdo_fetch('select log.id,log.status,log.goodsid,g.goodstype,g.type,log.iscomment,log.optionid,g.thumb,o.title as optiontitle,g.title' . "\n" . '                ,g.credit,g.money' . "\n" . '                from ' . tablename('ewei_shop_creditshop_log') . ' as log' . "\n" . '                left join ' . tablename('ewei_shop_creditshop_goods') . ' as g on g.id = log.goodsid' . "\n" . '                left join ' . tablename('ewei_shop_creditshop_option') . ' o on o.id=log.optionid' . "\n" . '                where log.uniacid = ' . $uniacid . ' and log.goodsid = ' . $goodsid . ' and log.id = ' . $logid . ' ');
		$log = set_medias($log, 'thumb');
		if (($log['money'] - intval($log['money'])) == 0) 
		{
			$log['money'] = intval($log['money']);
		}
		if (empty($log)) 
		{
			header('location: ' . mobileUrl('creditshop/log'));
			exit();
		}
		if ($log['goodstype'] == 0) 
		{
			if ($log['status'] != 3) 
			{
				$this->message('订单未完成，不能评价!', mobileUrl('creditshop/log/detail', array('id' => $logid)));
			}
		}
		else if ($log['goodstype'] == 1) 
		{
			if ($log['status'] != 3) 
			{
				$this->message('订单未完成，不能评价!', mobileUrl('creditshop/log/detail', array('id' => $logid)));
			}
		}
		else if ($log['goodstype'] == 2) 
		{
			if ($log['status'] != 3) 
			{
				$this->message('订单未完成，不能评价!', mobileUrl('creditshop/log/detail', array('id' => $logid)));
			}
		}
		else if ($log['goodstype'] == 3) 
		{
			if ($log['status'] != 3) 
			{
				$this->message('订单未完成，不能评价!', mobileUrl('creditshop/log/detail', array('id' => $logid)));
			}
		}
		if (2 <= $log['iscomment']) 
		{
			$this->message('您已经评价过了!', mobileUrl('creditshop/log/detail', array('id' => $logid)));
		}
		include $this->template();
	}
	public function submit() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$logid = intval($_GPC['logid']);
		$log = pdo_fetch('select id,status,iscomment,logno from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $logid, ':uniacid' => $uniacid, ':openid' => $openid));
		if (empty($log)) 
		{
			show_json(0, '兑换记录未找到');
		}
		$member = m('member')->getMember($openid);
		$comments = $_GPC['comments'];
		if (!(is_array($comments))) 
		{
			show_json(0, '数据出错，请重试!');
		}
		$trade = m('common')->getSysset('trade');
		if (!(empty($trade['commentchecked']))) 
		{
			$checked = 0;
		}
		else 
		{
			$checked = 1;
		}
		foreach ($comments as $c ) 
		{
			$old_c = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_creditshop_comment') . "\n" . '            where uniacid=:uniacid and logid=:logid and goodsid=:goodsid limit 1', array(':uniacid' => $_W['uniacid'], ':goodsid' => $c['goodsid'], ':logid' => $logid));
			if (empty($old_c)) 
			{
				$comment = array('uniacid' => $uniacid, 'logid' => $logid, 'logno' => $log['logno'], 'goodsid' => $c['goodsid'], 'level' => $c['level'], 'content' => trim($c['content']), 'images' => (is_array($c['images']) ? iserializer($c['images']) : iserializer(array())), 'openid' => $openid, 'nickname' => $member['nickname'], 'headimg' => $member['avatar'], 'time' => time(), 'checked' => $checked);
				pdo_insert("ewei_shop_creditshop_comment", $comment);
			}
			else 
			{
				$comment = array('append_content' => trim($c['content']), 'append_images' => (is_array($c['images']) ? iserializer($c['images']) : iserializer(array())), 'append_checked' => $checked, 'append_time' => time());
				pdo_update("ewei_shop_creditshop_comment", $comment, array('uniacid' => $_W['uniacid'], 'goodsid' => $c['goodsid'], 'logid' => $logid));
			}
		}
		if ($log['iscomment'] <= 0) 
		{
			$d['iscomment'] = 1;
		}
		else 
		{
			$d['iscomment'] = 2;
		}
		pdo_update("ewei_shop_creditshop_log", $d, array('id' => $logid, 'uniacid' => $uniacid));
		show_json(1);
	}
}
?>