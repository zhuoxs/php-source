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


    if ($_GPC['act'] == 'save') {
        if (checksubmit('submit')) {
            $id = intval($_GPC['sights_id']);
            $newdata = array(
                'weid'=>$_W['uniacid'],
                'sights_name'=>$_GPC['sights_name'],
                'price'=>$_GPC['price'],
                'tel'=>$_GPC['tel'],
                'businesshours'=>$_GPC['businesshours'],
                'address'=>$_GPC['address'],
                'latlong'=>$_GPC['latlong'],
                'content' => $_GPC['content'],
                'town_id'=>$townid,
            );
            if($_GPC['cover']){
                $newdata['cover'] = $_GPC['cover'];
            }
            if($id){
                $res = pdo_update('bc_community_tour_sights', $newdata, array('sights_id'=>$id));
            }else{
                $newdata['dateline'] = time();
                $res = pdo_insert('bc_community_tour_sights', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_tour_sights',array('nav'=>11)), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_tour_sights',array('nav'=>11)), 'error');
            }
        }
    }
    if($_GPC['act'] == 'delete'){
        $id=intval($_GPC['sights_id']);
        $result = pdo_delete('bc_community_tour_sights', array('sights_id' =>$id));
        if (!empty($result)) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }





    if($_GPC['act'] == 'add'){
        $id = intval($_GPC['sights_id']);

        $sights = pdo_fetch("SELECT * FROM ".tablename('bc_community_tour_sights')." WHERE sights_id=:id",array(':id'=>$id));
        $sights['content'] = htmlspecialchars_decode($sights['content']);

        include $this->template('manage_tour_sights_add');
    }else{

	    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_tour_sights')." WHERE weid=:uniacid AND town_id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$townid));
        $page = intval($_GPC['page'])<1?1:intval($_GPC['page']);
	    $psize = 10;
        $page_count = ceil($count / $psize);
        $start = ($page-1)*$psize;
        $sightslist = pdo_fetchall("SELECT * FROM ".tablename('bc_community_tour_sights')." WHERE weid=:uniacid AND town_id=:id ORDER BY dateline DESC LIMIT $start,$psize",array(':uniacid'=>$_W['uniacid'],':id'=>$townid));
        $prevpage = $page - 1;
        if($prevpage>=1){
            $prevpageurl = $this->createMobileUrl('manage_tour_sights',array('nav'=>11,'page'=>$prevpage));
        }
        $nextpage = $page + 1;
        if($nextpage<=$page_count){
            $nextpageurl = $this->createMobileUrl('manage_tour_sights',array('nav'=>11,'page'=>$nextpage));
        }
        $s = $page - 2;
        $pages = array();
        for($i = 0; $i<=4; $i++){
            $t = $i + $s;
            if($t>=1 && $t<=$page_count){
                $pages[] = array(
                    'page' => $t,
                    'url' => $this->createMobileUrl('manage_tour_sights',array('nav'=>11,'page'=>$t)),
                    'active' => ($t==$page?true:false)
                );
            }
        }
        include $this->template('manage_tour_sights');
    }

}





?>