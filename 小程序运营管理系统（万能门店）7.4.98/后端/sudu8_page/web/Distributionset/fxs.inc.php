<?php 


function _requestGetcurl($url){
    //curl完成  
    $curl = curl_init();  
    //设置curl选项  
    $header = array(  
        "authorization: Basic YS1sNjI5dmwtZ3Nocmt1eGI2Njp1TlQhQVFnISlWNlkySkBxWlQ=",
        "content-type: application/json",
        "cache-control: no-cache",
        "postman-token: cd81259b-e5f8-d64b-a408-1270184387ca" 
    );
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER  , $header); 
    curl_setopt($curl, CURLOPT_URL, $url);//URL  
    curl_setopt($curl, CURLOPT_HEADER, 0);             // 0：不返回头信息
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
    // 发出请求  
    $response = curl_exec($curl);
    if (false === $response) {  
        echo '<br>', curl_error($curl), '<br>';  
        return false;  
    }  
    curl_close($curl);  
    $forms = stripslashes(html_entity_decode($response));
    $forms = json_decode($forms,TRUE);
    return $forms;  
}

function _requestPost($url, $data, $ssl=true) {  
        //curl完成  
        $curl = curl_init();  
        //设置curl选项  
        curl_setopt($curl, CURLOPT_URL, $url);//URL  
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';  
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息  
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源  
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
        //SSL相关  
        if ($ssl) {  
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证  
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。  
        }  
        // 处理post相关选项  
        curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求  
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据  
        // 处理响应结果  
        curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果  
        // 发出请求  
        $response = curl_exec($curl);
        if (false === $response) {  
            echo '<br>', curl_error($curl), '<br>';  
            return false;  
        }  
        curl_close($curl);  
        return $response;  
}

//发送微信模板消息
function sendTplMessage($flag, $openid, $formId, $types, $data){ //$fmsg, $orderid, $fprice){
    global $_GPC, $_W;
    $uniacid = $_W['uniacid'];

    $applet = pdo_get("account_wxapp", array("uniacid" => $uniacid));
    $appid = $applet['key'];
    $appsecret = $applet['secret'];
    if($applet){
        $mid = pdo_get("sudu8_page_message", array("uniacid" => $uniacid, "flag" => $flag));
        if($mid && $mid['mid'] != ""){
            $mids = $mid['mid'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $a_token = _requestGetcurl($url);
            if($a_token){
                $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];
                $ftime = date('Y-m-d H:i:s',time());
                $furl = $mid['url'];

                $post_info = '{ 
                  "touser": "'.$openid.'",  
                  "template_id": "'.$mids.'", 
                  "page": "'.$furl.'",         
                  "form_id": "'.$formId.'",         
                  "data": {
                      "keyword1": {
                          "value": "'.$data['truename'].'", 
                          "color": "#173177"
                      }, 
                      "keyword2": {
                          "value": "'.$data['content'].'", 
                          "color": "#173177"
                      }, 
                      "keyword3": {
                          "value": "'.$data['creattime'].'", 
                          "color": "#173177"
                      },
                      "keyword4": {
                          "value": "'.$data['notice'].'", 
                          "color": "#173177"
                      }
                  },
                  "emphasis_keyword": "" 
                }';
                
                $response = _requestPost($url_m, $post_info);
                // file_put_contents(__DIR__."/debug2.txt",$response);
                
            }
        }
    }
}

