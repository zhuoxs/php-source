<?php
defined('IN_IA') or exit('Access Denied');
//通知患者医生已经回复
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$user_openid = $_GPC['user_openid'];
$z_name = $_GPC['z_name'];
$question = $_GPC['question'];
$paytime = date('Y-m-d H:i:s', time());
//1.查询信息配置
$wxappaid = pdo_get('hyb_yl_parameter', array('uniacid' => $uniacid));
//2.查询微信模板
$wxapptemp = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid));
//3.获取appid and appsecret
$appid = $wxappaid['appid'];
$appsecret = $wxappaid['appsecret'];
//4.获取模板
$template_id = $wxapptemp['tixuser'];
$tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
$getArr = array();
$tokenArr = json_decode(send_post($tokenUrl, $getArr, "GET"));
$access_token = $tokenArr->access_token;
$url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
$res = pdo_get('hyb_yl_zhuanjia', array('zid' => $zid, 'uniacid' => $uniacid));
$user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $user_openid));
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
    $content = array(
    	"keyword1" => array(
    		"value" => $question, 
    		"color" => "#4a4a4a"
    		), 
    	"keyword2" => array(
    		"value" => $z_name, 
    		"color" => ""
    		), 
    	"keyword3" => array(
    		"value" => $paytime, 
    		"color" => ""
    		)
    	);
    $dd['template_id'] = $template_id;
    $dd['page'] = 'hyb_yl/mysubpages/pages/wodetiwen/wodetiwen?openid='.$user_openid; //点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
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
 function send_post($url, $post_data,$method='POST') {
    $postdata = http_build_query($post_data);
    $options = array(
      'http' => array(
        'method' => $method, //or GET
        'header' => 'Content-type:application/x-www-form-urlencoded',
        'content' => $postdata,
        'timeout' => 15 * 60 // 超时时间（单位:s）
      )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
  }
