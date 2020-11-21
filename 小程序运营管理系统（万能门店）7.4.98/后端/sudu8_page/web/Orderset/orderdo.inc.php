<?php 

define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');
define("HTTPSHOST",$_W['attachurl']);
    function _Postrequest($url, $data, $ssl = true)
    {
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

        //强制IPv4
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        // 发出请求
        $response = curl_exec($curl);
        if (false === $response) {
            echo '<br>', curl_error($curl), '<br>';
            return false;
        }
        curl_close($curl);
        return $response;
    }
    //好物圈
    function mall($openid,$orderid,$payprice,$status,$protype,$pid,$num,$yunfei,$kd_id, $kuaidi, $kuaidihao,$beizhu_val)
    {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $storeInfo = pdo_fetch("SELECT latitude,longitude,name,address,tel FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        $business_name = $storeInfo['name'];

        if($protype == 'miaosha' || $protype == 'yuyue' || $protype == 'duo'){
            $proinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ":id" => $pid));
            if($protype == 'miaosha'){
                $protype = 'showPro';
            }else if($protype == 'yuyue'){
                $protype = 'showPro_lv';
            }else if($protype == 'duo'){
                $protype = 'showProMore';
                $jsondata = pdo_getcolumn('sudu8_page_duo_products_order', array('order_id' => $orderid),'jsondata');
                $jsondata = unserialize($jsondata);
                foreach ($jsondata as $key => $value) {
                    $proinfo['price'] = $value['proinfo']['price'];
                }
            }
            $title = $proinfo['title'];
            $price = $proinfo['price'] * 100;
            $market_price = $proinfo['market_price'] * 100;
        }
        $payprice = $payprice * 100;
        $yunfei = $yunfei * 100;

        $tax_type = 0;
        $tax_title = $business_name;
        $orderinfo = '{
                      "order_list": [
                        {
                          "order_id": "'.$orderid.'",
                          "trans_id": "'.$orderid.'",
                          "status": '.$status.',
                          "desc": "'.$beizhu_val.'",
                          "ext_info": {
                            "express_info": {
                                "name": "",
                                "phone": "",
                                "address": "",
                                "price": '.$yunfei.',
                                "national_code": "",
                                "country": "",
                                "province": "",
                                "city": "",
                                "district": "",
                                "express_package_info_list": [
                                {
                                  "express_company_id": '.$kd_id.',
                                  "express_company_name": "'.$kuaidi.'",
                                  "express_code": "'.$kuaidihao.'",
                                  "ship_time": '.time().',
                                  "express_page": {
                                    "path": "/sudu8_page/index/index"
                                  },
                                  "express_goods_info_list": [
                                    {
                                      "item_code": "'.$pid.'",
                                      "sku_id": "00003563372839_10000010014xxx1"
                                    }
                                  ]
                                }
                              ]
                            },
                            "invoice_info": {
                              "type": '.$tax_type.',
                              "title": "'.$tax_title.'",
                              "tax_number": "",
                              "company_address": "",
                              "telephone": "",
                              "bank_name": "",
                              "bank_account": "",
                              "invoice_detail_page": {
                                "path": "/sudu8_page/index/index"
                              }
                            },
                        "user_open_id": "'.$openid.'",
                        "order_detail_page": {
                          "path": "/sudu8_page/index/index"
                        }
                      }
                    }
                  ]
                }';
            $app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
            $appid = $app['key'];
            $appsecret = $app['secret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $weixin = file_get_contents($url);
            $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
            $array = get_object_vars($jsondecode);//转换成数组
            $access_token = $array['access_token'];//输出token
            $url = 'https://api.weixin.qq.com/mall/importorder?action=update-order&is_history=0&access_token='.$access_token;
            $res = _Postrequest($url,$orderinfo);
    }
function addAllpay($price,$openid){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $str = '论坛信息发布,微同城信息发布,文章全文,视频消费,音频消费,店内支付扣余额,店内支付微信支付';
        $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid ", array(':uniacid' => $uniacid, ':openid' => $openid));

        if(!$userinfo['allpay']){
            $allpays = pdo_fetchcolumn("SELECT sum(score) as allpays FROM ".tablename('sudu8_page_money')." WHERE uniacid = :uniacid and type = 'del' and uid = {$userinfo['id']} and message  IN (:str_1, :str_2, :str_3, :str_4, :str_5, :str_6, :str_7)", array(':uniacid' => $uniacid, ':str_1' => '论坛信息发布', ':str_2' => '微同城信息发布', ':str_3' => '文章全文',':str_4' => '视频消费',':str_5' => '音频消费',':str_6' => '店内支付扣余额',':str_7' => '店内支付微信支付'));
            if($allpays){
                $allpays = round($allpays,2);
            }
            $dan = pdo_fetch("SELECT sum(true_price) as price FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$dan){
                $dan['price'] = 0;
            }else{
                $dan['price'] = round($dan['price'],2);
            }
            $duo = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$duo){
                $duo['price'] = 0;
            }else{
                $duo['price'] = round($duo['price'],2);
            }
            $pt = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 4", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$pt){
                $pt['price'] = 0;
            }else{
                $pt['price'] = round($pt['price'],2);
            }
            $food = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid and uid = :uid", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$food){
                $food['price'] = 0;
            }else{
                $food['price'] = round($food['price'],2);
            }
            $userinfo['allpays'] = $allpays + floatval($dan['price']) + floatval($duo['price']) + floatval($pt['price']) + floatval($food['price']);
            pdo_update("sudu8_page_user", array('allpay' => $userinfo['allpays']), array("id" => $userinfo['id']));
        }else{
            $userinfo['allpays'] = $userinfo['allpay'];
            $allpay = round($price + floatval($userinfo['allpay']),2);
            pdo_update("sudu8_page_user", array("allpay" => $allpay), array('id' => $userinfo['id']));
        }

    }
