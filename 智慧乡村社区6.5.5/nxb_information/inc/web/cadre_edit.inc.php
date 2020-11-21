<?php
global $_W, $_GPC;
$cadid=intval($_GPC['cadid']);

if($cadid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_cadre')." WHERE cadid=:cadid",array(':cadid'=>$cadid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		$images=$_GPC['avatar'];
		if(empty($images)){
			$images=$res['avatar'];
		}
		
		
		$newdata = array(
			
			'cname'=>$_GPC['cname'],
			'post'=>$_GPC['post'],
			'company'=>$_GPC['company'],
			'avatar'=>$images,
			'phone'=>$_GPC['phone'],
			'sex'=>$_GPC['sex'],
			'idcard'=>$_GPC['idcard'],
			'nomberone'=>$_GPC['nomberone'],
			'duizhang'=>$_GPC['duizhang'],
			'starttime'=>$_GPC['starttime'],
			'endtime'=>$_GPC['endtime'],
			'techang'=>$_GPC['techang'],
			'zhengzhi'=>$_GPC['zhengzhi'],
			'xueli'=>$_GPC['xueli'],
			'address'=>$_GPC['address'],
			'remark'=>$_GPC['remark'],
			
			
			 );
		$res = pdo_update('nx_information_cadre', $newdata,array('cadid'=>$cadid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('cadre'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('cadre'), 'error');
		}

	}
}



include $this->template('web/cadre_edit');
?>