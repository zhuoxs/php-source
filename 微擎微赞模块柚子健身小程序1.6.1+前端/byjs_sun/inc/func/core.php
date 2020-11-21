<?php
defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite
{
//首页获取菜单
    public function getMainMenu()
    {
        global $_W, $_GPC;
           $type=pdo_get('byjs_sun_system',array('uniacid'=>$_W['uniacid']));
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
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=index&m=byjs_sun" class="panel-title wytitle" id="yframe-14"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  平台数据</a>',
                'items' => array(
                     0 => $this->createMainMenu('数据展示 ', $do, 'index', ''),

                )
            );

//商品管理菜单
              $navemenu[7] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=goods&m=byjs_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  商品管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('商品列表 ', $do, 'goods', ''),
                    6 => $this->createMainMenu('商品分类 ', $do, 'type', ''),
                     1 => $this->createMainMenu('商品添加 ', $do, 'goodsinfo', ''),
                     3=> $this->createMainMenu('审核设置', $do, 'goodscheck', ''),
                     7 => $this->createMainMenu('商品推荐 ', $do, 'goodsdaily', ''),
                )
            );
              //商品管理菜单
              $navemenu[152] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=meal&m=byjs_sun" class="panel-title wytitle" id="yframe-152"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  餐劵管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('餐劵列表 ', $do, 'meal', ''),
                     2 => $this->createMainMenu('餐劵分类 ', $do, 'mealtype', ''),
                     1 => $this->createMainMenu('餐劵添加 ', $do, 'mealinfo', ''),
                     3=> $this->createMainMenu('餐劵订单', $do, 'mealorder', ''),
                     4=> $this->createMainMenu('餐劵记录', $do, 'mealorderdetail', ''),
                     5=> $this->createMainMenu('状态设置', $do, 'mealcheck', ''),
                     6=> $this->createMainMenu('管理设置', $do, 'mealtext', ''),
                )
            );
              //商品管理菜单
              $navemenu[178] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=activity&m=byjs_sun" class="panel-title wytitle" id="yframe-178"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  活动管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('活动列表 ', $do, 'activity', ''),
                     2 => $this->createMainMenu('活动分类 ', $do, 'activitytype', ''),
                     1 => $this->createMainMenu('活动添加 ', $do, 'activityinfo', ''),
                     6 => $this->createMainMenu('宣传添加 ', $do, 'activityinfo1', ''),
                     3=> $this->createMainMenu('活动订单', $do, 'activityorder', ''),
                     7=> $this->createMainMenu('评论管理', $do, 'zxpinglun', ''),
                     5=> $this->createMainMenu('状态设置', $do, 'activitycheck', ''),
                     // 6=> $this->createMainMenu('管理设置', $do, 'mealtext', ''),
                )
            );
//订单管理
              $navemenu[444] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ddgl&m=byjs_sun" class="panel-title wytitle" id="yframe-444"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  订单管理</a>',
                'items' => array(
                     0=> $this->createMainMenu('订单列表 ', $do, 'ddgl', ''),
                    3 => $this->createMainMenu('课程预约',$do,'courseappointment',''),
                  	5 => $this->createMainMenu('教练预约',$do,'coachappointment',''),
                  	// 4 => $this->createMainMenu('会员卡订单',$do,'vipcardorder','')
                )
            );
//文章管理`
             $navemenu[456] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=goodsarticle&m=byjs_sun" class="panel-title wytitle" id="yframe-456"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  文章管理</a>',
                'items' => array(      
                    0=> $this->createMainMenu('文章列表', $do, 'goodsarticle', ''),
                  	1=> $this->createMainMenu('添加文章', $do, 'addgoodsarticle', ''),
                )
            ); 
//动态管理菜单
              $navemenu[13] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=isshopen&m=byjs_sun" class="panel-title wytitle" id="yframe-13"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  动态管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('动态审核 ', $do, 'isshopen', ''),
                      6 => $this->createMainMenu('动态列表 ', $do, 'release', ''),
                      1 => $this->createMainMenu('动态设置 ', $do, 'fabuopen', ''),

                  )
              );



