<?php
global $_GPC, $_W;
$op = empty($_GPC['op'])?"display":$_GPC['op'];
load()->func('tpl');

$positionarr = array(
	'home'    => "系统主页",
	'arthome' => "党建动态",
	'eduhome' => "党员学习",
	'exahome' => "在线考试",
	'suphome' => "监督执纪",
	'serhome' => "志愿服务",
	'acthome' => "组织活动",
	);

if ($op=="display") {
	$con = ' WHERE uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    $position = trim($_GPC['position']);
    if (!empty($position)) {
        $con .= " AND position=:position ";
        $par[':position'] = $position;
    }
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall('SELECT * FROM '.tablename($this->table_slide).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, 'id');
	$total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_slide).$con, $par);
	$pager = pagination($total, $pindex, $psize);

	

} elseif ($op=="post") {
	$id = intval($_GPC['id']);
	if (checksubmit('submit')) {
		$wxapptype = intval($_GPC['wxapptype']);
		$wxapplink = trim($_GPC['wxapplink']);
		$data = array(
			'uniacid'   => $_W['uniacid'],
			'position'  => trim($_GPC['position']),
			'title'     => trim($_GPC['title']),
			'tilpic'    => trim($_GPC['tilpic']),
			'link'      => trim($_GPC['link']),
			'wxapptype' => $wxapptype,
			'wxapplink' => $wxapptype==2 ? urlencode($wxapplink) : $wxapplink,
			'priority'  => intval($_GPC['priority']),
			);
		if (empty($id)) {
			pdo_insert($this->table_slide,$data);
		}else{
			pdo_update($this->table_slide,$data,array('id'=>$id));
		}
		message("数据提交成功！", $this->createWebUrl('slide'),'success');
	}
	$slide = pdo_get($this->table_slide, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	if (empty($slide)) {
		$slide = array(
			'position'  => 'home',
			'link'      => 'javascript:;',
			'wxapptype' => 1,
			'priority'  => 0,
			);
	}else{
		$slide['wxapplink'] = $slide['wxapptype']==2 ? urldecode($slide['wxapplink']) : $slide['wxapplink'];
	}

} elseif ($op=="delete") {
	$id = intval($_GPC['id']);
	$slide = pdo_get($this->table_slide, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	if (empty($slide)) {
		message("要删除的轮播图片不存在或已被删除！", referer(),'error');
	}
	pdo_delete($this->table_slide, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	message("数据删除成功！", referer(),'success');

}
include $this->template("slide");
?>