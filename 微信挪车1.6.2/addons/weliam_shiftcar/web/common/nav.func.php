<?php
defined('IN_IA') or exit('Access Denied');

function _calc_current_frames2(&$frames) {
	global $_W,$_GPC;
	if(!empty($frames) && is_array($frames)) {
		foreach($frames as &$frame) {
			foreach($frame['items'] as &$fr) {
				if(count($fr['actions']) == 2){
					if(is_array($fr['actions']['1'])){
						$fr['active'] = in_array($_GPC[$fr['actions']['0']], $fr['actions']['1']) ? 'active' : '';
					}else{
						if($fr['actions']['1'] == $_GPC[$fr['actions']['0']]){
							$fr['active'] = 'active';
						}
					}
				}elseif(count($fr['actions']) == 3){
					if(($fr['actions']['1'] == $_GPC[$fr['actions']['0']] || @in_array($_GPC[$fr['actions']['0']], $fr['actions']['1'])) && ($fr['actions']['2'] == $_GPC['do'] || @in_array($_GPC['do'], $fr['actions']['2']))){
						$fr['active'] = 'active';
					}
				}elseif(count($fr['actions']) == 4){
					if(($fr['actions']['1'] == $_GPC[$fr['actions']['0']] || @in_array($_GPC[$fr['actions']['0']], $fr['actions']['1'])) && ($fr['actions']['3'] == $_GPC[$fr['actions']['2']] || @in_array($_GPC[$fr['actions']['2']], $fr['actions']['3']))){
						$fr['active'] = 'active';
					}
				}elseif(count($fr['actions']) == 5){
					if($fr['actions']['1'] == $_GPC[$fr['actions']['0']] && $fr['actions']['3'] == $_GPC[$fr['actions']['2']] && $fr['actions']['4'] ==$_GPC['status']){
						$fr['active'] = 'active';
					}
				}else{
					$query = parse_url($fr['url'], PHP_URL_QUERY);
					parse_str($query, $urls);
					if(defined('ACTIVE_FRAME_URL')) {
						$query = parse_url(ACTIVE_FRAME_URL, PHP_URL_QUERY);
						parse_str($query, $get);
					} else {
						$get = $_GET;
					}
					if(!empty($_GPC['a'])) {
						$get['a'] = $_GPC['a'];
					}
					if(!empty($_GPC['c'])) {
						$get['c'] = $_GPC['c'];
					}
					if(!empty($_GPC['do'])) {
						$get['do'] = $_GPC['do'];
					}
					if(!empty($_GPC['ac'])) {
						$get['ac'] = $_GPC['ac'];
					}
					if(!empty($_GPC['status'])) {
						$get['status'] = $_GPC['status'];
					}
					if(!empty($_GPC['op'])) {
						$get['op'] = $_GPC['op'];
					}
					if(!empty($_GPC['m'])) {
						$get['m'] = $_GPC['m'];
					}
					$diff = array_diff_assoc($urls, $get);
				
					if(empty($diff)) {
						$fr['active'] = 'active';
					}else{
						$fr['active'] = '';
					}
				}
			}
		}
	}
}

function getdashboardFrames(){
	$frames = array();
	return $frames;
}

