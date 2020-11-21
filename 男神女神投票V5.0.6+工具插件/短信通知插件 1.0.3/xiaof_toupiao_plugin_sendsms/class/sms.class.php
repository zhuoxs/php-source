<?php
/**
 * 【超人】超级商城模块
 *
 * @author 超人
 * @url http://bbs.we7.cc/thread-13060-1-1.html
 */
defined('IN_IA') or exit('Access Denied');
class Xiaofsendsms {
    public static $providers = array(
        'alidayu_new' => array(
            'title' => '阿里大于（新）',
            'url' => 'http://www.alidayu.com/',
        ),
    );
    public static $templates = array(
        'verifycode' => array(
            'title' => '验证码',
        ),
        'alidayu_new_verifycode' => array(
            'title' => '验证码（阿里大于-新）',
        ),
    );
    public $debug = true;
    public $account = array(
        'provider' => '',
        'url' => '',
        'username' => '',
        'password' => '',
        'signature' => '',
        'app_key' => '', //alidayu
        'app_secret' => '', //alidayu
    );
    public $provider;
    public function __construct() {}
    public function send($mobile, $message, $template = array(), $check_total = false, $extra = array()) {
        return false;
    }
    public function balance() {
        return -1;
    }
}

/*
 * Usage: Sms::init(string provider, array account)->send(string mobile, string message, [bool check_total], [array extra]);
 */
if (!class_exists('Sms')) {
    class Sms {
        static private $_instances;
        public static function init($provider, $account) {
            if (!isset(Sms::$_instances[$provider])) {
                if (empty($account) || !array_key_exists($provider, Xiaofsendsms::$providers)) {
                    WeUtility::logging('fatal', '[superman_mall:sms.class]未配置短信接口，account='.var_export($account, true).', provider='.$provider);
                    Sms::$_instances[$provider] = new Xiaofsendsms($account); //容错处理
                } else {
                    $classname = "XiaofSms_{$provider}";
                    $filename = MODULE_ROOT.'class/smsapi/'.$provider.'.class.php';
                    if (file_exists($filename)) {
                        require $filename;
                        Sms::$_instances[$provider] = new $classname();
                        Sms::$_instances[$provider]->account = $account;
                        Sms::$_instances[$provider]->provider = $provider;
                    } else {
                        trigger_error('短信接口 "'.'class/smsapi/'.$provider.'.class.php" 不存在', E_USER_ERROR);
                    }
                }
            }
            return Sms::$_instances[$provider];
        }
    }
} else {
    exit('class Sms conflict');
}