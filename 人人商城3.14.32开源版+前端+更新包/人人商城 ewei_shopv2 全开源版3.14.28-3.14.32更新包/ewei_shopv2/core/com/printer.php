<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Printer_EweiShopV2ComModel extends ComModel
{
	const PRINTRT_365 = 0;
	const PRINTRT_FEIE = 1;
	const PRINTRT_YILIANYUN = 2;
	const PRINTRT_365_S1 = 3;
	const PRINTRT_YILIANYUN_NEW = 4;
	const PRINTRT_FEIE_NEW = 5;
	const PRINTRT_YILIANYUN_AUTH2 = 6;
	const CONTENT_DEFAULT = 0;
	const CONTENT_BOLD = 1;
	const CONTENT_CENTER = 2;
	const CONTENT_CENTER_BOLD = 3;
	const CONTENT_CODE = 4;
	const CONTENT_QRCODE = 5;
	const CONTENT_BR = 6;

	public $type = 0;
	public $params = array();
	public $printer = array();
	public $template = array();
	public $verify = '';

	public function __construct()
	{
	}

	public function printer_list()
	{
		return array(self::PRINTRT_365_S1 => '365云打印(编号kdt1)', self::PRINTRT_365 => '365云打印(编号kdt2)', self::PRINTRT_YILIANYUN => '易联云K1、K2、K3', self::PRINTRT_YILIANYUN_NEW => '易联云K2S、K3S、K4、M1', self::PRINTRT_YILIANYUN_AUTH2 => '易联云auth2.0接口(支持K4及以上)', self::PRINTRT_FEIE => '飞鹅打印机', self::PRINTRT_FEIE_NEW => '飞鹅打印机(新接口)');
	}

	public function style_list()
	{
		return array(self::CONTENT_DEFAULT => '默认', self::CONTENT_BOLD => '加粗', self::CONTENT_CENTER => '居中');
	}

	public function style_list_code($str, $code = 0, $type = 0)
	{
		if ($type == '0' || $type == '1') {
			switch ($code) {
			case self::CONTENT_BOLD:
				$res = '<B>' . $str . '</B><BR>';
				break;

			case self::CONTENT_CENTER:
				$res = '<C>' . trim($str) . '</C>';
				break;

			case self::CONTENT_CENTER_BOLD:
				$res = '<CB>' . trim($str) . '</CB><BR>';
				break;

			case self::CONTENT_CODE:
				$res = '<CODE>' . $str . '<BR>';
				break;

			case self::CONTENT_QRCODE:
				$res = '<QR>' . $str . '</QR>';
				break;

			default:
				$res = $str . '<BR>';
				break;
			}
		}
		else if ($type == '2') {
			switch ($code) {
			case self::CONTENT_BOLD:
				$res = '@@2' . $str . '
';
				break;

			case self::CONTENT_CENTER:
				$res = '<center>' . trim($str) . '</center>';
				break;

			case self::CONTENT_CENTER_BOLD:
				$res = '<center>@@2' . trim($str) . '</center>
';
				break;

			case self::CONTENT_CODE:
				$res = '<b>' . $str . '</b>';
				break;

			case self::CONTENT_QRCODE:
				$res = '<q>' . $str . '</q>';
				break;

			default:
				$res = $str . '
';
				break;
			}
		}
		else if ($type == '3') {
			switch ($code) {
			case self::CONTENT_BOLD:
				$res = '^H2' . $str . '
';
				break;

			case self::CONTENT_CENTER_BOLD:
				$res = '^B2' . trim($str) . '
';
				break;

			case self::CONTENT_CODE:
				$qrlength = chr(strlen($str));
				$res = '^P' . $qrlength . $str . '
';
				break;

			case self::CONTENT_QRCODE:
				$qrlength = chr(strlen($str));
				$res = '^Q' . $qrlength . $str . '
';
				break;

			default:
				$res = $str . '
';
				break;
			}
		}
		else if ($type == '4') {
			switch ($code) {
			case self::CONTENT_BOLD:
				$res = '<FB>' . $str . '</FB>
';
				break;

			case self::CONTENT_CENTER:
				$res = '<center>' . trim($str) . '</center>';
				break;

			case self::CONTENT_CENTER_BOLD:
				$res = '<FB><center>' . trim($str) . '</center></FB>
';
				break;

			case self::CONTENT_CODE:
				$res = '<BR>' . $str . '</BR>';
				break;

			case self::CONTENT_QRCODE:
				$res = '<QR>' . $str . '</QR>';
				break;

			default:
				$res = $str . '
';
				break;
			}
		}
		else {
			if ($type == '6') {
				switch ($code) {
				case self::CONTENT_BOLD:
					$res = '<FB>' . $str . '</FB>
';
					break;

				case self::CONTENT_CENTER:
					$res = '<center>' . trim($str) . '</center>';
					break;

				case self::CONTENT_CENTER_BOLD:
					$res = '<FB><center>' . trim($str) . '</center></FB>
';
					break;

				case self::CONTENT_CODE:
					$res = '<BR>' . $str . '</BR>';
					break;

				case self::CONTENT_QRCODE:
					$res = '<QR>' . $str . '</QR>';
					break;

				default:
					$res = $str . '
';
					break;
				}
			}
		}

		return $res;
	}

	/**
     * @param $params 替换变量
     * @param $templateid 打印模板id
     * @param $printerid 打印机ID
     * @param $type 打印类型 0是订单,1是收银台
     * @return array|bool|void
     */
	public function printer($params, $templateid, $printerid, $type = 0)
	{
		global $_W;
		$this->type = $type;
		$printer = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_printer') . ' WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $printerid));

		if (empty($printer)) {
			return error(-1, '小票打印机未找到');
		}

		$template = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_printer_template') . ' WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $templateid));

		if (empty($printer)) {
			return error(-1, '打印模板未找到');
		}

		$print_data = json_decode($template['print_data'], true);

		if (!empty($print_data)) {
			foreach ($print_data as $key => &$value) {
				if ($key == 'key' && !empty($print_data['key'])) {
					$data = array();
					$data_value = array();

					foreach ($print_data['key'] as $ke => $val) {
						if (strexists($val, '|')) {
							foreach ($params['data'] as $v) {
								$v['paytype'] = $params['paytype'];
								$data[] = $this->replace($v, $val);
								$data_value[] = $print_data['value'][$ke];

								if (!empty($v['optiontitle'])) {
									$data[] = '规格 : ' . $v['optiontitle'];
									$data_value[] = $print_data['value'][$ke];
								}

								if ($template['goodssn'] == 1 && !empty($v['goodssn'])) {
									$data[] = '编码：' . $v['goodssn'];
									$data_value[] = $print_data['value'][$ke];
								}

								if ($template['productsn'] == 1 && !empty($v['productsn'])) {
									$data[] = '条码：' . $v['productsn'];
									$data_value[] = $print_data['value'][$ke];
								}
							}
						}
						else {
							if ($type == 0 && strexists($val, '[商品价格详情]')) {
								if (!empty($params['goodsprice'])) {
									$data[] = '商品小计：￥' . $params['goodsprice'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['dispatchprice'])) {
									$data[] = '运费：￥' . $params['dispatchprice'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['discountprice'])) {
									$data[] = '会员折扣：￥-' . $params['discountprice'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['deductprice'])) {
									$data[] = '积分抵扣：￥-' . $params['deductprice'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['deductcredit2'])) {
									$data[] = '余额抵扣：￥-' . $params['deductcredit2'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['deductenough'])) {
									$data[] = '商城满额立减：￥-' . $params['deductenough'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['merchdeductenough'])) {
									$data[] = '商户满额立减：￥-' . $params['merchdeductenough'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['couponprice'])) {
									$data[] = '优惠券优惠：￥-' . $params['couponprice'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['isdiscountprice'])) {
									$data[] = '促销优惠：￥-' . $params['isdiscountprice'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['changeprice'])) {
									$data[] = '卖家改价：￥' . $params['changeprice'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['changedispatchprice'])) {
									$data[] = '卖家改运费：￥' . $params['changedispatchprice'];
									$data_value[] = $print_data['value'][$ke];
								}

								if (!empty($params['price'])) {
									$data[] = '实际收款：￥' . $params['price'];
									$data_value[] = $print_data['value'][$ke];
								}
							}
							else {
								$data[] = $this->replace($params, $val);
								$data_value[] = $print_data['value'][$ke];
							}
						}
					}

					$print_data['value'] = $data_value;

					foreach ($data as &$vvv) {
						$len = strpos($vvv, '￥');

						if ($len !== false) {
							$start = substr($vvv, 0, $len);
							$end = strrchr($vvv, '￥');
							$e = is_utf8($end) ? iconv('utf-8', 'gb2312', $end) : $end;
							$end_len = strlen($e);
							$start_len = 32 - $end_len;
							$vvv = $this->setSpacing($start, $start_len) . $this->setSpacing($end, $end_len);
						}
					}

					unset($vvv);
					$value = $data;

					if (!empty($this->verify)) {
						$value[] = $this->verify;
					}
				}
				else {
					$value = $this->replace($params, $value);
				}
			}

			unset($value);
			$template['print_data'] = $print_data;
			$template['qrcode'] = $this->replace($params, $template['qrcode']);
		}

		$this->printer = $printer;
		$this->template = $template;
		$this->params = $params;
		load()->func('communication');

		switch ($printer['type']) {
		case self::PRINTRT_FEIE:
			$res = $this->printerFeie();
			break;

		case self::PRINTRT_YILIANYUN:
			$res = $this->printerYilianyun();
			break;

		case self::PRINTRT_YILIANYUN_NEW:
			$res = $this->printerYilianyunNew();
			break;

		case self::PRINTRT_YILIANYUN_AUTH2:
			$res = $this->printerYilianyunAuth2($printer['merchid']);
			break;

		case self::PRINTRT_365_S1:
			$res = $this->printer365s1();
			break;

		case self::PRINTRT_FEIE_NEW:
			$res = $this->printerFeieNew();
			break;

		default:
			$res = $this->printer365();
			break;
		}

		return $res;
	}

	/**
     * @param $template 模板
     * @param int $type 打印机类型
     * @return bool
     */
	public function buildContent($template, $type = 0)
	{
		$str = !empty($template['print_title']) ? $this->style_list_code($template['print_title'], self::CONTENT_CENTER_BOLD, $type) : '';
		$print_style_array = explode('|', $template['print_style']);
		$array_len = array();
		$temp = '';

		foreach ($print_style_array as $key => $val) {
			$val_array = explode(':', $val);

			if (1 < count($val_array)) {
				$array_len[] = $val_array[1];
				$temp .= $this->setSpacing($val_array[0], $val_array[1]);
			}
		}

		$print_data = $template['print_data'];
		$keys = isset($print_data['key']) ? $print_data['key'] : array();
		$values = isset($print_data['value']) ? $print_data['value'] : array();
		$for = 0;

		foreach ($keys as $key => $val) {
			if (strexists($val, '|')) {
				if ($for == 0) {
					$str .= $this->style_list_code($temp, 0, $type);
					$for = 1;
				}

				$val_array = explode('|', $val);
				$temp1 = '';

				foreach ($val_array as $k => $v) {
					$temp1 .= $this->setSpacing($v, $array_len[$k]);
				}

				$str .= $this->style_list_code($temp1, $values[$key], $type);
				continue;
			}

			$str .= $this->style_list_code($this->setSpacing($val), $values[$key], $type);
		}

		$str .= !empty($template['code']) ? $this->style_list_code($template['code'], self::CONTENT_CODE, $type) : '';
		$str .= !empty($template['qrcode']) ? $this->style_list_code($template['qrcode'], self::CONTENT_QRCODE, $type) : '';
		return $str;
	}

	public function setSpacing($str, $length = 32)
	{
		$str_old = $str;
		$str = is_utf8($str) ? iconv('utf-8', 'GBK//IGNORE', $str) : $str;
		$num = strlen($str);

		if ($length < $num) {
			if (32 < $num && $length == 32) {
				$temp = '';
				$count = ceil($num / $length);
				$i = 0;

				while ($i <= $count) {
					$temp .= mb_substr($str_old, $i * $length, $length);
					++$i;
				}

				return $temp;
			}

			$str_old = str_replace(' ', '  ', $str_old);
			return $this->cut_str($str_old, floor($length / 2)) . str_repeat(' ', $length % 2);
		}

		return $str_old . str_repeat(' ', $length - $num);
	}

	public function cut_str($sourcestr, $cutlength)
	{
		$returnstr = '';
		$i = 0;
		$n = 0;
		$str_length = strlen($sourcestr);

		while ($n < $cutlength && $i <= $str_length) {
			$temp_str = substr($sourcestr, $i, 1);
			$ascnum = Ord($temp_str);

			if (224 <= $ascnum) {
				$returnstr = $returnstr . substr($sourcestr, $i, 3);
				$i = $i + 3;
				++$n;
			}
			else if (192 <= $ascnum) {
				$returnstr = $returnstr . substr($sourcestr, $i, 2);
				$i = $i + 2;
				++$n;
			}
			else {
				if (65 <= $ascnum && $ascnum <= 90) {
					$returnstr = $returnstr . substr($sourcestr, $i, 1);
					$i = $i + 1;
					++$n;
				}
				else {
					$returnstr = $returnstr . substr($sourcestr, $i, 1);
					$i = $i + 1;
					$n = $n + 0.5;
				}
			}
		}

		return $returnstr;
	}

	public function printer365()
	{
		$print = json_decode($this->printer['print_data'], true);

		if (empty($print['printer_365'])) {
			return error(-1, '小票打印机配置不正确');
		}

		$content = $this->buildContent($this->template, self::PRINTRT_365);
		$selfMessage = array('deviceNo' => $print['printer_365']['deviceNo'], 'printContent' => $content, 'key' => $print['printer_365']['key'], 'times' => empty($print['printer_365']['times']) ? 1 : $print['printer_365']['times']);
		$res = ihttp_post($print['printer_365']['url'], $selfMessage);
		return $res['content'];
	}

	public function printerFeie()
	{
		$print = json_decode($this->printer['print_data'], true);

		if (empty($print['printer_feie'])) {
			return error(-1, '小票打印机配置不正确');
		}

		$content = $this->buildContent($this->template, self::PRINTRT_FEIE);
		$selfMessage = array('sn' => $print['printer_feie']['deviceNo'], 'printContent' => $content, 'key' => $print['printer_feie']['key'], 'times' => $print['printer_feie']['times']);
		$res = ihttp_post($print['printer_feie']['url'], $selfMessage);
		return $res['content'];
	}

	/**
     * 新版飞蛾打印机接口
     * @return array
     */
	public function printerFeieNew()
	{
		$print = json_decode($this->printer['print_data'], true);

		if (empty($print['printer_feie_new'])) {
			return error(-1, '小票打印机配置不正确');
		}

		$content = $this->buildContent($this->template, self::PRINTRT_FEIE);
		$selfMessage = array('user' => $print['printer_feie_new']['user'], 'stime' => time(), 'apiname' => 'Open_printMsg', 'debug' => 1, 'sn' => $print['printer_feie_new']['sn'], 'content' => $content, 'times' => $print['printer_feie_new']['times']);
		$sig = sha1($selfMessage['user'] . $print['printer_feie_new']['ukey'] . $selfMessage['stime']);
		$selfMessage['sig'] = $sig;
		$res = ihttp_post('http://api.feieyun.cn/Api/Open/', $selfMessage);
		return $res['content'];
	}

	public function printerYilianyun()
	{
		$print = json_decode($this->printer['print_data'], true);

		if (empty($print['printer_yilianyun'])) {
			return error(-1, '小票打印机配置不正确');
		}

		$content = $this->buildContent($this->template, self::PRINTRT_YILIANYUN);
		$selfMessage = array('partner' => $print['printer_yilianyun']['partner'], 'machine_code' => $print['printer_yilianyun']['machine_code'], 'time' => time());
		$selfMessage['sign'] = $this->generateSign($selfMessage, $print['printer_yilianyun']['apikey'], $print['printer_yilianyun']['msign']);
		$selfMessage['content'] = (empty($print['printer_yilianyun']['times']) ? '' : '**' . $print['printer_yilianyun']['times']) . $content;
		$res = ihttp_post($print['printer_yilianyun']['url'], $selfMessage);
		return $res['content'];
	}

	public function printerYilianyunNew()
	{
		$print = json_decode($this->printer['print_data'], true);

		if (empty($print['printer_yilianyun_new'])) {
			return error(-1, '小票打印机配置不正确');
		}

		$content = $this->buildContent($this->template, self::PRINTRT_YILIANYUN_NEW);
		$selfMessage = array('partner' => $print['printer_yilianyun_new']['partner'], 'machine_code' => $print['printer_yilianyun_new']['machine_code'], 'time' => time());
		$selfMessage['sign'] = $this->generateSign($selfMessage, $print['printer_yilianyun_new']['apikey'], $print['printer_yilianyun_new']['msign']);
		$selfMessage['content'] = (empty($print['printer_yilianyun_new']['times']) ? '' : '<MN>' . $print['printer_yilianyun_new']['times'] . '</MN>') . $content;
		$res = ihttp_post($print['printer_yilianyun_new']['url'], $selfMessage);
		return $res['content'];
	}

	public function printer365s1()
	{
		$print = json_decode($this->printer['print_data'], true);

		if (empty($print['printer_365_s1'])) {
			return error(-1, '小票打印机配置不正确');
		}

		$content = $this->buildContent($this->template, self::PRINTRT_365_S1);
		$selfMessage = array('deviceNo' => $print['printer_365_s1']['deviceNo'], 'printContent' => $content, 'key' => $print['printer_365_s1']['key'], 'times' => empty($print['printer_365_s1']['times']) ? 1 : $print['printer_365_s1']['times']);
		$selfMessage['printContent'] = (empty($print['printer_365_s1']['times']) ? '^N1^F1
' : '^N' . $print['printer_365_s1']['times'] . '^F1
') . $content;
		$res = ihttp_post($print['printer_365_s1']['url'], $selfMessage);
		return $res['content'];
	}

	/**
     * 生成签名sign
     * @param  array $params 参数
     * @param  string $apiKey API密钥
     * @param  string $msign 打印机密钥
     * @return   string sign
     */
	public function generateSign($params, $apiKey, $msign)
	{
		ksort($params);
		$stringToBeSigned = $apiKey;

		foreach ($params as $k => $v) {
			$stringToBeSigned .= urldecode($k . $v);
		}

		unset($k);
		unset($v);
		$stringToBeSigned .= $msign;
		return strtoupper(md5($stringToBeSigned));
	}

	public function getStr($param)
	{
		$str = '';

		foreach ($param as $key => $value) {
			$str = $str . $key . '=' . $value . '&';
		}

		$str = rtrim($str, '&');
		return $str;
	}

	protected function replace($params = array(), $template = '')
	{
		if (empty($params) || empty($template)) {
			return $template;
		}

		switch ($this->type) {
		case 1:
			$datas = array('[收银台名称]' => isset($params['title']) ? $params['title'] : '', '[收银金额]' => isset($params['price']) ? $params['price'] : '', '[收银时间]' => isset($params['paytime']) ? $params['paytime'] : '', '[支付类型]' => isset($params['paytype']) ? $params['paytype'] : '', '[订单编号]' => isset($params['logno']) ? $params['logno'] : '', '[随机减金额]' => isset($params['randommoney']) ? $params['randommoney'] : 0, '[满立减金额]' => isset($params['enough']) ? $params['enough'] : 0, '[余额抵扣金额]' => isset($params['deduction']) ? $params['deduction'] : 0, '[操作员]' => isset($params['operator']) ? $params['operator'] : '管理员', '[商品名称]' => isset($params['goodstitle']) ? $params['goodstitle'] : '', '[商品价格]' => isset($params['goodsprice']) ? $params['goodsprice'] : '', '[商品数量]' => isset($params['goodstotal']) ? $params['goodstotal'] : '', '[单商品合计]' => isset($params['goodstotalprice']) ? $params['goodstotalprice'] : '');
			break;

		default:
			$datas = array('[商品名称]' => isset($params['shorttitle']) ? $params['shorttitle'] : '', '[商品价格]' => isset($params['goodsprice']) ? $params['goodsprice'] : '', '[商品数量]' => isset($params['goodstotal']) ? $params['goodstotal'] : '', '[单商品合计]' => isset($params['goodstotalprice']) ? $params['goodstotalprice'] : '', '[商品规格]' => isset($params['optiontitle']) ? $params['optiontitle'] : '', '[订单编号]' => isset($params['ordersn']) ? $params['ordersn'] : '', '[订单金额]' => isset($params['price']) ? $params['price'] : '', '[优惠金额]' => isset($params['discount']) ? $params['discount'] : '', '[收货人]' => isset($params['realname']) ? $params['realname'] : '', '[收货地址]' => isset($params['address']) ? $params['address'] : '', '[收货电话]' => isset($params['mobile']) ? $params['mobile'] : '', '[备注]' => isset($params['remark']) ? $params['remark'] : '', '[运费]' => isset($params['dispatchprice']) ? $params['dispatchprice'] : '', '[订单时间标题]' => isset($params['order_time_title']) ? $params['order_time_title'] : '', '[订单时间]' => isset($params['order_time']) ? $params['order_time'] : '', '[订单状态]' => isset($params['order_status']) ? $params['order_status'] : '', '[门店名称]' => isset($params['storename']) ? $params['storename'] : '', '[门店地址]' => isset($params['storeaddress']) ? $params['storeaddress'] : '', '[门店联系方式]' => isset($params['storemobile']) ? $params['storemobile'] : '', '[门店联系人]' => isset($params['storerealname']) ? $params['storerealname'] : '', '[付款地址]' => isset($params['id']) ? $this->getUrl('order/pay', array('id' => $params['id'])) : '', '[付款类型]' => isset($params['paytype']) ? $params['paytype'] : '', '[订单详情地址]' => isset($params['id']) ? $this->getUrl('order/detail', array('id' => $params['id'])) : '');
			break;
		}

		$template = $this->replaceArray($datas, $template);
		return $template;
	}

	protected function replaceArray(array $array, $message)
	{
		foreach ($array as $key => $value) {
			$message = str_replace($key, $value, $message);
		}

		return $message;
	}

	public function getPrinterSet($merchid = 0)
	{
		global $_W;

		if (!empty($merchid)) {
			$data = p('merch')->getSet('printer', $merchid);
		}
		else {
			$data = m('common')->getSysset('printer');
		}

		if (!empty($data['order_printer'])) {
			$data['order_printer'] = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_printer') . ' WHERE uniacid=:uniacid AND id IN (' . $data['order_printer'] . ')', array(':uniacid' => $_W['uniacid']));
		}
		else {
			$data['order_printer'] = array();
		}

		$data['ordertype'] = !empty($data['ordertype']) ? explode(',', $data['ordertype']) : array();
		return $data;
	}

	public function getStorePrinterSet($store)
	{
		global $_W;

		if (!empty($store['order_printer'])) {
			$store['order_printer'] = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_printer') . ' WHERE uniacid=:uniacid AND id IN (' . $store['order_printer'] . ')', array(':uniacid' => $_W['uniacid']));
		}
		else {
			$store['order_printer'] = array();
		}

		$store['ordertype'] = !empty($store['ordertype']) ? explode(',', $store['ordertype']) : array();
		return $store;
	}

	public function sendRechargeMessage($params)
	{
		global $_W;
		$PrinterSet = $this->getPrinterSet();
		$res = array();

		if (!empty($PrinterSet['printer_recharge'])) {
			foreach ($PrinterSet['order_printer'] as $value) {
				$res[] = $this->printRechargeMessage($params, $value['id']);
			}
		}

		return $res;
	}

	public function printRechargeMessage($params, $printerid)
	{
		global $_W;
		$printer = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_printer') . ' WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $printerid));

		if (empty($printer)) {
			return error(-1, '小票打印机未找到');
		}

		$this->template = array(
			'print_title' => '会员充值',
			'print_style' => ':10|:22',
			'print_data'  => array(
				'key'   => array('会员昵称：|' . $params['nickname'], '充值金额：|￥' . $params['price'], '支付方式：|' . $params['paytype'], '充值时间：|' . $params['paytime']),
				'value' => array('0', '0', '0')
			)
		);
		$this->printer = $printer;
		load()->func('communication');

		switch ($printer['type']) {
		case self::PRINTRT_FEIE:
			$res = $this->printerFeie();
			break;

		case self::PRINTRT_YILIANYUN:
			$res = $this->printerYilianyun();
			break;

		case self::PRINTRT_YILIANYUN_NEW:
			$res = $this->printerYilianyunNew();
			break;

		case self::PRINTRT_YILIANYUN_AUTH2:
			$res = $this->printerYilianyunAuth2($printer['merchid']);
			break;

		case self::PRINTRT_365_S1:
			$res = $this->printer365s1();
			break;

		case self::PRINTRT_FEIE_NEW:
			$res = $this->printerFeieNew();
			break;

		default:
			$res = $this->printer365();
			break;
		}

		return $res;
	}

	/**
     * 打印订单
     * @param int $orderid
     */
	public function sendOrderMessage($orderid = 0, $verify = array())
	{
		global $_W;

		if ($orderid == 0) {
			return NULL;
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));

		if (empty($order)) {
			return NULL;
		}

		$status = 0;
		$order_status = '';
		$order_time = '';
		$order_time_title = '';

		if ($order['status'] == '0') {
			$status = 1;
			$order_status = '未支付';
			$order_time = date('Y-m-d H:i', $order['createtime']);
			$order_time_title = '下单时间';
		}
		else if ($order['status'] == '1') {
			$status = 2;
			$order_status = '已支付';
			$order_time = date('Y-m-d H:i', $order['paytime']);
			$order_time_title = '支付时间';
		}
		else if ($order['status'] == '2') {
			$status = 2;
			$order_status = '已支付';
			$order_time = date('Y-m-d H:i', $order['paytime']);
			$order_time_title = '支付时间';
		}
		else {
			if ($order['status'] == '3') {
				$status = 3;
				$order_status = '已完成';
				$order_time = date('Y-m-d H:i', $order['finishtime']);
				$order_time_title = '收货时间';
			}
		}

		if ($status == 3 && !empty($order['virtual']) && com('virtual')) {
			$status = 2;
		}

		if ($status == 1 && $order['paytype'] == 3) {
			$status = 2;
		}

		$param = array(':uniacid' => $_W['uniacid']);

		if ($order['isparent'] == 1) {
			$scondition = ' og.parentorderid=:parentorderid';
			$param[':parentorderid'] = $orderid;
		}
		else {
			$scondition = ' og.orderid=:orderid';
			$param[':orderid'] = $orderid;
		}

		$order_goods = pdo_fetchall('select g.id,g.title,g.shorttitle,og.realprice,og.total,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.goodssn,og.productsn from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and' . $scondition, $param);
		$goods = array();
		$replace_str = array('\'', '"', '#', '&', '+', ' ');

		foreach ($order_goods as $og) {
			$shorttitle = empty($og['shorttitle']) ? $og['title'] : $og['shorttitle'];
			$print_title = str_replace($replace_str, '', trim($shorttitle));
			$goods[] = array('shorttitle' => $print_title, 'goodsprice' => (double) $og['price'] / (int) $og['total'], 'goodstotal' => (int) $og['total'], 'goodssn' => (string) $og['goodssn'], 'productsn' => (string) $og['productsn'], 'goodstotalprice' => (double) $og['price'], 'optiontitle' => $og['optiontitle']);
		}

		$store = false;

		if (!empty($order['storeid'])) {
			if (0 < $order['merchid']) {
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_merch_store') . ' where id=:id and uniacid=:uniacid and merchid = :merchid limit 1', array(':id' => $order['storeid'], ':uniacid' => $_W['uniacid'], ':merchid' => $order['merchid']));
			}
			else {
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $order['storeid'], ':uniacid' => $_W['uniacid']));
				$StorePrinterSet = $this->getStorePrinterSet($store);
			}
		}

		$buyerinfo = '';
		$buyerinfo_name = '';
		$buyerinfo_mobile = '';
		$addressinfo = '';

		if (!empty($order['address'])) {
			$address = iunserializer($order['address_send']);
			if (is_array($address) && empty($address) || !is_array($address)) {
				$address = iunserializer($order['address']);

				if (!is_array($address)) {
					$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $order['addressid'], ':uniacid' => $_W['uniacid']));
				}
			}

			if (!empty($address)) {
				$addressinfo = $address['province'] . $address['city'] . $address['area'] . (isset($address['street']) ? $address['street'] : '') . ' ' . $address['address'];
				$buyerinfo = '收件人: ' . $address['realname'] . '
联系电话: ' . $address['mobile'] . '
收货地址: ' . $addressinfo;
				$buyerinfo_name = $address['realname'];
				$buyerinfo_mobile = $address['mobile'];
			}
		}
		else {
			$carrier = iunserializer($order['carrier']);

			if (is_array($carrier)) {
				$buyerinfo = '联系人: ' . $carrier['carrier_realname'] . '
联系电话: ' . $carrier['carrier_mobile'];
				$buyerinfo_name = $carrier['carrier_realname'];
				$buyerinfo_mobile = $carrier['carrier_mobile'];
			}
		}

		if ($order['isverify'] && $order['verifystoreid'] && !empty($verify)) {
			if ($verify['type'] == 0) {
				$this->verify = '核销完成!';
			}
			else if ($verify['type'] == 1) {
				$this->verify = '核销了 : ' . $verify['times'] . '次还剩' . $verify['lastverifys'] . '次';
			}
			else {
				if ($verify['type'] == 2) {
					$this->verify = '当前使用核销码: ' . $verify['verifycode'] . ';还剩' . $verify['lastverifys'] . '次';
				}
			}
		}

		if (!empty($order['verifystoreid'])) {
			$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $order['verifystoreid'], ':uniacid' => $_W['uniacid']));
			$StorePrinterSet = $this->getStorePrinterSet($store);
		}

		switch ($order['paytype']) {
		case 1:
			$paytype = '余额支付';
			break;

		case 11:
			$paytype = '后台付款';
			break;

		case 21:
			$paytype = '微信支付';
			break;

		case 22:
			$paytype = '支付宝支付';
			break;

		case 23:
			$paytype = '银联支付';
			break;

		case 3:
			$paytype = '货到付款';
			break;
		}

		if (0 < $order['changedispatchprice']) {
			$order['dispatchprice'] = $order['changedispatchprice'];
		}

		$params = array('id' => $order['id'], 'goodsprice' => (double) $order['goodsprice'], 'dispatchprice' => (double) $order['dispatchprice'], 'discountprice' => (double) $order['discountprice'], 'deductprice' => (double) $order['deductprice'], 'deductcredit2' => (double) $order['deductcredit2'], 'deductenough' => (double) $order['deductenough'], 'merchdeductenough' => (double) $order['merchdeductenough'], 'couponprice' => (double) $order['couponprice'], 'isdiscountprice' => (double) $order['isdiscountprice'], 'changeprice' => (double) $order['changeprice'], 'changedispatchprice' => (double) $order['changedispatchprice'], 'price' => (double) $order['price'], 'data' => $goods, 'discount' => (double) $order['goodsprice'] - $order['price'] + (double) $order['dispatchprice'], 'ordersn' => $order['ordersn'], 'remark' => $order['remark'], 'address' => $addressinfo, 'realname' => $buyerinfo_name, 'mobile' => $buyerinfo_mobile, 'expresscom' => $order['expresscom'], 'expresssn' => $order['expresssn'], 'createtime' => date('Y-m-d H:i', $order['createtime']), 'paytime' => date('Y-m-d H:i', $order['paytime']), 'paytype' => $paytype, 'sendtime' => date('Y-m-d H:i', $order['sendtime']), 'finishtime' => date('Y-m-d H:i', $order['finishtime']), 'storename' => !empty($store) ? $store['storename'] : '', 'storeaddress' => !empty($store) ? $store['address'] : '', 'storemobile' => !empty($store) ? $store['mobile'] : '', 'storerealname' => !empty($store) ? $store['realname'] : '', 'order_time_title' => $order_time_title, 'order_time' => $order_time, 'order_status' => $order_status);
		$PrinterSet = $this->getPrinterSet();
		$res = array();
		if (!empty($PrinterSet['printer_merch']) || empty($PrinterSet['printer_merch']) && $order['merchid'] == 0) {
			if (!empty($PrinterSet['ordertype']) && !empty($PrinterSet['order_printer'])) {
				if (in_array($status, $PrinterSet['ordertype'])) {
					foreach ($PrinterSet['order_printer'] as $value) {
						$res[] = $this->printer($params, $PrinterSet['order_template'], $value['id'], 0);
					}
				}
			}
		}

		if (0 < $order['merchid']) {
			$PrinterSet = $this->getPrinterSet($order['merchid']);
			if (!empty($PrinterSet['ordertype']) && !empty($PrinterSet['order_printer'])) {
				if (in_array($status, $PrinterSet['ordertype'])) {
					foreach ($PrinterSet['order_printer'] as $value) {
						$res[] = $this->printer($params, $PrinterSet['order_template'], $value['id'], 0);
					}
				}
			}
		}

		if (isset($StorePrinterSet)) {
			if (!empty($StorePrinterSet['ordertype']) && !empty($StorePrinterSet['order_printer'])) {
				if (in_array($status, $StorePrinterSet['ordertype'])) {
					foreach ($StorePrinterSet['order_printer'] as $value) {
						$res[] = $this->printer($params, $StorePrinterSet['order_template'], $value['id'], 0);
					}
				}
			}
		}

		return $res;
	}

	public function sendCashierMessage($log, $templateid, $printerid, $operator)
	{
		$params = array('title' => $log['title'], 'price' => $log['money'], 'paytime' => date('Y-m-d H:i:s'), 'paytype' => CashierModel::$paytype[$log['paytype']], 'logno' => $log['logno'], 'randommoney' => $log['randommoney'], 'enough' => $log['enough'], 'deduction' => $log['deduction'], 'operator' => '管理员');

		if ($operator) {
			$params['operator'] = $operator['title'];
		}

		$goods = array();

		if (!empty($log['isgoods'])) {
			$goodsAll = pdo_fetchall('SELECT g.title,g.goodssn,og.price,og.total FROM ' . tablename('ewei_shop_cashier_goods') . ' g LEFT JOIN ' . tablename('ewei_shop_cashier_pay_log_goods') . ' og ON g.id=og.goodsid WHERE og.cashierid=:cashierid AND og.logid=:logid', array(':cashierid' => $log['cashierid'], ':logid' => $log['id']));

			foreach ($goodsAll as $og) {
				$goods[] = array('goodstitle' => $og['title'], 'goodsprice' => (double) $og['price'] / (int) $og['total'], 'goodstotal' => (int) $og['total'], 'goodstotalprice' => (double) $og['price'], 'optiontitle' => '');
			}
		}

		if (!empty($log['orderid'])) {
			$order_goods = pdo_fetchall('select g.id,g.title,g.shorttitle,og.realprice,og.total,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $log['uniacid'], ':orderid' => $log['orderid']));

			foreach ($order_goods as $og) {
				$goods[] = array('goodstitle' => empty($og['shorttitle']) ? $og['title'] : $og['shorttitle'], 'goodsprice' => (double) $og['price'] / (int) $og['total'], 'goodstotal' => (int) $og['total'], 'goodstotalprice' => (double) $og['price'], 'optiontitle' => $og['optiontitle']);
			}
		}

		$printer = explode(',', $printerid);
		$params['data'] = $goods;
		if (!empty($printer) && !empty($templateid)) {
			foreach ($printer as $value) {
				$this->printer($params, $templateid, $value, 1);
			}
		}

		return true;
	}

	public function sendCashier($log, $templateid, $printerid, $operator)
	{
		$params = array('title' => $log['title'], 'price' => $log['money'], 'paytime' => date('Y-m-d H:i:s'), 'paytype' => CashierModel::$paytype[$log['paytype']], 'logno' => $log['logno'], 'randommoney' => $log['randommoney'], 'enough' => $log['enough'], 'deduction' => $log['deduction'], 'operator' => '管理员');

		if ($operator) {
			$params['operator'] = $operator['title'];
		}

		$printer = explode(',', $printerid);
		$params['data'] = array($params);
		if (!empty($printer) && !empty($templateid)) {
			foreach ($printer as $value) {
				$this->printer($params, $templateid, $value, 1);
			}
		}

		return true;
	}

	/**
     * 生成手机端付款地址
     * @param $do
     * @param null $query
     * @return mixed|string
     */
	public function getUrl($do, $query = NULL)
	{
		$url = mobileUrl($do, $query, true);

		if (strexists($url, '/addons/ewei_shopv2/')) {
			$url = str_replace('/addons/ewei_shopv2/', '/', $url);
		}

		if (strexists($url, '/core/mobile/order/')) {
			$url = str_replace('/core/mobile/order/', '/', $url);
		}

		if (strexists($url, '/core/task/order/')) {
			$url = str_replace('/core/task/order/', '/', $url);
		}

		return $url;
	}

	/**
     * 易联云 auth2.0新接口获取token
     * @param $client_id  易联云颁发给开发者的应用ID
     * @param $client_secret 易联云颁发给开发者的应用密钥
     * @param $merchid 商户id
	 * @param $refresh 是否刷新token
     * @return array
     */
	protected function getYilianyunToken($client_id = '', $client_secret = '', $merchid = 0, $refresh = false)
	{
		global $_W;

		if (empty($client_id)) {
			return array('error' => 100, 'error_description' => '缺少应用ID');
		}

		if (empty($client_secret)) {
			return array('error' => 101, 'error_description' => '缺少应用密钥');
		}

		$file_dir = dirname(__DIR__) . ('/../data/qrcode/' . $_W['uniacid'] . '/yilianyun_token/');

		if (!is_dir($file_dir)) {
			mkdir(iconv('GBK', 'UTF-8', $file_dir), 511, true);
		}

		$token_name = 'token_0';

		if (!empty($merchid)) {
			$token_name = 'token_' . $merchid;
		}

		$token_file = $file_dir . $token_name;

		if (file_exists($token_file) && !$refresh) {
			$content = file_get_contents($token_file);
			$cont = json_decode($content, true);

			if (time() - filemtime($token_file) < 3600 * 12) {
				return $cont;
			}
		}

		load()->func('communication');
		$timestamp = time();
		$sign = md5($client_id . $timestamp . $client_secret);
		$guid = $this->createguid();
		$post_data = array('client_id' => $client_id, 'grant_type' => 'client_credentials', 'sign' => $sign, 'scope' => 'all', 'timestamp' => $timestamp, 'id' => $guid);
		$curl = 'https://open-api.10ss.net/oauth/oauth';
		$content = ihttp_post($curl, $post_data);
		$cont = json_decode($content['content'], true);
		if ($cont['error'] == 0 && isset($cont['body']['access_token'])) {
			file_put_contents($token_file, $content['content']);
		}

		return $cont;
	}

	/**
     * 绑定易联云打印机(AUTH2.0接口)
     * @param $client_id        易联云颁发给开发者的应用ID
     * @param $client_secret    易联云颁发给开发者的应用密钥
     * @param $machine_code     易联云打印机终端号
     * @param $msign            易联云终端密钥
     * @param $merchid          商户id
     * @return [type] [description]
     */
	public function bindYilianyunPrinter($client_id = '', $client_secret = '', $machine_code = '', $msign = '', $merchid = 0)
	{
		global $_W;

		if (empty($client_id)) {
			return array('error' => 100, 'error_description' => '缺少应用ID');
		}

		if (empty($client_secret)) {
			return array('error' => 101, 'error_description' => '缺少应用密钥');
		}

		if (empty($machine_code)) {
			return array('error' => 102, 'error_description' => '缺少打印机编号');
		}

		if (empty($msign)) {
			return array('error' => 103, 'error_description' => '缺少打印机密钥');
		}

		$timestamp = time();
		$token = $this->getYilianyunToken($client_id, $client_secret, $merchid, true);

		if ($token['error']) {
			return array('error' => $token['error'], 'error_description' => $token['error_description']);
		}

		$access_token = $token['body']['access_token'];
		$sign = md5($client_id . $timestamp . $client_secret);
		$guid = $this->createguid();
		$post_data = array('client_id' => $client_id, 'machine_code' => $machine_code, 'msign' => $msign, 'access_token' => $access_token, 'sign' => $sign, 'timestamp' => $timestamp, 'id' => $guid);
		load()->func('communication');
		$curl = 'https://open-api.10ss.net/printer/addprinter';
		$content = ihttp_post($curl, $post_data);
		$cont = json_decode($content['content'], true);
		return $cont;
	}

	/**
     * 易联云 auth2.0新接口打印
     * @param $merchid 商户id
     * @return [type] [description]
     */
	public function printerYilianyunAuth2($merchid = 0)
	{
		$print = json_decode($this->printer['print_data'], true);

		if (empty($print['printer_yilianyun_auth2'])) {
			return error(-1, '小票打印机配置不正确');
		}

		$content = $this->buildContent($this->template, self::PRINTRT_YILIANYUN_AUTH2);
		$client_id = $print['printer_yilianyun_auth2']['partner'];
		$client_secret = $print['printer_yilianyun_auth2']['apikey'];
		$timestamp = time();
		$machine_code = $print['printer_yilianyun_auth2']['machine_code'];
		$sign = md5($client_id . $timestamp . $client_secret);
		$guid = $this->createguid();
		$token = $this->getYilianyunToken($client_id, $client_secret, $merchid);

		if ($token['error']) {
			return array('error' => $token['error'], 'error_description' => $token['error_description']);
		}

		$access_token = $token['body']['access_token'];
		$params = $this->params;
		$origin_id = empty($params['ordersn']) ? date('YmdHis', $timestamp) . mt_rand(10000, 99999) : $params['ordersn'];
		$post_data = array('client_id' => $client_id, 'machine_code' => $machine_code, 'access_token' => $access_token, 'origin_id' => $origin_id, 'sign' => $sign, 'timestamp' => $timestamp, 'id' => $guid);
		$post_data['content'] = (empty($print['printer_yilianyun_auth2']['times']) ? '' : '<MN>' . $print['printer_yilianyun_auth2']['times'] . '</MN>') . $content;
		$url = 'https://open-api.10ss.net/print/index';
		$res = ihttp_post($url, $post_data);
		return $res['content'];
	}

	/**
     * 生成唯一GUID标识
     * @return [type] [description]
     */
	protected function createguid()
	{
		if (function_exists('com_create_guid')) {
			$guid = com_create_guid();
		}
		else {
			mt_srand((double) microtime() * 10000);
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);
			$uuid = chr(123) . substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12) . chr(125);
			$guid = $uuid;
		}

		$guid = substr($guid, 1, 36);
		return $guid;
	}
}

?>
