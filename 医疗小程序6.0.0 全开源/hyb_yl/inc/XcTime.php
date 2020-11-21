<?php
define('IN_SYS', true);
require '../../../framework/bootstrap.inc.php';
define('dianc_ROOT', dirname(dirname(__FILE__)));
define('IS_OPERATOR', true);
require dianc_ROOT . '../../../web/common/bootstrap.sys.inc.php';
global $_GPC, $_W;
$uniacid =$_W['uniacid'];
function https_curl_json($url,$data,$type){
if($type=='json'){
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
$wxappaid = pdo_get('hyb_yl_parameter',array('uniacid'=>$uniacid));
//2.查询微信模板
$wxapptemp = pdo_get('hyb_yl_wxapptemp',array('uniacid'=>$uniacid));
//3.获取appid and appsecret
$appid = $wxappaid['appid'];
$appsecret = $wxappaid['appsecret'];
//4.获取模板
$template_id = $wxapptemp['txtempt'];
$tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
$getArr=array();
$tokenArr=json_decode(send_post($tokenUrl,$getArr,"GET"));
$access_token=$tokenArr->access_token;
$url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token='.$access_token;
ignore_user_abort(); // 后台无阻断运行 
set_time_limit(0); // 一直给我运行 
$zhoz_execute_time = 1; // 运行时间seconds，这里设置成一分钟跑一次。 
do{ 
$timearr =time();   
//查询当前时间所有用户的提醒
$res =pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_userdstimes')."where uniacid ='{$uniacid}' and timearr='{$timearr}'");
foreach ($res as &$value) {
  $openid=$value['openid'];
  $formid=$value['formid'];
  $xiangmu=$value['xiangmu'];
  $ds_id=$value['ds_id'];
  $timearr=date('Y-m-d H:i:s',$value['timearr']);
  $content=$value['content'];
  $dd['form_id'] = $formid;
  $dd['touser'] = $openid;
  $content = array(
      "keyword1"=>array(
      "value"=> $xiangmu,
      "color"=>"#4a4a4a"
      ),
      "keyword2"=>array(
          "value"=>$timearr,
          "color"=>""
      ),
      "keyword3"=>array(
          "value"=>$content,
          "color"=>""
      ),
        
  );
  $dd['template_id']=$template_id;
  $dd['page']='hyb_yl/twosubpages/pages/nextjiuzhen/nextjiuzhen?ds_id='.$ds_id;  //跳转点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
  $dd['data']=$content;                        //模板内容，不填则下发空模板
  $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
  $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
  $result1 = https_curl_json($url,$dd,'json');
}
sleep($zhoz_execute_time); // 按指定轨道时间运行 
} while (true);
?>