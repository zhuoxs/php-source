<?php
defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite
{

    public function getMainMenu()
    {
        global $_W, $_GPC;
        $type=pdo_get('yzpx_sun_system',array('uniacid'=>$_W['uniacid']));
        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
          if ($_W['role'] == 'operator') {
            $navemenu[13] = array(
                'title' => '<a href="javascript:void(0)" id="yframe-15" class="panel-title wytitle"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  业务菜单</a>',
                'items' => array(
                    0 => $this->createMainMenu('账号管理', $do, 'account', 'fa-home')
                )
            );}elseif($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator') {
               $navemenu[14] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=index&m=yzpx_sun" class="panel-title wytitle" id="yframe-14"><icon style="color:#8d8d8d;" class="fa fa-line-chart"></icon>  平台数据</a>',
                'items' => array(
                     0 => $this->createMainMenu('数据展示 ', $do, 'index', ''),
                     // 1 => $this->createMainMenu('自定义数据 ', $do, 'numdata', ''),
                )
            );
              $navemenu[5] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=schoollist&m=yzpx_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-institution"></icon> 分校管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('分校列表 ', $do, 'schoollist', ''),
                      1 => $this->createMainMenu('分校设置 ', $do, 'schoolset', ''),
                  )
              );
              $navemenu[7] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=courseclassify&m=yzpx_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-book"></icon> 课程管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('课程分类 ', $do, 'courseclassify', ''),
                      1 => $this->createMainMenu('课程列表 ', $do, 'courselist', ''),
                      2 => $this->createMainMenu('老师列表 ', $do, 'teacherlist', ''),
//                      3 => $this->createMainMenu('老师添加 ', $do, 'addteacher', ''),
                  )
              );
              $navemenu[1] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=breakclassify&m=yzpx_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  课间管理</a>',
                  'items' => array(
//                     0 => $this->createMainMenu('地址管理 ', $do, 'information', ''),
                      1=> $this->createMainMenu('课间分类', $do, 'breakclassify', ''),
                      2=> $this->createMainMenu('课间列表', $do, 'breaklist', ''),
                  )
              );
              $navemenu[2] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=order&m=yzpx_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-money"></icon>  订单管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('课程报名列表 ', $do, 'order', ''),
                      1 => $this->createMainMenu('课程预约列表 ', $do, 'orderlist', ''),
                      //
                      //1 => $this->createMainMenu('拼车信息置顶设置', $do, 'carset', ''),
//                     2=> $this->createMainMenu('砍价订单列表', $do, 'carcheck', ''),

                  )
              );

              $navemenu[3] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=vacationad&m=yzpx_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-bell"></icon>  广告管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('首页广告', $do, 'vacationad', ''),
                      1 => $this->createMainMenu('广告报名列表', $do, 'adsign', ''),
                      2 => $this->createMainMenu('首页广告弹窗', $do, 'adpic_list', ''),
                  )
              );

              $navemenu[4] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=newsclassify&m=yzpx_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  新闻管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('分类列表 ', $do, 'newsclassify', ''),
                      1 => $this->createMainMenu('新闻列表', $do, 'newslist', ''),
//                    2 => $this->createMainMenu('砍价', $do, 'bargainlist', ''),
                  )
              );
              $navemenu[9] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=ygquan&m=yzpx_sun" class="panel-title wytitle" id="yframe-9"><icon style="color:#8d8d8d;" class="fa fa-gift"></icon>  营销管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('营销插件 ', $do, 'ygquan', ''),
//                      1 => $this->createMainMenu('图标设置', $do, 'logoset', ''),
//                    2 => $this->createMainMenu('砍价', $do, 'bargainlist', ''),
                  )
              );

              $navemenu[11] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=user&m=yzpx_sun" class="panel-title wytitle" id="yframe-11"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  用户管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('用户列表 ', $do, 'user', ''),
