<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class UserapiModule extends WeModule {
	public $tablename = 'userapi_reply';

	public function fieldsFormDisplay($rid = 0) {
		global $_W;
		if (!empty($rid)) {
			$row = pdo_fetch("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
			$row['type'] = 1; 			if (!strexists($row['apiurl'], 'http://') && !strexists($row['apiurl'], 'https://')) {
				$row['apilocal'] =  $row['apiurl'];
				$row['type'] = 0; 				$row['apiurl'] = '';
			}
		} else {
			$row = array(
				'cachetime' => 0,
				'type' => 1
			);
		}
		$path = IA_ROOT . '/framework/builtin/userapi/api/';
		if (is_dir($path)) {
			$apis = array();
			if ($handle = opendir($path)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						$apis[] = $file;
					}
				}
			}
		}
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		global $_GPC;
		if (($_GPC['type'] && empty($_GPC['apiurl'])) || (empty($_GPC['type']) && empty($_GPC['apilocal']))) {
			itoast('请填写接口地址！', '', '');
		}
		if ($_GPC['type'] && empty($_GPC['token'])) {
			itoast('请填写Token值！', '', '');
		}
		return '';
	}

	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		$reply = array(
			'rid' => $rid,
			'description' => $_GPC['description'],
			'apiurl' => empty($_GPC['type']) ? $_GPC['apilocal'] : $_GPC['apiurl'],
			'token' => $_GPC['wetoken'],
			'default_text' => $_GPC['default-text'],
			'cachetime' => intval($_GPC['cachetime']),
		);
		$is_exists = pdo_fetchcolumn('SELECT id FROM ' . tablename($this->tablename) . ' WHERE rid = :rid', array(':rid' => $rid));
		if(!empty($is_exists)) {
			if(pdo_update($this->tablename, $reply, array('rid' => $rid)) !== false) {
				return true;
			}
		} else {
			if(pdo_insert($this->tablename, $reply)) {
				return true;
			}
		}
		return false;
	}

	public function ruleDeleted($rid = 0) {
		pdo_delete($this->tablename, array('rid' => $rid));
	}

	public function doSwitch() {
		global $_W, $_GPC;
		$m = array_merge($_W['modules']['userapi'], $_W['account']['modules']['userapi']);
		$cfg = $m['config'];
		if($_W['ispost']) {
			$rids = explode(',', $_GPC['rids']);
			if(is_array($rids)) {
				$cfg = array();
				foreach($rids as $rid) {
					$cfg[intval($rid)] = true;
				}
				$this->saveSettings($cfg);
			}
			exit();
		}
		load()->model('reply');
		$rs = reply_search("uniacid = 0 AND module = 'userapi' AND `status`=1");
		$ds = array();
		foreach($rs as $row) {
			$reply = pdo_fetch('SELECT * FROM ' . tablename($this->tablename) . ' WHERE `rid`=:rid', array(':rid' => $row['id']));
			$r = array();
			$r['title'] = $row['name'];
			$r['rid'] = $row['id'];
			$r['description'] = $reply['description'];
			$r['switch'] = $cfg[$r['rid']] ? ' checked="checked"' : '';
			$ds[] = $r;
		}
		include $this->template('switch');
}
}