<?php
/**
 * 拼团小程序模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("HTTPSHOST",$_W['attachurl']);
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');

class Sudu8_page_plugin_ptModuleSite extends WeModuleSite {

    //判断会员等级是否达到
    public function checkVipGrade($openid){
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
    public function addAllpay($price,$openid){
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
	// 新增拼团产品
	public function doWebproadd() {
        
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','types');
        $op = in_array($op, $ops) ? $op : 'display';
        $id = $_GPC['id'];
        if($op == "display"){
            $grade_arr = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_vipgrade')." WHERE uniacid = :uniacid order by grade asc", array(':uniacid' => $uniacid));
            
            $stores = pdo_fetchall("SELECT id,title FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

            $yunfei_gg_list = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_freight')." WHERE uniacid = :uniacid and is_delete = 0", array(':uniacid' => $uniacid));
            $listAll = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_pt_cate') ." WHERE uniacid = :uniacid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));

            $products = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ':id'=>$id));
            $gwcforms = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));
            $stores_now = explode(",",$products['stores']);
            if(!empty($products['vipconfig'])){
                $products['vipconfig'] = unserialize($products['vipconfig']);
            }
            $products['imgtext'] = unserialize($products['imgtext']);
            if (checksubmit('submit')) {

                $cid = intval($_GPC['cid']);
                $pcid = pdo_fetch("SELECT cid FROM ".tablename('sudu8_page_pt_cate')." WHERE uniacid = :uniacid and id =:id ", array(':uniacid' => $uniacid,':id'=>$cid));
                $pcid=implode('',$pcid);
                if($pcid == 0){
                    $pcid = $cid;
                }else{
                    $pcid = intval($pcid);
                }

				if($_GPC['show_pro'] != ''){
					$show_pro = $_GPC['show_pro'];
				} else{
					$show_pro = 1;
				}
                $stores_arr = implode(",", $_GPC['stores']);
                $data = array(
                    "uniacid" => $_W['uniacid'],
                    "num" => $_GPC['num'],
                    "cid" => $_GPC['cid'],
                    "pcid" => $pcid,
                    "type_x" => $_GPC['type_x'],
                    "type_y" => $_GPC['type_y'],
                    "type_i" => $_GPC['type_i'],
                    "thumb" => $_GPC['thumb'],
                    "title" => $_GPC['title'],
                    "price" => $_GPC['price'],
                    "mark_price" => $_GPC['mark_price'],
                    "descs" => $_GPC['descs'],
                    'imgtext' => serialize($_GPC['imgtext']),
                    'explains' => $_GPC['explains'],
                    "texts" => htmlspecialchars_decode($_GPC['product_txt'], ENT_QUOTES),
                    "score" => $_GPC['score'],
                    "pt_min" => $_GPC['pt_min'],
                    "pt_max" => $_GPC['pt_max'],
                    "formset" => $_GPC['formset'],
                    "types" => $_GPC['types'],
                    "tz_yh" => $_GPC['tz_yh'],
                    "kuaidi" =>$_GPC['kuaidi'] != null ?$_GPC['kuaidi']:2,
                    "show_pro" => $show_pro,
					"yunfei_ggid" => $_GPC['yunfei_ggid'],
                    "stores" => $stores_arr
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
                if($id){
                    $res = pdo_update('sudu8_page_pt_pro', $data, array('id' => $id));

                    message('更新成功!', $this->createWebUrl('proadd',array('op'=>'types','id'=>$id), 'success'));
                }else{
                    $res = pdo_insert('sudu8_page_pt_pro', $data);
                    if (!empty($res)) {
                        $id = pdo_insertid();
                        message('新增成功!', $this->createWebUrl('proadd',array('op'=>'types','id'=>$id), 'success'));
                    }
                }
            }
        }  
        if($op == "types"){
            $id = $_GPC['id'];

            $products = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ':id'=>$id));


            $proarr = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_pro_val') ." WHERE pid = :pid order by id desc", array(':pid'=>$id));
            if($proarr){
                $types = $proarr[0]['comment'];    
                //构建规格组
                $typesarr = explode(",", $types);  
                $counttypes = count($typesarr);

                // 构建规格组json
                $typesjson = [];
                foreach ($typesarr as $key => &$rec) {
                    $str = "type".($key+1);
                    $ziji = pdo_fetchall("SELECT ".$str." FROM ".tablename('sudu8_page_pt_pro_val') ." WHERE pid = :pid group by ".$str, array(':pid'=>$id));    
                    $xarr = array();
                    foreach ($ziji as $key => $res) {
                        array_push($xarr, $res[$str]);
                    }
                    $typesjson[$rec] = $xarr;
                }
                // 构建对应的数值
                $datajson = [];
                foreach ($proarr as $key => &$rec) {
                    $strs = $rec['type1'].$rec['type2'].$rec['type3'];
                    $strv = $rec['kc'].",".$rec['price'].",".$rec['dprice'].",".$rec['thumb'];
                    $datajson[$strs]=$strv;
                }
            }else{
                $counttypes = 0;
            }

            if (checksubmit('submit')) {
                //是否启用规则
                $guig = $_GPC['ischeck'];
                $kdatas = array(
                    "types" => $guig
                );
                $rek = pdo_update('sudu8_page_pt_pro', $kdatas, array('id' => $id ,'uniacid' => $uniacid));
                // 全部删除已有数据
                pdo_delete('sudu8_page_pt_pro_val', array('pid' => $id));
        

                // 规格组长度
                $typelen = $_GPC['typelen'];
                // 规格数组
                $types = $_GPC['typesarr'];
                $typezz = $types;
                $typesarr = explode(",", $types);
                // 子商品
                $ggarr = stripslashes(html_entity_decode($_GPC['biaogedata']));
                $proarr = json_decode($ggarr,true);


                $count = 0;
                foreach ($proarr as $key => $rec) {
                    if($typelen == 1){
                        $type1 = $rec[$typesarr[0]];
                        $type2 = "";
                        $type3 = "";
                    }
                    if($typelen == 2){
                        $type1 = $rec[$typesarr[0]];
                        $type2 = $rec[$typesarr[1]];
                        $type3 = "";
                    }
                    if($typelen == 3){
                        $type1 = $rec[$typesarr[0]];
                        $type2 = $rec[$typesarr[1]];
                        $type3 = $rec[$typesarr[2]];
                    }
                    $data = array(
                        "pid" => $id,
                        "type1" => $type1,
                        "type2" => $type2,
                        "type3" => $type3,
                        "kc" => $rec['库存'],
                        "price" => $rec['拼团价'],
                        "dprice" => $rec['单买价'],
                        "thumb" => $rec['规格图片'],
                        "comment" => $typezz
                    );
                    $res = pdo_insert("sudu8_page_pt_pro_val",$data);
                    if($res){
                        $count++;
                        if($count == count($proarr)){
                            message('新增/修改成功!', $this->createWebUrl('prolist',array('op'=>'duoproducts'), 'success')); 
                        }
                    }
                }
                

            }
        }   

		
        include $this->template('proadd');
    }

    // ccc
    

    // 拼团产品管理
    public function doWebprolist() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','delete');
        $op = in_array($op, $ops) ? $op : 'display';
        if ($op == 'display') {
			$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_pro') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 10;  
			$p = ($pageindex-1) * $pagesize;
			$pager = pagination($total, $pageindex, $pagesize); 

            $products = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE uniacid = :uniacid ORDER BY num desc limit ".$p.",".$pagesize, array(':uniacid' => $uniacid));
            foreach ($products as $key => &$res) {
                $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_cate') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $res['cid']));
                $res['cate'] = $cate['title'];
            }
        }
        if ($op == 'delete') {
            $id = intval($_GPC['id']);

			$pro_check = pdo_fetch("select id from ".tablename('sudu8_page_pt_pro')." where id = :id and uniacid = :uniacid",array(':id' => $id,':uniacid' => $uniacid));

			$order_check = pdo_fetchall("select jsondata from ".tablename('sudu8_page_pt_order')." where uniacid = :uniacid",array(':uniacid' => $uniacid));
			
			foreach($order_check as $key => $value){
				$jsondata = unserialize($value['jsondata']);
				foreach($jsondata as $kk => $vv){
					if($vv['pvid'] == $pro_check['id']){
						message('此商品有订单未完成,只保留下架功能!', $this->createWebUrl('prolist', array('op'=>'display')), 'success');
					}
				}
			}
			
            pdo_delete('sudu8_page_pt_pro', array('id' => $id ,'uniacid' => $uniacid));
            pdo_delete('sudu8_page_pt_pro_val', array('pid' => $id));
            message('删除成功!', $this->createWebUrl('prolist', array('op'=>'display')), 'success');
        }
		
        include $this->template('prolist');
    }

    //主动取消订单
    public function doWebqxorder(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $orderid = $_GPC['orderid'];
        $orderinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_order') ." WHERE uniacid = :uniacid and order_id = :order_id", array(':uniacid' => $uniacid, ':order_id'=>$orderid));
        pdo_update("sudu8_page_pt_order",array("flag"=>5),array("order_id"=>$orderid));
        $pdata=array(
            "uniacid"=>$uniacid,
            "openid"=>$orderinfo['openid'],
            "ptorder"=> $orderinfo['order_id'],
            "money"=>$orderinfo['price'],
            "creattime"=>time(),
            "flag"=>1,
            "is_success"=>1,
        );
        $res = pdo_insert("sudu8_page_pt_tx",$pdata);
        if($res){
            $id = pdo_insertid();
            $tx_query = pdo_fetch("select * from ".tablename('sudu8_page_pt_tx')." where id = :id and uniacid = :uniacid",array(':id' => $id,':uniacid' => $uniacid));
            $order_query = pdo_fetch("select * from ".tablename('sudu8_page_pt_order')." where order_id = :orderid and uniacid = :uniacid",array(':orderid' => $tx_query['ptorder'],':uniacid' => $uniacid));
            $yue_price = $order_query['yue_price'];
            $wx_price = $order_query['wx_price'];
            $user_info = pdo_fetch("select * from ".tablename('sudu8_page_user')." where openid = :openid and uniacid = :uniacid",array(':openid' => $tx_query['openid'],':uniacid' => $uniacid));
            if($tx_query['is_success'] == 1){
                $nowscore = $user_info['score'];
                $newscore = $nowscore*1 + $order_query['jf']*1;
                if($order_query['jf']>0){
                    $xfscore=array(
                        "uniacid"=>$uniacid,
                        "orderid"=>$order_query['order_id'],
                        "uid"=>$user_info["id"],
                        "type" => "add",
                        "score" => $order_query['jf']*1,
                        "message" => "拼团退还积分",
                        "creattime" => time()
                    );
                    pdo_insert("sudu8_page_score", $xfscore);
                }

                pdo_update("sudu8_page_user",array("score"=>$newscore),array("openid"=>$user_info['openid']));
                // 返回优惠券
                if($order_query['coupon']!=0){
                    // 先判断优惠券有没有过期了
                    $coupon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $order_query['coupon'],':uniacid' => $_W['uniacid']));
                    // 如果没有过期更改优惠券状态
                    if($coupon['etime']==0){
                        pdo_update("sudu8_page_coupon_user", array("utime"=>0,"flag"=>0), array("id" => $order_query['coupon']));
                    }else{
                        if($now <= $coupon['etime']){
                            pdo_update("sudu8_page_coupon_user", array("utime"=>0,"flag"=>0), array("id" => $order_query['coupon']));
                        }
                    }
                }
            }

            if($yue_price > 0){
                $new_yue = $user_info['money'] + $yue_price;
                $moneydata = array(
                    "money" => $new_yue
                    );
                pdo_update('sudu8_page_user',$moneydata,array('id' => $user_info['id']));
                pdo_update('sudu8_page_pt_order',array('yue_price' => 0),array('id' => $order_query['id']));
            }
            
            if($wx_price > 0){
                $app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
                $paycon = pdo_fetch("SELECT * FROM ".tablename('uni_settings')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
                $datas = unserialize($paycon['payment']);
                include 'WeixinPay.php';  
                $appid=$app['key'];  
                $appkey = $app['secret'];
                $mch_id=$datas['wechat']['mchid'];  
                $apikey=$datas['wechat']['signkey']; 
                // 更新信息
                $sqtx = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_tx')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $_W['uniacid'],':id' => $id));
                $openid= $sqtx['openid'];    //申请者的openid
                $outTradeNo = $sqtx['ptorder'];
                $totalFee= $sqtx['money']*100;  //申请了提现多少钱
                $outRefundNo = $sqtx['ptorder']; //商户订单号
                $refundFee= $sqtx['money']*100;  //申请了提现多少钱
                $SSLCERT_PATH = ROOT_PATH.'Cert/'.$uniacid.'/apiclient_cert.pem';//证书路径
                $SSLKEY_PATH =  ROOT_PATH.'Cert/'.$uniacid.'/apiclient_key.pem';//证书路径
                $opUserId = $mch_id;//商户号
                include "WinXinRefund.php";
                $weixinpay = new WinXinRefund($openid,$outTradeNo,$totalFee,$outRefundNo,$refundFee,$SSLCERT_PATH,$SSLKEY_PATH,$opUserId,$appid,$apikey);
                $return = $weixinpay->refund();
                if(!$return){
                    message('微信退款失败 请检查证书是否正常!', $this->createWebUrl('pttk', array('op'=>'display')), 'error');
                }
            }
            
            if($return){
                if($return['result_code'] == "SUCCESS"){
                    if($wx_price>0){
                         $xfmoney1=array(
                            "uniacid"=>$uniacid,
                            "orderid"=>$tx_query['ptorder'],
                            "uid"=>$user_info["id"],
                            "type"=>"add",
                            "score"=>$wx_price,
                            "message"=>"拼团失败退款",
                            "creattime"=>time()
                        );
                        pdo_insert("sudu8_page_money", $xfmoney1);
                    }

                    if($yue_price>0){
                        $xfmoney2=array(
                            "uniacid"=>$uniacid,
                            "orderid"=>$tx_query['ptorder'],
                            "uid"=>$user_info["id"],
                            "type"=>"add",
                            "score"=>$yue_price,
                            "message"=>"拼团失败退款",
                            "creattime"=>time()
                        );
                        pdo_insert("sudu8_page_money", $xfmoney2);
                    }
                    pdo_update('sudu8_page_pt_tx', array("flag"=>2,"txtime"=>time()), array('id' => $id));
                    pdo_update('sudu8_page_pt_order',array('wx_price' => 0),array('id' => $order_query['id']));
                    message('取消并退款成功 状态修改成功!', $this->createWebUrl('orderlist', array('op'=>'display')), 'success');
                }else{
                    message('取消并余额退款成功，微信退款失败 非微信支付订单或商户余额不足!', $this->createWebUrl('orderlist', array('op'=>'display')), 'error');
                }
            } else{
                if($wx_price>0){
                    $xfmoney1=array(
                        "uniacid"=>$uniacid,
                        "orderid"=>$tx_query['ptorder'],
                        "uid"=>$user_info["id"],
                        "type"=>"add",
                        "score"=>$wx_price,
                        "message"=>"拼团取消退款",
                        "creattime"=>time()
                    );
                    pdo_insert("sudu8_page_money", $xfmoney1);
                }

                if($yue_price>0){
                    $xfmoney2=array(
                        "uniacid"=>$uniacid,
                        "orderid"=>$tx_query['ptorder'],
                        "uid"=>$user_info["id"],
                        "type"=>"add",
                        "score"=>$yue_price,
                        "message"=>"拼团取消退款",
                        "creattime"=>time()
                    );
                    pdo_insert("sudu8_page_money", $xfmoney2);
                }
                pdo_update('sudu8_page_pt_tx', array("flag"=>2,"txtime"=>time()), array('id' => $id));
                message('取消并退款成功 状态修改成功!', $this->createWebUrl('orderlist', array('op'=>'display')), 'success');
            }
        }
    }
    public function doWebpttk(){
        //退款管理
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','shenhe');
        $op = in_array($op, $ops) ? $op : 'display';
        if ($op == 'display') {
			$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_tx') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 10;  
			$p = ($pageindex-1) * $pagesize;
			$pager = pagination($total, $pageindex, $pagesize); 

            $sqtx = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_tx') ." WHERE uniacid = :uniacid order by id desc limit ".$p.",".$pagesize, array(':uniacid' => $uniacid));
            foreach ($sqtx as $key => &$res) {
                $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user') ." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $res['openid']));
                $user['nickname'] = rawurldecode($user['nickname']);
                $res['userinfo'] = $user;
                $res['creattime'] = date("Y-m-d H:i:s", $res['creattime']);
            }
        }
        if($op == 'shenhe'){

            $id = $_GPC['id'];
            $val = $_GPC['val'];

			$tx_query = pdo_fetch("select * from ".tablename('sudu8_page_pt_tx')." where id = :id and uniacid = :uniacid",array(':id' => $id,':uniacid' => $uniacid));

			$order_query = pdo_fetch("select * from ".tablename('sudu8_page_pt_order')." where order_id = :orderid and uniacid = :uniacid",array(':orderid' => $tx_query['ptorder'],':uniacid' => $uniacid));

            $yue_price = $order_query['yue_price'];
            $wx_price = $order_query['wx_price'];
            $user_info = pdo_fetch("select * from ".tablename('sudu8_page_user')." where openid = :openid and uniacid = :uniacid",array(':openid' => $tx_query['openid'],':uniacid' => $uniacid));
            if($val==2){
                if($tx_query['is_success'] == 1){
                    $nowscore = $user_info['score'];
                    $newscore = $nowscore*1 + $order_query['jf']*1;
                    if($order_query['jf']>0){
                        $xfscore=array(
                            "uniacid"=>$uniacid,
                            "orderid"=>$order_query['order_id'],
                            "uid"=>$user_info["id"],
                            "type" => "add",
                            "score" => $order_query['jf']*1,
                            "message" => "拼团退还积分",
                            "creattime" => time()
                        );
                        pdo_insert("sudu8_page_score", $xfscore);
                    }

                    pdo_update("sudu8_page_user",array("score"=>$newscore),array("openid"=>$user_info['openid']));
                    // 返回优惠券
                    if($order_query['coupon']!=0){
                        // 先判断优惠券有没有过期了
                        $coupon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $order_query['coupon'],':uniacid' => $_W['uniacid']));
                        // 如果没有过期更改优惠券状态
                        if($coupon['etime']==0){
                            pdo_update("sudu8_page_coupon_user", array("utime"=>0,"flag"=>0), array("id" => $order_query['coupon']));
                        }else{
                            if($now <= $coupon['etime']){
                                pdo_update("sudu8_page_coupon_user", array("utime"=>0,"flag"=>0), array("id" => $order_query['coupon']));
                            }
                        }
                    }
                }

				if($yue_price > 0){
					$new_yue = $user_info['money'] + $yue_price;
					$moneydata = array(
						"money" => $new_yue
						);
					pdo_update('sudu8_page_user',$moneydata,array('id' => $user_info['id']));
					pdo_update('sudu8_page_pt_order',array('yue_price' => 0),array('id' => $order_query['id']));
				}
				
				if($wx_price > 0){
					$app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
					$paycon = pdo_fetch("SELECT * FROM ".tablename('uni_settings')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
					$datas = unserialize($paycon['payment']);
					include 'WeixinPay.php';  
					$appid=$app['key'];  
					$appkey = $app['secret'];
					$mch_id=$datas['wechat']['mchid'];  
					$apikey=$datas['wechat']['signkey']; 
					// 更新信息
					$sqtx = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_tx')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $_W['uniacid'],':id' => $id));
					$openid= $sqtx['openid'];    //申请者的openid
					$outTradeNo = $sqtx['ptorder'];
					$totalFee= $sqtx['money']*100;  //申请了提现多少钱
					$outRefundNo = $sqtx['ptorder']; //商户订单号
					$refundFee= $sqtx['money']*100;  //申请了提现多少钱
					$SSLCERT_PATH = ROOT_PATH.'Cert/'.$uniacid.'/apiclient_cert.pem';//证书路径
					$SSLKEY_PATH =  ROOT_PATH.'Cert/'.$uniacid.'/apiclient_key.pem';//证书路径
					$opUserId = $mch_id;//商户号
					include "WinXinRefund.php";
					$weixinpay = new WinXinRefund($openid,$outTradeNo,$totalFee,$outRefundNo,$refundFee,$SSLCERT_PATH,$SSLKEY_PATH,$opUserId,$appid,$apikey);
					$return = $weixinpay->refund();
					if(!$return){
						message('微信退款失败 请检查证书是否正常!', $this->createWebUrl('pttk', array('op'=>'display')), 'error');
					}
				}
				
				if($return){
					if($return['result_code'] == "SUCCESS"){
                        if($wx_price>0){
                             $xfmoney1=array(
                                "uniacid"=>$uniacid,
                                "orderid"=>$tx_query['ptorder'],
                                "uid"=>$user_info["id"],
                                "type"=>"add",
                                "score"=>$wx_price,
                                "creattime"=>time()
                            );
                             if($tx_query['is_success'] == 1){
                                $xfmoney1['message'] = "拼团取消退款";
                             }else{
                                $xfmoney1['message'] = "拼团失败退款";
                             }
                            pdo_insert("sudu8_page_money", $xfmoney1);
                        }

                        if($yue_price>0){
                            $xfmoney2=array(
                                "uniacid"=>$uniacid,
                                "orderid"=>$tx_query['ptorder'],
                                "uid"=>$user_info["id"],
                                "type"=>"add",
                                "score"=>$yue_price,
                                "creattime"=>time()
                            );
                             if($tx_query['is_success'] == 1){
                                $xfmoney2['message'] = "拼团取消退款";
                             }else{
                                $xfmoney2['message'] = "拼团失败退款";
                             }
                            pdo_insert("sudu8_page_money", $xfmoney2);
                        }
						pdo_update('sudu8_page_pt_tx', array("flag"=>2,"txtime"=>time()), array('id' => $id));
						pdo_update('sudu8_page_pt_order',array('wx_price' => 0),array('id' => $order_query['id']));
						message('退款成功 状态修改成功!', $this->createWebUrl('pttk', array('op'=>'display')), 'success');
					}else{
						message('余额退款成功，微信退款失败 非微信支付订单或商户余额不足!', $this->createWebUrl('pttk', array('op'=>'display')), 'error');
					}

				} else{
                    if($wx_price>0){
                        $xfmoney1=array(
                            "uniacid"=>$uniacid,
                            "orderid"=>$tx_query['ptorder'],
                            "uid"=>$user_info["id"],
                            "type"=>"add",
                            "score"=>$wx_price,
                            "creattime"=>time()
                        );
                        if($tx_query['is_success'] == 1){
                            $xfmoney1['message'] = "拼团取消退款";
                        }else{
                            $xfmoney1['message'] = "拼团失败退款";
                        }
                        pdo_insert("sudu8_page_money", $xfmoney1);
                    }

                    if($yue_price>0){
                        $xfmoney2=array(
                            "uniacid"=>$uniacid,
                            "orderid"=>$tx_query['ptorder'],
                            "uid"=>$user_info["id"],
                            "type"=>"add",
                            "score"=>$yue_price,
                            "creattime"=>time()
                        );
                        if($tx_query['is_success'] == 1){
                            $xfmoney2['message'] = "拼团取消退款";
                        }else{
                            $xfmoney3['message'] = "拼团失败退款";
                        }
                        pdo_insert("sudu8_page_money", $xfmoney2);
                    }
					pdo_update('sudu8_page_pt_tx', array("flag"=>2,"txtime"=>time()), array('id' => $id));
					message('退款成功 状态修改成功!', $this->createWebUrl('pttk', array('op'=>'display')), 'success');
				}
                
            }
            if($val==3){
                if($tx_query['is_success']){ //成团订单
                    if($order_query['nav'] == 1 && $order_query['kuaidihao']){ //发货订单
                        pdo_update('sudu8_page_pt_order', array("flag"=>4,"txtime"=>time()), array('id' => $id));
                    }else{
                        pdo_update('sudu8_page_pt_order', array("flag"=>1,"txtime"=>time()), array('id' => $id));
                    }
                }
                pdo_update('sudu8_page_pt_tx', array("flag"=>3,"txtime"=>time()), array('id' => $id));
                message('退款状态 修改成功!', $this->createWebUrl('pttk', array('op'=>'display')), 'success');
            }
        }
            include $this->template('pttx');
    }

    // 拼团订单管理
    public function doWeborderlist() {

        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display', 'hx', 'fahuo','fh','excel', 'getwuliu');
        $op = in_array($op, $ops) ? $op : 'display';

        $this->doovershare();
        if($op == 'getwuliu'){
            $kuaidi = $_GPC['kuaidi'];
            $kuaidihao = $_GPC['kuaidihao'];
            $kd_code = array(
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
            include IA_ROOT.'/addons/sudu8_page/KdSearch.php';
            $ShipperCode = $kd_code[$kuaidi];
            $LogisticCode = $kuaidihao;

            $wuliu = pdo_fetch("SELECT api_type,ebusinessid,appkey FROM ".tablename('sudu8_page_duo_products_yunfei')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
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
        if($op == "hx"){  //核销
            $order = $_GPC['order'];
            $data['hxtime'] = time();
            $data['flag'] = 2;
            $data['hxinfo'] = 'a:1:{i:0;i:1;}';
            $res = pdo_update('sudu8_page_pt_order', $data, array('id' => $order));
            $info = pdo_fetch("SELECT openid,price FROM".tablename('sudu8_page_pt_order')." WHERE id = :id", array(':id' => $order));
            $this->addAllpay($info['price'], $info['openid']);
            $this->checkVipGrade($info['openid']);
            message('核销成功!', $this->createWebUrl('orderlist',array('op'=>'display')), 'success');
        }
        if($op == "fh"){  
            $order = $_GPC['order'];
            $data['flag'] = 2;
            $res = pdo_update('sudu8_page_pt_order', $data, array('id' => $order));
            message('成功!', $this->createWebUrl('orderlist',array('op'=>'display')), 'success');
        }
        if($op == "fahuo"){  //发货
            $order = $_GPC['orderid'];
            $data['hxtime'] = time();
            $data['kuadi'] = $_GPC['kuadi'];
            $data['kuaidihao'] = $_GPC['kuaidihao'];
            $data['flag'] = 4;
            pdo_update("sudu8_page_pt_order",$data,array('id'=>$order));
            $info = pdo_fetch("SELECT openid,price FROM".tablename('sudu8_page_pt_order')." WHERE id = :id", array(':id' => $order));
            $this->addAllpay($info['price'], $info['openid']);
            $this->checkVipGrade($info['openid']);

            message('成功!', $this->createWebUrl('orderlist',array('op'=>'display')), 'success');
        }

        if($op == "excel"){
            include IA_ROOT.'/addons/sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new \PHPExcel();

            /*以下是一些设置*/
            $objPHPExcel->getProperties()->setCreator("拼团订单记录")
                ->setLastModifiedBy("拼团订单记录")
                ->setTitle("拼团订单记录")
                ->setSubject("拼团订单记录")
                ->setDescription("拼团订单记录")
                ->setKeywords("拼团订单记录")
                ->setCategory("拼团订单记录");
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '下单时间');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '拼团编号');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '订单编号');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '商品信息');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '总价');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '核销时间');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', '姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', '联系方式');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', '邮编');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', '地址');
            $objPHPExcel->getActiveSheet()->setCellValue('K1', '状态');

                    $order_id = $_GPC['order_id'];
                    if($order_id){
                        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and order_id LIKE :order_id and jqr = 1" , array(':uniacid' => $_W['uniacid'],':order_id' => '%'.$order_id.'%'));
                        $pageindex = max(1, intval($_GPC['page']));
                        $pagesize = 10;  
                        $p = ($pageindex-1) * $pagesize;
                        $pager = pagination($total, $pageindex, $pagesize); 

                        $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and order_id LIKE :order_id and jqr = 1 order by creattime desc  ", array(':uniacid' => $_W['uniacid'],':order_id' => '%'.$order_id.'%'));
                        foreach ($orders as $key => &$res) {
                            $res['jsondata'] = unserialize($res['jsondata']);
                            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                            $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                            $res['counts'] = count($res['jsondata']);
                            $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                            $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                            $res['couponinfo'] = $couponinfo;

                            $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
                            if($res['hxtime'] == 0 && $res['nav'] == 1){
                                $res['hxtime'] = "无";
                            }

                            // 订单退款情况
                            $pt_tx = pdo_fetch("select * from ".tablename('sudu8_page_pt_tx')." where ptorder = :ptorder and uniacid = :uniacid",array(':ptorder' => $res['order_id'],':uniacid' => $uniacid));
                            if($pt_tx){
                                $res['pt_tx'] = $pt_tx;
                            }

                            // 已加入拼团人数
                            $pt_open = pdo_fetch("select * from ".tablename("sudu8_page_pt_share")." where uniacid = :uniacid and shareid = :shareid",array('uniacid' => $uniacid,'shareid' => $res['pt_order']));
                            $res['join_count'] = $pt_open['join_count'];
                            $res['pt_min'] = $pt_open['pt_min'];
                            $res['pt_max'] = $pt_open['pt_max'];

                            // 获取万能表单信息
                             if ($res['formid']) {
                                $arr2ss = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                                $res['val'] = unserialize($arr2ss);
                             }

                            // 重新算总价
                            $allprice = 0;
                            $goodsinfo = '';
                            foreach ($res['jsondata'] as $key2 => &$reb) {
                                $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                                if(!isset($reb['baseinfo2'])){
                                    $reb['baseinfo2']=pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $reb['baseinfo'] ,':uniacid' => $uniacid));
                                    $reb['baseinfo2']['thumb'] = HTTPSHOST.$reb['baseinfo2']['thumb'];
                                    $reb['proinfo']=pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro_val')." WHERE id = :id" , array(':id' => $reb['proinfo']));
                                    $goodsinfo .= $reb['baseinfo2']['title'].':规格‘'.$reb['proval_ggz'].'’、单价 '.$reb['proinfo']['price'].'*'.$reb['num'].';';
                                    if($reb['proinfo']){
                                        //$reb['proinfo']['ggz']=$reb['proinfo']['comment'].":".$reb['proinfo']['type1'];
                                        $reb['proinfo']['ggz'] = $reb['proval_ggz'];
                                    }
                                    $goodsinfo=$reb['baseinfo2']['title'].";".$reb['proinfo']['ggz'];
                                }
                            }
                            // var_dump($goodsinfo);die;
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
                            // var_dump($res['address_get']);die;
                            $num=$key+2;
                            if($res['flag'] ==0 && $res['ck'] == 2 && $res['join_count'] < $res['pt_max'] && !$res['pt_tx']['flag'] || $res['flag'] == 0 && $res['ck'] == 1 && !$res['join_count'] && !$res['pt_tx']['flag']){
                                $res['flag1'] = '未付款';
                            }else if($res['flag'] ==0 && $res['ck'] == 2 && $res['join_count'] >= $res['pt_max'] && !$res['pt_tx']['flag'] || $res['flag'] ==3 && ($res['yue_price'] == 0 || $res['wx_price'] == 0) && !$res['pt_tx']['flag'] || $res['flag'] == 3 && $res['ck'] == 1 && !$res['join_count'] && !$res['pt_tx']['flag']){
                                $res['flag1'] = '待支付、已结束';
                            }else if($res['join_count'] < $res['pt_min'] && $res['flag'] == 1 && $res['types'] == 1){
                                $res['flag1'] = '已付款';
                            }else if($res['flag'] ==1 && $res['nav'] == 2 && $res['join_count'] >= $res['pt_min'] && !$res['pt_tx']['flag'] || $res['flag'] ==3 && ($res['yue_price'] != 0 || $res['wx_price'] != 0) && $res['nav'] == 2 && $res['join_count'] >= $res['pt_min'] && !$res['pt_tx']['flag'] || $res['flag'] ==1 && $res['nav'] == 2 && $res['types'] == 2 && !$res['pt_tx']['flag']){
                                $res['flag1'] = '未核销';
                            }else if($res['flag'] == 2 ){
                                $res['flag1'] = '已完成';
                            }else if($res['flag'] == 4){
                                $res['flag1'] = '已发货';
                            }else if($res['pt_tx']['flag'] == 1){
                                $res['flag1'] = '待退款';
                            }else if($res['pt_tx']['flag'] == 2){
                                $res['flag1'] = '已退款';
                            }else if($res['pt_tx']['flag'] == 3){
                                $res['flag1'] = '已拒绝退款';
                            }else{
                                $res['flag1'] = '待发货';
                            }

                            $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValueExplicit('A'.$num, $res['creattime'],'s')
                                        ->setCellValueExplicit('B'.$num, $res['pt_order'],'s')
                                        ->setCellValueExplicit('C'.$num, $res['order_id'],'s')
                                        ->setCellValueExplicit('D'.$num, $goodsinfo,'s')
                                        ->setCellValueExplicit('E'.$num, $res['price'],'s')
                                        ->setCellValueExplicit('F'.$num, $res['hxtime'], 's')
                                        ->setCellValueExplicit('G'.$num, $res['address_get']['name'], 's')
                                        ->setCellValueExplicit('H'.$num, $res['address_get']['mobile'], 's')
                                        ->setCellValueExplicit('I'.$num, $res['address_get']['postalcode'], 's')
                                        ->setCellValueExplicit('J'.$num, $res['address_get']['address'], 's')
                                        ->setCellValueExplicit('K'.$num, $res['flag1'], 's');
                        }

                        $objPHPExcel->getActiveSheet()->setTitle('导出拼团订单');
                        $objPHPExcel->setActiveSheetIndex(0);
                        $excelname="拼团订单记录表";
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
                        header('Cache-Control: max-age=0');
                        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        $objWriter->save('php://output');
                        exit;
                        
                    }else{
                    	// include IA_ROOT.'/addons/sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';
                    	// $objPHPExcel = new \PHPExcel();

                    	/*以下是一些设置*/
                    	$objPHPExcel->getProperties()->setCreator("拼团订单记录")
                    	    ->setLastModifiedBy("拼团订单记录")
                    	    ->setTitle("拼团订单记录")
                    	    ->setSubject("拼团订单记录")
                    	    ->setDescription("拼团订单记录")
                    	    ->setKeywords("拼团订单记录")
                    	    ->setCategory("拼团订单记录");
                    	$objPHPExcel->getActiveSheet()->setCellValue('A1', '下单时间');
                    	$objPHPExcel->getActiveSheet()->setCellValue('B1', '拼团编号');
                    	$objPHPExcel->getActiveSheet()->setCellValue('C1', '订单编号');
                    	$objPHPExcel->getActiveSheet()->setCellValue('D1', '商品信息');
                    	$objPHPExcel->getActiveSheet()->setCellValue('E1', '总价');
                    	$objPHPExcel->getActiveSheet()->setCellValue('F1', '核销时间');
                    	$objPHPExcel->getActiveSheet()->setCellValue('G1', '姓名');
                    	$objPHPExcel->getActiveSheet()->setCellValue('H1', '联系方式');
                    	$objPHPExcel->getActiveSheet()->setCellValue('I1', '邮编');
                    	$objPHPExcel->getActiveSheet()->setCellValue('J1', '地址');
                    	$objPHPExcel->getActiveSheet()->setCellValue('K1', '状态');
                        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and jqr = 1" , array(':uniacid' => $_W['uniacid']));
                        $pageindex = max(1, intval($_GPC['page']));
                        $pagesize = 10;  
                        $p = ($pageindex-1) * $pagesize;
                        $pager = pagination($total, $pageindex, $pagesize); 

                        $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and jqr = 1 order by creattime desc " , array(':uniacid' => $_W['uniacid']));
                        // var_dump($orders);die;
                        foreach ($orders as $key => &$res) {
                            $res['jsondata'] = unserialize($res['jsondata']);
                            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                            $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
                            
                            if($res['hxtime'] == 0 && $res['nav'] == 1){
                                $res['hxtime'] = "无";
                            }

                            // 订单退款情况
                            $pt_tx = pdo_fetch("select * from ".tablename('sudu8_page_pt_tx')." where ptorder = :ptorder and uniacid = :uniacid",array(':ptorder' => $res['order_id'],':uniacid' => $uniacid));
                            if($pt_tx){
                                $res['pt_tx'] = $pt_tx;
                            }

                            $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                            $res['counts'] = count($res['jsondata']);
                            $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                            $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                            $res['couponinfo'] = $couponinfo;
                            
                            // 已加入拼团人数
                            $pt_open = pdo_fetch("select * from ".tablename("sudu8_page_pt_share")." where uniacid = :uniacid and shareid = :shareid",array('uniacid' => $uniacid,'shareid' => $res['pt_order']));
                            $res['join_count'] = $pt_open['join_count'];
                            $res['pt_min'] = $pt_open['pt_min'];
                            $res['pt_max'] = $pt_open['pt_max'];



                            //获取万能表单信息
                            if($res['formid']){
                                $arr2ss = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                                $res[$key]['val'] = unserialize($arr2ss);
                            }

                            // 重新算总价
                            $allprice = 0;
                            foreach ($res['jsondata'] as $key2 => &$reb) {

                                $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                                if(!isset($reb['baseinfo2'])){
                                    $reb['baseinfo2']=pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $reb['baseinfo'] ,':uniacid' => $uniacid));
                                    $reb['baseinfo2']['thumb'] = HTTPSHOST.$reb['baseinfo2']['thumb'];
                                    
                                    $reb['proinfo']=pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro_val')." WHERE id = :id" , array(':id' => $reb['proinfo']));
                                    if($reb['proinfo']){
                                        //$reb['proinfo']['ggz']=$reb['proinfo']['comment'].":".$reb['proinfo']['type1'];
                                        $reb['proinfo']['ggz'] = $reb['proval_ggz'];
                                    }
                                    $goodsinfo=$reb['baseinfo2']['title'].";".$reb['proinfo']['ggz'];
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

                            $num=$key+2;
                            if($res['flag'] ==0 && $res['ck'] == 2 && $res['join_count'] < $res['pt_max'] && !$res['pt_tx']['flag'] || $res['flag'] == 0 && $res['ck'] == 1 && !$res['join_count'] && !$res['pt_tx']['flag']){
                                $res['flag1'] = '未付款';
                            }else if($res['flag'] ==0 && $res['ck'] == 2 && $res['join_count'] >= $res['pt_max'] && !$res['pt_tx']['flag'] || $res['flag'] ==3 && ($res['yue_price'] == 0 || $res['wx_price'] == 0) && !$res['pt_tx']['flag'] || $res['flag'] == 3 && $res['ck'] == 1 && !$res['join_count'] && !$res['pt_tx']['flag']){
                                $res['flag1'] = '待支付、已结束';
                            }else if($res['join_count'] < $res['pt_min'] && $res['flag'] == 1 && $res['types'] == 1){
                                $res['flag1'] = '已付款';
                            }else if($res['flag'] ==1 && $res['nav'] == 2 && $res['join_count'] >= $res['pt_min'] && !$res['pt_tx']['flag'] || $res['flag'] ==3 && ($res['yue_price'] != 0 || $res['wx_price'] != 0) && $res['nav'] == 2 && $res['join_count'] >= $res['pt_min'] && !$res['pt_tx']['flag'] || $res['flag'] ==1 && $res['nav'] == 2 && $res['types'] == 2 && !$res['pt_tx']['flag']){
                                $res['flag1'] = '未核销';
                            }else if($res['flag'] == 2 ){
                                $res['flag1'] = '已完成';
                            }else if($res['flag'] == 4){
                                $res['flag1'] = '已发货';
                            }else if($res['pt_tx']['flag'] == 1){
                                $res['flag1'] = '待退款';
                            }else if($res['pt_tx']['flag'] == 2){
                                $res['flag1'] = '已退款';
                            }else if($res['pt_tx']['flag'] == 3){
                                $res['flag1'] = '已拒绝退款';
                            }else{
                                $res['flag1'] = '待发货';
                            }

                            $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValueExplicit('A'.$num, $res['creattime'],'s')
                                        ->setCellValueExplicit('B'.$num, $res['pt_order'],'s')
                                        ->setCellValueExplicit('C'.$num, $res['order_id'],'s')
                                        ->setCellValueExplicit('D'.$num, $goodsinfo,'s') 
                                        ->setCellValueExplicit('E'.$num, $res['price'],'s')
                                        ->setCellValueExplicit('F'.$num, $res['hxtime'], 's')
                                        ->setCellValueExplicit('G'.$num, $res['address_get']['name'], 's')
                                        ->setCellValueExplicit('H'.$num, $res['address_get']['mobile'], 's')
                                        ->setCellValueExplicit('I'.$num, $res['address_get']['postalcode'], 's')
                                        ->setCellValueExplicit('J'.$num, $res['address_get']['address'], 's')
                                        ->setCellValueExplicit('K'.$num, $res['flag1'], 's');
                        }
                        	$objPHPExcel->getActiveSheet()->setTitle('导出拼团订单');
                        	$objPHPExcel->setActiveSheetIndex(0);
                        	$excelname="拼团订单记录表";
                        	header('Content-Type: application/vnd.ms-excel');
                        	header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
                        	header('Cache-Control: max-age=0');
                        	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        	$objWriter->save('php://output');
                        	exit;

                    }

        }

        // 处理已发货并且过了7天还没有确定的订单
        $clorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and flag = 4" , array(':uniacid' => $_W['uniacid']));
		$pt_gz = pdo_fetch("select * from ".tablename('sudu8_page_pt_gz')." where uniacid = :uniacid",array(':uniacid' => $_W['uniacid']));
		
        foreach ($clorders as $key => &$res) {
            $st = $res['hxtime'] + 3600*24*$pt_gz['fahuo'];
            if($st < time()){
                $adata = array(
                    "hxtime" => $st,
                    "flag" => 2
                );
                pdo_update("sudu8_page_pt_order",$adata,array('id'=>$res['id']));

                // 核销完成后去检测要不要进行分销商返现
                $order_id = $res['order_id'];
                $openid = $res['openid'];

                $fxsorder = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$order_id));
                if($fxsorder){
                    $this->dopagegivemoney($openid,$order_id);
                }

            }
        }
        // 处理30分钟未付款的订单
        $wforders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and flag = 0" , array(':uniacid' => $_W['uniacid']));
        foreach ($wforders as $key => &$res) {
            $st = $res['creattime'] + 1800;
            if($st < time()){
                $adata = array(
                    "flag" => 3
                );
                pdo_update("sudu8_page_pt_order",$adata,array('id'=>$res['id']));
                pdo_update("sudu8_page_fx_ls",$adata,array('uniacid' => $uniacid,'orderid'=>$res['order_id']));

            }
        }

        $order_id = $_GPC['order_id'];
        if($order_id){
			$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and order_id LIKE :order_id and jqr = 1" , array(':uniacid' => $_W['uniacid'],':order_id' => '%'.$order_id.'%'));
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 10;  
			$p = ($pageindex-1) * $pagesize;
			$pager = pagination($total, $pageindex, $pagesize); 

            $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and order_id LIKE :order_id and jqr = 1 order by creattime desc limit ".$p.",".$pagesize, array(':uniacid' => $_W['uniacid'],':order_id' => '%'.$order_id.'%'));
            foreach ($orders as $key => &$res) {
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
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;

				$res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
				if($res['hxtime'] == 0 && $res['nav'] == 1){
					$res['hxtime'] = "无";
				}

				// 订单退款情况
				$pt_tx = pdo_fetch("select * from ".tablename('sudu8_page_pt_tx')." where ptorder = :ptorder and uniacid = :uniacid",array(':ptorder' => $res['order_id'],':uniacid' => $uniacid));
				if($pt_tx){
					$res['pt_tx'] = $pt_tx;
				}

				// 已加入拼团人数
				$pt_open = pdo_fetch("select * from ".tablename("sudu8_page_pt_share")." where uniacid = :uniacid and shareid = :shareid",array('uniacid' => $uniacid,'shareid' => $res['pt_order']));
				$res['join_count'] = $pt_open['join_count'];
				$res['pt_min'] = $pt_open['pt_min'];
				$res['pt_max'] = $pt_open['pt_max'];


                // 获取万能表单信息
                 if ($res['formid']) {
                    $arr2ss = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                    $res['val'] = unserialize($arr2ss);
                 }

                // 重新算总价
                $allprice = 0;
                foreach ($res['jsondata'] as $key2 => &$reb) {
                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                    if(!isset($reb['baseinfo2'])){
                        $reb['baseinfo2']=pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $reb['baseinfo'] ,':uniacid' => $uniacid));
                        $reb['baseinfo2']['thumb'] = HTTPSHOST.$reb['baseinfo2']['thumb'];
                        $reb['proinfo']=pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro_val')." WHERE id = :id" , array(':id' => $reb['proinfo']));
                        if($reb['proinfo']){
                            //$reb['proinfo']['ggz']=$reb['proinfo']['comment'].":".$reb['proinfo']['type1'];
							$reb['proinfo']['ggz'] = $reb['proval_ggz'];
                        }
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
			
        }else{
			$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and jqr = 1" , array(':uniacid' => $_W['uniacid']));
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 10;  
			$p = ($pageindex-1) * $pagesize;
			$pager = pagination($total, $pageindex, $pagesize); 

            $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid and jqr = 1 order by creattime desc limit ".$p.",".$pagesize , array(':uniacid' => $_W['uniacid']));
            foreach ($orders as $key => &$res) {
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
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
				
				if($res['hxtime'] == 0 && $res['nav'] == 1){
					$res['hxtime'] = "无";
				}

				// 订单退款情况
				$pt_tx = pdo_fetch("select * from ".tablename('sudu8_page_pt_tx')." where ptorder = :ptorder and uniacid = :uniacid",array(':ptorder' => $res['order_id'],':uniacid' => $uniacid));
				if($pt_tx){
					$res['pt_tx'] = $pt_tx;
				}

                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;
				
				// 已加入拼团人数
				$pt_open = pdo_fetch("select * from ".tablename("sudu8_page_pt_share")." where uniacid = :uniacid and shareid = :shareid",array('uniacid' => $uniacid,'shareid' => $res['pt_order']));
				$res['join_count'] = $pt_open['join_count'];
				$res['pt_min'] = $pt_open['pt_min'];
				$res['pt_max'] = $pt_open['pt_max'];

                 // 获取万能表单信息
                 if ($res['formid']) {
                    $arr2ss = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                    $res['val'] = unserialize($arr2ss);
                 }


                // 重新算总价
                $allprice = 0;
                foreach ($res['jsondata'] as $key2 => &$reb) {

                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                    if(!isset($reb['baseinfo2'])){
                        $reb['baseinfo2']=pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $reb['baseinfo'] ,':uniacid' => $uniacid));
                        $reb['baseinfo2']['thumb'] = HTTPSHOST.$reb['baseinfo2']['thumb'];
						
                        $reb['proinfo']=pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro_val')." WHERE id = :id" , array(':id' => $reb['proinfo']));
                        if($reb['proinfo']){
                            //$reb['proinfo']['ggz']=$reb['proinfo']['comment'].":".$reb['proinfo']['type1'];
							$reb['proinfo']['ggz'] = $reb['proval_ggz'];
                        }
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

        include $this->template('orderlist');
    }


    // 拼团邀请管理
    public function doWebyaoqing() {
            
    	global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display', 'heixiao');
        $op = in_array($op, $ops) ? $op : 'display';

        $this->doovershare();

		$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_share')." WHERE uniacid = :uniacid order by id desc" , array(':uniacid' => $_W['uniacid']));
		$pageindex = max(1, intval($_GPC['page']));
		$pagesize = 10;  
		$p = ($pageindex-1) * $pagesize;
		$pager = pagination($total, $pageindex, $pagesize); 

        $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_share')." WHERE uniacid = :uniacid order by id desc limit ".$p.",".$pagesize , array(':uniacid' => $_W['uniacid']));

        $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));

        foreach ($orders as $key => &$res) {
        	
        	// 商品
        	$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ':id'=>$res['pid']));
        	$pro['thumb'] = HTTPSHOST.$pro['thumb'];
        	$res['pro'] = $pro;
            if(empty($guiz)){
                $overtime = $res['creattime']*1 + (24 * 3600);
            }else{
                $overtime = $res['creattime']*1 + ($guiz['pt_time'] * 3600);
            }
            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
            $res['overtime'] = date("Y-m-d H:i:s",$overtime);
            // 团员
            $res['team'] = $this->getmytd($res['shareid']);
        } 
		
        include $this->template('yaoqing');
    }

    function getmytd($shareid){
    	global $_GPC, $_W;
        $uniacid = $_W['uniacid'];

        $alllist = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE pt_order = :pt_order and flag != 0 and uniacid = :uniacid order by creattime" , array(':pt_order' => $shareid,':uniacid' => $_W['uniacid']));
        foreach ($alllist as $key => &$res) {
        	$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $res['openid'] ,':uniacid' => $_W['uniacid']));
        	$res['team'] = $userinfo;
        }
        return $alllist;

    }


    // 拼团设置
    public function doWebptsz() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display','types');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];    

        $pintuan = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_gz') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

        if (checksubmit('submit')) {
            $pintuan = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_gz') ." WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));

			if(!$_GPC['pt_time']){
				$pt_time = 24;
			} else{
				$pt_time = $_GPC['pt_time'];
			}

			if(!$_GPC['fahuo']){
				$fahuo = 7;
			} else{
				$fahuo = $_GPC['fahuo'];
			}

            $data = array(
                'uniacid' => $_W['uniacid'],
                'types' => $_GPC['types'],
                'is_score' =>$_GPC['is_score'],
                'is_tuanz' =>$_GPC['is_tuanz'],
                'is_pt' => $_GPC['is_pt'],
                'is_tuikuan' => $_GPC['is_tuikuan'],
                'pt_time' =>$pt_time,
                'fahuo' =>$fahuo,
                'guiz' =>htmlspecialchars_decode($_GPC['guiz'], ENT_QUOTES)
            );

            if(!$pintuan){
                $res = pdo_insert('sudu8_page_pt_gz', $data);
            }else{
                $res = pdo_update('sudu8_page_pt_gz', $data ,array('uniacid' => $uniacid));
            }

            if($res){
                message('拼团规则  新增/更新成功!', $this->createWebUrl('ptsz', array('op'=>'display')), 'success');
            }
        }
        

        
        include $this->template('ptsz');
    }

    // 拼团邀请管理
    public function doWebptcate() {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $ops = array('display','post','delete');
        $op = in_array($op, $ops) ? $op : 'display';
        $uniacid = $_W['uniacid'];    

        //产品列表
        if ($op == 'display'){

			$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_pt_cate')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 10;  
			$p = ($pageindex-1) * $pagesize;
			$pager = pagination($total, $pageindex, $pagesize); 

            $cates = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_pt_cate')." WHERE uniacid = :uniacid  order by num desc limit ".$p.",".$pagesize, array(':uniacid' => $uniacid));
        }


        //分类修改新增
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            $cate = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));


            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => intval($_GPC['num']),         
                    'title' => $_GPC['title'],
                    'creattime' => time()
                );

                if (!$id) {
                    pdo_insert('sudu8_page_pt_cate', $data);
                } else {
                    pdo_update('sudu8_page_pt_cate', $data, array('id' => $id ,'uniacid' => $uniacid));
                }

                message('栏目 添加/修改 成功!', $this->createWebUrl('ptcate', array('op'=>'display')), 'success');
            }

        }

        //删除栏目
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('栏目不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_pt_cate', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('ptcate', array('op'=>'display')), 'success');
        }
        include $this->template('ptcate');
    }



    // 处理过期的订单
    function doovershare(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $now = time();

        $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
        $allshare = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_share')." WHERE uniacid = :uniacid and flag in (1,2)" , array(':uniacid' => $_W['uniacid']));

        foreach ($allshare as $key => &$res) {

            //$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE id = :id and uniacid = :uniacid", array(':id'=>$res['pid'],':uniacid' => $_W['uniacid']));

            $max = $res['pt_max']*1;
            $min = $res['pt_min']*1;

            $ct = $res['creattime'];
            if(empty($guiz)){
                $overtime = $ct*1 + 24 * 3600;  //拼团结束的时间
            }else{
                $overtime = $ct*1 + ($guiz['pt_time'] * 3600);  //拼团结束的时间
            }


            // 订单没过期
            if($overtime >= $now){
                // 拼团成功
                if($res['join_count']>=$min){
                    pdo_update("sudu8_page_pt_share",array("flag"=>2),array("id"=>$res['id']));
                }
            }

            // 订单已过期
            if($overtime < $now){
                // 拼团失败
                if($res['join_count']<$min){
                    // 自动成团
                    if($guiz['is_pt']==2){
                        // 生成机器人并完成订单
                        pdo_update("sudu8_page_pt_share",array("flag"=>2,"join_count"=>$min),array("id"=>$res['id']));
                        // 生成机器人订单
                        $xhjc = $min - $res['join_count'];
            
                        $tmp = range(1,30);
                        $arr = array_rand($tmp,$xhjc);

                        for($i=0; $i<$xhjc; $i++){
                            // 获取机器人信息
                            $jqr = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_robot')." WHERE id = :id" , array(':id' => $arr[$i]));
                            $jqrarr = array(
                                "uniacid" => $uniacid,
                                "openid" => $jqr['openid'],
                                "pt_order" => $res['shareid'],
                                "ck" => 2,
                                "jqr" => 2
                            );
                            pdo_insert("sudu8_page_pt_order",$jqrarr);
                        }

                    }else{
       					// 结束订单并退还所有的钱到余额
	        			pdo_update("sudu8_page_pt_share",array("flag"=>3),array("id"=>$res['id']));

	        			$lists = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_order') ." WHERE uniacid = :uniacid and pt_order = :pt_order and jqr = 1", array(':uniacid' => $uniacid, ':pt_order'=>$res['shareid']));
	        			
	        			foreach ($lists as $key1 => &$reb) {
	        				
	        				pdo_update("sudu8_page_pt_order",array("flag"=>5),array("id"=>$reb['id']));

	        				$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $reb['openid'] ,':uniacid' => $_W['uniacid']));
							$pdata=array(
		        					"uniacid"=>$uniacid,
		        					"openid"=>$reb['openid'],
		        					"ptorder"=> $reb['order_id'],
		        					"money"=>$reb['price'],
		        					"creattime"=>time(),
		        					"flag"=>1
		        					);
							pdo_insert("sudu8_page_pt_tx",$pdata);
	        				// 返回钱
			        				// $nowmoney = $user['money'];
			        				// $newmoney = $nowmoney*1 + $reb['price']*1;
	        				// 返回积分
	        				$nowscore = $user['score'];
	        				$newscore = $nowscore*1 + $reb['jf']*1;
                            if($reb['jf']>0){
                                $xfscore=array(
                                        "uniacid"=>$uniacid,
                                        "orderid"=>$reb['id'],
                                        "uid"=>$user["id"],
                                        "type" => "add",
                                        "score" => $reb['jf']*1,
                                        "message" => "拼团退还积分",
                                        "creattime" => time()
                                );
                                pdo_insert("sudu8_page_score", $xfscore);
                            }
	        				pdo_update("sudu8_page_user",array("score"=>$newscore),array("openid"=>$user['openid']));
	        				// 返回优惠券
	        				if($reb['coupon']!=0){
	        					// 先判断优惠券有没有过期了
	        					$coupon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $reb['coupon'],':uniacid' => $_W['uniacid']));
	        					// 如果没有过期更改优惠券状态
	        					if($coupon['etime']==0){
                                    pdo_update("sudu8_page_coupon_user", array("utime"=>0,"flag"=>0), array("id" => $reb['coupon']));
                                }else{
                                    if($now <= $coupon['etime']){
                                        pdo_update("sudu8_page_coupon_user", array("utime"=>0,"flag"=>0), array("id" => $reb['coupon']));
                                    }
                                }
	        				}
	        			}	 
       				}
                }else{
                    pdo_update("sudu8_page_pt_share",array("flag"=>4),array("id"=>$res['id']));
                }
            }
        }
    }
}
