 <?php
defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite
{
    public function getStores(){
        global $_W, $_GPC;

        $admin = $_SESSION['admin'];
        if($admin['code'] == 'admin'){
            $sql = "select * from ".tablename('yzhyk_sun_store')." where uniacid = {$_W['uniacid']}";
            $storelist = pdo_fetchall($sql);
            $storelist[] = ['id'=>0,'name'=>'平台'];
            if(!isset($admin['store_id'])){
                $_SESSION['admin']['store_id'] = 0;
            }
        }else{
            $sql = "";
            $sql .= "select IFNULL(t1.store_id,0) as id,IFNULL(t2.name,'平台') as name ";
            $sql .= "from ".tablename('yzhyk_sun_userrole')." t1 ";
            $sql .= "left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
            $sql .= "where t1.user_id = {$admin['id']} ";
            $sql .= "order by t1.store_id ";
            $storelist = pdo_fetchall($sql);
            if(!isset($admin['store_id'])){
                $_SESSION['admin']['store_id'] = $storelist[0]['id'];
            }
        }


        return $storelist;
    }
    public function getMainMenu()
    {
        global $_W, $_GPC;
        $admin = $_SESSION['admin'];
        if($admin['code'] == 'admin'){
            $sql = "";
            $sql .= "select * from ".tablename('yzhyk_sun_menu')." order by menu_id,menu_index";
            $list = pdo_fetchall($sql);

            $new_list = [];
            foreach ($list as $item) {
                // p($item['name']);

                if(!$item['menu_id']){
                    $new_list[$item['id']]=[
                        'text'=>$item['name'],
                        'icon'=>$item['icon'],
                        'do'=>$item['menu_do'],
                        'items'=>[],
                    ];
                    // if($item['name']=='积分任务'){
                    //     p($item);
                    // }
                }else{
                    $new_list[$item['menu_id']]['items'][] = [
                        'text'=>$item['name'],
                        'do'=>$item['menu_do'],
                        'op'=>$item['menu_op'],
                    ];
                    
                }
            }
            return $new_list;
        }elseif(!$admin['store_id'] && $admin['store_id'] !== 0 && $admin['store_id'] !== "0"){
//            var_dump($admin);exit;
            return [];
        }else{
            $sql = "";

            $sql .= "select t3.*,t4.name as menu_name,t4.icon as menu_icon ";
            $sql .= "from ".tablename('yzhyk_sun_userrole')." t1 ";
            $sql .= "inner join ".tablename('yzhyk_sun_roleauth')." t2 on t2.role_id = t1.role_id ";
            $sql .= "inner join ".tablename('yzhyk_sun_menu')." t3 on t3.id = t2.menu_id ";
            $sql .= "left join ".tablename('yzhyk_sun_menu')." t4 on t4.id = t3.menu_id ";
            $sql .= "where t1.user_id = {$admin['id']} and t1.store_id = {$admin['store_id']} order by menu_id,menu_index";
            $list = pdo_fetchall($sql);

            $new_list = [];
            foreach ($list as $item) {
                // p($item);
                if($item['menu_id'] && !isset($new_list[$item['menu_id']])){
                    $new_list[$item['menu_id']]=[
                        'text'=>$item['menu_name'],
                        'icon'=>$item['menu_icon'],
                        'items'=>[],
                    ];
                }
                $new_list[$item['menu_id']]['items'][] = [
                    'text'=>$item['name'],
                    'do'=>$item['menu_do'],
                    'op'=>$item['menu_op'],
                ];
            }
            return $new_list;
        }


        return [
            [
                'text'=>'门店管理',
                'icon'=>'weixin',
                'items'=>[
                    ['text'=>'门店列表', 'do'=>'store'],
                    ['text'=>'门店新增', 'do'=>'store','op'=>'add'],
                    ['text'=>'门店用户', 'do'=>'storeuser'],
                    ['text'=>'门店商品', 'do'=>'storegoods'],
                    ['text'=>'门店活动', 'do'=>'storeactivity'],
                ],
            ],
            [
                'text'=>'商品管理',
                'icon'=>'weixin',
                'items'=>[
                    ['text'=>'商品列表', 'do'=>'goods'],
                    ['text'=>'商品新增', 'do'=>'goods','op'=>'add'],
                    ['text'=>'分类列表', 'do'=>'goodsclass'],
                ],
            ],
            [
                'text'=>'促销管理',
                'icon'=>'weixin',
                'items'=>[
                    ['text'=>'活动列表', 'do'=>'activity'],
                    ['text'=>'活动新增', 'do'=>'activity','op'=>'add'],
                    ['text'=>'优惠券列表', 'do'=>'coupon'],
                    ['text'=>'优惠券新增', 'do'=>'coupon','op'=>'add'],
                ],
            ],
            [
                'text'=>'订单管理',
                'icon'=>'comment-o',
                'items'=>[
                    ['text'=>'商城订单', 'do'=>'order'],
                    ['text'=>'扫码购订单', 'do'=>'orderscan'],
                    ['text'=>'线上支付订单', 'do'=>'orderonline'],
                ],
            ],
            [
                'text'=>'充值管理',
                'icon'=>'comment-o',
                'items'=>[
                    ['text'=>'充值管理', 'do'=>'recharge'],
                ],
            ],
            [
                'text'=>'会员等级管理',
                'icon'=>'comment-o',
                'items'=>[
                    ['text'=>'会员等级管理', 'do'=>'cardlevel'],
                ],
            ],
            [
                'text'=>'访客管理',
                'icon'=>'cog',
                'items'=>[
                    ['text'=>'访客列表', 'do'=>'user2'],
                    ['text'=>'积分明细', 'do'=>'integral'],
                    ['text'=>'余额账单', 'do'=>'bill'],
                ],
            ],
            [
                'text'=>'权限管理',
                'icon'=>'cog',
                'items'=>[
                    ['text'=>'菜单管理', 'do'=>'menu'],
                    ['text'=>'角色管理', 'do'=>'role'],
                ],
            ],
            [
                'text'=>'系统设置',
                'icon'=>'cog',
                'items'=>[
                    ['text'=>'商家设置', 'do'=>'system','op'=>'baseinfo'],
                    ['text'=>'技术支持设置', 'do'=>'system','op'=>'team'],
                    ['text'=>'活动设置', 'do'=>'system','op'=>'activity'],
                    ['text'=>'积分设置', 'do'=>'system','op'=>'integral'],
                    ['text'=>'配送设置', 'do'=>'system','op'=>'postage'],
                    ['text'=>'折扣设置', 'do'=>'system','op'=>'discount'],
                    ['text'=>'广告设置', 'do'=>'system','op'=>'ad'],
                    ['text'=>'区域设置', 'do'=>'system','op'=>'qqmapset'],
                    ['text'=>'小程序配置', 'do'=>'system','op'=>'smallapp'],
                    ['text'=>'小程序样式设置', 'do'=>'system','op'=>'smallappstyle'],
                ],
            ],
            // [
            //     'text'=>'积分任务',
            //     'icon'=>'cog',
            //     'items'=>[
            //         // ['text'=>'商家设置', 'do'=>'system','op'=>'baseinfo'],
            //     ],
            // ],
        ];
    }

    public function getSystemSetting(){
        global $_W, $_GPC;
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        return $info;
    }

    public function getNaveMenu($city, $action)
    {  
        global $_W, $_GPC;      
        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = '#8d8d8d';
        $navemenu[0] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=start&m=yzhyk_sun" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  数据概况</a>',
            'items' => array(
                0 => $this->createSubMenu('数据展示', $do, 'start', 'fa-angle-right', $cur_color, $city),
              
               
            ),
            'icon' => 'fa fa-user-md'
        );
        $cur_color = '#8d8d8d';
        $navemenu[1] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlininformation&m=yzhyk_sun" class="panel-title wytitle" id="yframe-1"><icon style="color:' . $cur_color . ';" class="fa fa-bars"></icon>  帖子管理</a>',
           
            'items' => array(
                0 => $this->createSubMenu('帖子列表 ', $do, 'dlininformation', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('添加帖子', $do, 'dlinaddinformation', 'fa-angle-right', $cur_color, $city),
                2 => $this->createSubMenu('评论管理', $do, 'dlintzpinglun', 'fa-angle-right', $cur_color, $city),
               
              
            )

        );
        $cur_color = '#8d8d8d';
        $navemenu[2] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlincarinfo&m=yzhyk_sun" class="panel-title wytitle" id="yframe-2"><icon style="color:' . $cur_color . ';" class="fa fa-trophy"></icon> 拼车管理</a>',
            'items' => array(
                0 => $this->createSubMenu('拼车列表 ', $do, 'dlincarinfo', 'fa-angle-right', $cur_color, $city),
               
            )
        );

        $cur_color = '#8d8d8d';
            $navemenu[3] = array(
                'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinzx&m=yzhyk_sun" class="panel-title wytitle" id="yframe-3"><icon style="color:' . $cur_color . ';" class="fa fa-binoculars"></icon>  资讯管理</a>',
                'items' => array(
                    0 => $this->createSubMenu('资讯管理', $do, 'dlinzx', 'fa-angle-right', $cur_color, $city),
                    1 => $this->createSubMenu('资讯审核', $do, 'dlinzxcheckmanager', 'fa-angle-right', $cur_color, $city),
                     5 => $this->createSubMenu('评论管理', $do, 'dlinzxpinglun', 'fa-angle-right', $cur_color, $city),
                ),
            );
   
