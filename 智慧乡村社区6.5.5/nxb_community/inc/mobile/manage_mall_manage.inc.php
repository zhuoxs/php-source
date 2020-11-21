<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base();
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken = $_SESSION['webtoken']; //cache_load('webtoken');



if($webtoken==''){
    header('Location: '.$_W['siteroot'].'web/index.php?c=user&a=login&referer='.urlencode($_W['siteroot'].'app/'.$this->createMobileUrl('manage_login_go')));
}else{
    //通过缓存查找到管理员信息
    $manageid = $_SESSION['manageid']; //cache_load('manageid');
    $manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
    $townid=$manage['townid'];
    $nav=intval($_GPC['nav']);
    if($nav==0){
        $nav=1;
    }

    if($_GPC['act'] == 'add_ad_save'){
        if (checksubmit('submit')) {
            $id = intval($_GPC['id']);
            $newdata = array(
                'simg'=>$_GPC['simg'],
                'stitle'=>$_GPC['stitle'],
                'surl'=>$_GPC['surl'],
                'weid'=>$_W['uniacid'],
            );
            if($id){
                $res = pdo_update('bc_community_mall_banner', $newdata, array('id'=>$id));
            }else{
                $res = pdo_insert('bc_community_mall_banner', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_mall_manage',array('act'=>'add_ad')), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_mall_manage',array('act'=>'add_ad')), 'error');
            }
        }
    }
    if($_GPC['act'] == 'add_nav_save'){
        if (checksubmit('submit')) {
            $id = intval($_GPC['id']);
            $newdata = array(
                'nicon'=>$_GPC['nicon'],
                'ntitle'=>$_GPC['ntitle'],
                'nurl'=>$_GPC['nurl'],
                'weid'=>$_W['uniacid'],
            );
            if($id){
                $res = pdo_update('bc_community_mall_nav', $newdata, array('id'=>$id));
            }else{
                $res = pdo_insert('bc_community_mall_nav', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_mall_manage',array('act'=>'add_nav')), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_mall_manage',array('act'=>'add_nav')), 'error');
            }
        }
    }
    if($_GPC['act'] == 'add_class_save'){
        if (checksubmit('submit')) {
            $id = intval($_GPC['id']);
            $newdata = array(
                'cicon'=>$_GPC['cicon'],
                'ctitle'=>$_GPC['ctitle'],
                'weid'=>$_W['uniacid'],
            );
            if($id){
                $res = pdo_update('bc_community_mall_category', $newdata, array('id'=>$id));
            }else{
                $res = pdo_insert('bc_community_mall_category', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_mall_manage',array('act'=>'add_class')), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_mall_manage',array('act'=>'add_class')), 'error');
            }
        }
    }
    if($_GPC['act'] == 'delete_ad'){
        $id=intval($_GPC['id']);
        $result = pdo_delete('bc_community_mall_banner', array('id' =>$id));
        if ($result) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }
    if($_GPC['act'] == 'delete_nav'){
        $id=intval($_GPC['id']);
        $result = pdo_delete('bc_community_mall_nav', array('id' =>$id));
        if ($result) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }
    if($_GPC['act'] == 'delete_class'){
        $id=intval($_GPC['id']);
        $result = pdo_delete('bc_community_mall_category', array('id' =>$id));
        if ($result) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }



    if($_GPC['act'] == 'add_nav') {
        if ($_GPC['id']) {
            $item = pdo_get('bc_community_mall_nav', array('id' => $_GPC['id']));
        }
        $list = pdo_getall('bc_community_mall_nav', array('weid' => $_W['uniacid']));
        include $this->template('manage_mall_nav');
    }else if($_GPC['act'] == 'add_ad'){
            if($_GPC['id']){
                $item = pdo_get('bc_community_mall_banner',array('id'=>$_GPC['id']));
            }
            $list = pdo_getall('bc_community_mall_banner',array('weid'=>$_W['uniacid']));
            include $this->template('manage_mall_ad');
    }else{
        if($_GPC['id']){
            $item = pdo_get('bc_community_mall_category',array('id'=>$_GPC['id']));
        }
        $list = pdo_getall('bc_community_mall_category',array('weid'=>$_W['uniacid']));
        include $this->template('manage_mall_class');
    }

}

?>