<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info = pdo_get('ymktv_sun_keepwine',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

$system = pdo_get('ymktv_sun_system',array('uniacid'=>$_W['uniacid']));
if($info['build_id']==0){
    $info['b_name'] = $system['pt_name']."(".'总店'.")";
}else{
    $info['b_name'] = pdo_getcolumn('ymktv_sun_building',array('uniacid'=>$_W['uniacid'],'id'=>$info['build_id']),'b_name');
}
if($info['remark']=='' || $info['remark']=='undefined'){
    $info['remark'] = '';
}
if($info['status']==0){
    $status = '待确认';
}elseif ($info['status']==1){
    $status = '已存酒';
}else{
    $status = '已提取';
}
$info['status'] = $status;
$info['addtime'] = date('Y-m-d H:i:s',$info['addtime']);


include $this->template('web/winedatainfo');