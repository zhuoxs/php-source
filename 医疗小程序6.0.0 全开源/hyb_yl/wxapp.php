<?php
/**
 * 行业宝模块小程序接口定义
 *
 * @author wangbosichuang
 * @url
 */
defined('IN_IA') or exit('Access Denied');
class hyb_ylModuleWxapp extends WeModuleWxapp {
    //短信验证
    public function doPageSendSms() {
        require_once dirname(__FILE__) . '/inc/SignatureHelper.php';
        $params = array();
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $phoneNum = $_GPC['phoneNum'];
        $aliduanxin = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_duanxin") . "WHERE uniacid = '{$uniacid}'");
        $accessKeyId = $aliduanxin['key'];
        $accessKeySecret = $aliduanxin['scret'];
        $params["PhoneNumbers"] = $phoneNum;
        $params["SignName"] = $aliduanxin['qianming'];
        $params["TemplateCode"] = $aliduanxin['moban_id'];
        $code = rand(1000, 9999);
        $params['TemplateParam'] = Array("code" => $code, "product" => "sms");
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"]);
        }
        $helper = new SignatureHelper();
        $content = $helper->request($accessKeyId, $accessKeySecret, "dysmsapi.aliyuncs.com", array_merge($params, array("RegionId" => "cn-hangzhou", "Action" => "SendSms", "Version" => "2017-05-25",)));
        return $this->result(0, 'success', $code);
    }
    public function doPageSelectdoctime() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['zid'];
        $rows = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_guatime") . " where uniacid ='{$uniacid}' and zid ='{$zid}' ");
        //   foreach ($rows as $k => $v) {
        //    if(is_array($v)){
        //       foreach ($v as $v2) {
        //         if($v2==''){
        //            unset($rows[$k]);
        //         }
        //       }
        //    }
        // }
        $time = time();
        $neardate = date("Y-m-d", TIMESTAMP);
        $ga = date("w");
        foreach ($rows as $key => $value) {

            $week['week'] = unserialize($value['week']);
            $week['week1'] = unserialize($value['week1']);
            $week['week2'] = unserialize($value['week2']);
            $week['week3'] = unserialize($value['week3']);
            $week['week4'] = unserialize($value['week4']);
            $week['week5'] = unserialize($value['week5']);
            $week['week6'] = unserialize($value['week6']);
            $week['week6'] = unserialize($value['week6']);
            $data1 =array(
              'tid'=>$value['tid'],
              'data'=>$week,
                );
            echo json_encode($data1);
        }
    }
    public function doPageSelect1() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tid = $_GPC['tid'];
        $rows = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_guatime") . " where uniacid ='{$uniacid}' and tid ='{$tid}'");
        $rows['end_time'] = unserialize($rows['end_time']);
        $rows['star_time'] = unserialize($rows['star_time']);
        $rows['shengyunus'] = unserialize($rows['shengyunus']);
        $rows['nums'] = unserialize($rows['nums']);
        return $this->result(0, 'success', $rows);
    }
    public function doPageUpweek() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tid = $_GPC['tid'];
        $wekinfo = $_GPC['wekinfo'];
        $xingqi = $_GPC['xingqi'];
        $idarr = htmlspecialchars_decode($wekinfo);
        $array = json_decode($idarr);
        $object = json_decode(json_encode($array), true);
        $data = array($xingqi => serialize($object));
        $rows = pdo_update("hyb_yl_guatime", $data, array('uniacid' => $uniacid, 'tid' => $tid));
        return $this->result(0, 'success', $rows);
    }
    public function doPageUpweekfuwu() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tid = $_GPC['tid'];
        $wekinfo = $_GPC['wekinfo'];
        $xingqi = $_GPC['xingqi'];
        $idarr = htmlspecialchars_decode($wekinfo);
        $array = json_decode($idarr);
        $object = json_decode(json_encode($array), true);
        $data = array($xingqi => serialize($object));
        $rows = pdo_update("hyb_yl_fuwutime", $data, array('uniacid' => $uniacid, 'tid' => $tid));
        return $this->result(0, 'success', $rows);
    }
    //短信通知管理
    public function doPagePaysendSms() {
        $params = array();
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        require_once dirname(__FILE__) . '/inc/SignatureHelper.php';
        $aliduanxin = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_duanxin") . "WHERE uniacid = '{$uniacid}' ", array("uniacid" => $uniacid));
        if ($aliduanxin['stadus'] == 1) {
            $accessKeyId = $aliduanxin['key'];
            $accessKeySecret = $aliduanxin['scret'];
            $params["PhoneNumbers"] = $aliduanxin['tel'];
            $params["SignName"] = $aliduanxin['qianming'];
            $params["TemplateCode"] = $aliduanxin['templateid'];
            $my_id = $_GPC['my_id'];
            $myname = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_myinfors") . "WHERE uniacid = '{$uniacid}' and  my_id ='{$my_id}'", array("uniacid" => $uniacid));
            $name = $myname['myname'];
            $phoneNum = $myname['myphone'];
            $zid = $_GPC['zid'];
            $doname = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . "as a left join" . tablename('hyb_yl_category') . "as b on b.id=a.z_room WHERE a.uniacid = '{$uniacid}' and a.zid ='{$zid}'", array("uniacid" => $uniacid));
            $doctor = $doname['z_name'];
            $ksname = $doname['name'];
            $params['TemplateParam'] = Array('content' => $phoneNum, 'name' => $name, 'ksname' => $ksname, 'doctor' => $doctor);
            // var_dump($my_id,$zid,$name,$phoneNum,$doctor,$ksname,$params['TemplateParam']);
            if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
                $params["TemplateParam"] = json_encode($params["TemplateParam"]);
            }
            $helper = new SignatureHelper();
            $content = $helper->request($accessKeyId, $accessKeySecret, "dysmsapi.aliyuncs.com", array_merge($params, array("RegionId" => "cn-hangzhou", "Action" => "SendSms", "Version" => "2017-05-25",)));
        }
        return $this->result(0, 'success', $content);
    }
    //订单核销
    public function doPageMoney() {
        global $_W;
        $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        $res = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . "WHERE zy_id = '{$id}' and uniacid='{$uniacid}'");
        $res['zy_sex'] = $_W['attachurl'] . $res['zy_sex'];
        return $this->result(0, 'success', $res);
    }
    //查看预约价格
    public function doPageDmoney() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);
        $Dmoney = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . "WHERE zy_id = '{$id}' and uniacid='{$uniacid}'");
        //生成订单二维码zy_sex
        if (empty($Dmoney['zy_sex'])) {
            if ($Dmoney['zy_telephone']) {
                $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_parameter') . " where `uniacid`='{$uniacid}' ", array(":uniacid" => $uniacid));
                $APPID = $result['appid'];
                $SECRET = $result['appsecret'];
                $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
                $getArr = array();
                $tokenArr = json_decode($this->send_post($tokenUrl, $getArr, "GET"));
                $access_token = $tokenArr->access_token;
                $noncestr = $Dmoney['zy_telephone'];
                $width = 430;
                $post_data = '{"path":"' . $noncestr . '","width":' . $width . '}';
                $url = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=" . $access_token;
                $result = $this->api_notice_increment($url, $post_data);
                $image_name = md5(uniqid(rand())) . ".jpg";
                $filepath = "../attachment/{$image_name}";
                $file_put = file_put_contents($filepath, $result);
                if ($file_put) {
                    $u_phone = pdo_getcolumn('hyb_yl_zhuanjia_yuyue', array('zy_id' => $id), 'zy_sex');
                    $datas = array('zy_sex' => $filepath);
                    $getupdate = pdo_update("hyb_yl_zhuanjia_yuyue", $datas, array('zy_id' => $id, 'uniacid' => $uniacid));
                } else {
                    $filepath = "../attachment/{$image_name}";
                }
            }
        } else {
            echo "2";
        }
        return $this->result(0, 'success', $filepath);
    }
    private function send_post($url, $post_data, $method = 'POST') {
        $postdata = http_build_query($post_data);
        $options = array('http' => array('method' => $method, //or GET
        'header' => 'Content-type:application/x-www-form-urlencoded', 'content' => $postdata, 'timeout' => 15 * 60 // 超时时间（单位:s）
        ));
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    private function api_notice_increment($url, $data) {
        $ch = curl_init();
        // $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        } else {
            return $tmpInfo;
        }
    }
    //订单核销
    public function doPageStore() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $oncode = $_GPC['ky_yibao'];
        $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_zhuanjia_yuyue') . " where `zy_telephone`='{$oncode}' and `uniacid` = '{$uniacid}' ", array(":uniacid" => $uniacid));
        $id = $result['zy_id'];
        $results = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_myinfors") . " as a left join " . tablename("hyb_yl_zhuanjia_yuyue") . " as b on b.zy_name=a.my_id " . "left join " . tablename("hyb_yl_zhuanjia") . "as c on b.z_name=c.zid where b.uniacid = '{$uniacid}' and b.zy_id='{$id}'");
        return $this->result(0, 'success', $results);
    }
    public function doPageSave_order() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $oncode = $_GPC['oncode'];
        $user_data = array('zy_zhenzhuang' => 1);
        $update = pdo_update('hyb_yl_zhuanjia_yuyue', $user_data, array('zy_telephone' => $oncode));
        return $this->result(0, 'success', $updateperson);
    }
    //c查询订单详情
    public function doPageCxhextype() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);
        $type = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " as a left join " . tablename("hyb_yl_zhuanjia") . " as b on b.zid=a.z_name " . "left join " . tablename("hyb_yl_category") . "as c on b.z_room=c.id where a.uniacid = '{$uniacid}' and a.zy_id='{$id}'");
        $type['z_thumbs'] = $_W['attachurl'] . $type['z_thumbs'];
        return $this->result(0, 'success', $type);
    }
    //保存手机号
    public function doPageSavemyphone() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $myphone = $_GPC['u_phone'];
        $seunseinfo = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_userinfo') . "WHERE openid = '{$openid}' and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        // UPDATE ims_hyb_yl_userinfo SET u_phone='' WHERE u_phone='1111' AND openid='onMvv0FREZbxVWAHxpWx2mV2UUoc';
        if (pdo_fieldexists('hyb_yl_userinfo', 'u_phone')) {
            $u_phone = pdo_getcolumn('hyb_yl_userinfo', array('openid' => $seunseinfo['openid']), 'u_phone');
            $datas = array('u_phone' => $myphone);
            $getupdate = pdo_update("hyb_yl_userinfo", $datas, array('openid' => $openid, 'uniacid' => $uniacid));
        }
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $getupdate);
    }
    //获取我的预约订单
    public function doPageSelectord() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $selectord = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " as a left join " . tablename("hyb_yl_myinfors") . " as b on a.zy_name=b.my_id " . "left join " . tablename("hyb_yl_category") . "as c on b.uniacid=c.uniacid " . "left join " . tablename("hyb_yl_zhuanjia") . "as d on a.z_name=d.zid where a.uniacid = '{$uniacid}' and a.zy_openid='{$openid}' group by a.zy_id desc");
        foreach ($selectord as & $value) {
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
        }
        return $this->result($errno, $message, $selectord);
    }
    // 获取预约订单总额
    public function doPageSelectordsum() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $selectord = pdo_fetch("SELECT SUM(zy_money) AS `money` FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " where `zy_openid`='{$openid}'  and uniacid = '{$uniacid}'", array(":uniacid" => $uniacid));
        return $this->result($errno, $message, $selectord);
    }
    //获取我的体检报告
    public function doPageSelectijianbaogao() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $selectord = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_tijianbaogao') . "WHERE openid = '{$openid}' and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        foreach ($selectord as & $value) {
            $value['picfengm'] = $_W['attachurl'] . $value['picfengm'];
        }
        return $this->result($errno, $message, $selectord);
    }
    //获取我的检验报告
    public function doPageSelecjianybaogao() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $selectord = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_jianybaogao') . "WHERE openid = '{$openid}' and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        foreach ($selectord as & $value) {
            $value['picfengm'] = $_W['attachurl'] . $value['picfengm'];
        }
        return $this->result($errno, $message, $selectord);
    }
    //获取我的预约订单
    public function doPageSelectord1() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $selectord = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " as a left join " . tablename("hyb_yl_myinfors") . " as b on a.zy_name=b.my_id " . "left join " . tablename("hyb_yl_category") . "as c on b.uniacid=c.uniacid " . "left join " . tablename("hyb_yl_zhuanjia") . "as d on a.z_name=d.zid where a.uniacid = '{$uniacid}' and a.zy_zhenzhuang=1  and a.zy_openid='{$openid}' group by a.zy_id desc");
        foreach ($selectord as & $value) {
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
        }
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $selectord);
    }
    //获取我的预约订单
    public function doPageSelectord2() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $selectord = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_zhuanjia_yuyue') . "as a left join" . tablename('hyb_yl_zhuanjia') . "as b on b.zid=a.z_name left join" . tablename('hyb_yl_myinfors') . "as d on d.my_id =a.zy_name where a.uniacid=b.uniacid and a.zy_openid='{$openid}' and (a.zy_zhenzhuang=2 or a.zy_zhenzhuang=0) order by a.zy_id desc");
        foreach ($selectord as & $value) {
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
        }
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $selectord);
    }
    public function doPageSelectord3() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $selectdata = pdo_fetch("SELECT * FROM" . tablename('hyb_yl_zhuanjia_yuyue') . "as a left join" . tablename('hyb_yl_myinfors') . "as b on a.zy_name = b.my_id WHERE a.uniacid ='{$uniacid}' order by a.zy_id desc limit 1", array('uniacid' => $uniacid));
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $selectdata);
    }
    //删除会话信息
    public function doPageDeleteMsg() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $f_id = $_REQUEST['fid'];
        $t_id = $_REQUEST['tid'];
        $openid = $_REQUEST['openid'];
        //查询用户信息
        $user_curr = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
        $t_id1 = $user_curr['u_id'];
        $res = pdo_delete("hyb_yl_chat_msg", array("t_id" => $t_id1, "f_id" => $f_id));
        $res = pdo_delete("hyb_yl_chat_msg", array("t_id" => $f_id, "f_id" => $t_id1));
        return $this->result(0, "success", $res);
    }
    //获取我的手机号
    public function doPageMyphone() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $res = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_userinfo') . " where `openid`='{$openid}'and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    //专家资料
    public function doPageMyzhuan() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $res = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_zhuanjia') . " where `openid`='{$openid}'and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        
        if(!empty($res)){
            if($res['z_yy_sheng'] ==0){
                $res['z_thumbs'] = $_W['attachurl'] . $res['z_thumbs'];
                $res['nameText'] ="认证中";
            }else{
               $res['z_thumbs'] = $_W['attachurl'] . $res['z_thumbs'];
            }
        }else{
            $res['z_yy_sheng']=0;
            $res['nameText'] ="去认证";
        }
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }

    public function doPageMyzhuanfuwu() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $op =$_GPC['op'];
        $res = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_zhuanjia') . " where `openid`='{$openid}'and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        $twzx=unserialize($res['twzixun']);
        $array=array();
        foreach ($twzx as $key => $value) {
            $array[]= unserialize($value);
        }
        $res['twzixun'] =$array;

        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageMyzhuanfuwudianh() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $op =$_GPC['op'];
        $res = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_zhuanjia') . " where `openid`='{$openid}'and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        $dianhuazix=unserialize($res['dianhuazix']);
        $array1=array();
        foreach ($dianhuazix as $key => $value) {
            $array1[]= unserialize($value);
        }
        $res['dianhuazix'] =$array1;
        $res['type'] ="dianhua";
        unset($res['twzixun']);
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }

    public function doPageMyzhuanfuwuzaix() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $op =$_GPC['op'];
        $res = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_zhuanjia') . " where `openid`='{$openid}'and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        $zaixian=unserialize($res['zaixian']);
        $array1=array();
        foreach ($zaixian as $key => $value) {
            $array1[]= unserialize($value);
        }
        $res['zaixian'] =$array1;
        $res['type'] ="zaixian";
        unset($res['twzixun']);
        unset($res['dianhuazix']);
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }

    public function doPageMyzhuan1() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $res = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_zhuanjia') . " where `openid`='{$openid}'and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        if (empty($res)) {
            echo "1";
        } else {
            echo "2";
            $res['z_thumbs'] = $_W['attachurl'] . $res['z_thumbs'];
        }
        // return $this->result($errno, $message, $res);
        
    }
    //获取用户信息
    public function doPageTyMember() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $item['u_name'] = $_GPC['u_name'];
        $item['u_thumb'] = $_GPC['u_thumb'];
        $item['uniacid'] = $uniacid;
        if ($openid) {
            $res = pdo_update('hyb_yl_userinfo', $item, array('openid' => $openid));
        }
        if (!$res['u_id']) {
            $res = pdo_fetch('SELECT `u_id` FROM ' . tablename('hyb_yl_userinfo') . " where `openid`='{$openid}' and uniacid = '{$uniacid}'", array("uniacid" => $uniacid));
        }
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $item);
    }
    public function doPageGetUid() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_parameter') . " where `uniacid`='{$uniacid}'");
        $APPID = $result['appid'];
        $SECRET = $result['appsecret'];
        $code = trim($_GPC['code']);
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$APPID}&secret={$SECRET}&js_code={$code}&grant_type=authorization_code";
        $data['userinfo'] = json_decode($this->httpGet($url));
        $openid = $data['userinfo']->openid;
        $item['openid'] = $openid;
        if ($openid) {
            $res = pdo_fetch('SELECT `u_id` FROM ' . tablename('hyb_yl_userinfo') . " where `openid`='{$openid}'");
            if (!$res['u_id']) {
                $res = pdo_insert('hyb_yl_userinfo', $item);
            }
        }
        $data['openid'] = $openid;
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $data);
    }
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
    //判断用户是否验证
    public function doPageUsercheck() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //var_dump($openid);
        $user = pdo_fetch("SELECT u_type FROM " . tablename("hyb_yl_userinfo") . " WHERE uniacid=:uniacid AND openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
        return $this->result(0, 'success', $user);
    }
    public function doPageUrl() {
        global $_W;
        echo $_W['siteroot'];
    }
    //图片上传
    public function doPageUpload() {
        global $_W, $_GPC;
   
        $uniacid = $_W['uniacid'];
        $uptypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');
        $max_file_size = 2000000;
        $destination_folder = '../attachment/';
        if (!is_uploaded_file($_FILES['upfile']['tmp_name'])) {
            echo '图片不存在!';
            die;
        }
        $file = $_FILES['upfile'];
        if ($max_file_size < $file['size']) {
            echo '文件太大!';
            die;
        }
        if (!in_array($file['type'], $uptypes)) {
            echo '文件类型不符!' . $file['type'];
            die;
        }
        $filename = $file['tmp_name'];
        $image_size = getimagesize($filename);
        $pinfo = pathinfo($file['name']);
        $ftype = $pinfo['extension'];
        $destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . '.' . $ftype;
        if (file_exists($destination) && $overwrite != true) {
            echo '同名文件已经存在了';
            die;
        }
        if (!move_uploaded_file($filename, $destination)) {
            echo '移动文件出错';
            die;
        }
        $pinfo = pathinfo($destination);
        $fname = $pinfo['basename'];
        echo $fname;
        @(require_once IA_ROOT . '/framework/function/file.func.php');
        @($filename = $fname);
        @file_remote_upload($filename);
    }
    public function doPageUploads() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $uptypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');
        $max_file_size = 2000000;
        $destination_folder = '../attachment/';
        if (!is_uploaded_file($_FILES['upfile']['tmp_name'])) {
            echo '图片不存在!';
            die;
        }
        $file = $_FILES['upfile'];
        if ($max_file_size < $file['size']) {
            echo '文件太大!';
            die;
        }
        if (!in_array($file['type'], $uptypes)) {
            echo '文件类型不符!' . $file['type'];
            die;
        }
        $filename = $file['tmp_name'];
        $image_size = getimagesize($filename);
        $pinfo = pathinfo($file['name']);
        $ftype = $pinfo['extension'];
        $destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . '.' . $ftype;
        if (file_exists($destination) && $overwrite != true) {
            echo '同名文件已经存在了';
            die;
        }
        if (!move_uploaded_file($filename, $destination)) {
            echo '移动文件出错';
            die;
        }
        $pinfo = pathinfo($destination);
        $fname = tomedia($pinfo['basename']);
        echo $fname;
        @(require_once IA_ROOT . '/framework/function/file.func.php');
        @($filename = $fname);
        @file_remote_upload($filename);
    }
    //专家头像
    public function doPageUploadsarray() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $uptypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');
        $max_file_size = 2000000;
        $destination_folder = '../attachment/';
        if (!is_uploaded_file($_FILES['upfile']['tmp_name'])) {
            echo '图片不存在!';
            die;
        }
        $file = $_FILES['upfile'];
        if ($max_file_size < $file['size']) {
            echo '文件太大!';
            die;
        }
        if (!in_array($file['type'], $uptypes)) {
            echo '文件类型不符!' . $file['type'];
            die;
        }
        $filename = $file['tmp_name'];
        $image_size = getimagesize($filename);
        $pinfo = pathinfo($file['name']);
        $ftype = $pinfo['extension'];
        $destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . '.' . $ftype;
        if (file_exists($destination) && $overwrite != true) {
            echo '同名文件已经存在了';
            die;
        }
        if (!move_uploaded_file($filename, $destination)) {
            echo '移动文件出错';
            die;
        }
        $pinfo = pathinfo($destination);
        $fname = $pinfo['basename'];
        echo $fname;
        @(require_once IA_ROOT . '/framework/function/file.func.php');
        @($filename = $fname);
        @file_remote_upload($filename);
    }
    public function doPageMyzhuanjiaimg() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $data = array('z_thumbs' => $_REQUEST['uplogo'],);
        $pdogx = pdo_update('hyb_yl_zhuanjia', $data, array('openid' => $_REQUEST['openid'], 'uniacid' => $uniacid));
        return $this->result(0, 'success', $pdogx);
    }
    //查询所有课程分类
    public function doPageKcfl() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['fl_id'];
        if (empty($id)) {
            $baseInfos = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_schoolroom") . " as a left join " . tablename("hyb_yl_jfenl") . " as b on a.room_fl=b.fl_id  where a.uniacid = '{$uniacid}' and a.room_parentid=0  ORDER BY sord ");
        } else {
            $baseInfos = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_schoolroom") . " as a left join " . tablename("hyb_yl_jfenl") . " as b on a.room_fl=b.fl_id  where a.room_fl='{$id}' and a.room_parentid=0 and a.uniacid = '{$uniacid}' ORDER BY sord ");
        }
        if ($id == 'undefined') {
            $baseInfos = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_schoolroom") . " as a left join " . tablename("hyb_yl_jfenl") . " as b on a.room_fl=b.fl_id  where a.uniacid = '{$uniacid}' and a.room_parentid=0  ORDER BY sord ");
        }
        foreach ($baseInfos as & $value) {
            $id = $value['id'];
            $ress = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_schoolroom') . "where uniacid = '{$uniacid}' and room_parentid='{$id}'");
            $count = count($ress);
            $value['num'] = $count;
            $value['room_thumb'] = $_W['attachurl'] . $value['room_thumb'];
        }
        return $this->result(0, 'success', $baseInfos);
    }
    //查询分类患者案例
    public function doPageHzfl() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['fl_id'];
        if ($id == 'undefined' || $id == '') {
            $baseInfos = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_huanzhe") . " where uniacid = '{$uniacid}' ORDER BY sord ", array(":uniacid" => $uniacid));
        } else {
            $baseInfos = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_huanzhe") . "WHERE `hz_zlks` = '{$id}' and uniacid = '{$uniacid}' ORDER BY sord", array(":uniacid" => $uniacid));
        }
        foreach ($baseInfos as & $value) {
            $value['hz_thumb'] = $_W['attachurl'] . $value['hz_thumb'];
        }
        return $this->result(0, 'success', $baseInfos);
    }
    //查询所有分类
    public function doPageSelecthzfl() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $baseInfos = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_huanzhe") . "WHERE hz_type = 1 and `uniacid` = '{$uniacid}'", array(":uniacid" => $uniacid));
        foreach ($baseInfos as & $value) {
            $value['hz_thumb'] = $_W['attachurl'] . $value['hz_thumb'];
        }
        return $this->result(0, 'success', $baseInfos);
    }
    public function doPageSchoolfl() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $daohangs = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_keshi") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        return $this->result(0, 'success', $daohangs);
    }
    //视频分类
    public function doPageSchoolflarray() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $daohangs = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_jfenl") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        return $this->result(0, 'success', $daohangs);
    }
    //推荐视频
    public function doPageTjvideo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $baseInfos = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_schoolroom") . "WHERE room_tj=1 and iflouc=0 and uniacid='{$uniacid}' order by sord limit 8", array(":uniacid" => $uniacid));
        foreach ($baseInfos as $key => $value) {
            $id = $value['id'];
            $ress = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_schoolroom') . "where uniacid = '{$uniacid}' and room_parentid='{$id}'");
            $count = count($ress);
            $baseInfos[$key]['num'] = $count;
            $value[$key]['room_thumb'] = $_W['attachurl'] . $value['room_thumb'];
        }
        return $this->result(0, 'success', $baseInfos);
    }
    public function doPageTjvideoer() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $baseInfos = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_schoolroom") . "WHERE room_tj=1 and iflouc !=0 and uniacid='{$uniacid}' order by sord limit 8", array(":uniacid" => $uniacid));
        foreach ($baseInfos as $key => $value) {
            $id = $value['id'];
            $ress = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_schoolroom') . "where uniacid = '{$uniacid}' and room_parentid='{$id}'");
            $count = count($ress);
            $baseInfos[$key]['num'] = $count;
            $value[$key]['room_thumb'] = $_W['attachurl'] . $value['room_thumb'];
        }
        return $this->result(0, 'success', $baseInfos);
    }
    //视频详情
    public function doPageVideoxiang() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        $baseInfo = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_schoolroom') . " WHERE id = '{$id}' and uniacid = '{$uniacid}' ", array(':uniacid' => $uniacid));
        if ($baseInfo['kaiguan'] == 0) {
            if ($baseInfo['spkg'] == 0) {
                $baseInfo['room_video'] = $_W['attachurl'] . $baseInfo['room_video'];
            } else {
                $baseInfo['room_video'] = $baseInfo['al_video'];
            }
        } else {
            if ($baseInfo['ypkg'] == 0) {
                $baseInfo['mp3'] = $_W['attachurl'] . $baseInfo['mp3'];
            } else {
                $baseInfo['mp3'] = $baseInfo['mp3m'];
            }
        }
        $baseInfo['tea_pic'] = $_W['attachurl'] . $baseInfo['tea_pic'];
        $baseInfo['room_thumb'] = $_W['attachurl'] . $baseInfo['room_thumb'];
        return $this->result(0, 'success', $baseInfo);
    }
    public function doPageMianfei() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        $openid = $_REQUEST['openid'];
        $baseInfo = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_sorder') . " WHERE s_pid = '{$id}' and s_openid= '{$openid}' and s_type = 0 and uniacid = '{$uniacid}'");
        return $this->result(0, 'success', $baseInfo);
    }
    public function doPageMygou() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        $openid = $_REQUEST['openid'];
        $baseInfo = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_sorder') . " WHERE s_pid = '{$id}' and s_openid= '{$openid}' and uniacid = '{$uniacid}'");
        return $this->result(0, 'success', $baseInfo);
    }
    //我的评论
    public function doPagePingl() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $s_id = $_REQUEST['s_id'];
        $pingl = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_sorder") . " where uniacid='{$uniacid}' and s_id='{$s_id}' and s_openid = '{$openid}' ", array("uniacid" => $uniacid));
        return $this->result(0, "success", $pingl);
    }
    //订单的评价
    public function doPageAllorderspingj() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_sorder") . " as a left join " . tablename("hyb_yl_schoolroom") . " as b on a.s_pid=b.id  where a.s_openid='{$openid}' and a.uniacid='{$uniacid}' and a.m_comment =''  group BY a.s_id DESC");
        foreach ($res as & $value) {
            $value['room_thumb'] = $_W['attachurl'] . $value['room_thumb'];
        }
        return $this->result(0, "success", $res);
    }
    //已评价
    public function doPageAllordersypj() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_sorder") . " as a left join " . tablename("hyb_yl_schoolroom") . " as b on a.s_pid=b.id  where a.s_openid='{$openid}' and a.uniacid='{$uniacid}' and a.m_comment !=''  group BY a.s_id DESC");
        foreach ($res as & $value) {
            $value['room_thumb'] = $_W['attachurl'] . $value['room_thumb'];
        }
        return $this->result(0, "success", $res);
    }
    public function doPageBase() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];

        $baseInfo = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_bace') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        $baseInfo['show_thumb'] = unserialize($baseInfo['show_thumb']);
        $baseInfo['slide'] = unserialize($baseInfo['slide']);
        $baseInfo['goodslunb'] = unserialize($baseInfo['goodslunb']);
        $baseInfo['back_zjthumb'] = unserialize($baseInfo['back_zjthumb']);
        $baseInfo['zhciheng'] =explode(',',$baseInfo['zhciheng']);
        $num = count($baseInfo['show_thumb']);
        $slinum = count($baseInfo['slide']);
        $goodsnum = count($baseInfo['goodslunb']);
        $back_zjthumb = count($baseInfo['back_zjthumb']);

        for ($i = 0;$i < $num;$i++) {
            $baseInfo['show_thumb'][$i] = $_W['attachurl'] . $baseInfo['show_thumb'][$i];
        }
        for ($i = 0;$i < $slinum;$i++) {
            $baseInfo['slide'][$i] = $_W['attachurl'] . $baseInfo['slide'][$i];
        }
        for ($i = 0;$i < $goodsnum;$i++) {
            $baseInfo['goodslunb'][$i] = $_W['attachurl'] . $baseInfo['goodslunb'][$i];
        }
        for ($i = 0;$i < $back_zjthumb;$i++) {
            $baseInfo['back_zjthumb'][$i] = $_W['attachurl'] . $baseInfo['back_zjthumb'][$i];
        }
        $baseInfo['yy_thumb'] = $_W['attachurl'] . $baseInfo['yy_thumb'];
        $baseInfo['bq_thumb'] = $_W['attachurl'] . $baseInfo['bq_thumb'];
        $baseInfo['tj_thumb'] = $_W['attachurl'] . $baseInfo['tj_thumb'];
        $baseInfo['tjl_thumb'] = $_W['attachurl'] . $baseInfo['tjl_thumb'];
        $baseInfo['servicePackage']=array(
            array(
                   'title'=>'手术快约',
                   'state'=> 0,
                   'id'=> 1,
                   'image' => $_W['attachurl'] . $baseInfo['back_thumb'],
                ),
            array(
                   'title'=>'专家坐诊',
                   'state'=> 1,
                   'id'=>  2,
                   'image' => $_W['attachurl'] . $baseInfo['zuozdoc_thumb'],
                ),
            array(
                   'title'=>'点名会诊',
                   'state'=> 1,
                   'id'=> 3,
                   'image' => $_W['attachurl'] . $baseInfo['dianm_thumb']
                ),
        
            );
                    // $dataa ='{"background":"#ffffff","color":"#666666","img":"./resource/images/nopic.jpg","interval":"5"}';

       
        return $this->result(0, 'success', $baseInfo);
    }
    //资讯详情
    public function doPageXiangq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);
        $datas = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zixun") . "WHERE id='{$id}' and uniacid ='{$uniacid}'", array(":uniacid" => $uniacid));
        $datas['thumb'] = $_W['attachurl'] . $datas['thumb'];
        if ($datas['kiguan'] == 1) {
            $datas['mp3'] = $datas['aliaut'];
        } else {
            $datas['mp3'] = $_W['attachurl'] . $datas['mp3'];
        }
        $daras['time'] = date("Y-m-d H:i:s", $datas['time']);
        return $this->result(0, 'success', $datas);
    }
    //资讯分类
    public function doPageFenli() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $daohangs = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun_type") . " where uniacid=:uniacid and zx_type = 1 ", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $daohangs);
    }
    public function doPageFenliarray() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $daohangs = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun_type") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $daohangs);
    }
    //资讯分类数据
    public function doPageFenlidata() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['zx_id']);
        $daohangs = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zixun") . " where uniacid=:uniacid and zx_names = '{$id}'", array(":uniacid" => $uniacid));
        $daohangs['thumb'] = $_W['attachurl'] . $daohangs['thumb'];
        return $this->result(0, "success", $daohangs);
    }
    public function doPageDaohang() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $daohangs = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_daohang") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        foreach ($daohangs as & $value) {
            $value['thumb'] = $_W['attachurl'] . $value['thumb'];
        }
        return $this->result(0, "success", $daohangs);
    }
    public function doPageDaohangxiangqing() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        $daohangxq = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_daohang") . " where uniacid=:uniacid and id=:id", array(":uniacid" => $uniacid, ":id" => $id));
        $daohangxq['content_thumb'] = $_W['attachurl'] . $daohangxq['content_thumb'];
        return $this->result(0, "success", $daohangxq);
    }
    public function doPageFuwu() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $fuwu = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_fuwu") . "  where uniacid=:uniacid ", array(":uniacid" => $uniacid));
        foreach ($fuwu as & $value) {
            $value['fuwu_thumb'] = $_W['attachurl'] . $value['fuwu_thumb'];
        }
        return $this->result(0, "success", $fuwu);
    }
    public function doPageMyser() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $fuwu = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_myser") . "  where uniacid=:uniacid", array(":uniacid" => $uniacid));
        foreach ($fuwu as & $value) {
            $value['ser_thumb'] = $_W['attachurl'] . $value['ser_thumb'];
        }
        return $this->result(0, "success", $fuwu);
    }
    public function doPageZhuanjia() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $zjlist = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " as zj left join " . tablename("hyb_yl_addresshospitai") . " as k on zj.nksid=k.id where zj.uniacid='{$uniacid}'  and zj.z_yy_sheng = 1 order by zj.sord asc", array(":uniacid" => $uniacid));
        foreach ($zjlist as & $value) {
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
            $value['url'] = unserialize($value['url']);
        }
        return $this->result(0, "success", $zjlist);
    }
    public function doPageZhuanjiawenz() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $zjlist = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " as zj left join " . tablename("hyb_yl_addresshospitai") . " as k on zj.nksid=k.id where zj.uniacid='{$uniacid}'  and zj.z_yy_sheng = 1 and zj.z_shenfengzheng != 1 order by zj.sord asc", array(":uniacid" => $uniacid));
        foreach ($zjlist as & $value) {
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
            $value['url'] = unserialize($value['url']);
        }
        return $this->result(0, "success", $zjlist);
    }
    public function doPageZhuanjiaxiangqing() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $zj_xiangqing = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " as a left join " . tablename("hyb_yl_addresshospitai") . " as b on a.nksid=b.id where a.zid='{$id}' and a.uniacid='{$uniacid}'", array("uniacid" => $_W['uniacid']));
        $zj_xiangqing['z_thumbs'] = $_W['attachurl'] . $zj_xiangqing['z_thumbs'];
        $zj_xiangqing['twzixun'] =unserialize($zj_xiangqing['twzixun']);
        $zj_xiangqing['zaixianpt'] =unserialize($zj_xiangqing['twzixun']['putonguser']); 
        $zj_xiangqing['zaixianfe'] =unserialize($zj_xiangqing['twzixun']['fufeiuser']); 
        $zj_xiangqing['url'] = unserialize($zj_xiangqing['url']);
        $zj_xiangqing['shanchang'] = explode(',', $zj_xiangqing['z_zhenzhi']);
        $zj_xiangqing['fufeiuser']=unserialize($zj_xiangqing['twzixun']['fufeiuser']);
        $zj_xiangqing['putonguser']=unserialize($zj_xiangqing['twzixun']['putonguser']);
        return $this->result(0, "success", $zj_xiangqing);
    }
    public function doPageZhuanjiazl() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $zl = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
        $zl['z_thumb'] = $_W['attachurl'] . $zl['z_thumb'];
        return $this->result(0, "success", $zl);
    }
    // 专家粉丝
    public function doPageCheckCollect2() {
        global $_W, $_GPC;
        $id = intval($_REQUEST['goods_id']);
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];

        $rst = pdo_get('hyb_yl_collect', array('goods_id' => $id, 'openid' => $openid,'cerated_type'=>0));
        echo json_encode($rst);
    }
    public function doPageCheckCollect()
    {
      global $_W, $_GPC;
      $id = intval($_REQUEST['goods_id']);
      $openid = $_GPC['openid'];
      $uniacid = $_W['uniacid'];
      $cerated_type =$_GPC['cerated_type'];
      $rst = pdo_get('hyb_yl_collect', array('goods_id' => $id, 'openid' => $openid,'cerated_type'=>$cerated_type));
      if ($rst) {
        echo '2';
      } else {
        echo '1';
      }
    }
    //关注

    public function doPageSaveCollect1() {
        global $_W, $_GPC;
        $id = intval($_REQUEST['goods_id']);
        $re = pdo_get('hyb_yl_collect', array('openid' => $_GPC['openid'], 'goods_id' => $id));
        if ($re) {
            echo '1';
        } else {
            $data['openid'] = $_GPC['openid'];
            $data['goods_id'] = $id;
            $data['cerated_time'] = date('Y-m-d H:i:s');
            $res = pdo_insert('hyb_yl_collect', $data);
            if ($res) {
                // pdo_update('nangua_sign', array('id' =>$id));
                echo '1';
            } else {
                echo '2';
            }
        }
    }
