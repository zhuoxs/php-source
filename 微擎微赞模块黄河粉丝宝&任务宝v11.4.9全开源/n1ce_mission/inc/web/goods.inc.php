<?php
global $_W,$_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$activity = pdo_fetchall("SELECT * FROM ".tablename('n1ce_mission_reply')." as t1,".tablename('rule_keyword')."as t2 WHERE t1.rid=t2.rid AND t1.uniacid = '{$_W['uniacid']}' ORDER BY t2.displayorder DESC");
if($operation == 'display'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$sql = 'select * from ' . tablename('n1ce_mission_goods') . 'where uniacid = :uniacid order by id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize ;
	$prarm = array(':uniacid' => $_W['uniacid']);
	$list = pdo_fetchall($sql, $prarm);
	$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_goods') . 'where uniacid = :uniacid ', $prarm);
	$pager = pagination($count, $pindex, $psize);
}elseif ($operation == 'post') {
	$id = $_GPC['id'];
	if($id){
		$goods = pdo_fetch("select * from " .tablename('n1ce_mission_goods'). " where id = :id",array(':id'=>$id));
		$goods['goods_img'] = unserialize($goods['goods_img']);
	}
	if(checksubmit()){
		$data = array(
			'uniacid' => $_W['uniacid'],
			'rid' => $_GPC['rid'],
			'title' => $_GPC['title'],
			'goods_img' => iserializer($_GPC['goods_img']),
			'quality' => $_GPC['quality'],
			'markert_price' => $_GPC['markert_price']*100,
			'get_price' => $_GPC['get_price']*100,
			'postage' => $_GPC['postage']*100,
			'goods_desc' => $_GPC['goods_desc'],
			'goodstype' => $_GPC['goodstype'],
			'usecode' => $_GPC['usecode'],
			'createtime' => time(),
		);
		if($data['goodstype'] == 2){
			$data['postage'] = 0;
		}
		if($id){ 
			pdo_update('n1ce_mission_goods',$data,array('id'=>$id));
			pdo_update('n1ce_mission_prize',array('prizesum'=>$_GPC['quality']),array('uniacid'=>$_W['uniacid'],'gid'=>$id));
		}else{
			pdo_insert('n1ce_mission_goods',$data);
		}
		message('提交成功',$this->createWebUrl('goods',array('op'=>'display')),'success');
	}
}elseif ($operation == 'delete') {
	pdo_delete('n1ce_mission_goods',array('id'=>$_GPC['id']));
	message('删除成功',$this->createWebUrl('goods',array('op'=>'display')),'success');
}
include $this->template('goods');