<?php
global $_W,$_GPC;
$op = $_GPC['op'];
$action = array('edit');
$op = in_array($op,$action)?$op:'index';
$id = intval($_GPC['id']);
$model = M('coupon');
$header = pdo_get('ymktv_sun_setting');
if($op=='edit'){
  if(checksubmit()) {
    if($_GPC['type'] == 1){
      unset($_GPC['val']['b'],$_GPC['val']['c']);
    }elseif($_GPC['type'] == 2){
      unset($_GPC['val']['a']);
    }
    $data = array(
      'title' => $_GPC['title'],
      'scene' => $_GPC['scene'],
      'type' => $_GPC['type'],
      'astime' => $_GPC['astime'],
      'antime' => $_GPC['antime'],
      'expiryDate' => $_GPC['expiryDate'],
      'allowance' => $_GPC['allowance'],
      'total' => $_GPC['total'],
      'val' => json_encode($_GPC['val']),
      'exchange' => $_GPC['exchange'],
      'showIndex' => $_GPC['showIndex']?1:0,
    );
      $res = $model->save($data,$id);
      if($res){
        $this->ajaxReturn(0);
      }else{
        $this->ajaxReturn(-1);
      }
  }
  if($id){
    $info = $model->find($id);
    $info['val'] = json_decode($info['val'],true);
  }
}else{
  $pindex = max(1,$_GPC['page']);
  $list = $model->select(($pindex-1)*$this->psize,$this->psize);
}

include $this->template('web/coupon/'.$op);
