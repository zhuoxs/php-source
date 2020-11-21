<?php
defined('IN_IA') or exit('Access Denied');
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $f_id = $_REQUEST['fid'];
        $t_id = $_REQUEST['tid'];
        $u_id = $_GPC['u_id'];
        $openid = $_REQUEST['openid'];
        $f_name = $_GPC['f_name'];
        $data_arr = $_GPC['data_arr'];
        $typetext =$_GPC['typetext'];
        $ifkf =$_GPC['ifkf'];
        $kfid =$_GPC['kfid'];
        $zid = $_GPC['docid'];
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
        $data = array('uniacid' => $uniacid, 'f_id' => $f_id, 'f_name' => $_GPC['f_name'], 'f_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
        't_id' => $t_id, 't_name' => $_GPC['nickName'], 't_msg' => $textinfo, 'r_state' => 2, //状态:1为已读,2为未读,默认为2
        'add_time' => time(), 'docid' => $_GPC['docid'], 'is_img' => $_GPC['is_img'], 'touxiang' => $_GPC['touxiang'],'typetext'=>$typetext,'ifkf'=>$ifkf,'kfid'=>$kfid,'ifkf'=>$_GPC['ifkf']);

        $data1 = array('uniacid' => $uniacid, 'f_id' => $f_id, 'f_name' => $_GPC['f_name'], 'f_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
        't_id' => $t_id, 't_name' => $_GPC['nickName'], 't_msg' => $t_msg2, 'r_state' => 2, //状态:1为已读,2为未读,默认为2
        'add_time' => time(), 'docid' => $_GPC['docid'], 'is_img' => $_GPC['is_img'], 'touxiang' => $_GPC['touxiang'],'typetext'=>$typetext,'ifkf'=>$ifkf,'kfid'=>$kfid,'ifkf'=>$_GPC['ifkf']);

        $data2 = array('uniacid' => $uniacid, 'f_id' => $f_id, 'f_name' => $_GPC['f_name'], 'f_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
        't_id' => $t_id, 't_name' => $_GPC['nickName'], 't_msg' => $textinfo, 'r_state' => 2, //状态:1为已读,2为未读,默认为2
        'add_time' => time(), 'docid' => $_GPC['docid'], 'is_img' => $_GPC['is_img'], 'touxiang' => $_GPC['touxiang'],'typetext'=>0,'ifkf'=>$ifkf,'kfid'=>$kfid,'ifkf'=>$_GPC['ifkf']);
         
        $data3 = array('uniacid' => $uniacid, 'f_id' => $f_id, 'f_name' => $_GPC['f_name'], 'f_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
        't_id' => $t_id, 't_name' => $_GPC['nickName'], 't_msg' => $_GPC['t_msg'], 'r_state' => 2, //状态:1为已读,2为未读,默认为2
        'add_time' => time(), 'docid' => $_GPC['docid'], 'is_img' => $_GPC['is_img'], 'touxiang' => $_GPC['touxiang'],'typetext'=>3,'ifkf'=>$ifkf,'kfid'=>$kfid,'ifkf'=>$_GPC['ifkf']);

        if($typetext ==0){
         //添加text

          $res = pdo_insert("hyb_yl_chat_msg_wz", $data);  

        }
        if($typetext ==1){
         //添加图片
          $res = pdo_insert("hyb_yl_chat_msg_wz", $data1);  

        }
        if($typetext ==2){
             pdo_insert("hyb_yl_chat_msg_wz", $data2);
             pdo_insert("hyb_yl_chat_msg_wz", $data1);

        }
        if($typetext ==3){

             pdo_insert("hyb_yl_chat_msg_wz", $data3);

        }
        $m_id = pdo_insertid();
        $ifstate = pdo_get('hyb_yl_chat_msg_wz', array('uniacid' => $uniacid, 'm_id' => $m_id));
        $r_state = $ifstate['r_state'];
        $docid = $ifstate['docid'];
        $timess = date("Y-m-d H:i:s", $ifstate['add_time']);
        $tmpStr = json_encode($ifstate['t_msg']); //暴露出unicode
        $tmpStr1 = preg_replace_callback('/\\\\\\\\/i', function ($a) {
            return '\\';
        }, $tmpStr); //将两条斜杠变成一条，其他不动
        $t_msg = json_decode($tmpStr1);


        if ($r_state == 2) {
            //发送模板消息给医生
            //1.查询信息配置
            $wxappaid = pdo_get('hyb_yl_parameter', array('uniacid' => $uniacid));
            //2.查询微信模板
            $wxapptemp = pdo_get('hyb_yl_wxapptemp', array('uniacid' => $uniacid));
            //3.获取appid and appsecret
            $appid = $wxappaid['appid'];
            $appsecret = $wxappaid['appsecret'];
            //4.获取模板
            $template_id = $wxapptemp['doctemp'];
            $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $getArr = array();
            $tokenArr = json_decode(send_post($tokenUrl, $getArr, "GET"));
            $access_token = $tokenArr->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
            //5.查询当前医生formid
           $zhiban = pdo_fetch("SELECT * FROM".tablename("hyb_yl_zhuanjia")."where uniacid='{$uniacid}' and z_shenfengzheng=1 limit 1");   
           $user_curr = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $t_id));

     
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
                if($ifstate['f_name'] =='undefined'){
                     $faxinname =$ifstate['f_name'];
                }else{
                     
                     $faxinname = $_GPC['nickName'];
                }
                $content = array("keyword1" => array("value" => $faxinname, "color" => "#4a4a4a"), "keyword2" => array("value" => $timess, "color" => ""), "keyword3" => array("value" => '有一条最新问诊消息', "color" => ""),);
                $dd['template_id'] = $template_id;
                
                if($ifkf==3){
                  $dd['page'] = 'hyb_yl/mysubpages/pages/wodezixun/wodezixun'; 
                }
                if($ifkf==0)
                {
                  $dd['page'] = 'hyb_yl/userLife/pages/wodezixun/wodezixun?zid='.$zid; 
                }
                $dd['data'] = $content; //模板内容，不填则下发空模板
                $dd['color'] = ''; //模板内容字体的颜色，不填默认黑色
                $dd['emphasis_keyword'] = ''; //模板需要放大的关键词，不填则默认无放大
                $result1 = https_curl_json($url, $dd, 'json');
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

 return $this->result(0, "success", $t_msg);

 function send_post($url, $post_data, $method = 'POST') {
        $postdata = http_build_query($post_data);
        $options = array('http' => array('method' => $method, //or GET
        'header' => 'Content-type:application/x-www-form-urlencoded', 'content' => $postdata, 'timeout' => 15 * 60 // 超时时间（单位:s）
        ));
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
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