public function doPageSaveCollect(){
  global $_W, $_GPC;
  $id = intval($_REQUEST['goods_id']);
  $cerated_type = $_GPC['cerated_type'];
  $re = pdo_get('hyb_yl_collect', 
    array(
      'openid' => $_GPC['openid'], 
      'goods_id' =>$id,
      'cerated_type' =>$cerated_type
      )
    );
  if ($re) {
        $result = pdo_delete('hyb_yl_collect', array('id' => $re['id']));
        //pdo_update('hyb_yl_zhuanjia', array('z_yy_fens -=' => 1), array('zid' => $id));
        echo '1';
  } else {
    $data['openid'] = $_GPC['openid'];
    $data['goods_id'] = $id;
    $data['cerated_type'] = $cerated_type;
    $data['cerated_time'] = date('Y-m-d H:i:s');
    $res = pdo_insert('hyb_yl_collect', $data);
            //var_dump($data['openid']);
    if ($res) {
      pdo_update('hyb_yl_zhuanjia',array('z_yy_fens +=' => 1),  array('zid' =>$id));
      echo '1';
    } else {
      echo '2';
    }
  }
}
    //查询专家余额
    public function doPageDoctormoney() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $getmoney = pdo_get('hyb_yl_zhuanjia', array('uniacid' => $uniacid, 'openid' => $openid));
        //$getmoney['d_txmoney']=unserialize($getmoney['d_txmoney']);
        return $this->result(0, "success", $getmoney);
    }
    //查询专家提现余额
    public function doPageDoctormoneytx() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $getmoney = pdo_fetch("SELECT SUM(countmoney) as `money` FROM " . tablename("hyb_yl_mymoney") . " where `use_openid`='{$openid}' and uniacid = '{$uniacid}' ", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $getmoney);
    }
    //专家提现
    public function doPageSaveTx() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $rows = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " where openid='{$openid}' and uniacid = '{$uniacid}' ", array(":uniacid" => $uniacid));
        $data['tx_type'] = $_GPC['tx_type'];
        $data['tx_cost'] = $_GPC['tx_cost'];
        $data['status'] = 1;
        $data['sj_cost'] = $_GPC['sj_cost'];
        $data['user_openid'] = $openid;
        $data['uniacid'] = $_W['uniacid'];
        $data['cerated_time'] = strtotime("now");
        $data['tx_admin'] = $_GPC['tx_admin'];
        $data['zjid'] = $_GPC['zjid'];
        $res = pdo_insert('hyb_yl_yltx', $data);
        $money = $rows['overmoney'] - $_GPC['tx_cost'];
        if ($res) {
            if ($rows) {
                $update = pdo_update('hyb_yl_zhuanjia', array('overmoney' => $money), array('openid' => $openid, 'uniacid' => $uniacid));
            }
            echo '1';
        } else {
            echo '2';
        }
    }
    //专家问答
    public function doPageQuestion() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pid = intval($_REQUEST['pid']);
        $res = pdo_fetchall("select * from ( select * from " . tablename("hyb_yl_question") . " order by qid desc ) as b WHERE p_id='{$pid}' and sj_type = 1  group by user_openid limit 3");
        foreach ($res as & $value) {
            $value['z_thumb'] = $_W['attachurl'] . $value['z_thumb'];
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
        }
        return $this->result(0, "success", $res);
    }
    //专家问答
    public function doPageSelectallque() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pid = intval($_REQUEST['zid']);
        $res = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid where a.p_id = '{$pid}' and a.uniacid = '{$uniacid}' and sj_type = 1 order by a.qid desc", array(":uniacid" => $uniacid));
        foreach ($res as & $value) {
            $value['z_thumb'] = $_W['attachurl'] . $value['z_thumb'];
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
        }
        return $this->result(0, "success", $res);
    }
    //查询发现页面问题详情
    public function doPageFquestion() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pid = intval($_REQUEST['pid']);
        $res = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid where a.qid = '{$pid}' and a.uniacid = '{$uniacid}' and a.sj_type = 1", array(":uniacid" => $uniacid));
        $res['hd_question'] = unserialize($res['hd_question']);
        $res['z_thumbs'] = $_W['attachurl'] . $res['z_thumbs'];
        $res['q_docthumb'] = $_W['attachurl'] . $res['q_docthumb'];
        return $this->result(0, "success", $res);
    }
    //查询发现页面问题详情
    public function doPageFquestionoption() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pid = intval($_REQUEST['pid']);
        $res = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid where a.qid = '{$pid}' and a.uniacid = '{$uniacid}' and a.sj_type = 1", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $res);
    }
    //我的问题详情
    public function doPageMyqinfo() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pid = intval($_REQUEST['pid']);
        $res = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid  where a.qid = '{$pid}' and a.uniacid = '{$uniacid}'", array(":uniacid" => $uniacid));
        $res['z_thumb'] = $_W['attachurl'] . $res['z_thumb'];
        return $this->result(0, "success", $res);
    }
    //所有专家推荐问答
    public function doPageQusetiontype() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid left join" . tablename('hyb_yl_category') . "as c on c.id = b.z_room left join " . tablename('hyb_yl_overquestion') . "as d on d.useropenid =a.user_openid where  a.uniacid = '{$uniacid}' and a.if_over = 1 order by a.qid desc", array(':uniacid' => $uniacid));
        $pindex = max(1, intval($_GPC['page']));
        $pagesize = 6;
        $pager = pagination($total, $pindex, $pagesize);
        $p = ($pindex - 1) * $pagesize;
        $res = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid left join" . tablename('hyb_yl_category') . "as c on c.id = b.z_room left join " . tablename('hyb_yl_overquestion') . "as d on d.useropenid =a.user_openid where  a.uniacid = '{$uniacid}' and a.if_over = 1 order by a.qid desc limit " . $p . "," . $pagesize);
        foreach ($res as & $value) {
            $value['user_picture'] = unserialize($value['user_picture']);
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
            $num = count($value['user_picture']);
            for ($i = 0;$i < $num;$i++) {
                $value['user_picture'][$i] = $_W['attachurl'] . $value['user_picture'][$i];
            }
        }
        return $this->result(0, "success", $res);
    }
    //查询所有用户图片
    public function doPageUserpic() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $qid = $_GPC['qid'];
        $res = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_question") . " where  uniacid = '{$uniacid}' and sj_type = 1 and  qid = '{$qid}' order by qid asc", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $res);
    }
    //w问题图片
    public function doPageQuestionimg() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $allcoment = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_category') . "WHERE uniacid = :uniacid and parentid =0", array(':uniacid' => $this->uniacid));
        return $this->result(0, "success", $allcoment);
    }
    //图片分类回答
    public function doPageQuestionimgsingle() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        if (!empty($id)) {
            //1.查询一级
           $erji1 = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_category') . "where uniacid='{$uniacid}' and parentid='{$id}'");
           $arrinfo =array();
           foreach ($erji1 as & $value) {

            //循环查询所有二级下的公开问题
            $erjid1 = $value['id'];        
            $allcoment = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid left join" . tablename('hyb_yl_category') . "as c on c.id = b.z_room  where  a.uniacid = '{$uniacid}' and a.if_over = 1 and (a.q_category='{$id}' or a.q_category='{$erjid1}') order by a.qid desc");
            $arrinfo[] = $allcoment;
           }    
            $allcoment['data'] = array_filter($arrinfo);
            $arr2 = array();
            //循环遍历三维数组$arr3
            foreach ($allcoment as & $value) {
                foreach ($value as & $v) {
                    $arr2[] = $v;
                }
            }
            $werw = array_unique($arr2);
            foreach ($werw as & $v2) {
                foreach ($v2 as & $v1) {
                    $arr3[] = $v1;
                }
            }
         
           
            foreach ($arr3 as & $value) {
                $value['user_picture'] = unserialize($value['user_picture']);
                $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
                $num = count($value['user_picture']);
                for ($i = 0;$i < $num;$i++) {
                    $value['user_picture'][$i] = $_W['attachurl'] . $value['user_picture'][$i];
                }
            }

            //2.查询二级,先查询一级下面的所有二级
            if (empty($allcoment)) {
                $erji = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_category') . "where uniacid='{$uniacid}' and parentid='{$id}'");
                $arr =array();
                foreach ($erji as & $value) {
                    //循环查询所有二级下的公开问题
                    $erjid = $value['id'];
                    $kidinfo = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid left join" . tablename('hyb_yl_category') . "as c on c.id = b.z_room left join " . tablename('hyb_yl_overquestion') . "as d on d.useropenid =a.user_openid where  a.uniacid = '{$uniacid}' and a.if_over = 1 and d.kid='{$erjid}'order by a.qid desc");
                    $arr[] = $kidinfo;
                }


                $allcoment['data'] = array_filter($arr);
                $arr2 = array();
                //循环遍历三维数组$arr3
                foreach ($allcoment as & $value) {
                    foreach ($value as & $v) {
                        $arr2[] = $v;
                    }
                }
                foreach ($arr2 as & $v2) {
                    foreach ($v2 as & $v1) {
                        $arr3[] = $v1;
                    }
                }
                foreach ($arr3 as & $value) {

                    $value['user_picture'] = unserialize($value['user_picture']);
                    $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
                    $num = count($value['user_picture']);
                    for ($i = 0;$i < $num;$i++) {
                        $value['user_picture'][$i] = $_W['attachurl'] . $value['user_picture'][$i];
                    }
                }
                return $this->result(0, "success", $arr3);
            } else {
                foreach ($allcoment as & $value) {
                    $value['user_picture'] = unserialize($value['user_picture']);
                    $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
                }

                return $this->result(0, "success", $arr3);
            }


        } else {
            $allcoment1 = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_question") . " as a left join " . tablename("hyb_yl_zhuanjia") . "as b on a.p_id=b.zid left join" . tablename('hyb_yl_category') . "as c on c.id = b.z_room left join " . tablename('hyb_yl_overquestion') . "as d on d.useropenid =a.user_openid where  a.uniacid = '{$uniacid}' and a.if_over = 1  group by a.user_openid desc");
            foreach ($allcoment1 as & $value) {
                $value['user_picture'] = unserialize($value['user_picture']);
                $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
                $num = count($value['user_picture']);
                for ($i = 0;$i < $num;$i++) {
                    $value['user_picture'][$i] = $_W['attachurl'] . $value['user_picture'][$i];
                }
            }
            return $this->result(0, "success", $allcoment1);
        }
        //return $this->result(0,"success",$allcoment1);
        
    }
    function mbstringtoarray($str,$charset) {
      $strlen=mb_strlen($str);
      while($strlen){
        $array[]=mb_substr($str,0,1,$charset);
        $str=mb_substr($str,1,$strlen,$charset);
        $strlen=mb_strlen($str);
      }
      return $array;
    }
    //课堂评价
    public function doPageRoomcoment() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $s_id = $_GPC['s_id'];
        $data['m_comment'] = $_GPC['m_comment'];
        $data['m_fenshu'] = $_GPC['m_fenshu'];
        $data['name'] = $_GPC['name'];
        $data['m_img'] = $_GPC['m_img'];
        $data['m_time'] = date('Y-m-d H:i:s');
        $u_phone = pdo_getcolumn('hyb_yl_sorder', array('s_id' => $s_id, 'uniacid' => $uniacid), 'm_comment');
        $getupdate = pdo_update("hyb_yl_sorder", $data, array('s_id' => $s_id, 'uniacid' => $uniacid));
        return $this->result(0, "success", $getupdate);
    }
    //
    //课堂评价
    public function doPageRoomcomentarray() {
        global $_W, $_GPC;
        $mid = $_REQUEST['kc_id'];
        $openid = $_REQUEST['m_openid'];
        $uniacid = $_W['uniacid'];
        $kc_id = $_GPC['kc_id'];
        $data['uniacid'] = $_W['uniacid'];
        $data['m_openid'] = $_GPC['m_openid'];
        $data['m_money'] = $_GPC['m_money'];
        $data['kc_id'] = $_GPC['kc_id'];
        $data['m_comment'] = $_GPC['m_comment'];
        $data['m_fenshu'] = $_GPC['m_fenshu'];
        $data['name'] = $_GPC['name'];
        $data['m_img'] = $_GPC['m_img'];
        $data['m_time'] = date('Y-m-d H:i:s');
        $data['m_tj'] = 0;
        $data['m_type'] = $_GPC['m_type'];
        $res = pdo_insert('hyb_yl_mcoment', $data);
        return $this->result(0, "success", $getupdate);
    }
    //查询所有评论
    public function doPageAllcoment() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        $allcoment = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_sorder") . " where uniacid=:uniacid and `s_pid` = '{$id}' order by s_id desc", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $allcoment);
    }
    //查询患者所有评论
    public function doPageAllcoments() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['hz_id']);
        $allcoment = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_mcoment") . " where uniacid=:uniacid and `kc_id` = '{$id}' and `m_type` = 3 ORDER BY m_id asc ", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $allcoment);
    }
    //查询资讯所有评论
    public function doPageAllzicoment() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        $allcoment = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_mcoment") . " where uniacid=:uniacid and `kc_id` = '{$id}' and `m_type` = 2 ORDER BY m_id asc ", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $allcoment);
    }
    // 查询患者案例点赞
    public function doPageAllhzzan() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['goods_id']);
        $openid = $_GPC['openid'];
        $baseInfo = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename('hyb_yl_collect') . " WHERE `cerated_type` = 2 and goods_id = '{$id}' ");
        return $this->result(0, "success", $baseInfo);
    }
    // 查询个人资讯点赞
    public function doPageAllzzan() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['goods_id']);
        $openid = $_GPC['openid'];
        $baseInfo = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename('hyb_yl_collect') . " WHERE `cerated_type` = 3 and goods_id = '{$id}' ");
        return $this->result(0, "success", $baseInfo);
    }
    // 查询个人资讯点赞
    public function doPageAllpzan() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['goods_id']);
        $openid = $_GPC['openid'];
        $baseInfo = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename('hyb_yl_collect') . " WHERE `cerated_type` = 4 and goods_id = '{$id}'");
        return $this->result(0, "success", $baseInfo);
    }
    //专家搜索
    public function doPageActivity() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $op = empty($_GPC['keywords']) ? '' : $_GPC['keywords'];
        if (!empty($op)) {
            $where = "%{$op}%";
        } else {
            $where = '%%';
        }
        $sql = "select *  from " . tablename('hyb_yl_zhuanjia') . " as zj left join " . tablename("hyb_yl_category") . "as k on zj.z_room=k.id where  zj.uniacid='{$uniacid}' and zj.z_yy_sheng = 1 and k.name LIKE '{$where}' ORDER BY  zj.zid desc";
        $list = pdo_fetchall($sql, array('uniacid' => $_W['uniacid']));
        foreach ($list as & $value) {
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
        }
        echo json_encode($list);
    }
    //查询专家坐诊时间
    public function doPageZhuanjiazuozhen() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //查询已预约的时间
        $zhuanjia = pdo_fetch("SELECT z_name FROM " . tablename("hyb_yl_zhuanjia") . " where uniacid=:uniacid and openid=:openid ", array(":uniacid" => $uniacid, ":openid" => $openid));
        $riqi = pdo_fetchall("SELECT riqi  FROM " . tablename("hyb_yl_zhuanjia_yuyuetime") . " WHERE uniacid=:uniacid and openid=:openid order by riqi asc", array(":uniacid" => $uniacid, ":openid" => $openid));
        foreach ($riqi as $key => $value) {
            //查询已预约的时间
            $yy_time = pdo_fetchall("SELECT zy_time FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " where uniacid=:uniacid and zy_riqi=:zy_riqi ", array(":uniacid" => $uniacid, ":zy_riqi" => $value['riqi']));
            //查询未预约的时间
            $wy_time = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyuetime") . " where uniacid=:uniacid and riqi=:riqi order by riqi asc", array(":uniacid" => $uniacid, ":riqi" => $value['riqi']));
            $wy_times = explode(",", $wy_time['time']);
            $a1 = array();
            foreach ($yy_time as $k => $val) {
                $a1[$k] = $val['zy_time'];
            }
            foreach ($a1 as $key1 => $v1) {
                foreach ($wy_times as $key2 => $v2) {
                    if ($v1 == $v2) {
                        //unset($a1[$key1]);//删除$a1数组同值元素
                        unset($wy_times[$key2]); //删除$weiyy_time数组同值元素
                        
                    }
                }
            }
            //var_dump($wy_times);
            $riqi[$key]['o_wy_time'] = $wy_times;
        }
        return $this->result(0, "success", $riqi);
    }
    public function doPageAllquestyi() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $allquestwei = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_question') . "where (savant_openid = '{$openid}' or fromuser='{$openid}') and uniacid='{$uniacid}'  and yuedu =1 order by q_time desc", array("uniacid" => $uniacid));
        // $allquestwei = pdo_fetchall("SELECT * FROM".tablename('hyb_yl_question')."as a left join".tablename('hyb_yl_overquestion')."as b on b.useropenid =a.user_openid and b.zid =a.p_id where a.savant_openid = '{$openid}'and a.uniacid='{$uniacid}' and a.yuedu =1   order by a.qid desc",array("uniacid"=>$uniacid));
        // foreach ($allquestwei as &$value) {
        //       $value['user_picture'] = unserialize($value['user_picture']);
        //       $num = count($value['user_picture']);
        //       for($i = 0; $i < $num; $i++) {
        //          $value['user_picture'][$i] = $_W['attachurl'].$value['user_picture'][$i];
        //      }
        //  }
        return $this->result(0, "success", $allquestwei);
    }
    public function doPageAllquestwei() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $allquestwei = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_question') . "where fromuser='{$openid}' and uniacid='{$uniacid}'  and yuedu =0  and usertype =0 order by qid desc", array("uniacid" => $uniacid));
        foreach ($allquestwei as & $value) {
            $value['user_picture'] = unserialize($value['user_picture']);
            $num = count($value['user_picture']);
            for ($i = 0;$i < $num;$i++) {
                $value['user_picture'][$i] = $_W['attachurl'] . $value['user_picture'][$i];
            }
        }
        return $this->result(0, "success", $allquestwei);
    }
    //回答备份
    public function doPageAllerciquestion() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $pid = intval($_REQUEST['qid']);
        $allquestwei = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_docquestion') . "where do_openid = '{$openid}'and uniacid='{$uniacid}' and p_id ='{$pid}' ", array("uniacid" => $uniacid));
        return $this->result(0, "success", $allquestwei);
    }
    //专家回答
    public function doPageInsertvalue() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $qid = intval($_REQUEST['qid']);
        $hd_question = $_REQUEST['hd_question'];
        $zid = $_GPC['zid'];
        $selectdata = pdo_fetch("SELECT * FROM" . tablename('hyb_yl_question') . "where qid = '{$qid}' and uniacid = '{$uniacid}' order by qid desc ", array("uniacid" => $uniacid));
        if ($selectdata['hd_question'] == '') {
            $u_phone = pdo_getcolumn('hyb_yl_question', array('savant_openid' => $selectdata['savant_openid']), 'hd_question');
            $datas = array('hd_question' => $hd_question);
            $getupdate = pdo_update("hyb_yl_question", $datas, array('savant_openid' => $selectdata['savant_openid'], 'uniacid' => $uniacid, 'qid' => $qid));
            $docinfo = pdo_getcolumn('hyb_yl_zhuanjia', array('zid' => $zid, 'uniacid' => $uniacid), 'helpnum');
            $datadoc = array('helpnum' => $docinfo + 1);
            pdo_update('hyb_yl_zhuanjia', $datadoc, array('zid' => $zid, 'uniacid' => $uniacid));
        } else {
            $data['p_id'] = intval($_REQUEST['qid']);
            $data['uniacid'] = $_W['uniacid'];
            $data['da'] = $_REQUEST['hd_question'];
            $data['do_openid'] = $_REQUEST['openid'];
            $res = pdo_insert("hyb_yl_docquestion", $data);
            $docinfo = pdo_getcolumn('hyb_yl_zhuanjia', array('zid' => $zid, 'uniacid' => $uniacid), 'helpnum');
            $datadoc = array('helpnum' => $docinfo + 1);
            pdo_update('hyb_yl_zhuanjia', $datadoc, array('zid' => $zid, 'uniacid' => $uniacid));
        }
        //$pdo_debug = pdo_debug($getupdate);
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    //专家审核
    public function doPagezhuanjiash() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $us_openid = $_GPC['openid'];
        $selimg = pdo_fetchall("SELECT `i_img` FROM" . tablename('hyb_yl_upload_img') . "WHERE i_openid = '{$us_openid}'and uniacid ='{$uniacid}' and i_type=2 ", array("uniacid" => $uniacid));
        foreach ($selimg as $key => $link) {
            foreach ($link as $key1 => $val) {
                echo $val . ";";
            }
        }
    }
    //查询我的病例库
    public function doPageAllbinli() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $us_openid = $_GPC['openid'];
        $res = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_bingzheng") . " as a left join " . tablename("hyb_yl_userinfo") . " as b on a.us_openid=b.openid  where a.us_openid='{$us_openid}' and a.uniacid='{$uniacid}'  ORDER BY a.id DESC", array(":uniacid" => $uniacid));
        return $this->result(0, 'success', $res);
    }
    public function doPageDelbinli() {
        $id = intval($_REQUEST['id']);
        $uniacid = $_REQUEST['uniacid'];
        $del = pdo_delete("hyb_yl_bingzheng", array("id" => $id, "uniacid" => $uniacid));
        return $this->result(0, 'success', $uniacid);
    }
    //删除体检报告
    public function doPageDeltijian() {
        $id = intval($_REQUEST['id']);
        $uniacid = $_REQUEST['uniacid'];
        $del = pdo_delete("hyb_yl_tijianbaogao", array("t_id" => $id, "uniacid" => $uniacid));
        return $this->result(0, 'success', $uniacid);
    }
    //删除体检报告
    public function doPageDeljijian() {
        $id = intval($_REQUEST['id']);
        $uniacid = $_REQUEST['uniacid'];
        $del = pdo_delete("hyb_yl_jianybaogao", array("j_id" => $id, "uniacid" => $uniacid));
        return $this->result(0, 'success', $uniacid);
    }
    //删除视频订单
    public function doPageDelvideo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $id = intval($_REQUEST['id']);
        //var_dump($openid,$uniacid,$id);
        //链表删除
        // $sql = pdo_query("DELETE a,b FROM" . tablename('hyb_yl_sorder')."a INNER JOIN ".tablename('hyb_yl_mcoment')."b ON a.s_pid = b.kc_id and a.s_openid=b.m_openid WHERE a.s_id ='{$id}' and a.s_openid='{$openid}' and a.uniacid = '{$uniacid}' and b.m_comment !='' ");
        $sql = pdo_delete('hyb_yl_sorder', array('s_id' => $id, 'uniacid' => $uniacid));
        // DELETE a,b FROM ims_hyb_yl_sorder a
        // INNER JOIN  ims_hyb_yl_mcoment b
        // ON a.s_pid = b.kc_id and a.s_openid=b.m_openid
        // WHERE a.s_id = '16' and a.s_openid='onMvv0FREZbxVWAHxpWx2mV2UUoc'
        return $this->result(0, 'success', $sql);
    }
    public function doPageAllorders() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_sorder") . " as a left join " . tablename("hyb_yl_schoolroom") . " as b on a.s_pid=b.id  where a.s_openid='{$openid}' and a.uniacid='{$uniacid}'  group BY a.s_id DESC");
        foreach ($res as & $value) {
            $value['room_thumb'] = $_W['attachurl'] . $value['room_thumb'];
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageAllordersyi() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_sorder") . " as a left join " . tablename("hyb_yl_schoolroom") . " as b on a.s_pid=b.id  where a.s_openid='{$openid}' and a.uniacid='{$uniacid}'  ORDER BY a.s_id DESC", array(":uniacid" => $uniacid));
        foreach ($res as & $value) {
            $value['room_thumb'] = $_W['attachurl'] . $value['room_thumb'];
        }
        return $this->result(0, 'success', $res);
    }
    //课堂消费
    public function doPageAllordersyisum() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetch("SELECT SUM(s_ormoney) AS `money` FROM " . tablename("hyb_yl_sorder") . " where `s_openid`='{$openid}'  and uniacid = '{$uniacid}'", array(":uniacid" => $uniacid));
        return $this->result(0, 'success', $res);
    }
    public function doPageZimages() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $us_openid = $_GPC['openid'];
        $dataimg = $_GPC['dataimg'];
        $arr1 = explode(';', $dataimg);
        $data['uniacid'] = $_W['uniacid'];
        $data['openid'] = $_REQUEST['openid'];
        $data['z_name'] = $_REQUEST['z_name'];
        $data['z_content'] = $_REQUEST['z_content'];
        $data['z_room'] = $_REQUEST['pid'];
        $data['z_zhiwu'] = $_REQUEST['z_zhiwu'];
        $data['z_telephone'] = $_REQUEST['z_telephone'];
        $data['z_sex'] = $_REQUEST['z_sex'];
        $data['z_yiyuan'] = $_REQUEST['z_yiyuan'];
        $data['z_thumb'] = serialize($arr1);
        $data['z_thumbs'] = $_REQUEST['z_thumbs'];
        $res = pdo_insert("hyb_yl_zhuanjia", $data);
        if ($res) {
            $del = pdo_delete("hyb_yl_upload_img", array("i_openid" => $us_openid, "i_type" => 2));
        } else {
            echo "2";
        }
        return $this->result(0, 'success', $arr1);
    }
    public function doPageZimagesnew() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $us_openid = $_GPC['openid'];
        $data['uniacid'] = $_W['uniacid'];
        $data['openid'] = $_REQUEST['openid'];
        $data['z_name'] = $_REQUEST['z_name'];
        $data['z_content'] = $_REQUEST['z_content'];
        $data['z_room'] = $_REQUEST['id'];
        $data['z_zhiwu'] = $_REQUEST['z_zhiwu'];
        $data['z_telephone'] = $_REQUEST['z_telephone'];
        $data['z_sex'] = $_REQUEST['z_sex'];
        $data['z_yiyuan'] = $_REQUEST['z_yiyuan'];
        $data['z_room'] = $_GPC['z_room'];
        if ($us_openid) {
            $ress = pdo_update("hyb_yl_zhuanjia", $data, array("openid" => $us_openid, "uniacid" => $uniacid));
            if ($ress) {
                $dele = pdo_delete("hyb_yl_upload_img", array("i_openid" => $us_openid, "i_type" => 2));
            }
        } else {
            $res = pdo_insert("hyb_yl_zhuanjia", $data);
            if ($res) {
                $del = pdo_delete("hyb_yl_upload_img", array("i_openid" => $us_openid, "i_type" => 2));
            } else {
                echo "2";
            }
        }
        return $this->result(0, 'success', $dataimg);
    }
    public function doPageZhuanjiayuyue() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $zy_time_1 = $_REQUEST['zy_time_1'];
        $zy_time_2 = $_REQUEST['zy_time_2'];
        // $zy_time = implode(" ",array($zy_time_1,$zy_time_2));
        $data = array('uniacid' => $_W['uniacid'], 'zy_name' => $_REQUEST['zy_name'], 'zy_sex' => $_REQUEST['zy_sex'], 'zy_zhenzhuang' => $_REQUEST['zy_zhenzhuang'], 'zy_telephone' => $_REQUEST['zy_telephone'], 'zy_yibao' => $_REQUEST['zy_yibao'], 'z_name' => $_REQUEST['z_name'], 'zy_riqi' => $zy_time_1, 'zy_time' => $zy_time_2, "zy_openid" => $_REQUEST['openid'], "zy_type" => "未出诊", "zy_money" => $_REQUEST['z_yy_money'],);
        $res = pdo_insert('hyb_yl_zhuanjia_yuyue', $data);
        if ($res) {
            $resarr = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_email') . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
            //var_dump($resarr);
            $smtpemailto = $resarr['mailhostname']; //'';//发送给谁
            $mailtitle = "预约提醒通知：客户 " . $_REQUEST['zy_name'] . " 手机号：" . $_REQUEST['zy_telephone'] . " 预约专家：" . $_REQUEST['z_name'] . "，预约时间：" . $zy_time; //邮件主题
            $mailcontent = "预约详情：客户 <b>" . $_REQUEST['zy_name'] . "</b>， 手机号：" . $_REQUEST['zy_telephone'] . " 预约 <b>" . $_REQUEST['z_name'] . "</b> 专家，预约时间：<b>" . $zy_time; //
            //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
            require_once ("../framework/library/phpmailer/class.phpmailer.php");
            require_once ("../framework/library/phpmailer/class.smtp.php");
            //实例化PHPMailer核心类
            $mail = new PHPMailer();
            //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
            //$mail->SMTPDebug = 2;
            //使用smtp鉴权方式发送邮件
            $mail->isSMTP();
            //smtp需要鉴权 这个必须是true
            $mail->SMTPAuth = true;
            //链接qq域名邮箱的服务器地址
            $mail->Host = $resarr['mailhost'];
            //设置使用ssl加密方式登录鉴权
            $mail->SMTPSecure = 'ssl';
            //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
            $mail->Port = $resarr['mailport'];
            //设置smtp的helo消息头 这个可有可无 内容任意
            // $mail->Helo = 'Hello smtp.qq.com Server';
            //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
            //$mail->Hostname = $resarr['mailhostname'];
            //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
            $mail->CharSet = 'UTF-8';
            //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
            $mail->FromName = $resarr['mailformname'];
            //smtp登录的账号 这里填入字符串格式的qq号即可
            $mail->Username = $resarr['mailusername'];
            //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
            $mail->Password = $resarr['mailpassword'];
            //SMTP服务器的验证密码 'jvpfoeokxomufgji';//'drtzejqwbdomegbc';//jvpfoeokxomufgji
            //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
            $mail->From = $resarr['mailsend']; //$redis->get('email:send_email');//SMTP服务器的用户邮箱
            //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
            $mail->isHTML(true);
            //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
            $arr_mailto = explode(',', $smtpemailto);
            foreach ($arr_mailto as $v_mailto) {
                $mail->addAddress($v_mailto, '预约通知');
            }
            //添加该邮件的主题
            $mail->Subject = $mailtitle;
            //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
            $mail->Body = $mailcontent;
            $flag = $mail->send();
            if ($flag) {
                $post->error = 0;
                $post->msg = "邮件发送成功！";
                return $this->result(0, 'success', $post);
            } else {
                $post->error = 1;
                $post->msg = "邮件发送失败！请检查邮箱填写是否有误。";
                return $this->result(1, 'error', $post);
            }
            return $this->result(0, 'success');
        } else {
            return $this->result(1, 'error');
        }
    }
    public function doPageZhuanjiayytime() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $time1 = str_replace("[", "", $_REQUEST['time1']);
        $time1s = str_replace("]", "", $time1);
        $time1ss = str_replace('"', "", $time1s);
        $time2 = str_replace("[", "", $_REQUEST['time2']);
        $time2s = str_replace("]", "", $time2);
        $time2ss = str_replace('"', "", $time2s);
        $time3 = str_replace("[", "", $_REQUEST['time3']);
        $time3s = str_replace("]", "", $time3);
        $time3ss = str_replace('"', "", $time3s);
        $data1 = array("uniacid" => $uniacid, "openid" => $openid, "riqi" => $_REQUEST['riqi1'], "time" => $time1ss,);
        $data2 = array("uniacid" => $uniacid, "openid" => $openid, "riqi" => $_REQUEST['riqi2'], "time" => $time2ss,);
        $data3 = array("uniacid" => $uniacid, "openid" => $openid, "riqi" => $_REQUEST['riqi3'], "time" => $time3ss,);
        //查询专家坐诊时间
        $item1 = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyuetime") . " where uniacid =:uniacid and openid=:openid and riqi=:riqi", array(":uniacid" => $uniacid, ":openid" => $openid, ":riqi" => $_REQUEST['riqi1']));
        if (empty($item1['id'])) {
            pdo_insert("hyb_yl_zhuanjia_yuyuetime", $data1);
        } else {
            pdo_update("hyb_yl_zhuanjia_yuyuetime", $data1, array("id" => $item1['id']));
        }
        $item2 = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyuetime") . " where uniacid =:uniacid and openid=:openid and riqi=:riqi", array(":uniacid" => $uniacid, ":openid" => $openid, ":riqi" => $_REQUEST['riqi2']));
        if (empty($item2['id'])) {
            pdo_insert("hyb_yl_zhuanjia_yuyuetime", $data2);
        } else {
            pdo_update("hyb_yl_zhuanjia_yuyuetime", $data2, array("id" => $item2['id']));
        }
        $item3 = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyuetime") . " where uniacid =:uniacid and openid=:openid and riqi=:riqi", array(":uniacid" => $uniacid, ":openid" => $openid, ":riqi" => $_REQUEST['riqi3']));
        if (empty($item3['id'])) {
            pdo_insert("hyb_yl_zhuanjia_yuyuetime", $data3);
        } else {
            pdo_update("hyb_yl_zhuanjia_yuyuetime", $data3, array("id" => $item3['id']));
        }
        $deltime = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyuetime") . " where uniacid=:uniacid and openid=:openid and riqi<:riqi ", array(":uniacid" => $uniacid, ":openid" => $openid, ":riqi" => $_REQUEST['riqi1']));
        foreach ($deltime as & $value) {
            pdo_delete("hyb_yl_zhuanjia_yuyuetime", array("id" => $value['id']));
        }
    }
    public function doPageButton() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $button = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_button_daohang") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        foreach ($button as & $value) {
            $value['fw_thumb'] = $_W['attachurl'] . $value['fw_thumb'];
        }
        return $this->result(0, "success", $button);
    }
    //科室ID查询医生
    public function doPageJdoctor() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $keshi = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_keshi") . " as a left join " . tablename("hyb_yl_zhuanjia") . " as b on a.k_id=b.z_room  where a.k_id='{$id}' and b.uniacid = '{$uniacid}' and b.z_yy_sheng = 1 ", array(":uniacid" => $uniacid));
        foreach ($keshi as & $value) {
            $arr[] = $value['z_name'];
            $arr2[] = $value['z_yy_money'];
            $arr3[] = $value['id'];
        }
        $keshi['z_name'] = $arr;
        $keshi['z_yy_money'] = $arr2;
        $keshi['id'] = $arr3;
        return $this->result(0, "success", $keshi);
    }
    //根据ID查询二级科室
    public function doPageCategory2() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $keshi2 = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_category') . "WHERE parentid = '{$id}' and uniacid = '{$uniacid}'", array('uniacid' => $uniacid));
        foreach ($keshi2 as & $value) {
            $arr[] = $value['id'];
        }
        foreach ($keshi2 as & $value) {
            $arr1[] = $value['name'];
        }
        $keshi2['name'] = $arr1;
        $keshi2['id'] = $arr;
        return $this->result(0, "success", $keshi2);
    }
    //修改医生资料
    public function doPageUpdatazhuanjia() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $data['openid'] = $_REQUEST['openid'];
        $data['z_name'] = $_REQUEST['z_name'];
        $data['z_room'] = $_REQUEST['z_room'];
        $data['z_sex'] = $_REQUEST['z_sex'];
        $data['z_telephone'] = $_REQUEST['z_telephone'];
        $data['z_thumbs'] = $_REQUEST['z_thumbs'];
        $data['z_yiyuan'] = $_REQUEST['z_yiyuan'];
        $data['z_zhiwu'] = $_REQUEST['z_zhiwu'];
        if ($openid) {
            $res = pdo_update('hyb_yl_zhuanjia', $data, array('openid' => $openid, "uniacid" => $uniacid));
        }
        return $this->result(0, "success", $image);
    }
    public function doPageKeshi() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $keshi = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_category") . " where uniacid=:uniacid and parentid = 0", array(":uniacid" => $uniacid));
        foreach ($keshi as & $value) {
            $arrs[] = $value['name'];
        }
        foreach ($keshi as & $value) {
            $arrs1[] = $value['id'];
        }
        $keshi['name'] = $arrs;
        $keshi['id'] = $arrs1;
        return $this->result(0, "success", $keshi);
    }
    public function doPageHdoctor() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $keshi = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " where uniacid='{$uniacid}'", array(":uniacid" => $uniacid));
        foreach ($keshi as & $value) {
            $arr[] = $value['z_name'];
        }
        foreach ($keshi as & $value) {
            $arrs[] = $value['z_yy_money'];
        }
        $keshi['k_name'] = $arr;
        $keshi['k_yuymoney'] = $arrs;
        return $this->result(0, "success", $keshi);
    }
    //我的关注
    public function doPageMyguan() {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];

        $myguan = pdo_fetchall("SELECT a.id as aid,c.id as cid,a.*,b.*,c.* FROM " . tablename("hyb_yl_collect") . " as a left join " . tablename("hyb_yl_zhuanjia") . " as b on a.goods_id= b.zid " . "left join " . tablename("hyb_yl_category") . "as c on b.z_room=c.id WHERE a.openid='{$openid}' and a.cerated_type=0 and b.uniacid!='' ORDER BY a.id DESC ");
        foreach ($myguan as & $value) {
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
        }
        return $this->result(0, "success", $myguan);
    }
    //关注我的
    public function doPageOrderguan() {
        global $_W, $_GPC;
        $zid = $_GPC['zid'];
        $uniacid = $_W['uniacid'];
        $guanzhu = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_collect") . " as a left join " . tablename("hyb_yl_zhuanjia") . " as b on a.goods_id= b.zid " . "left join " . tablename("hyb_yl_userinfo") . "as c on a.openid=c.openid WHERE a.uniacid = '{$uniacid}' and a.goods_id = '{$zid}' and a.cerated_type=0 and a.ifqianyue=2");
        return $this->result(0, 'success', $guanzhu);
    }
    //关注我的
    public function doPageOrderguanqianyu() {
        global $_W, $_GPC;
        $zid = $_GPC['zid'];
        $uniacid = $_W['uniacid'];
        $guanzhu = pdo_fetchall("SELECT a.openid as aopenid,a.*,b.*,c.* FROM".tablename("hyb_yl_collect")."as a left join".tablename("hyb_yl_userinfo")."as b on b.openid=a.openid left join".tablename("hyb_yl_myinfors")."as c on c.openid=b.openid where a.uniacid='{$uniacid}' and a.goods_id='{$zid}' and a.ifqianyue=2  order by a.id desc");

        return $this->result(0, 'success', $guanzhu);
    }    
