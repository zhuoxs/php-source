<?php
/**
 * 男神女神投票排名自助查询模块微站定义
 *
 * @author 忘道
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Xiaof_toupiao_plugin_rankModuleSite extends WeModuleSite
{


    public function doMobileIndex()
    {
        global $_W, $_GPC;

        $sid = intval($_GPC['sid']);

        if ($settings = pdo_fetch("SELECT `id`,`tit`,`data` FROM " . tablename("xiaof_toupiao_setting") . " WHERE `id` = :id", array(":id" => $sid))) {
            $setting = iunserializer($settings['data']);


            $rank = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_plugin_rank") . " WHERE `sid` = :sid", array(":sid" => $sid));
            $item = iunserializer($rank['data']);

            $prize = array();
            if (isset($_GPC['phone'])) {
                if ($tp = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = :sid AND `phone` = :phone", array(":sid" => $sid, ":phone" => $_GPC['phone']))) {
                    if (empty($item['openparallel'])) {
                        $top = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = '" . $sid . "' AND `verify`!='2' AND `good` > :good", array(":good" => $tp['good']));
                        $top = empty($top) ? 1 : $top+1;
                        $parallel = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("xiaof_toupiao") . " WHERE `sid` = '" . $sid . "' AND `verify`!='2' AND `good` = :good AND `id` < :id", array(":good" => $tp['good'], ":id" => $tp['id']));
                        empty($parallel) or $top = $top + $parallel;
                    } else {
                        $top = pdo_fetchcolumn("SELECT COUNT(*) FROM (SELECT * FROM " . tablename("xiaof_toupiao") . "  WHERE `sid` = '" . $sid . "' AND `verify`!='2' group by `good`) as tp WHERE `good` > :good", array(":good" => $tp['good']));
                        $top = empty($top) ? 1 : $top+1;
                    }
                    foreach ($item['paiming'] as $k => $v) {
                        if ($_GPC['phone'] == $v['phone']) {
                            $top = $v['num'];
                            break;
                        }
                    }
                    foreach ($item['giving'] as $k => $v) {
                        if ($top >= $v['lsort'] && $top <= $v['rsort']) {
                            $prize = $v;
                            break;
                        }
                    }
                }
            }
        } else {
            message('参数错误');
        }

        include $this->template("index");
    }

    public function doWebPrize()
    {
        global $_W, $_GPC;

        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = " . $_W['uniacid']);
        $lists = pdo_fetchall("SELECT * FROM " . tablename('xiaof_toupiao_setting') . " WHERE `uniacid` = :uniacid ORDER BY `id` DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(":uniacid" => $_W['uniacid']));

        $list = array();
        foreach ($lists as $k => $v) {
            $rank = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_plugin_rank") . " WHERE `sid` = :sid", array(":sid" => $v['id']));
            $item = array();
            $item['id'] = $v['id'];
            $item['created_at'] = $v['created_at'];
            $item['tags'] = $rank ? $rank['id'] : 0;
            $list[] = array_merge($item, unserialize($v['data']));
        }

        $pager = pagination($total, $pindex, $psize);

        include $this->template("prize");
    }

    public function doWebPrizeedit()
    {
        global $_W, $_GPC;

        $item = array();
        if (isset($_GET['sid'])) {
            $rank = pdo_fetch("SELECT * FROM " . tablename("xiaof_toupiao_plugin_rank") . " WHERE `sid` = :sid", array(":sid" => intval($_GPC['sid'])));
            $item = iunserializer($rank['data']);
            $did = $rank['id'];
        }


        if (checksubmit()) {

            $dat['openparallel'] = $_GPC['openparallel'];

            foreach ($_GPC['giving']['lsort'] as $k => $v) {
                $fieldarray = array();
                $fieldarray['lsort'] = $v;
                $fieldarray['rsort'] = $_GPC['giving']['rsort'][$k];
                $fieldarray['name'] = $_GPC['giving']['name'][$k];
                $fieldarray['pic'] = $_GPC['giving']['pic'][$k];
                $dat['giving'][] = $fieldarray;
            }

            foreach ($_GPC['paiming']['phone'] as $k => $v) {
                $fieldarray1 = array();
                $fieldarray1['phone'] = $v;
                $fieldarray1['num'] = $_GPC['paiming']['num'][$k];
                $dat['paiming'][] = $fieldarray1;
            }

            $data = iserializer($dat);

            if ($_GPC['did'] >= 1) {

                $did = intval($_GPC['did']);
                pdo_update("xiaof_toupiao_plugin_rank", array(
                    "data" => $data
                ), array("id" => $did));

            } else {
                pdo_insert("xiaof_toupiao_plugin_rank", array(
                    "sid" => intval($_GPC['sid']),
                    "data" => $data
                ));
                $id = pdo_insertid();

            }
            message('信息编辑成功', referer(), 'success');
        }

        include $this->template("edit");
    }

}