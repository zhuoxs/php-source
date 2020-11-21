<?php

/**

 * 柚子会员卡小程序模块小程序接口定义

 *

 * @author 厦门梵挚慧

 * @url

 */

defined('IN_IA') or exit('Access Denied');
defined('TD_PATH') or define('TD_PATH',__DIR__);

require_once TD_PATH."/inc/func/func.php";

// 20180727
// 类自动加载
spl_autoload_register(function($name)
{
    $file = realpath(__DIR__).DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$name.'.model.php';
    if(file_exists($file)){
        require_once($file);
        if(class_exists($name,false)){
            return true;
        } 
        return false;
    }
    return false;
});

//处理 pdo 异常信息
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    $arr = explode('SQL Error: <br/>',$errstr,2);
    if (!isset($arr[1])){
        return false;
    }
    echo explode('<hr/>Traces:',$arr[1])[0];
    return true;
}
//set_error_handler("myErrorHandler");

class yzhyk_sunModuleWxapp extends WeModuleWxapp {
    public function __call($name, $arguments)
    {
        pdo_begin();
        try{
            ob_start();
            $wx = new wxapp();
            $wx->{$name}();
            pdo_commit();
        }catch (Exception $e){
            pdo_rollback();
            $error = ob_get_contents();
            ob_clean();
            $data = array(
                'code'=>$e->getCode(),
                'msg'=>$e->getMessage(),
                'sqlerror'=>$error,
            );
            if ($e->data){
                $data['data'] = $e->data;
            }
            echo json_encode($data);
        }
    }
}
class wxapp extends WeModuleWxapp {

    use order2,bill2,goods2,coupon2,membercard2,groupgoods2,cutgoods2,task2;

