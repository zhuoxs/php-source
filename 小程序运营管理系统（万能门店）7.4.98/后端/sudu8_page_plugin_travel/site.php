<?php
/**
 * 预约预定模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
class Sudu8_page_plugin_travelModuleSite extends WeModuleSite {
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
            $res = $this-> _Postrequest($url,$orderinfo);
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
                        $receive['uniacid'] = $uniacid;
                        $receive['vid'] = $v['id'];

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
    public function doWebProducts_more() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display', 'post','consumption', 'delete', 'evaluate');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];
        // var_dump($op);
        // die();
        //产品列表
        if ($op == 'display'){
            $_W['page']['title'] = '产品管理';
            //$products = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE uniacid = :uniacid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));
            $products = pdo_fetchall("SELECT i.num,i.thumb,i.title,i.id,c.name,i.type,i.is_more,i.buy_type,i.sale_num,i.sale_tnum FROM ".tablename('sudu8_page_products')."as i left join" .tablename('sudu8_page_cate')." as c on i.cid = c.id WHERE i.uniacid = ".$uniacid." and i.type ='showPro'  and i.is_more = 1 ORDER BY i.num DESC,i.id DESC");

        }
        if ($op == 'consumption'){
        }
        //产品添加、修改
        if ($op == 'post'){
            $stores = pdo_fetchall("SELECT id,title FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

            
            


            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

            if(!empty($item['vipconfig'])){
                $item['vipconfig'] = unserialize($item['vipconfig']);
            }

            $stores_now = explode(",",$item['stores']);

            $tablepro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_table')." WHERE proname = :proname and uniacid = :uniacid ", array(':proname' => $item['title'] ,':uniacid' => $uniacid));
            $columnstr = $tablepro['columnstr'] ? $tablepro['columnstr'] : "yyy,";
            $rowstr = $tablepro['rowstr'] ? $tablepro['rowstr'] : "xxx,";
            $selectstr = $tablepro['selectstr'] ? $tablepro['selectstr'] : "";
            $column_arr = explode(",", chop($columnstr, ","));
            $column_num = $tablepro['columnstr'] ? count($column_arr) : 1;
            $row_arr = explode(",", chop($rowstr, ","));
            $row_num = $tablepro['rowstr'] ? count($row_arr) : 1;
            $select_temp = explode(",", chop($selectstr, ","));
            $select_arr = array();
            for($i = 0; $i < count($select_temp); $i++){
                $temp = explode("a", $select_temp[$i]);
                $select_arr[intval($temp[0])][intval($temp[1])] = 1;
            }

            $orders_l = pdo_fetchall("SELECT num FROM ".tablename('sudu8_page_order')." WHERE pid = :pid and uniacid = :uniacid and flag > 0" , array(':pid' => $id ,':uniacid' => $uniacid));
            $forms = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));

            $item['text'] = unserialize($item['text']);
            $item['more_type'] = unserialize($item['more_type']);
            $item['labels'] = unserialize($item['labels']);
            $item['pro_flag_data_name'] = explode(";", $item['pro_flag_data_name']);
            $item['afterdays'] = $item['pro_flag_data_name'][1];
            $item['beforedays'] = $item['pro_flag_data_name'][2];
            $item['modifydays'] = $item['pro_flag_data_name'][3];
            $item['pro_flag_data_name'] = $item['pro_flag_data_name'][0];
            $item['discount'] = unserialize($item['discount']); 
            $grade_arr = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_vipgrade')." WHERE uniacid = :uniacid order by grade asc", array(":uniacid" => $uniacid));
            if(empty($grade_arr)){
                $data_s = [
                    'uniacid' => $uniacid,
                    'grade' => 1,
                    'name' => '大众会员',
                    'upgrade' => 0,
                    'price' => 0,
                    'status' => 1,
                    'bgcolor' => '#434550',
                    'card_img' => 'static/images/vip_card.png',
                    'descs' => '默认会员等级'
                ];
                pdo_insert('sudu8_page_vipgrade',$data_s);
                $grade_arr[0]['name'] = '大众会员';
                $grade_arr[0]['grade'] = 1;
                $grade_arr[0]['id'] = pdo_insertid();
            }

            foreach ($grade_arr as $key => $value) {
                foreach ($item['discount'] as $ks => $vs) {
                    if($value['grade'] == $vs['grade']){
                        $grade_arr[$key]['discount'] = $vs['discount'];
                    }
                }
            }
            if($item['sale_time']!=0){
                $item['sale_time'] = date("Y-m-d H:i:s",$item['sale_time']);
            }
            $listV = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE cid = :cid and uniacid = :uniacid and type='showPro' ORDER BY num DESC,id DESC", array(':cid' => 0 ,':uniacid' => $uniacid));
            $listAll = array();
            foreach($listV as $key=>$val) {
                $cid = intval($val['id']);
                $listP = pdo_fetch("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and id = :id and type='showPro' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listS = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :id and type='showPro' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listP['data'] = $listS;
                array_push($listAll,$listP);
            }
            //var_dump($listAll);
            if (!empty($id)) {
                if (empty($item)) {
                    message('抱歉，产品不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')) {
                $stores_arr = implode(",", $_GPC['stores']);
                $duogg = $_GPC['duogg'];
                $duoggarr = explode(',',substr($duogg, 0,strlen($duogg)-1));
                $kkk = serialize($duoggarr);
                $dggarr = array_chunk($duoggarr,4);
                $mmm = serialize($dggarr);
                $tongji = array();
                foreach ($dggarr as &$rec) {
                    $tjs = array(
                                "allnum"=>$rec[2],
                                "salenum"=>0,
                                "shennum"=>$rec[2]
                            );   
                    $tongji[] = $tjs; 
                }
                $uuu = serialize($tongji);
                $lab = $_GPC['labels'];

                if(!empty($lab)){
                    $newlab = explode(';',substr($lab, 0, strlen($lab)-1));
                    $labs = array();
                    foreach ($newlab as $rec) {
                        $nnn = explode(':',$rec);
                        $key = $nnn[0];
                        $val = $nnn[1];
                        $labs[$key] = $val;
                    }
                    $vvv = serialize($labs);
                }else{
                    $vvv = "";
                }

                if (empty($_GPC['title'])) {
                    message('标题不能为空，请输入标题！');
                }
                if (empty($_GPC['buy_type'])) {
                    message('自定义购买方式不能为空！');
                }
                $cid = intval($_GPC['cid']);
                $pcid = pdo_fetch("SELECT cid FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id =:id ", array(':uniacid' => $uniacid,':id'=>$cid));
                $pcid=implode(“”,$pcid);
                if($pcid == 0){
                    $pcid = $cid;
                }else{
                    $pcid = intval($pcid);
                }
                
                $table = array(
                    'uniacid' => $_W['uniacid'],
                    'name' => $_GPC['tablename'],
                    'columnstr' => $_GPC['columnstr'],
                    'rowstr' => $_GPC['rowstr'],
                    'selectstr'=>$_GPC['selectstr'],
                    'proname' => $_GPC['title']
                );
                if($_GPC['tableis']==1){
                    //插入选座的数据
                    if($tablepro){
                        // var_dump("pdo_update");
                        pdo_update('sudu8_page_table', $table, array('proname' => $item['title'] ,'uniacid' => $uniacid));
                    }else{
                        // var_dump("insert");
                        pdo_insert('sudu8_page_table', $table);
                    }
                }
                $tablepro2 = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_table')." WHERE proname = :proname and uniacid = :uniacid ", array(':proname' => $_GPC['title'] ,':uniacid' => $uniacid));
                //第一次插入table
                if($tablepro2['id']){
                    $tableid = $tablepro2['id'];
                }else{
                    $tableid ='';
                }

                $afterdays = $_GPC['afterdays'] ? $_GPC['afterdays'] : 0;
                $beforedays = $_GPC['beforedays'] ? $_GPC['beforedays'] : 0;
                $modifydays = $_GPC['modifydays'] ? $_GPC['modifydays'] : 0;
                $pro_flag_data_name = $_GPC['pro_flag_data_name']?$_GPC['pro_flag_data_name']:"上门时间";
                if($_GPC['flag'] === null){
                    $flag = 1;
                }else{
                    $flag = $_GPC['flag'];
                }
                $discount_status = $_GPC['discount_status'];
                $valarr = $_GPC['valarr'];

                $discount = [];
                foreach ($grade_arr as $ki => $vi) {
                    foreach ($valarr as $key => $value) {
                        if($ki == $key){
                            $discount[$ki]['grade'] = $vi['grade'];
                            $discount[$ki]['discount'] = $value;
                            continue;
                        }
                    }
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'cid' => intval($_GPC['cid']),
                    'pcid' => $pcid,
                    'num' => intval($_GPC['num']),
                    'type' => 'showPro',
                    'type_x' => intval($_GPC['type_x']),
                    'type_y' => intval($_GPC['type_y']),
                    'type_i' => intval($_GPC['type_i']),
                    'hits' => intval($_GPC['hits']),
                    'sale_num' => intval($_GPC['sale_num']),
                    'title' => addslashes($_GPC['title']),
                    'text' => serialize($_GPC['text']),
                    'thumb'=>$_GPC['thumb'],
                    'desc'=>$_GPC['desc'],
                    'ctime' => TIMESTAMP,
                    'price'=>$_GPC['price'],
                    'market_price'=>$_GPC['market_price'],
                    'score'=>$_GPC['score'],
                    'pro_flag'=>$_GPC['pro_flag'],
                    'pro_flag_tel'=>$_GPC['pro_flag_tel'],
                    'pro_flag_add'=>$_GPC['pro_flag_add'],
                    'pro_flag_data'=>$_GPC['pro_flag_data'],
                    'pro_flag_data_name'=>$pro_flag_data_name . ";" . $afterdays . ";" . $beforedays . ";" . $modifydays,
                    'pro_flag_time'=>$_GPC['pro_flag_time'],
                    'pro_flag_ding'=>$_GPC['pro_flag_ding'],
                    'product_txt'=>htmlspecialchars_decode($_GPC['product_txt'], ENT_QUOTES),
                    'labels'=>$vvv,
                    'is_more'=>1,
                    'more_type'=>$kkk,
                    "more_type_x"=>$mmm,
                    "more_type_num"=>$uuu,
                    'flag'=>$flag,
                    'buy_type'=>$_GPC['buy_type'],
                    'formset'=>$_GPC['formset'],
                    'is_score'=>$_GPC['is_score'],
                    'score_num'=>$_GPC['score_num'],
                    'tableid'=>$tableid,
                    'tableis'=>$_GPC['tableis'],
                    'seller_remind'=>$_GPC['seller_remind'],
                    'foottitle'=>$_GPC['foottitle'],
                    'get_share_gz' => $_GPC['get_share_gz'],
                    'get_share_score' => $_GPC['get_share_score'],
                    'get_share_num' => $_GPC['get_share_num'],
                    'stores' => $stores_arr,
                    'discount_status' => $discount_status,
                    'discount' => serialize($discount)
                );
                $set1 = $_GPC["set1"];
                $set2 = $_GPC["set2"];
                $set3 = $_GPC["set3"];
                $vipconfig = array(
                    "set1" => $set1,
                    "set2" => $set2,
                    "set3" => $set3
                    );
                $data['vipconfig']  = serialize($vipconfig);
                if (!empty($_GPC['thumb'])) {
                    $data['thumb'] = parse_path($_GPC['thumb']);
                }
                if (empty($id)) {
                    pdo_insert('sudu8_page_products', $data);
                } else {
                    unset($data['ctime']);
                    $data['etime '] = TIMESTAMP;
                    pdo_update('sudu8_page_products', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                message('产品 添加/修改 成功!', $this->createWebUrl('products_more', array('op'=>'display')), 'success');
            }
        }
        //删除产品
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('产品不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_products', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('products_more', array('op'=>'display')), 'success');
        }

        include $this->template('products_more');
    }
    public function doWebevaluate()
    {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display','delete','content','hf');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];

        //评论列表
        if ($op == 'display'){
            $_W['page']['title'] = '评论管理';
            $flag = $_GPC['flag'];
            $orderid = $_GPC['orderids'];
            $where1 = "";
            $where = "";
            if($flag > 0){
              $where1 .= " and assess = ".$flag;
              $where .= " and a.assess = ".$flag;
            }
            if($orderid != ''){
              $where1 .= " and orderid = ".trim($orderid);
              $where .= " and a.orderid = ".trim($orderid);
            }

            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_evaluate')." WHERE pid = :pid and uniacid = :uniacid {$where1}", array(':pid' => $id, ':uniacid' => $uniacid));
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);
            $list = pdo_fetchAll("SELECT a.*,b.avatar,b.nickname FROM ".tablename('sudu8_page_evaluate')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.openid = b.openid and a.uniacid = b.uniacid WHERE a.pid = :pid and a.uniacid = :uniacid {$where} order by a.id desc LIMIT ".$start.",".$pagesize, array(':pid' => $id, ':uniacid' => $uniacid));
            foreach ($list as $key => &$value) {
                $value['nickname'] = rawurldecode($value['nickname']);
                $value['imgs'] = unserialize($value['imgs']);
            }
        }

        //删除评论
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $pid = intval($_GPC['pid']);

            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_evaluate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('评论不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_evaluate', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功', $this->createWebUrl('evaluate', array('id' => $pid)), 'success');
        }
        if ($op == 'content') {
            $eid = $_GPC['evid'];
            $item = pdo_fetch("SELECT a.*,b.avatar,b.nickname FROM ".tablename('sudu8_page_evaluate')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.openid = b.openid and a.uniacid = b.uniacid WHERE a.id = :id and a.uniacid = :uniacid", array(':id' => $eid, ':uniacid' => $uniacid));
            if($item){
                $item['nickname'] = rawurldecode($item['nickname']);
                if($item['imgs']){
                    $item['imgs'] = unserialize($item['imgs']);
                }
                if($item['append_imgs']){
                    $item['append_imgs'] = unserialize($item['append_imgs']);
                }
            }
        }
        if($op == 'hf') {
            $id = intval($_GPC['id']);
            $huifu = $_GPC['huifu'];
            $cishu = intval($_GPC['cishu']);
            $evaluate = pdo_fetch("SELECT * FROM " . tablename('sudu8_page_evaluate') . " WHERE id = :id and uniacid = :uniacid", array(':id' => $id, ':uniacid' => $uniacid));
            if ($evaluate) {
                if ((!$evaluate['reply_first']) && $cishu == 1) {
                    $data = array(
                        "reply_first" => $huifu,
                        "reply_first_time" => date('Y-m-d H:i:s', time())
                    );
                    pdo_update('sudu8_page_evaluate', $data, array('id' => $id, 'uniacid' => $uniacid));
                }
                if ((!$evaluate['reply_second']) && $cishu == 2) {
                    $data2 = array(
                        "reply_second" => $huifu,
                        "reply_second_time" => date('Y-m-d H:i:s', time())
                    );
                    pdo_update('sudu8_page_evaluate', $data2, array('id' => $id, 'uniacid' => $uniacid));
                }
                message('回复成功', $this->createWebUrl('evaluate', array('id' => $pid,'op' => 'content', 'evid' => $id)), 'success');


            } else {
                message('删除失败', $this->createWebUrl('evaluate', array('id' => $pid,'op' => 'content', 'evid' => $id)), 'error');
            }


        }

        include $this->template('evaluate');
        }
    public function doWeborders(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display', 'yh', 'hx','qr','confirmqx','refuseqx','changedate', 'acceptmodify', 'refusemodify', 'queren');
        $op = in_array($op, $ops) ? $op : 'display';
        $order = $_GPC['order'];
        if($op == "queren"){
            $id = $_GPC['orderid'];
            $emp = $_GPC['emp'];
            pdo_update("sudu8_page_order", array("flag"=>1, "emp_id"=>$emp), array("uniacid"=>$uniacid, "id"=>$id));
            message('确认成功!', $this->createWebUrl('orders', array('op'=>'display')), 'success');
        }
        if($op == "acceptmodify"){
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
            message('客户修改申请已通过!', $this->createWebUrl('orders', array('op'=>'display')), 'success');
        }

        if($op == "refusemodify"){
            $id = $_GPC['order'];
            $modify_info = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$id), "modify_info");
            $modify_info = unserialize($modify_info);
            $modify_info['flag'] = 3;
            $modify_info = serialize($modify_info);
            pdo_update("sudu8_page_order", array("modify_info"=>$modify_info), array("uniacid"=>$uniacid, "id"=>$id));
            message('客户修改申请已拒绝!', $this->createWebUrl('orders', array('op'=>'display')), 'success');
        }
        if($op == "changedate"){
            $id = $_GPC['orderid'];
            $newdate = $_GPC['newdate'];
            pdo_update("sudu8_page_order", array("appoint_date"=>strtotime($newdate)), array("uniacid"=>$uniacid, "id"=>$id));
            message('日期修改成功!', $this->createWebUrl('orders', array('op'=>'display')), 'success');
        }
        if($op == 'confirmqx'){
            $id = trim($_GPC['order']);
            $now = time();
            $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
            pdo_update("sudu8_page_order", array("th_orderid" => $out_refund_no), array("uniacid"=>$uniacid, "id"=>$id));
            $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$id));

            $beforedays = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order['pid']), "beforedays");
            $types = ($opt == "confirmqx") ? "yuyue" : "yuyueqx";
            if($order['pay_price'] > 0){
                require_once MODULE_ROOT."/../sudu8_page/WeixinRefund.php";
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

            message('取消成功!', $this->createWebUrl('orders', array('op'=>'display')), 'success');

        }
        if($op == 'refuseqx'){
            $id = $_GPC['order'];
            $pid = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$id), "pid");
            $pro_flag_ding = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$pid), "pro_flag_ding");
            $flag = ($pro_flag_ding == '0') ? 1 : 3;
            pdo_update("sudu8_page_order", array("flag"=>$flag), array("uniacid"=>$uniacid, "id"=>$id));
            message('已拒绝取消!', $this->createWebUrl('orders', array('op'=>'display')), 'success');
        }
        if($op == "hx"){
            $data['custime'] = time();
            $data['flag'] = 2;
            $data['hxinfo'] = 'a:1:{i:0;i:1;}';
            $res = pdo_update('sudu8_page_order', $data, array('id' => $order));
            $info = pdo_fetch("SELECT * FROM".tablename('sudu8_page_order')." WHERE id = :id", array(':id' => $order));
            $this->addAllpay($info['true_price'], $info['openid']);
            $this->checkVipGrade($info['openid']);
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

                $this->mall($info['openid'], $info['order_id'], $allprice, $status, 'yuyue', $info['pid'], $num,  $yunfei, $kd_id, $kuaidi, $kuaidihao, $beizhu_val);
            }
            message('核销成功!', $this->createWebUrl('orders',array('op'=>'display')), 'success');
        }
        if($op == "qr"){
            $data['flag'] = 1;
            $res = pdo_update('sudu8_page_order', $data, array('id' => $order));
            message('确认成功!', $this->createWebUrl('orders',array('op'=>'display')), 'success');
        }

        if($op == "display"){
            $order_id = $_GPC['order_id'];
            $emps = pdo_getall("sudu8_page_staff", array("uniacid"=>$uniacid), array("id", "realname"));
            if($order_id){
                $orderinfo = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id LIKE :order_id and uniacid = :uniacid and is_more = 1", array(':order_id' => '%'.$order_id.'%' ,':uniacid' => $uniacid));

                $total = count($orderinfo);

                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize);  
                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id LIKE :order_id and uniacid = :uniacid and is_more = 1  LIMIT " . $p . "," . $pagesize, array(':order_id' => '%'.$order_id.'%' ,':uniacid' => $uniacid));
                
                $beizhu_val = unserialize($orders['beizhu_val']);
                $beizhu_val = $beizhu_val['val'];
                foreach ($orders as $k => $res) {
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
                        "true_price"=>$res['true_price'],
                        "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                        "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                        "flag"=>$res['flag'],
                        "pro_user_name"=>$res['pro_user_name'],
                        "pro_user_tel"=>$res['pro_user_tel'],
                        "pro_user_txt"=>$res['pro_user_txt'],
                        "pro_user_add"=>$res['pro_user_add'],
                        "appoint_date"=>$res['appoint_date']>0?date("Y-m-d H:i:s",$res['appoint_date']):0,
                        "order_duo"=>unserialize($res['order_duo']),
                        "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                        "beizhu_val"=>unserialize($res['beizhu_val']),
                        "hxinfo2" => $res['hxinfo2'],
                        "discounts" => $res['discounts']
                    );

                    if(isset($res['modify_info'])){
                        $arr[$k]['modify_info'] = unserialize($res['modify_info']);
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
            }else{
                $all = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid and is_more = 1 ORDER BY `creattime` DESC ", array(':uniacid' => $uniacid));
                $total = count($all);
                $pageindex = max(1, intval($_GPC['page']));
                $pagesize = 10;  
                $p = ($pageindex-1) * $pagesize;
                $pager = pagination($total, $pageindex, $pagesize);  
                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid and is_more = 1 ORDER BY `creattime` DESC LIMIT " . $p . "," . $pagesize, array(':uniacid' => $uniacid));

                foreach ($orders as $k => $res) {
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
                        "true_price"=>$res['true_price'],
                        "creattime" => date("Y-m-d H:i:s",$res['creattime']),
                        "custime" => $res['custime']?date("Y-m-d H:i:s",$res['custime']):"未消费",
                        "flag"=>$res['flag'],
                        "pro_user_name"=>$res['pro_user_name'],
                        "pro_user_tel"=>$res['pro_user_tel'],
                        "pro_user_txt"=>$res['pro_user_txt'],
                        "pro_user_add"=>$res['pro_user_add'],
                        "appoint_date"=>$res['appoint_date']>0?date("Y-m-d H:i:s",$res['appoint_date']):0,
                        "order_duo"=>unserialize($res['order_duo']),
                        "overtime" => date("Y-m-d H:i:s",$res['overtime']),
                        "beizhu_val"=>unserialize($res['beizhu_val']),
                        "hxinfo2" => $res['hxinfo2'],
                        "discounts" => $res['discounts']
                    );

                    if($arr[$k]['beizhu_val'] == "NULL"){
                        $arr[$k]['beizhu_val'] = "";
                    }
                    if(isset($res['modify_info'])){
                        $arr[$k]['modify_info'] = unserialize($res['modify_info']);
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
        }
        include $this->template('orders');
    }
    public function doWebTorder() {
    }
}