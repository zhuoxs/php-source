<?php
/**
 * 无人便利架模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page_plugin_forum/');

class Sudu8_page_plugin_forumModuleSite extends WeModuleSite {

    public function doWebFunc(){

        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post','delete', 'checktitle');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];


        //菜单列表
        if ($op == 'display'){
            $_W['page']['title'] = '论坛分类列表';
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_forum_func')." WHERE uniacid = ".$uniacid);
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);
            $cate = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_forum_func')." WHERE uniacid = " . $uniacid . " ORDER BY num DESC,id DESC LIMIT ".$start.",".$pagesize);
        }
        
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_func')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            
            if (checksubmit('submit')) {
                $num = $_GPC['num'];
                if(!$num){
                    $num = 1;
                }

                $status = $_GPC['status'];
                if(!$status){
                    $status = 1;
                }

                $title = $_GPC['title'];
                $is = pdo_fetch("SELECT * FROM".tablename('sudu8_page_forum_func')." WHERE `title` = :title and `id` <> :id", array(':title' => $title, ':id' => $id));
                if($is){
                    message('分类名称重复，请修改！');
                    exit;
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'title' => $_GPC['title'],
                    'func_img' => $_GPC['func_img'],
                    'num' => $num,
                    'status' => $status,
                    'createtime' => date("Y-m-d H:i:s",time()),
                    'page_type' => $_GPC['page_type']
                );

                if (empty($id)) {
                    pdo_insert('sudu8_page_forum_func', $data);
                } else {
                    pdo_update('sudu8_page_forum_func', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                message('分类 添加/修改 成功!', $this->createWebUrl('func', array('op'=>'display')), 'success');

            }

        }
        //删除产品
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_func')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('分类不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_forum_func', array('id' => $id ,'uniacid' => $uniacid)); 
            message('删除成功!', $this->createWebUrl('func', array('op'=>'display')), 'success');

        }
     
        include $this->template('func');
    }

    //发布管理
    public function doWebRelease(){
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post', 'delete', 'hot', 'shenhe');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];

        if($op == 'shenhe'){
            $id = intval($_GPC['id']);
            $flag = intval($_GPC['flag']);
            $res = pdo_update("sudu8_page_forum_release", array('shenhe' => $flag), array('id' => $id));
            if($res){
                message('审核操作成功!', $this->createWebUrl('release', array('op'=>'display')), 'success');
            }else{
                message('审核操作失败!', $this->createWebUrl('release', array('op'=>'display')), 'error');
            }
        }

        //菜单列表
        if ($op == 'display'){
            $_W['page']['title'] = '论坛发布列表';
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_forum_release')." as a left join ".tablename('sudu8_page_user')." as b on a.uid = b.id left join ".tablename('sudu8_page_forum_func')." as c on a.fid = c.id WHERE a.uniacid = ".$uniacid);
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);
            $releaseList = pdo_fetchall("SELECT a.*,b.avatar,b.nickname,c.title as func_title FROM ".tablename('sudu8_page_forum_release')." as a left join ".tablename('sudu8_page_user')." as b on a.uid = b.id left join ".tablename('sudu8_page_forum_func')." as c on a.fid = c.id WHERE a.uniacid = ".$uniacid. " ORDER BY hot ASC, stick ASC, id DESC LIMIT ".$start.",".$pagesize);
            foreach ($releaseList as $key => &$value) {
                $value['nickname'] = rawurldecode($value['nickname']);
                if($value['stick'] == 1){
                    $is = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_stick')."  WHERE `uniacid` = :uniacid and `rid` = :rid and stick = 1 and stick_status = 1", array(':uniacid' => $uniacid, ':rid' => $value['id']));
                    $overtime = strtotime($is['stick_time']) + $is['stick_days'] * 24 * 3600;
                    if($overtime <= time()){
                        pdo_update("sudu8_page_forum_stick", array('stick_status' => 2), array('rid' => $value['id'], 'stick_status' => 1));
                        pdo_update("sudu8_page_forum_release", array('stick' => 2), array('id' => $value['id'], 'stick' => 1));
                        $value['stick'] = 2;
                    }
                }
            }
        }
        
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT a.*,b.avatar,b.nickname,c.title as func_title FROM ".tablename('sudu8_page_forum_release')." as a left join ".tablename('sudu8_page_user')." as b on a.uid = b.id left join ".tablename('sudu8_page_forum_func')." as c on a.fid = c.id WHERE a.id = :id and a.uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
            if($item){

                $item['nickname'] = rawurldecode($item['nickname']);
                
                if($item['stick'] == 1){
                    $is = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_stick')."  WHERE `uniacid` = :uniacid and `rid` = :rid and stick = 1 and stick_status = 1", array(':uniacid' => $uniacid, ':rid' => $item['id']));
                    $overtime = strtotime($is['stick_time']) + $is['stick_days'] * 24 * 3600;
                    if($overtime <= time()){
                        pdo_update("sudu8_page_forum_stick", array('stick_status' => 2), array('rid' => $item['id'], 'stick_status' => 1));
                        pdo_update("sudu8_page_forum_release", array('stick' => 2), array('id' => $item['id'], 'stick' => 1));
                        $item['stick'] = 2;
                    }
                }
                
                $item['stickall'] = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_forum_stick')." WHERE `rid` = :rid and `stick` = 1 ORDER BY id DESC", array(':rid' => $item['id']));
                $item['set'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_set')." WHERE `uniacid` = :uniacid", array(':uniacid' => $uniacid));
                if($item['stickall']){
                    foreach ($item['stickall'] as $k => &$vi) {
                        $vi['moneyAll'] = $vi['stick_money'] * $vi['stick_days'];
                    }
                }else{
                    $item['moneyAll'] = 0;
                }
                
                if($item['img']){
                    $item['img'] = unserialize($item['img']);
                }
                $updatetime = strtotime($item['updatetime']);
                $item['moneyAll'] = $item['stick_money'] * $item['stick_days'];
                if($updatetime < 0){
                    $item['updatetime'] = "";
                }
            }
        }
        
        //删除
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_release')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('发布信息不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_forum_release', array('id' => $id ,'uniacid' => $uniacid)); 
            message('删除成功!', $this->createWebUrl('release', array('op'=>'display')), 'success');

        }

        //推荐
        if ($op == 'hot') {
        
            $id = intval($_GPC['id']);
            $is = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_release')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if ($is['hot'] == 1) {
                $res = pdo_update("sudu8_page_forum_release", array("hot" => 2), array("id" => $id));
            } elseif ($is['hot'] == 2) {
                $res = pdo_update("sudu8_page_forum_release", array("hot" => 1), array("id" => $id));
            }

            message('操作成功!', $this->createWebUrl('release', array('op'=>'display')), 'success');

        }
        include $this->template('release');
    }

    //评论管理
    public function doWebComment(){
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'delete');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];

        //菜单列表
        if ($op == 'display'){
            $_W['page']['title'] = '论坛评论列表';
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_forum_comment')." as a left join ".tablename('sudu8_page_user')." as b on a.uid = b.id WHERE a.uniacid = ".$uniacid);
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);
            $commentList = pdo_fetchall("SELECT a.*,b.avatar,b.nickname FROM ".tablename('sudu8_page_forum_comment')." as a left join ".tablename('sudu8_page_user')." as b on a.uid = b.id WHERE a.uniacid = ".$uniacid. " ORDER BY id DESC LIMIT ".$start.",".$pagesize);
            foreach ($commentList as $key => &$value) {
                $value['nickname'] = rawurldecode($value['nickname']);
                $value['reply'] = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_forum_reply')." WHERE commentId = :commentid", array(":commentid" => $value['id']));
            }


        }
        
        //删除产品
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_comment')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('评论不存在或是已经被删除！');
            }
            $release_comment = pdo_getcolumn("sudu8_page_forum_release", array("uniacid" => $uniacid, "id" => $row['rid']), "comment") - 1;
            pdo_update("sudu8_page_forum_release", array("comment" => $release_comment), array("uniacid" => $uniacid, "id" => $row['rid'])); //评论发布内容评论数减1
            pdo_delete('sudu8_page_forum_comment', array('id' => $id ,'uniacid' => $uniacid)); //删除评论点赞
            pdo_delete('sudu8_page_forum_comment_likes', array('commentId' => $row['id'] ,'uniacid' => $uniacid));  //删除评论点赞


            message('删除成功!', $this->createWebUrl('comment', array('op'=>'display')), 'success');

        }
        include $this->template('comment');
    }

    //设置管理
    public function doWebSet(){
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];

        //菜单列表
        if ($op == 'display'){
            $_W['page']['title'] = '论坛设置管理';
            $set = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forum_set')." WHERE uniacid = ".$uniacid);
            if (checksubmit('submit')) {
                $release_money = $_GPC['release_money'];
                $stick_money = $_GPC['stick_money'];
                $settop = $_GPC['settop'];
                $release_audit = $_GPC['release_audit'];
                if($stick_money == ""){
                    $stick_money = 10;
                }

                $data = array(
                    "release_money" => $release_money,
                    "stick_money" => $stick_money,
                    "settop" => $settop,
                    "release_audit" => $release_audit
                );

                if (!$set) {
                     $data['uniacid'] = $uniacid;
                    pdo_insert('sudu8_page_forum_set', $data);
                } else {
                    pdo_update('sudu8_page_forum_set', $data, array('uniacid' => $uniacid));
                }
                message('评论 设置成功!', $this->createWebUrl('set', array('op'=>'display')), 'success');

            }
        }
        include $this->template('set');
    }


}
