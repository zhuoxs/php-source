<?php
/**
 * [weliam] Copyright (c) 2016
 * 拼团商城数据库查询方法
 */
defined('IN_IA') or exit('Access Denied');

function pdo_fetch_one($tablename, $params = array(), $fields = array()){
	$result = pdo()->get($tablename, $params, $fields);
	if (!is_array($result) || empty($result)) {
		return array();
	}
	return $result;
}

function pdo_select_count($tablename, $params = array()){
	$condition = wl_implode($params, 'AND');
	$sql = 'SELECT COUNT(*) AS total FROM ' . tablename($tablename) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '') . " LIMIT 1";
	$result = pdo()->fetch($sql, $condition['params']);
	
	if (empty($result)) {
		return 0;
	}
	
	return intval($result['total']);
}


function pdo_fetch_value($tablename, $field, $params = array()){
	$row = pdo_fetch_one($tablename, $params, array($field));
	return !empty($row) ? $row[$field] : NULL;
}


function pdo_fetch_many($tablename, $params = array(), $fields = array(), $key = '', $after_where = ''){
	if (!empty($fields) && !empty($key) && !in_array($key, $fields)) {
		$fields[] = $key;
	}
	$result = pdo()->getall($tablename, $params, $fields, $key, $after_where);
	if (!is_array($result) || empty($result)) {
		return array();
	}
	return $result;
}

function pdo_pagination($sqlTotal, $sqlData, $params = array(), $keyfield = '',&$total = null, &$page = 1, $size = 50){
	$total = pdo_fetchcolumn($sqlTotal, $params);
	$page = max(1, intval($page));
	$size = max(1, intval($size));
	$sql = $sqlData.' LIMIT ' . ($page - 1) * $size . ',' . $size;
	$data = pdo_fetchall($sql, $params, $keyfield);
	return $data;
}

function pdo_sql_select_count_from($tablename){
	return 'SELECT COUNT(*) FROM '.tablename($tablename).' ';
}

function pdo_sql_select_all_from($tablename, $fields = array()){
	$fields = (empty($fields) || !is_array($fields)) ? '*' : ('`'.implode('`,`', $fields).'`');
	return 'SELECT ' . $fields . ' FROM '.tablename($tablename).' ';
}

function wl_implode($params, $glue = ',') {
	$result = array('fields' => ' 1 ', 'params' => array());
	$split = '';
	$suffix = '';
	if (in_array(strtolower($glue), array('and', 'or'))) {
		$suffix = '__';
	}
	if (!is_array($params)) {
		$result['fields'] = $params;
		return $result;
	}
	if (is_array($params)) {
		$result['fields'] = '';
		foreach ($params as $fields => $value) {
			if (is_array($value)) {
				$result['fields'] .= $split . "`$fields` IN ('".implode("','", $value)."')";
				$split = ' ' . $glue . ' ';
			} else {
				$result['fields'] .= $split . "`$fields` =  :{$suffix}$fields";
				$split = ' ' . $glue . ' ';
				$result['params'][":{$suffix}$fields"] = is_null($value) ? '' : $value;
			}
		}
	}
	return $result;
}
