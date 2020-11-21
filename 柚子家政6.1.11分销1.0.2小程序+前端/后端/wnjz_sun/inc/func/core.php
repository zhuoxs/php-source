 <?php
defined('IN_IA') or exit ('Access Denied');
include IA_ROOT . '/addons/wnjz_sun/inc/func/func.php';

class Core extends WeModuleSite
{

    public function getMainMenu()
    {
        global $_W, $_GPC;
           $type=pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));
        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
       /*   if ($_W['role'] == 'operator') {
            $navemenu[13] = array(
                'title' => '<a href="javascript:void(0)" id="yframe-15" class="panel-title wytitle"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  业务菜单</a>',
                'items' => array(
                    0 => $this->createMainMenu('账号管理', $do, 'account', 'fa-home')
                )
            );}elseif($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator') {
               $navemenu[14] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=index&m=wnjz_sun" class="panel-title wytitle" id="yframe-14"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  平台数据</a>',
                'items' => array(
                     0 => $this->createMainMenu('数据展示 ', $do, 'index', ''),
                     // 1 => $this->createMainMenu('自定义数据 ', $do, 'numdata', ''),
                )
            );
              $navemenu[7] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=goods&m=wnjz_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon> 服务管理</a>',
                  'items' => array(
                      2 => $this->createMainMenu('技师列表 ', $do, 'servies', ''),
                      3 => $this->createMainMenu('服务分类 ', $do, 'category', ''),
                      0 => $this->createMainMenu('服务列表 ', $do, 'goods', ''),
                      1 => $this->createMainMenu('服务添加 ', $do, 'goodsinfo', ''),
//                     2=> $this->createMainMenu('商品规格', $do, 'attribute', ''),


//                      3=> $this->createMainMenu('服务评价', $do, 'goodscheck', ''),
                  )
              );


//          $navemenu[0] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=store&m=wnjz_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  商家管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('商家列表 ', $do, 'store', ''),
//                     1 => $this->createMainMenu('商家添加 ', $do, 'storeinfo2', ''),
//                     2 => $this->createMainMenu('入驻期限', $do, 'in', ''),
//                     3 => $this->createMainMenu('商家分类', $do, 'storetype', ''),
//                     4=> $this->createMainMenu('审核设置', $do, 'storecheck', ''),
//                     5=> $this->createMainMenu('评论管理', $do, 'sjpinglun', ''),
//                )
//            );
              $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=branchslist&m=wnjz_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-car"></icon>  门店管理</a>',
                'items' => array(
//                     0 => $this->createMainMenu('地址管理 ', $do, 'information', ''),
                     1=> $this->createMainMenu('店铺管理', $do, 'branchslist', ''),
                      6 => $this->createMainMenu('店长管理 ', $do, 'adminstore', ''),
//                    8=> $this->createMainMenu('理发师列表', $do, 'faxingshi', ''),
//                      7 => $this->createMainMenu('二级分类 ', $do, 'type2', ''),
//                     4=> $this->createMainMenu('帖子设置', $do, 'tzcheck', ''),
//                     5=> $this->createMainMenu('评论管理', $do, 'tzpinglun', '')
                     
                     
                )
            );
              $navemenu[10] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=txsz&m=wnjz_sun" class="panel-title wytitle" id="yframe-10"><icon style="color:#8d8d8d;" class="fa fa-money"></icon>  充值管理</a>',
                  'items' => array(
//                      0 => $this->createMainMenu('客户列表 ', $do, 'txlist', ''),
                      1 => $this->createMainMenu('充值优惠 ', $do, 'txsz', ''),
                  )
              );
             $navemenu[2] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=orderinfo&m=wnjz_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-comment-o"></icon>  订单管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('服务订单列表 ', $do, 'orderinfo', ''),
                     //
                     //1 => $this->createMainMenu('拼车信息置顶设置', $do, 'carset', ''),
                     2=> $this->createMainMenu('砍价订单列表', $do, 'carcheck', ''),
                     3=> $this->createMainMenu('充值订单列表', $do, 'recharge', ''),
                     4=> $this->createMainMenu('订单评价列表', $do, 'pingjia', ''),

                )
            );

            $navemenu[3] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=zx&m=wnjz_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  文章管理</a>',
                'items' => array(
                      1 => $this->createMainMenu('文章管理', $do, 'zx', ''),
//                     3=> $this->createMainMenu('文章审核', $do, 'zxcheckmanager', ''),
                     0 => $this->createMainMenu('分类管理 ', $do, 'zxtype', ''),
//                     2=> $this->createMainMenu('审核设置', $do, 'zxcheck', ''),
//                    4=> $this->createMainMenu('评论管理', $do, 'zxpinglun', ''),
                )
            );
//            $navemenu[4] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=yellowstore&m=wnjz_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-compass"></icon>'黄页114</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('入驻列表 ', $do, 'yellowstore', ''),
//                     3=> $this->createMainMenu('添加入驻', $do, 'addyellowstore', ''),
//                     1=> $this->createMainMenu('入驻设置', $do, 'yellowset', ''),
//                     2=> $this->createMainMenu('审核设置', $do, 'yellowcheck', ''),
//
//                )
//            );
           $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=news&m=wnjz_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-bell"></icon>  公告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('公告列表 ', $do, 'news', ''),
                )
            );
            // 下面是复制的上面的数据
//            $navemenu[6] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ad&m=wnjz_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  广告管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('管理广告 ', $do, 'ad', ''),
//                    1 => $this->createMainMenu('广告添加', $do, 'addad', ''),
//                )
//            );

          $navemenu[9] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ygquan&m=wnjz_sun" class="panel-title wytitle" id="yframe-9"><icon style="color:#8d8d8d;" class="fa fa-gift"></icon>  营销设置</a>',
                'items' => array(
                     0 => $this->createMainMenu('营销插件 ', $do, 'ygquan', ''),
//                    1 => $this->createMainMenu('优惠券', $do, 'counp', ''),
//                    2 => $this->createMainMenu('砍价', $do, 'bargainlist', ''),


                )
            );
//            $navemenu[2] = array(
//                'title' => '<icon style="color:#8d8d8d;" class="fa fa-cog"></icon> 充值管理',
//                'items' => array(
//                    0 => $this->createMainMenu('客户列表', $do, 'fxlist', ''),
//                    1 => $this->createMainMenu('充值优惠', $do, 'fxset', ''),
//                )
//            );


//
            $navemenu[11] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=user2&m=wnjz_sun" class="panel-title wytitle" id="yframe-11"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  会员管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('会员列表 ', $do, 'user2', ''),
                )
            );
//               if($type['many_city']==2){
//            $navemenu[15] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=account&m=wnjz_sun" class="panel-title wytitle" id="yframe-15"><icon style="color:#8d8d8d;" class="fa fa-graduation-cap"></icon>多城市管理</a>',
//                'items' => array(
//                    0 => $this->createMainMenu('账号管理 ', $do, 'account', ''),
//                    1 => $this->createMainMenu('账号添加 ', $do, 'countadd', ''),
//                    2 => $this->createMainMenu('佣金提现 ', $do, 'yjtx', ''),
//                    3 => $this->createMainMenu('代理佣金比例设置', $do, 'commission', '')
//                )
//            );
//        }
           
            
            
            $navemenu[12] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=settings&m=wnjz_sun" class="panel-title wytitle" id="yframe-12"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  系统设置</a>',
                'items' => array(
                    0 => $this->createMainMenu('基本信息 ', $do, 'settings', ''),
                    8 => $this->createMainMenu('首页轮播图', $do, 'banner', ''),
                    7 => $this->createMainMenu('首页弹窗', $do, 'winindex', ''),
                    11 => $this->createMainMenu('海报设置', $do, 'poster', ''),
                    1 => $this->createMainMenu('小程序配置', $do, 'peiz', ''),
                    2 => $this->createMainMenu('手机端账号', $do, 'addaccount', ''),
                    4=> $this->createMainMenu('砍价轮播图 ', $do, 'kanjia_banner', ''),
                    5=> $this->createMainMenu('模板消息', $do, 'template', ''),
//                    6=> $this->createMainMenu('首页导航', $do, 'indextu', ''),
                    6=> $this->createMainMenu('首页导航', $do, 'nav', ''),
//                    3=> $this->createMainMenu('底部TAB', $do, 'tab', ''),
                    3=> $this->createMainMenu('底部TAB', $do, 'tabbar', ''),
//                    2 => $this->createMainMenu('支付配置', $do, 'pay', ''),
                    // 3 => $this->createMainMenu('分享设置', $do, 'fenx', ''),
                    9 => $this->createMainMenu('短信配置', $do, 'sms', ''),
                    10 => $this->createMainMenu('打印配置', $do, 'printing', ''),
                    13 => $this->createMainMenu('腾讯地图key', $do, 'copyright', ''),

                )
            );
        }
       */
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
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inindex&m=wnjz_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  数据概况</a>',
                'items' => array(
                     0 => $this->createMainMenu('数据展示', $do, 'inindex', ''),
                )
            );
             $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ininformation&m=wnjz_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-comment-o"></icon>  帖子管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('帖子列表 ', $do, 'ininformation', ''),
                     1 => $this->createMainMenu('添加帖子', $do, 'inaddinformation', ''),
                     2=> $this->createMainMenu('评论管理', $do, 'intzpinglun', ''),
                )
            );

