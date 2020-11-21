<?php

/**

 * -微圈小程序模块微站定义

 *

 * @author 厦门科技

 * @url 

 */

defined('IN_IA') or exit('Access Denied');

require 'inc/func/core.php';
require_once "inc/func/func.php";
// 20180727
// 类自动加载
spl_autoload_register(function($name)
{
    $file = realpath(__DIR__).DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$name.'.model.php';
    if(file_exists($file)){
        require_once($file);
        if(class_exists($name,false)){
            return true;
        } 
        return false;
    }
    return false;
});

class yzhyk_sunModuleSite extends Core {
    // public function __call($name, $arguments) {
    //     global $_GPC, $_W;

    //     $fun_name = $_GPC['op'] ?: "display";
    //     if (method_exists($this,$fun_name)) {
    //         $this->{$fun_name}($arguments);
    //     }else{
    //         parent::__call($name,$arguments);
    //     }
    // }
    public function doWebNotify($data){

        $attach = json_decode($data['attach'],true);
        $payrecord_id = $attach['payrecord_id'];
        $payrecord = new payrecord();

        $payrecord_data = $payrecord->get_data_by_id($payrecord_id);
        
        $user_id = $payrecord_data['user_id'];
        $source_id = $payrecord_data['source_id'];
        $source_type = $payrecord_data['source_type'];
        $pay_money = $payrecord_data['pay_money'];
        $uniacid = $payrecord_data['uniacid'];
        if ($payrecord_data['back_time']){
            die('SUCCESS');
        }

        $payrecord_data = [];
        $payrecord_data['back_time'] = time();
        $payrecord_data['xml'] = json_encode($data);
        $payrecord->update_by_id($payrecord_data,$payrecord_id);
        $user = new user();
        $user_data = $user->get_data_by_id($user_id);

         // 载入日志函数
            // load()->func('logging');
            
        if($user_data['isbuy']==1){
            $member_upgrade=pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid),array('member_upgrade'));
            // logging_run(json_encode($uniacid), 'trace','test333' );
            // logging_run(json_encode($member_upgrade['member_upgrade']), 'trace','test333' );
            if($member_upgrade['member_upgrade']==1){
                // 增加用户消费额
                $user->update_by_id(array('amount'=>($user_data['amount']?:0) + $pay_money),$user_id);
                $user->update_member_level($user_id);
            }
        }else{
            $user->update_by_id(array('amount'=>($user_data['amount']?:0) + $pay_money),$user_id);
            $user->update_member_level($user_id);
        }

        $payrecord->finish($payrecord_id);
    }
    function __construct()
    {
        global $_GPC, $_W;
        session_start();
        $admin = $_SESSION['admin'];
        if(!$admin || !$admin['code']){
            if($_W['uniacid']) {
                $_SESSION['admin']['code'] = 'admin';
                $_SESSION['admin']['name'] = '管理员';
                $_SESSION['admin']['uniacid'] = $_W['uniacid'];
            }
        //            header('location:' . "/addons/yzhyk_sun/admin/index.php?c=site&a=entry&op=display&do=index&m=yzhyk_sun");
        }
        if($_W['uniacid'] && $_W['uniacid'] != $_SESSION['admin']['uniacid']){
            $_SESSION['admin']['uniacid'] = $_W['uniacid'];
        } 
//        require "upgrade.php";
    }

    //    删除
    public function delete(){
        global $_GPC, $_W;

        $ret=pdo_delete("yzhyk_sun_".$_GPC['do'],array('id'=>$_GPC['id']));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'删除失败'
            ));
        }
    }
    //    软删除
    public function softdelete(){
        global $_GPC, $_W;
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_".$_GPC['do'],['isdel'=>'1'],array('id'=>$ids));
        if($ret){
            message('删除成功！', $this->createWebUrl($_GPC['do']), 'success');
        }else{
            message('删除失败！','','error');
        }
    }
    //    批量删除
    public function batchdelete(){
        global $_GPC, $_W;
        $ids = explode(',',$_GPC['ids']);
        $ret=pdo_delete("yzhyk_sun_".$_GPC['do'],array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'删除失败'
            ));
        }
    }
    //    批量删除-软删除
    public function batchsoftdelete(){
        global $_GPC, $_W;
        $ids = explode(',',$_GPC['ids']);
        $ret=pdo_update("yzhyk_sun_".$_GPC['do'],['isdel'=>'1'],array('id'=>$ids));
        if($ret){
            message('删除成功！', $this->createWebUrl($_GPC['do']), 'success');
        }else{
            message('删除失败！','','error');
        }
    }
    //    新增
    public function add(){
        global $_GPC, $_W;
        if($_GPC['do']=='store'){
            //获取腾讯地图key
            $developkey=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']),array('developkey'));
            $developkey = $developkey['developkey'];
        }
        include $this->template('web/'.$_GPC['do'].'/add');
    }
    //    复制新增
    public function copy(){
        global $_GPC, $_W;
        $info=pdo_get('yzhyk_sun_'.$_GPC['do'],array('id'=>$_GPC['id']));
        unset($info['id']);
        $info['pics'] = json_decode($info['pics']);
        if($_GPC['do']=='store'){
            //获取腾讯地图key
            $developkey=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']),array('developkey'));
            $developkey = $developkey['developkey'];
        }
        include $this->template('web/'.$_GPC['do'].'/edit');
    }
    //    修改
    public function edit(){
        global $_GPC, $_W;
        $info=pdo_get('yzhyk_sun_'.$_GPC['do'],array('id'=>$_GPC['id']));
        $info['pics'] = json_decode($info['pics']);
        if($_GPC['do']=='store'){
            //获取腾讯地图key
            $developkey=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']),array('developkey'));
            $developkey = $developkey['developkey'];
        }
        include $this->template('web/'.$_GPC['do'].'/edit');
    }
    //    选择窗口
    public function choose(){
        global $_GPC, $_W;
        // var_dump($_GPC['isapp']);
        if($_GPC['app']==1){
            $isapp=$_GPC['isapp'];

            include $this->template('web/'.$_GPC['do'].'/choose');
        }else{
            include $this->template('web/'.$_GPC['do'].'/choose');
        }
    }
    //    默认展示-列表
    public function display(){
        global $_GPC, $_W;
        include $this->template('web/'.$_GPC['do'].'/display');
    }
    //    下拉数据
    public function select(){
        global $_GPC, $_W;
        $sql = "select id,name as text,CONCAT(id,name) as keywords from ".tablename("yzhyk_sun_".$_GPC['do']);
        $list = pdo_fetchall($sql);
        echo json_encode($list);
    }
    //    保存数据
    public function save($data){
        global $_GPC, $_W;
        $name = $_GPC['do'];
        $table = new $name();
        
        if($_GPC['id']){
            $res = $table->update_by_id($data,$_GPC['id']);
        }else{
            $res = $table->insert($data);
        }
        echo json_encode($res);exit;
    }
    //    查询
    public function query(){
        global $_GPC, $_W;
        $name = $_GPC['do'];
        $table = new $name();
        
        $where = array();
        if($_GPC['key']){
            $where[] ="name LIKE  concat('%', '{$_GPC['key']}','%')";
        }
        $this->query2($where);
    }
    //    导出 csv
    public function toCSV($filename, $tileArray=array(), $dataArray=array()){
        ini_set('memory_limit','512M');
        ini_set('max_execution_time',0);
        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=".$filename);
        $fp=fopen('php://output','w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))
        fputcsv($fp,$tileArray);
        $index = 0;
        foreach ($dataArray as $item) {
            // if($index==5000){
            //     $index=0;
            //     ob_flush();
            //     flush();
            // }
            $index++;
            fputcsv($fp,$item);
        }

        ob_flush();
        flush();
        ob_end_clean();
    }
    //    查询
    public function query2($where = array()){
        global $_GPC, $_W;
        $order = array();
        if($_GPC['orderfield']){
            $order[] = $_GPC['orderfield'].(strtolower($_GPC['ordertype'])=="desc"?" DESC":"");
        }

        $limit = array();
        $limit['page'] = $_GPC['page'];
        $limit['limit'] = $_GPC['limit'];

        $name = $_GPC['do'];
        
        $table = new $name();
        $list = $table->query2($where,$limit,$order);
        echo json_encode($list);
    }
}