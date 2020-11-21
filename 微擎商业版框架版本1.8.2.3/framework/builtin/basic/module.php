<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class BasicModule extends WeModule {
	public $tablename = 'basic_reply';
	private $replies = '';
	
	public function fieldsFormDisplay($rid = 0) {
		if(!empty($rid) && $rid > 0) {
			$isexists = pdo_fetch("SELECT id FROM ".tablename('rule')." WHERE id = :id", array(':id' => $rid));
		}
		if(!empty($isexists)) {
			$replies = pdo_fetchall("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `id`", array(':rid' => $rid));
		}
		include $this->template('display');
	}
	
	public function fieldsFormValidate($rid = 0) {
		global $_GPC;
		$this->replies = @json_decode(htmlspecialchars_decode($_GPC['replies']), true);
		if(empty($this->replies)) {
			return '必须填写有效的回复内容.';
		}
		return '';
	}
	
	public function fieldsFormSubmit($rid = 0) {
		pdo_delete($this->tablename, array('rid' => $rid));
		
		foreach($this->replies as $reply) {
			pdo_insert($this->tablename, array('rid' => $rid, 'content' => $reply['content']));
		}
		return true;
	}
	
	public function ruleDeleted($rid = 0) {
		pdo_delete($this->tablename, array('rid' => $rid));
	}
}