    /**********************  柚子会员卡   ******************************/
    //    获取图片根目录
    public function doPageGetImgRoot(){
        global $_GPC,$_W;
        echo $_W['attachurl'];
    }
    //判断是否有门店
    public function doPageGetAddress(){
        global $_W, $_GPC;
        $store=pdo_get('yzhyk_sun_store',array('uniacid'=>$_W['uniacid'],'isdel'=>0));
        if($store){
            echo 1;
        }else{
            echo 2;
        }
    }
    //    获取门店列表
    public function doPageGetStores(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $lat = $_GPC['latitude'];
        $lng = $_GPC['longitude'];
        $store = new store();
        $list = $store->get_list_app($lat, $lng)['data'];

        foreach ($list as &$item) {
            if($item['distance'] < 1000){
                $item['distance'] .= "m";
            }elseif($item['distance'] > 20000){
                $item['distance'] = floor($item['distance']/1000) . "km";
            }else{
                $item['distance'] = $item['distance']/1000 . "km";
            }
        }
        echo json_encode($list);
    }
    //    获取底部菜单列表
    public function doPageGetTabs(){
        $tab = new tab();
        $data = $tab->query();
        $list = $data['data'];

        echo json_encode($list);
    }
    //    获取首页菜单列表
    public function doPageGetAppMenus(){
        $appmenu = new appmenu();
        $data = $appmenu->query(array(),array('limit'=>4));
        $list = $data['data'];

        echo json_encode($list);
    }
    public function doPageCheckStock(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];
        $goodses = json_decode(htmlspecialchars_decode($_GPC['goodses']));
        $ret_goodses = [];
        foreach ($goodses as $goods) {
            $num = 999999999;
            if($goods->activity_id){
                $sql = "";
                $sql .= "select * from ".tablename('yzhyk_sun_storeactivitygoods')." t1 left join ".tablename('yzhyk_sun_storeactivity')." t2 on t2.id = t1.storeactivity_id where t2.store_id = $store_id and t1.goods_id = {$goods->id} and t2.activity_id = {$goods->activity_id} ";
                $storeactivitygoods = pdo_fetchall($sql);
                if($storeactivitygoods[0]['stock']< $goods->num){
                    $num = $storeactivitygoods[0]['stock'];
                }
            }
            $sql = "";
            $sql .= "select * from ".tablename('yzhyk_sun_storegoods')." where store_id = $store_id and goods_id = {$goods->id} ";
            $storegoods = pdo_fetchall($sql);
            if($storegoods[0]['stock']< $goods->num && $storegoods[0]['stock'] < $num){
                $num = $storegoods[0]['stock'];
            }
            if($num != 999999999){
                $ret_goodses[] = [
                    'id'=>$goods->id,
                    'limit'=>$num,
                ];
            }
        }
        echo json_encode([
            'code'=>count($ret_goodses),
            'goodses'=>$ret_goodses,
        ]);
    }
    //预约确认订单页面
    public function doPageCheckStock1(){
        global $_W,$_GPC;
        $store_id = $_GPC['store_id'];
        $id=$_GPC['id'];
        $goods=pdo_fetch("select * from ".tablename('yzhyk_sun_goods')."a left join ".tablename('yzhyk_sun_storegoods')."b on b.goods_id = a.id where a.id = $id and b.store_id = $store_id and a.uniacid=".$_W['uniacid']." and b.uniacid = ".$_W['uniacid']);
        // var_dump("select * from ".tablename('yzhyk_sun_goods')."a left join ".tablename('yzhyk_sun_storegoods')."b on b.goods_id = a.id where a.id = $id and b.store_id = $store_id and a.uniacid=".$_W['uniacid']." and b.uniacid = ".$_W['uniacid']);
        echo json_encode($goods);
    }
    //    获取有权限的门店列表
    public function doPageGetAdminStores(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $sql = "";
        $sql .= "select t2.* ";
        $sql .= "from ".tablename('yzhyk_sun_userrole')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
        $sql .= "inner join ".tablename('yzhyk_sun_user')." t3 on t3.admin_id = t1.user_id and t3.id = $user_id ";

        $list = pdo_fetchall($sql);
        echo json_encode($list);
    }
    //    获取后台统计数据
    public function doPageGetAdminReport(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];

        $sql="";
        $sql="select * from ".tablename('yzhyk_sun_storebill')." where store_id = ".$store_id." and uniacid = ".$_W['uniacid'];
        $storebill = pdo_fetchall($sql);
        $num='';
        foreach ($storebill as $key => $value) {

            if($value['type']!=6){
                $num += $value['balance'];
            }
            else{
                $num -= $value['balance'];
            }
        }


        $sql = "";
        $sql .= "select ifnull(sum(amount),0) ";
        $sql .= "from ".tablename('yzhyk_sun_order')." ";
        $sql .= "where to_days(from_unixtime(time)) = to_days(now()) and store_id = $store_id ";
        $today_amount = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select ifnull(sum(amount),0) ";
        $sql .= "from ".tablename('yzhyk_sun_order')." ";
        $sql .= "where to_days(from_unixtime(time)) = to_days(now()) +1 and store_id = $store_id ";
        $yesterday_amount = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select ifnull(sum(amount),0) ";
        $sql .= "from ".tablename('yzhyk_sun_order')." where store_id = $store_id ";
        $amount = pdo_fetchcolumn($sql);



        $sql = "";
        $sql .= "select count(*) ";
        $sql .= "from ".tablename('yzhyk_sun_order')." ";
        $sql .= "where to_days(from_unixtime(time)) = to_days(now()) and store_id = $store_id ";
        $today_count = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select count(*) ";
        $sql .= "from ".tablename('yzhyk_sun_order')." where store_id = $store_id ";
        $count = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select count(*) ";
        $sql .= "from ".tablename('yzhyk_sun_order')." where store_id = $store_id and state = 30";
        $send_count = pdo_fetchcolumn($sql);
        echo json_encode([
            'today_amount'=>$today_amount,
            'yesterday_amount'=>$yesterday_amount,
            'amount'=>$amount,
            'today_count'=>$today_count,
            'count'=>$count,
            'send_count'=>$send_count,
            'num'=>$num,
        ]);
    }
    public function doPageUpdateStoreLocation(){
        global $_W, $_GPC;
        $data['latitude'] = $_GPC['latitude'];
        $data['longitude'] = $_GPC['longitude'];
        $store_id = $_GPC['store_id'];

        $store = new store();
        $store->update_by_id($data,$store_id);
        // $res = pdo_update('yzhyk_sun_store', $data, array('id' =>$store_id));
    }
    //    获取充值列表
    public function doPageGetRecharges(){
        $recharge = new recharge();
        $data = $recharge->query(array('used = 1'));
        $list = $data['data'];
        echo json_encode($list);
    }
    //    新增充值记录
    public function doPageRecharge(){
        global $_W, $_GPC;

        $user_id=$_GPC['user_id'];
        $user =pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        $data2['balance']=($user['balance']?:0) + $_GPC['money']+$_GPC['give_money'];
        $res = pdo_update('yzhyk_sun_user', $data2, array('id' =>$user_id));

        $data['user_id'] = $_GPC['user_id'];
        $data['content'] = "充值{$_GPC['money']}送{$_GPC['give_money']}";
        $data['balance'] = $_GPC['money'] + $_GPC['give_money'];
        $data['time'] = time();
        $data['type'] = 5;
        $res=pdo_insert('yzhyk_sun_bill',$data);
    }
    //    获取会员卡信息：当前会员等级/下一级
    public function doPageGetCardLevel(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $level_id = $_GPC['level_id'];

        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_cardlevel')." where id = $level_id and uniacid = $uniacid ";
        $list = pdo_fetchall($sql);

        if(count($list)){
            $curr_level = $list[0];
        }else{
            $curr_level = [
                'id'=>0,
                'name'=>'0',
                'discount'=>'10',
                'amount'=>0,
            ];
        }
        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_cardlevel')." where amount > {$curr_level['amount']} and uniacid = $uniacid order by amount limit 1 ";
        // var_dump($sql);
        $list = pdo_fetchall($sql);
        if(count($list)){
            $curr_level['next_name'] = $list[0]['name'];
            $curr_level['next_amount'] = $list[0]['amount'];
            $curr_level['next_discount'] = $list[0]['discount'];
        }

        echo json_encode($curr_level);
    }
    //获取会员卡信息，下一级会员卡价格
    public function doPageGetCardPrice(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $level_id = $_GPC['level_id'];

        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_cardlevel')." where id = $level_id and uniacid = $uniacid ";
        $list = pdo_fetchall($sql);

        if(count($list)){
            $curr_level = $list[0];
        }else{
            $curr_level = [
                'id'=>0,
                'name'=>'0',
                'discount'=>'10',
                'amount'=>0,
                'price'=>0,
            ];
        }
        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_cardlevel')." where amount > {$curr_level['amount']} and uniacid = $uniacid order by amount ";
        $list = pdo_fetchall($sql);
        if(count($list)){
            $curr_level['leave']=$list;
            // $curr_level['next_name'] = $list[0]['name'];
            // $curr_level['next_amount'] = $list[0]['amount'];
            // $curr_level['next_discount'] = $list[0]['discount'];
        }

        echo json_encode($curr_level);
    }
    //购买会员卡等级
    public function doPagebuyleave(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $user_id=$_GPC['user_id'];
        $level_id=$_GPC['level_id'];
        $amount=$_GPC['amount'];
        $res=pdo_update('yzhyk_sun_user',array('amount'=>$amount,'level_id'=>$level_id,'isbuy'=>1),array('uniacid'=>$uniacid,'id'=>$user_id));
        if($res){
            echo 1;
        }else{
            echo 0;
        }

    }
    //    获取最近门店列表
    public function doPageGetNearestStore(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $data['latitude']=$_GPC['latitude'];
        $data['longitude']=$_GPC['longitude'];
        $lat = $data['latitude'];
        $lng = $data['longitude'];
    //        $info = pdo_get('yzhyk_sun_store',array('id' =>9));
        $sql = "";
        $sql .= "select *,convert(acos(cos($lat*pi()/180 )*cos(latitude*pi()/180)*cos($lng*pi()/180 -longitude*pi()/180)+sin($lat*pi()/180 )*sin(latitude*pi()/180))*6370996.81,decimal)  as distance from ".tablename('yzhyk_sun_store')." where uniacid = $uniacid order by distance ";

    //        $stores = pdo_fetchall("select * from ".tablename('yzhyk_sun_store')." where uniacid = $uniacid");
        $stores = pdo_fetchall("$sql");

        //todo 选择最近的门店

        echo json_encode($stores[0]);
    }
    //    修改用户信息
    public function doPageUpdateUser(){
        global $_W, $_GPC;
        $user_id = $_GPC['id'];
        if(isset($_GPC['gender'])){
            $data['gender']=$_GPC['gender'];
        }
        if(isset($_GPC['name'])){
            $data['name']=$_GPC['name'];
        }
        if(isset($_GPC['date'])){
            $data['birthday']=$_GPC['date'];
        }
        if(isset($_GPC['email'])){
            $data['email']=$_GPC['email'];
        }
        if(isset($_GPC['tel'])){
            $data['tel']=$_GPC['tel'];
        }
        if(isset($_GPC['img'])){
            $data['img']=$_GPC['img'];
        }
        $res = pdo_update('yzhyk_sun_user', $data, array('id' =>$user_id));
        $user=pdo_get('yzhyk_sun_user',array('id' =>$user_id));
        $user['store_id'] = 9;//todo 选择最近的门店
        echo json_encode($user);
    }
    //    获取解密数据
    public function doPageDecrypt(){
        include_once "wxBizDataCrypt.php";
        global $_W, $_GPC;
        $res=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $appid=$res['appid'];
        $secret=$res['appsecret'];
        $wx = new WXBizDataCrypt($appid,$_GPC['key']);
        $data = "";
        $wx->decryptData($_GPC['data'],$_GPC['iv'],$data);
        echo json_encode(json_decode($data));
    }
    //    获取openid
    public function doPageOpenid(){

        global $_W, $_GPC;
        $res=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $code=$_GPC['code'];
        $appid=$res['appid'];
        $secret=$res['appsecret'];
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
        function httpRequest($url,$data = null){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            if (!empty($data)){
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;
        }
        $re=httpRequest($url);
        print_r($re);
    }
    //    登录并返回用户信息
    public function doPageLogin(){
        global $_GPC, $_W;
        $openid=$_GPC['openid'];
        $res=pdo_get('yzhyk_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
        if($openid and $openid!='undefined'){
            if(!$res){
                $data['openid']=$_GPC['openid'];
                $data['uniacid']=$_W['uniacid'];
                $data['time']=time();
                $res2=pdo_insert('yzhyk_sun_user',$data);
                $res=pdo_get('yzhyk_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
                $this->updateUserAmountLevel($res['id']);
            }
        }
        $res['is_member'] = $res['end_time']&&$res['end_time']>time()?1:null;
        $res['end_time'] = $res['end_time']?date('Y-m-d',$res['end_time']):null;
        echo json_encode($res);
    }
    //    获取用户信息
    public function doPageGetUser(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid=$_GPC['openid'];
        $user=pdo_get('yzhyk_sun_user',array('openid'=>$openid,'uniacid'=>$uniacid));
        $user['is_member'] = $user['end_time']&&$user['end_time']>time()?1:null;
        $user['end_time'] = $user['end_time']?date('Y-m-d',$user['end_time']):null;
        echo json_encode($user);
    }
    //    获取平台信息
    public function doPageGetPlatformInfo(){
        global $_GPC, $_W;
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));

        unset($info['appid']);
        unset($info['appsecret']);
        unset($info['wxkey']);
        unset($info['mchid']);
        echo json_encode($info);
    }
    //    更新用户消费与等级
    public function updateUserAmountLevel($user_id){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];

        $user = pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        $sql = "select sum(amount)as amount from ".tablename('yzhyk_sun_orderscan')." where user_id = $user_id";
        $list = pdo_fetchall($sql);
        $amount1 = $list[0]['amount']?:0;
        $sql = "select sum(amount)as amount from ".tablename('yzhyk_sun_orderonline')." where user_id = $user_id";
        $list = pdo_fetchall($sql);
        $amount2 = $list[0]['amount']?:0;
        $sql = "select sum(amount)as amount from ".tablename('yzhyk_sun_order')." where user_id = $user_id";
        $list = pdo_fetchall($sql);
        $amount3 = $list[0]['amount']?:0;
        $amount = $amount1 + $amount2 + $amount3;
        $res = pdo_update('yzhyk_sun_user', ['amount'=>$amount], array('id' =>$user_id));

        $sql = "";
        $sql .= "select t1.*,t3.id as next_level_id from ".tablename('yzhyk_sun_user')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_cardlevel')." t2 on t2.id = t1.level_id ";
        $sql .= "left join ".tablename('yzhyk_sun_cardlevel')." t3 on (t3.amount > t2.amount or t1.level_id is null) and t3.amount <= t1.amount and t3.uniacid = $uniacid ";
        $sql .= "where t1.id = $user_id ";
        $sql .= "order by t3.amount DESC ";
        $sql .= "limit 1 ";
        $list = pdo_fetchall($sql);
        $next = $list[0]['next_level_id'];
        if($next){
            $res = pdo_update('yzhyk_sun_user', ['level_id'=>$next], array('id' =>$user_id));
        }
    }
    //    收集formid
    public function doPageAddFormID(){
        global $_GPC,$_W;

        $data['user_id'] = $_GPC['user_id'];
        $data['form_id'] = $_GPC['form_id'];
        $formid = new formid();
        $res = $formid->insert($data);
        return json_encode($res);
    }
    //    发送模板消息-购买
    public function sendTemplateMsg($opt){
        function getaccess_token($_W)
        {
            $res = pdo_get('yzhyk_sun_system', array('uniacid' => $_W['uniacid']));
            $appid = $res['appid'];
            $secret = $res['appsecret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data, true);
            return $data['access_token'];
        }

        global $_W, $_GPC;
        $access_token = getaccess_token($_W);


        $user_id = $opt['user_id'];
        $user = pdo_get('yzhyk_sun_user',['id'=>$user_id]);
        $openid = $user['openid'];

        $t = time();
        $res = pdo_delete('yzhyk_sun_formid',['user_id'=>$user_id,'time<='=>$t]);
        $forms = pdo_fetchall("select * from ".tablename('yzhyk_sun_formid')." where user_id = $user_id and time > $t");
        $form_id = $forms[0]['form_id'];
        $res = pdo_delete('yzhyk_sun_formid',['id'=>$forms[0]['id']]);

        $goods_name = $opt['goods_name'];
        $amount = $opt['amount'];
        $num = $opt['num'];
        $time = $opt['time'];
        $address = $opt['address'];
        $page = $opt['page'];

        $res2 = pdo_get('yzhyk_sun_system', array('uniacid' => $_W['uniacid']));
        $template_id = $res2['template_id_buy'];

        $formwork = [
            'touser'=>$openid,
            'template_id'=>$template_id,
            'page'=>$page,
            'form_id'=>$form_id,
            'data'=>[
                'keyword1'=>[
                    'value'=>$goods_name,
                    'color'=>'#173177',
                ],
                'keyword2'=>[
                    'value'=>$amount,
                    'color'=>'#173177',
                ],
                'keyword3'=>[
                    'value'=>$num,
                    'color'=>'#173177',
                ],
                'keyword4'=>[
                    'value'=>$time,
                    'color'=>'#173177',
                ],
                'keyword5'=>[
                    'value'=>$address,
                    'color'=>'#173177',
                ],
                'keyword6'=>[
                    'value'=>$time,
                    'color'=>'#173177',
                ],
            ]
        ];

        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token . "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formwork));
        $data = curl_exec($ch);
        curl_close($ch);
        // echo $data;
    }
    //todo    家政项目拿过来用，需要整理
    //    获取微信支付的数据
//    public function doPageOrderarr() {
//        global $_GPC,$_W;
//        $openid = $_GPC['openid'];
//        $appData = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
//        $appid = $appData['appid'];
//        $mch_id = $appData['mchid'];
//        $keys = $appData['wxkey'];
//        $price = $_GPC['price'];
//        $order_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
//        $data = array(
//            'appid' => $appid,
//            'mch_id' => $mch_id,
//            'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',//
//            //'sign' => '',
//            'body' => time(),
//            'out_trade_no' => date('Ymd') . substr('' . time(), -4, 4),
//            'total_fee' => $price*100,
//        //            'total_fee' => 1,
//            'spbill_create_ip' => '120.79.152.105',
//            'notify_url' => '120.79.152.105',
//            'trade_type' => 'JSAPI',
//            'openid' => $openid
//        );
//        ksort($data, SORT_ASC);
//        $stringA = http_build_query($data);
//        $signTempStr = $stringA . '&key='.$keys;
//        $signValue = strtoupper(md5($signTempStr));
//        $data['sign'] = $signValue;
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $order_url);//如果不传这样进行设置
//        curl_setopt($ch, CURLOPT_HEADER, 0);//header就是返回header头相关信息
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置数据是直接输出还是返回
//        curl_setopt($ch, CURLOPT_POST, 1);//设置为post模式提交 跟 form表单的提交是一样
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->arrayToXml($data));//设置提交数据
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//设置ssl不验证
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//设置ssl不验证
//        $result = curl_exec($ch);//执行请求 就等于html表单的 input:submit 如果没有设置 returntransfer 那么 是不会有返回值的 会直接输出
//        curl_close($ch);//关闭
//        $result = xml2array($result);
//        //        return $this->result(0,'',$result);
//        echo json_encode($this->createPaySign($result));
//
//    }
//    function createPaySign($result)
//    {
//        global $_W;
//        $appData = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
//        $keys = $appData['wxkey'];
//        $data = array(
//            'appId' => $result['appid'],
//            'timeStamp' => (string)time(),
//            'nonceStr' => $result['nonce_str'],
//            'package' => 'prepay_id=' . $result['prepay_id'],
//            'signType' => 'MD5'
//        );
//        ksort($data, SORT_ASC);
//        $stringA = '';
//        foreach ($data as $key => $val) {
//            $stringA .= "{$key}={$val}&";
//        }
//        $signTempStr = $stringA . 'key='.$keys;
//        $signValue = strtoupper(md5($signTempStr));
//        $data['paySign'] = $signValue;
//        return $data;
//    }
//    function arrayToXml($arr)
//    {
//        $xml = "<xml>";
//        foreach ($arr as $key=>$val)
//        {
//            if (is_numeric($val)){
//                $xml.="<".$key.">".$val."</".$key.">";
//            }else{
//                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
//            }
//        }
//        $xml.="</xml>";
//        return $xml;
//    }
    public function doPageOrderarr() {
        include_once 'wxpay.php';
        global $_GPC,$_W;

        $openid = $_GPC['openid'];
        $appData = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $appid = $appData['appid'];
        $mch_id = $appData['mchid'];
        $key = $appData['wxkey'];
        $out_trade_no = date('YmdHis') . substr('' . time(), -4, 4);//订单号
        $total_fee = $_GPC['price']*100;
        $body = '支付';
        $attach = json_encode([//回调参数
            'type'=>$_GPC['type']?:'pay',
//            todo 订单号，id
        ]);
        $notify_url = '120.79.152.105';//回调地址

        $wxpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);
        $ret = $wxpay->pay();
        echo json_encode($ret);
    }

    public function doPageAddWithdraw(){
        global $_GPC,$_W;

        $data['user_id'] = $_GPC['user_id'];
        $data['store_id'] = $_GPC['store_id'];
        $data['balance'] = $_GPC['balance'];
        $data['paycommission'] = $_GPC['paycommission'];
        $data['ratesmoney'] = $_GPC['ratesmoney'];
        $data['time'] = time();

        $takerecord = new storetakerecord();
        $res = $takerecord->insert($data);

        return json_encode($res);
    }
}

