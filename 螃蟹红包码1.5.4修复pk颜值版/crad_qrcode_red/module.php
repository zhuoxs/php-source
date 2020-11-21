<?php
defined('IN_IA') or exit('Access Denied');
define('MB_ROOT', IA_ROOT . '/addons/crad_qrcode_red');
class Crad_qrcode_redModule extends WeModule
{
    public function settingsDisplay($settings)
    {
        global $_W, $_GPC;
        global $_W, $_GPC;
        if (checksubmit()) {
            load()->func('file');
            mkdirs(MB_ROOT . '/cert', 0777);
            $r = true;
            if (!empty($_GPC['cert'])) {
                $ret = file_put_contents(MB_ROOT . '/cert/apiclient_cert.pem.' . $_W['uniacid'], trim($_GPC['cert']));
                $r = $r && $ret;
            }
            if (!empty($_GPC['key'])) {
                $ret = file_put_contents(MB_ROOT . '/cert/apiclient_key.pem.' . $_W['uniacid'], trim($_GPC['key']));
                $r = $r && $ret;
            }
            if (!$r) {
                message('证书保存失败, 请保证 /addons/crad_qrcode_red/cert/ 目录可写');
            }
            $input['token'] = md5('abcdefghjklmnopqistuvwkyz1234567');
            $input['copyright'] = $_GPC['copyright'];
            $input['mid'] = $_GPC['mid'];
            $input['mid_check'] = $_GPC['mid_check'];
            $input['mid_red'] = $_GPC['mid_red'];
            $input['mid_share'] = $_GPC['mid_share'];
            $input['site_name'] = $_GPC['site_name'];
            $input['openid'] = $_GPC['openid'];
            $input['wish'] = $_GPC['wish'];
            $input['mchid'] = $_GPC['mchid'];
            $input['send_name'] = $_GPC['send_name'];
            $input['red_name'] = $_GPC['red_name'];
            $input['pay_desc'] = $_GPC['pay_desc'];
            $input['jump_url'] = $_GPC['jump_url'];
            $input['isremote'] = $_GPC['isremote'];
            $input['site_domain'] = $_GPC['site_domain'];
            $input['jump_domain'] = $_GPC['jump_domain'];
            $input['version'] = $_W['current_module']['version'];
            $input['appid'] = trim($_GPC['appid']);
            $input['mchid'] = trim($_GPC['mchid']);
            $input['password'] = trim($_GPC['password']);
            $input['scene_red'] = trim($_GPC['scene_red']);
            $input['sub_mch_id'] = trim($_GPC['sub_mch_id']);
            $input['msgappid'] = trim($_GPC['msgappid']);
            $input['sl_pay'] = $_GPC['sl_pay'] ? 1 : 0;
            $input['consume_mch_id'] = $_GPC['consume_mch_id'] ? 1 : 0;
            $input['ip'] = trim($_GPC['ip']);
            $input['accesskeyid'] = trim($_GPC['accesskeyid']);
            $input['signname'] = trim($_GPC['signname']);
            $input['accesskeysecret'] = trim($_GPC['accesskeysecret']);
            $input['templatecode'] = trim($_GPC['templatecode']);
            $input['protocol'] = htmlspecialchars_decode($_GPC['protocol']);
            $input["ticket"]="abcdefghjklmnopqistuvwkyz1234567";
            $baidu_config["baidu_appid"]=trim($_GPC['baidu_appid']);
            $baidu_config["baidu_api_key"]=trim($_GPC['baidu_api_key']);
            $baidu_config["baidu_api_secret"]=trim($_GPC['baidu_api_secret']);

            if ($input['isremote'] == 1) {
                $input['qiniu_accesskey'] = trim($_GPC['qiniu_accesskey']);
                $input['qiniu_secretkey'] = strexists($_GPC['qiniu_secretkey'], '*') ? $_W['setting']['remote']['qiniu']['secretkey'] : trim($_GPC['qiniu_secretkey']);
                $input['qiniu_bucket'] = trim($_GPC['qiniu_bucket']);
                $input['qiniu_url'] = trim($_GPC['qiniu_url']);
                if (empty($input['qiniu_accesskey'])) {
                    message('请填写Accesskey', '', 'info');
                }
                if (empty($input['qiniu_secretkey'])) {
                    message('secretkey', '', 'info');
                }
                if (empty($input['qiniu_bucket'])) {
                    message('请填写bucket', '', 'info');
                }
                if (empty($input['qiniu_url'])) {
                    message('请填写url', '', 'info');
                } else {
                    $input['qiniu_url'] = strexists($input['qiniu_url'], 'http') ? trim($input['qiniu_url'], '/') : 'http://' . trim($input['qiniu_url'], '/');
                }
                $auth = attachment_qiniu_auth($input['qiniu_accesskey'], $input['qiniu_secretkey'], $input['qiniu_bucket']);
                if (is_error($auth)) {
                //    $message = $auth['message']['error'] == 'bad token' ? '七牛配置错误：Accesskey或Secretkey填写错误， 请检查后重新提交' : '七牛配置错误：bucket填写错误或是bucket所对应的存储区域选择错误，请检查后重新提交';
                 //   message($message, '', 'info');
                }
            }
            $setting = $this->module['config'];
            $setting['api'] = $input;
            $setting['baidu_config']=$baidu_config;
            if ($this->saveSettings($setting)) {
                message('保存参数成功', 'refresh');
            }
        }
        $config = $this->module['config']['api'];
        $baidu_config= $this->module['config']['baidu_config'];
        if (empty($config['ip'])) {
            $config['ip'] = $_SERVER['SERVER_ADDR'];
        }
        include $this->template('setting');
    }
}