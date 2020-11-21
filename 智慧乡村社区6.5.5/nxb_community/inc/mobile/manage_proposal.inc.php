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
            $pid = intval($_GPC['pid']);
            $newdata = array(
                'ptype'=>$_GPC['ptype'],
                'phandleper'=>$_GPC['phandleper'],
                'phandle'=>$_GPC['phandle'],
                'pstatus'=>$_GPC['pstatus'],
                'phandletime'=>time(),
            );
            $res = pdo_update('bc_community_proposal', $newdata, array('pid'=>$pid));
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_proposal',array('nav'=>14)), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_proposal',array('nav'=>14)), 'error');
            }
        }
    }


    if ($_GPC['act'] == 'type_save') {
        if (checksubmit('submit')) {
            $tid = intval($_GPC['tid']);
            $newdata = array(
                'tname'=>$_GPC['tname'],
                'weid'=>$_W['uniacid'],
                'town_id'=>$townid,
                'tstatus'=>$_GPC['tstatus'],
                'tctime'=>time(),
            );
            if($tid){
                $res = pdo_update('bc_community_type', $newdata, array('tid'=>$tid));
            }else{
                $res = pdo_insert('bc_community_type', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_proposal',array('nav'=>14,'act'=>'type_list')), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_proposal',array('nav'=>14,'act'=>'type_list')), 'error');
            }
        }
    }

    if($_GPC['act'] == 'delete'){
        $pid=intval($_GPC['id']);
        $result = pdo_delete('bc_community_proposal', array('pid' => $pid));
        if (!empty($result)) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }


    if($_GPC['act'] == 'type_delete'){
        $tid=intval($_GPC['tid']);
        $result = pdo_delete('bc_community_type', array('tid' => $tid));
        if (!empty($result)) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }


    if($_GPC['act'] == 'type_list') {
        //分类列表
        $list = pdo_fetchall("SELECT * FROM ".tablename('bc_community_type')." WHERE weid=:uniacid AND town_id=".$townid." ORDER BY tctime",array(':uniacid'=>$_W['uniacid']));
        include $this->template('manage_proposal_type_list');
        exit;
    }


    if($_GPC['act'] == 'view'){
        $type = pdo_fetchall("SELECT * FROM ".tablename('bc_community_type')." WHERE weid=:uniacid AND town_id=".$townid." ORDER BY tctime",array(':uniacid'=>$_W['uniacid']));


	    $pid = $_GPC['id'];
	    $items = pdo_fetch("SELECT * FROM ".tablename('bc_community_proposal')." WHERE pid=$pid");
	    $items['author'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=".$items['mid'],array(':uniacid'=>$_W['uniacid']));
        include $this->template('manage_proposal_view');
	    exit;
    }




    if($_GPC['act'] == 'type_add'){
        $tid = intval($_GPC['tid']);

        $items = pdo_fetch("SELECT * FROM ".tablename('bc_community_type')." WHERE tid=$tid");


        include $this->template('manage_proposal_type_add');
    }else{
        //列表

        $sql = "  AND town_id=$townid";
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_proposal')." WHERE weid=:uniacid $sql",array(':uniacid'=>$_W['uniacid']));
        $page = intval($_GPC['page'])<1?1:intval($_GPC['page']);
        $psize = 15;
        $page_count = ceil($count / $psize);
        $start = ($page-1)*$psize;
        $list = pdo_fetchall("SELECT * FROM ".tablename('bc_community_proposal')." WHERE weid=:uniacid $sql ORDER BY phandletime DESC LIMIT $start,$psize",array(':uniacid'=>$_W['uniacid']));
        $prevpage = $page - 1;
        if($prevpage>=1){
            $prevpageurl = $this->createMobileUrl('manage_post',array('nav'=>11,'page'=>$prevpage));
        }
        $nextpage = $page + 1;
        if($nextpage<=$page_count){
            $nextpageurl = $this->createMobileUrl('manage_post',array('nav'=>11,'page'=>$nextpage));
        }
        $s = $page - 2;
        $pages = array();
        for($i = 0; $i<=4; $i++){
            $t = $i + $s;
            if($t>=1 && $t<=$page_count){
                $pages[] = array(
                    'page' => $t,
                    'url' => $this->createMobileUrl('manage_post',array('nav'=>11,'page'=>$t)),
                    'active' => ($t==$page?true:false)
                );
            }
        }

        foreach ($list as $key=>$value){
            $list[$key]['type_name'] = pdo_fetchcolumn("SELECT tname FROM ".tablename('bc_community_type')." WHERE weid=:uniacid AND tid=".$value['ptype'],array(':uniacid'=>$_W['uniacid']));
            $list[$key]['author'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=".$value['mid'],array(':uniacid'=>$_W['uniacid']));

        }

        include $this->template('manage_proposal');
    }

}





?>