//积分/账单
trait bill2{
    //    获取积分明细
    public function doPageGetIntegrals(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $where_sql = " where user_id = $user_id";

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "select content,integral,from_unixtime(time,'%Y-%m-%d %H:%i') as time,type from ".tablename('yzhyk_sun_integral')." ";
        $order_sql = " order by time desc ";
        $list = pdo_fetchall($sql.$where_sql.$order_sql.$limt_sql);

        echo json_encode($list);
    }
    //获取积分设置
    public function doPageGetIntegralsSetting(){
        global $_W, $_GPC;

        $res=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        echo json_encode($res);
    }
    //    获取积分兑换明细
    public function doPageGetIntegralsExchange(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $where_sql = " where user_id = $user_id and type = 4";

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "select content,integral,from_unixtime(time,'%Y-%m-%d %H:%i') as time,type from ".tablename('yzhyk_sun_integral')." ";
        $order_sql = " order by time desc ";
        $list = pdo_fetchall($sql.$where_sql.$order_sql.$limt_sql);

        echo json_encode($list);
    }
    //    获取账单明细
    public function doPageGetBills(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];
        $year = $_GPC['year'];
        $month = $_GPC['month'];

        $where_sql = " where user_id = $user_id and month(FROM_UNIXTIME(time)) = $month and year(FROM_UNIXTIME(time)) = $year ";

        $sql = "";
        $sql .= "select type,sum(balance) as amount ";
        $sql .= "from ".tablename('yzhyk_sun_bill')." ";
        $sql .= $where_sql;
        $sql .= "group by type ";

        $list = pdo_fetchall($sql);

        $amount1 = 0;
        $amount2 = 0;
        foreach ($list as $item) {
            if($item['type'] == 4 || $item['type'] == 5){
                $amount2 += $item['amount'];
            }else{
                $amount1 += $item['amount'];
            }
        }
        $info = ['amount1'=>$amount1,'amount2'=>$amount2];

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "select content,balance,from_unixtime(time,'%Y-%m-%d %H:%i') as time,type from ".tablename('yzhyk_sun_bill')." ";
        $order_sql = " order by time desc ";
        $list = pdo_fetchall($sql.$where_sql.$order_sql.$limt_sql);

        echo json_encode(['info'=>$info,'list'=>$list]);
    }
    //    积分兑换成余额
    public function doPageIntegral2Balance(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $user_id = $_GPC['user_id'];
        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_system')." where uniacid = $uniacid";
        $systeminfo = pdo_fetchall($sql)[0];
        $rate = $systeminfo['integral2'];

        $user = pdo_get('yzhyk_sun_user',array('id' =>$user_id));
        $balance = floor($user['integral']/$rate);
        if($balance > 0){
            $res = pdo_update('yzhyk_sun_user', ['balance'=>$user['balance']+$balance,'integral'=>$user['integral']%$rate], array('id' =>$user_id));

            $data3['user_id'] = $user_id;
            $data3['content'] = ($balance*$rate)." 积分兑换 $balance 余额";
            $data3['integral'] = ($balance*$rate);
            $data3['time'] = time();
            $data3['type'] = 4;
            $data3['uniacid'] = $uniacid;
            $res=pdo_insert('yzhyk_sun_integral',$data3);

            //余额账单
            $data4['user_id'] = $user_id;
            $data4['content'] = ($balance*$rate)." 积分兑换 $balance 余额";
            $data4['balance'] = $balance;
            $data4['time'] = $data3['time'];
            $data4['type'] = 4;
            $data4['uniacid'] = $uniacid;
            $res=pdo_insert('yzhyk_sun_bill',$data4);
        }
    }
    //    积分兑换点劵
    public function doPageIntegral3Balance(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $user_id = $_GPC['user_id'];
        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_system')." where uniacid = $uniacid";
        $systeminfo = pdo_fetch($sql);
        $rate = $systeminfo['integral3'];

        $user = pdo_get('yzhyk_sun_user',array('id' =>$user_id));
        $balance = floor($user['integral']/$rate);
        // var_dump($rate);
        // var_dump($user['integral']);
        // var_dump($balance);
        if($balance > 0){
            $res = pdo_update('yzhyk_sun_user', ['integral1'=>$user['integral1']+$balance,'integral'=>$user['integral']%$rate], array('id' =>$user_id));

            $data3['user_id'] = $user_id;
            $data3['content'] = ($balance*$rate)." 积分兑换 $balance 点劵";
            $data3['integral'] = ($balance*$rate);
            $data3['time'] = time();
            $data3['type'] = 4;
            $data3['uniacid'] = $uniacid;
            $res=pdo_insert('yzhyk_sun_integral',$data3);

            $data=array(
                'uniacid'=>$_W['uniacid'],
                'openid'=>$user['openid'],
                'type'=>13,
                'task_id'=>0,
                'sign'=>1,
                'score'=>$balance,
                'date'=>date('Y-m-d'),
                'add_time'=>time()
            );
            pdo_insert('yzhyk_sun_plugin_scoretask_taskrecord',$data);

            //余额账单
            // $data4['user_id'] = $user_id;
            // $data4['content'] = ($balance*$rate)." 积分兑换 $balance 余额";
            // $data4['balance'] = $balance;
            // $data4['time'] = $data3['time'];
            // $data4['type'] = 4;
            // $data4['uniacid'] = $uniacid;
            // $res=pdo_insert('yzhyk_sun_bill',$data4);
        }
    }
}
//订单
trait order2 {
    /************************
     * 线上支付订单
     * */
        //    增加线上支付订单
    public function doPageAddOrderOnline(){
        global $_W, $_GPC;
        $data['user_id']=$_GPC['user_id'];
        $data['store_id']=$_GPC['store_id'];
        $data['amount']=$_GPC['amount'];
        $data['pay_amount']=$_GPC['pay_amount'];
        $data['pay_type']=$_GPC['pay_type'];
        $data['coupon_id']=$_GPC['coupon_id'];
        $orderonline = new orderonline();
        echo json_encode($orderonline->insert($data));
    }
    public function doPageGetOutOrder(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];
        $store_id = $_GPC['store_id'];
        $uniacid = $_W['uniacid'];

        $sql = "";
        $sql .= "select t2.* ";
        $sql .= "from ".tablename('yzhyk_sun_orderscan')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_orderscangoods')." t2 on t2.orderscan_id = t1.id and t1.user_id = $user_id and t1.store_id = $store_id and t1.uniacid = $uniacid ";
        $sql .= "where t1.is_out = 0 ";
        $sql .= "order by t2.goods_id ";

