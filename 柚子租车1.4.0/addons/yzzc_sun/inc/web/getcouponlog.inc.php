<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 15:56
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


$where="cid =".$_GPC['cid']." and type =".$_GPC['type'];
//var_dump($where);exit;
//var_dump($_GPC['type']);exit;
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzzc_sun_coupon_get where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$list = pdo_fetchall($sql);
//var_dump($list);exit;
foreach ($list as $key =>$value){
    $list[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
    if($value['usetime']>0){
        $list[$key]['usetime']=date('Y-m-d H:i:s',$value['usetime']);
    }
    $user=pdo_get('yzzc_sun_user',array('id'=>$value['uid']),array('user_name','headimg'));
    $list[$key]['user_name']=$user['user_name'];
    $list[$key]['headimg']=$user['headimg'];
}
$total=pdo_fetchcolumn("select count(*) from ims_yzzc_sun_coupon_get where ".$where);
$pager = pagination($total, $page, $size);
$type=$_GPC['type'];

include $this->template('web/getcouponlog');