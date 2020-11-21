<?php
defined('IN_IA') or exit('Access Denied');
date_default_timezone_set('Etc/GMT-8');

function sendTplNotice($touser, $template_id, $postdata, $url = '', $account = null) {
    global $_W;
    load()->model('account');
    if (!$account) {
        if (!empty($_W['acid'])) {
            $account = WeAccount::create($_W['acid']);
        } else {
            $acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(
                ':uniacid' => $_W['uniacid']
            ));
            $account = WeAccount::create($acid);
        }
    }
    if (!$account) {
        return;
    }
    return $account->sendTplNotice($touser, $template_id, $postdata, $url);
}

function movecar_notice($openid,$recordid) {
    global $_W;
    $m_send = $_W['wlsetting']['notice']['m_movecar'];
    $postdata = array(
        "first" => array(
            "value" => "您好，您有一条挪车提醒",
            "color" => "#173177"
        ) ,
        "keyword1" => array(
            'value' => "系统",
            "color" => "#173177"
        ) ,
        "keyword2" => array(
            'value' => "您的爱车挡住了他人车辆，麻烦您给挪一下呗",
            "color" => "#173177"
        ) ,
        "remark" => array(
            "value" => '如有疑问，请点击查看详情或联系客服',
            "color" => "#173177"
        ) ,
    );
	$url = app_url('member/record/detail',array('id' => $recordid));
    sendTplNotice($openid, $m_send, $postdata, $url);
}

function movecarsch_notice($openid,$carcard,$recordid) {
    global $_W;
    $m_send = $_W['wlsetting']['notice']['m_schedule'];
    $postdata = array(
        "first" => array(
            "value" => "你好，已成功通知到对方车主，预计15分钟内完成挪车。",
            "color" => "#173177"
        ) ,
        "keyword1" => array(
            'value' => $carcard,
            "color" => "#173177"
        ) ,
        "keyword2" => array(
            'value' => date('Y年m月d日 H:i:s', time()),
            "color" => "#173177"
        ) ,
        "keyword3" => array(
            'value' => "已成功通知车主",
            "color" => "#173177"
        ) ,
        "remark" => array(
            "value" => '点击查看详情，感谢你的使用。',
            "color" => "#173177"
        ) ,
    );
	$url = app_url('member/record/detail',array('id' => $recordid));
    sendTplNotice($openid, $m_send, $postdata, $url);
}

function delivery_notice($openid,$orderNo,$expressName,$expressOrder) {
    global $_W;
	wl_load()->model('setting');
	$settings = wlsetting_read('notice');
    $m_send = $settings['delivery'];
    $postdata = array(
        "first" => array(
            "value" => "亲，挪车卡已经启程了，好想快点来到你身边",
            "color" => "#173177"
        ) ,
        "keyword1" => array(
            'value' => $orderNo,
            "color" => "#173177"
        ) ,
        "keyword2" => array(
            'value' => $expressName,
            "color" => "#173177"
        ) ,
        "keyword3" => array(
            'value' => $expressOrder,
            "color" => "#173177"
        ) ,
        "remark" => array(
            "value" => '点击查看完整的物流信息 。如有问题请直接在微信里留言，我们将在第一时间为您服务！',
            "color" => "#173177"
        ) ,
    );
	$url = app_url('app/apply');
    sendTplNotice($openid, $m_send, $postdata, $url);
}

function pecc_notice($order) {
    global $_W;
	$openid = pdo_getcolumn('weliam_shiftcar_member', array('id' => $order['mid']), 'openid');
    $m_send = $_W['wlsetting']['pecc']['m_pecc'];
    $postdata = array(
        "first" => array(
            "value" => "您好，您有一条新的违章",
            "color" => "#173177"
        ) ,
        "keyword1" => array(
            'value' => $order['hphm'],
            "color" => "#173177"
        ) ,
        "keyword2" => array(
            'value' => date('Y-m-d H:i:s',$order['acttime']),
            "color" => "#173177"
        ) ,
        "keyword3" => array(
            'value' => $order['address'],
            "color" => "#173177"
        ) ,
        "keyword4" => array(
            'value' => $order['info'],
            "color" => "#173177"
        ) ,
        "remark" => array(
            "value" => '请及时处理，以免产生滞纳金或被扣车等情况，点击查看详情。',
            "color" => "#173177"
        ) ,
    );
	$url = app_url('app/pecc/list');
    sendTplNotice($openid, $m_send, $postdata, $url);
}

