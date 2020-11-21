<?php
defined('IN_IA') or exit ('Access Denied');
include IA_ROOT . '/addons/mzhk_sun/inc/func/func.php';
$classfile = IA_ROOT . '/addons/mzhk_sun/inc/web/class.php';
if(file_exists($classfile)){
    include $classfile;
}else{
    echo $_W["message_a"];
    exit;
}

class Core extends WeModuleSite{

    public function getMainMenu(){
        global $_W, $_GPC;
        $type=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
//        if ($_W['role'] == 'operator') {
//            $navemenu[13] = array(
//                'title' => '<a href="javascript:void(0)" id="yframe-15" class="panel-title wytitle"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  业务菜单</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('账号管理', $do, 'account', 'fa-home')
//                )
//            );}elseif($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator') {
//               $navemenu[14] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=index&m=mzhk_sun" class="panel-title wytitle" id="yframe-14"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  平台数据</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('数据展示 ', $do, 'index', ''),
//                     // 1 => $this->createMainMenu('自定义数据 ', $do, 'numdata', ''),
//                )
//            );
//              $navemenu[1] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=brand&m=mzhk_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-car"></icon>  商家管理</a>',
//                'items' => array(
//                    2 => $this->createMainMenu('商家列表 ', $do, 'brand', ''),
//                    3 => $this->createMainMenu('商家添加 ', $do, 'brandadd', ''),
//                    4 => $this->createMainMenu('商家分类 ', $do, 'storecate', ''),
//                    5 => $this->createMainMenu('缴费记录 ', $do, 'storefeelog', ''),
//                    6 => $this->createMainMenu('店内设施 ', $do, 'storefacility', ''),
//                    7 => $this->createMainMenu('入驻设置 ', $do, 'storeset', ''),
//                    8 => $this->createMainMenu('入驻价格 ', $do, 'storeprice', ''),
//                )
//            );
//              $navemenu[7] = array(
//                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=goods&m=mzhk_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon> 商品管理</a>',
//                  'items' => array(
//                      0 => $this->createMainMenu('商品列表 ', $do, 'goods', ''),
//                      1 => $this->createMainMenu('商品添加 ', $do, 'goodsinfo', ''),
////                    2=> $this->createMainMenu('商品规格', $do, 'attribute', ''),
////                    3=> $this->createMainMenu('服务评价', $do, 'goodscheck', ''),
//                  )
//              );
//             $navemenu[2] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=orderinfo&m=mzhk_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-comment-o"></icon> 订单管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('拼团订单列表 ', $do, 'orderinfo', ''),
//                     2=> $this->createMainMenu('砍价订单列表', $do, 'kjinfo', ''),
//                     3=> $this->createMainMenu('集卡订单列表', $do, 'jkinfo', ''),
//                     4=> $this->createMainMenu('抢购订单列表', $do, 'qginfo', ''),
//                     5 => $this->createMainMenu('普通订单列表', $do, 'otherinfo', ''),
//                     1 => $this->createMainMenu('免单订单列表', $do, 'hyinfo', ''),
//                     6 => $this->createMainMenu('优惠券记录', $do, 'counporder', ''),
//                     7 => $this->createMainMenu('会员卡订单', $do, 'viporder', ''),
//                )
//            );
//             $navemenu[3] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=withdrawset&m=mzhk_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-bank"></icon> 财务管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('提现设置', $do, 'withdrawset', ''),
//                     1=> $this->createMainMenu('提现列表', $do, 'withdraw', ''),
//                     2=> $this->createMainMenu('商家资金明细', $do, 'mercapdetails', ''),
//                     3=> $this->createMainMenu('线下付款设置', $do, 'offlinepay', ''),
//                )
//            );
//             $navemenu[4] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=specialtopic&m=mzhk_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-book"></icon> 专题管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('专题管理', $do, 'specialtopic', ''),
//                     1=> $this->createMainMenu('添加专题', $do, 'addspecialtopic', array("op"=>"add")),
//                )
//            );
//            $navemenu[5] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=circle&m=mzhk_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-bullseye"></icon> 圈子管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('圈子管理', $do, 'circle', ''),
//                )
//            );
//            // 下面是复制的上面的数据
//          $navemenu[6] = array(
//               'title' => '<a href="index.php?c=site&a=entry&op=display&do=banner&m=mzhk_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  广告管理</a>',
//               'items' => array(
//                  0 => $this->createMainMenu('广告管理 ', $do, 'banner', ''),
//                  1 => $this->createMainMenu('Banner设置', $do, 'acbranner', ''),
//                  2 => $this->createMainMenu('首页弹窗设置', $do, 'popbanner', ''),
//                  3 => $this->createMainMenu('小程序跳转', $do, 'wxappjump', ''),
//               )
//          );
//          $navemenu[9] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ygquan&m=mzhk_sun" class="panel-title wytitle" id="yframe-9"><icon style="color:#8d8d8d;" class="fa fa-gift"></icon>  营销设置</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('营销插件 ', $do, 'ygquan', ''),
//                     1 => $this->createMainMenu('线下优惠券', $do, 'mjcounp', ''),
//                     2 => $this->createMainMenu('拼团活动', $do, 'collage', ''),
//                     3 => $this->createMainMenu('集卡活动', $do, 'card', ''),
//                     4 => $this->createMainMenu('抢购活动', $do, 'qglist', ''),
//                     5 => $this->createMainMenu('砍价活动', $do, 'kjlist', ''),
//                     6 => $this->createMainMenu('免单活动', $do, 'hylist', ''),
//                )
//            );
//            $navemenu[11] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=user2&m=mzhk_sun" class="panel-title wytitle" id="yframe-11"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  会员管理</a>',
//                'items' => array(
//                    1 => $this->createMainMenu('会员列表 ', $do, 'user2', ''),
//                    2 => $this->createMainMenu('vip等级', $do, 'vip', ''),
//                    3 => $this->createMainMenu('vip激活码 ', $do, 'vipcode', ''),
//                    4 => $this->createMainMenu('会员激活记录 ', $do, 'vippaylog', ''),
//                    5 => $this->createMainMenu('会员充值卡', $do, 'rechargecard', ''),
//                    6 => $this->createMainMenu('会员明细', $do, 'rechargelogo', ''),
//                )
//            );
//            $navemenu[12] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=settings&m=mzhk_sun" class="panel-title wytitle" id="yframe-12"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  系统设置</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('基本信息 ', $do, 'settings', ''),
//                    1 => $this->createMainMenu('小程序配置', $do, 'peiz', ''),
//                    2 => $this->createMainMenu('黑卡设置 ', $do, 'hklogo', ''),
//                    3 => $this->createMainMenu('顶部导航管理', $do, 'tbbanner', ''),
//                    4 => $this->createMainMenu('底部导航管理', $do, 'settab', ''),
//                    5 => $this->createMainMenu('短信配置', $do, 'sms', ''),
//                    6 => $this->createMainMenu('模板消息', $do, 'template', ''),
//                    7 => $this->createMainMenu('小程序页面', $do, 'wxapppages', ''),
//                    9 => $this->createMainMenu('福利群设置', $do, 'welfaregroup', ''),
//                    10 => $this->createMainMenu('前端主题', $do, 'tplset', ''),
//                    11 => $this->createMainMenu('展示订单设置', $do, 'orderset', ''),
//                )
//            );
//        }

        $menu = include APP_PATH.'/admin/menu.php';

		$virtuals = false;
		if($virtuals){
			$menu[15]= array(
				'title' => '虚拟数据',
				'controller' => 'virtuals',
				'action' => 'virtuals',
				'icon' => 'fa-cog',
				'items' => array(
					array('title' => '虚拟设置','action' => 'virtuals',),
					array('title' => '虚拟分类','action' => 'virtualcate',),
					array('title' => '虚拟数据','action' => 'virtualdata',),
				)
			);
		}

        $navemenu = array();
        $do = $_GPC['do'];
        $ctrl = $_GPC['ctrl']?$_GPC['ctrl']:'';
        $color = 'color:#8d8d8d;';
        foreach ($menu as $key=> $v){
            $op = $v['op']?$v['op']:"display";
            $do = $v["action"]?$v["action"]:$do;
            $_menuData =  array(
                'title'=>'<a href="'.$this->createWebUrl($do, array('op' => $op,'ctrl'=>$v['controller'])) .'" class="panel-title wytitle" id="yframe-'.$key.'"><icon style="'.$color.'" class="fa '.$v['icon'].'"></icon>'.$v['title'].'</a>',
                'items' => array()
            );
            if($v['items']){
                foreach ($v['items'] as $item){
                    $controller = $item['controller']?$item['controller']:$v['controller'];
                    $ctrl = $ctrl?$ctrl:$controller;
                    $_menuData['items'][] =  $this->createMainMenu($item['title'], $item["action"], $controller,$_GPC['do'].$ctrl, '',$item["op"]);
                }
            }

            $navemenu[$key] = $_menuData;
        }
     
        return $navemenu;
    }

