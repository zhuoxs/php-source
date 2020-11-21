<?php
/**
 * boguan_mall模块小程序接口定义
 *
 * @author 阿莫源码社区
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');

class Boguan_mallModuleWxapp extends WeModuleWxapp {
	public function doPageTest(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '返回消息';
		$data = array();
		return $this->result($errno, $message, $data);
	}
}