//营销管理菜单
              $navemenu[123] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=ygquan&m=byjs_sun" class="panel-title wytitle" id="yframe-123"><icon style="color:#8d8d8d;" class="fa fa-gift"></icon>  营销管理</a>',
                  'items' => array(
					        0 => $this->createMainMenu('营销管理 ', $do, 'ygquan', ''),
                    1 => $this->createMainMenu('会员卡 ', $do, 'viplist', ''),
                    2 => $this->createMainMenu('会员卡管理 ', $do, 'vipcardlogo', ''),
                    // 3 => $this->createMainMenu('会员卡权益 ', $do, 'vipcardinterests', ''),
                    5 =>$this->createMainMenu('红包管理',$do,'redpacket',''),
                    4 => $this->createMainMenu('集卡 ', $do, 'cardopen', ''),
                    
                  )
              );
//商家管理菜单

//访客管理菜单
            $navemenu[11] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=user2&m=byjs_sun" class="panel-title wytitle" id="yframe-11"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  访客管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('访客列表 ', $do, 'user2', ''),
                )
            );
            


//课程管理
              $navemenu[18] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=course&m=byjs_sun" class="panel-title wytitle" id="yframe-18"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  课程管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('课程列表', $do, 'course', ''),
                      11 => $this->createMainMenu('添加课程 ', $do, 'addcourse', ''),
                      2 => $this->createMainMenu('课程类型',$do,'coursetype',''),
                      
                  )
              );


//广告管理
              $navemenu[58] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=ad&m=byjs_sun" class="panel-title wytitle" id="yframe-58"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  广告管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('广告列表', $do, 'ad', ''),
                      1 => $this->createMainMenu('添加广告 ', $do, 'addad', ''),
                      8 => $this->createMainMenu('首页轮播图', $do, 'banner', ''),
						 4=> $this->createMainMenu('商品页轮播图', $do, 'goodsbanner', ''),

                  )
              );

//教练管理
              $navemenu[109] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=coachlist&m=byjs_sun" class="panel-title wytitle" id="yframe-109"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  教练管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('教练列表', $do, 'coachlist', ''),
                      1 => $this->createMainMenu('添加教练 ', $do, 'addcoach', ''),
                  )
              );
            
//门店管理
              $navemenu[108] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=malllist&m=byjs_sun" class="panel-title wytitle" id="yframe-108"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  门店管理</a>',
                  'items' => array(
                      0 => $this->createMainMenu('门店列表', $do, 'malllist', ''),
                      1 => $this->createMainMenu('添加门店 ', $do, 'addmall', ''),
                  )
              );
            
