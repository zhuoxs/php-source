<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}
load()->model('miniapp');
class Tongrelease_EweiShopV2Page extends PluginWebPage {
    private $key = 'asdf734JH3464tr56GJ';
    public function main() {
        global $_W;
        $error                   = NULL;
        $log                     = pdo_fetchall('select * from ' . tablename('ewei_shop_upwxapp_log') . ' where uniacid=:uniacid and type=1 order by id desc', array(
            ':uniacid' => $_W['uniacid']
        ));
        $test_code               = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/test_code_' . $_W['uniacid'] . '.jpg';
        $app_info                = $this->miniapp_app_info('ewei_shopv2');
        $app_info['update_time'] = date('Y-m-d H:i:s', $app_info['update_time']);
        $version_time            = 0;
        if (!(filemtime($test_code)) || ((filemtime($test_code) + 1490) < time())) {
            $is_expire = 1;
        } else {
            $version_time = filemtime($test_code);
        }
        $wxcode = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/wxcode_' . $_W['uniacid'] . '.jpg';
        if (!(filemtime($wxcode)) || ((filemtime($wxcode) + 7200) < time())) {
            $accessToken = $this->model->getAccessToken();
            if (is_error($accessToken)) {
                $error = $accessToken['message'];
            } else {
                load()->func('communication');
                $result = ihttp_post('https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $accessToken, json_encode(array(
                    'scene' => 'index',
                    'path' => 'pages/index/index'
                )));
                file_put_contents($wxcode, $result['content']);
            }
        }
        //		}
        include $this->template();
    }
    public function upload() {
        global $_W;
        global $_GPC;
        $is_goods = $_GPC['is_goods'];
        $sets     = m('common')->getSysset(array(
            'app'
        ));
        $appid    = $sets['app']['appid'];
        if (empty($appid)) {
            header('location: ' . webUrl('app/setting'));
        }
        define('EWEI_APPID', $appid);
        $last_log = pdo_fetch('select * from ' . tablename('ewei_shop_upwxapp_log') . ' where uniacid=:uniacid and type=1 order by id desc limit 1', array(
            ':uniacid' => $_W['uniacid']
        ));
        @session_start();
        $ticket = $_SESSION['wxapp_new_ticket'];
        if (empty($ticket)) {
            $need_scan    = 1;
            $version_id   = $_W['uniacid'];
            $user_version = $_GPC['user_version'];
            $data         = $this->miniapp_code_generate($version_id, $user_version, $is_goods);
            if ($data['errno'] != 0)
                $this->message($data['message']);
            $uuid      = $data['data']['code_uuid'];
            $tokendata = $this->miniapp_code_token();
            if ($tokendata['errno'] != 0)
                $this->message($tokendata['message']);
            $code_token = $tokendata['data']['code_token'];
        } else {
            $need_scan = 0;
        }
        if (!(empty($response['content']))) {
            $content = $response['content'];
            $ret     = json_decode($content, true);
            if ($ret['errno'] == -1) {
                $this->message($ret['errmsg']);
            }
        }
        include $this->template();
    }
    public function getstatus() {
        global $_W;
        global $_GPC;
        $uuid = $_GPC['uuid'];
        if (empty($uuid)) {
            show_json(0);
        }
        $last       = $_GPC['last'] ? $_GPC['last'] : 408;
        $code_token = $_GPC['code_token'];
        $data       = $this->miniapp_code_check_scan($code_token, $last);
        if ($data['errno'] != 0)
            show_json(0, $data['message']);
        if (empty($data['data']['code_token'])) {
            show_json(0);
        }
        show_json(1, array(
            'wx_errcode' => $data['data']['errcode'],
            'wx_code' => $data['data']['code_token']
        ));
    }
    public function getticket() {
        global $_W;
        global $_GPC;
        $code_uuid = $_GPC['code_uuid'];
        $data      = $this->miniapp_check_code_isgen($code_uuid); // 是否确认？？
        if ($data['errno'] != 0)
            show_json(0, $data['message']);
        show_json(1, array(
            'new_ticket' => $data['data']['is_gen']
        ));
    }
    public function submit() {
        global $_W;
        global $_GPC;
        $version = $_GPC['version'];
        if (empty($version)) {
            show_json(0, '版本号不能为空！');
        }
        $describe = $_GPC['describe'];
        if (empty($describe)) {
            show_json(0, '版本描述不能为空！');
        }
        $user_version = $version;
        $user_desc    = $describe;
        $code_token   = $_GPC['code_token'];
        $code_uuid    = $_GPC['code_uuid'];
        $data         = $this->miniapp_code_commit($code_uuid, $code_token, $user_version, $user_desc);
        if ($data['errno'] != 0)
            show_json(0, $data['message']);
        $diy_str              = '';
        $data                 = array();
        $data['uniacid']      = $_W['uniacid'];
        $data['type']         = 1;
        $data['is_goods']     = EWEI_APPID;
        $data['version']      = $version;
        $data['describe']     = $describe;
        $data['version_time'] = time();
        pdo_insert('ewei_shop_upwxapp_log', $data);
        show_json(1);
    }
    public function uploadstatus() {
        global $_W;
        global $_GPC;
        $code_token = $_GPC['code_token'];
        $code_uuid  = $_GPC['code_uuid'];
        $data       = $this->miniapp_code_preview_qrcode($code_uuid, $code_token);
        if ($data['errno'] != 0)
            show_json(0, $data['message']);
        $image     = $data['data']['qrcode_img'];
        $imageName = "test_code_" . $_W['uniacid'] . '.jpg';
        if (strstr($image, ",")) {
            $image = explode(',', $image);
            $image = $image[1];
        }
        $path = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $imageSrc = $path . "/" . $imageName; //图片名字
        $r        = file_put_contents($imageSrc, base64_decode($image));
        show_json(1);
    }
    public function deletes() {
        global $_W;
        global $_GPC;
        @session_start();
        $_SESSION['wxapp_new_ticket'] = NULL;
    }
    public function wechatset() {
        include $this->template();
    }
    public function getAuth() {
        global $_W;
        global $_GPC;
        $key = 'app_auth' . $_W['uniacid'];
        @session_start();
        $auth = $_SESSION[$key];
        if (empty($auth) || is_error($auth)) {
            $auth = $this->model->getAuth();
            @session_start();
            $_SESSION[$key] = $auth;
        }
        return $auth;
    }
    function miniapp_code_generate($version_id, $user_version, $is_goods = 0) {
        global $_W;
        $api      = new XcApi();
        $app_info = $_W['current_module'];
        if ($app_info['name'] == 'ewei_shopv2') {
            $app_set        = pdo_get('ewei_shop_sysset', array(
                'uniacid' => $_W['uniacid']
            ));
            $un             = unserialize($app_set['sets']);
            $app_set['set'] = $un['app'];
            unset($app_set['sets']);
            $siteurl  = $_W['siteroot'];
            $appid    = $app_set['set']['appid'];
            $siteinfo = array(
                'name' => $app_info['name'],
                'uniacid' => $_W['uniacid'],
                'acid' => $_W['uniacid'],
                'multiid' => $app_info['version'],
                'version' => $user_version,
                'siteroot' => $siteurl,
                'design_method' => 3,
                'tominiprogram' => '',
                'is_goods' => $is_goods
            );
            $tabBar   = '';
            if ($app_set['set']['tabbar']) {
                $tabBar = iunserializer($app_set['set']['tabbar']);
            }
            $commit_data = array(
                'do' => 'generate',
                'appid' => $appid,
                'modules' => array(
                    $app_info['name'] => array(
                        'name' => $app_info['name'],
                        'version' => $app_info['version']
                    )
                ),
                'siteinfo' => $siteinfo,
                'tabBar' => $tabBar,
                'wxapp_type' => 0
            );
        } else {
            $version_info       = miniapp_version($version_id);
            $account_wxapp_info = miniapp_fetch($version_info['uniacid'], $version_id);
            if (empty($account_wxapp_info)) {
                return error(1, '');
            }
            $siteurl = $_W['siteroot'] . 'app/index.php';
            if (!empty($account_wxapp_info['appdomain'])) {
                $siteurl = $account_wxapp_info['appdomain'];
            }
            if (!starts_with($siteurl, 'https')) {
                return error(1, '');
            }
            if ($version_info['type'] == WXAPP_CREATE_MODULE && $version_info['entry_id'] <= 0) {
                return error(1, '');
            }
            $appid       = $account_wxapp_info['key'];
            $siteinfo    = array(
                'name' => $account_wxapp_info['name'],
                'uniacid' => $account_wxapp_info['uniacid'],
                'acid' => $account_wxapp_info['acid'],
                'multiid' => $account_wxapp_info['version']['multiid'],
                'version' => $user_version,
                'siteroot' => $siteurl,
                'design_method' => $account_wxapp_info['version']['design_method'],
                'tominiprogram' => array_keys($version_info['tominiprogram'])
            );
            $commit_data = array(
                'do' => 'generate',
                'appid' => $appid,
                'modules' => $account_wxapp_info['version']['modules'],
                'siteinfo' => $siteinfo,
                'tabBar' => json_decode($account_wxapp_info['version']['quickmenu'], true),
                'wxapp_type' => isset($version_info['type']) ? $version_info['type'] : 0
            );
        }
        $do = 'upload';
        if ($version_info['use_default'] == 0) {
            $appjson = miniapp_code_custom_appjson_tobase64($version_id);
            if ($appjson) {
                if (!isset($appjson['tabBar']['list'])) {
                    unset($appjson['tabBar']);
                }
                $commit_data['appjson'] = $appjson;
            }
        }
        $data = $api->post('wxapp', $do, $commit_data, 'json', false);
        return $data;
    }
    function miniapp_check_code_isgen($code_uuid) {
        $api  = new XcApi();
        $data = $api->get('wxapp', 'upload', array(
            'do' => 'check_gen',
            'code_uuid' => $code_uuid
        ), 'json', false);
        return $data;
    }
    function miniapp_code_token() {
        global $_W;
        $cloud_api = new XcApi();
        $data      = $cloud_api->get('wxapp', 'upload', array(
            'do' => 'code_token'
        ), 'json', false);
        return $data;
    }
    function miniapp_code_check_scan($code_token, $last) {
        $cloud_api = new XcApi();
        $data      = $cloud_api->get('wxapp', 'upload', array(
            'do' => 'checkscan',
            'code_token' => $code_token,
            'last' => $last
        ), 'json', false);
        return $data;
    }
    function miniapp_code_qrcode($code_token) {
        $cloud_api = new XcApi();
        $data      = $cloud_api->get('wxapp', 'upload', array(
            'do' => 'qrcode',
            'code_token' => $code_token
        ), 'html', false);
        return $data;
    }
    function miniapp_code_commit($code_uuid, $code_token, $user_version = 3, $user_desc = '代码提交') {
        $cloud_api   = new XcApi();
        $commit_data = array(
            'do' => 'commitcode',
            'code_uuid' => $code_uuid,
            'code_token' => $code_token,
            'user_version' => $user_version,
            'user_desc' => $user_desc
        );
        $data        = $cloud_api->post('wxapp', 'upload', $commit_data, 'json', false);
        return $data;
    }
    public function getqrcode() {
        global $_GPC;
        $code_token = $_GPC['code_token'];
        header('Content-type: image/jpg');
        $qrcode = $this->miniapp_code_qrcode($code_token);
        echo $qrcode;
    }
    function miniapp_code_preview_qrcode($code_uuid, $code_token) {
        $cloud_api   = new XcApi();
        $commit_data = array(
            'do' => 'preview_qrcode',
            'code_uuid' => $code_uuid,
            'code_token' => $code_token
        );
        $data        = $cloud_api->post('wxapp', 'upload', $commit_data, 'json', false);
        return $data;
    }
    function miniapp_app_info($name = '') {
        $cloud_api   = new XcApi();
        $commit_data = array(
            'do' => 'geteweiversion',
            'name' => $name
        );
        $data        = $cloud_api->post('wxapp', 'upload', $commit_data, 'json', false);
        return $data;
    }
}
	load()->model('cloud'); load()->func('communication');
	class XcApi {
    private $url = 'http://cloud.xjn360.com/XcxApi/Wxa/auth/auth?id=';
    private $development = false;
    private $module = null;
    private $sys_call = false;
    private $default_token = 'asdf734JH3464tr56GJ';
    private $appid = '';
    const ACCESS_TOKEN_EXPIRE_IN = 7200;
    public function __construct($development = false) {
        if (!defined('MODULE_ROOT')) {
            $this->sys_call = true;
            $this->module   = 'core';
        } else {
            $this->sys_call = true;
            $this->module   = 'ewei_shopv2';
        }
        $this->development = !is_error($this->developerCerContent());
        $sets              = m('common')->getSysset(array(
            'app'
        ));
        if (empty($sets['app']['appid'])) {
            header('location: ' . webUrl('app/setting'));
        }
        $this->appid = $sets['app']['appid'];
    }
    private function getCerContent($file) {
        $cer_filepath = $this->cer_filepath($file);
        if (is_file($cer_filepath)) {
            $cer = file_get_contents($cer_filepath);
            if (!empty($cer)) {
                return $cer;
            }
        }
        return error(1, '');
    }
    private function developerCerContent() {
        $cer = $this->getCerContent('developer.cer');
        if (is_error($cer)) {
            return error(1, '');
        }
        return $cer;
    }
    private function cer_filepath($file) {
        if (defined('MODULE_ROOT')) {
            return MODULE_ROOT . '/' . $file;
        }
        return $file;
    }
    private function moduleCerContent() {
        $cer_filename = 'manage.cer';
        $cer_filepath = $this->cer_filepath($cer_filename);
        if (is_file($cer_filepath)) {
            $expire_time = filemtime($cer_filepath) + CloudApi::ACCESS_TOKEN_EXPIRE_IN - 200;
            if (TIMESTAMP > $expire_time) {
                unlink($cer_filepath);
            }
        }
        if (!is_file($cer_filepath)) {
            $pars           = _cloud_build_params();
            $pars['method'] = 'api.oauth';
            $pars['module'] = $this->module;
            $data           = cloud_request('http://127.0.0.1', $pars);
            if (is_error($data)) {
                return $data;
            }
            $data = json_decode($data['content'], true);
            if (is_error($data)) {
                return $data;
            }
        }
        $cer = $this->getCerContent($cer_filename);
        if (is_error($cer)) {
            return error(1, '');
        }
        return $cer;
    }
    private function systemCerContent() {
        global $_W;
        if (empty($_W['setting']['site'])) {
            return $this->default_token;
        }
        $cer_filename = 'manage.cer';
        $cer_filepath = IA_ROOT . '/manage.cer';
        load()->func('file');
        $we7_team_dir = dirname($cer_filepath);
        if (!is_dir($we7_team_dir)) {
            mkdirs($we7_team_dir);
        }
        if (is_file($cer_filepath)) {
            $expire_time = filemtime($cer_filepath) + CloudApi::ACCESS_TOKEN_EXPIRE_IN - 200;
            if (TIMESTAMP > $expire_time) {
                unlink($cer_filepath);
            }
        }
        if (!is_file($cer_filepath)) {
            $pars           = _cloud_build_params();
            $pars['method'] = 'api.oauth';
            $pars['module'] = $this->module;
            $data           = cloud_request('http://127.0.0.1', $pars);
            if (is_error($data)) {
                return $data;
            }
            $data = json_decode($data['content'], true);
            if (is_error($data)) {
                return $data;
            }
        }
        if (is_file($cer_filepath)) {
            $cer = file_get_contents($cer_filepath);
            if (is_error($cer)) {
                return error(1, '');
            }
            return $cer;
        } else {
            return $this->default_token;
        }
    }
    private function deleteModuleCer() {
        $cer_filename = 'manage.cer';
        $cer_filepath = $this->cer_filepath($cer_filename);
        if (is_file($cer_filepath)) {
            unlink($cer_filepath);
        }
    }
    private function getAccessToken() {
        global $_W;
        if ($this->sys_call) {
            $token = $this->systemCerContent();
        } else {
            if ($this->development) {
                $token = $this->developerCerContent();
            } else {
                $token = $this->moduleCerContent();
            }
        }
        if (empty($token)) {
            return error(1, '');
        }
        if (is_error($token)) {
            return $token;
        }
        $access_token = array(
            'token' => $token,
            'module' => $this->module
        );
        return base64_encode(json_encode($access_token));
    }
    public function url($api, $method, $params = array(), $dataType = 'json') {
        global $_W;
        $access_token = $this->getAccessToken();
        if (is_error($access_token)) {
            return $access_token;
        }
        if (empty($params) || !is_array($params)) {
            $params = array();
        }
        $_url = parse_url($this->url);
        $_url = $_url['scheme'] . '://' . $_url['host'];
        $url  = $_url . DIRECTORY_SEPARATOR . $api . DIRECTORY_SEPARATOR . $method . '/index?access_token=' . $access_token;
        if (!empty($dataType)) {
            $url .= "&dataType={$dataType}";
        }
        $params['siteurl'] = $_W['siteroot'];
        if (!empty($params)) {
            $querystring = base64_encode(json_encode($params));
            $url .= "&api_qs={$querystring}";
        }
        $url .= "&appid=" . $this->appid . "&appname=ewei_shopv2";
        if (strlen($url) > 2800) {
            return error(1, 'url query string too long');
        }
        return $url;
    }
    private function actionResult($result, $dataType = 'json') {
        if ($dataType == 'html') {
            return $result;
        }
        if ($dataType == 'json') {
            $result      = strval($result);
            $json_result = json_decode($result, true);
            if (is_null($json_result)) {
                $json_result = error(1, 'JSON无效');
            }
            if (is_error($json_result)) {
                if ($json_result['errno'] == 10000) {
                    $this->deleteCer();
                    $this->deleteModuleCer();
                }
                ;
                return $json_result;
            }
            return $json_result;
        }
        return $result;
    }
    public function get($api, $method, $url_params = array(), $dataType = 'json', $with_cookie = true) {
        $url = $this->url($api, $method, $url_params, $dataType);
        if (is_error($url)) {
            return $url;
        }
        $response = ihttp_get($url);
        if (is_error($response)) {
            return $response;
        }
        if ($with_cookie) {
            $ihttp_options = array();
            if ($response['headers'] && $response['headers']['Set-Cookie']) {
                $cookiejar = $response['headers']['Set-Cookie'];
            }
            if (!empty($cookiejar)) {
                if (is_array($cookiejar)) {
                    $ihttp_options['CURLOPT_COOKIE'] = implode('; ', $cookiejar);
                } else {
                    $ihttp_options['CURLOPT_COOKIE'] = $cookiejar;
                }
            }
            $response = ihttp_request($url, array(), $ihttp_options);
            if (is_error($response)) {
                return $response;
            }
        }
        $result = $this->actionResult($response['content'], $dataType);
        return $result;
    }
    public function post($api, $method, $post_params = array(), $dataType = 'json', $with_cookie = true) {
        $url = $this->url($api, $method, array(), $dataType);
        if (is_error($url)) {
            return $url;
        }
        $ihttp_options = array();
        if ($with_cookie) {
            $response = ihttp_get($url);
            if (is_error($response)) {
                return $response;
            }
            $ihttp_options = array();
            if ($response['headers'] && $response['headers']['Set-Cookie']) {
                $cookiejar = $response['headers']['Set-Cookie'];
            }
            if (!empty($cookiejar)) {
                if (is_array($cookiejar)) {
                    $ihttp_options['CURLOPT_COOKIE'] = implode('; ', $cookiejar);
                } else {
                    $ihttp_options['CURLOPT_COOKIE'] = $cookiejar;
                }
            }
        }
        $response = ihttp_request($url, $post_params, $ihttp_options);
        if (is_error($response)) {
            return $response;
        }
        if ($dataType == 'binary') {
            return $response;
        }
        return $this->actionResult($response['content'], $dataType);
    }
    public function deleteCer() {
        if ($this->sys_call) {
            $cer_filepath = IA_ROOT . '/manage.cer';
            if (is_file($cer_filepath)) {
                unlink($cer_filepath);
            }
        }
    }
}
