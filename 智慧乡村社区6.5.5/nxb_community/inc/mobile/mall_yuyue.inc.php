<?php
global $_W, $_GPC;
load() -> func('tpl');

$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();

$sid=intval($_GPC['sid']);
$pid=intval($_GPC['pid']);
$danyuan=intval($_GPC['danyuan']);
$menpai=intval($_GPC['menpai']);

if ($_W['ispost']) {
	if (checksubmit('submit')) {
			
	
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mid'=>$mid,
			'sid'=>$sid,
			'pid'=>$pid,
			'content'=>$_GPC['content'],
			'contacts'=>$_GPC['contacts'],
			'mobile'=>$_GPC['mobile'],
			'ctime'=>time(),
			'danyuan'=>$danyuan,
			'menpai'=>$menpai,
		);
		
		$res = pdo_insert('bc_community_mall_bespeak', $newdata);
		
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('mall_goodsinfo',array('id'=>$pid)), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('mall_goodsinfo',array('id'=>$pid)), 'error');
		}

	}

}
	

include $this -> template('mall_yuyue');

?>