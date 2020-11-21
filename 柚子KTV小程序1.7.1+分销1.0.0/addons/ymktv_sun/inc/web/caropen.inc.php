<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$coupon = pdo_get('ymktv_sun_coupon', array('id' => $_GPC['id']));

if (checksubmit('submit')) {
    $data['weid'] = $_W['weid'];
    $data['title'] = $_GPC['title'];
    if (empty($_GPC['type'])) {
        //暂时未启用优惠券类型功能,将优惠券类型设置为代金券(包含满减类型)
        $data['type'] = $_GPC['type'] = 2;
    }
    $data['astime'] = $_GPC['astime'];
    $data['antime'] = $_GPC['antime'];
    $data['expiryDate'] = $_GPC['expiryDate'];
    $data['allowance'] = $_GPC['allowance'];
    $data['total'] = $_GPC['total'];
    $data['val'] = json_encode($_GPC['val']);
//    $data['exchange'] = $_GPC['exchange'];
    $data['scene'] = $_GPC['scene'];
    $data['showIndex'] = $_GPC['showIndex'];

    if (empty($_GPC['id'])) {
        $res = pdo_insert('ymktv_sun_coupon', $data);
    } else {
        $res = pdo_update('ymktv_sun_coupon', $data);
    }

    if ($res) {
        message('编辑成功', $this->createWebUrl('caropen', array(), 'success'));
    } else {
        message('编辑失败', '', 'error');
    }
}

include $this->template('web/caropen');

//<?php
//global $_W,$_GPC;
//$op = $_GPC['op'];
//$action = array('edit');
//$op = in_array($op,$action)?$op:'index';
//$id = intval($_GPC['id']);
//$model = M('coupon');
//$header = pdo_get('hssd_sun_setting');
//if($op=='edit'){
//    if(checksubmit()) {
//        if($_GPC['type'] == 1){
//            unset($_GPC['val']['b'],$_GPC['val']['c']);
//        }elseif($_GPC['type'] == 2){
//            unset($_GPC['val']['a']);
//        }
//        $data = array(
//            'title' => $_GPC['title'],
//            'scene' => $_GPC['scene'],
//            'type' => $_GPC['type'],
//            'astime' => $_GPC['astime'],
//            'antime' => $_GPC['antime'],
//            'expiryDate' => $_GPC['expiryDate'],
//            'allowance' => $_GPC['allowance'],
//            'total' => $_GPC['total'],
//            'val' => json_encode($_GPC['val']),
//            'exchange' => $_GPC['exchange'],
//            'showIndex' => $_GPC['showIndex']?1:0,
//        );
//        $res = $model->save($data,$id);
//        if($res){
//            $this->ajaxReturn(0);
//        }else{
//            $this->ajaxReturn(-1);
//        }
//    }
//    if($id){
//        $info = $model->find($id);
//        $info['val'] = json_decode($info['val'],true);
//    }
//}else{
//    $pindex = max(1,$_GPC['page']);
//    $list = $model->select(($pindex-1)*$this->psize,$this->psize);
//}
//
//include $this->template('web/caropen');
