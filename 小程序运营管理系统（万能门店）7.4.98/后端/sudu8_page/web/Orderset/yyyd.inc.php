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
function addAllpay($price,$openid){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $str = '论坛信息发布,微同城信息发布,文章全文,视频消费,音频消费,店内支付扣余额,店内支付微信支付';
        $userinfo = pdo_fetch("SELECT id,allpay,grade FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid ", array(':uniacid' => $uniacid, ':openid' => $openid));

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
global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $opts = array('display', 'yh', 'hx' , 'confirmqx', 'qx', 'queren', 'changedate', 'refuseqx', 'acceptmodify', 'refusemodify', 'record', 'excel');
        $opt = in_array($opt, $opts) ? $opt : 'display';
        $order = $_GPC['order'];
        if($opt == "hx"){
            $flag = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$order), 'flag');
            if($flag == 6){
            message('核销失败！订单状态发送改变!',$this->createWebUrl('Orderset', array('op'=>'yyyd','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])),'error');
            }
            $data['custime'] = time();
            $data['flag'] = 2;
            $data['hxinfo'] = 'a:1:{i:0;i:1;}';
            $res = pdo_update('sudu8_page_order', $data, array('id' => $order));
            $info = pdo_fetch("SELECT * FROM".tablename('sudu8_page_order')." WHERE id = :id", array(':id' => $order));
            addAllpay($info['true_price'], $info['openid']);
            checkVipGrade($info['openid']);
            if($info['hwq'] == 1){
                $yunfei = 0;
                $kd_id = 9999;
                $kuaidi = '暂无物流信息';
                $kuaidihao = '暂无物流信息';
                $status = 100;//status订单状态，3：支付完成 4：已发货 5：已退款 100: 已完成
                $beizhu_val = unserialize($info['beizhu_val']);
                if($info['tsid'] > 0){
                    $num = 1;
                    $allprice = $info['price'];
                }else{
                    $num = 0;
                    $order_duo = unserialize($info['order_duo']);
                    foreach ($order_duo as $key => $value) {
                        $num = $num + $value[4];
                    }
                    $allprice = $info['price'] * $num;
                }
                
                mall($info['openid'], $info['order_id'], $allprice, $status, 'yuyue', $info['pid'], $num,  $yunfei, $kd_id, $kuaidi, $kuaidihao, $beizhu_val);
            }
            message('核销成功!', $this->createWebUrl('Orderset', array('op'=>'yyyd','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        if($opt == "display"){
            $select_state = 99;
            $emps = pdo_getall("sudu8_page_staff", array("uniacid"=>$uniacid), array("id", "realname"));
            $order_id = $_GPC['order_id'];
            if($order_id){
                $orderinfo = pdo_fetchAll("SELECT id FROM ".tablename('sudu8_page_order')." WHERE order_id LIKE :order_id and uniacid = :uniacid  and is_more = 1", array(':order_id' => '%'.$order_id.'%' ,':uniacid' => $uniacid));
                $total = count($orderinfo);
                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize);  
                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id LIKE :order_id and uniacid = :uniacid  and is_more = 1  LIMIT " . $p . "," . $pagesize, array(':order_id' => '%'.$order_id.'%' ,':uniacid' => $uniacid));
                foreach ($orders as $k=> $res) {
                    if($res['emp_id']){
                        $emp = pdo_get("sudu8_page_staff", array("uniacid"=>$uniacid), array("id", "realname", "mobile"));
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

                    $arr[] = array(
                        "id"=>$res['id'],
                        "order_id"=>$res['order_id'],
                        "pid"=>$res['pid'],
                        "thumb" => $_W['attachurl'].$res['thumb'],
                        "product"=>$res['product'],
                        "price"=>$res['price'],
                        "num"=>$res['num'],
                        "yhq"=>$res['yhq'],
                        "true_price"=>$res['true_price'],
                        "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                        "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                        "flag"=>$res['flag'],
                        "pro_user_name"=>$res['pro_user_name'],
                        "pro_user_tel"=>$res['pro_user_tel'],
                        "pro_user_add"=>$res['pro_user_add'],
                        "pro_user_txt"=>$res['pro_user_txt'],
                        "appoint_date"=>$res['appoint_date'] == '0' ? 0 : date("Y-m-d H:i:s", $res['appoint_date']),
                        "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                        "coupon"=>$res['coupon'],
                        "order_duo"=>unserialize($res['order_duo']),
                        "emp_name" => $emp['realname'],
                        "emp_mobile" => $emp['mobile'],
                        "jf"=>$res['dkscore'],
                        "modify_info" => $res['modify_info'] ? unserialize($res['modify_info']) : "",
                        "hxinfo2" => $res['hxinfo2'],
                        "discounts" => $res['discounts']
                    );
                    if($res['formid']){
                        $arr2 = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                        $arr[$k]['val'] = unserialize($arr2);
                    }else{
                        $arr[$k]['val'] = unserialize($res['beizhu_val']);
                    }
                    $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'],':uniacid' => $uniacid));

                    $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                    $arr[$k]['couponinfo'] = $couponinfo;

                }
            }else{
                $all = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid  and is_more = 1 ORDER BY `creattime` DESC ", array(':uniacid' => $uniacid));
                $total = count($all);
                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize);  
                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid  and is_more = 1 ORDER BY `creattime` DESC LIMIT " . $p . "," . $pagesize, array(':uniacid' => $uniacid));
                foreach ($orders as $k=> $res) {
                    if($res['emp_id']){
                        $emp = pdo_get("sudu8_page_staff", array("uniacid"=>$uniacid), array("id", "realname", "mobile"));
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
                        "jf"=>$res['dkscore'],
                        "true_price"=>$res['true_price'],
                        "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                        "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                        "flag"=>$res['flag'],
                        "pro_user_name"=>$res['pro_user_name'],
                        "pro_user_tel"=>$res['pro_user_tel'],
                        "pro_user_add"=>$res['pro_user_add'],
                        "pro_user_txt"=>$res['pro_user_txt'],
                        "appoint_date"=>$res['appoint_date'] == '0' ? 0 : date("Y-m-d H:i:s", $res['appoint_date']),
                        "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                        "coupon"=>$res['coupon'],
                        "order_duo"=>unserialize($res['order_duo']),
                        "emp_name" => $emp['realname'],
                        "emp_mobile" => $emp['mobile'],
                        "modify_info" => $res['modify_info'] ? unserialize($res['modify_info']) : "",
                        "hxinfo2" => $res['hxinfo2'],
                        "discounts" => $res['discounts']
                    );
                    if($res['formid']){
                        $arr2 = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                        $arr[$k]['val'] = unserialize($arr2);
                    }else{
                        $arr[$k]['val'] = unserialize($res['beizhu_val']);
                    }
                    $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'],':uniacid' => $uniacid));

                    $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                    $arr[$k]['couponinfo'] = $couponinfo;

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
        }

        if($opt == "queren"){
            $id = $_GPC['orderid'];
            $emp = $_GPC['emp'];

            pdo_update("sudu8_page_order", array("flag"=>1, "emp_id"=>$emp), array("uniacid"=>$uniacid, "id"=>$id));

            message('确认成功!', $this->createWebUrl('Orderset', array('op'=>'yyyd','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        if($opt == "refuseqx"){
            $id = $_GPC['order'];
            $pid = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$id), "pid");
            $pro_flag_ding = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$pid), "pro_flag_ding");
            $flag = ($pro_flag_ding == '0') ? 1 : 3;
            pdo_update("sudu8_page_order", array("flag"=>$flag), array("uniacid"=>$uniacid, "id"=>$id));
            message('已拒绝取消!', $this->createWebUrl('Orderset', array('op'=>'yyyd','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        if($opt == "changedate"){
            $id = $_GPC['orderid'];
            $newdate = $_GPC['newdate'];

            pdo_update("sudu8_page_order", array("appoint_date"=>strtotime($newdate)), array("uniacid"=>$uniacid, "id"=>$id));
            message('日期修改成功!', $this->createWebUrl('Orderset', array('op'=>'yyyd','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        if($opt == "acceptmodify"){
            $id = $_GPC['order'];
            $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$id));
            $modify_info = unserialize($order['modify_info']);
            $data = array(
                "pro_user_name" => $modify_info['pro_name'],
                "pro_user_tel" => $modify_info['pro_tel'],
                "pro_user_add" => $modify_info['pro_address'],
                "appoint_date" => $modify_info['appoint_date']
            );

            $modify_info['pro_name'] = $order['pro_user_name'];
            $modify_info['pro_tel'] = $order['pro_user_tel'];
            $modify_info['pro_address'] = $order['pro_user_add'];
            $modify_info['appoint_date'] = $order['appoint_date'];
            $modify_info['flag'] = 2;
            
            $data['modify_info'] = serialize($modify_info);
            pdo_update("sudu8_page_order", $data, array("uniacid"=>$uniacid, "id"=>$id));
            message('客户修改申请已通过!', $this->createWebUrl('Orderset', array('op'=>'yyyd','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        if($opt == "refusemodify"){
            $id = $_GPC['order'];
            $modify_info = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$id), "modify_info");
            $modify_info = unserialize($modify_info);
            $modify_info['flag'] = 3;
            $modify_info = serialize($modify_info);
            pdo_update("sudu8_page_order", array("modify_info"=>$modify_info), array("uniacid"=>$uniacid, "id"=>$id));
            message('客户修改申请已拒绝!', $this->createWebUrl('Orderset', array('op'=>'yyyd','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

        if($opt == "confirmqx" || $opt == "qx"){
            $id = trim($_GPC['order']);
            $now = time();
            $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
            pdo_update("sudu8_page_order", array("th_orderid" => $out_refund_no), array("uniacid"=>$uniacid, "id"=>$id));
            $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$id));
            $beforedays = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order['pid']), "beforedays");
            $types = ($opt == "confirmqx") ? "yuyue" : "yuyueqx";

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
                    $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                    if($order['tsid'] > 0){
                        pdo_update("sudu8_page_tableselect", array("flag"=>2), array("uniacid"=>$uniacid, "id"=>$order['tsid']));
                    }else{
                        $pro = pdo_get("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order['pid']));

                        $more_type_num = unserialize($pro['more_type_num']);
                        $more_type = unserialize($pro['more_type']);
                        $order_duo = unserialize($order['order_duo']);
                        $sale_tnum = $pro['sale_tnum'];


                        foreach ($order_duo as $key => &$value) {
                            $more_type_num[$key]['shennum'] += $value[4];
                            $sale_tnum -= 1;
                            if($key == 0){
                                $more_type[2] += $value[4];
                            }else{
                                $k = 4 * $key + 2;
                                $more_type[$k] += $value[4];
                            }
                        }

                        $more_type_num = serialize($more_type_num);
                        $more_type = serialize($more_type);
                        pdo_update("sudu8_page_products", array("more_type_num"=>$more_type_num,"more_type"=>$more_type,"sale_tnum" => $sale_tnum), array("uniacid"=>$uniacid, "id"=>$order['pid']));
                    }

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
                if($opt == "confirmqx"){
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
                if($order['tsid'] > 0){
                    pdo_update("sudu8_page_tableselect", array("flag"=>2), array("uniacid"=>$uniacid, "id"=>$order['tsid']));
                }else{
                    $pro = pdo_get("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order['pid']));
                    
                    $more_type_num = unserialize($pro['more_type_num']);
                    $more_type = unserialize($pro['more_type']);
                    $order_duo = unserialize($order['order_duo']);
                    $sale_tnum = $pro['sale_tnum'];


                    foreach ($order_duo as $key => &$value) {
                        $more_type_num[$key]['shennum'] += $value[4];
                        $sale_tnum -= 1;
                        if($key == 0){
                            $more_type[2] += $value[4];
                        }else{
                            $k = 4 * $key + 2;
                            $more_type[$k] += $value[4];
                        }
                    }

                    $more_type_num = serialize($more_type_num);
                    $more_type = serialize($more_type);
                    pdo_update("sudu8_page_products", array("more_type_num"=>$more_type_num,"more_type"=>$more_type,"sale_tnum" => $sale_tnum), array("uniacid"=>$uniacid, "id"=>$order['pid']));
                }

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
            }
            message('取消成功!', $this->createWebUrl('Orderset', array('op'=>'yyyd','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }

        if($opt == "record"){
            $datetimepicker = $_GPC['datetimepicker'];
            $end_datetimepicker = $_GPC['end_datetimepicker'];
            $select_state = $_GPC['select_state'];
            $datetimepicker2 = $_GPC['datetimepicker2'];
            $end_datetimepicker2 = $_GPC['end_datetimepicker2'];
            $select_info = $_GPC['select_info'];
            $user_info = $_GPC['user_info'];

            $where = '';

            if(!empty($_GPC['datetimepicker']) || !empty($_GPC['end_datetimepicker']) || !empty($_GPC['end_datetimepicker2']) || in_array($_GPC['select_state'], ['99','0','1','2','-1','-2']) || !empty($_GPC['datetimepicker2']) || (in_array($_GPC['select_info'],['order','name','phone','address']) && !empty($_GPC['user_info']))){
                if(!empty($_GPC['datetimepicker'])){
                    $creattime = strtotime($_GPC['datetimepicker']);
                    $where .= ' and creattime >= ' . $creattime;
                }
                if(!empty($_GPC['end_datetimepicker'])){
                    $end_creattime = strtotime($_GPC['end_datetimepicker']);
                    $where .= ' and creattime <= ' . $end_creattime;
                }
                if(in_array($_GPC['select_state'], ['0','1','2','-1','-2'])){
                    $flag = intval($_GPC['select_state']);
                    $where .= ' and flag = ' . $flag;
                }
                if(!empty($_GPC['datetimepicker2'])){
                    $appoint_date = strtotime($_GPC['datetimepicker2']);
                    $where .= ' and appoint_date >= ' . $appoint_date;
                }
                if(!empty($_GPC['end_datetimepicker2'])){
                    $end_appoint_date = strtotime($_GPC['end_datetimepicker2']);
                    $where .= ' and appoint_date <= ' . $end_appoint_date;
                }
                if(!empty($_GPC['user_info'])){
                    $userinfo = $_GPC['user_info'];
                    $where .= ' and order_id LIKE "%'.$userinfo.'%"';
                }

            

                $total = pdo_fetchcolumn("select count(*) from ".tablename('sudu8_page_order')." where uniacid = :uniacid and is_more = 1".$where,array(':uniacid'=> $uniacid));
                //var_dump($total);exit();
                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize); 

                $orders = pdo_fetchall("select * from ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid  and is_more = 1".$where." order by creattime desc limit " . $p . "," . $pagesize, array(':uniacid' => $uniacid));

                foreach ($orders as $k=> $res) {

                        $arr[] = array(
                            "id"=>$res['id'],
                            "order_id"=>$res['order_id'],
                            "pid"=>$res['pid'],
                            "thumb" => $_W['attachurl'].$res['thumb'],
                            "product"=>$res['product'],
                            "price"=>$res['price'],
                            "num"=>$res['num'],
                            "yhq"=>$res['yhq'],
                            "true_price"=>$res['true_price'],
                            "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                            "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                            "flag"=>$res['flag'],
                            "pro_user_name"=>$res['pro_user_name'],
                            "pro_user_tel"=>$res['pro_user_tel'],
                            "pro_user_add"=>$res['pro_user_add'],
                            "pro_user_txt"=>$res['pro_user_txt'],
                            "appoint_date"=>$res['appoint_date'] == '0' ? 0 : date("Y-m-d H:i:s", $res['appoint_date']),
                            "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                            "coupon"=>$res['coupon'],
                            "order_duo"=>unserialize($res['order_duo'])
                        );

                        if($res['formid']){
                            $arr2 = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                            $arr[$k]['val'] = unserialize($arr2);
                        }else{
                            $arr[$k]['val'] = unserialize($res['beizhu_val']);
                        }
                        $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'],':uniacid' => $uniacid));

                        $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                        $arr[$k]['couponinfo'] = $couponinfo;

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

        }

        if($opt == "excel"){
            $where = '';

            if(!empty($_GPC['datetimepicker']) || !empty($_GPC['end_datetimepicker']) || !empty($_GPC['end_datetimepicker2']) || in_array($_GPC['select_state'], ['99','0','1','2','-1','-2']) || !empty($_GPC['datetimepicker2']) || (in_array($_GPC['select_info'],['order','name','phone','address']) && !empty($_GPC['user_info']))){

                if(!empty($_GPC['datetimepicker'])){
                    $creattime = strtotime($_GPC['datetimepicker']);
                    $where .= ' and creattime >= ' . $creattime;
                }
                if(!empty($_GPC['end_datetimepicker'])){
                    $end_creattime = strtotime($_GPC['end_datetimepicker']);
                    $where .= ' and creattime <= ' . $end_creattime;
                }
                if(in_array($_GPC['select_state'], ['0','1','2','-1','-2'])){
                    $flag = intval($_GPC['select_state']);
                    $where .= ' and flag = ' . $flag;
                }
                if(!empty($_GPC['datetimepicker2'])){
                    $appoint_date = strtotime($_GPC['datetimepicker2']);
                    $where .= ' and appoint_date >= ' . $appoint_date;
                }
                if(!empty($_GPC['end_datetimepicker2'])){
                    $end_appoint_date = strtotime($_GPC['end_datetimepicker2']);
                    $where .= ' and appoint_date <= ' . $end_appoint_date;
                }
                
                if(!empty($_GPC['user_info'])){
                    $userinfo = $_GPC['user_info'];
                    $where .= ' and order_id LIKE "%'.$userinfo.'%"';
                }
            }

                $excel_orders = pdo_fetchall("select * from ".tablename('sudu8_page_order')." where uniacid = :uniacid and is_more = 1 ".$where." order by creattime desc",array(':uniacid' => $uniacid));

                include MODULE_ROOT.'/plugin/phpexcel/Classes/PHPExcel.php';

                $objPHPExcel = new \PHPExcel();

                /*以下是一些设置*/
                $objPHPExcel->getProperties()->setCreator("预约预定筛选记录")
                    ->setLastModifiedBy("预约预定筛选记录")
                    ->setTitle("预约预定筛选记录")
                    ->setSubject("预约预定筛选记录")
                    ->setDescription("预约预定筛选记录")
                    ->setKeywords("预约预定筛选记录")
                    ->setCategory("预约预定筛选记录");
                $objPHPExcel->getActiveSheet()->setCellValue('A1', '商品');
                $objPHPExcel->getActiveSheet()->setCellValue('B1', '规格/单价/数量');
                $objPHPExcel->getActiveSheet()->setCellValue('C1', '营销活动');
                $objPHPExcel->getActiveSheet()->setCellValue('D1', '实付金额');
                $objPHPExcel->getActiveSheet()->setCellValue('E1', '姓名');
                $objPHPExcel->getActiveSheet()->setCellValue('F1', '电话');
                $objPHPExcel->getActiveSheet()->setCellValue('G1', '地址');
                $objPHPExcel->getActiveSheet()->setCellValue('H1', '下单时间');
                $objPHPExcel->getActiveSheet()->setCellValue('I1', '预约时间');
                $objPHPExcel->getActiveSheet()->setCellValue('J1', '状态');
                $objPHPExcel->getActiveSheet()->setCellValue('K1', '万能表单提交信息');

                foreach($excel_orders as $k => $v){
                    $num=$k+2;

                    switch($v['flag']){
                        case '0':
                            $state = '未支付';
                            break;

                        case '1':
                            $state = '立即核销';
                            break;

                        case '2':
                            $state = '已完成';
                            break;

                        case '-1':
                            $state = '已关闭';
                            break;

                        case '-2':
                            $state = '订单无效';
                            break;
                    }
                    
                    //选座产品
                    if($v['tsid'] > 0){
                        $tableselect = pdo_fetch("select * from ".tablename('sudu8_page_tableselect')." where id = :id and uniacid = :uniacid",array(':id' => $v['tsid'],':uniacid' => $uniacid));
                        $table_arr = pdo_fetch("select * from ".tablename('sudu8_page_table')." where id = :tid and uniacid = :uniacid",array(':tid' => $tableselect['tid'],':uniacid' => $uniacid));
                        $row = explode(",",$table_arr['rowstr']);
                        $column = explode(",",$table_arr['columnstr']);
                        $v['appoint_date'] = $tableselect['appoint_date'];
                        $promess_arr = explode(",",$tableselect['select_str']);
                        
                        foreach($promess_arr as $kk => $vv){
                            $select_num = explode("a",$vv);
                            $row_name = $row[$select_num[0] - 1];        //行名
                            $column_name = $column[$select_num[1] - 1];  //列名
                            $promess = $row_name.",".$column_name;
                            $v['mess'] = $v['mess'].$promess."  ;  ";
                        }
                        $v['mess'] = $v['mess']." / ".$v['price']." / ".$v['num'];
                        
                    } else{
                        $order_duo = unserialize($v['order_duo']);
                        foreach($order_duo as $yy => $jj){
                            $value_name = $jj[0];
                            $value_price = $jj[1];
                            $buy_num = $jj[4];
                            $promess = $value_name." / ".$value_price." / ".$buy_num."  ;  ";
                            $v['mess'] = $v['mess'].$promess;
                        }
                        
                    }

                    $yhq = '';
                    if($v['coupon'] > 0){
                        $coupon_user = pdo_fetch("select cid from ".tablename('sudu8_page_coupon_user')." where id = :coupon and uniacid = :uniacid",array(':coupon' => $v['coupon'],':uniacid' => $uniacid));
                        $coupon = pdo_fetch("select * from ".tablename('sudu8_page_coupon')." where id = :id and uniacid = :uniacid",array(':id' => $coupon_user['cid'],'uniacid' => $uniacid));
                        $coupon_title = $coupon['title'];
                        $yhq = $coupon_title;
                    } else{
                        $yhq = $yhq;
                    }
                    
                    $time_str = strpos((date("Y-m-d H:i:s",$v['appoint_date'])),"1970-01-01");
                    if($time_str >= 0){
                        $v['appoint_date'] = '';
                    }
                    $form_val = [];
                    if($v['formid']){
                        $arr2 = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$v['formid']));
                        $form_val = unserialize($arr2);
                    }else{
                        $form_val = unserialize($v['beizhu_val']);
                    }

                    $forminfo = "";
                    if(count($form_val) > 0){
                        foreach ($form_val as $kk => $vv) {
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

                    $objPHPExcel->getActiveSheet()->getStyle("K".$num)->getAlignment()->setWrapText(true);
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValueExplicit('A'.$num, $v['product'],'s')
                                ->setCellValueExplicit('B'.$num, $v['mess'],'s')
                                ->setCellValueExplicit('C'.$num, $yhq,'s') //营销活动
                                ->setCellValueExplicit('D'.$num, $v['true_price'],'s')
                                ->setCellValueExplicit('E'.$num, $v['pro_user_name'], 's')
                                ->setCellValueExplicit('F'.$num, $v['pro_user_tel'], 's')
                                ->setCellValueExplicit('G'.$num, $v['pro_user_add'], 's')
                                ->setCellValueExplicit('H'.$num, date("Y-m-d H:i:s",$v['creattime']), 's')
                                ->setCellValueExplicit('I'.$num, date("Y-m-d H:i:s",$v['appoint_date']), 's')
                                ->setCellValueExplicit('J'.$num, $state,'s')
                                ->setCellValueExplicit('K'.$num, $forminfo,'s');

                }

                $objPHPExcel->getActiveSheet()->setTitle('导出筛选记录');
                $objPHPExcel->setActiveSheetIndex(0);
                $excelname="预约预定记录导出表";
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                exit;
            
        }






return include self::template('web/Orderset/yyyd');