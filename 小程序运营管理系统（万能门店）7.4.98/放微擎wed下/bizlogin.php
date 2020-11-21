<?php
/**
 * [WeEngine System] Copyright (c) 20180503162240 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_SYS', true);
define("TEMPLATE",dirname(__DIR__)."/addons/sudu8_page/template/");
require dirname(__DIR__).'/framework/bootstrap.inc.php';
require dirname(__DIR__).'/web/common/bootstrap.sys.inc.php';
global $_W,$_GPC;

$_W['uniacid'] = $_COOKIE['uniacid']?$_COOKIE['uniacid']:0;

$op = isset($_GPC['op']) ? $_GPC['op'] : 'display';
$act = isset($_GPC['act']) ? $_GPC['act'] : '';

if($_W['uniacid'] == 0 && $op != 'display' && $op != 'login') header("Location:bizlogin.php?op=display");

// $_W['site_root'] = substr($_W['siteroot'], 0, 23);

$syscatelist = [
    ['cate_name' => '总览','icon' => '','objname' => 'data','icon' => 'wb-pie-chart'],
    ['cate_name' => '商品','icon' => '','objname' => 'commentset','icon' => 'wb-list'],
    ['cate_name' => '订单','icon' => '','objname' => 'orderset','icon' => 'wb-order'],
    ['cate_name' => '提现','icon' => '','objname' => 'withdrawset','icon' => ''],
    ['cate_name' => '设置','icon' => '','objname' => 'shopset','icon' => ''],
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
            // ['cate_name' => '分类管理' ,'act' => 'category'],
            ['cate_name' => '商品列表', 'act' => 'goods']
        ];
        break;
    case 'orderset':
        $children = [
            ['cate_name' => '订单列表', 'act' => 'order']
        ];
        break;
    case 'withdrawset':
        $children = [
        	['cate_name' => '提现记录', 'act' => 'withdraw']
        ];
        break;
    case 'shopset':
        $children = [
            ['cate_name' => '店铺设置', 'act' => 'set']
        ];
        break;
}
/*获取小程序版本号*/
$Swxapp = cache_load("uniaccount:".$_W['uniacid']);
$Smodel = cache_load("we7:module_info:sudu8_page");

if($op == 'display'){
    $venue_id = isset($_COOKIE['venue_id']) ? $_COOKIE['venue_id'] : 0;
    if($venue_id > 0){
        header("Location: bizlogin.php?op=".$syscatelist[0]['objname']);
    }else{
        load()->web('template');
        Dtemplate("viplogin/login");
    }
}

if($op == 'login'){
    $username = $_GPC['username'];
    $password = $_GPC['password'];

    $sql = "SELECT * FROM ".tablename('sudu8_page_shops_shop')." WHERE `username` = '{$username}' AND `password` = '{$password}' AND status=1"; //status=1表示已审核通过
    $data = pdo_fetch($sql);
    if($data && isset($data['id'])){
        setcookie('venue_id',$data['id'],time()+86400,'/');
        setcookie('is_venue',1,time()+86400,'/');
        setcookie('uniacid',$data['uniacid'],time()+86400,'/');
        echo json_encode(['code' => 1,'message' => '登录成功']);
    }else{
    	// message('登录失败！');
        echo json_encode(['code' => 0,'message' => '登录失败']);
    }
}

if($op == 'data'){
    if($act == ''){
        Dtemplate("web/Datashow/index");
    }
}

