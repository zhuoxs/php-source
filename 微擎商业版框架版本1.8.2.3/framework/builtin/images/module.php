<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class ImagesModule extends WeModule {
	public $tablename = 'images_reply';

	public function fieldsFormDisplay($rid = 0) {
		global $_W;
		load()->func('tpl');
		if (!empty($rid)) {
			$replies = pdo_fetch("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid", array(':rid' => $rid));
		}
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		global $_GPC;
		if(empty($_GPC['title'])) {
			return '必须填写有效的图片标题.';
		}
		if (empty($_GPC['mediaid'])) {
			return '必须上传有效的图片.';
		}
		$this->replies['title'] = $_GPC['title'];
		$this->replies['mediaid'] = $_GPC['mediaid'];
		$this->replies['description'] = $_GPC['description'];
		$this->replies['createtime'] = time();
		return '';
	}

	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		pdo_delete($this->tablename, array('rid' => $rid));
		
		$this->replies['rid'] = $rid;
		pdo_insert($this->tablename, $this->replies);
		return true;
	}

	public function ruleDeleted($rid = 0) {
		global $_W;
		$replies = pdo_fetchall("SELECT id FROM ".tablename($this->tablename)." WHERE rid = '$rid'");
		$deleteid = array();
		if (!empty($replies)) {
			foreach ($replies as $index => $row) {
				$deleteid[] = $row['id'];
			}
		}
		pdo_delete($this->tablename, "id IN ('".implode("','", $deleteid)."')");
		return true;
	}
	
}

