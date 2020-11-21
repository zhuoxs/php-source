<?php

defined('IN_IA') or exit('Access Denied');
define('HTTP_X_FOR', (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://');
define('CLOUD_GATEWAY_URL', HTTP_X_FOR .'cloud.zhifun.cc/app/api.php');
define('CLOUD_GATEWAY_URL_NORMAL', HTTP_X_FOR .'cloud.zhifun.cc/app/api.php');
function cloud_client_define() {
    return array(
        '/framework/function/communication.func.php',
        '/framework/model/cloud.mod.php',
        '/web/source/cloud/upgrade.ctrl.php',
        '/web/source/cloud/process.ctrl.php',
        '/web/source/cloud/dock.ctrl.php',
        '/web/themes/default/cloud/upgrade.html',
        '/web/themes/default/cloud/process.html'
    );
}
function _cloud_build_params() {
    global $_W;
    $pars = array();
    $pars['family'] = IMS_FAMILY;
    $pars['version'] = IMS_VERSION;
    $pars['release'] = IMS_RELEASE_DATE;
	$pars['host'] = trim(preg_replace('/http(s)?:\\/\\//', '', trim($_W['siteroot'], '/')));
    $pars['key'] = $_W['setting']['site']['key'];
    $pars['token'] = $_W['setting']['site']['token'];
    $pars['password'] = md5($_W['setting']['site']['key'] . $_W['setting']['site']['token']);
    $clients = cloud_client_define();
    $string = '';
    foreach ($clients as $cli) {
        $string.= md5_file(IA_ROOT . $cli);
    }
    $pars['client'] = md5($string);
    return $pars;
}
function _cloud_shipping_parse($dat, $file) {
    if (is_error($dat)) {
        return error(-1, '网络传输错误, 请检查您的cURL是否可用, 或者服务器网络是否正常. ' . $dat['message']);
    }
    $tmp = unserialize($dat['content']);
    if (is_array($tmp) && is_error($tmp)) {
        if ($tmp['errno'] == '-2') {
            $data = file_get_contents(IA_ROOT . '/framework/version.inc.php');
            file_put_contents(IA_ROOT . '/framework/version.inc.php', str_replace("'x'", "'v'", $data));
        }
        return $tmp;
    }
    if ($dat['content'] == 'patching') {
        return error(-1, '补丁程序正在更新中，请稍后再试！');
    }
    if ($dat['content'] == 'frequent') {
        return error(-1, '更新操作太频繁，请稍后再试！');
    }
    $data = @file_get_contents($file);
    @unlink($file);
    $ret = @iunserializer($data);
    $ret = iunserializer($ret['data']);
    if (is_array($ret) && is_error($ret)) {
        if ($ret['errno'] == '-2') {
            $data = file_get_contents(IA_ROOT . '/framework/version.inc.php');
            file_put_contents(IA_ROOT . '/framework/version.inc.php', str_replace("'x'", "'v'", $data));
        }
    }
    if (!is_error($ret) && is_array($ret) && !empty($ret)) {
        if ($ret['state'] == 'fatal') {
            return error($ret['errorno'], '发生错误: ' . $ret['message']);
        }
        return $ret;
    } else {
        return error($ret['errno'], "发生错误: {$ret['message']}");
    }
}
function cloud_request($url, $post = '', $extra = array() , $timeout = 60) {
    global $_W;
    load()->func('communication');
    if (!empty($_W['setting']['cloudip']['ip']) && empty($extra['ip'])) {
        //$extra['ip'] = $_W['setting']['cloudip']['ip'];
        //$extra['ip'] = "cloud.zhifun.cc";
        
    }
    return ihttp_request($url, $post, $extra, $timeout);
}
function cloud_prepare() {
    global $_W;
    setting_load();
    if (empty($_W['setting']['site']['key']) || empty($_W['setting']['site']['token'])) {
        return error('-1', "您的站点只有在微擎云服务平台成功注册后，才能使用云服务的相应功能。");
    }
    return true;
}
function cloud_build() {
    $pars = _cloud_build_params();
    $pars['method'] = 'application.build2';
    $pars['extra'] = cloud_extra_account();
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/application.build';
    $ret = _cloud_shipping_parse($dat, $file);
    if (!is_error($ret)) {
        if ($ret['state'] == 'warning') {
            $ret['files'] = cloud_client_define();
            unset($ret['schemas']);
            unset($ret['scripts']);
        } else {
            $files = array();
            if (!empty($ret['files'])) {
                foreach ($ret['files'] as $file) {
                    $entry = IA_ROOT . $file['path'];
                    if (!is_file($entry) || md5_file($entry) != $file['checksum']) {
                        $files[] = $file['path'];
                    }
                }
            }
            $ret['files'] = $files;
            if (!empty($ret['files'])) {
                cloud_bakup_files($ret['files']);
            }
            $schemas = array();
            if (!empty($ret['schemas'])) {
                load()->func('db');
                foreach ($ret['schemas'] as $remote) {
                    $name = substr($remote['tablename'], 4);
                    $local = db_table_schema(pdo() , $name);
                    unset($remote['increment']);
                    unset($local['increment']);
                    if (empty($local)) {
                        $schemas[] = $remote;
                    } else {
                        $sqls = db_table_fix_sql($local, $remote);
                        if (!empty($sqls)) {
                            $schemas[] = $remote;
                        }
                    }
                }
            }
            $ret['schemas'] = $schemas;
        }
        if ($ret['family'] == 'x' && IMS_FAMILY == 'v') {
            load()->model('setting');
            setting_upgrade_version('x', IMS_VERSION, IMS_RELEASE_DATE);
            itoast('您已经购买了商业授权版本, 系统将转换为商业版, 并重新运行自动更新程序.', 'refresh');
        }
		$crelease = IMS_RELEASE_DATE;
        if ($ret['release'] <= $crelease) {
			unset($ret['scripts']);
		}
        $ret['upgrade'] = false;
        if (!empty($ret['files']) || !empty($ret['schemas']) || !empty($ret['scripts'])) {
            $ret['upgrade'] = true;
        }
        $upgrade = array();
        $upgrade['upgrade'] = $ret['upgrade'];
        $upgrade['data'] = $ret;
        $upgrade['lastupdate'] = TIMESTAMP;
        cache_write('upgrade', $upgrade);
        cache_write('cloud:transtoken', authcode($ret['token'], 'ENCODE'));
    }
    return $ret;
}
function cloud_schema() {
    $pars = _cloud_build_params();
    $pars['method'] = 'application.schema';
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/application.schema';
    $ret = _cloud_shipping_parse($dat, $file);
    if (!is_error($ret)) {
        $schemas = array();
        if (!empty($ret['schemas'])) {
            load()->func('db');
            foreach ($ret['schemas'] as $remote) {
                $name = substr($remote['tablename'], 4);
                $local = db_table_schema(pdo() , $name);
                unset($remote['increment']);
                unset($local['increment']);
                if (empty($local)) {
                    $schemas[] = $remote;
                } else {
                    $diffs = db_schema_compare($local, $remote);
                    if (!empty($diffs)) {
                        $schemas[] = $remote;
                    }
                }
            }
        }
        $ret['schemas'] = $schemas;
    }
    return $ret;
}
function cloud_download($path, $type = '') {
    $pars = _cloud_build_params();
    $pars['method'] = 'application.shipping';
    $pars['path'] = $path;
    $pars['type'] = $type;
    $pars['gz'] = function_exists('gzcompress') && function_exists('gzuncompress') ? 'true' : 'false';
    $pars['download'] = 'true';
    $headers = array(
        'content-type' => 'application/x-www-form-urlencoded'
    );
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, $headers, 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    if ($dat['content'] == 'success') {
        return true;
    }
    $ret = @json_decode($dat['content'], true);
    if (is_error($ret)) {
        return $ret;
    } else {
        $post = $dat['content'];
        $data = base64_decode($post);
        if (base64_encode($data) !== $post) {
            $data = $post;
        }
        $ret = iunserializer($data);
        $gz = function_exists('gzcompress') && function_exists('gzuncompress');
        $file = base64_decode($ret['file']);
        if ($gz) {
            $file = gzuncompress($file);
        }
        $_W['setting']['site']['token'] = authcode(cache_load('cloud:transtoken') , 'DECODE');
        $string = (md5($file) . $ret['path'] . $_W['setting']['site']['token']);
        if (!empty($_W['setting']['site']['token']) && md5($string) === $ret['sign']) {
            $path = IA_ROOT . $ret['path'];
            load()->func('file');
            @mkdirs(dirname($path));
            if (file_put_contents($path, $file)) {
                return true;
            } else {
                return error(-1, '写入失败');
            }
        }
        return error(-1, '写入失败');
    }
}
function cloud_m_prepare($name) {
    $pars['method'] = 'module.check';
    $pars['module'] = $name;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    if (is_error($dat)) {
        return $dat;
    }
    if ($dat['content'] == 'install-module-protect') {
        //	return error('-1', '此模块已设置版权保护，您只能通过云平台来安装。');
        
    }
    return true;
}
function cloud_m_build($modulename, $type = '') {
    $type = in_array($type, array(
        'uninstall'
    )) ? $type : '';
    $sql = 'SELECT * FROM ' . tablename('modules') . ' WHERE `name`=:name';
    $module = pdo_fetch($sql, array(
        ':name' => $modulename
    ));
    $pars = _cloud_build_params();
    $pars['method'] = 'module.build';
    $pars['module'] = $modulename;
    $pars['type'] = $type;
    if (!empty($module)) {
        $pars['module_version'] = $module['version'];
    }
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/module.build';
    $ret = _cloud_shipping_parse($dat, $file);
    if (!is_error($ret)) {
        $dir = IA_ROOT . '/addons/' . $modulename;
        $files = array();
        if (!empty($ret['files'])) {
            foreach ($ret['files'] as $file) {
                $entry = $dir . $file['path'];
                if (!is_file($entry) || md5_file($entry) != $file['checksum']) {
                    $files[] = '/' . $modulename . $file['path'];
                }
            }
        }
        $ret['files'] = $files;
        $schemas = array();
        if (!empty($ret['schemas'])) {
            load()->func('db');
            foreach ($ret['schemas'] as $remote) {
                $name = substr($remote['tablename'], 4);
                $local = db_table_schema(pdo() , $name);
                unset($remote['increment']);
                unset($local['increment']);
                if (empty($local)) {
                    $schemas[] = $remote;
                } else {
                    $diffs = db_table_fix_sql($local, $remote);
                    if (!empty($diffs)) {
                        $schemas[] = $remote;
                    }
                }
            }
        }
        $ret['upgrade'] = true;
        $ret['type'] = 'module';
        $ret['schemas'] = $schemas;
        if (empty($module)) {
            $ret['install'] = 1;
        }
        cache_write('cloud:transtoken', authcode($ret['token'], 'ENCODE'));
    }
    return $ret;
}
function cloud_m_query() {
    $pars = _cloud_build_params();
    $pars['method'] = 'module.query';
    $pars['module'] = cloud_extra_module();
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/module.query';
    $ret = _cloud_shipping_parse($dat, $file);
    return $ret;
}
function cloud_m_info($name) {
    $pars = _cloud_build_params();
    $pars['method'] = 'module.info';
    $pars['module'] = $name;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/module.info';
    $ret = _cloud_shipping_parse($dat, $file);
    return $ret;
}
function cloud_m_upgradeinfo($name) {
    $module = pdo_fetch("SELECT name, version FROM " . tablename('modules') . " WHERE name = '{$name}'");
    $pars = _cloud_build_params();
    $pars['method'] = 'module.info';
    $pars['module'] = $name;
    $pars['curversion'] = $module['version'];
    $pars['isupgrade'] = 1;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/module.info';
    $ret = _cloud_shipping_parse($dat, $file);
    if (!empty($ret) && !is_error($ret)) {
        $ret['site_branch'] = $ret['branches'][$ret['version']['branch_id']];
        $ret['from'] = 'cloud';
        foreach ($ret['branches'] as & $branch) {
            if ($branch['displayorder'] < $ret['site_branch']['displayorder'] || ($ret['site_branch']['displayorder'] == $ret['site_branch']['displayorder'] && $ret['site_branch']['id'] > intval($branch['id']))) {
                unset($module['branches'][$branch['id']]);
                continue;
            }
            $branch['id'] = intval($branch['id']);
            $branch['displayorder'] = intval($branch['displayorder']);
            $branch['day'] = intval(date('d', $branch['version']['createtime']));
            $branch['month'] = date('Y.m', $branch['version']['createtime']);
            $branch['hour'] = date('H:i', $branch['version']['createtime']);
        }
        unset($branch);
    }
    return $ret;
}
function cloud_t_prepare($name) {
    $pars['method'] = 'theme.check';
    $pars['theme'] = $name;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    if (is_error($dat)) {
        return $dat;
    }
    if ($dat['content'] == 'install-theme-protect') {
        return error('-1', '此模板已设置版权保护，您只能通过云平台来安装。');
    }
    return true;
}
function cloud_t_query() {
    $pars = _cloud_build_params();
    $pars['method'] = 'theme.query';
    $pars['theme'] = cloud_extra_theme();
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/theme.query';
    //$ret = _cloud_shipping_parse($dat, $file);
    return $ret;
}
function cloud_t_info($name) {
    $pars = _cloud_build_params();
    $pars['method'] = 'theme.info';
    $pars['theme'] = $name;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/theme.info';
    $ret = _cloud_shipping_parse($dat, $file);
    return $ret;
}
function cloud_t_build($name) {
    $sql = 'SELECT * FROM ' . tablename('site_templates') . ' WHERE `name`=:name';
    $theme = pdo_fetch($sql, array(
        ':name' => $name
    ));
    $pars = _cloud_build_params();
    $pars['method'] = 'theme.build';
    $pars['theme'] = $name;
    if (!empty($theme)) {
        $pars['themeversion'] = $theme['version'];
    }
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/theme.build';
    $ret = _cloud_shipping_parse($dat, $file);
    if (!is_error($ret)) {
        $dir = IA_ROOT . '/app/themes/' . $name;
        $files = array();
        if (!empty($ret['files'])) {
            foreach ($ret['files'] as $file) {
                $entry = $dir . $file['path'];
                if (!is_file($entry) || md5_file($entry) != $file['checksum']) {
                    $files[] = '/' . $name . $file['path'];
                }
            }
        }
        $ret['files'] = $files;
        $ret['upgrade'] = true;
        $ret['type'] = 'theme';
        if (empty($theme)) {
            $ret['install'] = 1;
        }
        cache_write('cloud:transtoken', authcode($ret['token'], 'ENCODE'));
    }
    return $ret;
}
function cloud_t_upgradeinfo($name) {
    $sql = 'SELECT `name`, `version` FROM ' . tablename('site_templates') . ' WHERE `name` = :name';
    $theme = pdo_fetch($sql, array(
        ':name' => $name
    ));
    $pars = _cloud_build_params();
    $pars['method'] = 'theme.upgrade';
    $pars['theme'] = $theme['name'];
    $pars['version'] = $theme['version'];
    $pars['isupgrade'] = 1;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/module.info';
    $ret = _cloud_shipping_parse($dat, $file);
    return $ret;
}
function cloud_w_prepare($name) {
    $pars['method'] = 'webtheme.check';
    $pars['webtheme'] = $name;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    if (is_error($dat)) {
        return $dat;
    }
    if ($dat['content'] == 'install-webtheme-protect') {
        return error('-1', '此后台皮肤已设置版权保护，您只能通过云平台来安装。');
    }
    return true;
}
function cloud_w_query() {
    $pars = _cloud_build_params();
    $pars['method'] = 'webtheme.query';
    $pars['webtheme'] = cloud_extra_webtheme();
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/webtheme.query';
    $ret = _cloud_shipping_parse($dat, $file);
    return $ret;
}
function cloud_w_info($name) {
    $pars = _cloud_build_params();
    $pars['method'] = 'webtheme.info';
    $pars['webtheme'] = $name;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/webtheme.info';
    $ret = _cloud_shipping_parse($dat, $file);
    return $ret;
}
function cloud_w_build($name) {
    $sql = 'SELECT * FROM ' . tablename('webtheme_homepages') . ' WHERE `name`=:name';
    $webtheme = pdo_fetch($sql, array(
        ':name' => $name
    ));
    $pars = _cloud_build_params();
    $pars['method'] = 'webtheme.build';
    $pars['webtheme'] = $name;
    if (!empty($webtheme)) {
        $pars['webtheme_version'] = $webtheme['version'];
    }
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/webtheme.build';
    $ret = _cloud_shipping_parse($dat, $file);
    if (!is_error($ret)) {
        $dir = IA_ROOT . '/web/themes/' . $name;
        $files = array();
        if (!empty($ret['files'])) {
            foreach ($ret['files'] as $file) {
                $entry = $dir . $file['path'];
                if (!is_file($entry) || md5_file($entry) != $file['checksum']) {
                    $files[] = '/' . $name . $file['path'];
                }
            }
        }
        $ret['files'] = $files;
        $ret['upgrade'] = true;
        $ret['type'] = 'webtheme';
        if (empty($webtheme)) {
            $ret['install'] = 1;
        }
        cache_write('cloud:transtoken', authcode($ret['token'], 'ENCODE'));
    }
    return $ret;
}
function cloud_w_upgradeinfo($name) {
    $sql = 'SELECT `name`, `version` FROM ' . tablename('webtheme_homepages') . ' WHERE `name` = :name';
    $webtheme = pdo_fetch($sql, array(
        ':name' => $name
    ));
    $pars = _cloud_build_params();
    $pars['method'] = 'webtheme.upgrade';
    $pars['webtheme'] = $webtheme['name'];
    $pars['version'] = $webtheme['version'];
    $pars['isupgrade'] = 1;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    $file = IA_ROOT . '/data/webtheme.info';
    $ret = _cloud_shipping_parse($dat, $file);
    return $ret;
}
function cloud_sms_send($mobile, $content, $postdata = array()) {
    global $_W;
    if (!preg_match('/^1\d{10}$/', $mobile) || empty($content)) {
        return error(1, '发送短信失败, 原因: 手机号错误或内容为空.');
    }
    $row = pdo_get('uni_settings', array(
        'uniacid' => $_W['uniacid']
    ) , array(
        'notify'
    ));
    $row['notify'] = @iunserializer($row['notify']);
    $config = $row['notify']['sms'];
    $balance = intval($config['balance']);
    $sign = $config['signature'];
    if (empty($sign)) {
        $sign = '涛盛微擎团队';
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'sms.sendnew';
    $pars['mobile'] = $mobile;
    $pars['uniacid'] = $_W['uniacid'];
    $pars['balance'] = $balance;
    $pars['sign'] = $sign;
    if (!empty($postdata)) {
        $pars['content'] = $content;
        $pars['postdata'] = $postdata;
    } else {
        $pars['content'] = "{$content} 【{$sign}】";
    }
    $response = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    if (is_error($response)) {
        return error($response['errno'], '短信发送失败, 原因:' . $response['message']);
    }
    $result = json_decode($response['content'], true);
    if (is_error($result)) {
        return error($result['errno'], $result['message']);
    }
    if (intval($result['errno']) != - 1) {
        $row['notify']['sms']['balance'] = $row['notify']['sms']['balance'] - 1;
        if ($row['notify']['sms']['balance'] < 0) {
            $row['notify']['sms']['balance'] = 0;
        }
        pdo_update('uni_settings', array(
            'notify' => iserializer($row['notify'])
        ) , array(
            'uniacid' => $_W['uniacid']
        ));
        uni_setting_save('notify', $row['notify']);
    }
    return true;
}
function cloud_sms_info() {
    global $_W;
    $pars = _cloud_build_params();
    $pars['method'] = 'sms.info';
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php?', $pars);
    if ($dat['content'] == 'success') {
        $setting_key = "sms.info";
        $dat = setting_load($setting_key);
        return $dat[$setting_key];
    }
    return array();
}
function cloud_extra_account() {
    $data = array();
    $data['accounts'] = pdo_fetchall("SELECT name, account, original FROM " . tablename('account_wechats') . " GROUP BY account");
    return serialize($data);
}
function cloud_extra_module() {
    $sql = 'SELECT `name` FROM ' . tablename('modules') . ' WHERE `type` <> :type';
    $modules = pdo_fetchall($sql, array(
        ':type' => 'system'
    ) , 'name');
    if (!empty($modules)) {
        return base64_encode(iserializer(array_keys($modules)));
    } else {
        return '';
    }
}
function cloud_extra_theme() {
    $sql = 'SELECT `name` FROM ' . tablename('site_templates') . ' WHERE `name` <> :name';
    $themes = pdo_fetchall($sql, array(
        ':name' => 'default'
    ) , 'name');
    if (!empty($themes)) {
        return base64_encode(iserializer(array_keys($themes)));
    } else {
        return '';
    }
}
function cloud_extra_webtheme() {
    $sql = 'SELECT `name` FROM ' . tablename('webtheme_templates') . ' WHERE `name` <> :name';
    $themes = pdo_fetchall($sql, array(
        ':name' => 'default'
    ) , 'name');
    if (!empty($themes)) {
        return base64_encode(iserializer(array_keys($themes)));
    } else {
        return '';
    }
}
function cloud_cron_create($cron) {
    $pars = _cloud_build_params();
    $pars['method'] = 'cron.create';
    $pars['cron'] = base64_encode(iserializer($cron));
    $result = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    return _cloud_cron_parse($result);
}
function cloud_cron_update($cron) {
    $pars = _cloud_build_params();
    $pars['method'] = 'cron.update';
    $pars['cron'] = base64_encode(iserializer($cron));
    $result = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    return _cloud_cron_parse($result);
}
function cloud_cron_get($cron_id) {
    $pars = _cloud_build_params();
    $pars['method'] = 'cron.get';
    $pars['cron_id'] = $cron_id;
    $result = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    return _cloud_cron_parse($result);
}
function cloud_cron_change_status($cron_id, $status) {
    $pars = _cloud_build_params();
    $pars['method'] = 'cron.status';
    $pars['cron_id'] = $cron_id;
    $pars['status'] = $status;
    $result = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    return _cloud_cron_parse($result);
}
function cloud_cron_remove($cron_id) {
    $pars = _cloud_build_params();
    $pars['method'] = 'cron.remove';
    $pars['cron_id'] = $cron_id;
    $result = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars);
    return _cloud_cron_parse($result);
}
function _cloud_cron_parse($result) {
    if (empty($result)) {
        return error(-1, '没有接收到服务器的传输的数据');
    }
    if ($result['content'] == 'blacklist') {
        return error(-1, '抱歉，您的站点已被列入云服务黑名单，云服务一切业务已被禁止，请联系微擎客服！');
    }
    $result = json_decode($result['content'], true);
    if (null === $result) {
        return error(-1, '云服务通讯发生错误，请稍后重新尝试！');
    }
    $result = $result['message'];
    if (is_error($result)) {
        return error(-1, $result['message']);
    }
    return $result;
}
function cloud_auth_url($forward, $data = array()) {
    global $_W;
    if (!empty($_W['setting']['site']['url']) && !strexists($_W['siteroot'], $_W['setting']['site']['url'])) {
        $url = $_W['setting']['site']['url'];
    } else {
        $url = rtrim($_W['siteroot'], '/');
    }
    $auth = array();
    $auth['key'] = '';
    $auth['password'] = '';
    $auth['url'] = $url;
    $auth['referrer'] = intval($_W['config']['setting']['referrer']);
    $auth['version'] = IMS_VERSION;
    $auth['forward'] = $forward;
    if (!empty($_W['setting']['site']['key']) && !empty($_W['setting']['site']['token'])) {
        $auth['key'] = $_W['setting']['site']['key'];
        $auth['password'] = md5($_W['setting']['site']['key'] . $_W['setting']['site']['token']);
    }
    if ($data && is_array($data)) {
        $auth = array_merge($auth, $data);
    }
    $query = base64_encode(json_encode($auth));
    $auth_url = HTTP_X_FOR .'cloud.zhifun.cc/api/auth.php?__auth=' . $query;
    return $auth_url;
}
function cloud_module_setting_prepare($module, $binding) {
    global $_W;
    $auth = _cloud_build_params();
    $auth['arguments'] = array(
        'binding' => $binding,
        'acid' => $_W['uniacid'],
        'type' => 'module',
        'module' => $module,
    );
    $iframe_auth_url = cloud_auth_url('module', $auth);
    return $iframe_auth_url;
}
function cloud_resource_to_local($uniacid, $type, $url) {
    global $_W;
    load()->func('file');
    $setting = $_W['setting']['upload'][$type];
    if (!file_is_image($url)) {
        return error(1, '远程图片后缀非法,请重新上传');;
    }
    $pathinfo = pathinfo($url);
    $extension = $pathinfo['extension'];
    $originname = $pathinfo['basename'];
    $setting['folder'] = "{$type}s/{$uniacid}/" . date('Y/m/');
    $originname = pathinfo($url, PATHINFO_BASENAME);
    $filename = file_random_name(ATTACHMENT_ROOT . '/' . $setting['folder'], $extension);
    $pathname = $setting['folder'] . $filename;
    $fullname = ATTACHMENT_ROOT . $pathname;
    mkdirs(dirname($fullname));
    load()->func('communication');
    $response = ihttp_get($url);
    if (is_error($response)) {
        return error(1, $response['message']);
    }
    if (file_put_contents($fullname, $response['content']) == false) {
        return error(1, '提取文件失败');
    }
    if (!empty($_W['setting']['remote']['type'])) {
        $remotestatus = file_remote_upload($pathname);
        if (is_error($remotestatus)) {
            return error(1, '远程附件上传失败，请检查配置并重新上传');
        } else {
            file_delete($pathname);
        }
    }
    $data = array(
        'uniacid' => $uniacid,
        'uid' => intval($_W['uid']) ,
        'filename' => $originname,
        'attachment' => $pathname,
        'type' => $type == 'image' ? 1 : 2,
        'createtime' => TIMESTAMP,
    );
    pdo_insert('core_attachment', $data);
    $data['url'] = tomedia($pathname);
    $data['id'] = pdo_insertid();
    return $data;
}
function cloud_bakup_files($files) {
    global $_W;
    if (empty($files)) {
        return false;
    }
    $map = json_encode($files);
    $hash = md5($map . $_W['config']['setting']['authkey']);
    if ($handle = opendir(IA_ROOT . '/data/patch/' . date('Ymd'))) {
        while (false !== ($patchpath = readdir($handle))) {
            if ($patchpath != '.' && $patchpath != '..') {
                if (strexists($patchpath, $hash)) {
                    return false;
                }
            }
        }
    }
    $path = IA_ROOT . '/data/patch/' . date('Ymd') . '/' . date('Hi') . '_' . $hash;
    load()->func('file');
    if (!is_dir($path) && mkdirs($path)) {
        foreach ($files as $file) {
            if (file_exists(IA_ROOT . $file)) {
                mkdirs($path . '/' . dirname($file));
                file_put_contents($path . '/' . $file, file_get_contents(IA_ROOT . $file));
            }
        }
        file_put_contents($path . '/' . 'map.json', $map);
    }
    return false;
}
function cloud_flow_master_post($flow_master) {
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.master_post';
    $pars['flow_master'] = array(
        'linkman' => $flow_master['linkman'],
        'mobile' => $flow_master['mobile'],
        'address' => $flow_master['address'],
        'id_card_photo' => $flow_master['id_card_photo'],
        'business_licence_photo' => $flow_master['business_licence_photo'],
    );
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    cache_delete("cloud:flow:master");
    $ret = @json_decode($dat['content'], true);
    return $ret;
}
function cloud_flow_master_get() {
    $cachekey = "cloud:flow:master";
    $cache = cache_load($cachekey);
    if (!empty($cache) && $cache['expire'] > TIMESTAMP) {
        return $cache['setting'];
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.master_get';
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    $ret = @json_decode($dat['content'], true);
    if ($ret['status'] == '3') {
        cache_write($cachekey, array(
            'expire' => TIMESTAMP + 300,
            'setting' => $ret
        ));
    } else if ($ret['status'] == '4') {
        cache_write($cachekey, array(
            'expire' => TIMESTAMP + 12 * 3600,
            'setting' => $ret
        ));
    }
    return $ret;
}
function cloud_flow_uniaccount_post($uniaccount) {
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.uniaccount_post';
    $pars['uniaccount'] = array(
        'uniacid' => $uniaccount['uniacid'],
    );
    isset($uniaccount['title']) && $pars['uniaccount']['title'] = $uniaccount['title'];
    isset($uniaccount['original']) && $pars['uniaccount']['original'] = $uniaccount['original'];
    isset($uniaccount['gh_type']) && $pars['uniaccount']['gh_type'] = $uniaccount['gh_type'];
    isset($uniaccount['ad_tags']) && $pars['uniaccount']['ad_tags'] = $uniaccount['ad_tags'];
    isset($uniaccount['enable']) && $pars['uniaccount']['enable'] = $uniaccount['enable'];
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    cache_delete("cloud:ad:uniaccount:{$uniaccount['uniacid']}");
    cache_delete("cloud:ad:uniaccount:list");
    $ret = @json_decode($dat['content'], true);
    return $ret;
}
function cloud_flow_uniaccount_get($uniacid) {
    $cachekey = "cloud:ad:uniaccount:{$uniacid}";
    $cache = cache_load($cachekey);
    if (!empty($cache) && $cache['expire'] > TIMESTAMP) {
        return $cache['setting'];
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.uniaccount_get';
    $pars['uniaccount'] = array(
        'uniacid' => $uniacid,
    );
    $pars['md5'] = md5(base64_encode(serialize($pars['uniaccount'])));
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    $ret = @json_decode($dat['content'], true);
    cache_write($cachekey, array(
        'expire' => TIMESTAMP + 600,
        'setting' => $ret
    ));
    return $ret;
}
function cloud_flow_uniaccount_list_get() {
    $cachekey = "cloud:ad:uniaccount:list";
    $cache = cache_load($cachekey);
    if (!empty($cache) && $cache['expire'] > TIMESTAMP) {
        return $cache['setting'];
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.uniaccount_list_get';
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    $ret = @json_decode($dat['content'], true);
    cache_write($cachekey, array(
        'expire' => TIMESTAMP + 600,
        'setting' => $ret
    ));
    return $ret;
}
function cloud_flow_ad_tag_list() {
    $cachekey = "cloud:ad:tags";
    $cache = cache_load($cachekey);
    if (!empty($cache) && $cache['expire'] > TIMESTAMP) {
        return $cache['items'];
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.ad_tag_list';
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    $ret = @json_decode($dat['content'], true);
    cache_write($cachekey, array(
        'expire' => TIMESTAMP + 6 * 3600,
        'items' => $ret
    ));
    return $ret;
}
function cloud_flow_ad_type_list() {
    $cachekey = "cloud:ad:type:list";
    $cache = cache_load($cachekey);
    if (!empty($cache) && $cache['expire'] > TIMESTAMP) {
        return $cache['items'];
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.ad_type_list';
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    $ret = @json_decode($dat['content'], true);
    cache_write($cachekey, array(
        'expire' => TIMESTAMP + 3600,
        'items' => $ret
    ));
    return $ret;
}
function cloud_flow_app_post($uniacid, $module_name, $enable = 0, $ad_types = null) {
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.app_post';
    $pars['uniaccount_app'] = array(
        'uniacid' => $uniacid,
        'module' => $module_name,
    );
    if (!empty($enable)) {
        $pars['uniaccount_app']['enable'] = $enable;
    }
    if (is_array($ad_types)) {
        $pars['uniaccount_app']['ad_types'] = $ad_types;
    }
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    cache_delete("cloud:ad:app:list:{$uniacid}");
    $ret = @json_decode($dat['content'], true);
    return $ret;
}
function cloud_flow_app_list_get($uniacid) {
    $cachekey = "cloud:ad:app:list:{$uniacid}";
    $cache = cache_load($cachekey);
    if (!empty($cache) && $cache['expire'] > TIMESTAMP) {
        return $cache['setting'];
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.app_list_get';
    $pars['uniaccount'] = array(
        'uniacid' => $uniacid,
    );
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    $ret = @json_decode($dat['content'], true);
    cache_write($cachekey, array(
        'expire' => TIMESTAMP + 300,
        'setting' => $ret
    ));
    return $ret;
}
function cloud_flow_app_support_list($module_names) {
    if (empty($module_names)) {
        return array();
    }
    $cachekey = "cloud:ad:app:support:list";
    $cache = cache_load($cachekey);
    if (!empty($cache) && $cache['expire'] > TIMESTAMP) {
        return $cache['setting'];
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.app_support_list';
    $pars['modules'] = $module_names;
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    $ret = @json_decode($dat['content'], true);
    cache_write($cachekey, array(
        'expire' => TIMESTAMP + 300,
        'setting' => $ret
    ));
    return $ret;
}
function cloud_flow_site_stat_day($condition) {
    $cachekey = "cloud:ad:site:finance";
    $cache = cache_load($cachekey);
    if (!empty($cache) && $cache['expire'] > TIMESTAMP) {
        return $cache['info'];
    }
    $pars = _cloud_build_params();
    $pars['method'] = 'flow.site_stat_day';
    $pars['condition'] = array();
    $pars['condition']['starttime'] = $condition['starttime'];
    $pars['condition']['endtime'] = $condition['endtime'];
    $pars['condition']['page'] = $condition['page'];
    $pars['condition']['size'] = $condition['size'];
    $dat = cloud_request(HTTP_X_FOR .'cloud.zhifun.cc/app/api.php', $pars, array() , 300);
    if (is_error($dat)) {
        return error(-1, '网络存在错误， 请稍后重试。' . $dat['message']);
    }
    $ret = @json_decode($dat['content'], true);
    cache_write($cachekey, array(
        'expire' => TIMESTAMP + 300,
        'info' => $ret
    ));
    return $ret;
}
function get_url_content(){
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $result=curl_exec($ch);
    return $result;
}