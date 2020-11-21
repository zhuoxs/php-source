<?php
/**
 * 万能门店小程序模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("HTTPSHOST",$_W['attachurl']);
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');
/**
 * 自动加载 结合命名空间
 */
include __DIR__.'/autoload.php';

class Sudu8_pageModuleSite extends WeModuleSite {

    /*
     * 栏目表 : ims_sudu8_page_mcategory
     * 权限表 ： ims_sudu8_page_mauth
     * */

    private static $_GPC,$_W;

    public function __construct()
    {

        global $_GPC,$_W;
        self::$_GPC = $_GPC;
        self::$_W = $_W;

    }

    public function doWebIndex(){
        return include $this->template("web/Index/index");
    }

    /*百度小程序发布*/
    public function doWebBdapp(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }


    /*权限管理*/
    public function doWebAuth(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 基础信息
    public function doWebBase(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 栏目管理
    public function doWebCate(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 数据总览
    public function doWebDatashow(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 商城设置
    public function doWebShopset(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 内容管理
    public function doWebCommentset(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 订单管理
    public function doWebOrderset(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 会员管理
    public function doWebUserset(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 门店管理
    public function doWebStoreset(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 营销管理
    public function doWebSaleset(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 分销管理
    public function doWebDistributionset(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 应用中心
    public function doWebAppcenter(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // DIY
    public function doWebDiy(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }

    // 帮助中心
    public function doWebHelpcenter(){
        $action = isset(self::$_GPC['op'])?self::$_GPC['op']:null;
        return $this->__includeinc(__FUNCTION__,$action);
    }


    public function __includeinc($class,$action = null){
        if($class[2] == 'W'){
            $path = '';
            $s = 5;
            while ($s <= strlen($class) - 1){
                $path .= $class[$s];
                $s++;
            }
            $inc = MODULE_ROOT.'/web/'.$path;
        }else{
            $path = '';
            $s = 8;
            while ($s <= strlen($class) - 1){
                $path .= $class[$s];
                $s++;
            }
            $inc = MODULE_ROOT.'/app/'.$path;
        }
        
        $action = empty($action) ? 'display':$action;
        if(!is_dir($inc)){
            mkdir($inc);
        }
        if(!file_exists($inc.'/'.$action.'.inc.php')){
            $file = fopen($inc.'/'.$action.'.inc.php','w');
            fwrite($file,'<?php $act = isset(self::$_GPC["act"])?self::$_GPC["act"]:"display"; echo $act;');
            fclose($file);
        }
        define("ASSETS",MODULE_URL."/static/css");
        /*获取可访问的栏目*/
        /*开启缓存机制*/

        $cateid = isset(self::$_GPC['cateid'])?self::$_GPC['cateid']:0;
        $userid = self::$_W['user']['uid'];
        $ss = cache_load($userid.'role_stat');
        $status = $ss ? $ss : self::$_W['user']['type'];
        $status = $userid==1?0:$status;
        $help_status = 0;
        if($userid == 1){
            $help_status = 1;
        }
        if($status == 3){
            /*检测是否旧数据*/
            $sql = "SELECT * FROM ".tablename('sudu8_page_muser')." WHERE `uid` = ".$userid." AND `uniacid` = ".self::$_W['uniacid'];
            $olduser = pdo_fetch($sql);
            if(!$olduser){
                cache_write($userid.'role_stat','0');
                $status = 0;
            }else{
                cache_write($userid.'role_stat','3');
                $status = 3;
            }
        }

        $users = pdo_fetch("SELECT * FROM ".tablename("users")." WHERE `uid` = {$userid}");
        $auth = cache_load($userid.'auth');


        if($auth == ""){
            $gid = pdo_get("users", array("uid" => $userid), "gid");
            if($gid['gid'] > 0){
                $auth = pdo_get("sudu8_page_mauth",array('gid' => $gid['gid']));
            }else{
                $auth = pdo_get("sudu8_page_mauth",array('userid' => $userid));     
            }
            
            if(!empty($auth)){
                cache_write($userid.'auth',$auth);
            }
        }else{
            $gid = pdo_get("users", array("uid" => $userid), "gid");
        }
        
        if(in_array(10000,explode(",",$auth['parent']))){
            $help_status = 1;
        }
        if($gid['gid'] > 0){
            $syscatelist = cache_load($userid.'catelist');
            if(!$syscatelist){
                if($status == 0){
                    /*管理员默认超级权限*/
                    $sql1 = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `pid` = 0 ORDER BY sort DESC";
                }else{
                    $sql1 = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `id` IN (".$auth['parent'].") ORDER BY sort DESC";
                }
                $syscatelist = pdo_fetchall($sql1);
                cache_write($userid.'catelist',$syscatelist);
            }
        }else{

            if(($userid == 1 || $status == 1) && $users['type'] != 3){
                $syscatelist = cache_load($userid.'catelist');
                if(!$syscatelist){
                    if($status == 0 || $status == 1){
                        /*管理员默认超级权限*/
                        $sql1 = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `pid` = 0 ORDER BY sort DESC";
                    }else{
                        $sql1 = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `id` IN (".$auth['parent'].") ORDER BY sort DESC";
                    }
                    $syscatelist = pdo_fetchall($sql1);
                    if($userid != 1){
                        if($gid['gid'] == 0 || $gid['gid'] == null){
                            foreach ($syscatelist as $key => $value) {
                                if($value['cate_name'] == "权限"){
                                    unset($syscatelist[$key]);
                                }
                            }
                        }
                    }
                    cache_write($userid.'catelist',$syscatelist);
                }else{
                    if($userid != 1){
                        if($gid['gid'] == 0 || $gid['gid'] == null){
                            foreach ($syscatelist as $key => $value) {
                                if($value['cate_name'] == "权限"){
                                    unset($syscatelist[$key]);
                                }
                            }
                        }
                    }
                }
            }else{
                $sql1 = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `id` IN (".$auth['parent'].") ORDER BY sort DESC";
                $syscatelist = pdo_fetchall($sql1);
                cache_write($userid.'catelist',$syscatelist);
            }
        }

        if((int)$cateid == 0){
            $incs = substr($inc,strrpos($inc,"/")+1);
            if($incs == 'Base'){
                $child = 7;
                $inc = IA_ROOT.'/addons/sudu8_page/web/Shopset';
                $action = 'base';
            }else{
                $child = $syscatelist[0]['id'];
            }
        }else{
            $child = $cateid;
        }
        
        if((intval($status) == 0 || $gid['gid'] == null) && $users['type'] != 3){
            $sql2 = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `pid` = ".$child." AND `stat` = 1 ORDER BY sort DESC";
        }else{
            $sql2 = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `id` IN (".$auth['child'].") AND `pid` = ".$child." AND `stat` = 1 ORDER BY sort DESC";
        }

        /*重组一级栏目的默认操作*/
        foreach ($syscatelist as $k => $v){
            if($auth['child']){
                $where2 =  " `id` IN (".$auth['child'].") AND ";
            }
            $sqls = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE ".$where2." `pid` = ".$v['id']." AND `stat` = 1 ORDER BY sort DESC";
            $childonedata = pdo_fetch($sqls);
            $syscatelist[$k]['opt'] = $childonedata['opt'];
        }

        $children = pdo_fetchall($sql2);

        if(isset(self::$_GPC['chid'])){
            $chid = self::$_GPC['chid'];
            $cname = '';
            foreach ($children as $k => $v){
                if($chid == $v['id']){
                    $cname = $v['cate_name'];
                    continue;
                }
                /*获取三级栏目的下级栏目*/
                if((int)$v['type'] == 1){
                    $sql = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `pid` = ".$v['id'];
                    $children[$k]['child'] = pdo_fetchall($sql);
                }
            }
        }else{
            
            foreach ($children as $k => $v){
                if($v['opt'] == 'display'){
                    $chid = $v['id'];
                    $cname =$v['cate_name'];
                    continue;
                }
                if($v['objname'] == "Diy"){
                    if($v['opt'] == "make"){
                        $diyindex = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypage')." WHERE `index` and `uniacid` = ".self::$_W['uniacid']);
                        if($diyindex){
                            $key_id = $diyindex['id'];
                        }
                    }
                }

                /*获取三级栏目的下级栏目*/

                if((int)$v['type'] == 1){
                    $sql = "SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `pid` = ".$v['id'];
                    $children[$k]['child'] = pdo_fetchall($sql);
                    if($k == 0){
                        $action = $children[$k]['child'][0]['opt'];
                    }
                }
            }
            if(!isset($child)){
                $chid = isset($children[0]['id'])?$children[0]['id']:'';
                $cname = isset($children[0]['cate_name'])?$children[0]['cate_name']:'';
            }
        }

        /*获取小程序版本号*/
        $Swxapp = cache_load("uniaccount:".self::$_W['uniacid']);
        $Smodel = cache_load("we7:module_info:sudu8_page");
        include $inc.'/'.$action.'.inc.php';
    }

    public function returnResult($b,$m){
        if($b){
            echo json_encode(['code' => 1,'message' => $m?$m:'操作成功']);
        }else{
            echo json_encode(['code' => 0,'message' => $m?$m:'操作失败']);
        }
        exit;
    }
}
