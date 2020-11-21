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

class yzhyk_sunModuleWxapp extends WeModuleWxapp {

    use order2,bill2,goods2,coupon2,membercard2,groupgoods2,cutgoods2;

    /**********************  柚子会员卡   ******************************/
    //    获取图片根目录
    public function doPageGetImgRoot(){
        global $_GPC,$_W;
        echo $_W['attachurl'];
    }
    //    获取门店列表
    public function doPageGetStores(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $lat = $_GPC['latitude'];
        $lng = $_GPC['longitude'];
        $sql = "";
        $sql .= "select *,convert(acos(cos($lat*pi()/180 )*cos(latitude*pi()/180)*cos($lng*pi()/180 -longitude*pi()/180)+sin($lat*pi()/180 )*sin(latitude*pi()/180))*6370996.81,decimal)  as distance from ims_yzhyk_sun_store where uniacid = $uniacid order by distance ";

        $list = pdo_fetchall($sql);
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
    //    获取底部菜单列表
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
                $sql .= "select * from ims_yzhyk_sun_storeactivitygoods where store_id = $store_id and goods_id = {$goods->id} and activity_id = {$goods->activity_id} ";
                $storeactivitygoods = pdo_fetchall($sql);
                if($storeactivitygoods[0]['stock']< $goods->num){
                    $num = $storeactivitygoods[0]['stock'];
                }
            }
            $sql = "";
            $sql .= "select * from ims_yzhyk_sun_storegoods where store_id = $store_id and goods_id = {$goods->id} ";
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
    //    获取有权限的门店列表
    public function doPageGetAdminStores(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $sql = "";
        $sql .= "select t2.* ";
        $sql .= "from ims_yzhyk_sun_userrole t1 ";
        $sql .= "inner join ims_yzhyk_sun_store t2 on t2.id = t1.store_id ";
        $sql .= "inner join ims_yzhyk_sun_user t3 on t3.admin_id = t1.user_id and t3.id = $user_id ";

        $list = pdo_fetchall($sql);
        echo json_encode($list);
    }
    //    获取后台统计数据
    public function doPageGetAdminReport(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];

        $sql = "";
        $sql .= "select ifnull(sum(amount),0) ";
        $sql .= "from ims_yzhyk_sun_order ";
        $sql .= "where to_days(from_unixtime(time)) = to_days(now()) and store_id = $store_id ";
        $today_amount = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select ifnull(sum(amount),0) ";
        $sql .= "from ims_yzhyk_sun_order ";
        $sql .= "where to_days(from_unixtime(time)) = to_days(now()) +1 and store_id = $store_id ";
        $yesterday_amount = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select ifnull(sum(amount),0) ";
        $sql .= "from ims_yzhyk_sun_order where store_id = $store_id ";
        $amount = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select count(*) ";
        $sql .= "from ims_yzhyk_sun_order ";
        $sql .= "where to_days(from_unixtime(time)) = to_days(now()) and store_id = $store_id ";
        $today_count = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select count(*) ";
        $sql .= "from ims_yzhyk_sun_order where store_id = $store_id ";
        $count = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .= "select count(*) ";
        $sql .= "from ims_yzhyk_sun_order where store_id = $store_id and state = 30";
        $send_count = pdo_fetchcolumn($sql);
        echo json_encode([
            'today_amount'=>$today_amount,
            'yesterday_amount'=>$yesterday_amount,
            'amount'=>$amount,
            'today_count'=>$today_count,
            'count'=>$count,
            'send_count'=>$send_count,
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
        $sql .= "select * from ims_yzhyk_sun_cardlevel where id = $level_id and uniacid = $uniacid ";
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
        $sql .= "select * from ims_yzhyk_sun_cardlevel where amount > {$curr_level['amount']} and uniacid = $uniacid order by amount limit 1 ";
        $list = pdo_fetchall($sql);
        if(count($list)){
            $curr_level['next_name'] = $list[0]['name'];
            $curr_level['next_amount'] = $list[0]['amount'];
            $curr_level['next_discount'] = $list[0]['discount'];
        }

        echo json_encode($curr_level);
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
        $sql .= "select *,convert(acos(cos($lat*pi()/180 )*cos(latitude*pi()/180)*cos($lng*pi()/180 -longitude*pi()/180)+sin($lat*pi()/180 )*sin(latitude*pi()/180))*6370996.81,decimal)  as distance from ims_yzhyk_sun_store where uniacid = $uniacid order by distance ";

    //        $stores = pdo_fetchall("select * from ims_yzhyk_sun_store where uniacid = $uniacid");
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
        // var_dump($info);
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

        $sql = "select sum(amount)as amount from ims_yzhyk_sun_orderscan where user_id = $user_id";
        $list = pdo_fetchall($sql);
        $amount1 = $list[0]['amount']?:0;
        $sql = "select sum(amount)as amount from ims_yzhyk_sun_orderonline where user_id = $user_id";
        $list = pdo_fetchall($sql);
        $amount2 = $list[0]['amount']?:0;
        $sql = "select sum(amount)as amount from ims_yzhyk_sun_order where user_id = $user_id";
        $list = pdo_fetchall($sql);
        $amount3 = $list[0]['amount']?:0;
        $amount = $amount1 + $amount2 + $amount3;
        $res = pdo_update('yzhyk_sun_user', ['amount'=>$amount], array('id' =>$user_id));

        $sql = "";
        $sql .= "select t1.*,t3.id as next_level_id from ims_yzhyk_sun_user t1 ";
        $sql .= "left join ims_yzhyk_sun_cardlevel t2 on t2.id = t1.level_id ";
        $sql .= "left join ims_yzhyk_sun_cardlevel t3 on (t3.amount > t2.amount or t1.level_id is null) and t3.amount <= t1.amount and t3.uniacid = $uniacid ";
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
        $forms = pdo_fetchall("select * from ims_yzhyk_sun_formid where user_id = $user_id and time > $t");
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
    public function doPageOrderarr() {
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $appData = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $appid = $appData['appid'];
        $mch_id = $appData['mchid'];
        $keys = $appData['wxkey'];
        $price = $_GPC['price'];
        $order_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $data = array(
            'appid' => $appid,
            'mch_id' => $mch_id,
            'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',//
            //'sign' => '',
            'body' => time(),
            'out_trade_no' => date('Ymd') . substr('' . time(), -4, 4),
            'total_fee' => $price*100,
    //            'total_fee' => 1,
            'spbill_create_ip' => '120.79.152.105',
            'notify_url' => '120.79.152.105',
            'trade_type' => 'JSAPI',
            'openid' => $openid
        );
        ksort($data, SORT_ASC);
        $stringA = http_build_query($data);
        $signTempStr = $stringA . '&key='.$keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['sign'] = $signValue;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $order_url);//如果不传这样进行设置
        curl_setopt($ch, CURLOPT_HEADER, 0);//header就是返回header头相关信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置数据是直接输出还是返回
        curl_setopt($ch, CURLOPT_POST, 1);//设置为post模式提交 跟 form表单的提交是一样
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->arrayToXml($data));//设置提交数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//设置ssl不验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//设置ssl不验证
        $result = curl_exec($ch);//执行请求 就等于html表单的 input:submit 如果没有设置 returntransfer 那么 是不会有返回值的 会直接输出
        curl_close($ch);//关闭
        $result = xml2array($result);
    //        return $this->result(0,'',$result);
        echo json_encode($this->createPaySign($result));

    }
    function createPaySign($result)
    {
        global $_W;
        $appData = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $keys = $appData['wxkey'];
        $data = array(
            'appId' => $result['appid'],
            'timeStamp' => (string)time(),
            'nonceStr' => $result['nonce_str'],
            'package' => 'prepay_id=' . $result['prepay_id'],
            'signType' => 'MD5'
        );
        ksort($data, SORT_ASC);
        $stringA = '';
        foreach ($data as $key => $val) {
            $stringA .= "{$key}={$val}&";
        }
        $signTempStr = $stringA . 'key='.$keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['paySign'] = $signValue;
        return $data;
    }
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
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

