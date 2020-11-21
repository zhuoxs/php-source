<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class ExchangeModel extends PluginModel
{
	public function getSet()
	{
		return parent::getSet();
	}

	public function sendMessage($coupon, $send_total, $member, $account = NULL)
	{
		global $_W;
		$articles = array();
		$title = str_replace('[nickname]', $member['nickname'], $coupon['resptitle']);
		$desc = str_replace('[nickname]', $member['nickname'], $coupon['respdesc']);
		$title = str_replace('[total]', $send_total, $title);
		$desc = str_replace('[total]', $send_total, $desc);
		$url = empty($coupon['respurl']) ? mobileUrl('sale/coupon/my', NULL, true) : $coupon['respurl'];

		if (!empty($coupon['resptitle'])) {
			$articles[] = array('title' => urlencode($title), 'description' => urlencode($desc), 'url' => $url, 'picurl' => tomedia($coupon['respthumb']));
		}

		if (!empty($articles)) {
			$resp = m('message')->sendNews($member['openid'], $articles, $account);

			if (is_error($resp)) {
				$msg = array(
					'keyword1' => array('value' => $title, 'color' => '#73a68d'),
					'keyword2' => array('value' => $desc, 'color' => '#73a68d')
					);
				$ret = m('message')->sendCustomNotice($member['openid'], $msg, $url, $account);

				if (is_error($ret)) {
					$info = pdo_fetch('SELECT coupon_templateid FROM ' . tablename('ewei_shop_exchange_setting') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $_W['uniacid']));
					$templateid = $info['coupon_templateid'];
					$msg = array(
						'first'    => array('value' => '亲爱的' . $member['nickname'] . '恭喜您获得优惠券', 'color' => '#ff0000'),
						'keyword1' => array('title' => '业务类型', 'value' => '优惠券通知', 'color' => '#000000'),
						'keyword2' => array('title' => '处理进度', 'value' => $coupon['resptitle'], 'color' => '#000000'),
						'keyword3' => array('title' => '处理内容', 'value' => $coupon['respdesc'], 'color' => '#4b9528'),
						'remark'   => array('value' => '点击查看详情', 'color' => '#000000')
						);

					if (!empty($templateid)) {
						m('message')->sendTplNotice($member['openid'], $templateid, $msg, $url);
					}
				}
			}
		}
	}

	public function sendExchangeMessage($openid, $num, $type = 0)
	{
		global $_W;
		global $_GPC;
		$time = date('Y-m-d H:i', time());
		$url = mobileUrl('member', NULL, 1);
		$member = m('member')->getMember($openid);
		$datas[] = array('name' => '兑换时间', 'value' => $time);
		$datas[] = array('name' => '兑换面值', 'value' => $num);
		$datas[] = array('name' => '粉丝昵称', 'value' => $member['nickname']);
		$datas[] = array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']);

		if ($type == 0) {
			$credittext = empty($_W['shopset']['trade']['credittext']) ? '积分' : $_W['shopset']['trade']['credittext'];
			$tag = 'exchange_score';
			$remark = '
感谢您的支持 <a href=\'' . $url . '\'>点击查看详情</a>';
			$text = '恭喜您' . $credittext . '兑换成功！
' . $credittext . '兑换：' . $num . '积分
兑换时间：' . $time . '
充值方式：积分兑换
' . $credittext . '余额：' . (int) $member['credit1'] . ($credittext . ' 
') . $remark;
			$message = array(
				'first'    => array('value' => '亲爱的' . $member['nickname'] . ('，恭喜您' . $credittext . '兑换成功，具体如下:'), 'color' => '#ff0000'),
				'keyword1' => array('title' => '获得时间', 'value' => $time, 'color' => '#000000'),
				'keyword2' => array('title' => '获得积分', 'value' => $num . $credittext, 'color' => '#000000'),
				'keyword3' => array('title' => '获得原因', 'value' => $credittext . '兑换', 'color' => '#000000'),
				'keyword4' => array('title' => '当前' . $credittext, 'value' => (double) $member['credit1'] . $credittext, 'color' => '#ff0000'),
				'remark'   => array('value' => '
' . $_W['shopset']['shop']['name'] . '感谢您的支持，如有疑问请联系在线客服。', 'color' => '#000000')
				);
		}
		else if ($type == 1) {
			$tag = 'exchange_balance';
			$remark = '
感谢您的支持 <a href=\'' . $url . '\'>点击查看详情</a>';
			$text = '恭喜您余额兑换成功！
余额兑换：' . $num . '元
兑换时间：' . $time . '
充值方式：余额兑换
当前余额：' . (int) $member['credit2'] . '元 
' . $remark;
			$message = array(
				'first'    => array('value' => '亲爱的' . $member['nickname'] . '，恭喜您余额兑换成功，具体如下:', 'color' => '#ff0000'),
				'keyword1' => array('title' => '充值金额', 'value' => $num . '元', 'color' => '#000000'),
				'keyword2' => array('title' => '充值时间', 'value' => $time, 'color' => '#000000'),
				'keyword3' => array('title' => '账户余额', 'value' => (double) $member['credit2'] . '元', 'color' => '#ff0000'),
				'remark'   => array('value' => '获得原因：余额兑换
' . $_W['shopset']['shop']['name'] . '感谢您的支持，如有疑问请联系在线客服。', 'color' => '#000000')
				);
		}
		else {
			$tag = 'exchange_recharge';
			$remark = '
感谢您的支持 <a href=\'' . $url . '\'>点击查看详情</a>';
			$text = '恭喜您充值成功！
余额充值：' . $num . '元
兑换时间：' . $time . '
充值方式：余额充值
当前余额：' . (int) $member['credit2'] . '元 
' . $remark;
			$message = array(
				'first'    => array('value' => '亲爱的' . $member['nickname'] . '，恭喜您余额充值成功，具体如下:', 'color' => '#ff0000'),
				'keyword1' => array('title' => '充值金额', 'value' => $num . '元', 'color' => '#000000'),
				'keyword2' => array('title' => '充值时间', 'value' => $time, 'color' => '#000000'),
				'keyword4' => array('title' => '账户余额', 'value' => (double) $member['credit2'] . '元', 'color' => '#ff0000'),
				'remark'   => array('value' => '充值方式：卡密充值
' . $_W['shopset']['shop']['name'] . '感谢您的支持，如有疑问请联系在线客服。', 'color' => '#000000')
				);
		}

		m('notice')->sendNotice(array('openid' => $openid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas));
	}

	public function sendRedpacket($key)
	{
		global $_W;
		$is_exchange = $this->is_exchange($key);

		if ($is_exchange[0] === '0') {
			m('message')->sendCustomNotice($_W['openid'], $is_exchange[1]);
			return false;
		}

		if ($is_exchange[1] != 'redpacket') {
			return false;
		}

		if (empty($is_exchange)) {
			return false;
		}

		$checkSubmit = $this->checkSubmit('exchange_key_' . $key);

		if (is_error($checkSubmit)) {
			m('message')->sendCustomNotice($_W['openid'], $checkSubmit['message']);
			return false;
		}

		$table1 = tablename('ewei_shop_exchange_group');
		$table2 = tablename('ewei_shop_exchange_code');
		$codeResult = pdo_fetch('SELECT *FROM ' . $table2 . ' WHERE uniacid = :uniacid AND `key`=:key ', array(':key' => $key, ':uniacid' => $_W['uniacid']));
		$groupResult = pdo_fetch('SELECT * FROM ' . $table1 . ' WHERE id = :id AND uniacid = :uniacid', array(':uniacid' => $_W['uniacid'], ':id' => $codeResult['groupid']));

		if ($groupResult['type'] == 1) {
			$red = $groupResult['red'];
		}
		else {
			$red = rand($groupResult['red_left'] * 100, $groupResult['red_right'] * 100) / 100;
		}

		$params = array('openid' => $_W['openid'], 'tid' => time(), 'send_name' => $groupResult['sendname'], 'money' => $red, 'wishing' => $groupResult['wishing'], 'act_name' => $groupResult['actname'], 'remark' => $groupResult['remark']);
		$result = m('common')->sendredpack($params);

		if (!is_error($result)) {
			pdo_update('ewei_shop_exchange_code', array('status' => 2), array('key' => $key, 'uniacid' => $_W['uniacid'], 'status' => 1));
			$info = m('member')->getInfo($_W['openid']);
			$record = array('key' => $key, 'uniacid' => $_W['uniacid'], 'red' => $red, 'time' => time(), 'openid' => $_W['openid'], 'nickname' => $info['nickname'], 'mode' => 3, 'title' => $groupResult['title'], 'groupid' => $groupResult['id'], 'serial' => $codeResult['serial']);
			pdo_insert('ewei_shop_exchange_record', $record);
			pdo_query('UPDATE ' . $table1 . ' SET `use` = `use` + 1 WHERE id = :id AND uniacid = :uniacid', array(':id' => $groupResult['id'], ':uniacid' => $_W['uniacid']));
			m('message')->sendCustomNotice($_W['openid'], '成功兑换了' . $red . '元红包');
			return true;
		}

		m('message')->sendCustomNotice($_W['openid'], $result['message']);
		return false;
	}

	private function is_exchange($key)
	{
		global $_W;
		$set = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exchange_setting') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		$counterror = $this->counterror($set);
		logg('1.txt', json_encode($counterror));

		if (is_error($counterror)) {
			m('message')->sendCustomNotice($_W['openid'], $counterror['message']);
			return false;
		}

		$time = strtotime('now');
		$time = date('Y-m-d');
		$time1 = $time . ' 00:00:00';
		$time2 = $time . ' 23:59:59';
		$time1 = strtotime($time1);
		$time2 = strtotime($time2);

		if (empty($_W['openid'])) {
			return false;
		}

		if (!empty($set['alllimit'])) {
			$exchangelimit = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exchange_record') . ' WHERE openid =:openid AND uniacid = :uniacid AND `time` > :timea AND `time` <= :timeb', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':timea' => $time1, ':timeb' => $time2));

			if ($set['alllimit'] <= intval($exchangelimit)) {
				m('message')->sendCustomNotice($_W['openid'], '今日口令已达上限');
				return false;
			}
		}

		if (!empty($set['grouplimit'])) {
			$exchangelimit2 = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exchange_record') . ' WHERE openid =:openid AND uniacid = :uniacid AND `time` > :timea AND `time` <= :timeb AND groupid = :groupid', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':timea' => $time1, ':timeb' => $time2, ':groupid' => $_SESSION['exchangeGroupId']));

			if ($set['grouplimit'] <= intval($exchangelimit2)) {
				m('message')->sendCustomNotice($_W['openid'], '今日口令已达上限');
				return false;
			}
		}

		$return = array();
		$table1 = tablename('ewei_shop_exchange_group');
		$table2 = tablename('ewei_shop_exchange_code');
		$codeResult = pdo_fetch('SELECT * FROM ' . $table2 . ' WHERE uniacid = :uniacid AND `key` = :key', array(':uniacid' => $_W['uniacid'], ':key' => $key));

		if ($codeResult === false) {
			$return = array('0', '兑换码不存在或已失效');
			pdo_query('UPDATE ' . tablename('ewei_shop_exchange_query') . ' SET `errorcount` = `errorcount` + 1 WHERE openid = :openid', array(':openid' => $_W['openid']));
			return $return;
		}

		pdo_query('UPDATE ' . tablename('ewei_shop_exchange_query') . ' SET `errorcount` = 0 AND `unfreeze`=0 WHERE openid = :openid', array(':openid' => $_W['openid']));

		if ($codeResult['status'] == 2) {
			$return = array('0', '兑换码已兑换');
			return $return;
		}

		if (strtotime($codeResult['endtime']) <= time()) {
			$return = array('0', '兑换码已过期');
			return $return;
		}

		$groupResult = pdo_fetch('SELECT * FROM ' . $table1 . ' WHERE id = :id AND uniacid = :uniacid', array(':uniacid' => $_W['uniacid'], ':id' => $codeResult['groupid']));
		if (!empty($codeResult['openid']) && $codeResult['openid'] != $_W['openid'] && !empty($groupResult['binding'])) {
			$return = array('0', '兑换码已绑定其他用户');
			return $return;
		}

		pdo_query('UPDATE ' . tablename('ewei_shop_exchange_code') . ' SET openid = :openid , `count` = `count` + 1 WHERE openid != :openid AND uniacid = :uniacid AND `key`=:key', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid'], ':key' => $key));

		if ($groupResult === false) {
			$return = array('0', '兑换活动不存在');
			return $return;
		}

		if (strtotime($groupResult['endtime']) <= time()) {
			$return = array('0', '兑换活动已结束');
			return $return;
		}

		if ($groupResult['status'] == 0) {
			$return = array('0', '兑换活动暂停中');
			return $return;
		}

		if (time() < strtotime($groupResult['starttime'])) {
			$return = array('0', '兑换活动未开始');
			return $return;
		}

		switch ($groupResult['mode']) {
		case '1':
			$method = 'goods';
			break;

		case 2:
			$method = 'balance';
			break;

		case 3:
			$method = 'redpacket';
			break;

		case 4:
			$method = 'score';
			break;

		case 5:
			$method = 'coupon';
			break;

		case 6:
			$method = 'group';
			break;
		}

		$return = array('1', $method, $groupResult['mode']);
		return $return;
	}

	public function checkSubmit($key, $time = 3, $message = '操作频繁，请稍后再试!')
	{
		global $_W;
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['setting']['site']['key'] . '_' . $_W['account']['key'] . '_' . $_W['uniacid'] . '_' . $_W['openid'] . '_mobilesubmit_' . $key;
			$redis = redis();

			if ($redis->setnx($redis_key, time())) {
				$redis->expireAt($redis_key, time() + $time);
			}
			else {
				return error(-1, $message);
			}
		}

		return true;
	}

	public function counterror($set)
	{
		global $_W;

		if ($set == false) {
			return true;
		}

		$query = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exchange_query') . ' WHERE openid = :openid AND uniacid = :uniacid', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($query)) {
			pdo_insert('ewei_shop_exchange_query', array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'querytime' => time()));
		}

		if ($query['querytime'] < strtotime(date('Y-m-d', time()) . ' 00:00:00')) {
			pdo_update('ewei_shop_exchange_query', array('errorcount' => 0, 'querytime' => time()));
		}

		if (time() < $query['unfreeze']) {
			return error(-1, '请' . ($query['unfreeze'] - time()) . '秒后再试');
		}

		if (!empty($set['mistake']) && $set['mistake'] <= $query['errorcount']) {
			pdo_update('ewei_shop_exchange_query', array('unfreeze' => time() + $set['freeze'] * 86400), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
			pdo_update('ewei_shop_exchange_query', array('errorcount' => 0, 'unfreeze' => time() + $set['freeze'] * 86400), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
			return error(-1, '错误次数太多,' . $set['freeze'] * 86400 . '秒后再试');
		}
	}

	public function createRule($koulingstart, $status, $id)
	{
		global $_W;
		$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:exchange:' . $id));
		$keyword = m('common')->keyExist($koulingstart);
		if (!empty($keyword) && $keyword['name'] != 'ewei_shopv2:exchange:' . $id) {
			show_json(0, '关键字已存在!');
		}
		else {
			if (!empty($rule)) {
				return pdo_update('rule_keyword', array('content' => $koulingstart, 'status' => $status), array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
			}

			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:exchange:' . $id, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => $status);
			pdo_insert('rule', $rule_data);
			$rid = pdo_insertid();
			$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => $koulingstart, 'type' => 1, 'displayorder' => 0, 'status' => $status);
			pdo_insert('rule_keyword', $keyword_data);
			return pdo_insertid();
		}
	}

	public function redKeyword($key)
	{
		global $_W;

		if (empty($key)) {
			return false;
		}

		$key = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exchange_group') . ' WHERE uniacid = :uniacid AND koulingstart = :koulingstart AND kouling = 1', array(':koulingstart' => $key, ':uniacid' => $_W['uniacid']));

		if (empty($key)) {
			return false;
		}

		return $key;
	}

	public function setRepeatCount($key)
	{
		global $_W;
		$sql = 'UPDATE ' . tablename('ewei_shop_exchange_code') . ' SET repeatcount = repeatcount - 1 WHERE repeatcount >1 AND uniacid = :uniacid AND `key` = :key';
		return pdo_query($sql, array(':uniacid' => $_W['uniacid'], ':key' => $key));
	}

	public function checkRepeatExchange($key, $group)
	{
		global $_W;
		$logsql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_exchange_record') . ' WHERE `key` = :code AND uniacid = :uniacid AND openid = :openid';
		$rowCount = pdo_fetchcolumn($logsql, array(':code' => $key, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		if (!empty($rowCount) && !empty($group['repeat']) && $rowCount == $group['repeat']) {
			show_json(0, '此兑换码已没有可用次数');
		}
	}

	public function noQrImg()
	{
		global $_W;
		$no_qrimg = pdo_fetchcolumn('select no_qrimg from ' . tablename('ewei_shop_exchange_setting') . ' where uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));

		if ($no_qrimg) {
			return true;
		}

		return false;
	}
}

?>
