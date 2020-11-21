<?php

defined('IN_IA') or exit('Access Denied');
define('VOTE_RES', '../addons/vote_res/');
define('VOTE_RES_MOBILE', '../addons/vote_res/template/mobile/');

if (!function_exists('show_json')) {

    function show_json($status = 1, $return = null) {
        $ret = array(
            'status' => $status,
            'result' => $status == 1 ? array('url' => referer()) : array()
        );
        if (!is_array($return)) {
            if ($return) {
                $ret['result']['message'] = $return;
            }
            die(json_encode($ret));
        } else {
            $ret['result'] = $return;
        }
        if (isset($return['url'])) {
            $ret['result']['url'] = $return['url'];
        } else if ($status == 1) {
            $ret['result']['url'] = referer();
        }
        die(json_encode($ret));
    }

}

class Vote_resModuleSite extends WeModuleSite {

    public function __construct() {
        global $_W;
        $this->modulename = 'vote_res';
        $setting = pdo_get('uni_account_modules', array('module' => 'vote_res', 'uniacid' => $_W['uniacid']), 'settings');
        if (explode('/', trim($_W['script_name'], '/'))[0] == 'app') {
            mc_oauth_userinfo();
            if (empty($_W['openid']) && !is_h5app()) {
                die("<!DOCTYPE html>
                        <html>
                            <head>
                                <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                                <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
                            </head>
                            <body>
                            <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请在微信客户端打开链接</h4></div></div></div>
                            </body>
                        </html>");
            }
        }
        $member = pdo_fetch('SELECT * FROM ' . tablename('mc_mapping_fans') . ' WHERE uniacid = :uniacid AND openid = :openid ',array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));
        $tag = iunserializer(base64_decode($member['tag']));
        $member['avatar'] = $this->dispose132($tag['headimgurl']);
        $member['province'] = $tag['province'];
        $member['city'] = $tag['city'];
        $member['nickname'] = $member['nickname']?:'暂未获取';
        if (!empty($member) && !empty($_W['openid'])){
            $checkid = pdo_getcolumn('vote_res_member',array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']),'id');
            if (empty($checkid)){
                $memberdata = array(
                    'uniacid'=>$_W['uniacid'],
                    'openid'=>$_W['openid'],
                    'mid'=>$member['fanid'],
                    'nickname'=>$member['nickname'],
                    'createtime'=>time()
                );
                pdo_insert('vote_res_member',$memberdata);
            }
        }
        $_W['mid'] = $member['fanid'];
        $_W['member'] = $member;
        $_W['vote_res'] = !empty($setting['settings']) ? iunserializer($setting['settings']) : array();
        $this->insertMembertype();
    }
    public function saveSet($settings) {
        global $_W;
        $pars = array('module' => 'vote_res', 'uniacid' => $_W['uniacid']);
        $row = array('settings' => iserializer($settings));
        if (pdo_fetchcolumn('SELECT module FROM ' . tablename('uni_account_modules') . ' WHERE module = :module AND uniacid = :uniacid', array(':module' => 'vote_res', ':uniacid' => $_W['uniacid']))) {
            return pdo_update('uni_account_modules', $row, $pars) != false;
        } else {
            return pdo_insert('uni_account_modules', array('settings' => iserializer($settings), 'module' => 'vote_res', 'uniacid' => $_W['uniacid'], 'enabled' => 1)) != false;
        }
    }

    public function createQrcode($url) {
        global $_W;
        $path = IA_ROOT . '/addons/vote_res/data/qrcode/' . $_W['uniacid'] . '/';
        if (!is_dir($path)) {
            load()->func('file');
            mkdirs($path);
        }
        $file = md5(base64_encode($url)) . '.jpg';
        $qrcode_file = $path . $file;
        if (!is_file($qrcode_file)) {
            require_once IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
            QRcode::png($url, $qrcode_file, QR_ECLEVEL_L, 4);
        }
        return $_W['siteroot'] . 'addons/vote_res/data/qrcode/' . $_W['uniacid'] . '/' . $file;
    }

    public function shopShare($desc = 'CCIA投票-武汉指尖优品电子商务有限公司', $title = 'CCIA投票', $link = '', $imgurl = '') {
        global $_W;
        if (empty($imgurl)) {
            $imgurl = $_W['setting']['copyright']['flogo'];
        }
        if (empty($imgurl)) {
            $imgurl = $_W['siteroot'] . '/addons/vote_res/icon.jpg';
        }
        $_W['shopshare'] = array(
            'title' => $title,
            'imgUrl' => tomedia($imgurl),
            'desc' => $desc,
            'link' => empty($link) ? $_W['siteroot'] . 'app/' . ltrim($this->createMobileUrl('index'), './') : $link,
        );
        if (!empty($_W['vote_res']['share_title'])) {
            $_W['shopshare']['title'] = $_W['vote_res']['share_title'];
        }
        if (!empty($_W['vote_res']['share_desc'])) {
            $_W['shopshare']['desc'] = $_W['vote_res']['share_desc'];
        }
        if (!empty($_W['vote_res']['share_link'])) {
            $_W['shopshare']['link'] = $_W['vote_res']['share_link'];
        }
        if (!empty($_W['vote_res']['share_imgurl'])) {
            $_W['shopshare']['imgUrl'] = tomedia($_W['vote_res']['share_imgurl']);
        }
    }
    public function dispose132($url) {
        if (substr($url, -7) == '/132132') {
            return substr($url, 0, -3);
        }
        return $url;
    }
    public function insertMembertype(){
        global $_W;
        $membertype = pdo_fetch('SELECT id FROM ' . tablename('vote_res_member_type') . ' limit 1',array(':uniacid'=>$_W['uniacid']));
        if (empty($membertype)){
            $data = array();
            $data[0] = array(
                'id'=>1,
                'sort'=>1,
                'uniacid'=>$_W['uniacid'],
                'typename'=>'医生',
                'enabled'=>1,
                'createtime'=>time(),
            );
            $data[1] = array(
                'id'=>2,
                'sort'=>2,
                'uniacid'=>$_W['uniacid'],
                'typename'=>'普通用户',
                'enabled'=>1,
                'createtime'=>time(),
            );
            foreach ($data as $v){
                pdo_insert('vote_res_member_type',$v);
            }
        }
    }
}