        $sql = "select content,integral,from_unixtime(time,'%Y-%m-%d %H:%i') as time,type from ims_yzhyk_sun_integral ";
        $order_sql = " order by time desc ";
        $list = pdo_fetchall($sql.$where_sql.$order_sql.$limt_sql);

        echo json_encode($list);
    }
    //    获取积分兑换明细
    public function doPageGetIntegralsExchange(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $where_sql = " where user_id = $user_id and type = 4";

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "select content,integral,from_unixtime(time,'%Y-%m-%d %H:%i') as time,type from ims_yzhyk_sun_integral ";
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
        $sql .= "from ims_yzhyk_sun_bill ";
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

        $sql = "select content,balance,from_unixtime(time,'%Y-%m-%d %H:%i') as time,type from ims_yzhyk_sun_bill ";
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
        $sql .= "select * from ims_yzhyk_sun_system where uniacid = $uniacid";
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
        $sql .= "from ims_yzhyk_sun_orderscan t1 ";
        $sql .= "inner join ims_yzhyk_sun_orderscangoods t2 on t2.orderscan_id = t1.id and t1.user_id = $user_id and t1.store_id = $store_id and t1.uniacid = $uniacid ";
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
            echo json_encode(array(
                'code'=>1,
                'msg'=>'更新失败'
            ));
        }
    }
    //    增加线上支付订单
    public function doPageAddOrderOnline2(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $data['user_id']=$_GPC['user_id'];
        $data['store_id']=$_GPC['store_id'];
        $data['amount']=$_GPC['amount'];
        $data['pay_amount']=$_GPC['pay_amount'];
        $data['pay_type']=$_GPC['pay_type'];
        $data['time']=time();
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['uniacid'] = $uniacid;
        $res=pdo_insert('yzhyk_sun_orderonline',$data);
        $res = pdo_update('yzhyk_sun_usercoupon', ["is_used"=>1], array('id' =>$data['coupon_id']));

        $user_id=$_GPC['user_id'];
        $user =pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        if($data['pay_type'] == "余额"){
            $pay_amount = $_GPC['pay_amount'];
            if($user['balance'] < $pay_amount){
                echo json_encode(["code"=>1,"msg"=>"余额不足"]);exit;
            }else{
                $data2['balance']=$user['balance'] - $pay_amount;
                $res = pdo_update('yzhyk_sun_user', $data2, array('id' =>$user_id));
                //余额账单
                $data4['user_id'] = $data['user_id'];
                $data4['content'] = "线下订单、线上支付";
                $data4['balance'] = $_GPC['pay_amount'];
                $data4['time'] = $data['time'];
                $data4['type'] = 1;
                $data4['uniacid'] =$uniacid;
                $res=pdo_insert('yzhyk_sun_bill',$data4);
            }
        }
        //积分明细
        $setting = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $i = $setting['integral1'];

        $data3['user_id'] = $data['user_id'];
        $data3['content'] = "线下订单、线上支付";
        $data3['integral'] = floor($_GPC['pay_amount']/$i);
        $data3['time'] = $data['time'];
        $data3['type'] = 1;
        $data3['uniacid'] = $uniacid;
        $res=pdo_insert('yzhyk_sun_integral',$data3);
        $res = pdo_update('yzhyk_sun_user', ["integral"=>$user['integral']+$data3['integral']], array('id' =>$user_id));
        $this->updateUserAmountLevel($user_id);

        $store = pdo_get('yzhyk_sun_store',['id'=> $data['store_id']]);
        $opt = [
            'user_id'=>$user_id,
            'goods_name'=>$data3['content'],
            'amount'=>$data['amount'],
            'num'=>'1',
            'time'=>$data['time'],
            'address'=>$store['address'],
            'page'=>'',
        ];
        $this->sendTemplateMsg($opt);
    }
    /************************
     * 扫码购订单
     * */
    //    增加扫码购订单
    public function doPageAddOrderScan(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

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
    //    增加扫码购订单
    public function doPageAddOrderScan2(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $data['user_id']=$_GPC['user_id'];
        $data['store_id']=$_GPC['store_id'];
        $data['amount']=$_GPC['amount'];
        $data['pay_amount']=$_GPC['pay_amount'];
        $data['pay_type']=$_GPC['pay_type'];
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['time']=time();
        $data['order_number'] = date('Ymd').time().rand(1000,9999);
        $data['uniacid'] = $uniacid;

        $user_id=$_GPC['user_id'];
        $user =pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        if($data['pay_type'] == "余额"){
            $pay_amount = $_GPC['pay_amount'];
            if($user['balance'] < $pay_amount){
                echo json_encode(["code"=>1,"msg"=>"余额不足"]);
            }else{
                $data2['balance']=$user['balance'] - $pay_amount;
                $res = pdo_update('yzhyk_sun_user', $data2, array('id' =>$user_id));

                //余额账单
                $data4['user_id'] = $data['user_id'];
                $data4['content'] = "扫码购订单";
                $data4['balance'] = $_GPC['pay_amount'];
                $data4['time'] = $data['time'];
                $data4['type'] = 2;
                $data4['uniacid'] = $uniacid;
                $res=pdo_insert('yzhyk_sun_bill',$data4);
            }
        }
        $res=pdo_insert('yzhyk_sun_orderscan',$data);
        $res = pdo_update('yzhyk_sun_usercoupon', ["is_used"=>1], array('id' =>$data['coupon_id']));
        $order = pdo_get('yzhyk_sun_orderscan',array('user_id'=>$data['user_id'],'store_id'=>$data['store_id'],'time'=>$data['time']));
        $goodses = json_decode(htmlspecialchars_decode($_GPC['goodses']));
        foreach ($goodses as $goods) {
            $new_goods = [];
            $new_goods['orderscan_id'] = $order['id'];
            $new_goods['goods_id'] = $goods->id;
            $new_goods['goods_name'] = $goods->title;
            $new_goods['goods_price'] = $goods->price;
            $new_goods['goods_img'] = $goods->src;
            $new_goods['num'] = $goods->num;
            $new_goods['uniacid'] = $uniacid;
            pdo_insert('yzhyk_sun_orderscangoods',$new_goods);

            $storegoods = pdo_fetchall("select * from ims_yzhyk_sun_storegoods where store_id = {$data['store_id']} and goods_id = {$goods->id}");
            pdo_update("yzhyk_sun_storegoods",['stock'=>$storegoods[0]['stock']-$goods->num],['id'=>$storegoods[0]['id']]);
        }

        $setting = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $i = $setting['integral1'];

        $data3['user_id'] = $data['user_id'];
        $data3['content'] = "扫码购订单";
        $data3['integral'] = floor($_GPC['pay_amount']/$i);
        $data3['time'] = $data['time'];
        $data3['type'] = 2;
        $data3['uniacid'] = $uniacid;
        $res=pdo_insert('yzhyk_sun_integral',$data3);
        $res = pdo_update('yzhyk_sun_user', ["integral"=>$user['integral']+$data3['integral']], array('id' =>$user_id));
        $this->updateUserAmountLevel($user_id);

        $store = pdo_get('yzhyk_sun_store',['id'=> $data['store_id']]);
        $opt = [
            'user_id'=>$user_id,
            'goods_name'=>$data3['content'],
            'amount'=>$data['amount'],
            'num'=>'1',
            'time'=>$data['time'],
            'address'=>$store['address'],
            'page'=>'',
        ];
        $this->sendTemplateMsg($opt);
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
        $sql .= ",(select SUM(ti.num) from ims_yzhyk_sun_orderscangoods ti where ti.orderscan_id = t1.id) as nums ";
        $sql .= ",t3.goods_id,t3.goods_img,t3.goods_name,t3.goods_price,t3.num ";
        $sql .= "from ims_yzhyk_sun_orderscan t1 ";
        $sql .= "left join ims_yzhyk_sun_store t2 on t2.id = t1.store_id ";
        $sql .= "left join ims_yzhyk_sun_orderscangoods t3 on t3.orderscan_id = t1.id and t3.id = (select id from ims_yzhyk_sun_orderscangoods tii where tii.orderscan_id = t1.id order by num desc limit 1) ";
        $sql .= "where t1.user_id = {$_GPC['user_id']} and (t1.isdel = 0 or t1.isdel is null) and t1.is_out = $state ";
        $sql .= "order by t1.time desc ";
        //echo $sql.$limt_sql ;exit();
        $list = pdo_fetchall($sql.$limt_sql);

        echo json_encode($list);

    }
    //    删除扫码购订单
    public function doPageDeleteOrderScan(){
        global $_W, $_GPC;
        $orderscan_id = $_GPC['id'];
        $orderscan = new orderscan();
        echo json_encode($orderscan->delete_by_id($orderscan_id));
    }
    //    获取扫码购订单详情
    public function doPageGetOrderScanInfo(){
        global $_W, $_GPC;
        $orderscan = new orderscan();
        $info = $orderscan->get_data_by_id($_GPC['id']);
        echo json_encode($info);
    }
    //    获取扫码购订单详情
    public function doPageGetOrderScanInfo2(){
        global $_W, $_GPC;
        $sql = "";
        $sql .= "select t1.*,t2.name as store_name,t2.tel,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time from ims_yzhyk_sun_orderscan t1 ";
        $sql .= "left join ims_yzhyk_sun_store t2 on t2.id = t1.store_id ";
        $sql .= "where t1.id = {$_GPC['id']} ";
        $info = pdo_fetchall($sql)[0];

        $sql = "";
        $sql .= "select * from ims_yzhyk_sun_orderscangoods ";
        $sql .= "where orderscan_id = {$_GPC['id']} ";

        $list = pdo_fetchall($sql);
        $info['goodses'] = $list;

        echo json_encode($info);

    }
    /************************
     * 商城订单
     * */
    //    增加商城订单
    public function doPageAddOrder(){
        global $_W, $_GPC;

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


        $data['goodses'] = json_decode(htmlspecialchars_decode($_GPC['goodses']));

        $order = new order();
        $res = $order->insert($data);
        $res['id'] = $res['data'];
        echo json_encode($res);
    }
    //    增加商城订单
    public function doPageAddOrder2(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

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
        $data['time']= time();
        $data['order_number'] = date('Ymd').time().rand(1000,9999);
        $data['state'] = 10;
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['uniacid'] = $uniacid;

        $res=pdo_insert('yzhyk_sun_order',$data);
        $res = pdo_update('yzhyk_sun_usercoupon', ["is_used"=>1], array('id' =>$data['coupon_id']));

        $order = pdo_get('yzhyk_sun_order',array('user_id'=>$data['user_id'],'store_id'=>$data['store_id'],'time'=>$data['time']));
        $goodses = json_decode(htmlspecialchars_decode($_GPC['goodses']));
        foreach ($goodses as $goods) {
            $new_goods = [];
            $new_goods['order_id'] = $order['id'];
            $new_goods['goods_id'] = $goods->id;
            $new_goods['goods_name'] = $goods->title;
            $new_goods['goods_price'] = $goods->price;
            $new_goods['goods_img'] = $goods->src;
            $new_goods['num'] = $goods->num;
            $new_goods['uniacid'] = $uniacid;
            pdo_insert('yzhyk_sun_ordergoods',$new_goods);

            $storegoods = pdo_fetchall("select * from ims_yzhyk_sun_storegoods where store_id = {$data['store_id']} and goods_id = {$goods->id}");
            pdo_update("yzhyk_sun_storegoods",['stock'=>$storegoods[0]['stock']-$goods->num],['id'=>$storegoods[0]['id']]);
            if($goods->activity_id){
                $storeactivitygoods = pdo_fetchall("select * from ims_yzhyk_sun_storeactivitygoods where store_id = {$data['store_id']} and goods_id = {$goods->id} and activity_id = {$goods->activity_id}");
                pdo_update("yzhyk_sun_storeactivitygoods",['stock'=>$storeactivitygoods[0]['stock']-$goods->num],['id'=>$storeactivitygoods[0]['id']]);
            }
        }

        echo json_encode(['code'=>0,'id'=>$order['id']]);
    }
    //    获取商城订单
    public function doPageGetOrders(){
        global $_W, $_GPC;

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .="select t2.name as store_name,t2.tel as store_tel,t1.pay_amount,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time,t1.id,t1.state,t1.distribution_type ";
        $sql .=",(select SUM(ti.num) from ims_yzhyk_sun_ordergoods ti where ti.order_id = t1.id) as nums ";
        $sql .=",t3.goods_id,t3.goods_img,t3.goods_name,t3.goods_price,t3.num ";
        $sql .="from ims_yzhyk_sun_order t1 ";
        $sql .="left join ims_yzhyk_sun_store t2 on t2.id = t1.store_id ";
        $sql .="left join ims_yzhyk_sun_ordergoods t3 on t3.order_id = t1.id and t3.id = (select id from ims_yzhyk_sun_ordergoods tii where tii.order_id = t1.id order by num desc limit 1) ";
        $sql .="where t1.user_id = {$_GPC['user_id']} and t1.state <> -10 and ({$_GPC['state']} = 0 or t1.state = {$_GPC['state']}) ";
        $sql .= "order by t1.time desc ";

        $list = pdo_fetchall($sql.$limt_sql);

        echo json_encode($list);

    }
    //    获取订单状态数量
    public function doPageGetOrderStateCounts(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $sql = "";
        $sql .= "select state,count(1) as counts from ims_yzhyk_sun_order where user_id = {$user_id} GROUP BY state";

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
    //    商城订单-支付
    public function doPagePayOrder2(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $data['state'] = 20;
        $data['pay_type']=$_GPC['pay_type'];
        $data['pay_time']=time();

        $user_id=$_GPC['user_id'];
        $user =pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        if($data['pay_type'] == "余额"){
            $pay_amount = $_GPC['pay_amount'];
            if($user['balance'] < $pay_amount){
                echo json_encode(["code"=>1,"msg"=>"余额不足"]);
                exit();
            }else{
                $data2['balance']=$user['balance'] - $pay_amount;
                $res = pdo_update('yzhyk_sun_user', $data2, array('id' =>$user_id));

                //余额账单
                $data4['user_id'] = $data['user_id'];
                $data4['content'] = "线上商城订单";
                $data4['balance'] = $_GPC['pay_amount'];
                $data4['time'] = $data['time'];
                $data4['type'] = 3;
                $data4['uniacid'] = $uniacid;
                $res=pdo_insert('yzhyk_sun_bill',$data4);
            }
        }
        $ret=pdo_update('yzhyk_sun_order',$data,array('id'=>$_GPC['id']));

        $setting = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $i = $setting['integral1'];

        $data3['user_id'] = $data['user_id'];
        $data3['content'] = "线上商城订单";
        $data3['integral'] = floor($_GPC['pay_amount']/$i);
        $data3['time'] = $data['time'];
        $data3['type'] = 3;
        $data3['uniacid'] = $uniacid;
        $res=pdo_insert('yzhyk_sun_integral',$data3);
        $res = pdo_update('yzhyk_sun_user', ["integral"=>$user['integral']+$data3['integral']], array('id' =>$user_id));
        $this->updateUserAmountLevel($user_id);

        $opt = [
            'user_id'=>$user_id,
            'goods_name'=>$data3['content'],
            'amount'=>$data['amount'],
            'num'=>'1',
            'time'=>$data['time'],
            'address'=>"线上订单",
            'page'=>'',
        ];
        $this->sendTemplateMsg($opt);
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
        $sql .= "select t1.*,t2.name as store_name,t3.name as take_name,t2.tel,t2.address as store_address,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time from ims_yzhyk_sun_order t1 ";
        $sql .= "left join ims_yzhyk_sun_store t2 on t2.id = t1.store_id ";
        $sql .= "left join ims_yzhyk_sun_user t3 on t3.id = t1.user_id ";
        $sql .= "where t1.order_number = {$order_number} ";
        $info = pdo_fetchall($sql)[0];

        $sql = "";
        $sql .= "select * from ims_yzhyk_sun_ordergoods ";
        $sql .= "where order_id = {$info['id']} ";

        $list = pdo_fetchall($sql);
        $info['goodses'] = $list;

        echo json_encode($info);

    }
    //    获取订单详情
    public function doPageGetOrderInfo2(){
        global $_W, $_GPC;
        $sql = "";
        $sql .= "select t1.*,t2.name as store_name,t2.tel,t2.address as store_address,from_unixtime(t1.time,'%Y-%m-%d %H:%i') as time from ims_yzhyk_sun_order t1 ";
        $sql .= "left join ims_yzhyk_sun_store t2 on t2.id = t1.store_id ";
        $sql .= "where t1.id = {$_GPC['id']} ";
        $info = pdo_fetchall($sql)[0];

        $sql = "";
        $sql .= "select * from ims_yzhyk_sun_ordergoods ";
        $sql .= "where order_id = {$_GPC['id']} ";

        $list = pdo_fetchall($sql);
        $info['goodses'] = $list;

        echo json_encode($info);

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
        $sql .= "select t2.name as provence,t3.name as city,t4.name as county from ims_yzhyk_sun_store t1 ";
        $sql .= "left join ims_yzhyk_sun_province t2 on t2.id = t1.province_id ";
        $sql .= "left join ims_yzhyk_sun_city t3 on t3.id = t1.city_id ";
        $sql .= "left join ims_yzhyk_sun_county t4 on t4.id = t1.county_id ";
        $sql .= "where t1.id = $store_id ";

        $storeinfo = pdo_fetchall($sql)[0];

        $sql = "";
        $sql .= "select * from ims_yzhyk_sun_system where uniacid = $uniacid";

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
}
//商品
trait goods2 {
    //    获取分类
    public function doPageGetClasses(){
        global $_W, $_GPC;

        $sql = "";
        $sql .= "select * from ims_yzhyk_sun_goodsclass ";
        $sql .= "where isdel != 1 ";
        $sql .= "        and (id in ( ";
        $sql .= "            select t2.class_id from ims_yzhyk_sun_storegoods t1 ";
        $sql .= "    left join ims_yzhyk_sun_goods t2 on t2.id = t1.goods_id and t1.store_id = {$_GPC['store_id']}";
        $sql .= ") or id in( ";
        $sql .= "    select t2.root_id from ims_yzhyk_sun_storegoods t1 ";
        $sql .= "    left join ims_yzhyk_sun_goods t2 on t2.id = t1.goods_id and t1.store_id = {$_GPC['store_id']}";
        $sql .= ")) ";
        $sql .= "order by level ";
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
        $sql .= "select t1.id,t1.name as title,t4.activity_id ";
        $sql .= ",case when t4.price is null then t1.marketprice else coalesce(t2.shop_price,t1.shopprice) end as old_price,t1.pic as src ";
        $sql .= ",coalesce(t4.price,t2.shop_price,t1.shopprice) as price ";
        $sql .= ",case when t4.price is null then 0 else 1 end as is_activity ";
        $sql .= "from ims_yzhyk_sun_goods t1 ";
        $sql .= "inner join ims_yzhyk_sun_storegoods t2 on t2.goods_id = t1.id and t2.stock != 0 and t2.store_id = $store_id ";
        $sql .= "left join ims_yzhyk_sun_storeactivity t3 on t3.store_id = t2.Store_id ";
        $sql .= "left join ims_yzhyk_sun_storeactivitygoods t5 on t5.activity_id = t3.activity_id and t5.goods_id = t1.id and t5.store_id = t2.store_id and t5.stock >0 ";
        $sql .= "left join ims_yzhyk_sun_activitygoods t4 on t4.activity_id = t5.activity_id and t4.goods_id = t1.id ";

        $order_sql = " order by t4.price desc ";
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
        $sql .= "from ims_yzhyk_sun_goods t1 ";
        $sql .= "inner join ims_yzhyk_sun_storegoods t2 on t2.goods_id = t1.id and t2.stock != 0 and t2.store_id = $store_id ";

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
        $sql .= "select t1.*,t1.name as title,t1.std as spec ";
        $sql .= ",t1.pic as src,t3.activity_id,t4.end_time ";
        $sql .= ",case when t3.id is not null then t3.price when t2.shop_price is not null and t2.shop_price != 0 then t2.shop_price  else t1.shopprice end as price ";
        $sql .= "from ims_yzhyk_sun_goods t1 ";
        $sql .= "inner join ims_yzhyk_sun_storegoods t2 on t2.goods_id = t1.id and t2.stock != 0 and t2.store_id = $store_id ";
        $sql .= "left join ims_yzhyk_sun_activitygoods t3 on t3.goods_id = t1.id and t3.activity_id = $activity_id ";
        $sql .= "left join ims_yzhyk_sun_activity t4 on t4.id = $activity_id";

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
        $where[] = "t4.isdel != 1";
        $where_sql = " where ".implode(" and ",$where);

        $limt_sql = "";
    //        $pageindex = max(1, intval($_GPC['page']));
    //        $pagesize=$_GPC['limit']?:10;
    //        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t4.id,t4.name as title,t4.pic as src,t1.price,t2.end_time,t1.activity_id ";
        $sql .= ",coalesce(t5.shop_price,t4.shopprice) as old_price ";
        $sql .= "from ims_yzhyk_sun_activitygoods t1 ";
        $sql .= "inner join ims_yzhyk_sun_activity t2 on t2.id = t1.activity_id and t2.begin_time <= now() and t2.end_time > now() ";
        $sql .= "inner join ims_yzhyk_sun_storeactivity t3 on t3.activity_id = t1.activity_id and t3.store_id = $store_id ";
        $sql .= "inner join ims_yzhyk_sun_goods t4 on t4.id = t1.goods_id ";
        $sql .= "left join ims_yzhyk_sun_storegoods t5 on t5.goods_id = t4.id and t5.store_id = t3.store_id ";
        $sql .= "inner join ims_yzhyk_sun_storeactivitygoods t6 on t6.activity_id = t1.activity_id and t6.store_id = $store_id and t6.goods_id = t1.goods_id and t6.stock > 0 ";

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
        $sql .= "select keyword,count(1) as search_time from ims_yzhyk_sun_searchrecord where uniacid = $uniacid group by keyword order by search_time desc LIMIT 0,10";

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
        $sql .= "from ims_yzhyk_sun_goods t1 ";
        $sql .= "inner join ims_yzhyk_sun_storegoods t2 on t2.goods_id = t1.id and t2.stock != 0 and t2.store_id = $store_id ";
        $sql .= "left join ims_yzhyk_sun_storeactivity t3 on t3.store_id = t2.Store_id ";
        $sql .= "left join ims_yzhyk_sun_activitygoods t4 on t4.activity_id = t3.activity_id and t4.goods_id = t1.id";

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
        $sql .= "select distinct t1.*,case when t2.id is not null then 2 when t1.left_num = 0 then 1 else 0 end as status ";
        $sql .= "from ims_yzhyk_sun_storecoupon t1 ";
        $sql .= "left join ims_yzhyk_sun_usercoupon t2 on t2.storecoupon_id = t1.id and t2.user_id = $user_id ";
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
        $sql .= "select id,name,DATE_FORMAT(begin_time,'%Y.%m.%d') as begin_time,DATE_FORMAT(end_time,'%Y.%m.%d') as end_time,use_amount,amount from ims_yzhyk_sun_usercoupon ";
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
        $sql .= "select * from ims_yzhyk_sun_membercard where uniacid = $uniacid order by days desc ";

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
        $amount = $_GPC['amount'];
        $pay_type = $_GPC['pay_type'];

        $user = pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        $data['uniacid'] = $uniacid;
        $data['user_id'] = $user_id;
        $data['membercard_id'] = $card_id;
        $data['time'] = time();

        if($pay_type == "余额"){
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
            echo json_encode(['code'=>1,'msg'=>'购买失败']);
        }
    }
    //    激活会员卡
    public function doPageRechargeCard(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $user_id = $_GPC['user_id'];
        $code = $_GPC['code'];

        $rechargecodelist = pdo_fetchall("select * from ims_yzhyk_sun_rechargecode where recharge_code = '$code'");
        if(!count($rechargecodelist)){
            echo json_encode(['code'=>1,'msg'=>'激活码不存在']);
            exit();
        }

        $rechargecode = $rechargecodelist[0];

        $membercard = pdo_get("yzhyk_sun_membercard",['id'=>$rechargecode['membercard_id']]);
        if(!$membercard){
            echo json_encode(['code'=>1,'msg'=>'激活码无效']);
            exit();
        }

        $user = pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        $data['uniacid'] = $uniacid;
        $data['user_id'] = $user_id;
        $data['membercard_id'] = $membercard['id'];
        $data['recharge_code'] = $code;
        $data['time'] = time();
        $res=pdo_insert('yzhyk_sun_membercardrecord',$data);

        $days = $membercard['days'];
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
            echo json_encode(['code'=>1,'msg'=>'激活失败']);
        }
    }
    //    获取会员充值卡记录列表
    public function doPageGetMemberCardRecords(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];


        $sql = "";
        $sql .= "select t3.name as user_name,t3.img,t2.name as card_name,t1.recharge_code ";
        $sql .= "from ims_yzhyk_sun_membercardrecord t1 ";
        $sql .= "inner join ims_yzhyk_sun_membercard t2 on t2.id = t1.membercard_id ";
        $sql .= "inner join ims_yzhyk_sun_user t3 on t3.id = t1.user_id ";
        $sql .= "where t1.uniacid = $uniacid ";
        $sql .= "order by t1.time desc ";
        $sql .= "LIMIT 10 ";

        $list = pdo_fetchall($sql);
        echo json_encode($list);
    }
}
//拼团
trait groupgoods2{
    public function doPageGetGroupGoodses(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t2.title,t2.pic as src,t2.price,t2.num as userNum,0 as groupNum, t3.shop_price - t2.price as discount,t2.id ";
        $sql .= "from ims_yzhyk_sun_storegroupgoods t1 ";
        $sql .= "inner join ims_yzhyk_sun_groupgoods t2 on t2.id = t1.groupgoods_id and t2.begin_time < NOW() and t2.end_time > now() and t1.store_id = $store_id ";
        $sql .= "inner join ims_yzhyk_sun_storegoods t3 on t3.store_id = t1.store_id and t3.goods_id = t2.goods_id ";

        $order_sql = " order by t1.is_hot desc,t1.id desc ";
        $list = pdo_fetchall($sql.$order_sql.$limt_sql);

        echo json_encode($list);
    }
    public function doPageGetGroupGoods(){
        global $_W, $_GPC;
        $store_id = $_GPC['store_id'];
        $goods_id = $_GPC['goods_id'];

        $sql = "";
        $sql .= "select t1.*,t2.shopprice from ims_yzhyk_sun_groupgoods t1 ";
        $sql .= "inner join ims_yzhyk_sun_goods t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.id = $goods_id ";

        $list = pdo_fetchall($sql);

        $data  = $list[0];
        $data['content'] = htmlspecialchars_decode($data['content']);
        $data['end_time'] = strtotime($data['end_time'])*1000;

        $sql = "";
        $sql .= "select t2.name as uname,t2.img as uthumb,t1.end_time * 1000 as end_time,t4.num - t1.num as num,t1.id ";
        $sql .= "from ims_yzhyk_sun_group t1 ";
        $sql .= "inner join ims_yzhyk_sun_user t2 on t2.id = t1.user_id ";
        $sql .= "inner join ims_yzhyk_sun_storegroupgoods t3 on t3.id = t1.storegroupgoods_id and t3.store_id = $store_id and t3.groupgoods_id = $goods_id ";
        $sql .= "inner join ims_yzhyk_sun_groupgoods t4 on t4.id = t3.groupgoods_id ";
        $sql .= "where t1.state = 0 ";

        $list = pdo_fetchall($sql);
        echo json_encode(['info'=>$data,'list'=>$list]);

    }
    public function doPageGetGroup(){
        global $_W, $_GPC;
        $group_id = $_GPC['group_id'];
        $user_id = $_GPC['user_id'];

        $sql = "";
        $sql .= "select t2.pic as img,t2.title,t2.price,t3.shopprice as oldprice,t1.num,t2.num as userNum,t2.id ";
        $sql .= "from ims_yzhyk_sun_group t1 ";
        $sql .= "inner join ims_yzhyk_sun_groupgoods t2 on t2.id = t1.groupgoods_id and t1.id = $group_id ";
        $sql .= "inner join ims_yzhyk_sun_goods t3 on t3.id = t2.goods_id ";
        $list = pdo_fetchall($sql);
        $data  = $list[0];
        $data['status'] = 2;

        $sql = "";
        $sql .= "select t2.img,t2.id ";
        $sql .= "from ims_yzhyk_sun_group t1 ";
        $sql .= "inner join ims_yzhyk_sun_user t2 on t2.id = t1.user_id and t1.id = $group_id ";
        $list = pdo_fetchall($sql);
        $user = [];
        $userid = [];
        $user[] = $list[0]['img'];
        $userid[] = $list[0]['id'];

        $sql = "";
        $sql .= "select t2.img ";
        $sql .= "from ims_yzhyk_sun_groupuser t1 ";
        $sql .= "inner join ims_yzhyk_sun_user t2 on t2.id = t1.user_id and t1.group_id = $group_id ";
        $list = pdo_fetchall($sql);
        foreach ($list as $item) {
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
        $data['time']= time();
        $data['order_number'] = date('Ymd').time().rand(1000,9999);
        $data['state'] = 10;
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['uniacid'] = $uniacid;
        // 订单商品信息
        $goodses = json_decode(htmlspecialchars_decode($_GPC['goodses']));
        foreach ($goodses as $goods) {
            $data['goods_id'] = $goods->id;
            $data['goods_name'] = $goods->title;
            $data['goods_price'] = $goods->price;
            $data['goods_img'] = $goods->src;
            $data['num'] = $goods->num;
            break;
        }

        // // 拼团id
        $group_id = $_GPC['group_id'];
        // // 判断是参团还是开团
        // if($group_id && $group_id != "undefined"){
        //     $data['group_id'] = $group_id;
        //     $res=pdo_insert('yzhyk_sun_grouporder',$data);
        //     $orderid = pdo_insertid();
        //     $data2['group_id'] = $group_id;
        //     $data2['user_id'] = $data['user_id'];
        //     $data2['state'] = 0;
        //     $data2['uniacid'] = $data['uniacid'];
        //     $res=pdo_insert('yzhyk_sun_groupuser',$data2);

        //     $res = pdo_query("update ims_yzhyk_sun_group set num = num+1 where id = $group_id");
        //     $groupgoods = pdo_get("yzhyk_sun_groupgoods",array('id'=>$data['goods_id']));
        //     $group = pdo_get("yzhyk_sun_group",array('id'=>$group_id));
        //     if($groupgoods['num'] == $group['num']){
        //         $res = pdo_query("update ims_yzhyk_sun_group set state = 1 where id = $group_id");
        //         $orders = pdo_fetchall("select * from ims_yzhyk_sun_grouporder where group_id = $group_id");
        //         foreach ($orders as $order) {
        //             $data_goods['goods_id'] = $order['goods_id'];
        //             $data_goods['goods_name'] = $order['goods_name'];
        //             $data_goods['goods_price'] = $order['goods_price'];
        //             $data_goods['goods_img'] = $order['goods_img'];
        //             $data_goods['num'] = $order['num'];
        //             $data_goods['uniacid'] = $order['uniacid'];

        //             unset($order['goods_id']);
        //             unset($order['goods_name']);
        //             unset($order['goods_price']);
        //             unset($order['goods_img']);
        //             unset($order['num']);
        //             unset($order['group_id']);
        //             unset($order['id']);
        //             $order['state'] = 20;
        //             pdo_insert("yzhyk_sun_order",$order);

        //             $data_goods['order_id'] = pdo_insertid();
        //             pdo_insert("yzhyk_sun_ordergoods",$data_goods);
        //         }
        //     }
        // }else{
        //     $data2['user_id'] = $data["user_id"];
        //     $data2['uniacid'] = $data['uniacid'];
        //     $data2['num'] = 1;
        //     $data2['state'] = 0;
        //     $data2['groupgoods_id'] = $data["goods_id"];

        //     $storegroupgoods = pdo_get('yzhyk_sun_storegroupgoods',array('store_id'=>$data['store_id'],'groupgoods_id'=>$data['goods_id']));
        //     $data2['storegroupgoods_id'] = $storegroupgoods['id'];
        //     // 设置开团有效期
        //     $groupgoods = pdo_get('yzhyk_sun_groupgoods',array('id'=>$storegroupgoods['groupgoods_id']));
        //     $data2['end_time'] = strtotime($groupgoods['end_time']);
        //     $time = time() + $groupgoods['useful_hour']*3600;
        //     if ($groupgoods['useful_hour'] && $data2['end_time']>$time) {
        //         $data2['end_time']=$time;
        //     }
            
        //     $res=pdo_insert('yzhyk_sun_group',$data2);
        //     $group_id = pdo_insertid();
            $data['group_id'] = $group_id;
            $res=pdo_insert('yzhyk_sun_grouporder',$data);
            $orderid = pdo_insertid();
        // }

        echo json_encode(['code'=>0,'id'=>$orderid]);//,'group_id'=>$group_id]);
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
        $sql .= "from ims_yzhyk_sun_grouporder t1 ";
        $sql .= "left join ims_yzhyk_sun_groupgoods t2 on t2.id = t1.goods_id ";
        $sql .= "left join ims_yzhyk_sun_goods t3 on t3.id = t2.goods_id ";
        $sql .= "left join ims_yzhyk_sun_group t4 on t4.id = t1.group_id ";
        $sql .= "where t1.user_id = $user_id and t1.uniacid = $uniacid and t4.state = $state and t1.state <> -10 ";
        $sql .= "order by t1.time desc ";

        $list = pdo_fetchall($sql.$limt_sql);
        echo json_encode($list);
    }
    //    拼团订单-支付
    public function doPagePayGroupOrder(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $data['state'] = 20;
        $data['pay_type']=$_GPC['pay_type'];
        $data['pay_time']=time();

        $user_id=$_GPC['user_id'];
        $user =pdo_get('yzhyk_sun_user',array('id'=>$user_id));

        if($data['pay_type'] == "余额"){
            $pay_amount = $_GPC['pay_amount'];
            if($user['balance'] < $pay_amount){
                echo json_encode(["code"=>1,"msg"=>"余额不足"]);
                exit();
            }else{
                $data2['balance']=$user['balance'] - $pay_amount;
                $res = pdo_update('yzhyk_sun_user', $data2, array('id' =>$user_id));

                //余额账单
                $data4['user_id'] = $data['user_id'];
                $data4['content'] = "拼团订单";
                $data4['balance'] = $_GPC['pay_amount'];
                $data4['time'] = $data['time'];
                $data4['type'] = 3;
                $data4['uniacid'] = $uniacid;
                $res=pdo_insert('yzhyk_sun_bill',$data4);
            }
        }
        $ret=pdo_update('yzhyk_sun_grouporder',$data,array('id'=>$_GPC['id']));

        // 根据参团或者开团做不同逻辑
        $grouporder = pdo_get('yzhyk_sun_grouporder',array('id'=>$_GPC['id']));
        // 拼团id
        $group_id = $grouporder['group_id'];
        // 判断不是团长
        if($group_id){
            $orderid = $_GPC['id'];
            $data3['group_id'] = $group_id;
            $data3['user_id'] = $user_id;
            $data3['state'] = 0;
            $data3['uniacid'] = $uniacid;
            $res=pdo_insert('yzhyk_sun_groupuser',$data3);

            $res = pdo_query("update ims_yzhyk_sun_group set num = num+1 where id = $group_id");
            $groupgoods = pdo_get("yzhyk_sun_groupgoods",array('id'=>$grouporder['goods_id']));
            $group = pdo_get('yzhyk_sun_group',array('id'=>$group_id));
            if($groupgoods['num'] == $group['num']){
                $res = pdo_query("update ims_yzhyk_sun_group set state = 1 where id = $group_id");
                $orders = pdo_fetchall("select * from ims_yzhyk_sun_grouporder where group_id = $group_id");
                foreach ($orders as $order) {
                    $data_goods['goods_id'] = $order['goods_id'];
                    $data_goods['goods_name'] = $order['goods_name'];
                    $data_goods['goods_price'] = $order['goods_price'];
                    $data_goods['goods_img'] = $order['goods_img'];
                    $data_goods['num'] = $order['num'];
                    $data_goods['uniacid'] = $order['uniacid'];

                    unset($order['goods_id']);
                    unset($order['goods_name']);
                    unset($order['goods_price']);
                    unset($order['goods_img']);
                    unset($order['num']);
                    unset($order['group_id']);
                    unset($order['id']);
                    $order['state'] = 20;
                    $order['order_type'] = 2;
                    pdo_insert("yzhyk_sun_order",$order);

                    $data_goods['order_id'] = pdo_insertid();
                    pdo_insert("yzhyk_sun_ordergoods",$data_goods);
                }
            }
        }else{
            $data3['user_id'] = $user_id;
            $data3['uniacid'] = $uniacid;
            $data3['num'] = 1;
            $data3['state'] = 0;
            $data3['groupgoods_id'] = $grouporder["goods_id"];

            $storegroupgoods = pdo_get('yzhyk_sun_storegroupgoods',array('store_id'=>$grouporder['store_id'],'groupgoods_id'=>$grouporder['goods_id']));
            $data3['storegroupgoods_id'] = $storegroupgoods['id'];
            // 设置开团有效期
            $groupgoods = pdo_get('yzhyk_sun_groupgoods',array('id'=>$storegroupgoods['groupgoods_id']));
            $data3['end_time'] = strtotime($groupgoods['end_time']);
            $time = time() + $groupgoods['useful_hour']*3600;
            if ($groupgoods['useful_hour'] && $data3['end_time']>$time) {
                $data3['end_time']=$time;
            }
            $res=pdo_insert('yzhyk_sun_group',$data3);
            $group_id = pdo_insertid();
            $res = pdo_update('yzhyk_sun_grouporder',array('group_id',$group_id),array('id'=>$_GPC['id']));
        }

        $setting = pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
        $i = $setting['integral1'];

        $data3['user_id'] = $data['user_id'];
        $data3['content'] = "拼团订单";
        $data3['integral'] = floor($_GPC['pay_amount']/$i);
        $data3['time'] = $data['time'];
        $data3['type'] = 3;
        $data3['uniacid'] = $uniacid;
        $res=pdo_insert('yzhyk_sun_integral',$data3);
        $res = pdo_update('yzhyk_sun_user', ["integral"=>$user['integral']+$data3['integral']], array('id' =>$user_id));
        $this->updateUserAmountLevel($user_id);

        $opt = [
            'user_id'=>$user_id,
            'goods_name'=>$data3['content'],
            'amount'=>$data['amount'],
            'num'=>'1',
            'time'=>$data['time'],
            'address'=>"拼团订单",
            'page'=>'',
        ];
        $this->sendTemplateMsg($opt);

        echo json_encode(['group_id'=>$group_id]);
    }

    public function doPageCancelGroupOrder(){
        global $_W, $_GPC;
        $data['state'] = 50;
        $order = pdo_get('yzhyk_sun_grouporder',array('id'=>$_GPC['id']));
        $user_id = $order['user_id'];
        $group_id = $order['group_id'];
        $group = pdo_get('yzhyk_sun_group',array('id'=>$group_id));
        // 判断是否团长
        if ($group['user_id'] != $user_id) {
            pdo_query('update ims_yzhyk_sun_group set num = num -1 where id = '.$group_id);
            pdo_query('update ims_yzhyk_sun_groupuser set state = -1 where group_id = '.$group_id.' and user_id = '.$user_id);
            $ret=pdo_update('yzhyk_sun_grouporder',$data,array('id'=>$_GPC['id']));
            echo json_encode(['code'=>0,'group_id'=>$group_id,'r1'=>$ret1,'r2'=>$ret2]);exit;
        }else{
            $ret1= pdo_query('update ims_yzhyk_sun_group set state = -1 where id = '.$group_id);
            $ret2=pdo_query('update ims_yzhyk_sun_groupuser set state = -1 where group_id = '.$group_id);
            $ret = pdo_update('yzhyk_sun_grouporder',$data,array('group_id'=>$group_id));
            echo json_encode(['code'=>0,'group_id'=>$group_id,'r1'=>$ret1,'r2'=>$ret2]);exit;
        }
        if($ret){
            echo json_encode(['code'=>0]);
        }else{
            echo json_encode(['code'=>1,'msg'=>"取消失败"]);
        }
    }
    // 取消拼团订单
    public function cancelGroupOrder($id=0){

    }
    public function doPageDeleteGroupOrder(){
        global $_W, $_GPC;
        $data['state'] = -10;
        $ret=pdo_update('yzhyk_sun_grouporder',$data,array('id'=>$_GPC['id']));
        if($ret){
            echo json_encode(['code'=>0]);
        }else{
            echo json_encode(['code'=>1,'msg'=>"删除失败"]);
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
        $sql .= "from ims_yzhyk_sun_storecutgoods t1 ";
        $sql .= "inner join ims_yzhyk_sun_cutgoods t2 on t2.id = t1.cutgoods_id and t2.begin_time < NOW() and t2.end_time > now() and t1.store_id = $store_id ";
        $sql .= "inner join ims_yzhyk_sun_storegoods t3 on t3.store_id = t1.store_id and t3.goods_id = t2.goods_id ";

        $order_sql = " order by t1.is_hot desc,t1.id desc ";
        $list = pdo_fetchall($sql.$order_sql.$limt_sql);
        foreach ($list as &$item) {
            $item['endtime'] = strtotime($item['endtime']) * 1000;

            $sql = "";
            $sql .= "select t2.img from ims_yzhyk_sun_cut t1 ";
            $sql .= "inner join ims_yzhyk_sun_user t2 on t2.id = t1.user_id and t1.storecutgoods_id = {$item['id']} ";
            $sql .= "order by t1.end_time desc ";
            $sql .= "limit 5 ";
            
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
        $sql .= "from ims_yzhyk_sun_cut t1 ";
        $sql .= "left join ims_yzhyk_sun_cutgoods t2 on t2.id = t1.cutgoods_id ";
        $sql .= "left join ims_yzhyk_sun_goods t3 on t3.id = t2.goods_id ";
        $sql .= "where t1.state = $state and t1.user_id = $user_id ";

        $list = pdo_fetchall($sql.$order_sql.$limt_sql);

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
            echo json_encode(array('code'=>1,'msg'=>'当前门店没有该商品'));
            exit();
        }
        $user_id = $_GPC['user_id'];
        $goods_id = $storecutgoods['cutgoods_id'];

        $sql = "";
        $sql .= "select t1.*,t2.shopprice from ims_yzhyk_sun_cutgoods t1 ";
        $sql .= "inner join ims_yzhyk_sun_goods t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.id = $goods_id ";

        $list = pdo_fetchall($sql);

        $data  = $list[0];
        $data['content'] = htmlspecialchars_decode($data['content']);
        $data['endtime'] = strtotime($data['end_time'])*1000;

        $sql = "";
        $sql .= "select t4.img,t3.cut_price,t1.id as cut_id ";
        $sql .= "from ims_yzhyk_sun_cut t1 ";
        $sql .= "inner join ims_yzhyk_sun_storecutgoods t2 on t2.id = t1.storecutgoods_id and t2.id = $storecutgoods_id and t1.user_id = $user_id ";
        $sql .= "left join ims_yzhyk_sun_cutuser t3 on t3.cut_id = t1.id ";
        $sql .= "inner join ims_yzhyk_sun_user t4 on t4.id = t3.user_id ";

        $list = pdo_fetchall($sql);

        $cut = pdo_get('yzhyk_sun_cut',array('id'=>$list[0]['cut_id'],'user_id'=>$user_id));

        echo json_encode(array('code'=>0,'info'=>$data,'list'=>$list,'cut_info'=>$cut));
    }

    public function doPageAddCut(){
        global $_W, $_GPC;
        $user_id = $_GPC['user_id'];

        $storecutgoods_id = $_GPC['storecutgoods_id'];
        $storecutgoods = pdo_get('yzhyk_sun_storecutgoods',array('id'=>$storecutgoods_id));

        $goods_id = $storecutgoods['cutgoods_id'];

        $cutgoods = pdo_get('yzhyk_sun_cutgoods',array('id'=>$goods_id));
        $goods = pdo_get('yzhyk_sun_goods',array('id'=>$cutgoods['goods_id']));

        $data['user_id'] = $user_id;
        $data['storecutgoods_id'] = $storecutgoods_id;
        $data['end_time'] = $cutgoods['end_time'];
        $data['uniacid'] = $cutgoods['uniacid'];
        $data['num'] = $cutgoods['num'];
        $data['state'] = 0;
        $data['cutgoods_id'] = $goods_id;
        $data['price'] = $cutgoods['price'];
        $data['shop_price'] = $goods['shopprice'];
        $data['cut_price'] = 0;
        $data['cut_num'] = 0;

        pdo_insert('yzhyk_sun_cut',$data);
        $cut_id = pdo_insertid();

        $data2['cut_id'] = $cut_id;
        $data2['user_id'] = $data['user_id'];
        $data2['uniacid'] = $data['uniacid'];
        $data2['time'] = time();
        $data2['cut_price'] = $this->getRandMoney($data['shop_price']-$data['price'],$data['num']);

        pdo_insert('yzhyk_sun_cutuser',$data2);

        pdo_query("update ims_yzhyk_sun_cut set cut_price = cut_price + {$data2['cut_price']},cut_num = cut_num + 1 where id = $cut_id");

        echo json_encode(['cut_id'=>$cut_id,'cut_price'=>$data2['cut_price']]);
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
        $sql .= "select t1.*,t2.shopprice from ims_yzhyk_sun_cutgoods t1 ";
        $sql .= "inner join ims_yzhyk_sun_goods t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.id = $goods_id ";
        $list = pdo_fetchall($sql);
        $data  = $list[0];
        $data['content'] = htmlspecialchars_decode($data['content']);
        $data['endtime'] = strtotime($data['end_time'])*1000;

        $sql = "";
        $sql .= "select t4.img,t3.cut_price,t1.id as cut_id ";
        $sql .= "from ims_yzhyk_sun_cut t1 ";
        $sql .= "inner join ims_yzhyk_sun_storecutgoods t2 on t2.id = t1.storecutgoods_id and t2.store_id = $store_id and t1.cutgoods_id = $goods_id  and t1.id = $cut_id ";
        $sql .= "left join ims_yzhyk_sun_cutuser t3 on t3.cut_id = t1.id ";
        $sql .= "inner join ims_yzhyk_sun_user t4 on t4.id = t3.user_id ";
        $list = pdo_fetchall($sql);

        $cut_user = pdo_get('yzhyk_sun_cutuser',array('cut_id'=>$cut_id,'user_id'=>$user_id));

        echo json_encode(['info'=>$data,'list'=>$list,'cut_info'=>$cut,'cut_price'=>$cut_user?$cut_user['cut_price']:0]);
    }

    public function doPageHelpCut(){
        global $_W, $_GPC;
        $cut_id = $_GPC['cut_id'];
        $user_id = $_GPC['user_id'];

        $cut_user = pdo_get('yzhyk_sun_cutuser',array('cut_id'=>$cut_id,'user_id'=>$user_id));
        if ($cut_user) {
            echo json_encode(['code'=>1,'msg'=>'您已经帮该好友砍过价了']);
            exit();
        }

        $cut = pdo_get('yzhyk_sun_cut',array('id'=>$cut_id));

        $money = $this->getRandMoney($cut['shop_price'] - $cut['cut_price'] - $cut['price'], $cut['num'] - $cut['cut_num']);

        $data2['cut_id'] = $cut_id;
        $data2['user_id'] = $user_id;
        $data2['uniacid'] = $cut['uniacid'];
        $data2['time'] = time();
        $data2['cut_price'] = $money;

        pdo_insert('yzhyk_sun_cutuser',$data2);

        pdo_query("update ims_yzhyk_sun_cut set cut_price = cut_price + {$data2['cut_price']},cut_num = cut_num + 1 where id = $cut_id");

        echo json_encode(['code'=>0,'price'=>$money]);
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
            echo json_encode(['code'=>1,'msg'=>"删除失败"]);
        }
    }
    public function doPageAddCutOrder(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

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
        $data['time']= time();
        $data['order_number'] = date('Ymd').time().rand(1000,9999);
        $data['state'] = 10;
        $data['coupon_id']=$_GPC['coupon_id'];
        $data['uniacid'] = $uniacid;
        $data['order_type'] = 3;

        $res=pdo_insert('yzhyk_sun_order',$data);
        $order_id = pdo_insertid();

        $goodses = json_decode(htmlspecialchars_decode($_GPC['goodses']));
        foreach ($goodses as $goods) {
            $new_goods = [];
            $new_goods['order_id'] = $order_id;
            $new_goods['goods_id'] = $goods->id;
            $new_goods['goods_name'] = $goods->title;
            $new_goods['goods_price'] = $goods->price;
            $new_goods['goods_img'] = $goods->src;
            $new_goods['num'] = $goods->num;
            $new_goods['uniacid'] = $uniacid;
            pdo_insert('yzhyk_sun_ordergoods',$new_goods);
        }

        $cut_id = $_GPC['cut_id'];
        pdo_update('yzhyk_sun_cut',array('state'=>1),array('id'=>$cut_id));

        echo json_encode(['code'=>0,'id'=>$order_id]);
    }
}