//        $cur_color = '#8d8d8d';
//        $navemenu[4] = array(
//            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinyellowstore&m=yzhyk_sun" class="panel-title wytitle" id="yframe-4"><icon style="color:' . $cur_color . ';" class="fa fa-gift"></icon>  黄页114</a>',
//            'items' => array(
//                0 => $this->createSubMenu('入驻列表 ', $do, 'dlinyellowstore', 'fa-angle-right', $cur_color, $city),
//                1 => $this->createSubMenu('添加入驻', $do, 'dlinaddyellowstore', 'fa-angle-right', $cur_color, $city),
//            )
//        );

        $cur_color = '#8d8d8d';
        $navemenu[5] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinnews&m=yzhyk_sun" class="panel-title wytitle" id="yframe-5"><icon style="color:' . $cur_color . ';" class="fa fa-key"></icon>  公告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('公告列表 ', $do, 'dlinnews', 'fa-angle-right', $cur_color, $city),
            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[6] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlinad&m=yzhyk_sun" class="panel-title wytitle" id="yframe-6"><icon style="color:' . $cur_color . ';" class="fa fa-book"></icon>  广告管理</a>',
            'items' => array(
                0 => $this->createSubMenu('管理广告 ', $do, 'dlinad', 'fa-angle-right', $cur_color, $city),
                1 => $this->createSubMenu('广告添加', $do, 'dlinaddad', 'fa-angle-right', $cur_color, $city),
                
            )
        );
          $cur_color = '#8d8d8d';
        $navemenu[7] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dlingoods&m=yzhyk_sun" class="panel-title wytitle" id="yframe-7"><icon style="color:' . $cur_color . ';" class="fa fa-cubes"></icon>  商品管理</a>',
            'items' => array(
                0 => $this->createSubMenu('商品列表 ', $do, 'dlingoods', 'fa-angle-right', $cur_color, $city),
               
            )
        );
         $cur_color = '#8d8d8d';
        $navemenu[8] = array(
            'title' => '<a href="city.php?c=site&a=entry&op=display&do=dltxdetails&m=yzhyk_sun" class="panel-title wytitle" id="yframe-8"><icon style="color:' . $cur_color . ';" class="fa fa-database"></icon>  提现管理</a>',
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
        // var_dump(strtolower($this->modulename));
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