<?php
defined('IN_IA') or exit('Access Denied');

class User {
	
    static function agentuser_single($user_or_uid) {
		$user = $user_or_uid;
		if (empty($user)) {
			return false;
		}
		if (is_numeric($user)) {
			$user = array('id' => $user);
		}
		if (!is_array($user)) {
			return false;
		}
		$where = ' WHERE 1 ';
		$params = array();
		if (!empty($user['id'])) {
			$where .= ' AND `id`=:id';
			$params[':id'] = intval($user['id']);
		}
		if (!empty($user['username'])) {
			$where .= ' AND `username`=:username';
			$params[':username'] = $user['username'];
		}
		if (!empty($user['status'])) {
			$where .= " AND `status`=:status";
			$params[':status'] = intval($user['status']);
		}
		if (empty($params)) {
			return false;
		}
		$sql = 'SELECT * FROM ' . tablename(PDO_NAME.'agentusers') . " $where LIMIT 1";
		$record = pdo_fetch($sql, $params);
		if (empty($record)) {
			return false;
		}
		if (!empty($user['password'])) {
			$password = Util::encryptedPassword($user['password'], $record['salt']);
			if ($password != $record['password']) {
				return false;
			}
		}
		return $record;
	}
	
	
	static function agentuser_update($user) {
		if (empty($user['id']) || !is_array($user)) {
			return false;
		}
		$record = array();
		if (!empty($user['username'])) {
			$record['username'] = $user['username'];
		}
		if (!empty($user['password'])) {
			$record['password'] = user_hash($user['password'], $user['salt']);
		}
		if (!empty($user['lastvisit'])) {
			$record['lastvisit'] = (strlen($user['lastvisit']) == 10) ? $user['lastvisit'] : strtotime($user['lastvisit']);
		}
		if (!empty($user['lastip'])) {
			$record['lastip'] = $user['lastip'];
		}
		if (isset($user['joinip'])) {
			$record['joinip'] = $user['joinip'];
		}
		if (isset($user['remark'])) {
			$record['remark'] = $user['remark'];
		}
		if (isset($user['status'])) {
			$status = intval($user['status']);
			if (!in_array($status, array(0, 1))) {
				$status = 1;
			}
			$record['status'] = $status;
		}
		if (isset($user['groupid'])) {
			$record['groupid'] = $user['groupid'];
		}
		if (isset($user['starttime'])) {
			$record['starttime'] = $user['starttime'];
		}
		if (isset($user['endtime'])) {
			$record['endtime'] = $user['endtime'];
		}
		if (empty($record)) {
			return false;
		}
		return pdo_update(PDO_NAME.'agentusers', $record, array('id' => intval($user['id'])));
	}
}