function checkVipGrade($openid){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid ", array(':uniacid' => $uniacid, ':openid' => $openid));

        if(!$userinfo['allpay']){
            $allpays = pdo_fetchcolumn("SELECT sum(score) as allpays FROM ".tablename('sudu8_page_money')." WHERE uniacid = :uniacid and type = 'del' and uid = {$userinfo['id']} and message  IN (:str_1, :str_2, :str_3, :str_4, :str_5, :str_6, :str_7)", array(':uniacid' => $uniacid, ':str_1' => '论坛信息发布', ':str_2' => '微同城信息发布', ':str_3' => '文章全文',':str_4' => '视频消费',':str_5' => '音频消费',':str_6' => '店内支付扣余额',':str_7' => '店内支付微信支付'));
            if($allpays){
                $allpays = round($allpays,2);
            }
            $dan = pdo_fetch("SELECT sum(true_price) as price FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$dan){
                $dan['price'] = 0;
            }else{
                $dan['price'] = round($dan['price'],2);
            }
            $duo = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$duo){
                $duo['price'] = 0;
            }else{
                $duo['price'] = round($duo['price'],2);
            }
            $pt = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and uid = :uid and flag = 2", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$pt){
                $pt['price'] = 0;
            }else{
                $pt['price'] = round($pt['price'],2);
            }
            $food = pdo_fetch("SELECT sum(price) as price FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid and uid = :uid ", array(":uniacid" => $uniacid, ":uid" => $userinfo['id']));
            if(!$food){
                $food['price'] = 0;
            }else{
                $food['price'] = round($food['price'],2);
            }
            $userinfo['allpays'] = $allpays + floatval($dan['price']) + floatval($duo['price']) + floatval($pt['price']) + floatval($food['price']);
            pdo_update("sudu8_page_user", array('allpay' => $userinfo['allpays']), array("id" => $userinfo['id']));
        }else{
            $userinfo['allpays'] = $userinfo['allpay'];
        }
        $result = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_vipgrade')." WHERE uniacid = :uniacid and status = 1 and grade > 1 order by grade desc", array(':uniacid' => $uniacid));
        if($result){
            foreach ($result as $k => $v) {
                if($v['grade'] > $userinfo['grade']){
                    if($userinfo['allpays'] >= $v['upgrade']){
                        $receive = [];
                        $receive['vid'] = $v['id'];
                        $receive['uniacid'] = $v['uniacid'];
                        

                        if($userinfo['grade'] == 0){
                            $vipid = time().''.rand(100000,999999);
                            $data['vipid'] = $vipid;
                            $data['vipcreatetime'] = time();
                        }
                        $data['grade'] = $v['grade'];
                        if($v['score_feedback_flag'] == 1){
                            if($v['score_feedback'] > 0){
                                $receive['score'] = $v['score_feedback'];
                                $data['score'] = $userinfo['score'] + $v['score_feedback'];
                                $score_data = array(
                                    "uniacid" => $uniacid,
                                    "orderid" => '',
                                    "uid" => $userinfo['id'],
                                    "type" => "add",
                                    "score" => $v['score_feedback'],
                                    "message" => "会员等级回馈积分",
                                    "creattime" => time()
                                );
                                pdo_insert("sudu8_page_score", $score_data);
                            }
                        }
                        if($v['coupon_flag'] == 1){
                            $coupon_give = unserialize($v['coupon_give']);
                            if(count($coupon_give) > 0){
                                $receive['coupon'] = $v['coupon_give'];
                                foreach ($coupon_give as $k => $v) {
                                    $coup_info = [];
                                    for($i = 0;$i<$v['coupon_num'];$i++){
                                        $coup = [];
                                        $cid = $v['coupon_id'];
                                        if(count($coup_info) == 0){
                                            $coup_info = pdo_get("sudu8_page_coupon", array('uniacid' => $uniacid, 'id' => $cid));
                                        }

                                        $coup['uniacid'] = $uniacid;
                                        $coup['uid'] = $userinfo['id'];
                                        $coup['cid'] = $cid;
                                        $coup['btime'] = $coup_info['btime'];
                                        $coup['etime'] = $coup_info['etime'];
                                        $coup['ltime'] = time();
                                        pdo_insert('sudu8_page_coupon_user',$coup);
                                    }
                                }
                            }
                        }
                        $receive['openid'] = $openid;
                        pdo_insert('sudu8_page_vip_receive',$receive);
                        pdo_update("sudu8_page_user", $data, array('uniacid' => $uniacid, 'openid' => $openid));
                        break;
                    }
                }
            }

        }
    }