load()->func('tpl');
global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display','shenhe','fxs', 'fxsstop');
        $opt = in_array($opt, $ops) ? $opt : 'display';

        if($opt == "display"){
            // $users = array();
            // $users = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_sq')." WHERE uniacid = :uniacid and flag = 1" , array(':uniacid' => $_W['uniacid']));
            // $yijin = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and fxs = 2" , array(':uniacid' => $_W['uniacid']));
            
            // foreach ($yijin as $key => &$res) {
            //     $res['flag'] = 2;
            //     array_push($users, $res);
            // }
            
            $userinfo = pdo_fetchall("SELECT a.id,a.uniacid,a.openid,a.truetel,a.truename,a.creattime,a.flag,b.uniacid,b.openid,b.avatar,b.createtime,b.nickname FROM ".tablename('sudu8_page_fx_sq') ." as a LEFT JOIN ".tablename('sudu8_page_user') ." as b on a.openid = b.openid and a.uniacid = b.uniacid WHERE a.uniacid = :uniacid order by a.creattime desc", array(':uniacid' => $uniacid));
            foreach($userinfo as &$v){
                $v['nickname'] = rawurldecode($v['nickname']);
                $v['creattime'] = $v['creattime']> 0 ? date("Y-m-d H:i:s", $v['creattime']) : '';
            }
        }
        if($opt == "fxs"){
            // $users = array();
            // $users = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_sq')." WHERE uniacid = :uniacid and flag = 1" , array(':uniacid' => $_W['uniacid']));
            $optt = $_GPC['optt'];
            if(empty($optt)){
                $userinfo = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and fxs = 2 order by id desc" , array(':uniacid' => $_W['uniacid']));
                if($userinfo){
                    foreach($userinfo as $k => &$v){
                        $v['nickname'] = rawurldecode($v['nickname']);
                        if($v['parent_id'] !='0' && $v['parent_id']!='undefined'){
                            $v['parent'] = pdo_fetch("SELECT avatar,nickname FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and fxs = 2 and openid = :openid" , array(':uniacid' => $_W['uniacid'],':openid'=>$v['parent_id']));
                            $v['parent']['nickname'] = rawurldecode($v['parent']['nickname']);
                        }else{
                            $v['parent'] = 0;
                        }
                    }
                }
            }else{
                $openid = $_GPC['openid'];
                $users = pdo_getall("sudu8_page_user", array("uniacid"=>$uniacid, "parent_id"=>$openid));
                foreach($users as &$vv){
                        $vv['nickname'] = rawurldecode($vv['nickname']);
                }
            }
            
            
            // foreach ($yijin as $key => &$res) {
            //     $res['flag'] = 2;
            //     array_push($users, $res);
            // }
            
            // $userinfo = pdo_fetchall("SELECT a.id,a.uniacid,a.openid,a.truetel,a.truename,a.creattime,a.flag,b.uniacid,b.openid,b.avatar,b.createtime,b.nickname FROM ".tablename('sudu8_page_fx_sq') ." as a LEFT JOIN ".tablename('sudu8_page_user') ." as b on a.openid = b.openid and a.uniacid = b.uniacid  WHERE a.flag=1 and a.uniacid = :uniacid order by a.creattime desc", array(':uniacid' => $uniacid));
        }

        if($opt == "shenhe"){
            $id = $_GPC['id'];
            $val = $_GPC['val'];

            $users = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_sq')." WHERE id = :id" , array(':id' => $id));
 
            pdo_update("sudu8_page_fx_sq",array("flag"=>$val),array("id"=>$id));   
            if($val==2){
                
                $fxs_sz = pdo_getcolumn("sudu8_page_fx_gz", array("uniacid" => $uniacid), "fxs_sz");
                $fxsstop = pdo_getcolumn("sudu8_page_user", array("uniacid" => $uniacid,'openid' => $users['openid']), "fxsstop");
                pdo_update("sudu8_page_user",array("fxs"=>2,"fxsstop" => 1), array('openid' => $users['openid'] ,'uniacid' => $_W['uniacid']));
                if($fxs_sz == "2" || $fxsstop == "2"){
                    $flag2 = 10;
                    $data2 = array(
                        "truename" => $users['truename'],
                        "content" => "申请成为分销商",
                        "creattime" => date("Y-m-d H:i:s", time()),
                        "notice" => "恭喜您已成为分销商！"
                    );
                    sendTplMessage($flag2, $users['openid'], $users['formid'], "fenxiao", $data2);
                }
            }

            message('审核成功!', $this->createWebUrl('Distributionset', array('op'=>'fxs','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
        if($opt == "fxsstop"){
            $openid = $_GPC['openid'];
            $fxsstop = pdo_getcolumn('sudu8_page_user', array('uniacid' => $uniacid, 'openid' => $openid, 'fxs' => 2), 'fxsstop');

            if($fxsstop == 1){
                $res = pdo_update('sudu8_page_user', array('fxsstop' => 2), array('uniacid' => $uniacid, 'openid' => $openid, 'fxs' => 2));
                if($res){
                    message('禁用成功!', $this->createWebUrl('Distributionset', array('op'=>'fxs','opt'=>"fxs",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
                }else{
                    message('禁用失败，分销商不存在或已禁用!', $this->createWebUrl('Distributionset', array('op'=>'fxs','opt'=>"fxs",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'error');
                }
            }else{
                message('禁用失败，分销商不存在或已禁用!', $this->createWebUrl('Distributionset', array('op'=>'fxs','opt'=>"fxs",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'error');
            }
        }
return include self::template('web/Distributionset/fxs');