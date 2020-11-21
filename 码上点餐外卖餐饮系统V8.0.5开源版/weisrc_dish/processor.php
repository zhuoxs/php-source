<?php
/**
 * 微点餐
 *
 * 作者:迷失卍国度
 *
 * qq : 15595755
 */
defined('IN_IA') or exit('Access Denied');
include 'huanghe_function.php';

class weisrc_dishModuleProcessor extends WeModuleProcessor
{
    public $name = 'weisrc_dishModuleProcessor';

    public function respond()
    {
        global $_W;
        $rid = $this->rule;
        $curopenid = $this->message['from'];

        $weid = $_W['uniacid'];
        load()->model('mc');
        load()->classs('weixin.account');
        $setting = $this->getSetting();

        //获取昵称，坑爹的mc_fansinfo，用mc_fetch !不能实时获取到新关注的粉丝昵称
        $mc = mc_fetch($curopenid);
        $tip = '～～～';
        if (empty($mc['nickname']) || empty($mc['avatar']) || empty($mc['gender'])) {
            load()->classs('account');
            load()->func('communication');
            $account_api = WeAccount::create();
            $accToken = $account_api->getAccessToken();

            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$accToken}&openid={$curopenid}&lang=zh_CN";
            $json = ihttp_get($url);
            $userinfo = @json_decode($json['content'], true);
            if ($userinfo['nickname']) {
                $mc['nickname'] = $userinfo['nickname'];
            }
            if ($userinfo['headimgurl']) {
                $mc['avatar'] = $userinfo['headimgurl'];
            }
            if ($userinfo['sex']) {
                $mc['gender'] = $userinfo['sex'];
            }
            $tip = '。。。';
        }

        //关键字
        if ($this->message['msgtype'] == 'text' || $this->message['event'] == 'CLICK') {
            $reply = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_poster") . " WHERE weid = :weid ORDER BY `id` DESC",
                array(':weid' => $weid));

