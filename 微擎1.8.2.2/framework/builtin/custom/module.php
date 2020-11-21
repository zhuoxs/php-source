<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class CustomModule extends WeModule {
	public $tablename = 'custom_reply';
	private $replies = '';
	
	public function fieldsFormDisplay($rid = 0) {
		if(!empty($rid) && $rid > 0) {
			$isexists = pdo_fetch("SELECT id FROM ".tablename('rule')." WHERE id = :id", array(':id' => $rid));
		}
		if(!empty($isexists)) {
			$replies = pdo_fetch("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `id`", array(':rid' => $rid));
		}
		include $this->template('display');
	}
	
	public function fieldsFormValidate($rid = 0) {
		global $_GPC;
		if($_GPC['start1'] == '-1' && $_GPC['end1'] == '-1' && $_GPC['start2'] == '-1' && $_GPC['end2'] == '-1') {
			return '没有选择有效的接入时间段';
		}
		if($_GPC['start2'] != '-1' && ($_GPC['end1'] > $_GPC['start2'])) {
			return '第一个时间段的结束日期大于第二个时间段的开始时间.';
		}
		return '';
	}
	
	public function fieldsFormSubmit($rid = 0) {
		global $_GPC;
		pdo_delete($this->tablename, array('rid' => $rid));
		
		pdo_insert($this->tablename, array('rid' => $rid, 'start1' => $_GPC['start1'], 'end1' => $_GPC['end1'], 'start2' => $_GPC['start2'], 'end2' => $_GPC['end2']));
		return true;
	}
	
	public function ruleDeleted($rid = 0) {
		pdo_delete($this->tablename, array('rid' => $rid));
	}
}
