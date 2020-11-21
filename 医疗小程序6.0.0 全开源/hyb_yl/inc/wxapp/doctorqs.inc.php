<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$user_picture = $_GPC['user_picture'];
$arr1 = explode(';', $user_picture);
$zid = $_GPC['p_id'];
$doctor_openid = $_REQUEST['savant_openid'];
$us_openid = $_GPC['user_openid'];
$data['uniacid'] = $_W['uniacid'];
$data['question'] = $_GPC['question'];
$data['user_openid'] = $_GPC['user_openid'];
$data['savant_openid'] = $_GPC['savant_openid'];
$data['user_payment'] = $_GPC['user_payment'];
$data['sj_type'] = $_GPC['sj_type'];
$data['p_id'] = $_GPC['p_id'];
$data['q_username'] = $_GPC['q_username'];
$data['q_thumb'] = $_GPC['q_thumb'];
$data['user_picture'] = serialize($arr1);
$data['q_docthumb'] = $_GPC['q_docthumb'];
$data['q_zhiwei'] = $_GPC['q_zhiwei'];
$data['q_dname'] = $_GPC['q_dname'];
$data['h_pic'] = $_REQUEST['h_pic'];
$data['fromuser'] = $_REQUEST['fromuser'];
$data['usertype'] = 0;
$data['q_time'] = date('Y-m-d H:i:s');
$data['q_category'] = $_GPC['q_category'];
$data['tw_num'] = $_GPC['tw_num'];
$data['tiwenlx'] = $_GPC['tiwenlx'];
$data['dttjtime'] =strtotime('now');
$leixing['leixing'] = $_GPC['leixing'];
$leixing['time'] = date('Y-m-d H:i:s', time());
$leixing['name'] = $_GPC['name'];
$leixing['pay'] = $_GPC['pay'];

$member = pdo_get('hyb_yl_mymoney', array('use_openid' => $us_openid, 'uniacid' => $uniacid));
if ($member['countmoney'] == '') {
    $arr = array();
} else {
    $arr = unserialize($member['countmoney']);
}
array_push($arr, $leixing);
$new_arr = serialize($arr);
$data1 = array('uniacid' => $uniacid, 'countmoney' => $new_arr, 'use_openid' => $us_openid);
if ($member['countmoney'] == '') {
    $ret = pdo_insert('hyb_yl_mymoney', $data1);
} else {
    $ret = pdo_update('hyb_yl_mymoney', array('countmoney' => $new_arr, 'use_openid' => $us_openid), array('id' => $member['id'], 'uniacid' => $uniacid));
}
$res = pdo_insert('hyb_yl_question', $data);
$qid = pdo_insertid();
//更新当天的所有提问记录的提问次数
$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));//当天开始时间戳
$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;//当天结束时间戳
$dangtinres = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_question")."where uniacid=:uniacid and dttjtime >='{$beginToday}' and dttjtime<='{$endToday}' ",array("uniacid"=>$uniacid));
$tw_num =$_GPC['tw_num'];
if($dangtinres){
  //如果存在就更新
    foreach ($dangtinres as &$value) {
        $qid =$value['qid'];
        pdo_update("hyb_yl_question",array('tw_num'=>$tw_num),array('uniacid'=>$uniacid,'qid'=>$qid));
    }
}
//更新优惠券
$lid = $_GPC['lid'];
$yhqdate =array(
  'types'=>1
 );
