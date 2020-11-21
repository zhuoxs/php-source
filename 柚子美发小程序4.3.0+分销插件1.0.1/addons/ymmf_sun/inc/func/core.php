<?php
defined('IN_IA') or exit ('Access Denied');


class Core extends WeModuleSite
{

    public function getMainMenu()
    {
        global $_W, $_GPC;
        $type=pdo_get('ymmf_sun_system',array('uniacid'=>$_W['uniacid']));
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
//            $navemenu[14] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=index&m=ymmf_sun" class="panel-title wytitle" id="yframe-14"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  平台数据</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('数据展示 ', $do, 'index', ''),
//                    // 1 => $this->createMainMenu('自定义数据 ', $do, 'numdata', ''),
//                )
//            );
//
//
////          $navemenu[0] = array(
////                'title' => '<a href="index.php?c=site&a=entry&op=display&do=store&m=ymmf_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  商家管理</a>',
////                'items' => array(
////                     0 => $this->createMainMenu('商家列表 ', $do, 'store', ''),
////                     1 => $this->createMainMenu('商家添加 ', $do, 'storeinfo2', ''),
////                     2 => $this->createMainMenu('入驻期限', $do, 'in', ''),
////                     3 => $this->createMainMenu('商家分类', $do, 'storetype', ''),
////                     4=> $this->createMainMenu('审核设置', $do, 'storecheck', ''),
////                     5=> $this->createMainMenu('评论管理', $do, 'sjpinglun', ''),
////                )
////            );
//            $navemenu[1] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=fenlei&m=ymmf_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-comment-o"></icon>  服务管理</a>',
//                'items' => array(
//                    1=> $this->createMainMenu('服务分类', $do, 'fenlei', ''),
////                    8=> $this->createMainMenu('技师列表', $do, 'faxingshi', '')
//                    0 => $this->createMainMenu('服务列表 ', $do, 'goods', ''),
//                    2 => $this->createMainMenu('服务添加 ', $do, 'goodsinfo', ''),
//
//
//                )
//            );
//
//
//            $navemenu[5] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=news&m=ymmf_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-bell"></icon>  公告管理</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('公告列表 ', $do, 'news', ''),
//                )
//            );
//
//
//
//
//			  $navemenu[7] = array(
//				'title' => '<a href="index.php?c=site&a=entry&op=display&do=banner&m=ymmf_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  广告管理</a>',
//				'items' => array(
////					 0 => $this->createMainMenu('服务列表 ', $do, 'goods', ''),
////					 1 => $this->createMainMenu('服务添加 ', $do, 'goodsinfo', ''),
////					 2=> $this->createMainMenu('商品规格', $do, 'attribute', ''),
////					 3=> $this->createMainMenu('服务地址', $do, 'branchslist', ''),
////					 4=> $this->createMainMenu('订单管理 ', $do, 'ddgl', ''),
//
//					8 => $this->createMainMenu('首页轮播图', $do, 'banner', ''),
//					3 => $this->createMainMenu('砍价轮播图', $do, 'kanjia_banner', ''),
//					5 => $this->createMainMenu('首页弹窗', $do, 'winindex', ''),
//					6 => $this->createMainMenu('海报背景图', $do, 'hbbg', ''),
//
//				)
//			  );
//            $navemenu[10] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=txsz&m=ymmf_sun" class="panel-title wytitle" id="yframe-10"><icon style="color:#8d8d8d;" class="fa fa-money"></icon>  充值管理</a>',
//                'items' => array(
////                      0 => $this->createMainMenu('客户列表 ', $do, 'txlist', ''),
//                    1 => $this->createMainMenu('充值优惠 ', $do, 'txsz', ''),
//                )
//            );
//            $navemenu[2] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ddgl&m=ymmf_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-comment-o"></icon>  订单管理</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('服务订单列表 ', $do, 'ddgl', ''),
//                    2=> $this->createMainMenu('砍价订单列表', $do, 'carcheck', ''),
//                    3=> $this->createMainMenu('充值订单列表', $do, 'recharge', ''),
//                )
//            );
//
//            $navemenu[13] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=branchslist&m=ymmf_sun" class="panel-title wytitle" id="yframe-13"><icon style="color:#8d8d8d;" class="fa fa-building"></icon>  &nbsp;&nbsp;&nbsp;门店管理</a>',
//                'items' => array(
//                    3=> $this->createMainMenu('门店列表', $do, 'branchslist', ''),
//                    2=> $this->createMainMenu('店长列表', $do, 'adminstore', ''),
//                    1=> $this->createMainMenu('门店技师', $do, 'building', ''),
//                )
//            );
//
//            $navemenu[3] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=vipmanage&m=ymmf_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-gift"></icon>  会员管理</a>',
//                'items' => array(
//                    0=> $this->createMainMenu('会员等级', $do, 'vipmanage', ''),
//                    1=> $this->createMainMenu('会员设置', $do, 'vipopen', ''),
//                )
//            );
//
//
//
//            $navemenu[9] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ygquan&m=ymmf_sun" class="panel-title wytitle" id="yframe-9"><icon style="color:#8d8d8d;" class="fa fa-gift"></icon>  营销设置</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('营销插件 ', $do, 'ygquan', ''),
//                    1 => $this->createMainMenu('优惠券', $do, 'counp', ''),
//                    3 => $this->createMainMenu('砍价', $do, 'kanjiaopen', ''),
//                )
//            );
//
//            $navemenu[11] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=user2&m=ymmf_sun" class="panel-title wytitle" id="yframe-11"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  访客管理</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('访客列表 ', $do, 'user2', ''),
//                )
//            );
//
//
//            $navemenu[12] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=settings&m=ymmf_sun" class="panel-title wytitle" id="yframe-12"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  系统设置</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('基本信息 ', $do, 'settings', ''),
////                    8 => $this->createMainMenu('首页轮播图', $do, 'banner', ''),
//                    1 => $this->createMainMenu('小程序配置', $do, 'peiz', ''),
////                    3 => $this->createMainMenu('砍价轮播图', $do, 'kanjia_banner', ''),
//                    4 => $this->createMainMenu('手机端账号', $do, 'addaccount', ''),
////                    5 => $this->createMainMenu('首页弹窗', $do, 'winindex', ''),
////                    7 => $this->createMainMenu('首页导航', $do, 'indextu', ''),
////                    9 => $this->createMainMenu('底部TAB', $do, 'tab', ''),
//                    7 => $this->createMainMenu('首页营销导航', $do, 'nav', ''),
//                    9 => $this->createMainMenu('底部TAB', $do, 'tabbar', ''),
//                    8 => $this->createMainMenu('云推送', $do, 'qituisetting', ''),
////                    2 => $this->createMainMenu('支付配置', $do, 'pay', ''),
//                    // 3 => $this->createMainMenu('分享设置', $do, 'fenx', ''),
//                    10 => $this->createMainMenu('短信配置', $do, 'sms', ''),
//                    6 => $this->createMainMenu('模板消息', $do, 'template', ''),
//                    11 => $this->createMainMenu('打印配置', $do, 'printing', ''),
//                    12 => $this->createMainMenu('腾讯地图key', $do, 'copyright', ''),
//
//                )
//            );
//        }
        $menu = include APP_PATH.'/admin/menu.php';
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

        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
        if($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator') {
            $navemenu[0] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inindex&m=ymmf_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  数据概况</a>',
                'items' => array(
                    0 => $this->createMainMenu('数据展示', $do, 'inindex', ''),
                )
            );
            $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ininformation&m=ymmf_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-comment-o"></icon>  帖子管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('帖子列表 ', $do, 'ininformation', ''),
                    1 => $this->createMainMenu('添加帖子', $do, 'inaddinformation', ''),
                    2=> $this->createMainMenu('评论管理', $do, 'intzpinglun', ''),
                )
            );