       public function getMainMenu2()
    {
        global $_W, $_GPC;

       
        return $navemenu;
    }
   
    public function getNaveMenu($city, $action)
    {  
        global $_W, $_GPC;      
        
        return $navemenu;
    }

        function createWebUrl2($do, $query = array()) {
        $query['do'] = $do;
        $query['m'] = strtolower($this->modulename);
      
        return $this->wurl('site/entry', $query);
    }

    function wurl($segment, $params = array()) {
      
        list($controller, $action, $do) = explode('/', $segment);
        $url = './city.php?';
        if (!empty($controller)) {
            $url .= "c={$controller}&";
        }
        if (!empty($action)) {
            $url .= "a={$action}&";
        }
        if (!empty($do)) {
            $url .= "do={$do}&";
        }
        if (!empty($params)) {
            $queryString = http_build_query($params, '', '&');
            $url .= $queryString;
        }
        return $url;
    }

    function createCoverMenu($title, $method, $op, $icon = "fa-image", $color = '#d9534f')
    {
        global $_GPC, $_W;
        $cur_op = $_GPC['op'];
        $color = ' style="color:'.$color.';" ';
        return array('title' => $title, 'url' => $op != $cur_op ? $this->createWebUrl($method, array('op' => $op)) : '',
            'active' => $op == $cur_op ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa fa-angle-right"></i>',
            )
        );
    }

    function createMainMenu($title, $do, $method,$doact, $icon = "fa-image", $color = '',$op="display"){
        $color = ' style="color:'.$color.';" ';
//        echo $do."----".$method."----".$doact."=";
        return array(
            'title' => $title,
            'url' =>  $this->createWebUrl($do, array('op' => $op,'ctrl'=>$method)) ,
            'active' => $doact == $do.$method ? ' active' : '',
            'append' => array(
                'title' => '<i '.$color.' class="fa fa-angle-right"></i>',
            )
        );
    }