        $list = pdo_fetchall($sql);
        $ids = array();
        foreach ($list as $item) {
            $ids[] = $item['orderscan_id'];
        }
        echo json_encode(array('code'=>0,'list'=>$list,'ids'=>implode(',',$ids)));
    }
    public function doPageSetOutOrder(){
        global $_W, $_GPC;
        $order_ids = $_GPC['ids'];
        $ids = explode(',',$order_ids);
        $res = pdo_update('yzhyk_sun_orderscan',array('is_out'=>1),array('id'=>$ids));
        if ($res){
            echo json_encode(array(
                'code'=>0
            ));
        }else{
            throw new ZhyException('更新失败');
        }
    }
    /************************
     * 扫码购订单
     * */
    //    增加扫码购订单
    public function doPageAddOrderScan(){
        global $_W, $_GPC;
        $data['user_id']=$_GPC['user_id'];
        $data['store_id']=$_GPC['store_id'];
        $data['amount']=$_GPC['amount'];
        $data['pay_amount']=$_GPC['pay_amount'];
        $data['pay_type']=$_GPC['pay_type'];
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['goodses'] = json_decode(htmlspecialchars_decode($_GPC['goodses']));
        $orderscan = new orderscan();
        $res = $orderscan->insert($data);
        $res['id'] = $res['data'];
        echo json_encode($res);
    }
    //    获取扫码购订单
    public function doPageGetOrderScan(){
        global $_W, $_GPC;
        $state = $_GPC['state']?:0;

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t1.is_out,t2.name as store_name,t1.pay_amount,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time,t1.id ";
        $sql .= ",(select SUM(ti.num) from ".tablename('yzhyk_sun_orderscangoods')." ti where ti.orderscan_id = t1.id) as nums ";
        $sql .= ",t3.goods_id,t3.goods_img,t3.goods_name,t3.goods_price,t3.num ";
        $sql .= "from ".tablename('yzhyk_sun_orderscan')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
        $sql .= "left join ".tablename('yzhyk_sun_orderscangoods')." t3 on t3.orderscan_id = t1.id and t3.id = (select id from ".tablename('yzhyk_sun_orderscangoods')." tii where tii.orderscan_id = t1.id order by num desc limit 1) ";
        $sql .= "where t1.user_id = {$_GPC['user_id']} and (t1.isdel = 0 or t1.isdel is null) and t1.is_out = $state ";
        $sql .= "order by t1.time desc ";
        //echo $sql.$limt_sql ;exit();
        $list = pdo_fetchall($sql.$limt_sql);

        echo json_encode($list);

    }
    //    删除扫码购订单
    public function doPageDeleteOrderScan(){
        global $_W, $_GPC;
        $orderscan = new orderscan();
        echo json_encode($orderscan->delete_app($_GPC['id']));
    }
    //    获取扫码购订单详情
    public function doPageGetOrderScanInfo(){
        global $_W, $_GPC;
        $orderscan = new orderscan();
        $info = $orderscan->get_data_by_id($_GPC['id']);
        echo json_encode($info);
    }
    /************************
     * 预约订单
     * */
    // 增加预约订单
    public function doPageAddOrderapp(){
        global $_W, $_GPC;

        $data['user_id']=$_GPC['user_id'];
        $data['store_id']=$_GPC['store_id'];
        $data['amount']=$_GPC['amount'];
        $data['pay_amount']=$_GPC['pay_amount'];
        $data['pay_type']=$_GPC['pay_type'];
        $data['distribution_fee'] = $_GPC['distribution_fee'];
        $data['take_time'] = $_GPC['take_time'];
        $data['take_tel'] = $_GPC['take_tel'];
        $data['memo'] = $_GPC['memo'];
        $data['take_address'] = $_GPC['take_address'];
        $data['state'] = 10;
        $data['coupon_id']=$_GPC['coupon_id'];

        $data['goods_id']=$_GPC['goods_id'];
        $data['goods_price']=$_GPC['goods_price'];
        $data['num']=$_GPC['num'];
        $data['goods_name']=$_GPC['goods_name'];
        $data['goods_img']=$_GPC['goods_img'];
        // var_dump($data);die;
        $order = new orderapp();
        $res = $order->insert($data);
        $res['id'] = $res['data'];


        echo json_encode($res);
    }
    //获取预约订单
    public function doPageGetOrderapp(){
        global $_W, $_GPC;
        // $state = $_GPC['state']==0?10:$_GPC['state']==1?20:30;
        if($_GPC['state']==0){
            $state=10;
        }else if($_GPC['state']==1){
            $state=20;
        }else{
            $state=30;
        }
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t1.state,t2.name as store_name,t1.pay_amount,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time,t1.id ";
        $sql .= ",t3.goods_id,t3.goods_img,t3.goods_name,t3.goods_price,t3.num ";
        $sql .= "from ".tablename('yzhyk_sun_orderapp')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
        $sql .= "left join ".tablename('yzhyk_sun_orderappgoods')." t3 on t3.order_id = t1.id ";
        $sql .= "where t1.user_id = {$_GPC['user_id']} and (t1.isdel = 0 or t1.isdel is null) and t1.state= $state ";
        $sql .= "order by t1.time desc ";
        // echo $sql.$limt_sql ;exit();
        $list = pdo_fetchall($sql.$limt_sql);

        echo json_encode($list);
    }
    //获取预约订单详情
    public function doPageGetOrderappinfo(){
        global $_W, $_GPC;
        $orderapp = new orderapp();
        $info = $orderapp->get_data_by_id($_GPC['id']);
        echo json_encode($info);
    }
    //    删除预约订单
    public function doPageDeleteOrderapp(){
        global $_W, $_GPC;
        $orderapp = new orderapp();
        echo json_encode($orderapp->delete($_GPC['id']));
    }
    //    取消预约订单
    public function doPagecancelOrderapp(){
        global $_W, $_GPC;
        $orderapp = new orderapp();
        echo json_encode($orderapp->cancel($_GPC['id']));
    }
    //    预约订单-支付
    public function doPagePayOrderapp(){
        global $_W, $_GPC;

        $data['pay_type'] = $_GPC['pay_type'];
        $data['pay_amount'] = $_GPC['pay_amount'];

        $order = new orderapp();
        $res = $order->pay($data,$_GPC['id']);
        echo json_encode($res);
    }
    //判断预约门店是否符合
    public function doPageisStoreapp(){
        global $_W, $_GPC;
        $storeid = $_GPC['storeid'];
        $id = $_GPC['id'];
        $res=pdo_get('yzhyk_sun_orderapp',array('uniacid'=>$_W['uniacid'],'order_number'=>$id,'store_id'=>$storeid));
        if($res){
            echo 1;
        }else{
            echo 2;
        }

    }
    //预约订单核销页面
    public function doPageGetAppOrder(){
        global $_W, $_GPC;
        $order_number = $_GPC['appid'];
        $store_id = $_GPC['store_id'];
        $uniacid = $_W['uniacid'];

        $sql = "";
        $sql .= "select t1.state,t2.* ";
        $sql .= "from ".tablename('yzhyk_sun_orderapp')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_orderappgoods')." t2 on t2.order_id = t1.id and t1.order_number = $order_number and t1.store_id = $store_id and t1.uniacid = $uniacid ";

        $list = pdo_fetch($sql);

        echo json_encode($list);
    }
    //预约核销
    public function doPageSetAppOrder(){
        global $_W, $_GPC;
        $order_number = $_GPC['order_number'];
        $is_offline=0;
        $res=pdo_update("yzhyk_sun_orderapp",['state'=>'30'],array('order_number'=>$order_number));
        if($res){
            $order = pdo_get('yzhyk_sun_orderapp',array('uniacid'=>$_W['uniacid'],'state'=>30,'order_number'=>$order_number));
            if($order['pay_type']=='余额'){
                $distributionset = pdo_get('yzhyk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array("is_offline"));
                if($distributionset['is_offline']==1){
                    $is_offline=1;
                }
            }else{
                $is_offline=1;
            }
            if($is_offline==1){

                //========计算分销佣金 S===========
                include_once IA_ROOT . '/addons/yzhyk_sun/inc/func/distribution.php';
                $distribution = new Distribution();
                $distribution->order_id = $order['id'];
                // $distribution->money = $order['pay_amount'];
                // $distribution->userid = pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$order['user_id']))['openid'];
                $distribution->ordertype = 4;
                // $distribution->computecommission();
                //========计算分销佣金 E===========
                //直接结算
                $distribution->settlecommission();
            }
            echo 1;
        }else{
            echo 2;
        }
    }
    /*****************
     * 商城订单
     * */
    //    增加商城订单
    public function doPageAddOrder(){
        global $_W, $_GPC;

        $data['user_id']=$_GPC['user_id'];
        $data['store_id']=$_GPC['store_id'];
        $data['amount']=$_GPC['amount'];
        $data['pay_amount']=$_GPC['pay_amount'];
        $data['pay_type']=$_GPC['pay_type'];
        $data['distribution_type'] = $_GPC['distribution_type'];
        $data['province'] = $_GPC['province'];
        $data['city'] = $_GPC['city'];
        $data['county'] = $_GPC['county'];
        $data['address'] = $_GPC['address'];
        $data['distribution_fee'] = $_GPC['distribution_fee'];
        $data['take_time'] = $_GPC['take_time'];
        $data['take_tel'] = $_GPC['take_tel'];
        $data['memo'] = $_GPC['memo'];
        $data['take_address'] = $_GPC['take_address'];
        

        $data['state'] = 10;
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['goodses'] = json_decode(htmlspecialchars_decode($_GPC['goodses']));
        // var_dump($data);
        $order = new order();
        $res = $order->insert($data);

        
        $res['id'] = $res['data'];
        echo json_encode($res);
    }
    // 微信支付增加积分
    public function doPageaddint(){
        global $_W, $_GPC;
        $iid=$_GPC['iid'];
        $payrecord = new payrecord();
        $res=$payrecord->finish($iid);
        echo json_encode($res);


    }
    //    获取商城订单
    public function doPageGetOrders(){
        global $_W, $_GPC;

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .="select t2.name as store_name,t2.tel as store_tel,t1.pay_amount,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time,t1.id,t1.state,t1.distribution_type,t1.pay_type,t1.istui ";
        $sql .=",(select SUM(ti.num) from ".tablename('yzhyk_sun_ordergoods')." ti where ti.order_id = t1.id) as nums ";
        $sql .=",t3.goods_id,t3.goods_img,t3.goods_name,t3.goods_price,t3.num ";
        $sql .="from ".tablename('yzhyk_sun_order')." t1 ";
        $sql .="left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
        $sql .="left join ".tablename('yzhyk_sun_ordergoods')." t3 on t3.order_id = t1.id and t3.id = (select id from ".tablename('yzhyk_sun_ordergoods')." tii where tii.order_id = t1.id order by num desc limit 1) ";
        $sql .="where t1.user_id = {$_GPC['user_id']} and t1.state <> -10 and ({$_GPC['state']} = 0 or t1.state = {$_GPC['state']}) ";
        $sql .= "order by t1.time desc ";

        $list = pdo_fetchall($sql.$limt_sql);

        echo json_encode($list);

    }
    //查询配置
    public  function doPageSystem(){
        global $_W, $_GPC;
        $data = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $data["tab_navdata"] = unserialize($data["tab_navdata"]);
        $data["attachurl"] = $_W['attachurl'];
        echo json_encode($data);
    }
    //判断是否开启相关插件
    public function doPagePlugin(){
        global $_W, $_GPC;
        $type = intval($_GPC["type"]);
        $uniacid = $_W["uniacid"];
        //1为积分任务宝
        //2为大转盘
        if($type==1){
            //判断积分任务宝是否存在
            if(pdo_tableexists("yzhyk_sun_plugin_scoretask_system")){
                $set = pdo_get('yzhyk_sun_plugin_scoretask_system',array('uniacid'=>$uniacid));
                if($set){
                    if($set["is_show"]>0){
                        echo json_encode($set["is_show"]);
                        exit;
                    }
                }
            }
        }elseif($type==2){
            //判断大转盘设置表是否存在
            if(pdo_tableexists("yzhyk_sun_eatvisit_set")){
                $set = pdo_get('yzhyk_sun_eatvisit_set',array('uniacid'=>$uniacid));
                if($set){
                    if($set["isopen"]==1){
                        $set["url"] = $_W['attachurl'];
                        echo json_encode($set);
                        exit;
                    }
                }
            }
        }
        else if($type==3){
            //判断分销表是否存在
            if(pdo_tableexists("yzhyk_sun_distribution_set")){
                $system=pdo_get('yzhyk_sun_distribution_set',array('uniacid'=>$_W['uniacid']));
                if($system['status']>0){
                    echo json_encode($system);
                    exit;
                }
            }
        }
        echo 2;
        exit;
    }
    //获取积分任务
    // public function doPagePlugin(){
    //     global $_W, $_GPC;
    //     $res=pdo_get('yzhyk_sun_plugin_scoretask_system',array('uniacid'=>$_W['uniacid']),array('is_show'));
    //     echo json_encode($res['is_show']);
    // }

    //    获取订单状态数量
    public function doPageGetOrderStateCounts(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $sql = "";
        $sql .= "select state,count(1) as counts from ".tablename('yzhyk_sun_order')." where user_id = {$user_id} GROUP BY state";

        $list = pdo_fetchall($sql);

        $ret = [];
        foreach ($list as $item) {
            $ret[$item['state']] = $item['counts'];
        }

        echo json_encode($ret);
    }
    //    商城订单-支付
    public function doPagePayOrder(){
        global $_W, $_GPC;

        $data['pay_type'] = $_GPC['pay_type'];
        $data['pay_amount'] = $_GPC['pay_amount'];

        $order = new order();
        $res = $order->pay($data,$_GPC['id']);
        echo json_encode($res);
    }
    //    商城订单-取消
    public function doPageCancelOrder(){
        global $_W, $_GPC;
        $order = new order();
        $res = $order->cancel($_GPC['id']);
        echo json_encode($res);
    }
    //    商城订单-确认收货
    public function doPageConfirmOrder(){
        global $_W, $_GPC;
        $order = new order();
        $res = $order->confirm($_GPC['id']);
        echo json_encode($res);
    }
    //    商城订单-删除
    public function doPageDeleteOrder(){
        global $_W, $_GPC;
        $order = new order();
        $res = $order->delete($_GPC['id']);
        echo json_encode($res);
    }
    //    商城订单-退款
    public function doPagetuiOrder(){
        global $_W, $_GPC;
        
        $res = pdo_update('yzhyk_sun_order',array('istui'=>1),array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        echo json_encode($res);
    }
    //    获取订单详情
    public function doPageGetOrderInfo(){
        global $_W, $_GPC;
        $order = new order();
        $info = $order->get_data_by_id($_GPC['id']);
        echo json_encode($info);
    }
    //    获取订单详情
    public function doPageGetOrderInfoByCode(){
        global $_W, $_GPC;
        $order_number = $_GPC['code'];
        $sql = "";
        $sql .= "select t1.*,t2.name as store_name,t3.name as take_name,t2.tel,t2.address as store_address,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time from ".tablename('yzhyk_sun_order')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t3 on t3.id = t1.user_id ";
        $sql .= "where t1.order_number = {$order_number} ";
        $info = pdo_fetchall($sql)[0];

        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_ordergoods')." ";
        $sql .= "where order_id = {$info['id']} ";

        $list = pdo_fetchall($sql);
        $info['goodses'] = $list;

        echo json_encode($info);

    }
    //获取大转盘订单详情
    public function doPageGetOrderInfoByEat(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $sql .= "select t1.*,t2.name as store_name,t3.name as take_name,t3.tel as usertel,t2.tel,t2.address as store_address,from_unixtime(t1.addtime,'%Y-%m-%d %H:%i') as time,t4.shopprice,from_unixtime(t4.astime,'%Y-%m-%d %H:%i') as astime,from_unixtime(t4.antime,'%Y-%m-%d %H:%i') as antime,from_unixtime(t4.expirationtime,'%Y-%m-%d %H:%i') as expirationtime,t4.expirationtime as extime from ".tablename('yzhyk_sun_eatvisit_order')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.storeid ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t3 on t3.id = t1.uid ";
        $sql .= "left join ".tablename('yzhyk_sun_eatvisit_goods')." t4 on t4.id = t1.gid ";
        $sql .= "where t1.id = {$id} and t1.uniacid=".$_W['uniacid'];

        // var_dump($sql);
        $info = pdo_fetch($sql);
        echo json_encode($info);


    }
    //大转盘订单-判断门店是否符合
    public function doPageisStore(){
        global $_W, $_GPC;
        $storeid = $_GPC['storeid'];
        $id = $_GPC['id'];
        $res=pdo_get('yzhyk_sun_eatvisit_order',array('uniacid'=>$_W['uniacid'],'id'=>$id,'storeid'=>$storeid));
        if($res){
            echo 1;
        }else{
            echo 2;
        }

    }
    //    大转盘订单-确认核销
    public function doPageConfirmEatOrder(){
        global $_W, $_GPC;
        // $order = new order();
        // $res = $order->confirm($_GPC['id']);
        $res=pdo_update('yzhyk_sun_eatvisit_order',array('status'=>2,'finishtime'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        if($res){
            echo 0;
        }else{
            echo 1;
        }

        // echo json_encode($res);
    }
    //    计算配送费
    public function doPageGetDistributionFee(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $store_id = $_GPC['store_id'];
        $province = $_GPC['province'];
        $city = $_GPC['city'];
        $county = $_GPC['county'];

        $sql = "";
        $sql .= "select t2.name as province,t3.name as city,t4.name as county from ".tablename('yzhyk_sun_store')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_province')." t2 on t2.id = t1.province_id ";
        $sql .= "left join ".tablename('yzhyk_sun_city')." t3 on t3.id = t1.city_id ";
        $sql .= "left join ".tablename('yzhyk_sun_county')." t4 on t4.id = t1.county_id ";
        $sql .= "where t1.id = $store_id ";

        $storeinfo = pdo_fetchall($sql)[0];

        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_system')." where uniacid = $uniacid";

        $systeminfo = pdo_fetchall($sql)[0];

        $fee = $systeminfo['postage_base'];
        if($storeinfo['province'] != $province){
            $fee = $systeminfo['postage_province'];
        }else{
            if($storeinfo['city'] != $city){
                $fee = $systeminfo['postage_city'];
            }else{
                if($storeinfo['county'] != $county){
                    $fee = $systeminfo['postage_county'];
                }
            }
        }
        echo $fee;
    }

    //    获取门店商城订单
    public function doPageGetStoreOrders(){
        global $_W, $_GPC;

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .="select t2.name as store_name,t2.tel as store_tel,t1.pay_amount,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time,t1.id,t1.state,t1.distribution_type ";
        $sql .=",(select SUM(ti.num) from ".tablename('yzhyk_sun_ordergoods')." ti where ti.order_id = t1.id) as nums ";
        $sql .=",t3.goods_id,t3.goods_img,t3.goods_name,t3.goods_price,t3.num ";
        $sql .="from ".tablename('yzhyk_sun_order')." t1 ";
        $sql .="left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
        $sql .="left join ".tablename('yzhyk_sun_ordergoods')." t3 on t3.order_id = t1.id and t3.id = (select id from ".tablename('yzhyk_sun_ordergoods')." tii where tii.order_id = t1.id order by num desc limit 1) ";
        $sql .="where t1.store_id = {$_GPC['store_id']} and t1.state <> -10 and ({$_GPC['state']} = 0 or t1.state = {$_GPC['state']}) ";
        $sql .= "order by t1.time desc ";

        $list = pdo_fetchall($sql.$limt_sql);

        echo json_encode($list);

    }
    //    获取门店预约订单
    public function doPageGetStoreappOrders(){
        global $_W, $_GPC;

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .="select t2.name as store_name,t2.tel as store_tel,t1.pay_amount,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time,t1.id,t1.state ";
        $sql .=",(select SUM(ti.num) from ".tablename('yzhyk_sun_orderappgoods')." ti where ti.order_id = t1.id) as nums ";
        $sql .=",t3.goods_id,t3.goods_img,t3.goods_name,t3.goods_price,t3.num ";
        $sql .="from ".tablename('yzhyk_sun_orderapp')." t1 ";
        $sql .="left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
        $sql .="left join ".tablename('yzhyk_sun_orderappgoods')." t3 on t3.order_id = t1.id and t3.id = (select id from ".tablename('yzhyk_sun_orderappgoods')." tii where tii.order_id = t1.id order by num desc limit 1) ";
        $sql .="where t1.store_id = {$_GPC['store_id']} and t1.state <> -10 and ({$_GPC['state']} = 0 or t1.state = {$_GPC['state']}) ";
        $sql .= "order by t1.time desc ";
        // echo ($sql.$limt_sql);exit();
        $list = pdo_fetchall($sql.$limt_sql);

        echo json_encode($list);

    }
}
//商品
trait goods2 {
    //    获取分类
    public function doPageGetClasses(){
        global $_W, $_GPC;

        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_goodsclass')." ";
        $sql .= "where isdel != 1 ";
        $sql .= "        and (id in ( ";
        $sql .= "            select t2.class_id from ".tablename('yzhyk_sun_storegoods')." t1 ";
        $sql .= "    left join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id and t1.store_id = {$_GPC['store_id']}";
        $sql .= ") or id in( ";
        $sql .= "    select t2.root_id from ".tablename('yzhyk_sun_storegoods')." t1 ";
        $sql .= "    left join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id and t1.store_id = {$_GPC['store_id']}";
        $sql .= ")) ";
        $sql .= "order by `level`,`index` ";
        $list = pdo_fetchall($sql);
        $new_list = [];
        $new_list[] = ['id'=>0,'name'=>'推荐','group'=>[]];
        foreach ($list as $item) {
            if(!$item['root_id']){
                $item['group']=[];
                $new_list[$item['id']]=$item;
            }else{
                $new_list[$item['root_id']]['group'][0] = ['id'=>0,'name'=>'全部'];
                $new_list[$item['root_id']]['group'][] = $item;
            }
        }
        echo json_encode(array_values($new_list));
    }
    //    获取商品列表
    public function doPageGetGoodses(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];
        $root_id = $_GPC['root_id'];
        $class_id = $_GPC['class_id'];

        $where=[];
        $where[] = "t1.isdel != 1";
        if($root_id){
            $where[] = "t1.root_id = $root_id";
        }else{
            $where[] = "t2.ishot = 1";
        }
        if($class_id){
            $where[] = "t1.class_id = $class_id";
        }
        $where_sql = " where ".implode(" and ",$where);

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t1.id,t1.name as title,t1.isappointment ";
        $sql .= ",case when t5.price is null then t1.marketprice else coalesce(t2.shop_price,t1.shopprice) end as old_price,t1.pic as src ";
        $sql .= ",coalesce(t5.price,t2.shop_price,t1.shopprice) as price ";
        $sql .= ",case when t5.price is null then 0 else 1 end as is_activity ";
        $sql .= ",case when t5.price is null then 0 else t3.activity_id end as activity_id ";
        $sql .= "from ".tablename('yzhyk_sun_goods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_storegoods')." t2 on t2.goods_id = t1.id and t2.stock != 0 and t2.store_id = $store_id ";
        $sql .= "left join ".tablename('yzhyk_sun_storeactivity')." t3 on t3.store_id = t2.store_id and t3.begin_time <= now() and t3.end_time > now() ";
        $sql .= "left join ".tablename('yzhyk_sun_storeactivitygoods')." t5 on t5.storeactivity_id = t3.id and t5.goods_id = t1.id and t5.stock >0 ";
//        $sql .= "left join ".tablename('yzhyk_sun_activitygoods')." t4 on t4.activity_id = t5.activity_id and t4.goods_id = t1.id ";

        $order_sql = " order by t5.price desc,t1.index,t1.id ";
        $list = pdo_fetchall($sql.$where_sql.$order_sql.$limt_sql);

        $new_list = [];
        foreach ($list as $item) {
            $item['num'] = '0';
            $item['limit'] = '1000';//todo 库存当限定值
            $new_list[] = $item;
        }

        echo json_encode($new_list);
    }
    //    获取商品信息 by 条形码
    public function doPageGetGoodsByBarcode(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];
        $barcode = $_GPC['barcode'];

        $where_sql = " where t1.isdel != 1 and t1.barcode = $barcode";

        $sql = "";
        $sql .= "select t1.id,t1.name as title ";
        $sql .= ",t1.marketprice,t1.pic as src ";
        $sql .= ",case when t2.shop_price is not null and t2.shop_price != 0 then t2.shop_price else t1.shopprice end as price ";
        $sql .= "from ".tablename('yzhyk_sun_goods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_storegoods')." t2 on t2.goods_id = t1.id and t2.stock != 0 and t2.store_id = $store_id ";

        $list = pdo_fetchall($sql.$where_sql);

        $data  = $list[0];
        $data['num']='0';
        $data['limit']='1000';

        echo json_encode($data);
    }
    //    获取商品信息 by id
    public function doPageGetGoodsById(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];
        $goods_id = $_GPC['goods_id'];
        $activity_id = $_GPC['activity_id'];

        $where_sql = " where t1.isdel != 1 and t1.id = $goods_id";

        $sql = "";
        $sql .= "select t1.*,t1.name as title,t1.isappointment,t1.std as spec ";
        $sql .= ",t1.pic as src,t4.activity_id,t4.end_time,IFNULL(t5.stock,0) as activity_stock,IFNULL(t5.limit,0) - IFNULL(t5.stock,0) as buy_stock ";
        $sql .= ",case when t5.id is not null then t5.price when t2.shop_price is not null and t2.shop_price != 0 then t2.shop_price else t1.shopprice end as price ";
        $sql .= "from ".tablename('yzhyk_sun_goods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_storegoods')." t2 on t2.goods_id = t1.id and t2.stock != 0 and t2.store_id = $store_id ";
//        $sql .= "left join ".tablename('yzhyk_sun_activitygoods')." t3 on t3.goods_id = t1.id and t3.activity_id = $activity_id ";
        $sql .= "left join ".tablename('yzhyk_sun_storeactivity')." t4 on t4.activity_id = $activity_id ";
        $sql .= "left join ".tablename('yzhyk_sun_storeactivitygoods')." t5 on t5.storeactivity_id = t4.id and t5.goods_id = t1.id ";

        $list = pdo_fetchall($sql.$where_sql);

        $data  = $list[0];
        $data['num']='0';
        $data['limit']='1000';
        $data['content'] = htmlspecialchars_decode($data['content']);
        $data['end_time'] = strtotime($data['end_time'])*1000;

        echo json_encode($data);

    }
    //    获取门店限时抢购商品
    public function doPageGetActivityGoods(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];

        $where=[];
        $where[] = "t3.isdel != 1";
        $where_sql = " where ".implode(" and ",$where);

        $limt_sql = "";
    //        $pageindex = max(1, intval($_GPC['page']));
    //        $pagesize=$_GPC['limit']?:10;
    //        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t3.id,t3.name as title,t3.pic as src,t1.price,t2.end_time,t2.activity_id ";
        $sql .= ",coalesce(t3.marketprice,t4.shop_price,t3.shopprice) as old_price ";

        $sql .= "from ims_yzhyk_sun_storeactivitygoods t1 ";
        $sql .= "inner join ims_yzhyk_sun_storeactivity t2 on t2.id = t1.storeactivity_id and t2.begin_time <= now() and t2.end_time > now() and t1.stock > 0 and t2.store_id = $store_id ";
        $sql .= "inner join ims_yzhyk_sun_goods t3 on t3.id = t1.goods_id ";
        $sql .= "inner join ims_yzhyk_sun_storegoods t4 on t4.goods_id = t3.id and t4.store_id = t2.store_id and t4.stock > 0 ";

//        $sql .= "from ".tablename('yzhyk_sun_activitygoods')." t1 ";
//        $sql .= "inner join ".tablename('yzhyk_sun_activity')." t2 on t2.id = t1.activity_id and t2.begin_time <= now() and t2.end_time > now() ";
//        $sql .= "inner join ".tablename('yzhyk_sun_storeactivity')." t3 on t3.activity_id = t1.activity_id and t3.store_id = $store_id ";
//        $sql .= "inner join ".tablename('yzhyk_sun_goods')." t4 on t4.id = t1.goods_id ";
//        $sql .= "inner join ".tablename('yzhyk_sun_storegoods')." t5 on t5.goods_id = t4.id and t5.store_id = t3.store_id and t5.stock > 0 ";
//        $sql .= "inner join ".tablename('yzhyk_sun_storeactivitygoods')." t6 on t6.activity_id = t1.activity_id and t6.store_id = $store_id and t6.goods_id = t1.goods_id and t6.stock > 0 ";

        $list = pdo_fetchall($sql.$where_sql.$limt_sql);

        $new_list = [];
        foreach ($list as $item) {
            $item['num'] = '0';
            $item['limit'] = '1000';//todo 库存当限定值
            $item['end_time'] = strtotime($item['end_time'])*1000;
            $new_list[] = $item;
        }

        echo json_encode($new_list);
    }
    //    获取热搜
    public function doPageGetHotSearch(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $sql = "";
        $sql .= "select keyword,count(1) as search_time from ".tablename('yzhyk_sun_searchrecord')." where uniacid = $uniacid group by keyword order by search_time desc LIMIT 0,10";

        $list = pdo_fetchall($sql);

        $new_list = [];
        foreach ($list as $item) {
            $new_list[] = $item['keyword'];
        }

        echo json_encode($new_list);
    }
    //    增加搜索记录
    public function doPageAddSearchRecord(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $keywords = explode(' ',$_GPC['keyword']);
        foreach ($keywords as $keyword) {
            $data['keyword']=$keyword;
            $data['search']=$_GPC['keyword'];
            $data['user_id']=$_GPC['user_id'];
            $data['time']=time();
            $data['uniacid'] = $uniacid;
            $res=pdo_insert('yzhyk_sun_searchrecord',$data);
        }
    }
    //    获取搜索结果
    public function doPageGetSearchResult(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];
        $keywords = explode(' ',$_GPC['keyword']);

        $where=[];
        $where[] = "t1.isdel != 1";
        foreach ($keywords as $keyword) {
            $where[] = "t1.name like \"%$keyword%\"";
        }
        $where_sql = " where ".implode(" and ",$where);

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t1.id,t1.name as title ";
        $sql .= ",case when t4.price is null then t1.marketprice else coalesce(t2.shop_price,t1.shopprice) end as old_price,t1.pic as src ";
        $sql .= ",coalesce(t4.price,t2.shop_price,t1.shopprice) as price ";
        $sql .= ",case when t4.price is null then 0 else 1 end as is_activity ";
        $sql .= "from ".tablename('yzhyk_sun_goods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_storegoods')." t2 on t2.goods_id = t1.id and t2.stock != 0 and t2.store_id = $store_id ";
        $sql .= "left join ".tablename('yzhyk_sun_storeactivity')." t3 on t3.store_id = t2.Store_id ";
        $sql .= "left join ".tablename('yzhyk_sun_activitygoods')." t4 on t4.activity_id = t3.activity_id and t4.goods_id = t1.id";

        $list = pdo_fetchall($sql.$where_sql.$limt_sql);

        $new_list = [];
        foreach ($list as $item) {
            $item['num'] = '0';
            $item['limit'] = '1000';//todo 库存当限定值
            $new_list[] = $item;
        }

        echo json_encode($new_list);
    }
    //    检查余额是否充足
    public function doPageCheckBalance(){
        global $_W, $_GPC;
        $user_id=$_GPC['user_id'];
        $pay_amount = $_GPC['pay_amount'];
        $user =pdo_get('yzhyk_sun_user',array('id'=>$user_id));
        if($user['balance'] < $pay_amount){
            echo json_encode(["code"=>1,"msg"=>"余额不足"]);
        }else{
            echo json_encode(["code"=>0]);
        }
    }
}
//优惠券
trait coupon2{
    public function doPageGetCoupons(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $user_id = $_GPC['user_id'];
        $store_id = $_GPC['store_id'];

        $sql = "";
        $sql .= "select distinct t1.*,t3.isvip,case when t2.id is not null then 2 when t1.left_num = 0 then 1 else 0 end as status ";
        $sql .= "from ".tablename('yzhyk_sun_storecoupon')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_usercoupon')." t2 on t2.storecoupon_id = t1.id and t2.user_id = $user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_coupon')." t3 on t1.coupon_id = t3.id ";
        $sql .= "where t1.begin_time <= NOW() and t1.end_time >= now() and t1.uniacid = $uniacid and t1.store_id = $store_id ";
        $list = pdo_fetchall($sql);
        echo json_encode($list);
    }
    public function doPageAddUserCoupon(){
        global $_W, $_GPC;
        $data['user_id'] = $_GPC['user_id'];
        $data['storecoupon_id'] = $_GPC['storecoupon_id'];

        $usercoupon = new usercoupon();
        $res = $usercoupon->insert($data);
        echo json_encode($res);
    }
    public function doPageGetUserCoupons(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];
        $store_id = $_GPC['store_id'];

        $sql = "";
        $sql .= "select id,name,DATE_FORMAT(begin_time,'%Y.%m.%d') as begin_time,DATE_FORMAT(end_time,'%Y.%m.%d') as end_time,use_amount,amount from ".tablename('yzhyk_sun_usercoupon')." ";
        $sql .= "where user_id = $user_id and store_id = $store_id ";
        $sql .= "    and begin_time <= now() ";
        $sql .= "    and end_time >= now() ";
        $sql .= "    and is_used = 0 ";

        $list = pdo_fetchall($sql);
        echo json_encode($list);
    }

}
//会员充值卡
trait membercard2{
    //    获取会员充值卡列表
    public function doPageGetMemberCards(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $sql = "";
        $sql .= "select * from ".tablename('yzhyk_sun_membercard')." where uniacid = $uniacid order by days desc ";

        $list = pdo_fetchall($sql);
        echo json_encode($list);
    }
    //    购买会员卡
    public function doPageBuyCard(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $user_id = $_GPC['user_id'];
        $card_id = $_GPC['card_id'];
        $days = $_GPC['days'];
        if($days==0){
            $days = 36500;
        }
        $amount = $_GPC['amount'];
        $pay_type = $_GPC['pay_type'];

        $user = pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        $data['uniacid'] = $uniacid;
        $data['user_id'] = $user_id;
        $data['membercard_id'] = $card_id;
        $data['time'] = time();

        if($pay_type == "余额"){
            if($amount>0){
                if($user['balance'] < $amount){
                    echo json_encode(["code"=>1,"msg"=>"余额不足"]);exit;
                }else{
                    $data2['balance']=$user['balance'] - $amount;
                    $res = pdo_update('yzhyk_sun_user', $data2, array('id' =>$user_id));

                    //余额账单
                    $data4['user_id'] = $user_id;
                    $data4['content'] = "会员卡续费";
                    $data4['balance'] = $amount;
                    $data4['time'] = $data['time'];
                    $data4['type'] = 6;
                    $data4['uniacid'] = $uniacid;
                    $res=pdo_insert('yzhyk_sun_bill',$data4);
                }
                
            }else{
                //余额账单
                $data4['user_id'] = $user_id;
                $data4['content'] = "会员卡续费";
                $data4['balance'] = $amount;
                $data4['time'] = $data['time'];
                $data4['type'] = 6;
                $data4['uniacid'] = $uniacid;
                $res=pdo_insert('yzhyk_sun_bill',$data4);
            }
            
        }

        $res=pdo_insert('yzhyk_sun_membercardrecord',$data);

        if($user['end_time'] > time()){
            $time = $user['end_time'] + ($days*24*60*60);
        }else{
            $time = time()+($days*24*60*60);
        }
        $res = pdo_update('yzhyk_sun_user', ["end_time"=>$time], array('id' =>$user_id));
        if($res){
            echo json_encode(['code'=>0]);
        }else{
            throw new ZhyException('购买失败');
        }
    }
    //    激活会员卡
    public function doPageRechargeCard(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $user_id = $_GPC['user_id'];
        $code = $_GPC['code'];

        $rechargecodelist = pdo_fetchall("select * from ".tablename('yzhyk_sun_rechargecode')." where recharge_code = '$code'");
        if(!count($rechargecodelist)){
            throw new ZhyException('激活码不存在');
        }  

        $rechargecode = $rechargecodelist[0];

        $membercard = pdo_get("yzhyk_sun_membercard",['id'=>$rechargecode['membercard_id']]);
        if(!$membercard){
            throw new ZhyException('激活码无效');
        }

        $user = pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        $data['uniacid'] = $uniacid;
        $data['user_id'] = $user_id;
        $data['membercard_id'] = $membercard['id'];
        $data['recharge_code'] = $code;
        $data['time'] = time();
        $res=pdo_insert('yzhyk_sun_membercardrecord',$data);

        $days = $membercard['days'];
        if($days==0){
            $days = 36500;
        }
        if($user['end_time'] > time()){
            $time = $user['end_time'] + ($days*24*60*60);
        }else{
            $time = time()+($days*24*60*60);
        }
        $res = pdo_update('yzhyk_sun_user', ["end_time"=>$time], array('id' =>$user_id));

        if($res){
            pdo_delete('yzhyk_sun_rechargecode',array('uniacid'=>$uniacid,'id'=>$rechargecode['id']));
            echo json_encode(['code'=>0]);
        }else{
            throw new ZhyException('激活失败');
        }
    }
    //    获取会员充值卡记录列表
    public function doPageGetMemberCardRecords(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];