//             $navemenu[2] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=incarinfo&m=ymmf_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-car"></icon>  拼车管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('拼车列表 ', $do, 'incarinfo', ''),
//
//                )
//            );

//            $navemenu[3] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inzx&m=ymmf_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  资讯管理</a>',
//                'items' => array(
//                    1 => $this->createMainMenu('资讯管理', $do, 'inzx', ''),
//                    3=> $this->createMainMenu('资讯审核', $do, 'inzxcheckmanager', ''),
//                    4=> $this->createMainMenu('评论管理', $do, 'inzxpinglun', ''),
//                )
//            );
//            $navemenu[4] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inyellowstore&m=ymmf_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-compass"></icon>黄页114</a>',
//                'items' => array(
//                     0=> $this->createMainMenu('入驻列表 ', $do, 'inyellowstore', ''),
//                     3=> $this->createMainMenu('添加入驻', $do, 'inaddyellowstore', ''),
//
//                )
//            );
            $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=innews&m=ymmf_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  公告管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('公告列表 ', $do, 'innews', ''),
                )
            );
            // 下面是复制的上面的数据
            $navemenu[6] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inad&m=ymmf_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  广告管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('管理广告 ', $do, 'inad', ''),
                    1 => $this->createMainMenu('广告添加', $do, 'inaddad', ''),
                )
            );

            $navemenu[7] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ingoods&m=ymmf_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  商品管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('商品列表 ', $do, 'ingoods', ''),
                    4=> $this->createMainMenu('订单管理 ', $do, 'inddgl', ''),
                )
            );
            $navemenu[8] = array(
                'id' => 'nav12',
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=txdetails&m=ymmf_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  提现管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('提现明细 ', $do, 'txdetails', ''),
                    1 => $this->createMainMenu('申请提现 ', $do, 'txapply', '')
                )
            );




        }
        return $navemenu;
    }

    public function getNaveMenu($city, $action)
    {
        global $_W, $_GPC;
        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = '#8d8d8d';
        $navemenu[0] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=start&m=ymmf_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  数据概况</a>',
            'items' => array(
                0 => $this->createSubMenu('数据展示', $do, 'start', 'fa-angle-right', $cur_color, $city),


            ),
            'icon' => 'fa fa-user-md'
        );
        $cur_color = '#8d8d8d';
        $navemenu[1] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlininformation&m=ymmf_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:' . $cur_color . ';" class="fa fa-bars"></icon>  帖子管理</a>',

            'items' => array(
                0 => $this->createSubMenu('帖子列表 ', $do, 'dlininformation', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('添加帖子', $do, 'dlinaddinformation', 'fa-angle-right', $cur_color, $city),
                2 => $this->createSubMenu('评论管理', $do, 'dlintzpinglun', 'fa-angle-right', $cur_color, $city),


            )

        );
        $cur_color = '#8d8d8d';
        $navemenu[2] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlincarinfo&m=ymmf_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:' . $cur_color . ';" class="fa fa-trophy"></icon> 拼车管理</a>',
            'items' => array(
                0 => $this->createSubMenu('拼车列表 ', $do, 'dlincarinfo', 'fa-angle-right', $cur_color, $city),

            )
        );

        $cur_color = '#8d8d8d';
        $navemenu[3] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinzx&m=ymmf_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:' . $cur_color . ';" class="fa fa-binoculars"></icon>  资讯管理</a>',
            'items' => array(
                0 => $this->createSubMenu('资讯管理', $do, 'dlinzx', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('资讯审核', $do, 'dlinzxcheckmanager', 'fa-angle-right', $cur_color, $city),
                5 => $this->createSubMenu('评论管理', $do, 'dlinzxpinglun', 'fa-angle-right', $cur_color, $city),
            ),
        );

