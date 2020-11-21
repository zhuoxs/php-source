<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken = $_SESSION['webtoken']; //cache_load('webtoken');
$index_name = pdo_getcolumn('bc_community_base', array('id' => 1),'article_index_name');


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
            $sid = intval($_GPC['sid']);
            $newdata = array(
                'weid'=>$_W['uniacid'],
                'service_name'=>$_GPC['service_name'],
                'parent_id'=>intval($_GPC['parent_id']),
                'town_id'=>$townid,
                'icon'=>$_GPC['icon'],
                'url'=>$_GPC['url']
            );
            if($sid){
                $res = pdo_update('bc_community_service', $newdata, array('sid'=>$sid));
            }else{
                $newdata['dateline'] = time();
                $res = pdo_insert('bc_community_service', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_service',array('nav'=>17)), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_service',array('nav'=>17)), 'error');
            }
        }
    }
    if ($_GPC['act'] == 'add_class_save') {
        if (checksubmit('submit')) {
            $cid = intval($_GPC['cid']);
            $newdata = array(
                'weid'=>$_W['uniacid'],
                'classname'=>$_GPC['classname'],
                'parent_id'=>$_GPC['parent_id'],
                'town_id'=>$townid
            );
            if($cid){
                $res = pdo_update('bc_community_article_class', $newdata, array('cid'=>$cid));
            }else{
                $newdata['dateline'] = time();
                $res = pdo_insert('bc_community_article_class', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_article',array('nav'=>16)), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_article',array('nav'=>16)), 'error');
            }
        }
    }
    if ($_GPC['act'] == 'article_add_save') {
        if (checksubmit('submit')) {

            if(empty($_GPC['title'])){
                message('请填写标题', '', 'error');
            }
            if(empty($_GPC['class_id'])){
                message('请选择栏目', '', 'error');
            }
            if(empty($_GPC['content'])){
                message('请选择栏目', '', 'error');
            }

            $aid = intval($_GPC['aid']);
            $newdata = array(
                'weid'=>$_W['uniacid'],
                'class_id'=>$_GPC['class_id'],
                'author_id'=>$manageid,
                'title'=>$_GPC['title'],
                'cover'=>$_GPC['cover'],
                'slide'=>$_GPC['slide'],
                'recommend'=>$_GPC['recommend'],
                'content'=>$_GPC['content'],
                'town_id'=>$townid,
            );
            if($aid){
                $res = pdo_update('bc_community_article', $newdata, array('aid'=>$aid));
            }else{
                $newdata['dateline'] = time();
                $res = pdo_insert('bc_community_article', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_article',array('parent_id'=>$_GPC['class_id'],'act'=>'article_list')), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_article',array('parent_id'=>$_GPC['class_id'],'act'=>'article_list')), 'error');
            }
        }
    }

    if($_GPC['act'] == 'add_slide_save'){
        if (checksubmit('submit')) {
            $id = intval($_GPC['id']);
            $newdata = array(
                'weid'=>$_W['uniacid'],
                'cover'=>$_GPC['cover'],
                'url'=>$_GPC['url'],
                'type'=>1,
                'town_id'=>$townid,
            );


            if($id){
                $res = pdo_update('bc_community_slide', $newdata, array('id'=>$id));
            }else{
                $res = pdo_insert('bc_community_slide', $newdata);
            }
            if (!empty($res)) {
                message('恭喜，提交成功', $this -> createMobileUrl('manage_service',array('act'=>'slide')), 'success');
            } else {
                message('抱歉，提交失败！', $this -> createMobileUrl('manage_service',array('act'=>'slide')), 'error');
            }
        }
    }



    if($_GPC['act'] == 'displayorder_save'){
	    foreach ($_GPC['sid'] as $key=>$value){
	        $data = array(
	            'displayorder'=>intval($_GPC['displayorder'][$key])
            );
	        pdo_update('bc_community_service',$data,array('sid'=>$value));
        }
        message('排序设置提交成功', $this -> createMobileUrl('manage_service',array('nav'=>17)), 'success');
    }



    if($_GPC['act'] == 'delete_slide'){
        $id=intval($_GPC['id']);
        $result = pdo_delete('bc_community_slide', array('id' =>$id));
        if ($result) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }


    if($_GPC['act'] == 'article_delete'){
        $aid=intval($_GPC['aid']);
        $result = pdo_delete('bc_community_article', array('aid' =>$aid));
        if ($result) {
            echo json_encode(array('status'=>1,'log'=>'删除成功','cids'=>$cids));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败','cids'=>$cids));
        }
        exit;
    }
    if($_GPC['act'] == 'article_delete_batch'){   //批量删除
        foreach ($_GPC['aid'] as $value){
            $aid=intval($value);
            $result = pdo_delete('bc_community_article', array('aid' =>$aid));
        }
        echo json_encode(array('status'=>1,'log'=>'删除成功','aids'=>$_GPC['aid']));
        exit;
    }

    if($_GPC['act'] == 'article_move_batch'){  //批量移动
	    $cid = intval($_GPC['cid']);
        foreach ($_GPC['aid'] as $value){
            $aid=intval($value);
            $result = pdo_update('bc_community_article',array('class_id'=>$cid), array('aid' =>$aid));
        }
        echo json_encode(array('status'=>1,'log'=>'移动成功','aids'=>$_GPC['aid']));
        exit;
    }

    if($_GPC['act'] == 'article_slide_batch'){  //批量设置幻灯
        foreach ($_GPC['aid'] as $value){
            $aid=intval($value);
            if($_GPC['slide'] == 'yes'){
                $result = pdo_update('bc_community_article',array('slide'=>1), array('aid' =>$aid));
            }
            if($_GPC['slide'] == 'no'){
                $result = pdo_update('bc_community_article',array('slide'=>0), array('aid' =>$aid));
            }
        }
        echo json_encode(array('status'=>1,'log'=>'设置成功','aids'=>$_GPC['aid']));
        exit;
    }

    if($_GPC['act'] == 'article_recommend_batch'){  //批量设置推荐
        foreach ($_GPC['aid'] as $value){
            $aid=intval($value);
            if($_GPC['recommend'] == 'yes'){
                $result = pdo_update('bc_community_article',array('recommend'=>1), array('aid' =>$aid));
            }
            if($_GPC['recommend'] == 'no'){
                $result = pdo_update('bc_community_article',array('recommend'=>0), array('aid' =>$aid));
            }
        }
        echo json_encode(array('status'=>1,'log'=>'设置成功','aids'=>$_GPC['aid']));
        exit;
    }




    if($_GPC['act'] == 'delete'){
        $sid=intval($_GPC['sid']);
        $sids = deleteclass($sid);
        //$result = pdo_delete('bc_community_article_class', array('cid' =>$cid));
        if (count($sids)>0) {
            echo json_encode(array('status'=>1,'log'=>'删除成功','sids'=>$sids));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败','sids'=>$sids));
        }
        exit;
    }

    if($_GPC['act'] == 'getchild'){
        $sid=intval($_GPC['sid']);
        $sids = getchildclass($sid);
        echo json_encode(array('sids'=>$sids));
        exit;
    }

    if($_GPC['act'] == 'edit_index_name'){
        $result = pdo_update('bc_community_base',array('article_index_name'=>$_GPC['indexname']), array('id' =>1));
        if($result){
            echo json_encode(array('status'=>1,'log'=>'设置成功'));
        }else{
            echo json_encode(array('status'=>2,'log'=>'设置失败'));
        }
        exit;
    }





    if($_GPC['act'] == 'add') {  //添加首页
        $sid = intval($_GPC['sid']);
        $item = pdo_fetch("SELECT * FROM ".tablename('bc_community_service')." WHERE sid=:sid",array(':sid'=>$sid));

        if($item['parent_id']){
            $parent_id = $item['parent_id'];
        }else{
            $parent_id = intval($_GPC['parent_id']);
        }

        $parent = pdo_fetchall("SELECT * FROM ".tablename('bc_community_service')." WHERE weid=:uniacid AND parent_id=0",array(':uniacid'=>$_W['uniacid']));


        include $this->template('manage_service_add');
    }else if($_GPC['act'] == 'slide') {  //添加市首页导航
        if($_GPC['id']){
            $item = pdo_get('bc_community_slide',array('id'=>$_GPC['id']));
        }
        $list = pdo_getall('bc_community_slide',array('weid'=>$_W['uniacid'],'type'=>1,'town_id'=>$townid));
        include $this->template('manage_service_slide');
    }else{

	    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_service')." WHERE weid=:uniacid AND town_id=:id AND parent_id=0",array(':uniacid'=>$_W['uniacid'],':id'=>$townid));
        $page = intval($_GPC['page'])<1?1:intval($_GPC['page']);
	    $psize = 10;
        $page_count = ceil($count / $psize);
        $start = ($page-1)*$psize;
        $list = pdo_fetchall("SELECT * FROM ".tablename('bc_community_service')." WHERE weid=:uniacid AND town_id=:id AND parent_id=0 ORDER BY displayorder DESC,dateline DESC LIMIT $start,$psize",array(':uniacid'=>$_W['uniacid'],':id'=>$townid));
        $prevpage = $page - 1;
        if($prevpage>=1){
            $prevpageurl = $this->createMobileUrl('manage_service',array('nav'=>16,'page'=>$prevpage));
        }
        $nextpage = $page + 1;
        if($nextpage<=$page_count){
            $nextpageurl = $this->createMobileUrl('manage_service',array('nav'=>16,'page'=>$nextpage));
        }
        $s = $page - 2;
        $pages = array();
        for($i = 0; $i<=4; $i++){
            $t = $i + $s;
            if($t>=1 && $t<=$page_count){
                $pages[] = array(
                    'page' => $t,
                    'url' => $this->createMobileUrl('manage_service',array('nav'=>16,'page'=>$t)),
                    'active' => ($t==$page?true:false)
                );
            }
        }
        foreach ($list as $key=>$value){
            $list[$key]['child'] = pdo_fetchall("SELECT * FROM ".tablename('bc_community_service')." WHERE parent_id=".$value['sid']." ORDER BY displayorder DESC");
        }
        include $this->template('manage_service');
    }

}