function dopagegivemoney($openid,$orderid){
    global $_GPC, $_W;
    $uniacid = $_W['uniacid'];
    $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
    $order = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$orderid));
    pdo_update("sudu8_page_fx_ls",array("flag"=>2),array("order_id"=>$orderid));
    $me = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['openid'] ,':uniacid' => $_W['uniacid']));
    $me_p_get_money = $me['p_get_money'];
    $me_p_p_get_money = $me['p_p_get_money'];
    $me_p_p_p_get_money = $me['p_p_p_get_money'];
    // 启动一级分销提成
    if($guiz['fx_cj'] == 1){
        if($order['parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级贡献的钱
            $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
    }
    // 启动二级分销提成
    if($guiz['fx_cj'] == 2){
        if($order['parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级贡献的钱
            $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
        if($order['p_parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级的父级贡献的钱
            $new_p_p_get_money = $me_p_p_get_money*1 + $order['p_parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_p_get_money" => $new_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
    }
    // 启动三级分销提成
    if($guiz['fx_cj'] == 3){
        if($order['parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级贡献的钱
            $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
        if($order['p_parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级的父级贡献的钱
            $new_p_p_get_money = $me_p_p_get_money*1 + $order['p_parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_p_get_money" => $new_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
        if($order['p_p_parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_p_parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['p_p_parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['p_p_parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_p_parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级的父级的附近贡献的钱
            $new_p_p_p_get_money = $me_p_p_p_get_money*1 + $order['p_p_parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_p_p_get_money" => $new_p_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
    }
}

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
                          "value": "'.$data['orderid'].'", 
                          "color": "#173177"
                      }, 
                      "keyword2": {
                          "value": "'.$data['fmsg'].'", 
                          "color": "#173177"
                      }, 
                      "keyword3": {
                          "value": "'.$data['fprice'].'元", 
                          "color": "#173177"
                      },
                      "keyword4": {
                          "value": "'.$ftime.'", 
                          "color": "#173177"
                      },
                      "keyword5": {
                          "value": "'.$data['refund_type'].'", 
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

global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('fahuosp', 'hx', 'fahuo','fh','ziti','quxiao','allowth','refuseth','refuseqx','confirmtk','excel','getwuliu');
        $opt = in_array($opt, $ops) ? $opt : 'fahuosp';
        if($opt == 'getwuliu'){
            $kuaidi = $_GPC['kuaidi'];
            $kuaidihao = $_GPC['kuaidihao'];

            $kd_code = array(
                    '顺丰速运' => 'SFEXPRESS',
                    '韵达' => 'YD',
                    '天天' => 'TTKDEX',
                    '申通' => 'STO',
                    '圆通' => 'YTO',
                    '中通' => 'ZTO',
                    '国通' => 'GTO',
                    '百世汇通' => 'HTKY',
                    'EMS'  => 'EMS',
                    '邮政' => 'CHINAPOST',
                    'FEDEX联邦(国内件)' => 'FEDEX',
                    '宅急送' => 'ZJS',
                    '安捷快递' => 'ANJELEX',
                    '大田物流' => 'DTW',
                    '百福东方' => 'EES',
                    '德邦' => 'DEPPON',
                    'D速物流' => 'DEXP',
                    'COE东方快递' => 'COE',
                    '共速达' => 'GSD',
                    '佳怡物流' => 'JIAYI',
                    '京广速递' => 'KKE',
                    '急先达' => 'JOUST',
                    '加运美' => 'TMS',
                    '晋越快递' => 'PEWKEE',
                    '全晨快递' => 'QCKD',
                    '民航快递' => 'CAE',
                    '龙邦快递' => 'LBEX',
                    '联昊通速递' => 'LTS',
                    '全一快递' => 'APEX',
                    '如风达' => 'RFD',
                    '速尔快递' => 'SURE',
                    '盛丰物流' => 'SFWL',
                    '天地华宇' => 'HOAU',
                    'TNT快递' => 'TNT',
                    'UPS' => 'UPS',
                    '万家物流' => 'WANJIA',
                    '信丰物流' => 'XFEXPRESS',
                    '亚风快递' => 'BROADASIA',
                    '优速' => 'UC56',
                    '远成物流' => 'YCGWL',
                    '运通快递' => 'YTEXPRESS',
                    '源安达快递' => 'YADEX',
                    '中铁快运' => 'CRE',
                    '中邮快递' => 'CNPL',
                    '安能物流' => 'ANE',
                    '九曳供应链' => 'JIUYESCM',
                    '东骏快捷'=>'DJ56',
                    '万象'=>'EWINSHINE',
                    '芝麻开门'=>'ZMKMEX'
                );
            include MODULE_ROOT.'/KdSearch.php';
            $ShipperCode = $kd_code[$kuaidi];
            $LogisticCode = $kuaidihao;

            $wuliu = pdo_fetch("SELECT api_type,ebusinessid,appkey, appcode FROM ".tablename('sudu8_page_duo_products_yunfei')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            if(!$wuliu){
                $ebusinessid = 1412090;
                $appkey = '9dc7f785-8ed0-4739-aaa0-ae619d449923';
            }else{
                if($wuliu['api_type'] == 2){
                    $ebusinessid = $wuliu['ebusinessid'];
                    $appkey = $wuliu['appkey'];
                }elseif($wuliu['api_type'] == 3){
                    //阿里云接口
                    $ali_code = array(
                    '顺丰速运' => 'SFEXPRESS',
                    '韵达' => 'YUNDA',
                    '天天' => 'TTKDEX',
                    '申通' => 'STO',
                    '圆通' => 'YTO',
                    '中通' => 'ZTO',
                    '国通' => 'GTO',
                    '百世汇通' => 'HTKY',
                    'EMS'  => 'EMS',
                    '邮政' => 'CHINAPOST',
                    'FEDEX联邦(国内件)' => 'FEDEX',
                    '宅急送' => 'ZJS',
                    '安捷快递' => 'ANJELEX',
                    '大田物流' => 'DTW',
                    '百福东方' => 'EES',
                    '德邦' => 'DEPPON',
                    'D速物流' => 'DEXP',
                    'COE东方快递' => 'COE',
                    '共速达' => 'GSD',
                    '佳怡物流' => 'JIAYI',
                    '京广速递' => 'KKE',
                    '急先达' => 'JOUST',
                    '加运美' => 'TMS',
                    '晋越快递' => 'PEWKEE',
                    '全晨快递' => 'QCKD',
                    '民航快递' => 'CAE',
                    '龙邦快递' => 'LBEX',
                    '联昊通速递' => 'LTS',
                    '全一快递' => 'APEX',
                    '如风达' => 'RFD',
                    '速尔快递' => 'SURE',
                    '盛丰物流' => 'SFWL',
                    '天地华宇' => 'HOAU',
                    'TNT快递' => 'TNT',
                    'UPS' => 'UPS',
                    '万家物流' => 'WANJIA',
                    '信丰物流' => 'XFEXPRESS',
                    '亚风快递' => 'BROADASIA',
                    '优速' => 'UC56',
                    '远成物流' => 'YCGWL',
                    '运通快递' => 'YTEXPRESS',
                    '源安达快递' => 'YADEX',
                    '中铁快运' => 'CRE',
                    '中邮快递' => 'CNPL',
                    '安能物流' => 'ANE',
                    '九曳供应链' => 'JIUYESCM',
                    '东骏快捷'=>'DJ56',
                    '万象'=>'EWINSHINE',
                    '芝麻开门'=>'ZMKMEX'
                    );
                    $kuaidi = $ali_code[$kuaidi];
                    // $data = $_POST;
                    $host = "https://wuliu.market.alicloudapi.com";//api访问链接
                    $path = "/kdi";//API访问后缀
                    $method = "GET";
                    $appcode = $wuliu['appcode'];  //阿里云云市场购买的 appcode
                    $headers = array();
                    array_push($headers, "Authorization:APPCODE " . $appcode);
                    $querys = "no=$kuaidihao&type=$kuaidi";  //参数写在这里
                    $bodys = "";
                    $url = $host . $path . "?" . $querys;//url拼接

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_FAILONERROR, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    if (1 == strpos("$".$host, "https://"))
                    {
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    }
                    $data = curl_exec($curl);
                    
                    curl_close($curl);

                    $res = json_decode($data, true);
                    if($res){
                        if($res['status'] == 0){
                            foreach ($res['result']['list'] as $key => &$value) {
                                $value['AcceptStation'] = $value['status'];
                                $value['AcceptTime'] = $value['time'];
                            }
                            echo json_encode($res['result']['list']);
                        }else{
                            echo json_encode([]);
                        }
                        
                    }else{
                        echo -1;
                    }
                    exit;
                }else{
                    $ebusinessid = 1412090;
                    $appkey = '9dc7f785-8ed0-4739-aaa0-ae619d449923';
                }
            }
            $kd = new KdSearch();
            $return=$kd->getOrderTracesByJson($ebusinessid,$appkey,$ShipperCode,$LogisticCode);
            $result = json_decode($return,true);
            if(!$result['Success']){
                echo -1;
            }else{
                echo json_encode(array_reverse($result['Traces']));
            }
            exit;
        }
        if($opt == "hx"){  //核销
            $order = $_GPC['order'];
            $data['hxtime'] = time();
            $data['hxinfo'] = 'a:1:{i:0;i:1;}';
            $flag = pdo_getcolumn("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order), 'flag');
            if($flag == 6){
            message('发货失败！订单状态发送改变!',$this->createWebUrl('Orderset', array('op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])),'error');
            }
            $data['flag'] = 2;
            $res = pdo_update('sudu8_page_duo_products_order', $data, array('id' => $order));
            $info = pdo_fetch("SELECT * FROM".tablename('sudu8_page_duo_products_order')." WHERE id = :id", array(':id' => $order));
            addAllpay($info['price'], $info['openid']);
            checkVipGrade($info['openid']);
            if($info['hwq'] == 1){
                $yunfei = 0;
                $kd_id = 9999;
                $kuaidi = '暂无物流信息';
                $kuaidihao = '暂无物流信息';
                $status = 100;//status订单状态，3：支付完成 4：已发货 5：已退款 100: 已完成
                $beizhu_val = $info['liuyan'];
                $jsondata = unserialize($info['jsondata']);
                $num = 0;
                $pid = 0;
                foreach($jsondata as $v){
                    $num = $num + $v['num'];
                    $pid = $v['pvid'];
                }
      
                mall($info['openid'], $info['order_id'], $info['price'], $status, 'duo', $pid, $num,  $yunfei, $kd_id, $kuaidi, $kuaidihao, $beizhu_val);
            }
            //购买送积分
            $order2 = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order), array("uid", "jsondata", "order_id"));
            $jsondata = unserialize($order2['jsondata']);
            $jf_jsondata = unserialize($order2['jsondata']);
            $total_num = 0;
            $total_price = 0;
            foreach ($jsondata as $key => &$value) {
                $total_num += $value['num'];
                $total_price += $value['proinfo']['price'] * $value['num'];
            }

            if($jf_jsondata){
                $hasscoreback = 0;
                foreach ($jf_jsondata as $key => $value) {
                    $scoreback = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$value['baseinfo']['id']), "scoreback");
                    if(!empty($scoreback)){
                        if(strpos($scoreback, "%")){
                            $scoreback = floatval(chop($scoreback, "%"));
                            $scoretomoney = pdo_get("sudu8_page_rechargeconf", array("uniacid" => $uniacid));
                            $scoreback = $value['proinfo']['price'] * $value['num'] * $scoreback / 100;
                            // $scoreback = floor($scoreback * intval($scoretomoney['scroe']) / intval($scoretomoney['money']));
                            if($info['score_flag'] == 0 && $info['score_bei'] > 0){
                                $scoreback = floor($scoreback * intval($scoretomoney['scroe']) * $info['score_bei'] / intval($scoretomoney['money']));
                            }else{
                                $scoreback = floor($scoreback * intval($scoretomoney['scroe']) / intval($scoretomoney['money']));
                            }
                        }else{
                            // $scoreback = floor($total_num * floatval($scoreback));
                            if($info['score_flag'] == 0 && $info['score_bei'] > 0){
                                $scoreback = floor($value['num'] * floatval($scoreback) * $info['score_bei']);
                            }else{
                                $scoreback = floor($value['num'] * floatval($scoreback));
                            }
                        }
                        $hasscoreback = $hasscoreback + $scoreback*1;
                    }
                    if($hasscoreback > 0){
                        $new_user = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "id"=>$order2['uid']));
                        // if($info['score_flag'] == 0 && $info['score_bei'] > 0){
                        //     $scoreback = $scoreback * $info['score_bei'];
                        // }
                        $new_my_score = $new_user['score'] + $scoreback;
                        pdo_update("sudu8_page_user", array("score"=>$new_my_score), array("uniacid"=>$uniacid, "id"=>$new_user['id']));
                        $scoreback_data = array(
                            "uniacid" => $uniacid,
                            "orderid" => $order2['order_id'],
                            "uid" => $new_user['id'],
                            "type" => "add",
                            "score" => $hasscoreback,
                            "message" => "买送积分",
                            "creattime" => time()
                        );
                        pdo_insert("sudu8_page_score", $scoreback_data);
                    } 
                }
                
            }
            

            // 核销完成后去检测要不要进行分销商返现
            $orderinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $uniacid,':id' => $order));
            $order_id = $orderinfo['order_id'];
            $openid = $orderinfo['openid'];

            $fxsorder = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$order_id));
            if($fxsorder){
                dopagegivemoney($openid,$order_id);
            }

            message('核销成功!', $this->createWebUrl('Orderset', array('opt'=>'fahuosp','op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }
        if($opt == "fh"){  
            $flag = pdo_getcolumn("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$id), 'flag');
            if($flag == 6){
            message('发货失败！订单状态发送改变!',$this->createWebUrl('Orderset', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])),'error');
            }
            $order = $_GPC['order'];
            $data['flag'] = 2;
            $res = pdo_update('sudu8_page_duo_products_order', $data, array('id' => $order));

            message('成功!', $this->createWebUrl('Orderset', array('opt'=>'fahuosp','op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }
        if($opt == "fahuo"){  //发货
            $order = $_GPC['orderid'];
            $flag = pdo_getcolumn("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order), 'flag');
            if($flag == 6){
            message('发货失败！订单状态未发生改变!',$this->createWebUrl('Orderset', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])),'error');
            }
            $data['hxtime'] = time();
            $data['kuadi'] = $_GPC['kuadi'];
            $data['kuaidihao'] = $_GPC['kuaidihao'];
            $data['flag'] = 4;
            pdo_update("sudu8_page_duo_products_order",$data,array('id'=>$order));
            $info = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order));
            if($info['hwq'] == 1 ){
                $yunfei = 0;
                if(!empty($info['yhInfo'])){
                    $yhinfo = unserialize($info['yhInfo']);
                    if(isset($yhinfo['yunfei'])){
                        $yunfei = $yhinfo['yunfei'];
                    }
                }
                $status = 4;//status订单状态，3：支付完成 4：已发货 5：已退款 100: 已完成
                $kd_arr = [
                        'EMS' => 2000,
                        '圆通' => 2001,
                        'DHL' => 2002,
                        '中通' => 2004,
                        '韵达' => 2005,
                        '畅灵' => 2006,
                        '百世汇通' => 2008,
                        '德邦' => 2009,
                        '申通' => 2010,
                        '顺丰速运' => 2011,
                        '顺兴' => 2012,
                        '如风达' => 2014,
                        '优速' => 2015
                    ];
                $kd_id = isset($kd_arr[$info['kuadi']]) ? $kd_arr[$info['kuadi']] : 9999;
                $kuaidi = $info['kuadi'];
                $kuaidihao = $info['kuaidihao'] != '' ? $info['kuaidihao'] : '暂无物流信息';
                $status = 4;//status订单状态，3：支付完成 4：已发货 5：已退款 100: 已完成
                $beizhu_val = $info['liuyan'];
                $jsondata = unserialize($info['jsondata']);
                $num = 0;
                $pid = 0;
                foreach($jsondata as $v){
                    $num = $num + $v['num'];
                    $pid = $v['pvid'];
                }
                mall($info['openid'], $info['order_id'], $info['price'], $status, 'duo', $pid, $num,  $yunfei, $kd_id, $kuaidi, $kuaidihao, $beizhu_val);
            }
            message('成功!', $this->createWebUrl('Orderset', array('opt'=>'fahuosp','op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        //取消订单
        if($opt == "quxiao" || $opt == "confirmtk"){  //取消
            $order_id = $_GPC['orderid'];
       
            //微信退款
            if($_GPC['qxbeizhu']){
                $data['qxbeizhu'] = $_GPC['qxbeizhu'];
            }
            $now = time();
            $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
            $data['th_orderid'] = $out_refund_no;
            pdo_update("sudu8_page_duo_products_order", $data, array("uniacid"=>$uniacid, "id"=>$order_id));
            $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order_id));

            $types = ($opt == "confirmtk") ? "duotk" : "duoqx";

            if($order['payprice'] > 0){
                require_once ROOT_PATH."WeixinRefund.php";
                $app = pdo_get("account_wxapp", array("uniacid"=>$uniacid));
                $paycon = pdo_get("uni_settings", array("uniacid"=>$uniacid));
                $datas = unserialize($paycon['payment']);
                $appid = $app['key'];  
                $mch_id = $datas['wechat']['mchid'];
                $zfkey = $datas['wechat']['signkey'];
                $refund_fee = intval($order['payprice'] * 100);
                $weixinrefund = new WeixinRefund($appid, $zfkey, $mch_id, $order['order_id'], $out_refund_no, $refund_fee, $refund_fee, $uniacid, $types);
                $return = $weixinrefund->refund();

                if(!$return){
                    message('退货失败!请检查系统设置->小程序设置和支付设置');
                }else if($return['result_code'] == "FAIL"){
                    message('退货失败!'.$return['err_code_des']);
                }else if($return['return_code'] == "FAIL"){
                    message('退货失败!'.$return['return_msg']);
                }else{
                    //金钱流水
                    $xfmoney = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $order['uid'],
                        "type" => "add",
                        "score" => $order['payprice'],
                        "message" => "退款退回微信",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_money", $xfmoney);

                    $tk_je = $order['price'] - $order['payprice']; //退回余额
                    if($tk_je > 0){
                        $xfmoney1 = array(
                            "uniacid" => $uniacid,
                            "orderid" => $order['order_id'],
                            "uid" => $order['uid'],
                            "type" => "add",
                            "score" => $tk_je,
                            "message" => "退款退回余额",
                            "creattime" => time()
                        );
                        pdo_insert("sudu8_page_money", $xfmoney1);
                    }
                }
            }else{
                if($opt == "confirmtk"){
                    pdo_update("sudu8_page_duo_products_order", array("flag"=>8), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                }else{
                    pdo_update("sudu8_page_duo_products_order", array("flag"=>5), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                }

                //金钱流水
                if($order['price'] > 0){
                    $xfmoney = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $order['uid'],
                        "type" => "add",
                        "score" => $order['price'],
                        "message" => "退款退回余额",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_money", $xfmoney);
                }


                pdo_query("UPDATE ".tablename("sudu8_page_user")." SET money = money + ".$order['price']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                
                if($order['coupon']){
                    pdo_update("sudu8_page_coupon_user", array("flag"=>0), array("uniacid"=>$uniacid, "uid"=>$order['uid'], "id"=>$order['coupon']));
                }
                if($order['jf']){
                    pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score + ".$order['jf']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                    $score_data = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $order['uid'],
                        "type" => "add",
                        "score" => $order['jf'],
                        "message" => "退款退回抵扣积分",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_score", $score_data);
                }

                $scoreback = pdo_get("sudu8_page_score", array("uniacid"=>$uniacid, "uid"=>$order["uid"], "orderid"=>$order['order_id'], "type"=>"add", "message"=>"买送积分"));
                if($scoreback){
                    pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score - ".$scoreback['score']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                    $score_data2 = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $order['uid'],
                        "type" => "del",
                        "score" => $scoreback['score'],
                        "message" => "退款扣除买送积分",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_score", $score_data2);
                }

                $fmsg = "";
                $jsondata = unserialize($order['jsondata']);
                foreach($jsondata as $key => &$value){
                    if($key != 0){
                        $fmsg .= "\\n";
                    }
                    $fmsg .= $value['baseinfo']['title'] . "（" . chop($value['proinfo']['ggz'],',') . "） ×" .$value['num'];
                    $res1 = pdo_query("UPDATE ".tablename("sudu8_page_duo_products_type_value")." SET kc = kc + ".$value['num'].",salenum = salenum - ".$value['num']." WHERE id = :id", array(":id"=>$value['proinfo']['id']));
                    $res2 = pdo_query("UPDATE ".tablename("sudu8_page_products")." SET sale_tnum = sale_tnum - ".$value['num']." WHERE id = :id", array(":id"=>$value['pvid']));
                    $sale_tnum = pdo_getcolumn("sudu8_page_products", array('id' => $value['pvid']),"sale_tnum");
                }

                $flag = 9;
                if($order['qx_formid']){
                    $refund_type = ($opt == "confirmtk") ? "退回到余额" : "退回到余额（商家主动取消订单）";
                    sendTplMessage($flag, $order['openid'], $order['qx_formid'], $types, array("orderid"=>$order['order_id'], "fmsg"=>$fmsg, "fprice"=>$order['price'], "refund_type"=>$refund_type));
                }
            }
            message('取消成功!', $this->createWebUrl('Orderset', array('opt'=>'fahuosp','op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }       
        //取消订单end

        // 处理已发货并且过了7天还没有确定的订单
        $clorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and flag = 4" , array(':uniacid' => $_W['uniacid']));
        foreach ($clorders as $key => &$res) {
            $st = $res['hxtime'] + 3600*24*7;
            if($st < time()){
                $adata = array(
                    "hxtime" => $st,
                    "flag" => 2
                );
                pdo_update("sudu8_page_duo_products_order",$adata,array('id'=>$res['id']));

                // 核销完成后去检测要不要进行分销商返现
                // $order_id = $res['order_id'];
                // $openid = $res['openid'];

                // $fxsorder = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$order_id));
                // if($fxsorder){
                //     $this->dopagegivemoney($openid,$order_id);
                // }

            }
        }
        // 处理30分钟未付款的订单
        $wforders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and flag = 0" , array(':uniacid' => $_W['uniacid']));
        foreach ($wforders as $key => &$res) {
            $st = $res['creattime'] + 1800;
            if($st < time()){
                $adata = array(
                    "flag" => 3
                );
                pdo_update("sudu8_page_duo_products_order",$adata,array('id'=>$res['id']));
                pdo_update("sudu8_page_fx_ls",$adata,array('uniacid' => $uniacid,'orderid'=>$res['order_id']));

            }
        }


        $order_id = $_GPC['order_id'];

    if($opt == "ziti"){  //
        $search_flag = $_GPC['search_flag'];
        $start_get = $_GPC['start_get'];
        $end_get = $_GPC['end_get'];
        $search_type = $_GPC['search_type'];
        $search_keys = $_GPC['search_keys'];
        $where = "";
        if($search_flag != null && $search_flag != 'undefined' && $search_flag != undefined){
            $where .= "and a.flag = ".$_GPC['search_flag'];
        }
        if(!empty($_GPC['start_get'])){//时间开始
            $where .= ' and a.creattime >= '.strtotime($_GPC['start_get']);
        }
        if(!empty($_GPC['end_get'])){//时间结束
            $where .= ' and a.creattime <= '.strtotime($_GPC['end_get']);
        }
        if(!empty($_GPC['search_keys'])){
            if(!empty($_GPC['search_type'])){
                if($search_type == 1){ //订单号
                    $where .= ' and a.order_id like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 2){
                    $where .= ' and b.name like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 3){
                    $where .= ' and b.mobile like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 4){
                    $where .= " and (b.address like '%".trim($_GPC['search_keys'])."%' or b.more_address like '%".trim($_GPC['search_keys'])."%')";
                }
            }
        }
            $all = pdo_fetchall("SELECT a.id FROM ".tablename('sudu8_page_duo_products_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.nav = 2 ".$where." order by a.creattime desc" , array(':uniacid' => $_W['uniacid']));
            $total = count($all);
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $p = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);  
            $orders = pdo_fetchall("SELECT a.* FROM ".tablename('sudu8_page_duo_products_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.nav = 2 ".$where." order by a.creattime desc LIMIT " . $p . "," . $pagesize,  array(':uniacid' => $_W['uniacid']));
            
            foreach ($orders as $key => &$res) {
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;

                if($res['hxinfo'] != ""){
                    $res['hxinfo'] = unserialize($res['hxinfo']);
                     if($res['hxinfo'][0]==1){
                         $res['hxinfo2']="总账号核销密码或后台核销";
                     }else{
                        $store = pdo_get("sudu8_page_store", ['id' => $res['hxinfo'][1], 'uniacid' => $uniacid]);
                        $staff = pdo_get("sudu8_page_staff", ['id' => $res['hxinfo'][2], 'uniacid' => $uniacid]);
                        $res['hxinfo2']="门店：".$store['title']." 员工：".$staff['realname'];
                     }
                }

                // 重新算总价
                $allprice = 0;
                foreach ($res['jsondata'] as $key2 => &$reb) {
                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                    if($reb['proinfo']['thumb'] && !strstr($reb['proinfo']['thumb'], "http")){
                        $reb['proinfo']['thumb'] = HTTPSHOST . $reb['proinfo']['thumb'];
                    }

                    if($reb['baseinfo']['thumb'] && !strstr($reb['baseinfo']['thumb'], "http")){
                        $reb['baseinfo']['thumb'] = HTTPSHOST . $reb['baseinfo']['thumb'];
                    }
                }
                $res['allprice'] = $allprice;

                // 积分转钱
                //积分转换成金钱
                $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
                if(!$jf_gz){
                    $gzscore = 10000;
                    $gzmoney = 1;
                }else{
                    $gzscore = $jf_gz['scroe'];
                    $gzmoney = $jf_gz['money'];
                }
                $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;


                // 转换地址
                if(empty($res['m_address'])){
                    $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
                }else{
                    $res['address_get'] = unserialize($res['m_address']);
                }
            }
    }

    if($opt == "fahuosp"){  //
        $search_flag = $_GPC['search_flag'];
        $start_get = $_GPC['start_get'];
        $end_get = $_GPC['end_get'];
        $search_type = $_GPC['search_type'];
        $search_keys = $_GPC['search_keys'];
        $where = "";
        if($search_flag != null && $search_flag != 'undefined' && $search_flag != undefined){
            $where .= "and flag = ".$_GPC['search_flag'];
        }
        if(!empty($_GPC['start_get'])){//时间开始
            $where .= ' and a.creattime >= '.strtotime($_GPC['start_get']);
        }
        if(!empty($_GPC['end_get'])){//时间结束
            $where .= ' and a.creattime <= '.strtotime($_GPC['end_get']);
        }
        if(!empty($_GPC['search_keys'])){
            if(!empty($_GPC['search_type'])){
                if($search_type == 1){ //订单号
                    $where .= ' and a.order_id like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 2){
                    $where .= ' and b.name like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 3){
                    $where .= ' and b.mobile like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 4){
                    $where .= " and (b.address like '%".trim($_GPC['search_keys'])."%' or b.more_address like '%".trim($_GPC['search_keys'])."%')";
                }
            }
        }
        $all = pdo_fetchall("SELECT a.id FROM ".tablename('sudu8_page_duo_products_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.nav = 1 ".$where." order by a.creattime desc" , array(':uniacid' => $_W['uniacid']));
        $total = count($all);
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $p = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize);  
        $orders = pdo_fetchall("SELECT a.* FROM ".tablename('sudu8_page_duo_products_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.nav = 1 ".$where." order by a.creattime desc LIMIT " . $p . "," . $pagesize,  array(':uniacid' => $_W['uniacid']));

        foreach ($orders as $key => &$res) {
            $res['jsondata'] = unserialize($res['jsondata']);
            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
            $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
            $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
            $res['counts'] = count($res['jsondata']);
            $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
            $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
            $res['couponinfo'] = $couponinfo;

            // 重新算总价
            $allprice = 0;
            foreach ($res['jsondata'] as $key2 => &$reb) {
                $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                if($reb['proinfo']['thumb'] && !strstr($reb['proinfo']['thumb'], "http")){
                    $reb['proinfo']['thumb'] = HTTPSHOST . $reb['proinfo']['thumb'];
                }

                if($reb['baseinfo']['thumb'] && !strstr($reb['baseinfo']['thumb'], "http")){
                    $reb['baseinfo']['thumb'] = HTTPSHOST . $reb['baseinfo']['thumb'];
                }
            }
            $res['allprice'] = $allprice;

            // 积分转钱
            //积分转换成金钱
            $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
            if(!$jf_gz){
                $gzscore = 10000;
                $gzmoney = 1;
            }else{
                $gzscore = $jf_gz['scroe'];
                $gzmoney = $jf_gz['money'];
            }
            $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;


            // 转换地址
            if(empty($res['m_address'])){
                $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
            }else{
                $res['address_get'] = unserialize($res['m_address']);
            }
            if($res['formid']){
                $res['formcon'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formcon') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid,':id'=>$res['formid']));
                $res['formcon'] = unserialize($res['formcon']['val']);
                foreach ($res['formcon'] as $k => $vi) {
                    if($vi['z_val']){
                        foreach ($vi['z_val'] as $kv => $vv) {
                            if(strpos($vv,'http')===false){
                                $res['formcon'][$k]['z_val'][$kv] = HTTPSHOST.$vv;
                            }else{
                                $res['formcon'][$k]['z_val'][$kv] = $vv;
                            }
                        }
                    }
                }
            }
            if(!empty($res['yhInfo'])){
                $yhInfo = unserialize($res['yhInfo']);
                $res['yhInfo_yunfei'] = $yhInfo['yunfei'];
                $res['yhInfo_score'] = $yhInfo['score'];
                $res['yhInfo_yhq'] = $yhInfo['yhq'];
                $res['yhInfo_mj'] = $yhInfo['mj'];
            }else{
                $res['yhInfo_yunfei'] = 0;
                if($res['dkscore'] > 0){
                    $jfgz = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
                    $res['yhInfo_score']['msg'] = $res['dkscore']."抵扣".floatval($res['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                    $res['yhInfo_score']['money'] = floatval($res['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                }else{
                    $res['yhInfo_score']['msg'] = "未使用积分";
                    $res['yhInfo_score']['money'] = 0;
                }
                if($res['couponinfo']){
                    $res['yhInfo_yhq']['msg'] = $res['couponinfo']['title'];
                    $res['yhInfo_yhq']['money'] = $res['couponinfo']['price'];
                }else{
                    $res['yhInfo_yhq']['msg'] = "未使用优惠券";
                    $res['yhInfo_yhq']['money'] = 0;
                }
                $res['yhInfo_mj']['msg'] = "";
                $res['yhInfo_mj']['money'] = 0;
            }
        }
    }

    if($opt == 'excel'){
        $search_flag = $_GPC['search_flag'];
        $start_get = $_GPC['start_get'];
        $end_get = $_GPC['end_get'];
        $search_type = $_GPC['search_type'];
        $search_keys = $_GPC['search_keys'];
        $where = "";
        if($search_flag != null && $search_flag != 'undefined' && $search_flag != undefined){
            $where .= "and a.flag = ".$_GPC['search_flag'];
        }
        if(!empty($_GPC['start_get'])){//时间开始
            $where .= ' and a.creattime >= '.strtotime($_GPC['start_get']);
        }
        if(!empty($_GPC['end_get'])){//时间结束
            $where .= ' and a.creattime <= '.strtotime($_GPC['end_get']);
        }
        if(!empty($_GPC['search_keys'])){
            if(!empty($_GPC['search_type'])){
                if($search_type == 1){ //订单号
                    $where .= ' and a.order_id like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 2){
                    $where .= ' and b.name like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 3){
                    $where .= ' and b.mobile like "%'.$_GPC['search_keys'].'%"';
                }else if($search_type == 4){
                    $where .= " and (b.address like '%".trim($_GPC['search_keys'])."%' or b.more_address like '%".trim($_GPC['search_keys'])."%')";
                }
            }
        }
        $all = pdo_fetchall("SELECT a.id FROM ".tablename('sudu8_page_duo_products_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid ".$where." order by a.creattime desc" , array(':uniacid' => $_W['uniacid']));
        $total = count($all);
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $p = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize);  
        $orders = pdo_fetchall("SELECT a.* FROM ".tablename('sudu8_page_duo_products_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid ".$where." order by a.creattime desc ",  array(':uniacid' => $_W['uniacid']));

        include MODULE_ROOT.'/plugin/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new \PHPExcel();

        /*以下是一些设置*/
        $objPHPExcel->getProperties()->setCreator("商城订单记录")
            ->setLastModifiedBy("商城订单记录")
            ->setTitle("商城订单记录")
            ->setSubject("商城订单记录")
            ->setDescription("商城订单记录")
            ->setKeywords("商城订单记录")
            ->setCategory("商城订单记录");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '时间');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '订单号');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '商品信息');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '单价');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '营销活动');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '运费');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '总价');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '实付金额');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '联系方式');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '联系地址');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '状态');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '快递');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '快递号');
        foreach ($orders as $key => &$res) {
            $res['jsondata'] = unserialize($res['jsondata']);
            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
            $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
            $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
            $res['counts'] = count($res['jsondata']);
            $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
            $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
            $res['couponinfo'] = $couponinfo;

            // 重新算总价
            $allprice = 0;
            $goodsinfo = '';
            foreach ($res['jsondata'] as $key2 => &$reb) {
                $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                if($reb['proinfo']['thumb'] && !strstr($reb['proinfo']['thumb'], "http")){
                    $reb['proinfo']['thumb'] = HTTPSHOST . $reb['proinfo']['thumb'];
                }
                $goodsinfo = '标题：'.$goodsinfo.$reb['proinfo']['title'].'、数量：'.$reb['num'].'、规格:'.$reb['proinfo']['ggz'];
                if($reb['baseinfo']['thumb'] && !strstr($reb['baseinfo']['thumb'], "http")){
                    $reb['baseinfo']['thumb'] = HTTPSHOST . $reb['baseinfo']['thumb'];
                }
            }
            $res['allprice'] = $allprice;



            // 积分转钱
            //积分转换成金钱
            $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
            if(!$jf_gz){
                $gzscore = 10000;
                $gzmoney = 1;
            }else{
                $gzscore = $jf_gz['scroe'];
                $gzmoney = $jf_gz['money'];
            }
            $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;


            // 转换地址
            if($res['address'] != '0'){
                $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
            }else{
                $res['address_get'] = unserialize($res['m_address']);
            }
            if($res['formid']){
                $res['formcon'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formcon') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid,':id'=>$res['formid']));
                $res['formcon'] = unserialize($res['formcon']['val']);
                foreach ($res['formcon'] as $k => $vi) {
                    if($vi['z_val']){
                        foreach ($vi['z_val'] as $kv => $vv) {
                            if(strpos($vv,'http')===false){
                                $res['formcon'][$k]['z_val'][$kv] = HTTPSHOST.$vv;
                            }else{
                                $res['formcon'][$k]['z_val'][$kv] = $vv;
                            }
                        }
                    }
                }
            }
            if(!empty($res['yhInfo'])){
                $yhInfo = unserialize($res['yhInfo']);
                $res['yhInfo_yunfei'] = $yhInfo['yunfei'];
                $res['yhInfo_score'] = $yhInfo['score'];
                $res['yhInfo_yhq'] = $yhInfo['yhq'];
                $res['yhInfo_mj'] = $yhInfo['mj'];
            }else{
                $res['yhInfo_yunfei'] = 0;
                if($res['dkscore'] > 0){
                    $jfgz = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
                    $res['yhInfo_score']['msg'] = $res['dkscore']."抵扣".floatval($res['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                    $res['yhInfo_score']['money'] = floatval($res['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                }else{
                    $res['yhInfo_score']['msg'] = "未使用积分";
                    $res['yhInfo_score']['money'] = 0;
                }
                if($res['couponinfo']){
                    $res['yhInfo_yhq']['msg'] = $res['couponinfo']['title'];
                    $res['yhInfo_yhq']['money'] = $res['couponinfo']['price'];
                }else{
                    $res['yhInfo_yhq']['msg'] = "未使用优惠券";
                    $res['yhInfo_yhq']['money'] = 0;
                }
                $res['yhInfo_mj']['msg'] = "";
                $res['yhInfo_mj']['money'] = 0;
            }

                $num=$key+2;
                if($res['flag'] == -2){
                    $res['flag1'] = '订单无效';
                }else if($res['flag'] == -1){
                    $res['flag1'] = '已关闭';
                }else if($res['flag'] == 0){
                    $res['flag1'] = '未支付';
                }else if($res['flag'] == 1 && $res['nav'] == 1){
                    $res['flag1'] = '待发货';
                }else if($res['flag'] == 1 && $res['nav'] == 2){
                    $res['flag1'] = '待消费';
                }else if($res['flag'] == 2){
                    $res['flag1'] = '完成';
                }else if($res['flag'] == 3){
                    $res['flag1'] = '已过期';
                }else if($res['flag'] == 4){
                    $res['flag1'] = '已发货';
                }else if($res['flag'] == 5){
                    $res['flag1'] = '已取消';
                }else if($res['flag'] == 6){
                    $res['flag1'] = '取消中';
                }else if($res['flag'] == 7){
                    $res['flag1'] = '退货中';
                }else if($res['flag'] == 8){
                    $res['flag1'] = '退货成功';
                }else if($res['flag'] == 9){
                    $res['flag1'] = '退货失败';
                }

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValueExplicit('A'.$num, $res['creattime'],'s')
                            ->setCellValueExplicit('B'.$num, $res['order_id'],'s')
                            ->setCellValueExplicit('C'.$num, $goodsinfo,'s') 
                            ->setCellValueExplicit('D'.$num, $res['price'],'s')
                            ->setCellValueExplicit('E'.$num, '运费：'.$res['yhInfo_yunfei'].'、优惠券：'.$res['yhInfo_yhq']['msg'].'、积分：'.$res['yhInfo_score']['msg'].'、满减：'.$res['yhInfo_mj']['msg'], 's')
                            ->setCellValueExplicit('F'.$num, $res['yhInfo_yunfei'], 's')
                            ->setCellValueExplicit('G'.$num, $res['allprice'], 's')
                            ->setCellValueExplicit('H'.$num, $res['price'], 's')
                            ->setCellValueExplicit('I'.$num, $res['address_get']['name'], 's')
                            ->setCellValueExplicit('J'.$num, $res['address_get']['mobile'], 's')
                            ->setCellValueExplicit('K'.$num, $res['address_get']['address'].$res['address_get']['more_address'], 's')
                            ->setCellValueExplicit('L'.$num, $res['flag1'], 's')
                            ->setCellValueExplicit('M'.$num, $res['kuadi'], 's')
                            ->setCellValueExplicit('N'.$num, $res['kuaidihao'], 's');
                  
            }

            $objPHPExcel->getActiveSheet()->setTitle('导出商城订单');
            $objPHPExcel->setActiveSheetIndex(0);
            $excelname="商城订单记录表";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
    }


    if($opt == 'allowth'){
        $order_id = $_GPC['order'];
        //微信退款
        $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order_id), array("price", "order_id", "payprice"));
        $now = time();
        $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
        pdo_update("sudu8_page_duo_products_order", array("th_orderid"=>$out_refund_no), array("uniacid"=>$uniacid, "id"=>$order_id));

        if($order['payprice'] > 0){
            require_once ROOT_PATH."WeixinRefund.php";
            $app = pdo_get("account_wxapp", array("uniacid"=>$uniacid));
            $paycon = pdo_get("uni_settings", array("uniacid"=>$uniacid));
            $datas = unserialize($paycon['payment']);
            $appid = $app['key'];  
            $mch_id = $datas['wechat']['mchid'];
            $zfkey = $datas['wechat']['signkey'];
            $refund_fee = intval($order['payprice'] * 100);
            $weixinrefund = new WeixinRefund($appid, $zfkey, $mch_id, $order['order_id'], $out_refund_no, $refund_fee, $refund_fee, $uniacid, "duo");
            $return = $weixinrefund->refund();

            if(!$return){
                message('取消失败!请检查系统设置->小程序设置和支付设置');
            }

        }else{
            pdo_update("sudu8_page_duo_products_order", array("flag"=>8), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
            $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));

            pdo_query("UPDATE ".tablename("sudu8_page_user")." SET money = money + ".$order['price']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
            
            if($order['coupon']){
                pdo_update("sudu8_page_coupon_user", array("flag"=>0, "utime" => 0), array("uniacid"=>$uniacid, "uid"=>$order['uid'], "id"=>$order['coupon']));
            }
            if($order['jf']){
                pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score + ".$order['jf']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                $score_data = array(
                    "uniacid" => $uniacid,
                    "orderid" => $order_id,
                    "uid" => $order['uid'],
                    "type" => "add",
                    "score" => $order['jf'],
                    "message" => "退款退回抵扣积分",
                    "creattime" => time()
                );
                pdo_insert("sudu8_page_score", $score_data);
            }

            $scoreback = pdo_get("sudu8_page_score", array("uniacid"=>$uniacid, "uid"=>$order["uid"], "orderid"=>$order['order_id'], "type"=>"add", "message"=>"买送积分"));
            if($scoreback){
                pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score - ".$scoreback['score']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                $score_data2 = array(
                    "uniacid" => $uniacid,
                    "orderid" => $order_id,
                    "uid" => $order['uid'],
                    "type" => "del",
                    "score" => $scoreback['score'],
                    "message" => "退款扣除买送积分",
                    "creattime" => time()
                );
                pdo_insert("sudu8_page_score", $score_data2);
            }
            
            $jsondata = unserialize($order['jsondata']);
            foreach($jsondata as $key => &$value){
                pdo_query("UPDATE ".tablename("sudu8_page_duo_products_type_value")." SET kc = kc + ".$value['num']." WHERE id = :id", array(":id"=>$value['proinfo']['id']));

            }

        }

        message('取消成功!', $this->createWebUrl('Orderset', array('opt'=>'fahuosp','op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }


    if($opt == 'refuseth'){
        $order_id = $_GPC['order'];
        pdo_update("sudu8_page_duo_products_order", array("flag"=>9), array("uniacid"=>$uniacid, "id"=>$order_id));
        message('拒绝取消成功!', $this->createWebUrl('Orderset', array('opt'=>'fahuosp','op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }

    if($opt == 'refuseqx'){
        $order_id = $_GPC['orderid'];
        pdo_update("sudu8_page_duo_products_order", array("flag"=>1), array("uniacid"=>$uniacid, "id"=>$order_id));
        message('拒绝取消成功!', $this->createWebUrl('Orderset', array('opt'=>'fahuosp','op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }

return include self::template('web/Orderset/orderdo');
