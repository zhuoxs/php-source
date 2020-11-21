<?php
defined('IN_IA') or exit('Access Denied');

class Areaagent_WeliamController {
    /**
     * 代理列表
     */
    public function agentIndex() {
        global $_W, $_GPC;

        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $where = array();
        if (!empty($_GPC['agentname'])) {
            $where['agentname'] = $_GPC['agentname'];
        }
        if (!empty($_GPC['status'])) {
            $where['status'] = $_GPC['status'];
        }

        $agentes = Area::getAllAgent($pindex - 1, $psize, $where);
        $agents = $agentes['data'];
        if (!empty($agents)) {
            foreach ($agents as $key => $value) {
                $group = Area::getSingleGroup($value['groupid']);
                $agents[$key]['groupname'] = $group['name'];
            }
        }
        $pager = pagination($agentes['count'], $pindex, $psize);
        include wl_template('area/agentIndex');
    }

    public function agentImport() {
        global $_W, $_GPC;
        if ($_W['ispost']) {
            $level = intval($_GPC['districtslevel']);
            $groupid = intval($_GPC['groupid']);
            $allarea = pdo_getall(PDO_NAME . "area", array('displayorder' => 0, 'level' => $level), array('id', 'name'));
            foreach ($allarea as $item) {
                $hasarea = pdo_getcolumn(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'areaid' => $item['id']), 'id');
                if ($hasarea) {
                    continue;
                }
                $agent = array(
                    'uniacid'   => $_W['uniacid'],
                    'groupid'   => $groupid,
                    'agentname' => $item['name'] . '代理',
                    'username'  => Util::createSalt(12),
                    'password'  => '12345678',
                    'salt'      => Util::createSalt(8),
                    'status'    => 1,
                    'joindate'  => time(),
                    'joinip'    => $_W['clientip'],
                    'starttime' => time(),
                    'endtime'   => time() + 365*24*60*60
                );
                $agent['password'] = Util::encryptedPassword($agent['password'], $agent['salt']);
                pdo_insert(PDO_NAME . 'agentusers', $agent);
                pdo_insert(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => pdo_insertid(), 'level' => $level, 'status' => 1, 'areaid' => $item['id']));
            }
            show_json(1, '代理一键导入成功。');
        }

        $allgroups = Area::getAllGroup(0, 100, 1);
        $allgroup = $allgroups['data'];
        include wl_template('area/agentImport');
    }

    /**
     * 代理编辑
     */
    public function agentEdit() {
        global $_W, $_GPC;
        $settings = Setting::wlsetting_read('base');
        if (checksubmit('submit')) {
            $agent = $_GPC['agent'];
            if (empty($_GPC['districts']))
                wl_message('您需要选择代理区域');
            if (empty($_GPC['id'])) {
                load()->model('user');
                if (!preg_match(REGULAR_USERNAME, $agent['username'])) {
                    wl_message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
                }
                if (User::agentuser_single(array('username' => $agent['username']))) {
                    wl_message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
                }
                if (istrlen($agent['password']) < 8) {
                    wl_message('必须输入密码，且密码长度不得低于8位。');
                }
                $agent['joindate'] = time();
                $agent['joinip'] = $_W['clientip'];
                $agent['starttime'] = time();
                $agent['salt'] = Util::createSalt(8);
                $agent['password'] = Util::encryptedPassword($agent['password'], $agent['salt']);
                $agent['username'] = trim($agent['username']);
            } else {
                load()->model('user');
                if (!preg_match(REGULAR_USERNAME, $agent['username'])) {
                    wl_message('用户名格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
                }
                if (!empty($_GPC['password']) && istrlen($_GPC['password']) < 8) {
                    wl_message('必须输入密码，且密码长度不得低于8位。');
                }
                if (!empty($_GPC['password'])) {
                    $agent['salt'] = Util::createSalt(8);
                    $agent['password'] = Util::encryptedPassword($_GPC['password'], $agent['salt']);
                }
            }
            $agent['cashopenid'] = $_GPC['openid'];
            $agent['agentname'] = trim($agent['agentname']);
            $agent['realname'] = trim($agent['realname']);
            $agent['mobile'] = trim($agent['mobile']);
            $agent['status'] = $_GPC['status'];
            $agent['endtime'] = strtotime($agent['endtime']);
            $agent['percent'] = serialize($_GPC['percent']);
            $agentid = Area::editAgent($agent, $_GPC['id']);

            if (Area::save_agent_area($_GPC['districts'], $_GPC['districtslevel'], $agentid)) {
                Cache::deleteCache('area', 'terarea' . $_W['uniacid']);
                wl_message('保存成功！', web_url('area/areaagent/agentIndex'), 'success');
            } else {
                wl_message('保存失败！', referer(), 'error');
            }
        }

        $agent = Area::getSingleAgent(intval($_GPC['id']));
        $allgroups = Area::getAllGroup(0, 100, 1);
        $allgroup = $allgroups['data'];
        $m['openid'] = $agent['cashopenid'];
        if ($m['openid']) {
            $member = Util::getSingelData('nickname', PDO_NAME . 'member', array('openid' => $m['openid']));
            $m['nickname'] = $member['nickname'];
        }

        //区域操作
        $AreaTab = tablename(PDO_NAME . "area");
        $orderBy = " ORDER BY id ASC ";
        //获取一级省/直辖市
        $province = pdo_fetchall("SELECT id,name FROM " . $AreaTab . " WHERE level = 1 AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) " . $orderBy);
        if ($_GPC['id']) {
            //id存在 修改操作
            $area = pdo_get(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => intval($_GPC['id'])));
            $province_id = $area['areaid'];//省/直辖市id
            $city_id = $area['areaid'];//市id
            $district_id = $area['areaid'];//区/县id
            $town_id = $area['areaid'];//镇/乡id
            //逆推 获取当前代理商的省/市/区/镇的信息
            if ($area['level'] >= 4) {
                $district_id = pdo_fetchcolumn("SELECT pid FROM " . $AreaTab . " WHERE level = 4 AND id = {$town_id}  AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) ");
                $town = pdo_fetchall("SELECT id,name FROM " . $AreaTab . " WHERE level = 4 AND pid = {$district_id}  AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) " . $orderBy);
            }
            if ($area['level'] >= 3) {
                $city_id = pdo_fetchcolumn("SELECT pid FROM " . $AreaTab . " WHERE level = 3 AND id = {$district_id}  AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) ");
                $district = pdo_fetchall("SELECT id,name FROM " . $AreaTab . " WHERE level = 3 AND pid = {$city_id}  AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) " . $orderBy);
            }
            if ($area['level'] >= 2) {
                $province_id = pdo_fetchcolumn("SELECT pid FROM " . $AreaTab . " WHERE level = 2 AND id = {$city_id}  AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) ");
                $city = pdo_fetchall("SELECT id,name FROM " . $AreaTab . " WHERE level = 2 AND pid = {$province_id} AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) " . $orderBy);
            }
        } else {
            //获取第一个省/直辖市 下所有的市
            $city = pdo_fetchall("SELECT id,name FROM " . $AreaTab . " WHERE level = 2 AND pid = {$province[0]['id']} AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) " . $orderBy);
            //获取第一个市  下所有的区/县
            $district = pdo_fetchall("SELECT id,name FROM " . $AreaTab . " WHERE level = 3 AND pid = {$city[0]['id']} AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) " . $orderBy);
            //获取第一个区/县  下所有的镇/乡
            $town = pdo_fetchall("SELECT id,name FROM " . $AreaTab . " WHERE level = 4 AND pid = {$district[0]['id']} AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) " . $orderBy);
        }

        include wl_template('area/agentEdit');
    }

    public function getArea() {
        global $_W, $_GPC;
        $nodes = Area::address_tree_in_use();
        die(json_encode($nodes));
    }

    /**
     * 代理编辑
     */
    public function agentDelete() {
        global $_W, $_GPC;
        if (Area::deleteAgent($_GPC['id']))
            wl_message('删除成功！', web_url('area/areaagent/agentIndex'), 'success');
        wl_message('删除失败！', web_url('area/areaagent/agentIndex'), 'error');
    }

    /**
     * 代理删除
     */
    public function deletearea() {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $res = pdo_delete('wlmerchant_agentusers', array('id' => $id, 'uniacid' => $_W['uniacid']));
        if ($res) {
            pdo_delete('wlmerchant_oparea', array('aid' => $id, 'uniacid' => $_W['uniacid']));
            show_json(1, '代理删除成功');
        } else {
            show_json(0, '代理删除失败，请重试');
        }
    }

    /**
     * Comment: 获取对应的地区信息
     * Author: zzw
     */
    public function getAreaInfo() {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $lv = $_GPC['lv'];
        $info = pdo_fetchall("SELECT id,name FROM " . tablename(PDO_NAME . "area") . " WHERE pid = {$id} AND `level` = {$lv}  AND (displayorder = 0 OR displayorder = {$_W['uniacid']}) ");
        wl_json(1, '下级区域信息', $info);
    }
    //////////////////////////代理分组//////////////////////////////

    /**
     * 代理分组列表
     */
    public function groupIndex() {
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $groupes = Area::getAllGroup($pindex - 1, $psize);

        $groups = $groupes['data'];
        $pager = pagination($groupes['count'], $pindex, $psize);
        $plugins = App::get_apps(0, 'agent');

        include wl_template('area/groupIndex');
    }

    /**
     * 代理分组编辑
     */
    public function groupEdit() {
        global $_W, $_GPC;
        if (checksubmit('submit')) {
            $arr['name'] = trim($_GPC['name']);
            $arr['isdefault'] = $_GPC['isdefault'];
            $arr['enabled'] = $_GPC['enabled'];
            $arr['package'] = iserializer($_GPC["plugins"]);
            if (empty($arr['name']))
                wl_message('分组名称不能为空');
            if (Area::editGroup($arr, intval($_GPC['id']))) {
                wl_message('代理分组更新成功', web_url('area/areaagent/groupIndex'), 'success');
            } else {
                wl_message('代理分组更新失败', web_url('area/areaagent/groupIndex'), 'error');
            }
        }
        $category = Area::getSingleGroup(intval($_GPC['id']));
        $plugins = App::get_apps(0, 'agent');

        include wl_template('area/groupEdit');
    }

    /**
     * 删除代理分组
     */
    public function groupDelete() {
        global $_W, $_GPC;
        if (empty($_GPC['id']))
            wl_message('未找到该分组', referer(), 'error');
        if (Area::deleteGroup($_GPC['id']))
            wl_message('分组删除成功', web_url('area/areaagent/groupIndex'), 'success');
        wl_message('分组删除失败', web_url('area/areaagent/groupIndex'), 'error');
    }

    public function manage() {
        global $_W, $_GPC;
        $agent = Area::getSingleAgent(intval($_GPC['id']));
        if (empty($agent)) {
            wl_message('未找到代理信息，请重试');
        }
        $cookie = array();
        $cookie['id'] = $agent['id'];
        $cookie['uniacid'] = $agent['uniacid'];
        $cookie['hash'] = md5($agent['password'] . $agent['salt']);
        $session = base64_encode(json_encode($cookie));
        isetcookie('__wlagent_staff_session', '', -10000);//删除员工登录信息
        isetcookie('__wlagent_session', $session, 7 * 86400, true);
        header('location: ' . $_W['siteroot'] . "web/agent.php?p=dashboard&ac=dashboard&do=index&");
    }

}
