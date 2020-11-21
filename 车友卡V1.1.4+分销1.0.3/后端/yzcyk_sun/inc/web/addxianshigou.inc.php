<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzcyk_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
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


if($info['lb_imgs']){
    if(strpos($info['lb_imgs'],',')){
        $lb_imgs= explode(',',$info['lb_imgs']);
    }else{
        $lb_imgs=array(
            0=>$info['lb_imgs']
        );
    }
}
if(checksubmit('submit')){
        if(strlen($_GPC['goods_name'])> 42){
            message('商品名称字数限制14个');
        }
        $data = array(
            'goods_name' => $_GPC['goods_name'],
            'lid'=>6,
            'uniacid' => $_W['uniacid'],
            'goods_price'=>$_GPC['goods_price'],
            'num'=>$_GPC['num'],
            'content' => ihtmlspecialchars($_GPC['content']),
            'start_time' =>strtotime($_GPC['start_time']),
            'end_time' =>strtotime($_GPC['end_time']),
            'pic' => $_GPC['pic'],
            'goods_details' => htmlspecialchars_decode($_GPC['goods_details']),
            'time' => time(),
            'show_index'=>$_GPC['show_index'],
            'show_recommend'=>$_GPC['show_recommend'],
            'goods_cost'=>$_GPC['goods_cost'], 
        );
        $data['spec_name']=$_GPC['spec_name'];
        $data['spec_value']=$_GPC['spec_value'];
        $data['spec_names']=$_GPC['spec_names'];
        $data['spec_values']=$_GPC['spec_values'];
        $data['tag']=$_GPC['tag'];
        if($_GPC['imgs']){
            $data['imgs']=implode(",",$_GPC['imgs']);
        }else{
            $data['imgs']='';
        }
        if($_GPC['lb_imgs']){
            $data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
        }else{
            $data['lb_imgs']='';
        }
        if (!empty($id)) {
            unset($data['time']);
           $res = pdo_update('yzcyk_sun_goods',$data, array('id' => $id));
        } else {
           $res = pdo_insert('yzcyk_sun_goods',$data);

            $id = pdo_insertid();
        }
        if($res){
            message('更新成功！', $this->createWebUrl('xianshigou'), 'success');
        }
        exit;

}
include $this->template('web/addxianshigou');