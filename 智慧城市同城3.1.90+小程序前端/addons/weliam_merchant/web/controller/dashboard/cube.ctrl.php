<?php
defined('IN_IA') or exit('Access Denied');

class Cube_WeliamController{
	/*
	 * 查看排版
	 */
	public function index(){
		global $_W;
		$cubes = Dashboard::readSetting('cube');
		if(empty($cubes)) $cubes = array(array(''),array(''),array(''),array(''),array(''),array(''));
		include wl_template('dashboard/cube');
	}
	
	/*
	 * 保存排版
	 */
	public function save(){
		global $_W,$_GPC;
		$cubes_thumbs = $_GPC['cubes_thumbs'];
		$cubes_links = $_GPC['cubes_links'];
		$checkbox = $_GPC['on'];
		$new_arr = array();
		for($i=0;$i<6;$i++){
			$new_arr[$i]['thumb'] = $cubes_thumbs[$i];
			$new_arr[$i]['link'] = trim($cubes_links[$i]);
			if(!empty($checkbox) && in_array($i, $checkbox)){
				$new_arr[$i]['on']=1;
			}else{
				$new_arr[$i]['on']=0;
			}
		}
		Dashboard::saveSetting($new_arr, 'cube');
		wl_message('保存成功',web_url('dashboard/cube/index'),'success');
	}
}
