<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class AccountTable extends We7Table {

	protected $tableName = 'uni_account';
	protected $primaryKey = 'acid';
	protected $uni_verifycode = 'uni_verifycode';
	protected $uniSettings = 'uni_settings';
	protected $uniAccountUsers = 'uni_account_users';
	
	public function baseaccount() {
		return $this->hasOne('baseaccount', 'acid', 'default_acid');
	}

	
	public function menus() {
		return $this->hasMany('menu', 'uniacid', 'uniacid');
	}

	
	public function unigroup() {
		return $this->belongsMany('unigroup', 'id', 'uniacid', 'uni_account_group', 'groupid' ,'uniacid');
	}

	public function searchAccountList($expire = false) {
		global $_W;
		$this->query->from('uni_account', 'a')->select('a.uniacid')->leftjoin('account', 'b')
				->on(array('a.uniacid' => 'b.uniacid', 'a.default_acid' => 'b.acid'))
				->where('b.isdeleted !=', '1');

				if (!user_is_founder($_W['uid']) || user_is_vice_founder()) {
			$this->query->leftjoin('uni_account_users', 'c')->on(array('a.uniacid' => 'c.uniacid'))
						->where('a.default_acid !=', '0')->where('c.uid', $_W['uid']);
		} else {
			$this->query->where('a.default_acid !=', '0');
		}
		if (!empty($expire)) {
			$this->searchWithExprie();
		}
		$list = $this->query->getall('uniacid');
		return $list;
	}

	public function searchAccountListFields($fields = 'a.uniacid',$expire = false) {
		global $_W;
		$this->query->from('uni_account', 'a')->select($fields)->leftjoin('account', 'b')
			->on(array('a.uniacid' => 'b.uniacid', 'a.default_acid' => 'b.acid'))
			->where('b.isdeleted !=', '1');

				if (!user_is_founder($_W['uid']) || user_is_vice_founder()) {
			$this->query->leftjoin('uni_account_users', 'c')->on(array('a.uniacid' => 'c.uniacid'))
				->where('a.default_acid !=', '0')->where('c.uid', $_W['uid']);
		} else {
			$this->query->where('a.default_acid !=', '0');
		}
		if (!empty($expire)) {
			$this->searchWithExprie();
		}
		$this->accountUniacidOrder();
		$list = $this->query->getall('uniacid');
		return $list;
	}

	
	public function userOwnedAccount($uid = 0) {
		global $_W;
		$uid = intval($uid) > 0 ? intval($uid) : $_W['uid'];
		$is_founder = user_is_founder($uid, true);
		if (empty($is_founder)) {
			$users_table = table('users');
			$uniacid_list = $users_table->userOwnedAccount($uid);
			if (empty($uniacid_list)) {
				return array();
			}
			$this->query->where('u.uniacid', $uniacid_list);
		}
		return $this->query->from('uni_account', 'u')->leftjoin('account', 'a')->on(array('u.default_acid' => 'a.acid'))->where('a.isdeleted', 0)->getall('uniacid');
	}

	
	public function accountWechatsInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
				->leftjoin('account_wechats', 'w')
				->on(array('w.uniacid' => 'a.uniacid'))
				->leftjoin('uni_account_users', 'au')
				->on(array('a.uniacid' => 'au.uniacid'))
				->where(array('a.uniacid' => $uniacids))
				->where(array('au.uid' => $uid))
				->orderby('a.uniacid', 'asc')
				->getall('acid');
	}

	
	public function accountWxappInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
				->leftjoin('account_wxapp', 'w')
				->on(array('w.uniacid' => 'a.uniacid'))
				->leftjoin('uni_account_users', 'au')
				->on(array('a.uniacid' => 'au.uniacid'))
				->where(array('a.uniacid' => $uniacids))
				->where(array('au.uid' => $uid))
				->orderby('a.uniacid', 'asc')
				->getall('acid');
	}

	
	public function accountWebappInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
				->leftjoin('account_webapp', 'w')
				->on(array('w.uniacid' => 'a.uniacid'))
				->leftjoin('uni_account_users', 'au')
				->on(array('a.uniacid' => 'au.uniacid'))
				->where(array('a.uniacid' => $uniacids))
				->where(array('au.uid' => $uid))
				->orderby('a.uniacid', 'asc')
				->getall('acid');
	}

	public function accountPhoneappInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
				->leftjoin('account_phoneapp', 'w')
				->on(array('w.uniacid' => 'a.uniacid'))
				->leftjoin('uni_account_users', 'au')
				->on(array('a.uniacid' => 'au.uniacid'))
				->where(array('a.uniacid' => $uniacids))
				->where(array('au.uid' => $uid))
				->orderby('a.uniacid', 'asc')
				->getall('acid');
	}

	public function accountXzappInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
			->leftjoin('account_xzapp', 'w')
			->on(array('w.uniacid' => 'a.uniacid'))
			->leftjoin('uni_account_users', 'au')
			->on(array('a.uniacid' => 'au.uniacid'))
			->where(array('a.uniacid' => $uniacids))
			->where(array('au.uid' => $uid))
			->orderby('a.uniacid', 'asc')
			->getall('acid');
	}

	public function searchWithKeyword($title) {
		$this->query->where('a.name LIKE', "%{$title}%");
		return $this;
	}

	public function searchWithTitle($title) {
		$this->query->where('a.name', $title);
		return $this;
	}

	public function searchWithType($types = array()) {
		$this->query->where(array('b.type' => $types));
		return $this;
	}

	public function searchWithLetter($letter) {
		if (!empty($letter)) {
			$this->query->where('a.title_initial', $letter);
		} else {
			$this->query->where('a.title_initial', '');
		}
		return $this;
	}

	public function accountRankOrder() {
		$this->query->orderby('a.rank', 'desc');
		return $this;
	}

	public function accountUniacidOrder($order = 'desc') {
		$order = !empty($order) ? $order : 'desc';
		$this->query->orderby('a.uniacid', $order);
		return $this;
	}

	public function searchWithNoconnect() {
		$this->query->where('b.isconnect =', '0');
		return $this;
	}

	public function searchWithExprie() {
		global $_W;
		if (user_is_founder($_W['uid']) && !user_is_vice_founder()) {
			$this->query->leftjoin('uni_account_users', 'c')->on(array('a.uniacid' => 'c.uniacid'));
			$this->query->leftjoin('users', 'u')->on(array('c.uid' => 'u.uid'))
				->where('c.role', 'owner')->where('u.endtime !=', 0)->where('u.endtime <', TIMESTAMP);
		}

		return $this;
	}

	public function getWechatappAccount($acid) {
		return $this->query->from('account_wechats')->where('acid', $acid)->get();
	}

	public function getWxappAccount($acid) {
		return $this->query->from('account_wxapp')->where('acid', $acid)->get();
	}

	public function getWebappAccount($acid) {
		return $this->query->from('account_webapp')->where('acid', $acid)->get();
	}

	public function getPhoneappAccount($acid) {
		return $this->query->from('account_phoneapp')->where('acid', $acid)->get();
	}

	public function getUniAccountByAcid($acid) {
		$account = $this->query->from('account')->where('acid', $acid)->get();
		$uniaccount = array();
		if (!empty($account)) {
			$uniaccount = $this->query->from('uni_account')->where('uniacid', $account['uniacid'])->get();
		}
		if (empty($account)) {
			return array();
		} else {
			return array_merge($account, $uniaccount);
		}
	}

	public function getUniAccountByUniacid($uniacid) {
		$account = $this->getAccountByUniacid($uniacid);
		$uniaccount = array();
		if (!empty($account)) {
			$uniaccount = $this->query->from('uni_account')->where('uniacid', $account['uniacid'])->get();
		}
		if (empty($account)) {
			return array();
		} else {
			return !empty($uniaccount) && is_array($uniaccount) ? array_merge($account, $uniaccount) : $account;
		}
	}

	public function accountGroupModules($uniacid, $type = '') {
		$packageids = $this->query->from('uni_account_group')->where('uniacid', $uniacid)->select('groupid')->getall('groupid');
		$packageids = empty($packageids) ? array() : array_keys($packageids);
		if (in_array('-1', $packageids)) {
			$modules = $this->query->from('modules')->select('name')->getall('name');
			return array_keys($modules);
		}
		$uni_modules = array();
		
			$site_store_buy_package = table('store')->searchUserBuyPackage($uniacid);
			$packageids = array_merge($packageids, array_keys($site_store_buy_package));
		
		$uni_groups = $this->query->from('uni_group')->where('uniacid', $uniacid)->whereor('id', $packageids)->getall('modules');
		if (!empty($uni_groups)) {
			if (empty($type)) {
				$account = $this->getAccountByUniacid($uniacid);
				$type = $account['type'];
			}
			foreach ($uni_groups as $group) {
				$group_module = (array)iunserializer($group['modules']);
				if (empty($group_module)) {
					continue;
				}
				switch ($type) {
					case ACCOUNT_TYPE_OFFCIAL_NORMAL:
					case ACCOUNT_TYPE_OFFCIAL_AUTH:
						$uni_modules = is_array($group_module['modules']) ? array_merge($group_module['modules'], $uni_modules) : $uni_modules;
						break;
					case ACCOUNT_TYPE_APP_NORMAL:
					case ACCOUNT_TYPE_APP_AUTH:
					case ACCOUNT_TYPE_WXAPP_WORK:
						$uni_modules = is_array($group_module['wxapp']) ? array_merge($group_module['wxapp'], $uni_modules) : $uni_modules;
						break;
					case ACCOUNT_TYPE_WEBAPP_NORMAL:
						$uni_modules = is_array($group_module['webapp']) ? array_merge($group_module['webapp'], $uni_modules) : $uni_modules;
						break;
					case ACCOUNT_TYPE_XZAPP_NORMAL:
					case ACCOUNT_TYPE_XZAPP_AUTH:
						$uni_modules = is_array($group_module['xzapp']) ? array_merge($group_module['xzapp'], $uni_modules) : $uni_modules;
						break;
					case ACCOUNT_TYPE_PHONEAPP_NORMAL:
						$uni_modules = is_array($group_module['phoneapp']) ? array_merge($group_module['phoneapp'], $uni_modules) : $uni_modules;
						break;
					case ACCOUNT_TYPE_ALIAPP_NORMAL:
						$uni_modules = is_array($group_module['aliapp']) ? array_merge($group_module['aliapp'], $uni_modules) : $uni_modules;
						break;
				}
			}
			$uni_modules = array_unique($uni_modules);
		}
		return $uni_modules;
	}

	public function getAccountOwner($uniacid) {
		if (empty($uniacid)) {
			return array();
		}
		$owneruid = $this->query->from('uni_account_users')->where(array('uniacid' => $uniacid, 'role' => ACCOUNT_MANAGE_NAME_OPERATOR))->getcolumn('uid');
		if (empty($owneruid)) {
			return array();
		}
		return table('users')->usersInfo($owneruid);
	}

	public function getAccountByUniacid($uniacid) {
		return $this->query->from('account')->where('uniacid', $uniacid)->get();
	}

	public function getAccountExtraPermission($uniacid) {
		if (empty($uniacid)) {
			return array();
		}
		$result = $this->query->from('uni_group')->where('uniacid', $uniacid)->get();
		if (!empty($result)) {
			$result['templates'] = iunserializer($result['templates']);
			$group_module = (array)iunserializer($result['modules']);
			if (empty($group_module)) {
				$result['modules'] = array();
			} else {
				$account = $this->getAccountByUniacid($uniacid);
				switch ($account['type']) {
					case ACCOUNT_TYPE_OFFCIAL_NORMAL:
					case ACCOUNT_TYPE_OFFCIAL_AUTH:
						$result['modules'] = $group_module['modules'];
						break;
					case ACCOUNT_TYPE_APP_NORMAL:
					case ACCOUNT_TYPE_APP_AUTH:
					case ACCOUNT_TYPE_WXAPP_WORK:
						$result['modules'] = $group_module['wxapp'];
						break;
					case ACCOUNT_TYPE_WEBAPP_NORMAL:
						$result['modules'] = $group_module['webapp'];
						break;
					case ACCOUNT_TYPE_XZAPP_NORMAL:
					case ACCOUNT_TYPE_XZAPP_AUTH:
						$result['modules'] = $group_module['xzapp'];
						break;
					case ACCOUNT_TYPE_PHONEAPP_NORMAL:
						$result['modules'] = $group_module['phoneapp'];
						break;
					default:
						$result['modules'] = array();
				}
			}
		} else {
			$result = array();
		}
		return $result;
	}

	public function getUniVerifycode($params) {
		global $_W;
		$this->query->from($this->uni_verifycode);
		if (!empty($params['uniacid'])) {
			$this->query->where('uniacid', $params['uniacid']);
		}
		if (!empty($params['receiver'])) {
			$this->query->where('receiver', $params['receiver']);
		}
		if (!empty($params['createtime >'])) {
			$this->query->where('createtime >', $params['createtime >']);
		}
		if (!empty($params['verifycode'])) {
			$this->query->where('verifycode', $params['verifycode']);
		}

		return $this->query->get();
	}

	public function getUniSetting() {
		return $this->query->from($this->uniSettings)->get();
	}

	public function getUniAccountList() {
		return $this->query->select('uniacid')->from($this->tableName)->getall();
	}

	public function getOwnerUid() {
		return $this->query->from($this->uniAccountUsers)->getcolumn('uid');
	}

	public function getOwnedAccountCount($uid) {
		return $this->query->from($this->uniAccountUsers, 'u')->select('d.type, count(*) as count')->leftjoin($this->tableName, 'a')
		->on(array('u.uniacid' => 'a.uniacid'))->leftjoin('account', 'd')->on(array('a.default_acid' => 'd.acid'))
		->where('u.uid', $uid)->where('u.role', 'owner')->where('d.isdeleted', 0)->groupby('d.type')->getall();
	}
}