//             $navemenu[2] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=incarinfo&m=wnjz_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-car"></icon>  拼车管理</a>',
//                'items' => array(
//                     0 => $this->createMainMenu('拼车列表 ', $do, 'incarinfo', ''),
//
//                )
//            );

//            $navemenu[3] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inzx&m=wnjz_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  资讯管理</a>',
//                'items' => array(
//                    1 => $this->createMainMenu('资讯管理', $do, 'inzx', ''),
//                    3=> $this->createMainMenu('资讯审核', $do, 'inzxcheckmanager', ''),
//                    4=> $this->createMainMenu('评论管理', $do, 'inzxpinglun', ''),
//                )
//            );
//            $navemenu[4] = array(
//                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inyellowstore&m=wnjz_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-compass"></icon>黄页114</a>',
//                'items' => array(
//                     0=> $this->createMainMenu('入驻列表 ', $do, 'inyellowstore', ''),
//                     3=> $this->createMainMenu('添加入驻', $do, 'inaddyellowstore', ''),
//
//                )
//            );
           $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=innews&m=wnjz_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  公告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('公告列表 ', $do, 'innews', ''),
                )
            );
            // 下面是复制的上面的数据
            $navemenu[6] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inad&m=wnjz_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  广告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('管理广告 ', $do, 'inad', ''),
                    1 => $this->createMainMenu('广告添加', $do, 'inaddad', ''),
                )
            );

              $navemenu[7] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ingoods&m=wnjz_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  商品管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('商品列表 ', $do, 'ingoods', ''),
                     4=> $this->createMainMenu('订单管理 ', $do, 'inddgl', ''),
                )
            );
             $navemenu[8] = array(
                'id' => 'nav12',
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=txdetails&m=wnjz_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  提现管理</a>',
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
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=start&m=wnjz_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  数据概况</a>',
            'items' => array(
                0 => $this->createSubMenu('数据展示', $do, 'start', 'fa-angle-right', $cur_color, $city),
              
               
            ),
            'icon' => 'fa fa-user-md'
        );
        $cur_color = '#8d8d8d';
        $navemenu[1] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlininformation&m=wnjz_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:' . $cur_color . ';" class="fa fa-bars"></icon>  帖子管理</a>',
           
            'items' => array(
                0 => $this->createSubMenu('帖子列表 ', $do, 'dlininformation', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('添加帖子', $do, 'dlinaddinformation', 'fa-angle-right', $cur_color, $city),
                2 => $this->createSubMenu('评论管理', $do, 'dlintzpinglun', 'fa-angle-right', $cur_color, $city),
               
              
            )

        );
        $cur_color = '#8d8d8d';
        $navemenu[2] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlincarinfo&m=wnjz_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:' . $cur_color . ';" class="fa fa-trophy"></icon> 拼车管理</a>',
            'items' => array(
                0 => $this->createSubMenu('拼车列表 ', $do, 'dlincarinfo', 'fa-angle-right', $cur_color, $city),
               
            )
        );

        $cur_color = '#8d8d8d';
            $navemenu[3] = array(
                'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinzx&m=wnjz_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:' . $cur_color . ';" class="fa fa-binoculars"></icon>  资讯管理</a>',
                'items' => array(
                    0 => $this->createSubMenu('资讯管理', $do, 'dlinzx', 'fa-angle-right', $cur_color, $city),
                    1 => $this->createSubMenu('资讯审核', $do, 'dlinzxcheckmanager', 'fa-angle-right', $cur_color, $city),
                     5 => $this->createSubMenu('评论管理', $do, 'dlinzxpinglun', 'fa-angle-right', $cur_color, $city),
                ),
            );
   
