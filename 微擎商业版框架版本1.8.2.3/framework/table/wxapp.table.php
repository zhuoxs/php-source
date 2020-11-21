<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');
load()->table('account');
class WxappTable extends AccountTable {
	
	protected $tableName ='wxapp_versions';
	private $version_table = 'wxapp_versions';
	
	
	public function latestVersion($uniacid) {
		if (empty($uniacid)) {
			return array();
		}
		return $this->query->from($this->version_table)
				->where('uniacid', $uniacid)
				->orderby('id', 'desc')->limit(4)->getall('id');
	}


	public function last($uniacid) {
		return $this->query->from($this->version_table)
			->where('uniacid', $uniacid)
			->orderby('id', 'desc')->limit(1)->get();
	}

	public function wxappInfo($uniacid) {
		return $this->query->from('account_wxapp')->where('uniacid', $uniacid)->getall('uniacid');
	}

}