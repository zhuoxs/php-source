<?php
global $_W, $_GPC;
load()->web('tpl'); 


//添加帮扶项目记录
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'projectname'=>$_GPC['projectname'],
			'helpcontent'=>$_GPC['helpcontent'],
			'subsidy'=>$_GPC['subsidy'],
			'aincome'=>$_GPC['aincome'],
			'bincome'=>$_GPC['bincome'],
			'expenditure'=>$_GPC['expenditure'],
			'yearincome'=>$_GPC['yearincome'],	
			'proctime'=>time(),
			
			 );
		$res = pdo_insert('nx_information_project', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('project'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('project'), 'error');
		}

	}

}else{
	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$projectlist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_project')." WHERE weid=:uniacid ORDER BY proid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(proid) FROM " . tablename('nx_information_project') ." WHERE weid=:uniacid ORDER BY proid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);

	include $this->template('web/project');	
	
}


?>