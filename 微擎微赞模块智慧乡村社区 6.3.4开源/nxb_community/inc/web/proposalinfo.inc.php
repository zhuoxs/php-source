<?php
global $_W, $_GPC;
load()->web('tpl'); 
$pid=intval($_GPC['pid']);

//获取问题类型
	$typelist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_type')."WHERE weid=:uniacid AND tstatus=0 ORDER BY tid DESC",array(':uniacid'=>$_W['uniacid']));

if (!empty($pid)){
	//获取建议详情
	$proposalinfo=pdo_fetch("SELECT a.*,b.tname,c.realname FROM ".tablename('bc_community_proposal')." as a left join ".tablename('bc_community_type')." as b on a.ptype=b.tid left join ".tablename('bc_community_member')." as c on a.mid=c.mid WHERE a.weid=:uniacid AND pid=:pid",array(':uniacid'=>$_W['uniacid'],':pid'=>$pid));
	$images=explode("|",$proposalinfo['pimg']);
	
}

//更新意见建议处理情况
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'ptype'=>$_GPC['ptype'],
			'phandleper'=>$_GPC['phandleper'],
			'phandle'=>$_GPC['phandle'],
			'pstatus'=>$_GPC['pstatus'],
			'phandletime'=>time(),
			 );
		$res = pdo_update('bc_community_proposal', $newdata,array('pid'=>$pid));
		if (!empty($res)) {
			message('恭喜，保存成功！', $this -> createWebUrl('proposal'), 'success');
		} else {
			message('抱歉，保存失败！', $this -> createWebUrl('proposal'), 'error');
		}

	}

}


include $this->template('web/proposalinfo');	

?>