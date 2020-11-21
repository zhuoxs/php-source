<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_getall('chbl_sun_county_city',array('uniacid'=>$_W['uniacid']));
foreach ($info as $k=>$v){
    $info[$k]['province'] = pdo_getcolumn('chbl_sun_province',array('id'=>$v['province_id']),'name');
    $info[$k]['county'] = pdo_getcolumn('chbl_sun_county',array('id'=>$v['county_id']),'name');
    $info[$k]['city'] = pdo_getcolumn('chbl_sun_city',array('id'=>$v['city_id']),'name');
}

if($_GPC['op'] == 'delete'){
    $id = intval($_GPC['id']);
    $res = pdo_delete('chbl_sun_county_city',array('id'=>$id));
    if($res){
        message('删除成功！',referer(), 'success');
    }else{
        message('删除失败！');
    }
}
include $this->template('web/city');