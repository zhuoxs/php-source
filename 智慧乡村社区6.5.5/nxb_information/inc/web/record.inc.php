<?php
global $_W, $_GPC;
load()->web('tpl'); 

//查询帮扶信息记录
$messagelist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_message')." WHERE weid=:weid ORDER BY mesid DESC",array(':weid'=>$_W['uniacid']));
//查询帮扶项目记录
$projectlist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_project')." WHERE weid=:weid ORDER BY proid DESC",array(':weid'=>$_W['uniacid']));



//添加帮扶记录
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mesid'=>$_GPC['mesid'],
			'proid'=>$_GPC['proid'],	
			'recctime'=>time(),
			 );
		$res = pdo_insert('nx_information_record', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('record'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('record'), 'error');
		}

	}

}else{
	$cx='';
	$mesid=intval($_GPC['mesid']);
	if($mesid!=0){
		$cx=' AND a.mesid='.$mesid;
	}
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$recordlist=pdo_fetchall("SELECT a.*,b.projectname,c.bianma FROM ".tablename('nx_information_record')." as a left join ".tablename('nx_information_project')." as b on a.proid=b.proid left join ".tablename('nx_information_message')." as c on a.mesid=c.mesid WHERE a.weid=:uniacid ".$cx." ORDER BY recid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(breid) FROM " . tablename('nx_information_record') ." WHERE weid=:uniacid ".$cx." ORDER BY recid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);

	include $this->template('web/record');	
	
}


?>