if($op == 'commentset'){
    if($act == '' || $act == 'goods'){
    	load()->func('tpl');
        $opt = $_GPC['opt'] ? $_GPC['opt'] : 'display';
        $_W['page']['title'] = '产品管理';
        $uniacid = $_W['uniacid'];
        $sid = $_COOKIE['venue_id'];

        if($opt == 'display'){
     	   $products = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_shops_goods')." WHERE uniacid = :uniacid and sid = :sid ORDER BY createtime DESC", array(':uniacid'=>$uniacid, ':sid' => $sid));
     	   
     	}

     	if($opt == 'post'){
     		if(!empty($_GPC['id'])){
                $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_goods')." WHERE uniacid = :uniacid and id = :id",array(':uniacid'=>$uniacid, ':id'=>$_GPC['id']));
                $item['images'] = unserialize($item['images']);
            }
            

            if(checksubmit('submit')){
                if(empty($_GPC['title'])){
                    message('产品标题不能为空！');
                }

                $goods = pdo_fetchcolumn("SELECT goods FROM ".tablename('sudu8_page_shops_set')." WHERE uniacid = :uniacid", array(":uniacid"=>$uniacid));

                $data = array(
                    'title' => $_GPC['title'],
                    'sid' => $sid,
                    'flag' => $_GPC['flag'],
                    'pageview' => $_GPC['pageview'],
                    'rsales' => $_GPC['rsales'],
                    'sellprice' => $_GPC['sellprice'],
                    'marketprice' => $_GPC['marketprice'],
                    'storage' => $_GPC['storage'],
                    'thumb' => $_GPC['thumb'],
                    'images' => serialize($_GPC['images']),
                    'descp' => $_GPC['descp'],
                    'num' => $_GPC['num'],
                    'hot' => 0,
                    'vsales' => 0,
                    'buy_type' => $_GPC['buy_type']
                );

                if(!empty($_GPC['id'])){
                    pdo_update('sudu8_page_shops_goods', $data, array('id' => $_GPC['id'], 'uniacid' => $uniacid));
                }else{
                    $data['uniacid'] = $uniacid;
                    $data['createtime'] = time();
                    $data['status'] = ($goods == '1') ? 0 : 1;    //goods为设置表里面的 "添加商品是否需要审核"
                    pdo_insert('sudu8_page_shops_goods', $data);
                }

                message('商品添加/修改成功!', "http://wxkf2.nttrip.cn/web/bizlogin.php?op=commentset&act=goods&opt=display", 'success');
            }
     	}

        Dtemplate("web/Commentset/sgoods");
    }
}

if($op == 'loginout'){
    setcookie("venue_id","",time()-3600,"/");
    setcookie("is_venue","",time()-3600,"/");
    setcookie("uniacid","",time()-3600,"/");
    header("Location: bizlogin.php");
}

