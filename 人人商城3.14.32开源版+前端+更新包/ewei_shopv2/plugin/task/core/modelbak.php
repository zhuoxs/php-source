<?php 
if( !defined("IN_IA") ) 
{
    exit( "Access Denied" );
}

set_time_limit(0);

class TaskModel extends PluginModel
{
    public $extension = "[{\"id\":\"1\",\"taskname\":\"\\u63a8\\u8350\\u4eba\\u6570\",\"taskclass\":\"commission_member\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"commission\",\"verb\":\"\\u63a8\\u8350\",\"unit\":\"\\u4eba\"},{\"id\":\"2\",\"taskname\":\"\\u5206\\u9500\\u4f63\\u91d1\",\"taskclass\":\"commission_money\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"commission\",\"verb\":\"\\u8fbe\\u5230\",\"unit\":\"\\u5143\"},{\"id\":\"3\",\"taskname\":\"\\u5206\\u9500\\u8ba2\\u5355\",\"taskclass\":\"commission_order\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"commission\",\"verb\":\"\\u8fbe\\u5230\",\"unit\":\"\\u7b14\"},{\"id\":\"6\",\"taskname\":\"\\u8ba2\\u5355\\u6ee1\\u989d\",\"taskclass\":\"cost_enough\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"cost\",\"verb\":\"\\u6ee1\",\"unit\":\"\\u5143\"},{\"id\":\"7\",\"taskname\":\"\\u7d2f\\u8ba1\\u91d1\\u989d\",\"taskclass\":\"cost_total\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"cost\",\"verb\":\"\\u7d2f\\u8ba1\",\"unit\":\"\\u5143\"},{\"id\":\"8\",\"taskname\":\"\\u8ba2\\u5355\\u6570\\u91cf\",\"taskclass\":\"cost_count\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"cost\",\"verb\":\"\\u8fbe\\u5230\",\"unit\":\"\\u5355\"},{\"id\":\"9\",\"taskname\":\"\\u6307\\u5b9a\\u5546\\u54c1\",\"taskclass\":\"cost_goods\",\"status\":\"1\",\"classify\":\"select\",\"classify_name\":\"cost\",\"verb\":\"\\u8d2d\\u4e70\\u6307\\u5b9a\\u5546\\u54c1\",\"unit\":\"\\u4ef6\"},{\"id\":\"10\",\"taskname\":\"\\u5546\\u54c1\\u8bc4\\u4ef7\",\"taskclass\":\"cost_comment\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"cost\",\"verb\":\"\\u8bc4\\u4ef7\\u8ba2\\u5355\",\"unit\":\"\\u6b21\"},{\"id\":\"11\",\"taskname\":\"\\u7d2f\\u8ba1\\u5145\\u503c\",\"taskclass\":\"cost_rechargetotal\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"cost\",\"verb\":\"\\u8fbe\\u5230\",\"unit\":\"\\u5143\"},{\"id\":\"12\",\"taskname\":\"\\u5145\\u503c\\u6ee1\\u989d\",\"taskclass\":\"cost_rechargeenough\",\"status\":\"1\",\"classify\":\"number\",\"classify_name\":\"cost\",\"verb\":\"\\u6ee1\",\"unit\":\"\\u5143\"},{\"id\":\"13\",\"taskname\":\"\\u7ed1\\u5b9a\\u624b\\u673a\",\"taskclass\":\"member_info\",\"status\":\"1\",\"classify\":\"boole\",\"classify_name\":\"member\",\"verb\":\"\\u7ed1\\u5b9a\\u624b\\u673a\\u53f7\\uff08\\u5fc5\\u987b\\u5f00\\u542fwap\\u6216\\u5c0f\\u7a0b\\u5e8f\\uff09\",\"unit\":\"\"}]";
    public $taskType = array(  );
/**
     * 数据库注册字段
     * @var array
     */
    public $ewei_shop_task_list = array( "id", "uniacid", "displayorder", "title", "image", "type", "status", "picktype", "starttime", "endtime", "stop_type", "stop_limit", "stop_time", "stop_cycle", "repeat_type", "repeat_interval", "repeat_cycle", "demand", "reward", "followreward", "design_data", "design_bg", "goods_limit", "notice", "requiregoods", "native_data", "native_data2", "native_data3", "reward3", "reward2", "level2", "level3", "member_group", "auto_pick", "keyword_pick", "verb", "unit", "member_level" );
    public $ewei_shop_task_set = array( "uniacid", "entrance", "keyword", "cover_title", "cover_img", "cover_desc", "msg_pick", "msg_progress", "msg_finish", "msg_follow", "isnew", "bg_img", "top_notice" );
    public $ewei_shop_task_record = array( "id", "uniacid", "taskid", "tasktitle", "tasktype", "task_demand", "openid", "nickname", "picktime", "stoptime", "finishtime", "task_progress", "reward_data", "followreward_data", "taskimage", "design_data", "design_bg", "require_goods", "level1", "level2", "reward_data1", "reward_data2", "member_group", "auto_pick" );

    public function get_unread()
    {
        global $_W;
        $sql = "select count(*) from " . tablename("ewei_shop_task_reward") . " where openid = :openid and uniacid = :uniacid and `get` = 1 and `sent` = 0 and `read` = 0";
        return pdo_fetchcolumn($sql, array( ":openid" => $_W["openid"], ":uniacid" => $_W["uniacid"] ));
    }

    public function set_read()
    {
        global $_W;
        pdo_update("ewei_shop_task_reward", array( "read" => 1 ), array( "openid" => $_W["openid"], "uniacid" => $_W["uniacid"], "get" => 1, "sent" => 0, "read" => 0 ));
    }

    public function isnew()
    {
        global $_W;
        $uniacid = pdo_fetchcolumn("select uniacid from " . tablename("ewei_shop_task_set") . " where uniacid = " . $_W["uniacid"]);
        if( empty($uniacid) ) 
        {
            pdo_insert("ewei_shop_task_set", array( "uniacid" => $_W["uniacid"] ));
        }

        $this->set_read();
        return pdo_fetchcolumn("select isnew from " . tablename("ewei_shop_task_set") . " where uniacid = " . $_W["uniacid"]);
    }