//        $cur_color = '#8d8d8d';
//        $navemenu[4] = array(
//            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinyellowstore&m=wnjz_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:' . $cur_color . ';" class="fa fa-gift"></icon>  黄页114</a>',
//            'items' => array(
//                0 => $this->createSubMenu('入驻列表 ', $do, 'dlinyellowstore', 'fa-angle-right', $cur_color, $city),
//                1 => $this->createSubMenu('添加入驻', $do, 'dlinaddyellowstore', 'fa-angle-right', $cur_color, $city),
//            )
//        );

        $cur_color = '#8d8d8d';
        $navemenu[5] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinnews&m=wnjz_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:' . $cur_color . ';" class="fa fa-key"></icon>  公告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('公告列表 ', $do, 'dlinnews', 'fa-angle-right', $cur_color, $city),
            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[6] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinad&m=wnjz_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:' . $cur_color . ';" class="fa fa-book"></icon>  广告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('管理广告 ', $do, 'dlinad', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('广告添加', $do, 'dlinaddad', 'fa-angle-right', $cur_color, $city),
                
            )
        );
          $cur_color = '#8d8d8d';
        $navemenu[7] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlingoods&m=wnjz_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:' . $cur_color . ';" class="fa fa-cubes"></icon>  商品管理</a>',
            'items' => array(
                0 => $this->createSubMenu('商品列表 ', $do, 'dlingoods', 'fa-angle-right', $cur_color, $city),
               
            )
        );
         $cur_color = '#8d8d8d';
        $navemenu[8] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dltxdetails&m=wnjz_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:' . $cur_color . ';" class="fa fa-database"></icon>  提现管理</a>',
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

    public function getSon($pid ,$arr){
        $newarr=array();
        foreach ($arr as $key => $value) {
            if($pid==$value['type_id']){
                $newarr[]=$value; 
               // continue;                     
            }      
        }
        return $newarr;
        
    }

     public function getSon2($pid ,$arr){
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