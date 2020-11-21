<?php 
class membercard{

	static function get_cardid($userid,$sid){
		global $_W;
		if(empty($userid) || empty($sid)) return FALSE;
		$data = pdo_get('weliam_shiftcar_membercard', array('uniacid'=>$_W['uniacid'],'mid'=>$userid,'sid'=>$sid));
		if(empty($data)){
			$data = array('uniacid'=>$_W['uniacid'],'mid'=>$userid,'sid'=>$sid,'createtime'=>time());
			pdo_insert('weliam_shiftcar_membercard',$data);
			$data['id'] = pdo_insertid();
		}
		return $data;
	}
	
	static function recharge($retype,$fee,$card,$mid,$sid,$userid){
		global $_W;
		if(empty($retype) || empty($fee) || empty($card) || empty($mid)) return FALSE;
		if($retype == 1){
			$fee = Util::currency_format($fee);
			pdo_update('weliam_shiftcar_membercard',array('credit2'=>$fee+$card['credit2']),array('id'=>$card['id']));
			pdo_insert('weliam_shiftcar_mcrecord',array('uniacid'=>$_W['uniacid'],'mid'=>$userid,'sid'=>$sid,'type'=>$retype,'model'=>1,'fee'=>$fee,'remid'=>$mid,'createtime'=>time()));
		}else{
			pdo_update('weliam_shiftcar_membercard',array('times'=>intval($fee)+$card['times']),array('id'=>$card['id']));
			pdo_insert('weliam_shiftcar_mcrecord',array('uniacid'=>$_W['uniacid'],'mid'=>$userid,'sid'=>$sid,'type'=>$retype,'model'=>1,'times'=>intval($fee),'remid'=>$mid,'createtime'=>time()));
		}
		return TRUE;
	}
	
	static function consume($retype,$fee,$card,$mid,$sid,$userid,$jifennum){
		global $_W;
		if(empty($retype) || empty($fee) || empty($card) || empty($mid)) return FALSE;
		if($retype == 1){
			$fee = Util::currency_format($fee);
			pdo_update('weliam_shiftcar_membercard',array('credit2'=>$card['credit2'] - $fee),array('id'=>$card['id']));
			pdo_insert('weliam_shiftcar_mcrecord',array('uniacid'=>$_W['uniacid'],'mid'=>$userid,'sid'=>$sid,'type'=>$retype,'model'=>2,'fee'=>$fee,'remid'=>$mid,'createtime'=>time()));
		}else{
			pdo_update('weliam_shiftcar_membercard',array('times'=>$card['times'] - intval($fee)),array('id'=>$card['id']));
			pdo_insert('weliam_shiftcar_mcrecord',array('uniacid'=>$_W['uniacid'],'mid'=>$userid,'sid'=>$sid,'type'=>$retype,'model'=>2,'times'=>intval($fee),'remid'=>$mid,'createtime'=>time()));
		}
		if(!empty($jifennum)){
			pdo_update('weliam_shiftcar_membercard',array('credit1'=>$card['credit1'] + $jifennum),array('id'=>$card['id']));
			pdo_insert('weliam_shiftcar_mcrecord',array('uniacid'=>$_W['uniacid'],'mid'=>$userid,'sid'=>$sid,'type'=>3,'model'=>1,'fee'=>$jifennum,'remid'=>$mid,'createtime'=>time(),'remark'=>'消费返积分'));
		}
		return TRUE;
	}
	