        $sql = "";
        $sql .= "select t3.name as user_name,t3.img,t2.name as card_name,t1.recharge_code ";
        $sql .= "from ".tablename('yzhyk_sun_membercardrecord')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_membercard')." t2 on t2.id = t1.membercard_id ";
        $sql .= "inner join ".tablename('yzhyk_sun_user')." t3 on t3.id = t1.user_id ";
        $sql .= "where t1.uniacid = $uniacid ";
        $sql .= "order by t1.time desc ";
        $sql .= "LIMIT 10 ";

        $list = pdo_fetchall($sql);
        echo json_encode($list);
    }
}
    // public function doPageGetactivity(){
    //     global $_W, $_GPC;
        
    // }
//拼团
trait groupgoods2{
    public function doPageGetGroupGoodses(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t2.title,t2.pic as src,t2.price,t2.num as userNum, t3.shop_price - t2.price as discount,t3.shop_price,t2.id ";
        $sql .= "from ".tablename('yzhyk_sun_storegroupgoods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_groupgoods')." t2 on t2.id = t1.groupgoods_id and t2.begin_time < NOW() and t2.end_time > now() and t1.store_id = $store_id ";
        $sql .= "inner join ".tablename('yzhyk_sun_storegoods')." t3 on t3.store_id = t1.store_id and t3.goods_id = t2.goods_id ";

        $order_sql = " order by t1.is_hot desc,t1.id desc ";
        $list = pdo_fetchall($sql.$order_sql.$limt_sql);

        foreach ($list as $key => $value) {

            $groupNum=count(pdo_getall('yzhyk_sun_group',array('uniacid'=>$_W['uniacid'],'groupgoods_id'=>$value['id'],'state'=>1)));
            $list[$key]['groupNum']=$groupNum;
        }
        echo json_encode($list);
    }
    public function doPageGetGroupGoods(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];
        $goods_id = $_GPC['goods_id'];

