<?php

!(defined('IA_ROOT')) && define('IA_ROOT', 'IA_ROOT', str_replace("\\", '/', dirname(dirname(__FILE__))));
!(defined('MODULE_ROOT')) && define('MODULE_ROOT', '');
!(defined('ATTACHMENT_ROOT')) && define('ATTACHMENT_ROOT', IA_ROOT .'/attachment/');

/**
 * @method func(string $string)
 */
class Loader {

}
function load() {
	static $loader;
	if(empty($loader)) {
		$loader = new Loader();
	}
	return $loader;
}
class WeModuleWxapp {

}
function result() {
	return [];
}
function tomedia($src, $local_path = false, $is_cahce = false) {
	return '';
}
function tablename($table) {
	return '';
}
function pdo_getall($tablename, $condition = array(), $fields = array(), $keyfield = '', $orderby = array(), $limit = array())
{
	return [];
}
function pdo_get($tablename, $condition = array(), $fields = array()) {
	return [];
}
function pdo_update($table, $data = array(), $params = array(), $glue = 'AND') {
	return [];
}
function pdo_delete($table, $params = array(), $glue = 'AND') {
	return [];
}
function pdo_query($sql, $params = array()) {
	return [];
}
function pdo_fetch($sql, $params = array()) {
	return [];
}
function pdo_fetchall($sql, $params = array(), $keyfield = '') {
	return [];
}
function pdo_getcolumn($tablename, $condition, $field) {
	return [];
}
function pdo_insert($table, $data = array(), $replace = FALSE) {
	return [];
}
function pdo_insertid() {
	return [];
}
function pdo_exists($tablename, $condition = array()) {
	return [];
}
function pdo_fetchcolumn($sql, $params = array(), $column = 0) {
	return [];
}
function pagination($total, $pageIndex, $pageSize = 15, $url = '', $context = array('before' => 5, 'after' => 4, 'ajaxcallback' => '', 'callbackfuncname' => '')) {
	return '';
}
function db_table_fix_sql($schema1, $schema2, $strict = false) {
	return [];
}
function db_table_schema($db, $tablename = '') {
	return [];
}
function pdo_count($tablename, $condition = array(), $cachetime = 15) {
	return '';
}
function pdo_debug($output = true, $append = array()) {
	return [];
}
function pdo_begin() {
	return [];
}
function pdo_commit() {
	return [];
}
function pdo_rollback() {
	return [];
}
function pdo_run($sql) {
	return [];
}
function mkdirs($path) {
	return is_dir($path);
}
function ihttp_request($url, $post = '', $extra = array(), $timeout = 60) {
	return [];
}
function pdo() {
	return [];
}
function message($msg, $redirect = '', $type = '', $tips = false, $extend = array()) {
	return [];
}
function murl($segment, $params = array(), $noredirect = true, $addhost = false) {
	return '';
}
function uni_fetch($uniacid = 0) {
	return [];
}
function file_upload($file, $type = 'image', $name = '', $compress = false) {
	return [];
}
function is_error($data) {
	return false;
}
function file_remote_upload($filename, $auto_delete_local = true) {
	return [];
}
function file_delete($file) {
	return true;
}