	function mc_notice_init() {
		global $_W;
		if(empty($_W['account'])) {
			$_W['account'] = uni_fetch($_W['uniacid']);
		}
		if(empty($_W['account'])) {
			return error(-1, '创建公众号操作类失败');
		}
		if($_W['account']['level'] < 3) {
			return error(-1, '公众号没有经过认证，不能使用模板消息和客服消息');
		}
		$acc = WeAccount::create();
		if(is_null($acc)) {
			return error(-1, '创建公众号操作对象失败');
		}
		$setting = uni_setting();
		$noticetpl = $setting['tplnotice'];
		$acc->noticetpl = $noticetpl;
		if(!is_array($acc->noticetpl)) {
			return error(-1, '微信通知参数错误');
		}
		return $acc;
	}
	
	
	function mc_notice_public($openid, $title, $sender, $content, $url = '', $remark = '') {
		$acc = mc_notice_init();
		if(is_error($acc)) {
			return error(-1, $acc['message']);
		}
		$data = array(
			'first' => array(
				'value' => $title,
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $sender,
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => $content,
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => $remark,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['public'], $data, $url);
		return $status;
	}
	
	
	function mc_notice_recharge($openid, $uid = 0, $num = 0, $url = '', $remark = '') {
		global $_W;
		if(!$uid) {
			$uid = $_W['member']['uid'];
		}
		if(!$uid || !$num || empty($openid)) {
			return error(-1, '参数错误');
		}
		$acc = mc_notice_init();
		if(is_error($acc)) {
			return error(-1, $acc['message']);
		}
		if(empty($acc->noticetpl['recharge']['tpl'])) {
			return error(-1, '未开启通知');
		}
		$credit = mc_credit_fetch($uid);
		$time = date('Y-m-d H:i');
		if(empty($url)) {
			$url = murl('mc/bond/credits', array('credittype' => 'credit2', 'type' => 'record', 'period' => '1'), true, true);
		}
		if($_W['account']['level'] == ACCOUNT_SERVICE_VERIFY) {
			$data = array(
				'first' => array(
					'value' => "您好，您在{$time}进行会员余额充值，充值金额{$num}元，充值后余额为{$credit['credit2']}元",
					'color' => '#ff510'
				),
				'accountType' => array(
					'value' => '会员UID',
					'color' => '#ff510'
				),
				'account' => array(
					'value' => $uid,
					'color' => '#ff510'
				),
				'amount' => array(
					'value' => $num . '元',
					'color' => '#ff510'
				),
				'result' => array(
					'value' => '充值成功',
					'color' => '#ff510'
				),
				'remark' => array(
					'value' => "{$remark}" ,
					'color' => '#ff510'
				),
			);
			$status = $acc->sendTplNotice($openid, $acc->noticetpl['recharge']['tpl'], $data, $url);
		}
		if($_W['account']['level'] == ACCOUNT_SUBSCRIPTION_VERIFY) {
			$info = "【{$_W['account']['name']}】充值通知\n";
			$info .= "您在{$time}进行会员余额充值，充值金额【{$num}】元，充值后余额【{$credit['credit2']}】元。\n";
			$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
			$custom = array(
				'msgtype' => 'text',
				'text' => array('content' => urlencode($info)),
				'touser' => $openid,
			);
			$status = $acc->sendCustomNotice($custom);
		}
		return $status;
	}
	
	
	function mc_notice_credit2($openid, $uid, $credit2_num, $credit1_num = 0, $store = '线下消费', $url = '', $remark = '谢谢惠顾，点击查看详情') {
		global $_W;
		if(!$uid) {
			$uid = $_W['member']['uid'];
		}
		if(!$uid || !$credit2_num || empty($openid)) {
			return error(-1, '参数错误');
		}
		$acc = mc_notice_init();
		if(is_error($acc)) {
			return error(-1, $acc['message']);
		}
		if(empty($acc->noticetpl['credit2']['tpl'])) {
			return error(-1, '未开启通知');
		}
		$credit = mc_credit_fetch($uid);
		$time = date('Y-m-d H:i');
		if(empty($url)) {
			$url = murl('mc/bond/credits', array('credittype' => 'credit2', 'type' => 'record', 'period' => '1'), true, true);
		}
		if($_W['account']['level'] == ACCOUNT_SERVICE_VERIFY) {
			$data = array(
				'first' => array(
					'value' => "您好，您在{$time}有余额消费",
					'color' => '#ff510'
				),
				'keyword1' => array(
					'value' => abs($credit2_num) . '元',
					'color' => '#ff510'
				),
				'keyword2' => array(
					'value' => floatval($credit1_num) . '积分',
					'color' => '#ff510'
				),
				'keyword3' => array(
					'value' => trim($store),
					'color' => '#ff510'
				),
				'keyword4' => array(
					'value' => $credit['credit2'] . '元',
					'color' => '#ff510'
				),
				'keyword5' => array(
					'value' => $credit['credit1'] . '积分',
					'color' => '#ff510'
				),
				'remark' => array(
					'value' => "{$remark}" ,
					'color' => '#ff510'
				),
			);
			$status = $acc->sendTplNotice($openid, $acc->noticetpl['credit2']['tpl'], $data, $url);
		}
		if($_W['account']['level'] == ACCOUNT_SUBSCRIPTION_VERIFY) {
			$info = "【{$_W['account']['name']}】消费通知\n";
			$info .= "您在{$time}进行会员余额消费，消费金额【{$credit2_num}】元，获得积分【{$credit1_num}】,消费后余额【{$credit['credit2']}】元，消费后积分【{$credit['credit1']}】。\n";
			$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
			$custom = array(
				'msgtype' => 'text',
				'text' => array('content' => urlencode($info)),
				'touser' => $openid,
			);
			$status = $acc->sendCustomNotice($custom);
		}
		return $status;
	}
	
	
	function mc_notice_credit1($openid, $uid, $credit1_num, $tip, $url = '', $remark = '谢谢惠顾，点击查看详情') {
		global $_W;
		if(!$uid) {
			$uid = $_W['member']['uid'];
		}
		if(!$uid || !$credit1_num || empty($tip)) {
			return error(-1, '参数错误');
		}
		$acc = mc_notice_init();
		if(is_error($acc)) {
			return error(-1, $acc['message']);
		}
		if(empty($acc->noticetpl['credit1']['tpl'])) {
			return error(-1, '未开启通知');
		}
		$credit = mc_credit_fetch($uid);
		$time = date('Y-m-d H:i');
		if(empty($url)) {
			$url = murl('mc/bond/credits', array('credittype' => 'credit1', 'type' => 'record', 'period' => '1'), true, true);
		}
		$credit1_num = floatval($credit1_num);
		$type = '消费';
		if($credit1_num > 0) {
			$type = '到账';
		}
		$username = $_W['member']['realname'];
		if(empty($username)) {
			$username = $_W['member']['nickname'];
		}
		if(empty($username)) {
			$username = $uid;
		}
		if($_W['account']['level'] == ACCOUNT_SERVICE_VERIFY) {
			$data = array(
				'first' => array(
					'value' => "您好，您在{$time}有积分变更",
					'color' => '#ff510'
				),
				'account' => array(
					'value' => $username,
					'color' => '#ff510'
				),
				'time' => array(
					'value' => $time,
					'color' => '#ff510'
				),
				'type' => array(
					'value' => $tip,
					'color' => '#ff510'
				),
				'creditChange' => array(
					'value' => $type,
					'color' => '#ff510'
				),
				'number' => array(
					'value' => abs($credit1_num) . '积分',
					'color' => '#ff510'
				),
				'creditName' => array(
					'value' => '账户积分',
					'color' => '#ff510'
				),
				'amount' => array(
					'value' => abs($credit['credit1']) . '积分',
					'color' => '#ff510'
				),
				'remark' => array(
					'value' => "{$remark}" ,
					'color' => '#ff510'
				),
			);
			$status = $acc->sendTplNotice($openid, $acc->noticetpl['credit1']['tpl'], $data, $url);
		}
		if($_W['account']['level'] == ACCOUNT_SUBSCRIPTION_VERIFY) {
			$info = "【{$_W['account']['name']}】积分变更通知\n";
			$info .= "您在{$time}有积分{$type}，{$type}积分【{$credit1_num}】，变更原因：【{$tip}】,消费后账户积分余额【{$credit['credit1']}】。\n";
			$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
			$custom = array(
				'msgtype' => 'text',
				'text' => array('content' => urlencode($info)),
				'touser' => $openid,
			);
			$status = $acc->sendCustomNotice($custom);
		}
		return $status;
	}
	
	
	function mc_notice_nums_plus($openid, $type, $num, $total_num, $remark = '感谢您的支持，祝您生活愉快！') {
		global $_W;
		if(empty($num) || empty($total_num) || empty($type)) {
			return error(-1, '参数错误');
		}
		$acc = mc_notice_init();
		if(is_error($acc)) {
			return error(-1, $acc['message']);
		}
		if(empty($acc->noticetpl['nums_plus']['tpl'])) {
			return error(-1, '未开启通知');
		}
		$time = date('Y-m-d H:i');
		if($_W['account']['level'] == ACCOUNT_SERVICE_VERIFY) {
			$data = array(
				'first' => array(
					'value' => "您好，您的{$type}已充次成功",
					'color' => '#ff510'
				),
				'keyword1' => array(
					'value' => $time,
					'color' => '#ff510'
				),
				'keyword2' => array(
					'value' => $num . '次',
					'color' => '#ff510'
				),
				'keyword3' => array(
					'value' => $total_num . '次',
					'color' => '#ff510'
				),
				'keyword4' => array(
					'value' => '用完为止',
					'color' => '#ff510'
				),
				'remark' => array(
					'value' => "{$remark}" ,
					'color' => '#ff510'
				),
			);
			$status = $acc->sendTplNotice($openid, $acc->noticetpl['nums_plus']['tpl'], $data);
		}
		if($_W['account']['level'] == ACCOUNT_SUBSCRIPTION_VERIFY) {
			$info = "【{$_W['account']['name']}】-【{$type}】充值通知\n";
			$info .= "您的{$type}已充值成功，本次充次【{$num}】次，总剩余【{$total_num}】次。\n";
			$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
			$custom = array(
				'msgtype' => 'text',
				'text' => array('content' => urlencode($info)),
				'touser' => $openid,
			);
			$status = $acc->sendCustomNotice($custom);
		}
		return $status;
	}
	
	
	function mc_notice_nums_times($openid, $card_id, $type, $num, $remark = '感谢您对本店的支持，欢迎下次再来！') {
		global $_W;
		if(empty($num) || empty($type) || empty($card_id)) {
			return error(-1, '参数错误');
		}
		$acc = mc_notice_init();
		if(is_error($acc)) {
			return error(-1, $acc['message']);
		}
		if(empty($acc->noticetpl['nums_times']['tpl'])) {
			return error(-1, '未开启通知');
		}
		$time = date('Y-m-d H:i');
		if($_W['account']['level'] == ACCOUNT_SERVICE_VERIFY) {
			$data = array(
				'first' => array(
					'value' => "您好，您的{$type}已成功使用了【1】次。",
					'color' => '#ff510'
				),
				'keyword1' => array(
					'value' => $card_id,
					'color' => '#ff510'
				),
				'keyword2' => array(
					'value' => $time,
					'color' => '#ff510'
				),
				'keyword3' => array(
					'value' => $num . '次',
					'color' => '#ff510'
				),
				'keyword4' => array(
					'value' => '用完为止',
					'color' => '#ff510'
				),
				'remark' => array(
					'value' => "{$remark}" ,
					'color' => '#ff510'
				),
			);
			$status = $acc->sendTplNotice($openid, $acc->noticetpl['nums_times']['tpl'], $data);
		}
		if($_W['account']['level'] == ACCOUNT_SUBSCRIPTION_VERIFY) {
			$info = "【{$_W['account']['name']}】-【{$type}】消费通知\n";
			$info .= "您的{$type}已成功使用了一次，总剩余【{$num}】次，消费时间【{$time}】。\n";
			$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
			$custom = array(
				'msgtype' => 'text',
				'text' => array('content' => urlencode($info)),
				'touser' => $openid,
			);
			$status = $acc->sendCustomNotice($custom);
		}
		return $status;
	}
}