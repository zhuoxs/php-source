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
    $info = pdo_fetch("SELECT * FROM ".tablename("bc_community_tour_info")." WHERE weid=:uniacid AND town_id=:town_id",array(':uniacid'=>$_W['uniacid'],':town_id'=>$townid));
	if($_W['ispost']){
	    $data = array();
	    $data['weid'] = $_W['uniacid'];
	    $data['town_id'] = $manage['townid'];
	    $data['hushu'] = $_GPC['hushu'];
        $data['zongmianji'] = $_GPC['zongmianji'];
        $data['hezuoshe'] = $_GPC['hezuoshe'];
        $data['pinkunhu'] = $_GPC['pinkunhu'];
        $data['nongtian'] = $_GPC['nongtian'];
        $data['zhuyaoxinshi'] = $_GPC['zhuyaoxinshi'];
        $data['tel'] = $_GPC['tel'];
        if($_GPC['cover']){
            $data['cover'] = $_GPC['cover'][0];
            $data['photoalbum'] = serialize($_GPC['cover']);
        }
        $data['content'] = $_GPC['content'];
        if($info['tour_id']){
            $res = pdo_update('bc_community_tour_info', $data,array('tour_id'=>$info['tour_id']));
        }else{
            $data['dateline'] = time();
            $res = pdo_insert('bc_community_tour_info', $data);
        }
        if (!empty($res)) {
            message('提交成功', $this -> createMobileUrl('manage_tour').'&nav=11', 'success');
        }else{
            message('提交失败', $this -> createMobileUrl('manage_tour').'&nav=11', 'error');
        }

    }


    $info['photoalbum'] = unserialize($info['photoalbum']);
    $info['content'] = htmlspecialchars_decode($info['content']);

	include $this->template('manage_tour');
}





?>