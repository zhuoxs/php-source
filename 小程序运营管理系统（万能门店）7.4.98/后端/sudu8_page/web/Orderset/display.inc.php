<?php 
    define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');
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
            if($protype == 'miaosha'){
                $protype = 'showPro';
            }else if($protype == 'yuyue'){
                $protype = 'showPro_lv';
            }else if($protype == 'duo'){
                $protype = 'showProMore';
            }
            $proinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ":id" => $pid));
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
//不带报头的curl
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
            }
        }
    }
}


		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $opts = array('display', 'yh', 'hx', 'qx', 'fahuo', 'refuseqx', 'confirmtk','excel');
        $opt = in_array($opt, $opts) ? $opt : 'display';
        $order = $_GPC['order'];

        if($opt == "hx"){
            $data['custime'] = time();
            $data['hxinfo'] = 'a:1:{i:0;i:1;}';
            $flag = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$order), 'flag');
            if($flag == 6){
            message('核销失败！订单状态发送改变!',$this->createWebUrl('Orderset', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])),'error');
            }
            $data['flag'] = 2;

            $res = pdo_update('sudu8_page_order', $data, array('id' => $order));
            $info = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_order')." WHERE id = :id", array(':id' => $order));
            addAllpay($info['true_price'], $info['openid']);
            checkVipGrade($info['openid']);
            if($info['hwq'] == 1){
                $yunfei = 0;
                $kd_id = 9999;
                $kuaidi = '暂无物流信息';
                $kuaidihao = '暂无物流信息';
                $status = 100;//status订单状态，3：支付完成 4：已发货 5：已退款 100: 已完成
                $beizhu_val = $info['beizhu_val'];
                mall($info['openid'], $info['order_id'], $info['true_price'], $status, 'miaosha', $info['pid'], $info['num'],  $yunfei, $kd_id, $kuaidi, $kuaidihao, $beizhu_val);
            }
            //购买送积分
            $order2 = pdo_get("sudu8_page_order", array("uniacid" => $uniacid, "id"=>$order));
            $scoreback = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order2['pid']), "scoreback");
            if(!empty($scoreback)){
                if(strpos($scoreback, "%")){
                    $scoreback = floatval(chop($scoreback, "%"));
                    $scoretomoney = pdo_get("sudu8_page_rechargeconf", array("uniacid" => $uniacid));
                    $scoreback = floatval($order2['price']) * intval($order2['num']) * $scoreback / 100;
                    // $scoreback = floor($scoreback * intval($scoretomoney['scroe']) / intval($scoretomoney['money']));
                    if($info['score_flag'] == 0 && $info['score_bei'] > 0){
                        $scoreback = floor($scoreback * intval($scoretomoney['scroe']) * $info['score_bei'] / intval($scoretomoney['money']));
                    }else{
                        $scoreback = floor($scoreback * intval($scoretomoney['scroe']) / intval($scoretomoney['money']));
                    }
                }else{
                    // $scoreback = floor(intval($order2['num']) * floatval($scoreback));
                    if($info['score_flag'] == 0 && $info['score_bei'] > 0){
                        $scoreback = floor(intval($order2['num']) * floatval($scoreback) * $info['score_bei']);
                    }else{
                        $scoreback = floor(intval($order2['num']) * floatval($scoreback));
                    }
                }
                if($scoreback > 0){
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
                        "score" => $scoreback,
                        "message" => "买送积分",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_score", $scoreback_data);
                } 
            }

            $order_dan = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$order));
            $openid = $order_dan['openid'];
            $fsorder = pdo_get("sudu8_page_fx_ls", array("uniacid"=>$uniacid, "order_id"=>$order_dan['order_id']));
            if($fsorder){
                dopagegivemoney($openid, $order_dan['order_id']);
            }
            message('核销成功!', $this->createWebUrl('Orderset', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
        if($opt == "display"){
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
                        $where .= " and a.order_id like '%".trim($_GPC['search_keys'])."%'";
                    }else if($search_type == 2){
                        $where .= " and b.name like '%".trim($_GPC['search_keys'])."%'";
                    }else if($search_type == 3){
                        $where .= " and b.mobile like '%".trim($_GPC['search_keys'])."%'";
                    }else if($search_type == 4){
                        $where .= " and (b.address like '%".trim($_GPC['search_keys'])."%' or b.more_address like '%".trim($_GPC['search_keys'])."%')";
                    }
                }
            }

            $all = pdo_fetchall("SELECT a.id FROM ".tablename('sudu8_page_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.is_more = 0 ".$where." ORDER BY a.creattime DESC ", array(':uniacid' => $uniacid));
            $total = count($all);
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;
            $p = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);  

            $orders = pdo_fetchall("SELECT a.* FROM ".tablename('sudu8_page_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.is_more = 0 ".$where." ORDER BY a.creattime DESC LIMIT " . $p . "," . $pagesize, array(':uniacid' => $uniacid));
            foreach ($orders as $k => &$res) {
                if(($content = @unserialize($res['beizhu_val'])) === false) {
                    if($res['beizhu_val']) {
                        $res['beizhu_val'] === 'undefined' ? '无' : $res['beizhu_val'];
                    } else {
                        $res['beizhu_val'] === "无";
                    }
                } else {
                    $res['beizhu_val'] === NULL ? "无" : $content;
                }


                // 转换地址
                if(empty($res['m_address'])){
                    $res['address'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
                }else{
                    $res['address'] = unserialize($res['m_address']);
                }
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
                $arr[$k] = array(
                    "id"=>$res['id'],
                    "order_id"=>$res['order_id'],
                    "pid"=>$res['pid'],
                    "thumb" => $_W['attachurl'].$res['thumb'],
                    "product"=>$res['product'],
                    "price"=>$res['price'],
                    "num"=>$res['num'],
                    "yhq"=>$res['yhq'],
                    "coupon"=>$res['coupon'],
                    "true_price"=>$res['true_price'],
                    "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                    "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                    "flag"=>$res['flag'],
                    "pro_user_name"=>$res['pro_user_name'],
                    "pro_user_tel"=>$res['pro_user_tel'],
                    "pro_user_add"=>$res['pro_user_add'],
                    "pro_user_txt"=>$res['pro_user_txt'],
                    "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                    "beizhu_val" => $res['beizhu_val']?$res['beizhu_val']:"",
                    "qxbeizhu" => $res['qxbeizhu'],
                    "nav" => $res['nav'],
                    "kuaidi" => $res['kuaidi'],
                    "kuaidihao" => $res['kuaidihao'],
                    "address" => $res['address'],
                    "hxinfo2" => $res['hxinfo2']
                );
                
                if($res['formid']){
                    $arr2 = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                    $arr[$k]['val'] = unserialize($arr2);
                }
                $arr[$k]['couponinfo'] = pdo_fetch("SELECT b.title,b.price FROM ".tablename('sudu8_page_coupon_user')." as a LEFT JOIN  ".tablename('sudu8_page_coupon')." as b on a.cid = b.id WHERE a.uniacid = :uniacid and a.flag = 1 and a.id=:coupon",array(":uniacid"=>$uniacid,":coupon"=>$res['coupon']));
                if(strpos($res['thumb'],"http")===false){
                    $arr[$k]['thumb'] = $_W['attachurl'].$res['thumb'];
                }else{
                    $arr[$k]['thumb'] = $res['thumb'];
                }

                if(!empty($res['yhInfo'])){
                    $yhInfo = unserialize($res['yhInfo']);
                    $arr[$k]['yhInfo_yunfei'] = $yhInfo['yunfei'];
                    $arr[$k]['yhInfo_score'] = $yhInfo['score'];
                    $arr[$k]['yhInfo_yhq'] = $yhInfo['yhq'];
                    $arr[$k]['yhInfo_mj'] = $yhInfo['mj'];
                }else{
                    $arr[$k]['yhInfo_yunfei'] = 0;
                    if($res['dkscore'] > 0){
                        $jfgz = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
                        $arr[$k]['yhInfo_score']['msg'] = $res['dkscore']."抵扣".floatval($res['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                        $arr[$k]['yhInfo_score']['money'] = floatval($res['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                    }else{
                        $arr[$k]['yhInfo_score']['msg'] = "未使用积分";
                        $arr[$k]['yhInfo_score']['money'] = 0;
                    }
                    if($arr[$k]['couponinfo']){
                        $arr[$k]['yhInfo_yhq']['msg'] = $arr[$k]['couponinfo']['title'];
                        $arr[$k]['yhInfo_yhq']['money'] = $arr[$k]['couponinfo']['price'];
                    }else{
                        $arr[$k]['yhInfo_yhq']['msg'] = "未使用优惠券";
                        $arr[$k]['yhInfo_yhq']['money'] = 0;
                    }
                    $arr[$k]['yhInfo_mj']['msg'] = "";
                    $arr[$k]['yhInfo_mj']['money'] = 0;
                }
            }
        }

        if($opt == "qx" || $opt == "confirmtk"){
            $order_id = $_GPC['orderid'];
            if($_GPC['qxbeizhu']){
                $data['qxbeizhu'] = $_GPC['qxbeizhu'];
            }
            $now = time();
            $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
            $data['th_orderid'] = $out_refund_no;
            pdo_update("sudu8_page_order", $data, array("uniacid"=>$uniacid, "id"=>$order_id));
            $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$order_id));


            $types = ($opt == "confirmtk") ? "dantk" : "danqx";
            

            if($order['pay_price'] > 0){
                require_once ROOT_PATH."WeixinRefund.php";
                $app = pdo_get("account_wxapp", array("uniacid"=>$uniacid));
                $paycon = pdo_get("uni_settings", array("uniacid"=>$uniacid));
                $datas = unserialize($paycon['payment']);
                $appid = $app['key'];  
                $mch_id = $datas['wechat']['mchid'];
                $zfkey = $datas['wechat']['signkey'];
                $refund_fee = intval($order['pay_price'] * 100);
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
                        "score" => $order['pay_price'],
                        "message" => "退款退回微信",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_money", $xfmoney);

                    $tk_je = $order['true_price'] - $order['pay_price']; //退回余额
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
                    pdo_update("sudu8_page_order", array("flag"=>8), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                }else{
                    pdo_update("sudu8_page_order", array("flag"=>5), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                }
                //金钱流水
                if($order['true_price'] > 0){
                    $xfmoney = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $order['uid'],
                        "type" => "add",
                        "score" => $order['true_price'],
                        "message" => "退款退回余额",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_money", $xfmoney);
                }
                $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));

                pdo_query("UPDATE ".tablename("sudu8_page_user")." SET money = money + ".$order['true_price']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                
                if($order['coupon']){
                    pdo_update("sudu8_page_coupon_user", array("flag"=>0,"utime" => 0), array("uniacid"=>$uniacid, "uid"=>$order['uid'], "id"=>$order['coupon']));
                }

                if($order['dkscore']){
                    pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score + ".$order['dkscore']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                    $score_data = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $order['uid'],
                        "type" => "add",
                        "score" => $order['dkscore'],
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
                
                if($order['num'] > 0){
                    $pro_kc = pdo_get("sudu8_page_products" ,array("uniacid" => $uniacid,"id" => $order['pid']));
                    if(intval($pro_kc['pro_kc']) != -1){
                        pdo_query("UPDATE ".tablename("sudu8_page_products")." SET pro_kc = pro_kc + ".$order['num']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order['pid']));
                    }
                    pdo_query("UPDATE ".tablename("sudu8_page_products")." SET sale_tnum = sale_tnum - ".$order['num']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order['pid']));
                   
                }


                $flag = 9;
                $refund_type = ($opt == "confirmtk") ? "退回到余额" : "退回到余额（商家主动取消订单）";
                $fmsg = $order['product'];
                sendTplMessage($flag, $order['openid'], $order['qx_formid'], $types, array("orderid"=>$order['order_id'], "fmsg"=>$fmsg, "fprice"=>$order['price'], "refund_type"=>$refund_type));

            }

            
            message('取消成功!', $this->createWebUrl('Orderset', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }


        if($opt == "fahuo"){
        	$id = $_GPC['orderid'];
        	$data = array(
                'custime' => time(),
        		'kuaidi' => $_GPC['kuaidi'],
        		'kuaidihao' => $_GPC['kuaidihao'],
        		'flag' => 4
        	);

            $flag = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$id), 'flag');
            if($flag == 6){
            message('发货失败！订单状态发送改变!',$this->createWebUrl('Orderset', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])),'error');
            }

            pdo_update("sudu8_page_order", $data, array("uniacid"=>$uniacid, "id"=>$id));
            $info = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_order')." WHERE id = :id", array(':id' => $id));
            if($info['hwq'] == 1){
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
                $kd_id = isset($kd_arr[$info['kuaidi']]) ? $kd_arr[$info['kuaidi']] : 9999;
                $kuaidi = $info['kuaidi'];
                $kuaidihao = $info['kuaidihao'] != '' ? $info['kuaidihao'] : '暂无物流信息';
                $beizhu_val = $info['beizhu_val'];
                mall($info['openid'], $info['order_id'], $info['true_price'], $status, 'miaosha', $info['pid'], $info['num'], $yunfei, $kd_id, $kuaidi, $kuaidihao, $beizhu_val);
            }
            message('发货成功!', $this->createWebUrl('Orderset', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        if($opt == "refuseqx"){
            $order_id = $_GPC['orderid'];
            pdo_update("sudu8_page_order", array("flag"=>1), array("uniacid"=>$uniacid, "id"=>$order_id));
            message('拒绝取消成功!', $this->createWebUrl('Orderset', array('opt'=>'display','op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        if($opt == 'excel'){
            // $all = pdo_fetchall("SELECT a.id FROM ".tablename('sudu8_page_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.is_more = 0  ORDER BY a.creattime DESC ", array(':uniacid' => $uniacid));


            // $orders = pdo_fetchall("SELECT a.* FROM ".tablename('sudu8_page_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.is_more = 0  ORDER BY a.creattime DESC ", array(':uniacid' => $uniacid));

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
                        $where .= " and a.order_id like '%".trim($_GPC['search_keys'])."%'";
                    }else if($search_type == 2){
                        $where .= " and b.name like '%".trim($_GPC['search_keys'])."%'";
                    }else if($search_type == 3){
                        $where .= " and b.mobile like '%".trim($_GPC['search_keys'])."%'";
                    }else if($search_type == 4){
                        $where .= " and (b.address like '%".trim($_GPC['search_keys'])."%' or b.more_address like '%".trim($_GPC['search_keys'])."%')";
                    }
                }
            }

            $all = pdo_fetchall("SELECT a.id FROM ".tablename('sudu8_page_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.is_more = 0 ".$where." ORDER BY a.creattime DESC ", array(':uniacid' => $uniacid));
            $total = count($all);
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;
            $p = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);  

            $orders = pdo_fetchall("SELECT a.* FROM ".tablename('sudu8_page_order')." as a LEFT JOIN ".tablename('sudu8_page_duo_products_address')." as b on a.address = b.id WHERE a.uniacid = :uniacid and a.is_more = 0 ".$where." ORDER BY a.creattime DESC", array(':uniacid' => $uniacid));

            foreach ($orders as $k => &$res) {
                if($res['beizhu_val'] == 's:4:"NULL";' ||  $res['beizhu_val'] == 'undefined'){
                    $res['beizhu_val'] = "无";
                }
                if($res['address'] > 0){
                    $res['address'] = pdo_get("sudu8_page_duo_products_address", array("uniacid"=>$uniacid, "id"=>$res['address']));
                }

                $arr[$k] = array(
                    "id"=>$res['id'],
                    "order_id"=>$res['order_id'],
                    "pid"=>$res['pid'],
                    // "thumb" => $_W['attachurl'].$res['thumb'],
                    "product"=>$res['product'],
                    "price"=>$res['price'],
                    "num"=>$res['num'],
                    "yhq"=>$res['yhq'],
                    "coupon"=>$res['coupon'],
                    "true_price"=>$res['true_price'],
                    "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                    "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                    "flag"=>$res['flag'],
                    "pro_user_name"=>$res['pro_user_name'],
                    "pro_user_tel"=>$res['pro_user_tel'],
                    "pro_user_add"=>$res['pro_user_add'],
                    "pro_user_txt"=>$res['pro_user_txt'],
                    "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                    "beizhu_val" => $res['beizhu_val']?unserialize($res['beizhu_val']):"",
                    "qxbeizhu" => $res['qxbeizhu'],
                    "nav" => $res['nav'],
                    "kuaidi" => $res['kuaidi'],
                    "kuaidihao" => $res['kuaidihao'],
                    "address" => $res['address'],
                );
                
                if($res['formid']){
                    $arr2 = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                    $arr[$k]['val'] = unserialize($arr2);
                }



                $arr[$k]['couponinfo'] = pdo_fetch("SELECT b.title,b.price FROM ".tablename('sudu8_page_coupon_user')." as a LEFT JOIN  ".tablename('sudu8_page_coupon')." as b on a.cid = b.id WHERE a.uniacid = :uniacid and a.flag = 1 and a.id=:coupon",array(":uniacid"=>$uniacid,":coupon"=>$res['coupon']));

                if(!empty($res['yhInfo'])){
                    $yhInfo = unserialize($res['yhInfo']);
                    $arr[$k]['yhInfo_yunfei'] = $yhInfo['yunfei'];
                    $arr[$k]['yhInfo_score'] = $yhInfo['score'];
                    $arr[$k]['yhInfo_yhq'] = $yhInfo['yhq'];
                    $arr[$k]['yhInfo_mj'] = $yhInfo['mj'];
                }else{
                    $arr[$k]['yhInfo_yunfei'] = 0;
                    if($res['dkscore'] > 0){
                        $jfgz = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
                        $arr[$k]['yhInfo_score']['msg'] = $res['dkscore']."抵扣".floatval($res['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                        $arr[$k]['yhInfo_score']['money'] = floatval($res['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                    }else{
                        $arr[$k]['yhInfo_score']['msg'] = "未使用积分";
                        $arr[$k]['yhInfo_score']['money'] = 0;
                    }
                    if($arr[$k]['couponinfo']){
                        $arr[$k]['yhInfo_yhq']['msg'] = $arr[$k]['couponinfo']['title'];
                        $arr[$k]['yhInfo_yhq']['money'] = $arr[$k]['couponinfo']['price'];
                    }else{
                        $arr[$k]['yhInfo_yhq']['msg'] = "未使用优惠券";
                        $arr[$k]['yhInfo_yhq']['money'] = 0;
                    }
                    $arr[$k]['yhInfo_mj']['msg'] = "";
                    $arr[$k]['yhInfo_mj']['money'] = 0;
                }
            }

            include MODULE_ROOT.'/plugin/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new \PHPExcel();

            /*以下是一些设置*/
            $objPHPExcel->getProperties()->setCreator("限时秒杀记录")
                ->setLastModifiedBy("限时秒杀记录")
                ->setTitle("限时秒杀记录")
                ->setSubject("限时秒杀记录")
                ->setDescription("限时秒杀记录")
                ->setKeywords("限时秒杀记录")
                ->setCategory("限时秒杀记录");
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '时间');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '订单号');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '商品名');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '单价');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '数量');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '营销活动');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', '运费');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', '实付金额');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', '姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', '联系方式');
            $objPHPExcel->getActiveSheet()->setCellValue('K1', '联系地址');
            $objPHPExcel->getActiveSheet()->setCellValue('L1', '状态');
            $objPHPExcel->getActiveSheet()->setCellValue('M1', '万能表单提交信息');

            foreach($arr as $k => $v){
                $num=$k+2;

                // if($v['utime'] > 0){
                //     $utime = date("Y-m-d H:i:s", $v['utime']);
                // }else{
                //     $utime = "";
                // }

                if($v['flag'] == -2){
                    $v['flag1'] = '订单无效';
                }else if($v['flag'] == -1){
                    $v['flag1'] = '已关闭';
                }else if($v['flag'] == 0){
                    $v['flag1'] = '未支付';
                }else if($v['flag'] == 1 && $v['nav'] == 1){
                    $v['flag1'] = '待发货';
                }else if($v['flag'] == 1 && $v['nav'] == 2){
                    $v['flag1'] = '待消费';
                }else if($v['flag'] == 2){
                    $v['flag1'] = '完成';
                }else if($v['flag'] == 3){
                    $v['flag1'] = '已过期';
                }else if($v['flag'] == 4){
                    $v['flag1'] = '已发货';
                }else if($v['flag'] == 5){
                    $v['flag1'] = '已取消';
                }else if($v['flag'] == 6){
                    $v['flag1'] = '取消中';
                }else if($v['flag'] == 7){
                    $v['flag1'] = '退货中';
                }else if($v['flag'] == 8){
                    $v['flag1'] = '退货成功';
                }else if($v['flag'] == 9){
                    $v['flag1'] = '退货失败';
                }


                $forminfo = "";
                if(count($v['val']) > 0){
                    foreach ($v['val'] as $kk => $vv) {
                        if($vv['type']== 3){
                            $type3_info = "";
                            foreach ($vv['val'] as $key => $value) {
                                $type3_info = $type3_info.$value.",";
                            }

                            $forminfo = $forminfo.$vv['name'].":".$types3_info.";\r\n";
                        }
                        if($vv['type']== 5){
                            $type5_info = "";
                            foreach ($vv['z_val'] as $key => $value) {
                                $type5_info = $type5_info.$value.",";
                            }

                            $forminfo = $forminfo.$vv['name'].":".$type5_info.";\r\n";
                        }
                        if($vv['type']== 16){
                            $forminfo = $forminfo."表单说明：".$vv['val'].";\r\n";
                        }
                        if($vv['type'] != 5 && $vv['type'] != 3 && $vv['type'] != 16){
                            $forminfo = $forminfo.$vv['name']."：".$vv['val'].";\r\n";
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->getStyle("M".$num)->getAlignment()->setWrapText(true);

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValueExplicit('A'.$num, $v['creattime'],'s')
                            ->setCellValueExplicit('B'.$num, $v['order_id'],'s')
                            ->setCellValueExplicit('C'.$num, $v['product'],'s') 
                            ->setCellValueExplicit('D'.$num, $v['price'],'s')
                            ->setCellValueExplicit('E'.$num, $v['num'], 's')
                            ->setCellValueExplicit('F'.$num, '运费：'.$v['yhInfo_yunfei'].'、优惠券：'.$v['yhInfo_yhq']['msg'].'、积分：'.$v['yhInfo_score']['msg'].'、满减：'.$v['yhInfo_mj']['msg'], 's')
                            ->setCellValueExplicit('G'.$num, $v['yhInfo_yunfei'], 's')
                            ->setCellValueExplicit('H'.$num, $v['true_price'], 's')
                            ->setCellValueExplicit('I'.$num, $v['address']['name'], 's')
                            ->setCellValueExplicit('J'.$num, $v['address']['mobile'], 's')
                            ->setCellValueExplicit('K'.$num, $v['address']['address'].$v['address']['more_address'], 's')
                            ->setCellValueExplicit('L'.$num, $v['flag1'], 's')
                            ->setCellValueExplicit('M'.$num, $forminfo, 's');

                  
            }

            $objPHPExcel->getActiveSheet()->setTitle('导出限时秒杀');
            $objPHPExcel->setActiveSheetIndex(0);
            $excelname="限时秒杀记录表";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
       }


return include self::template('web/Orderset/display');
