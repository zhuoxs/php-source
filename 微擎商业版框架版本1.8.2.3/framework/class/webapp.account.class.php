<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class WebappAccount extends WeAccount {
	public function __construct($account = array()) {
		$this->menuFrame = 'webapp';
		$this->type = ACCOUNT_TYPE_WEBAPP_NORMAL;
		$this->typeSign = WEBAPP_TYPE_SIGN;
		$this->typeName = 'PC';
		$this->typeTempalte = '-webapp';
	}

	public function checkIntoManage() {
		if (empty($this->account) || (!empty($this->uniaccount['account']) && $this->uniaccount['type'] != ACCOUNT_TYPE_WEBAPP_NORMAL && !defined('IN_MODULE'))) {
			return false;
		}
		return true;
	}

	public function fetchAccountInfo() {
		$account_table = table('account');
		$account = $account_table->getWebappAccount($this->uniaccount['acid']);
		return $account;
	}

	public function accountDisplayUrl() {
		return url('account/display', array('type' => WEBAPP_TYPE_SIGN));
	}
}