function getparentid($sid){
    static $tmp;
    $parent = pdo_fetch("SELECT * FROM ".tablename('bc_community_service')." WHERE sid=:sid",array(':sid'=>$sid));
    if($parent['parent_id']>0){
        $tmp = getparentid($parent['parent_id']);
    }else{
        $tmp = $sid;
    }
    return $tmp;
}



//找出所有子栏目
function getchildclass($sid){
    static $tmp = array();
    $child = pdo_fetchall("SELECT * FROM ".tablename('bc_community_service')." WHERE parent_id=:sid",array(':sid'=>$sid));
    if(count($child)>0){
        foreach ($child as $value){
            getchildclass($value['sid']);
        }
        $tmp[] = $sid;
    }else{
        $tmp[] = $sid;
    }
    return $tmp;
}



//使用递归实现找出所有子栏目的ID,且删除栏目
function deleteclass($sid){
    static $tmp = array();
    $child = pdo_fetchall("SELECT * FROM ".tablename('bc_community_service')." WHERE parent_id=:sid",array(':sid'=>$sid));
    if(count($child)>0){
        foreach ($child as $value){
            deleteclass($value['cid']);
        }
        $tmp[] = $sid;
        pdo_delete('bc_community_service', array('sid' =>$sid));
    }else{
        $tmp[] = $sid;
        pdo_delete('bc_community_service', array('sid' =>$sid));
    }
    return $tmp;
}

//使用递归实现无限极分类
function digui($data,$parent_id = 0 ,$cengji = 0)
{
    //使用静态定义
    static $tmp = array();
    foreach($data as $k=>$v)
    {
        //判断如果“层级ID==自增ID”
        if($v['parent_id'] == $parent_id)
        {
            $v['cengji'] = $cengji;
            $tmp[] = $v;
            digui($data,$v['cid'],$cengji+1);
        }
    }
    return $tmp;
}


?>