//                      1 => $this->createMainMenu('积分设置 ', $do, 'userinfo', ''),
//                      3 => $this->createMainMenu('会员特权 ', $do, 'memberslist', ''),
                  )
              );





              $navemenu[12] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=banner&m=yzpx_sun" class="panel-title wytitle" id="yframe-12"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  系统设置</a>',
                  'items' => array(
//                      0 => $this->createMainMenu('基本信息 ', $do, 'settings', ''),
                      0 => $this->createMainMenu('基础设置', $do, 'banner', ''),
                      1 => $this->createMainMenu('小程序配置', $do, 'peiz', ''),
                      2 => $this->createMainMenu('总校设置', $do, 'we', ''),
                      3=> $this->createMainMenu('首页营销图标设置 ', $do, 'logoset', ''),
//                      4=> $this->createMainMenu('首页底部图标设置 ', $do, 'navset', ''),
                      4=> $this->createMainMenu('底部导航 ', $do, 'footnav', ''),
                      5=> $this->createMainMenu('个人中心图标设置 ', $do, 'myset', ''),
                      6=> $this->createMainMenu('模板消息设置 ', $do, 'template', ''),
                      7=> $this->createMainMenu('短信配置', $do, 'msgset', ''),
                      8 => $this->createMainMenu('小程序页面', $do, 'wxpages', ''),
//                    4 => $this->createMainMenu('短信配置', $do, 'sms', ''),
//                    5 => $this->createMainMenu('模板消息', $do, 'template', ''),
//                    6 => $this->createMainMenu('帮助中心', $do, 'help', ''),
//                    7 => $this->createMainMenu('版权设置', $do, 'copyright', ''),

                  )
              );

//              $navemenu[10] = array(
//                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=txsz&m=yzpx_sun" class="panel-title wytitle" id="yframe-10"><icon style="color:#8d8d8d;" class="fa fa-money"></icon>  充值管理</a>',
//                  'items' => array(
////                      0 => $this->createMainMenu('客户列表 ', $do, 'txlist', ''),
//                      1 => $this->createMainMenu('充值优惠 ', $do, 'txsz', ''),
//                  )
//              );


//            $navemenu[3] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=zx&m=yzpx_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  文章管理</a>',
//                'items' => array(
//                      1 => $this->createMainMenu('文章管理', $do, 'zx', ''),
////                     3=> $this->createMainMenu('文章审核', $do, 'zxcheckmanager', ''),
//                     0 => $this->createMainMenu('分类管理 ', $do, 'zxtype', ''),
////                     2=> $this->createMainMenu('审核设置', $do, 'zxcheck', ''),
////                    4=> $this->createMainMenu('评论管理', $do, 'zxpinglun', ''),
//                )
//            );


            // 下面是复制的上面的数据
//            $navemenu[6] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ad&m=yzpx_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  广告管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('管理广告 ', $do, 'ad', ''),
//                    1 => $this->createMainMenu('广告添加', $do, 'addad', ''),
//                )
//            );

//            $navemenu[2] = array(
//                'title' => '<icon style="color:#8d8d8d;" class="fa fa-cog"></icon> 充值管理',
//                'items' => array(
//                    0 => $this->createMainMenu('客户列表', $do, 'fxlist', ''),
//                    1 => $this->createMainMenu('充值优惠', $do, 'fxset', ''),
//                )
//            );


//               if($type['many_city']==2){
//            $navemenu[15] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=account&m=yzpx_sun" class="panel-title wytitle" id="yframe-15"><icon style="color:#8d8d8d;" class="fa fa-graduation-cap"></icon>多城市管理</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('账号管理 ', $do, 'account', ''),
//                    1 => $this->createMainMenu('账号添加 ', $do, 'countadd', ''),
//                    2 => $this->createMainMenu('佣金提现 ', $do, 'yjtx', ''),
//                    3 => $this->createMainMenu('代理佣金比例设置', $do, 'commission', '')
//                )
//            );
//        }

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
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inindex&m=yzpx_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  数据概况</a>',
                'items' => array(
                     0 => $this->createMainMenu('数据展示', $do, 'inindex', ''),
                )
            );
             $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ininformation&m=yzpx_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-comment-o"></icon>  帖子管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('帖子列表 ', $do, 'ininformation', ''),
                     1 => $this->createMainMenu('添加帖子', $do, 'inaddinformation', ''),
                     2=> $this->createMainMenu('评论管理', $do, 'intzpinglun', ''),
                )
            );

//             $navemenu[2] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=incarinfo&m=yzpx_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-car"></icon>  拼车管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('拼车列表 ', $do, 'incarinfo', ''),
//
//                )
//            );

