<?php
/**
 * 【超人】超级商城模块
 *
 * @author 超人
 * @url http://bbs.we7.cc/thread-13060-1-1.html
 */
defined('IN_IA') or exit('Access Denied');
class SupermanHandCloud {
    public $showMessage = true;
    private $errmsg = '';
    private $module_info = array(), $site_info = array(), $result, $post_data;

    public function __construct($module_info, $site_info = array()) {
        $this->module_info = $module_info;
        $this->site_info = $site_info;
    }
    public function api($action_method, $data = array()) {
        global $_W;
        $data['php_verion'] = PHP_VERSION; //php_verion 参数丢一个s字符，接口需向下兼容
        $data['module_version'] = $this->module_info['version'];
        $data['module_name'] = $this->module_info['name'];
        $data['branch'] = 'business';
        $data['siteroot'] = $_W['siteroot'];
        $data['siteid'] = $this->site_info['siteid'];
        $url = $this->url($action_method, array(), true);
        $response = $this->request($url, $data, true);
        if (empty($response)) {
            WeUtility::logging('fatal', "[cloud.$action_method] response is null, url=$url, post_data=".var_export($this->post_data, true));
            if ($this->showMessage) {
                $this->errmsg = '网络异常，请稍后重试！';
                return false;
            } else {
                return false;
            }
        }
        $this->result = json_decode($response['content'], true);
        if (!is_array($this->result) || !isset($this->result['errno'])) {
            WeUtility::logging('fatal', "[cloud.$action_method] response invalide, response=".var_export($response, true));
            if ($this->showMessage) {
                $msg = "{$this->result['errmsg']}({$this->result['errno']})";
                $this->errmsg = $msg;
                return false;
            } else {
                return false;
            }
        }
        return $this->result;
    }
    public function hand2_report($data) {
        global $_W;
        $type = pdo_get('account', array('uniacid' => $_W['uniacid']), array('type'));
        $this->post_data = array(
            'module_name' => 'superman_hand2',
            'uniacid' => $_W['uniacid'],
            'name' => $_W['account']['name'],
            'type' => $type['type'],
            'data' => $data,
        );
        $url = $this->url('hand2.report', array(), true);
        $response = $this->request($url, $this->post_data, true);
        if (empty($response)) {
            WeUtility::logging('fatal', '[cloud.hand2_report] response is null, url='.$url.', post_data='.var_export($this->post_data, true));
            if ($this->showMessage) {
                $this->errmsg = '网络异常，请稍后重试！';
                return false;
            } else {
                return false;
            }
        }
        $result = json_decode($response['content'], true);
        if (!is_array($result) || !isset($result['errno'])) {
            WeUtility::logging('fatal', '[cloud.hand2_report] response invalide, response='.var_export($response, true));
            return false;
        }
        return $result;
    }
    public function url($action_method, $extra = array(), $signature = false) {
        global $_W;
        $action = $action_method;
        $method = 'index';
        if (strpos($action_method, '.') !== false) {
            list($action, $method) = explode('.', $action_method);
        }
        $params = array(
            '_common' => array(
                'm' => 'index',
                'c' => 'api',
            ),
            'check' => array(
                'index' => array(
                    'a' => 'check',
                    'method' => 'index',
                    'siteid' => $this->site_info['siteid'],
                ),
            ),
            'hand2' => array(
                'report' => array(
                    'a' => 'hand2',
                    'method' => 'report',
                ),
            ),
        );
        if (!isset($params[$action][$method])) {
            trigger_error('invalid params "'.$action_method.'"');
        }
        $host = $this->get_host();
        $querystring = array_merge($params['_common'], $params[$action][$method], $extra);
        if ($signature) {
            ksort($querystring);
            $str = http_build_query($querystring);
            $str .= '&secret='.$this->site_info['secret'];
            $querystring['sn'] = sha1($str);
        }
        $url = $_W['ishttps']?'https://':'http://';
        $url .= $host.'/index.php?';
        $url .= http_build_query($querystring);
        return $url;
    }
    public function is_error() {
        if (!empty($this->errmsg)) {
            return true;
        }
        return false;
    }
    public function get_errmsg() {
        $errmsg = $this->errmsg;
        $this->errmsg = '';
        return $errmsg;
    }
    ////////////////////////////////////////////////////////////
    private function get_host() {
        if (defined('LOCAL_DEVELOPMENT')) {
            return 'local-cloud.supermanapp.cn';
        }
        if (defined('ONLINE_DEVELOPMENT')) {
            return 'devcloud.supermanapp.cn';
        }
        return 'cloud.supermanapp.cn';
    }
    private function request($url, $post, $extra = array(), $timeout = 30) {
        load()->func('communication');
        if (defined('SUPERMAN_DEVELOPMENT')) {
            WeUtility::logging('debug', "[request] url=$url, post=".var_export($post, true).', extra='.var_export($extra, true));
        }
        $response = ihttp_request($url, $post, $extra, $timeout);
        if (defined('SUPERMAN_DEVELOPMENT')) {
            WeUtility::logging('debug', '[response] content='.$response['content'].', data='.var_export(json_decode($response['content'], true), true));
        }
        return $response;
    }
}