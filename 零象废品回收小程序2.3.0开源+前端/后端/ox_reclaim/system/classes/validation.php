<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/25
 * Time: 14:19
 */
class Validation
{
    public static  $instance;
    public static  function Instance(){
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * 获取 全部菜单带路由
     * @param bool $full 是否返回长URL
     * @return array
     */
    public function getMenu($full = false)
    {
        global $_W;
        global $_GPC;
        $return_menu = array();
        $return_submenu = array();
        $route = trim($_W['routes']);
        $routes = explode('.', $_W['routes']);
        $top = (empty($routes[0]) ? 'shop' : $routes[0]);
        $allmenus = include_once IA_ROOT . '/addons/'.MODEL_NAME.'/config/menu.php';
        if (!empty($allmenus)) {
            $submenu = $allmenus[$top];
            $topmenu = [];
            foreach ($allmenus as $key => $val) {
                if(in_array($key,['user','information'])){
                    if ($this->cv($key)) {
                        $top_item = array('route' => empty($val['route']) ? $key : $val['route'], 'text' => $val['title']);
                        if (!empty($val['index'])) {
                            $top_item['index'] = $val['index'];
                        }
                        if (!empty($val['param'])) {
                            $top_item['param'] = $val['param'];
                        }
                        if (!empty($val['icon'])) {
                            $top_item['icon'] = $val['icon'];
                        }
                        if ($full) {
                            $top_item['url'] = webUrl($top_item['route'], !empty($top_item['param']) && is_array($top_item['param']) ? $top_item['param'] : array());
                        }
                        $topmenu[] = $top_item;
                    }
                    continue;
                }
                if ($this->cv($key)) {
                    $menu_item = array('route' => empty($val['route']) ? $key : $val['route'], 'text' => $val['title']);
                    if (!empty($val['index'])) {
                        $menu_item['index'] = $val['index'];
                    }
                    if (!empty($val['param'])) {
                        $menu_item['param'] = $val['param'];
                    }
                    if (!empty($val['icon'])) {
                        $menu_item['icon'] = $val['icon'];
                    }
                    $menu_item['isplugin'] = $val['isplugin'];
                    if (($top == $menu_item['route']) || ($menu_item['route'] == $route) || (('system.' . $top) == $menu_item['route']) || ($top == $key)) {
                        if ($this->verifyParam($val) && !empty($_GPC['r'])) {
                            $menu_item['active'] = 1;
                        }
                    } else {
                    }
                    if ($full) {
                        $menu_item['url'] = webUrl($menu_item['route'], !empty($menu_item['param']) && is_array($menu_item['param']) ? $menu_item['param'] : array());
                    }
                    $return_menu[] = $menu_item;
                }
            }
            unset($key);
            unset($val);
            if (!empty($submenu)) {
                $return_submenu['subtitle'] = $submenu['subtitle'];
                if ($submenu['main']) {
                    $return_submenu['route'] = $top;
                    if (is_string($submenu['main'])) {
                        $return_submenu['route'] .= '.' . $submenu['main'];
                    }
                }
                if (!empty($submenu['index'])) {
                    $return_submenu['route'] = $top . '.' . $submenu['index'];
                }
                if (!empty($submenu['items'])) {
                    foreach ($submenu['items'] as $i => $child) {
                        if (empty($child['items'])) {
                            $return_submenu_default = $top . '';
                            $route_second = $top;
                            if (!empty($child['route'])) {
                                if (!empty($top)) {
                                    $route_second .= '.';
                                }
                                $route_second .= $child['route'];
                            }
                            $return_menu_child = array('title' => $child['title'], 'route' => empty($child['route']) ? $return_submenu_default : $route_second);
                            if (!empty($child['param'])) {
                                $return_menu_child['param'] = $child['param'];
                            }
                            if ($routes[0] == 'system') {
                                $return_menu_child['route'] = 'system.' . $return_menu_child['route'];
                            }
                            $addedit = false;
                            if (!$child['route_must']) {
                                //if ((($return_menu_child['route'] . '.add') == $route) || (($return_menu_child['route'] . '.edit') == $route)) {
                                if (($return_menu_child['route'] . '.edit') == $route) {
                                    $addedit = true;
                                }
                            }
                            $extend = false;
                            if ($child['route_in'] && strexists($route, $return_menu_child['route'])) {
                                $return_menu_child['active'] = 1;
                            }
                            else {
                                if (($return_menu_child['route'] == $route) || $addedit || $extend) {
                                    if ($this->verifyParam($child)) {
                                        $return_menu_child['active'] = 1;
                                    }
                                }
                            }
                            if ($full) {
                                $return_menu_child['url'] = webUrl($return_menu_child['route'], !empty($return_menu_child['param']) && is_array($return_menu_child['param']) ? $return_menu_child['param'] : array());
                            }
                            if (!$this->cv($return_menu_child['route'])) {
                                continue;
                            }
                            $return_submenu['items'][] = $return_menu_child;
                            unset($return_submenu_default);
                            unset($route_second);
                        }
                        else {
                            $return_menu_child = array(
                                'title' => $child['title'],
                                'items' => array()
                            );
                            foreach ($child['items'] as $ii => $three) {
                                if ($this->merch && $three['hidemerch']) {
                                    continue;
                                }
                                $return_submenu_default = $top . '';
                                $route_second = 'main';
                                if (!empty($child['route'])) {
                                    $return_submenu_default = $top . '.' . $child['route'];
                                    $route_second = $child['route'];
                                }
                                $return_submenu_three = array('title' => $three['title']);
                                if (!empty($three['route'])) {
                                    if (!empty($child['route'])) {
                                        if (!empty($three['route_ns'])) {
                                            $return_submenu_three['route'] = $top . '.' . $three['route'];
                                        }
                                        else {
                                            $return_submenu_three['route'] = $top . '.' . $child['route'] . '.' . $three['route'];
                                        }
                                    }
                                    else {
                                        $return_submenu_three['route'] = $top . '.' . $three['route'];
                                        $route_second = $three['route'];
                                    }
                                }
                                else {
                                    $return_submenu_three['route'] = $return_submenu_default;
                                }
                                if (!empty($three['param'])) {
                                    $return_submenu_three['param'] = $three['param'];
                                }
                                if ($routes[0] == 'system') {
                                    $return_submenu_three['route'] = 'system.' . $return_submenu_three['route'];
                                }
                                $addedit = false;
                                if (!$three['route_must']) {
                                    if ((($return_submenu_three['route'] . '.add') == $route) || (($return_submenu_three['route'] . '.edit') == $route)) {
                                        $addedit = true;
                                    }
                                }
                                $extend = false;
                                if (!empty($three['extend'])) {
                                    if ((($three['extend'] . '.add') == $route) || (($three['extend'] . '.edit') == $route) || ($three['extend'] == $route)) {
                                        $extend = true;
                                    }
                                }
                                else {
                                    if (!empty($three['extends']) && is_array($three['extends'])) {
                                        if (in_array($route, $three['extends']) || in_array($route . '.add', $three['extends']) || in_array($route . '.edit', $three['extends'])) {
                                            $extend = true;
                                        }
                                    }
                                }
                                if ($three['route_in'] && strexists($route, $return_submenu_three['route'])) {
                                    $return_menu_child['active'] = 1;
                                    $return_submenu_three['active'] = 1;
                                }
                                else {
                                    if (($return_submenu_three['route'] == $route) || $addedit || $extend) {
                                        if ($this->verifyParam($three)) {
                                            $return_menu_child['active'] = 1;
                                            $return_submenu_three['active'] = 1;
                                        }
                                    }
                                }
                                if ($full) {
                                    $return_submenu_three['url'] = webUrl($return_submenu_three['route'], !empty($return_submenu_three['param']) && is_array($return_submenu_three['param']) ? $return_submenu_three['param'] : array());
                                }
                                if (!$this->cv($return_submenu_three['route'])) {
                                    continue;
                                }
                                $return_menu_child['items'][] = $return_submenu_three;
                            }
                            if (!empty($child['items']) && empty($return_menu_child['items'])) {
                                continue;
                            }
                            $return_submenu['items'][] = $return_menu_child;
                            unset($ii);
                            unset($three);
                            unset($route_second);
                        }
                    }
                }
            }
        }
        $toupixie=array();
        if(!empty($routes[0]))
        {
            $toupixie[0]=array(
                'title' =>$allmenus[$routes[0]]['title'],
                'icon'  =>$allmenus[$routes[0]]['icon'],
                'url'   =>webUrl($allmenus[$routes[0]]['route']),
            );
            foreach ($allmenus[$routes[0]]['items'] as $v)
            {
                $routes_wz = $routes[2]!=''? $routes[1].'.'.$routes[2] : $routes[1];
                if($routes_wz == $v['route'])
                {
                    $toupixie[1]=array(
                        'title' =>$v['title'],
                        'icon'  =>$v['icon'],
                        'url'   =>webUrl($routes[0].'.'.$v['route']),
                    );
                    break;
                }
            }
        }
        return array('menu' => $return_menu, 'submenu' => $return_submenu, 'toupixie' =>$toupixie,'topmenu'=>$topmenu);
    }
    /**
     * 获取后台数据
     * @return array
     */
    public function init()
    {
        global $_W;
        $users_profile = pdo_get('users_profile', array('uid' => $_W['uid']));
        $result = [
            'user' => $users_profile
        ];
        return $result;
    }
    /**
     * 处理历史记录
     */
    public function history_url()
    {
        global $_W;
        global $_GPC;
        $history_url = $_GPC['history_url'];
        if (empty($history_url)) {
            $history_url = array();
        }else {
            $history_url = htmlspecialchars_decode($history_url);
            $history_url = json_decode($history_url, true);
        }
        if (!empty($history_url)) {
            $this_url = str_replace($_W['siteroot'] . 'web/', './', $_W['siteurl']);
            foreach ($history_url as $index => $history_url_item) {
                $item_url = str_replace($_W['siteroot'] . 'web/', './', $history_url_item['url']);
                if ($item_url == $this_url) {
                    unset($history_url[$index]);
                }
            }
        }
        $thispage = array();
        if ($thispage) {
            $thispage_item = array(
                array('title' => $thispage['title'], 'url' => $thispage['url'])
            );
            $history_url = array_merge($thispage_item, $history_url);
            if (10 < count($history_url)) {
                $history_url = array_slice($history_url, 0, 10);
            }
            isetcookie( 'history_url', json_encode($history_url), 7 * 86400);
        }
    }
    // 权限检查
    public function cv($str)
    {
        return true;
        return Permission::instance()->check_perm($str);
    }
    /**
     * 判断二级、三级带参的Active状态
     * @param array $item
     * @return bool
     */
    protected function verifyParam($item = array())
    {
        global $_GPC;
        if (empty($item['param'])) {
            return true;
        }
        $return = true;
        foreach ($item['param'] as $k => $v) {
            if ($_GPC[$k] != $v) {
                $return = false;
                break;
            }
        }
        return $return;
    }
    //头部信息
    public function headarr()
    {
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
//        $result = pdo_fetch("SELECT * FROM ".tablename('pfzl_chance_user')." where `uniacid`='$uniacid' order by id desc limit 1");
//        $ex_url = webUrl('examine/goods');
//        $user_list = pdo_getall('pfzl_chance_user',array('uniacid'=>$uniacid,'aut_state'=>1));
//        $user_num = count($user_list);
//        if(!empty($user_num))
//        {
//            $ex_url = webUrl('examine/prove');
//        }
//        $goods_list = pdo_getall('pfzl_chance_list',array('uniacid'=>$uniacid,'state'=>0));
//        $goods_num = count($goods_list);
//        $num = $user_num+$goods_num;
//        $num = empty($num)?0:$num;
        $num =0;
        $header_arr = array('num'=>$num,'ex_url'=>$ex_url);
        return $header_arr;
    }
    //手机端基础信息
    public function mobile_info()
    {
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $info = pdo_get('pfzl_chance_info',array('uniacid'=>$_W['uniacid']));

        return $info;
    }
}