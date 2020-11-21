<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

/**
 * 聊天主逻辑
 * 主要是处理 onMessage onClose
 */
use \GatewayWorker\Lib\Gateway;
require_once './vendor/workerman/mysql/Connection.php';
require_once './vendor/common/communication.func.php';

class Events {
    public static $db = null;
    public static $wqConfig = null;
    public static $moduleSettings = null;
    public static $wechatAccounts = null;
    public static $accessTokens = null;

    public static function init() {
        if (!defined('IN_IA')) {
            define('IN_IA', true);
        }
        $config = array();
        include '../../../data/config.php';
        self::$wqConfig = $config;

        //set timestamp
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set(self::$wqConfig['setting']['timezone']);
        }
        if (!defined('TIMESTAMP')) {
            define('TIMESTAMP', time());
        }
    }

    /**
     * 进程启动后初始化数据库连接
     */
    public static function onWorkerStart($worker) {
        self::init();
        self::$db = new Workerman\MySQL\Connection(
            //'host', 'port', 'user', 'password', 'db_name'
            isset(self::$wqConfig['db']['master']['host'])?self::$wqConfig['db']['master']['host']:self::$wqConfig['db']['host'],
            isset(self::$wqConfig['db']['master']['port'])?self::$wqConfig['db']['master']['port']:self::$wqConfig['db']['port'],
            isset(self::$wqConfig['db']['master']['username'])?self::$wqConfig['db']['master']['username']:self::$wqConfig['db']['username'],
            isset(self::$wqConfig['db']['master']['password'])?self::$wqConfig['db']['master']['password']:self::$wqConfig['db']['password'],
            isset(self::$wqConfig['db']['master']['database'])?self::$wqConfig['db']['master']['database']:self::$wqConfig['db']['database']
        );
    }

    public static function table($name) {
        return (isset(self::$wqConfig['db']['master']['tablepre'])?self::$wqConfig['db']['master']['tablepre']:self::$wqConfig['db']['tablepre']).$name;
    }

    /**
    * 有消息时
    * @param int $client_id
    * @param mixed $message
    */
    public static function onMessage($client_id, $message) {
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";

        // 客户端传递的是json数据
        $message_data = json_decode($message, true);
        if (!$message_data) {
            return;
        }
        if (isset($message_data['content']) && strlen($message_data['content']) >= 2048) {
            return;
        }

        switch($message_data['type']) {
            case 'pong':
                return;
            case 'check':
                Gateway::sendToCurrentClient(json_encode(array(
                    'type' => 'check',
                    'status' => 'ok',
                )));
                return;
            case 'login':
                $sid = $message_data['sid'];
                $uid = $message_data['uid'];
                $uniacid = $message_data['uniacid'];
                // 设置用户在线状态
                $member = self::$db->select('*')->from(self::table('superman_hand2_member_login'))->where("uid='$uid' AND uniacid='$uniacid'")->row();
                if (!empty($member)) {
                    $member_count = self::$db->update(self::table('superman_hand2_member_login'))->cols(array(
                        'is_online' => 1
                    ))->where("id='{$member['id']}'")->query();
                } else {
                    $member_id = self::$db->insert(self::table('superman_hand2_member_login'))->cols(array(
                        'uniacid' => $uniacid,
                        'uid' => $uid,
                        'is_online' => 1
                    ))->query();
                }

                $new_sid = md5('SupermanHand2:'.$uid.':'.date('Ymd').':'.self::$wqConfig['setting']['authkey']);
                if ($sid != $new_sid) {
                    return Gateway::destoryCurrentClient();
                }
                Gateway::bindUid($client_id, $uid);
                return;
            case 'say':
                $from_uid = intval($message_data['from_uid']);
                $to_uid = intval($message_data['to_uid']);
                $itemid = intval($message_data['itemid']);
                $createtime = intval($message_data['createtime']);
                if (empty($itemid)) {
                    echo "itemid is null \n";
                    return;
                }
                $item = self::$db->select('*')->from(self::table('superman_hand2_item'))->where("id='$itemid'")->row();
                if (empty($item)) {
                    echo "itemid($itemid) not found \n";
                    return;
                }
                //记录最新消息
                $last = self::$db->select('*')->from(self::table('superman_hand2_message_list'))
                    ->where("uid='$to_uid' AND from_uid='$from_uid' AND itemid='$itemid'")->row();
                if (!empty($last)) {
                    $row_count = self::$db->update(self::table('superman_hand2_message_list'))->cols(array(
                        'status' => 1,
                        'message' => htmlspecialchars($message_data['content']),
                        'updatetime' => $createtime,
                    ))->where("id='{$last['id']}'")->query();
                    $chat_id = $last['id'];
                } else {
                    $chat_id = self::$db->insert(self::table('superman_hand2_message_list'))->cols(array(
                        'uniacid' => $item['uniacid'],
                        'uid' => $to_uid,
                        'from_uid' => $from_uid,
                        'itemid' => $itemid,
                        'status' => 1,
                        'message' => htmlspecialchars($message_data['content']),
                        'updatetime' => $createtime,
                    ))->query();
                }
                //记录消息
                $insert_id = self::$db->insert(self::table('superman_hand2_message'))->cols(array(
                    'uniacid' => $item['uniacid'],
                    'itemid' => $itemid,
                    'from_uid' => $from_uid,
                    'to_uid' => $to_uid,
                    'message' => htmlspecialchars($message_data['content']),
                    //'chatid' => $chat_id,
                    'createtime' => $createtime,
                ))->query();

                $new_message = array(
                    'type' => $message_data['type'],
                    'from_uid' => $from_uid,
                    'to_uid' => $to_uid,
                    'itemid' => $itemid,
                    'content' => htmlspecialchars($message_data['content']),
                );
                if (Gateway::isUidOnline($to_uid)) {
                    Gateway::sendToUid($to_uid, json_encode($new_message));
                } else {
                    //发送模板消息
                    $expiretime = $createtime - 7*24*3600;
                    $member_formid = self::$db->select('`formid`, `id`')->from(self::table('superman_hand2_member_formid'))
                        ->where("uid='$to_uid' AND uniacid='{$item['uniacid']}' AND createtime >'$expiretime'")->row();
                    echo 'debug: member_formid='.var_export($member_formid, true);
                    $ret = self::sendTplNotice($item, $message_data, $chat_id, $member_formid['formid']);
                    if ($ret) {
                        //删除使用过的formid
                        if ($member_formid['formid']) {
                            self::$db->delete(self::table('superman_hand2_member_formid'))->where('id='.$member_formid['id'])->query();
                        }
                    }
                }

                //send myself
                Gateway::sendToCurrentClient(json_encode($new_message));
                return;
            case 'logout':
                $uid = $_SESSION['uid']?$_SESSION['uid']:intval($message_data['uid']);
                // 切换用户在线状态
                $m_count = self::$db->update(self::table('superman_hand2_member_login'))->cols(array(
                    'is_online' => 0
                ))->where("uid='$uid' AND uniacid='{$message_data['uniacid']}'")->query();

                if (!empty($uid)) {
                    Gateway::unbindUid($client_id, $uid);
                }
                return;
        }
    }

    /**
    * 当客户端断开连接时
    * @param integer $client_id 客户端id
    */
    public static function onClose($client_id) {
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";
        $uid = $_SESSION['uid'];
        if (!empty($uid)) {
            Gateway::unbindUid($client_id, $uid);
        }
    }

    private static function log($level = 'info', $message = '') {
        $path = str_replace("\\", '/', dirname(dirname(dirname(__FILE__))));
        $filename = $path . '/data/logs/' . date('Ymd') . '.log';
        self::mkdirs(dirname($filename));
        $content = date('Y-m-d H:i:s') . " {$level} :\n------------\n";
        if(is_string($message) && !in_array($message, array('post', 'get'))) {
            $content .= "String:\n{$message}\n";
        }
        if(is_array($message)) {
            $content .= "Array:\n";
            foreach($message as $key => $value) {
                $content .= sprintf("%s : %s ;\n", $key, $value);
            }
        }
        if($message === 'get') {
            $content .= "GET:\n";
            foreach($_GET as $key => $value) {
                $content .= sprintf("%s : %s ;\n", $key, $value);
            }
        }
        if($message === 'post') {
            $content .= "POST:\n";
            foreach($_POST as $key => $value) {
                $content .= sprintf("%s : %s ;\n", $key, $value);
            }
        }
        $content .= "\n";

        $fp = fopen($filename, 'a+');
        fwrite($fp, $content);
        fclose($fp);
    }
    private static function mkdirs($path) {
        if (!is_dir($path)) {
            self::mkdirs(dirname($path));
            mkdir($path);
        }

        return is_dir($path);
    }

    private static function sendTplNotice($item, $message_data, $id, $formid = '') {
        $uniacid = $item['uniacid'];
        //获取模块参数设置
        $setting = self::getModuleSetting($uniacid);
        if (is_error($setting)) {
            echo 'Warning: not found module setting, uniacid='.$uniacid;
            return;
        }
        if ($formid && empty($setting['minipg']['chat_remind']['tmpl_id'])) {
            echo 'Warning: not found chat_remind.tmpl_id, uniacid='.$uniacid;
            return;
        }
        if (empty($formid) && empty($setting['tmpl']['chat_remind']['tmpl_id'])) {
            echo 'Warning: not found chat_remind.tmpl_id, uniacid='.$uniacid;
            return;
        }
        //--end
        $type = empty($formid) ? 1 : 4;
        $token = self::getAccessToken($uniacid, $type);
		if (is_error($token)) {
            return $token;
        }
        $to_member = self::$db->select('nickname')->from(self::table('mc_members'))->where('uid='.$message_data['from_uid'])->row();
        $postdata = array(
            'first' => array(
                'value' => '您有新的咨询消息。。。',
                //'color' => '#173177',
            ),
            'keyword1' => array(
                'value' => $to_member['nickname']?$to_member['nickname']:$message_data['from_uid'],  //咨询人
                //'color' => '#173177',
            ),
            'keyword2' => array(
                'value' =>$item['title'],  //咨询内容
                //'color' => '#173177',
            ),
            'remark' => array(
                'value' => '消息内容：'.$message_data['content'],
            ),
        );
        $data = array();
        $data['touser'] = self::uid2openid($uniacid, $message_data['to_uid']);
        if ($formid) {
            $data['page'] = 'pages/chat/index?itemid='.$item['id'].'&fromuid='.$message_data['from_uid'];
            $data['template_id'] = $setting['minipg']['chat_remind']['tmpl_id'];
            $data['form_id'] = $formid;
            $data['data'] = $postdata;
            $data = json_encode($data);
            $post_url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token={$token}";
            $response = ihttp_request($post_url, $data);
        } else {
            $data['url'] = $setting['base']['siteroot']."app/index.php?i={$uniacid}&c=entry&do=message&act=list&from=tmpl_msg&id={$id}&m=superman_hand2";

            $data['template_id'] = $setting['tmpl']['chat_remind']['tmpl_id'];
            $data['topcolor'] = '#FF683F';
            $data['data'] = $postdata;
            $data = json_encode($data);
            $post_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
            $response = ihttp_request($post_url, $data);
        }

		if (is_error($response)) {
		    echo "访问公众平台接口失败, 错误: {$response['message']}";
		    return;
            //return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
        }
		$result = @json_decode($response['content'], true);
		if (empty($result)) {
		    echo "接口调用失败, 元数据: {$response['meta']}";
		    return;
            //return error(-1, "接口调用失败, 元数据: {$response['meta']}");
        } else if (!empty($result['errcode'])) {
		    echo "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']},信息详情：".self::errorCode($result['errcode']);
		    return;
            //return error(-1, "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']},信息详情：{$this->errorCode($result['errcode'])}");
        }
        echo "sendTplNotic: success, uid={$message_data['to_uid']}";
		return true;
    }

    private static function getAccessToken($uniacid, $type = 4) {
        if (empty($uniacid)) {
            echo 'Warning: not params, uniacid is null';
            return;
        }
        if (isset(self::$accessTokens[$uniacid]) && !empty(self::$accessTokens[$uniacid])) {
            return self::$accessTokens[$uniacid];
        }
        $account = self::getWechatAccount($uniacid, $type);
        if (empty($account)) {
            echo 'Warning: not found wechat account, uniacid='.$uniacid;
            return;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$account['key']}&secret={$account['secret']}";
        $content = ihttp_get($url);
        if (is_error($content)) {
            echo '获取微信公众号授权失败, 请稍后重试！错误详情: ' . $content['message'];
            return;
            //return error('-1', '获取微信公众号授权失败, 请稍后重试！错误详情: ' . $content['message']);
        }
        if (empty($content['content'])) {
            echo 'AccessToken获取失败，请检查appid和appsecret的值是否与微信公众平台一致！';
            return;
            //return error('-1', 'AccessToken获取失败，请检查appid和appsecret的值是否与微信公众平台一致！');
        }
        $result = @json_decode($content['content'], true);
        if (empty($result) || !is_array($result) || empty($result['access_token']) || empty($result['expires_in'])) {
            $errorinfo = substr($content['meta'], strpos($content['meta'], '{'));
            $errorinfo = @json_decode($errorinfo, true);
            echo '获取微信公众号授权失败, 请稍后重试！ 公众平台返回原始数据为: 错误代码-' . $errorinfo['errcode'] . '，错误信息-' . $errorinfo['errmsg'];
            return;
            //return error('-1', '获取微信公众号授权失败, 请稍后重试！ 公众平台返回原始数据为: 错误代码-' . $errorinfo['errcode'] . '，错误信息-' . $errorinfo['errmsg']);
        }
        /*$record = array();
        $record['token'] = $token['access_token'];
        $record['expire'] = TIMESTAMP + $token['expires_in'] - 200;
        $this->account['access_token'] = $record;
        cache_write($cachekey, $record);
        return $record['token'];*/
        self::$accessTokens[$uniacid] = $result['access_token'];
        return $result['access_token'];
    }

    private static function getWechatAccount($uniacid, $type = 4) {
        if (empty($uniacid)) {
            return null;
        }
        if (isset(self::$wechatAccounts[$uniacid]) && !empty(self::$wechatAccounts[$uniacid])) {
            return self::$wechatAccounts[$uniacid];
        }
        if ($type = 4) {
            $table = self::table('account_wxapp');
        } else {
            $table = self::table('account_wechats');
        }
        self::$wechatAccounts[$uniacid] = self::$db->select('`key`, `secret`')->from($table)->where('uniacid='.$uniacid)->row();
        return self::$wechatAccounts[$uniacid];
    }

    private static function getModuleSetting($uniacid) {
        if (empty($uniacid)) {
            return null;
        }
        if (isset(self::$moduleSettings[$uniacid]) && !empty(self::$moduleSettings[$uniacid])) {
            return self::$moduleSettings[$uniacid];
        }
        $table = self::table('uni_account_modules');
        $row = self::$db->select('settings')->from($table)->where("uniacid=$uniacid AND module='superman_hand2'")->row();
        if (!empty($row)) {
            self::$moduleSettings[$uniacid] = unserialize($row['settings']);
        } else {
            self::$moduleSettings[$uniacid] = array();
        }
        return self::$moduleSettings[$uniacid];
    }

    private static function uid2openid($uniacid, $uid) {
        $table = self::table('mc_mapping_fans');
        $row = self::$db->select('openid')->from($table)->where("uniacid=$uniacid AND uid=$uid")->row();
        return isset($row['openid'])?$row['openid']:'';
    }

    private static function errorCode($code, $errmsg = '未知错误') {
        $errors = array(
            '-1' => '系统繁忙',
            '0' => '请求成功',
            '40001' => '获取access_token时AppSecret错误，或者access_token无效',
            '40002' => '不合法的凭证类型',
            '40003' => '不合法的OpenID',
            '40004' => '不合法的媒体文件类型',
            '40005' => '不合法的文件类型',
            '40006' => '不合法的文件大小',
            '40007' => '不合法的媒体文件id',
            '40008' => '不合法的消息类型',
            '40009' => '不合法的图片文件大小',
            '40010' => '不合法的语音文件大小',
            '40011' => '不合法的视频文件大小',
            '40012' => '不合法的缩略图文件大小',
            '40013' => '不合法的APPID',
            '40014' => '不合法的access_token',
            '40015' => '不合法的菜单类型',
            '40016' => '不合法的按钮个数',
            '40017' => '不合法的按钮个数',
            '40018' => '不合法的按钮名字长度',
            '40019' => '不合法的按钮KEY长度',
            '40020' => '不合法的按钮URL长度',
            '40021' => '不合法的菜单版本号',
            '40022' => '不合法的子菜单级数',
            '40023' => '不合法的子菜单按钮个数',
            '40024' => '不合法的子菜单按钮类型',
            '40025' => '不合法的子菜单按钮名字长度',
            '40026' => '不合法的子菜单按钮KEY长度',
            '40027' => '不合法的子菜单按钮URL长度',
            '40028' => '不合法的自定义菜单使用用户',
            '40029' => '不合法的oauth_code',
            '40030' => '不合法的refresh_token',
            '40031' => '不合法的openid列表',
            '40032' => '不合法的openid列表长度',
            '40033' => '不合法的请求字符，不能包含\uxxxx格式的字符',
            '40035' => '不合法的参数',
            '40038' => '不合法的请求格式',
            '40039' => '不合法的URL长度',
            '40050' => '不合法的分组id',
            '40051' => '分组名字不合法',
            '40155' => '请勿添加其他公众号的主页链接',
            '41001' => '缺少access_token参数',
            '41002' => '缺少appid参数',
            '41003' => '缺少refresh_token参数',
            '41004' => '缺少secret参数',
            '41005' => '缺少多媒体文件数据',
            '41006' => '缺少media_id参数',
            '41007' => '缺少子菜单数据',
            '41008' => '缺少oauth code',
            '41009' => '缺少openid',
            '42001' => 'access_token超时',
            '42002' => 'refresh_token超时',
            '42003' => 'oauth_code超时',
            '43001' => '需要GET请求',
            '43002' => '需要POST请求',
            '43003' => '需要HTTPS请求',
            '43004' => '需要接收者关注',
            '43005' => '需要好友关系',
            '44001' => '多媒体文件为空',
            '44002' => 'POST的数据包为空',
            '44003' => '图文消息内容为空',
            '44004' => '文本消息内容为空',
            '45001' => '多媒体文件大小超过限制',
            '45002' => '消息内容超过限制',
            '45003' => '标题字段超过限制',
            '45004' => '描述字段超过限制',
            '45005' => '链接字段超过限制',
            '45006' => '图片链接字段超过限制',
            '45007' => '语音播放时间超过限制',
            '45008' => '图文消息超过限制',
            '45009' => '接口调用超过限制',
            '45010' => '创建菜单个数超过限制',
            '45015' => '回复时间超过限制',
            '45016' => '系统分组，不允许修改',
            '45017' => '分组名字过长',
            '45018' => '分组数量超过上限',
            '45056' => '创建的标签数过多，请注意不能超过100个',
            '45057' => '该标签下粉丝数超过10w，不允许直接删除',
            '45058' => '不能修改0/1/2这三个系统默认保留的标签',
            '45059' => '有粉丝身上的标签数已经超过限制',
            '45065' => '24小时内不可给该组人群发该素材',
            '45157' => '标签名非法，请注意不能和其他标签重名',
            '45158' => '标签名长度超过30个字节',
            '45159' => '非法的标签',
            '46001' => '不存在媒体数据',
            '46002' => '不存在的菜单版本',
            '46003' => '不存在的菜单数据',
            '46004' => '不存在的用户',
            '47001' => '解析JSON/XML内容错误',
            '48001' => 'api功能未授权',
            '48003' => '请在微信平台开启群发功能',
            '50001' => '用户未授权该api',
            '40070' => '基本信息baseinfo中填写的库存信息SKU不合法。',
            '41011' => '必填字段不完整或不合法，参考相应接口。',
            '40056' => '无效code，请确认code长度在20个字符以内，且处于非异常状态（转赠、删除）。',
            '43009' => '无自定义SN权限，请参考开发者必读中的流程开通权限。',
            '43010' => '无储值权限,请参考开发者必读中的流程开通权限。',
            '43011' => '无积分权限,请参考开发者必读中的流程开通权限。',
            '40078' => '无效卡券，未通过审核，已被置为失效。',
            '40079' => '基本信息base_info中填写的date_info不合法或核销卡券未到生效时间。',
            '45021' => '文本字段超过长度限制，请参考相应字段说明。',
            '40080' => '卡券扩展信息cardext不合法。',
            '40097' => '基本信息base_info中填写的参数不合法。',
            '49004' => '签名错误。',
            '43012' => '无自定义cell跳转外链权限，请参考开发者必读中的申请流程开通权限。',
            '40099' => '该code已被核销。',
            '61005' => '缺少接入平台关键数据，等待微信开放平台推送数据，请十分钟后再试或是检查“授权事件接收URL”是否写错（index.php?c=account&amp;a=auth&amp;do=ticket地址中的&amp;符号容易被替换成&amp;amp;）',
            '61023' => '请重新授权接入该公众号',
        );
        if($errors[$code]) {
            return $errors[$code];
        } else {
            return $errmsg;
        }
    }
}