//系统设置菜单
              $navemenu[12] = array(
                  'title' => '<a href="index.php?c=site&a=entry&op=display&do=settings&m=byjs_sun" class="panel-title wytitle" id="yframe-12"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  系统设置</a>',
                  'items' => array(
                      0 => $this->createMainMenu('基本信息 ', $do, 'settings', ''),
                      10 => $this->createMainMenu('底部Tab图标', $do, 'tab', ''),
                      11 => $this->createMainMenu('顶部Tab图标', $do, 'tab1', ''),
                      1 => $this->createMainMenu('小程序配置', $do, 'peiz', ''),
					  20 => $this->createMainMenu('技术支持', $do, 'businesstel', ''),
                      21=> $this->createMainMenu('我的页面背景',$do,'backimg',''),
                      28=> $this->createMainMenu('区域设置',$do,'qqmapset',''),
                      // 22=> $this->createMainMenu('商家登陆设置',$do,'addbusinessacount',''),
                    24=> $this->createMainMenu('模板消息开关',$do,'mbmessage',''),
                    25=> $this->createMainMenu('提现设置',$do,'withdrawset',''),
                    26=> $this->createMainMenu('提现列表',$do,'withdraw','')

                  )
              );
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
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inindex&m=byjs_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-newspaper-o"></icon>  数据概况</a>',
                'items' => array(
                     0 => $this->createMainMenu('数据展示', $do, 'inindex', ''),
                )
            );
             $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ininformation&m=byjs_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-comment-o"></icon>  帖子管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('帖子列表 ', $do, 'ininformation', ''),
                     1 => $this->createMainMenu('添加帖子', $do, 'inaddinformation', ''),
                     2=> $this->createMainMenu('评论管理', $do, 'intzpinglun', ''),
                )
            );

             $navemenu[2] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=incarinfo&m=byjs_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-car"></icon>  拼车管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('拼车列表 ', $do, 'incarinfo', ''),

                )
            );

            $navemenu[3] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inzx&m=byjs_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  资讯管理</a>',
                'items' => array(
                    1 => $this->createMainMenu('资讯管理', $do, 'inzx', ''),
                    3=> $this->createMainMenu('资讯审核', $do, 'inzxcheckmanager', ''),
                    4=> $this->createMainMenu('评论管理', $do, 'inzxpinglun', ''),
                )
            );

            $navemenu[4] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inyellowstore&m=byjs_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-compass"></icon>黄页114</a>',
                'items' => array(
                     0=> $this->createMainMenu('入驻列表 ', $do, 'inyellowstore', ''),
                     3=> $this->createMainMenu('添加入驻', $do, 'inaddyellowstore', ''),

                )
            );
           $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=innews&m=byjs_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  公告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('公告列表 ', $do, 'innews', ''),
                )
            );
            // 下面是复制的上面的数据
            $navemenu[6] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inad&m=byjs_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  广告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('管理广告 ', $do, 'inad', ''),
                    1 => $this->createMainMenu('广告添加', $do, 'inaddad', ''),
                )
            );

              $navemenu[7] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ingoods&m=byjs_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-cart-plus"></icon>  商品管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('商品列表 ', $do, 'ingoods', ''),
                     4=> $this->createMainMenu('订单管理 ', $do, 'inddgl', ''),
                )
            );
             $navemenu[8] = array(
                'id' => 'nav12',
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=txdetails&m=byjs_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  提现管理</a>',
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
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=start&m=byjs_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  数据概况</a>',
            'items' => array(
                0 => $this->createSubMenu('数据展示', $do, 'start', 'fa-angle-right', $cur_color, $city),


            ),
            'icon' => 'fa fa-user-md'
        );
        $cur_color = '#8d8d8d';
        $navemenu[1] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlininformation&m=byjs_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:' . $cur_color . ';" class="fa fa-bars"></icon>  帖子管理</a>',

            'items' => array(
                0 => $this->createSubMenu('帖子列表 ', $do, 'dlininformation', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('添加帖子', $do, 'dlinaddinformation', 'fa-angle-right', $cur_color, $city),
                2 => $this->createSubMenu('评论管理', $do, 'dlintzpinglun', 'fa-angle-right', $cur_color, $city),


            )

        );
        $cur_color = '#8d8d8d';
        $navemenu[2] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlincarinfo&m=byjs_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:' . $cur_color . ';" class="fa fa-trophy"></icon> 拼车管理</a>',
            'items' => array(
                0 => $this->createSubMenu('拼车列表 ', $do, 'dlincarinfo', 'fa-angle-right', $cur_color, $city),

            )
        );

        $cur_color = '#8d8d8d';
            $navemenu[3] = array(
                'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinzx&m=byjs_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:' . $cur_color . ';" class="fa fa-binoculars"></icon>  资讯管理</a>',
                'items' => array(
                    0 => $this->createSubMenu('资讯管理', $do, 'dlinzx', 'fa-angle-right', $cur_color, $city),
                    1 => $this->createSubMenu('资讯审核', $do, 'dlinzxcheckmanager', 'fa-angle-right', $cur_color, $city),
                     5 => $this->createSubMenu('评论管理', $do, 'dlinzxpinglun', 'fa-angle-right', $cur_color, $city),
                ),
            );

        $cur_color = '#8d8d8d';
        $navemenu[4] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinyellowstore&m=byjs_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:' . $cur_color . ';" class="fa fa-gift"></icon>  黄页114</a>',
            'items' => array(
                0 => $this->createSubMenu('入驻列表 ', $do, 'dlinyellowstore', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('添加入驻', $do, 'dlinaddyellowstore', 'fa-angle-right', $cur_color, $city),
            )
        );

        $cur_color = '#8d8d8d';
        $navemenu[5] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinnews&m=byjs_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:' . $cur_color . ';" class="fa fa-key"></icon>  公告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('公告列表 ', $do, 'dlinnews', 'fa-angle-right', $cur_color, $city),
            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[6] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinad&m=byjs_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:' . $cur_color . ';" class="fa fa-book"></icon>  广告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('管理广告 ', $do, 'dlinad', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('广告添加', $do, 'dlinaddad', 'fa-angle-right', $cur_color, $city),

            )
        );
          $cur_color = '#8d8d8d';
        $navemenu[7] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlingoods&m=byjs_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:' . $cur_color . ';" class="fa fa-cubes"></icon>  商品管理</a>',
            'items' => array(
                0 => $this->createSubMenu('商品列表 ', $do, 'dlingoods', 'fa-angle-right', $cur_color, $city),

            )
        );
         $cur_color = '#8d8d8d';
        $navemenu[8] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dltxdetails&m=byjs_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:' . $cur_color . ';" class="fa fa-database"></icon>  提现管理</a>',
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