if($op == 'orderset'){
    if($act == '' || $act == 'order'){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display', 'hx');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $sid = $_COOKIE['venue_id'];

        if($opt == 'display'){
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 5;
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = :sid and uniacid = :uniacid", array(':sid' => $sid, ':uniacid' => $uniacid));
            $pager = pagination($total, $pageindex, $pagesize);
            $p = ($pageindex-1) * $pagesize;

            $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = :sid and uniacid = :uniacid order by creattime desc LIMIT ".$p.",".$pagesize, array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
            foreach ($orders as $key => &$res) {
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;
                $res['shopname'] = pdo_fetchcolumn("SELECT name FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid=:uniacid and id=:id", array(':uniacid'=>$uniacid, ':id'=>$res['sid']));

                // 重新算总价
                $allprice = 0;
                foreach ($res['jsondata'] as $key2 => &$reb) {
                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                }
                $res['allprice'] = $allprice;

                // 积分转钱
                //积分转换成金钱
                $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
                if(!$jf_gz){
                    $gzscore = 10000;
                    $gzmoney = 1;
                }else{
                    $gzscore = $jf_gz['scroe'];
                    $gzmoney = $jf_gz['money'];
                }
                $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;


                // 转换地址
                if($res['address']!=0){
                    $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
                }else{
                    $res['address_get'] = unserialize($res['m_address']);
                }
                if($res['formid']){
                    $res['formcon'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formcon') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid,':id'=>$res['formid']));
                    $res['formcon'] = unserialize($res['formcon']['val']);
                    foreach ($res['formcon'] as $k => $vi) {
                        if($vi['z_val']){
                            foreach ($vi['z_val'] as $kv => $vv) {
                                if(strpos($vv,'http')===false){
                                    $res['formcon'][$k]['z_val'][$kv] = HTTPSHOST.$vv;
                                }else{
                                    $res['formcon'][$k]['z_val'][$kv] = $vv;
                                }
                            }
                        }
                    }
                }
            }
        }

        if($opt == 'hx'){
            $orderid = $_GPC['orderid'];
            $data['hxtime'] = time();
            $data['flag'] = 2;
            pdo_update('sudu8_page_duo_products_order', $data, array('uniacid' => $uniacid, 'id' => $orderid));

            $money = pdo_fetchcolumn("SELECT tixian FROM ".tablename("sudu8_page_shops_shop")." WHERE uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$sid));
            $add = pdo_fetchcolumn("SELECT price FROM ".tablename("sudu8_page_duo_products_order")." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id" => $orderid));
            
            $money = $money + $add;
            $result = pdo_update("sudu8_page_shops_shop", array('tixian' => $money), array('uniacid'=>$uniacid, 'id'=>$sid));

            message('核销成功!', "http://wxkf2.nttrip.cn/web/bizlogin.php?op=orderset&act=order&opt=display", 'success');
        }

        Dtemplate("web/Orderset/sorder");
    }
}

if($op == 'shopset'){
    if($act == '' || $act == 'set'){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $sid = $_COOKIE['venue_id'];

        if($opt == 'display'){
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_shop')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $sid ,':uniacid' => $uniacid));
            if(!empty($item['latitude'])){
                $item['latlong'] = $item['latitude'] . ',' . $item['longitude'];
            }
            $item['images'] = unserialize($item['images']);
            $cateList = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_shops_cate')." WHERE  uniacid = :uniacid ", array(':uniacid' => $uniacid));
            if (checksubmit('submit')) {
                if (empty($_GPC['name'])) {
                    message('请输入店铺名称！');
                }
                if(is_null($_GPC['flag'])){
                    $_GPC['flag'] = 1;
                }
                $images = serialize($_GPC['images']);
                $latlong = $_GPC['latlong'];
                $latlong = explode(',', $latlong);

                $data = array(
                    'cid' => intval($_GPC['cid']),   //6
                    'username' => trim($_GPC['username']), //4
                    'password' => trim($_GPC['password']),  //5
                    'logo' => $_GPC['logo'],     //7
                    'bg' => $_GPC['bg'],         //8
                    'intro' => $_GPC['intro'],
                    'worktime' => $_GPC['worktime'],
                    'name' => $_GPC['name'],     //9
                    'tel' => $_GPC['tel'],      //10
                    'address' => $_GPC['address'],   //11
                    'latitude' => $latlong[0],    //12
                    'longitude' => $latlong[1],   //12
                    //'star' => $_GPC['star'],
                    //'flag' => $_GPC['flag'],  
                    //'hot' => $_GPC['hot'],
                    'descp' => $_GPC['descp'],   //15
                    'title' => $_GPC['title'],   //13
                    //'images' => $images,   
                );
                if (empty($item['id'])) {
                    $data['uniacid'] = $uniacid;
                    pdo_insert('sudu8_page_shops_shop', $data);
                } else {
                    pdo_update('sudu8_page_shops_shop', $data ,array('id' => $item['id'], 'uniacid'=>$uniacid));
                }
                message('店铺设置修改成功!', "http://wxkf2.nttrip.cn/web/bizlogin.php?op=shopset&act=set&opt=display", 'success');
            }
        }
        Dtemplate("web/Shopset/shopset");
    }

}

if($op == 'withdrawset'){
    if($act == '' || $act == 'withdraw'){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display','post','delete');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $sid = $_COOKIE['venue_id'];

        if($opt == 'display'){
            $records = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_shops_tixian')." WHERE uniacid = :uniacid and sid=:sid ORDER BY createtime desc", array('uniacid' => $uniacid,':sid'=>$sid));
            foreach ($records as $key => &$value) {
                $value['shopname'] = pdo_fetchcolumn("SELECT name FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid=:uniacid and id=:id",array(':uniacid'=>$uniacid,':id'=>$value['sid']));
            }
        }

        if($opt == 'post'){
            $minimum = pdo_fetchcolumn("SELECT minimum FROM ".tablename("sudu8_page_shops_set")." WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
            $tixian = pdo_fetchcolumn("SELECT tixian FROM ".tablename("sudu8_page_shops_shop")." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$sid));

            if(checksubmit('submit')){
                $types = $_GPC['types'];
                $account = $_GPC['account'];
                $money = $_GPC['money'];
                $beizhu = $_GPC['beizhu'];

                if(empty($types)) message('提现方式不可为空！');
                if(empty($account)) message('账号不可为空！');
                if(empty($money)) message('金额不可为空！');
                if($tixian < $money) message('提现金额超过可提金额！');
                if($money < $minimum) message('提现金额低于最低限度！');

                $withdraw = pdo_fetchcolumn("SELECT withdraw FROM ".tablename('sudu8_page_shops_set')." WHERE uniacid = :uniacid", array(':uniacid'=>$uniacid));

                pdo_update("sudu8_page_shops_shop", array('tixian' => $tixian - $money), array('uniacid'=>$uniacid, 'id'=>$sid));

                $data = array(
                    'uniacid' => $uniacid,
                    'sid' => $sid,
                    'money' => $money,
                    'types' => $types,
                    'account' => $account,
                    'beizhu' => $beizhu,
                    'flag' => ($withdraw == '0') ? 1 : 0,
                    'createtime' => time()
                );

                pdo_insert('sudu8_page_shops_tixian', $data);

                message('已提交申请，等待审核!', "http://wxkf2.nttrip.cn/web/bizlogin.php?op=withdrawset&act=withdraw&opt=display", 'success');
            }
        }

        Dtemplate("web/Distributionset/stixian");
    }
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

function tpl_form_field_images($name, $value = '', $default = '', $options = array()) {
    global $_W;
    if (empty($default)) {
        $default = '/web/resource/images/nopic.jpg';
    }
    $val = $default;
    if (!empty($value)) {
        $val = tomedia($value);
    }
    if (!empty($options['global'])) {
        $options['global'] = true;
    } else {
        $options['global'] = false;
    }
    if (empty($options['class_extra'])) {
        $options['class_extra'] = '';
    }
    if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
        if (!preg_match('/^\w+([\/]\w+)?$/i', $options['dest_dir'])) {
            exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
        }
    }
    $options['direct'] = true;
    $options['multiple'] = false;
    if (isset($options['thumb'])) {
        $options['thumb'] = !empty($options['thumb']);
    }
    $options['fileSizeLimit'] = intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024;
    $s = '';
    if (!defined('TPL_INIT_IMAGE')) {
        $s = '
        <script type="text/javascript">
            function showImageDialog(elm, opts, options) {
                require(["utils"], function(utils){
                    var btn = $(elm);
                    var ipt = btn.parent().prev();
                    var val = ipt.val();
                    var img = ipt.parent().next().children();
                    options = '.str_replace('"', '\'', json_encode($options)).';
                    utils.image(val, function(url){
                        if(url.url){
                            if(img.length > 0){
                                img.get(0).src = url.url;
                            }
                            ipt.val(url.attachment);
                            ipt.attr("filename",url.filename);
                            ipt.attr("url",url.url);
                        }
                        if(url.media_id){
                            if(img.length > 0){
                                img.get(0).src = "";
                            }
                            ipt.val(url.media_id);
                        }
                    }, options);
                });
            }
            function deleteImage(elm){
                $(elm).prev().attr("src", "/web/resource/images/nopic.jpg");
                $(elm).parent().prev().find("input").val("");
            }
        </script>';
        define('TPL_INIT_IMAGE', true);
    }

    $s .= '
        <div class="input-group ' . $options['class_extra'] . '">
            <input type="text" name="' . $name . '" value="' . $value . '"' . ($options['extras']['text'] ? $options['extras']['text'] : '') . ' class="form-control" autocomplete="off">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>
            </span>
        </div>
        <div class="input-group ' . $options['class_extra'] . '" style="margin-top:.5em;">
            <img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" ' . ($options['extras']['image'] ? $options['extras']['image'] : '') . ' width="150" />
            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
        </div>';
    return $s;
}