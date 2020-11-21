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
            $nid = intval($_GPC['nid']);
            $newdata = array(
                'ntitle'=>$_GPC['ntitle'],
                'ntext'=>$_GPC['ntext'],
                'lxfs'=>$_GPC['lxfs'],
                'name'=>$_GPC['name'],
                'top'=>intval($_GPC['top']),
                'choice'=>intval($_GPC['choice']),
                'status'=>$_GPC['status'],
            );
            $res = pdo_update('bc_community_news', $newdata, array('nid'=>$nid));
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_post',array('nav'=>12)), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_post',array('nav'=>12)), 'error');
            }
        }
    }
    if($_GPC['act'] == 'delete'){
        $nid=intval($_GPC['nid']);
        $result = pdo_delete('bc_community_news', array('nid' => $nid));
        if (!empty($result)) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }
    if($_GPC['act'] == 'c_delete'){
        $cid=intval($_GPC['cid']);
        $result = pdo_delete('bc_community_comment', array('cid' => $cid));
        if (!empty($result)) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }




    if($_GPC['act'] == 'view') {
        $nid = intval($_GPC['nid']);

        $post = pdo_fetch("SELECT * FROM " . tablename('bc_community_news') . " WHERE nid=$nid");
        $post['author'] = pdo_fetchcolumn("SELECT nickname FROM " . tablename('bc_community_member') . " WHERE weid=:uniacid AND mid=" . $post['mid'], array(':uniacid' => $_W['uniacid']));
        $post['nmenu_name'] = pdo_fetchcolumn("SELECT mtitle FROM " . tablename('bc_community_menu') . " WHERE weid=:uniacid AND meid=" . $post['nmenu'], array(':uniacid' => $_W['uniacid']));

        include $this->template('manage_post_view');
    }else if($_GPC['act'] == 'zyhd'){
        //查找志愿活动这个栏目的ID变量
        $res=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'志愿活动'));
        if(!empty($res)){
            $zyfwid=$res['meid'];
        }else{
            $zyfwid=0;
        }
        $sql = " AND nmenu=$zyfwid";
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_news')." WHERE weid=:uniacid $sql ",array(':uniacid'=>$_W['uniacid']));
        $page = intval($_GPC['page'])<1?1:intval($_GPC['page']);
        $psize = 10;
        $page_count = ceil($count / $psize);
        $start = ($page-1)*$psize;
        $list = pdo_fetchall("SELECT * FROM ".tablename('bc_community_news')." WHERE weid=:uniacid $sql ORDER BY nid DESC LIMIT $start,$psize",array(':uniacid'=>$_W['uniacid']));

        $prevpage = $page - 1;
        if($prevpage>=1){
            $prevpageurl = $this->createMobileUrl('manage_post',array('nav'=>12,'act'=>'comment','page'=>$prevpage));
        }
        $nextpage = $page + 1;
        if($nextpage<=$page_count){
            $nextpageurl = $this->createMobileUrl('manage_post',array('nav'=>12,'act'=>'comment','page'=>$nextpage));
        }
        $s = $page - 2;
        $pages = array();
        for($i = 0; $i<=4; $i++){
            $t = $i + $s;
            if($t>=1 && $t<=$page_count){
                $pages[] = array(
                    'page' => $t,
                    'url' => $this->createMobileUrl('manage_post',array('nav'=>11,'act'=>'comment','page'=>$t)),
                    'active' => ($t==$page?true:false)
                );
            }
        }

        include $this->template('manage_post_zyhd');
    }else if($_GPC['act'] == 'bmjl'){
        include $this->template('manage_post_bmjl');
    }else if($_GPC['act'] == 'comment'){
        $nid = intval($_GPC['nid']);
        $sql = " AND newsid = $nid";
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_comment')." WHERE weid=:uniacid $sql ",array(':uniacid'=>$_W['uniacid']));
        $page = intval($_GPC['page'])<1?1:intval($_GPC['page']);
        $psize = 10;
        $page_count = ceil($count / $psize);
        $start = ($page-1)*$psize;
        $list = pdo_fetchall("SELECT * FROM ".tablename('bc_community_comment')." WHERE weid=:uniacid $sql ORDER BY cctime DESC LIMIT $start,$psize",array(':uniacid'=>$_W['uniacid']));

        $prevpage = $page - 1;
        if($prevpage>=1){
            $prevpageurl = $this->createMobileUrl('manage_post',array('nav'=>12,'act'=>'comment','page'=>$prevpage));
        }
        $nextpage = $page + 1;
        if($nextpage<=$page_count){
            $nextpageurl = $this->createMobileUrl('manage_post',array('nav'=>12,'act'=>'comment','page'=>$nextpage));
        }
        $s = $page - 2;
        $pages = array();
        for($i = 0; $i<=4; $i++){
            $t = $i + $s;
            if($t>=1 && $t<=$page_count){
                $pages[] = array(
                    'page' => $t,
                    'url' => $this->createMobileUrl('manage_post',array('nav'=>11,'act'=>'comment','page'=>$t)),
                    'active' => ($t==$page?true:false)
                );
            }
        }
        foreach ($list as $key=>$value) {
            $list[$key]['author'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=".$value['mid'],array(':uniacid'=>$_W['uniacid']));
        }

        include $this->template('manage_post_comment');
    }else{
        //分类列表
        $classlist = pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND townid=".$townid." ORDER BY createtime",array(':uniacid'=>$_W['uniacid']));


        $sql = '';
        if($_GPC['nmenu']){
            $sql .= " AND nmenu=".$_GPC['nmenu'];
        }
        if($manage['lev'] == 2){
            $sql .= " AND danyuan=".$townid;
        }elseif($manage['lev'] == 3){
            $sql .= " AND menpai=".$townid;
        }elseif($manage['lev'] == 0){
            $sql .= " ";
        }
        echo $sql;

	    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_news')." WHERE weid=:uniacid $sql",array(':uniacid'=>$_W['uniacid']));
        $page = intval($_GPC['page'])<1?1:intval($_GPC['page']);
	    $psize = 10;
        $page_count = ceil($count / $psize);
        $start = ($page-1)*$psize;
        $postlist = pdo_fetchall("SELECT * FROM ".tablename('bc_community_news')." WHERE weid=:uniacid $sql ORDER BY nctime DESC LIMIT $start,$psize",array(':uniacid'=>$_W['uniacid']));


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

        foreach ($postlist as $key=>$value){
            $postlist[$key]['nmenu_name'] = pdo_fetchcolumn("SELECT mtitle FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND meid=".$value['nmenu'],array(':uniacid'=>$_W['uniacid']));
            $postlist[$key]['author'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=".$value['mid'],array(':uniacid'=>$_W['uniacid']));
            if($value['top']){
                $postlist[$key]['top_txt'] = '是';
            }
            if($value['choice']){
                $postlist[$key]['choice_txt'] = '是';
            }


            if($value['status']){
                $postlist[$key]['status_txt'] = '已审核';
            }else{
                $postlist[$key]['status_txt'] = '未审核';
            }
        }




        include $this->template('manage_post');
    }

}





?>