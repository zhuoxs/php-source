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


    if($_GPC['act'] == 'add_adslide_save'){
        if (checksubmit('submit')) {
            $id = intval($_GPC['id']);
            $newdata = array(
                'weid'=>$_W['uniacid'],
                'cover'=>$_GPC['cover'],
                'url'=>$_GPC['url'],
                'type'=>2,
                'town_id'=>$townid,
            );


            if($id){
                $res = pdo_update('bc_community_slide', $newdata, array('id'=>$id));
            }else{
                $res = pdo_insert('bc_community_slide', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_setting',array('act'=>'add_adslide')), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_setting',array('act'=>'add_adslide')), 'error');
            }
        }
    }

    if($_GPC['act'] == 'delete_adslide'){
        $id=intval($_GPC['id']);
        $result = pdo_delete('bc_community_slide', array('id' =>$id));
        if ($result) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }


    if($_GPC['id']){
        $item = pdo_get('bc_community_slide',array('id'=>$_GPC['id']));
    }
    $list = pdo_getall('bc_community_slide',array('weid'=>$_W['uniacid'],'type'=>2,'town_id'=>$townid));

    include $this->template('manage_setting_adslide');
}

?>