pdo_update("hyb_yl_lingquyouhuiq",$yhqdate,array('lid'=>$lid,'uniacid'=>$uniacid));
$user = pdo_get('hyb_yl_userinfo', array('uniacid' => $uniacid, 'openid' => $us_openid));
//发送模板消息给医生
//1.查询信息配置
$wxappaid = pdo_get('hyb_yl_parameter', array('uniacid' => $uniacid));
//2.查询微信模板
$wxapptemp = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid));
//3.获取appid and appsecret
$appid = $wxappaid['appid'];
$appsecret = $wxappaid['appsecret'];
//4.获取模板
$template_id = $wxapptemp['weidbb'];
$tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
$getArr = array();
$tokenArr = json_decode(send_post($tokenUrl, $getArr, "GET"));
$access_token = $tokenArr->access_token;
$url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
//5.查询当前医生formid
$member = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_userinfo') . "where uniacid='{$uniacid}' and  openid='{$doctor_openid}'");
//1专家ID 2.用户openid 2.问题ID
foreach ($member as $key => $value) {
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
    $content = array("keyword1" => array("value" => $_GPC['question'], "color" => "#4a4a4a"), "keyword2" => array("value" => $user['u_name'], "color" => ""), "keyword3" => array("value" => date('Y-m-d H:i:s', time()), "color" => ""),);
    $dd['template_id'] = $template_id;
    $dd['page'] = 'hyb_yl/userLife/pages/zhuan_da/zhuan_da?zid=' . $zid . '&user_openid=' . $us_openid . '&qid=' . $qid;
    $dd['data'] = $content; //模板内容，不填则下发空模板
    $dd['color'] = ''; //模板内容字体的颜色，不填默认黑色
    $dd['emphasis_keyword'] = ''; //模板需要放大的关键词，不填则默认无放大
    $result1 = https_curl_json($url, $dd, 'json');
    foreach ($formids as $k => $v) {
        if ($form_id == $v['form_id']) {
            unset($formids[$k]);
        }
    }
    $new_formids = array_values($formids);
    $datas['form_id'] = serialize($new_formids);
    pdo_update('hyb_yl_userinfo', $datas, array('u_id' => $value['u_id']));
   
}
if ($res) {
    $del = pdo_delete("hyb_yl_upload_img", array("i_openid" => $us_openid, "i_type" => 1));
    $rowsmymoney = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_mymoney') . "where `use_openid`='{$doctor_openid}' and uniacid = '{$uniacid}' ", array('uniacid' => $uniacid));
}
//查询我的总消费
$userpay = pdo_get('hyb_yl_userinfo', array('openid' => $us_openid), array('u_xfmoney', 'u_id', 'u_name'));
$data = array('u_xfmoney' => $userpay['u_xfmoney'] + $leixing['pay']);
$upuser = pdo_update('hyb_yl_userinfo', $data, array('uniacid' => $uniacid, 'u_id' => $userpay['u_id']));
if ($upuser) {
    if (!empty($zid)) {
        $docpay = pdo_get('hyb_yl_zhuanjia', array('zid' => $_GPC['zid'], 'uniacid' => $uniacid), array('d_txmoney', 'overmoney'));
        $docinfo['time'] = date('Y-m-d H:i:s', time());
        $docnew_arr = $docpay['d_txmoney'] + $leixing['pay'];
        //更新医生总金额
        $zengjia = pdo_update('hyb_yl_zhuanjia', array('d_txmoney' => $docnew_arr, 'overmoney' => $docpay['overmoney'] + $docpay['d_txmoney'] + $leixing['pay']), array('uniacid' => $uniacid, 'zid' => $zid));
        //新增医生收益订单
        $shouyi = array('uniacid' => $_W['uniacid'], 'z_ids' => $_GPC['zid'], 'funame' => $_GPC['leixing'], 'username' => $userpay['u_name'], 'type' => 0, 'symoney' => $_GPC['pay'], 'times' => strtotime("now"));
        $upshouy = pdo_insert('hyb_yl_docshouyi', $shouyi);
    }
}



function https_curl_json($url, $data, $type) {
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
function send_post($url, $post_data, $method = 'POST') {
        $postdata = http_build_query($post_data);
        $options = array('http' => array('method' => $method, //or GET
        'header' => 'Content-type:application/x-www-form-urlencoded', 'content' => $postdata, 'timeout' => 15 * 60 // 超时时间（单位:s）
        ));
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

