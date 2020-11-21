<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class MusicModule extends WeModule {
	public $tablename = 'music_reply';

	public function fieldsFormDisplay($rid = 0) {
		global $_W;
		load()->func('tpl');
		if (!empty($rid)) {
			$replies = pdo_fetchall("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `id` ASC", array(':rid' => $rid));
			$replies = istripslashes($replies);
		}
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		global $_GPC;
		if(empty($_GPC['title'])) {
			return '必须填写有效的回复内容.';
		}
		foreach($_GPC['title'] as $k => $v) {
			$row = array();
			$row['title'] = $v;
			$row['url'] = $_GPC['url'][$k];
			$row['hqurl'] = $_GPC['hqurl'][$k];
			$row['description'] = $_GPC['description'][$k];
			$this->replies[] = $row;
		}
		if(empty($this->replies)) {
			return '必须填写有效的回复内容.';
		}
		foreach($this->replies as &$r) {
						if(trim($r['title']) == '' || (trim($r['url']) == '' && trim($r['hqurl']) == '')) {
				return '必须填写有效的回复内容.';
			}
			$r['description'] = htmlspecialchars_decode($r['description']);
		}
		return '';
	}

	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		pdo_delete($this->tablename, array('rid' => $rid));
		
		foreach($this->replies as $reply) {
			$reply['rid'] = $rid;
			pdo_insert($this->tablename, $reply);
		}
		return true;
	}

	public function ruleDeleted($rid = 0) {
		global $_W;
		$replies = pdo_getall($this->tablename, array('rid' => $rid));
		$deleteid = array();
		if (!empty($replies)) {
			foreach ($replies as $index => $row) {
				$deleteid[] = $row['id'];
			}
		}
		pdo_delete($this->tablename, array('id' => $deleteid));
		return true;
	}

	public function doFormDisplay() {
		global $_W, $_GPC;
		$result = array('error' => 0, 'message' => '', 'content' => '');
		$result['content']['id'] = $GLOBALS['id'] = 'add-row-news-'.$_W['timestamp'];
		$result['content']['html'] = $this->template('item', TEMPLATE_FETCH);
		exit(json_encode($result));
	}

	public function doUploadMusic() {
		global $_W;
		checklogin();
		if (empty($_FILES['attachFile']['name'])) {
			$result['message'] = '请选择要上传的音乐！';
			exit(json_encode($result));
		}

		if ($_FILES['attachFile']['error'] != 0) {
			$result['message'] = '上传失败，请重试！';
			exit(json_encode($result));
		}
		if ($file = $this->fileUpload($_FILES['attachFile'], 'music')) {
			if (!$file['success']) {
				exit(json_encode($file));
			}
			$result['url'] = $_W['config']['upload']['attachdir'] . $file['path'];
			$result['error'] = 0;
			$result['filename'] = $file['path'];
			exit(json_encode($result));
		}
	}

	public function doDelete() {
		global $_W,$_GPC;
		$id = intval($_GPC['id']);
		$sql = "SELECT id, rid, url, hqurl FROM " . tablename($this->tablename) . " WHERE `id`=:id";
		$row = pdo_fetch($sql, array(':id'=>$id));
		if (empty($row)) {
			itoast('抱歉，回复不存在或是已经被删除！', '', 'error');
		}
		if (pdo_delete($this->tablename, array('id' => $id))) {
			itoast('删除回复成功', '', 'success');
		}
	}

	private function fileUpload($file, $type) {
		global $_W;
		set_time_limit(0);
		$_W['uploadsetting'] = array();
		$_W['uploadsetting']['music']['folder'] = 'music';
		$_W['uploadsetting']['music']['extentions'] = array('mp3', 'wma', 'wav', 'amr');
		$_W['uploadsetting']['music']['limit'] = 50000;
		$result = array();
		$upload = file_upload($file, 'music');
		if (is_error($upload)) {
			iajax(1, $upload['message']);
		}
		$result['url'] = $upload['url'];
		$result['error'] = 0;
		$result['filename'] = $upload['path'];
		return $result;
	}
}
