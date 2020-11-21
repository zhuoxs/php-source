<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


//
$info=pdo_get('mzhk_sun_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
$brand=pdo_getall('mzhk_sun_brand',array('uniacid'=>$_W['uniacid']));
if($info['zs_imgs']){
    if(strpos($info['zs_imgs'],',')){
        $zs_imgs= explode(',',$info['zs_imgs']);
    }else{
        $zs_imgs=array(
            0=>$info['zs_imgs']
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
    // p($_GPC);die;
    if($_GPC['goods_name']==null) {
        message('请您填写商品名称', '', 'error');
    }elseif($_GPC['survey']==null){
        message('请您填写商品详情','','error');
    }elseif($_GPC['pic']==null){
        message('请您写上传图片','','error');
    }elseif($_GPC['content']==null){
        message('详情不能为空','','error');
    } elseif($_GPC['bid']==null){
        message('分类不能为空','','error');
    }elseif($_GPC['num']==null){
        message('库存不能为零','','error');
    }elseif($_GPC['astime']>=$_GPC['antime']){
        message('活动开始的时间必须比活动结束的时间要早','','error');
    }

    //拼团
    if($_GPC['lid']==3){
        if($_GPC['ptprice']==null){
            message('请您填写商品拼团价格','','error');
        }elseif($_GPC['shopprice']==null){
            message('请您填写商品价格','','error');
        }
    }
    //砍价
    if($_GPC['lid']==2){
        if($_GPC['kjprice']>$_GPC['shopprice']){
            message('砍价不能高于原价', '', 'error');
        }elseif($_GPC['shopprice']==null){
            message('请您填写商品价格','','error');
        }
    }

    //砍价
    if($_GPC['lid']==5){
        if($_GPC['qgprice']>$_GPC['shopprice']){
            message('抢购价不能高于原价', '', 'error');
        }elseif($_GPC['shopprice']==null){
            message('请您填写商品价格','','error');
        }
    }
    //处理图片
    if($_GPC['lb_imgs']){
        $data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
    }else{
        $data['lb_imgs']='';
    }
    $data['qgprice'] = $_GPC['qgprice'];
    $data['kjprice'] = $_GPC['kjprice'];
    $data['ptprice'] = $_GPC['ptprice'];
    $data['ptnum'] = $_GPC['ptnum'];
    $data['shopprice']=$_GPC['shopprice'];
    $data['uniacid']=$_W['uniacid'];
    $data['gname']=$_GPC['goods_name'];
    $data['content']=c($_GPC['content']);
    $data['lid']=$_GPC['lid'];
    $data['status']=1;
    $data['tid']=$_GPC['tid'];
    $data['selftime']=date('Y-m-d H:i:s', time());
    $data['probably']=$_GPC['survey'];
    $data['pic'] = $_GPC['pic'];
    $data['bid'] = $_GPC['bid'];
    $data['num'] = $_GPC['num'];
    $data['astime'] = $_GPC['astime'];
    $data['antime'] = $_GPC['antime'];

    if(empty($_GPC['gid'])){
        $res = pdo_insert('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('mzhk_sun_goods', $data, array('gid' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('goods',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/con');