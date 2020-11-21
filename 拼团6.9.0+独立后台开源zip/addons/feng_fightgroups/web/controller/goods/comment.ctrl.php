<?php
defined('IN_IA') or exit('Access Denied');

$ops = array('display', 'setting');
$op = !empty($op) ? $op : 'display';
if ($op == 'display') {
	$status = $_GPC['status']?$_GPC['status']:1;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$where =array();
	$where['status'] = $status;
	if($_SESSION['role_id'])$where['merchantid'] = $_SESSION['role_id'];
	if($_GPC['keyword'])$where['goodsid^content'] = $_GPC['keyword'];
	$commentsData = Util::getNumData("*", 'tg_discuss', $where,'id desc',$pindex,$psize,1);
	$comments = $commentsData[0];
	foreach($comments as $key=>&$value){
		$value['goods'] = model_goods::getSingleGoods($value['goodsid'], '*');
		if(empty($value['star'])){
			$value['star'] = 5;
		}
	}
	
	include wl_template('goods/comment/comment_list');
}
if($op == 'setting'){
	$id = $_GPC['id'];
	$goods = model_goods::getSingleGoods($id, '*');
	$comment = model_goods::getSingleGoodsComment($goods['id']);
	if(checksubmit()){
		$t = time();
		$init = $goods['createtime'];
		$filename = TG_WEB."resource/nickname.text";
		$url='../addons/feng_fightgroups/web/resource/images/head_imgs';
		$head_imgs_array = get_head_img($url, 1);
		$nickname_array = get_nickname($filename,1);
		$time_array = get_randtime($init,$t,1);
		$openid = serialize(array($head_imgs_array[0],$nickname_array[0]['nickname'],$time_array[0]));
		$data['content'] = $_GPC['content'];
		$data['status'] = $_GPC['status'];
		$data['createtime'] = '虚拟';
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $openid;
		$data['commentid'] = $comment['id'];
		$data['goodsid'] = $goods['id'];
		
		if(pdo_insert('tg_discuss',$data)){
			pdo_update('tg_comment',array('speechcount'=>$comment['speechcount']+1),array('uniacid'=>$_W['uniacid'],'goodsid'=>$goods['id']));
			message('成功', referer(), 'success');
		}else{
			message('失败', referer(), 'error');
		}
	}
	include wl_template('goods/comment/create');
}
