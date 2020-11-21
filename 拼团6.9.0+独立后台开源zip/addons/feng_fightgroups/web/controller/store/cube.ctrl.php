<?php
load()->func('tpl');
wl_load()->model('setting');

$ops = array('display');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	$cubes = tgsetting_read('cube');
	if(empty($cubes)){
		$cubes = array(array(''),array(''),array(''),array(''),array(''),array(''));
	}
	
	if (checksubmit('submit')) {
		$cubes_thumbs = $_GPC['cubes_thumbs'];
		$cubes_links = $_GPC['cubes_links'];
		$checkbox = $_GPC['on'];
		
		$new_arr = array();
		for($i=0;$i<6;$i++){
			$new_arr[$i]['thumb'] = $cubes_thumbs[$i];
			$new_arr[$i]['link'] = $cubes_links[$i];
			if(in_array($i, $checkbox)){
				$new_arr[$i]['on']=1;
			}else{
				$new_arr[$i]['on']=0;
			}
		}
		
		tgsetting_save($new_arr,'cube');
		message('更新成功！', web_url('store/cube', array('op' => 'display')), 'success');
	}
}

include wl_template('store/cube');
