<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('chbl_sun_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$id = $_GPC['id'];
if($info['imgs']){
    if(strpos($info['imgs'],',')){
        $imgs= explode(',',$info['imgs']);
    }else{
        $imgs=array(
            0=>$info['imgs']
        );
    }
}
//查找出所有门店
$store = pdo_getall('chbl_sun_store_active',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    if($_GPC['store_id']==0 || !$_GPC['store_id']){
        message('请选择门店名称！');
    }
    if(!$_GPC['share_title'] || !$_GPC['part_bargain_num']){
        message('请填写分享标题或者可参与人数！');
    }
    $data = array(
        'store_id'=>$_GPC['store_id'],
        'gname' => $_GPC['gname'],
        'uniacid' => $_W['uniacid'],
        'marketprice'=>$_GPC['marketprice'],
        'shopprice'=>$_GPC['shopprice'],
        'num'=>$_GPC['num'],
        'showindex'=>$_GPC['showindex'],
        'content' => ihtmlspecialchars($_GPC['content']),
        'starttime' => $_GPC['starttime'],
        'endtime' => $_GPC['endtime'],
        'share_title' => $_GPC['share_title'],
        'part_bargain_num' => $_GPC['part_bargain_num'],
        'is_vip' => $_GPC['is_vip'],
        'pic' => $_GPC['pic'],
        'details' => htmlspecialchars_decode($_GPC['details']),
        'status' => 2,
        'selftime' => time(),
        'lowdebuxing' => $_GPC['lowdebuxing'],
        'sort' => $_GPC['sort'],
    );
    if($_GPC['imgs']){
        $data['imgs']=implode(",",$_GPC['imgs']);
    }else{
        $data['imgs']='';
    }
    if (!empty($id)) {
        unset($data['createtime']);
        unset($data['status']);
       $res = pdo_update('chbl_sun_bargain',$data, array('id' => $id));
    } else {
       $res = pdo_insert('chbl_sun_bargain',$data);
//            $id = pdo_insertid();
    }
    if($res){
        message('更新成功！', $this->createWebUrl('bargainlist'), 'success');
    }

}
include $this->template('web/addbargain');