function getsettingFrames(){
	global $_W,$_GPC;
	$frames = array();
	
	$frames['store']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 系统设置';
	$frames['store']['items'] = array();
	$frames['store']['items']['base']['url'] = web_url('setting/setting/base');
	$frames['store']['items']['base']['title'] = '基础设置';
	$frames['store']['items']['base']['actions'] = array();
	$frames['store']['items']['base']['active'] = '';
	
	$frames['store']['items']['share']['url'] = web_url('setting/setting/share');
	$frames['store']['items']['share']['title'] = '分享设置';
	$frames['store']['items']['share']['actions'] = array();
	$frames['store']['items']['share']['active'] = '';
	
	$frames['store']['items']['templat']['url'] = web_url('setting/setting/templat');
	$frames['store']['items']['templat']['title'] = '模板设置';
	$frames['store']['items']['templat']['actions'] = array();
	$frames['store']['items']['templat']['active'] = '';
	
	$frames['store']['items']['notice']['url'] = web_url('setting/setting/notice');
	$frames['store']['items']['notice']['title'] = '通知设置';
	$frames['store']['items']['notice']['actions'] = array();
	$frames['store']['items']['notice']['active'] = '';
	
	$frames['store']['items']['api']['url'] = web_url('setting/setting/api');
	$frames['store']['items']['api']['title'] = '接口设置';
	$frames['store']['items']['api']['actions'] = array();
	$frames['store']['items']['api']['active'] = '';
	
	$frames['store']['items']['veri']['url'] = web_url('setting/setting/veri');
	$frames['store']['items']['veri']['title'] = '验证设置';
	$frames['store']['items']['veri']['actions'] = array();
	$frames['store']['items']['veri']['active'] = '';
	
	$frames['store']['items']['hide']['url'] = web_url('setting/setting/hide');
	$frames['store']['items']['hide']['title'] = '躲罚单设置';
	$frames['store']['items']['hide']['actions'] = array();
	$frames['store']['items']['hide']['active'] = '';

	$frames['cover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口设置';
	$frames['cover']['items'] = array();
	$frames['cover']['items']['index']['url'] = web_url('setting/cover',array('ado' => 'index'));
	$frames['cover']['items']['index']['title'] = '首页入口';
	$frames['cover']['items']['index']['actions'] = array('ado','index');
	$frames['cover']['items']['index']['active'] = '';
	
	$frames['cover']['items']['hide']['url'] = web_url('setting/cover',array('ado' => 'hide'));
	$frames['cover']['items']['hide']['title'] = '躲罚单入口';
	$frames['cover']['items']['hide']['actions'] = array('ado','hide');
	$frames['cover']['items']['hide']['active'] = '';
	
	$frames['cover']['items']['record']['url'] = web_url('setting/cover',array('ado' => 'record'));
	$frames['cover']['items']['record']['title'] = '挪车记录入口';
	$frames['cover']['items']['record']['actions'] = array('ado','record');
	$frames['cover']['items']['record']['active'] = '';
	
	$frames['cover']['items']['member']['url'] = web_url('setting/cover',array('ado' => 'member'));
	$frames['cover']['items']['member']['title'] = '用户中心入口';
	$frames['cover']['items']['member']['actions'] = array('ado','member');
	$frames['cover']['items']['member']['active'] = '';
	
	$frames['cover']['items']['movecar']['url'] = web_url('setting/cover',array('ado' => 'movecar'));
	$frames['cover']['items']['movecar']['title'] = '车牌挪车入口';
	$frames['cover']['items']['movecar']['actions'] = array('ado','movecar');
	$frames['cover']['items']['movecar']['active'] = '';
	
	$frames['cover']['items']['code_movecar']['url'] = web_url('setting/cover',array('ado' => 'code_movecar'));
	$frames['cover']['items']['code_movecar']['title'] = '用户码挪车入口';
	$frames['cover']['items']['code_movecar']['actions'] = array('ado','code_movecar');
	$frames['cover']['items']['code_movecar']['active'] = '';
	
	$frames['cover']['items']['queue']['url'] = web_url('setting/cover',array('ado' => 'queue'));
	$frames['cover']['items']['queue']['title'] = '计划任务入口';
	$frames['cover']['items']['queue']['actions'] = array('ado','queue');
	$frames['cover']['items']['queue']['active'] = '';
	
	return $frames;
}

function getcardFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['summary']['title'] = '<i class="fa fa-list"></i>&nbsp;&nbsp; 概况';
	$frames['summary']['items'] = array();
	$frames['summary']['items']['summary']['url'] = web_url('card/qr/summary');
	$frames['summary']['items']['summary']['title'] = '挪车卡统计';
	$frames['summary']['items']['summary']['actions'] = array();
	$frames['summary']['items']['summary']['active'] = '';
	
	$frames['card']['title'] = '<i class="fa fa-list"></i>&nbsp;&nbsp; 挪车卡管理';
	$frames['card']['items'] = array();
	$frames['card']['items']['list']['url'] = web_url('card/qr/list');
	$frames['card']['items']['list']['title'] = '挪车卡列表';
	$frames['card']['items']['list']['actions'] = array();
	$frames['card']['items']['list']['active'] = '';
	
	$frames['card']['items']['post']['url'] = web_url('card/qr/post');
	$frames['card']['items']['post']['title'] = '生成挪车卡';
	$frames['card']['items']['post']['actions'] = array();
	$frames['card']['items']['post']['active'] = '';
	
	$frames['card']['items']['display']['url'] = web_url('card/qr/display');
	$frames['card']['items']['display']['title'] = '扫描记录';
	$frames['card']['items']['display']['actions'] = array();
	$frames['card']['items']['display']['active'] = '';
	
	$frames['setting']['title'] = '<i class="fa fa-list"></i>&nbsp;&nbsp; 挪车卡设置';
	$frames['setting']['items'] = array();
	$frames['setting']['items']['list']['url'] = web_url('card/setting/qrset');
	$frames['setting']['items']['list']['title'] = '挪车卡设置';
	$frames['setting']['items']['list']['actions'] = array();
	$frames['setting']['items']['list']['active'] = '';
	
	$frames['setting']['items']['dosalt']['url'] = web_url('card/qr/dosalt');
	$frames['setting']['items']['dosalt']['title'] = '挪车卡处理';
	$frames['setting']['items']['dosalt']['actions'] = array();
	$frames['setting']['items']['dosalt']['active'] = '';
	
	$frames['setting']['items']['remark']['url'] = web_url('card/qr/remark');
	$frames['setting']['items']['remark']['title'] = '备注修改';
	$frames['setting']['items']['remark']['actions'] = array();
	$frames['setting']['items']['remark']['active'] = '';
	
	return $frames;
}

function getmemberFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['member']['title'] = '<i class="fa fa-user"></i>&nbsp;&nbsp; 会员管理';
	$frames['member']['items'] = array();

	$frames['member']['items']['summary']['url'] = web_url('member/member/summary');
	$frames['member']['items']['summary']['title'] = '会员概况';
	$frames['member']['items']['summary']['actions'] = array();
	$frames['member']['items']['summary']['active'] = '';

	$frames['member']['items']['display']['url'] = web_url('member/member/display');
	$frames['member']['items']['display']['title'] = '会员列表';
	$frames['member']['items']['display']['actions'] = array();
	$frames['member']['items']['display']['active'] = '';
	
	return $frames;
}

function getappFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['application']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 管理应用';
	$frames['application']['items'] = array();

	$frames['application']['items']['list']['url'] = web_url('app/plugins/list');
	$frames['application']['items']['list']['title'] = '所有应用';
	$frames['application']['items']['list']['actions'] = array();
	$frames['application']['items']['list']['active'] = '';
	$frames['application']['items']['list']['append']['url'] = web_url('app/plugins/list');
	$frames['application']['items']['list']['append']['title'] = '<i class="fa fa-plus"></i>';
	
	if($_GPC['ac'] == 'plugins'){
		$frames['plugins']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 运营工具';
		$frames['plugins']['items'] = array();
		
		$frames['plugins']['items']['apply']['url'] = web_url('app/apply/list');
		$frames['plugins']['items']['apply']['title'] = '挪车卡发放';
		$frames['plugins']['items']['apply']['actions'] = array();
		$frames['plugins']['items']['apply']['active'] = '';
		
		$frames['plugins']['items']['pecc']['url'] = web_url('app/pecc/display');
		$frames['plugins']['items']['pecc']['title'] = '违章提醒';
		$frames['plugins']['items']['pecc']['actions'] = array();
		$frames['plugins']['items']['pecc']['active'] = '';
		
		$frames['plugins']['items']['limitline']['url'] = web_url('app/limitline/display');
		$frames['plugins']['items']['limitline']['title'] = '限行提醒';
		$frames['plugins']['items']['limitline']['actions'] = array();
		$frames['plugins']['items']['limitline']['active'] = '';
		
		$frames['plugins']['items']['advertisement']['url'] = web_url('app/advertisement/list');
		$frames['plugins']['items']['advertisement']['title'] = '广告系统';
		$frames['plugins']['items']['advertisement']['actions'] = array();
		$frames['plugins']['items']['advertisement']['active'] = '';

		$frames['plugins']['items']['distance']['url'] = web_url('app/distance/list');
		$frames['plugins']['items']['distance']['title'] = '商户管理';
		$frames['plugins']['items']['distance']['actions'] = array();
		$frames['plugins']['items']['distance']['active'] = '';
		
		$frames['help']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 帮助反馈';
		$frames['help']['items'] = array();
		
		$frames['help']['items']['help']['url'] = web_url('app/help/answer_list');
		$frames['help']['items']['help']['title'] = '帮助中心';
		$frames['help']['items']['help']['actions'] = array();
		$frames['help']['items']['help']['active'] = '';
		
		$frames['help']['items']['sug']['url'] = web_url('app/sug');
		$frames['help']['items']['sug']['title'] = '意见反馈';
		$frames['help']['items']['sug']['actions'] = array();
		$frames['help']['items']['sug']['active'] = '';
	
		$frames['system']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 系统工具';
		$frames['system']['items'] = array();
		
		$frames['system']['items']['sms']['url'] = web_url('app/sms/display');
		$frames['system']['items']['sms']['title'] = '自定义短信';
		$frames['system']['items']['sms']['actions'] = array();
		$frames['system']['items']['sms']['active'] = '';
	}
	
	if($_GPC['ac'] == 'pecc'){
		$frames['apply']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 违章管理';
		$frames['apply']['items'] = array();
		$frames['apply']['items']['list']['url'] = web_url('app/pecc/display');
		$frames['apply']['items']['list']['title'] = '违章记录';
		$frames['apply']['items']['list']['actions'] = array();
		$frames['apply']['items']['list']['active'] = '';
		
		$frames['setting']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 违章设置';
		$frames['setting']['items'] = array();
		$frames['setting']['items']['list']['url'] = web_url('app/pecc/setting');
		$frames['setting']['items']['list']['title'] = '违章设置';
		$frames['setting']['items']['list']['actions'] = array();
		$frames['setting']['items']['list']['active'] = '';
		
		$frames['setting']['items']['cover']['url'] = web_url('app/pecc/cover');
		$frames['setting']['items']['cover']['title'] = '入口设置';
		$frames['setting']['items']['cover']['actions'] = array();
		$frames['setting']['items']['cover']['active'] = '';
	}
	
	if($_GPC['ac'] == 'limitline'){
		$frames['limitline']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 限行条件';
		$frames['limitline']['items'] = array();
		$frames['limitline']['items']['list']['url'] = web_url('app/limitline/display');
		$frames['limitline']['items']['list']['title'] = '限行模板';
		$frames['limitline']['items']['list']['actions'] = array();
		$frames['limitline']['items']['list']['active'] = '';
		
		$frames['limitline']['items']['send']['url'] = web_url('app/limitline/post');
		$frames['limitline']['items']['send']['title'] = '添加模板';
		$frames['limitline']['items']['send']['actions'] = array();
		$frames['limitline']['items']['send']['active'] = '';
		
		$frames['setting']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 限行设置';
		$frames['setting']['items'] = array();
		$frames['setting']['items']['list']['url'] = web_url('app/limitline/setting');
		$frames['setting']['items']['list']['title'] = '限行设置';
		$frames['setting']['items']['list']['actions'] = array();
		$frames['setting']['items']['list']['active'] = '';
		
		$frames['setting']['items']['sync']['url'] = web_url('app/limitline/sync');
		$frames['setting']['items']['sync']['title'] = '同步模板';
		$frames['setting']['items']['sync']['actions'] = array();
		$frames['setting']['items']['sync']['active'] = '';
	}
	
	if($_GPC['ac'] == 'apply'){
		$frames['apply']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 挪车卡发放';
		$frames['apply']['items'] = array();
		$frames['apply']['items']['list']['url'] = web_url('app/apply/list');
		$frames['apply']['items']['list']['title'] = '申请列表';
		$frames['apply']['items']['list']['actions'] = array();
		$frames['apply']['items']['list']['active'] = '';
		
		$frames['apply']['items']['send']['url'] = web_url('app/apply/send');
		$frames['apply']['items']['send']['title'] = '批量发货';
		$frames['apply']['items']['send']['actions'] = array();
		$frames['apply']['items']['send']['active'] = '';
		
		$frames['setting']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 发放设置';
		$frames['setting']['items'] = array();
		$frames['setting']['items']['list']['url'] = web_url('app/apply/setting');
		$frames['setting']['items']['list']['title'] = '申请设置';
		$frames['setting']['items']['list']['actions'] = array();
		$frames['setting']['items']['list']['active'] = '';
		
		$frames['setting']['items']['cover']['url'] = web_url('app/apply/cover');
		$frames['setting']['items']['cover']['title'] = '入口设置';
		$frames['setting']['items']['cover']['actions'] = array();
		$frames['setting']['items']['cover']['active'] = '';
	}
	
	if($_GPC['ac'] == 'help'){
		$frames['help']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 帮助中心';
		$frames['help']['items'] = array();
		$frames['help']['items']['list']['url'] = web_url('app/help/category_list');
		$frames['help']['items']['list']['title'] = '帮助分类';
		$frames['help']['items']['list']['actions'] = array();
		$frames['help']['items']['list']['active'] = '';
		
		$frames['help']['items']['send']['url'] = web_url('app/help/answer_list');
		$frames['help']['items']['send']['title'] = '答疑列表';
		$frames['help']['items']['send']['actions'] = array();
		$frames['help']['items']['send']['active'] = '';
	}
	
	if($_GPC['ac'] == 'sms'){
		$frames['sms']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 自定义短信';
		$frames['sms']['items'] = array();
		$frames['sms']['items']['list']['url'] = web_url('app/sms/display');
		$frames['sms']['items']['list']['title'] = '短信模板';
		$frames['sms']['items']['list']['actions'] = array();
		$frames['sms']['items']['list']['active'] = '';
		
		$frames['sms']['items']['send']['url'] = web_url('app/sms/post');
		$frames['sms']['items']['send']['title'] = '添加模板';
		$frames['sms']['items']['send']['actions'] = array();
		$frames['sms']['items']['send']['active'] = '';
		
		$frames['setting']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 短信设置';
		$frames['setting']['items'] = array();
		$frames['setting']['items']['list']['url'] = web_url('app/sms/setting');
		$frames['setting']['items']['list']['title'] = '短信设置';
		$frames['setting']['items']['list']['actions'] = array();
		$frames['setting']['items']['list']['active'] = '';
	}
	
	if($_GPC['ac'] == 'sug'){
		$frames['sug']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 意见反馈';
		$frames['sug']['items'] = array();
		$frames['sug']['items']['list']['url'] = web_url('app/sug');
		$frames['sug']['items']['list']['title'] = '反馈列表';
		$frames['sug']['items']['list']['actions'] = array();
		$frames['sug']['items']['list']['active'] = '';
	}
	
	if($_GPC['ac'] == 'advertisement'){
		$frames['advertisement']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 广告设置';
		$frames['advertisement']['items'] = array();
		
		$frames['advertisement']['items']['list']['url'] = web_url('app/advertisement/list');
		$frames['advertisement']['items']['list']['title'] = '模板列表';
		$frames['advertisement']['items']['list']['actions'] = array();
		$frames['advertisement']['items']['list']['active'] = '';
		
		$frames['advertisement']['items']['post']['url'] = web_url('app/advertisement/post');
		$frames['advertisement']['items']['post']['title'] = '广告添加';
		$frames['advertisement']['items']['post']['actions'] = array();
		$frames['advertisement']['items']['post']['active'] = '';
	}
	
	if($_GPC['ac'] == 'distance'){
		$frames['distance']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 周边商户';
		$frames['distance']['items'] = array();
		
		$frames['distance']['items']['list']['url'] = web_url('app/distance/list');
		$frames['distance']['items']['list']['title'] = '商户列表';
		$frames['distance']['items']['list']['actions'] = array();
		$frames['distance']['items']['list']['active'] = '';
		
		$frames['setting']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 商户设置';
		$frames['setting']['items'] = array();
		$frames['setting']['items']['cover']['url'] = web_url('app/distance/cover');
		$frames['setting']['items']['cover']['title'] = '会员卡入口';
		$frames['setting']['items']['cover']['actions'] = array();
		$frames['setting']['items']['cover']['active'] = '';
		
		$frames['setting']['items']['setting']['url'] = web_url('app/distance/setting');
		$frames['setting']['items']['setting']['title'] = '商户设置';
		$frames['setting']['items']['setting']['actions'] = array();
		$frames['setting']['items']['setting']['active'] = '';
	}

	return $frames;
}