//    function createMainMenu($title, $do, $method, $icon = "fa-image", $color = '')
//    {
//        $color = ' style="color:'.$color.';" ';
//
//        return array('title' => $title, 'url' => $do != $method ? $this->createWebUrl($method, array('op' => 'display')) : '',
//            'active' => $do == $method ? ' active' : '',
//            'append' => array(
//                'title' => '<i '.$color.' class="fa fa-angle-right"></i>',
//            )
//        );
//    }

    function createSubMenu($title, $do, $method, $icon = "fa-image", $color = '#d9534f', $city)
    {
        $color = ' style="color:'.$color.';" ';
        $url = $this->createWebUrl2($method, array('op' => 'display', 'city' => $city));
        if ($method == 'stores2') {
            $url = $this->createWebUrl2('stores2', array('op' => 'post', 'id' => $storeid, 'city' =>$city));
        }



        return array('title' => $title, 'url' => $do != $method ? $url : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa '.$icon.'"></i>',
                )
            );
    }

    public function getStoreById($id)
    {
        $store = pdo_fetch("SELECT * FROM " . tablename('wpdc_store') . " WHERE id=:id LIMIT 1", array(':id' => $id));
        return $store;
    }

    public function set_tabbar($action, $storeid)
    {
        $actions_titles = $this->actions_titles;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles as $key => $value) {
            if ($key == 'stores') {
                $url = $this->createWebUrl('stores', array('op' => 'post', 'id' => $storeid));
            } else {
                $url = $this->createWebUrl($key, array('op' => 'display', 'storeid' => $storeid));
            }

            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public   function getSon($pid ,$arr){
        $newarr=array();
        foreach ($arr as $key => $value) {
            if($pid==$value['type_id']){
                $newarr[]=$value; 
               // continue;                     
            }      
        }
        return $newarr;
        
    }

     public   function getSon2($pid ,$arr){
        $newarr=array();
        foreach ($arr as $key => $value) {
            if($pid==$value['type2_id']){
                $newarr[]=$value; 
               // continue;                     
            }      
        }
        return $newarr;
        
    }
}