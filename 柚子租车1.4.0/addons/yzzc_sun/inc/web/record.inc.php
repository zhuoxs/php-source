<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$data[':uniacid']=$_W['uniacid'];
$where="uid =".$_GPC['uid'];
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzzc_sun_integral_log where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$list = pdo_fetchall($sql);
foreach ($list as $key =>$value){
    $list[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
}
$total=pdo_fetchcolumn("select count(*) from ims_yzzc_sun_integral_log where ".$where);
$pager = pagination($total, $page, $size);

include $this->template('web/record');