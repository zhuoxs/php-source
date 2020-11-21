<?php
global $_W,$_GPC;
$op=$_GPC['op'];
$tbuid=$_GPC['tkuid'];
$tbnickname=$_GPC['tbnickname'];
$memberid=$_GPC['memberid'];
$qdtgurl=trim($_GPC['qdtgurl']);
$id=$_GPC['id'];


if(!empty($id)){
	 $qd = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  id='{$id}'");
}

if (checksubmit('submit')){
	$memberid=trim($_GPC['memberid']);
	$id=$_GPC['id'];
	if (empty($_GPC['memberid'])){
			message('memberid必须填写！');
	}
	$res=pdo_update($this->modulename."_tksign",array('memberid'=>$memberid,'qdtgurl'=>$qdtgurl), array('id' => $id));
	if(!empty($res)){
		message('更新成功！', $this -> createWebUrl('yunkong', array('op' => 'display')), 'success');
	}else{
		message('抱歉' . $id . '不存在或是已经被删除！');
	}

	
}
$cfg = $this->module['config'];
        $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
        $tksignlist = pdo_fetchall ( 'select * from ' . tablename ($this->modulename . "_tksign" ) . " where weid='{$_W['uniacid']}' order by id desc" );
        include $this -> template('yunkong');