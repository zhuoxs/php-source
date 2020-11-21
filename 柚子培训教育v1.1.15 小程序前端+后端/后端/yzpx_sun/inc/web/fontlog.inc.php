<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'].' and cid ='.$_GPC['cid']  ;

$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzpx_sun_card_getlog") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzpx_sun_card_getlog')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
foreach ($info as $key =>$value){
    $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
    $font=pdo_get('yzpx_sun_card_font',array('id'=>$value['fid']),array('font'));
    $info[$key]['font']=$font['font'];
    $user=pdo_get('yzpx_sun_user',array('id'=>$value['uid']),array('user_name'));
    $info[$key]['username']=$user['user_name'];
}
include $this->template('web/fontlog');