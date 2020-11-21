<?php
defined('IN_IA') or exit('Access Denied');

class Sort_WeliamController{
	/*
	 * 排版展示
	 */
	public function index(){
		global $_W;
		include wl_template('dashboard/sort');
	}
}
