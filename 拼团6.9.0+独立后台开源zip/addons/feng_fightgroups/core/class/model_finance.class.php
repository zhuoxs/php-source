<?php
	/** 
	* 类的介绍 
	*
	* @author         qidada<937991452@qq.com>
	* @since          1.0 
	*/ 
	class model_finance{
		
	public function downloadbill($starttime, $endtime, $type = 'ALL')
	{
		global $_W;
		global $_GPC;
		$dates = array();
		$startdate = date('Ymd', $starttime);
		$enddate = date('Ymd', $endtime);

		if ($startdate == $enddate) {
			$dates = array($startdate);
		}
		else {
			$days = (double) ($endtime - $starttime) / 86400;
			$d = 0;

			while ($d < $days) {
				$dates[] = date('Ymd', strtotime($startdate . '+' . $d . ' day'));
				++$d;
			}
		}

		if (empty($dates)) {
			show_message('对账单日期选择错误!', '', 'error');
		}

		$setting = uni_setting($_W['uniacid'], array('payment'));

		if (!is_array($setting['payment'])) {
			return error(1, '没有设定支付参数');
		}

		$wechat = $setting['payment']['wechat'];
		$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
		$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
		$content = '';

		foreach ($dates as $date) {
			$dc = self::downloadday($date, $row, $wechat, $type);
			if (is_error($dc) || strexists($dc, 'CDATA[FAIL]')) {
				continue;
			}

			$content .= $date . " 账单\r\n\r\n";
			$content .= $dc . "\r\n\r\n";
		}

		$content = "\xef\xbb\xbf" . $content;
		$file = time() . '.csv';
		header('Content-type: application/octet-stream ');
		header('Accept-Ranges: bytes ');
		header('Content-Disposition: attachment; filename=' . $file);
		header('Expires: 0 ');
		header('Content-Encoding: UTF8');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0 ');
		header('Pragma: public ');
		exit($content);
	}

	static function downloadday($date, $row, $wechat, $type)
	{
		$url = 'https://api.mch.weixin.qq.com/pay/downloadbill';
		$pars = array();
		$pars['appid'] = $row['key'];
		$pars['mch_id'] = $wechat['mchid'];
		$pars['nonce_str'] = random(8);
		$pars['device_info'] = 'ewei_shopv2';
		$pars['bill_date'] = $date;
		$pars['bill_type'] = $type;
		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		load()->func('communication');
		$resp = ihttp_request($url, $xml, $extras);

		if (strexists($resp['content'], 'No Bill Exist')) {
			return error(-2, '未搜索到任何账单');
		}

		if (is_error($resp)) {
			return error(-2, $resp['message']);
		}

		if (empty($resp['content'])) {
			return error(-2, '网络错误');
		}

		return $resp['content'];
	}
	}