        $sql = "";
        $sql .= "select t1.*,t2.shopprice from ".tablename('yzhyk_sun_groupgoods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.id = $goods_id ";

        $list = pdo_fetchall($sql);

        $data  = $list[0];
        $data['content'] = htmlspecialchars_decode($data['content']);
        $data['end_time'] = strtotime($data['end_time'])*1000;

        $sql = "";
        $sql .= "select t2.name as uname,t2.img as uthumb,t1.end_time * 1000 as end_time,t4.num - t1.num as num,t1.id ";
        $sql .= "from ".tablename('yzhyk_sun_group')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "inner join ".tablename('yzhyk_sun_storegroupgoods')." t3 on t3.id = t1.storegroupgoods_id and t3.store_id = $store_id and t3.groupgoods_id = $goods_id ";
        $sql .= "inner join ".tablename('yzhyk_sun_groupgoods')." t4 on t4.id = t3.groupgoods_id ";
        $sql .= "where t1.state = 0 and t1.end_time > ".time()." ";
        $sql .= "order by t1.end_time desc ";

        $list = pdo_fetchall($sql);
        echo json_encode(['info'=>$data,'list'=>$list]);

    }
    public function doPageGetGroup(){
        global $_W, $_GPC;
        $group_id = $_GPC['group_id'];
        $user_id = $_GPC['user_id'];

        $sql = "";
        $sql .= "select t2.pic as img,t2.title,t2.price,t3.shopprice as oldprice,t1.num,t2.num as userNum,t2.id ";
        $sql .= "from ".tablename('yzhyk_sun_group')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_groupgoods')." t2 on t2.id = t1.groupgoods_id and t1.id = $group_id ";
        $sql .= "inner join ".tablename('yzhyk_sun_goods')." t3 on t3.id = t2.goods_id ";
        $list = pdo_fetchall($sql);
        $data  = $list[0];
        $data['status'] = 2;

        $sql = "";
        $sql .= "select t2.img,t2.id ";
        $sql .= "from ".tablename('yzhyk_sun_group')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id and t1.id = $group_id ";
        $list = pdo_fetchall($sql);
        $user = [];
        $userid = [];
        $user[] = $list[0]['img'];
        $userid[] = $list[0]['id'];

        $sql = "";
        $sql .= "select t2.img,t2.id ";
        $sql .= "from ".tablename('yzhyk_sun_groupuser')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id and t1.group_id = $group_id";
        $list = pdo_fetchall($sql);
        foreach ($list as $item) {
            if (in_array($item['id'],$userid)){
                continue;
            }
            $user[] = $item['img'];
            $userid[] = $item['id'];
        }
        if(in_array($user_id,$userid)){
            $data['status'] = 1;
        }
        echo json_encode(['info'=>$data,'list'=>$user,'ids'=>$userid]);
    }
    //    增加拼团订单
    public function doPageAddGroupOrder(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        // 订单数据
        $data['user_id']=$_GPC['user_id'];
        $data['store_id']=$_GPC['store_id'];
        $data['amount']=$_GPC['amount'];
        $data['pay_amount']=$_GPC['pay_amount'];
        $data['distribution_type'] = $_GPC['distribution_type'];
        $data['province'] = $_GPC['province'];
        $data['city'] = $_GPC['city'];
        $data['county'] = $_GPC['county'];
        $data['address'] = $_GPC['address'];
        $data['distribution_fee'] = $_GPC['distribution_fee'];
        $data['take_time'] = $_GPC['take_time'];
        $data['take_tel'] = $_GPC['take_tel'];
        $data['memo'] = $_GPC['memo'];
        $data['take_address'] = $_GPC['take_address'];
        $data['state'] = 10;
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['group_id'] = $_GPC['group_id'];
        // 订单商品信息
        $data['goodses'] = json_decode(htmlspecialchars_decode($_GPC['goodses']));

        $grouporder = new grouporder();
        $res = $grouporder->insert($data);
        echo json_encode(['code'=>0,'id'=>$res['data']]);//,'group_id'=>$group_id]);
    }
    //    获取拼团订单
    public function doPageGetGroupOrders(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $user_id = $_GPC['user_id'];
        $state = $_GPC['status'];
        switch($state){
            case 2:
                $state = -1;
                break;
            case 1:
            case 0:
                break;
            default:
                $state = 0;
        }

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t1.order_number as ordernum,$state as status,t1.id ";
        $sql .= ",t1.goods_img as img,t1.goods_name as title,t1.group_id ";
        $sql .= ",t1.goods_price as price,t3.shopprice as oldprice ";
        $sql .= ",t4.num,t2.num as userNum,t4.end_time*1000 as endtime ";
        $sql .= "from ".tablename('yzhyk_sun_grouporder')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_groupgoods')." t2 on t2.id = t1.goods_id ";
        $sql .= "left join ".tablename('yzhyk_sun_goods')." t3 on t3.id = t2.goods_id ";
        $sql .= "left join ".tablename('yzhyk_sun_group')." t4 on t4.id = t1.group_id ";
        $sql .= "where t1.user_id = $user_id and t1.uniacid = $uniacid and t4.state = $state and t1.state <> -10 ";
        $sql .= "order by t1.time desc ";

        $list = pdo_fetchall($sql.$limt_sql);
        echo json_encode($list);
    }
    //    拼团订单-支付
    public function doPagePayGroupOrder(){
        global $_W, $_GPC;

        $data['pay_type'] = $_GPC['pay_type'];
        $data['pay_amount'] = $_GPC['pay_amount'];

        $grouporder = new grouporder();
        $res = $grouporder->pay($data,$_GPC['id']);
        echo json_encode($res);
    }

