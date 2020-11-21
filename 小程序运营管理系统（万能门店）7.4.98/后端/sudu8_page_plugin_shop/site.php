<?php
/**
 * sudu8_page_plugin_shop模块微站定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page_plugin_shop/');
class Sudu8_page_plugin_shopModuleSite extends WeModuleSite {
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
    public function doWebCate() {
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','post','delete');
        $op = in_array($op, $ops) ? $op : 'display';

        
        //栏目列表
        if ($op == 'display'){
            $_W['page']['title'] = '分类列表';
            $list = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_shops_cate') ." WHERE uniacid = :uniacid ORDER BY num DESC", array(':uniacid' => $uniacid));
        }
        
        //添加修改栏目
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (checksubmit('submit')) {
                if (empty($_GPC['name'])) {
                    message('请输入栏目标题！');
                }
                if(is_null($_GPC['flag'])){
                    $_GPC['flag'] = 1;
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'num' => intval($_GPC['num']),
                    'flag' => $_GPC['flag'],
                    'name' => $_GPC['name'],
                );
                if (empty($item['id'])) {
                    pdo_insert('sudu8_page_shops_cate', $data);
                } else {
                    pdo_update('sudu8_page_shops_cate', $data ,array('id' => $item['id']));
                }
                message('栏目添加/修改成功!', $this->createWebUrl('cate', array('op'=>'display')), 'success');
            }
        }
        //删除栏目
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('栏目不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_shops_cate', array('id' => $id ,'uniacid' => $uniacid));
            message('栏目删除成功!', $this->createWebUrl('cate', array('op'=>'display')), 'success');
        }
        include $this->template('cate');
    }

    public function doWebShops() {
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','post','delete','shenhe', 'cancel', 'getewm', 'getewmsc');
        $op = in_array($op, $ops) ? $op : 'display';
        //获取二维码
        if($op == 'getewm'){
            $id = $_GPC['id'];
            $store = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid = :uniacid and id = :id", [':uniacid' => $uniacid, ':id' => $id]);
        }
        // 获取二维码
        if($op == 'getewmsc'){
            $app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
            $appid = $app['key'];
            $appsecret = $app['secret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $weixin = file_get_contents($url);
            $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
            $array = get_object_vars($jsondecode);//转换成数组
            $access_token = $array['access_token'];//输出openid
            $id = $_GPC['id'];
            $ewmurl = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
            $sjc = time().rand(1000,9999);
            $data = [
                        'page' => "sudu8_page_plugin_shop/shop/shop",
                        'width' => '500',
                        'scene' => $id
                    ];
            $data=json_encode($data);
            $result = $this->_requestPost($ewmurl,$data); 
            // var_dump($result);
            // die();
            $newpath = ROOT_PATH."ewmimg";
            if(!file_exists($newpath)){
                mkdir($newpath);
            }

            file_put_contents(ROOT_PATH."ewmimg/".$sjc.".jpg", $result); 
            $path = MODULE_URL."ewmimg/".$sjc.".jpg";
            
            $tdata = array(
                "ewm" => $path
            );
            
            pdo_update("sudu8_page_shops_shop",$tdata,array("id"=>$id));
            message('二维码生成成功!', $this->createWebUrl('shops', array('id'=>$id,'op'=>'getewm')), 'success');
        }
        //生成二维码
        //栏目列表
        if ($op == 'display'){
            $_W['page']['title'] = '店铺列表';

            $catelist = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_shops_cate')." WHERE uniacid = :uniacid", [':uniacid' => $uniacid]);

            $where = "";
            $cid = $_GPC['cid'];
            $search_keys = $_GPC['search_keys'];
            if($cid > 0){
                $where .=" and cid = {$cid}";
            }
            if($search_keys != ""){
                $where .=" and name like '%{$search_keys}%'";
            }
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_shops_shop') ." WHERE uniacid = :uniacid {$where} ORDER BY createtime DESC", array(':uniacid' => $uniacid));

            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);


            $list = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_shops_shop') ." WHERE uniacid = :uniacid {$where} ORDER BY createtime DESC LIMIT ".$start.",".$pagesize, array(':uniacid' => $uniacid));
            foreach ($list as $key => &$value) {
                $catename = array();
                $cids = explode('|', $value['cid']);
                foreach ($cids as $k => $v) {
                    $catename[] = pdo_fetchcolumn("SELECT name FROM ".tablename('sudu8_page_shops_cate')." WHERE uniacid = :uniacid and id = :id",array(':uniacid'=>$uniacid,':id'=>$v));
                }
                $value['catename'] = implode("|", $catename);
            }
        }
        //添加修改
        if ($op == 'post'){
            $id = intval($_GPC['id']);
            if(!empty($id)){
                $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_shop')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
                $item['cid'] = explode('|', $item['cid']);
                $cid_num = count($item['cid']);
            }else{
                $cid_num = 1;
            }
            if(!empty($item['latitude'])){
                $item['latlong'] = $item['latitude'] . ',' . $item['longitude'];
            }
            $item['images'] = unserialize($item['images']);
            $cateList = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_shops_cate')." WHERE  uniacid = :uniacid ", array(':uniacid' => $uniacid));
            $cateNum = count($cateList);
            if (checksubmit('submit')) {
                if (empty($_GPC['name'])) {
                    message('请输入店铺名称！');
                }
                $shop_exist = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid = :uniacid and username = :username and id <> :id", array(":uniacid" => $uniacid, ":username" => $_GPC['username'], ":id" => $id));
                // pdo_getcolumn("sudu8_page_shops_shop",array("uniacid"=>$uniacid, "username"=>$_GPC['username'], "id <>" => $id), "count(*)");
                if($shop_exist['id'] > 0){
                    message("该用户名已存在！请更换用户名，建议使用手机号");
                }
                if(is_null($_GPC['flag'])){
                    $_GPC['flag'] = 1;
                }
                if(!$_GPC['openid']){
                     message("请联系商家获取唯一标识openID");
                }
                $images = serialize($_GPC['images']);
                $latlong = $_GPC['latlong'];
                $latlong = explode(',', $latlong);

                $cid = array();
                for($i = 1; $i<=$cateNum; $i++){
                    $c = 'cid'.$i;
                    if(!empty($_GPC[$c]) && !in_array($_GPC[$c], $cid)){
                        $cid[] = $_GPC[$c];
                    }
                }
                $cid = implode('|', $cid);
                
                $data = array(   
                    'cid' => $cid,   //6
                    'username' => trim($_GPC['username']), //4
                    'password' => trim($_GPC['password']),  //5
                    'openid' => $_GPC['openid'],
                    'logo' => $_GPC['logo'],     //7
                    'yyzz' => $_GPC['yyzz'],     //7
                    'bg' => $_GPC['bg'],         //8
                    'intro' => $_GPC['intro'],
                    'worktime' => $_GPC['worktime'],
                    'name' => $_GPC['name'],     //9
                    'tel' => $_GPC['tel'],      //10
                    'address' => $_GPC['address'],   //11
                    'latitude' => $latlong[0],    //12
                    'longitude' => $latlong[1],   //12
                    'star' => $_GPC['star'],   //10
                    'flag' => $_GPC['flag'],  //2
                    'hot' => $_GPC['hot'], //3
                    'descp' => $_GPC['descp'],   //15
                    'title' => $_GPC['title'],   //13
                    'num' => $_GPC['num'], //1
                    'shoppay_is' => $_GPC['shoppay_is'] ? $_GPC['shoppay_is'] : 2, //1
                    'images' => $images,   //14
                    'status' => 1,
                );

                if (empty($item['id'])) {
                    $data['uniacid'] = $uniacid;
                    $data['createtime'] = time();
                    pdo_insert('sudu8_page_shops_shop', $data);
                } else {
                    pdo_update('sudu8_page_shops_shop', $data ,array('id' => $item['id'], 'uniacid'=>$uniacid));
                }
                message('商户添加/修改成功!', $this->createWebUrl('shops', array('op'=>'display')), 'success');
            }
        }
        //删除商户
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_shop')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('商户不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_shops_shop', array('id' => $id ,'uniacid' => $uniacid));
            message('商户删除成功!', $this->createWebUrl('shops', array('op'=>'display')), 'success');
        }

        //审核商户
        if($op == 'shenhe'){
            $id = intval($_GPC['id']);


                    pdo_update('sudu8_page_shops_shop',array('status'=>1),array('uniacid'=>$uniacid, 'id'=>$id));

                      message('商户审核通过!', $this->createWebUrl('shops', array('op'=>'display')), 'success');
            
            //发送模板消息
            $applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
                    $appid = $applet['key'];
                    $appsecret = $applet['secret'];
                    if($applet)
                    {
                        
                                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
                                $a_token = $this->_requestGetcurl($url);
   

                                if($a_token)
                                {
         
                                    //获取openid
                                    $openID = pdo_fetchcolumn("SELECT openid FROM ".tablename("sudu8_page_shops_shop")." WHERE id = :id", array(':id'=>$id));
                                    // $openID = 'oYyHv0D57T_qDD2zPLhN7lRp7lEs';

                                    $url_m="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];

                                    $shenheok = pdo_fetchcolumn("SELECT shenheok FROM ".tablename('sudu8_page_shops_set')." WHERE uniacid = :uniacid", array(":uniacid"=>$uniacid));


                                    $status = pdo_fetchcolumn("SELECT status FROM ".tablename('sudu8_page_shops_shop')." WHERE id = :id", array(":id"=>$id));

                                    $formId = pdo_fetchcolumn("SELECT formId FROM ".tablename('sudu8_page_shops_shop')." WHERE id = :id", array(":id"=>$id));

        
                                    $ftime=date('Y-m-d H:i:s',time());

                                    if ($status == 1) {
                                         $tInfo = '店铺审核通过了！';
                                    } else {
                                         $tInfo = '店铺审核被拒绝！';
                                    }

                                     $post_info = '{
                                              "touser": "'.$openID.'",  
                                              "template_id": "'.$shenheok.'",        
                                              "form_id": "'.$formId.'",  
                                              "page": "sudu8_page/index/index",
                                              "access_token": "'.$url_m.'",      
                                              "data": {
                                                  "keyword1": {
                                                      "value": "'.$tInfo.'", 
                                                      "color": "#173177"
                                                  }, 
                                                  "keyword2": {
                                                      "value": "'.$ftime.'", 
                                                      "color": "#173177"
                                                  }                
                                              },
                                              "emphasis_keyword": "" 
                                            }';

                                    $this->_requestPost($url_m,$post_info);
                                }
                    }

        }

        //审核不通过
        if($op == 'cancel'){
            $id = intval($_GPC['id']);
            pdo_update('sudu8_page_shops_shop',array('status'=>2),array('uniacid'=>$uniacid, 'id'=>$id));
            message('商户申请已拒绝!', $this->createWebUrl('shops', array('op'=>'display')), 'success');

             //发送模板消息
            $applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
                    $appid = $applet['key'];
                    $appsecret = $applet['secret'];
                    if($applet)
                    {
                        
                                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
                                $a_token = $this->_requestGetcurl($url);
   

                                if($a_token)
                                {
         
                                    //获取openid
                                    $openID = pdo_fetchcolumn("SELECT openid FROM ".tablename("sudu8_page_shops_shop")." WHERE id = :id", array(':id'=>$id));
                                    // $openID = 'oYyHv0D57T_qDD2zPLhN7lRp7lEs';

                                    $url_m="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];

                                    $shenheok = pdo_fetchcolumn("SELECT shenheok FROM ".tablename('sudu8_page_shops_set')." WHERE uniacid = :uniacid", array(":uniacid"=>$uniacid));


                                    $status = pdo_fetchcolumn("SELECT status FROM ".tablename('sudu8_page_shops_shop')." WHERE id = :id", array(":id"=>$id));

                                    $formId = pdo_fetchcolumn("SELECT formId FROM ".tablename('sudu8_page_shops_shop')." WHERE id = :id", array(":id"=>$id));

        
                                    $ftime=date('Y-m-d H:i:s',time());

                                    if ($status == 1) {
                                         $tInfo = '店铺审核通过了！';
                                    } else {
                                         $tInfo = '店铺审核被拒绝！';
                                    }

                                     $post_info = '{
                                              "touser": "'.$openID.'",  
                                              "template_id": "'.$shenheok.'",        
                                              "form_id": "'.$formId.'",  
                                              "page": "sudu8_page/index/index",
                                              "access_token": "'.$url_m.'",      
                                              "data": {
                                                  "keyword1": {
                                                      "value": "'.$tInfo.'", 
                                                      "color": "#173177"
                                                  }, 
                                                  "keyword2": {
                                                      "value": "'.$ftime.'", 
                                                      "color": "#173177"
                                                  }                
                                              },
                                              "emphasis_keyword": "" 
                                            }';

                                    $this->_requestPost($url_m,$post_info);
                                }
                    }
        }
        include $this->template('shop');
    }

    public function doWebGoods(){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','post','delete','pass');
        $op = in_array($op, $ops) ? $op : 'display';

        //多商户商品列表
        if ($op == 'display'){
            $_W['page']['title'] = '商品列表';

            $storelist = pdo_fetchall("SELECT id,name FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid = :uniacid", [':uniacid' => $uniacid]);

            $where = "";
            $sid = $_GPC['sid'];
            $search_keys = $_GPC['search_keys'];
            if($sid > 0){
                $where .=" and a.sid = {$sid}";
            }
            if($search_keys != ""){
                $where .=" and a.title like '%{$search_keys}%'";
            }

            $total = pdo_fetchcolumn("SELECT count(a.id) FROM ".tablename('sudu8_page_shops_goods') ." as a left join ".tablename('sudu8_page_goods_cate')." as b on a.cid = b.id WHERE a.uniacid = :uniacid {$where} ORDER BY a.createtime DESC ", array(':uniacid' => $uniacid));
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);

            $list = pdo_fetchall("SELECT a.*,b.name as catename FROM ".tablename('sudu8_page_shops_goods') ." as a left join ".tablename('sudu8_page_goods_cate')." as b on a.cid = b.id WHERE a.uniacid = :uniacid {$where} ORDER BY a.createtime DESC LIMIT ".$start.",".$pagesize, array(':uniacid' => $uniacid));
            for($i=0; $i < count($list); $i++) {
                if($list[$i]['sid'] == '0'){
                    $list[$i]['sname'] = '总平台';
                }else{
                    $list[$i]['sname'] = pdo_fetchcolumn("SELECT name FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ':id'=>$list[$i]['sid']));
                }
            }
        }

        if ($op == 'post'){
            if(!empty($_GPC['id'])){
                $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_goods')." WHERE uniacid = :uniacid and id = :id",array(':uniacid'=>$uniacid, ':id'=>$_GPC['id']));
                $item['images'] = unserialize($item['images']);
            }

              // die(var_dump($_GPC['formset']));
            $shopList = pdo_fetchAll("SELECT * FROM " . tablename('sudu8_page_shops_shop') . " WHERE uniacid = :uniacid ORDER BY num DESC", array(':uniacid' => $uniacid));

            $listV = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_goods_cate') ." WHERE cid = :cid and uniacid = :uniacid ORDER BY num DESC,id DESC", array(':cid' => 0 ,':uniacid' => $uniacid));
            $listAll = array();

            $gwcforms = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE uniacid = :uniacid order by id desc", array(':uniacid' => $uniacid));
            foreach($listV as $key=>$val) {
                $cid = intval($val['id']);
                $listP = pdo_fetch("SELECT id,cid,name FROM ".tablename('sudu8_page_goods_cate') ." WHERE uniacid = :uniacid and id = :id ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listS = pdo_fetchAll("SELECT id,cid,name FROM ".tablename('sudu8_page_goods_cate') ." WHERE uniacid = :uniacid and cid = :id ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $cid));
                $listP['data'] = $listS;
                array_push($listAll,$listP);
            }

            if(checksubmit('submit')){
                if(empty($_GPC['title'])){
                    message('产品标题不能为空！');
                }


                $goods = pdo_fetchcolumn("SELECT goods FROM ".tablename('sudu8_page_shops_set')." WHERE uniacid = :uniacid", array(":uniacid"=>$uniacid));
                $data = array(
                    'title' => $_GPC['title'],
                    'sid' => intval($_GPC['sid']),
                    'flag' => $_GPC['flag'] != null ? $_GPC['flag'] : 1,
                    'hot' => $_GPC['hot'],
                    'pageview' => $_GPC['pageview'],
                    'vsales' => $_GPC['vsales'],
                    'rsales' => $_GPC['rsales'],
                    'sellprice' => $_GPC['sellprice'],
                    'marketprice' => $_GPC['marketprice'],
                    'storage' => $_GPC['storage'],
                    'thumb' => $_GPC['thumb'],
                    'images' => serialize($_GPC['images']),
                    'descp' => $_GPC['descp'],
                    'num' => $_GPC['num'],
                    'buy_type' => $_GPC['buy_type'],
                    'kuaidi'=>$_GPC['kuaidi'] != null ?$_GPC['kuaidi']:2,
                    'cid'=>$_GPC['cid'],
                    'video'=>$_GPC['video'],
                    'formset'=>$_GPC['formset']
                );


                if(!empty($_GPC['id'])){
                    pdo_update('sudu8_page_shops_goods', $data, array('id' => $_GPC['id'], 'uniacid' => $uniacid));
                }else{
                    $data['uniacid'] = $uniacid;
                    $data['createtime'] = time();
                    $data['status'] = ($goods == '1' && $_GPC['sid'] != '0') ? 0 : 1;    //goods为设置表里面的 "添加商品是否需要审核"
                    pdo_insert('sudu8_page_shops_goods', $data);
                }

                message('商品添加/修改成功!', $this->createWebUrl('goods', array('op'=>'display')), 'success');
            }
        }

        //删除商品
        if ($op == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_goods')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('商品不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_shops_goods', array('id' => $id ,'uniacid' => $uniacid));
            message('商品删除成功!', $this->createWebUrl('goods', array('op'=>'display')), 'success');
        }

        //审核通过
        if($op == 'pass'){
            $id = intval($_GPC['id']);
            $data = array('status' => 1);
            pdo_update('sudu8_page_shops_goods', $data, array('uniacid'=>$uniacid, 'id'=>$id));
            message('商品审核通过!', $this->createWebUrl('goods', array('op'=>'display')), 'success');
        }

        include $this->template('goods');
    }

    public function doWebOrder(){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        // var_dump($uniacid);die;
        $op = $_GPC['op'];
        $ops = array('fahuosp','post','delete','hx','excel','ziti','fahuo','getwuliu','quxiao','allowth','refuseth','refuseqx','confirmtk',);
        $op = in_array($op, $ops) ? $op : 'fahuosp';
        if($op == 'getwuliu'){
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
            include IA_ROOT.'/addons/sudu8_page/KdSearch.php';
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
        if($op == 'fahuosp'){
            $search_flag = $_GPC['search_flag'];
            $search_keys = $_GPC['search_keys'];
            $where = "";
            if($search_flag != null && $search_flag != 'undefined' && $search_flag != undefined){
                $where .= " and flag = ".$_GPC['search_flag'];
            }

            if(!empty($_GPC['search_keys'])){
                $where .= ' and order_id like "%'.$_GPC['search_keys'].'%"';
            }



            $data['kuadi'] = $_GPC['kuadi'];
            $data['kuaidihao'] = $_GPC['kuaidihao'];
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 5;
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and sid != 0 and nav = 1 {$where}", array(':uniacid' => $uniacid));
            $pager = pagination($total, $pageindex, $pagesize);
            $p = ($pageindex-1) * $pagesize;

            $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and sid != 0 and nav = 1 {$where} order by creattime desc LIMIT ".$p.",".$pagesize, array(':uniacid' => $_W['uniacid']));
            foreach ($orders as $key => &$res) {
                // var_dump($res['sid']);die;
                if(!empty($res['hxtime']) && $res['flag']!=2){
                    $now = time();
                    if(($now-$res['hxtime']) > 518400){
                            
                        pdo_update("sudu8_page_duo_products_order",array('flag'=>2),array('id'=>$res['id']));

                        if($res['sid'] != '0'){
                            $rate = pdo_fetchcolumn("SELECT jiesuan FROM ".tablename("sudu8_page_shops_set")."WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));

                            $money = pdo_fetchcolumn("SELECT tixian FROM ".tablename("sudu8_page_shops_shop")." WHERE uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$res['sid']));
                            $add = pdo_fetchcolumn("SELECT price FROM ".tablename("sudu8_page_duo_products_order")." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id" => $res['id']));
                        
                            $money = $money + number_format($add - $add*$rate*0.01,2);
                            $result = pdo_update("sudu8_page_shops_shop", array('tixian' => $money), array('uniacid'=>$uniacid, 'id'=>$res['sid']));
                        }

                    }
                }

                
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;
                if($res['sid'] == '0'){
                    $res['shopname'] = '总平台';
                }else{
                    $res['shopname'] = pdo_fetchcolumn("SELECT name FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid=:uniacid and id=:id", array(':uniacid'=>$uniacid, ':id'=>$res['sid']));
                }

                // 重新算总价
                $allprice = 0;
                foreach ($res['jsondata'] as $key2 => &$reb) {
                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
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


                // 获取万能表单信息
                if ($res['formid']) {
                    $arr2ss = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                    $res['val'] = unserialize($arr2ss);

                }

                // 转换地址
                if($res['address']!=0){
                    $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
                }else{
                    $res['address_get'] = unserialize($res['m_address']);
                }
            }
        }


        if($op == "fahuo"){  //发货
            $order = $_GPC['orderid'];
            $flag = pdo_getcolumn("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order), 'flag');
            if($flag == 6){
            message('发货失败！订单状态发送改变!',$this->createWebUrl('order', array('op'=>'fahuosp','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])),'error');
            }
            $data['hxtime'] = time();
            $data['kuadi'] = $_GPC['kuadi'];
            $data['kuaidihao'] = $_GPC['kuaidihao'];
            $data['flag'] = 4;
            pdo_update("sudu8_page_duo_products_order",$data,array('id'=>$order));
            message('成功!', $this->createWebUrl('order', array('op'=>'fahuosp','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }

        if($op == 'ziti'){
            $search_flag = $_GPC['search_flag'];
            $search_keys = $_GPC['search_keys'];
            $where = "";
            if($search_flag != null && $search_flag != 'undefined' && $search_flag != undefined){
                $where .= " and flag = ".$_GPC['search_flag'];
            }
            if(!empty($_GPC['search_keys'])){
                $where .= ' and order_id like "%'.$_GPC['search_keys'].'%"';
            }

            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 5;
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and sid != 0 and nav = 2 {$where}", array(':uniacid' => $uniacid));
            $pager = pagination($total, $pageindex, $pagesize);
            $p = ($pageindex-1) * $pagesize;

            $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and sid != 0 and nav = 2 {$where} order by creattime desc LIMIT ".$p.",".$pagesize, array(':uniacid' => $_W['uniacid']));
            foreach ($orders as $key => &$res) {
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;
                if($res['sid'] == '0'){
                    $res['shopname'] = '总平台';
                }else{
                    $res['shopname'] = pdo_fetchcolumn("SELECT name FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid=:uniacid and id=:id", array(':uniacid'=>$uniacid, ':id'=>$res['sid']));
                }

                // 重新算总价
                $allprice = 0;
                foreach ($res['jsondata'] as $key2 => &$reb) {
                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                }
                $res['allprice'] = $allprice;

               // 获取万能表单信息
                if ($res['formid']) {
                    $arr2ss = pdo_fetchcolumn("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid  and id = :id", array(':uniacid' => $uniacid,':id'=>$res['formid']));
                    $res['val'] = unserialize($arr2ss);

                }

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
                if($res['address']!=0){
                    $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
                }else{
                    $res['address_get'] = unserialize($res['m_address']);
                }
            }
        }
        //取消订单
        if($op == "quxiao" || $op == "confirmtk"){  //取消
            $order_id = $_GPC['order'];
       
            //微信退款
            if($_GPC['qxbeizhu']){
                $data['qxbeizhu'] = $_GPC['qxbeizhu'];
            }
            $now = time();
            $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
            $data['th_orderid'] = $out_refund_no;
            pdo_update("sudu8_page_duo_products_order", $data, array("uniacid"=>$uniacid, "id"=>$order_id));
            $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order_id));

            $types = ($op == "confirmtk") ? "duotk" : "duoqx";

            if($order['payprice'] > 0){
                require_once MODULE_ROOT."/../sudu8_page/WeixinRefund.php";
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
                if($op == "confirmtk"){
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
                $jsondata = unserialize($order['jsondata']);
                foreach($jsondata as $key => &$value){
                    $sgoods = pdo_get("sudu8_page_shops_goods", array("id"=>$value['proinfo']['pid']));
                    $rsales = $sgoods['rsales'] - $value['num'];
                    $storage = $sgoods['storage'] + $value['num'];
                    pdo_update("sudu8_page_shops_goods",['rsales' => $rsales, 'storage' => $storage], array("id"=>$value['proinfo']['pid']));
                }

                $flag = 9;

                // if($op == "confirmtk" && $order['qx_formid']){
                    // $refund_type = ($op == "confirmtk") ? "退回到余额" : "退回到余额（商家主动取消订单）";
                    // $res = sendTplMessage($flag, $order['openid'], $order['qx_formid'], $types, array("orderid"=>$order['order_id'], "fmsg"=>$fmsg, "fprice"=>$order['price'], "refund_type"=>$refund_type));
                // }
            }
            message('取消成功!', $this->createWebUrl('order', array('op'=>'fahuosp')), 'success');

        }    
        if($op == 'allowth'){
            $order_id = $_GPC['order'];
            //微信退款
            $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "id"=>$order_id), array("price", "order_id", "payprice"));
            $now = time();
            $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
            pdo_update("sudu8_page_duo_products_order", array("th_orderid"=>$out_refund_no), array("uniacid"=>$uniacid, "id"=>$order_id));

            if($order['payprice'] > 0){

                require_once IA_ROOT."/addons/sudu8_page/WeixinRefund.php";
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
                    $sgoods = pdo_get("sudu8_page_shops_goods", array("id"=>$value['proinfo']['pid']));
                    $rsales = $sgoods['rsales'] - $value['num'];
                    $storage = $sgoods['storage'] + $value['num'];
                    pdo_update("sudu8_page_shops_goods",['rsales' => $rsales, 'storage' => $storage], array("id"=>$value['proinfo']['pid']));
                }
            }
            message('取消成功!', $this->createWebUrl('order', array('op'=>'display')), 'success');
        }


        if($op == 'refuseth'){
            $order_id = $_GPC['order'];
            pdo_update("sudu8_page_duo_products_order", array("flag"=>9), array("uniacid"=>$uniacid, "id"=>$order_id));
            message('拒绝取消成功!', $this->createWebUrl('order', array('op'=>'display')), 'success');
        }

        if($op == 'refuseqx'){
            $order_id = $_GPC['order'];
            $res = pdo_update("sudu8_page_duo_products_order", array("flag"=>1), array("uniacid"=>$uniacid, "id"=>$order_id));
            message('拒绝取消成功!', $this->createWebUrl('order', array('op'=>'display')), 'success');
        }


        if($op == 'excel'){
            if($_GPC['biaozhi'] ==1){
                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and sid != 0 and nav =1 order by creattime desc ", array(':uniacid' => $_W['uniacid']));
            }

            if($_GPC['biaozhi'] ==2){
                $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and sid != 0 and nav =2 order by creattime desc ", array(':uniacid' => $_W['uniacid'])); 
            }
            include IA_ROOT.'/addons/sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';
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
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '店铺');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '商品信息');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '总价');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '实付金额');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', '姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', '联系方式');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', '联系地址');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', '状态');
            foreach ($orders as $key => &$res) {
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;
                if($res['sid'] == '0'){
                    $res['shopname'] = '总平台';
                }else{
                    $res['shopname'] = pdo_fetchcolumn("SELECT name FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid=:uniacid and id=:id", array(':uniacid'=>$uniacid, ':id'=>$res['sid']));
                }

                // var_dump($res['shopname']);die;

                // 重新算总价
                $allprice = 0;
                $goodsinfo = '';
                foreach ($res['jsondata'] as $key2 => &$reb) {
                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                    $goodsinfo .= '商品名：'.$reb['baseinfo']['title'].' 规格‘'.$reb['proinfo']['ggz'].'’ 单价￥'.$reb['proinfo']['price'].'*数量'.$reb['num'].',';
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
                if($res['address']!=0){
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
                        $res['flag1'] = '待核销';
                    }else if($res['flag'] == 2 && $res['nav'] == 1){
                        $res['flag1'] = '已完成';
                    }else if($res['flag'] == 2 && $res['nav'] == 2){
                        $res['flag1'] = '已结算';
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
                                ->setCellValueExplicit('C'.$num, $res['shopname'],'s') 
                                ->setCellValueExplicit('D'.$num, $goodsinfo,'s')
                                ->setCellValueExplicit('E'.$num, $res['allprice'], 's')
                                ->setCellValueExplicit('F'.$num, $res['price'], 's')
                                ->setCellValueExplicit('G'.$num, $res['address_get']['name'], 's')
                                ->setCellValueExplicit('H'.$num, $res['address_get']['mobile'], 's')
                                ->setCellValueExplicit('I'.$num, $res['address_get']['address'].$res['address_get']['more_address'], 's')
                                ->setCellValueExplicit('J'.$num, $res['flag1'], 's');
                      
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


        if($op == 'hx'){
            $orderid = $_GPC['orderid'];
            $shopid = $_GPC['shopid'];

            $data['hxtime'] = time();
            $data['flag'] = 2;
            pdo_update('sudu8_page_duo_products_order', $data, array('uniacid' => $uniacid, 'id' => $orderid));

            if($shopid != '0'){
                $rate = pdo_fetchcolumn("SELECT jiesuan FROM ".tablename("sudu8_page_shops_set")."WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
                $money = pdo_fetchcolumn("SELECT tixian FROM ".tablename("sudu8_page_shops_shop")." WHERE uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$shopid));
                $add = pdo_fetchcolumn("SELECT price FROM ".tablename("sudu8_page_duo_products_order")." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id" => $orderid));
                $money = $money + number_format($add - $add*$rate*0.01,2);
                   
                $result = pdo_update("sudu8_page_shops_shop", array('tixian' => $money), array('uniacid'=>$uniacid, 'id'=>$shopid));
            }
            $info = pdo_fetch("SELECT openid,price FROM".tablename('sudu8_page_duo_products_order')." WHERE id = :id", array(':id' => $orderid));
            $this->addAllpay($info['price'], $info['openid']);
            $this->checkVipGrade($info['openid']);

            message('核销成功!', $this->createWebUrl('order', array('op'=>'display')), 'success');
        }




        include $this->template('order');
    }



    public function doWebWithdraw(){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','post','delete','shenhe');
        $op = in_array($op, $ops) ? $op : 'display';

        if($op == 'display'){
            $records = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_shops_tixian')." WHERE uniacid = :uniacid ORDER BY createtime desc", array('uniacid' => $uniacid));
            foreach ($records as $key => &$value) {
                $value['shopname'] = pdo_fetchcolumn("SELECT name FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid=:uniacid and id=:id",array(':uniacid'=>$uniacid,':id'=>$value['sid']));
                
            }
        }

        if($op == 'shenhe'){
            $id = $_GPC['id'];
            $formid = pdo_fetchcolumn("SELECT formID FROM ".tablename('sudu8_page_shops_tixian')." WHERE uniacid=:uniacid and id=:id",array(':uniacid'=>$uniacid,':id'=>$id));
            if($formid && is_numeric($formid)){
            //发送模板消息
            $applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
                    $appid = $applet['key'];
                    $appsecret = $applet['secret'];
                    if($applet)
                    {
                        
                                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
                                $a_token = $this->_requestGetcurl($url);

                                if($a_token)
                                {


                                    //获取当前提现记录的信息
                                    $tixianInfo = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_shops_tixian')." WHERE uniacid = :uniacid and id = :id", array('uniacid' => $uniacid, 'id'=>$id));

                                    //获取openid
                                    $openID = pdo_fetchcolumn("SELECT openid FROM ".tablename("sudu8_page_shops_shop")." WHERE id = :id", array(':id'=>$id));
                                    // $openID = 'oYyHv0D57T_qDD2zPLhN7lRp7lEs';

                                    $url_m="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];
                                    $formId=$tixianInfo[0]['formID'];
                                   
                                    switch ($tixianInfo[0]['types']) {
                                        case '1':
                                            $ftype = '微信';
                                            break;
                                        case '2':
                                            $ftype = '支付宝';
                                            break;
                                        default:
                                            $ftype = '银行卡';
                                            break;
                                    }

                                    $tixianok = pdo_fetchcolumn("SELECT tixianok FROM ".tablename('sudu8_page_shops_set')." WHERE uniacid = :uniacid", array(":uniacid"=>$uniacid));

                                     

                                    $fmoney = $tixianInfo[0]['money'];

        
                                    $ftime=date('Y-m-d H:i:s',time());
                                

                                     $post_info = '{
                                              "touser": "'.$openID.'",  
                                              "template_id": "'.$tixianok.'",        
                                              "form_id": "'.$formId.'",  
                                              "page": "sudu8_page_plugin_shop/manage_shop_txjl/manage_shop_txjl" ,
                                              "access_token": "'.$url_m.'",      
                                              "data": {
                                                  "keyword1": {
                                                      "value": "'.$ftime.'", 
                                                      "color": "#173177"
                                                  }, 
                                                  "keyword2": {
                                                      "value": "'.$fmoney.'", 
                                                      "color": "#173177"
                                                  }, 
                                                  "keyword3": {
                                                      "value": "'.$ftype.'", 
                                                      "color": "#173177"
                                                  }                   
                                              },
                                              "emphasis_keyword": "" 
                                            }';
                                    $this->_requestPost($url_m,$post_info);
                                }
                    }
            }
            $data=array(
                'flag' => 1,
                'txtime' => time()
            );
            pdo_update("sudu8_page_shops_tixian",$data, array('uniacid'=>$uniacid, 'id'=>$id));
            message('打款成功!', $this->createWebUrl('withdraw', array('op'=>'display')), 'success');
        }

        include $this->template('withdraw');
    }


     public function _requestGetcurl($url){
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

 //不带报头的curl
    public function _requestPost($url, $data, $ssl=true) {
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





    public function doWebSet(){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','post','delete');
        $op = in_array($op, $ops) ? $op : 'display';

        if($op == 'display'){
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_shops_set')." WHERE uniacid = :uniacid", array(':uniacid'=>$uniacid));
            if(checksubmit('submit')){
                $tixiantype = implode(",",$_GPC['tixiantype']);
                $data = array(
                    'apply' => $_GPC['apply'],
                    'goods' => $_GPC['goods'],
                    'minimum' => $_GPC['minimum'],
                    'bg' => $_GPC['bg'],
                    'protocol' => $_GPC['protocol'],
                    'tjnum' => $_GPC['tjnum'],
                    'num' => $_GPC['num'],
                    'tixiantype' => $tixiantype,
                    'jiesuan' => $_GPC['jiesuan'],
                    'shenheok' => $_GPC['shenheok'],
                    'tixianok' => $_GPC['tixianok'],
                );

                if(!empty($item)){
                    pdo_update('sudu8_page_shops_set', $data, array('uniacid'=>$uniacid));
                }else{
                    $data['uniacid'] = $uniacid;
                    pdo_insert('sudu8_page_shops_set', $data);
                }
                message('设置修改成功!', $this->createWebUrl('set', array('op'=>'display')), 'success');
            }
        }
        include $this->template('set');
    }

    public function doWebGoodscate(){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display','post','delete','secondpost','secdisplay','secdelete','edit');
        $op = in_array($op, $ops) ? $op : 'display';
                //栏目列表
                if ($op == 'display'){
                    $_W['page']['title'] = '分类列表';
                    // var_dump($uniacid);
                    $list = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_goods_cate')." WHERE  cid = :cid and uniacid = :uniacid ORDER BY num DESC", array(':uniacid' => $uniacid,':cid' =>0));
                    // var_dump($list);die;
                }

                if ($op == 'secdisplay'){
                    $_W['page']['title'] = '分类列表';
                    $id = $_GPC['id'];
                    // var_dump($id);die;
                    $list1 = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_goods_cate')." WHERE cid = :cid and uniacid = :uniacid ORDER BY num DESC", array(':uniacid' => $uniacid,':cid' => $id));
                }
                //添加修改栏目
                if ($op == 'post'){
                    $id = intval($_GPC['id']);

                    $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_goods_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
                    if (checksubmit('submit')) {
                        if (empty($_GPC['name'])) {
                            message('请输入栏目标题！');
                        }
                        if(is_null($_GPC['flag'])){
                            $_GPC['flag'] = 1;
                        }
                        $data = array(
                            'uniacid' => $_W['uniacid'],
                            'num' => intval($_GPC['num']),
                            'flag' => $_GPC['flag'],
                            'name' => $_GPC['name'],
                        );
                        if (empty($item['id'])) {
                            pdo_insert('sudu8_page_goods_cate', $data);
                        } else {
                            pdo_update('sudu8_page_goods_cate', $data ,array('id' => $item['id']));
                        }
                        message('栏目添加/修改成功!', $this->createWebUrl('goodscate', array('op'=>'display')), 'success');
                    }
                }
                //添加二级分类
                if($op == 'secondpost'){
                    $id = intval($_GPC['id']);
                    // var_dump($id);
                    $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_goods_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
                    $item1 = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_goods_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $item['cid'] ,':uniacid' => $uniacid));
                    if (checksubmit('submit')) {
                        if (empty($_GPC['name1'])) {
                            message('请输入栏目标题！');
                        }
                        if(is_null($_GPC['flag1'])){
                            $_GPC['flag'] = 1;
                        }
                        $data = array(
                            'uniacid' => $_W['uniacid'],
                            'num' => intval($_GPC['num1']),
                            'flag' => $_GPC['flag1'],
                            'name' => $_GPC['name1'],
                            'cid' =>$_GPC['id'],
                        );
                        if (empty($item1['id'])) {
                            pdo_insert('sudu8_page_goods_cate', $data);
                        } else {
                            pdo_update('sudu8_page_goods_cate', $data ,array('id' => $item1['id']));
                        }
                        message('栏目添加/修改成功!', $this->createWebUrl('goodscate', array('op'=>'secdisplay','id'=>$id)), 'success');
                    }
                }
                if($op == 'edit'){
                    $id = intval($_GPC['id']);
                    $item1 = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_goods_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
                    if (checksubmit('submit')) {
                        if (empty($_GPC['name1'])) {
                            message('请输入栏目标题！');
                        }
                        if(is_null($_GPC['flag1'])){
                            $_GPC['flag'] = 1;
                        }
                        $data = array(
                            'uniacid' => $_W['uniacid'],
                            'num' => intval($_GPC['num1']),
                            'flag' => $_GPC['flag1'],
                            'name' => $_GPC['name1'],
                        );
                       
                        pdo_update('sudu8_page_goods_cate', $data ,array('id' => $item1['id']));

                        message('栏目添加/修改成功!', $this->createWebUrl('goodscate', array('op'=>'secdisplay','id'=>$item1['cid'])), 'success');
                    }
                }
                //删除栏目
                if ($op == 'delete') {
                    $id = intval($_GPC['id']);
                    $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_goods_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
                    if (empty($row)) {
                        message('栏目不存在或是已经被删除！');
                    }
                    pdo_delete('sudu8_page_goods_cate', array('id' => $id ,'uniacid' => $uniacid));
                    message('栏目删除成功!', $this->createWebUrl('goodscate', array('op'=>'display')), 'success');
                }

                if ($op == 'secdelete') {
                    $id = intval($_GPC['id']);
                    $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_goods_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
                    if (empty($row)) {
                        message('栏目不存在或是已经被删除！');
                    }
                    pdo_delete('sudu8_page_goods_cate', array('id' => $id ,'uniacid' => $uniacid));
                    message('栏目删除成功!', $this->createWebUrl('goodscate', array('op'=>'secdisplay','id'=>$row['cid'])), 'success');
                }       

        include $this->template('goodscate');
    }
    public function doWebshoppay(){
        load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $op = $_GPC['op'];
        $ops = array('display', 'excel');
        $op = in_array($op, $ops) ? $op : 'display';
        $search_keys = $_GPC['search_keys'];
        if(!empty($search_keys)){
            $where = " and b.name like '%".$search_keys."%'";
        }
        $total = pdo_fetchcolumn("SELECT count(a.id) FROM ".tablename('sudu8_page_money')." as a LEFT JOIN ".tablename('sudu8_page_shops_shop')." as b on a.sid = b.id LEFT JOIN ".tablename('sudu8_page_user')." as c on a.uid = c.id WHERE a.sid > 0 and a.uniacid = :uniacid {$where}",array(':uniacid' => $uniacid));


        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $start = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize);
        $list = pdo_fetchAll("SELECT a.*,b.name,c.nickname,c.avatar,c.realname,c.mobile FROM ".tablename('sudu8_page_money')." as a LEFT JOIN ".tablename('sudu8_page_shops_shop')." as b on a.sid = b.id LEFT JOIN ".tablename('sudu8_page_user')." as c on a.uid = c.id WHERE a.sid > 0 and a.uniacid = :uniacid {$where} ORDER BY creattime DESC LIMIT ".$start.",".$pagesize,array(':uniacid' => $uniacid));
        foreach ($list as $key => &$value) {
            $value['nickname'] = rawurldecode($value['nickname']);
        }
        if($op == 'display'){
            include $this->template('shoppay');
        }else if($op == 'excel'){
            $list = pdo_fetchAll("SELECT a.*,b.name,c.nickname,c.avatar,c.realname,c.mobile FROM ".tablename('sudu8_page_money')." as a LEFT JOIN ".tablename('sudu8_page_shops_shop')." as b on a.sid = b.id LEFT JOIN ".tablename('sudu8_page_user')." as c on a.uid = c.id WHERE a.sid > 0 and a.uniacid = :uniacid {$where} ORDER BY creattime DESC",array(':uniacid' => $uniacid));
            
            include IA_ROOT.'/addons/sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new \PHPExcel();

            /*以下是一些设置*/
            $objPHPExcel->getProperties()->setCreator("多商户店内支付记录")
                ->setLastModifiedBy("多商户店内支付记录")
                ->setTitle("多商户店内支付记录")
                ->setSubject("多商户店内支付记录")
                ->setDescription("多商户店内支付记录")
                ->setKeywords("多商户店内支付记录")
                ->setCategory("多商户店内支付记录");
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '店铺名称');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '金额(元)');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '用户微信信息');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '用户真实信息');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '支付描述');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '支付时间');
            foreach ($list as $key => &$res) {
                $num=$key+2;
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValueExplicit('A'.$num, $res['name'],'s')
                            ->setCellValueExplicit('B'.$num, $res['score'],'s')
                            ->setCellValueExplicit('C'.$num, $res['avatar'].' '.$res['nickname'],'s') 
                            ->setCellValueExplicit('D'.$num, $res['realname'].' '.$res['mobile'],'s')
                            ->setCellValueExplicit('E'.$num, $res['message'], 's')
                            ->setCellValueExplicit('F'.$num, $res['creattime'], 's');
                  
            }
            $objPHPExcel->getActiveSheet()->setTitle('多商户店内支付记录');
            $objPHPExcel->setActiveSheetIndex(0);
            $excelname="多商户店内支付记录";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }
}