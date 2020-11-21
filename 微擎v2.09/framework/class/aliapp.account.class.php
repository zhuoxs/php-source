<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


class AliappAccount extends WeAccount {
	public $tablename = 'account_aliapp';

	public function __construct($account = array()) {
		$this->menuFrame = 'wxapp';
		$this->type = ACCOUNT_TYPE_ALIAPP_NORMAL;
		$this->typeName = '支付宝小程序';
		$this->typeTempalte = '-aliapp';
		$this->typeSign = ALIAPP_TYPE_SIGN;
	}

	public function accountDisplayUrl() {
		return url('account/display');
	}

	public function fetchAccountInfo() {
		$account_table = table('account_aliapp');
		$account = $account_table->getAccount($this->uniaccount['acid']);
		$account['encrypt_key'] = $account['key'];
		return $account;
	}
	public function checkIntoManage() {
		if (empty($this->account) || (!empty($this->uniaccount['account']) && $this->uniaccount['type'] != ACCOUNT_TYPE_PHONEAPP_NORMAL && !defined('IN_MODULE'))) {
			return false;
		}
		return true;
	}
}