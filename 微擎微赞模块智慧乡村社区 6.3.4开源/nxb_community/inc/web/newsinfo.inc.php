<?php
global $_W, $_GPC;
load()->web('tpl'); 
$newsid=intval($_GPC['newsid']);

if (!empty($newsid)){
	//获取帖子详情
	$newsinfo=pdo_fetch("SELECT a.*,b.mtitle,c.nickname,c.tel FROM ".tablename('bc_community_news')." as a left join ".tablename('bc_community_menu')." as b on a.nmenu=b.meid left join ".tablename('bc_community_member')." as c on a.mid=c.mid WHERE a.weid=:uniacid AND nid=:newsid",array(':uniacid'=>$_W['uniacid'],':newsid'=>$newsid));
	$images=explode("|",$newsinfo['nimg']);
	
}

//处理帖子详情
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'ntitle'=>$_GPC['ntitle'],
			'ntext'=>$_GPC['ntext'],
			'top'=>$_GPC['top'],
			'status'=>$_GPC['status'],				
			 );
		$res = pdo_update('bc_community_news', $newdata,array('nid'=>$newsid));
		if (!empty($res)) {

			message('恭喜，处理成功！', $this -> createWebUrl('news'), 'success');
		} else {
			message('抱歉，处理失败！', $this -> createWebUrl('news'), 'error');
		}

	}

}


include $this->template('web/newsinfo');	

?>