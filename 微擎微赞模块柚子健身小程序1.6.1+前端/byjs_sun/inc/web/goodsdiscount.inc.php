<?php
global $_W,$_GPC;
$GLOBALS['frames'] = $this->getMainMenu();

$info = pdo_get('byjs_sun_goods',array('uniacid'=>$_W['uniacid'],'state'=>2,'id'=>$_GPC['id']),array('id','goods_name','goods_price','imgs'));
if(checksubmit('submit')){
    $data['goods_id'] = $_GPC['id'];
    $data['goods_name'] = $_GPC['goods_name'];
    $data['goods_price'] = $_GPC['goods_price'];
    $data['goods_new_price'] = $_GPC['goods_new_price'];
    $data['endtime'] = $_GPC['endtime'];
    $data['goods_img'] = $_GPC['goods_img'];
    $data['uniacid'] = $_W['uniacid'];
    $list = pdo_getall('byjs_sun_goodsdiscount',array('uniacid'=>$_W['uniacid']));
    if($_GPC['id']){
        $id = $_GPC['id'];
          $res = pdo_insert('byjs_sun_goodsdiscount',$data);
              if($res){
                    message('插入成功',$this->createWebUrl('goods',array()),'success');
                }else{
                    message('失败','','error');
                }
     
        
    }
}

include $this->template('web/goodsdiscount');