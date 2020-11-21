<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzqzk_sun_groups',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$id = $_GPC['id'];

if(checksubmit('submit')){
        if(strlen($_GPC['gname'])> 42){
            message('商品名称字数限制14个');
        }
        $data = array(
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
        );
        if (!empty($id)) {
            unset($data['createtime']);
            unset($data['status']);
           $res = pdo_update('yzqzk_sun_groups',$data, array('id' => $id));
        } else {
           $res = pdo_insert('yzqzk_sun_groups',$data);

            $id = pdo_insertid();
        }
        if($res){
            message('更新成功！', $this->createWebUrl('groups'), 'success');
        }
        exit;

}
include $this->template('web/addgroups');