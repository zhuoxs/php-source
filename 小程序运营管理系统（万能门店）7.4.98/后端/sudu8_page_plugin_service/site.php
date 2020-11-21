<?php
/**
 * 小程序手机客服模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("HTTPSHOST",$_W['attachurl']);
class Sudu8_page_plugin_serviceModuleSite extends WeModuleSite {

    public function doWebBase() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];
        if ($op == 'display'){
            $base = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_p_s_base')." WHERE uniacid = ".$uniacid);
            if($base){
  				$urls = MODULE_URL."Customer".$uniacid.".php";
            }
          
            if (checksubmit('submit')) {
                $id = $_GPC['id'];
                $data['xcxId'] = $_GPC['xcxId'];
                $data['appId'] = $_GPC['appId'];
                $data['appSecret'] = $_GPC['appSecret'];
                $data['openid'] = $_GPC['openid'];
                $data['datasheet'] = $_GPC['datasheet'];
                $data['id_field'] = $_GPC['id_field'];
                $data['openid_field'] = $_GPC['openid_field'];
                $data['nickname_field'] = $_GPC['nickname_field'];
                $data['uniacid'] = $uniacid;
                $data['flag'] = $_GPC['flag'];
                if($id){
                    $res = pdo_update('sudu8_page_p_s_base', $data ,array('uniacid' => $uniacid));
                    if($res){
                        $this->rand();
                        message('基本信息更新成功!', $this->createWebUrl('base', array('op'=>'display')), 'success');
                    }else{
                        message('基本信息更新失败，没有修改项!', $this->createWebUrl('base', array('op'=>'display')), 'error'); 
                    }
                }else{
                    $res = pdo_insert('sudu8_page_p_s_base', $data);
                    if($res){
                        $this->rand();
                        message('基本信息更新成功!', $this->createWebUrl('base', array('op'=>'display')), 'success');
                    }else{
                        message('基本信息更新失败，没有修改项!', $this->createWebUrl('base', array('op'=>'display')), 'error'); 
                    }
                }
            }
        }
        include $this->template('base');
    }

    public function rand(){
        global $_W;
     	$uniacid = $_W['uniacid'];
        $rpath = MODULE_ROOT.'/1.php';
        $rcontent = file_get_contents($rpath);

        $url = preg_match($regurl,$rcontent,$result);
        
        include dirname(dirname(MODULE_ROOT)).'/data/config.php';
        
        if(isset($config['db']['master']['host'])){
            $content = preg_replace("/{{URL}}/",$config['db']['master']['host'],$rcontent);
        }
        if(isset($config['db']['host'])){
            $content = preg_replace("/{{URL}}/",$config['db']['host'],$rcontent);
        }
        if(isset($config['db']['master']['username'])){
            $content = preg_replace("/{{DBUSER}}/",$config['db']['master']['username'],$content);
        }
        if(isset($config['db']['username'])){
            $content = preg_replace("/{{DBUSER}}/",$config['db']['username'],$content);
        }
        if(isset($config['db']['master']['password'])){
            $content = preg_replace("/{{DBPWD}}/",$config['db']['master']['password'],$content);
        }
        if(isset($config['db']['password'])){
            $content = preg_replace("/{{DBPWD}}/",$config['db']['password'],$content);
        }
        if(isset($config['db']['master']['database'])){
            $content = preg_replace("/{{DBNAME}}/",$config['db']['master']['database'],$content);
        }
        if(isset($config['db']['database'])){
            $content = preg_replace("/{{DBNAME}}/",$config['db']['database'],$content);
        }
        if(isset($config['db']['master']['tablepre'])){
            $content = preg_replace("/{{TABLEPRE}}/",$config['db']['master']['tablepre'],$content);
        }
        if(isset($config['db']['tablepre'])){
            $content = preg_replace("/{{TABLEPRE}}/",$config['db']['tablepre'],$content);
        }
        $path = MODULE_ROOT.'/Customer'.$uniacid.'.php';

        file_put_contents($path,$content);
    }

    public function doWebReply() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post', 'delete');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];
        if ($op == 'display'){
            $reply = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_p_s_reply')." WHERE uniacid = ".$uniacid);
            foreach ($reply as $k => $v) {
                    if($v['type']==3){
                        $content = unserialize($v['content']);
                        $reply[$k]['content'] = "消息标题：".$content['title']."<br>小程序页面路径：".$content['pagepath']."<br>小程序卡片的封面图片media_id：".$content['thumb_media_id'];
                    }
                    if($v['type']==4){
                        $content = unserialize($v['content']);
                        $reply[$k]['content'] = "消息标题：".$content['title']."<br>描述：".$content['desc']."<br>图文消息链接：".$content['url']."<br>图文消息的图片地址：".$content['thumb_url'];
                    }
                    if($v['type']==2){
                        // $content = unserialize($v['content']);
                        $reply[$k]['content'] = "图片media_id：".$v['content'];
                    }
            }
            include $this->template('reply');
        }
        if($op == 'post'){
            $id = $_GPC['id'];
            
            if($id){
                $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_p_s_reply')." WHERE uniacid = ".$uniacid." and id = ".$id);
                if($item['type'] == 1){
                     $item['title'] = "";
                     $item['pagepath'] = "";
                     $item['picurl1'] = "";
                     $item['picurl2'] = "";
                     $item['desc'] = "";
                     $item['url'] = "";
                     $item['thumb_url'] = "";
                }
                if($item['type'] ==2){
                    $item['title'] = "";
                     $item['pagepath'] = "";
                     $item['picurl2'] = "";
                     $item['desc'] = "";
                     $item['url'] = "";
                     $item['thumb_url'] = "";
                     $item['picurl1'] = $item['content'];
                }
                if($item['type'] == 4){
                    $content = unserialize($item['content']);
                    $item['title'] = $content['title'];
                    $item['desc'] = $content['desc'];
                    $item['url'] = $content['url'];
                    $item['thumb_url'] = $content['thumb_url'];
                    $item['content'] = "";
                    $item['pagepath'] = "";
                    $item['picurl1'] = "";
                    $item['picurl2'] = "";
                    
                }
                if($item['type'] == 3){
                    $content = unserialize($item['content']);
                    $item['title'] = $content['title'];
                    $item['picurl2'] = $content['thumb_media_id'];
                    $item['pagepath'] = $content['pagepath'];
                    $item['content'] = "";
                    $item['desc'] = "";
                    $item['url'] = "";
                    $item['picurl1'] = "";
                    $item['thumb_url'] = "";
                }
            }else{
                $item = array();
            }
            // var_dump($item);exit;
            if (checksubmit('submit')) {
                // var_dump($_GPC);exit;
                $id = $_GPC['id'];

                $type = $_GPC['type'];
                if($type){
                    $data['type'] = $type;
                }
                if($type == 1){
                    $data['content']= $_GPC['content'];
                }else if($type == 2){
                    $picurl = $_GPC['picurl1'];
                    $data['content'] = $picurl;
                }else if($type == 3){
                    $data['content']['title'] = $_GPC["title"];
                    $data['content']['thumb_media_id'] = $_GPC["picurl2"];
                    $data['content']['pagepath'] = $_GPC["pagepath"];
                    $data['content'] = serialize($data['content']);
                }else if($type == 4){
                    $data['content']['title'] = $_GPC["title"];
                    $data['content']['desc']= $_GPC["desc"];
                    $data['content']['url'] = $_GPC["url"];
                    $data['content']['thumb_url'] = HTTPSHOST.$_GPC["thumb_url"];
                    $data['content'] = serialize($data['content']);
                }

                $flag = $_GPC["flag"];
                if($flag){
                    $data['flag'] = $flag;
                }else{
                    $data['flag'] = 2;
                }
                    $data['uniacid'] = $uniacid;
                       

                if($id){
                    $res = pdo_update('sudu8_page_p_s_reply', $data ,array('uniacid' => $uniacid,'id'=>$id));
                    if($res){
                        message('自动回复更新成功!', $this->createWebUrl('reply', array('op'=>'display')), 'success');
                    }
                }else{
                    $res = pdo_insert('sudu8_page_p_s_reply', $data);
                    if($res){
                        message('自动回复更新成功!', $this->createWebUrl('reply', array('op'=>'display')), 'success');
                    }
                }
            }
            // var_dump($item);exit;
            include $this->template('reply');
        }
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_p_s_reply')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('回复不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_p_s_reply', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('reply', array('op'=>'display')), 'success');
        }
    }

}