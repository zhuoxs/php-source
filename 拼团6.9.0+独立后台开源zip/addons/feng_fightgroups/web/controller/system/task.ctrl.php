<?php
	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	wl_load()->model('syssetting');
	load()->func('communication');
	if($op == 'display'){
		$domain = $_W['siteroot']; 
		$siteid = $_W['setting']['site']['key'];
		$resp = ihttp_request('http://weixin.weliam.cn/addons/weliam_manage/api.php', array('type' => 'get_task','module' => 'feng_fightgroups'),null,1);
		$resp = @json_decode($resp['content'], true);
		$task_status = $resp['result'];
		if(checksubmit('submit')){
			$task_status = !empty($_GPC['task_status'])?1:2;
			$request = app_url("home/auto_task");
			$resp = ihttp_request('http://weixin.weliam.cn/addons/weliam_manage/api.php', array('type' => 'task','module' => 'feng_fightgroups','website' => $siteid,'status'=>$task_status,'request'=>$request),null,1);
			$resp = @json_decode($resp['content'], true);
			if($resp['result']==1){
				message("计划任务更改成功",web_url("system/task/display"),'success');
			}else{
				message("拼团未授权,计划任务更改失败",web_url("system/task/display"),'fail');
			}
		}
	}
	if($op == 'list'){
		$domain = $_SERVER['SERVER_NAME']; 
		$siteid = $_W['setting']['site']['key'];
		$message['status']=tg_syssetting_read('task');
		if(checksubmit('submit')){
			$data = $_GPC['m_status'];
			tg_syssetting_save($data,'task');
			message("保存成功",web_url("system/task/list"),'success');
		}
		
	}
	include wl_template('system/task');