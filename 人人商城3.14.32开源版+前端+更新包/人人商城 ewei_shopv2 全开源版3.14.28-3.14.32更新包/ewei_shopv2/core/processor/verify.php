<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require IA_ROOT . '/addons/ewei_shopv2/defines.php';
require EWEI_SHOPV2_INC . 'com_processor.php';
class VerifyProcessor extends ComProcessor
{
	protected $sessionkey;
	protected $errkey;
	protected $codekey;

	public function __construct()
	{
		parent::__construct('verify');
		$this->sessionkey = EWEI_SHOPV2_PREFIX . 'order_wechat_verify_info';
		$this->codekey = EWEI_SHOPV2_PREFIX . 'order_wechat_verify_code';
	}

	public function respond($obj = NULL)
	{
		global $_W;
		$message = $obj->message;
		$openid = $obj->message['from'];
		$content = $obj->message['content'];
		$msgtype = strtolower($message['msgtype']);
		$event = strtolower($message['event']);
		@session_start();
		if ($msgtype == 'text' || $event == 'click') {
			$saler = pdo_fetch('select * from ' . tablename('ewei_shop_saler') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

			if (empty($saler)) {
				$saler = pdo_fetch('select * from ' . tablename('ewei_shop_merch_saler') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (empty($saler)) {
				return $this->responseEmpty();
			}

			$verifyset = m('common')->getSysset('verify');

			if (!empty($verifyset['type'])) {
				return $obj->respText('<a href=\'' . mobileUrl('verify/page', NULL, true) . '\'>点击进入核销台</a>');
			}

			if (!$obj->inContext) {
				unset($_SESSION[$this->sessionkey]);
				unset($_SESSION[$this->codekey]);
				$obj->beginContext();
				return $obj->respText('请输入8位及以上数字订单消费码或自提码:');
			}

			if ($obj->inContext) {
				if (is_numeric($content)) {
					if (8 <= strlen($content)) {
						$_SESSION[$this->codekey] = $verifycode = trim($content);

						if (strlen($content) == 8) {
							$orderid = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and ( verifycode=:verifycode or verifycodes like :verifycodes ) limit 1 ', array(':uniacid' => $_W['uniacid'], ':verifycode' => $verifycode, ':verifycodes' => '%|' . $verifycode . '|%'));
						}
						else {
							if (strlen($content) == 9 && substr($content, 0, 1) == '8') {
								$verifygood = m('verifygoods')->search($content);

								if (is_error($verifygood)) {
									return $obj->respText($verifygood['message']);
								}

								$orderid = $verifygood['orderid'];
							}
						}

						if (empty($orderid)) {
							unset($_SESSION[$this->sessionkey]);
							return $obj->respText('未找到订单，请继续输入，退出请回复 n。');
						}

						if (strlen($content) == 8) {
							$allow = com('verify')->allow($orderid, 0, $openid);
						}
						else {
							$allow = m('verifygoods')->allow($content, 0);
						}

						if (is_error($allow)) {
							unset($_SESSION[$this->sessionkey]);
							return $obj->respText($allow['message'] . ' 请输入其他消费码或自提码，退出请回复 n。');
						}

						extract($allow);
						$_SESSION[$this->sessionkey] = json_encode(array('verifygoods' => strlen($content) == 9 && substr($content, 0, 1) == '8', 'orderid' => $allow['order']['id'], 'verifytype' => $allow['order']['verifytype'], 'lastverifys' => $allow['lastverifys']));
						$member = pdo_get('ewei_shop_member', array('openid' => $order['openid']));
                        $paytime = date('Y-m-d H:i:s', $order['paytime']);
						$str = '';
						$str .= '订单：' . $order['ordersn'] . '
金额：' . $order['price'] . ' 元
';
						$str .= '用户昵称：' . $member['nickname'] . '\r\n';
						$str .= '付款时间：' . $paytime . '\r\n';
						$str .= '商品名称：
';

						if ($this->isMultiArray($allgoods)) {
							foreach ($allgoods as $index => $g) {
								$str .= $g['title'] . '\r\n';
                                $str .= '商品规格：' . $g['optiontitle'] . '\r\n';
							}
						}
						else {
							$str .= $allgoods['title'] . '
';
							$str .= '商品规格：' . $allgoods['optiontitle'] . '\r\n';
						}

						if ($order['dispatchtype'] == 1) {
							$str .= '
信息正确请回复 y 进行自提确认，回复 n 退出。';
						}
						else if ($order['verifytype'] == 0) {
							$str .= '
正确请回复 y 进行订单核销，回复 n 退出。';
						}
						else if ($order['verifytype'] == 1) {
							$str .= '
信息正确请输入核销次数进行核销（可核销剩余 ' . $lastverifys . ' 次），回复 n 退出。';
						}
						else {
							if ($order['verifytype'] == 2) {
								$str .= '
消费码：' . $verifycode;
								$str .= '
确认信息正确请回复 y 进行确认，回复 n 退出。';
							}
						}

						return $obj->respText($str);
					}

					if (isset($_SESSION[$this->sessionkey])) {
						$session = json_decode($_SESSION[$this->sessionkey], true);
						$verifycode = $_SESSION[$this->codekey];

						if ($session['verifytype'] == 1) {
							if (intval($content) <= 0) {
								return $obj->respText('订单最少核销 1 次!');
							}

							if ($session['verifygoods']) {
								$result = m('verifygoods')->complete($verifycode, intval($content), '');
							}
							else {
								if ($session['lastverifys'] < intval($content)) {
									return $obj->respText('此订单最多核销 ' . $session['lastverifys'] . ' 次!');
								}

								$result = com('verify')->verify($session['orderid'], intval($content), '', $openid);
							}

							if (is_error($result)) {
								unset($_SESSION[$this->sessionkey]);
								return $obj->respText($result['message'] . ' 请输入其他消费码或自提码，退出请回复 n。');
							}

							$obj->endContext();
							return $obj->respText('核销成功!');
						}
					}

					return $obj->respText('请输入8位及以上数字订单消费码或自提码:');
				}

				if (strtolower($content) == 'y') {
					if (isset($_SESSION[$this->sessionkey])) {
						$session = json_decode($_SESSION[$this->sessionkey], true);

						if ($session['verifytype'] == 1) {
							return $obj->respText(' 请输入核销次数:');
						}

						$result = com('verify')->verify($session['orderid'], 0, $_SESSION[$this->codekey], $openid);

						if (is_error($result)) {
							unset($_SESSION[$this->sessionkey]);
							return $obj->respText($result['message'] . ' 请输入其他消费码或自提码，退出请回复 n。');
						}

						$obj->endContext();
						return $obj->respText('核销成功!');
					}

					return $obj->respText('请输入8位及以上数字订单消费码或自提码:');
				}

				@session_start();
				unset($_SESSION[$this->sessionkey]);
				unset($_SESSION[$this->codekey]);
				$obj->endContext();
				return $obj->respText('退出成功.');
			}
		}
	}

	private function isMultiArray($array)
	{
		return count($array) && count($array, true);
	}
	private function responseEmpty()
    {
        ob_clean();
        ob_start();
        echo "";
        ob_flush();
        ob_end_flush();
        exit(0);
    }
}

?>