//            $navemenu[3] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inzx&m=yzpx_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  资讯管理</a>',
//                'items' => array(
//                    1 => $this->createMainMenu('资讯管理', $do, 'inzx', ''),
//                    3=> $this->createMainMenu('资讯审核', $do, 'inzxcheckmanager', ''),
//                    4=> $this->createMainMenu('评论管理', $do, 'inzxpinglun', ''),
//                )
//            );
//            $navemenu[4] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inyellowstore&m=yzpx_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-compass"></icon>黄页114</a>',
//                'items' => array(
//                     0=> $this->createMainMenu('入驻列表 ', $do, 'inyellowstore', ''),
//                     3=> $this->createMainMenu('添加入驻', $do, 'inaddyellowstore', ''),
//
//                )
//            );
           $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=innews&m=yzpx_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  公告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('公告列表 ', $do, 'innews', ''),
                )
            );
            // 下面是复制的上面的数据
            $navemenu[6] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inad&m=yzpx_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  广告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('管理广告 ', $do, 'inad', ''),
                    1 => $this->createMainMenu('广告添加', $do, 'inaddad', ''),
                )
            );

              $navemenu[7] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ingoods&m=yzpx_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  商品管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('商品列表 ', $do, 'ingoods', ''),
                     4=> $this->createMainMenu('订单管理 ', $do, 'inddgl', ''),
                )
            );
             $navemenu[8] = array(
                'id' => 'nav12',
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=txdetails&m=yzpx_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  提现管理</a>',
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
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=start&m=yzpx_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  数据概况</a>',
            'items' => array(
                0 => $this->createSubMenu('数据展示', $do, 'start', 'fa-angle-right', $cur_color, $city),
              
               
            ),
            'icon' => 'fa fa-user-md'
        );
        $cur_color = '#8d8d8d';
        $navemenu[1] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlininformation&m=yzpx_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:' . $cur_color . ';" class="fa fa-bars"></icon>  帖子管理</a>',
           
            'items' => array(
                0 => $this->createSubMenu('帖子列表 ', $do, 'dlininformation', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('添加帖子', $do, 'dlinaddinformation', 'fa-angle-right', $cur_color, $city),
                2 => $this->createSubMenu('评论管理', $do, 'dlintzpinglun', 'fa-angle-right', $cur_color, $city),
               
              
            )

        );
        $cur_color = '#8d8d8d';
        $navemenu[2] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlincarinfo&m=yzpx_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:' . $cur_color . ';" class="fa fa-trophy"></icon> 拼车管理</a>',
            'items' => array(
                0 => $this->createSubMenu('拼车列表 ', $do, 'dlincarinfo', 'fa-angle-right', $cur_color, $city),
               
            )
        );

        $cur_color = '#8d8d8d';
            $navemenu[3] = array(
                'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinzx&m=yzpx_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:' . $cur_color . ';" class="fa fa-binoculars"></icon>  资讯管理</a>',
                'items' => array(
                    0 => $this->createSubMenu('资讯管理', $do, 'dlinzx', 'fa-angle-right', $cur_color, $city),
                    1 => $this->createSubMenu('资讯审核', $do, 'dlinzxcheckmanager', 'fa-angle-right', $cur_color, $city),
                     5 => $this->createSubMenu('评论管理', $do, 'dlinzxpinglun', 'fa-angle-right', $cur_color, $city),
                ),
            );
   
//        $cur_color = '#8d8d8d';
//        $navemenu[4] = array(
//            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinyellowstore&m=yzpx_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:' . $cur_color . ';" class="fa fa-gift"></icon>  黄页114</a>',
//            'items' => array(
//                0 => $this->createSubMenu('入驻列表 ', $do, 'dlinyellowstore', 'fa-angle-right', $cur_color, $city),
//                1 => $this->createSubMenu('添加入驻', $do, 'dlinaddyellowstore', 'fa-angle-right', $cur_color, $city),
//            )
//        );

        $cur_color = '#8d8d8d';
        $navemenu[5] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinnews&m=yzpx_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:' . $cur_color . ';" class="fa fa-key"></icon>  公告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('公告列表 ', $do, 'dlinnews', 'fa-angle-right', $cur_color, $city),
            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[6] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinad&m=yzpx_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:' . $cur_color . ';" class="fa fa-book"></icon>  广告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('管理广告 ', $do, 'dlinad', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('广告添加', $do, 'dlinaddad', 'fa-angle-right', $cur_color, $city),
                
            )
        );
          $cur_color = '#8d8d8d';
        $navemenu[7] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlingoods&m=yzpx_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:' . $cur_color . ';" class="fa fa-cubes"></icon>  商品管理</a>',
            'items' => array(
                0 => $this->createSubMenu('商品列表 ', $do, 'dlingoods', 'fa-angle-right', $cur_color, $city),
               
            )
        );
         $cur_color = '#8d8d8d';
        $navemenu[8] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dltxdetails&m=yzpx_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:' . $cur_color . ';" class="fa fa-database"></icon>  提现管理</a>',
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

    function createMainMenu($title, $do, $method, $icon = "fa-image", $color = '')
    {
        $color = ' style="color:'.$color.';" ';

        return array('title' => $title, 'url' => $do != $method ? $this->createWebUrl($method, array('op' => 'display')) : '',
            'active' => $do == $method ? ' active' : '',
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