function getdataFrames(){
	global $_W,$_GPC;
	$frames = array();
//	$frames['data']['title'] = '<i class="fa fa-pie-chart"></i>&nbsp;&nbsp; 数据统计';
//	$frames['data']['items'] = array();
//
//	$frames['data']['items']['dashboard']['url'] = web_url('data/dashboard');
//	$frames['data']['items']['dashboard']['title'] = '数据概况';
//	$frames['data']['items']['dashboard']['actions'] = array();
//	$frames['data']['items']['dashboard']['active'] = '';
	
	$frames['record']['title'] = '<i class="fa fa-history"></i>&nbsp;&nbsp; 系统记录';
	$frames['record']['items'] = array();
	
	$frames['record']['items']['summary']['url'] = web_url('data/summary');
	$frames['record']['items']['summary']['title'] = '记录概况';
	$frames['record']['items']['summary']['actions'] = array();
	$frames['record']['items']['summary']['active'] = '';
	
	$frames['record']['items']['movecar']['url'] = web_url('data/movecar');
	$frames['record']['items']['movecar']['title'] = '挪车记录';
	$frames['record']['items']['movecar']['actions'] = array();
	$frames['record']['items']['movecar']['active'] = '';
	
	$frames['record']['items']['api']['url'] = web_url('data/api');
	$frames['record']['items']['api']['title'] = 'API记录';
	$frames['record']['items']['api']['actions'] = array();
	$frames['record']['items']['api']['active'] = '';
	
	return $frames;
}

function getsystemFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['member']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 云服务';
	$frames['member']['items'] = array();

	$frames['member']['items']['setting']['url'] = web_url('system/auth/display');
	$frames['member']['items']['setting']['title'] = '系统授权';
	$frames['member']['items']['setting']['actions'] = array();
	$frames['member']['items']['setting']['active'] = '';

//	$frames['member']['items']['display']['url'] = web_url('system/auth/upgrade');
//	$frames['member']['items']['display']['title'] = '系统更新';
//	$frames['member']['items']['display']['actions'] = array();
//	$frames['member']['items']['display']['active'] = '';
	
	$frames['account']['title'] = '<i class="fa fa-comments"></i>&nbsp;&nbsp; 公众号管理';
	$frames['account']['items'] = array();

	$frames['account']['items']['add']['url'] = web_url('system/account/display');
	$frames['account']['items']['add']['title'] = '添加公众号';
	$frames['account']['items']['add']['actions'] = array();
	$frames['account']['items']['add']['active'] = '';

	$frames['account']['items']['display']['url'] = web_url('system/account/list');
	$frames['account']['items']['display']['title'] = '公众号列表';
	$frames['account']['items']['display']['actions'] = array();
	$frames['account']['items']['display']['active'] = '';
	
	$frames['database']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 数据管理';
	$frames['database']['items'] = array();
	
	$frames['database']['items']['repair']['url'] = web_url('system/database/repair');
	$frames['database']['items']['repair']['title'] = '修复数据';
	$frames['database']['items']['repair']['actions'] = array();
	$frames['database']['items']['repair']['active'] = '';

	$frames['database']['items']['run']['url'] = web_url('system/database/run');
	$frames['database']['items']['run']['title'] = '运行SQL';
	$frames['database']['items']['run']['actions'] = array();
	$frames['database']['items']['run']['active'] = '';
	
	$frames['database']['items']['import']['url'] = web_url('system/database/import');
	$frames['database']['items']['import']['title'] = '数据管理';
	$frames['database']['items']['import']['actions'] = array();
	$frames['database']['items']['import']['active'] = '';

	$frames['database']['items']['addcarinfo']['url'] = web_url('system/database/addcarinfo');
	$frames['database']['items']['addcarinfo']['title'] = '车辆信息';
	$frames['database']['items']['addcarinfo']['actions'] = array();
	$frames['database']['items']['addcarinfo']['active'] = '';
	return $frames;
}

