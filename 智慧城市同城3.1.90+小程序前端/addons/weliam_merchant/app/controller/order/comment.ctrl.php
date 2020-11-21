<?php
defined('IN_IA') or exit('Access Denied');

class Comment_WeliamController{
	
	public function add(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '添加评论 - '.$_W['wlsetting']['base']['name'] : '添加评论';
		$id = $_GPC['orderid'];
		$plugin = $_GPC['plugin'];
		if($plugin == 'rush'){
			$orderstatus = pdo_getcolumn(PDO_NAME.'rush_order',array('id'=>$id),'status');
			if($orderstatus != 2){
				wl_message('此订单未完成或已评价');
			}
		}else if($plugin == 'usehalf'){
			$orderstatus = pdo_getcolumn(PDO_NAME.'wlmerchant_timecardrecord',array('id'=>$id),'commentflag');
			if($orderstatus){
				wl_message('此订单未完成或已评价');
			}
		}else if($plugin != 'noorder'){
			$orderstatus = pdo_getcolumn(PDO_NAME.'order',array('id'=>$id),'status');
			if($orderstatus != 2){
				wl_message('此订单未完成或已评价');
			}
		}
		if(empty($id)){
			wl_message('缺少重要参数');
		}
		include wl_template('order/comment_add');
	}
	
	public function add_ajax(){
		global $_W,$_GPC;
		$id = intval($_GPC['id']);
		if(empty($id)){
			wl_message(error(-1, '缺少重要参数，请重试'), '', 'ajax');
		}
		$data = array('uniacid'=>$_W['uniacid'],'aid'=>$_W['aid'],'mid'=>$_W['mid'],'status'=>1,'pic'=>serialize($_GPC['thumbs']),'idoforder'=>$id,'text'=>$_GPC['commenttext'],'star'=>intval($_GPC['star']),'createtime'=>time(),'headimg'=>$_W['wlmember']['avatar'],'nickname'=>$_W['wlmember']['nickname']);
		if($_GPC['plugin'] == 'rush'){
			$data['sid'] = pdo_getcolumn(PDO_NAME.'rush_order', array('id'=>$id,'uniacid'=>$_W['uniacid']),'sid');
			$data['plugin'] = 'rush';
			pdo_update(PDO_NAME.'rush_order',array('status'=>3),array('id'=>$id));
		}else if($_GPC['plugin'] == 'usehalf'){
			$data['sid'] = pdo_getcolumn(PDO_NAME.'timecardrecord', array('id'=>$id,'uniacid'=>$_W['uniacid']),'merchantid');
			$data['plugin'] = 'usehalf';
			pdo_update(PDO_NAME.'timecardrecord',array('commentflag'=>1),array('id'=>$id));
		}else if($_GPC['plugin'] == 'noorder'){
			$data['idoforder'] = 0;
			$data['sid'] = $id;
			$data['plugin'] = 'noorder';
		}else{
			$order = pdo_get(PDO_NAME.'order', array('id'=>$id,'uniacid'=>$_W['uniacid']),array('sid','plugin'));
			$data['sid'] = $order['sid'];
			$data['plugin'] = $order['plugin'];
			$re = pdo_update(PDO_NAME.'order',array('status'=>3),array('id'=>$id,'uniacid'=>$_W['uniacid']));
		}
		if(empty($data['sid']) || empty($data['plugin'])){
			wl_message(error(-1, '未找到订单信息，请重试'), '', 'ajax');
		}
		if($data['star'] > 3){
			$data['level'] = 1;
		}elseif($data['star'] == 3){
			$data['level'] = 2;
		}else{
			$data['level'] = 3;
		}
		if($_GPC['thumbs']){
			$data['ispic'] = 1;
		}
		pdo_insert(PDO_NAME.'comment',$data);
		//模板消息通知
		$storename = pdo_getcolumn(PDO_NAME.'merchantdata',array('id'=>$data['sid']),'storename');
		//通知管理员
		$openids = pdo_getall('wlmerchant_agentadmin',array('aid' => $_W['aid'],'notice'=> 1),array('openid'));
		if($openids){
			$first = '有用户发表了评论，请前往后台审核';
			$keyword1 = '商家['.$storename.']的评论';
			$keyword2 = '待审核';
			$remark = '评价内容:'.$data['text'];
			$url = app_url('dashboard/home/index');
			foreach ($openids as $key => $member){
				Message::jobNotice($member['openid'],$first,$keyword1,$keyword2,$remark,$url);
			}
		}
		//通知商户店长
		$set = Setting::agentsetting_read('comment');
		if($set['comment_check']){
			$mid = pdo_getcolumn(PDO_NAME.'merchantuser',array('storeid'=>$data['sid'],'ismain'=>1),'mid');
			$openid = pdo_getcolumn(PDO_NAME.'member',array('id'=>$mid),'openid');
			$first = '有用户发表了评论，请审核';
			$keyword1 = '商家['.$storename.']的评论';
			$keyword2 = '待审核';
			$remark = '评价内容:'.$data['text'];
			$url = app_url('store/supervise/comment',array('checkone'=>1));
			Message::jobNotice($openid,$first,$keyword1,$keyword2,$remark,$url);
		}
		wl_message(error(0), '', 'ajax');
	}
}