            if ($setting['is_commission'] == 1) { //开启分销
//                if ($setting['commission_mode'] == 2) { //代理商模式
//                    $share = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $curopenid, ':weid' => $_W['uniacid']));
//                    if ($share['is_commission'] == 2) { //代理商
//                        $img = $this->createPoster($mc, $reply, $curopenid);
//                        $media_id = $this->uploadImage($img);
//                        if ($reply['first_info']) {
//                            $info = str_replace('#时间#', date('Y-m-d H:i', time() + 30 * 24 * 3600), $reply['first_info']);
//                            $info = str_replace('#昵称#', $mc['nickname'], $info);
//                            $this->postText($curopenid, $info);
//
//                        }
//                        if ($reply['miss_wait']) {
//                            sleep(1);
//                            $miss_wait = str_replace('#昵称#', $mc['nickname'], $reply['miss_wait']);
//                            $this->postText($curopenid, $miss_wait);
//                        }
//                        $this->sendImage($curopenid, $media_id);
//                    } else {
//                        $this->postText($curopenid, '您还不是代理商，不能生成专属二维码！');
//                    }
//                }

                $img = $this->createPoster($mc, $reply, $curopenid);
                $media_id = $this->uploadImage($img);
                if ($reply['first_info']) {
                    $info = str_replace('#时间#', date('Y-m-d H:i', time() + 30 * 24 * 3600), $reply['first_info']);
                    $info = str_replace('#昵称#', $mc['nickname'], $info);
                    $this->postText($curopenid, $info);

                }
                if ($reply['miss_wait']) {
                    sleep(1);
                    $miss_wait = str_replace('#昵称#', $mc['nickname'], $reply['miss_wait']);
                    $this->postText($curopenid, $miss_wait);
                }
                $this->sendImage($curopenid, $media_id);


            } else {
                $this->postText($curopenid, '分销功能已关闭！');
            }
        }

        //扫码
        if ($this->message['msgtype'] == 'event' && $this->message['event'] != 'CLICK') {
            $scene_str = str_replace('qrscene_', '', $this->message['eventkey']); //场景

            if ($this->message['event'] == 'subscribe') { //关注

            } elseif ($this->message['event'] == 'SCAN') { //扫描

            }

            if ($scene_str) {
                //餐桌
                if (strstr($scene_str, 'table')) {
                    $picurl = "http://cdn.w7.cc/images/2018/03/08/15204854295aa0c4353ec06_xb1SgFsbxC2b.jpg";
                    $tabledesc = "感谢您的使用！";

                    if ($setting['table_cover']) {
                        $picurl = tomedia($setting['table_cover']);
                    }
                    if ($setting['table_desc']) {
                        $tabledesc = $setting['table_desc'];
                    }

                    $tablesid = str_replace('table_', '', $scene_str);

                    $table = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_tables") . " WHERE id=:id LIMIT 1",
                        array(':id' => $tablesid));
                    if ($table) {
                        $url = $this->createMobileUrl('waplist', array('mode' => 1, 'storeid' => $table['storeid'], 'tablesid' => $table['id']));
//                        $news = array();
//                        $news[] = array(
//                            'Title' => '桌号-' . $table['title'],
//                            'Description' => $tabledesc,
//                            'PicUrl' => $picurl,
//                            'Url' => $url
//                        );
//                        $news[] = array(
//                            'Title' => $tabledesc,
//                            'Description' => $tabledesc,
//                            'PicUrl' => $picurl,
//                            'Url' => $url
//                        );
//                        return $this->respNews($news);
//


                        $response = array();
                        $response['FromUserName'] = $this->message['to'];
                        $response['ToUserName'] = $this->message['from'];
                        $response['MsgType'] = 'news';
                        $response['ArticleCount'] = 2;
                        $response['Articles'] = array();
                        $response['Articles'][] = array(
                            'Title' => '桌号-' . $table['title'],
                            'Description' => $tabledesc,
                            'PicUrl' => $picurl,
                            'Url' => $this->buildSiteUrl($url),
                            'TagName' => 'item'
                        );
                        $response['Articles'][] = array(
                            'Title' => $tabledesc,
                            'Description' => $tabledesc,
                            'PicUrl' => $picurl,
                            'Url' => $this->buildSiteUrl($url),
                            'TagName' => 'item'
                        );
                        return $response;



//                        return $this->respNews(array(
//                            'Title' => '桌号-' . $table['title'],
//                            'Description' => $tabledesc,
//                            'PicUrl' => $picurl,
//                            'Url' => $url,
//                        ));

                    } else {
                        file_put_contents(IA_ROOT . "/addons/weisrc_dish/debug.log", var_export(date("Y-m-d H:i:s",
                                    TIMESTAMP). $scene_str, true) . PHP_EOL, FILE_APPEND);
                        $this->postText($curopenid, '访问的桌台不存在，请您重新扫码');
                    }
                } elseif (strstr($scene_str, 'savewine')) {
                    //存酒
                    $picurl = "http://cdn.w7.cc/images/2018/03/08/15204854295aa0c4353ec06_xb1SgFsbxC2b.jpg";
                    $tabledesc = "感谢您的使用！";

                    if ($setting['table_cover']) {
                        $picurl = tomedia($setting['table_cover']);
                    }
                    if ($setting['table_desc']) {
                        $tabledesc = $setting['table_desc'];
                    }
                    $tablesid = str_replace('savewine_', '', $scene_str);
                    $tablesid = intval($tablesid);
                    $table = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_tables") . " WHERE id=:id LIMIT 1", array(':id' => $tablesid));
                    if ($table) {
                        $url = $this->createMobileUrl('savewineform', array('storeid' => $table['storeid'], 'tablesid' => $table['id']));
//                        $news = array();
//                        $news[] = array(
//                            'Title' => '桌号-' . $table['title'],
//                            'Description' => $tabledesc,
//                            'PicUrl' => $picurl,
//                            'Url' => $url
//                        );
//                        $news[] = array(
//                            'Title' => $tabledesc,
//                            'Description' => $tabledesc,
//                            'PicUrl' => $picurl,
//                            'Url' => $url
//                        );
//                        return $this->respNews($news);


                        $response = array();
                        $response['FromUserName'] = $this->message['to'];
                        $response['ToUserName'] = $this->message['from'];
                        $response['MsgType'] = 'news';
                        $response['ArticleCount'] = 2;
                        $response['Articles'] = array();
                        $response['Articles'][] = array(
                            'Title' => '桌号-' . $table['title'],
                            'Description' => $tabledesc,
                            'PicUrl' => $picurl,
                            'Url' => $this->buildSiteUrl($url),
                            'TagName' => 'item'
                        );
                        $response['Articles'][] = array(
                            'Title' => $tabledesc,
                            'Description' => $tabledesc,
                            'PicUrl' => $picurl,
                            'Url' => $this->buildSiteUrl($url),
                            'TagName' => 'item'
                        );
                        return $response;

                    } else {
                        file_put_contents(IA_ROOT . "/addons/weisrc_dish/debug.log", var_export(date("Y-m-d H:i:s", TIMESTAMP). $scene_str, true) . PHP_EOL, FILE_APPEND);
                        $this->postText($curopenid, '访问的桌台不存在，请您重新扫码！');
                    }
                } else {
                    //分销
                    $agent = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE scene_str=:scene_str AND weid=:weid LIMIT 1", array(':scene_str' => $scene_str, ':weid' => $_W['uniacid']));

                    $fans = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $curopenid, ':weid' => $_W['uniacid']));

                    if ($agent['from_user'] == $curopenid) {
                        $this->postText($curopenid, '这是您的推广二维码！');
                        exit;
                    }

                    if ($agent) {
                        $agentid = $agent['id'];
                        $agent = $this->getFansById($agentid);
//                        if ($setting['commission_mode'] == 2) { //代理商模式
//                            if ($agent['is_commission'] != 2) {//用户不是代理商重新查找
//                                $agent = $this->getFansById($agent['agentid']);
//                                $agentid = intval($agent['id']);
//                            }
//                        }

                        if (!empty($agent['agentid'])) {
                            $agentid2 = intval($agent['agentid']);
                            $agent2 = $this->getFansById($agentid2);
                            if (!empty($agent2['agentid'])) {
                                $agentid3 = intval($agent2['agentid']);
                            }
                        }

                        if (empty($fans)) {
                            $insert = array(
                                'weid' => $weid,
                                'from_user' => $curopenid,
                                'nickname' => $mc['nickname'],
                                'headimgurl' => $mc['avatar'],
                                'agentid' => $agentid,
                                'agentid2' => $agentid2,
                                'agentid3' => $agentid3,
                                'dateline' => TIMESTAMP
                            );
                            pdo_insert("weisrc_dish_fans", $insert);

                            if (!empty($mc['nickname'])) {
                                $msg = $mc['nickname'] . "成为您的下级成员！";
                                $this->postText($agent['from_user'], $msg);
                            } else {
                                $msg = $curopenid . "取不到用户信息！" . $tip;
                                $this->postText($agent['from_user'], $msg);
                            }
                        } else {
                            $update = array(
                                'nickname' => $mc['nickname'],
                                'headimgurl' => $mc['avatar']
                            );
                            pdo_update("weisrc_dish_fans", $update, array('id' => $fans['id']));

                            $msg = $mc['nickname'] . "访问您的二维码！" . $tip;
                            $this->postText($agent['from_user'], $msg);
                        }
                    } else {
                        $this->postText($curopenid, '您访问的代理商不存在！' . $this->message['event']);
                    }
                }
            }
        }
    }

    public function sendImage($openid, $media_id)
    {
        $data = array("touser" => $openid, "msgtype" => "image", "image" => array("media_id" => $media_id));
        $ret = $this->postRes($this->getAccessToken(), json_encode($data));
        return $ret;
    }

    private function uploadImage($img)
    {
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $this->getAccessToken() . "&type=image";
        $post = array('media' => '@' . $img);
        load()->func('communication');
        $ret = ihttp_request($url, $post);
        $content = @json_decode($ret['content'], true);
        return $content['media_id'];
    }

    private $sceneid = 0;
    private $Qrcode = "/addons/weisrc_dish/qrcode/mposter#sid#.jpg";

    private function createPoster($mc, $reply, $openid)
    {
        global $_W;
        $bg = $reply['bg'];
//        $rid = $reply['rid'];

        $share = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $openid, ':weid' => $_W['uniacid']));


        if (empty($share)) {
            $inserts = array(
                'weid' => $_W['uniacid'],
                'from_user' => $openid,
                'nickname' => $mc['nickname'],
                'headimgurl' => $mc['avatar'],
                'dateline' => TIMESTAMP
            );
            pdo_insert("weisrc_dish_fans", $inserts);
            $share['id'] = pdo_insertid();
            $share = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $openid, ':weid' => $_W['uniacid']));
        } else {
//            pdo_update('weisrc_dish_fans', array('updatetime' => time()), array('id' => $share['id']));
        }

        $qrcode = str_replace('#sid#', $share['id'], IA_ROOT . $this->Qrcode);
        $data = json_decode(str_replace('&quot;', "'", $reply['data']), true);
        set_time_limit(0);
        @ini_set('memory_limit', '256M');
        $size = getimagesize(tomedia($bg));
        $target = imagecreatetruecolor($size[0], $size[1]);

        $bg = imagecreates(tomedia($bg));

        imagecopy($target, $bg, 0, 0, 0, 0, $size[0], $size[1]);
        imagedestroy($bg);

        foreach ($data as $value) {
            $value = trimPx($value);

            if ($value['type'] == 'qr') {

                // return $this->respText($bg);

                $setting = $this->getSetting();
                if ($setting['is_commission'] == 1) { //开启分销
//                    if ($setting['commission_mode'] == 2) { //代理商模式
//                        $scene_str = 'fxdish_' . $share['id'];
//                        if ($share['is_commission'] == 2) { //代理商
//                            if (!empty($setting['commission_keywords'])) {
//                                $qrcodedata = $this->createQrcode($setting['commission_keywords'], $scene_str, '餐饮分销' .
//                                    $scene_str);
//                                if ($qrcodedata) {
//                                    $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($qrcodedata['ticket']);
//                                    pdo_update("weisrc_dish_fans", array('scene_str' => $scene_str), array('id' => $share['id']));
//                                }
//                            }
//                        }
//                    }
                    $scene_str = 'fxdish_' . $share['id'];
                    if (!empty($setting['commission_keywords'])) {
                        $qrcodedata = $this->createQrcode($setting['commission_keywords'], $scene_str, '餐饮分销' .
                            $scene_str);
                        if ($qrcodedata) {
                            $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($qrcodedata['ticket']);
                            pdo_update("weisrc_dish_fans", array('scene_str' => $scene_str), array('id' => $share['id']));
                        }
                    }
                } else {
                    $this->postText($openid, '分销功能已关闭！');
                }
                //$url = $this->getQR($mc, $reply, $share['id']);
                file_put_contents(IA_ROOT . "/addons/weisrc_dish/debug.log", var_export(date("Y-m-d H:i:s",
                            TIMESTAMP). $url, true) . PHP_EOL, FILE_APPEND);
                if (!empty($url)) {
//                    $img = IA_ROOT . "/addons/weisrc_dish/temp_qrcode.png";
//                    include "phpqrcode.php";
//                    $errorCorrectionLevel = "L";
//                    $matrixPointSize = "4";
//                    QRcode::png($url, $img, $errorCorrectionLevel, $matrixPointSize, 2);
//                    mergeImage($target, $img, array('left' => $value['left'], 'top' => $value['top'], 'width' => $value['width'], 'height' => $value['height']));
//                    @unlink($img);

                    mergeImage($target, saveImage($url), array('left' => $value['left'], 'top' => $value['top'], 'width' => $value['width'], 'height' => $value['height']));
                }
            } elseif ($value['type'] == 'img') {
                $img = saveImage($share['headimgurl']);
                mergeImage($target, $img, array('left' => $value['left'], 'top' => $value['top'], 'width' => $value['width'], 'height' => $value['height']));
                @unlink($img);
            } elseif ($value['type'] == 'name') {
                mergeText($this->modulename, $target, $mc['nickname'], array('size' => $value['size'], 'color' => $value['color'], 'left' => $value['left'], 'top' => $value['top']), $reply);
            }
        }

        imagejpeg($target, $qrcode);
        imagedestroy($target);
        return $qrcode;
    }

    //$keyword 关键字
    //$scene_str 场景值
    public function createQrcode($keyword, $scene_str, $name)
    {
        global $_W, $_GPC;
        $acid = intval($_W['acid']);
        $uniacccount = WeAccount::create($acid);
        $scene_str = trim($scene_str) ? trim($scene_str) : itoast('场景值不能为空', '', '');
        $is_exist = pdo_fetch('SELECT * FROM ' . tablename('qrcode') . ' WHERE uniacid = :uniacid AND acid = :acid AND scene_str = :scene_str AND model = 2 LIMIT 1;', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':scene_str' => $scene_str));
        if (!empty($is_exist)) {
            return $is_exist;
        }
        $barcode['action_info']['scene']['scene_str'] = $scene_str;
        $barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
        $result = $uniacccount->barCodeCreateFixed($barcode);
        if (!is_error($result)) {
            $insert = array(
                'uniacid' => $_W['uniacid'],
                'acid' => $acid,
                'qrcid' => $barcode['action_info']['scene']['scene_id'],
                'scene_str' => $barcode['action_info']['scene']['scene_str'],
                'keyword' => $keyword,
                'name' => $name,
                'model' => 2,
                'ticket' => $result['ticket'],
                'url' => $result['url'],
                'expire' => $result['expire_seconds'],
                'createtime' => TIMESTAMP,
                'status' => '1',
                'type' => 'scene',
            );
            pdo_insert('qrcode', $insert);
            return $insert;
        }
        return false;
    }

    private function getQR($mc, $reply, $sid)
    {
        global $_W;
//        $rid = $reply['rid'];
        $rid = $this->rule;

        if (empty($this->sceneid)) {
            $share = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_fans') . " WHERE id = :id", array(':id' => $sid));

            if (!empty($share['url'])) {
                $out = false;
                $qrcode = pdo_fetch('select * from ' . tablename('qrcode') . " where uniacid='{$_W['uniacid']}' and qrcid='{$share['sceneid']}' " . " and name='{$reply['title']}' and ticket='{$share['ticketid']}' and url='{$share['url']}'");
                if ($qrcode['createtime'] + $qrcode['expire'] < time()) {
                    pdo_delete('qrcode', array('id' => $qrcode['id']));
                    $out = true;
                }
                if (!$out) {
                    $this->sceneid = $share['sceneid'];
                    return $share['url'];
                }
            }
            $this->sceneid = pdo_fetchcolumn('select sceneid from ' . tablename('weisrc_dish_fans') . " where weid='{$_W['uniacid']}' order by sceneid desc limit 1");
            if (empty($this->sceneid)) {
                $this->sceneid = 5500001;
            } else {
                $this->sceneid++;
            }
            $barcode['action_info']['scene']['scene_id'] = $this->sceneid;
            load()->model('account');
            $acid = pdo_fetchcolumn('select acid from ' . tablename('account') . " where uniacid={$_W['uniacid']}");
            $uniacccount = WeAccount::create($acid);
            $time = 0;
            $barcode['action_name'] = 'QR_SCENE';
            $barcode['expire_seconds'] = 30 * 24 * 3600;
            $res = $uniacccount->barCodeCreateDisposable($barcode);
            $time = $barcode['expire_seconds'];
            $sql = "SELECT * FROM " . tablename('rule_keyword') . " WHERE `rid`=:rid LIMIT 1";
            $row = pdo_fetch($sql, array(':rid' => $rid));
            pdo_insert('qrcode', array('uniacid' => $_W['uniacid'], 'acid' => $acid, 'qrcid' => $this->sceneid, 'name' => $reply['title'], 'keyword' => $row['content'], 'model' => 1, 'ticket' => $res['ticket'], 'expire' => $time, 'createtime' => time(), 'status' => 1, 'url' => $res['url']));
            pdo_update('weisrc_dish_fans', array('sceneid' => $this->sceneid, 'ticketid' => $res['ticket'], 'url' => $res['url'], 'nickname' => base64_encode($mc['nickname']), 'headimgurl' => $share['headimgurl']), array('id' => $sid));
            return $res['url'];
        }
    }


    public function postText($openid, $text)
    {
        $post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
        $ret = $this->postRes($this->getAccessToken(), $post);
        return $ret;
    }

    private function postRes($access_token, $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        load()->func('communication');
        $ret = ihttp_request($url, $data);
        $content = @json_decode($ret['content'], true);
        return $content['errcode'];
    }

    private function getAccessToken()
    {
        global $_W;
        load()->model('account');
        $acid = $_W['acid'];
        if (empty($acid)) {
            $acid = $_W['uniacid'];
        }
        $account = WeAccount::create($acid);
        $token = $account->getAccessToken();
        return $token;
    }

    public function getFansById($id)
    {
        global $_W;
        $fans = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $id, ':weid' => $_W['uniacid']));
        return $fans;
    }

    public function getSetting()
    {
        global $_W, $_GPC;
        $setting = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_setting") . " where weid = :weid LIMIT 1", array(':weid' => $_W['uniacid']));
        return $setting;
    }

    public function isNeedSaveContext()
    {
        return false;
    }

    public function isNeedInitContext()
    {
        return 0;
    }
}
