<?php
class Pay_EweiShopV2Model
{
	private $qpay;

	public function __construct()
	{
		$this->qpay = p('qpay');
	}

	public function __call($method, $args)
	{
		if (!empty($this->qpay) && method_exists($this->qpay, $method)) {
			return call_user_func_array(array($this->qpay, $method), $args);
		}

		return error(-1, '没有全付通支付!');
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
