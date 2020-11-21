<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('chbl_sun_active',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$id = $_GPC['id'];
if (!empty($id)) {
    $item = pdo_fetch("SELECT *  FROM " . tablename('chbl_sun_active') . " WHERE id = :id", array(':id' => $id));
    $piclist1 = unserialize($item['thumb_url']);
    $piclist = array();
    if(is_array($piclist1)){
        foreach($piclist1 as $p){
            $piclist[] = is_array($p)?$p['attachment']:$p;
        }
    }
}

if($info['details']){
    if(strpos($info['details'],',')){
        $detailimgs= explode(',',$info['details']);
    }else{
        $detailimgs=array(
            0=>$info['details']
        );
    }
}

//查找出所有门店
$store = pdo_getall('chbl_sun_store_active',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    if($_GPC['store_id']==0 || !$_GPC['store_id']){
        message('请选择门店名称！');
    }
        if(is_array($_GPC['thumbs'])){
            $thumb_data['thumb_url'] = serialize($_GPC['thumbs']);
        }
        if($_GPC['detailimgs']){
            $datas['details']=implode(",",$_GPC['detailimgs']);
        }else{
            $datas['details']='';
        }

        $data = array(
            'font_details'=>$_GPC['font_details'],
            'store_id'=>$_GPC['store_id'],
            'storeinfo' => $_GPC['storeinfo'],
            'uniacid' => $_W['uniacid'],
            'title'=>$_GPC['title'],
            'subtitle'=>$_GPC['subtitle'],
            'content' => ihtmlspecialchars($_GPC['content']),
            'astime' => $_GPC['astime'],
            'antime' => $_GPC['antime'],
            'active_num' => $_GPC['active_num'],
            'share_plus' => $_GPC['share_plus'],
            'new_partnum' => $_GPC['new_partnum'],
            'sort'=>$_GPC['sort'],
            'showindex' => $_GPC['showindex'],
            'thumb'=>$_GPC['thumb'],
            'sharenum'=>$_GPC['sharenum'],
            'createtime' => TIMESTAMP,
            'num'=>$_GPC['num'],
            'details'=>$datas['details'],
            'thumb_url'=>$thumb_data['thumb_url'],
            'is_vip'=>$_GPC['is_vip'],
        );
        if (!empty($id)) {
            unset($data['createtime']);
            pdo_update('chbl_sun_active', $data, array('id' => $id));
        } else {
            pdo_insert('chbl_sun_active', $data);
            $id = pdo_insertid();
        }
        message('更新成功！', $this->createWebUrl('active'), 'success');
        }
include $this->template('web/addactive');