function get_top_menus(){
	global $_W;
	$frames = array();
	$appact = Util::traversingFiles(PATH_PLUGIN);
	$appact[] = 'app';
		
	$frames['dashboard']['title'] = '<i class="fa fa-desktop"></i>&nbsp;&nbsp; 概况';
	$frames['dashboard']['url'] = web_url('dashboard/index');
	$frames['dashboard']['active'] = 'dashboard';
	
	$frames['member']['title'] = '<i class="fa fa-user"></i>&nbsp;&nbsp; 会员';
	$frames['member']['url'] = web_url('member/member/summary');
	$frames['member']['active'] = 'member';
	
	$frames['card']['title'] = '<i class="fa fa-qrcode"></i>&nbsp;&nbsp; 挪车卡';
	$frames['card']['url'] = web_url('card/qr/summary');
	$frames['card']['active'] = 'card';
	
	$frames['data']['title'] = '<i class="fa fa-area-chart"></i>&nbsp;&nbsp; 数据';
	$frames['data']['url'] = web_url('data/summary');
	$frames['data']['active'] = 'data';
	
	$frames['apps']['title'] = '<i class="fa fa-cubes"></i>&nbsp;&nbsp; 应用';
	$frames['apps']['url'] = web_url('app/plugins/list');
	$frames['apps']['active'] = $appact;
	
	$frames['setting']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 设置';
	$frames['setting']['url'] = web_url('setting/setting/base');
	$frames['setting']['active'] = 'setting';
	
	if($_W['isfounder']){
		$frames['system']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 云服务';
		$frames['system']['url'] = web_url('system/auth/display');
		$frames['system']['active'] = 'system';
	}
	
	return $frames;
}