    public function doPageCancelGroupOrder(){
        global $_W, $_GPC;
        $grouporder = new grouporder();
        $ret = $grouporder->cancel($_GPC['id']);
        echo json_encode($ret);
    }

    public function doPageDeleteGroupOrder(){
        global $_W, $_GPC;
        $data['state'] = -10;
        $ret=pdo_update('yzhyk_sun_grouporder',$data,array('id'=>$_GPC['id']));
        if($ret){
            echo json_encode(['code'=>0]);
        }else{
            throw new ZhyException('删除失败');
        }
    }
} 
// 砍价
trait cutgoods2{
    // 砍价，获取随机金额
    public function getRandMoney($total,$num){
        if ($num == 1) {
            return $total;
        }
        $cut_money2 = $total - $num * 0.01;

        $cuts = [];
        for ($ddd=0; $ddd < max(1,$num/2); $ddd++) { 
            $cuts[] = rand(1,$num);
        }

        // 本次砍价金额
        $cut = round(min($cuts)/$num*rand(1,10000)/10000*$cut_money2,2)+ 0.01;
        
        return $cut;
    }
    public function getCutGoodses($opt){
        $store_id = $opt['store_id'];
        $user_id = $opt['user_id'];

        $pageindex = max(1, intval($opt['page']));
        $pagesize = $opt['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t2.title,t2.pic as src,t2.price,0 as barNum, t3.shop_price as oldPrice,t1.id,t2.end_time as endtime ";
        $sql .= "from ".tablename('yzhyk_sun_storecutgoods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_cutgoods')." t2 on t2.id = t1.cutgoods_id and t2.begin_time < now() and t2.end_time > now() and t1.store_id = $store_id ";
        $sql .= "inner join ".tablename('yzhyk_sun_storegoods')." t3 on t3.store_id = t1.store_id and t3.goods_id = t2.goods_id ";
        // var_dump($sql);

        $order_sql = " order by t1.is_hot desc,t1.id desc ";
        $list = pdo_fetchall($sql.$order_sql.$limt_sql);
        foreach ($list as &$item) {
            $item['endtime'] = strtotime($item['endtime']) * 1000;

            $sql = "";
            $sql .= "select t2.img from ".tablename('yzhyk_sun_cut')." t1 ";
            $sql .= "inner join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id and t1.storecutgoods_id = {$item['id']} ";
            $sql .= "order by t1.end_time desc ";
            $sql .= "limit 4 ";
            
            $item['pics'] = array();
            $imgs = pdo_fetchall($sql);
            foreach ($imgs as $img) {
                $item['pics'][] = $img['img'];
            }
        }

        return $list;
    }
    public function getCuts($opt){
        $state = $opt['state']?:0;
        $user_id = $opt['user_id'];

        $pageindex = max(1, intval($opt['page']));
        $pagesize = $opt['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t1.id,t1.storecutgoods_id,t2.title,t2.price,t3.shopprice,t1.cut_price,t2.pic ";
        $sql .= "from ".tablename('yzhyk_sun_cut')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_cutgoods')." t2 on t2.id = t1.cutgoods_id ";
        $sql .= "left join ".tablename('yzhyk_sun_goods')." t3 on t3.id = t2.goods_id ";
        $sql .= "where t1.state = $state and t1.user_id = $user_id ";

        $list = pdo_fetchall($sql.$limt_sql);

        return $list;
    }

    // app接口
    public function doPageGetCutGoodses(){
        global $_W, $_GPC;

        $list = $this->getCutGoodses([
            'store_id'=>$_GPC['store_id'],
            'user_id'=>$_GPC['user_id'],
            'page'=>$_GPC['page'],
            'limit'=>$_GPC['limit'],
        ]);

        echo json_encode($list);
    }
    public function doPageGetCutGoods(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];
        $storecutgoods_id = $_GPC['storecutgoods_id'];
        $storecutgoods = pdo_get('yzhyk_sun_storecutgoods',array('id'=>$storecutgoods_id));

        if($storecutgoods['store_id'] != $store_id){
            throw new ZhyException('当前门店没有该商品');
            exit();
        }
        $user_id = $_GPC['user_id'];
        $goods_id = $storecutgoods['cutgoods_id'];
        $goods_stock = $storecutgoods['stock'];

        $sql = "";
        $sql .= "select t1.*,t2.shopprice from ".tablename('yzhyk_sun_cutgoods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.id = $goods_id ";

        $list = pdo_fetchall($sql);

        $data  = $list[0];
        $data['content'] = htmlspecialchars_decode($data['content']);
        $data['endtime'] = strtotime($data['end_time'])*1000;
        $data['goods_stock'] = $goods_stock;

        $sql = "";
        $sql .= "select t4.img,t3.cut_price,t1.id as cut_id ";
        $sql .= "from ".tablename('yzhyk_sun_cut')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_storecutgoods')." t2 on t2.id = t1.storecutgoods_id and t2.id = $storecutgoods_id and t1.user_id = $user_id and t1.state = 0 ";
        $sql .= "left join ".tablename('yzhyk_sun_cutuser')." t3 on t3.cut_id = t1.id ";
        $sql .= "inner join ".tablename('yzhyk_sun_user')." t4 on t4.id = t3.user_id ";

        $list = pdo_fetchall($sql);

        $cut = pdo_get('yzhyk_sun_cut',array('id'=>$list[0]['cut_id'],'user_id'=>$user_id,'state'=>0));

        echo json_encode(array('code'=>0,'info'=>$data,'list'=>$list,'cut_info'=>$cut));
    }

    public function doPageAddCut(){
        global $_W, $_GPC;
        $data['user_id'] = $_GPC['user_id'];
        $data['storecutgoods_id'] = $_GPC['storecutgoods_id'];

        $cut = new cut();
        $ret = $cut->insert($data);
        echo json_encode($ret);
    }
    public function doPageGetCutGoodsByCutID(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $cut_id = $_GPC['cut_id'];
        $cut = pdo_get('yzhyk_sun_cut',array('id'=>$cut_id));
        $user = pdo_get('yzhyk_sun_user',array('id'=>$cut['user_id']));
        $cut['img'] = $user['img'];
        $cut['name'] = $user['name'];

        $storecutgoods = pdo_get('yzhyk_sun_storecutgoods',array('id'=>$cut['storecutgoods_id']));
        $store_id = $storecutgoods['store_id'];
        $goods_id = $storecutgoods['cutgoods_id'];
        $sql = "";
        $sql .= "select t1.*,t2.shopprice from ".tablename('yzhyk_sun_cutgoods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.id = $goods_id ";
        $list = pdo_fetchall($sql);
        $data  = $list[0];
        $data['content'] = htmlspecialchars_decode($data['content']);
        $data['endtime'] = strtotime($data['end_time'])*1000;

        $sql = "";
        $sql .= "select t4.img,t3.cut_price,t1.id as cut_id ";
        $sql .= "from ".tablename('yzhyk_sun_cut')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_storecutgoods')." t2 on t2.id = t1.storecutgoods_id and t2.store_id = $store_id and t1.cutgoods_id = $goods_id  and t1.id = $cut_id ";
        $sql .= "left join ".tablename('yzhyk_sun_cutuser')." t3 on t3.cut_id = t1.id ";
        $sql .= "inner join ".tablename('yzhyk_sun_user')." t4 on t4.id = t3.user_id ";
        $list = pdo_fetchall($sql);

        $cut_user = pdo_get('yzhyk_sun_cutuser',array('cut_id'=>$cut_id,'user_id'=>$user_id));

        echo json_encode(['info'=>$data,'list'=>$list,'cut_info'=>$cut,'cut_price'=>$cut_user?$cut_user['cut_price']:0]);
    }

    public function doPageHelpCut(){
        global $_W, $_GPC;
        $cutuser_data['cut_id'] = $_GPC['cut_id'];;
        $cutuser_data['user_id'] = $_GPC['user_id'];;

        $cutuser = new cutuser();
        $price = $cutuser->insert($cutuser_data);

        echo json_encode(['code'=>0,'price'=>$price]);
    }
    public function doPageGetCuts(){
        global $_W, $_GPC;

        $list = $this->getCuts([
            'state'=>$_GPC['state'],
            'user_id'=>$_GPC['user_id'],
            'page'=>$_GPC['page'],
            'limit'=>$_GPC['limit'],
        ]);

        echo json_encode($list);
    }
    public function doPageDeleteCut(){
        global $_W, $_GPC;
        $data['state'] = -10;
        $ret=pdo_update('yzhyk_sun_cut',$data,array('id'=>$_GPC['id']));
        if($ret){
            echo json_encode(['code'=>0]);
        }else{
            throw new ZhyException('删除失败');
        }
    }
    public function doPageAddCutOrder(){
        global $_W, $_GPC;

        $cut = new cut();
        $cut->finish($_GPC['cut_id']);

        $data['user_id']=$_GPC['user_id'];
        $data['store_id']=$_GPC['store_id'];
        $data['amount']=$_GPC['amount'];
        $data['pay_amount']=$_GPC['pay_amount'];
        $data['pay_type']=$_GPC['pay_type'];
        $data['order_type']=3;
        $data['distribution_type'] = $_GPC['distribution_type'];
        $data['province'] = $_GPC['province'];
        $data['city'] = $_GPC['city'];
        $data['county'] = $_GPC['county'];
        $data['address'] = $_GPC['address'];
        $data['distribution_fee'] = $_GPC['distribution_fee'];
        $data['take_time'] = $_GPC['take_time'];
        $data['take_tel'] = $_GPC['take_tel'];
        $data['memo'] = $_GPC['memo'];
        $data['take_address'] = $_GPC['take_address'];
        $data['state'] = 10;
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['goodses'] = json_decode(htmlspecialchars_decode($_GPC['goodses']));

//        门店砍价商品id 转商品id
        foreach ($data['goodses'] as &$goods) {
            $storecutgoods = new storecutgoods();
            $storecutgoods_data = $storecutgoods->get_data_by_id($goods->id);

            $cutgoods = new cutgoods();
            $cutgoods_data = $cutgoods->get_data_by_id($storecutgoods_data['cutgoods_id']);

            $goods->id = $cutgoods_data['goods_id'];
        }

        $order = new order();
        $res = $order->insert($data);
        $res['id'] = $res['data'];
        echo json_encode($res);
    }

//    清理过期砍价 a 拼团
   // public function doPageClearCutAGroup(){
   //     (new cut())->clear();
   //     (new group())->clear();
   // }
}

trait task2{
//    function doPageStart1Task(){
//        start1Task();
//        echo 11;
//    }
    function doPageTestTask(){
        global $_GPC;
        $id = $_GPC['id'];
        $task_model = new task();
        $task = $task_model->get_data_by_id($id);
        $ret =  $this->{$task['type']}($task['value']);
        var_dump($ret);
    }
    function doPageRunTask(){
        global $_GPC;

        ignore_user_abort(true);//忽略客户端关闭
        set_time_limit(0);

        $config_model = new config();

//        如果不是新线程
        if (!$_GPC['newthread']){
            $config_list = $config_model->query2(["`key`='autotask'"])['data'];
            $config_data = $config_list[0];

            if (!$config_data['value']){
                exit();
            }
        }

        $config_model->update_by_id(['value'=>time()],$config_data['id']);

        $task_model = new task();
        $task_list = $task_model->query2(
            [
                "state=0",//待执行
                "execute_time<=".time(),//已过执行时间
                "execute_times<=5",//执行次数不超过 10
            ],
            [
                'limit'=>10,
            ],
            [
                "level desc",
                "execute_times",
                "execute_time",
            ]
        )['data'];

//        $config_model = new config();
//        $config_data = [];
//        $config_data['key']='-'.time();
//        $config_data['memo']=json_encode($task_list);
//        $config_model->insert($config_data);

        if (count($task_list)){

            $task_map = [
//                商城订单
                "sendDingtalk4Order"=>"sendDingtalk4Order",
                "fePrint4Order"=>"fePrint4Order",
                "sendTemplate4Order"=>"sendTemplate4Order",
//                线上买单
                "sendTemplate4OrderOnline"=>"sendTemplate4OrderOnline",
                "sendDingtalk4OrderOnline"=>"sendDingtalk4OrderOnline",
//                扫码购
                "sendTemplate4OrderScan"=>"sendTemplate4OrderScan",
//                砍价过期检查
                "checkOutdateCut"=>"checkOutdateCut",
//                拼团过期检查
                "checkOutdateGroup"=>"checkOutdateGroup",
                //预约下单
                "sendTemplate4Orderapp"=>"sendTemplate4Orderapp",
                
            ];
            foreach ($task_list as $task_data) {
                $config_model->update_by_id(['value'=>time()],$config_data['id']);

                $ret = false;
                $method_name = $task_map[$task_data['type']]?:"";
                if ($method_name){
                    try{
                        $ret = $this->{$method_name}($task_data['value']);
                    }catch (Exception $exception){
                        $task_model->update_by_id(['memo'=>json_encode($exception->getMessage())],$task_data['id']);
                        $ret = false;
                    }
                }

                if ($ret === true){
                    $task_model->update_by_id(['state'=>1,'execute_times'=>$task_data['execute_times']+1],$task_data['id']);
                }else{
                    $task_model->update_by_id(['execute_times'=>$task_data['execute_times']+1,'execute_time'=>$task_data['execute_time']+($task_data['execute_times']*$task_data['execute_times']*5)],$task_data['id']);
                }
            }
            pdo_commit();
        }else{
            sleep(5);
        }
        runTask();
    }
    function sendDingtalk4Order($order_id){
        global $_W;
        $order_model = new order();
        return $order_model->send_dingtalk($order_id);
    }
    function fePrint4Order($order_id){
        // p($order_id);
        $order_model = new order();
        $ret = $order_model->fe_print($order_id);
        if ($ret['code']){
            return false;
        }
        return true;
    }
    function sendTemplate4Order($order_id){
        $order_model = new order();
        return $order_model->send_template($order_id);
    }
    function sendTemplate4Orderapp($order_id){
        $order_model = new orderapp();
        return $order_model->send_template($order_id);
    }

    function sendTemplate4OrderOnline($order_id){
        $order_model = new orderonline();
        return $order_model->send_template($order_id);
    }
    function sendDingtalk4OrderOnline($order_id){
        global $_W;
        $order_model = new orderonline();
        return $order_model->send_dingtalk($order_id);
    }

    function sendTemplate4OrderScan($order_id){
        $order_model = new orderscan();
        return $order_model->send_template($order_id);
    }

    function checkOutdateCut($cut_id){
        $cut_model = new cut();
        return $cut_model->checkOutdate($cut_id);
    }
    function checkOutdateGroup($group_id){
        $group_model = new group();
        return $group_model->checkOutdate($group_id);
    }
}