<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$sql = 'SELECT t.id, t.goods_name, t.goods_price, t.goods_volume, t.time, t.teamWork FROM ims_ymktv_sun_goods t WHERE t.uniacid = '.$_W['uniacid'];
$list = pdo_fetchall($sql);

if($_GPC['op'] == 'edit'){
    $goods = pdo_get('ymktv_sun_goods',array('id' => $_GPC['id']));
    if ($goods['state'] != 2){
        message('该商品未处于审核通过状态,请通过审核后再开启拼团',$this->createWebUrl('goods'),'error');
    }
    $flag = false;
    if ($goods['teamWork'] == '1'){
        $teamWork = array('teamWork' => 2);
        $res = pdo_update('ymktv_sun_goods',$teamWork,array('id' => $_GPC['id']));
    }else{
        $teamWork = array('teamWork' => 1);
        $res = pdo_update('ymktv_sun_goods',$teamWork,array('id' => $_GPC['id']));
        //删除拼团表里的数据
        pdo_delete('ymktv_sun_teamwork',array('goodsid' => $_GPC['id'],'uniacid' => $_W['uniacid']));
        $flag = true;
    }
    if($flag){
        message('开启成功! 请前往商品详情页面添加拼团起止时间 ', $this->createWebUrl('teamworkinfo',array('id' => $_GPC['id'])), 'success');
    }else{
        message('关闭成功！',$this->createWebUrl('teamwork'),'success');
    }
}

include $this->template('web/teamwork');