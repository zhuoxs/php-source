<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/9/29
 * Time: 17:10
 */

defined('IN_IA') or exit('Access Denied');

/**
 * 给用户发送支付成功推送信息
 * @param $orderData    订单信息
 * @param $prepay_id    支付成功formid
 * @param $touser       用户openid
 * @param $uniacid      小程序唯一标志
 * @param $page         链接地址
 */
function send_msg_to_user($orderData,$prepay_id,$touser,$uniacid,$page){
    $wxData=pdo_get('cqkundian_farm_wx_set',array('uniacid'=>$uniacid));
    $account_api = WeAccount::create();
    $access_token=$account_api->getAccessToken();
    $value = array(
        "keyword1"=>array(
            "value"=>$orderData['body'],
            "color"=>"#4a4a4a"
        ),
        "keyword2"=>array(
            "value"=>date("Y-m-d H:i:s",$orderData['create_time']),
            "color"=>"#9b9b9b"
        ),
        "keyword3"=>array(
            "value"=>$orderData['total_price'],
            "color"=>"#9b9b9b"
        ),
    );
    $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
    $dd = array();
    $dd['touser']=$touser;
    $dd['template_id']=$wxData['wx_small_template_id'];
    $dd['page']=$page;
    $dd['form_id']=$prepay_id;
    $dd['data']=$value;
    $dd['color']='';
    $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
    $result = https_curl_json($url,$dd,'json');
    return $result;
}

/**
 * 商家推送
 * @param $touser       openid
 * @param $orderData    订单信息
 * @param $uniacid      小程序唯一id
 * @param $type         推送类型
 * @param $order_type   订单类型
 * @return bool
 */
function sendMerchantInfo($touser,$orderData,$uniacid,$type,$order_type){
    global $_W;
    $setting = uni_setting($_W['uniacid'], array('payment'));
    $wechat = $setting['payment']['wechat'];
    $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wxapp') . ' WHERE `acid`=:acid';
    $row = pdo_fetch($sql, array(':acid' => $wechat['account']));
    $wxData=pdo_get('cqkundian_farm_wx_set',array('uniacid'=>$uniacid));
    $access_token = get_Wx_accessToken($wxData['wx_appid'],$wxData['wx_secret'],$uniacid);
    if($order_type==1){
        $data=array(
            'first'=>array('value'=>'您有新的订单',"color"=>"#436EEE"),
            'keyword1'=>array("value"=>$type),
            'keyword2'=>array("value"=>date("Y-m-d H:i:s",$orderData['create_time'])),
            'remark'=>array('value'=>'请尽快处理!点击进入查看详情','color'=>'#436EEE'),
        );
    }elseif ($order_type==2){
        $data=array(
            'first'=>array('value'=>'订单取消通知',"color"=>"#436EEE"),
            'keyword1'=>array("value"=>$type),
            'keyword2'=>array("value"=>date("Y-m-d H:i:s",time())),
            'remark'=>array('value'=>'请尽快处理!点击进入查看详情','color'=>'#436EEE'),
        );
    }

    $template = array(
        'touser' => $touser,
        'template_id' => $wxData['wx_shop_template_id'],
        'data' => $data,
        "miniprogram"=>array(
            "appid"=>$row['key'],
            "pagepath"=>"kundian_farm/pages/user/userCenter/index"
        )
    );
    $json_template = json_encode($template);
    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
    $dataRes = http_request($url, urldecode($json_template));
    if ($dataRes->errcode == 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * 获取微信公众号access_token
 * @param $appid        微信公众号appid
 * @param $secret       微信公众号密钥
 * @param $uniacid      小程序唯一标志
 * @return array|bool|Memcache|mixed|Redis|string
 */
function get_Wx_accessToken($appid,$secret,$uniacid){
    if(cache_load('kundian_farm_access_token_wx_time'.$uniacid)>time()){
        return cache_load('kundian_farm_access_token_wx'.$uniacid);
    }else{
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
        $result = http_request($url);
        $res = json_decode($result,true);
        if($res){
            cache_write('kundian_farm_access_token_wx_time'.$uniacid,time()+7000);
            cache_write('kundian_farm_access_token_wx'.$uniacid,$res['access_token']);
            return $res['access_token'];
        }else{
            return 'api return error';
        }
    }
}

/* 发送json格式的数据，到api接口 -xzz0704  */
function https_curl_json($url,$data,$type){
    if($type=='json'){//json $_POST=json_decode(file_get_contents('php://input'), TRUE);
        $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
        $data=json_encode($data);
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
    $output = curl_exec($curl);
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl);
    return $output;
}
function http_request($url,$data=array()){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // POST数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getWeek($day){
    switch ($day){
        case 1:
            return "周一";
            break;
        case 2:
            return '周二';
            break;
        case 3:
            return '周三';
            break;
        case 4:
            return '周四';
            break;
        case 5:
            return '周五';
            break;
        case 6:
            return '周六';
            break;
        case 0:
            return '周日';
            break;
    }
}

/**
 * 订单状态整理
 * @param $orderData    //订单类型
 * @return mixed
 */
function neatenOrder($orderData){
    if($orderData['apply_delete']==0){
        if($orderData['is_pay']==0){
            $orderData['status']=0;
            $orderData['status_txt']='未支付';
        }else{
            if($orderData['is_check']==0){
                $orderData['status']=1;
                $orderData['status_txt']='已支付，待审核';
            }elseif ($orderData['is_check']==1){
                $orderData['status']=2;
                $orderData['status_txt']='审核通过，待参加';
            }elseif ($orderData['is_check']==2){
                $orderData['status']=3;
                $orderData['status_txt']='审核未通过';
            }elseif ($orderData['is_check']==3){
                $orderData['status']=4;
                $orderData['status_txt']='已参加';
            }
        }
    }else{
        $orderData['status']=5;
        $orderData['status_txt']='订单已取消';
    }

    return $orderData;
}

/**
 * 对象转数组
 * @param $obj  对象
 * @return array|void
 */
function objectToArray($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)objectToArray($v);
        }
    }
    return $obj;
}

/**
 * 获取配置信息
 * @param $uniacid      小程序唯一id
 * @param $field        查询字段
 * @return array        返回值
 */
function getCommonSet($uniacid,$field){
    $condition=array(
        'ikey'=>$field,
        'uniacid'=>$uniacid,
    );
    $nowList=pdo_getall('cqkundian_farm_plugin_active_set',$condition);
    $list=array();
    foreach ($nowList as $key => $value) {
        $list[$value['ikey']]=$value['value'];
    }
    return $list;
}
