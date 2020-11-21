<?php
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->_weid;
$action = 'fans';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $condition = " weid=:weid AND from_user<>'' ";
    if (!empty($_GPC['keyword'])) {
        $types = trim($_GPC['types']);
        $condition .= " AND {$types} LIKE '%{$_GPC['keyword']}%'";
    }
    if (isset($_GPC['status']) && $_GPC['status'] != '') {
        $condition .= " AND status={$_GPC['status']} ";
    }

    $agentid = intval($_GPC['agentid']);
    if ($agentid != 0) {
        $condition .= " AND (agentid={$agentid} OR agentid2={$agentid}) ";
    }

    $paras = array(':weid' => $weid);

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";

    $usertype = intval($_GPC['usertype']);
    if ($usertype == 1) {
        $condition .= " AND is_commission=2 AND agentid=0 ";
    } else if ($usertype == 2) {
        $condition .= " AND is_commission=2 AND agentid>0 ";
    } else if ($usertype == 3) {
        $condition .= " AND is_commission=1 ";
    }

    $datapage = intval($_GPC['datapage']);

    if ($_GPC['out_put'] == 'output') {
        $this->out_fans($condition, $paras, $datapage);
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE {$condition} ORDER BY lasttime DESC,id DESC " . $limit, $paras);
    if ($agentid != 0) {
        $totallist = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE {$condition} ORDER BY lasttime DESC,id DESC " , $paras);

        $page_total = count($totallist);
    }
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " WHERE {$condition} ", array(':weid' => $weid));

    $datapage = ceil($total / 100);
    if($datapage <= 1) {

    }

    load()->model('mc');
    load()->func('compat.biz');

    foreach ($list as $key => $value) {
        if ($value['agentid'] > 0) {
            $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $value['agentid']));
            if ($agent) {
                if (empty($agent['nickname'])) {
                    $agentfans = mc_fetch($agent['from_user'], array("nickname","avatar"));
                    $list[$key]['agentheadimgurl'] = $agentfans['avatar'];
                    $list[$key]['agentnickname'] = $agentfans['nickname'];
                    pdo_update($this->table_fans, array('headimgurl' => $agentfans['avatar'], 'nickname' =>
                        $agentfans['nickname']), array('id' => $agent['id']));
                } else {
                    $list[$key]['agentheadimgurl'] = $agent['headimgurl'];
                    $list[$key]['agentnickname'] = $agent['nickname'];
                }
            }
        }
        $fans = mc_fetch($value['from_user'], array("credit1","credit2","nickname","avatar"));
        if (empty($value['nickname'])) {
            $list[$key]['headimgurl'] = $fans['avatar'];
            $list[$key]['nickname'] = $fans['nickname'];
            pdo_update($this->table_fans, array('headimgurl' => $fans['avatar'], 'nickname' => $fans['nickname']), array('id' => $value['id']));
        }

        if (!empty($fans)) {
            $list[$key]['credit1'] = $fans['credit1'];
            $list[$key]['credit2'] = $fans['credit2'];
        }

        $list[$key]['iscard'] = 0;
        $mcard = $this->get_sys_card($value['from_user']);
        if ($mcard == 1) {
            $list[$key]['iscard'] = 1;
        }
    }

    $order_count = pdo_fetchall("SELECT from_user,COUNT(1) as count FROM " . tablename($this->table_order) . "  GROUP BY from_user,weid having weid = :weid", array(':weid' => $_W['uniacid']), 'from_user');
    $pay_price = pdo_fetchall("SELECT from_user,sum(totalprice) as totalprice FROM " . tablename($this->table_order) . " WHERE status=3 GROUP BY
from_user,weid having weid = :weid", array(':weid' => $_W['uniacid']), 'from_user');

    if ($agentid != 0) {
        $page_totalprice = 0;
        foreach ($totallist as $k => $v) {
            $page_totalprice = $page_totalprice + floatval($pay_price[$v['from_user']]['totalprice']);
        }
    }

    $pager = pagination($total, $pindex, $psize);
} elseif($operation == 'black'){
    $condition = " weid=:weid AND from_user<>'' AND status=0 ";
    if (!empty($_GPC['keyword'])) {
        $types = trim($_GPC['types']);
        $condition .= " AND {$types} LIKE '%{$_GPC['keyword']}%'";
    }
    if (isset($_GPC['status']) && $_GPC['status'] != '') {
        $condition .= " AND status={$_GPC['status']} ";
    }

    $agentid = intval($_GPC['agentid']);
    if ($agentid != 0) {
        $condition .= " AND (agentid={$agentid} OR agentid2={$agentid}) ";
    }

    $paras = array(':weid' => $weid);

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";

    $usertype = intval($_GPC['usertype']);
    if ($usertype == 1) {
        $condition .= " AND is_commission=2 AND agentid=0 ";
    } else if ($usertype == 2) {
        $condition .= " AND is_commission=2 AND agentid>0 ";
    } else if ($usertype == 3) {
        $condition .= " AND is_commission=1 ";
    }

    $datapage = intval($_GPC['datapage']);

    if ($_GPC['out_put'] == 'output') {
        $this->out_fans($condition, $paras, $datapage);
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE {$condition} ORDER BY lasttime DESC,id DESC " . $limit, $paras);
    if ($agentid != 0) {
        $totallist = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE {$condition} ORDER BY lasttime DESC,id DESC " , $paras);

        $page_total = count($totallist);
    }
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " WHERE {$condition} ", array(':weid' => $weid));

    $datapage = ceil($total / 100);
    if($datapage <= 1) {

    }

    load()->model('mc');
    load()->func('compat.biz');

    foreach ($list as $key => $value) {
        if ($value['agentid'] > 0) {
            $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $value['agentid']));
            if ($agent) {
                if (empty($agent['nickname'])) {
                    $agentfans = mc_fetch($agent['from_user'], array("nickname","avatar"));
                    $list[$key]['agentheadimgurl'] = $agentfans['avatar'];
                    $list[$key]['agentnickname'] = $agentfans['nickname'];
                    pdo_update($this->table_fans, array('headimgurl' => $agentfans['avatar'], 'nickname' =>
                        $agentfans['nickname']), array('id' => $agent['id']));
                } else {
                    $list[$key]['agentheadimgurl'] = $agent['headimgurl'];
                    $list[$key]['agentnickname'] = $agent['nickname'];
                }
            }
        }
        $fans = mc_fetch($value['from_user'], array("credit1","credit2","nickname","avatar"));
        if (empty($value['nickname'])) {
            $list[$key]['headimgurl'] = $fans['avatar'];
            $list[$key]['nickname'] = $fans['nickname'];
            pdo_update($this->table_fans, array('headimgurl' => $fans['avatar'], 'nickname' => $fans['nickname']), array('id' => $value['id']));
        }

        if (!empty($fans)) {
            $list[$key]['credit1'] = $fans['credit1'];
            $list[$key]['credit2'] = $fans['credit2'];
        }

        $list[$key]['iscard'] = 0;
        $mcard = $this->get_sys_card($value['from_user']);
        if ($mcard == 1) {
            $list[$key]['iscard'] = 1;
        }
    }

    $order_count = pdo_fetchall("SELECT from_user,COUNT(1) as count FROM " . tablename($this->table_order) . "  GROUP BY from_user,weid having weid = :weid", array(':weid' => $_W['uniacid']), 'from_user');
    $pay_price = pdo_fetchall("SELECT from_user,sum(totalprice) as totalprice FROM " . tablename($this->table_order) . " WHERE status=3 GROUP BY
from_user,weid having weid = :weid", array(':weid' => $_W['uniacid']), 'from_user');

    if ($agentid != 0) {
        $page_totalprice = 0;
        foreach ($totallist as $k => $v) {
            $page_totalprice = $page_totalprice + floatval($pay_price[$v['from_user']]['totalprice']);
        }
    }

    $pager = pagination($total, $pindex, $psize);
} else if ($operation == 'record') {
    $fanslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND uid=0 ORDER BY lasttime DESC,id DESC ", array(':weid' => $weid));
    load()->model('mc');
    $groups = mc_groups();

    $fans_group = pdo_fetch('SELECT * FROM ' . tablename('mc_fans_groups') . ' WHERE uniacid = :uniacid AND acid = :acid', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']));
    $fans_group = iunserializer($fans_group['groups']);

    foreach ($fanslist as $key => $value) {
        $uid = mc_openid2uid($value['from_user']);
        pdo_update($this->table_fans, array('uid' => $uid), array('id' => $value['id']));
    }
    $condition = '';

    $groupid = intval($_GPC['groupid']);
    if ($groupid != 0) {
        $condition .= " AND b.groupid = {$groupid} ";
    }

    $gender = intval($_GPC['gender']);
    if ($gender != 0) {
        $condition .= " AND b.gender = {$gender} ";
    }
    $addtime = intval($_GPC['addtime']);
    if ($addtime != 0) {
        if ($addtime == 1) {
            $time = strtotime('-7 day');
            $condition .= " AND a.dateline > {$time} ";
        } else if ($addtime == 2) {
            $time = strtotime('-30 day');
            $condition .= " AND a.dateline > {$time} ";
        } else if ($addtime == 3) {
            $time = strtotime('-3 month');
            $condition .= " AND a.dateline > {$time} ";
        } else if ($addtime == 4) {
            $time = strtotime('-6 month');
            $condition .= " AND a.dateline > {$time} ";
        } else if ($addtime == 5) {
            $time = strtotime('-12 month');
            $condition .= " AND a.dateline > {$time} ";
        }
    }
    $paytime = intval($_GPC['paytime']);
    if ($paytime != 0) {
        if ($paytime == 1) {
            $time = strtotime('-1 month');
            $condition .= " AND a.paytime > {$time} ";
        } else if ($paytime == 2) {
            $stime = strtotime('-1 month');
            $etime = strtotime('-3 month');
            $condition .= " AND a.paytime < {$stime} AND a.paytime > {$etime} ";
        } else if ($paytime == 3) {
            $stime = strtotime('-3 month');
            $etime = strtotime('-6 month');
            $condition .= " AND a.paytime < {$stime} AND a.paytime > {$etime} ";
        } else if ($paytime == 4) {
            $stime = strtotime('-6 month');
            $etime = strtotime('-12 month');
            $condition .= " AND a.paytime < {$stime} AND a.paytime > {$etime} ";
        }
    }
    $selstoreid = intval($_GPC['selstoreid']);
    if ($selstoreid != 0) {
        $condition .= " AND a.storeid = {$selstoreid} ";
    }

    $age = intval($_GPC['age']);
    $cur_year = date('Y');
    if ($age != 0) {
        if ($age == 1) {
            $space_age = $cur_year - 18;
            $condition .= " AND b.birthyear > {$space_age} AND b.birthyear<>0 ";
        } else if ($age == 2) {
            $space_age_min = $cur_year - 18;
            $space_age_max = $cur_year - 24;
            $condition .= " AND b.birthyear <= {$space_age_min} AND b.birthyear >= {$space_age_max} AND b.birthyear<>0 ";
        } else if ($age == 3) {
            $space_age_min = $cur_year - 25;
            $space_age_max = $cur_year - 30;
            $condition .= " AND b.birthyear <= {$space_age_min} AND b.birthyear >= {$space_age_max} AND b.birthyear<>0 ";
        } else if ($age == 4) {
            $space_age_min = $cur_year - 31;
            $space_age_max = $cur_year - 35;
            $condition .= " AND b.birthyear <= {$space_age_min} AND b.birthyear >= {$space_age_max} AND b.birthyear<>0 ";
        } else if ($age == 5) {
            $space_age_min = $cur_year - 36;
            $space_age_max = $cur_year - 40;
            $condition .= " AND b.birthyear <= {$space_age_min} AND b.birthyear >= {$space_age_max} AND b.birthyear<>0 ";
        } else if ($age == 6) {
            $space_age = $cur_year - 40;
            $condition .= " AND b.birthyear < {$space_age} AND b.birthyear<>0 ";
        }
    }

    $count_min = intval($_GPC['count_min']);
    if ($count_min != 0) {
        $condition .= " AND a.totalcount >= {$count_min} ";
    }
    $count_max = intval($_GPC['count_max']);
    if ($count_max != 0) {
        $condition .= " AND a.totalcount <= {$count_max} ";
    }
    $price_min = intval($_GPC['price_min']);
    if ($price_min != 0) {
        $condition .= " AND a.totalprice >= {$price_min} ";
    }
    $price_max = intval($_GPC['price_max']);
    if ($price_max != 0) {
        $condition .= " AND a.totalprice <= {$price_max} ";
    }

    if (!empty($_GPC['keyword'])) {
        $types = trim($_GPC['types']);
        $condition .= " AND {$types} LIKE '%{$_GPC['keyword']}%'";
    }
    if (isset($_GPC['status']) && $_GPC['status'] != '') {
        $condition .= " AND status={$_GPC['status']} ";
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";

    if ($_GPC['out_put'] == 'output') {
        $list = pdo_fetchall("SELECT a.*,b.groupid FROM " . tablename($this->table_fans) . " a INNER JOIN " . tablename('mc_members') . " b
ON a.uid=b.uid WHERE a.weid = :weid {$condition} ORDER
BY a.lasttime DESC,a.id DESC", array(':weid' => $weid));

        $i = 0;
        foreach ($list as $key => $value) {
            $arr[$i]['nickname'] = $value['nickname'];
            $arr[$i]['username'] = $value['username'];
            $arr[$i]['mobile'] = $value['mobile'];
            $arr[$i]['from_user'] = $value['from_user'];
            $arr[$i]['level'] = $groups[$value['groupid']]['title'];
            $arr[$i]['totalprice'] = $value['totalprice'];
            $arr[$i]['totalcount'] = $value['totalcount'];
            $arr[$i]['paytime'] = date('Y-m-d H:i:s', $value['paytime']);
            $i++;
        }
        $this->exportexcel($arr, array('昵称', '姓名', '联系电话','微信ID', '会员等级', '交易总额', '交易笔数', '上次交易时间'), time());
        exit();
    }

    $list = pdo_fetchall("SELECT a.*,b.groupid,b.birthyear,b.credit1,b.credit2 FROM " . tablename($this->table_fans) . " a INNER
    JOIN " . tablename('mc_members') . " b
ON a.uid=b.uid WHERE a.weid = :weid {$condition} ORDER
BY a.lasttime DESC,a.id DESC
" . $limit, array(':weid' => $weid));

    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " a INNER JOIN " . tablename('mc_members') . " b ON a.uid=b.uid
WHERE a.weid = :weid {$condition} ORDER BY a.lasttime DESC,a.id DESC", array(':weid' => $weid));

    foreach ($list as $key => $value) {
        if ($value['agentid'] > 0) {
            $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $value['agentid']));
            if ($agent) {
                $list[$key]['agentheadimgurl'] = $agent['headimgurl'];
                $list[$key]['agentnickname'] = $agent['nickname'];
            }
        }
    }

    //门店列表
    $storelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid ORDER BY id DESC", array(':weid' => $weid), 'id');

    $pager = pagination($total, $pindex, $psize);
} else if ($operation == 'synchrodata') {
    $list = pdo_fetchall("SELECT from_user FROM " . tablename($this->table_fans) . " WHERE weid = :weid ORDER
            BY id DESC ", array(':weid' => $weid));
    foreach ($list as $key => $val) {
        $this->updateFansData($val['from_user']);
    }
    message('操作成功！', $this->createWebUrl('allfans', array('op' => 'record')), 'success');
} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $id));

    if ($item['agentid'] > 0) { //有推荐人
        $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $item['agentid'], ':weid' => $this->_weid));
    }
    if (!empty($item)) {
        $agent_url = $_W['siteroot'] . 'app/' . $this->createMobileUrl('usercenter', array('agentid' => $item['id']), true);
    }

    if (checksubmit()) {
        $data = array(
            'weid' => $weid,
            'nickname' => trim($_GPC['nickname2']),
            'agentid' => intval($_GPC['agentid']),
            'username' => trim($_GPC['username']),
            'mobile' => trim($_GPC['mobile']),
            'is_commission' => intval($_GPC['is_commission']),
            'address' => trim($_GPC['address']),
            'scene_str' => trim($_GPC['scene_str']),
            'lat' => trim($_GPC['baidumap']['lat']),
            'lng' => trim($_GPC['baidumap']['lng']),
            'sex' => intval($_GPC['sex']),
            'dateline' => TIMESTAMP
        );

        if ($data['agentid'] > 0) { //有推荐人
            if ($item['agentid'] <> $data['agentid']) { //推荐人有变动
                //更新二级推荐人
                pdo_update($this->table_fans, array('agentid2' => $data['agentid']), array('agentid' => $item['id'], 'weid' => $weid));
            }
        }

        if (!empty($_GPC['headimgurl'])) {
            $data['headimgurl'] = $_GPC['headimgurl'];
        }

        if (empty($item)) {
            pdo_insert($this->table_fans, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_fans, $data, array('id' => $id, 'weid' => $weid));
        }
        message('操作成功！', $this->createWebUrl('allfans', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }

    $order_count = pdo_fetchcolumn("SELECT COUNT(1) as count FROM " . tablename($this->table_order) . " WHERE from_user=:from_user AND weid = :weid", array(':weid' => $weid, ':from_user' => $item['from_user']));
    $cancel_count = pdo_fetchcolumn("SELECT COUNT(1) as count FROM " . tablename($this->table_order) . " WHERE from_user=:from_user AND weid = :weid AND status=-1", array(':weid' => $weid, ':from_user' => $item['from_user']));
    $pay_price = pdo_fetchcolumn("SELECT sum(totalprice) as totalprice FROM " . tablename($this->table_order)
        . " WHERE status=3 AND weid = :weid AND
from_user=:from_user", array(':weid' => $weid, ':from_user' => $item['from_user']));
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_fans) . " WHERE id = :id AND weid=:weid", array(':id' => $id, ':weid' => $weid));
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('allfans', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    pdo_delete($this->table_fans, array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('allfans', array('op' => 'display', 'storeid' => $storeid)), 'success');
} else if ($operation == 'setstatus') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    pdo_query("UPDATE " . tablename($this->table_fans) . " SET status = abs(:status - 1) WHERE id=:id", array(':status' => $status, ':id' => $id));
    message('操作成功！', $this->createWebUrl('allfans', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/allfans');