function sendstore_notice($openid,$sid,$sendcontent) {
    global $_W;
	$storename = pdo_getcolumn('wlmerchant_merchantdata', array('id' => $sid), 'storename');
    $m_send = $_W['wlsetting']['merchant']['m_sendmsg'];
    $postdata = array(
        "first" => array(
            "value" => "您收到了一条商家发送的提醒消息",
            "color" => "#173177"
        ) ,
        "keyword1" => array(
            'value' => $storename,
            "color" => "#173177"
        ) ,
        "keyword2" => array(
            'value' => $sendcontent,
            "color" => "#173177"
        ) ,
        "keyword3" => array(
            'value' => date('Y-m-d H:i:s',time()),
            "color" => "#173177"
        ) ,
        "remark" => array(
            "value" => '请及时处理，如有打扰尽请谅解。',
            "color" => "#173177"
        ) ,
    );
	$url = '';
    sendTplNotice($openid, $m_send, $postdata, $url);
}

function sendlimit_notice($str) {
    global $_W;
	$member = pdo_get('weliam_shiftcar_member', array('id' => $str['mid']), array('openid','plate1','plate_number','plate2'));
	$tpl = pdo_get('weliam_shiftcar_limitlinetpl',array('uniacid'=>$_W['uniacid'],'id'=>$str['tplid']));
    $m_send = $_W['wlsetting']['limitline']['m_limit'];
	$tomorr = date('m月d日',time()+86400);
	$interval = unserialize($tpl['interval']);
	if($tpl['type'] == 1){
		$limitweek = explode(';', $tpl['limitweek']);
		$week = date('w');
		$wh = $limitweek[$week];
	}elseif($tpl['type'] == 2){
		$limitday = explode(';', $tpl['limitday']);
		$day = date('j');
		$day = $day%2;
		if($day == 0){
			$wh = $limitday[0];
		}else{
			$wh = $limitday[1];
		}
	}
	
    $postdata = array(
        "first" => array(
            "value" => "尊敬的车主，您的车辆明日限行：\n",
            "color" => "#173177"
        ) ,
        "keyword1" => array(
            'value' => $member['plate1'].$member['plate2'].$member['plate_number'],
            "color" => "#173177"
        ) ,
        "keyword2" => array(
            'value' => $tpl['reason'],
            "color" => "#173177"
        ) ,
        "remark" => array(
            "value" => "限行尾号：".$wh."\n\n".'请明日（'.$tomorr.'）'.$interval['start']."—".$interval['end'].",不要驶入".$tpl['region'],
            "color" => "#173177"
        ) ,
    );
	$url = app_url('app/limitline',array('id'=>$tpl['id']));
    sendTplNotice($member['openid'], $m_send, $postdata, $url);
}

function hidelimit_notice($str) {
    global $_W;
	$hide = pdo_get('weliam_shiftcar_hidenotice', array('id' => $str),array('touser','address'));
    $m_send = $_W['wlsetting']['notice']['hidetpl'];
	$now = date("Y-m-d H:i:s",time());
	$touser = unserialize($hide['touser']);
	if(is_array($touser) && !empty($touser)){
		foreach ($touser as $key => $value) {
			$member = pdo_get('weliam_shiftcar_member', array('id' => $value),array('openid','plate1','plate2','plate_number'));
			$postdata = array(
		        "first" => array(
		            "value" => "您附近有交警贴罚单,请您注意！",
		            "color" => "#173177"
		        ) ,
		        "keyword1" => array(
		            'value' => '防贴条行动',
		            "color" => "#173177"
		        ) ,
		        "keyword2" => array(
		            'value' => $member['plate1'].$member['plate2'].$member['plate_number'],
		            "color" => "#173177"
		        ) ,
		        "keyword3" => array(
		            'value' => $now,
		            "color" => "#173177"
		        ) ,
		        "keyword4" => array(
		            "value" => $hide['address'],
		            "color" => "#173177"
		        ) ,
		        "remark" => array(
		            "value" => '附近，有交警贴罚单，请您尽快离开！',
		            "color" => "#173177"
		        )
		    );
			$url = '';
		    sendTplNotice($member['openid'], $m_send, $postdata, $url);
		}
	}
}

function forcar_notice($member,$str) {
    global $_W;
    $m_send = $_W['wlsetting']['notice']['hidetpl'];
	$now = date("Y-m-d H:i:s",time());
	$postdata = array(
        "first" => array(
            "value" => "您好，您收到一条车友互助提醒：",
            "color" => "#173177"
        ) ,
        "keyword1" => array(
            'value' => '车友互助提醒',
            "color" => "#173177"
        ) ,
        "keyword2" => array(
            'value' => $member['plate1'].$member['plate2'].$member['plate_number'],
            "color" => "#173177"
        ) ,
        "keyword3" => array(
            'value' => $now,
            "color" => "#173177"
        ) ,
        "keyword4" => array(
            "value" => '无',
            "color" => "#173177"
        ) ,
        "remark" => array(
            "value" => $str,
            "color" => "#173177"
        )
    );
	$url = '';
    sendTplNotice($member['openid'], $m_send, $postdata, $url);
}