<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('chbl_sun_groups',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
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
        $data = array(
            'is_vip'=>$_GPC['is_vip'],
            'store_id'=>$_GPC['store_id'],
            'gname' => $_GPC['gname'],
            'uniacid' => $_W['uniacid'],
            'marketprice'=>$_GPC['marketprice'],
            'shopprice'=>$_GPC['shopprice'],
            'groups_num'=>$_GPC['groups_num'],
            'num'=>$_GPC['num'],
            'content' => ihtmlspecialchars($_GPC['content']),
            'starttime' => $_GPC['starttime'],
            'endtime' => $_GPC['endtime'],
            'pic' => $_GPC['pic'],
            'details' => htmlspecialchars_decode($_GPC['details']),
            'status' => 2,
            'selftime' => time(),
            'is_deliver'=>$_GPC['is_deliver'],
            'showindex'=>$_GPC['showindex'],
            'sort'=>$_GPC['sort'],
        );

        if($_GPC['imgs']){
        $data['imgs']=implode(",",$_GPC['imgs']);
        }else{
            $data['imgs']='';
        }
        if (!empty($id)) {
            unset($data['createtime']);
            unset($data['status']);
           $res = pdo_update('chbl_sun_groups',$data, array('id' => $id));
        } else {

           $res = pdo_insert('chbl_sun_groups',$data);
            $id = pdo_insertid();
        }
        if($res){
            message('更新成功！', $this->createWebUrl('groups'), 'success');
        }

}
//给你看看我们的这个  是不是特别乱
include $this->template('web/addgroups');