    public function getSceneTicket($expire, $scene_id)
    {
        global $_W;
        global $_GPC;
        $account = m("common")->getAccount();
        $bb = "{\"expire_seconds\":" . $expire . ",\"action_info\":{\"scene\":{\"scene_id\":" . $scene_id . "}},\"action_name\":\"QR_SCENE\"}";
        $token = $account->fetch_token();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $token;
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url);
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $bb);
        $c = curl_exec($ch1);
        $result = @json_decode($c, true);
        if( !is_array($result) ) 
        {
            return false;
        }

        if( !empty($result["errcode"]) ) 
        {
            return error(-1, $result["errmsg"]);
        }

        $ticket = $result["ticket"];
        return array( "barcode" => json_decode($bb, true), "ticket" => $ticket );
    }

    public function getSceneID()
    {
        global $_W;
        $acid = $_W["acid"];
        $start = 1;
        $end = -2147483649;
        $scene_id = rand($start, $end);
        if( empty($scene_id) ) 
        {
            $scene_id = rand($start, $end);
        }

        while( 1 ) 
        {
            $count = pdo_fetchcolumn("select count(*) from " . tablename("qrcode") . " where qrcid=:qrcid and acid=:acid and model=0 limit 1", array( ":qrcid" => $scene_id, ":acid" => $acid ));
            if( $count <= 0 ) 
            {
                break;
            }

            $scene_id = rand($start, $end);
            if( empty($scene_id) ) 
            {
                $scene_id = rand($start, $end);
            }

        }
        return $scene_id;
    }

    public function getQR($poster, $member)
    {
        global $_W;
        global $_GPC;
        $acid = $_W["acid"];
        $time = time();
        $expire = $poster["days"];
        if( 86400 * 30 - 15 < $expire ) 
        {
            $expire = 86400 * 30 - 15;
        }

        $posterendtime = $time + $expire;
        $qr = pdo_fetch("select * from " . tablename("ewei_shop_task_poster_qr") . " where openid=:openid and acid=:acid and posterid=:posterid limit 1", array( ":openid" => $member["openid"], ":acid" => $acid, ":posterid" => $poster["id"] ));
        if( empty($qr) ) 
        {
            $qr["current_qrimg"] = "";
            $scene_id = $this->getSceneID();
            $result = $this->getSceneTicket($expire, $scene_id);
            if( is_error($result) ) 
            {
                return $result;
            }

            if( empty($result) ) 
            {
                return error(-1, "生成二维码失败");
            }

            $barcode = $result["barcode"];
            $ticket = $result["ticket"];
            $qrimg = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $ticket;
            $ims_qrcode = array( "uniacid" => $_W["uniacid"], "acid" => $_W["acid"], "qrcid" => $scene_id, "model" => 0, "name" => "EWEI_SHOPV2_TASK_QRCODE", "keyword" => $poster["keyword"], "expire" => $expire, "createtime" => time(), "status" => 1, "url" => $result["url"], "ticket" => $result["ticket"] );
            pdo_insert("qrcode", $ims_qrcode);
            $qr = array( "acid" => $acid, "openid" => $member["openid"], "sceneid" => $scene_id, "type" => 1, "ticket" => $result["ticket"], "qrimg" => $qrimg, "posterid" => $poster["id"], "expire" => $expire, "url" => $result["url"], "endtime" => $posterendtime );
            pdo_insert("ewei_shop_task_poster_qr", $qr);
            $qr["id"] = pdo_insertid();
        }
        else
        {
            $qr["current_qrimg"] = $qr["qrimg"];
            if( $qr["endtime"] < $time ) 
            {
                $scene_id = $qr["sceneid"];
                $result = $this->getSceneTicket($expire, $scene_id);
                if( is_error($result) ) 
                {
                    return $result;
                }

                if( empty($result) ) 
                {
                    return error(-1, "生成二维码失败");
                }

                $barcode = $result["barcode"];
                $ticket = $result["ticket"];
                $qrimg = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $ticket;
                pdo_update("qrcode", array( "ticket" => $result["ticket"], "url" => $result["url"] ), array( "acid" => $_W["acid"], "qrcid" => $scene_id ));
                pdo_update("ewei_shop_task_poster_qr", array( "ticket" => $ticket, "qrimg" => $qrimg, "url" => $result["url"], "endtime" => $posterendtime ), array( "id" => $qr["id"] ));
                $qr["ticket"] = $ticket;
                $qr["qrimg"] = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $qr["ticket"];
            }

        }

        return $qr;
    }

    public function getRealData($data)
    {
        $data["left"] = intval(str_replace("px", "", $data["left"])) * 2;
        $data["top"] = intval(str_replace("px", "", $data["top"])) * 2;
        $data["width"] = intval(str_replace("px", "", $data["width"])) * 2;
        $data["height"] = intval(str_replace("px", "", $data["height"])) * 2;
        $data["size"] = intval(str_replace("px", "", $data["size"])) * 2;
        $data["src"] = tomedia($data["src"]);
        return $data;
    }

    public function createImage($imgurl)
    {
        load()->func("communication");
        $resp = ihttp_request($imgurl);
        if( $resp["code"] == 200 && !empty($resp["content"]) ) 
        {
            return imagecreatefromstring($resp["content"]);
        }

        for( $i = 0; $i < 3; $i++ ) 
        {
            $resp = ihttp_request($imgurl);
            if( $resp["code"] == 200 && !empty($resp["content"]) ) 
            {
                return imagecreatefromstring($resp["content"]);
            }

        }
        return "";
    }

    public function mergeImage($target, $data, $imgurl)
    {
        $img = $this->createImage($imgurl);
        $w = imagesx($img);
        $h = imagesy($img);
        imagecopyresized($target, $img, $data["left"], $data["top"], 0, 0, $data["width"], $data["height"], $w, $h);
        imagedestroy($img);
        return $target;
    }

    public function mergeHead($target, $data, $imgurl)
    {
        if( $data["head_type"] == "default" ) 
        {
            $img = $this->createImage($imgurl);
            $w = imagesx($img);
            $h = imagesy($img);
            imagecopyresized($target, $img, $data["left"], $data["top"], 0, 0, $data["width"], $data["height"], $w, $h);
            imagedestroy($img);
            return $target;
        }

        if( $data["head_type"] == "circle" ) 
        {
        }
        else
        {
            if( $data["head_type"] == "rounded" ) 
            {
            }

        }

    }

    public function mergeText($target, $data, $text)
    {
        $font = IA_ROOT . "/addons/ewei_shopv2/static/fonts/msyh.ttf";
        $colors = $this->hex2rgb($data["color"]);
        $color = imagecolorallocate($target, $colors["red"], $colors["green"], $colors["blue"]);
        imagettftext($target, $data["size"], 0, $data["left"], $data["top"] + $data["size"], $color, $font, $text);
        return $target;
    }

    public function hex2rgb($colour)
    {
        if( $colour[0] == "#" ) 
        {
            $colour = substr($colour, 1);
        }

        if( strlen($colour) == 6 ) 
        {
            list($r, $g, $b) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        }
        else
        {
            if( strlen($colour) == 3 ) 
            {
                list($r, $g, $b) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
            }
            else
            {
                return false;
            }

        }

        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array( "red" => $r, "green" => $g, "blue" => $b );
    }

    public function createPoster($poster, $member, $qr, $upload = true)
    {
        global $_W;
        $path = IA_ROOT . "/addons/ewei_shopv2/data/task/poster/" . $_W["uniacid"] . "/";
        if( !is_dir($path) ) 
        {
            load()->func("file");
            mkdirs($path);
        }

        $md5 = md5(json_encode(array( "openid" => $member["openid"], "id" => $qr["id"], "bg" => $poster["bg"], "data" => $poster["data"], "version" => 1 )));
        $file = $md5 . ".png";
        $is_new = false;
        if( !is_file($path . $file) || $qr["qrimg"] != $qr["current_qrimg"] ) 
        {
            $is_new = true;
            set_time_limit(0);
            @ini_set("memory_limit", "256M");
            $target = imagecreatetruecolor(640, 1008);
            $bg = $this->createImage(tomedia($poster["bg"]));
            imagecopy($target, $bg, 0, 0, 0, 0, 640, 1008);
            imagedestroy($bg);
            $data = json_decode(str_replace("&quot;", "'", $poster["data"]), true);
            foreach( $data as $d ) 
            {
                $d = $this->getRealData($d);
                if( $d["type"] == "head" ) 
                {
                    $avatar = preg_replace("/\\/0\$/i", "/96", $member["avatar"]);
                    $target = $this->mergeImage($target, $d, $avatar);
                }
                else
                {
                    if( $d["type"] == "time" ) 
                    {
                        $time = date("Y-m-d H:i", $qr["endtime"]);
                        $target = $this->mergeText($target, $d, $d["title"] . ":" . $time);
                    }
                    else
                    {
                        if( $d["type"] == "img" ) 
                        {
                            $target = $this->mergeImage($target, $d, $d["src"]);
                        }
                        else
                        {
                            if( $d["type"] == "qr" ) 
                            {
                                $target = $this->mergeImage($target, $d, tomedia($qr["qrimg"]));
                            }
                            else
                            {
                                if( $d["type"] == "nickname" ) 
                                {
                                    $target = $this->mergeText($target, $d, $member["nickname"]);
                                }
                                else
                                {
                                    if( !empty($goods) ) 
                                    {
                                        if( $d["type"] == "title" ) 
                                        {
                                            $target = $this->mergeText($target, $d, $goods["title"]);
                                        }
                                        else
                                        {
                                            if( $d["type"] == "thumb" ) 
                                            {
                                                $thumb = (!empty($goods["commission_thumb"]) ? tomedia($goods["commission_thumb"]) : tomedia($goods["thumb"]));
                                                $target = $this->mergeImage($target, $d, $thumb);
                                            }
                                            else
                                            {
                                                if( $d["type"] == "marketprice" ) 
                                                {
                                                    $target = $this->mergeText($target, $d, $goods["marketprice"]);
                                                }
                                                else
                                                {
                                                    if( $d["type"] == "productprice" ) 
                                                    {
                                                        $target = $this->mergeText($target, $d, $goods["productprice"]);
                                                    }

                                                }

                                            }

                                        }

                                    }

                                }

                            }

                        }

                    }

                }

            }
            imagepng($target, $path . $file);
            imagedestroy($target);
        }

        $img = $_W["siteroot"] . "addons/ewei_shopv2/data/task/poster/" . $_W["uniacid"] . "/" . $file;
        if( !$upload ) 
        {
            return $img;
        }

        if( $qr["qrimg"] != $qr["current_qrimg"] || empty($qr["mediaid"]) || empty($qr["createtime"]) || ($qr["createtime"] + 3600 * 24 * 3) - 7200 < time() || $is_new ) 
        {
            $mediaid = $this->uploadImage($path . $file);
            $qr["mediaid"] = $mediaid;
            $qr["img"] = $mediaid;
            pdo_update("ewei_shop_task_poster_qr", array( "mediaid" => $mediaid, "createtime" => time() ), array( "id" => $qr["id"] ));
        }

        return array( "img" => $img, "mediaid" => $qr["mediaid"] );
    }

    public function uploadImage($img)
    {
        load()->func("communication");
        $account = m("common")->getAccount();
        $access_token = $account->fetch_token();
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $access_token . "&type=image";
        $ch1 = curl_init();
        $data = array( "media" => "@" . $img );
        if( version_compare(PHP_VERSION, "5.5.0", ">") ) 
        {
            $data = array( "media" => curl_file_create($img) );
        }

        curl_setopt($ch1, CURLOPT_URL, $url);
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
        $content = @json_decode(@curl_exec($ch1), true);
        if( !is_array($content) ) 
        {
            $content = array( "media_id" => "" );
        }

        curl_close($ch1);
        return $content["media_id"];
    }

    public function getQRByTicket($ticket = "")
    {
        global $_W;
        if( empty($ticket) ) 
        {
            return false;
        }

        $qrs = pdo_fetchall("select * from " . tablename("ewei_shop_task_poster_qr") . " where ticket=:ticket and acid=:acid limit 1", array( ":ticket" => $ticket, ":acid" => $_W["acid"] ));
        $count = count($qrs);
        if( $count <= 0 ) 
        {
            return false;
        }

        if( $count == 1 ) 
        {
            return $qrs[0];
        }

        return false;
    }

    public function checkMember($openid = "", $acc = "")
    {
        global $_W;
        $redis = redis();
        if( empty($acc) ) 
        {
            $acc = WeiXinAccount::create();
        }

        $userinfo = $acc->fansQueryInfo($openid);
        $userinfo["avatar"] = $userinfo["headimgurl"];
        load()->model("mc");
        $uid = mc_openid2uid($openid);
        if( !empty($uid) ) 
        {
            pdo_update("mc_members", array( "nickname" => $userinfo["nickname"], "gender" => $userinfo["sex"], "nationality" => $userinfo["country"], "resideprovince" => $userinfo["province"], "residecity" => $userinfo["city"], "avatar" => $userinfo["headimgurl"] ), array( "uid" => $uid ));
        }

        pdo_update("mc_mapping_fans", array( "nickname" => $userinfo["nickname"] ), array( "uniacid" => $_W["uniacid"], "openid" => $openid ));
        $model = m("member");
        $member = $model->getMember($openid);
        if( empty($member) ) 
        {
            if( !is_error($redis) ) 
            {
                $member = $redis->get($openid . "_task_checkMember");
                if( !empty($member) ) 
                {
                    return json_decode($member, true);
                }

            }

            $mc = mc_fetch($uid, array( "realname", "nickname", "mobile", "avatar", "resideprovince", "residecity", "residedist" ));
            $member = array( "uniacid" => $_W["uniacid"], "uid" => $uid, "openid" => $openid, "realname" => $mc["realname"], "mobile" => $mc["mobile"], "nickname" => (!empty($mc["nickname"]) ? $mc["nickname"] : $userinfo["nickname"]), "avatar" => (!empty($mc["avatar"]) ? $mc["avatar"] : $userinfo["avatar"]), "gender" => (!empty($mc["gender"]) ? $mc["gender"] : $userinfo["sex"]), "province" => (!empty($mc["resideprovince"]) ? $mc["resideprovince"] : $userinfo["province"]), "city" => (!empty($mc["residecity"]) ? $mc["residecity"] : $userinfo["city"]), "area" => $mc["residedist"], "createtime" => time(), "status" => 0 );
            pdo_insert("ewei_shop_member", $member);
            $member["id"] = pdo_insertid();
            $member["isnew"] = true;
            if( method_exists(m("member"), "memberRadisCountDelete") ) 
            {
                m("member")->memberRadisCountDelete();
            }

            if( !is_error($redis) ) 
            {
                $redis->set($openid . "_task_checkMember", json_encode($member), 20);
            }

        }
        else
        {
            $member["nickname"] = $userinfo["nickname"];
            $member["avatar"] = $userinfo["headimgurl"];
            $member["province"] = $userinfo["province"];
            $member["city"] = $userinfo["city"];
            pdo_update("ewei_shop_member", $member, array( "id" => $member["id"] ));
            $member["isnew"] = false;
        }

        file_put_contents(__DIR__ . "/user.json", json_encode($member));
        return $member;
    }

    public function perms()
    {
        return array( "task" => array( "text" => $this->getName(), "isplugin" => true, "view" => "浏览", "add" => "添加-log", "edit" => "修改-log", "delete" => "删除-log", "log" => "扫描记录", "clear" => "清除缓存-log", "setdefault" => "设置默认海报-log" ) );
    }

    public function responseUnsubscribe($param = "")
    {
        global $_W;
        if( isset($param["openid"]) && !empty($param["openid"]) ) 
        {
            $openid = $param["openid"];
            $where = array( "uniacid" => $_W["uniacid"], "joiner_id" => $openid );
            $task_info = pdo_fetch("SELECT join_user FROM " . tablename("ewei_shop_task_join") . "WHERE failtime>" . time() . " and is_reward=0 and join_id in (SELECT join_id from " . tablename("ewei_shop_task_joiner") . " where uniacid=:uniacid and joiner_id=:joiner_id and join_status=1)", array( ":uniacid" => $_W["uniacid"], ":joiner_id" => $openid ));
            if( $task_info ) 
            {
                $member = $this->checkMember($openid);
                pdo_update("ewei_shop_task_joiner", array( "join_status" => 0 ), $where);
                $updatesql = "UPDATE " . tablename("ewei_shop_task_join") . " SET completecount = completecount-1 WHERE failtime>" . time() . " and is_reward=0 and join_id in (SELECT join_id from " . tablename("ewei_shop_task_joiner") . " where uniacid=:uniacid and joiner_id=:joiner_id and join_status=1)";
                pdo_query($updatesql, array( ":uniacid" => $_W["uniacid"], ":joiner_id" => $openid ));
                foreach( $task_info as $val ) 
                {
                    m("message")->sendCustomNotice($val["join_user"], "您推荐的用户[" . $member["nickname"] . "]取消了关注，您失去了一个小伙伴");
                }
            }

        }

    }

    public function notice_complain($templete, $member, $poster, $scaner = "", $type = 1)
    {
        global $_W;
        $reward_type = "sub";
        $openid = $scaner["openid"];
        if( $type == 2 ) 
        {
            $reward_type = "rec";
            $openid = $member["openid"];
        }

        if( $templete ) 
        {
            $templete = trim($templete);
            $templete = str_replace("[任务执行者昵称]", $member["nickname"], $templete);
            $templete = str_replace("[任务名称]", $poster["title"], $templete);
            if( $poster["poster_type"] == 1 ) 
            {
                $templete = str_replace("[任务目标]", $poster["needcount"], $templete);
            }
            else
            {
                if( $poster["poster_type"] == 2 ) 
                {
                    $reward_data = unserialize($poster["reward_data"]);
                    $reward_data = array_shift($reward_data["rec"]);
                    $templete = str_replace("[任务目标]", $reward_data["needcount"], $templete);
                }

            }

            $templete = str_replace("[任务领取时间]", date("Y年m月d日 H:i", $poster["timestart"]) . "-" . date("Y年m月d日 H:i", $poster["timeend"]), $templete);
            if( !empty($scaner) ) 
            {
                $templete = str_replace("[海报扫描者昵称]", $scaner["nickname"], $templete);
            }

            if( $poster["reward_data"] ) 
            {
                $poster["reward_data"] = unserialize($poster["reward_data"]);
                $templete = str_replace("[余额奖励]", $poster["reward_data"][$reward_type]["money"]["num"], $templete);
                if( isset($poster["reward_data"][$reward_type]["coupon"]["total"]) ) 
                {
                    $templete = str_replace("[奖励优惠券]", $poster["reward_data"][$reward_type]["coupon"]["total"], $templete);
                }
                else
                {
                    $templete = str_replace("[奖励优惠券]", "", $templete);
                }

                $templete = str_replace("[积分奖励]", $poster["reward_data"][$reward_type]["credit"], $templete);
                $reward_text = "";
                foreach( $poster["reward_data"][$reward_type] as $key => $val ) 
                {
                    if( $key == "credit" ) 
                    {
                        $reward_text .= "积分" . $val . " |";
                    }

                    if( $key == "goods" ) 
                    {
                        $reward_text .= "指定商品" . count($val) . "件";
                    }

                    if( $key == "money" ) 
                    {
                        $reward_text .= "余额" . $val["num"] . "元 |";
                    }

                    if( $key == "coupon" ) 
                    {
                        $reward_text .= "优惠券" . $val["total"] . "张 |";
                    }

                    if( $key == "bribery" ) 
                    {
                        $reward_text .= "红包" . $val . "元 |";
                    }

                }
                $templete = str_replace("[关注奖励列表]", $reward_text, $templete);
            }
            else
            {
                $templete = str_replace("[余额奖励]", "0", $templete);
                $templete = str_replace("[奖励优惠券]", "0", $templete);
                $templete = str_replace("[积分奖励]", "0", $templete);
            }

            if( isset($poster["completecount"]) ) 
            {
                $notcomplete = intval($poster["needcount"] - $poster["completecount"]);
                if( $notcomplete <= 0 ) 
                {
                    $notcomplete = 0;
                }

                $templete = str_replace("[还需完成数量]", $notcomplete, $templete);
                $templete = str_replace("[完成数量]", intval($poster["completecount"]), $templete);
            }

            if( isset($poster["okdays"]) ) 
            {
                $templete = str_replace("[海报有效期]", date("Y年m月d日 H:i", $poster["okdays"]), $templete);
            }

            $db_data = pdo_fetchcolumn("select `data` from " . tablename("ewei_shop_task_default") . " where uniacid=:uniacid limit 1", array( ":uniacid" => $_W["uniacid"] ));
            $res = "";
            if( !empty($db_data) ) 
            {
                $res = unserialize($db_data);
            }

            $rankinfo = array(  );
            $rankinfoone = array( 1 => $res["taskranktitle"] . "1", 2 => $res["taskranktitle"] . "2", 3 => $res["taskranktitle"] . "3", 4 => $res["taskranktitle"] . "4", 5 => $res["taskranktitle"] . "5" );
            $rankinfotwo = array( 1 => $res["taskranktitle"] . "Ⅰ", 2 => $res["taskranktitle"] . "Ⅱ", 3 => $res["taskranktitle"] . "Ⅲ", 4 => $res["taskranktitle"] . "Ⅳ", 5 => $res["taskranktitle"] . "Ⅴ" );
            $rankinfothree = array( 1 => $res["taskranktitle"] . "A", 2 => $res["taskranktitle"] . "B", 3 => $res["taskranktitle"] . "C", 4 => $res["taskranktitle"] . "D", 5 => $res["taskranktitle"] . "E" );
            if( $res["taskranktype"] == 1 ) 
            {
                $rankinfo = $rankinfoone;
            }
            else
            {
                if( $res["taskranktype"] == 2 ) 
                {
                    $rankinfo = $rankinfotwo;
                }
                else
                {
                    if( $res["taskranktype"] == 3 ) 
                    {
                        $rankinfo = $rankinfothree;
                    }
                    else
                    {
                        $rankinfo = $rankinfoone;
                    }

                }

            }

            if( isset($poster["reward_rank"]) && !empty($poster["reward_rank"]) ) 
            {
                $templete = str_replace("[任务阶段]", $rankinfo[$poster["reward_rank"]], $templete);
            }

            return trim($templete);
        }
        else
        {
            return "";
        }

    }

    public function rec_notice_complain($poster)
    {
        if( $poster["reward_data"] ) 
        {
            $poster["reward_data"] = unserialize($poster["reward_data"]);
            $reward_text = "";
            foreach( $poster["reward_data"] as $key => $val ) 
            {
                if( $key == "credit" ) 
                {
                    $reward_text .= "积分:" . $val;
                }

                if( $key == "goods" ) 
                {
                    $reward_text .= "商品:" . count($val) . "个";
                }

                if( $key == "money" ) 
                {
                    $reward_text .= "奖金:" . $val["num"] . "元";
                }

                if( $key == "coupon" ) 
                {
                    $reward_text .= "优惠券:" . $val["total"] . "张";
                }

                if( $key == "bribery" ) 
                {
                    $reward_text .= "红包:" . $val . "元";
                }

            }
            return trim($reward_text);
        }
        else
        {
            return "";
        }

    }

    public function getdefault($key)
    {
        global $_W;
        if( $key ) 
        {
            $default = pdo_fetchcolumn("select `data` from " . tablename("ewei_shop_task_default") . " where uniacid=:uniacid limit 1", array( ":uniacid" => $_W["uniacid"] ));
            $default = unserialize($default);
            return $default[$key];
        }

        return 0;
    }

    public function getGoods($param = "")
    {
        load()->func("logging");
        if( empty($param) ) 
        {
            return false;
        }

        if( !isset($param["join_id"]) || empty($param["join_id"]) ) 
        {
            return false;
        }

        global $_W;
        $search_sql = "SELECT * FROM " . tablename("ewei_shop_task_join") . " WHERE join_user= :openid AND uniacid = :uniacid AND `join_id`=:join_id  AND is_reward=1";
        $data = array( ":uniacid" => $_W["uniacid"], ":openid" => $param["openid"], ":join_id" => $param["join_id"] );
        $join_info = pdo_fetch($search_sql, $data);
        if( empty($join_info) ) 
        {
            return false;
        }

        if( isset($param["goods_num"]) && !empty($param["goods_num"]) ) 
        {
            if( $join_info["task_type"] == 1 ) 
            {
                $rec_reward = unserialize($join_info["reward_data"]);
                if( !empty($rec_reward) ) 
                {
                    $goods_id = intval($param["goods_id"]);
                    if( isset($rec_reward["goods"][$goods_id]) && !empty($rec_reward["goods"][$goods_id]) ) 
                    {
                        $goods_spec = intval($param["goods_spec"]);
                        $goods_num = intval($param["goods_num"]);
                        if( 0 < $goods_spec ) 
                        {
                            $rec_reward["goods"][$goods_id]["spec"][$goods_spec]["total"] -= $goods_num;
                            if( $rec_reward["goods"][$goods_id]["spec"][$goods_spec]["total"] < 0 ) 
                            {
                                return false;
                            }

                            $rec_reward = serialize($rec_reward);
                            $update_data = array( "reward_data" => $rec_reward );
                            $update_where = array( "join_id" => $param["join_id"] );
                            $res = pdo_update("ewei_shop_task_join", $update_data, $update_where);
                            if( $res ) 
                            {
                                return true;
                            }

                            return false;
                        }

                        $rec_reward["goods"][$goods_id]["total"] -= $goods_num;
                        if( $rec_reward["goods"][$goods_id]["total"] < 0 ) 
                        {
                            return false;
                        }

                        $rec_reward = serialize($rec_reward);
                        $update_data = array( "reward_data" => $rec_reward );
                        $update_where = array( "join_id" => $param["join_id"] );
                        $res = pdo_update("ewei_shop_task_join", $update_data, $update_where);
                        if( $res ) 
                        {
                            return true;
                        }

                        return false;
                    }

                    return false;
                }

                return false;
            }

            if( $join_info["task_type"] == 2 ) 
            {
                $rec_reward = unserialize($join_info["reward_data"]);
                if( !empty($rec_reward) ) 
                {
                    $rank = intval($param["rank"]);
                    $goods_id = intval($param["goods_id"]);
                    if( !isset($rec_reward[$rank]["is_reward"]) || empty($rec_reward[$rank]["is_reward"]) ) 
                    {
                        return false;
                    }

                    if( isset($rec_reward[$rank]["goods"][$goods_id]) && !empty($rec_reward[$rank]["goods"][$goods_id]) ) 
                    {
                        $goods_spec = intval($param["goods_spec"]);
                        $goods_num = intval($param["goods_num"]);
                        if( 0 < $goods_spec ) 
                        {
                            $rec_reward[$rank]["goods"][$goods_id]["spec"][$goods_spec]["total"] -= $goods_num;
                            if( $rec_reward[$rank]["goods"][$goods_id]["spec"][$goods_spec]["total"] < 0 ) 
                            {
                                return false;
                            }

                            $rec_reward = serialize($rec_reward);
                            $update_data = array( "reward_data" => $rec_reward );
                            $update_where = array( "join_id" => $param["join_id"] );
                            $res = pdo_update("ewei_shop_task_join", $update_data, $update_where);
                            if( $res ) 
                            {
                                return true;
                            }

                            return false;
                        }

                        $rec_reward[$rank]["goods"][$goods_id]["total"] -= $goods_num;
                        if( $rec_reward[$rank]["goods"][$goods_id]["total"] < 0 ) 
                        {
                            return false;
                        }

                        $rec_reward = serialize($rec_reward);
                        $update_data = array( "reward_data" => $rec_reward );
                        $update_where = array( "join_id" => $param["join_id"] );
                        $res = pdo_update("ewei_shop_task_join", $update_data, $update_where);
                        if( $res ) 
                        {
                            return true;
                        }

                        return false;
                    }

                    return false;
                }

                return false;
            }

        }
        else
        {
            if( $join_info["task_type"] == 1 ) 
            {
                $rec_reward = unserialize($join_info["reward_data"]);
                if( !empty($rec_reward) ) 
                {
                    $goods_id = intval($param["goods_id"]);
                    if( isset($rec_reward["goods"][$goods_id]) && !empty($rec_reward["goods"][$goods_id]) ) 
                    {
                        $createtime_sql = "SELECT `createtime` FROM " . tablename("ewei_shop_task_log") . " WHERE openid= :openid AND uniacid = :uniacid AND `join_id`=:join_id  AND (recdata IS NOT NULL AND recdata !=\"\") ";
                        $createtime_data = array( ":uniacid" => $_W["uniacid"], ":openid" => $param["openid"], ":join_id" => $param["join_id"] );
                        $createtime = pdo_fetchcolumn($createtime_sql, $createtime_data);
                        $rewardday_sql = "SELECT `reward_days`,`is_goods` FROM " . tablename("ewei_shop_task_poster") . " WHERE  uniacid = :uniacid AND `id`=:id  AND poster_type=:poster_type ";
                        $rewardday_data = array( ":uniacid" => $_W["uniacid"], ":id" => $join_info["task_id"], ":poster_type" => $join_info["task_type"] );
                        $reward_days = pdo_fetch($rewardday_sql, $rewardday_data);
                        if( 0 < $reward_days["reward_days"] ) 
                        {
                            $reward_day = $createtime + $reward_days["reward_days"];
                            if( time() < $reward_day ) 
                            {
                                return $rec_reward["goods"][$goods_id];
                            }

                            return false;
                        }

                        return $rec_reward["goods"][$goods_id];
                    }

                    return false;
                }

                return false;
            }

            if( $join_info["task_type"] == 2 ) 
            {
                $rec_reward = unserialize($join_info["reward_data"]);
                if( !isset($param["rank"]) || empty($param["rank"]) ) 
                {
                    return false;
                }

                $rank = intval($param["rank"]);
                if( !empty($rec_reward) ) 
                {
                    $goods_id = intval($param["goods_id"]);
                    if( isset($rec_reward[$rank]["goods"][$goods_id]) && !empty($rec_reward[$rank]["goods"][$goods_id]) ) 
                    {
                        $rewardday_sql = "SELECT `reward_days`,`is_goods` FROM " . tablename("ewei_shop_task_poster") . " WHERE  uniacid = :uniacid AND `id`=:id  AND poster_type=:poster_type ";
                        $rewardday_data = array( ":uniacid" => $_W["uniacid"], ":id" => $join_info["task_id"], ":poster_type" => $join_info["task_type"] );
                        $reward_days = pdo_fetch($rewardday_sql, $rewardday_data);
                        if( 0 < $reward_days["reward_days"] ) 
                        {
                            $reward_day = $rec_reward[$rank]["reward_time"] + $reward_days["reward_days"];
                            if( time() < $reward_day ) 
                            {
                                return $rec_reward[$rank]["goods"][$goods_id];
                            }

                            return false;
                        }

                        return $rec_reward[$rank]["goods"][$goods_id];
                    }

                    return false;
                }

                return false;
            }

        }

    }

    public function reward($member_info, $poster, $join_info, $qr, $openid, $qrmember)
    {
        if( empty($member_info) || empty($poster) || empty($join_info) || empty($openid) || empty($qr) ) 
        {
            return false;
        }

        global $_W;
        if( empty($poster["autoposter"]) ) 
        {
            $_SESSION["postercontent"] = NULL;
        }
        else
        {
            $_SESSION["postercontent"] = $poster["keyword"];
        }

        load()->func("logging");
        $reward_data = unserialize($poster["reward_data"]);
        $count = $join_info["completecount"] + 1;
        if( $join_info["needcount"] == $count && $join_info["is_reward"] == 0 ) 
        {
            $reward = serialize($reward_data["rec"]);
            $sub_reward = serialize($reward_data["sub"]);
            $reward_log = array( "uniacid" => $_W["uniacid"], "openid" => $qr["openid"], "from_openid" => $openid, "join_id" => $join_info["join_id"], "taskid" => $qr["posterid"], "task_type" => 1, "subdata" => $sub_reward, "recdata" => $reward, "createtime" => time() );
            pdo_update("ewei_shop_task_join", array( "completecount" => $count, "is_reward" => 1, "reward_data" => $reward ), array( "uniacid" => $_W["uniacid"], "join_id" => $join_info["join_id"], "join_user" => $qr["openid"], "task_id" => $poster["id"], "task_type" => 1 ));
            pdo_insert("ewei_shop_task_log", $reward_log);
            $log_id = pdo_insertid();
            $scaner = array( "uniacid" => $_W["uniacid"], "task_user" => $qr["openid"], "joiner_id" => $openid, "task_id" => $qr["posterid"], "join_id" => $join_info["join_id"], "task_type" => 1, "join_status" => 1, "addtime" => time() );
            pdo_insert("ewei_shop_task_joiner", $scaner);
            foreach( $reward_data as $key => $val ) 
            {
                if( $key == "rec" ) 
                {
                    if( isset($val["credit"]) && 0 < $val["credit"] ) 
                    {
                        m("member")->setCredit($qr["openid"], "credit1", $val["credit"], array( 0, "推荐扫码关注积分+" . $val["credit"] ));
                    }

                    if( isset($val["money"]) && 0 < $val["money"]["num"] ) 
                    {
                        $pay = $val["money"]["num"];
                        if( $val["money"]["type"] == 1 ) 
                        {
                            $pay *= 100;
                        }

                        m("finance")->pay($qr["openid"], $val["money"]["type"], $pay, "", "任务活动推荐奖励", false);
                    }

                    if( isset($val["bribery"]) && 0 < $val["bribery"] ) 
                    {
                        $tid = rand(1, 1000) . time() . rand(1, 10000);
                        $params = array( "openid" => $qr["openid"], "tid" => $tid, "send_name" => "推荐奖励", "money" => $val["bribery"], "wishing" => "推荐奖励", "act_name" => $poster["title"], "remark" => "推荐奖励" );
                        $err = m("common")->sendredpack($params);
                        if( !is_error($err) ) 
                        {
                            $reward = unserialize($reward);
                            $reward["briberyOrder"] = $tid;
                            $reward = serialize($reward);
                            $upgrade = array( "recdata" => $reward );
                            pdo_update("ewei_shop_task_log", $upgrade, array( "id" => $log_id ));
                        }

                    }

                    if( isset($val["coupon"]) && !empty($val["coupon"]) ) 
                    {
                        $cansendreccoupon = false;
                        $plugin_coupon = com("coupon");
                        unset($val["coupon"]["total"]);
                        foreach( $val["coupon"] as $k => $v ) 
                        {
                            if( $plugin_coupon && !empty($v["id"]) && 0 < $v["couponnum"] ) 
                            {
                                $reccoupon = $plugin_coupon->getCoupon($v["id"]);
                                if( !empty($reccoupon) ) 
                                {
                                    $cansendreccoupon = true;
                                }

                            }

                            if( $cansendreccoupon ) 
                            {
                                $plugin_coupon->taskposter($qrmember, $v["id"], $v["couponnum"]);
                            }

                        }
                    }

                }
                else
                {
                    if( $key == "sub" ) 
                    {
                        if( 0 < $val["credit"] ) 
                        {
                            m("member")->setCredit($openid, "credit1", $val["credit"], array( 0, "扫码关注积分+" . $val["credit"] ));
                        }

                        if( 0 < $val["bribery"] ) 
                        {
                            $tid = rand(1, 1000) . time() . rand(1, 10000);
                            $params = array( "openid" => $openid, "tid" => $tid, "send_name" => "推荐奖励", "money" => $val["bribery"], "wishing" => "推荐奖励", "act_name" => $poster["title"], "remark" => "推荐奖励" );
                            $err = m("common")->sendredpack($params);
                            if( !is_error($err) ) 
                            {
                                $sub_reward = unserialize($sub_reward);
                                $sub_reward["briberyOrder"] = $tid;
                                $sub_reward = serialize($sub_reward);
                                $upgrade = array( "subdata" => $sub_reward );
                                pdo_update("ewei_shop_task_log", $upgrade, array( "id" => $log_id ));
                            }
                            else
                            {
                                logging_run("bribery" . $err["message"]);
                            }

                        }

                        if( 0 < $val["money"]["num"] ) 
                        {
                            $pay = $val["money"]["num"];
                            if( $val["money"]["type"] == 1 ) 
                            {
                                $pay *= 100;
                            }

                            $res = m("finance")->pay($openid, $val["money"]["type"], $pay, "", "任务活动奖励", false);
                            if( is_error($res) ) 
                            {
                                logging_run($res["message"]);
                            }

                        }

                        if( isset($val["coupon"]) && !empty($val["coupon"]) ) 
                        {
                            $cansendreccoupon = false;
                            $plugin_coupon = com("coupon");
                            unset($val["coupon"]["total"]);
                            foreach( $val["coupon"] as $k => $v ) 
                            {
                                if( $plugin_coupon && !empty($v["id"]) && 0 < $v["couponnum"] ) 
                                {
                                    $reccoupon = $plugin_coupon->getCoupon($v["id"]);
                                    if( !empty($reccoupon) ) 
                                    {
                                        $cansendreccoupon = true;
                                    }

                                }

                                if( $cansendreccoupon ) 
                                {
                                    $plugin_coupon->taskposter($member_info, $v["id"], $v["couponnum"]);
                                }

                            }
                        }

                    }

                }

            }
            $default_text = pdo_fetchcolumn("SELECT `data` FROM " . tablename("ewei_shop_task_default") . " WHERE uniacid=:uniacid limit 1", array( ":uniacid" => $_W["uniacid"] ));
            if( !empty($default_text) ) 
            {
                $default_text = unserialize($default_text);
                if( !empty($default_text["successscaner"]) ) 
                {
                    $poster["okdays"] = $join_info["failtime"];
                    $poster["completecount"] = $join_info["completecount"];
                    foreach( $default_text["successscaner"] as $key => $val ) 
                    {
                        $default_text["successscaner"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 1);
                    }
                    if( $default_text["templateid"] ) 
                    {
                        m("message")->sendTplNotice($openid, $default_text["templateid"], $default_text["successscaner"], "");
                    }
                    else
                    {
                        m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
                    }

                }
                else
                {
                    m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
                }

                if( !empty($default_text["complete"]) ) 
                {
                    $poster["okdays"] = $join_info["failtime"];
                    $poster["completecount"] = $count;
                    foreach( $default_text["complete"] as $key => $val ) 
                    {
                        $default_text["complete"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 2);
                    }
                    if( $default_text["templateid"] ) 
                    {
                        m("message")->sendTplNotice($qrmember["openid"], $default_text["templateid"], $default_text["complete"], mobileUrl("task", array( "tabpage" => "complete" ), true));
                    }
                    else
                    {
                        m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task", array( "tabpage" => "complete" ), true));
                    }

                }
                else
                {
                    m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task", array( "tabpage" => "complete" ), true));
                }

            }
            else
            {
                m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
                m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task", array( "tabpage" => "complete" ), true));
            }

            if( p("lottery") ) 
            {
                $res = p("lottery")->getLottery($qrmember["openid"], 3, array( "taskid" => $poster["id"] ));
                if( $res ) 
                {
                    p("lottery")->getLotteryList($qrmember["openid"], array( "lottery_id" => $res ));
                }

            }

        }
        else
        {
            $reward = serialize($reward_data["rec"]);
            $sub_reward = serialize($reward_data["sub"]);
            $reward_log = array( "uniacid" => $_W["uniacid"], "openid" => $qr["openid"], "from_openid" => $openid, "join_id" => $join_info["join_id"], "taskid" => $qr["posterid"], "task_type" => 1, "subdata" => $sub_reward, "createtime" => time() );
            pdo_update("ewei_shop_task_join", array( "completecount" => $count ), array( "uniacid" => $_W["uniacid"], "join_user" => $qr["openid"], "task_id" => $poster["id"], "task_type" => 1 ));
            pdo_insert("ewei_shop_task_log", $reward_log);
            $log_id = pdo_insertid();
            $scaner = array( "uniacid" => $_W["uniacid"], "task_user" => $qr["openid"], "joiner_id" => $openid, "task_id" => $qr["posterid"], "join_id" => $join_info["join_id"], "task_type" => 1, "join_status" => 1, "addtime" => time() );
            pdo_insert("ewei_shop_task_joiner", $scaner);
            foreach( $reward_data as $key => $val ) 
            {
                if( $key == "sub" ) 
                {
                    if( 0 < $val["credit"] ) 
                    {
                        m("member")->setCredit($openid, "credit1", $val["credit"], array( 0, "扫码关注积分+" . $val["credit"] ));
                    }

                    if( 0 < $val["money"]["num"] ) 
                    {
                        $pay = $val["money"]["num"];
                        if( $val["money"]["type"] == 1 ) 
                        {
                            $pay *= 100;
                        }

                        $res = m("finance")->pay($openid, $val["money"]["type"], $pay, "", "任务活动奖励", false);
                        if( is_error($res) ) 
                        {
                            logging_run("submoney" . $res["message"]);
                        }

                    }

                    if( 0 < $val["bribery"] ) 
                    {
                        $tid = rand(1, 1000) . time() . rand(1, 10000);
                        $params = array( "openid" => $openid, "tid" => $tid, "send_name" => "推荐奖励", "money" => $val["bribery"], "wishing" => "推荐奖励", "act_name" => $poster["title"], "remark" => "推荐奖励" );
                        $err = m("common")->sendredpack($params);
                        if( !is_error($err) ) 
                        {
                            $sub_reward = unserialize($sub_reward);
                            $sub_reward["briberyOrder"] = $tid;
                            $sub_reward = serialize($sub_reward);
                            $upgrade = array( "subdata" => $sub_reward );
                            pdo_update("ewei_shop_task_log", $upgrade, array( "id" => $log_id ));
                        }
                        else
                        {
                            logging_run("bribery" . $err["message"]);
                        }

                    }

                    if( isset($val["coupon"]) && !empty($val["coupon"]) ) 
                    {
                        $cansendreccoupon = false;
                        $plugin_coupon = com("coupon");
                        unset($val["coupon"]["total"]);
                        foreach( $val["coupon"] as $k => $v ) 
                        {
                            if( $plugin_coupon ) 
                            {
                                $cansendreccoupon = false;
                                if( !empty($v["id"]) && 0 < $v["couponnum"] ) 
                                {
                                    $reccoupon = $plugin_coupon->getCoupon($v["id"]);
                                    if( !empty($reccoupon) ) 
                                    {
                                        $cansendreccoupon = true;
                                    }

                                }

                            }

                            if( $cansendreccoupon ) 
                            {
                                $plugin_coupon->taskposter($member_info, $v["id"], $v["couponnum"]);
                            }

                        }
                    }

                }

            }
            $default_text = pdo_fetchcolumn("SELECT `data` FROM " . tablename("ewei_shop_task_default") . " WHERE uniacid=:uniacid limit 1", array( ":uniacid" => $_W["uniacid"] ));
            if( !empty($default_text) ) 
            {
                $default_text = unserialize($default_text);
                if( !empty($default_text["successscaner"]) ) 
                {
                    $poster["okdays"] = $join_info["failtime"];
                    $poster["completecount"] = $join_info["completecount"];
                    foreach( $default_text["successscaner"] as $key => $val ) 
                    {
                        $default_text["successscaner"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 1);
                    }
                    if( $default_text["templateid"] ) 
                    {
                        m("message")->sendTplNotice($openid, $default_text["templateid"], $default_text["successscaner"], "");
                    }
                    else
                    {
                        m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
                    }

                }
                else
                {
                    m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
                }

                if( $poster["needcount"] < $count ) 
                {
                    if( $default_text["is_completed"] == 1 ) 
                    {
                        if( !empty($default_text["completed"]) ) 
                        {
                            $poster["okdays"] = $join_info["failtime"];
                            $poster["completecount"] = $count;
                            foreach( $default_text["completed"] as $key => $val ) 
                            {
                                $default_text["completed"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 2);
                            }
                            if( $default_text["templateid"] ) 
                            {
                                m("message")->sendTplNotice($qrmember["openid"], $default_text["templateid"], $default_text["completed"], mobileUrl("task", array( "tabpage" => "complete" ), true));
                            }
                            else
                            {
                                m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task", array( "tabpage" => "complete" ), true));
                            }

                        }
                        else
                        {
                            m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task", array( "tabpage" => "complete" ), true));
                        }

                    }

                }
                else
                {
                    if( !empty($default_text["successtasker"]) ) 
                    {
                        $poster["okdays"] = $join_info["failtime"];
                        $poster["completecount"] = $count;
                        foreach( $default_text["successtasker"] as $key => $val ) 
                        {
                            $default_text["successtasker"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 2);
                        }
                        if( $default_text["templateid"] ) 
                        {
                            m("message")->sendTplNotice($qrmember["openid"], $default_text["templateid"], $default_text["successtasker"], mobileUrl("task", array( "tabpage" => "runninga" ), true));
                        }
                        else
                        {
                            m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "您的海报被" . $member_info["nickname"] . "关注,增加了1点人气值", mobileUrl("task", array( "tabpage" => "runninga" ), true));
                        }

                    }
                    else
                    {
                        m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "您的海报被" . $member_info["nickname"] . "关注,增加了1点人气值", mobileUrl("task", array( "tabpage" => "runninga" ), true));
                    }

                }

            }
            else
            {
                m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
                m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "您的海报被" . $member_info["nickname"] . "关注,增加了1点人气值", mobileUrl("task", array( "tabpage" => "runninga" ), true));
            }

        }

    }

    public function rankreward($member_info, $poster, $join_info, $qr, $openid, $qrmember)
    {
        if( empty($member_info) || empty($poster) || empty($join_info) || empty($openid) || empty($qr) ) 
        {
            return false;
        }

        global $_W;
        if( empty($poster["autoposter"]) ) 
        {
            $_SESSION["postercontent"] = NULL;
        }
        else
        {
            $_SESSION["postercontent"] = $poster["keyword"];
        }

        $reward_data = unserialize($poster["reward_data"]);
        $rec_data = unserialize($join_info["reward_data"]);
        $count = $join_info["completecount"] + 1;
        $is_reward = 0;
        $needcount = 0;
        foreach( $rec_data as $k => $val ) 
        {
            $needcount = $val["needcount"];
            if( $val["needcount"] == $count && $is_reward == 0 ) 
            {
                $is_reward = 1;
                if( !isset($val["is_reward"]) || empty($val["is_reward"]) ) 
                {
                    unset($val["rank"]);
                    unset($val["needcount"]);
                    $reward_data["rec"] = $reward_data["rec"][$k];
                    $poster["reward_rank"] = $k;
                    $this->reward_both($count, $reward_data, $qr, $join_info, $openid, $qrmember, $member_info, $poster);
                    $rec_data[$k] = $reward_data["rec"];
                    $rec_data[$k]["is_reward"] = 1;
                    $rec_data[$k]["reward_time"] = time();
                    $rec_data = serialize($rec_data);
                    pdo_update("ewei_shop_task_join", array( "reward_data" => $rec_data, "is_reward" => 1 ), array( "uniacid" => $_W["uniacid"], "join_id" => $join_info["join_id"], "join_user" => $qr["openid"], "task_id" => $poster["id"], "task_type" => 2 ));
                }
                else
                {
                    $poster["needcount"] = $needcount;
                    $this->reward_scan($count, $reward_data, $qr, $join_info, $openid, $qrmember, $member_info, $poster);
                }

            }

        }
        if( $is_reward == 0 ) 
        {
            $is_reward = 1;
            $poster["needcount"] = $needcount;
            $this->reward_scan($count, $reward_data, $qr, $join_info, $openid, $qrmember, $member_info, $poster);
        }

    }

    protected function reward_both($count, $reward_data, $qr, $join_info, $openid, $qrmember, $member_info, $poster)
    {
        global $_W;
        load()->func("logging");
        $reward = serialize($reward_data["rec"]);
        $sub_reward = serialize($reward_data["sub"]);
        $reward_log = array( "uniacid" => $_W["uniacid"], "openid" => $qr["openid"], "from_openid" => $openid, "join_id" => $join_info["join_id"], "taskid" => $qr["posterid"], "task_type" => 2, "subdata" => $sub_reward, "recdata" => $reward, "createtime" => time() );
        pdo_update("ewei_shop_task_join", array( "completecount" => $count ), array( "uniacid" => $_W["uniacid"], "join_id" => $join_info["join_id"], "join_user" => $qr["openid"], "task_id" => $poster["id"], "task_type" => 2 ));
        pdo_insert("ewei_shop_task_log", $reward_log);
        $log_id = pdo_insertid();
        $scaner = array( "uniacid" => $_W["uniacid"], "task_user" => $qr["openid"], "joiner_id" => $openid, "task_id" => $qr["posterid"], "join_id" => $join_info["join_id"], "task_type" => 2, "join_status" => 1, "addtime" => time() );
        pdo_insert("ewei_shop_task_joiner", $scaner);
        foreach( $reward_data as $key => $val ) 
        {
            if( $key == "rec" ) 
            {
                if( isset($val["credit"]) && 0 < $val["credit"] ) 
                {
                    m("member")->setCredit($qr["openid"], "credit1", $val["credit"], array( 0, "推荐扫码关注积分+" . $val["credit"] ));
                }

                if( isset($val["money"]) && 0 < $val["money"]["num"] ) 
                {
                    $pay = $val["money"]["num"];
                    if( $val["money"]["type"] == 1 ) 
                    {
                        $pay *= 100;
                    }

                    m("finance")->pay($qr["openid"], $val["money"]["type"], $pay, "", "任务活动推荐奖励", false);
                }

                if( isset($val["bribery"]) && 0 < $val["bribery"] ) 
                {
                    $tid = rand(1, 1000) . time() . rand(1, 10000);
                    $params = array( "openid" => $qr["openid"], "tid" => $tid, "send_name" => "推荐奖励", "money" => $val["bribery"], "wishing" => "推荐奖励", "act_name" => $poster["title"], "remark" => "推荐奖励" );
                    $err = m("common")->sendredpack($params);
                    if( !is_error($err) ) 
                    {
                        $reward = unserialize($reward);
                        $reward["briberyOrder"] = $tid;
                        $reward = serialize($reward);
                        $upgrade = array( "recdata" => $reward );
                        pdo_update("ewei_shop_task_log", $upgrade, array( "id" => $log_id ));
                    }

                }

                if( isset($val["coupon"]) && !empty($val["coupon"]) ) 
                {
                    $cansendreccoupon = false;
                    $plugin_coupon = com("coupon");
                    unset($val["coupon"]["total"]);
                    foreach( $val["coupon"] as $k => $v ) 
                    {
                        if( $plugin_coupon && !empty($v["id"]) && 0 < $v["couponnum"] ) 
                        {
                            $reccoupon = $plugin_coupon->getCoupon($v["id"]);
                            if( !empty($reccoupon) ) 
                            {
                                $cansendreccoupon = true;
                            }

                        }

                        if( $cansendreccoupon ) 
                        {
                            $plugin_coupon->taskposter($qrmember, $v["id"], $v["couponnum"]);
                        }

                    }
                }

            }
            else
            {
                if( $key == "sub" ) 
                {
                    if( 0 < $val["credit"] ) 
                    {
                        m("member")->setCredit($openid, "credit1", $val["credit"], array( 0, "扫码关注积分+" . $val["credit"] ));
                    }

                    if( 0 < $val["money"]["num"] ) 
                    {
                        $pay = $val["money"]["num"];
                        if( $val["money"]["type"] == 1 ) 
                        {
                            $pay *= 100;
                        }

                        $res = m("finance")->pay($openid, $val["money"]["type"], $pay, "", "任务活动奖励", false);
                        if( is_error($res) ) 
                        {
                            logging_run($res["message"]);
                        }

                    }

                    if( isset($val["coupon"]) && !empty($val["coupon"]) ) 
                    {
                        $cansendreccoupon = false;
                        $plugin_coupon = com("coupon");
                        unset($val["coupon"]["total"]);
                        foreach( $val["coupon"] as $k => $v ) 
                        {
                            if( $plugin_coupon && !empty($v["id"]) && 0 < $v["couponnum"] ) 
                            {
                                $reccoupon = $plugin_coupon->getCoupon($v["id"]);
                                if( !empty($reccoupon) ) 
                                {
                                    $cansendreccoupon = true;
                                }

                            }

                            if( $cansendreccoupon ) 
                            {
                                $plugin_coupon->taskposter($member_info, $v["id"], $v["couponnum"]);
                            }

                        }
                    }

                }

            }

        }
        $default_text = pdo_fetchcolumn("SELECT `data` FROM " . tablename("ewei_shop_task_default") . " WHERE uniacid=:uniacid limit 1", array( ":uniacid" => $_W["uniacid"] ));
        if( !empty($default_text) ) 
        {
            $default_text = unserialize($default_text);
            if( !empty($default_text["successscaner"]) ) 
            {
                $poster["okdays"] = $join_info["failtime"];
                $poster["completecount"] = $join_info["completecount"];
                foreach( $default_text["successscaner"] as $key => $val ) 
                {
                    $default_text["successscaner"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 1);
                }
                if( $default_text["templateid"] ) 
                {
                    m("message")->sendTplNotice($openid, $default_text["templateid"], $default_text["successscaner"], "");
                }
                else
                {
                    m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
                }

            }
            else
            {
                m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
            }

            if( !empty($default_text["rankcomplete"]) ) 
            {
                $poster["okdays"] = $join_info["failtime"];
                $poster["completecount"] = $count;
                $poster["needcount"] = $count;
                foreach( $default_text["rankcomplete"] as $key => $val ) 
                {
                    $default_text["rankcomplete"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 2);
                }
                if( $default_text["templateid"] ) 
                {
                    m("message")->sendTplNotice($qrmember["openid"], $default_text["templateid"], $default_text["rankcomplete"], mobileUrl("task/mytask", array( "id" => $join_info["join_id"] ), true));
                }
                else
                {
                    m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task/mytask", array( "id" => $join_info["join_id"] ), true));
                }

            }
            else
            {
                m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task/mytask", array( "id" => $join_info["join_id"] ), true));
            }

        }
        else
        {
            m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
            m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task/mytask", array( "id" => $join_info["join_id"] ), true));
        }

        if( p("lottery") ) 
        {
            $res = p("lottery")->getLottery($qrmember["openid"], 3, array( "taskid" => $poster["id"] ));
            if( $res ) 
            {
                p("lottery")->getLotteryList($qrmember["openid"], array( "lottery_id" => $res ));
            }

        }

    }

    protected function reward_scan($count, $reward_data, $qr, $join_info, $openid, $qrmember, $member_info, $poster)
    {
        global $_W;
        load()->func("logging");
        $sub_reward = serialize($reward_data["sub"]);
        $reward_log = array( "uniacid" => $_W["uniacid"], "openid" => $qr["openid"], "from_openid" => $openid, "join_id" => $join_info["join_id"], "taskid" => $qr["posterid"], "task_type" => 2, "subdata" => $sub_reward, "createtime" => time() );
        pdo_update("ewei_shop_task_join", array( "completecount" => $count ), array( "uniacid" => $_W["uniacid"], "join_user" => $qr["openid"], "task_id" => $poster["id"], "task_type" => 2 ));
        pdo_insert("ewei_shop_task_log", $reward_log);
        $log_id = pdo_insertid();
        $scaner = array( "uniacid" => $_W["uniacid"], "task_user" => $qr["openid"], "joiner_id" => $openid, "task_id" => $qr["posterid"], "join_id" => $join_info["join_id"], "task_type" => 2, "join_status" => 1, "addtime" => time() );
        pdo_insert("ewei_shop_task_joiner", $scaner);
        foreach( $reward_data as $key => $val ) 
        {
            if( $key == "sub" ) 
            {
                if( 0 < $val["credit"] ) 
                {
                    m("member")->setCredit($openid, "credit1", $val["credit"], array( 0, "扫码关注积分+" . $val["credit"] ));
                }

                if( 0 < $val["money"]["num"] ) 
                {
                    $pay = $val["money"]["num"];
                    if( $val["money"]["type"] == 1 ) 
                    {
                        $pay *= 100;
                    }

                    $res = m("finance")->pay($openid, $val["money"]["type"], $pay, "", "任务活动奖励", false);
                    if( is_error($res) ) 
                    {
                        logging_run("submoney" . $res["message"]);
                    }

                }

                if( 0 < $val["bribery"] ) 
                {
                    $tid = rand(1, 1000) . time() . rand(1, 10000);
                    $params = array( "openid" => $openid, "tid" => $tid, "send_name" => "推荐奖励", "money" => $val["bribery"], "wishing" => "推荐奖励", "act_name" => $poster["title"], "remark" => "推荐奖励" );
                    $err = m("common")->sendredpack($params);
                    if( !is_error($err) ) 
                    {
                        $sub_reward = unserialize($sub_reward);
                        $sub_reward["briberyOrder"] = $tid;
                        $sub_reward = serialize($sub_reward);
                        $upgrade = array( "subdata" => $sub_reward );
                        pdo_update("ewei_shop_task_log", $upgrade, array( "id" => $log_id ));
                    }
                    else
                    {
                        logging_run("bribery" . $err["message"]);
                    }

                }

                if( isset($val["coupon"]) && !empty($val["coupon"]) ) 
                {
                    $cansendreccoupon = false;
                    $plugin_coupon = com("coupon");
                    unset($val["coupon"]["total"]);
                    foreach( $val["coupon"] as $k => $v ) 
                    {
                        if( $plugin_coupon ) 
                        {
                            $cansendreccoupon = false;
                            if( !empty($v["id"]) && 0 < $v["couponnum"] ) 
                            {
                                $reccoupon = $plugin_coupon->getCoupon($v["id"]);
                                if( !empty($reccoupon) ) 
                                {
                                    $cansendreccoupon = true;
                                }

                            }

                        }

                        if( $cansendreccoupon ) 
                        {
                            $plugin_coupon->taskposter($member_info, $v["id"], $v["couponnum"]);
                        }

                    }
                }

            }

        }
        $default_text = pdo_fetchcolumn("SELECT `data` FROM " . tablename("ewei_shop_task_default") . " WHERE uniacid=:uniacid limit 1", array( ":uniacid" => $_W["uniacid"] ));
        if( !empty($default_text) ) 
        {
            $default_text = unserialize($default_text);
            if( !empty($default_text["successscaner"]) ) 
            {
                $poster["okdays"] = $join_info["failtime"];
                $poster["completecount"] = $join_info["completecount"];
                foreach( $default_text["successscaner"] as $key => $val ) 
                {
                    $default_text["successscaner"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 1);
                }
                if( $default_text["templateid"] ) 
                {
                    m("message")->sendTplNotice($openid, $default_text["templateid"], $default_text["successscaner"], "");
                }
                else
                {
                    m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
                }

            }
            else
            {
                m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
            }

            if( $poster["needcount"] < $count ) 
            {
                if( $default_text["is_completed"] == 1 ) 
                {
                    if( !empty($default_text["completed"]) ) 
                    {
                        $poster["okdays"] = $join_info["failtime"];
                        $poster["completecount"] = $count;
                        foreach( $default_text["completed"] as $key => $val ) 
                        {
                            $default_text["completed"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 2);
                        }
                        if( $default_text["templateid"] ) 
                        {
                            m("message")->sendTplNotice($qrmember["openid"], $default_text["templateid"], $default_text["completed"], mobileUrl("task", array( "tabpage" => "complete" ), true));
                        }
                        else
                        {
                            m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task", array( "tabpage" => "complete" ), true));
                        }

                    }
                    else
                    {
                        m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "恭喜您完成任务获得奖励", mobileUrl("task", array( "tabpage" => "complete" ), true));
                    }

                }

            }
            else
            {
                if( !empty($default_text["successtasker"]) ) 
                {
                    $poster["okdays"] = $join_info["failtime"];
                    $poster["completecount"] = $count;
                    foreach( $default_text["successtasker"] as $key => $val ) 
                    {
                        $default_text["successtasker"][$key]["value"] = $this->notice_complain($val["value"], $qrmember, $poster, $member_info, 2);
                    }
                    if( $default_text["templateid"] ) 
                    {
                        m("message")->sendTplNotice($qrmember["openid"], $default_text["templateid"], $default_text["successtasker"], mobileUrl("task", array( "tabpage" => "runninga" ), true));
                    }
                    else
                    {
                        m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "您的海报被" . $member_info["nickname"] . "关注,增加了1点人气值", mobileUrl("task", array( "tabpage" => "runninga" ), true));
                    }

                }
                else
                {
                    m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "您的海报被" . $member_info["nickname"] . "关注,增加了1点人气值", mobileUrl("task", array( "tabpage" => "runninga" ), true));
                }

            }

        }
        else
        {
            m("message")->sendCustomNotice($openid, "感谢您的关注，恭喜您获得关注奖励");
            m("message")->sendCustomNotice($qrmember["openid"], "亲爱的" . $qrmember["nickname"] . "您的海报被" . $member_info["nickname"] . "关注,增加了1点人气值", mobileUrl("task", array( "tabpage" => "runninga" ), true));
        }

    }

    /**
     * 返回全部指定状态的任务
     * @param int $status
     * @return array or false
     */

    public function getAvailableTask($status = 1, $classify = true)
    {
        global $_W;
        $status = intval($status);
        $list = json_decode($this->extension, true);
        if( empty($list) ) 
        {
            return false;
        }

        if( empty($classify) ) 
        {
            return $list;
        }

        $return = array(  );
        foreach( $list as $ik => $item ) 
        {
            $return[$item["classify_name"]][count($return[$item["classify_name"]])] = $list[$ik];
        }
        return $return;
    }

    /**
     * 检查是否是可用任务
     * @param $taskclass
     * @return bool
     */

    public function checkAvailableTask($taskclass)
    {
        global $_W;
        $tasks = json_decode($this->extension, true);
        foreach( $tasks as $key => $value ) 
        {
            if( $value["status"] == 1 && $value["taskclass"] == $taskclass ) 
            {
                return $value;
            }

        }
        return false;
    }

    /**
     * 检查任务是否已完成
     * 如果已经完成则发放奖励
     * 如果没有完成则返回boole值 false代表更新失败,
     */

    public function checkTaskReward($taskclass = "", $num = 1, $openid = "")
    {
        global $_W;
        if( strpos("first", "1" . $taskclass) ) 
        {
            $taskclass($openid);
            $this->firstTask . $taskclass($openid);
        }

        if( empty($openid) ) 
        {
            $openid = $_W["openid"];
        }

        if( empty($taskclass) ) 
        {
            return false;
        }

        $sql = "SELECT * FROM " . tablename("ewei_shop_task_extension_join") . " WHERE openid = :openid AND uniacid = :uniacid AND completetime = 0 AND endtime > " . time();
        $allTask = pdo_fetchall($sql, array( ":openid" => $openid, ":uniacid" => $_W["uniacid"] ));
        foreach( $allTask as $tk => $tv ) 
        {
            $a = $this->checktaskstatus($tv);
            if( !$a ) 
            {
                continue;
            }

            $require = unserialize($tv["require_data"]);
            $progress = unserialize($tv["progress_data"]);
            if( !array_key_exists($taskclass, $require) ) 
            {
                continue;
            }

            if( intval($progress[$taskclass]["num"]) < intval($require[$taskclass]["num"]) ) 
            {
                $progress[$taskclass]["num"] = intval($progress[$taskclass]["num"]) + $num;
            }

            $progress_data = serialize($progress);
            pdo_update("ewei_shop_task_extension_join", array( "progress_data" => $progress_data ), array( "uniacid" => $_W["uniacid"], "id" => $tv["id"] ));
            foreach( $progress as $k => $v ) 
            {
                if( $v < $require[$k] ) 
                {
                    $isreward = false;
                    break;
                }

                $isreward = true;
            }
            if( $isreward ) 
            {
                pdo_update("ewei_shop_task_extension_join", array( "completetime" => time() ), array( "uniacid" => $_W["uniacid"], "id" => $tv["id"] ));
                $reward_data = unserialize($tv["reward_data"]);
                $this->sendReward($reward_data, 0, $openid, $tv["id"]);
            }

        }
        return true;
    }

    public function firstTaskfirst_recharge($openid)
    {
        global $_W;
        return 1;
    }

    public function firstTaskfirst_order($openid)
    {
        global $_W;
        return 1;
    }

    public function checktaskstatus($task)
    {
        global $_W;
        $time = time();
        if( $task["endtime"] < $time || 0 < $task["completetime"] ) 
        {
            return false;
        }

        return true;
    }

    public function sendReward($reward_data = array(  ), $btn = 0, $openid = NULL, $rewardid = 0)
    {
        global $_W;
        if( empty($openid) ) 
        {
            $openid = $_W["openid"];
        }

        if( empty($rewardid) ) 
        {
            return false;
        }

        if( !$btn ) 
        {
            $data = array( "balance" => $reward_data["balance"], "score" => $reward_data["score"], "coupon" => count($reward_data["coupon"]) );
            $this->sendmessage($data);
        }

        if( empty($reward_data) ) 
        {
            return false;
        }

        $rewarded = array(  );
        if( !empty($reward_data["balance"]) ) 
        {
            m("member")->setCredit($openid, "credit2", $reward_data["balance"], array( 0, "完成任务余额+" . $reward_data["balance"] ));
        }

        if( !empty($reward_data["score"]) ) 
        {
            m("member")->setCredit($openid, "credit1", $reward_data["score"], array( 0, "完成任务积分+" . $reward_data["score"] ));
        }

        if( !empty($reward_data["redpacket"]) ) 
        {
            if( $btn ) 
            {
                $tid = rand(1, 1000) . time() . rand(1, 10000);
                $params = array( "openid" => $openid, "tid" => $tid, "send_name" => "任务完成奖励", "money" => floatval($reward_data["redpacket"]), "wishing" => "任务完成奖励", "act_name" => "任务完成奖励", "remark" => "任务完成奖励" );
                $err = m("common")->sendredpack($params);
                if( is_error($err) ) 
                {
                    $rewarded["redpacket"] = $reward_data["redpacket"];
                    show_json(0, $err["message"]);
                }

            }
            else
            {
                $rewarded["redpacket"] = $reward_data["redpacket"];
            }

        }

        if( !empty($reward_data["coupon"]) && is_array($reward_data["coupon"]) ) 
        {
            foreach( $reward_data["coupon"] as $k => $v ) 
            {
                $data = array( "uniacid" => $_W["uniacid"], "merchid" => 0, "openid" => $openid, "couponid" => $v["id"], "gettype" => 7, "gettime" => time(), "senduid" => $_W["uid"] );
                pdo_insert("ewei_shop_coupon_data", $data);
            }
        }

        if( !empty($reward_data["goods"]) ) 
        {
            $rewarded["goods"] = $reward_data["goods"];
        }

        $rewarded = serialize($rewarded);
        pdo_update("ewei_shop_task_extension_join", array( "rewarded" => $rewarded ), array( "id" => $rewardid, "uniacid" => $_W["uniacid"] ));
    }

    public function getNewTask($id)
    {
        global $_W;
        $openid = $_W["openid"];
        $member = m("member")->getInfo($openid);
        $nowtime = time();
        $sql = "SELECT * FROM " . tablename("ewei_shop_task") . " WHERE id = :id AND status = 1 AND starttime < " . $nowtime . " AND endtime >" . $nowtime . " AND uniacid = :uniacid";
        $task = pdo_fetch($sql, array( ":id" => $id, ":uniacid" => $_W["uniacid"] ));
        if( empty($task) ) 
        {
            return "任务不存在";
        }

        $can = $this->taskFilter($task);
        if( is_string($can) ) 
        {
            return $can;
        }

        $data = array(  );
        $data["uniacid"] = $_W["uniacid"];
        $data["uid"] = $member["id"];
        $data["title"] = $task["title"];
        $data["taskid"] = $id;
        $data["openid"] = $_W["openid"];
        $progress = unserialize($task["require_data"]);
        foreach( $progress as $p => $v ) 
        {
            $progress[$p]["num"] = 0;
        }
        $progress = serialize($progress);
        $data["progress_data"] = $progress;
        $data["require_data"] = $task["require_data"];
        $data["reward_data"] = $task["reward_data"];
        $data["pickuptime"] = time();
        $data["endtime"] = $task["endtime"];
        if( 0 < $task["timelimit"] ) 
        {
            $data["endtime"] = $data["pickuptime"] + intval($task["timelimit"] * 3600);
        }

        $data["dotime"] = $task["dotime"];
        $data["logo"] = $task["logo"];
        pdo_insert("ewei_shop_task_extension_join", $data);
        return intval(pdo_insertid());
    }

    public function getTaskLixt($action, $page)
    {
        global $_W;
        switch( $action ) 
        {
            case "single":
                $type = 1;
                break;
            case "repeat":
                $type = 2;
                break;
            case "first":
                $type = 3;
                break;
            case "period":
                $type = 4;
                break;
            case "point":
                $type = 5;
                break;
            default:
                return false;
        }
        $psize = 20;
        $pstart = ($page - 1) * $psize;
        $sql = "SELECT id,title,starttime,endtime,status FROM " . tablename("ewei_shop_task") . " WHERE `type` = :type AND uniacid = :uniacid ORDER BY endtime DESC LIMIT " . $pstart . "," . $psize;
        return pdo_fetchall($sql, array( ":uniacid" => $_W["uniacid"], ":type" => $type ));
    }

    public function taskFilter($task)
    {
        global $_W;
        $type = $task["type"];
        if( time() < $task["starttime"] || $task["endtime"] < time() || empty($task["status"]) ) 
        {
            return "不是接任务的时间";
        }

        switch( $type ) 
        {
            case 1:
                $sql = "SELECT COUNT(*) FROM " . tablename("ewei_shop_task_extension_join") . " WHERE taskid = :taskid AND openid = :openid AND uniacid = :uniacid";
                $all = pdo_fetchcolumn($sql, array( ":taskid" => $task["id"], ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
                if( !empty($all) ) 
                {
                    return "已参加过";
                }

                break;
            case 2:
                $sql = "SELECT COUNT(*) FROM " . tablename("ewei_shop_task_extension_join") . " WHERE taskid = :taskid AND openid = :openid AND completetime = 0 AND uniacid = :uniacid";
                $res = pdo_fetchcolumn($sql, array( ":taskid" => $task["id"], ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
                if( !empty($res) ) 
                {
                    return "任务未完成不能继续领";
                }

                $sql1 = "SELECT completetime FROM " . tablename("ewei_shop_task_extension_join") . " WHERE taskid = :taskid AND openid = :openid AND uniacid = :uniacid ORDER BY completetime DESC";
                $completetime = pdo_fetchcolumn($sql1, array( ":taskid" => $task["id"], ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
                $cantime = $task["repeat"] + $completetime;
                if( time() < $cantime ) 
                {
                    return ("请在" . $cantime - time()) . "秒后领取";
                }

                $hourl = date("Y-m-d H:00:00", time());
                $hourr = date("Y-m-d H:59:59", time());
                $hourl = strtotime($hourl);
                $hourr = strtotime($hourr);
                $sql2 = "SELECT COUNT(*) FROM " . tablename("ewei_shop_task_extension_join") . " WHERE taskid = :taskid AND uniacid = :uniacid AND openid = :openid AND completetime > " . $hourl . " AND completetime < " . $hourr . " AND completetime != 0";
                $num = pdo_fetchcolumn($sql2, array( ":taskid" => $task["id"], ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
                if( $task["maxtimes"] < $num ) 
                {
                    return "每" . $task["everyhours"] . "小时只能接" . $task["maxtimes"] . "次任务";
                }

                break;
            case 3:
                $sql = "SELECT COUNT(*) FROM " . tablename("ewei_shop_task_extension_join") . " WHERE taskid = :taskid AND openid = :openid AND  uniacid = :uniacid";
                $all = pdo_fetchcolumn($sql, array( ":taskid" => $task["id"], ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
                if( !empty($all) ) 
                {
                    return "已参加过";
                }

                break;
            case 4:
                return "周期任务可由重复任务替代";
            case 5:
                return "目标任务暂不开放";
            default:
                return "任务类型不存在";
        }
    }

    public function getRecordsList($page, $taskid)
    {
        global $_W;
        $psize = 20;
        $pstart = ($page - 1) * $psize;
        $sql = "SELECT * FROM " . tablename("ewei_shop_task_log") . " WHERE taskid = :taskid AND uniacid = :uniacid ORDER BY id DESC LIMIT " . $pstart . "," . $psize;
        return pdo_fetch($sql, array( ":taskid" => $taskid, ":uniacid" => $_W["uniacid"] ));
    }

    public function checkFirst($taskclass)
    {
        global $_W;
        $funcname = "first" . $taskclass;
        return $this->$funcname();
    }

    public function firstcommission_member()
    {
    }

    /**
     * 获得全部任务列表
     */

    public function getUserTaskList($type)
    {
        global $_W;
        $time = time();
        $condition = " AND `type` = 2 ";
        if( $type == 1 ) 
        {
            $condition = "AND ( `type` = 3 OR `type` = 1) ";
        }

        $sql = "SELECT * FROM " . tablename("ewei_shop_task") . " WHERE status = 1 " . $condition . " AND starttime < " . $time . " AND endtime > " . $time . " AND uniacid = :uniacid";
        return pdo_fetchall($sql, array( ":uniacid" => $_W["uniacid"] ));
    }

    /**
     * @param string $condition
     * @return array
     */

    public function getMyTaskList($condition = "=")
    {
        global $_W;
        $condition2 = "";
        if( $condition == "=" ) 
        {
            $condition2 .= " AND  a.endtime > " . time();
        }

        $sql = "SELECT a.* FROM " . tablename("ewei_shop_task_extension_join") . " a JOIN " . tablename("ewei_shop_task") . " b ON a.taskid = b.id WHERE a.openid = :openid AND a.completetime " . $condition . " 0 " . $condition2 . " AND a.uniacid = :uniacid";
        return pdo_fetchall($sql, array( ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
    }

    public function failTask()
    {
        global $_W;
        $sql = "SELECT a.* FROM " . tablename("ewei_shop_task_extension_join") . " a JOIN " . tablename("ewei_shop_task") . " b ON a.taskid = b.id WHERE a.openid = :openid AND a.completetime = 0 AND a.endtime < " . time() . " AND a.uniacid = :uniacid";
        return pdo_fetchall($sql, array( ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
    }

    public function returnName($taskclass)
    {
        if( strpos("1" . $taskclass, "cost_goods") ) 
        {
            return "购买指定商品";
        }

        $sql = "SELECT taskname FROM " . tablename("ewei_shop_task_extension") . " WHERE taskclass = :taskclass";
        return pdo_fetchcolumn($sql, array( ":taskclass" => $taskclass ));
    }

    public function returnGoodsName($id)
    {
        global $_W;
        $sql = "SELECT title FROM " . tablename("ewei_shop_goods") . " WHERE id = :id AND uniacid = :uniacid";
        $res = pdo_fetchcolumn($sql, array( ":id" => $id, ":uniacid" => $_W["uniacid"] ));
        return $res;
    }

    public function returnTaskname($taskclass)
    {
        $sql = "SELECT taskname FROM " . tablename("ewei_shop_task_extension") . " WHERE taskclass = :taskclass";
        return pdo_fetchcolumn($sql, array( ":taskclass" => $taskclass ));
    }

    public function sendmessage($data)
    {
        global $_W;
        if( $data["score"] ) 
        {
            $score = "已发放" . $data["score"] . "积分，";
        }

        if( $data["balance"] ) 
        {
            $balance = (string) $data["balance"] . "余额，";
        }

        if( $data["coupon"] ) 
        {
            $coupon = (string) $data["coupon"] . "种优惠券，";
        }

        $message = "任务完成通知\n\r\n\r任务已完成，" . $score . $balance . $coupon . "剩余未发放奖励请到我的任务中领取\n\r\n\r<a href='" . mobileUrl("task.mytask", NULL, 1) . "'>点击查看详情</a>";
        m("message")->sendCustomNotice($_W["openid"], $message);
    }

    public function __construct($name = "")
    {
        parent::__construct($name);
        $this->taskType = pdo_getall("ewei_shop_task_type");
    }

    /**
     * 得到task_type详情
     * @param string $type
     * @return array|mixed
     */

    public function getTaskType($type = "")
    {
        if( empty($type) ) 
        {
            return $this->taskType;
        }

        foreach( $this->taskType as $tasktype ) 
        {
            if( $tasktype["type_key"] == $type ) 
            {
                return $tasktype;
            }

        }
        return false;
    }

    /**
     * web 分页查询所有任务
     * @param $page
     * @param int $psize
     * @return array|boolean
     */

    public function getAllTask(&$page, $psize = 15)
    {
        global $_W;
        global $_GPC;
        $page = max(1, $page);
        $pstart = ($page - 1) * $psize;
        $params = array( ":uniacid" => $_W["uniacid"] );
        $type = trim($_GPC["type"]);
        $keyword = trim($_GPC["keyword"]);
        $condition = "";
        if( !empty($type) || !empty($keyword) ) 
        {
            $condition = " and `title` like '%" . $keyword . "%' and `type` like '%" . $type . "%' ";
        }

        $field = "id,displayorder,title,image,type,starttime,endtime,status";
        $sql = "select " . $field . " from " . tablename("ewei_shop_task_list") . " where uniacid = :uniacid " . $condition . "  order by displayorder desc,id desc limit " . $pstart . " , " . $psize;
        $return = pdo_fetchall($sql, $params);
        $countsql = substr($sql, 0, strpos($sql, "order by"));
        $countsql = str_replace($field, "count(*)", $countsql);
        $count = pdo_fetchcolumn($countsql, $params);
        $page = pagination2($count, $page, $psize);
        return $return;
    }

    /**
     * task插件公用save方法,添加/编辑任务表
     * @param $table
     * @param $task
     * @param bool $Update 是否支持更新
     * @return bool
     */

    public function taskSave($table, $task, $Update = true)
    {
        global $_W;
        $this->checkDbFormat($table, $task);
        if( !is_array($task) ) 
        {
            return false;
        }

        $task["uniacid"] = intval($_W["uniacid"]);
        $isIdKey = in_array("id", $this->$table);
        if( empty($task["id"]) && $isIdKey ) 
        {
            pdo_insert($table, $task);
            return pdo_insertid();
        }

        if( !$isIdKey ) 
        {
            $countSql = "select count(*) from " . tablename($table) . " where uniacid = :uniacid";
            $ifExist = pdo_fetchcolumn($countSql, array( "uniacid" => $_W["uniacid"] ));
            if( $ifExist && $Update ) 
            {
                pdo_update($table, $task, array( "uniacid" => $_W["uniacid"] ));
                if( empty($task["id"]) ) 
                {
                    return $_W["uniacid"];
                }

                return $task["id"];
            }

            if( !$ifExist ) 
            {
                pdo_insert($table, $task);
                return pdo_insertid();
            }

            return false;
        }

        if( $Update ) 
        {
            pdo_update($table, $task, array( "id" => $task["id"] ));
            if( empty($task["id"]) ) 
            {
                return $_W["uniacid"];
            }

            return $task["id"];
        }

        return false;
    }

    /**
     * 校验数据库字段
     * @param $task
     */

    protected function checkDbFormat($table, &$task)
    {
        if( !is_array($task) || !is_array($this->$table) ) 
        {
            return $task = false;
        }

        $field = array_flip($this->$table);
        $diff = array_diff_key($task, $field);
        if( !empty($diff) ) 
        {
            return $task = false;
        }

        foreach( $task as &$t ) 
        {
            if( is_array($t) ) 
            {
                $t = json_encode($t);
            }

        }
        return true;
    }

    /**
     * 删除任务
     * @param $ids
     * @return bool
     */

    public function deleteTask($ids)
    {
        $isArr = is_array($ids);
        $isNum = is_numeric($ids);
        if( $isNum ) 
        {
            $ids = array( $ids );
            $isArr = true;
        }

        if( $isArr ) 
        {
            $condition = " id = '" . implode(" ' or id = '", $ids) . "'";
            return pdo_query("delete from " . tablename("ewei_shop_task_list") . " where " . $condition);
        }

        if( !$isArr && !$isNum ) 
        {
            return false;
        }

    }

    /**
     * 得到任务By id
     * @param $id
     * @return bool
     */

    public function getThisTask($id)
    {
        global $_W;
        if( empty($id) ) 
        {
            return false;
        }

        return pdo_get("ewei_shop_task_list", array( "id" => $id, "uniacid" => $_W["uniacid"] ));
    }

    /**
     * 分页获取任务记录
     * @param $page
     * @param int $psize
     * @return array
     */

    public function getAllRecords(&$page, $psize = 20)
    {
        global $_W;
        global $_GPC;
        $page = max(1, $page);
        $pstart = ($page - 1) * $psize;
        $params = array( ":uniacid" => $_W["uniacid"] );
        $condition = "";
        $keyword = trim($_GPC["keyword"]);
        !empty($keyword) and $starttime = $_GPC["time"]["start"];
        !empty($starttime) and $endtime = $_GPC["time"]["end"];
        !empty($endtime) and $field = "*";
        $sql = "select " . $field . " from " . tablename("ewei_shop_task_record") . "where uniacid = :uniacid " . $condition . " order by id desc limit " . $pstart . " , " . $psize;
        $return = pdo_fetchall($sql, $params);
        $countsql = substr($sql, 0, strpos($sql, "order by"));
        $countsql = str_replace($field, "count(*)", $countsql);
        $count = pdo_fetchcolumn($countsql, $params);
        $page = pagination2($count, $page, $psize);
        return $return;
    }

    /**
     * 分页获取奖励记录
     * @param $page
     * @param int $psize
     * @return array
     */

    public function getAllRewards(&$page, $psize = 20)
    {
        global $_W;
        global $_GPC;
        $page = max(1, $page);
        $pstart = ($page - 1) * $psize;
        $params = array( ":uniacid" => $_W["uniacid"] );
        $condition = "";
        $keyword = trim($_GPC["keyword"]);
        !empty($keyword) and $starttime = $_GPC["time"]["start"];
        !empty($starttime) and $endtime = $_GPC["time"]["end"];
        !empty($endtime) and $field = "*";
        $sql = "select " . $field . " from " . tablename("ewei_shop_task_reward") . " where uniacid = :uniacid " . $condition . " and `get` = 1 order by id desc limit " . $pstart . " , " . $psize;
        $return = pdo_fetchall($sql, $params);
        $countsql = substr($sql, 0, strpos($sql, "order by"));
        $countsql = str_replace($field, "count(*)", $countsql);
        $count = pdo_fetchcolumn($countsql, $params);
        $page = pagination2($count, $page, $psize);
        return $return;
    }

    /**
     * 分页获取商品
     * @param string $keyword
     * @param int $page
     */

    public function getGoods_new($keyword = "", $page = 1)
    {
        global $_W;
        $psize = 10;
        $pstart = ($page - 1) * $psize;
        $field = "id,title,thumb,marketprice,total";
        $like = ($keyword === "" ? $keyword : " and title like %" . $keyword . "%");
        $sql = "select " . $field . " from " . tablename("ewei_shop_goods") . "where uniacid = :uniacid and status = 1 and deleted = 0" . $like . " limit " . $pstart . " , " . $psize;
        $countsql = substr($sql, 0, strpos($sql, "limit"));
        $countsql = str_replace($field, "count(*)", $countsql);
        $params = array( ":uniacid" => $_W["uniacid"] );
        $count = pdo_fetchcolumn($countsql, $params);
        $list = pdo_fetchall($sql, $params);
        show_json($count, $list);
    }

    /**
     * 分页获取优惠券
     * @param string $keyword
     * @param int $page
     */

    public function getCoupon($keyword = "", $page = 1)
    {
        global $_W;
        $psize = 10;
        $pstart = ($page - 1) * $psize;
        $field = "id,couponname";
        $like = ($keyword === "" ? $keyword : " and title like %" . $keyword . "%");
        $sql = "select " . $field . " from " . tablename("ewei_shop_coupon") . "where uniacid = :uniacid " . $like . " limit " . $pstart . " , " . $psize;
        $countsql = substr($sql, 0, strpos($sql, "limit"));
        $countsql = str_replace($field, "count(*)", $countsql);
        $params = array( ":uniacid" => $_W["uniacid"] );
        $count = pdo_fetchcolumn($countsql, $params);
        $list = pdo_fetchall($sql, $params);
        show_json($count, $list);
    }

    protected function stoptime($task)
    {
        global $_W;
        $time = time();
        $stoptime = "0000-00-00 00:00:00";
        if( $task["picktype"] == 1 ) 
        {
            return $task["endtime"];
        }

        if( $task["stop_type"] == 1 ) 
        {
            $stoptime = date("Y-m-d H:i:s", $time + $task["stop_limit"]);
        }
        else
        {
            if( $task["stop_type"] == 2 ) 
            {
                $stoptime = $task["stop_time"];
            }
            else
            {
                if( $task["stop_type"] == 3 ) 
                {
                    switch( $task["stop_cycle"] ) 
                    {
                        case "0":
                            $stoptime = date("Y-m-d 00:00:00", strtotime("+1 day"));
                            break;
                        case "1":
                            $stoptime = date("Y-m-d 00:00:00", strtotime("next Monday"));
                            break;
                        case "2":
                            $stoptime = date("Y-m-d 00:00:00", mktime(0, 0, 0, date("n") + 1, 1, date("Y")));
                            break;
                    }
                }

            }

        }

        return $stoptime;
    }

    /**
     * 接任务
     * @param $listid
     * @param $openid
     * @return int
     */

    public function pickTask($taskid, $openid)
    {
        global $_W;
        empty($openid) and $task = $this->getThisTask($taskid);
        $info = m("member")->getInfo($openid);
        if( empty($task) ) 
        {
            return error(-1, "任务不存在");
        }

        $canPick = $this->checkCanPick($task, $openid);
        if( is_error($canPick) ) 
        {
            return $canPick;
        }

        $stoptime = $this->stoptime($task);
        $taskArr = array( "uniacid" => $_W["uniacid"], "taskid" => $task["id"], "tasktitle" => $task["title"], "tasktype" => $task["type"], "openid" => $openid, "nickname" => $info["nickname"], "picktime" => date("Y-m-d H:i:s"), "task_demand" => max((int) $task["demand"], (int) $task["level2"], (int) $task["level3"]), "taskimage" => $task["image"], "reward_data" => $task["reward"], "followreward_data" => $task["followreward"], "design_data" => $task["design_data"], "design_bg" => $task["design_bg"], "stoptime" => $stoptime, "require_goods" => $task["requiregoods"], "member_group" => $task["member_group"], "auto_pick" => $task["auto_pick"] );
        if( $task["type"] == "poster" && 0 < $task["level2"] ) 
        {
            $taskArr["level1"] = $task["demand"];
            $taskArr["reward_data1"] = $task["reward"];
            $taskArr["level2"] = $task["level2"];
            $taskArr["reward_data2"] = $task["reward2"];
            if( 0 < $task["level3"] ) 
            {
                $taskArr["reward_data"] = $task["reward3"];
            }
            else
            {
                $taskArr["reward_data"] = $task["reward2"];
            }

        }

        $table = "ewei_shop_task_record";
        $recordid = $this->taskSave($table, $taskArr, false);
        if( !$recordid ) 
        {
            return error(1, "任务接取失败了");
        }

        $reward = json_decode($task["reward"], true);
        $level = 0;
        if( $task["type"] === "poster" && (0 < $task["level3"] || 0 < $task["level2"]) ) 
        {
            $level = 1;
        }

        if( is_array($reward) ) 
        {
            foreach( $reward as $ke => $re ) 
            {
                if( is_array($re) ) 
                {
                    foreach( $re as $r ) 
                    {
                        while( 0 < $r["num"] ) 
                        {
                            pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $task["id"], "tasktitle" => $task["title"], "tasktype" => $task["type"], "taskowner" => $openid, "ownernickname" => $info["nickname"], "recordid" => $recordid, "reward_type" => $ke, "reward_data" => $r["id"], "nickname" => $info["nickname"], "openid" => $info["openid"], "headimg" => $info["avatar"], "reward_title" => ($ke == "coupon" ? $r["couponname"] : $r["title"]), "price" => ($task["type"] == "coupon" ? 0 : $r["price"]), "level" => $level ));
                            $r["num"]--;
                        }
                    }
                }
                else
                {
                    if( $re ) 
                    {
                        if( $ke == "credit" ) 
                        {
                            $reward_title = "积分";
                        }
                        else
                        {
                            if( $ke == "balance" ) 
                            {
                                $reward_title = "元余额";
                            }
                            else
                            {
                                if( $ke == "redpacket" ) 
                                {
                                    $reward_title = "元微信红包";
                                }

                            }

                        }

                        pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $task["id"], "tasktitle" => $task["title"], "tasktype" => $task["type"], "taskowner" => $openid, "ownernickname" => $info["nickname"], "recordid" => $recordid, "reward_type" => $ke, "reward_data" => $re, "nickname" => $info["nickname"], "openid" => $info["openid"], "headimg" => $info["avatar"], "reward_title" => $re . $reward_title, "level" => $level ));
                    }

                }

            }
        }

        $level = 2;
        if( $task["type"] === "poster" && $task["level3"] == 0 ) 
        {
            $level = 0;
        }

        $reward2 = json_decode($task["reward2"], true);
        if( is_array($reward2) ) 
        {
            foreach( $reward2 as $ke => $re ) 
            {
                if( is_array($re) ) 
                {
                    foreach( $re as $r ) 
                    {
                        while( 0 < $r["num"] ) 
                        {
                            pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $task["id"], "tasktitle" => $task["title"], "tasktype" => $task["type"], "taskowner" => $openid, "ownernickname" => $info["nickname"], "recordid" => $recordid, "reward_type" => $ke, "reward_data" => $r["id"], "nickname" => $info["nickname"], "openid" => $info["openid"], "headimg" => $info["avatar"], "reward_title" => ($ke == "coupon" ? $r["couponname"] : $r["title"]), "price" => ($task["type"] == "coupon" ? 0 : $r["price"]), "level" => $level ));
                            $r["num"]--;
                        }
                    }
                }
                else
                {
                    if( $re ) 
                    {
                        if( $ke == "credit" ) 
                        {
                            $reward_title = "积分";
                        }
                        else
                        {
                            if( $ke == "balance" ) 
                            {
                                $reward_title = "元余额";
                            }
                            else
                            {
                                if( $ke == "redpacket" ) 
                                {
                                    $reward_title = "元微信红包";
                                }

                            }

                        }

                        pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $task["id"], "tasktitle" => $task["title"], "tasktype" => $task["type"], "taskowner" => $openid, "ownernickname" => $info["nickname"], "recordid" => $recordid, "reward_type" => $ke, "reward_data" => $re, "nickname" => $info["nickname"], "openid" => $info["openid"], "headimg" => $info["avatar"], "reward_title" => $re . $reward_title, "level" => $level ));
                    }

                }

            }
        }

        $reward3 = json_decode($task["reward3"], true);
        if( is_array($reward3) ) 
        {
            foreach( $reward3 as $ke => $re ) 
            {
                if( is_array($re) ) 
                {
                    foreach( $re as $r ) 
                    {
                        while( 0 < $r["num"] ) 
                        {
                            pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $task["id"], "tasktitle" => $task["title"], "tasktype" => $task["type"], "taskowner" => $openid, "ownernickname" => $info["nickname"], "recordid" => $recordid, "reward_type" => $ke, "reward_data" => $r["id"], "nickname" => $info["nickname"], "openid" => $info["openid"], "headimg" => $info["avatar"], "reward_title" => ($ke == "coupon" ? $r["couponname"] : $r["title"]), "price" => ($task["type"] == "coupon" ? 0 : $r["price"]), "level" => 0 ));
                            $r["num"]--;
                        }
                    }
                }
                else
                {
                    if( $re ) 
                    {
                        if( $ke == "credit" ) 
                        {
                            $reward_title = "积分";
                        }
                        else
                        {
                            if( $ke == "balance" ) 
                            {
                                $reward_title = "元余额";
                            }
                            else
                            {
                                if( $ke == "redpacket" ) 
                                {
                                    $reward_title = "元微信红包";
                                }

                            }

                        }

                        pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $task["id"], "tasktitle" => $task["title"], "tasktype" => $task["type"], "taskowner" => $openid, "ownernickname" => $info["nickname"], "recordid" => $recordid, "reward_type" => $ke, "reward_data" => $re, "nickname" => $info["nickname"], "openid" => $info["openid"], "headimg" => $info["avatar"], "reward_title" => $re . $reward_title, "level" => 0 ));
                    }

                }

            }
        }

        $taskArr["id"] = $recordid;
        $taskArr["stoptime"] = $stoptime;
        if( $task["type"] == "poster" ) 
        {
            $this->posterPickMessage($openid, $taskArr);
            $taskArr["design_data"] = $task["design_data"];
            $taskArr["design_bg"] = $task["design_bg"];
            if( $_W["ispost"] && !empty($_POST["openid"]) ) 
            {
                $poster = $this->create_poster(array( "id" => $taskArr["id"], "design_data" => $taskArr["design_data"], "design_bg" => $taskArr["design_bg"], "stoptime" => $taskArr["stoptime"] ));
                $this->send2wechat($recordid, $openid);
            }

        }
        else
        {
            $this->taskPickMessage($openid, $taskArr);
        }

        return $recordid;
    }

    public function send2wechat($recordid, $openid = "")
    {
        global $_W;
        global $_GPC;
        if( empty($openid) ) 
        {
            $openid = $_W["openid"];
        }

        if( empty($openid) ) 
        {
            show_json(0, "缺少用户身份标识");
        }

        $sql = "SELECT `follow` FROM " . tablename("mc_mapping_fans") . " WHERE openid = :openid AND uniacid = :uniacid";
        $isFollowed = pdo_fetchcolumn($sql, array( ":openid" => $openid, ":uniacid" => $_W["uniacid"] ));
        if( !$isFollowed ) 
        {
            show_json(0, "未关注公众号无法接收海报");
        }

        $mediaid = pdo_fetchcolumn("select mediaid from " . tablename("ewei_shop_task_qr") . " where recordid = :recordid", array( ":recordid" => $recordid ));
        $ret = m("message")->sendImage($openid, $mediaid);
        if( is_error($ret) ) 
        {
            show_json(0, $ret["message"]);
        }

        show_json(1);
    }

    public function create_poster($poster, $openid = "")
    {
        global $_W;
        if( empty($openid) ) 
        {
            $openid = $_W["openid"];
        }

        $info = m("member")->getInfo($openid);
        $img = $this->createPoster2($poster, $info);
        if( is_error($img) ) 
        {
            return error(-1, $img["message"]);
        }

        return error(0, $img);
    }

    /**
     * 检查是否可以接取任务
     * @param $task
     * @param $openid
     * @return bool
     */

    protected function checkCanPick($task, $openid)
    {
        global $_W;
        global $_GPC;
        if( empty($openid) ) 
        {
            $openid = $_W["openid"];
        }

        if( empty($openid) ) 
        {
            return error(1, "请先登录");
        }

        if( substr($task["type"], 0, 7) == "pyramid" && !p("commission")->isAgent($openid) ) 
        {
            return error(1, "只有分销商能接此任务");
        }

        $time = time();
        if( $time < $task["starttime"] ) 
        {
            return error(-1, "任务尚未开放");
        }

        if( $time < $task["endtime"] ) 
        {
            return error(-1, "任务已结束");
        }

        $sql = "select * from " . tablename("ewei_shop_task_record") . " where openid = :openid and taskid = :taskid and uniacid = :uniacid order by id desc";
        $lastRecord = pdo_fetch($sql, array( ":openid" => $openid, ":taskid" => $task["id"], ":uniacid" => $_W["uniacid"] ));
        if( empty($lastRecord) ) 
        {
            return true;
        }

        if( $task["repeat_type"] == 1 ) 
        {
            return error(-1, "不能重复接此任务");
        }

        $finishtime = strtotime($lastRecord["finishtime"]);
        $stoptime = strtotime($lastRecord["stoptime"]);
        if( $finishtime < 0 && ($time < $stoptime || $stoptime < 0) ) 
        {
            if( $_W["ispost"] && !empty($_GPC["openid"]) ) 
            {
                $this->send2wechat($lastRecord["id"], $_GPC["openid"]);
            }

            return error(-1, "任务未完成，不能重复领取");
        }

        if( 0 < $finishtime ) 
        {
            $compareTime = $finishtime;
        }
        else
        {
            if( $time < $stoptime ) 
            {
                $compareTime = $stoptime;
            }

        }

        if( $task["repeat_type"] == 0 ) 
        {
            return true;
        }

        if( $task["repeat_type"] == 2 ) 
        {
            if( $task["repeat_interval"] < $time - $compareTime ) 
            {
                return true;
            }

            return error(-1, $task["repeat_interval"] . "秒后才能再接此任务");
        }

        if( $task["repeat_type"] == 3 ) 
        {
            if( $task["repeat_cycle"] == 1 ) 
            {
                if( 86400 < (int) strtotime(date("Ymd")) - (int) strtotime(date("Ymd", $compareTime)) ) 
                {
                    return true;
                }

                return error(-1, "明天才能再接此任务");
            }

            if( $task["repeat_cycle"] == 2 ) 
            {
                $w = date("w", $compareTime);
                $w == 0 and $between = $this->diffBetweenTwoDays($compareTime, $time);
                if( 7 < $w + $between ) 
                {
                    return true;
                }

                return error(-1, "下个周才能再接此任务");
            }

            if( $task["repeat_cycle"] == 3 ) 
            {
                if( 0 < date("Ym") - date("Ym", $compareTime) ) 
                {
                    return true;
                }

                return error(-1, "下个月才可以再接此任务");
            }

            return true;
        }

        return error(-1, "重复领取类型不详");
    }

    /**
     * 两天相差的天数
     * @param $day1
     * @param $day2
     * @return float|int
     */

    protected function diffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime(date("Y-m-d", $day1));
        $second2 = strtotime(date("Y-m-d", $day2));
        if( $second1 < $second2 ) 
        {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }

        return ($second1 - $second2) / 86400;
    }

    protected function createPoster2($poster, $member = 0, $upload = true)
    {
        global $_W;
        if( empty($member["openid"]) ) 
        {
            $member = m("member")->getMember($_W["openid"]);
        }

        $path = IA_ROOT . "/addons/ewei_shopv2/data/task/poster/" . $_W["uniacid"] . "/";
        while( !is_dir($path) ) 
        {
            load()->func("file");
            mkdirs($path);
        }
        $qr = $this->getQR2($poster, $member);
        if( is_error($qr) ) 
        {
            return $qr;
        }

        $md5 = md5(json_encode(array( "recordid" => $poster["id"], "openid" => $member["openid"], "bg" => $poster["design_bg"], "data" => $poster["design_data"] )));
        $file = $md5 . ".png";
        $NoFile = !is_file($path . $file);
        if( $NoFile ) 
        {
            set_time_limit(0);
            @ini_set("memory_limit", "256M");
            $width = 640;
            $height = 1008;
            $target = imagecreatetruecolor($width, $height);
            $color = imagecolorallocate($target, 255, 255, 255);
            imagefill($target, 0, 0, $color);
            $bg = $this->createImage2(tomedia($poster["design_bg"]));
            if( empty($poster["design_bg"]) ) 
            {
                $width_orig = $width;
                $height_orig = $height;
            }
            else
            {
                list($width_orig, $height_orig) = getimagesize(tomedia($poster["design_bg"]));
            }

            if( $width && $width_orig < $height_orig ) 
            {
                $width = $height / $height_orig * $width_orig;
            }
            else
            {
                $height = $width / $width_orig * $height_orig;
            }

            imagecopyresampled($target, $bg, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagedestroy($bg);
            $data = json_decode(str_replace("&quot;", "'", $poster["design_data"]), true);
            if( empty($data) ) 
            {
                return error(-1, "数据不完整,处理失败");
            }

            foreach( $data as $d ) 
            {
                $d = $this->getRealData2($d);
                if( $d["type"] == "head" ) 
                {
                    $avatar = preg_replace("/\\/0\$/i", "/96", $member["avatar"]);
                    $target = $this->mergeImage2($target, $d, $avatar);
                }
                else
                {
                    if( $d["type"] == "time" ) 
                    {
                        if( $poster["stoptime"] == "0000-00-00 00:00:00" ) 
                        {
                            $time = "无限制";
                        }
                        else
                        {
                            $time = date("Y-m-d H:i", strtotime($poster["stoptime"]));
                        }

                        $target = $this->mergeText2($target, $d, "到期时间:" . $time);
                    }
                    else
                    {
                        if( $d["type"] == "img" ) 
                        {
                            $target = $this->mergeImage2($target, $d, $d["src"]);
                        }
                        else
                        {
                            if( $d["type"] == "qr" ) 
                            {
                                $target = $this->mergeImage2($target, $d, "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $qr["ticket"]);
                            }
                            else
                            {
                                if( $d["type"] == "nickname" ) 
                                {
                                    $target = $this->mergeText2($target, $d, $member["nickname"]);
                                }

                            }

                        }

                    }

                }

            }
            imagepng($target, $path . $file);
            imagedestroy($target);
        }

        $img = $_W["siteroot"] . "addons/ewei_shopv2/data/task/poster/" . $_W["uniacid"] . "/" . $file;
        if( !$upload ) 
        {
            return $img;
        }

        if( empty($qr["mediaid"]) ) 
        {
            $mediaid = $this->uploadImage2($path . $file);
            $qr["mediaid"] = $mediaid;
            $qr["img"] = $mediaid;
            pdo_update("ewei_shop_task_qr", array( "mediaid" => $mediaid ), array( "id" => $qr["id"] ));
        }

        return array( "img" => $img, "mediaid" => $qr["mediaid"] );
    }

    protected function getRealData2($data)
    {
        $data["left"] = intval(str_replace("px", "", $data["left"])) * 2;
        $data["top"] = intval(str_replace("px", "", $data["top"])) * 2;
        $data["width"] = intval(str_replace("px", "", $data["width"])) * 2;
        $data["height"] = intval(str_replace("px", "", $data["height"])) * 2;
        $data["size"] = intval(str_replace("px", "", $data["size"])) * 2;
        $data["src"] = tomedia($data["src"]);
        return $data;
    }

    protected function getQR2($poster, $member)
    {
        global $_W;
        $time = time();
        $expire = strtotime($poster["stoptime"]) - $time;
        if( 86400 * 30 - 15 < $expire ) 
        {
            $scene_id = "t" . time() . rand(100000, 999999);
        }

        $this->createRule();
        $qr = pdo_fetch("select * from " . tablename("ewei_shop_task_qr") . " where openid = :openid and uniacid = :uniacid and recordid = :recordid limit 1", array( ":openid" => $member["openid"], ":uniacid" => $_W["uniacid"], ":recordid" => $poster["id"] ));
        if( empty($qr) ) 
        {
            empty($scene_id) and $this->getSceneID2();
            $result = $this->getSceneTicket2($expire, $scene_id);
            if( is_error($result) ) 
            {
                return $result;
            }

            $ims_qrcode = array( "uniacid" => $_W["uniacid"], "acid" => $_W["acid"], "qrcid" => ($scene_id[0] != "t" ? $scene_id : 0), "model" => 0, "name" => "EWEI_SHOPV2_TASKNEW_POSTER", "keyword" => "EWEI_SHOPV2_TASKNEW", "expire" => $expire, "createtime" => time(), "status" => 1, "url" => $result["url"], "ticket" => $result["ticket"], "scene_str" => ($scene_id[0] == "t" ? $scene_id : "") );
            pdo_insert("qrcode", $ims_qrcode);
            $qr = array( "uniacid" => $_W["uniacid"], "openid" => $member["openid"], "sceneid" => $scene_id, "ticket" => $result["ticket"], "recordid" => $poster["id"] );
            pdo_insert("ewei_shop_task_qr", $qr);
            $qr["id"] = pdo_insertid();
        }

        return $qr;
    }

    /**
     * 创建TASKNEW回复规则
     */

    protected function createRule()
    {
        global $_W;
        $ruleSql = "select id from " . tablename("rule") . " where `name` = 'ewei_shopv2:task' and `module` = 'ewei_shopv2' and uniacid = " . $_W["uniacid"];
        $ruleCount = pdo_fetchcolumn($ruleSql);
        if( empty($ruleCount) ) 
        {
            $rule = array( "uniacid" => $_W["uniacid"], "name" => "ewei_shopv2:task", "module" => "ewei_shopv2", "status" => 1 );
            if( 1 < (double) IMS_VERSION ) 
            {
                $rule["reply_type"] = 1;
            }

            pdo_insert("rule", $rule);
            $ruleCount = pdo_insertid();
            if( empty($ruleCount) ) 
            {
                $rule = array( "uniacid" => $_W["uniacid"], "name" => "ewei_shopv2:task", "module" => "ewei_shopv2", "status" => 1 );
                pdo_insert("rule", $rule);
                $ruleCount = pdo_insertid();
            }

        }

        $keywordSql = "select COUNT(*) from " . tablename("rule_keyword") . " where `content` = 'EWEI_SHOPV2_TASKNEW' and uniacid = " . $_W["uniacid"];
        $keywordCount = pdo_fetchcolumn($keywordSql);
        if( empty($keywordCount) ) 
        {
            $keyword = array( "rid" => $ruleCount, "uniacid" => $_W["uniacid"], "module" => "ewei_shopv2", "content" => "EWEI_SHOPV2_TASKNEW", "type" => 1, "status" => 1 );
            pdo_insert("rule_keyword", $keyword);
        }

    }

    public function checkMember2($openid = "", $acc = "")
    {
        global $_W;
        $redis = redis();
        if( empty($acc) ) 
        {
            $acc = WeiXinAccount::create();
        }

        $userinfo = $acc->fansQueryInfo($openid);
        $userinfo["avatar"] = $userinfo["headimgurl"];
        load()->model("mc");
        $uid = mc_openid2uid($openid);
        if( !empty($uid) ) 
        {
            pdo_update("mc_members", array( "nickname" => $userinfo["nickname"], "gender" => $userinfo["sex"], "nationality" => $userinfo["country"], "resideprovince" => $userinfo["province"], "residecity" => $userinfo["city"], "avatar" => $userinfo["headimgurl"] ), array( "uid" => $uid ));
        }

        pdo_update("mc_mapping_fans", array( "nickname" => $userinfo["nickname"] ), array( "uniacid" => $_W["uniacid"], "openid" => $openid ));
        $model = m("member");
        $member = $model->getMember($openid);
        if( empty($member) ) 
        {
            if( !is_error($redis) ) 
            {
                $member = $redis->get($openid . "_task_checkMember");
                if( !empty($member) ) 
                {
                    return json_decode($member, true);
                }

            }

            $mc = mc_fetch($uid, array( "realname", "nickname", "mobile", "avatar", "resideprovince", "residecity", "residedist" ));
            $member = array( "uniacid" => $_W["uniacid"], "uid" => $uid, "openid" => $openid, "realname" => $mc["realname"], "mobile" => $mc["mobile"], "nickname" => (!empty($mc["nickname"]) ? $mc["nickname"] : $userinfo["nickname"]), "avatar" => (!empty($mc["avatar"]) ? $mc["avatar"] : $userinfo["avatar"]), "gender" => (!empty($mc["gender"]) ? $mc["gender"] : $userinfo["sex"]), "province" => (!empty($mc["resideprovince"]) ? $mc["resideprovince"] : $userinfo["province"]), "city" => (!empty($mc["residecity"]) ? $mc["residecity"] : $userinfo["city"]), "area" => $mc["residedist"], "createtime" => time(), "status" => 0 );
            pdo_insert("ewei_shop_member", $member);
            $member["id"] = pdo_insertid();
            $member["isnew"] = true;
            if( method_exists(m("member"), "memberRadisCountDelete") ) 
            {
                m("member")->memberRadisCountDelete();
            }

            if( !is_error($redis) ) 
            {
                $redis->set($openid . "_task_checkMember", json_encode($member), 20);
            }

        }
        else
        {
            $member["nickname"] = $userinfo["nickname"];
            $member["avatar"] = $userinfo["headimgurl"];
            $member["province"] = $userinfo["province"];
            $member["city"] = $userinfo["city"];
            pdo_update("ewei_shop_member", $member, array( "id" => $member["id"] ));
            $member["isnew"] = false;
        }

        return $member;
    }

    protected function createImage2($imgurl)
    {
        load()->func("communication");
        $resp = ihttp_request($imgurl);
        if( $resp["code"] == 200 && !empty($resp["content"]) ) 
        {
            return imagecreatefromstring($resp["content"]);
        }

        for( $i = 0; $i < 3; $i++ ) 
        {
            $resp = ihttp_request($imgurl);
            if( $resp["code"] == 200 && !empty($resp["content"]) ) 
            {
                return imagecreatefromstring($resp["content"]);
            }

        }
        return "";
    }

    protected function mergeImage2($target, $data, $imgurl)
    {
        $img = $this->createImage2($imgurl);
        $w = imagesx($img);
        $h = imagesy($img);
        imagecopyresized($target, $img, $data["left"], $data["top"], 0, 0, $data["width"], $data["height"], $w, $h);
        imagedestroy($img);
        return $target;
    }

    protected function mergeHead2($target, $data, $imgurl)
    {
        if( $data["head_type"] == "default" ) 
        {
            $img = $this->createImage2($imgurl);
            $w = imagesx($img);
            $h = imagesy($img);
            imagecopyresized($target, $img, $data["left"], $data["top"], 0, 0, $data["width"], $data["height"], $w, $h);
            imagedestroy($img);
            return $target;
        }

        if( $data["head_type"] == "circle" ) 
        {
        }
        else
        {
            if( $data["head_type"] == "rounded" ) 
            {
            }

        }

    }

    protected function mergeText2($target, $data, $text)
    {
        $font = IA_ROOT . "/addons/ewei_shopv2/static/fonts/msyh.ttf";
        $colors = $this->hex2rgb2($data["color"]);
        $color = imagecolorallocate($target, $colors["red"], $colors["green"], $colors["blue"]);
        @imagettftext($target, $data["size"], 0, $data["left"], $data["top"] + $data["size"], $color, $font, $text);
        return $target;
    }

    protected function hex2rgb2($colour)
    {
        if( $colour[0] == "#" ) 
        {
            $colour = substr($colour, 1);
        }

        if( strlen($colour) == 6 ) 
        {
            list($r, $g, $b) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        }
        else
        {
            if( strlen($colour) == 3 ) 
            {
                list($r, $g, $b) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
            }
            else
            {
                return false;
            }

        }

        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array( "red" => $r, "green" => $g, "blue" => $b );
    }

    protected function uploadImage2($img)
    {
        load()->func("communication");
        $account = m("common")->getAccount();
        $access_token = $account->fetch_token();
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $access_token . "&type=image";
        $ch1 = curl_init();
        $data = array( "media" => "@" . $img );
        if( version_compare(PHP_VERSION, "5.5.0", ">") ) 
        {
            $data = array( "media" => curl_file_create($img) );
        }

        curl_setopt($ch1, CURLOPT_URL, $url);
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
        $content = @json_decode(@curl_exec($ch1), true);
        if( !is_array($content) ) 
        {
            $content = array( "media_id" => "" );
        }

        curl_close($ch1);
        return $content["media_id"];
    }

    protected function getSceneID2()
    {
        global $_W;
        $acid = $_W["acid"];
        $start = 1;
        $end = -2147483649;
        $scene_id = rand($start, $end);
        if( empty($scene_id) ) 
        {
            $scene_id = rand($start, $end);
        }

        while( 1 ) 
        {
            $count = pdo_fetchcolumn("select count(*) from " . tablename("qrcode") . " where qrcid=:qrcid and acid=:acid and model=0 limit 1", array( ":qrcid" => $scene_id, ":acid" => $acid ));
            if( $count <= 0 ) 
            {
                break;
            }

            $scene_id = rand($start, $end);
            if( empty($scene_id) ) 
            {
                $scene_id = rand($start, $end);
            }

        }
        return $scene_id;
    }

    protected function getSceneTicket2($expire, $scene_id)
    {
        global $_W;
        global $_GPC;
        $account = m("common")->getAccount();
        $bb = "{\"expire_seconds\":" . $expire . ",\"action_info\":{\"scene\":{\"scene_id\":" . $scene_id . "}},\"action_name\":\"QR_SCENE\"}";
        if( $scene_id[0] == "t" ) 
        {
            $bb = "{\"action_name\": \"QR_LIMIT_STR_SCENE\", \"action_info\": {\"scene\": {\"scene_str\": \"" . $scene_id . "\"}}}";
        }

        $token = $account->fetch_token();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $token;
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url);
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $bb);
        $c = curl_exec($ch1);
        $result = @json_decode($c, true);
        if( !is_array($result) ) 
        {
            return false;
        }

        if( !empty($result["errcode"]) ) 
        {
            return error(-1, $result["errmsg"]);
        }

        $ticket = $result["ticket"];
        return array( "barcode" => json_decode($bb, true), "ticket" => $ticket );
    }

    /**
     * 任务进度检查公用方法
     * @param $num
     * @param $typeKey
     */

    public function checkTaskProgress($num, $typeKey, $recordid = 0, $openid = "", $goodsid = 0)
    {
        global $_W;
        if( empty($openid) ) 
        {
            $openid = $_W["openid"];
        }

        if( empty($openid) ) 
        {
            return false;
        }

        $type = $this->getTaskType($typeKey);
        $time = date("Y-m-d H:i:s");
        $sqlPassive = "select * from " . tablename("ewei_shop_task_list") . " where uniacid = :uniacid and picktype = 1 and starttime < :starttime and endtime > :endtime";
        $paramsPassive = array( ":uniacid" => $_W["uniacid"], ":starttime" => $time, ":endtime" => $time );
        $passiveTask = pdo_fetchall($sqlPassive, $paramsPassive);
        if( !empty($passiveTask) ) 
        {
            foreach( $passiveTask as $task ) 
            {
                if( !pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_task_record") . " where taskid = " . $task["id"] . " and uniacid = " . $_W["uniacid"]) ) 
                {
                    $this->pickTask($task["id"], $openid);
                }

            }
        }

        $condtion = "";
        if( !empty($recordid) ) 
        {
            $condtion = " and id = " . $recordid . " ";
        }

        if( !empty($goodsid) ) 
        {
            $condtion .= " and FIND_IN_SET('" . $goodsid . "',require_goods) ";
        }

        $sql = "select * from " . tablename("ewei_shop_task_record") . " where uniacid = :uniacid " . $condtion . " and openid = :openid and tasktype = :tasktype and (stoptime = '0000-00-00 00:00:00' or stoptime >'" . $time . "') and finishtime = '0000-00-00 00:00:00'";
        $params = array( ":uniacid" => $_W["uniacid"], ":openid" => $openid, ":tasktype" => $typeKey );
        $allRecord = pdo_fetchall($sql, $params);
        if( !empty($allRecord) ) 
        {
            foreach( $allRecord as $record ) 
            {
                $cache_key = $record["id"] . "tasknew_" . $openid . "_pro" . $record["task_progress"];
                $height = m("cache")->get($cache_key);
                if( !empty($height) ) 
                {
                    m("cache")->del($cache_key);
                    return NULL;
                }

                m("cache")->set($cache_key, time());
                if( $typeKey == "recharge_full" && $num < $record["task_demand"] ) 
                {
                    continue;
                }

                $record["task_progress"] = $record["task_progress"] + $num;
                if( $record["task_demand"] <= $record["task_progress"] ) 
                {
                    $update_arr = array( "task_progress" => $record["task_demand"] );
                    $update_arr["finishtime"] = date("Y-m-d H:i:s");
                    $ret = pdo_update("ewei_shop_task_record", $update_arr, array( "id" => $record["id"] ));
                    if( $ret ) 
                    {
                        $this->sentReward($record["id"], $openid);
                        if( $type["type_key"] === "poster" ) 
                        {
                            $this->posterFinishMessage($record["openid"], $record);
                            $this->followReward($record["id"]);
                        }
                        else
                        {
                            $this->taskFinishMessage($record["openid"], $record);
                        }

                    }

                }
                else
                {
                    if( $type["type_key"] === "poster" ) 
                    {
                        if( 0 < $record["level1"] && $record["task_progress"] == $record["level1"] ) 
                        {
                            $this->sentReward($record["id"], $openid, 1);
                        }

                        if( 0 < $record["level2"] && $record["task_progress"] == $record["level2"] ) 
                        {
                            $this->sentReward($record["id"], $openid, 2);
                        }

                    }

                    if( $type["once"] != 1 ) 
                    {
                        pdo_update("ewei_shop_task_record", array( "task_progress" => $record["task_progress"] ), array( "id" => $record["id"] ));
                        if( $type["type_key"] === "poster" ) 
                        {
                            $this->posterProgressMessage($record["openid"], $record);
                            $this->followReward($record["id"]);
                        }
                        else
                        {
                            $this->taskProgressMessage($record["openid"], $record);
                        }

                    }

                }

            }
        }

    }

    public function sentReward($recordid, $openid, $level = 0)
    {
        global $_W;
        $time = date("Y-m-d H:i:s");
        $sql = "select * from " . tablename("ewei_shop_task_reward") . " where recordid = :recordid and openid = :openid and uniacid = :uniacid and `get` = 0 and sent = 0 and `level` = " . $level . " ";
        $param = array( ":recordid" => $recordid, ":uniacid" => $_W["uniacid"], ":openid" => $openid );
        $rewards = pdo_fetchall($sql, $param);
        if( !empty($rewards) ) 
        {
            foreach( $rewards as $k => $reward ) 
            {
                switch( $reward["reward_type"] ) 
                {
                    case "credit":
                        m("member")->setCredit($openid, "credit1", floatval($reward["reward_data"]), array( $_W["uid"], "任务中心奖励" ));
                        pdo_update("ewei_shop_task_reward", array( "sent" => 1, "get" => 1, "gettime" => $time, "senttime" => $time ), array( "id" => $reward["id"] ));
                        break;
                    case "balance":
                        m("member")->setCredit($openid, "credit2", floatval($reward["reward_data"]), array( $_W["uid"], "任务中心奖励" ));
                        pdo_update("ewei_shop_task_reward", array( "sent" => 1, "get" => 1, "gettime" => $time, "senttime" => $time ), array( "id" => $reward["id"] ));
                        break;
                    case "redpacket":
                        pdo_update("ewei_shop_task_reward", array( "get" => 1, "gettime" => $time ), array( "id" => $reward["id"] ));
                        break;
                    case "coupon":
                        $data = array( "uniacid" => $_W["uniacid"], "merchid" => 0, "openid" => $openid, "couponid" => $reward["reward_data"], "gettype" => 7, "gettime" => time(), "senduid" => $_W["uid"] );
                        pdo_insert("ewei_shop_coupon_data", $data);
                        pdo_update("ewei_shop_task_reward", array( "sent" => 1, "get" => 1, "gettime" => $time, "senttime" => $time ), array( "id" => $reward["id"] ));
                        break;
                    case "goods":
                        pdo_update("ewei_shop_task_reward", array( "get" => 1, "gettime" => $time ), array( "id" => $reward["id"] ));
                        break;
                }
            }
        }

    }

    /**
     * 关注奖励发放
     * @param $recordid
     * @return bool
     */

    public function followReward($recordid)
    {
        global $_W;
        $time = date("Y-m-d H:i:s");
        $info = m("member")->getInfo($_W["openid"]);
        $record = pdo_fetch("select * from " . tablename("ewei_shop_task_record") . " where id = :id and uniacid = :uniacid", array( ":id" => $recordid, ":uniacid" => $_W["uniacid"] ));
        $frewards = json_decode($record["followreward_data"], true);
        if( empty($frewards) ) 
        {
            return false;
        }

        foreach( $frewards as $k => $reward ) 
        {
            switch( $k ) 
            {
                case "credit":
                    if( 0 < $reward ) 
                    {
                        m("member")->setCredit($_W["openid"], "credit1", floatval($reward), array( $_W["uid"], "任务中心关注海报奖励" ));
                        pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $record["taskid"], "tasktitle" => $record["tasktitle"], "tasktype" => $record["tasktype"], "taskowner" => $record["openid"], "ownernickname" => $record["nickname"], "recordid" => $record["id"], "nickname" => $info["nickname"], "headimg" => $info["avatar"], "openid" => $_W["openid"], "reward_type" => "credit", "reward_title" => $reward . "积分", "reward_data" => $reward, "sent" => 1, "get" => 1, "gettime" => $time, "senttime" => $time, "isjoiner" => 1 ));
                    }

                    break;
                case "balance":
                    if( 0 < $reward ) 
                    {
                        m("member")->setCredit($_W["openid"], "credit2", floatval($reward), array( $_W["uid"], "任务中心关注海报奖励" ));
                        pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $record["taskid"], "tasktitle" => $record["tasktitle"], "tasktype" => $record["tasktype"], "taskowner" => $record["openid"], "ownernickname" => $record["nickname"], "recordid" => $record["id"], "nickname" => $info["nickname"], "headimg" => $info["avatar"], "openid" => $_W["openid"], "reward_type" => "balance", "reward_title" => $reward . "元余额", "reward_data" => $reward, "sent" => 1, "get" => 1, "gettime" => $time, "senttime" => $time, "isjoiner" => 1 ));
                    }

                    break;
                case "redpacket":
                    if( 0 < $reward ) 
                    {
                        pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $record["taskid"], "tasktitle" => $record["tasktitle"], "tasktype" => $record["tasktype"], "taskowner" => $record["openid"], "ownernickname" => $record["nickname"], "recordid" => $record["id"], "nickname" => $info["nickname"], "headimg" => $info["avatar"], "openid" => $_W["openid"], "reward_type" => "redpacket", "reward_title" => $reward . "元微信红包", "reward_data" => $reward, "get" => 1, "gettime" => $time, "isjoiner" => 1 ));
                    }

                    break;
                case "coupon":
                    if( !empty($reward) && is_array($reward) ) 
                    {
                        foreach( $reward as $ck => $cv ) 
                        {
                            $data = array( "uniacid" => $_W["uniacid"], "merchid" => 0, "openid" => $_W["openid"], "couponid" => $cv["id"], "gettype" => 7, "gettime" => time(), "senduid" => $_W["uid"] );
                            for( $i = 0; $i < $cv["num"]; $i++ ) 
                            {
                                pdo_insert("ewei_shop_coupon_data", $data);
                                pdo_insert("ewei_shop_task_reward", array( "uniacid" => $_W["uniacid"], "taskid" => $record["taskid"], "tasktitle" => $record["tasktitle"], "tasktype" => $record["tasktype"], "taskowner" => $record["openid"], "ownernickname" => $record["nickname"], "recordid" => $record["id"], "nickname" => $info["nickname"], "headimg" => $info["avatar"], "openid" => $_W["openid"], "reward_type" => "coupon", "reward_title" => $cv["couponname"], "reward_data" => $cv["id"], "sent" => 1, "get" => 1, "gettime" => $time, "senttime" => $time, "isjoiner" => 1 ));
                            }
                        }
                    }

                    break;
            }
            $sign = 1;
        }
        if( !empty($sign) ) 
        {
            $this->taskPosterFollowMessage($_W["openid"], $record, $info["nickname"]);
        }

    }

    /**
     * 接取任务通知
     * @param $openid
     */

    public function taskPickMessage($openid, $record)
    {
        $tag = "task_pick";
        $type = $this->getTaskType($record["tasktype"]);
        $message = array( "first" => array( "value" => "亲爱的" . $record["nickname"] . "，恭喜您成功领取任务。", "color" => "#ff0000" ), "keyword2" => array( "title" => "业务状态", "value" => $record["tasktitle"], "color" => "#000000" ), "keyword3" => array( "title" => "业务内容", "value" => $type["type_name"], "color" => "#000000" ), "keyword1" => array( "title" => "业务类型", "value" => "会员通知", "color" => "#000000" ), "remark" => array( "value" => ("截止时间：" . $record["stoptime"] == "0000-00-00 00:00:00" ? "无限制" : substr($record["stoptime"], 0, 16) . "\n完成任务可获得丰厚奖励，赶快去完成任务吧~~"), "color" => "#000000" ) );
        $url = mobileUrl("task.detail", array( "rid" => $record["id"] ), 1);
        $text = "亲爱的[任务所有者昵称]，恭喜您成功领取[任务名称]\n\n领取时间：[接取时间]\n截止时间：[截止时间]\n完成任务可获得丰厚奖励，快去完成任务吧~~\n\n";
        $remark = "<a href='" . $url . "'>点击查看详情</a>";
        $text .= $remark;
        $datas = $this->getNoticeDatas($record);
        m("notice")->sendNotice(array( "openid" => $openid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "url" => $url, "datas" => $datas ));
    }

    /**
     * 任务进度通知
     * @param $openid
     */

    public function taskProgressMessage($openid, $record)
    {
        $tag = "task_progress";
        $type = $this->getTaskType($record["tasktype"]);
        $message = array( "first" => array( "value" => "任务最新进度", "color" => "#ff0000" ), "keyword2" => array( "title" => "业务状态", "value" => $record["tasktitle"], "color" => "#000000" ), "keyword3" => array( "title" => "业务内容", "value" => $type["type_name"], "color" => "#000000" ), "keyword1" => array( "title" => "业务类型", "value" => "会员通知", "color" => "#000000" ), "remark" => array( "value" => "接取时间：" . date("Y-m-d H:i") . "\n当前进度：" . $record["task_progress"] . "/" . $record["task_demand"] . "\n完成任务可获得丰厚奖励，赶快去完成任务吧~~", "color" => "#000000" ) );
        $url = mobileUrl("task.detail", array( "rid" => $record["id"] ), 1);
        $text = "恭喜，您的任务：[任务名称]当前进度为[分数进度]，任务完成后可以获得丰厚奖励，再接再厉~~\n";
        $remark = "<a href='" . $url . "'>点击查看详情</a>";
        $text .= $remark;
        $datas = $this->getNoticeDatas($record);
        m("notice")->sendNotice(array( "openid" => $openid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "url" => $url, "datas" => $datas ));
    }

    /**
     * 任务完成通知
     * @param $openid
     */

    public function taskFinishMessage($openid, $record)
    {
        $tag = "task_finish";
        $type = $this->getTaskType($record["tasktype"]);
        $message = array( "first" => array( "value" => "恭喜！您的任务已完成", "color" => "#ff0000" ), "keyword2" => array( "title" => "业务状态", "value" => $record["tasktitle"], "color" => "#000000" ), "keyword3" => array( "title" => "业务内容", "value" => $type["type_name"], "color" => "#000000" ), "keyword1" => array( "title" => "业务类型", "value" => "会员通知", "color" => "#000000" ), "remark" => array( "value" => "如有疑问请联系在线客服", "color" => "#000000" ) );
        $url = mobileUrl("task.reward", array(  ), 1);
        $text = "亲爱的[任务所有者昵称]，您的任务已经完成！快去查看您的奖励吧~~\n";
        $remark = "<a href='" . $url . "'>点击查看详情</a>";
        $text .= $remark;
        $datas = $this->getNoticeDatas($record);
        m("notice")->sendNotice(array( "openid" => $openid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "url" => $url, "datas" => $datas ));
    }

    /**
     * 海报接取通知
     * @param $openid
     */

    public function posterPickMessage($openid, $record)
    {
        $this_member = m("member")->getInfo($openid);
        $tag = "task_poster_pick";
        $message = array( "first" => array( "value" => "任务接取通知", "color" => "#ff0000" ), "keyword2" => array( "title" => "业务状态", "value" => $record["tasktitle"], "color" => "#000000" ), "keyword3" => array( "title" => "业务内容", "value" => "海报任务", "color" => "#000000" ), "keyword1" => array( "title" => "业务类型", "value" => "会员通知", "color" => "#000000" ), "remark" => array( "value" => "领取时间：" . substr($record["picktime"], 0, 16) . "\n截止时间：" . substr($record["stoptime"], 0, 16) . "\n这是您的专属任务海报，快推出去让大家知道吧~~", "color" => "#000000" ) );
        $url = mobileUrl("task.detail", array( "rid" => $record["id"] ), 1);
        $text = "亲爱的[任务所有者昵称]，这是您的专属任务海报，快推出去让大家知道吧~~\n";
        $remark = "\n<a href='" . $url . "'>点击查看详情</a>";
        $text .= $remark;
        $datas = $this->getNoticeDatas($record, $this_member["nickname"]);
        m("notice")->sendNotice(array( "openid" => $openid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "url" => $url, "datas" => $datas ));
    }

    /**
     * 海报进度通知
     * @param $openid
     */

    public function posterProgressMessage($openid, $record)
    {
        global $_W;
        $this_member = m("member")->getInfo($_W["openid"]);
        $tag = "task_poster_progress";
        $message = array( "first" => array( "value" => (string) $record["niackname"] . "关注了您的海报，为您增加了1 点人气。", "color" => "#ff0000" ), "keyword2" => array( "title" => "业务状态", "value" => $record["tasktitle"], "color" => "#000000" ), "keyword3" => array( "title" => "业务内容", "value" => "海报任务", "color" => "#000000" ), "keyword1" => array( "title" => "业务类型", "value" => "会员通知", "color" => "#000000" ), "remark" => array( "value" => "当前进度：" . $record["task_progress"] . "/" . $record["task_demand"] . "\n扫描关注：" . $this_member["nickname"] . "\n扫描时间：" . date("Y-m-d H:i") . "如有疑问请联系在线客服", "color" => "#000000" ) );
        $url = mobileUrl("task.reward", NULL, 1);
        $text = "您的海报被" . $this_member["nickname"] . "扫描，人气值+1！\n";
        $remark = "\n <a href='" . $url . "'>点击查看详情</a>";
        $text .= $remark;
        $datas = $this->getNoticeDatas($record, $this_member["nickname"]);
        m("notice")->sendNotice(array( "openid" => $openid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "url" => $url, "datas" => $datas ));
    }

    /**
     * 海报完成通知
     * @param $openid
     */

    public function posterFinishMessage($openid, $record)
    {
        $this_member = m("member")->getInfo($openid);
        $tag = "task_poster_finish";
        $message = array( "first" => array( "value" => "您的任务已经完成！", "color" => "#ff0000" ), "keyword2" => array( "title" => "业务状态", "value" => $record["tasktitle"], "color" => "#000000" ), "keyword3" => array( "title" => "业务内容", "value" => "海报任务", "color" => "#000000" ), "keyword1" => array( "title" => "业务类型", "value" => "会员通知", "color" => "#000000" ), "remark" => array( "value" => "快去查看您的奖励吧~~", "color" => "#000000" ) );
        $url = mobileUrl("task.reward", NULL, 1);
        $text = "亲爱的[任务所有者昵称]，您的任务已经完成！\n";
        $remark = "\n感谢您的支持 <a href='" . $url . "'>点击查看详情</a>";
        $text .= $remark;
        $datas = $this->getNoticeDatas($record, $this_member["nickname"]);
        m("notice")->sendNotice(array( "openid" => $openid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "url" => $url, "datas" => $datas ));
    }

    /**
     * 关注海报奖励通知
     * @param $openid
     */

    public function taskPosterFollowMessage($openid, $record, $nickname = "")
    {
        $this_member = m("member")->getInfo($openid);
        $tag = "task_poster_scan";
        $message = array( "first" => array( "value" => "您关注了" . $record["niackname"] . "的海报", "color" => "#ff0000" ), "keyword2" => array( "title" => "业务状态", "value" => $record["tasktitle"], "color" => "#000000" ), "keyword3" => array( "title" => "业务内容", "value" => "海报任务", "color" => "#000000" ), "keyword1" => array( "title" => "业务类型", "value" => "会员通知", "color" => "#000000" ), "remark" => array( "value" => "快去查看您的奖励吧~~", "color" => "#000000" ) );
        $url = mobileUrl("task.reward", NULL, 1);
        $text = "您关注了[任务所有者昵称]的海报，快去查看您的奖励吧~~\n";
        $remark = "\n <a href='" . $url . "'>点击查看详情</a>";
        $text .= $remark;
        $datas = $this->getNoticeDatas($record, $this_member["nickname"]);
        m("notice")->sendNotice(array( "openid" => $openid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "url" => $url, "datas" => $datas ));
    }

    public function getNoticeDatas($record, $nickname = "")
    {
        global $_W;
        $datas = array(  );
        $datas[] = array( "name" => "当前时间", "value" => date("Y-m-d H:i") );
        $datas[] = array( "name" => "接取时间", "value" => substr($record["picktime"], 0, 16) );
        $datas[] = array( "name" => "截止时间", "value" => ($record["stoptime"] == "0000-00-00 00:00:00" ? "无限制" : substr($record["stoptime"], 0, 16)) );
        $datas[] = array( "name" => "任务名称", "value" => $record["tasktitle"] );
        $datas[] = array( "name" => "分数进度", "value" => $record["task_progress"] . "/" . $record["task_demand"] );
        $datas[] = array( "name" => "任务所有者昵称", "value" => $record["nickname"] );
        $datas[] = array( "name" => "已完成数", "value" => $record["task_progress"] );
        $datas[] = array( "name" => "待完成数", "value" => $record["task_demand"] - $record["task_progress"] );
        $datas[] = array( "name" => "总需求数", "value" => $record["task_demand"] );
        if( $record["tasktype"] == "poster" ) 
        {
            $datas[] = array( "name" => "一级海报需求", "value" => 1 );
            $datas[] = array( "name" => "二级海报需求", "value" => 1 );
            $datas[] = array( "name" => "三级级海报需求", "value" => 1 );
            $datas[] = array( "name" => "关注者昵称", "value" => $nickname );
        }

        return $datas;
    }

    /**
     * 特惠商品下单检测
     * @param int $taskrewardgoodsid
     * @return bool
     */

    public function getTaskRewardGoodsInfo($taskrewardgoodsid = 0)
    {
        global $_W;
        if( empty($taskrewardgoodsid) ) 
        {
            return false;
        }

        $reward = pdo_get("ewei_shop_task_reward", array( "id" => $taskrewardgoodsid, "openid" => $_W["openid"], "uniacid" => $_W["uniacid"], "get" => 1, "sent" => 0, "reward_type" => "goods" ));
        if( empty($reward) ) 
        {
            return false;
        }

        return $reward;
    }

    /**
     * 特惠商品下单完成
     * @param int $taskrewardgoodsid
     * @return bool
     */

    public function setTaskRewardGoodsSent($taskrewardgoodsid = 0)
    {
        global $_W;
        if( empty($taskrewardgoodsid) ) 
        {
            return false;
        }

        pdo_update("ewei_shop_task_reward", array( "sent" => 1, "senttime" => date("Y-m-d H:i:s") ), array( "id" => $taskrewardgoodsid ));
        $_SESSION["taskcut"] = NULL;
        return true;
    }

    /**
     * 会员中心入口是否开启
     */

    public function TasknewEntrance()
    {
        global $_W;
        $sql = "select entrance from " . tablename("ewei_shop_task_set") . " where uniacid = " . $_W["uniacid"];
        return pdo_fetchcolumn($sql);
    }

    /**
     * 会员中心入口是否开启
     */

    public function TaskTopNotice()
    {
        global $_W;
        $sql = "select top_notice from " . tablename("ewei_shop_task_set") . " where uniacid = " . $_W["uniacid"];
        return pdo_fetchcolumn($sql);
    }

    /**
     * 获取消息通知设置
     * @param array $field
     * @return bool
     */

    public function getMessageSet($field = array(  ))
    {
        global $_W;
        $isString = is_string($field);
        if( $isString ) 
        {
            $field2 = array( $field );
        }
        else
        {
            $field2 = $field;
        }

        if( !is_array($field2) ) 
        {
            return false;
        }

        $msg = pdo_get("ewei_shop_task_set", array( "uniacid" => $_W["uniacid"] ), $field2);
        if( $isString ) 
        {
            return $msg[$field];
        }

        return $msg;
    }

}


