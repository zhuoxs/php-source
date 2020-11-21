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
    $menulist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_tour_nav')." WHERE weid=:uniacid AND town_id=:townid",array(':uniacid'=>$_W['uniacid'],':townid'=>$townid));
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}


	if(empty($menulist)){
	    pdo_insert('bc_community_tour_nav',array('weid'=>$_W['uniacid'],'town_id'=>$townid,'title'=>'乡村概况','lock'=>1));
        pdo_insert('bc_community_tour_nav',array('weid'=>$_W['uniacid'],'town_id'=>$townid,'title'=>'景点','lock'=>1));
        pdo_insert('bc_community_tour_nav',array('weid'=>$_W['uniacid'],'town_id'=>$townid,'title'=>'美食','lock'=>1));
        pdo_insert('bc_community_tour_nav',array('weid'=>$_W['uniacid'],'town_id'=>$townid,'title'=>'住宿','lock'=>1));
    }


    if ($_W['ispost']) {
        if (checksubmit('submit')) {
            $id = intval($_GPC['nav_id']);
            $newdata = array(
                'weid'=>$_W['uniacid'],
                'title'=>$_GPC['title'],
                'url'=>$_GPC['url'],
                'town_id'=>$townid,
            );
            if($_GPC['icon']){
                $newdata['icon'] = $_GPC['icon'];
            }
            if($id){
                $res = pdo_update('bc_community_tour_nav', $newdata, array('id'=>$id));
            }else{
                $newdata['dateline'] = time();
                $res = pdo_insert('bc_community_tour_nav', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_tour_nav',array('nav'=>11)), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_tour_nav',array('nav'=>11)), 'error');
            }
        }
    }
    if($_GPC['act'] == 'delete'){
        $id=intval($_GPC['id']);
        $result = pdo_delete('bc_community_tour_nav', array('id' =>$id,'lock'=>0));
        if (!empty($result)) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }


    $id = intval($_GPC['nav_id']);
    $nav = pdo_fetch("SELECT * FROM ".tablename('bc_community_tour_nav')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));

	include $this->template('manage_tour_nav');
}





?>