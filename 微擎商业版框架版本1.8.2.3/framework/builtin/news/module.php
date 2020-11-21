<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class NewsModule extends WeModule {
	public $tablename = 'news_reply';
	public $replies = array();

	public function fieldsFormDisplay($rid = 0) {
		global $_W;
		load()->func('tpl');
		$replies = array();
		$replies = pdo_fetchall("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid AND parent_id = -1 ORDER BY `displayorder` DESC, id ASC", array(':rid' => $rid));
		if(!empty($replies)) {
						$parent_id = $replies[0]['id'];
			pdo_update($this->tablename, array('parent_id' => $parent_id), array('rid' => $rid));
			pdo_update($this->tablename, array('parent_id' => 0), array('rid' => $rid, 'id' => $parent_id));
		}
		$rows = pdo_fetchall("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `parent_id` ASC, `id` ASC", array(':rid' => $rid));
		$replies = array();
		foreach($rows as &$row) {
			if(!empty($row['thumb'])) {
				$row['thumb'] = tomedia($row['thumb']);
			}
			if (empty($row['parent_id'])) {
				$replies[$row['id']][] = $row;
			} else {
				$replies[$row['parent_id']][] = $row;
			}
		}
		$replies = array_values($replies);
		include $this->template('display');
	}
	
	public function fieldsFormValidate($rid = 0) {
		global $_GPC, $_W;
		$this->replies = @json_decode(htmlspecialchars_decode($_GPC['replies']), true);
		if(empty($this->replies)) {
			return '必须填写有效的回复内容.';
		}
		$column = array('id', 'parent_id', 'title', 'author', 'displayorder', 'thumb', 'description', 'content', 'url', 'incontent', 'createtime');
		foreach($this->replies as $i => &$group) {
			foreach($group as $k => &$v) {
				if(empty($v)) {
					unset($group[$k]);
					continue;
				}
				if (trim($v['title']) == '') {
					return '必须填写有效的标题.';
				}
				if (trim($v['thumb']) == '') {
					return '必须填写有效的封面链接地址.';
				}
				$v['thumb'] = str_replace($_W['attachurl'], '', $v['thumb']);
				$v['content'] = htmlspecialchars_decode($v['content']);
				$v['createtime'] = TIMESTAMP;
				$v = array_elements($column, $v);
			}
			if(empty($group)) {
				unset($i);
			}
		}
		if(empty($this->replies)) {
			return '必须填写有效的回复内容.';
		}
		return '';
	}
	
	public function fieldsFormSubmit($rid = 0) {
		$sql = 'SELECT `id` FROM ' . tablename($this->tablename) . " WHERE `rid` = :rid";
		$replies = pdo_fetchall($sql, array(':rid' => $rid), 'id');
		$replyids = array_keys($replies);
		$indexs = array();
		foreach($this->replies as &$group) {
			$parent_id = -1;
			foreach($group as $reply) {
				if($parent_id <= 0) {
					if($reply['parent_id'] == 0) {
						$parent_id = $reply['id'];
					} elseif($reply['parent_id'] > 0) {
						$parent_id = $reply['parent_id'];
					}
				}
			}
			if($parent_id == -1) {
								$i = 0;
				foreach($group as $reply) {
					if(!$i) {
						$i++;
						$reply['rid'] = $rid;
						$reply['parent_id'] = 0;
						pdo_insert($this->tablename, $reply);
						$parent_id = pdo_insertid();
					} else {
						$reply['parent_id'] = $parent_id;
						$reply['rid'] = $rid;
						pdo_insert($this->tablename, $reply);
					}
				}
				pdo_update($this->tablename, array('parent_id' => 0), array('id' => $parent_id));
			} else {
				$i = 0;
				foreach($group as $reply) {
					if(!$i) {
						$new_parent_id = $reply['id'];
						$i++;
					}
					$arr[] = $reply['id'];
					$reply['parent_id'] = $parent_id;
					if (in_array($reply['id'], $replyids)) {
						pdo_update($this->tablename, $reply, array('id' => $reply['id']));
						$index = array_search($reply['id'], $replyids);
						unset($replyids[$index]);
					} else {
						$reply['rid'] = $rid;
						pdo_insert($this->tablename, $reply);
					}
				}
				if(!in_array($parent_id, $arr)) {
					$parent_id = $new_parent_id;
				}
				pdo_update($this->tablename, array('parent_id' => $new_parent_id), array('parent_id' => $parent_id));
				pdo_update($this->tablename, array('parent_id' => 0), array('id' => $new_parent_id));
			}
		}

		if (!empty($replyids)) {
			$replies = array_values($replyids);
			$replyids = implode(',', $replyids);
			$sql = 'DELETE FROM '. tablename($this->tablename) . " WHERE `id` IN ({$replyids})";
			pdo_query($sql);
		}
		return true;
	}
	
	public function ruleDeleted($rid = 0) {
		pdo_delete($this->tablename, array('rid' => $rid));
		return true;
	}
}