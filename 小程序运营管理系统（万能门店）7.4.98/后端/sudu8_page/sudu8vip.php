<?php
/**
 * [WeEngine System] Copyright (c) 20180503162240 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_SYS', true);
define("TEMPLATE",dirname(dirname(__DIR__))."/addons/sudu8_page/template/");
require dirname(dirname(__DIR__)).'/framework/bootstrap.inc.php';
require dirname(dirname(__DIR__)).'/web/common/bootstrap.sys.inc.php';
global $_W,$_GPC;

$_W['uniacid'] = $_COOKIE['uniacid']?$_COOKIE['uniacid']:0;

$op = isset($_GPC['op']) ? $_GPC['op'] : 'display';
$act = isset($_GPC['act']) ? $_GPC['act'] : '';

if($_W['uniacid'] == 0 && $op != 'display') header("Location:sudu8vip.php?op=display");

$syscatelist = [
    ['cate_name' => '总览','icon' => '','objname' => 'data','icon' => 'wb-pie-chart'],
    ['cate_name' => '内容','icon' => '','objname' => 'commentset','icon' => 'wb-list'],
    ['cate_name' => '订单','icon' => '','objname' => 'orderset','icon' => 'wb-order'],
    ['cate_name' => '门店','icon' => '','objname' => 'storageset','icon' => '']
];
switch ($op){
    case 'test':
        $children = [
            ['cate_name' => '数据总览','act' => 'display']
        ];
        break;
    case 'data':
        $children = [
            ['cate_name' => '数据总览','act' => 'display']
        ];
        break;
    case 'commentset':
        $children = [
            ['cate_name' => '分类管理' ,'act' => 'category'],
            ['cate_name' => '秒杀商品' ,'act' => 'goods']
        ];
        break;
    case 'orderset':
        $children = [];
        break;
    case 'storageset':
        $children = [];
        break;
}
/*获取小程序版本号*/
$Swxapp = cache_load("uniaccount:".$_W['uniacid']);
$Smodel = cache_load("we7:module_info:sudu8_page");

if($op == 'display'){
    $venue_id = isset($_COOKIE['venue_id']) ? $_COOKIE['venue_id'] : 0;
    if($venue_id > 0){
        header("Location: sudu8vip.php?op=".$syscatelist[0]['objname']);
    }else{
        load()->web('template');
        Dtemplate("viplogin/login");
    }
}

if($op == 'login'){
    $username = $_GPC['username'];
    $password = $_GPC['password'];

    $sql = "SELECT * FROM ".tablename('sudu8_page_store')." WHERE `login_name` = '{$username}' AND `login_pwd` = '{$password}'";
    $data = pdo_fetch($sql);
    if($data && isset($data['id'])){
        setcookie('venue_id',$data['id'],time()+86400,'/');
        setcookie('is_venue',1,time()+86400,'/');
        setcookie('uniacid',$data['uniacid'],time()+86400,'/');
        echo json_encode(['code' => 1,'message' => '登录成功']);
    }else{
        echo json_encode(['code' => 0,'message' => '登录失败']);
    }
}

if($op == 'data'){
    if($act == ''){
        Dtemplate("web/Datashow/index");
    }
}

if($op == 'commentset'){
    if($act == ''){
        $opt = 'display';
        $_W['page']['title'] = '产品管理';
        $uniacid = $_W['uniacid'];
        $products = pdo_fetchall("SELECT i.num,i.thumb,i.title,i.id,c.name,i.type,i.is_more,i.buy_type FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showPro' and i.is_more = 0 ORDER BY i.num DESC,i.id DESC");
        // 获取文章分类
        $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showPro' and cid = 0", array(':uniacid' => $uniacid));
        foreach ($cates as $key => &$res) {
            $res['ziji'] = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and type = 'showPro' and cid = :cid", array(':uniacid' => $uniacid,':cid' => $res['id']));
        }


        if (checksubmit('submit')) {
            $sid = $_GPC['sid'];
            $skey = $_GPC['skey'];
            $where = "";
            if($sid > 0){
                $where.=" and i.cid = ".$sid;
            }
            if($skey){
                $where.=" and i.title like '%%".$skey."%%'";
            }
            $products = pdo_fetchall("SELECT i.num,i.thumb,i.title,i.id,c.name,i.type,i.is_more,i.buy_type FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showPro' ".$where." ORDER BY i.num DESC,i.id DESC");
        }

        Dtemplate("web/Commentset/sgoods");
    }
}

if($op == 'loginout'){
    setcookie("venue_id","",time()-3600,"/");
    setcookie("is_venue","",time()-3600,"/");
    setcookie("uniacid","",time()-3600,"/");
    header("Location: sudu8vip.php");
}

/**
 * @param $filename 要加载的模板文件
 * @param $flag 不用管
 * @return string 直接返回编译后的HTML
 */
function Dtemplate($filename,$flag = TEMPLATE_DISPLAY){
    global $_W;
    $source = IA_ROOT . "/addons/sudu8_page/template/{$filename}.html";
    $compile = IA_ROOT . "/data/tpl/web/{$_W['template']}/{$filename}.tpl.php";
    if(!is_file($source)) {
        $source = IA_ROOT . "/addons/sudu8_page/template/{$filename}.html";
        $compile = IA_ROOT . "/data/tpl/web/default/{$filename}.tpl.php";
    }

    if(!is_file($source)) {
        echo "template source '{$filename}' is not exist!";
        return '';
    }
    if(DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
        template_compile($source, $compile);
    }
    switch ($flag) {
        case TEMPLATE_DISPLAY:
        default:
            extract($GLOBALS, EXTR_SKIP);
            include $compile;
            break;
        case TEMPLATE_FETCH:
            extract($GLOBALS, EXTR_SKIP);
            ob_flush();
            ob_clean();
            ob_start();
            include $compile;
            $contents = ob_get_contents();
            ob_clean();
            return $contents;
            break;
        case TEMPLATE_INCLUDEPATH:
            return $compile;
            break;
    }
}


function _forward($c, $a) {
    $file = IA_ROOT . '/web/source/' . $c . '/' . $a . '.ctrl.php';
    if (!file_exists($file)) {
        list($section, $a) = explode('-', $a);
        $file = IA_ROOT . '/web/source/' . $c . '/' . $section . '/' . $a . '.ctrl.php';
    }
    return $file;
}
function _calc_current_frames(&$frames) {
    global $controller, $action;
    if (!empty($frames['section']) && is_array($frames['section'])) {
        foreach ($frames['section'] as &$frame) {
            if (empty($frame['menu'])) {
                continue;
            }
            foreach ($frame['menu'] as $key => &$menu) {
                $query = parse_url($menu['url'], PHP_URL_QUERY);
                parse_str($query, $urls);
                if (empty($urls)) {
                    continue;
                }
                if (defined('ACTIVE_FRAME_URL')) {
                    $query = parse_url(ACTIVE_FRAME_URL, PHP_URL_QUERY);
                    parse_str($query, $get);
                } else {
                    $get = $_GET;
                    $get['c'] = $controller;
                    $get['a'] = $action;
                }
                if (!empty($do)) {
                    $get['do'] = $do;
                }
                $diff = array_diff_assoc($urls, $get);
                if (empty($diff) || $get['c'] == 'profile' && $get['a'] == 'reply-setting' && $key == 'platform_reply') {
                    $menu['active'] = ' active';
                }
            }
        }
    }
}

function templates($path,$name = ""){
    $compile = IA_ROOT . "/data/tpl/web/{$name}.tpl.php";
    template_compile($path, $compile);
    include $compile;
}