//签约
    public function doPageOrderguanfenzu() {
        global $_W, $_GPC;
        $zid = $_GPC['zid'];
        $uniacid = $_W['uniacid'];
        $guanzhu = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_collect")."as a left join".tablename("hyb_yl_userinfo")."as b on b.openid=a.openid left join".tablename("hyb_yl_myinfors")."as c on c.openid=b.openid where a.uniacid='{$uniacid}' and a.goods_id='{$zid}' and a.ifqianyue=2 order by a.id desc");
        
        return $this->result(0, 'success', $guanzhu);
    }
    //问题的金额设置
    public function doPageQuestiommm() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);
        $openid = $_GPC['openid'];
        $seunseinfo = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . "WHERE zid='{$id}' and uniacid='{$uniacid}'", array("uniacid" => $uniacid));
        $z_tw_money = $_GPC['z_tw_money'];
        if (pdo_fieldexists('hyb_yl_zhuanjia', 'z_tw_money')) {
            $u_phone = pdo_getcolumn('hyb_yl_zhuanjia', array('openid' => $seunseinfo['openid']), 'z_tw_money');
            $datas = array('z_tw_money' => $z_tw_money);
            $getupdate = pdo_update("hyb_yl_zhuanjia", $datas, array('openid' => $seunseinfo['openid'], 'uniacid' => $uniacid));
        }
        //$pdo_debug = pdo_debug($getupdate);
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $getupdate);
    }
    public function doPageZjinfo() {
        global $_W, $_GPC;
        //$openid =$_REQUEST['openid'];
        $id = intval($_REQUEST['id']);
        $uniacid = $_W['uniacid'];
        $seunseinfo = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_zhuanjia') . "as a left join" . tablename('hyb_yl_category') . " as b on a.z_room = b.id WHERE a.uniacid = '{$uniacid}' and a.zid='{$id}' ");
        $seunseinfo['z_thumb'] = unserialize($seunseinfo['z_thumb']);
        $seunseinfo['z_thumbsback']=$seunseinfo['z_thumbs'];
        $seunseinfo['z_thumbs']=$_W['attachurl'].$seunseinfo['z_thumbs'];
        $seunseinfo['zgzimgurl1back']=$_W['attachurl'].$seunseinfo['zgzimgurl1back'];
        $seunseinfo['zgzimgurl2back']=$_W['attachurl'].$seunseinfo['zgzimgurl2back'];
        $seunseinfo['zczimgurlback']=$_W['attachurl'].$seunseinfo['zczimgurlback'];
        $seunseinfo['sfzimgurl1back']=$_W['attachurl'].$seunseinfo['sfzimgurl1back'];
        $seunseinfo['sfzimgurl2back']=$_W['attachurl'].$seunseinfo['sfzimgurl2back'];
        $seunseinfo['gzzimgurlback']=$_W['attachurl'].$seunseinfo['gzzimgurlback'];

        $count = count($seunseinfo['z_thumb']);
        for ($i = 0;$i < $count;$i++) {
            $seunseinfo['z_thumb'][$i] = $_W['attachurl'] . $seunseinfo['z_thumb'][$i];
        }
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $seunseinfo);
    }
    //查询详情体检报告
    public function doPageInformage() {
        global $_W, $_GPC;
        //$openid =$_REQUEST['openid'];
        $id = intval($_REQUEST['id']);
        $uniacid = $_W['uniacid'];
        $seunseinfo = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_tijianbaogao") . "WHERE t_id='{$id}' and uniacid='{$uniacid}'", array("uniacid" => $uniacid));
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $seunseinfo);
    }
    public function doPageInformyjy() {
        global $_W, $_GPC;
        //$openid =$_REQUEST['openid'];
        $id = intval($_REQUEST['id']);
        $uniacid = $_W['uniacid'];
        $seunseinfo = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_jianybaogao") . "WHERE j_id='{$id}' and uniacid='{$uniacid}'");
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $seunseinfo);
    }
    //查询我的病例库图片
    public function doPageSelcetmbingimg() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $us_openid = $_GPC['us_openid'];
        $selimg = pdo_fetchall("SELECT `i_img` FROM" . tablename('hyb_yl_upload_img') . "WHERE i_openid = '{$us_openid}'and uniacid ='{$uniacid}' and i_type=0 ", array("uniacid" => $uniacid));
        foreach ($selimg as $key => $link) {
            foreach ($link as $key1 => $val) {
                $arr = $val . ";";
                echo $arr;
            }
        }
    }
    //img
    public function doPageSelcetwzximg() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $us_openid = $_GPC['us_openid'];
        $i_doctor = $_GPC['i_doctor'];
        $selimg = pdo_fetchall("SELECT `i_img` FROM" . tablename('hyb_yl_upload_img') . "WHERE i_openid = '{$us_openid}'and uniacid ='{$uniacid}' and i_type=1 and i_doctor = '{$i_doctor}' ORDER BY i_time desc LIMIT 6 ", array("uniacid" => $uniacid));
        foreach ($selimg as $key => $link) {
            foreach ($link as $key1 => $val) {
                $arr = $val . ";";
                echo $arr;
            }
        }
    }
    //病例库
    public function doPageBingliku() {
        global $_W, $_GPC;

        $uniacid = $_W['uniacid'];
     
        $us_openid = $_GPC['us_openid'];
        $thumb = $_REQUEST['thumb'];
        $idarr = htmlspecialchars_decode($thumb);
        $is = str_replace('"]', "", $idarr);
        $id2 = str_replace('["', "", $is);
        $id3 = str_replace('""', "", $id2);
        $arr = explode(",", $id3);
        $arr1 = str_replace('"', '', $arr);
        $selectbl = pdo_fetch("SELECT * FROM" . tablename('hyb_yl_bingzheng') . "WHERE us_openid = '{$us_openid}'and uniacid ='{$uniacid}' ", array("uniacid" => $_W['uniacid']));
        $data['uniacid'] = $_W['uniacid'];
        $data['keshi'] = $_GPC['keshi'];
        $data['us_openid'] = $_GPC['us_openid'];
        $data['time'] = $_GPC['time'];
        $data['title_content'] = $_GPC['title_content'];
        $data['us_jhospital'] = $_GPC['us_jhospital'];
        $data['us_name'] = $_GPC['us_name'];
        $data['us_xhospital'] = $_GPC['us_xhospital'];
        $data['us_yibao'] = $_GPC['us_yibao'];
        $data['phone'] = $_GPC['phone'];
        $data['sex'] = $_GPC['sex'];
        $data['age'] = $_GPC['age'];
        $data['doctorn'] = $_GPC['doctorn'];
        $data['thumb'] = serialize($arr1);
        $data['uptime'] = date('Y-m-d H:i:s', time());



        $res = pdo_insert('hyb_yl_bingzheng', $data);
        if ($res) {
            $del = pdo_delete("hyb_yl_upload_img", array("i_openid" => $us_openid, "i_type" => 0));
        }
        return $this->result(0, 'success', $res);
    }
    //专家审核确认
    public function doPageZhuanjsh() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        //var_dump($openid);
        $resarr = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_zhuanjia') . " WHERE uniacid = '{$uniacid}' and openid = '{$openid}'", array(":uniacid" => $uniacid));
        return $this->result(0, 'success', $resarr);
    }
    //多图片上传
    public function doPageMsg_send_imgs() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];
        $i_type = $_GPC['i_type'];
        $zid = $_GPC['zid'];
        $logo_path = 'images/hyb_yl/';
        $uplogo_path = ATTACHMENT_ROOT . $logo_path;
        if (!is_dir($uplogo_path)) {
            $res = mkdir($uplogo_path, 0777, true);
        }
        $img_file_name = $_FILES['file']['name'];
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uplogo_path . $img_file_name)) {
            $restult = true;
        } else {
            $restult = false;
        }
        $webimgurl = $logo_path . $img_file_name;
        //echo $webimgurl;          //输出每一张图片存储到服务器的链接
        $imgs = $webimgurl;
        echo $imgs;
        $data = array("uniacid" => $uniacid, "i_openid" => $openid, "i_img" => $imgs, "i_type" => $i_type, 'i_doctor' => $zid);
        $res = pdo_insert("hyb_yl_upload_img", $data);
    }
    //科室预约
    public function doPageKeshiyuyue() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $ky_time_1 = $_REQUEST['ky_time_1'];
        // $ky_time_2 = $_REQUEST['ky_time_2'];
        // $ky_time = implode(" ",array($ky_time_1,$ky_time_2));
        $kname = $_REQUEST['ky_sex'];
        $openid = $_REQUEST['ky_openid'];
        $id = $_REQUEST['ky_zhenzhuang'];
        $rnd = rand(1000, time());
        $k_name = $_REQUEST['k_name'];
        $data = array('uniacid' => $_W['uniacid'], 'ky_name' => $_REQUEST['ky_name'], 'ky_openid' => $_REQUEST['ky_openid'], 'ky_sex' => $kname, 'k_name' => $_REQUEST['k_name'], 'ky_zhenzhuang' => $id, 'ky_telphone' => $_REQUEST['ky_telphone'], 'ky_time' => $ky_time_1, 'ky_doctor' => $_GPC['ky_doctor'], 'ky_docmoney' => $_GPC['ky_docmoney'], 'ky_yibao' => $rnd,);
        //var_dump($data);
        $res = pdo_insert('hyb_yl_keshi_yuyue', $data);
        if ($res) {
            $resarr = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_email') . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
            //var_dump($resarr);
            $smtpemailto = $resarr['mailhostname']; //'';//发送给谁
            $mailtitle = "理赔订单提醒通知：客户 " . $_REQUEST['ky_name'] . " 手机号：" . $_REQUEST['ky_telphone']; //邮件主题
            $mailcontent = "订单详情：客户 <b>" . $_REQUEST['ky_name'] . "</b>， 手机号：" . $_REQUEST['ky_telphone'] . " 预约了 <b>" . $_REQUEST['k_name'] . "</b> 科室，预约时间：<b>" . $ky_time_1 . "</b> 预约专家：<b>" . $_REQUEST['ky_doctor']; //
            //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
            require_once ("../framework/library/phpmailer/class.phpmailer.php");
            require_once ("../framework/library/phpmailer/class.smtp.php");
            //实例化PHPMailer核心类
            $mail = new PHPMailer();
            //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
            //$mail->SMTPDebug = 2;
            //使用smtp鉴权方式发送邮件
            $mail->isSMTP();
            //smtp需要鉴权 这个必须是true
            $mail->SMTPAuth = true;
            //链接qq域名邮箱的服务器地址
            $mail->Host = $resarr['mailhost'];
            //设置使用ssl加密方式登录鉴权
            $mail->SMTPSecure = 'ssl';
            //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
            $mail->Port = $resarr['mailport'];
            $mail->CharSet = 'UTF-8';
            //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
            $mail->FromName = $resarr['mailformname'];
            //smtp登录的账号 这里填入字符串格式的qq号即可
            $mail->Username = $resarr['mailusername'];
            //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
            $mail->Password = $resarr['mailpassword'];
            //SMTP服务器的验证密码 'jvpfoeokxomufgji';//'drtzejqwbdomegbc';//jvpfoeokxomufgji
            //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
            $mail->From = $resarr['mailsend']; //$redis->get('email:send_email');//SMTP服务器的用户邮箱
            //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
            $mail->isHTML(true);
            //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
            $arr_mailto = explode(',', $smtpemailto);
            foreach ($arr_mailto as $v_mailto) {
                $mail->addAddress($v_mailto, '预约通知');
            }
            //添加该邮件的主题
            $mail->Subject = $mailtitle;
            //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
            $mail->Body = $mailcontent;
            $flag = $mail->send();
            if ($flag) {
                $post->error = 0;
                $post->msg = "邮件发送成功！";
                return $this->result(0, 'success', $post);
            } else {
                $post->error = 1;
                $post->msg = "邮件发送失败！请检查邮箱填写是否有误。";
                return $this->result(1, 'error', $post);
            }
            return $this->result(0, 'success');
        } else {
            return $this->result(1, 'error');
        }
        // return $this->result(0, 'success', $getupdate);
        
    }
    public function doPageZixunthumb() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $baseInfo = pdo_fetch("SELECT zx_thumb,show_title FROM " . tablename('hyb_yl_bace') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        $baseInfo['zx_thumb'] = unserialize($baseInfo['zx_thumb']);
        $num = count($baseInfo['zx_thumb']);
        for ($i = 0;$i < $num;$i++) {
            $baseInfo['zx_thumb'][$i] = $_W['attachurl'] . $baseInfo['zx_thumb'][$i];
        }
        $baseInfo['yy_thumb'] = $_W['attachurl'] . $baseInfo['yy_thumb'];
        return $this->result(0, 'success', $baseInfo);
    }
    public function doPageZixuntype() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zixuntype = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun_type") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        foreach ($zixuntype as & $value) {
            $value['zx_thumb'] = $_W['attachurl'] . $value['zx_thumb'];
        }
        return $this->result(0, "success", $zixuntype);
    }
    public function doPageScurl() {
        global $_W;
        $Url = $_W['attachurl'];
        return $this->result(0, "success", $Url);
    }
    //推荐资讯
    public function doPageZixun() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zixun = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun") . " where uniacid = '{$uniacid}' and status = 1 and iflouc =0 order by sord", array(":uniacid" => $uniacid));
        foreach ($zixun as & $value) {
            $value['content_thumb'] = unserialize($value['content_thumb']);
            $value['thumb'] = $_W['attachurl'] . $value['thumb'];
            $value['time'] = date("Y-m-d", $value['time']);
            $num = count($value['content_thumb']);
            $value['content'] = strip_tags(htmlspecialchars_decode($value['content']));
            for ($i = 0;$i < $num;$i++) {
                $value['content_thumb'][$i] = $_W['attachurl'] . $value['content_thumb'][$i];
            }
        }
        return $this->result(0, "success", $zixun);
    }
    public function doPageZixuner() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zixun = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun") . " where uniacid = '{$uniacid}' and status = 1 and iflouc !=0 order by sord", array(":uniacid" => $uniacid));
        foreach ($zixun as & $value) {
            $value['content_thumb'] = unserialize($value['content_thumb']);
            $value['time'] = date("Y-m-d", $value['time']);
            $num = count($value['content_thumb']);
            $value['content'] = strip_tags(htmlspecialchars_decode($value['content']));
            for ($i = 0;$i < $num;$i++) {
                $value['content_thumb'][$i] = $_W['attachurl'] . $value['content_thumb'][$i];
            }
        }
        return $this->result(0, "success", $zixun);
    }
    //所有资讯
    public function doPageZixunall() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['zx_id']);
        if ($id == 'undefined' || $id == '') {
            $zixun = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun") . " where uniacid = '{$uniacid}' order by sord", array(":uniacid" => $uniacid));
        } else {
            $zixun = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun") . " where uniacid = '{$uniacid}' and zx_names = '{$id}' order by sord", array(":uniacid" => $uniacid));
        }
        foreach ($zixun as $key=> $value) {

            $zixun[$key]['content_thumb'] = unserialize($zixun[$key]['content_thumb']);
            $num = count($zixun[$key]['content_thumb']);

            for ($i=0; $i <$num ; $i++) { 
               $zixun[$key]['content_thumb'][$i]=$_W['attachurl'].$zixun[$key]['content_thumb'][$i];
            }
            $zixun[$key]['thumb'] = $_W['attachurl'] . $zixun[$key]['thumb'];
            $zixun[$key]['content'] = strip_tags(htmlspecialchars_decode($zixun[$key]['content']));
            $zixun[$key]['time'] = date("Y-m-d", $zixun[$key]['time']);
        }
        return $this->result(0, "success", $zixun);
    }
    //全部资讯
    public function doPageZixunallarray() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['zx_id']);
        $zixun = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun") . " where uniacid = '{$uniacid}' ", array(":uniacid" => $uniacid));
        foreach ($zixun as $key=> $value) {
            $zixun[$key]['content_thumb'] = unserialize($zixun[$key]['content_thumb']);
            $num = count($zixun[$key]['content_thumb']);

            for ($i=0; $i <$num ; $i++) { 
               $zixun[$key]['content_thumb'][$i]=$_W['attachurl'].$zixun[$key]['content_thumb'][$i];
            }
            $zixun[$key]['thumb'] = $_W['attachurl'] . $zixun[$key]['thumb'];
            $zixun[$key]['content'] = strip_tags(htmlspecialchars_decode($zixun[$key]['content']));
            $zixun[$key]['time'] = date("Y-m-d", $zixun[$key]['time']);
        }
        return $this->result(0, "success", $zixun);
    }
    public function doPageZixunyi() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['zx_id']);
        $zixun = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun") . " where uniacid = '{$uniacid}' and zx_names = '{$id}'", array(":uniacid" => $uniacid));
        foreach ($zixun as & $value) {
            $value['content_thumb'] = unserialize($value['content_thumb']);
            $value['thumb'] = $_W['attachurl'] . $value['thumb'];
            $value['time'] = date("Y-m-d", $value['time']);
            $value['content'] = strip_tags(htmlspecialchars_decode($value['content']));
        }
        return $this->result(0, "success", $zixun);
    }
    //首页指定id资讯
    //患者案例
    public function doPageHzal() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zixun = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_huanzhe") . " where uniacid=:uniacid and hz_type=1 and iflouc =0 order by sord", array(":uniacid" => $uniacid));
        foreach ($zixun as & $value) {
            $value['hz_thumb'] = $_W['attachurl'] . $value['hz_thumb'];
            //$value['hz_time'] = date("Y-m-d",$value['hz_time']);
            
        }
        return $this->result(0, "success", $zixun);
    }
    public function doPageHzaler() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zixun = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_huanzhe") . " where uniacid=:uniacid and hz_type=0 and iflouc =1 order by sord ", array(":uniacid" => $uniacid));

        // var_dump("SELECT * FROM " . tablename("hyb_yl_huanzhe") . " where uniacid=:uniacid and hz_type=1 and iflouc =1 order by sord ", array(":uniacid" => $uniacid));
        foreach ($zixun as & $value) {
            if(!empty($value['hz_thumb'])){
              $value['hz_thumb'] = $_W['attachurl'] . $value['hz_thumb'];
            }
           
            //$value['hz_time'] = date("Y-m-d",$value['hz_time']);
            
        }
        return $this->result(0, "success", $zixun);
    }
    //患者详情
    public function doPageHzxq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['hz_id']);
        $datas = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_huanzhe") . "WHERE hz_id='{$id}' and uniacid ='{$uniacid}'", array(":uniacid" => $uniacid));
        if ($datas['kiguan'] == 1) {
            $datas['hz_mp3'] = $datas['aliaut'];
        } else {
            $datas['hz_mp3'] = $_W['attachurl'] . $datas['hz_mp3'];
        }
        $datas['hz_thumb'] = $_W['attachurl'] . $datas['hz_thumb'];
        return $this->result(0, 'success', $datas);
    }
    public function doPageZixunxiangqing() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['id']);
        $zixunxq = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zixun") . " where id=:id and uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
        $zixunxq['content_thumb'] = $_W['attachurl'] . $zixunxq['content_thumb'];
        $zixunxq['time'] = date('Y-m-d', $zixunxq['time']);
        return $this->result(0, "success", $zixunxq);
    }
    public function doPageZixundolist() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zx_id = intval($_REQUEST['zx_id']);
        $zixunlist = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zixun") . " where zx_names=:zx_names and uniacid=:uniacid", array(":zx_names" => $zx_id, ":uniacid" => $uniacid));
        foreach ($zixunlist as & $value) {
            $value['thumb'] = $_W['attachurl'] . $value['thumb'];
            $value['time'] = date('Y-m-d', $value['time']);
        }
        return $this->result(0, "success", $zixunlist);
    }
    public function doPageDisease() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        // $keyword = $_REQUEST['keyword'];
        // if (!empty($keyword)) {
        //  $disease = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_bingzheng")." where uniacid=:uniacid and title like '%$keyword%' or title_content like '%$keyword%' ",array(":uniacid"=>$uniacid));
        //  foreach ($disease as &$value) {
        //    $value['thumb'] = $_W['attachurl'].$value["thumb"];
        //    $value['time'] = date('Y-m-d ',$value['time']);
        //  }
        // }
        // else
        // {
        $disease = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_bingzheng") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        foreach ($disease as & $value) {
            $value['thumb'] = $_W['attachurl'] . $value["thumb"];
            $value['time'] = date('Y-m-d ', $value['time']);
        }
        //}
        return $this->result(0, "success", $disease);
    }
    public function doPageDiseasexiangqing() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $diseasexiangqing = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_bingzheng") . " as bj left join " . tablename("hyb_yl_bingzheng_type") . " as bt on bj.jibing=bt.t_id where bj.uniacid=:uniacid and bj.id=:id", array(":uniacid" => $uniacid, ":id" => $id));
        return $this->result(0, "success", $diseasexiangqing);
    }
    public function doPageDisease_type() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $disease_type = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_bingzheng_type") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        return $this->result(0, "success", $disease_type);
    }
    public function doPageDisease_typexiangqing() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['t_id'];
        $keyword = $_REQUEST['keyword'];
        //var_dump($keyword);
        $diseasexiangqing = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_bingzheng") . " as bj left join " . tablename("hyb_yl_bingzheng_type") . " as bt on bj.jibing=bt.t_id where bj.uniacid=:uniacid and bt.type=:type or bj.title like '%$keyword%' ", array(":uniacid" => $uniacid, ":type" => $keyword));
        //var_dump($diseasexiangqing);
        return $this->result(0, "success", $diseasexiangqing);
    }
    public function doPagejbzx() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $data = array('uniacid' => $_W['uniacid'], 'wt_content' => $_REQUEST['wt_content'], 'wt_sex' => $_REQUEST['wt_sex'], 'wt_age' => $_REQUEST['wt_age'], 'wt_time' => time(), "wt_name" => $_REQUEST['wt_name'], "wt_hf_zhuanjia" => $_REQUEST['wt_hf_zhuanjia'], "wt_thumb" => $_REQUEST['wt_thumb'], "wt_telphone" => $_REQUEST['wt_telphone'], "openid" => $_REQUEST['openid'], "wt_hf_type" => "未回复", "wt_money" => $_REQUEST['z_tw_money'],);
        $res = pdo_insert('hyb_yl_jbzx', $data);
        $item = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " where uniacid=:uniacid and z_name=:z_name", array(":uniacid" => $uniacid, ":z_name" => $_REQUEST['wt_hf_zhuanjia']));
        if (empty($item['z_tw_money'])) {
            $data = array("uniacid" => $uniacid, "z_tw_money" => $_REQUEST['z_tw_money']);
            pdo_update("hyb_yl_zhuanjia", $data, array("zid" => $item['id']));
        } else {
            $z_tw_money = $item['z_tw_money'] + $_REQUEST['z_tw_money'];
            $data = array("uniacid" => $uniacid, "z_tw_money" => $z_tw_money);
            pdo_update("hyb_yl_zhuanjia", $data, array("zid" => $item['id']));
        }
    }
    public function doPageTijian_taocan_type() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tijian_taocan_type = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_tijian_taocan_type") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        //var_dump($tijian_taocan_type);
        foreach ($tijian_taocan_type as & $value) {
            $value['type_thumb'] = $_W['attachurl'] . $value['type_thumb'];
        }
        return $this->result(0, "success", $tijian_taocan_type);
    }
    public function doPageTijian_taocan_typexq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tjt_id = $_REQUEST['tjt_id'];
        $tijian_taocan_typexq = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_tijian_taocan_type") . " as ttt left join " . tablename("hyb_yl_tijian_taocan") . " as tt on ttt.tjt_id=tt.tt_type where ttt.uniacid=:uniacid and ttt.tjt_id=:tjt_id", array(":uniacid" => $uniacid, ":tjt_id" => $tjt_id));
        //var_dump($tijian_taocan_typexq);
        return $this->result(0, "success", $tijian_taocan_typexq);
    }
    public function doPageTijian_taocan_typexqs() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tjt_id = $_REQUEST['tjt_id'];
        $tijian_taocan_typexqs = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_tijian_taocan_type') . " AS ttt LEFT JOIN " . tablename("hyb_yl_tijian_taocan") . " AS tc ON ttt.tjt_id = tc.tt_type LEFT JOIN " . tablename("hyb_yl_tijian_taocan_xiangmu") . " AS tm ON tc.tt_id = tm.tm_taocanname LEFT JOIN " . tablename("hyb_yl_tijian_yiyuan") . " AS ty ON tc.tt_yiyuan = ty.ty_id WHERE ttt.uniacid = :uniacid AND ttt.tjt_id = :tjt_id ", array(":uniacid" => $uniacid, ":tjt_id" => $tjt_id));
        return $this->result(0, "success", $tijian_taocan_typexqs);
    }
    public function doPageTijian_taocan_yiyuanlist() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tjt_id = $_REQUEST['tjt_id'];
        $tijian_taocan_yiyuanlist = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_tijian_taocan_type') . " AS ttt LEFT JOIN " . tablename("hyb_yl_tijian_taocan") . " AS tc ON ttt.tjt_id = tc.tt_type LEFT JOIN " . tablename("hyb_yl_tijian_yiyuan") . " AS ty ON tc.tt_yiyuan = ty.ty_id WHERE ttt.uniacid = :uniacid AND ttt.tjt_id = :tjt_id", array(":uniacid" => $uniacid, ":tjt_id" => $tjt_id));
        //var_dump($tijian_taocan_yiyuanlist);
        return $this->result(0, "success", $tijian_taocan_yiyuanlist);
    }
    public function doPageTijian_yiyuan() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tijian_yiyuan = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_tijian_yiyuan") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        foreach ($tijian_yiyuan as & $value) {
            $value['ty_thumb'] = $_W['attachurl'] . $value['ty_thumb'];
        }
        return $this->result(0, "success", $tijian_yiyuan);
    }
    public function doPageTijian_yiyuanxq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $ty_id = $_REQUEST['ty_id'];
        $tijian_yiyuanxq = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_tijian_yiyuan") . " where uniacid=:uniacid and ty_id=:ty_id", array(":uniacid" => $uniacid, ":ty_id" => $ty_id));
        $tijian_yiyuanxq['ty_thumb'] = $_W['attachurl'] . $tijian_yiyuanxq['ty_thumb'];
        return $this->result(0, "success", $tijian_yiyuanxq);
    }
    public function doPageTijian_yiyuantaocanlist() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $ty_id = $_REQUEST['ty_id'];
        $tijian_yiyuantaocanlist = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_tijian_taocan") . " as tt left join " . tablename("hyb_yl_tijian_yiyuan") . " as ty on tt.tt_yiyuan=ty.ty_id where tt.uniacid=:uniacid and ty.ty_id=:ty_id", array(":uniacid" => $uniacid, ":ty_id" => $ty_id));
        return $this->result(0, "success", $tijian_yiyuantaocanlist);
    }
    public function doPageTijian_yiyuantaocan() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tt_id = $_REQUEST['tt_id'];
        $tijian_yiyuantaocan = pdo_fetch("SELECT tt_tongzhi,tt_money,tt_id FROM " . tablename("hyb_yl_tijian_taocan") . " where uniacid=:uniacid and tt_id=:tt_id", array(":uniacid" => $uniacid, ":tt_id" => $tt_id));
        return $this->result(0, "success", $tijian_yiyuantaocan);
    }
    public function doPageTijian_yiyuantaocanxq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tt_id = $_REQUEST['tt_id'];
        $tijian_yiyuantaocanxq = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_tijian_taocan_xiangmu") . " as tx left join " . tablename("hyb_yl_tijian_taocan") . " as tt on tx.tm_taocanname=tt.tt_id where tx.uniacid=:uniacid and tt.tt_id=:tt_id", array(":uniacid" => $uniacid, "tt_id" => $tt_id));
        return $this->result(0, "success", $tijian_yiyuantaocanxq);
    }
    public function doPageTijian_yuyue() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $tt_id = $_REQUEST['tt_id'];
        $ty_id = $_REQUEST['ty_id'];
        $tijian_yuyue = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_tijian_taocan") . " as tc left join " . tablename("hyb_yl_tijian_yiyuan") . " as ty on tc.tt_yiyuan=ty.ty_id where tc.uniacid=:uniacid and tc.tt_id=:tt_id and ty.ty_id=:ty_id", array(":uniacid" => $uniacid, ":tt_id" => $tt_id, ":ty_id" => $ty_id));
        return $this->result(0, "success", $tijian_yuyue);
    }
    public function doPageTijian_yuyues() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $ky_time_1 = $_REQUEST['ky_time_1'];
        $ky_time_2 = $_REQUEST['ky_time_2'];
        $ky_time = implode(" ", array($ky_time_1, $ky_time_2));
        $data = array('uniacid' => $uniacid, 'tjyy_tcname' => $_REQUEST['tt_name'], 'tjyy_yyname' => $_REQUEST['ty_name'], 'tjyy_tcnum' => $_REQUEST['tt_num'], 'tjyy_name' => $_REQUEST['tjyy_name'], 'tiyy_openid' => $_REQUEST['tiyy_openid'], 'tjyy_shenfenzheng' => $_REQUEST['tjyy_shenfenzheng'], 'tjyy_telphone' => $_REQUEST['tjyy_telphone'], 'tjyy_tcmoney' => $_REQUEST['tt_money'], 'tjyy_time' => $ky_time,);
        $res = pdo_insert('hyb_yl_tijian_yuyue', $data);
        if ($res) {
            $resarr = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_email') . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
            //var_dump($resarr);
            $smtpemailto = $resarr['mailhostname']; //'';//发送给谁
            $mailtitle = "预约提醒通知：客户 " . $_REQUEST['tjyy_name'] . " 手机号：" . $_REQUEST['tjyy_telphone'] . " 预约体检套餐：" . $_REQUEST['tjyy_tcname'] . "，预约时间：" . $ky_time . ",预约体检医院：" . $_REQUEST['tjyy_yyname']; //邮件主题
            $mailcontent = "预约详情：客户 <b>" . $_REQUEST['tjyy_name'] . "</b>， 手机号：" . $_REQUEST['tjyy_telphone'] . " 预约了 <b>" . $_REQUEST['tjyy_tcname'] . "</b> 套餐，预约时间：<b>" . $ky_time . "预约体检医院：" . $_REQUEST['tjyy_yyname']; //
            //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
            require_once ("api/phpmailer/class.phpmailer.php");
            require_once ("api/phpmailer/class.smtp.php");
            //实例化PHPMailer核心类
            $mail = new PHPMailer();
            //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
            //$mail->SMTPDebug = 2;
            //使用smtp鉴权方式发送邮件
            $mail->isSMTP();
            //smtp需要鉴权 这个必须是true
            $mail->SMTPAuth = true;
            //链接qq域名邮箱的服务器地址
            $mail->Host = $resarr['mailhost'];
            //设置使用ssl加密方式登录鉴权
            $mail->SMTPSecure = 'ssl';
            //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
            $mail->Port = $resarr['mailport'];
            //设置smtp的helo消息头 这个可有可无 内容任意
            // $mail->Helo = 'Hello smtp.qq.com Server';
            //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
            //$mail->Hostname = $resarr['mailhostname'];
            //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
            $mail->CharSet = 'UTF-8';
            //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
            $mail->FromName = $resarr['mailformname'];
            //smtp登录的账号 这里填入字符串格式的qq号即可
            $mail->Username = $resarr['mailusername'];
            //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
            $mail->Password = $resarr['mailpassword'];
            //SMTP服务器的验证密码 'jvpfoeokxomufgji';//'drtzejqwbdomegbc';//jvpfoeokxomufgji
            //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
            $mail->From = $resarr['mailsend']; //$redis->get('email:send_email');//SMTP服务器的用户邮箱
            //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
            $mail->isHTML(true);
            //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
            $arr_mailto = explode(',', $smtpemailto);
            foreach ($arr_mailto as $v_mailto) {
                $mail->addAddress($v_mailto, '预约通知');
            }
            //添加该邮件的主题
            $mail->Subject = $mailtitle;
            //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
            $mail->Body = $mailcontent;
            $flag = $mail->send();
            if ($flag) {
                $post->error = 0;
                $post->msg = "邮件发送成功！";
                return $this->result(0, 'success', $post);
            } else {
                $post->error = 1;
                $post->msg = "邮件发送失败！请检查邮箱填写是否有误。";
                return $this->result(1, 'error', $post);
            }
            return $this->result(0, 'success');
        } else {
            return $this->result(1, 'error');
        }
    }
    public function doPageZhuanjianzc() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $datas = array("uniacid" => $uniacid, "u_type" => $_REQUEST['currentTab'],);
        $userinfo = pdo_update("hyb_yl_userinfo", $datas, array("openid" => $openid));
        if ($_REQUEST['currentTab'] == 0) {
            $data = array("uniacid" => $uniacid, "openid" => $_REQUEST['openid'], "z_name" => $_REQUEST['z_name'], "z_sex" => $_REQUEST['z_sex'], "z_age" => $_REQUEST['z_age'], "z_shenfengzheng" => $_REQUEST['z_shenfengzheng'], "z_telephone" => $_REQUEST['z_telephone'], "z_yiyuan" => $_REQUEST['z_yiyuan'], "z_room" => $_REQUEST['z_room'], "z_zhicheng" => $_REQUEST['z_zhicheng'], "z_zhiwu" => $_REQUEST['z_zhiwu'], "z_zhenzhi" => $_REQUEST['z_zhenzhi'], "z_content" => $_REQUEST['z_content'], "z_thumb" => $_REQUEST['z_thumb'], "z_thumbs" => $_REQUEST['z_thumbs'],);
            $zhuanjianzc = pdo_insert("hyb_yl_zhuanjia", $data);
        }
        if ($_REQUEST['currentTab'] == 1) {
            $data = array("uniacid" => $uniacid, "openid" => $_REQUEST['openid'], "pt_name" => $_REQUEST['pt_name'], "pt_sex" => $_REQUEST['pt_sex'], "pt_age" => $_REQUEST['pt_age'], "pt_telphone" => $_REQUEST['pt_telphone'], "pt_shenfenzheng" => $_REQUEST['pt_shenfenzheng'], "pt_thumbs" => $_REQUEST['pt_thumbs'],);
            $putongzc = pdo_insert("hyb_yl_putong", $data);
        }
    }
    public function doPageZhuanjianzl() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $data = array("uniacid" => $uniacid, "z_name" => $_REQUEST['z_name'], "z_sex" => $_REQUEST['z_sex'], "z_age" => $_REQUEST['z_age'], "z_shenfengzheng" => $_REQUEST['z_shenfengzheng'], "z_telephone" => $_REQUEST['z_telephone'], "z_yiyuan" => $_REQUEST['z_yiyuan'], "z_room" => $_REQUEST['z_room'], "z_zhicheng" => $_REQUEST['z_zhicheng'], "z_zhiwu" => $_REQUEST['z_zhiwu'], "z_zhenzhi" => $_REQUEST['z_zhenzhi'], "z_content" => $_REQUEST['z_content'], "z_thumb" => $_REQUEST['z_thumb'], "z_thumbs" => $_REQUEST['z_thumbs'],);
        $res = pdo_update("hyb_yl_zhuanjia", $data, array("openid" => $openid));
    }
    public function doPagePutongzl() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $zl = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " as u left join " . tablename("hyb_yl_putong") . " as p on u.openid=p.openid where u.uniacid=:uniacid and u.openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
        return $this->result(0, "success", $zl);
    }
    public function doPageWtyhf() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $wt_hf_type = "已回复";
        $yhf = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_jbzx") . " as j left join " . tablename("hyb_yl_userinfo") . " as u on j.openid=u.openid WHERE j.uniacid=:uniacid and j.openid=:openid and j.wt_hf_type=:wt_hf_type", array(":uniacid" => $uniacid, ":openid" => $openid, ":wt_hf_type" => $wt_hf_type));
        foreach ($yhf as & $value) {
            $value['wt_time'] = date("Y-m-d H:i:s", $value['wt_time']);
        }
        return $this->result(0, "success", $yhf);
    }
    public function doPageWtwhf() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $wt_hf_type = "未回复";
        $whf = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_jbzx") . " as j left join " . tablename("hyb_yl_userinfo") . " as u on j.openid=u.openid WHERE j.uniacid=:uniacid and j.openid=:openid and j.wt_hf_type=:wt_hf_type", array(":uniacid" => $uniacid, ":openid" => $openid, ":wt_hf_type" => $wt_hf_type));
        foreach ($whf as & $value) {
            $value['wt_time'] = date("Y-m-d H:i:s", $value['wt_time']);
        }
        return $this->result(0, "success", $whf);
    }
    public function doPageWtxq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $jbwt_id = $_REQUEST['jbwt_id'];
        $wtxq = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_jbzx") . " WHERE uniacid=:uniacid AND jbwt_id=:jbwt_id", array(":uniacid" => $uniacid, ":jbwt_id" => $jbwt_id));
        $wtxq['wt_thumb'] = $_W['attachurl'] . $wtxq['wt_thumb'];
        $wtxq['wt_time'] = date("Y-m-d H:i:s", $wtxq['wt_time']);
        return $this->result(0, "sucess", $wtxq);
    }
    public function doPageWthf() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $jbwt_id = $_REQUEST['jbwt_id'];
        $wt_hf_type = "已回复";
        $data = array("uniacid" => $uniacid, "wt_hf_content" => $_REQUEST['wt_hf_content'], "wt_hf_type" => $wt_hf_type,);
        $res = pdo_update("hyb_yl_jbzx", $data, array("jbwt_id" => $jbwt_id));
    }
    public function doPageHzycz() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $ycz = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
    }
    public function doPageZjsf() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $data = array("uniacid" => $uniacid, "z_tw_money" => $_REQUEST['z_tw_money'], "z_zx_money" => $_REQUEST['z_zx_money'], "z_yy_money" => $_REQUEST['z_yy_money'],);
        $res = pdo_update("hyb_yl_zhuanjia", $data, array("zid" => $id));
    }
    public function doPagePay() {
        global $_GPC, $_W;
        include 'wxpay.php';
        $res = pdo_get('hyb_yl_parameter', array('uniacid' => $_W['uniacid']));
        $appid = $res['appid'];
        $openid = $_GPC['openid'];
        $mch_id = $res['mch_id'];
        $key = $res['appkey'];
        $out_trade_no = $mch_id . time();
        $total_fee = $_GPC['z_tw_money'];
        if (empty($total_fee)) {
            $body = '订单付款';
            $total_fee = floatval(99 * 100);
        } else {
            $body = '订单付款';
            $total_fee = floatval($total_fee * 100);
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
        $return = $weixinpay->pay();
        echo json_encode($return);
    }
    //课程支付
    public function doPageOrderpay() {
        global $_GPC, $_W;
        include 'wxpay.php';
        $res = pdo_get('hyb_yl_parameter', array('uniacid' => $_W['uniacid']));
        $appid = $res['appid'];
        $openid = $_GPC['s_openid'];
        $mch_id = $res['mch_id'];
        $key = $res['appkey'];
        $out_trade_no = $mch_id . time();
        $total_fee = $_GPC['s_ormoney'];
        if (empty($total_fee)) {
            $body = '订单付款';
            $total_fee = floatval(99 * 100);
        } else {
            $body = '订单付款';
            $total_fee = floatval($total_fee * 100);
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
        $return = $weixinpay->pay();
        echo json_encode($return);
    }
    //课程支付成功插入数据库
    public function doPageKcinsert() {
        global $_W, $_GPC;
        $s_order = str_shuffle(time() . rand(111111, 999999));
        $data['uniacid'] = $_W['uniacid'];
        $data['s_openid'] = $_GPC['s_openid'];
        $data['s_order'] = $s_order;
        $data['s_ormoney'] = $_GPC['s_ormoney'];
        $data['s_pid'] = $_GPC['s_pid'];
        $data['s_type'] = $_GPC['s_type'];
        $res = pdo_insert('hyb_yl_sorder', $data);
        $s_id = pdo_insertid();
        return $this->result(0, "sucess", $s_id);
    }
    //查询我的消费
    public function doPageMyvt() {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];
        //var_dump($openid);
        // $stvt = pdo_fetchcolumn("SELECT SUM(`s_ormoney`) FROM " .tablename('hyb_yl_sorder') . " WHERE `s_openid` ='{$openid}' and uniacid = '{$uniacid}'");
        $stvt = pdo_fetch("SELECT SUM(s_ormoney) AS `money` FROM " . tablename("hyb_yl_sorder") . " where `s_openid`='{$openid}'  and uniacid = '{$uniacid}'", array(":uniacid" => $uniacid));
        return $this->result(0, "sucess", $stvt);
    }
    public function doPageMyxfjl() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $question = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where `openid`='{$openid}' and uniacid = '{$uniacid}' ", array(":uniacid" => $uniacid));

        $question['adminguanbi']=date("Y-m-d H:i:s",$question['adminguanbi']);
        return $this->result(0, "sucess", $question);
    }
    public function doPageMyquestion() {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];
        $question = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_question') . "where user_openid='{$openid}' and uniacid='{$uniacid}' and usertype =0 and yuedu =1 order by qid desc", array("uniacid" => $uniacid));
        foreach ($question as & $value) {
            $value['user_picture'] = unserialize($value['user_picture']);
            $value['hd_question'] = unserialize($value['hd_question']);
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
            $qid = $value['qid'];
            $res = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_question') . "where uniacid ='{$uniacid}' and parentid='{$qid}'");
            $value['hd_question'] = $res['question'];
            $num = count($value['user_picture']);
            for ($i = 0;$i < $num;$i++) {
                $value['user_picture'][$i] = $_W['attachurl'] . $value['user_picture'][$i];
            }
        }
        return $this->result(0, "sucess", $question);
    }
    //消费总额
    public function doPageMyquestionsum() {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];
        $question = pdo_fetch("SELECT SUM(user_payment) AS `money` FROM " . tablename("hyb_yl_question") . " where `user_openid`='{$openid}'  and uniacid = '{$uniacid}'", array(":uniacid" => $uniacid));
        return $this->result(0, "sucess", $question);
    }
    //我的消费总额
    public function doPageMyxiaofeisum() {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];
        $question = pdo_fetch("SELECT SUM(user_payment) AS `money` FROM " . tablename("hyb_yl_question") . " where `user_openid`='{$openid}'  and uniacid = '{$uniacid}'", array(":uniacid" => $uniacid));
        $selectord = pdo_fetch("SELECT SUM(zy_money) AS `money` FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " where `zy_openid`='{$openid}'  and uniacid = '{$uniacid}'", array(":uniacid" => $uniacid));
        $res = pdo_fetch("SELECT SUM(s_ormoney) AS `money` FROM " . tablename("hyb_yl_sorder") . " where `s_openid`='{$openid}'  and uniacid = '{$uniacid}'", array(":uniacid" => $uniacid));
        $sum = $question['money'] + $selectord['money'] + $res['money'];
        return $this->result(0, "sucess", $sum);
    }
    public function doPageMywquestion() {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];
        $question = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_question') . "where user_openid='{$openid}' and uniacid='{$uniacid}' and usertype =0 and yuedu =0 order by qid desc", array("uniacid" => $uniacid));
        foreach ($question as & $value) {
            $value['user_picture'] = unserialize($value['user_picture']);
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
            $num = count($value['user_picture']);
            for ($i = 0;$i < $num;$i++) {
                $value['user_picture'][$i] = $_W['attachurl'] . $value['user_picture'][$i];
            }
        }
        return $this->result(0, "sucess", $question);
    }
    public function doPageMywyiquestion() {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $uniacid = $_W['uniacid'];
        $question = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_question') . "where user_openid='{$openid}' and uniacid='{$uniacid}' and usertype =0 and yuedu =1 order by qid desc", array("uniacid" => $uniacid));
        foreach ($question as & $value) {
            $value['user_picture'] = unserialize($value['user_picture']);
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
            $num = count($value['user_picture']);
            for ($i = 0;$i < $num;$i++) {
                $value['user_picture'][$i] = $_W['attachurl'] . $value['user_picture'][$i];
            }
        }
        return $this->result(0, "sucess", $question);
    }
    //查询是否付费
    public function doPageKcselect() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['s_pid'];
        $openid = $_GPC['s_openid'];
        $res = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_sorder") . "WHERE uniacid='{$uniacid}' and s_pid='{$id}' and `s_openid`= '{$openid}'", array(":uniacid" => $uniacid));
        return $this->result(0, "sucess", $res);
    }
    //专家患者
    public function doPageZjhzycz() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $z_name = $_REQUEST['z_name'];
        $type = "已出诊";
        $ycz = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " as zy left join " . tablename("hyb_yl_userinfo") . " as u on zy.zy_openid=u.openid where zy.uniacid=:uniacid and zy.zy_type=:zy_type and zy.z_name=:z_name", array(":uniacid" => $uniacid, ":zy_type" => $type, ":z_name" => $z_name));
        return $this->result(0, "success", $ycz);
    }
    public function doPageZjhzwcz() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $z_name = $_REQUEST['z_name'];
        $type = "未出诊";
        $wcz = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " as zy left join " . tablename("hyb_yl_userinfo") . " as u on zy.zy_openid=u.openid where zy.uniacid=:uniacid and zy.zy_type=:zy_type and zy.z_name=:z_name", array(":uniacid" => $uniacid, ":zy_type" => $type, ":z_name" => $z_name));
        return $this->result(0, "success", $wcz);
    }
    public function doPagePutj() {
        global $_W, $_GPC;
        $uniacid = $_W["uniacid"];
        $tiyy_openid = $_REQUEST['openid'];
        $putj = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_tijian_yuyue") . " as ty left join " . tablename("hyb_yl_tijian_yiyuan") . " as y on ty.tjyy_yyname=y.ty_name  where ty.uniacid=:uniacid and ty.tiyy_openid=:tiyy_openid", array(":uniacid" => $uniacid, ":tiyy_openid" => $tiyy_openid));
        foreach ($putj as & $value) {
            $value['ty_thumb'] = $_W['attachurl'] . $value['ty_thumb'];
        }
        return $this->result(0, "success", $putj);
    }
    public function doPagePutjs() {
        global $_W, $_GPC;
        $uniacid = $_W["uniacid"];
        $tjyy_id = $_REQUEST['tjyy_id'];
        $putj = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_tijian_yuyue") . " as ty left join " . tablename("hyb_yl_tijian_yiyuan") . " as y on ty.tjyy_yyname=y.ty_name  where ty.uniacid=:uniacid and ty.tjyy_id=:tjyy_id", array(":uniacid" => $uniacid, ":tjyy_id" => $tjyy_id));
        $putj['ty_thumb'] = $_W['attachurl'] . $putj['ty_thumb'];
        return $this->result(0, "success", $putj);
    }
    public function doPagePuksyy() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $puksyy = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_keshi_yuyue") . " where uniacid=:uniacid and ky_openid=:ky_openid", array(":uniacid" => $uniacid, ":ky_openid" => $openid));
        return $this->result(0, "success", $puksyy);
    }
    public function doPagePuzjyy() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $puzjyy = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyue") . " as zy left join " . tablename("hyb_yl_zhuanjia") . " as z on zy.z_name=z.z_name where zy.uniacid=:uniacid and zy.zy_openid=:zy_openid", array(":uniacid" => $uniacid, ":zy_openid" => $openid));
        foreach ($puzjyy as & $value) {
            $value['z_thumb'] = $_W['attachurl'] . $value['z_thumb'];
        }
        return $this->result(0, "success", $puzjyy);
    }
    public function doPagePutwwhf() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $wt_hf_type = "未回复";
        $openid = $_REQUEST['openid'];
        $whf = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_jbzx") . " where uniacid=:uniacid and openid=:openid and wt_hf_type=:wt_hf_type", array(":uniacid" => $uniacid, ":openid" => $openid, ":wt_hf_type" => $wt_hf_type));
        foreach ($whf as & $value) {
            $value['wt_time'] = date("Y-m-d H:i:s", $value['wt_time']);
        }
        return $this->result(0, "success", $whf);
    }
    public function doPagePutwyhf() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $wt_hf_type = "已回复";
        $openid = $_REQUEST['openid'];
        $yhf = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_jbzx") . " where uniacid=:uniacid and openid=:openid and wt_hf_type=:wt_hf_type", array(":uniacid" => $uniacid, ":openid" => $openid, ":wt_hf_type" => $wt_hf_type));
        foreach ($yhf as & $value) {
            $value['wt_time'] = date("Y-m-d H:i:s", $value['wt_time']);
        }
        return $this->result(0, "success", $yhf);
    }
    public function doPagePutwxq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $jbwt_id = $_REQUEST['jbwt_id'];
        $xq = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_jbzx") . " as jb left join " . tablename("hyb_yl_zhuanjia") . " as z on jb.wt_hf_zhuanjia=z.z_name where jb.uniacid=:uniacid and jb.jbwt_id=:jbwt_id", array(":uniacid" => $uniacid, ":jbwt_id" => $jbwt_id));
        $xq['wt_thumb'] = $_W['attachurl'] . $xq['wt_thumb'];
        $xq['z_thumb'] = $_W['attachurl'] . $xq['z_thumb'];
        $xq['wt_time'] = date("Y-m-d H:i:s", $xq['wt_time']);
        return $this->result(0, "success", $xq);
    }
    public function doPageZjzz() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //查询riqi1
        $time = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia_yuyuetime") . " where uniacid=:uniacid and openid=:openid order by riqi asc", array(":uniacid" => $uniacid, ":openid" => $openid));
        foreach ($time as & $value) {
            $value['time'] = explode(",", $value['time']);
        }
        return $this->result(0, "success", $time);
    }
    //查询患者预约的专家
    public function doPageSelectdoctororder() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $ky_zhenzhuang = $_REQUEST['id'];
        $time = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " as a left join " . tablename("hyb_yl_zhuanjia_yuyue") . " as b on b.zy_openid=a.openid left join" . tablename('hyb_yl_myinfors') . " as c on c.my_id = b.zy_name where b.z_name='{$ky_zhenzhuang}'and b.uniacid='{$uniacid}' order by b.zy_id desc");
        foreach ($time as & $value) {
            $value['zy_time'] = date("Y-m-d H:i:s", $value['zy_time']);
        }
        return $this->result(0, "success", $time);
    }
    public function doPageSelectdoctor1() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $ky_zhenzhuang = $_REQUEST['id'];
        $time = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " as a left join " . tablename("hyb_yl_zhuanjia_yuyue") . " as b on b.zy_openid=a.openid left join" . tablename('hyb_yl_myinfors') . " as c on c.my_id = b.zy_name where b.z_name='{$ky_zhenzhuang}'and b.uniacid='{$uniacid}' and b.zy_zhenzhuang=2 or b.zy_zhenzhuang=0 ");
        foreach ($time as & $value) {
            $value['zy_time'] = date("Y-m-d H:i:s", $value['zy_time']);
        }
        return $this->result(0, "success", $time);
    }
    public function doPageSelectdoctor2() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $ky_zhenzhuang = $_REQUEST['id'];
        $time = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " as a left join " . tablename("hyb_yl_zhuanjia_yuyue") . " as b on b.zy_openid=a.openid left join" . tablename('hyb_yl_myinfors') . " as c on c.my_id = b.zy_name where b.z_name='{$ky_zhenzhuang}'and b.uniacid='{$uniacid}' and b.zy_zhenzhuang=1 ");
        foreach ($time as & $value) {
            $value['zy_time'] = date("Y-m-d H:i:s", $value['zy_time']);
        }
        return $this->result(0, "success", $time);
    }
    //专家坐诊时间
    public function doPageDozhuantime() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $arrs = $_REQUEST['arrs'];
        $pp_id = $_REQUEST['pp_id'];
        $arr = json_decode($arrs, true);
        foreach ($arr as $key => $link) {
            $insert[] = array('d_id' => $link["d_id"], 'date' => $link["date"], 'day' => $link["day"], 'startTime' => $link['startTime'] . '-' . $link["endTime"], 'tijiatime' => date('Y-m-d H:i:s'), 'openid' => $openid, 'pp_id' => $pp_id, 'uniacid' => $uniacid,);
        }
        $insert = array_reverse($insert);
        foreach ($insert as $key => $value) {
            if ($value['d_id'] !== '') {
                $query = pdo_update('hyb_yl_dozhuantime', $value, array('d_id' => $value['d_id'], 'uniacid' => $uniacid));
            } else {
                $intval = pdo_insert('hyb_yl_dozhuantime', $value);
            }
        }
        return $this->result(0, "success", $intval);
        
    }
    //z专家排版时间
    public function doPageZhuanpaib() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pp_id = $_REQUEST['pp_id'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_dozhuantime') . "WHERE `pp_id`='{$pp_id}' and uniacid = '{$uniacid}' ORDER BY CAST(`sort_id` AS DECIMAL)", array('uniacid' => $uniacid));
        return $this->result(0, "success", $pdoselect);
    }
    //专家详情排版时间
    public function doPageZhuanpaibid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $pp_id = $_REQUEST['pp_id'];
        $date = $_REQUEST['date'];
        $day = $_REQUEST['day'];
        //var_dump($date,$pp_id,$openid,$uniacid);
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_dozhuantime') . "WHERE `pp_id`='{$pp_id}' and uniacid = '{$uniacid}'and day = '{$day}' and date = '{$date}' ", array('uniacid' => $uniacid));
        foreach ($pdoselect as & $value) {
            $arr[] = $value['startTime'];
        }
        $pdoselect['startTime'] = $arr;
        return $this->result(0, "success", $pdoselect);
    }
    public function doPageDozhuantimeselect() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_dozhuantime') . "WHERE uniacid = '{$uniacid}' and openid = '{$openid}' ", array('uniacid' => $uniacid));
        return $this->result(0, "success", $pdoselect);
    }
    //完善个人信息
    public function doPageMyinfors() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $my_id = $_REQUEST['my_id'];
        $data = array('uniacid' => $_W['uniacid'], 'openid' => $_REQUEST['openid'], 'myage' => $_REQUEST['age'], 'mysex' => $_REQUEST['gender'], 'mycontent' => $_REQUEST['miaoshu'], 'myphone' => $_REQUEST['tel'], 'myname' => $_REQUEST['user'], 'myyibao' => $_REQUEST['yibao'], 'myshengfen' => $_REQUEST['idcad']);
        if ($my_id !== '') {
            $pdoselect = pdo_update('hyb_yl_myinfors', $data, array('uniacid' => $uniacid, 'my_id' => $my_id));
        } else {
            $pdoselect = pdo_insert('hyb_yl_myinfors', $data, array('uniacid' => $uniacid));
        }
        return $this->result(0, "success", $pdoselect);
    }
    //查询个人资料
    public function doPageMyinforsarray() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $pdoselect = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_myinfors') . " as a left join".tablename("hyb_yl_userinfo")."as b on b.openid=a.openid WHERE a.uniacid = '{$uniacid}' and a.openid = '{$openid}' ", array('uniacid' => $uniacid));
        return $this->result(0, "success", $pdoselect);
    }
    //专家预约之后插入数据库hyb_yl_zhuanjia_yuyue
    public function doPageMyzhuanjiayy() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        //$uniacid = $_REQUEST['uniacid'];
        $openid = $_REQUEST['zy_openid'];

        $rnd = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $data = array('uniacid' => $uniacid, 'zy_money' => $_REQUEST['zy_money'], 'zy_openid' => $_REQUEST['zy_openid'], 'z_name' => $_REQUEST['z_name'], 'zy_name' => $_REQUEST['zy_name'], 'zy_type' => $_REQUEST['zy_type'], 'zy_riqi' => $_REQUEST['zy_riqi'], 'zy_time' => strtotime("now"), 'zy_telephone' => $rnd, 'ksname' => $_GPC['ksname'], 'states' => $_GPC['states'], 'remove' => $_GPC['remove'], 'paystate' => $_GPC['paystate']);
        $pdoselect = pdo_insert('hyb_yl_zhuanjia_yuyue', $data, array('uniacid' => $uniacid));
        return $this->result(0, "success", $pdoselect);
    }
    //查询我是否预约
    public function doPageMyshifouyy() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        // $uniacid = $_REQUEST['uniacid'];
        $openid = $_REQUEST['zy_openid'];
        $zy_riqi = $_REQUEST['zy_riqi']; //星期
        $zy_type = $_REQUEST['zy_type']; //专家坐诊时间
        $pdoselect = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_zhuanjia_yuyue') . "WHERE uniacid = '{$uniacid}' and zy_openid = '{$openid}' and zy_riqi='{$zy_riqi}' and zy_type='{$zy_type}'", array('uniacid' => $uniacid));
        return $this->result(0, "success", $pdoselect);
    }
    //
    //查询科室一级分类
    public function doPageCategoryf1() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_addresshospitai') . "WHERE uniacid = '{$uniacid}' and parentid = 0 ", array('uniacid' => $uniacid));
        foreach ($pdoselect as & $value) {
            $value['icon'] = $_W['attachurl'] . $value['icon'];
        }
        return $this->result(0, "success", $pdoselect);
    }
    //查询科室一级分类
    public function doPageCategoryself() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_selfhelp') . "WHERE uniacid = '{$uniacid}' and parentid = 0 ", array('uniacid' => $uniacid));
        foreach ($pdoselect as & $value) {
            $value['icon'] = $_W['attachurl'] . $value['icon'];
        }
        return $this->result(0, "success", $pdoselect);
    }
    public function doPageCategoryselffl2() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_selfhelp') . "WHERE uniacid = '{$uniacid}' and parentid = '{$id}' ", array('uniacid' => $uniacid));
        foreach ($pdoselect as & $value) {
            $value['icon'] = $_W['attachurl'] . $value['icon'];
        }
        return $this->result(0, "success", $pdoselect);
    }
    public function doPageCategoryfl2() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_addresshospitai') . "WHERE uniacid = '{$uniacid}' and parentid = '{$id}' ", array('uniacid' => $uniacid));
        foreach ($pdoselect as & $value) {
            $value['icon'] = $_W['attachurl'] . $value['icon'];
        }
        return $this->result(0, "success", $pdoselect);
    }
    //查询科室专家
    public function doPageKszhuanjia() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_zhuanjia') . "as a left join" . tablename('hyb_yl_category') . " as b on a.z_room = b.id WHERE a.uniacid = '{$uniacid}' and a.z_room = '{$id}' ");
        foreach ($pdoselect as & $value) {
            $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
        }
        return $this->result(0, "success", $pdoselect);
    }
    public function doPageHospatil() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_tijian_yiyuan') . "WHERE uniacid = '{$uniacid}'", array('uniacid' => $uniacid));
        foreach ($pdoselect as & $value) {
            $value['ty_thumb'] = $_W['attachurl'] . $value['ty_thumb'];
        }
        return $this->result(0, "success", $pdoselect);
    }

    public function doPageHospatillianmeng() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_addresshospitai') . "WHERE uniacid = '{$uniacid}' and hos_tuijian=1 order by tijiaotime desc", array('uniacid' => $uniacid));
        foreach ($pdoselect as $key=> $value) {
            $pdoselect[$key]['hos_pic'] = $_W['attachurl'] . $pdoselect[$key]['hos_pic'];
            
             $test= strip_tags(htmlspecialchars_decode($pdoselect[$key]['hos_desc']));
            $pdoselect[$key]['hos_desc']=preg_replace('/^(&nbsp;|\s)*|(&nbsp;|\s)*$/', '', $test);  
            
        }
        return $this->result(0, "success", $pdoselect);
    }

    public function doPageHospatillianmengall() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_addresshospitai') . "WHERE uniacid = '{$uniacid}' and parentid=0 order by tijiaotime desc", array('uniacid' => $uniacid));
        foreach ($pdoselect as $key=> $value) {
            $pdoselect[$key]['hos_thumb'] = $_W['attachurl'] . $pdoselect[$key]['hos_thumb'];
            
             $test= strip_tags(htmlspecialchars_decode($pdoselect[$key]['hos_desc']));
            $pdoselect[$key]['hos_desc']=preg_replace('/^(&nbsp;|\s)*|(&nbsp;|\s)*$/', '', $test);  
            
        }
        return $this->result(0, "success", $pdoselect);
    }

    public function doPageHospatiltj() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_tijian_yiyuan') . "WHERE uniacid = '{$uniacid}' and ifzz=1", array('uniacid' => $uniacid));
        foreach ($pdoselect as & $value) {
            $value['ty_thumb'] = $_W['attachurl'] . $value['ty_thumb'];
        }
        return $this->result(0, "success", $pdoselect);
    }
    //地图
    public function doPageHospatilmap() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $ty_id = $_REQUEST['id'];
        $pdoselect = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_tijian_yiyuan') . "WHERE uniacid = '{$uniacid}' and  ty_id='{$ty_id}' ", array('uniacid' => $uniacid));
        return $this->result(0, "success", $pdoselect);
    }
    //视频列表
    public function doPageVideoxianglist() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $room_parentid = $_REQUEST['id'];
        $pdoselect = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_schoolroom') . "WHERE uniacid = '{$uniacid}' and  room_parentid='{$room_parentid}' order by sord", array('uniacid' => $uniacid));
        $res = pdo_fetch('SELECT * from' . tablename('hyb_yl_schoolroom') . "where uniacid='{$uniacid}' and id ='{$room_parentid}'");
        foreach ($pdoselect as & $value) {
            if ($value['kaiguan'] == 0) {
                if ($value['spkg'] == 0) {
                    $value['room_video'] = $_W['attachurl'] . $value['room_video'];
                } else {
                    $value['room_video'] = $value['al_video'];
                }
            } else {
                if ($value['ypkg'] == 0) {
                    $value['mp3'] = $_W['attachurl'] . $value['mp3'];
                } else {
                    $value['mp3'] = $value['mp3m'];
                }
            }
            $value['room_teacher'] = $res['room_teacher'];
        }
        return $this->result(0, "success", $pdoselect);
    }
    //订单号查询用户ID
    public function doPageSaveinfouserid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $room_parentid = $_REQUEST['ky_yibao'];
    }
    public function doPageBiaoti1() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pdoselect = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_button_daohang') . "WHERE uniacid = '{$uniacid}' ", array('uniacid' => $uniacid));
        $pdoselect['fw_title'] = unserialize($pdoselect['fw_title']);
        $pdoselect['fw_title2'] = unserialize($pdoselect['fw_title2']);
        $pdoselect['fw_thumb'] = unserialize($pdoselect['fw_thumb']);
        return $this->result(0, "success", $pdoselect);
    }
    public function doPageMyinforphone() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $pdoselect = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_userinfo') . "WHERE uniacid = '{$uniacid}' and openid ='{$openid}' ", array('uniacid' => $uniacid));
        return $this->result(0, "success", $pdoselect);
    }
    public function doPageDelzjyy() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zy_id = $_GPC['zy_id'];
        $data = pdo_update('hyb_yl_zhuanjia_yuyue', array('zy_zhenzhuang' => 2), array('zy_id' => $zy_id, 'uniacid' => $uniacid));
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $data);
    }
    //是否核销
    public function doPageSelecthxstate() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zy_id = $_GPC['zy_id'];
        $res = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_zhuanjia_yuyue') . "where uniacid ='{$uniacid}' and zy_id='{$zy_id}'");
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPagePerson() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        //$res =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_schoolroom')."where uniacid ='{$uniacid}' and id='{$id}'");
        $res = pdo_getcolumn('hyb_yl_schoolroom', array('id' => $id, 'uniacid' => $uniacid), 'room_liulan');
        $data = array('room_liulan' => $res + 1);
        $pdo = pdo_update('hyb_yl_schoolroom', $data, array('id' => $id));
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $pdo);
    }
    public function doPageParentid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $res = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_category') . "where uniacid ='{$uniacid}' and id='{$id}'");
        $parentid = $res['parentid'];
        $word = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_category') . "where uniacid ='{$uniacid}' and id='{$parentid}'");
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $word);
    }
    public function doPageIfcunz() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['zid'];
        $res = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_zhuanjia') . "where uniacid ='{$uniacid}' and zid='{$zid}'");
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageMymoneysite() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_zhuanjia') . "where uniacid ='{$uniacid}' and openid='{$openid}'");
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageBlxiangq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $res = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_bingzheng") . " as bj left join " . tablename("hyb_yl_bingzheng_type") . " as bt on bj.jibing=bt.t_id left join" . tablename('hyb_yl_userinfo') . "as cp on bj.us_openid=cp.openid where bj.uniacid=:uniacid and bj.id=:id", array(":id" => $id, ":uniacid" => $uniacid));
        $res['thumb'] = unserialize($res['thumb']);
        $num = count($res['thumb']);
        for ($i = 0;$i < $num;$i++) {
            $res['thumb'][$i] = $_W['attachurl'] . $res['thumb'][$i];
        }
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageDelorder() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zy_id = $_GPC['zy_id'];
        $res = pdo_delete('hyb_yl_zhuanjia_yuyue', array('zy_id' => $zy_id, 'uniacid' => $uniacid));
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageUpdatetype() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zy_id = $_GPC['zy_id'];
        $data = array('zy_zhenzhuang' => 1);
        $res = pdo_update('hyb_yl_zhuanjia_yuyue', $data, array('zy_id' => $zy_id, 'uniacid' => $uniacid));
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageUpdatetype3() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zy_id = $_GPC['zy_id'];
        $data = array('states' => 3);
        $res = pdo_update('hyb_yl_zhuanjia_yuyue', $data, array('zy_id' => $zy_id, 'uniacid' => $uniacid));
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageAlltjself() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_selfhelp') . "where uniacid ='{$uniacid}' and enabled =1 and parentid =0");
        foreach ($res as & $value) {
            $value['icon'] = $_W['attachurl'] . $value['icon'];
        }
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageAlltjs() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_selfhelp') . "where uniacid ='{$uniacid}' and parentid !=0");
        foreach ($res as & $value) {
            $value['icon'] = $_W['attachurl'] . $value['icon'];
        }
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageSeflinfo() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $res = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_selfhelp') . "where uniacid ='{$uniacid}' and id ='{$id}'");
        $zids = explode(',', $res['zids']);
        foreach ($zids as & $value) {
            $doc[] = pdo_fetch('SELECT `zid`,`z_thumbs`,`z_yiyuan`,`z_zhicheng`,`z_zhenzhi`,`z_name` FROM' . tablename('hyb_yl_zhuanjia') . "where uniacid='{$uniacid}' and zid='{$value}'");
        }
        $res['zids'] = $doc;
        if($res['zids']){
            foreach ($res['zids'] as & $val) {
                if($val['z_thumbs']){
                 $val['z_thumbs'] = $_W['attachurl'] . $val['z_thumbs'];
                }
            } 
        }
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageAddhistory() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $pid = $_GPC['pid'];
        $openid = $_GPC['openid'];
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = str_shuffle($str);
        $number = substr($str, 0, 3);
        $num = rand(1000, 9999);
        $bianhao = $number . "-" . $num;
        $user = pdo_get('hyb_yl_selfnotes', array('openid' => $openid, 'pid' => $pid));
        if (empty($user)) {
            $data = array('uniacid' => $uniacid, 'pid' => $pid, 'openid' => $openid, 'time' => date('Y-m-d H:i:s', time()), 'number' => $bianhao);
            $res = pdo_insert('hyb_yl_selfnotes', $data);
            $message = '返回消息';
            $errno = 0;
        } else {
            echo "2";
        }
        return $this->result($errno, $message, $user);
    }
    public function doPageGetallhis() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_selfnotes') . "as a left join " . tablename('hyb_yl_selfhelp') . " as b on b.id = a.pid  where a.uniacid ='{$uniacid}' and a.openid ='{$openid}'");
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageDelnotes() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $sl_id = $_GPC['sl_id'];
        $res = pdo_delete('hyb_yl_selfnotes', array('sl_id' => $sl_id, 'uniacid' => $uniacid));
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageDelallnotes() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_delete('hyb_yl_selfnotes', array('openid' => $openid, 'uniacid' => $uniacid));
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    //保存聊天数据

    private function https_curl_json($url, $data, $type) {
        if ($type == 'json') {
            $headers = array("Content-type: application/json;charset=UTF-8", "Accept: application/json", "Cache-Control: no-cache", "Pragma: no-cache");
            $data = json_encode($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl); //捕抓异常
            
        }
        curl_close($curl);
        return $output;
    }
    public function doPageSeldocuid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $docopenid = $_GPC['docopenid'];
        $res = pdo_get('hyb_yl_userinfo', array('uniacid' => $uniacid, 'openid' => $docopenid));
        return $this->result(0, "success", $res);
    }
    public function doPageSelmycuid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_get('hyb_yl_userinfo', array('uniacid' => $uniacid, 'openid' => $openid));
        return $this->result(0, "success", $res);
    }
    public function doPageReadMsg() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $f_id = $_REQUEST['fid'];
        $ifkf = $_GPC['ifkf'];
        //var_dump($f_id);onMvv0JR5x5pCKCyDBEsrImStobk
        $t_id = $_REQUEST['tid'];
        $openid = $_REQUEST['openid'];
        //查询用户信息
        $user_curr = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
        if ($user_curr['u_id'] == $t_id) {
            $f_id = $_REQUEST['tid'];
            $t_id = $_REQUEST['fid'];

        }
        $data = array('r_state' => 1);
        $res = pdo_update("hyb_yl_chat_msg", $data, array("f_id" => $t_id, 't_id' => $f_id));
        $list = pdo_fetchall("SELECT a.*,b.z_thumbs,b.zid FROM " . tablename("hyb_yl_chat_msg") . "as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid=a.kfid where a.uniacid=:uniacid and ((a.f_id=:f_id and a.t_id=:t_id) or (a.f_id=:ft_id and a.t_id=:tf_id))  ORDER BY a.m_id ASC ", array(":uniacid" => $uniacid, ":f_id" => $f_id, ":t_id" => $t_id, ":ft_id" => $t_id, ":tf_id" => $f_id));
        foreach ($list as $key => $msg) {
            $typetext =$msg['typetext'];
            $msg['t_msg'] = $msg['t_msg'];
            $list[$key]['time'] = date("Y-m-d H:i:s", $msg['add_time']);
            $tmpStr = json_encode($msg['t_msg']); //暴露出unicode
            $tmpStr1 = preg_replace_callback('/\\\\\\\\/i', function ($a) {
                return '\\';
            }, $tmpStr); //将两条斜杠变成一条，其他不动
            $t_msg1 = json_decode($tmpStr1);
            $t_msg = str_replace('"', '', $t_msg1);
            if ($ifkf == $msg['ifkf'] ) {
                $list[$key]['is_show_right'] = 1;
                $list[$key]['is_img'] = false;
                $list[$key]['show_rignt'] = true;
                $list[$key]['content'] = $t_msg;
                if($typetext == 2){
                  $list[$key]['content'] = $_W['attachurl'].$list[$key]['content'];
                }
                 if($typetext == 1){
                  $list[$key]['content'] = $_W['attachurl'].$list[$key]['content'];
                }
                $list[$key]['z_thumbs'] = $_W['attachurl'].$list[$key]['z_thumbs'];
                //查询用户信息
                $user = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and u_id=:u_id", array(":uniacid" => $uniacid, ":u_id" => $f_id));
                $list[$key]['head_owner'] = $user['u_thumb'];
                $list[$key]['nickname_owner'] = $user['u_name'];
                } else {
                $list[$key]['is_show_right'] = 0;
                $list[$key]['is_img'] = false;
                $list[$key]['show_rignt'] = false;
                $list[$key]['content'] = $t_msg;
                if($typetext == 2){
                  $list[$key]['content'] = $_W['attachurl'].$list[$key]['content'];
                }
                 if($typetext == 1){
                  $list[$key]['content'] = $_W['attachurl'].$list[$key]['content'];
                }
                $list[$key]['z_thumbs'] = $_W['attachurl'].$list[$key]['z_thumbs'];
                //查询用户信息
                $user = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and u_id=:u_id", array(":uniacid" => $uniacid, ":u_id" => $t_id));
                $list[$key]['head_owner'] = $user['u_thumb'];
                $list[$key]['nickname_owner'] = $user['u_name'];
            }
        }
        $result = array('chat_list' => $list);
        return $this->result(0, "success", $result);
    }
    // 获取用户formid
    public function doPageUserFormId() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $data['form_id'] = $_REQUEST['form_id'];
        $data['form_time'] = time();
        $openid = $_REQUEST['openid'];
        $member = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_userinfo') . " where uniacid=:uniacid and openid = :openid", array(":openid" => $openid, ":uniacid" => $uniacid));
        if ($member['form_id'] == '') {
            $arr = array();
        } else {
            $arr = unserialize($member['form_id']);
            foreach ($arr as $k => $v) {
                $form_time = $v['form_time'];
                $out_time = strtotime('-7 days', time());
                if ($out_time >= $form_time) {
                    unset($arr[$k]);
                }
            }
        }
        array_push($arr, $data);
        $new_arr = serialize($arr);
        $ret = pdo_update('hyb_yl_userinfo', array('form_id' => $new_arr), array('u_id' => $member['u_id'], 'uniacid' => $uniacid));
        return $this->result(0, 'success', $ret);
    }
    //好友列表
    public function doPageHaoyouList() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //和我对话的列表
        $chat_list = pdo_fetchall("select a.*,c.nksname  from(select max(m_id) as m_id from". tablename('hyb_yl_chat_msg') ."where ifkf!=3 and f_id='{$openid}' group by docid ) b left join ".tablename('hyb_yl_chat_msg')." a on a.m_id=b.m_id  left join".tablename("hyb_yl_zhuanjia")."as c on c.zid=a.docid ");

        foreach ($chat_list as $key => $chat_msg) {
            $t_id = $chat_msg['t_id'];
            $f_id = $chat_msg['f_id'];
            $ext = strtolower(strrchr($chat_list[$key]['t_msg'], '.'));
            $ret = false;
            if ($ext == '.mp3')
            {  // MP3
              $chat_list[$key]['t_msg'] ='[语音]';
            }
            if ($ext == '.jpg' || $ext == '.png' || $ext == '.jpeg')
            {  // MP3
              $chat_list[$key]['t_msg'] ='[图片]';
            }
            $t_id1 = $value['t_id']; //别人发给我的
            $m_id = $value['m_id'];
            $chat_list[$key]['add_time'] = date("Y-m-d H:i:s", $chat_list[$key]['add_time']);
            $unread_count = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("hyb_yl_chat_msg") . " where uniacid='{$uniacid}' and t_id='{$t_id1}' and f_id='{$f_id}' and m_id ='{$m_id}' and r_state = 2");
            $chat_list[$key]['unread'] = $unread_count;
             
          }
         return $this->result(0, "success", $chat_list);
    }

    public function doPageSaveChatMsg(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $u_id = $_GPC['u_id'];
        $openid = $_REQUEST['openid'];
        $huihua=$_GPC['huihua'];
        if($huihua ==2){
          $f_name = $_GPC['nickName'];  
          $t_name = $_GPC['f_name']; 
          $t_id = $_GPC['tid'];
          $f_id  = $_GPC['fid'];
        }else{
          $f_name = $_GPC['f_name'];  
          $t_name = $_GPC['nickName']; 
          $t_id = $_REQUEST['tid']; 
          $f_id = $_REQUEST['fid'];
        }
        $data_arr = $_GPC['data_arr'];
        $typetext =$_GPC['typetext'];
        $ifkf =$_GPC['ifkf'];
        $kfid =$_GPC['kfid'];
        //查询用户信息
        if ($user_curr['u_id'] == $t_id) {
            $f_id = $_REQUEST['tid'];
            $t_id = $_REQUEST['fid'];
        }
        if($typetext ==0){
          $t_msg = $_REQUEST['t_msg'];
          $tmpStr = json_encode($t_msg); //暴露出unicode
          $tmpStr1 = preg_replace_callback("#(\\\ue[0-9a-f]{3})#i", function ($a) {
            return addslashes($a[1]);
         }, $tmpStr);
          $t_msg1 = json_decode($tmpStr1);
          $textinfo =  str_replace('"', '', $t_msg1);

        }
        if($typetext ==1){
          $t_msg = $data_arr;
          $tmpStr = json_encode($t_msg); //暴露出unicode
          $tmpStr1 = preg_replace_callback("#(\\\ue[0-9a-f]{3})#i", function ($a) {
            return addslashes($a[1]);
         }, $tmpStr);
          $t_msg1 = json_decode($tmpStr1);
          $t_msg2 = str_replace('"', '', $t_msg1);

        }
        if($typetext ==2){
          $t_msgtext = $_REQUEST['t_msg'];
          $tmpStrtext = json_encode($t_msgtext); //暴露出unicode
          $tmpStr1text = preg_replace_callback("#(\\\ue[0-9a-f]{3})#i", function ($a) {
            return addslashes($a[1]);
         }, $tmpStrtext);
          $t_msg1text = json_decode($tmpStr1text);
          $textinfo =  str_replace('"', '', $t_msg1text);

          $t_msg = $data_arr;
          $tmpStr = json_encode($t_msg); //暴露出unicode
          $tmpStr1 = preg_replace_callback("#(\\\ue[0-9a-f]{3})#i", function ($a) {
            return addslashes($a[1]);
         }, $tmpStr);
          $t_msg1 = json_decode($tmpStr1);
          $t_msg2 = str_replace('"', '', $t_msg1);

        }

        $f_user = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and u_id=:u_id", array(":uniacid" => $uniacid, ":u_id" => $u_id));
        $t_user = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and u_id=:u_id", array(":uniacid" => $uniacid, ":u_id" => $u_id));
        $data = array('uniacid' => $uniacid, 'f_id' => $f_id, 'f_name' => $f_name, 'f_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
        't_id' => $t_id, 't_name' => $t_name, 't_msg' => $textinfo, 'r_state' => 2, //状态:1为已读,2为未读,默认为2
        'add_time' => time(), 'docid' => $_GPC['docid'], 'is_img' => $_GPC['is_img'], 'touxiang' => $_GPC['touxiang'],'typetext'=>$typetext,'ifkf'=>$ifkf,'kfid'=>$kfid);

        $data1 = array('uniacid' => $uniacid, 'f_id' => $f_id, 'f_name' => $f_name, 'f_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
        't_id' => $t_id, 't_name' => $t_name, 't_msg' => $t_msg2, 'r_state' => 2, //状态:1为已读,2为未读,默认为2
        'add_time' => time(), 'docid' => $_GPC['docid'], 'is_img' => $_GPC['is_img'], 'touxiang' => $_GPC['touxiang'],'typetext'=>$typetext,'ifkf'=>$ifkf,'kfid'=>$kfid);

        $data2 = array('uniacid' => $uniacid, 'f_id' => $f_id, 'f_name' => $f_name, 'f_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
        't_id' => $t_id, 't_name' => $t_name, 't_msg' => $textinfo, 'r_state' => 2, //状态:1为已读,2为未读,默认为2
        'add_time' => time(), 'docid' => $_GPC['docid'], 'is_img' => $_GPC['is_img'], 'touxiang' => $_GPC['touxiang'],'typetext'=>0,'ifkf'=>$ifkf,'kfid'=>$kfid);
         
        $data3 = array('uniacid' => $uniacid, 'f_id' => $f_id, 'f_name' =>$f_name, 'f_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
        't_id' => $t_id, 't_name' => $t_name, 't_msg' => $_GPC['t_msg'], 'r_state' => 2, //状态:1为已读,2为未读,默认为2
        'add_time' => time(), 'docid' => $_GPC['docid'], 'is_img' => $_GPC['is_img'], 'touxiang' => $_GPC['touxiang'],'typetext'=>3,'ifkf'=>$ifkf,'kfid'=>$kfid);

        if($typetext ==0){
         //添加text
          $res = pdo_insert("hyb_yl_chat_msg", $data);  

        }
        if($typetext ==1){
         //添加图片
          $res = pdo_insert("hyb_yl_chat_msg", $data1);  

        }
        if($typetext ==2){
             pdo_insert("hyb_yl_chat_msg", $data2);
             pdo_insert("hyb_yl_chat_msg", $data1);

        }
        if($typetext ==3){

             pdo_insert("hyb_yl_chat_msg", $data3);

        }
        $m_id = pdo_insertid();
        $ifstate = pdo_get('hyb_yl_chat_msg', array('uniacid' => $uniacid, 'm_id' => $m_id));
        $r_state = $ifstate['r_state'];
        $docid = $ifstate['docid'];
        $timess = date("Y-m-d H:i:s", $ifstate['add_time']);
        $tmpStr = json_encode($ifstate['t_msg']); //暴露出unicode
        $tmpStr1 = preg_replace_callback('/\\\\\\\\/i', function ($a) {
            return '\\';
        }, $tmpStr); //将两条斜杠变成一条，其他不动
        $t_msg = json_decode($tmpStr1);


        if ($r_state == 2 ) {
            $wxappaid = pdo_get('hyb_yl_parameter', array('uniacid' => $uniacid));
            $wxapptemp = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid));
            $appid = $wxappaid['appid'];
            $appsecret = $wxappaid['appsecret'];
            $template_id = $wxapptemp['doctemp'];
            $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $getArr = array();
            $tokenArr = json_decode($this->send_post($tokenUrl, $getArr, "GET"));
            $access_token = $tokenArr->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
            //5.查询当前医生formid
            $zhiban = pdo_fetch("SELECT * FROM".tablename("hyb_yl_zhuanjia")."where uniacid='{$uniacid}' and z_shenfengzheng=1 limit 1");   
        if($zhiban && $huihua==2){
            $user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $zhiban['openid']));
                $zid =$_GPC['docid'];
                foreach ($user_curr as $key => $value) {
                    $out_time = strtotime('-7 days', time());
                    $formids = unserialize($value['form_id']);
                    foreach ($formids as $k => $v) {
                        if ($out_time >= $v['form_time']) {
                            unset($formids[$k]);
                        }
                    }
                    $formids = array_values($formids);
                    $form_id = $formids[0]['form_id'];
                    $dd['form_id'] = $form_id;
                    $dd['touser'] = $value['openid'];
                    $content = array("keyword1" => array("value" => $_GPC['f_name'], "color" => "#4a4a4a"), "keyword2" => array("value" => $timess, "color" => ""), "keyword3" => array("value" =>'有一条最新客服消息', "color" => ""),);
                    $dd['template_id'] = $template_id;
                    $dd['page'] = 'hyb_yl/tabBar/kefuduihua/kefuduihua'; //跳转医生id 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
                    $dd['data'] = $content; //模板内容，不填则下发空模板
                    $dd['color'] = ''; //模板内容字体的颜色，不填默认黑色
                    $dd['emphasis_keyword'] = ''; //模板需要放大的关键词，不填则默认无放大
                    $result1 = $this->https_curl_json($url, $dd, 'json');
                    foreach ($formids as $k => $v) {
                        if ($form_id == $v['form_id']) {
                            unset($formids[$k]);
                        }
                    }
                    // var_dump($result1);
                    $new_formids = array_values($formids);
                    $datas['form_id'] = serialize($new_formids);
                    $update = pdo_update('hyb_yl_userinfo', $datas, array('u_id' => $value['u_id']));
                    //var_dump($update);
                }
           }
           if($_GPC['ifkf'] ==0){
            $user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $t_id));
           }

           if($_GPC['ifkf'] ==1){
            
            $user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $f_id));
           }
            
           if($_GPC['ifkf'] ==3){
          
            $user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $t_id));
           }
            // var_dump($member);
           if($_GPC['ifkf'] !==1){
            foreach ($user_curr as $key => $value) {
                $out_time = strtotime('-7 days', time());
                $formids = unserialize($value['form_id']);
                foreach ($formids as $k => $v) {
                    if ($out_time >= $v['form_time']) {
                        unset($formids[$k]);
                    }
                }
                $formids = array_values($formids);
                $form_id = $formids[0]['form_id'];
                $dd['form_id'] = $form_id;
                $dd['touser'] = $value['openid'];
                $content = array("keyword1" => array("value" => $_GPC['f_name'], "color" => "#4a4a4a"), "keyword2" => array("value" => $timess, "color" => ""), "keyword3" => array("value" => '有一条最新消息', "color" => ""),);
                $dd['template_id'] = $template_id;
                if($_GPC['ifkf'] ==3){
                  $dd['page'] = 'hyb_yl/mysubpages/pages/guanzhuwode/guanzhuwode'; 
                }
                if($_GPC['ifkf'] ==0){
                  $dd['page'] = 'hyb_yl/backstageFollowUp/pages/explanation/explanation?zid='.$zid; 
                }
                $dd['data'] = $content; //模板内容，不填则下发空模板
                $dd['color'] = ''; //模板内容字体的颜色，不填默认黑色
                $dd['emphasis_keyword'] = ''; //模板需要放大的关键词，不填则默认无放大
                $result1 = $this->https_curl_json($url, $dd, 'json');
                foreach ($formids as $k => $v) {
                    if ($form_id == $v['form_id']) {
                        unset($formids[$k]);
                    }
                }
                // var_dump($result1);
                $new_formids = array_values($formids);
                $datas['form_id'] = serialize($new_formids);
                pdo_update('hyb_yl_userinfo', $datas, array('u_id' => $value['u_id']));
              }

           }

        }

           return $this->result(0, "success", $t_msg);

    }
    public function doPageKfuList() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $chat_list = pdo_fetchall("select a.*,c.zid,c.z_thumbs  from(select max(m_id) as m_id from". tablename('hyb_yl_chat_msg') ." group by docid) b left join ".tablename('hyb_yl_chat_msg')." a on a.m_id=b.m_id left join".tablename("hyb_yl_zhuanjia")."as c on c.zid=a.kfid ");

        foreach ($chat_list as $key => $chat_msg) {
   
            $chat_list[$key]['z_thumbs']=$_W['attachurl'].$chat_list[$key]['z_thumbs'];
            $chat_list[$key]['add_time'] = date("Y-m-d H:i:s", $chat_list[$key]['add_time']);
            $ext = strtolower(strrchr($chat_list[$key]['t_msg'], '.'));
            $ret = false;
            if ($ext == '.mp3')
            {  // MP3
              $chat_list[$key]['t_msg'] ='[语音]';
            }
            if ($ext == '.jpg' || $ext == '.png' || $ext == '.jpeg')
            {  // MP3
              $chat_list[$key]['t_msg'] ='[图片]';
            }

        }
        return $this->result(0, "success", $chat_list);
    }
    public function doPageHaoyouListwei() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $if_over = !empty($_GPC['if_over']) ? $_GPC['if_over'] : '0';
        //和我对话的列表
        $chat_list = pdo_fetchall("select a.*,c.u_thumb  from(select max(m_id) as m_id from". tablename('hyb_yl_chat_msg') ."where ifkf=0 and t_id='{$openid}' and if_over ='{$if_over}' group by f_id ) b left join ".tablename('hyb_yl_chat_msg')." a on a.m_id=b.m_id  left join".tablename("hyb_yl_userinfo")."as c on c.openid=a.f_id ");

        foreach ($chat_list as $key => $chat_msg) {
            $t_id = $chat_msg['t_id'];
            $f_id = $chat_msg['f_id'];

            $ext = strtolower(strrchr($chat_list[$key]['t_msg'], '.'));
            $ret = false;
            if ($ext == '.mp3')
            {  // MP3
              $chat_list[$key]['t_msg'] ='[语音]';
            }
            if ($ext == '.jpg' || $ext == '.png' || $ext == '.jpeg')
            {  // MP3
              $chat_list[$key]['t_msg'] ='[图片]';
            }
            $chat_list[$key]['add_time'] = date("Y-m-d H:i:s", $chat_list[$key]['add_time']);
            $unread_count = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("hyb_yl_chat_msg") . " where uniacid='{$uniacid}' and t_id='{$t_id}' and f_id='{$f_id}'  and r_state = 2");
            $chat_list[$key]['unread'] = $unread_count;
             
          }
          return $this->result(0, "success", $chat_list);
    }
    public function doPageDelmygz() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $res = pdo_delete('hyb_yl_collect', array('uniacid' => $uniacid, 'id' => $id));
        return $this->result(0, "success", $res);
    }
    public function doPageHzuid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_get('hyb_yl_userinfo', array('uniacid' => $uniacid, 'openid' => $openid), array('u_id'));
        return $this->result(0, "success", $res);
    }
    public function doPageMybkstate() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $fid = $_GPC['fid'];
        $tid = $_GPC['tid'];
        $bk_id = $_GPC['bk_id'];
        if (empty($bk_id)) {
            $res = pdo_get('hyb_yl_bkchat', array('uniacid' => $uniacid, 'fid' => $fid, 'tid' => $tid));
            $Mc = pdo_get('hyb_yl_bace', array('uniacid' => $uniacid), array('fwtim'));
            if (empty($res)) {
                $data = array('uniacid' => $uniacid, 'fid' => $fid, 'tid' => $tid, 'bkstate' => 0, 'countime' => $Mc['fwtim'], 'ttimes' => date("Y-m-d", TIMESTAMP) //当前时间
                );
                pdo_insert('hyb_yl_bkchat', $data);
                $bk_id = pdo_insertid();
                $res = pdo_get('hyb_yl_bkchat', array('uniacid' => $uniacid, 'bk_id' => $bk_id), array('bkstate', 'bk_id'));
            }
        } else {
            $data = array('bkstate' => 1);
            $res = pdo_update('hyb_yl_bkchat', $data, array('uniacid' => $uniacid, 'bk_id' => $bk_id));
        }
        return $this->result(0, "success", $res);
    }
    public function doPageMybkstateup() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $fid = $_GPC['fid'];
        $tid = $_GPC['tid'];
        $bk_id = $_GPC['bk_id'];
        $time = date("Y-m-d", TIMESTAMP); //当前时间
        //查询是否存在一条小于今天的数据
        $Backinfo = pdo_fetch('SELECT * from' . tablename('hyb_yl_bkchat') . "where uniacid='{$uniacid}' and fid='{$fid}' and tid='{$tid}' and ttimes<'{$time}'");

        if ($Backinfo) {
            $data = array('ttimes' => date("Y-m-d", TIMESTAMP), 'bkstate' => 0);
            pdo_update('hyb_yl_bkchat', $data, array('uniacid' => $uniacid, 'bk_id' => $Backinfo['bk_id']));
            $res = pdo_fetch('SELECT * from' . tablename('hyb_yl_bkchat') . "where uniacid='{$uniacid}' and fid='{$fid}' and tid='{$tid}' and ttimes='{$time}'");
        } else {
            $res = pdo_fetch('SELECT * from' . tablename('hyb_yl_bkchat') . "where uniacid='{$uniacid}' and fid='{$fid}' and tid='{$tid}' and ttimes='{$time}'");
        }
        return $this->result(0, "success", $res);
    }
    public function doPageMybkstate1() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $bk_id = $_GPC['bk_id'];
        $data = array('bkstate' => 0);
        $res = pdo_update('hyb_yl_bkchat', $data, array('uniacid' => $uniacid, 'bk_id' => $bk_id));
        return $this->result(0, "success", $res);
    }
    public function doPageAlldcouid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $nArr = $_GPC['nArr'];
        $idarr = htmlspecialchars_decode($_GPC['nArr']);
        $is = str_replace('"]', "", $idarr);
        $id2 = str_replace('["', "", $is);
        $id3 = str_replace('""', "", $id2);
        $arr = explode(",", $id3);
        $num = count($arr);
        $contents = array();
        for ($i = 0;$i < $num;$i++) {
            $arr[$i] = str_replace('"', '', $arr[$i]);
            $res = pdo_fetch('SELECT `u_id` FROM' . tablename('hyb_yl_userinfo') . "where uniacid='{$uniacid}' and openid='{$arr[$i]}'");
            $contents[] = $res;
        }
        return $this->result(0, "success", $contents);
    }
    //orderinfo打印
    public function doPageDyjj() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $username = $_GPC['username'];
        $rp = $_GPC['content'];
        $dmoney = $_GPC['dmoney'];
        $docname = $_GPC['docname'];
        $ky_yibao = $_GPC['ky_yibao'];
        $time = date('Y-m-d H:i:s', time());
        $res3 = pdo_get('hyb_yl_dyj', array('uniacid' => $_W['uniacid']));
        $content = '';
        $content.= '' . $res3['dyj_title'] . '';
        $content.= '患者处方' . '
      ';
        $content.= '--------------------------------' . '
      ';
        $name = '';
        $content.= "--------------------------------" . '
      ';
        $content.= '处方详情：' . '
      ' . $rp . '
      ';
        $content.= '估价：' . $dmoney . '元
      ';
        $content.= '订单编号：' . $ky_yibao . '
      ';
        $content.= '就诊时间：' . $time . '
      ';
        $content.= '坐诊专家：' . $docname . '
      ';
        $content.= '用户姓名：' . $username . '
      ';
        $selfMessage = array('deviceNo' => $res3['dyj_id'], 'printContent' => $content, 'key' => $res3['dyj_key'], 'times' => '1');
        $url = 'http://open.printcenter.cn:8080/addOrder';
        $options = array('http' => array('header' => 'Content-type: application/x-www-form-urlencoded ', 'method' => 'POST', 'content' => http_build_query($selfMessage)));
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $this->result(0, "success", $result);
    }
    public function doPageIfzhuanjia() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_get('hyb_yl_zhuanjia', array('openid' => $openid, 'uniacid' => $uniacid));
        return $this->result(0, "success", $res);
    }
    public function doPageDocinfo() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['zid'];
        $res = pdo_get('hyb_yl_zhuanjia', array('uniacid' => $uniacid, 'zid' => $zid));
        return $this->result(0, "success", $res);
    }
    public function doPageIfent() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $res = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid), 'kaiguan');
        return $this->result(0, "success", $res);
    }
    //保存处方
    public function doPageSaverecipe() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $username = $_REQUEST['username'];
        $value = htmlspecialchars_decode($_GPC['pic']);
        $array = json_decode($value);
        $object = json_decode(json_encode($array), true);
        $data = array('uniacid' => $_W['uniacid'], 'userid' => $_GPC['userid'], 'docid' => $_GPC['docid'], 'content' => $_GPC['content'], 'dmoney' => $_GPC['dmoney'], 'orderarr' => $_GPC['orderarr'], 'types' => 0, 'time' => date("Y-m-d H:i:s", time()), 'username' => $username, 'pic' => serialize($object), 'useropenid' => $_GPC['useropenid'], 'cfzhenj' => $_GPC['cfzhenj']);
        $info = pdo_insert('hyb_yl_recipe', $data);
        //邮箱通知管理员
        $docname = $_GPC['docname'];
        $orderarr = $_GPC['orderarr'];
        $zy_time = date('Y-m-d H:i:s', time());
        $resarr = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_email') . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
        $smtpemailto = $resarr['mailhostname']; //'';//发送给谁
        $mailtitle = "最新处方订单提醒通知:医生 " . $docname . " 订单号:" . $orderarr . " 提交了最新处方订单,请管理上后台查看,提交时间:" . $zy_time; //邮件主题
        //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
        $mailcontent.= '订单详情:' . '
      ';
        $mailcontent.= '客户:' . $docname . '
      ';
        $mailcontent.= '订单号:' . $orderarr . '
      ';
        $mailcontent.= '提交了最新处方订单,请管理上后台查看,提交时间' . $zy_time . '
      ';
        require_once ("../framework/library/phpmailer/class.phpmailer.php");
        require_once ("../framework/library/phpmailer/class.smtp.php");
        $mail = new PHPMailer();
        $mail->isSMTP();
        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;
        //链接qq域名邮箱的服务器地址
        $mail->Host = $resarr['mailhost'];
        //设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
        //设置ssl连接smtp服务器的远程服务器端口号 可选465或587
        $mail->Port = $resarr['mailport'];
        //设置smtp的helo消息头 这个可有可无 内容任意
        $mail->CharSet = 'UTF-8';
        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = $resarr['mailformname'];
        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username = $resarr['mailusername'];
        //smtp登录的密码 这里填入“独立密码” 若为设置“独立密码”则填入登录qq的密码 建议设置“独立密码”
        $mail->Password = $resarr['mailpassword'];
        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = $resarr['mailsend'];
        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);
        $arr_mailto = explode(',', $smtpemailto);
        foreach ($arr_mailto as $v_mailto) {
            $mail->addAddress($v_mailto, '订单提醒通知');
        }
        //添加该邮件的主题
        $mail->Subject = $mailtitle;
        $mail->Body = $mailcontent;
        $status = $mail->send();
        //简单的判断与提示信息
        if ($status) {
            echo '发送邮件成功';
        } else {
            echo '发送邮件失败，错误信息未：' . $mail->ErrorInfo;
        }
        return $this->result(0, "success", $data);
    }
    //查询处方
    public function doPageSelectdoctordocid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $docid = $_GPC['docid'];
        $info = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_recipe') . "as a left join" . tablename('hyb_yl_zhuanjia') . "as b on b.zid=a.docid  where a.uniacid='{$uniacid}' and a.docid='{$docid}' ", array("uniacid" => $uniacid));
        return $this->result(0, "success", $info);
    }
    public function doPageMyinfouid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_get('hyb_yl_myinfors', array('openid' => $openid, 'uniacid' => $uniacid));
        return $this->result(0, "success", $res);
    }
    public function doPageSelecthztordocid() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $userid = $_GPC['userid'];
        $info = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_recipe') . "as a left join" . tablename('hyb_yl_zhuanjia') . "as b on b.zid=a.docid  where a.uniacid='{$uniacid}' and ifxians=1 and a.userid='{$userid}' order by a.cid desc", array("uniacid" => $uniacid));
        return $this->result(0, "success", $info);
    }
    public function doPageSelcetcfinfo() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $cid = $_GPC['cid'];
        $info = pdo_fetch('SELECT * from ' . tablename('hyb_yl_recipe') . "as a left join" . tablename('hyb_yl_myinfors') . "as b on b.my_id=a.userid where a.uniacid='{$uniacid}' and a.cid ='{$cid}'");
        $info['pic'] = unserialize($info['pic']);
        $num = count($info['pic']);
        for ($i = 0;$i < $num;$i++) {
            $info['pic'][$i] = $_W['attachurl'] . $info['pic'][$i];
        }
        return $this->result(0, "success", $info);
    }
    public function doPagePiandaohang() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_pian_daohang") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        foreach ($list as & $value) {
            $value['thumb'] = $_W['attachurl'] . $value['thumb'];
            $value['text'] = htmlspecialchars_decode($value['text']);
        }
        return $this->result(0, "success", $list);
    }
    //骗审信息详情
    public function doPagePianxinxixq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $list = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_pian") . "  where uniacid=:uniacid and id=:id", array(":uniacid" => $uniacid, ":id" => $id));
        $list['thumb'] = $_W['attachurl'] . $list['thumb'];
        return $this->result(0, "success", $list);
    }
    //骗审信息
    public function doPagePianlist() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_pian") . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        foreach ($list as & $value) {
            $value['thumb'] = $_W['attachurl'] . $value['thumb'];
        }
        return $this->result(0, "success", $list);
    }
    public function doPagePianinfoxx(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $res =pdo_get('hyb_yl_pian_daohang',array('id'=>$id,'uniacid'=>$uniacid));
        $res['text'] = htmlspecialchars_decode($res['text']);
        return $this->result(0, "success", $res);
    }
    public function doPageAllquestion() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['zid'];
        $qid = $_GPC['qid'];
        $user_openid = $_GPC['user_openid'];
        $fromuser = $_GPC['fromuser']; //医生的
        //查询医生回答的qid所有问题
        $rew = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_question') . "as a left join" . tablename('hyb_yl_zhuanjia') . "as b on b.zid =a.p_id where a.uniacid='{$uniacid}' and a.qid='{$qid}'");
        $list = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_question') . "as a left join" . tablename('hyb_yl_zhuanjia') . "as b on b.zid = a.p_id where a.user_openid ='{$fromuser}' and a.parentid='{$qid}' and a.uniacid='{$uniacid}' and a.p_id='{$zid}' ");
        foreach ($list as & $value) {
            if ($value['parentid'] == $rew['qid']) {
                $arr[] = $value;
            }
        }
        $userpic = unserialize($rew['user_picture']);
        foreach ($userpic as & $v) {
            $v = $_W['attachurl'] . $v;
        }
        $rew['doc'] = $arr;
        $rew['user_picture'] = $userpic;
        return $this->result(0, "success", $rew);
    }
    public function doPageFromque() {
        global $_GPC, $_W;
        $qid = $_GPC['qid'];
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['p_id'];
        $data['usertype'] = 1;
        $data['q_docthumb'] = $_REQUEST['q_thumb'];
        $data['q_zhiwei'] = $_REQUEST['z_zhiwu'];
        $data['uniacid'] = $_W['uniacid'];
        $data['question'] = $_REQUEST['question'];
        $data['parentid'] = $_REQUEST['parentid'];
        $data['q_dname'] = $_REQUEST['q_dname'];
        $data['q_thumb'] = $_GPC['q_thumb'];
        $data['p_id'] = $_REQUEST['p_id'];
        $data['fromuser'] = $_REQUEST['fromuser'];
        $data['user_openid'] = $_REQUEST['user_openid'];
        $data['q_time'] = date('Y-m-d H:i:s', time());
        $res = pdo_insert('hyb_yl_question', $data);
        $member = pdo_update('hyb_yl_question', array('yuedu' => 1), array('qid' => $qid, 'uniacid' => $uniacid));
        $getupdate = pdo_update("hyb_yl_question", $datas, array('savant_openid' => $selectdata['savant_openid'], 'uniacid' => $uniacid, 'qid' => $qid));
        $docinfo = pdo_getcolumn('hyb_yl_zhuanjia', array('zid' => $zid, 'uniacid' => $uniacid), 'helpnum');
        $datadoc = array('helpnum' => $docinfo + 1);
        pdo_update('hyb_yl_zhuanjia', $datadoc, array('zid' => $zid, 'uniacid' => $uniacid));
        return $this->result(0, 'success', $member);
    }
    public function doPageSaveover() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $qid = $_GPC['qid1'];
        $data = array('gbmoney' => $_GPC['gbmoney'],);
        $res = pdo_update('hyb_yl_question', $data, array('uniacid' => $uniacid, 'qid' => $qid));
        return $this->result(0, 'success', $res);
    }
    public function doPageDelover() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $qid = intval($_REQUEST['qid']);
        $state1 = $_GPC['state'];
        $q_category = $_GPC['q_category'];
        if ($state1 == 'false') {
            $if_over = 0;
        } else {
            $if_over = 1;
        }
        $dada = pdo_update('hyb_yl_question', array('if_over' => $if_over, 'q_category' => $q_category), array('uniacid' => $uniacid, 'qid' => $qid));
        return $this->result(0, 'success', $dada);
    }
    public function doPageSelectnew() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $res = pdo_get('hyb_yl_overquestion', array('uniacid' => $uniacid, 'useropenid' => $_GPC['user_openid'], 'zid' => $_GPC['zid']));
        return $this->result(0, 'success', $res);
    }
    public function doPageGoodsinfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['pzid'];
        $data = array('uniacid' => $uniacid, 'qid' => $_GPC['qid'], 'money' => $_GPC['money'], 'openid' => $_GPC['openid'], 'type' => $_GPC['type1'], 'pzid' => $zid, 'g_time' => date('Y-m-d H:i:s', time()));
        $rows = pdo_get('hyb_yl_goodsinfo', array('uniacid' => $uniacid, 'qid' => $_GPC['qid'], 'money' => $_GPC['money'], 'openid' => $_GPC['openid']));
        if (!empty($zid)) {
            $userpay = pdo_get('hyb_yl_userinfo', array('openid' => $_GPC['openid'], 'uniacid' => $uniacid));
            $docpay = pdo_get('hyb_yl_zhuanjia', array('zid' => $zid, 'uniacid' => $uniacid), array('d_txmoney', 'overmoney'));
            $docinfo['time'] = date('Y-m-d H:i:s', time());
            $docnew_arr = ($docpay['d_txmoney'] + $_GPC['money']);
            $overmoney = ($docpay['overmoney'] + $_GPC['money']);
            //更新医生总金额
            $zengjia = pdo_update('hyb_yl_zhuanjia', array('d_txmoney' => $docnew_arr, 'overmoney' => $overmoney), array('uniacid' => $uniacid, 'zid' => $zid));
            //新增医生收益订单
            $shouyi = array('uniacid' => $_W['uniacid'], 'z_ids' => $_GPC['pzid'], 'funame' => '问答', 'username' => $userpay['u_name'], 'type' => $_GPC['types'], 'symoney' => $_GPC['money'], 'times' => strtotime("now"));
            $upshouy = pdo_insert('hyb_yl_docshouyi', $shouyi);
        }
        if (empty($rows)) {
            $res = pdo_insert('hyb_yl_goodsinfo', $data);
        } else {
            $res = pdo_update('hyb_yl_goodsinfo', $data, array('gid' => $rows['gid'], 'uniacid' => $uniacid));
        }
        return $this->result(0, 'success', $data);
    }
    public function doPageHistoryArr() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetchall('select * from' . tablename('hyb_yl_goodsinfo') . "as a left join" . tablename('hyb_yl_question') . "as b on b.qid = a.qid left join" . tablename('hyb_yl_zhuanjia') . "as c on c.zid = b.p_id where a.openid='{$openid}'");
        return $this->result(0, 'success', $res);
    }
    public function doPageDeletinfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $gid = htmlspecialchars_decode($_GPC['gid']);
        $is = str_replace('[', "", $gid);
        $is1 = str_replace(']', "", $is);
        $is2 = str_replace('"', "", $is1);
        $arr = explode(',', $is2);
        for ($i = 0;$i < count($arr);$i++) {
            $res = pdo_delete('hyb_yl_goodsinfo', array('gid' => $arr[$i]));
        }
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    //查询问题详情
    public function doPageInforquestion() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $qid = $_GPC['qid'];
        $res = pdo_get('hyb_yl_question', array('qid' => $qid, 'uniacid' => $uniacid));
        return $this->result(0, 'success', $res);
    }
    public function doPageJoninmoney() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $leixing['leixing'] = $_GPC['leixing'];
        $leixing['time'] = date('Y-m-d H:i:s', time());
        $leixing['name'] = $_GPC['name'];
        $leixing['pay'] = $_GPC['pay'];
        $use_openid = $_GPC['use_openid'];
        $zid = $_GPC['zid'];
        $types = $_GPC['types'];
        $year = date("Y",time());
        $newyear = strtotime($year);
        
        $member = pdo_get('hyb_yl_mymoney', array('use_openid' => $use_openid, 'uniacid' => $uniacid));
        if ($member['countmoney'] == '') {
            $arr = array();
        } else {
            $arr = unserialize($member['countmoney']);
        }
        array_push($arr, $leixing);
        $new_arr = serialize($arr);
        $data = array('uniacid' => $uniacid, 'countmoney' => $new_arr, 'use_openid' => $use_openid);
        if ($member['countmoney'] == '') {
            $ret = pdo_insert('hyb_yl_mymoney', $data);
        } else {
            $ret = pdo_update('hyb_yl_mymoney', array('countmoney' => $new_arr), array('id' => $member['id'], 'uniacid' => $uniacid));
        }
        //查询我的总消费
        $userpay = pdo_get('hyb_yl_userinfo', array('openid' => $use_openid), array('u_xfmoney', 'u_id', 'u_name'));
        $data = array('u_xfmoney' => $userpay['u_xfmoney'] + $leixing['pay']);
        $upuser = pdo_update('hyb_yl_userinfo', $data, array('uniacid' => $uniacid, 'u_id' => $userpay['u_id']));
        if ($types == '2') {
            if (!empty($zid)) {
                $docpay = pdo_get('hyb_yl_zhuanjia', array('zid' => $_GPC['zid'], 'uniacid' => $uniacid), array('d_txmoney', 'overmoney'));
                $docinfo['time'] = date('Y-m-d H:i:s', time());
                $docnew_arr = $docpay['d_txmoney'] + $leixing['pay'];
                //更新医生总金额
                $zengjia = pdo_update('hyb_yl_zhuanjia', array('d_txmoney' => $docnew_arr, 'overmoney' => $docpay['overmoney'] + $leixing['pay']), array('uniacid' => $uniacid, 'zid' => $zid));
                //新增医生收益订单
                $shouyi = array('uniacid' => $_W['uniacid'], 'z_ids' => $_GPC['zid'], 'funame' => $_GPC['leixing'], 'username' => $userpay['u_name'], 'type' => $_GPC['types'], 'symoney' => $_GPC['pay'], 'year'=>$newyear,'times' => strtotime("now"));
                $upshouy = pdo_insert('hyb_yl_docshouyi', $shouyi);
            }
        }
        return $this->result(0, 'success', $ret);
    }
    public function doPageSelmypay() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $use_openid = $_GPC['use_openid'];
        $member = pdo_get('hyb_yl_mymoney', array('use_openid' => $use_openid, 'uniacid' => $uniacid));
        $member['countmoney'] = unserialize($member['countmoney']);
        return $this->result(0, 'success', $member);
    }
    public function doPageSelectx() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $user_openid = $_GPC['user_openid'];
        $res = pdo_fetchall('select * from' . tablename('hyb_yl_yltx') . "where uniacid='{$uniacid}' and user_openid='{$user_openid}'");
        foreach ($res as & $value) {
            $value['cerated_time'] = date('Y-m-d H:i:s', $value['cerated_time']);
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageSelethzq() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $p_id = $_GPC['zid'];
        $user_openid = $_GPC['user_openid'];
        $res = pdo_fetchall('select * from' . tablename('hyb_yl_question') . "where uniacid='{$uniacid}' and user_openid='{$user_openid}' and p_id ='{$p_id}'");
        foreach ($res as & $value) {
            $parentid = $value['qid'];
            $allques = pdo_fetchall('select * from' . tablename('hyb_yl_question') . "where uniacid='{$uniacid}' and parentid='{$parentid}' ");
            $value['hd_question'] = $allques;
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageInseruser() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $value = htmlspecialchars_decode($_GPC['value']);
        $array = json_decode($value);
        $object = json_decode(json_encode($array), true);
        $data_arr = htmlspecialchars_decode($_GPC['data_arr']);
        $pic = json_decode($data_arr);
        $picarr['userpic'] = json_decode(json_encode($pic), true);
        $fid = $_GPC['fid'];
        // $num = count($picarr['userpic']);
        // for($i = 0; $i < $num; $i++) {
        //   $picarr['userpic'][$i] = $_W['attachurl'] . $picarr['userpic'][$i];
        // }
        $data = array('uniacid' => $_W['uniacid'], 'openid' => $object['openid'], 'cyname' => $object['cyname'], 'date1' => $object['date1'], 'date2' => $object['date2'], 'name_0' => serialize($object['lianxi']), 'sex' => $object['sex'], 'uerAge' => $object['uerAge'], 'uerName' => $object['uerName'], 'uerPhone' => $object['uerPhone'], 'uerinfor' => $object['uerinfor'], 'userDay' => $object['userDay'], 'userHospital' => $object['userHospital'], 'userMoney' => $object['userMoney'], 'userTpye' => $fid, 'usershoushu' => $object['usershoushu'], 'userpic' => serialize($picarr['userpic']), 'time' => date('Y-m-d H:i:s', time()), 'date' => $object['date3']);
        $res = pdo_insert('hyb_yl_lipei', $data);
        $lpid = pdo_insertid();
        return $this->result(0, 'success', $lpid);
    }
    public function doPageAlllipei() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetchall('select * from' . tablename('hyb_yl_lipei') . " as a left join " . tablename('hyb_yl_fwlxing') . "as b on b.fid = a.userTpye where a.uniacid='{$uniacid}' and a.openid ='{$openid}'");
        return $this->result(0, 'success', $res);
    }
    public function doPageAlonelip() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $lpid = $_GPC['lpid'];
        $res = pdo_fetch("SELECT * from" . tablename('hyb_yl_lipei') . "as a left join" . tablename('hyb_yl_fwlxing') . "as b on b.fid = a.userTpye where a.uniacid ='{$uniacid}' and lpid='{$lpid}'");
        $res['name_0'] = unserialize($res['name_0']);
        $res['userpic'] = unserialize($res['userpic']);
        $num = count($res['userpic']);
        for ($i = 0;$i < $num;$i++) {
            $res['userpic'][$i] = $_W['attachurl'] . $res['userpic'][$i];
        }
        return $this->result(0, 'suuess', $res);
    }
    public function doPageFwleix() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $res = pdo_fetchall("SELECT * from" . tablename('hyb_yl_fwlxing') . "where uniacid='{$uniacid}'");
        foreach ($res as & $value) {
            $arr[] = $value['fwname'];
        }
        $res['fwname'] = $arr;
        return $this->result(0, 'suuess', $res);
    }
    public function doPageDelelip() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $gid = htmlspecialchars_decode($_GPC['lpid']);
        $is = str_replace('[', "", $gid);
        $is1 = str_replace(']', "", $is);
        $is2 = str_replace('"', "", $is1);
        $arr = explode(',', $is2);
        for ($i = 0;$i < count($arr);$i++) {
            $res = pdo_delete('hyb_yl_lipei', array('lpid' => $arr[$i]));
        }
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $res);
    }
    public function doPageQQemail() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $phone = $_GPC['phone'];
        $cyname = $_GPC['cyname'];
        $zy_time = date('Y-m-d H:i:s', time());
        $resarr = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_goodsemail') . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
        $smtpemailto = $resarr['mailhostname']; //'';//发送给谁
        $mailtitle = "预约提醒通知：客户 " . $cyname . " 手机号：" . $phone . " 申请了理赔,预约时间：" . $zy_time; //邮件主题
        //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
        $mailcontent.= '预约详情:' . '
      ';
        $mailcontent.= '客户:' . $cyname . '
      ';
        $mailcontent.= '手机号:' . $phone . '
      ';
        $mailcontent.= '申请了理赔,提交时间' . $zy_time . '
      ';
        require_once ("../framework/library/phpmailer/class.phpmailer.php");
        require_once ("../framework/library/phpmailer/class.smtp.php");
        $mail = new PHPMailer();
        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        //$mail->SMTPDebug = 1;
        //使用smtp鉴权方式发送邮件，当然你可以选择pop方式 sendmail方式等 本文不做详解
        //可以参考https://phpmailer.github.io/PHPMailer/当中的详细介绍
        $mail->isSMTP();
        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;
        //链接qq域名邮箱的服务器地址
        $mail->Host = $resarr['mailhost'];
        //设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
        //设置ssl连接smtp服务器的远程服务器端口号 可选465或587
        $mail->Port = $resarr['mailport'];
        //设置smtp的helo消息头 这个可有可无 内容任意
        //$mail->Helo = 'Hello smtp.qq.com Server';
        //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        //$mail->Hostname = 'jjonline.cn';
        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';
        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = $resarr['mailformname'];
        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username = $resarr['mailusername'];
        //smtp登录的密码 这里填入“独立密码” 若为设置“独立密码”则填入登录qq的密码 建议设置“独立密码”
        $mail->Password = $resarr['mailpassword'];
        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = $resarr['mailsend'];
        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);
        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        //添加多个收件人 则多次调用方法即可
        $arr_mailto = explode(',', $smtpemailto);
        foreach ($arr_mailto as $v_mailto) {
            $mail->addAddress($v_mailto, '订单提醒通知');
        }
        //添加该邮件的主题
        $mail->Subject = $mailtitle;
        //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = $mailcontent;
        //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
        //$mail->addAttachment('./d.jpg','mm.jpg');
        //同样该方法可以多次调用 上传多个附件
        //$mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');
        //发送命令 返回布尔值
        //PS：经过测试，要是收件人不存在，若不出现错误依然返回true 也就是说在发送之前 自己需要些方法实现检测该邮箱是否真实有效
        $status = $mail->send();
        //简单的判断与提示信息
        if ($status) {
            echo '发送邮件成功';
        } else {
            echo '发送邮件失败，错误信息未：' . $mail->ErrorInfo;
        }
    }
    public function doPageAllparzilei() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $res = pdo_fetchall("SELECT * from" . tablename('hyb_yl_category') . "where uniacid = '{$uniacid}' and parentid='{$id}' and ifkq=1 order by id asc");
        foreach ($res as & $val) {
            $pId = $val['id'];
            $val['icon'] = $_W['attachurl'] . $val['icon'];
            $erji = pdo_fetchall("SELECT * from" . tablename('hyb_yl_category') . "where uniacid = '{$uniacid}' and parentid='{$pId}' and ifkq=1 order by id asc");
            foreach ($erji as & $value1) {
                $value1['icon'] = $_W['attachurl'] . $value1['icon'];
                if ($value1['parentid'] == $pId) {
                    $val['projectArr'] = $erji;
                }
            }
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageSelpar() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $res = pdo_get('hyb_yl_category', array('id' => $id, 'uniacid' => $uniacid));
        $res['icon'] = $_W['attachurl'] . $res['icon'];
        return $this->result(0, 'success', $res);
    }
    public function doPageZenjdj() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $hz_id = $_GPC['hz_id'];
        $res = pdo_getcolumn('hyb_yl_huanzhe', array('hz_id' => $hz_id, 'uniacid' => $uniacid), 'dianj');
        $data = array('dianj' => $res + 1,);
        $up = pdo_update('hyb_yl_huanzhe', $data, array('uniacid' => $uniacid, 'hz_id' => $hz_id));
        return $this->result(0, 'success', $up);
    }
    public function doPageZenzxdj() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $res = pdo_getcolumn('hyb_yl_zixun', array('id' => $id, 'uniacid' => $uniacid), 'dianj');
        $data = array('dianj' => $res + 1,);
        $up = pdo_update('hyb_yl_zixun', $data, array('uniacid' => $uniacid, 'id' => $id));
        return $this->result(0, 'success', $up);
    }
    public function doPageAdddianjil() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $qid = $_GPC['qid'];
        $res = pdo_getcolumn('hyb_yl_question', array('qid' => $qid, 'uniacid' => $uniacid), 'dianji');
        $data = array('dianji' => $res + 1,);
        $up = pdo_update('hyb_yl_question', $data, array('uniacid' => $uniacid, 'qid' => $qid));
        return $this->result(0, 'success', $up);
    }
    public function doPageZdybd() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);
        $condition = " uniacid = '{$_W['uniacid']}'";
        $allforms = pdo_fetchall("select * from " . tablename('hyb_yl_formdate') . " where" . $condition . " and activityid=:id order by displayorder asc", array(":id" => $id));
        $condition.= " and `show`=1";
        foreach ($allforms as & $s) {
            $s['items'] = pdo_fetchall("select * from " . tablename('hyb_yl_item') . " where" . $condition . " and formid=" . $s['id'] . " order by displayorder asc");
        }
        return $this->result(0, 'success', $allforms);
    }
    //批量查询三级分类的所有数据
    public function doPageGetzlinfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $condition = " uniacid = '{$_W['uniacid']}'";
        $array2 = htmlspecialchars_decode($_GPC['zlid']);
        $duox = json_decode($array2);
        $id = json_decode(json_encode($duox), true);
        //查询二级
        // $dqerj =pdo_fetch("SELECT * from".tablename('hyb_yl_category')."where uniacid = '{$uniacid}' and id='{$id}' and ifkq=1 ");
        //下面的所有三级
        // $res =pdo_fetchall("SELECT * from".tablename('hyb_yl_category')."where uniacid = '{$uniacid}' and parentid='{$id}' order by id asc");
        // foreach ($res as &$val) {
        //   $pId= $val['id'] ;
        //   $val['icon']=$_W['attachurl'].$val['icon'];
        // }
        $allforms = pdo_fetchall("select * from " . tablename('hyb_yl_formdate') . " where activityid=:id order by displayorder asc", array(":id" => $id));
        $condition.= " and `show`=1";
        foreach ($allforms as & $s) {
            $s['items'] = pdo_fetchall("select * from " . tablename('hyb_yl_item') . " where" . $condition . " and formid=" . $s['id'] . " order by displayorder asc");
        }
        // $time = date("Y-m-d",TIMESTAMP);//当前时间
        // //查询一条存在$dqerj['name']的数据
        // $pdo_get =pdo_get('hyb_yl_baogaoinfo',array('uniacid'=>$uniacid,'fuleiname'=>$dqerj['name'],'time='=>$time));
        return $this->result(0, 'success', $allforms);
    }
    public function doPageGetvalues() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $values = $_GPC['values'];
        $bg_id = $_GPC['bg_id'];
        $array2 = htmlspecialchars_decode($values);
        $duox = json_decode($array2);
        $request = json_decode(json_encode($duox), true);
        $ser = serialize($request);
        $title = $_GPC['title'];
        $hospital = $_GPC['hospital'];
        $org_pic = $_GPC['org_pic'];
        $hzid = $_GPC['hzid'];
        $time = $_GPC['time'];
        $data = array('uniacid' => $uniacid, 'info' => $ser, 'useropenid' => $_GPC['useropenid'], 'time' => $time, 'title' => $title, 'hospital' => $hospital, 'org_pic' => $org_pic, 'hzid' => $hzid,);
        if (empty($bg_id)) {
            $res = pdo_insert('hyb_yl_baogaoinfo', $data);
            $bg_id = pdo_insertid();
        } else {
            $docpay = pdo_get('hyb_yl_baogaoinfo', array('bg_id' => $_GPC['bg_id'], 'uniacid' => $uniacid), array('info'));
            $docinfo = serialize($request);
            $darr = $docpay['info'];
            $new_arr = $darr . '+' . $docinfo;
            $zengjia = pdo_update('hyb_yl_baogaoinfo', array('info' => $new_arr), array('uniacid' => $uniacid, 'bg_id' => $bg_id));
        }
        return $this->result(0, 'success', $bg_id);
    }
    public function doPageBginfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $hzid = $_GPC['hzid'];
        $res = pdo_fetchall('SELECT * from' . tablename('hyb_yl_baogaoinfo') . "where uniacid='{$uniacid}' and hzid='{$hzid}' ");
        foreach ($res as $key => $value) {
            $res[$key]['info'] = explode("+", $value['info']);
        }
        $item = array();
        foreach ($res as & $vs) {
            $num = count($vs['info']);
            for ($i = 0;$i < $num;$i++) {
                $vs['info'][$i] = unserialize($vs['info'][$i]);
                $item[] = $vs['info'][$i];
            }
        }
        $u = array();
        foreach ($item as $k => & $e) {
            $id = & $e['id'];
            if (!isset($u[$id])) {
                $u[$id] = $e;
                unset($u[$id]['data']);
            }
            $u[$id]['data'][] = array($e['data']);
        }
        $item = array_values($u);
        unset($u);
        // $res['info'] = explode("+",$res['info']);
        // foreach ($res['info'] as $key => $value) {
        //      $res[$key]['info']=unserialize($value);
        // }
        return $this->result(0, 'success', $item);
    }
    public function doPageZengpldianz() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = intval($_REQUEST['m_id']);
        $cerated_type = $_GPC['cerated_type'];
        $res = pdo_get('hyb_yl_collect', array('openid' => $_GPC['openid'], 'goods_id' => $id, 'cerated_type' => 4));
        if ($res) {
            $result = pdo_delete('hyb_yl_collect', array('id' => $re['id']));
            pdo_update('hyb_yl_mcoment', array('dianz -=' => 1), array('m_id' => $id));
            echo '1';
        } else {
            $data['openid'] = $_GPC['openid'];
            $data['goods_id'] = $id;
            $data['cerated_type'] = 4;
            $data['cerated_time'] = date('Y-m-d H:i:s');
            $res = pdo_insert('hyb_yl_collect', $data);
            pdo_update('hyb_yl_mcoment', array('dianz +=' => 1), array('m_id' => $id));
            echo '2';
        }
    }
    public function doPageAlltijianbaogao() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $useropenid = $_GPC['useropenid'];
        $hzid = $_GPC['hzid'];
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_baogaoinfo') . "where uniacid ='{$uniacid}' and useropenid ='{$useropenid}' and hzid='{$hzid}' order by bg_id desc");
        return $this->result(0, 'success', $res);
    }
    public function doPageAddtijian() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $openid =$_GPC['openid'];
        if($op =='display'){
             $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_userjiaren")."WHERE uniacid='{$uniacid}' and openid='{$openid}'");
             echo json_encode($res);
        }else{
            $data = array('uniacid' => $_W['uniacid'], 'names' => $_GPC['names'], 'openid' => $_GPC['openid'],'relationship'=>$_GPC['relationship'],'sex'=>$_GPC['sex'],'datetime'=>$_GPC['datetime'],'age'=>$_GPC['age']);
            $res = pdo_insert('hyb_yl_userjiaren', $data);
            $j_id = pdo_insertid();
            return $this->result(0, 'success', $j_id);  
        }

    }
    public function doPageAllmyjiaren() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_userjiaren') . "where uniacid ='{$uniacid}' and openid='{$openid}' order by j_id desc");
        return $this->result(0, 'success', $res);
    }
    public function doPageDuibi() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $values = $_GPC['bg_id'];
        $array2 = htmlspecialchars_decode($values);
        $duox = json_decode($array2);
        $bg_id = json_decode(json_encode($duox), true);
        // $ser = serialize($request);
        $arr = array();
        foreach ($bg_id as $key => $value) {
            $id = $value['bg_id'];
            $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_baogaoinfo') . "where uniacid='{$uniacid}' and bg_id='{$id}'");
            foreach ($res as $ke => $v1) {
                $masg = explode('+', $v1['info']);
                $arr[] = $masg;
            }
        }
        foreach ($arr as & $v2) {
            foreach ($v2 as & $vat) {
                $arr1[] = unserialize($vat);
            }
        }
        $result = [];
        foreach ($arr1 as $k1 => $data) {
            $displaytype = $data['data']['secArr1'];
            foreach ($displaytype as $k2 => $type) {
                $result[$type['displaytype']][] = $type;
            }
        }
        $datas = [];
        foreach ($result[3] as $key1 => $value1) {
            $datas[$value1['time']][] = $value1;
        }
        $shuju = array_values($datas);
        return $this->result(0, 'success', $shuju);
    }
    public function doPageFenxi() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $hzid = $_GPC['hzid'];
        // $ser = serialize($request);
        $arr = array();
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_baogaoinfo') . "where uniacid='{$uniacid}' and hzid='{$hzid}'");
        foreach ($res as $ke => $v1) {
            $masg = explode('+', $v1['info']);
            $arr[] = $masg;
        }
        $arr1 = [];
        foreach ($arr as & $v2) {
            foreach ($v2 as & $vat) {
                $arr1[] = unserialize($vat);
            }
        }
        $result = [];
        foreach ($arr1 as $k1 => $data) {
            $displaytype = $data['data']['secArr1'];
            foreach ($displaytype as $k2 => $type) {
                $result[$type['displaytype']][] = $type;
            }
        }
        $datas = [];
        foreach ($result[3] as $key1 => $value1) {
            $datas[$value1['title']][] = $value1;
        }
        $shuju = array_values($datas);
        return $this->result(0, 'success', $shuju);
    }
    //查询二级下面的所有三级
    public function doPageSanji() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $allforms = pdo_fetchall("select * from " . tablename('hyb_yl_jdcategory') . " where parentid=:id order by id asc", array(":id" => $id));
        return $this->result(0, 'success', $allforms);
    }
    public function doPageAlldiy() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $condition = " uniacid = '{$_W['uniacid']}'";
        $allforms = pdo_fetchall("select * from " . tablename('hyb_yl_jiandang') . " where activityid=:id order by displayorder asc", array(":id" => $id));
        $condition.= " and `show`=1";
        foreach ($allforms as & $s) {
            $s['items'] = pdo_fetchall("select * from " . tablename('hyb_yl_jderj') . " where" . $condition . " and formid=" . $s['id'] . " order by displayorder asc");
        }
        return $this->result(0, 'success', $allforms);
    }

    public function doPageSavedivjd() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $fuleiid = $_GPC['fuleiid'];
        $jd_id = $_GPC['jd_id'];
        $hosp = $_GPC['hosp'];
        $values = $_GPC['values'];
        $array2 = htmlspecialchars_decode($values);
        $duox = json_decode($array2);
        $msg = json_decode(json_encode($duox), true);
        $org_pic = $_GPC['org_pic'];
        $idarr = htmlspecialchars_decode($org_pic);
        $duox = json_decode($idarr);
        $pic_p = json_decode(json_encode($duox), true);
        $data = array('uniacid' => $_W['uniacid'], 'info' => serialize($msg), 'useropenid' => $_GPC['openid'], 'time' => date("Y-m-d", TIMESTAMP), //当前时间
        'fuleiid' => $fuleiid, 'org_pic' => serialize($pic_p), 'timearr' => $_GPC['timearr'], 'hosp' => $hosp, 'xctime' => $_GPC['xctime'], 'xmname' => $_GPC['xmname'], 'jcx_id' => $_GPC['jcx_id'], 'multsel' => $_GPC['multsel'], 'erjid' => $_GPC['erjid']);
        if ($jd_id == "undefined" || empty($jd_id)) {
            $res = pdo_insert('hyb_yl_jiandangbaogaoinfo', $data);
        } else {
            $res = pdo_update('hyb_yl_jiandangbaogaoinfo', $data, array('jd_id' => $jd_id, 'uniacid' => $uniacid));
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageGetfutj() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $res = pdo_fetchall('SELECT * From' . tablename('hyb_yl_yzfuwu') . "where uniacid='{$uniacid}' and futj=1");
        foreach ($res as & $value) {
            $value['fthumb'] = $_W['attachurl'] . $value['fthumb'];
            $value['biaoqian'] = explode(',', $value['biaoqian']);
            $value['jieshao'] = strip_tags(htmlspecialchars_decode($value['jieshao']));
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageTaocaninfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $f_id = $_GPC['f_id'];
        $res = pdo_get('hyb_yl_yzfuwu', array('f_id' => $f_id, 'uniacid' => $uniacid));
        $res['biaoqian'] = explode(',', $res['biaoqian']);
        $res['mor_thumb'] = unserialize($res['mor_thumb']);
        $res['taocanm'] = unserialize($res['taocanm']);
        $res['fthumb'] = $_W['attachurl'] . $res['fthumb'];
        $num = count($res['mor_thumb']);
        for ($i = 0;$i < $num;$i++) {
            $res['mor_thumb'][$i] = $_W['attachurl'] . $res['mor_thumb'][$i];
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageSavegoods() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $s_order = str_shuffle(time() . rand(111111, 999999));
        $data = array('uniacid' => $_W['uniacid'], 'openid' => $_GPC['openid'], 'money' => $_GPC['money'], 'goodsname' => $_GPC['goodsname'], 'types' => $_GPC['types'], 'address' => $_GPC['address'], 'ifzhifu' => $_GPC['ifzhifu'], 'danh' => $s_order, 'username' => $_GPC['username'], 'telNumber' => $_GPC['telNumber'], 'timesa' => date('Y-m-d H:i:s', time()));
        $res = pdo_insert('hyb_yl_usergoods', $data);
        return $this->result(0, 'success', $res);
    }
    public function doPageAllfeilei() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $condition = " uniacid = '{$_W['uniacid']}'";
        $allforms = pdo_fetchall("select * from " . tablename('hyb_yl_jdcategory') . " where" . $condition . "AND parentid = 0 order by id ASC");
        foreach ($allforms as & $s) {
            // $s['items'] = pdo_fetchall("select * from " . tablename('hyb_yl_jdcategory') . " where".$condition." and parentid=".$s['id']." order by id ASC");
            $s['icon'] = $_W['attachurl'] . $s['icon'];
            // foreach ($s['items'] as &$value) {
            //   $value['icon']=$_W['attachurl'].$value['icon'];
            // }
            
        }
        return $this->result(0, 'success', $allforms);
    }
    public function doPageAllerjifenl() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $condition = " uniacid = '{$_W['uniacid']}'";
        $res = pdo_fetchall("select * from " . tablename('hyb_yl_jdcategory') . " where" . $condition . " and parentid=" . $id . " order by id ASC");
        foreach ($res as & $value) {
            $value['icon'] = $_W['attachurl'] . $value['icon'];
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageJdlist() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $fuleiid = $_GPC['fuleiid'];
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_jiandangbaogaoinfo') . "where uniacid ='{$uniacid}' and fuleiid='{$fuleiid}' and useropenid='{$openid}' order by jd_id desc");
        foreach ($res as & $value) {
            $value['info'] = unserialize($value['info']);
            $value['org_pic'] = unserialize($value['org_pic']);
            $slinum = count($value['org_pic']);
            for ($i = 0;$i < $slinum;$i++) {
                $value['org_pic'][$i] = $_W['attachurl'] . $value['org_pic'][$i];
            }
        }
        return $this->result(0, 'success', $res);
    }


    public function doPageJdlistsanji(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $parentid = $_GPC['parentid']; 
        $openid = $_GPC['openid'];
        $fuleiid = $_GPC['fuleiid'];
        $get = pdo_fetchall("SELECT * from".tablename("hyb_yl_jdcategory")."WHERE uniacid ='{$uniacid}' and parentid='{$parentid}'");
        foreach ($get as $key => $value) {
           $id = $value['id'];
           $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_jiandangbaogaoinfo') . "where uniacid ='{$uniacid}' and fuleiid='{$id}' and useropenid='{$openid}' order by jd_id desc");
          }
            foreach ($res as & $value) {
                $value['info'] = unserialize($value['info']);
                $value['org_pic'] = unserialize($value['org_pic']);
                $slinum = count($value['org_pic']);
                for ($i = 0;$i < $slinum;$i++) {
                    $value['org_pic'][$i] = $_W['attachurl'] . $value['org_pic'][$i];
                }
            }
        return $this->result(0, 'success', $res);
    }
    public function doPageSelectjdinfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $jd_id = $_GPC['jd_id'];
        $res = pdo_fetch('SELECT * FROM' . tablename('hyb_yl_jiandangbaogaoinfo') . "where uniacid ='{$uniacid}' and  jd_id='{$jd_id}'");
        $res['org_pic'] = unserialize($res['org_pic']);
        $piccount = count($res['org_pic']);
        for ($i = 0;$i < $piccount;$i++) {
            $res['org_pic'][$i] = $_W['attachurl'] . $res['org_pic'][$i];
        }
        $res['info'] = unserialize($res['info']);
        return $this->result(0, 'success', $res);
    }
    public function doPageDelinfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $jd_id = $_GPC['jd_id'];
        $res = pdo_delete('hyb_yl_jiandangbaogaoinfo', array('jd_id' => $jd_id, 'uniacid' => $uniacid));
        return $this->result(0, 'success', $res);
    }
    public function doPageMyfuwuorder() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $index = $_GPC['index'];
        if (!empty($index)) {
            if ($index == 0) {
                $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_usergoods') . " AS a left join" . tablename('hyb_yl_yzfuwu') . "as b on b.f_id=a.types where a.uniacid='{$uniacid}' and a.openid='{$openid}'");
            }
            if ($index == 1) {
                $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_usergoods') . " AS a left join" . tablename('hyb_yl_yzfuwu') . "as b on b.f_id=a.types where a.uniacid='{$uniacid}' and a.openid='{$openid}' and ifzhifu !=1");
            }
            if ($index == 2) {
                $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_usergoods') . " AS a left join" . tablename('hyb_yl_yzfuwu') . "as b on b.f_id=a.types where a.uniacid='{$uniacid}' and a.openid='{$openid}' and ifzhifu=1");
            }
        } else {
            $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_usergoods') . " AS a left join" . tablename('hyb_yl_yzfuwu') . "as b on b.f_id=a.types where a.uniacid='{$uniacid}' and a.openid='{$openid}'");
        }
        foreach ($res as & $value) {
            $value['fthumb'] = $_W['attachurl'] . $value['fthumb'];
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageUpgoods() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $m_oid = $_GPC['m_oid'];
        $data = array('ifzhifu' => 1);
        $res = pdo_update('hyb_yl_usergoods', $data, array('m_oid' => $m_oid, 'uniacid' => $uniacid));
        return $this->result(0, 'success', $res);
    }
    public function doPageDelmyorder() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $m_oid = $_GPC['m_oid'];
        $res = pdo_delete('hyb_yl_usergoods', array('m_oid' => $m_oid, 'uniacid' => $uniacid));
        return $this->result(0, 'success', $res);
    }
    public function doPageGetalldq() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_csaddress') . "where uniacid='{$uniacid}'");
        foreach ($res as & $value) {
            $diz_id = $value['diz_id'];
            $value['items'] = pdo_fetchall('SELECT * from' . tablename('hyb_yl_duhospital') . "where uniacid='{$uniacid}' and diz_id='{$diz_id}'");
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageSavestime() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $data = array('uniacid' => $_W['uniacid'], 'timearr' => strtotime($_GPC['timearr']), 'content' => $_GPC['content'], 'openid' => $_GPC['openid'], 'xiangmu' => $_GPC['xiangmu'], 'formid' => $_GPC['formid'],);
        $res = pdo_insert('hyb_yl_userdstimes', $data);
        return $this->result(0, 'success', $data);
    }
    public function doPageSelecttx() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $ds_id = $_GPC['ds_id'];
        $res = pdo_fetch('SELECT * from' . tablename('hyb_yl_userdstimes') . "where uniacid='{$uniacid}' and ds_id='{$ds_id}'");
        $res['timearr'] = date('Y-m-d H:i:s', $res['timearr']);
        return $this->result(0, 'success', $res);
    }
    public function doPageAllyzfuwu() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $parid = $_GPC['parid'];
        $res = pdo_fetchall('SELECT * from' . tablename('hyb_yl_yzfuwu') . "where uniacid='{$uniacid}' and parid='{$parid}'");
        foreach ($res as & $value) {
            $value['fthumb'] = $_W['attachurl'] . $value['fthumb'];
            $value['jieshao'] = strip_tags(htmlspecialchars_decode($value['jieshao']));
            $value['taocanm'] = unserialize($value['taocanm']);
            $value['biaoqian'] = explode(',', $value['biaoqian']);
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageAllzzanli() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $parid = $_GPC['parid'];
        $res = pdo_fetchall('SELECT * from' . tablename('hyb_yl_zizhuanl') . "where uniacid='{$uniacid}' and parid='{$parid}'");
        foreach ($res as & $value) {
            $value['hz_thumb'] = $_W['attachurl'] . $value['hz_thumb'];
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageZzhzxq() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['hz_id']);
        $datas = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zizhuanl") . "WHERE hz_id='{$id}' and uniacid ='{$uniacid}'", array(":uniacid" => $uniacid));
        return $this->result(0, 'success', $datas);
    }
    public function doPageWeburl() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);
        $datas = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_fuwu") . "WHERE id='{$id}' and uniacid ='{$uniacid}'", array(":uniacid" => $uniacid));
        return $this->result(0, 'success', $datas);
    }
    public function doPageAlljcxm() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $p_id = intval($_GPC['p_id']);
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_jdxm') . "where p_id='{$p_id}' and uniacid ='{$uniacid}'");
        if (empty($res)) {
            echo "0";
        } else {
            foreach ($res as & $value) {
                $jc_type = $value['jc_type'];
                $p_id = $value['p_id'];
                if ($value['jc_type'] == '0') {
                    $value['jc_type'] = '男方检查';
                    $value['title'] = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_jdxm') . "where uniacid='{$uniacid}' and jc_type='{$jc_type}' and p_id='{$p_id}'");
                }
                if ($value['jc_type'] == '1') {
                    $value['jc_type'] = '女方检查';
                    $value['title'] = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_jdxm') . "where uniacid='{$uniacid}' and jc_type='{$jc_type}' and p_id='{$p_id}'");
                }
                if ($value['jc_type'] == '2') {
                    $value['jc_type'] = '其他';
                    $value['title'] = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_jdxm') . "where uniacid='{$uniacid}' and jc_type='{$jc_type}' and p_id='{$p_id}'");
                }
            }
            return $this->result(0, 'success', $res);
        }
    }
    public function doPageGetjcjg() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $jc_parentid = intval($_GPC['xm_id']);
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_jcjg') . "where uniacid='{$uniacid}' and jc_parentid='{$jc_parentid}'");
        foreach ($res as & $value) {
            $value['jc_danwei'] = unserialize($value['jc_danwei']);
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageUpcforder() {
        require_once dirname(__FILE__) . '/inc/SignatureHelper.php';
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $cid = intval($_GPC['cid']);
        $zid = $_GPC['zid'];
        //更新已经支付
        $res = pdo_update('hyb_yl_recipe', array('state' => 1, 'address' => $_GPC['address'], 'yjfs' => $_GPC['yjfs']), array('uniacid' => $uniacid, 'cid' => $cid));
        if (!empty($zid)) {
            $docpay = pdo_get('hyb_yl_zhuanjia', array('zid' => $_GPC['zid'], 'uniacid' => $uniacid), array('d_txmoney', 'overmoney'));
            $docinfo['time'] = date('Y-m-d H:i:s', time());
            $docnew_arr = $docpay['d_txmoney'] + $_GPC['money'];
            //更新医生总金额
            $zengjia = pdo_update('hyb_yl_zhuanjia', array('d_txmoney' => $docnew_arr, 'overmoney' => $docpay['overmoney'] + $_GPC['money']), array('uniacid' => $uniacid, 'zid' => $zid));
            //新增医生收益订单
            $shouyi = array('uniacid' => $_W['uniacid'], 'z_ids' => $_GPC['zid'], 'funame' => $_GPC['leixing'], 'username' => $_GPC['username'], 'type' => 4, 'symoney' => $_GPC['money'], 'times' => strtotime("now"));
            $upshouy = pdo_insert('hyb_yl_docshouyi', $shouyi);
        }
        //成功后通知管理员
        $params = array();
        $aliduanxin = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_duanxin") . "WHERE uniacid = '{$uniacid}' ", array("uniacid" => $uniacid));
        if ($aliduanxin['stadus'] == 1) {
            $accessKeyId = $aliduanxin['key'];
            $accessKeySecret = $aliduanxin['scret'];
            $params["PhoneNumbers"] = $aliduanxin['tel'];
            $params["SignName"] = $aliduanxin['qianming'];
            $params["TemplateCode"] = $aliduanxin['cfmb'];
            $mtname = $_GPC['username']; //用户
            $docname = $_GPC['docname']; //医生
            $store = $_GPC['ky_yibao']; //订单号
            $times = date('Y-m-d H:i:s', time());
            $params['TemplateParam'] = Array('mtname' => $mtname, 'docname' => $docname, 'store' => $store, 'times' => $times, "product" => "sms");
            if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
                $params["TemplateParam"] = json_encode($params["TemplateParam"]);
            }
            $helper = new SignatureHelper();
            $content = $helper->request($accessKeyId, $accessKeySecret, "dysmsapi.aliyuncs.com", array_merge($params, array("RegionId" => "cn-hangzhou", "Action" => "SendSms", "Version" => "2017-05-25",)));
        }
        return $this->result(0, 'success', $content);
    }
    public function doPageSavejcjg() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $erjid = $_GPC['erjid'];
        $values = $_GPC['val'];
        $openid = $_GPC['jxopenid'];
        $jcxid = $_GPC['jcx_id2'];
        $xm_id = $_GPC['xm_id'];
        //var_dump($jcxid);
        $array2 = htmlspecialchars_decode($values);
        $duox = json_decode($array2);
        $msg = json_decode(json_encode($duox), true);
        $data = array('uniacid' => $uniacid, 'contents' => serialize($msg), 'jxopenid' => $openid, 'erjid' => $erjid, 'duox' => $_GPC['duox'], 'xm_id' => $_GPC['xm_id']);
        if (!empty($jcxid)) {
            // echo "string";
            $res = pdo_update('hyb_yl_hzjcglb', $data);
            $jcx_id = $jcxid;
        } else {
            //echo "1231";
            $res = pdo_insert('hyb_yl_hzjcglb', $data);
            $jcx_id = pdo_insertid();
        }
        return $this->result(0, 'success', $jcx_id);
    }
    public function doPageGetdatajcjg() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $jcx_id = $_GPC['jcx_id'];
        $res = pdo_get('hyb_yl_hzjcglb', array('jcx_id' => $jcx_id, 'uniacid' => $uniacid));
        $res['contents'] = unserialize($res['contents']);
        return $this->result(0, 'success', $res);
    }
    public function doPageGtonly() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $xm_id = $_GPC['xm_id'];
        $erjid = $_GPC['erjid'];
        //var_dump($xm_id,$erjid,$_GPC['jxopenid']);
        $res = pdo_get('hyb_yl_hzjcglb', array('erjid' => $erjid, 'uniacid' => $uniacid, 'jxopenid' => $_GPC['jxopenid'], 'xm_id' => $_GPC['xm_id']));
        //$res['contents']=unserialize($res['contents']);
        return $this->result(0, 'success', $res);
    }
    public function doPageTongzhidoc() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['zid'];
        $money = $_GPC['money'];
        $ky_yibao = $_GPC['ky_yibao'];
        $username = $_GPC['username'];
        $ordername = "患者" . $username . "完成了处方支付";
        $paytime = date('Y-m-d H:i:s', time());
        //1.查询信息配置
        $wxappaid = pdo_get('hyb_yl_parameter', array('uniacid' => $uniacid));
        //2.查询微信模板
        $wxapptemp = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid));
        //3.获取appid and appsecret
        $appid = $wxappaid['appid'];
        $appsecret = $wxappaid['appsecret'];
        //4.获取模板
        $template_id = $wxapptemp['paymobel'];
        $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $getArr = array();
        $tokenArr = json_decode($this->send_post($tokenUrl, $getArr, "GET"));
        $access_token = $tokenArr->access_token;
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
        $res = pdo_get('hyb_yl_zhuanjia', array('zid' => $zid, 'uniacid' => $uniacid));
        $openid = $res['openid'];
        $user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
        foreach ($user_curr as $key => $value) {
            $out_time = strtotime('-7 days', time());
            $formids = unserialize($value['form_id']);
            foreach ($formids as $k => $v) {
                if ($out_time >= $v['form_time']) {
                    unset($formids[$k]);
                }
            }
            $formids = array_values($formids);
            $form_id = $formids[0]['form_id'];
            $dd['form_id'] = $form_id;
            $dd['touser'] = $value['openid'];
            $content = array("keyword1" => array("value" => $ordername, "color" => "#4a4a4a"), "keyword2" => array("value" => $money, "color" => ""), "keyword3" => array("value" => $paytime, "color" => ""), "keyword4" => array("value" => $ky_yibao, "color" => ""),);
            $dd['template_id'] = $template_id;
            $dd['page'] = 'hyb_yl/tabBar/index/index'; //跳转医生id 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
            $dd['data'] = $content; //模板内容，不填则下发空模板
            $dd['color'] = ''; //模板内容字体的颜色，不填默认黑色
            $dd['emphasis_keyword'] = ''; //模板需要放大的关键词，不填则默认无放大
            $result1 = $this->https_curl_json($url, $dd, 'json');
            foreach ($formids as $k => $v) {
                if ($form_id == $v['form_id']) {
                    unset($formids[$k]);
                }
            }
            // var_dump($result1);
            $new_formids = array_values($formids);
            $datas['form_id'] = serialize($new_formids);
            pdo_update('hyb_yl_userinfo', $datas, array('u_id' => $value['u_id']));
        }
    }
    public function doPageZhuanjshouymx() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['zid'];
        //查询专家处方收益
        $chufang = pdo_fetch("SELECT SUM(symoney) AS `chufmoney` FROM " . tablename("hyb_yl_docshouyi") . " where `z_ids`='{$zid}'  and uniacid = '{$uniacid}' AND type=4");
        //查询专家预约收益
        $yuyue = pdo_fetch("SELECT SUM(symoney) AS `yymoney` FROM " . tablename("hyb_yl_docshouyi") . " where `z_ids`='{$zid}'  and uniacid = '{$uniacid}' AND type=2");
        //付费问答收益
        $fufei = pdo_fetch("SELECT SUM(symoney) AS `fufeimoney` FROM " . tablename("hyb_yl_docshouyi") . " where `z_ids`='{$zid}'  and uniacid = '{$uniacid}' AND type=0");
        //发布问答
        $fabu = pdo_fetch("SELECT SUM(`symoney`) AS `fabumoney` FROM " . tablename("hyb_yl_docshouyi") . " where `z_ids`='{$zid}'  and uniacid = '{$uniacid}' AND type=3 ");
        $info = array(array('name' => '处方收益', 'rmb' => $chufang['chufmoney'], 'types' => 4), array('name' => '预约收益', 'rmb' => $yuyue['yymoney'], 'types' => 2), array('name' => '付费问答收益', 'rmb' => $fufei['fufeimoney'], 'types' => 0), array('name' => '发布问答收益', 'rmb' => $fabu['fabumoney'], 'types' => 3));
        echo json_encode($info);

    }
    public function doPageFuwuorder() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $type = $_GPC['types'];
        $z_ids = $_GPC['zid'];
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_docshouyi') . "where uniacid ='{$uniacid}' AND type ='{$type}' AND z_ids='{$z_ids}' ORDER by sy_id desc");
        foreach ($res as & $value) {
            $value['times'] = date('Y-m-d H:i:s', $value['times']);
        }
        echo json_encode($res);
    }
    public function doPagePaywexdocmb() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['zid'];
        //查用户姓名
        $my_id = $_GPC['my_id'];
        $user = pdo_get('hyb_yl_myinfors', array('my_id' => $my_id, 'uniacid' => $uniacid));
        $username = $user['myname'];
        $myphone = $user['myphone'];
        $paytime = $_GPC['tttime'] . '患者预约了您';
        //1.查询信息配置
        $wxappaid = pdo_get('hyb_yl_parameter', array('uniacid' => $uniacid));
        //2.查询微信模板
        $wxapptemp = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid));
        //3.获取appid and appsecret
        $appid = $wxappaid['appid'];
        $appsecret = $wxappaid['appsecret'];
        //4.获取模板
        $template_id = $wxapptemp['kzyytongz'];
        $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $getArr = array();
        $tokenArr = json_decode($this->send_post($tokenUrl, $getArr, "GET"));
        $access_token = $tokenArr->access_token;
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
        $res = pdo_get('hyb_yl_zhuanjia', array('zid' => $zid, 'uniacid' => $uniacid));
        $openid = $res['openid'];
        $user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
        foreach ($user_curr as $key => $value) {
            $out_time = strtotime('-7 days', time());
            $formids = unserialize($value['form_id']);
            foreach ($formids as $k => $v) {
                if ($out_time >= $v['form_time']) {
                    unset($formids[$k]);
                }
            }
            $formids = array_values($formids);
            $form_id = $formids[0]['form_id'];
            $dd['form_id'] = $form_id;
            $dd['touser'] = $value['openid'];
            $content = array("keyword1" => array("value" => $username, "color" => "#4a4a4a"), "keyword2" => array("value" => $myphone, "color" => ""), "keyword3" => array("value" => $paytime, "color" => ""),);
            $dd['template_id'] = $template_id;
            $dd['page'] = 'hyb_yl/userLife/pages/huanzheyuyue/huanzheyuyue?id=' . $zid; //跳转医生id 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
            $dd['data'] = $content; //模板内容，不填则下发空模板
            $dd['color'] = ''; //模板内容字体的颜色，不填默认黑色
            $dd['emphasis_keyword'] = ''; //模板需要放大的关键词，不填则默认无放大
            $result1 = $this->https_curl_json($url, $dd, 'json');
            foreach ($formids as $k => $v) {
                if ($form_id == $v['form_id']) {
                    unset($formids[$k]);
                }
            }
            // var_dump($result1);
            $new_formids = array_values($formids);
            $datas['form_id'] = serialize($new_formids);
            pdo_update('hyb_yl_userinfo', $datas, array('u_id' => $value['u_id']));
        }
        // return $this->result(0, 'success', $zid);
        
    }
    public function doPageIflpkg() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $res = pdo_get('hyb_yl_likaiguan', array('uniacid' => $_W['uniacid']));
        if ($res['liptype'] == 0) {
            echo "0";
        } else {
            echo "1";
        }
    }
    public function doPageUpshare() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $value = htmlspecialchars_decode($_GPC['sharepic']);
        $array = json_decode($value);
        $object = json_decode(json_encode($array), true);
        $contents = $_GPC['contents'];
        $openid = $_GPC['openid'];
        $data = array('uniacid' => $uniacid, 'openid' => $openid, 'sharepic' => serialize($object), 'contents' => $contents,'times'=>strtotime("now"));
        $res = pdo_insert('hyb_yl_share', $data);
        return $this->result(0, 'success', $res);
    }
    public function doPageAllshare() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $res = pdo_fetchall('SELECT * from' . tablename('hyb_yl_share') . "as a left join." . tablename('hyb_yl_userinfo') . "as b on b.openid = a.openid where a.uniacid ='{$uniacid}' ORDER by a.a_id desc ");
        foreach ($res as & $value) {
            $value['sharepic'] = unserialize($value['sharepic']);
            $value['times'] = date('Y-m-d H:i:s', $value['times']);
            $num = count($value['sharepic']);
            for ($i = 0;$i < $num;$i++) {
                $value['sharepic'][$i] = $_W['attachurl'] . $value['sharepic'][$i];
            }
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageDatainfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $a_id = $_GPC['a_id'];
        $res = pdo_fetch('SELECT * from' . tablename('hyb_yl_share') . "as a left join." . tablename('hyb_yl_userinfo') . "as b on b.openid = a.openid where a.uniacid ='{$uniacid}' AND a.a_id='{$a_id}'");
        $res['sharepic'] = unserialize($res['sharepic']);
        $res['times'] = date('Y-m-d H:i:s', $res['times']);
        $num = count($res['sharepic']);
        for ($i = 0;$i < $num;$i++) {
            $res['sharepic'][$i] = $_W['attachurl'] . $res['sharepic'][$i];
        }
        
        return $this->result(0, 'success', $res);
    }
    public function doPageAllfenlgoods() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $fid = $_GPC['fid'];
        $fenl = pdo_fetchall('SELECT * FROM ' . tablename('hyb_yl_goodsfenl') . "where uniacid = '{$uniacid}'");
        $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_goodsarr') . "WHERE uniacid = '{$uniacid}' AND spfenlei ='{$fid}'");
        foreach ($res as $key => $value) {
            $res[$key]['sthumb'] = $_W['attachurl'] . $res[$key]['sthumb'];
        }
        $data = array('fenli' => $fenl, 'flgoods' => $res);
        echo json_encode($data);
    }
    public function doPageGoodshoping() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $sid = $_GPC['sid'];
        $res = pdo_get('hyb_yl_goodsarr', array('uniacid' => $uniacid, 'sid' => $sid));
        $res['spic'] = unserialize($res['spic']);
        $res['sfbtime'] = date('Y-m-d H:i:s', $res['sfbtime']);
        $re1 = htmlspecialchars_decode($res['scontent']);
        $url = 'https://'.$_SERVER['HTTP_HOST'];
        $num = count($res['spic']);
        for ($i = 0;$i < $num;$i++) {
            $res['spic'][$i] = $_W['attachurl'] . $res['spic'][$i];
        }
        $data = array('item' => $res,'contents'=>$re1,'url'=>$url);
        echo json_encode($data);
    }
    public function doPageSavedocteam() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $t_id= $_GPC['t_id'];
        $data = array('uniacid' => $uniacid, 'teamname' => $_GPC['teamname'], 'teamaddress' => $_GPC['teamaddress'], 'teamtext' => $_GPC['teamtext'], 'teamtype' => $_GPC['teamtype'], 'teampic' => $_GPC['teampic'], 'zid' => $_GPC['zid'],'cltime'=>strtotime('now'));
        if(empty($_GPC['t_id'])){
         $res = pdo_insert('hyb_yl_zhuanjteam', $data);
        }else{
         $res = pdo_update('hyb_yl_zhuanjteam', $data,array('uniacid'=>$uniacid,'t_id'=>$t_id));
        }

      
        return $this->result(0, 'success', $t_id);
    }

    public function doPageSelectteaminfo() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $teamtype = $_GPC['teamtype'];
        $t_id = $_GPC['t_id'];
        $zid= $_GPC['zid'];
        $res = pdo_get('hyb_yl_zhuanjteam', array('uniacid' => $uniacid, 't_id' => $t_id));
        $res['teampic1'] =  $res['teampic'];
        $res['teampic'] = $_W['attachurl'] . $res['teampic'];

        if($res['zid'] ==$zid){
          $res['managerRole'] =1; 
          $res['type']=1;
        }
        return $this->result(0, 'success', $res);
    }
    public function doPageSaveshoushu() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op =$_GPC['op'];
        $sid =$_GPC['sid'];
        $idarr = htmlspecialchars_decode($_GPC['sthumb']);
        $array = json_decode($idarr);
        $object = json_decode(json_encode($array), true);
        $idarr2 = htmlspecialchars_decode($_GPC['spic']);
        $array2 = json_decode($idarr2);
        $spic = json_decode(json_encode($array2), true);
        $data = array('uniacid' => $_W['uniacid'], 'sname' => $_GPC['sname'], 'stext' => $_GPC['stext'], 'smoney' => $_GPC['smoney'], 'zid' => $_GPC['zid'], 'sthumb' => serialize($object), 'tjtime' => strtotime("now"), 'spic' => serialize($spic), 'stype' => $_GPC['stype'], 'suoltu' => $_GPC['suoltu']);
        if($op =='add'){
          $res = pdo_insert('hyb_yl_docshoushu', $data);
        }
        if($op =='update'){
          $res = pdo_update("hyb_yl_docshoushu",$data,array('sid'=>$sid));
        }
        
        return $this->result(0, 'success', $res);
    }



    public function doPageInfofuwu() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $sid = $_GPC['sid'];
        $res = pdo_get('hyb_yl_docshoushu', array('uniacid' => $uniacid, 'sid' => $sid));
        $res1 = pdo_get('hyb_yl_docshoushu', array('uniacid' => $uniacid, 'sid' => $sid));
        $res1['spic'] = unserialize($res1['spic']);
        $res1['sthumb'] = unserialize($res1['sthumb']);
        $res1['suoltu'] = $res1['suoltu'];
        $res['spic'] = unserialize($res['spic']);
        $res['sthumb'] = unserialize($res['sthumb']);
        $num = count($res['spic']);
        $num1 = count($res['sthumb']);
        for ($i = 0;$i < $num;$i++) {
            $res['spic'][$i] = $_W['attachurl'] . $res['spic'][$i];
        }
        for ($i = 0;$i < $num1;$i++) {
            $res['sthumb'][$i] = $_W['attachurl'] . $res['sthumb'][$i];
        }
        $data = array(
            'suoltu' => $_W['attachurl'] . $res['suoltu'], 
            'servicebBox' => array(
                'img' => $res['sthumb'], 
                'imgs' => $res['spic'],
                ), 
            'info' => $res,
            'spic1'=>$res1['spic'],
            'suoltu1'=>$res1['suoltu'],
            'img1'=>$res1['sthumb']
            );

        echo json_encode($data);
        //return $this->result(0,'success',$res);
        
    }
    public function doPageKaitongfw() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $sid = $_GPC['sid'];
        $skaig = $_GPC['skaig'];
        $res = pdo_update('hyb_yl_docshoushu', array('skaig' => $skaig), array('uniacid' => $uniacid, 'sid' => $sid));
        echo json_encode($res);
    }
    public function doPageSaveteam() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        if ($_GPC['state'] == true) {
            $state = 1;
        } else {
            $state = 0;
        }
        $idarr = htmlspecialchars_decode($_GPC['thumbarr']);
        $array = json_decode($idarr);
        $object = json_decode(json_encode($array), true);
        $data = array('uniacid' => $uniacid, 'title' => $_GPC['title'], 'teamtext' => $_GPC['teamtext'], 'thumbarr' => serialize($object), 't_id' => $_GPC['t_id'], 'menttypes' => $state, 'updateTime' => strtotime("now"));
        $res = pdo_insert('hyb_yl_teamment', $data);
        echo json_encode($res);
    }

    public function doPageAllmyshare() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $op = $_GPC['op'];
        if ($op == 'display') {
            $res = pdo_fetchall('SELECT * from' . tablename('hyb_yl_share') . "as a left join." . tablename('hyb_yl_userinfo') . "as b on b.openid = a.openid where a.uniacid ='{$uniacid}' AND a.openid='{$openid}' ORDER by a.a_id desc ");
            foreach ($res as & $value) {
                $value['sharepic'] = unserialize($value['sharepic']);
                $value['times'] = date('Y-m-d H:i:s', $value['times']);
                $num = count($value['sharepic']);
                for ($i = 0;$i < $num;$i++) {
                    $value['sharepic'][$i] = $_W['attachurl'] . $value['sharepic'][$i];
                }
            }
            echo json_encode($res);
        }
    }
    public function doPageNowshare() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $a_id = $_GPC['a_id'];
        $openid = $_GPC['openid'];
        $res = pdo_get('hyb_yl_share', array('uniacid' => $uniacid, 'a_id' => $a_id));
        if ($openid == $res['openid']) {
            $author = 1;
        } else {
            $author = 0;
        }
        echo json_encode($author);
    }
    public function doPageYdfenzu(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $fenzuid =intval($_GPC['fenzuid']);
        $data = array(
         'fenzuid'=>$fenzuid
            );
        $rows = pdo_update("hyb_yl_collect",$data,array('uniacid' => $uniacid, 'id' =>$id));
 
        if($rows==1){
          echo '1';
         }else{
           echo '0';  
        }
    }

     public function doPageUpdoczt(){
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $zid = $_GPC['zid'];
        $data =array(
            'gbyuanyin'=>$_GPC['gbyuanyin'],
            'gzstype'  =>$_GPC['gzstype']
            );
        $res =pdo_update("hyb_yl_zhuanjia",$data,array('zid'=>$zid,'uniacid'=>$uniacid));
        echo json_encode($res);
     }
   public function doPageMyswitch1Change(){
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $my_id =$_GPC['my_id'];
        $op =$_GPC['op'];
        if($op =='display'){
            $res =pdo_get('hyb_yl_myinfors',array('my_id'=>$my_id,'uniacid'=>$uniacid));
            echo json_encode($res);
        }
        if($op =='post'){
            $my_id =$_GPC['my_id'];
            $data=array(
               'mydatype'=>$_GPC['mydatype']
                );
            $res =pdo_update("hyb_yl_myinfors",$data,array('my_id'=>$my_id,'uniacid'=>$uniacid));
            echo json_encode($res);
        }
   }
     public function doPageIfquespay(){
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $qid =$_GPC['qid'];
        $openid =$_GPC['openid'];
        $res = pdo_get("hyb_yl_goodsinfo",array('uniacid'=>$uniacid,'openid'=>$openid,'qid'=>$qid));
        if(empty($res)){
            echo '0';
        }else{
            echo '1';
        }
     }
     public function doPageHyzhuce(){
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $res = pdo_get("hyb_yl_hyzhucesite",array('uniacid'=>$uniacid));
        if(empty($res)){
            echo '0';
        }else{
            if($res['hy_type'] ==0){
               echo '0';
            }else{
               echo '1';
            }
        }
     }
    public function doPageUserfuwuadd() {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['zy_openid'];
        $rnd = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $data = array('uniacid' => $uniacid, 'z_yy_money' => $_REQUEST['z_yy_money'], 'openid' => $_REQUEST['openid'], 'zid' => $_REQUEST['zid'], 'my_id' => $_REQUEST['my_id'], 'stype' => $_REQUEST['stype'], 'sid' => $_REQUEST['sid'], 'zy_time' => time(), 'orderid' => $rnd, 'tttime' => $_GPC['tttime'], 'week' => $_GPC['week']);
        $pdoselect = pdo_insert('hyb_yl_fuwuyuyuelist', $data, array('uniacid' => $uniacid));
        return $this->result(0, "success", $pdoselect);
    }
   public function doPageBinrinfo(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];
    $openid = $_GPC['openid'];

    //hyb_yl_chat_msgand m_id in(select max(m_id) from" . tablename('hyb_yl_chat_msg')
    $res = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_chat_msg").'as a left join '.tablename("hyb_yl_myinfors")."as b on a.f_id = b.openid WHERE a.uniacid ='{$uniacid}' and a.f_id ='{$openid}' and a.m_id in(select max(a.m_id) from".tablename('hyb_yl_chat_msg').")");

    $tmpStr = json_encode($res['t_msg']); //暴露出unicode
    $tmpStr1 = preg_replace_callback('/\\\\\\\\/i', function ($a) {
        return '\\';
    }, $tmpStr); //将两条斜杠变成一条，其他不动
    $res['t_msg'] = str_replace('"','',json_decode($tmpStr1));
    echo json_encode($res);
   }

   public function doPageBinrinfowen(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];
    $openid = $_GPC['openid'];
    //hyb_yl_chat_msgand m_id in(select max(m_id) from" . tablename('hyb_yl_chat_msg')
    $res = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_chat_msg_wz").'as a left join '.tablename("hyb_yl_myinfors")."as b on a.f_id = b.openid WHERE a.uniacid ='{$uniacid}' and a.f_id ='{$openid}' or a.t_id ='{$openid}'  and a.m_id in(select max(a.m_id) from".tablename('hyb_yl_chat_msg').")");

    $tmpStr = json_encode($res['t_msg']); //暴露出unicode
    $tmpStr1 = preg_replace_callback('/\\\\\\\\/i', function ($a) {
        return '\\';
    }, $tmpStr); //将两条斜杠变成一条，其他不动
    $res['t_msg'] = str_replace('"','',json_decode($tmpStr1));
    echo json_encode($res);
   }
   public function doPageJieshuzix(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];
    $m_id = $_GPC['m_id'];
    $res = pdo_update("hyb_yl_chat_msg",array('if_over'=>1),array('m_id'=>$m_id));
    echo json_encode($res);
   }
   public function doPageGetcitywd(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];
    $city =$_GPC['city'];
    $base = pdo_get("hyb_yl_bace",array('uniacid'=>$uniacid));
    $key =  $base['baidukey'];  
    $url = "http://api.map.baidu.com/geocoder?address=$city&output=json&key=$key";
    $result = file_get_contents($url);
    $json = json_decode($result,true); 
    $var = $json['result']['location'];
    echo json_encode($var);
   }
   public function doPageKfuid(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];
    $res = pdo_get("hyb_yl_zhuanjia",array('uniacid'=>$uniacid,'z_shenfengzheng'=>1));
    echo json_encode($res);
   }
   public function doPageUserjrinfo(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];
    $j_id =$_GPC['j_id'];
    $res = pdo_get("hyb_yl_userjiaren",array('uniacid'=>$uniacid,'j_id'=>$j_id));
    echo json_encode($res);
   }
 public function doPageSerchzhi(){
        global $_W,$_GPC;
        header('content-type: text/html;charset=utf-8');
        $uniacid =$_W['uniacid'];
        $keywords =$_GPC['keywords'];
        $so = scws_new(); 
        $so->set_charset('utf8'); 
        // 这里没有调用 set_dict 和 set_rule 系统会自动试调用 ini 中指定路径下的词典和规则文件 
        $so->add_dict(ini_get('scws.default.fpath') . '/dict.utf8.xdb');
        $so->set_rule(ini_get('scws.default.fpath') . '/rules.utf8.ini'); 
        $so->set_duality(0);  //散字二元 
        $so->set_ignore(0); //忽略标点符号
        $so->set_multi(0);
        $so->send_text($keywords);
        $data=array();
        while ($tmp = $so->get_result())
        {
              $data[]=$tmp;

        }
        $so->close();
          foreach ($data as $key=>$value) {
              foreach($value as $k=>$v){
                 $kewordfenci = str_replace(',','w',$v['word']);
                 $kew = explode(',', $kewordfenci);
                 foreach ($kew as $key1 => $value1) {
                   $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_zhuanjia")."WHERE uniacid='{$uniacid}' and z_zhenzhi LIKE '%{$value1}%' "); 
                  foreach ($res as &$value2) {
                        $result['errno'] = 1;
                        $result['message'] = '操作失败 : 没有找到指定ID';
                        message($res, '', 'ajax');
                  }
              }
          }
      }
  }
  public function doPagePeisong()
  {
    global $_GPC,$_W;
    $uniacid = $_W['uniacid'];
    $op = $_GPC['op'];
    $res =pdo_fetchall("SELECT * FROM".tablename('hyb_yl_peisong')."where uniacid ='{$uniacid}'");
    echo json_encode($res);
  }
   public function doPageAddlmyuyue(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];
    $openid =$_GPC['openid'];
    $rnd = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    $data = array(
                  'uniacid' => $uniacid,
                  'keshi' =>$_REQUEST['keshi'],
                  'us_name' => $_REQUEST['us_name'],
                  'sex' => $_REQUEST['sex'],
                  'age' => $_REQUEST['age'],
                  'phone' => $_REQUEST['phone'],
                  'time' => $_REQUEST['time'],
                  'title_content' =>$_REQUEST['title_content'],
                  'lm_pid' => $_REQUEST['lm_pid'],
                  'times' => strtotime("now"),
                  'orders' =>  $rnd,
                  'paymoney' =>$_REQUEST['paymoney'],
                  'openid' => $_REQUEST['openid'],
                  'paystate' => $_REQUEST['paystate'],
                 );
    $pdoselect = pdo_insert('hyb_yl_lmyuyue', $data, array('uniacid' => $uniacid));

    echo json_encode($pdoselect);
   }
   public function doPagePinglun(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];  
    $sid =$_GPC['sid'];
    $res = pdo_fetchall("SELECT * FROM".tablename('hyb_yl_plsite')."where uniacid='{$uniacid}' and sid ='{$sid}' order by createTime desc limit 5");
    //查询
    foreach ($res as $key => $value) {
       $res[$key]['createTime'] =date('Y-m-d',$res[$key]['createTime']);
       $res[$key]['star'] =intval($res[$key]['star']);

    }
       echo json_encode($res);
   }
   public function doPagePinglun2(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];  
    $sid =$_GPC['sid'];
    $res = pdo_fetchall("SELECT * FROM".tablename('hyb_yl_plsite')."where uniacid='{$uniacid}' and sid ='{$sid}' order by createTime desc");
    foreach ($res as $key => $value) {
       $res[$key]['createTime'] =date('Y-m-d',$res[$key]['createTime']);
       $res[$key]['star'] =intval($res[$key]['star']);
    }
       echo json_encode($res);
   }
   public function doPageMygoodshoping(){
    global $_W,$_GPC;
    $uniacid =$_W['uniacid'];  
    $spid =$_GPC['spid'];
    $res = pdo_fetch("SELECT * FROM".tablename('hyb_yl_shopgoods')."as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid WHERE a.spid=:spid and a.uniacid=:uniacid",array(':spid'=>$spid,':uniacid'=>$uniacid));
     $res['sthumb'] =$_W['attachurl'].$res['sthumb'];
       echo json_encode($res);
   }
}
