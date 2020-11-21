<?php
global $_W, $_GPC;
$weid = $this->_weid;
$action = 'setting';
$title = '系统设置';
$GLOBALS['frames'] = $this->getMainMenu();
$config = $this->module['config']['weisrc_dish'];
load()->func('tpl');
$setting = $this->getSetting();

$stores = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid ORDER BY `id` DESC", array(':weid' => $_W['uniacid']));
if (empty($stores)) {
    $url = $this->createWebUrl('stores', array('op' => 'display'));
}

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $reply = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_poster") . " WHERE weid = :weid ORDER BY `id` DESC",
        array(':weid' => $weid));

    $ishave = 0;
    if ($reply) {
        $ishave = 1;
        $now = TIMESTAMP;
        $data = json_decode(str_replace('&quot;', "'", $reply['data']), true);
        $size = getimagesize(toimage($reply['bg']));
        $size = array($size[0] / 2, $size[1] / 2);
        $titles = unserialize($reply['stitle']);
        $thumbs = unserialize($reply['sthumb']);
        $sdesc = unserialize($reply['sdesc']);
        $surl = unserialize($reply['surl']);
        foreach ($titles as $key => $value) {
            if (empty($value)) continue;
            $slist[] = array('stitle' => $value, 'sdesc' => $sdesc[$key], 'sthumb' => $thumbs[$key], 'surl' => $surl[$key]);
        }

    } else {
        $now = TIMESTAMP;
        $reply = array(
            "starttime" => $now,
            "endtime" => strtotime(date("Y-m-d H:i", $now + 7 * 24 * 3600)),
            "first_info" => '正在为您发送海报，请稍候……',
            "miss_wait" => '嗨：#昵称#下图是您的专属任务海报',
            "first_info" => '正在为您发送海报，请稍候……',
            "miss_sub" => '欢迎您关注拼红包活动，您的朋友#昵称#成为您的上级',
            "miss_resub" => '您的朋友#昵称#被您成功邀请了，他参加拼红包活动，提现时您将会获得佣金',
        );
    }

    if (checksubmit('submit')) {
//        print_r($_GPC ['data']);
//        exit;

        $insert = array(
            'weid' => $_W['uniacid'],
            'keywords' => $_GPC['keywords'],
            'title' => $_GPC['title'],
            'bg' => $_GPC['bg'],
            'data' => htmlspecialchars_decode($_GPC['data']),
            'first_info' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['first_info']), ENT_QUOTES),
            'miss_wait' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_wait']), ENT_QUOTES),
            'stitle' => serialize($_GPC['stitle']),
            'sthumb' => serialize($_GPC['sthumb']),
            'sdesc' => serialize($_GPC['sdesc']),
            'miss_start' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_start']), ENT_QUOTES),
            'miss_end' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_end']), ENT_QUOTES),
            'miss_sub' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_sub']), ENT_QUOTES),
            'miss_back' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_back']), ENT_QUOTES),
            'miss_resub' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_resub']), ENT_QUOTES),
            'miss_finish' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_finish']), ENT_QUOTES),
            'miss_youzan' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_youzan']), ENT_QUOTES),
            'miss_cj' => htmlspecialchars_decode(str_replace('&quot;', '&#039;', $_GPC ['miss_cj']), ENT_QUOTES),
            'starttime' => strtotime($_GPC['datelimit']['start']),
            //            'endtime' => strtotime($_GPC['datelimit']['end']) + 86400 - 1,
            'endtime' => strtotime($_GPC['datelimit']['end']),
            'surl' => serialize($_GPC ['surl']),
            'miss_temp' => $_GPC ['miss_temp'],
            'xzlx' => $_GPC['xzlx'],
            'fans_limit' => $_GPC['fans_limit'],
            'area' => $_GPC['area'],
            'sex' => $_GPC['sex'],
            'iptype' => $_GPC['iptype'],
            'posttype' => $_GPC['posttype'],
            'miss_name' => $_GPC ['miss_name'],
            'miss_num' => $_GPC ['miss_num'],
            'miss_font' => $_GPC ['miss_font'],
            'dateline' => TIMESTAMP,
        );
        if ($ishave == 0) {
            $id = pdo_insert("weisrc_dish_poster", $insert);
        } else {
            unset($insert['dateline']);
            pdo_update("weisrc_dish_poster", $insert, array('id' => $reply['id']));
        }


        $rule = array(
            'uniacid' => $_W['uniacid'],
            'name' => "餐饮海报",
            'module' => 'weisrc_dish',
            'status' => 1,
            'displayorder' => 255
        );
        $sql = "SELECT * FROM " . tablename('rule') . ' WHERE `module` = :module AND `name` = :name AND uniacid = :uniacid';
        $pars = array();
        $pars[':module'] = 'weisrc_dish';
        $pars[':name'] = "餐饮海报";
        $pars[':uniacid'] = $_W['uniacid'];
        $replyrule = pdo_fetch($sql, $pars);
        if (!empty($replyrule)) {
            $rid = $replyrule['id'];
            $result = pdo_update('rule', $rule, array('id' => $rid));
        } else {
            $result = pdo_insert('rule', $rule);
            $rid = pdo_insertid();
        }

        if (!empty($rid)) {
            $sql = 'DELETE FROM ' . tablename('rule_keyword') . ' WHERE `rid`=:rid AND `uniacid`=:uniacid';
            $pars = array();
            $pars[':rid'] = $rid;
            $pars[':uniacid'] = $_W['uniacid'];
            $item = pdo_query($sql, $pars);

            $rowtpl = array(
                'rid' => $rid,
                'uniacid' => $_W['uniacid'],
                'module' => 'weisrc_dish',
                'status' => 1,
                'displayorder' => $rule['displayorder'],
                'type' => 1,
                'content' => $_GPC['keywords']
            );
            if ($keyword) {
                pdo_update('rule_keyword', $rowtpl, array('id' => $item['id']));
            } else {
                pdo_insert('rule_keyword', $rowtpl);
            }
        }
        message('操作成功', $this->createWebUrl('poster', array('op' => 'display')), 'success');
    }

} elseif ($operation == 'post') {

}

include $this->template('web/poster');
