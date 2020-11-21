<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];

$op =$_GPC['op'];

if($op =='add'){
    $zid = $_GPC['zid'];
	$value = htmlspecialchars_decode($_GPC['arr']);
	$array = json_decode($value);
	$yaoqing = json_decode(json_encode($array), true);
	$teampic = $yaoqing['teampic'];
	$t_id = $yaoqing['t_id'];
	$teamtext = $yaoqing['teamtext'];
	$z_name = $yaoqing['z_name'];
	$teamname = $yaoqing['teamname'];
	$z_thumbs = $yaoqing['z_thumbs'];
	$pdodoc = pdo_get("hyb_yl_zhuanjia",array('zid'=>$zid,'uniacid'=>$uniacid));
	$openid = $pdodoc['openid'];
	    //插入数据
    $data =array(

          'uniacid'=>$_W['uniacid'],
          'zid' =>$zid,
          'yao_time'=>strtotime('now'),
          'openid' =>$openid,
          't_id' =>$t_id
    	);
    $insertdoc  = pdo_insert("hyb_yl_yaoqingdoc",$data);
    $yao_id =pdo_insertid();  
	//发送邀请模板消息给医生
	//1.查询信息配置
	$wxappaid = pdo_get('hyb_yl_parameter', array('uniacid' => $uniacid));
	//2.查询微信模板
	$wxapptemp = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid));
	//3.获取appid and appsecret
	$appid = $wxappaid['appid'];
	$appsecret = $wxappaid['appsecret'];
	//4.获取模板
	$template_id = $wxapptemp['yqtemp'];
	$tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
	$getArr = array();
	$tokenArr = json_decode(send_post($tokenUrl, $getArr, "GET"));
	$access_token = $tokenArr->access_token;
	$url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
	//5.查询医生formid
	$user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
	// var_dump($member);
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
	    	"keyword1" => array("value" => $ifstate['f_name'], "color" => "#4a4a4a"), 
	    	"keyword2" => array("value" => $timess, "color" => ""), 
	    	"keyword3" => array("value" => $t_msg, "color" => ""),);
	    $dd['template_id'] = $template_id;
	    $dd['page'] = 'hyb_yl/backstageTeam/pages/teamDetails/teamDetails?zid='.$zid.'&t_id='.$t_id.'&teampic='.$teampic.'&teamtext='.$teamtext.'&z_thumbs='.$z_thumbs.'&z_name='.$z_name.'&teamname='.$teamname.'&yaoqing=1'.'&yao_id='.$yao_id; //跳转点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
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
       echo json_encode($insertdoc);
	}
}

if($op =='display'){
	$t_id =$_GPC['t_id'];
    $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_yaoqingdoc")." as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid =a.zid where a.uniacid='{$uniacid}' and a.t_id='{$t_id}' and a.yao_type !=0");
    foreach ($res as $key => $value) {
    	$res[$key]['yao_time']=date("Y-m-d H:i:s",$res[$key]['yao_time']);
    	$res[$key]['z_thumbs'] =$_W['attachurl'].$res[$key]['z_thumbs'];
   
    	if($res[$key]['yao_type'] ==1){
            $res[$key]['textname']="已同意";
    	}
    	if($res[$key]['yao_type'] ==2){
           $res[$key]['textname'] ="已拒绝";
    	}
    }
    echo json_encode($res);
}
if($op =='yaoqingjilu'){
		$t_id =$_GPC['t_id'];
	    $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_yaoqingdoc")." as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid =a.zid where a.uniacid='{$uniacid}' and a.t_id='{$t_id}'");
	    foreach ($res as $key => $value) {
	    	$res[$key]['yao_time']=date("Y-m-d H:i:s",$res[$key]['yao_time']);
	    	$res[$key]['z_thumbs'] =$_W['attachurl'].$res[$key]['z_thumbs'];
	    	if($res[$key]['yao_type'] ==0){
	            $res[$key]['textname'] ="邀请中";
	    	}
	    	if($res[$key]['yao_type'] ==1){
	            $res[$key]['textname']="已同意";
	    	}
	    	if($res[$key]['yao_type'] ==2){
	           $res[$key]['textname'] ="已拒绝";
	    	}
	    }
	    echo json_encode($res);
}
if($op =='ifduiz'){
	$t_id=$_GPC['t_id'];
	$openid = $_GPC['openid'];
	$doc = pdo_get("hyb_yl_zhuanjia",array('uniacid'=>$uniacid,'t_id'=>$t_id),array('zid'));

    $res =pdo_get("hyb_yl_yaoqingdoc",array('uniacid'=>$uniacid,'t_id'=>$t_id),array('zid'));
    
    if($doc['zid']=$res['zid']){
       echo '1';
    }else{
       echo '0';
    }
}
if($op == 'entryyao'){
  $yao_id =$_GPC['yao_id'];
  $yao_type = $_GPC['yao_type'];
  $t_id =$_GPC['t_id'];
  $data = array(
    'yao_type'=>$yao_type
  	);
    $res = pdo_update("hyb_yl_yaoqingdoc",$data,array('uniacid'=>$uniacid,'yao_id'=>$yao_id));
    //查询受邀人信息
    $shouyao = pdo_get("hyb_yl_yaoqingdoc",array('yao_id'=>$yao_id,'uniacid'=>$uniacid),array('zid'));
    //受邀人ID
    $sydocinfo = pdo_get("hyb_yl_zhuanjia",array('zid'=>$shouyao['zid'],'uniacid'=>$uniacid),array('z_name'));
    //查询邀请人信息
    $zhuanjiaid = pdo_get("hyb_yl_zhuanjteam",array('uniacid'=>$uniacid,'t_id'=>$t_id),array('zid'));
    $zid = $zhuanjiaid['zid'];
    if($res){
 	//同意
    //1.查询信息配置
	$wxappaid = pdo_get('hyb_yl_parameter', array('uniacid' => $uniacid));
	//2.查询微信模板
	$wxapptemp = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid));
	//3.获取appid and appsecret
	$appid = $wxappaid['appid'];
	$appsecret = $wxappaid['appsecret'];
	//4.获取模板
	$template_id = $wxapptemp['jujyaoqi'];
	if($yao_type ==1){
       $infotext ='受邀人同意了您的邀请';
	}else{
	  $infotext ='受邀人拒绝了您的邀请';
	}
	
	$tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
	$getArr = array();
	$tokenArr = json_decode(send_post($tokenUrl, $getArr, "GET"));
	$access_token = $tokenArr->access_token;
	$url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
	//5.查询医生formid
	$docccc = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " where uniacid=:uniacid and zid=:zid", array(":uniacid" => $uniacid, ":zid" => $zid));

	$user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $docccc['openid']));
	// var_dump($member);
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
	    	"keyword1" => array("value" => $infotext, "color" => "#4a4a4a"), 
	    	"keyword2" => array("value" => $sydocinfo['z_name'], "color" => "")
	    	);
	    $dd['template_id'] = $template_id;
	    //teampic=https://www.webstrongtech.net/attachment/7815396407165469.jpg&t_id=2&zid=2&teamtext=测试下娃哈哈&teamname=我的专家团队&z_name=王医生&z_thumbs=https://www.webstrongtech.net/attachment/images/141/2018/12/JZzbRhv0c8zBvHxIcAqs0bBA2GLrR8.jpeg&yaoqing=1

	    $dd['page'] = 'hyb_yl/tabBar/index/index'; //跳转点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
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
  }
    echo json_encode($res);
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