<?php
defined('IN_IA') or exit('Access Denied');
define('MB_ROOT', IA_ROOT . '/addons/crad_qrcode_red');
define('TABLE_USER', 'crad_qrcode_red_user');
define('TABLE_INVITATION_USER', 'crad_qrcode_red_invitation_user');
define('TABLE_SHOP_TASK', 'crad_qrcode_red_shop_task');
define('TABLE_IMPORT_MODE', 'crad_qrcode_red_import_mode');
define('TABLE_QRCODE', 'crad_qrcode_red_qrcode');
define('TABLE_RED', 'crad_qrcode_red_red');
define('TABLE_ACTIVITY', 'crad_qrcode_red_activity');
define('TABLE_COUPON', 'crad_qrcode_red_coupon');
define('TABLE_SHOP_COUPON', 'crad_qrcode_red_shop_coupon');
define('TABLE_CUTEFACE', 'crad_qrcode_red_cuteface');
define('TABLE_CIRCLE', 'crad_qrcode_red_circle');
define('TABLE_SHOP', 'crad_qrcode_red_shop');
define('TABLE_MANAGER', 'crad_qrcode_red_manager');
define('TABLE_FINANCE', 'crad_qrcode_red_finance');
define('TABLE_BEFOREHAND', 'crad_qrcode_red_beforehand');
define('TABLE_ORDER', 'crad_qrcode_red_order');
define('MODULE_NAME', 'crad_qrcode_red');
class Crad_qrcode_redModuleSite extends WeModuleSite
{

