<?php
defined('IN_IA') or exit('Access Denied');

function _calc_current_frames2(&$frames) {
	global $_W,$_GPC;
	if(!empty($frames) && is_array($frames)) {
		foreach($frames as &$frame) {
			foreach($frame['items'] as &$fr) {
				if(count($fr['actions']) == 2){
					if($fr['actions']['1'] == $_GPC[$fr['actions']['0']]){
						$fr['active'] = 'active';
					}
				}elseif(count($fr['actions']) == 4){
					if($fr['actions']['1'] == $_GPC[$fr['actions']['0']] && $fr['actions']['3'] == $_GPC[$fr['actions']['2']]){
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
					if(!empty($_GPC['orderType'])) {
						$get['orderType'] = $_GPC['orderType'];
					}
					if(!empty($_GPC['g_type'])) {
						$get['g_type'] = $_GPC['g_type'];
					}
					if(!empty($_GPC['is_hexiao'])) {
						$get['is_hexiao'] = $_GPC['is_hexiao'];
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

//后台管理列表生成
function getstoreFrames(){
	global $_W,$_GPC;
	$frames = array();
	if(TG_ID){
		$frames['store']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 店铺';
		$frames['store']['items']['setting']['url'] = web_url('store/setting');
		$frames['store']['items']['setting']['title'] = '店铺设置';
		$frames['store']['items']['setting']['actions'] = array();
		$frames['store']['items']['setting']['active'] = '';
	}else{
		$frames['store']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 商城管理';
		$frames['store']['items'] = array();
		$frames['store']['items']['setting']['url'] = web_url('store/setting/display');
		$frames['store']['items']['setting']['title'] = '系统设置';
		$frames['store']['items']['setting']['actions'] = array();
		$frames['store']['items']['setting']['active'] = '';
		
		$frames['cache']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 缓存';
		$frames['cache']['items'] = array();
		$frames['cache']['items']['cache']['url'] = web_url('store/setting/cache');
		$frames['cache']['items']['cache']['title'] = '更新缓存';
		$frames['cache']['items']['cache']['actions'] = array();
		$frames['cache']['items']['cache']['active'] = '';
		
		$frames['cover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口设置';
		$frames['cover']['items'] = array();
		$frames['cover']['items']['index']['url'] = web_url('store/cover',array('ado' => 'index'));
		$frames['cover']['items']['index']['title'] = '首页入口';
		$frames['cover']['items']['index']['actions'] = array('ado','index');
		$frames['cover']['items']['index']['active'] = '';
		
		$frames['cover']['items']['group']['url'] = web_url('store/cover',array('ado' => 'group'));
		$frames['cover']['items']['group']['title'] = '我的团入口';
		$frames['cover']['items']['group']['actions'] = array('ado','group');
		$frames['cover']['items']['group']['active'] = '';
		
		$frames['cover']['items']['order']['url'] = web_url('store/cover',array('ado' => 'order'));
		$frames['cover']['items']['order']['title'] = '我的订单入口';
		$frames['cover']['items']['order']['actions'] = array('ado','order');
		$frames['cover']['items']['order']['active'] = '';
		
		$frames['cover']['items']['member']['url'] = web_url('store/cover',array('ado' => 'member'));
		$frames['cover']['items']['member']['title'] = '个人中心入口';
		$frames['cover']['items']['member']['actions'] = array('ado','member');
		$frames['cover']['items']['member']['active'] = '';
	
		$frames['page']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 主页管理';
		$frames['page']['items'] = array();
		$frames['page']['items']['notice']['url'] = web_url('store/notice/display');
		$frames['page']['items']['notice']['title'] = '公告';
		$frames['page']['items']['notice']['actions'] = array('ac','notice');
		$frames['page']['items']['notice']['active'] = '';
		
		$frames['page']['items']['adv']['url'] = web_url('store/adv/display');
		$frames['page']['items']['adv']['title'] = '幻灯片';
		$frames['page']['items']['adv']['actions'] = array('ac','adv');
		$frames['page']['items']['adv']['active'] = '';
		
		$frames['page']['items']['nav']['url'] = web_url('store/nav/display');
		$frames['page']['items']['nav']['title'] = '导航栏';
		$frames['page']['items']['nav']['actions'] = array('ac','nav');
		$frames['page']['items']['nav']['active'] = '';
		
		$frames['page']['items']['banner']['url'] = web_url('store/banner/display');
		$frames['page']['items']['banner']['title'] = '广告栏';
		$frames['page']['items']['banner']['actions'] = array('ac','banner');
		$frames['page']['items']['banner']['active'] = '';
		
		$frames['page']['items']['cube']['url'] = web_url('store/cube/display');
		$frames['page']['items']['cube']['title'] = '商品魔方';
		$frames['page']['items']['cube']['actions'] = array('ac','cube');
		$frames['page']['items']['cube']['active'] = '';
		
		$frames['page']['items']['home']['url'] = web_url('store/home/display');
		$frames['page']['items']['home']['title'] = '主页排版';
		$frames['page']['items']['home']['actions'] = array();
		$frames['page']['items']['home']['active'] = '';
		
		$frames['page']['items']['footerbar']['url'] = web_url('store/footerbar/display');
		$frames['page']['items']['footerbar']['title'] = '脚部栏';
		$frames['page']['items']['footerbar']['actions'] = array('ac','footerbar');
		$frames['page']['items']['footerbar']['active'] = '';
	}
	return $frames;
}

function getgoodsFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['goods']['title'] = '<i class="fa fa-gift"></i>&nbsp;&nbsp; 商品管理';
	$frames['goods']['items'] = array();
	$frames['goods']['items']['display1']['url'] = web_url('goods/goods/display',array('status' => '1'));
	$frames['goods']['items']['display1']['title'] = '拼团商品';
	$frames['goods']['items']['display1']['actions'] = array();
	$frames['goods']['items']['display1']['active'] = '';
	if(!TG_ID){
		$frames['goods']['items']['display3']['url'] = web_url('goods/goods/display',array('g_type' => '3'));
		$frames['goods']['items']['display3']['title'] = '抽奖商品';
		$frames['goods']['items']['display3']['actions'] = array();
		$frames['goods']['items']['display3']['active'] = '';
		
		$frames['goods']['items']['display2']['url'] = web_url('goods/goods/display',array('g_type' => '2'));
		$frames['goods']['items']['display2']['title'] = '赠送商品';
		$frames['goods']['items']['display2']['actions'] = array();
		$frames['goods']['items']['display2']['active'] = '';
	}
	$frames['goods']['items']['display4']['url'] = web_url('goods/goods/display',array('status' => '4'));
	$frames['goods']['items']['display4']['title'] = '商品回收';
	$frames['goods']['items']['display4']['actions'] = array();
	$frames['goods']['items']['display4']['active'] = '';
	
	$frames['goods']['items']['post']['url'] = web_url('goods/goods/post');
	$frames['goods']['items']['post']['title'] = '发布商品';
	$frames['goods']['items']['post']['actions'] = array();
	$frames['goods']['items']['post']['active'] = '';
	if(!TG_ID){
		$frames['other']['title'] = '<i class="fa fa-bookmark"></i>&nbsp;&nbsp; 其他管理';
		$frames['other']['items'] = array();
		$frames['other']['items']['category']['url'] = web_url('goods/category/display');
		$frames['other']['items']['category']['title'] = '商品分类';
		$frames['other']['items']['category']['actions'] = array('ac','category');
		$frames['other']['items']['category']['active'] = '';
		
		$frames['other']['items']['setting']['url'] = web_url('goods/setting/cate');
		$frames['other']['items']['setting']['title'] = '分类设置';
		$frames['other']['items']['setting']['actions'] = array('ac','setting');
		$frames['other']['items']['setting']['active'] = '';
	}
	$frames['comment']['title'] = '<i class="fa fa-bookmark"></i>&nbsp;&nbsp; 评价管理';
	$frames['comment']['items'] = array();
	$frames['comment']['items']['comment1']['url'] = web_url('goods/comment/display',array('status'=>1));
	$frames['comment']['items']['comment1']['title'] = '待处理';
	$frames['comment']['items']['comment1']['actions'] = array();
	$frames['comment']['items']['comment1']['active'] = '';
	
	$frames['comment']['items']['comment2']['url'] = web_url('goods/comment/display',array('status'=>2));
	$frames['comment']['items']['comment2']['title'] = '已通过';
	$frames['comment']['items']['comment2']['actions'] = array();
	$frames['comment']['items']['comment2']['active'] = '';
	
	$frames['comment']['items']['comment3']['url'] = web_url('goods/comment/display',array('status'=>3));
	$frames['comment']['items']['comment3']['title'] = '未通过';
	$frames['comment']['items']['comment3']['actions'] = array();
	$frames['comment']['items']['comment3']['active'] = '';
	
	return $frames;
}

function getorderFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['order']['title'] = '<i class="fa fa-list"></i>&nbsp;&nbsp; 订单管理';
	$frames['order']['items'] = array();
	
	$frames['order']['items']['summary']['url'] = web_url('order/order/summary');
	$frames['order']['items']['summary']['title'] = '订单概况';
	$frames['order']['items']['summary']['actions'] = array();
	$frames['order']['items']['summary']['active'] = '';
	
	$frames['order']['items']['display1']['url'] = web_url('order/order/received',array('orderType' => 'received'));
	$frames['order']['items']['display1']['title'] = '快递订单';
	$frames['order']['items']['display1']['actions'] = array();
	$frames['order']['items']['display1']['active'] = '';
	$frames['order']['items']['display1']['append']['url'] = web_url('order/order/received',array('orderType' => 'received'));

	$frames['order']['items']['display2']['url'] = web_url('order/order/received',array('orderType' => 'fetch'));
	$frames['order']['items']['display2']['title'] = '自提订单';
	$frames['order']['items']['display2']['actions'] = array();
	$frames['order']['items']['display2']['active'] = '';

	$frames['group']['title'] = '<i class="fa fa-users"></i>&nbsp;&nbsp; 团购管理';
	$frames['group']['items'] = array();
	$frames['group']['items']['all']['url'] = web_url('order/group/all');
	$frames['group']['items']['all']['title'] = '全部团购';
	$frames['group']['items']['all']['actions'] = array('groupstatus','','ac','group');
	$frames['group']['items']['all']['active'] = '';

	$frames['group']['items']['ongoing']['url'] = web_url('order/group/all',array('groupstatus' => '3'));
	$frames['group']['items']['ongoing']['title'] = '团购中';
	$frames['group']['items']['ongoing']['actions'] = array('groupstatus','3');
	$frames['group']['items']['ongoing']['active'] = '';
	
	$frames['group']['items']['success']['url'] = web_url('order/group/all',array('groupstatus' => '2'));
	$frames['group']['items']['success']['title'] = '团购成功';
	$frames['group']['items']['success']['actions'] = array('groupstatus','2');
	$frames['group']['items']['success']['active'] = '';
	
	$frames['group']['items']['fail']['url'] = web_url('order/group/all',array('groupstatus' => '1'));
	$frames['group']['items']['fail']['title'] = '团购失败';
	$frames['group']['items']['fail']['actions'] = array('groupstatus','1');
	$frames['group']['items']['fail']['active'] = '';
		
	$frames['delivery']['title'] = '<i class="fa fa-paper-plane"></i>&nbsp;&nbsp; 配送方式';
	$frames['delivery']['items'] = array();
	$frames['delivery']['items']['template']['url'] = web_url('order/delivery/display');
	$frames['delivery']['items']['template']['title'] = '运费模板';
	$frames['delivery']['items']['template']['actions'] = array('ac','delivery');
	$frames['delivery']['items']['template']['active'] = '';

	$frames['import']['title'] = '<i class="fa fa-truck"></i>&nbsp;&nbsp; 批量发货';
	$frames['import']['items'] = array();
	$frames['import']['items']['import']['url'] = web_url('order/import/display');
	$frames['import']['items']['import']['title'] = '发货';
	$frames['import']['items']['import']['actions'] = array('ac','import');
	$frames['import']['items']['import']['active'] = '';
	
	$frames['refund']['title'] = '<i class="fa fa-money"></i>&nbsp;&nbsp; 批量退款';
	$frames['refund']['items'] = array();
	$frames['refund']['items']['refund']['url'] = web_url('order/refund/display');
	$frames['refund']['items']['refund']['title'] = '退款';
	$frames['refund']['items']['refund']['actions'] = array();
	$frames['refund']['items']['refund']['active'] = '';

	return $frames;
}

function getmemberFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['member']['title'] = '<i class="fa fa-user"></i>&nbsp;&nbsp; 会员管理';
	$frames['member']['items'] = array();

	$frames['member']['items']['setting']['url'] = web_url('member/member/setting');
	$frames['member']['items']['setting']['title'] = '设置';
	$frames['member']['items']['setting']['actions'] = array();
	$frames['member']['items']['setting']['active'] = '';
	$frames['member']['items']['setting']['append']['url'] = web_url('member/member/setting');

	$frames['member']['items']['display']['url'] = web_url('member/member/display');
	$frames['member']['items']['display']['title'] = '会员管理';
	$frames['member']['items']['display']['actions'] = array();
	$frames['member']['items']['display']['active'] = '';
	
	return $frames;
}

function getapplicationFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['application']['title'] = '<i class="fa fa-cubes"></i>&nbsp;&nbsp; 管理应用';
	$frames['application']['items'] = array();
	if(!TG_ID){
		$frames['application']['items']['list']['url'] = web_url('application/plugins/list');
		$frames['application']['items']['list']['title'] = '应用插件';
		$frames['application']['items']['list']['actions'] = array();
		$frames['application']['items']['list']['active'] = '';
		$frames['application']['items']['list']['append']['url'] = web_url('application/plugins/list');
		$frames['application']['items']['list']['append']['title'] = '<i class="fa fa-plus"></i>';
	}
	
	if($_GPC['ac'] == 'plugins'){
		$frames['base']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 促销工具';
		$frames['base']['items'] = array();
		$frames['base']['items']['ladder']['url'] = web_url('application/ladder/list');
		$frames['base']['items']['ladder']['title'] = '阶梯团';
		$frames['base']['items']['ladder']['actions'] = array('ac','ladder');
		$frames['base']['items']['ladder']['active'] = '';
		if(!TG_ID){
		$frames['base']['items']['lottery']['url'] = web_url('application/lottery/list');
		$frames['base']['items']['lottery']['title'] = '抽奖团';
		$frames['base']['items']['lottery']['actions'] = array();
		$frames['base']['items']['lottery']['active'] = '';
		
		$frames['base']['items']['activity']['url'] = web_url('application/activity/list');
		$frames['base']['items']['activity']['title'] = '优惠券';
		$frames['base']['items']['activity']['actions'] = array('ac','activity');
		$frames['base']['items']['activity']['active'] = '';
		
		$frames['base']['items']['special']['url'] = web_url('application/special/list');
		$frames['base']['items']['special']['title'] = '拼团有礼';
		$frames['base']['items']['special']['actions'] = array();
		$frames['base']['items']['special']['active'] = '';
		}
		$frames['merchant1']['title'] = '<i class="fa fa-archive"></i>&nbsp;&nbsp; 店铺扩展';
		$frames['merchant1']['items'] = array();
		$frames['merchant1']['items']['bdelete']['url'] = web_url('application/bdelete/hx_entry');
		$frames['merchant1']['items']['bdelete']['title'] = '线下核销';
		$frames['merchant1']['items']['bdelete']['actions'] = array('ac','bdelete');
		$frames['merchant1']['items']['bdelete']['active'] = '';
		if(!TG_ID){
		$frames['merchant1']['items']['merchantlist']['url'] = web_url('application/merchant/account_display',array('status' => '1'));
		$frames['merchant1']['items']['merchantlist']['title'] = '多商户';
		$frames['merchant1']['items']['merchantlist']['actions'] = array('op','account_display');
		$frames['merchant1']['items']['merchantlist']['active'] = '';
		
		$frames['marketing']['title'] = '<i class="fa fa-archive"></i>&nbsp;&nbsp; 互动营销';
		$frames['marketing']['items'] = array();
		$frames['marketing']['items']['helpbuy']['url'] = web_url('application/helpbuy/list');
		$frames['marketing']['items']['helpbuy']['title'] = '找人代付';
		$frames['marketing']['items']['helpbuy']['actions'] = array();
		$frames['marketing']['items']['helpbuy']['active'] = '';
		
//		$frames['marketing']['items']['distribution']['url'] = web_url('application/distribution/memberlist');
//		$frames['marketing']['items']['distribution']['title'] = '分销';
//		$frames['marketing']['items']['distribution']['actions'] = array();
//		$frames['marketing']['items']['distribution']['active'] = '';
		
//		$frames['merchant']['items']['merchantlist']['url'] = web_url('application/merchant/merchantAccount',array('status' => '1'));
//		$frames['merchant']['items']['merchantlist']['title'] = '商户中心';
//		$frames['merchant']['items']['merchantlist']['actions'] = array('op','merchantAccount');
//		$frames['merchant']['items']['merchantlist']['active'] = '';
		}
	}
	
	if($_GPC['ac'] == 'ladder'){
		$frames['base']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 阶梯团';
		$frames['base']['items'] = array();
		$frames['base']['items']['ladder']['url'] = web_url('application/ladder/list');
		$frames['base']['items']['ladder']['title'] = '阶梯团';
		$frames['base']['items']['ladder']['actions'] = array('ac','ladder');
		$frames['base']['items']['ladder']['active'] = '';
	}
	
	if($_GPC['ac'] == 'lottery'){
		$frames['base']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 抽奖团';
		$frames['base']['items'] = array();
		$frames['base']['items']['lottery']['url'] = web_url('application/lottery/list');
		$frames['base']['items']['lottery']['title'] = '抽奖团列表';
		$frames['base']['items']['lottery']['actions'] = array();
		$frames['base']['items']['lottery']['active'] = '';
		
		$frames['base']['items']['create']['url'] = web_url('application/lottery/create');
		$frames['base']['items']['create']['title'] = !empty($_GPC['id']) ? '编辑抽奖团' : '添加抽奖团';
		$frames['base']['items']['create']['actions'] = array();
		$frames['base']['items']['create']['active'] = '';
		
		$frames['setting']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口设置';
		$frames['setting']['items'] = array();
		$frames['setting']['items']['lottery']['url'] = web_url('application/lottery/cover');
		$frames['setting']['items']['lottery']['title'] = '抽奖团入口';
		$frames['setting']['items']['lottery']['actions'] = array();
		$frames['setting']['items']['lottery']['active'] = '';
		
		$frames['page']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 页面设置';
		$frames['page']['items'] = array();
		$frames['page']['items']['lottery']['url'] = web_url('application/lottery/page');
		$frames['page']['items']['lottery']['title'] = '抽奖团主题';
		$frames['page']['items']['lottery']['actions'] = array();
		$frames['page']['items']['lottery']['active'] = '';
	}
	
	if($_GPC['ac'] == 'activity'){
		$frames['base']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 优惠券';
		$frames['base']['items'] = array();
		$frames['base']['items']['activity']['url'] = web_url('application/activity/list');
		$frames['base']['items']['activity']['title'] = '优惠券';
		$frames['base']['items']['activity']['actions'] = array('ac','activity');
		$frames['base']['items']['activity']['active'] = '';
	}
	
	if($_GPC['ac'] == 'special'){
		$frames['base']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 拼团有礼';
		$frames['base']['items'] = array();
		$frames['base']['items']['special']['url'] = web_url('application/special/list');
		$frames['base']['items']['special']['title'] = '拼团有礼';
		$frames['base']['items']['special']['actions'] = array();
		$frames['base']['items']['special']['active'] = '';
	}
	
	if($_GPC['ac'] == 'gift'){
		$frames['base']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 赠品管理';
		$frames['base']['items'] = array();
		$frames['base']['items']['gift']['url'] = web_url('application/gift/list');
		$frames['base']['items']['gift']['title'] = '赠品';
		$frames['base']['items']['gift']['actions'] = array();
		$frames['base']['items']['gift']['active'] = '';
	}
	
	if($_GPC['ac'] == 'bdelete'){
		$frames['merchant']['title'] = '<i class="fa fa-archive"></i>&nbsp;&nbsp; 线下核销';
		$frames['merchant']['items'] = array();
		$frames['merchant']['items']['bdelete']['url'] = web_url('application/bdelete/hx_entry');
		$frames['merchant']['items']['bdelete']['title'] = '线下核销';
		$frames['merchant']['items']['bdelete']['actions'] = array('ac','bdelete');
		$frames['merchant']['items']['bdelete']['active'] = '';
	}
	
	if($_GPC['ac'] == 'merchant' && !MERCHANTID){
		$frames['merchant']['title'] = '<i class="fa fa-archive"></i>&nbsp;&nbsp; 多商户';
		$frames['merchant']['items'] = array();
//		$frames['merchant']['items']['merchantlist']['url'] = web_url('application/merchant/display',array('status' => '1'));
//		$frames['merchant']['items']['merchantlist']['title'] = '商家列表';
//		$frames['merchant']['items']['merchantlist']['actions'] = array('op','display');
//		$frames['merchant']['items']['merchantlist']['active'] = '';
		
		$frames['merchant']['items']['merchantcenter']['url'] = web_url('application/merchant/account_display',array('status' => '1'));
		$frames['merchant']['items']['merchantcenter']['title'] = '商家中心';
		$frames['merchant']['items']['merchantcenter']['actions'] = array();
		$frames['merchant']['items']['merchantcenter']['active'] = '';
		
		$frames['merchant']['items']['merchantcenteredit']['url'] = web_url('application/merchant/edit',array('status' => '1'));
		$frames['merchant']['items']['merchantcenteredit']['title'] = '添加商家';
		$frames['merchant']['items']['merchantcenteredit']['actions'] = array();
		$frames['merchant']['items']['merchantcenteredit']['active'] = '';
		
		$frames['merchantApply']['title'] = '<i class="fa fa-archive"></i>&nbsp;&nbsp; 提现申请';
		$frames['merchantApply']['items'] = array();
		$frames['merchantApply']['items']['cashConfirm']['url'] = web_url('application/merchant/merchantApply',array('status' => '1'));
		$frames['merchantApply']['items']['cashConfirm']['title'] = '待确认';
		$frames['merchantApply']['items']['cashConfirm']['actions'] = array();
		$frames['merchantApply']['items']['cashConfirm']['active'] = '';
		$frames['merchantApply']['items']['cashConfirm']['append']['url'] = web_url('application/merchant/merchantApply',array('status' => '1'));
		
		$frames['merchantApply']['items']['cashPay']['url'] = web_url('application/merchant/merchantApply',array('status' => '2'));
		$frames['merchantApply']['items']['cashPay']['title'] = '待打款';
		$frames['merchantApply']['items']['cashPay']['actions'] = array();
		$frames['merchantApply']['items']['cashPay']['active'] = '';
		$frames['merchantApply']['items']['cashPay']['append']['url'] = web_url('application/merchant/merchantApply',array('status' => '2'));
		
		$frames['merchantApply']['items']['cashFinish']['url'] = web_url('application/merchant/merchantApply',array('status' => '3'));
		$frames['merchantApply']['items']['cashFinish']['title'] = '已打款';
		$frames['merchantApply']['items']['cashFinish']['actions'] = array();
		$frames['merchantApply']['items']['cashFinish']['active'] = '';
		$frames['merchantApply']['items']['cashFinish']['append']['url'] = web_url('application/merchant/merchantApply',array('status' => '3'));
		
		$frames['cover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口设置';
		$frames['cover']['items'] = array();
		$frames['cover']['items']['index']['url'] = web_url('application/merchant/cover',array('type' => 'web'));
		$frames['cover']['items']['index']['title'] = '商家后台入口';
		$frames['cover']['items']['index']['actions'] = array();
		$frames['cover']['items']['index']['active'] = '';
		
		
		
	}
	if($_GPC['ac'] == 'merchant' && MERCHANTID){
		$frames['merchant']['items']['merchantlist']['url'] = web_url('application/merchant/merchantAccount',array('status' => '1'));
		$frames['merchant']['items']['merchantlist']['title'] = '商户中心';
		$frames['merchant']['items']['merchantlist']['actions'] = array('op','merchantAccount');
		$frames['merchant']['items']['merchantlist']['active'] = '';
		
		$frames['cover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口设置';
		$frames['cover']['items']['group']['url'] = web_url('application/merchant/cover',array('type' => 'app'));
		$frames['cover']['items']['group']['title'] = '微信端入口';
		$frames['cover']['items']['group']['actions'] = array();
		$frames['cover']['items']['group']['active'] = '';
	}

	if($_GPC['ac'] == 'helpbuy'){
		$frames['marketing']['title'] = '<i class="fa fa-archive"></i>&nbsp;&nbsp; 他人代付';
		$frames['marketing']['items'] = array();
		$frames['marketing']['items']['helpbuy']['url'] = web_url('application/helpbuy/list');
		$frames['marketing']['items']['helpbuy']['title'] = '他人代付';
		$frames['marketing']['items']['helpbuy']['actions'] = array();
		$frames['marketing']['items']['helpbuy']['active'] = '';
	}
	
	if($_GPC['ac'] == 'distribution'){
		$frames['distribution']['title'] = '<i class="fa fa-archive"></i>&nbsp;&nbsp; 分销列表';
		$frames['distribution']['items'] = array();
		$frames['distribution']['items']['memberlist']['url'] = web_url('application/distribution/memberlist');
		$frames['distribution']['items']['memberlist']['title'] = '分销商列表';
		$frames['distribution']['items']['memberlist']['actions'] = array();
		$frames['distribution']['items']['memberlist']['active'] = '';
		
		$frames['distribution']['items']['addmember']['url'] = web_url('application/distribution/addmember');
		$frames['distribution']['items']['addmember']['title'] = '添加分销商';
		$frames['distribution']['items']['addmember']['actions'] = array();
		$frames['distribution']['items']['addmember']['active'] = '';
		
		$frames['distribution']['items']['applylist']['url'] = web_url('application/distribution/applylist');
		$frames['distribution']['items']['applylist']['title'] = '提现列表';
		$frames['distribution']['items']['applylist']['actions'] = array();
		$frames['distribution']['items']['applylist']['active'] = '';
		
		$frames['distrset']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 分销设置';
		$frames['distrset']['items'] = array();
		$frames['distrset']['items']['disset']['url'] = web_url('application/distribution/disset');
		$frames['distrset']['items']['disset']['title'] = '基础设置';
		$frames['distrset']['items']['disset']['actions'] = array();
		$frames['distrset']['items']['disset']['active'] = '';
		
		
	}
	
	
	if($_GPC['ac'] == 'scratch'){
		$frames['game']['title'] = '<i class="fa fa-archive"></i>&nbsp;&nbsp; 刮刮卡';
		$frames['game']['items'] = array();
		$frames['game']['items']['scratch']['url'] = web_url('application/scratch/list');
		$frames['game']['items']['scratch']['title'] = '刮刮卡';
		$frames['game']['items']['scratch']['actions'] = array();
		$frames['game']['items']['scratch']['active'] = '';
	}
	return $frames;
}

function getdataFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['data']['title'] = '<i class="fa fa-pie-chart"></i>&nbsp;&nbsp; 管理数据';
	$frames['data']['items'] = array();

	$frames['data']['items']['home_data']['url'] = web_url('data/home_data');
	$frames['data']['items']['home_data']['title'] = '数据概况';
	$frames['data']['items']['home_data']['actions'] = array();
	$frames['data']['items']['home_data']['active'] = '';
	$frames['data']['items']['home_data']['append']['url'] = web_url('data/home_data');
	$frames['data']['items']['home_data']['append']['title'] = '';
	
	$frames['data']['items']['goods_data']['url'] = web_url('data/goods_data');
	$frames['data']['items']['goods_data']['title'] = '商品统计';
	$frames['data']['items']['goods_data']['actions'] = array();
	$frames['data']['items']['goods_data']['active'] = '';
	$frames['data']['items']['goods_data']['append']['url'] = web_url('data/goods_data');
	$frames['data']['items']['goods_data']['append']['title'] = '';
	
	$frames['data']['items']['order_data']['url'] = web_url('data/order_data');
	$frames['data']['items']['order_data']['title'] = '订单统计';
	$frames['data']['items']['order_data']['actions'] = array();
	$frames['data']['items']['order_data']['active'] = '';
	$frames['data']['items']['order_data']['append']['url'] = web_url('data/order_data');
	$frames['data']['items']['order_data']['append']['title'] = '';
	
	$frames['log']['title'] = '<i class="fa fa-history"></i>&nbsp;&nbsp; 日志';
	$frames['log']['items'] = array();
	
	if(!TG_ID){
		$frames['log']['items']['system_log']['url'] = web_url('data/system_log');
		$frames['log']['items']['system_log']['title'] = '系统日志';
		$frames['log']['items']['system_log']['actions'] = array();
		$frames['log']['items']['system_log']['active'] = '';
		$frames['log']['items']['system_log']['append']['url'] = web_url('data/system_log');
		$frames['log']['items']['system_log']['append']['title'] = '';
		
		$frames['log']['items']['check_log']['url'] = web_url('data/check_log');
		$frames['log']['items']['check_log']['title'] = '下载对账单';
		$frames['log']['items']['check_log']['actions'] = array();
		$frames['log']['items']['check_log']['active'] = '';
		$frames['log']['items']['check_log']['append']['url'] = web_url('data/check_log');
		$frames['log']['items']['check_log']['append']['title'] = '';
	}
	
	$frames['log']['items']['refund_log']['url'] = web_url('data/refund_log');
	$frames['log']['items']['refund_log']['title'] = '退款日志';
	$frames['log']['items']['refund_log']['actions'] = array();
	$frames['log']['items']['refund_log']['active'] = '';
	$frames['log']['items']['refund_log']['append']['url'] = web_url('data/refund_log');
	$frames['log']['items']['refund_log']['append']['title'] = '';
	
	return $frames;
}

function getsystemFrames(){
	global $_W,$_GPC;
	$frames = array();
	$frames['member']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 云服务';
	$frames['member']['items'] = array();

	$frames['member']['items']['setting']['url'] = web_url('system/auth/display');
	$frames['member']['items']['setting']['title'] = '系统授权';
	$frames['member']['items']['setting']['actions'] = array();
	$frames['member']['items']['setting']['active'] = '';

	$frames['member']['items']['display']['url'] = web_url('system/auth/upgrade');
	$frames['member']['items']['display']['title'] = '文件校验';
	$frames['member']['items']['display']['actions'] = array();
	$frames['member']['items']['display']['active'] = '';
	
	$frames['sysset']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 系统设置';
	$frames['sysset']['items'] = array();
	
	$frames['sysset']['items']['setting']['url'] = web_url('system/setting/base');
	$frames['sysset']['items']['setting']['title'] = '系统信息';
	$frames['sysset']['items']['setting']['actions'] = array();
	$frames['sysset']['items']['setting']['active'] = '';
	
	$frames['sysset']['items']['task']['url'] = web_url('system/setting/task');
	$frames['sysset']['items']['task']['title'] = '计划任务';
	$frames['sysset']['items']['task']['actions'] = array();
	$frames['sysset']['items']['task']['active'] = '';
	return $frames;
}

function get_top_menus(){
	global $_W;
	$frames = array();
	
	$frames['store']['title'] = '<i class="fa fa-desktop"></i>&nbsp;&nbsp; 商城';
	$frames['store']['url'] = web_url('store/setting');
	$frames['store']['active'] = 'store';
	
	$frames['goods']['title'] = '<i class="fa fa-gift"></i>&nbsp;&nbsp; 商品';
	$frames['goods']['url'] = web_url('goods/goods/display',array('status' => '1'));
	$frames['goods']['active'] = 'goods';
	
	$frames['order']['title'] = '<i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; 订单';
	$frames['order']['url'] = web_url('order/order/summary');
	$frames['order']['active'] = 'order';
	
	if(!TG_ID){
		$frames['member']['title'] = '<i class="fa fa-user"></i>&nbsp;&nbsp; 会员';
		$frames['member']['url'] = web_url('member/member/setting');
		$frames['member']['active'] = 'member';
	}
	
	$frames['data']['title'] = '<i class="fa fa-area-chart"></i>&nbsp;&nbsp; 数据';
	$frames['data']['url'] = web_url('data/home_data');
	$frames['data']['active'] = 'data';
	
	$frames['application']['title'] = '<i class="fa fa-cubes"></i>&nbsp;&nbsp; 应用';
	$frames['application']['url'] = web_url('application/plugins/list');
	$frames['application']['active'] = 'application';
	
	if($_W['isfounder']){
		$frames['system']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 云服务';
		$frames['system']['url'] = web_url('system/auth/display');
		$frames['system']['active'] = 'system';
	}
	
	return $frames;
}