//        $cur_color = '#8d8d8d';
//        $navemenu[4] = array(
//            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinyellowstore&m=ymmf_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:' . $cur_color . ';" class="fa fa-gift"></icon>  黄页114</a>',
//            'items' => array(
//                0 => $this->createSubMenu('入驻列表 ', $do, 'dlinyellowstore', 'fa-angle-right', $cur_color, $city),
//                1 => $this->createSubMenu('添加入驻', $do, 'dlinaddyellowstore', 'fa-angle-right', $cur_color, $city),
//            )
//        );

        $cur_color = '#8d8d8d';
        $navemenu[5] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinnews&m=ymmf_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:' . $cur_color . ';" class="fa fa-key"></icon>  公告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('公告列表 ', $do, 'dlinnews', 'fa-angle-right', $cur_color, $city),
            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[6] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinad&m=ymmf_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:' . $cur_color . ';" class="fa fa-book"></icon>  广告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('管理广告 ', $do, 'dlinad', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('广告添加', $do, 'dlinaddad', 'fa-angle-right', $cur_color, $city),

            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[7] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlingoods&m=ymmf_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:' . $cur_color . ';" class="fa fa-cubes"></icon>  商品管理</a>',
            'items' => array(
                0 => $this->createSubMenu('商品列表 ', $do, 'dlingoods', 'fa-angle-right', $cur_color, $city),

            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[8] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dltxdetails&m=ymmf_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:' . $cur_color . ';" class="fa fa-database"></icon>  提现管理</a>',
            'items' => array(
                0 => $this->createSubMenu('提现明细 ', $do, 'dltxdetails', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('申请提现 ', $do, 'dltxapply', 'fa-angle-right', $cur_color, $city),
            )
        );
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

    /*    function createSubMenu($title, $do, $method, $icon = "fa-image", $color = '#d9534f', $storeid)
        {
            $color = ' style="color:'.$color.';" ';
            $url = $this->createWebUrl($method, array('op' => 'display', 'storeid' => $storeid));
            if ($method == 'stores') {
                $url = $this->createWebUrl('stores', array('op' => 'post', 'id' => $storeid, 'storeid' => $storeid));
            }

            return array('title' => $title, 'url' => $do != $method ? $url : '',
                'active' => $do == $method ? ' active' : '',
                'append' => array(
                    'title' => '<i class="fa '.$icon.'"></i>',
                )
            );
        }*/
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