<?php 
	// 
	//  share_detail.inc.php
	//  <project>
	//  晒单详情，评价评论，讨论详情，讨论评价
	//  Created by Administrator on 2016-08-31.
	//  Copyright 2016 Administrator. All rights reserved.
	// 
	
	global $_W,$_GPC;
	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	$orderid = $_GPC['orderid'];
	if($orderid){
		$order = model_order::getSingleOrder($orderid, '*');
		$goods = model_goods::getSingleGoods($order['g_id'], '*');
	}
	if($_GPC['goodsid']){
		$goods = model_goods::getSingleGoods($_GPC['goodsid'], '*');
	}
	$comment = model_goods::getSingleGoodsComment($goods['id']);
	$where =array();
	$where['commentid'] = $comment['id'];
	$where['status'] = 2;
	$commentData = Util::getNumData('*', 'tg_discuss', $where,'id desc',0,0,1);
	if($op == 'display'){
		include wl_template('member/comment');
	}
	
	if($op == 'comment'){
		$pindex = max(1, intval($_GPC['pindex']));
		$psize = 5;
		$where =array();
		$where['commentid'] = $comment['id'];
		$where['status'] = 2;
		$commentData = Util::getNumData('*', 'tg_discuss', $where,'id desc',$pindex,$psize,1);
		$comment = $commentData[0];
		foreach($comment as $key => $value){
			if($value['createtime']=='虚拟'){
				$member = unserialize($value['openid']);
				$comment[$key]['avatar'] = tomedia($member[0]);
				$comment[$key]['nickname'] = $member[1];
				$comment[$key]['createtime'] = date('Y-m-d H:s:i',$member[2]);
			}else{
				$member = Util::getSingelData('*', 'tg_member', array('openid'=>$value['openid']));
				$comment[$key]['avatar'] = tomedia($member['avatar']);
				$comment[$key]['nickname'] = $member['nickname'];
				$comment[$key]['createtime'] = date('Y-m-d H:s:i',$value['createtime']);
			}
			if($comment[$key]['star'] == 0){
				$comment[$key]['star'] = 5;
			}
		}
		die(json_encode(array('status'=>2,'data'=>$comment,'total'=>$commentData[2],'msg'=>'评价查询成功')));
	}
	
	if($op == 'add_comment'){
		//判断是否可以评论
		$order = Util::getSingelData('id', 'tg_order', array('openid'=>$openid,'g_id'=>$goods['id'],'#status#'=>'(2,3,4)'));
		if(empty($order))die(json_encode(array('status'=>1,'data'=>'','msg'=>'您未购买，暂不能评论')));
		$com = Util::getSingelData('id', 'tg_discuss', array('openid'=>$openid,'orderid'=>$orderid));
		if(!empty($com))die(json_encode(array('status'=>1,'data'=>'','msg'=>'该订单您已评论过了。')));
		
		//添加评论
		$data['content'] = $_GPC['content'];
		$data['status'] = 1;
		$data['parentid'] = $_GPC['parentid'];
		$data['createtime'] = time();
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $openid;
		$data['commentid'] = $comment['id'];
		$data['goodsid'] = $goods['id'];
		$data['merchantid'] = $goods['merchantid'];
		$data['star'] = $_GPC['star'];
		$data['orderid'] = $_GPC['orderid'];
		if(empty($data['star'])){
			$data['star'] = 5;
		}
		
		if(empty($data['content']) || empty($data['openid'])){
			die(json_encode(array('status'=>1,'data'=>'','msg'=>'评价不能为空，或者参数不正确')));
		}
		
		if(pdo_insert('tg_discuss',$data)){
			pdo_update('tg_comment',array('speechcount'=>$comment['speechcount']+1),array('uniacid'=>$_W['uniacid'],'goodsid'=>$goods['id']));
			die(json_encode(array('status'=>2,'data'=>$comment,'msg'=>'评价成功')));
		}else{
			die(json_encode(array('status'=>1,'data'=>$comment,'msg'=>'评价失败')));
		}
	}
	if($op == 'like'){
		$praise = !empty($comment['praise'])?unserialize($comment['praise']):array();
		if(in_array($_W['openid'], $praise)) die(json_encode(array('status'=>1,'data'=>$comment['count'],'msg'=>'已经点赞过了')));
		$praise[count($praise)] = $_W['openid'];
		$praise = serialize($praise);
		pdo_update('tg_comment',array('count'=>$comment['count']+1,'praise'=>$praise),array('id'=>$comment['id']));
		die(json_encode(array('status'=>2,'data'=>$comment['count']+1,'msg'=>'点赞成功')));
	}
	