    public function doWebSetting()
    {
    }
    public function Get_checkoauth()
    {
        global $_GPC, $_W;
        load()->model('mc');
        if ($_W['account']['level'] < 3 && empty($_SESSION['oauth_openid'])) {
            return false;
        }
        if (!empty($_SESSION['oauth_openid'])) {
            $userinfo = mc_oauth_userinfo();
            $oauth_openid = $_SESSION['oauth_openid'];
            $nickname = $userinfo['nickname'];
            $avatar = $userinfo['avatar'];
            $unionid = $_SESSION['unionid'];
            $openid = $_SESSION['openid'];
            $follow = $_W['fans']['follow'];
            $followtime = $_W['fans']['followtime'];
        } else {
            if ($_W['account']['level'] == 2) {
                $oauth_openid = $_W['fans']['openid'];
                $nickname = $_W['fans']['tag']['nickname'];
                $avatar = $_W['fans']['tag']['avatar'];
                $unionid = $_W['fans']['unionid'];
                $openid = $_W['fans']['openid'];
                $follow = $_W['fans']['follow'];
                $followtime = $_W['fans']['followtime'];
            } else {
                $member = mc_fetch(intval($_SESSION['uid']), array("avatar", "nickname"));
                $oauth_openid = $_W['fans']['openid'];
                $nickname = $member['nickname'];
                $avatar = $member['avatar'];
                $unionid = $_W['fans']['unionid'];
                $openid = $_W['fans']['openid'];
                $follow = $_W['fans']['follow'];
                $followtime = $_W['fans']['followtime'];
            }
        }
        $userinfo = array("oauth_openid" => $oauth_openid, "nickname" => $nickname, "avatar" => $avatar, "unionid" => $unionid, "openid" => $openid, "follow" => $follow, "followtime" => $followtime);
        return $userinfo;
    }
    public function domain_site()
    {
        global $_W;
        $cfg = $this->module['config']['api'];
        if (empty($cfg['site_domain'])) {
            return $_W['siteroot'];
        }
        return $cfg['site_domain'] . '/';
    }
    public function domain_get()
    {
        $cfg = $this->module['config']['api'];
        if (empty($cfg['jump_domain']) || empty($cfg['site_domain'])) {
            return false;
        }
        $now_url = $_SERVER['HTTP_HOST'];
        if (strpos($cfg['site_domain'], $now_url) === false) {
            return false;
        }
        $jump_domain = explode('
', $cfg['jump_domain']);
        $temp_key = rand(0, count($jump_domain) - 1);
        $domain_str = trim($jump_domain[$temp_key]);
        if (empty($domain_str)) {
            return false;
        }
        $domain_arr = explode('*.', $domain_str);
        if (count($domain_arr) > 1) {
            $domain_before = random(4) . '.';
            $domain_str = str_replace('*.', $domain_before, $domain_str);
        }
        header('location: ' . $domain_str . $_SERVER['REQUEST_URI']);
    }
    public function addFileToZip($path, $zip)
    {
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != '.' && $filename != '..') {
                if (is_dir($path . '/' . $filename)) {
                    $this->addFileToZip($path . '/' . $filename, $zip);
                } else {
                    $zip->addFile($path . '/' . $filename, $filename);
                }
            }
        }
        @closedir($path);
    }
    public function doWebQr()
    {
        global $_GPC;
        $raw = @base64_decode($_GPC['raw']);
        if (!empty($raw)) {
            require_once IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
            QRcode::png($raw, false, QR_ECLEVEL_Q, 4);
        }
    }
    public function doMobileQr()
    {
        global $_GPC;
        $url = @base64_decode($_GPC['url']);
        if (!empty($url)) {
            require_once IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
            QRcode::png($url, false, QR_ECLEVEL_Q, 4);
        }
    }
    public function doMobilesetcookie()
    {
        global $_W, $_GPC;
        $aid = intval($_GPC['aid']);
        if (empty($aid)) {
            exit;
        }
        $gps = intval($_GPC['gps']);
        $lat = trim($_GPC['lat']);
        $lng = trim($_GPC['lng']);
        if ($_GPC['type'] == 1) {
            $coordinate = $this->Convert_GCJ02_To_BD09($lat, $lng);
            $lat = $coordinate['lat'];
            $lng = $coordinate['lng'];
        }
        if ($gps) {
            setcookie('gps[' . $aid . ']', $gps, time() + 60 * 10);
        }
        if ($lat) {
            setcookie('lat[' . $aid . ']', $lat, time() + 60 * 10);
        }
        if ($lng) {
            setcookie('lng[' . $aid . ']', $lng, time() + 60 * 10);
        }
        $res['sta'] = 1;
        echo json_encode($res);
        exit;
    }
    public function Convert_GCJ02_To_BD09($lat, $lng)
    {
        $x_pi = 3.141592653589793 * 3000.0 / 180.0;
        $x = $lng;
        $y = $lat;
        $z = sqrt($x * $x + $y * $y) + 2.0E-5 * sin($y * $x_pi);
        $theta = atan2($y, $x) + 3.0E-6 * cos($x * $x_pi);
        $lng = $z * cos($theta) + 0.0065;
        $lat = $z * sin($theta) + 0.006;
        return array("lng" => $lng, "lat" => $lat);
    }
    public function Convert_BD09_To_GCJ02($lat, $lng)
    {
        $x_pi = 3.141592653589793 * 3000.0 / 180.0;
        $x = $lng - 0.0065;
        $y = $lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 2.0E-5 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 3.0E-6 * cos($x * $x_pi);
        $lng = $z * cos($theta);
        $lat = $z * sin($theta);
        return array("lng" => $lng, "lat" => $lat);
    }
    public function file_picremote_delete($filename, $remote)
    {
        if (empty($filename) || $remote) {
            return false;
        }
        $filename = str_replace($remote['qiniu_url'] . '/', '', $filename);
        require_once IA_ROOT . '/framework/library/qiniu/autoload.php';
        $auth = new Qiniu\Auth($remote['qiniu_accesskey'], $remote['qiniu_secretkey']);
        $bucketMgr = new Qiniu\Storage\BucketManager($auth);
        $error = $bucketMgr->delete($remote['qiniu_bucket'], $filename);
        if ($error instanceof Qiniu\Http\Error) {
            if ($error->code() == 612) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }
    public function createNonceStr($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        $i = 0;
        while ($i < $length) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $i++;
        }
        return $str;
    }
    public function getJssdk_Config()
    {
        global $_W;
        $jsapiTicket = $_W['account']['jsapi_ticket']['ticket'];
        $nonceStr = $this->createNonceStr();
        $timestamp = TIMESTAMP;
        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
        $url = "{$protocol}{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $string1 = "jsapi_ticket={$jsapiTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
        $signature = sha1($string1);
        $config = array("appId" => $_W['account']['key'], "nonceStr" => $nonceStr, "timestamp" => "{$timestamp}", "signature" => $signature);
        return $config;
    }
    public function file_picremote_upload($filename, $remote, $path, $auto_delete_local = true)
    {
        global $_W;
        if (empty($remote['isremote'])) {
            return false;
        }
        require_once IA_ROOT . '/framework/library/qiniu/autoload.php';
        $auth = new Qiniu\Auth($remote['qiniu_accesskey'], $remote['qiniu_secretkey']);
        $uploadmgr = new Qiniu\Storage\UploadManager();
        $putpolicy = Qiniu\base64_urlSafeEncode(json_encode(array("scope" => $remote['qiniu_bucket'] . ':' . $filename)));
        $uploadtoken = $auth->uploadToken($remote['qiniu_bucket'], $filename, 3600, $putpolicy);
        list($ret, $err) = $uploadmgr->putFile($uploadtoken, $filename, $path . $filename);
        if ($auto_delete_local) {
            load()->func('file');
            file_delete($path . $filename);
        }
        if ($err !== null) {
            return false;
        } else {
            return true;
        }
    }
    public function time_tran($time)
    {
        if (is_numeric($time) && $time > 0) {
            $value = array("days" => 0, "hours" => 0, "minutes" => 0, "seconds" => 0, "tip" => "");
            if ($time >= 3600) {
                $value['hours'] = floor($time / 3600);
                $time = $time % 3600;
                $value['tip'] .= $value['hours'] . '小时';
            }
            if ($time >= 60) {
                $value['minutes'] = floor($time / 60);
                $time = $time % 60;
                $value['tip'] .= $value['minutes'] . '分钟';
            }
            if ($time >= 1) {
                $value['seconds'] = floor($time);
                $value['tip'] .= $value['seconds'] . '秒';
            }
            return $value;
        } else {
            return false;
        }
    }
    public function settlement_activity($shopid)
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $settlement = $_W['timestamp'] - 60;
        $settlement_red = $_W['timestamp'] - 86400;
        $where = " WHERE c.uniacid ='{$uniacid}' AND c.endtime>0 AND c.endtime<{$settlement} AND c.use_balance=1 AND c.settlement_open=1 AND u.status=1 AND u.type=2";
        if ($shopid) {
            $where .= " AND c.sid ='{$shopid}'";
        } else {
            $where .= ' AND c.sid >0';
        }
        $shop_activity_list = pdo_fetchall('SELECT c.sid,c.id,c.use_balance,c.endtime,c.refund_open,u.id as pid FROM ' . tablename(TABLE_ACTIVITY) . ' c left join ' . tablename(TABLE_FINANCE) . " u on c.sid=u.shopid  AND c.id = u.aid  {$where}");
        if ($shop_activity_list) {
            foreach ($shop_activity_list as $activity_row) {
                if ($activity_row['refund_open']) {
                    $list_red_check = pdo_fetchall('SELECT id,aid,status,mch_billno,refund_check,createtime,money FROM ' . tablename(TABLE_RED) . " WHERE aid='{$activity_row['id']}' AND status=1 AND refund_check!=1 AND mch_billno!='' AND createtime<{$settlement_red} LIMIT 0,30");
                    if (!$list_red_check) {
                        if (!($activity_row['endtime'] && $activity_row['endtime'] > $settlement_red)) {
                            $sum_money_activity = pdo_fetch('SELECT SUM(money) AS sum_money FROM ' . tablename(TABLE_RED) . " WHERE aid='{$activity_row['id']}' AND shopid='{$activity_row['sid']}' AND status=1");
                            $data_pinance = array("type" => 3, "status" => 1, "money" => $sum_money_activity['sum_money'] ? $sum_money_activity['sum_money'] : '0.00', "paytime" => time());
                            pdo_update(TABLE_FINANCE, $data_pinance, array("id" => $activity_row['pid']));
                        }
                    } else {
                        foreach ($list_red_check as $value) {
                            if (!($value['createtime'] >= $settlement)) {
                                $res_check = $this->getRedStatus($value['mch_billno']);
                                if (!(empty($res_check) || $res_check['sta'] != 1)) {
                                    if (!empty($res_check['status'])) {
                                        $update_check = array("refund_check" => 1);
                                        if ($res_check['status'] == 4 && $res_check['mch_billno'] == $value['mch_billno'] && $res_check['refund_amount'] == $value['money'] * 100) {
                                            $update_check['status'] = 4;
                                            $update_check['refund_time'] = $res_check['refund_time'];
                                        }
                                        if ($res_check['status'] == 1 && $res_check['mch_billno'] == $value['mch_billno'] && $res_check['total_amount'] == $value['money'] * 100) {
                                            $update_check['status'] = 1;
                                        }
                                        if ($res_check['status'] == 3 && $res_check['mch_billno'] == $value['mch_billno']) {
                                            $update_check['status'] = 0;
                                        }
                                        pdo_update(TABLE_RED, $update_check, array("uniacid" => $uniacid, "id" => $value['id']));
                                    }
                                } else {
                                    $activity_row['error_status'] = 1;
                                }
                                break;
                            }
                        }
                        if (!($activity_row['error_status'] == 1 || count($list_red_check) >= 30)) {
                        }
                    }
                } else {
                    if (!($activity_row['endtime'] && $activity_row['endtime'] > $_W['timestamp'])) {
                    }
                }
            }
        }
    }
    public function upload_image($file)
    {
        global $_W, $_GPC;
        load()->func('file');
        $uniacid = $_W['uniacid'];
        $openid = $_W['openid'];
        $file_name = $file['name'];
        $file_tmp_name = $file['tmp_name'];
        $file_type = strtolower(substr($file_name, strpos($file_name, '.') + 1));
        $allow_type = array("jpg", "jpeg", "png");
        $re_dir = "images/{$uniacid}/crad_qrcode_red/" . date('Y/m/');
        $upload_path = ATTACHMENT_ROOT . $re_dir;
        $upload_file = md5(time() . $openid . rand(10000, 99999));
        $upload_file_name = $upload_file . '.' . $file_type;
        if (!is_dir($upload_path)) {
            if (function_exists('mkdirs')) {
                mkdirs($upload_path);
            } else {
                mkdir($upload_path, 0777, true);
            }
        }
        if (!in_array($file_type, $allow_type)) {
            return false;
        }
        if (!is_uploaded_file($file_tmp_name)) {
            return false;
        }
        if (!move_uploaded_file($file_tmp_name, $upload_path . $upload_file_name)) {
            return false;
        }
        $cfg = $this->module['config']['api'];
        $image_path = $re_dir . $upload_file_name;
        if (!empty($cfg['isremote'])) {
            $this->file_picremote_upload($upload_file_name, $cfg, $upload_path);
            $url = $cfg['qiniu_url'];
            $filepath_new = $url . '/' . $upload_file_name;
        } else {
            if (!empty($_W['setting']['remote']['type'])) {
                $remotestatus = file_remote_upload($image_path, true);
                if (is_error($remotestatus)) {
                    return false;
                } else {
                    if (file_exists($filepath)) {
                        file_delete($filepath);
                    }
                }
            }
        }
        if ($filepath_new) {
            $image_path = $filepath_new;
        }
        return $image_path;
    }
    public function get_code()
    {
        return date('Ymd') .rand(1,999);
    }
    public function get_coupon_key($aid, $uniacid)
    {
        $charid = strtolower(md5(uniqid(mt_rand(), true) . rand(10000, 99999) . $aid . $uniacid . rand(10000, 99999)));
        $uuid = substr($charid, 2, 2) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 20, 2) . substr($charid, 16, 4);
        return $uuid;
    }
    public function get_uuid($aid, $uniacid)
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true) . rand(10000, 99999) . $aid . $uniacid . rand(10000, 99999)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 20, 12) . substr($charid, 16, 4);
        return $uuid;
    }
    public function section_code($code)
    {
        $r = array();
        $r[] = array("min" => $code[0]['code'], "max" => $code[0]['code']);
        $c = 0;
        $i = 1;
        $j = count($code);
        while ($i < $j) {
            $v = $code[$i]['code'];
            if ($r[$c]['max'] == $v - 1) {
                $r[$c]['max'] = $v;
            } else {
                $r[] = array("min" => $v, "max" => $v);
                $c++;
            }
            $i++;
        }
        $str = '';
        foreach ($r as $k => $v) {
            if ($v['min'] == $v['max']) {
                if ($k == 0) {
                    $str .= $v['max'];
                } else {
                    $str .= ',' . $v['max'];
                }
            } else {
                if ($k == 0) {
                    $str .= '[' . $v['min'] . ',' . $v['max'] . ']';
                } else {
                    $str .= ',' . '[' . $v['min'] . ',' . $v['max'] . ']';
                }
            }
        }
        return $str;
    }
    public function get_qrcode_url($scene_str, $type)
    {
        global $_W;
        load()->classs('weixin.account');
        if ($_W['account']['level'] > 3) {
            $accObj = WeiXinAccount::create($_W['account']);
        } else {
            if ($_W['oauth_account']['level'] > 3) {
                $accObj = WeiXinAccount::create($_W['account']);
            } else {
                $accObj = WeiXinAccount::create($_W['oauth_account']);
            }
        }
        $token = $accObj->fetch_available_token();
        if ($type == 1) {
            $data['action_name'] = 'QR_LIMIT_STR_SCENE';
        } else {
            $data['expire_seconds'] = 2592000;
            $data['action_name'] = 'QR_STR_SCENE';
        }
        $data['action_info'] = array("scene" => array("scene_str" => $scene_str));
        $urls = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $token;
        load()->func('communication');
        $data = json_encode($data);
        $content = ihttp_post($urls, $data);
        $result = json_decode($content['content'], true);
        return $result;
    }
    public function get_qrcode($id, $uuid, $aid = 0, $bid = 0, $code = 0, $pattern = "")
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        load()->func('file');
        if (empty($id) || empty($uuid)) {
            return false;
        }
        if ($bid) {
            $imgname = $bid . '_' . $code . '.png';
            $upload_path = ATTACHMENT_ROOT . 'crad_qrcode_red/b' . $bid . '/qrcode/';
        } else {
            $imgname = $id . '.png';
            $upload_path = ATTACHMENT_ROOT . 'crad_qrcode_red/' . $aid . '/qrcode/';
        }
        $qr_file = $upload_path . $imgname;
        if (!is_dir($upload_path)) {
            if (function_exists('mkdirs')) {
                $dir = mkdirs($upload_path);
            } else {
                $dir = mkdir($upload_path, 0777, true);
            }
        }
        if (!file_exists($qr_file)) {
            require_once IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
            if ($bid) {
                if ($pattern) {
                    $value = $pattern;
                } else {
                    $value = $this->domain_site() . 'app/index.php?i=' . $uniacid . '&c=entry&m=crad_qrcode_red&do=index&uuid=' . $uuid . '&code=' . $code;
                }
            } else {
                if ($pattern) {
                    $value = $pattern;
                } else {
                    $value = $this->domain_site() . 'app/index.php?i=' . $uniacid . '&c=entry&m=crad_qrcode_red&do=index&aid=' . $aid . '&uuid=' . $uuid;
                }
            }
            $errorCorrectionLevel = 'L';
            $matrixPointSize = '4';
            QRcode::png($value, $qr_file, $errorCorrectionLevel, $matrixPointSize);
        }
        if ($bid) {
            return 'crad_qrcode_red/b' . $bid . '/qrcode/' . $imgname;
        } else {
            return 'crad_qrcode_red/' . $aid . '/qrcode/' . $imgname;
        }
    }
    public function get_audio_shop($filename, $type = 0, $text = "")
    {
        global $_W;
        load()->func('tpl');
        load()->func('file');
        if (!$text) {
            return false;
        }
        require_once '../addons/crad_qrcode_red/libs/baidu/AipSpeech.php';
        $setting = $this->module['config'];
        $cfg = $setting['baidu_config'];
        if ($cfg['baidu_appid'] && $cfg['baidu_api_key'] && $cfg['baidu_api_secret']) {
            $APP_ID = $cfg['baidu_appid'];
            $API_KEY = $cfg['baidu_api_key'];
            $SECRET_KEY = $cfg['baidu_api_secret'];
        } else {
            return false;
        }
        $aipSpeech = new AipSpeech($APP_ID, $API_KEY, $SECRET_KEY);
        $result = $aipSpeech->synthesis($text, 'zh', 1, array("vol" => 5, "spd" => 5, "pit" => 5, "per" => $type));
        if (!is_array($result)) {
            $filemp3 = $result;
        } else {
            return false;
        }
        $rel_path = 'audio/';
        $fileoutroot = ATTACHMENT_ROOT . $rel_path;
        $fileurl = $fileoutroot . $filename;
        if (!is_array($result)) {
            $filemp3 = $result;
        } else {
            return false;
        }
        if (!is_dir($fileoutroot)) {
            $filerootmake = mkdir($fileoutroot, 0777);
        }
        if (false !== $filerootmake) {
            $zym_10 = fopen($fileurl, 'w');
            if (false !== $zym_10) {
                if (false !== fwrite($zym_10, $filemp3)) {
                    fclose($zym_10);
                    if (empty($setting['api']['isremote'])) {
                        file_remote_upload($rel_path . $filename);
                        $realurl = tomedia($rel_path . $filename);
                    } else {
                        self::file_picremote_upload($filename, $setting['api'], $fileoutroot, true);
                        $url = $setting['api']['qiniu_url'];
                        $realurl = $url . '/' . $filename;
                    }
                    return $realurl;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function get_audio($name, $type = 0, $text = "", $temp = false)
    {
        global $_W;
        load()->func('tpl');
        load()->func('file');
        $filename = $name . '.mp3';
        $fileroot = MODULE_ROOT . DIRECTORY_SEPARATOR . 'audio/';
        if (file_exists($fileroot . $filename)) {
            return json_encode(array("sta" => 1, "path" => "{$_W['siteroot']}addons/audio/" . $filename . '?' . time()));
        }
        if (!$text) {
            return json_encode(array("sta" => 0, "error" => "无语音文字"));
        }
        require_once '../addons/crad_qrcode_red/libs/baidu/AipSpeech.php';
        $setting = $this->module['config'];
        $cfg = $setting['baidu_config'];
        if ($cfg['baidu_appid'] && $cfg['baidu_api_key'] && $cfg['baidu_api_secret']) {
            $APP_ID = $cfg['baidu_appid'];
            $API_KEY = $cfg['baidu_api_key'];
            $SECRET_KEY = $cfg['baidu_api_secret'];
        } else {
            return false;
        }
        $aipSpeech = new AipSpeech($APP_ID, $API_KEY, $SECRET_KEY);
        $result = $aipSpeech->synthesis($text, 'zh', 1, array("vol" => 5, "spd" => 5, "pit" => 5, "per" => $type));
        $rel_path = 'audio/';
        $fileoutroot = ATTACHMENT_ROOT . $rel_path;
        $fileurl = $fileoutroot . $filename;
        if (!is_array($result)) {
            $filemp3 = $result;
        } else {
            return json_encode(array("sta" => 0, "error" => $result['err_msg']));
        }
        if (!is_dir($fileoutroot)) {
            $filerootmake = mkdir($fileoutroot, 0777);
        }
        if (false !== $filerootmake) {
            $zym_10 = fopen($fileurl, 'w');
            if (false !== $zym_10) {
                if (false !== fwrite($zym_10, $filemp3)) {
                    fclose($zym_10);
                    if (empty($setting['api']['isremote'])) {
                        file_remote_upload($rel_path . $filename);
                        $realurl = tomedia($rel_path . $filename);
                    } else {
                        self::file_picremote_upload($filename, $setting['api'], $fileoutroot, $temp);
                        $url = $setting['api']['qiniu_url'];
                        $realurl = $url . '/' . $filename;
                    }
                    return json_encode(array("sta" => 1, "path" => $realurl));
                }
            } else {
                return json_encode(array("sta" => 0, "error" => "权限错误"));
            }
        } else {
            return json_encode(array("sta" => 0, "error" => "权限错误"));
        }
    }

    public function exportexcel($data = array(), $title = array(), $filename = "report")
    {

        header("Content-type:application/octet-stream");

        header("Accept-Ranges:bytes");

        header("Content-type:application/vnd.ms-excel");

        header("Content-Disposition:attachment;filename=" . $filename . "-" . date("Y-m-d") . ".xls");

        header("Pragma: no-cache");

        header("Expires: 0");

        if (!empty($title)) {

            foreach ($title as $k => $v) {

                $title[$k] = iconv("UTF-8", "GB2312", $v);

            }

            $title = implode("\t", $title);

            echo (string) $title . "\n";

        }

        if (!empty($data)) {

            foreach ($data as $key => $val) {

                $data[$key] = implode("\t", $data[$key]);

            }

            echo implode("\n", $data);

        }

        return null;

    }
    public function show_error($msg, $type, $redirect = "")
    {
        global $_W;
        $type = $type;
        $msg = $msg;
        $redirect = $redirect;
        include $this->template('message');
        exit;
    }

    public function delDirAndFile($dirName)
    {

        if ($handle = opendir((string) $dirName)) {

            while (false !== ($item = readdir($handle))) {

                if ($item != "." && $item != "..") {

                    if (is_dir((string) $dirName . "/" . $item)) {

                        $this->delDirAndFile((string) $dirName . "/" . $item);

                    } else {

                        unlink((string) $dirName . "/" . $item);

                    }

                }

            }

            closedir($handle);

            rmdir($dirName);

        }

    }

    public function get_resource($pic_path)
    {
        $pathInfo = pathinfo($pic_path);
        switch (strtolower($pathInfo['extension'])) {
            case 'jpg':
                $imagecreatefromjpeg = 'imagecreatefromjpeg';
                break;
            case 'jpeg':
                $imagecreatefromjpeg = 'imagecreatefromjpeg';
                break;
            case 'png':
                $imagecreatefromjpeg = 'imagecreatefrompng';
                break;
            case 'gif':
                break;
            default:
                $imagecreatefromjpeg = 'imagecreatefromstring';
                $pic_path = file_get_contents($pic_path);
                break;
        }
        $resource = $imagecreatefromjpeg($pic_path);
        return $resource;
    }

    public function downloadWeixinFile($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        $imageAll = array_merge(array("header" => $httpinfo), array("body" => $package));
        return $imageAll;
    }

    public function findKJsetting()
    {
        global $_W;
        $tempuniacid = $_W['uniacid'];
        $tempappid = $_W['account']['key'];
        $tempappsecret = $_W['account']['secret'];
        if ($_W['account']['level'] < 4) {
            $tempuniacid = $_W['oauth_account']['acid'];
            $tempappid = $_W['oauth_account']['key'];
            $tempappsecret = $_W['oauth_account']['secret'];
        }
        $kjsetting = array();
        $setting = uni_setting($tempuniacid, array("payment"));
        $pay = (array) $setting['payment'];
        if (intval($pay['wechat']['switch']) == 2 || intval($pay['wechat']['switch']) == 3) {
            $uniacid = !empty($pay['wechat']['service']) ? $pay['wechat']['service'] : $pay['wechat']['borrow'];
            $oauth_account = uni_setting($uniacid, array("payment"));
            if (intval($pay['wechat']['switch']) == '2') {
                $_W['uniacid'] = $uniacid;
                $pay['wechat']['apikey'] = $oauth_account['payment']['wechat']['signkey'];
                $pay['wechat']['mchid'] = $oauth_account['payment']['wechat']['mchid'];
            } else {
                $pay['wechat']['apikey'] = $oauth_account['payment']['wechat_facilitator']['signkey'];
                $pay['wechat']['mchid'] = $oauth_account['payment']['wechat_facilitator']['mchid'];
            }
            $acid = pdo_getcolumn('uni_account', array("uniacid" => $uniacid), 'default_acid');
            $tempappid = pdo_getcolumn('account_wechats', array("acid" => $acid), 'key');
            $tempappsecret = pdo_getcolumn('account_wechats', array("acid" => $acid), 'secret');
        }
        $kjsetting['appid'] = $tempappid;
        $kjsetting['appsecret'] = $tempappsecret;
        $kjsetting['mchid'] = $pay['wechat']['mchid'];
        $kjsetting['shkey'] = $pay['wechat']['apikey'];
        return $kjsetting;
    }

    public function get_red_money($activity, $total_red, $sum_money)
    {
        if ($activity['qrcode_num'] - $total_red < 1 || $activity['start_money'] < 0.3 || $activity['end_money'] < 0.3 || $activity['end_money'] < $activity['start_money'] || $activity['money_sum'] - $sum_money < $activity['start_money']) {
            return false;
        }
        if ($activity['money_type'] == 1) {
            $money = min($activity['start_money'], $activity['money_sum'] - $sum_money);
        } else {
            if ($activity['qrcode_num'] - $total_red == 1) {
                $money = $activity['money_sum'] - $sum_money;
            } else {
                $middle_money = ($activity['start_money'] + $activity['end_money']) / 2;
                $pingjun_money = ($activity['money_sum'] - $sum_money) / ($activity['qrcode_num'] - $total_red);
                if ($middle_money > $pingjun_money) {
                    $rand_money = rand(intval($activity['start_money'] * 100), intval($pingjun_money * 100)) / 100;
                } else {
                    $rand_money = rand(intval($pingjun_money * 100), intval($activity['end_money'] * 100)) / 100;
                }
                $money = min($rand_money, $activity['money_sum'] - $sum_money);
                $pingjun_money_temp = ($activity['money_sum'] - $sum_money - $money) / ($activity['qrcode_num'] - $total_red - 1);
                if ($pingjun_money_temp < $activity['start_money']) {
                    $money = $activity['start_money'];
                }
                if ($pingjun_money_temp > $activity['end_money']) {
                    $money = $activity['end_money'];
                }
            }
        }
        return $money ? $money : 0;
    }

    public function cash($actdetail, $red_info, $uuid, $user = "")
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $openid = $red_info['openid'];
        $red_fetch = pdo_fetch('SELECT id,status,money,tid FROM ' . tablename(TABLE_RED) . ' WHERE uniacid = :uniacid AND id = :id', array(":uniacid" => $uniacid, ":id" => $red_info['id']));
        if (empty($red_fetch)) {
            $data['sta'] = 0;
            $data['error'] = '红包数据错误1';
            return json_encode($data);
        }
        if ($red_fetch['status'] > 0) {
            $data['sta'] = 0;
            $data['error'] = '红包数据错误2';
            return json_encode($data);
        }
        if (sprintf('%.2f', $red_fetch['money']) != sprintf('%.2f', $red_info['money'])) {
            $data['sta'] = 0;
            $data['error'] = '红包数据错误3';
            return json_encode($data);
        }
        if ($red_info['aid'] != $actdetail['id']) {
            $data['sta'] = 0;
            $data['error'] = '红包数据错误4';
            return json_encode($data);
        }
        if ($red_info['openid'] != $user['openid']) {
            $data['sta'] = 0;
            $data['error'] = '红包数据错误5';
            return json_encode($data);
        }
        if ($red_info['tid'] != $red_fetch['tid']) {
            $data['sta'] = 0;
            $data['error'] = '红包数据错误6';
            return json_encode($data);
        }
        if ($red_info['money']) {
            if ($red_info['money'] < 0.3) {
                $data['sta'] = 0;
                $data['error'] = '红包金额数据错误';
                return json_encode($data);
            }
            $fee = $red_info['money'] * 100;
            $api = $this->module['config']['api'];
            if (empty($api['appid']) || empty($api['mchid'])) {
                $data['sta'] = 0;
                $data['error'] = '系统未开发此功能';
                return json_encode($data);
            }
            if ($actdetail['payway'] == 0) {
                if ($api['sl_pay'] == 1 && $api['sub_mch_id']) {
                    $data['sta'] = 0;
                    $data['error'] = '服务商子商户只能使用现金红包，不能使用企业付款到零钱';
                    return json_encode($data);
                }
                $money_type = '企业付款';
                $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
                $pars = array();
                $pars['mch_appid'] = $api['appid'];
                $pars['mchid'] = $api['mchid'];
                $pars['nonce_str'] = random(32);
                $pars['partner_trade_no'] = $red_info['trade_no'] ? $red_info['trade_no'] : random(10) . date('Ymd') . random(3);
                $pars['openid'] = $openid;
                $pars['check_name'] = 'NO_CHECK';
                $pars['amount'] = $fee;
                if ($actdetail['pay_desc']) {
                    $actdetail['pay_desc'] = str_replace('#活动#', $actdetail['name'], $actdetail['pay_desc']);
                    $actdetail['pay_desc'] = str_replace('#金额#', $red_info['money'], $actdetail['pay_desc']);
                }
                $pay_desc = $actdetail['pay_desc'] ? $actdetail['pay_desc'] : $api['pay_desc'];
                $pars['desc'] = $pay_desc ? $pay_desc : '您在' . $actdetail['name'] . '中获得的' . $red_info['money'] . '元红包';
                $pars['spbill_create_ip'] = $api['ip'];
                ksort($pars, SORT_STRING);
                $string1 = '';
                foreach ($pars as $k => $v) {
                    $string1 .= "{$k}={$v}&";
                }
                $string1 .= 'key=' . $api['password'];
                $pars['sign'] = strtoupper(md5($string1));
                $xml = array2xml($pars);
                $extras = array();
                $extras['CURLOPT_SSLCERT'] = MB_ROOT . '/cert/apiclient_cert.pem.' . $uniacid;
                $extras['CURLOPT_SSLKEY'] = MB_ROOT . '/cert/apiclient_key.pem.' . $uniacid;
                $procResult = null;
                load()->func('communication');
                $resp = ihttp_request($url, $xml, $extras);
                if (is_error($resp)) {
                    $setting = $this->module['config'];
                    $setting['api']['error'] = $resp['message'];
                    $this->saveSettings($setting);
                    $procResult = array("errno" => -2, "error" => $resp['message']);
                } else {
                    $arr = json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
                    $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
                    $dom = new \DOMDocument();
                    if ($dom->loadXML($xml)) {
                        $xpath = new \DOMXPath($dom);
                        $code = $xpath->evaluate('string(//xml/return_code)');
                        $ret = $xpath->evaluate('string(//xml/result_code)');
                        if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                            $procResult = array("errno" => 0, "error" => "success");
                        } else {
                            $error = $xpath->evaluate('string(//xml/err_code_des)');
                            $procResult = array("errno" => -2, "error" => $error);
                        }
                    } else {
                        $procResult = array("errno" => -1, "error" => "未知错误");
                    }
                }
            } else {
                $money_type = '现金红包';
                if ($api['sl_pay'] == 1) {
                    $result = $this->sendSubRed($openid, $red_info['money'], $red_info['trade_no'], $actdetail);
                } else {
                    $result = $this->sendRedPacket($openid, $red_info['money'], $red_info['trade_no'], $actdetail);
                }
                if ($result['sta'] == 1) {
                    $procResult['errno'] = 0;
                    $updata_red['mch_billno'] = $result['mch_billno'];
                    $updata_red['send_listid'] = $result['send_listid'];
                } else {
                    $procResult['error'] = $result['message'];
                    $procResult['errno'] = 1;
                }
            }
            if ($procResult['errno'] != 0) {
                $res['sta'] = 0;
                $res['error'] = $procResult['error'];
                return json_encode($res);
            } else {
                $updata_red['status'] = 1;
                pdo_update(TABLE_RED, $updata_red, array("uniacid" => $uniacid, "id" => $red_info['id']));
                $res['sta'] = 1;
                if ($api['mid_red'] && $openid) {
                    $url = $_W['siteroot'] . 'app/' . substr($this->createMobileUrl('index', array("aid" => $actdetail['id'], "uuid" => $uuid), true), 2);
                    $template = array("touser" => $openid, "template_id" => $api['mid_red'], "url" => $url, "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode('恭喜您,红包领取成功,请实时查看微信到账通知'), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode($red_info['money'] . '元'), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode(date('Y-m-d H:i:s', $red_info['createtime'])), "color" => "#2F1B58"), "keyword3" => array("value" => urlencode($money_type), "color" => "#2F1B58"), "keyword4" => array("value" => urlencode($actdetail['name']), "color" => "#2F1B58"), "remark" => array("value" => urlencode('点击查看红包记录哦'), "color" => "#2F1B58")));
                    $this->send_temp_ms(urldecode(json_encode($template)));
                }
                return json_encode($res);
            }
        } else {
            $res['sta'] = 0;
            $res['error'] = '金额不足';
            return json_encode($res);
        }
    }

    public function GetDistance($lat1, $lng1, $lat2, $lng2)
    {
        define('PI', 3.1415926535898);
        define('EARTH_RADIUS', 6378.137);
        $radLat1 = $lat1 * (PI / 180);
        $radLat2 = $lat2 * (PI / 180);
        $a = $radLat1 - $radLat2;
        $b = $lng1 * (PI / 180) - $lng2 * (PI / 180);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return $s;
    }

    public function getRedStatus($mch_billno)
    {
        if (empty($mch_billno)) {
            return false;
        }
        global $_W;
        $uniacid = $_W['uniacid'];
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo';
        load()->func('communication');
        $pars = array();
        $cfg = $this->module['config'];
        $api = $cfg['api'];
        $pars['nonce_str'] = random(32);
        $pars['mch_id'] = $api['mchid'];
        $pars['appid'] = $api['appid'];
        $pars['mch_billno'] = $mch_billno;
        $pars['bill_type'] = 'MCHT';
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$api['password']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CURLOPT_SSLCERT'] = MB_ROOT . '/cert/apiclient_cert.pem.' . $uniacid;
        $extras['CURLOPT_SSLKEY'] = MB_ROOT . '/cert/apiclient_key.pem.' . $uniacid;
        $procResult = array("sta" => 0);
        $resp = ihttp_request($url, $xml, $extras);
        if (is_error($resp)) {
            $setting = $this->module['config'];
            $setting['api']['error'] = $resp['message'];
            $this->saveSettings($setting);
            $procResult['message'] = $resp['message'];
        } else {
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new DOMDocument();
            if ($dom->loadXML($xml)) {
                $xpath = new DOMXPath($dom);
                $status = $xpath->evaluate('string(//xml/status)');
                if ($status == 'REFUND') {
                    $status = 4;
                } else {
                    if ($status == 'FAILED') {
                        $status = 3;
                    } else {
                        if ($status == 'RECEIVED') {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                    }
                }
                $total_amount = $xpath->evaluate('string(//xml/total_amount)');
                $refund_time = $xpath->evaluate('string(//xml/refund_time)');
                $refund_amount = $xpath->evaluate('string(//xml/refund_amount)');
                $mch_billno_res = $xpath->evaluate('string(//xml/mch_billno)');
                $code = $xpath->evaluate('string(//xml/return_code)');
                $ret = $xpath->evaluate('string(//xml/result_code)');
                if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                    $setting = $this->module['config'];
                    $setting['api']['error'] = '';
                    $procResult['sta'] = 1;
                    $procResult['mch_billno'] = $mch_billno_res;
                    $procResult['total_amount'] = $total_amount;
                    $procResult['refund_time'] = $refund_time;
                    $procResult['status'] = $status;
                    $procResult['refund_amount'] = $refund_amount;
                    $this->saveSettings($setting);
                } else {
                    $error = $xpath->evaluate('string(//xml/err_code_des)');
                    $setting = $this->module['config'];
                    $setting['api']['error'] = $error;
                    $this->saveSettings($setting);
                    $procResult['message'] = $error;
                }
            } else {
                $procResult['message'] = 'error response';
            }
        }
        return $procResult;
    }

    public function sendRedPacket($openid, $money, $trade_no, $actdetail)
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        load()->func('communication');
        $pars = array();
        $cfg = $this->module['config'];
        $api = $cfg['api'];
        $pars['nonce_str'] = random(32);
        $pars['mch_billno'] = $trade_no ? $trade_no : $api['mchid'] . date('YmdHis') . rand(1000, 9999);
        $pars['mch_id'] = $api['mchid'];
        $pars['wxappid'] = $api['appid'];
        $pars['send_name'] = $actdetail['send_name'] ? $actdetail['send_name'] : $api['send_name'];
        $pars['re_openid'] = $openid;
        $pars['total_amount'] = floatval($money) * 100;
        $pars['total_num'] = 1;
        $pars['wishing'] = $actdetail['wish'] ? $actdetail['wish'] : $api['wish'];
        $pars['client_ip'] = $api['ip'];
        if ($actdetail['start_money'] < 1) {
            $pars['scene_id'] = $api['scene_red'] ? $api['scene_red'] : 'PRODUCT_1';
        }
        $pars['act_name'] = $actdetail['red_name'] ? $actdetail['red_name'] : $api['red_name'];
        $pars['remark'] = '恭喜,您的' . $money . '元红包已经发放，请注意查收';
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$api['password']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CURLOPT_SSLCERT'] = MB_ROOT . '/cert/apiclient_cert.pem.' . $uniacid;
        $extras['CURLOPT_SSLKEY'] = MB_ROOT . '/cert/apiclient_key.pem.' . $uniacid;
        $procResult = array("sta" => 0);
        $resp = ihttp_request($url, $xml, $extras);
        if (is_error($resp)) {
            $setting = $this->module['config'];
            $setting['api']['error'] = $resp['message'];
            $this->saveSettings($setting);
            $procResult['message'] = $resp['message'];
        } else {
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new DOMDocument();
            if ($dom->loadXML($xml)) {
                $xpath = new DOMXPath($dom);
                $mch_billno = $xpath->evaluate('string(//xml/mch_billno)');
                $send_listid = $xpath->evaluate('string(//xml/send_listid)');
                $code = $xpath->evaluate('string(//xml/return_code)');
                $ret = $xpath->evaluate('string(//xml/result_code)');
                if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                    $setting = $this->module['config'];
                    $setting['api']['error'] = '';
                    $procResult['sta'] = 1;
                    $procResult['mch_billno'] = $mch_billno;
                    $procResult['send_listid'] = $send_listid;
                    $this->saveSettings($setting);
                } else {
                    $error = $xpath->evaluate('string(//xml/err_code_des)');
                    $setting = $this->module['config'];
                    $setting['api']['error'] = $error;
                    $this->saveSettings($setting);
                    $procResult['message'] = $error;
                }
            } else {
                $procResult['message'] = 'error response';
            }
        }
        return $procResult;
    }

    public function sendSubRed($openid, $money, $trade_no, $actdetail)
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        load()->func('communication');
        $pars = array();
        $cfg = $this->module['config'];
        $api = $cfg['api'];
        $pars['nonce_str'] = random(32);
        $mchid_s = $this->data_decrypt($api['mchid_sl'], $api['ticket']);
        $pars['mch_billno'] = $trade_no ? $trade_no : $mchid_s . date('YmdHis') . rand(1000, 9999);
        $pars['mch_id'] = $mchid_s;
        if ($api['sub_mch_id']) {
            $pars['sub_mch_id'] = $api['sub_mch_id'];
            $pars['msgappid'] = $api['msgappid'] ? $api['msgappid'] : $api['appid'];
            if ($api['consume_mch_id'] == 1) {
                $pars['consume_mch_id'] = $mchid_s;
            }
        }
        $pars['wxappid'] = $api['appid'];
        $pars['send_name'] = $actdetail['send_name'] ? $actdetail['send_name'] : $api['send_name'];
        $pars['re_openid'] = $openid;
        $pars['total_amount'] = floatval($money) * 100;
        $pars['total_num'] = 1;
        $pars['wishing'] = $actdetail['wish'] ? $actdetail['wish'] : $api['wish'];
        $pars['client_ip'] = $api['ip'];
        if (!empty($api['scene_red'])) {
            $pars['scene_id'] = $api['scene_red'];
        }
        $pars['act_name'] = $actdetail['red_name'] ? $actdetail['red_name'] : $api['red_name'];
        $pars['remark'] = '恭喜,您的' . $money . '元红包已经发放，请注意查收';
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$api['password']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CURLOPT_SSLCERT'] = MB_ROOT . '/cert/apiclient_cert.pem.' . $uniacid;
        $extras['CURLOPT_SSLKEY'] = MB_ROOT . '/cert/apiclient_key.pem.' . $uniacid;
        $procResult = array("sta" => 0);
        $resp = ihttp_request($url, $xml, $extras);
        if (is_error($resp)) {
            $setting = $this->module['config'];
            $setting['api']['error'] = $resp['message'];
            $this->saveSettings($setting);
            $procResult['message'] = $resp['message'];
        } else {
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new DOMDocument();
            if ($dom->loadXML($xml)) {
                $xpath = new DOMXPath($dom);
                $mch_billno = $xpath->evaluate('string(//xml/mch_billno)');
                $send_listid = $xpath->evaluate('string(//xml/send_listid)');
                $code = $xpath->evaluate('string(//xml/return_code)');
                $ret = $xpath->evaluate('string(//xml/result_code)');
                if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                    $setting = $this->module['config'];
                    $setting['api']['error'] = '';
                    $procResult['sta'] = 1;
                    $procResult['mch_billno'] = $mch_billno;
                    $procResult['send_listid'] = $send_listid;
                    $this->saveSettings($setting);
                } else {
                    $error = $xpath->evaluate('string(//xml/err_code_des)');
                    $setting = $this->module['config'];
                    $setting['api']['error'] = $error;
                    $this->saveSettings($setting);
                    $procResult['message'] = $error;
                }
            } else {
                $procResult['message'] = 'error response';
            }
        }
        return $procResult;
    }

    public function rotate($filename, $degrees)
    {
        $temp = array(1 => "gif", 2 => "jpeg", 3 => "png", 4 => "jpg");
        list($fw, $fh, $tmp) = getimagesize($filename);
        if (!$temp[$tmp]) {
            return false;
        }
        $tmp = $temp[$tmp];
        $infunc = "imagecreatefrom{$tmp}";
        $outfunc = "image{$tmp}";
        $source = $infunc($filename);
        $rotate = imagerotate($source, $degrees, 0);
        return $outfunc($rotate, $filename);
    }

    public function image_resize($f, $t, $position)
    {
        $temp = array(1 => "gif", 2 => "jpeg", 3 => "png", 4 => "jpg");
        list($fw, $fh, $tmp) = getimagesize($f);
        if (!$temp[$tmp]) {
            return false;
        }
        $tmp = $temp[$tmp];
        $infunc = "imagecreatefrom{$tmp}";
        $outfunc = "image{$tmp}";
        $fimg = $infunc($f);
        $timg = imagecreatetruecolor($position['detect_width'], $position['detect_height']);
        imagecopy($timg, $fimg, 0, 0, $position['detect_left'], $position['detect_top'], $position['detect_width'], $position['detect_height']);
        if ($outfunc($timg, $t)) {
            if ($fh > $fw) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return false;
        }
    }

    public function image_recreate($source, $target)
    {
        load()->func('file');
        if (!file_exists($source)) {
            return false;
        }
        $temp = array(1 => "gif", 2 => "jpeg", 3 => "png", 4 => "jpg");
        list($fw, $fh, $tmp) = getimagesize($source);
        if (!$temp[$tmp]) {
            return false;
        }
        $tmp = $temp[$tmp];
        $infunc = "imagecreatefrom{$tmp}";
        $outfunc = "image{$tmp}";
        $image = $infunc($source);
        if (!isset($image)) {
            return false;
        }
        $newwidth = $source_w = $fw;
        $newheight = $source_h = $fh;
        if ($source_w > 400 || $source_h > 400) {
            $widthratio = 400 / $source_w;
            $heightratio = 400 / $source_h;
            if ($widthratio < $heightratio) {
                $ratio = $widthratio;
            } else {
                $ratio = $heightratio;
            }
            $newwidth = $source_w * $ratio;
            $newheight = $source_h * $ratio;
        }
        $target_img = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($target_img, $image, 0, 0, 0, 0, $newwidth, $newheight, $source_w, $source_h);
        if (!file_exists(dirname($target))) {
            if (function_exists('mkdirs')) {
                mkdirs(dirname($target));
            } else {
                mkdir(dirname($target), 0777, true);
            }
        }
        if ($tmp == 'png') {
            $outfunc($target_img, $target, 9);
        } else {
            $outfunc($target_img, $target, 50);
        }
        return file_exists($target);
    }

    public function passport_key($str, $encrypt_key)
    {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = '';
        $i = 0;
        while ($i < strlen($str)) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $str[$i] ^ $encrypt_key[$ctr++];
            $i++;
        }
        return $tmp;
    }

    public function data_decrypt($str, $key)
    {
        $str = $this->passport_key(base64_decode($str), $key);
        $tmp = '';
        $i = 0;
        while ($i < strlen($str)) {
            $md5 = $str[$i];
            $tmp .= $str[++$i] ^ $md5;
            $i++;
        }
        return $tmp;
    }

    public function get_shoptoken($uniacid, $shopid)
    {
        return md5(sha1('uru59jj' . $uniacid . $shopid . '558oo8jhhyye'));
    }

    public function check_shop($shopid, $token, $shop)
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        if ($this->get_shoptoken($uniacid, $shopid) != $token) {
            $this->show_error('参数错误', 'error');
        }
        if (empty($shop)) {
            $this->show_error('参数错误：商家信息不存在', 'error');
        }
        if ($shop['time_open'] && $shop['begintime'] && $_W['timestamp'] < $shop['begintime']) {
            $this->show_error('门店授权开始时间未到', 'error');
        }
        if ($shop['time_open'] && $shop['endtime'] && $_W['timestamp'] > $shop['endtime']) {
            $this->show_error('门店授权时间已过', 'error');
        }
        session_start();
        if ($_SESSION['qrcode_manager_user']) {
            $user = pdo_fetch('SELECT * FROM ' . tablename(TABLE_MANAGER) . " WHERE uniacid = '{$uniacid}' AND shopid = '{$shopid}' AND username = '{$_SESSION['qrcode_manager_user']['username']}'");
            if ($user) {
                if ($_SESSION['qrcode_manager_user']['power'] != $user['power']) {
                    $_SESSION['qrcode_manager_user'] = null;
                    return false;
                } else {
                    return $_SESSION['qrcode_manager_user'];
                }
            } else {
                $_SESSION['qrcode_manager_user'] = null;
                return false;
            }
        }
        $openid = $_W['openid'];
        if ($openid) {
            $user = pdo_fetch('SELECT * FROM ' . tablename(TABLE_MANAGER) . " WHERE uniacid = '{$uniacid}' AND shopid = '{$shopid}' AND openid = '{$openid}'");
            if ($user) {
                unset($user['password']);
                return $user;
            }
        }
        return false;
    }

    public function get_coupons($activity)
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_W['openid'];
        if (empty($activity['sid']) || empty($activity['coupon_open']) || empty($activity['cid'])) {
            return false;
        }
        $coupon_info = array();
        $coupon_info[0] = pdo_fetch('SELECT * FROM ' . tablename(TABLE_SHOP_COUPON) . ' WHERE id = :id AND status=1', array(":id" => $activity['cid']));
        $coupon_count = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename(TABLE_COUPON) . ' WHERE cid = :cid AND status=1', array(":cid" => $activity['cid']));
        $coupon_count_user = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename(TABLE_COUPON) . ' WHERE cid = :cid AND openid = :openid AND (coupon_friend=0 OR coupon_friend=3) AND status=1', array(":openid" => $openid, ":cid" => $activity['cid']));
        if (empty($coupon_info[0]) || $coupon_info[0]['coupon_probability'] > 0 || $coupon_info[0]['coupon_num'] && $coupon_count >= $coupon_info[0]['coupon_num'] || $coupon_info[0]['coupon_times'] && $coupon_count_user >= $coupon_info[0]['coupon_times']) {
            return false;
        }
        if ($coupon_info[0]['coupon_validity']) {
            $expiration = json_decode($coupon_info[0]['coupon_validity'], true);
            if ($expiration['time_type'] == 1 && ($_W['timestamp'] < strtotime($expiration['start']) || $_W['timestamp'] > strtotime($expiration['end']))) {
                return false;
            }
        }
        $coupon_info[0]['shop_info'] = pdo_fetch('SELECT * FROM ' . tablename(TABLE_SHOP) . ' WHERE id = :shopid', array(":shopid" => $activity['sid']));
        if ($activity['coupon_deputy_num'] > 0) {
            $deputy_shop_list = pdo_fetchall('SELECT * FROM ' . tablename(TABLE_SHOP_COUPON) . ' WHERE shopid=:sid AND id != :id AND status=1 ORDER BY id DESC', array(":id" => $activity['cid'], ":sid" => $activity['sid']));
            if ($deputy_shop_list) {
                $i = 1;
                foreach ($deputy_shop_list as $val) {
                    $coupon_count = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename(TABLE_COUPON) . ' WHERE cid = :cid AND status!=2', array(":cid" => $val['id']));
                    $coupon_count_user = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename(TABLE_COUPON) . ' WHERE cid = :cid AND openid = :openid AND (coupon_friend=0 OR coupon_friend=3) AND status!=2', array(":openid" => $openid, ":cid" => $val['id']));
                    if (!(empty($val) || $val['coupon_probability'] > 0 || $val['coupon_num'] && $coupon_count >= $val['coupon_num'] || $val['coupon_times'] && $coupon_count_user >= $val['coupon_times'])) {
                        if (!$val['coupon_validity']) {
                            $coupon_info['deputy' . $i] = $val;
                            $coupon_info['deputy' . $i]['shop_info'] = $coupon_info[0]['shop_info'];
                            if (!($i >= $activity['coupon_deputy_num'])) {
                                $i++;
                            }
                            break;
                        } else {
                            $expiration = json_decode($val['coupon_validity'], true);
                            if (!($expiration['time_type'] == 1 && ($_W['timestamp'] < strtotime($expiration['start']) || $_W['timestamp'] > strtotime($expiration['end'])))) {
                                break;
                            }
                        }
                    }
                }
            }
        }
        if ($activity['pcid']) {
            $coupon_info_p = pdo_fetch('SELECT * FROM ' . tablename(TABLE_SHOP_COUPON) . ' WHERE id = :id AND coupon_probability>0 AND status=1', array(":id" => $activity['pcid']));
            if ($coupon_info_p && $coupon_info_p['coupon_probability'] > 0) {
                $coupon_count_p = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename(TABLE_COUPON) . ' WHERE cid = :cid AND status!=2', array(":cid" => $activity['pcid']));
                $coupon_count_user_p = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename(TABLE_COUPON) . ' WHERE cid = :cid AND openid = :openid AND coupon_friend=2 AND status!=2', array(":openid" => $openid, ":cid" => $activity['pcid']));
                if ((empty($coupon_info_p['coupon_num']) || $coupon_info_p['coupon_num'] && $coupon_count_p < $coupon_info_p['coupon_num']) && (empty($coupon_info_p['coupon_times']) || $coupon_info_p['coupon_times'] && $coupon_count_user_p < $coupon_info_p['coupon_times'])) {
                    if ($coupon_info_p['coupon_validity']) {
                        $expiration = json_decode($coupon_info_p['coupon_validity'], true);
                        if ($expiration['time_type'] == 2 || ($expiration['time_type'] == 1 && $_W['timestamp'] >= strtotime($expiration['start']) || $_W['timestamp'] <= strtotime($expiration['end']))) {
                            $temp_rand = rand(1, 10000);
                            if ($temp_rand <= $coupon_info_p['coupon_probability']) {
                                $coupon_info['pcid'] = $coupon_info_p;
                                $coupon_info['pcid']['shop_info'] = $coupon_info[0]['shop_info'];
                            }
                        }
                    }
                }
            }
        }
        if (empty($activity['coupon_circle'])) {
            return $coupon_info;
        }
        $circle_shop_list = pdo_fetchall('SELECT * FROM ' . tablename(TABLE_SHOP) . " WHERE circleid='{$coupon_info[0]['shop_info']['circleid']}' AND id!='{$activity['sid']}' order by coupon_sort DESC");
        if ($circle_shop_list) {
            $j = 1;
            foreach ($circle_shop_list as $val) {
                $coupon_circle = pdo_fetch('SELECT * FROM ' . tablename(TABLE_SHOP_COUPON) . ' WHERE shopid = :id AND coupon_friend=1 AND status=1', array(":id" => $val['id']));
                if (!empty($coupon_circle)) {
                    if (!$coupon_circle['coupon_validity']) {
                        $coupon_count_circle = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename(TABLE_COUPON) . ' WHERE cid = :cid AND status!=2', array(":cid" => $coupon_circle['id']));
                        $coupon_count_user_circle = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename(TABLE_COUPON) . ' WHERE cid = :cid AND openid = :openid AND coupon_friend=1 AND status!=2', array(":openid" => $openid, ":cid" => $coupon_circle['id']));
                        if (!($coupon_circle['coupon_num'] && $coupon_count_circle >= $coupon_circle['coupon_num'] || $coupon_circle['friend_coupon_times'] && $coupon_count_user_circle >= $coupon_circle['friend_coupon_times'])) {
                            $coupon_info[$j] = $coupon_circle;
                            $coupon_info[$j]['shop_info'] = $val;
                            if (!($activity['coupon_circle_num'] && $j >= $activity['coupon_circle_num'])) {
                                $j++;
                            }
                            break;
                        }
                    } else {
                        $expiration_circle = json_decode($coupon_circle['coupon_validity'], true);
                        if (!($expiration_circle['time_type'] == 1 && (time() < strtotime($expiration_circle['start']) || time() > strtotime($expiration_circle['end'])))) {
                        }
                    }
                }
            }
        }
        return $coupon_info;
    }

    public function send_temp_ms($data)
    {
        global $_W;
        load()->classs('weixin.account');
        if ($_W['account']['level'] > 3) {
            $accObj = WeiXinAccount::create($_W['account']);
        } else {
            if ($_W['oauth_account']['level'] > 3) {
                $accObj = WeiXinAccount::create($_W['oauth_account']);
            } else {
                $accObj = WeiXinAccount::create($_W['account']);
            }
        }
        $access_token = $accObj->fetch_available_token();
        $tpl_url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=%s';
        $url = sprintf($tpl_url, $access_token);
        $response = ihttp_request($url, $data);
        if (is_error($response)) {
            $data_res['sta'] = 0;
            $data_res['error'] = "访问公众平台接口失败, 错误: {$response['message']}";
            return json_encode($data_res);
        }
        $result = @json_decode($response['content'], true);
        if (empty($result)) {
            $data_res['sta'] = 0;
            $data_res['error'] = "接口调用失败, 元数据: {$response['meta']}";
            return json_encode($data_res);
        } else {
            if (!empty($result['errcode'])) {
                $data_res['sta'] = 0;
                $data_res['error'] = "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']}";
                return json_encode($data_res);
            }
        }
        $data_res['sta'] = 1;
        return json_encode($data_res);
    }

    public function get_ads($position, $aid)
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $where = " position='{$position}' AND uniacid='{$uniacid}' AND status=1 AND {$_W['timestamp']}>=start_time AND end_time>={$_W['timestamp']}";
        if ($aid) {
            $activity_info = pdo_fetch('SELECT id,sid FROM ' . tablename(TABLE_ACTIVITY) . ' WHERE id = :id', array(":id" => $aid));
            if ($activity_info['sid']) {
                $shop_info = pdo_fetch('SELECT id,circleid FROM ' . tablename(TABLE_SHOP) . ' WHERE id = :id', array(":id" => $activity_info['sid']));
            }
        }
        if (!pdo_tableexists('crad_qrcode_red_adcenter')) {
            return false;
        }
        $lists_all = pdo_fetchall('SELECT * FROM ' . tablename('crad_qrcode_red_adcenter') . " WHERE {$where}");
        if (empty($lists_all)) {
            return false;
        }
        $max = 1;
        $min = 100;
        foreach ($lists_all as $value) {
            $max = max($max, $value['weight']);
            $min = min($min, $value['weight']);
            $shopids = explode(',', $value['shopids']);
            $aids = explode(',', $value['aids']);
            if (!($value['user_type'] == 2 && $value['circleid'] != $shop_info['circleid'] || $value['user_type'] == 3 && !in_array($aid, $aids) || $value['user_type'] == 4 && !in_array($shop_info['id'], $shopids))) {
                if (!($value['total_num'] && $value['total_num'] <= $value['show_num'])) {
                    $temp_ad[] = $value;
                }
            }
        }
        if (empty($temp_ad)) {
            return false;
        }
        $rand_weight = rand($min, $max);
        foreach ($temp_ad as $value) {
            if (!($value['weight'] < $rand_weight)) {
                $ad_list[] = $value;
            }
        }
        if (empty($ad_list)) {
            return false;
        }
        $temp = rand(0, count($ad_list) - 1);
        return $ad_list[$temp];
    }

    public function get_superqrcode_rules($sid, $jump_type, $last_rid)
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_W['openid'];
        $where = "uniacid='" . $uniacid . "' AND status!=1 AND sid='" . $sid . "'";
        if (empty($jump_type)) {
            $where .= " ORDER BY id ASC";
        }
        $lists_all = pdo_fetchall("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode_rules") . " WHERE " . $where);
        $max = 1;
        $min = 100;
        $today_start = strtotime(date('Y-m-d'));
        foreach ($lists_all as $value) {
            if (!($value['num'] && $value['scan_num'] >= $value['num'])) {
                if (!($value['num_day'] && $value['scan_num_day'] >= $value['num_day'])) {
                    $total_user = pdo_fetchcolumn("select COUNT(*) from " . tablename("crad_qrcode_red_superqrcode_log") . " WHERE  rid='" . $value["id"] . "' AND openid='" . $openid . "'");
                    $total_user_day = pdo_fetchcolumn("select COUNT(*) from " . tablename("crad_qrcode_red_superqrcode_log") . " WHERE rid='" . $value["id"] . "' AND openid='" . $openid . "' AND createtime>" . $today_start);
                    if (!($value['num_user'] && $total_user >= $value['num_user'])) {
                        if (!($value['num_day_user'] && $total_user_day >= $value['num_day_user'])) {
                            if (empty($jump_type) && $value['id'] > $last_rid) {
                                return $value;
                            }
                            $temp_rules[] = $value;
                            $max = max($max, $value['weight']);
                            $min = min($min, $value['weight']);
                        }
                    }
                }
            }
        }
        if (empty($temp_rules)) {
            return false;
        }
        if (empty($jump_type)) {
            return $temp_rules[0];
        }
        $rand_weight = rand($min, $max);
        foreach ($temp_rules as $value) {
            if (!($value['weight'] < $rand_weight)) {
                $rule_list[] = $value;
            }
        }
        if (empty($rule_list)) {
            return false;
        }
        $temp = rand(0, count($rule_list) - 1);
        return $rule_list[$temp];
    }

    public function send_ali_sms($settings, $tel, $code)
    {
        include IA_ROOT . '/addons/crad_qrcode_red/libs/aliyunSms.class.php';
        set_time_limit(0);
        $params = array();
        $security = false;
        $accessKeyId = $settings['ali_appkey'];
        $accessKeySecret = $settings['ali_secretkey'];
        $params['PhoneNumbers'] = $tel;
        $params['SignName'] = $settings['ali_smssign'];
        $params['TemplateCode'] = $settings['ali_smstemplate'];
        $params['TemplateParam'] = array("code" => $code);
        if (!empty($params['TemplateParam']) && is_array($params['TemplateParam'])) {
            $params['TemplateParam'] = json_encode($params['TemplateParam'], JSON_UNESCAPED_UNICODE);
        }
        $helper = new SignatureHelper();
        $content = $helper->request($accessKeyId, $accessKeySecret, 'dysmsapi.aliyuncs.com', array_merge($params, array("RegionId" => "cn-hangzhou", "Action" => "SendSms", "Version" => "2017-05-25")), $security);
        $content = json_encode($content, JSON_FORCE_OBJECT);
        $content = json_decode($content, true);
        return $content;
    }

    public function BuildCardExt($coupon)
    {
        load()->classs('coupon');
        $coupon_api = new Coupon();
        $time = TIMESTAMP;
        $sign = array($coupon['card_id'], $time);
        $signature = $coupon_api->SignatureCard($sign);
        if (is_error($signature)) {
            return $signature;
        }
        $cardExt = array("timestamp" => $time, "signature" => $signature);
        $cardExt = json_encode($cardExt);
        return array("card_id" => $coupon['card_id'], "card_ext" => $cardExt);
    }
    
    public function write_log($data){
        $url = IA_ROOT . '/addons/crad_qrcode_red/request_log.txt';  
        $fp = fopen($url,"a");//打开文件资源通道 不存在则自动创建       
        fwrite($fp,var_export($data,true)."\r\n");//写入文件
        fclose($fp);//关闭资源通道
    }
}
