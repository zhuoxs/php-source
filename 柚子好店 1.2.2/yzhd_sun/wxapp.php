<?php

/**

 * 柚子好店小程序模块小程序接口定义

 *

 * @author 厦门梵挚慧

 * @url
 */

defined('IN_IA') or exit('Access Denied');



class Yzhd_sunModuleWxapp extends WeModuleWxapp {
    /************************************************首页*****************************************************/
    //获取openid
    public function doPageOpenid(){
        global $_W, $_GPC;
        $res=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
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
        return $re;
    }

    //登录用户信息
    public function doPageLogin(){
        global $_GPC, $_W;
        $openid=$_GPC['openid'];
        $res=pdo_get('yzhd_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
        pdo_update('yzhd_sun_user',array('look_time'=>time()),array('openid'=>$_GPC['openid'],'uniacid'=>$_W['uniacid']));
        if($openid and $openid!='undefined'){
            if($res){
                $user_id=$res['id'];
                $data['openid']=$_GPC['openid'];
                $data['img']=$_GPC['img'];
                $data['name']=$_GPC['name'];
                $res = pdo_update('yzhd_sun_user', $data, array('id' =>$user_id));
                $user=pdo_get('yzhd_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
//                $user['vip_time'] = date('Y-m-d',$user['vip_expire_time']);
                echo json_encode($user);
            }else{
                $data['openid']=$_GPC['openid'];
                $data['img']=$_GPC['img'];
                $data['name']=$_GPC['name'];
                $data['uniacid']=$_W['uniacid'];
                $data['time']=time();
                $res2=pdo_insert('yzhd_sun_user',$data);
                $user=pdo_get('yzhd_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
                $comment_count = pdo_count('yzhd_sun_comment', array('openid' => $openid));
                $coupon_count  = pdo_count('yzhd_sun_user_coupon', array('uid' => $user_info['id']));
                $reservations_count = pdo_count('yzhd_sun_reservations', array('openid' => $openid));
                $comments = pdo_getall('yzhd_sun_comment', array('user_id' => $user_info['id']));
                $coupons = pdo_getall('yzhd_sun_user_coupon', array('uid' => $user_info['uid']));
                $reservations = pdo_getall('yzhd_sun_reservations', array('openid' => $openid));
                $user['comment']['count'] = $comment_count;
                $user['comment']['list'] = $comments;
                $user['coupon']['count'] = $coupon_count;
                $user['coupon']['list'] = $coupons;
                $user['reservations']['count'] = $reservations_count;
                $user['reservations']['list'] = $reservations;
//                $user['vip_time'] = date('Y-m-d',$user['vip_expire_time']);

                echo json_encode($user);
            }
        }
    }

    /*
         * 获取微信支付的数据
         *
         */
    private function _callWXPay($data) {
        global $_GPC,$_W;
        $openid = $data['openid'];
        $appData = pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
        $appid = $appData['appid'];
        $mch_id = $appData['mchid'];
        $keys = $appData['wxkey'];
        $price = $data['money'];
        $order_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $pay_data = array(
            'appid' => $appid,
            'mch_id' => $mch_id,
            'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',//
            //'sign' => '',
            'body' => time(),
            'out_trade_no' => $data['out_trade_no'].rand(1000, 9999),
            'total_fee' => $price * 100,
            //'total_fee' => 1,
            'spbill_create_ip' => '118.24.155.149',
            'notify_url' => 'http://www.51beiyong.com/addons/wnjz_sun/notify.php',
            'trade_type' => 'JSAPI',
            'openid' => $openid
        );
        ksort($pay_data, SORT_ASC);
        #$stringA = http_build_query($pay_data);
        $stringA = '';
        foreach ($pay_data as $key => $val) {
            $stringA .= "&{$key}={$val}";
        }
        $stringA = ltrim($stringA, '&');
        $signTempStr = $stringA . '&key='.$keys;
        $signValue = strtoupper(md5($signTempStr));
        $pay_data['sign'] = $signValue;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $order_url);//如果不传这样进行设置
        curl_setopt($ch, CURLOPT_HEADER, 0);//header就是返回header头相关信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置数据是直接输出还是返回
        curl_setopt($ch, CURLOPT_POST, 1);//设置为post模式提交 跟 form表单的提交是一样
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->arrayToXml($pay_data));//设置提交数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//设置ssl不验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//设置ssl不验证
        $result = curl_exec($ch);//执行请求 就等于html表单的 input:submit 如果没有设置 returntransfer 那么 是不会有返回值的 会直接输出
        curl_close($ch);//关闭
        $result = xml2array($result);
//        return $this->result(0,'',$result);
        $this->_returnData(0, 'ok', $this->_createPaySign($result));

    }
    public function _createPaySign($result)
    {
        global $_W;
        $appData = pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
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

    //系统设置
    public function doPageSystem(){
        global $_W, $_GPC;
        $res=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
        if(strpos($res['platform_ad'],',')){
            $res['platform_ad']= explode(',',$res['platform_ad']);

        }else{
            $res['platform_ad']=array(
                0=>$res['platform_ad']
            );
        }
        echo json_encode($res);
    }


// 拼接图片路径
    public function doPageUrl(){
        global $_GPC, $_W;
        echo $_W['attachurl'];
    }
//url
    public function doPageUrl2(){
        global $_W, $_GPC;
        echo $_W['siteroot'];
    }

    // 验证登录数据是否正确
    public function doPageisLogin()
    {
        global $_GPC,$_W;
        $account = $_GPC['account'];
        $password = $_GPC['password'];
        $admin = pdo_get('yzhd_sun_business_account',array('uniacid'=>$_W['uniacid'],'account'=>$account,'password'=>$password));
        if($admin){
            $res['r'] = 1;
        }else{
            $data = pdo_get('yzhd_sun_servies',array('uniacid'=>$_W['uniacid'],'login'=>$account,'password'=>$password));
            if($data){
                $res['r'] = 2;
                $res['id'] = $data['sid'];
            }else{
                $res['r'] = 3;
            }
        }
        echo json_encode($res);
    }

    // 获取当前管理用户的数据
    public function doPageNowuser()
    {
        global $_W,$_GPC;
        $sid = $_GPC['sid'];
        $data = pdo_getall('yzhd_sun_kjorder',array('uniacid'=>$_W['uniacid'],'sid'=>$sid));
        $count = [];
        foreach ($data as $k=>$v){
            if(date('Y-m-d',time())==date('Y-m-d',$v['addtime'])){
                $count['today'][] = $v;
            }else{
                $count['all'][] = $v;
            }
        }
        $count['today'] = count($count['today']);
        $count['all'] = count($count['all'])+$count['today'];
        echo json_encode($count);
    }

    // 进行订单核销
    public function doPageIsUserorder()
    {
        global $_W,$_GPC;
        $order_num = $_GPC['orderNum'];
        // 已付款
        $data = pdo_get('yzhd_sun_kjorder',array('uniacid'=>$_W['uniacid'],'orderNum'=>$order_num,'status'=>3));
        if($data){
            $res = pdo_update('yzhd_sun_kjorder',array('status'=>5),array('uniacid'=>$_W['uniacid'],'orderNum'=>$order_num));
        }else{
            $res = 0;
        }

        echo json_encode($res);
    }

    // 获取待接待订单
    public function doPageReception()
    {
        global $_GPC,$_W;
        $sid = $_GPC['sid'];
        $sql = ' SELECT * FROM ' . tablename('yzhd_sun_kjorderlist') . ' ol ' . ' JOIN ' . tablename('yzhd_sun_kjorder') . ' o ' .' JOIN ' .tablename('yzhd_sun_goods') . ' g ' . ' ON ' . ' o.id=ol.order_id' . ' AND ' . ' ol.oid=g.gid' . ' WHERE ' . ' o.sid='. $sid . ' AND ' . ' o.uniacid=' . $_W['uniacid'] . ' AND ' . ' o.status=3';
        $data = pdo_fetchall($sql);
        echo json_encode($data);
    }

    // 获取待接待订单
    public function doPageCompleted()
    {
        global $_GPC,$_W;
        $sid = $_GPC['sid'];
        $sql = ' SELECT * FROM ' . tablename('yzhd_sun_kjorderlist') . ' ol ' . ' JOIN ' . tablename('yzhd_sun_kjorder') . ' o ' .' JOIN ' .tablename('yzhd_sun_goods') . ' g ' . ' ON ' . ' o.id=ol.order_id' . ' AND ' . ' ol.oid=g.gid' . ' WHERE ' . ' o.sid='. $sid . ' AND ' . ' o.uniacid=' . $_W['uniacid'] . ' AND ' . ' o.status=5';
        $data = pdo_fetchall($sql);
        echo json_encode($data);
    }

    // 获取分类数据
    public function doPagecategory()
    {
        global $_GPC,$_W;
        $data = pdo_getall('yzhd_sun_category',array('uniacid'=>$_W['uniacid']));
        echo json_encode($data);
    }

    // 获取分类的所有数据
    public function doPagecateData()
    {
        global $_W;
        $sql = ' SELECT * FROM ' . tablename('yzhd_sun_goods') . ' g ' . ' JOIN ' . tablename('yzhd_sun_category') . ' c' . ' ON ' . ' g.cid=c.cid' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'];
        $data = pdo_fetchall($sql);
        echo json_encode($data);
    }

    // 获取选中分类对应的数据
    public function doPageXzcate()
    {
        global $_W,$_GPC;
        $cid = $_GPC['cid'];
        if($cid==0){
            $sql = ' SELECT * FROM ' . tablename('yzhd_sun_goods') . ' g ' . ' JOIN ' . tablename('yzhd_sun_category') . ' c' . ' ON ' . ' g.cid=c.cid' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'];
        }else{
            $sql = ' SELECT * FROM ' . tablename('yzhd_sun_goods') . ' g ' . ' JOIN ' . tablename('yzhd_sun_category') . ' c' . ' ON ' . ' g.cid=c.cid' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'] . ' AND ' . ' g.cid='.$cid;
        }
        $data = pdo_fetchall($sql);
        echo json_encode($data);
    }

    // BEGIN
    public function doPageGetCarousel()
    {
        global $_W,$_GPC;

        $banner = pdo_getall('yzhd_sun_popbanner',array('uniacid'=>$_W['uniacid']));
        if (empty($banner)) {
            $this->_returnData(1, 'banner图为空', []);
        }
        $this->_returnData(0, 'ok', $banner);
    }

    public function doPageGetHomeFavourableStr()
    {
        global $_W,$_GPC;

        $system = pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));

        if (empty($system)) {
            $this->_returnData(1, '设置为空', []);
        }
        $data['f_activity'] = $system['f_activity'];
        $data['f_activity_logo'] = $system['f_activity_logo'];
        $data['e_favourable'] = $system['e_favourable'];
        $data['e_favourable_logo'] = $system['e_favourable_logo'];
        $data['e_num'] = $system['e_num'];
        $data['f_num'] = $system['f_num'];
        $this->_returnData(0, 'ok', $data);

    }

    public function doPageGetMenu()
    {
        global $_W, $_GPC;

        $menu = pdo_get('yzhd_sun_front_menu', array('uniacid' => $_W['uniacid']));
        if (!($menu['menu1_name'])&&!($menu['menu2_name'])&&!($menu['menu3_name'])&&!($menu['menu4_name'])) {
            $this->_returnData(1, '菜单为空', []);
        }
        $data['menu1']['name'] = $menu['menu1_name'];
        $data['menu2']['name'] = $menu['menu2_name'];
        $data['menu3']['name'] = $menu['menu3_name'];
        $data['menu4']['name'] = $menu['menu4_name'];
        $data['menu1']['logo'] = $menu['menu1_logo'];
        $data['menu2']['logo'] = $menu['menu2_logo'];
        $data['menu3']['logo'] = $menu['menu3_logo'];
        $data['menu4']['logo'] = $menu['menu4_logo'];
        $data['menu1']['logo'] = $menu['menu1_logo'];
        $data['menu1']['ck_logo'] = $menu['menu1_ck_logo'];
        $data['menu2']['ck_logo'] = $menu['menu2_ck_logo'];
        $data['menu3']['ck_logo'] = $menu['menu3_ck_logo'];
        $data['menu4']['ck_logo'] = $menu['menu4_ck_logo'];
        $this->_returnData(0, 'ok', $data);
    }


    public function doPageGetPersonCenterBg()
    {
        global $_W, $_GPC;

        $bg = pdo_get('yzhd_sun_person_center');
        if (empty($bg)) $this->_returnData(1, '背景图为空', []);
        $data['img'] = $bg['img'];
        $this->_returnData(0, 'ok', $data);
    }


    public function doPageGetBranch($is_return = false)
    {
        global $_W, $_GPC;

        $lng = $_GPC['lng'];
        $lat = $_GPC['lat'];

        if (empty($lng) || empty($lat)) $this->_returnData(1, '经纬度不能为空', []);
        $point = $this->_returnSquarePoint($lng, $lat);
        $right_bottom_lat = $point['right_bottom']['lat'];   //右下纬度
        $left_top_lat = $point['left_top']['lat'];           //左上纬度
        $left_top_lng = $point['left_top']['lng'];           //左上经度
        $right_bottom_lng = $point['right_bottom']['lng'];   //右下经度


        $sql = "SELECT * FROM `ims_yzhd_sun_branch` WHERE lat > $right_bottom_lat AND lat < $left_top_lat AND lng >$left_top_lng AND lng <$right_bottom_lng ORDER BY lat,lng ASC";
        $branchs = pdo_fetchall($sql);
        if (empty($branchs)) $this->_returnData(2, '您的周围没有商家', []);

        $distance_base_url = 'http://apis.map.qq.com/ws/distance/v1/?';
        $from = "from={$lat},{$lng}";
        $to = 'to=';
        foreach ($branchs as $key => $val) {
            $to .= "{$val['lat']},{$val['lng']};";
        }
        $to = rtrim($to, ';');
        $mode = 'mode=walking';

        $key = 'key=LLJBZ-B7ZKU-A2MVM-B7CKH-T2GW7-MNFON';

        $parameters = "{$from}&{$to}&{$mode}&{$key}";
        $url = $distance_base_url . $parameters;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $json_result = json_decode($result, true);
        $elements = $json_result['result']['elements'];
        if ($json_result['status'] == 0 && count($elements) == count($branchs)) {
            foreach ($elements as $ek => $ev) {
                foreach ($branchs as $bk => $bv) {
                    $branchs[$bk]['distance'] = round($ev['distance']);
                }
            }
        }
        if (! $is_return) {
            $this->_returnData(0, 'ok', $branchs);

        } else {
            return $branchs;
        }

    }

    public function doPageGetCoupons()
    {
        global $_W, $_GPC;
        $branch_id = intval($_GPC['bid']);
        $openid = $_GPC['openid'];
        $where = array('uniacid'=>$_W['uniacid'],'state'=>2,'del'=>0);
        if (empty($openid)) $this->_returnData(1, '用户错误');
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid));
        if (empty($user_info)) $this->_returnData(-1, '用户信息错误');
//        $user_get_coupons = pdo_getall('yzhd_sun_user_coupon', array('uid' => $user_info['id'],'uniacid'=>$_W['uniacid']));
        if ($branch_id) {
            $where = array('branch_id' => $branch_id,'uniacid'=>$_W['uniacid'],'state'=>2);
        }
        $coupons = pdo_getall('yzhd_sun_coupon', $where);

//        $user_coupon_ids = array();
//        if (! empty($user_get_coupons)) {
//            foreach ($user_get_coupons as $ck => $vk) {
//                $user_coupon_ids[] = $vk['cid'];
//            }
//        }
        foreach ($coupons as $key => $val) {
//            if (in_array($val['id'], $user_coupon_ids)) {
//                unset($coupons[$key]);
//                continue;
//            }
            $coupons[$key]['logo'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$val['branch_id']),'logo');
            $coupons[$key]['sname'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$val['branch_id']),'name');
            if ($val['expire_time'] < time()) unset($coupons[$key]);
        }
//        foreach ($coupons as $k=>$v){

//            foreach ($user_get_coupons as $kk=>$vv){
//                if($coupons[$k]['id']==$user_get_coupons[$kk]['cid']) unset( $coupons[$k]);
//            }
//        }

        if (empty($coupons)) $this->_returnData(2, '没有优惠券', []);
        $this->_returnData(0, 'ok', $coupons);die;



    }

    public function doPageGetCouponDetail()
    {
        global $_W, $_GPC;

        $coupon_id = $_GPC['cid'];

        if (empty($coupon_id)) $this->_returnData(1, '优惠券错误', []);

        $coupon_info = pdo_get('yzhd_sun_coupon', array('id' => $coupon_id));
        $coupon_info['store_name'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$coupon_info['branch_id']),'name');
        $coupon_info['logo'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$coupon_info['branch_id']),'logo');

//        if ($coupon_info['expire_time'] < time()) $coupon_info = null;

        if (empty($coupon_info)) $this->_returnData(2, '优惠券不存在', []);

        $this->_returnData(0, 'ok', $coupon_info);

    }

    /**
     * 购买商品使用优惠券
     */
    //查询可使用的优惠券
    public function doPageGetMyCoupons(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $bid = $_GPC['bid'];
        $price = $_GPC['price']-0;

        if(!$openid){
            return $this->result(1,'用户信息错误！','');
        }
        $branch = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$bid,'stutes'=>1));
        if(!$branch){
            return $this->result(1,'店铺信息错误！','');
        }
        $sql = ' SELECT a.cid,a.uniacid,a.openid,a.xl_frequency as new_xl_frequency,a.use_num,b.* FROM ' . tablename('yzhd_sun_user_coupon') . ' a ' . ' JOIN ' . tablename('yzhd_sun_coupon') . ' b ' . ' ON ' . ' a.cid=b.id ' . ' WHERE ' . ' a.uniacid= ' . $_W['uniacid'] . ' AND ' . ' a.openid= ' . "'$openid'" . ' AND ' . ' b.branch_id=' . $branch['id'] . ' AND ' . ' a.del=0';
        $user_coupon = pdo_fetchall($sql);
        foreach ($user_coupon as $k=>$v){
            if($user_coupon[$k]['type']==1){
                if($v['xl_frequency']!=0){
                    if($v['price']>$price || $v['new_xl_frequency'] <= $v['use_num']){
                        unset($user_coupon[$k]);
                    }
                }else{
                    if($v['price']>$price){
                        unset($user_coupon[$k]);
                    }
                }

            }
            if($user_coupon[$k]['type']==2 ){
                if($v['xl_frequency']!=0){
                    if($v['money']>$price || $v['new_xl_frequency'] <= $v['use_num']){
                        unset($user_coupon[$k]);
                    }
                }else{
                    if($v['money']>$price){
                        unset($user_coupon[$k]);
                    }
                }

            }
        }
        return $this->result(0,'',$user_coupon);

    }
    //查询我所有的优惠券
    public function doPageGetMyAllCoupon(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $currentType = $_GPC['currentStatuss'];
        $uniacid = $_W['uniacid'];
        if($currentType==1){
            $condition = ' and b.expire_time>unix_timestamp(NOW()) ';
        }elseif($currentType==2){
            $condition = ' and b.expire_time<unix_timestamp(NOW()) ';
        }
        $sql = 'select b.name,b.id,b.desc,b.branch_id,a.qrcode,b.expire_time from ' . tablename('yzhd_sun_user_coupon') . ' a left join ' . tablename('yzhd_sun_coupon') . ' b  on a.cid=b.id' ." where a.uniacid=$uniacid and a.openid='$openid'" . ' and a.del!=1' . $condition . ' order by b.expire_time DESC';
        $data = pdo_fetchall($sql);
        foreach ($data as $k=>$v){
            $data[$k]['branch_name'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['branch_id']),'name');
            $data[$k]['logo'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['branch_id']),'logo');
            if($data[$k]['expire_time']>time()){
                $data[$k]['is_timeover'] = 0;
            }else{
                $data[$k]['is_timeover'] = 1;
            }
        }
        echo json_encode($data);
    }

    //删除我的优惠券
    public function doPageDelMyCoupon(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $openid = $_GPC['openid'];
        $res = pdo_update('yzhd_sun_user_coupon',array('del'=>1),array('uniacid'=>$_W['uniacid'],'cid'=>$id,'openid'=>$openid));
        echo $res;
    }
    //删除我的订单
    public function doPageDeleteOrder(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $res = pdo_update('yzhd_sun_order',array('del'=>1),array('id'=>$id));
        echo $res;
    }
    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }

        return $obj;
    }
    public function doPageGetGoodsDetail()
    {
        global $_W, $_GPC;
        $buy_type = intval($_GPC['buyType']);
        $goods_id = $_GPC['gid'];
        if($buy_type==2 || $buy_type=='2'){
            if (empty($goods_id)) $this->_returnData(1, '套餐错误', []);
            $goods_info = pdo_get('yzhd_sun_goods_meal', array('state' => 2,'id' => $goods_id,'uniacid'=>$_W['uniacid']));
            if (empty($goods_info)) $this->_returnData(2, '套餐不存在', []);

        }elseif($buy_type==3 || $buy_type=='3'){
            if (empty($goods_id)) $this->_returnData(1, '商品错误', []);
            $goods_info = pdo_get('yzhd_sun_caipin',array('uniacid'=>$_W['uniacid'],'cid'=>$goods_id));
            $goods_info['id'] = $goods_info['cid'];
            if (empty($goods_info)) $this->_returnData(2, '商品不存在', []);
        }else{
            if (empty($goods_id)) $this->_returnData(1, '商品错误', []);
            $goods_info = pdo_get('yzhd_sun_goods', array('state' => 2,'id' => $goods_id,'uniacid'=>$_W['uniacid']));
            if (empty($goods_info)) $this->_returnData(2, '商品不存在', []);

        }

        $this->_returnData(0, 'ok', $goods_info);
    }

    //下单判断库存
    public function doPageGetGoodsStock(){
        global $_GPC,$_W;
        $goods_id = $_GPC['gid'];
        $buy_type = $_GPC['buyType'];
        $num = intval($_GPC['num']);
        $openid = $_GPC['openid'];
        if($buy_type==2 || $buy_type=='2'){
            if (empty($goods_id)) $this->_returnData(1, '套餐错误', []);
            $goods_info = pdo_get('yzhd_sun_goods_meal', array('state' => 2,'id' => $goods_id,'uniacid'=>$_W['uniacid']));
            if (empty($goods_info)) $this->_returnData(2, '套餐不存在', []);
            if($goods_info['sp_num']<$num){
                return $this->result(1,'库存不足','');
            }
            if($goods_info['xg_num']!=0){
                $order = pdo_getall('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'type'=>3,'good_id'=>$goods_info['id'],'openid'=>$_GPC['openid']));
                $new_num = 0;
                foreach ($order as $k=>$v){
                    $new_num += $v['good_num'];
                }
                if($goods_info['xg_num'] < $num + $new_num){
                    return $this->result(1,'该商品总限购数量' . $goods_info['xg_num'],'');
                }
            }
        }elseif($buy_type==3 || $buy_type=='3'){
            if (empty($goods_id)) $this->_returnData(1, '商品错误', []);
            $goods_info = pdo_get('yzhd_sun_caipin',array('uniacid'=>$_W['uniacid'],'cid'=>$goods_id));
            $goods_info['id'] = $goods_info['cid'];
            if (empty($goods_info)) $this->_returnData(2, '商品不存在', []);
            if($goods_info['sp_num']<$num){
                return $this->result(1,'库存不足','');
            }
            if($goods_info['xg_num']!=0){
                $sql = 'select * from ' . tablename('yzhd_sun_order') . 'a where uniacid=' . $_W['uniacid'] . " and (a.type=0 or a.type=4) and a.openid='$openid'";
                $order = pdo_fetchall($sql);
                $new_array = array();
                foreach ($order as $k=>$v){
                    if(in_array($goods_info['id'],explode(',',$v['good_id']))){
                        $new_array[] = $v;
                    }
                }
                foreach ($new_array as $k=>$v){
                    $new_array[$k]['good_id']  =  explode(',',$v['good_id']);
                    $new_array[$k]['good_num']  =  explode(',',$v['good_num']);
                }
                $new_num = 0;
                foreach ($new_array as $k=>$v){
                    foreach ($v['good_id'] as $kk=>$vv){
                        foreach ($v['good_num'] as $kkk=>$vvv){
                            if($kk==$kkk){
                                if($goods_info['cid']==$vv){
                                    $new_num += $vvv;
                                }
                            }
                        }
                    }
                }
                if($goods_info['xg_num'] < $num + $new_num){//2<
                    return $this->result(1,'该商品总限购数量' . $goods_info['xg_num'],'');
                }
            }
        }else{
            if (empty($goods_id)) $this->_returnData(1, '商品错误', []);
            $goods_info = pdo_get('yzhd_sun_goods', array('state' => 2,'id' => $goods_id,'uniacid'=>$_W['uniacid']));
            $order = pdo_getall('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'type'=>1,'good_id'=>$goods_info['id'],'openid'=>$_GPC['openid']));
            $new_num = 0;
            if($order){
                foreach ($order as $k=>$v){
                    $new_num += $v['good_num'];
                }
            }

            if (empty($goods_info)) $this->_returnData(2, '商品不存在', []);
            if($goods_info['sp_num']<$num){
                return $this->result(1,'库存不足','');
            }
            if($goods_info['xg_num']!=0){
                if($goods_info['xg_num'] < $new_num + $num){
                    return $this->result(1,'该商品总限购数量' . $goods_info['xg_num'],'');
                }
            }
        }
        echo 123;
    }



    public function doPageUserGetCoupon()
    {
        global $_W, $_GPC;

        $openid = $_GPC['openid'];
        $coupon_id = $_GPC['cid'];

        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid,'uniacid'=>$_W['uniacid']));

        $vip_info = pdo_get('yzhd_sun_user_vipcard',array('uniacid'=>$_W['uniacid'],'uid'=>$openid,'status'=>0,'dq_time >='=>time()));

        if (empty($user_info)) $this->_returnData(1, '无效的用户', []);

        if (! $vip_info || $vip_info['dq_time'] < time()){
            return $this->result(1,'优惠券仅限购买粉丝卡用户领取！','');
        }
        $coupon_info = pdo_get('yzhd_sun_coupon', array('id' => $coupon_id));
        if ($coupon_info['start_time'] > time()) {
            $new_date = date('Y-m-d H:i:s',$coupon_info['start_time']);
            return $this->result(1,'该优惠券于' . $new_date . '之后可领取','');
        }
        if ($coupon_info['expire_time'] <= time()) $coupon_info = null;
        if (empty($coupon_info)) $this->_returnData(2, '无效的优惠券', []);
        if($coupon_info['sy_num']<=0){
            return $this->result(1,'优惠券被抢光啦~','');
        }

        $get_coupon_status = pdo_get('yzhd_sun_user_coupon', array('uid' => $user_info['id'], 'cid' => $coupon_id));
        //判断是否已经领取过优惠券。
        if(!$get_coupon_status){
            $user_coupon_data['xl_frequency'] = 1;
            $user_coupon_data['cid'] = $coupon_id;
            $user_coupon_data['uid'] = $user_info['id'];
            $user_coupon_data['get_time'] = time();
            $user_coupon_data['code'] = 'cp-' . md5(base64_encode(uniqid('youzi@#!$') . microtime())) . rand() . sha1(rand() . 'yanerwuxinxutuotuo,gouridefenhong,pianrenyitaoyouyitao12p3901278@#$$!@#!@%' . microtime());
            require 'phpqrcode/phpqrcode.php';
            $user_coupon_data['openid'] = $openid;
            $user_coupon_data['uniacid'] = $_W['uniacid'];
            $errorCorrectionLevel = 'L';    //容错级别
            $matrixPointSize = 5;           //生成图片大小
            //我们给每个用户动态的创建一个文件夹
            $user_path=IA_ROOT."/attachment/qrcode/";
            //判断该用户文件夹是否已经有这个文件夹
            if(!file_exists($user_path)) {
                mkdir($user_path);
            }
            //判断该用户文件夹是否已经有这个文件夹
            if(!file_exists($user_path)) {
                mkdir($user_path);
            }
            $filename = 'attachment/qrcode/'.md5(microtime()).'.png';

            $path = IA_ROOT . '/' . $filename;
            QRcode::png($user_coupon_data['code'],$path , $errorCorrectionLevel, $matrixPointSize, 2);
            $user_coupon_data['qrcode'] = ltrim($filename,'attachment/');
            @require_once (IA_ROOT . '/framework/function/file.func.php');
            @$filename=ltrim($filename,'attachment/');
            @file_remote_upload($filename);
            $res = pdo_insert('yzhd_sun_user_coupon', $user_coupon_data);
        }else{
            $user_coupon_data = pdo_get('yzhd_sun_user_coupon', array('uid' => $user_info['id'], 'cid' => $coupon_id));
            if($coupon_info['xl_frequency']!=0){
                if($get_coupon_status['xl_frequency']>=$coupon_info['xl_frequency']){
                    return $this->result(1,'该优惠券限领'.$coupon_info['xl_frequency'] . '张','');
                }
            }
            $res = pdo_update('yzhd_sun_user_coupon',array('xl_frequency +='=>1,'del'=>0,'get_time'=>time()),array('cid'=>$coupon_id,'uid'=>$user_info['id'],'openid'=>$openid,'uniacid'=>$_W['uniacid']));
        }
        if($res){
            pdo_update('yzhd_sun_coupon',array('sy_num -='=>1),array('uniacid'=>$_W['uniacid'],'id'=>$coupon_id));
        }

        $this->_returnData(0, 'ok', $user_coupon_data);
    }

    public function doPageGetUserInfo()
    {
        global $_W, $_GPC;

        $openid = $_GPC['openid'];

        if (empty($openid)) $this->_returnData(-1, '用户错误');

        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1,'uniacid'=>$_W['uniacid']));

        if (empty($user_info)) $this->_returnData(1, '该用户不存在', ['openid' => $openid]);
        $comment_count = pdo_count('yzhd_sun_comment', array('openid' => $openid));
        $coupon_count  = pdo_count('yzhd_sun_user_coupon', array('uid' => $user_info['id']));
        $reservations_count = pdo_count('yzhd_sun_reservations', array('openid' => $openid,'uniacid'=>$_W['uniacid']));
        $comments = pdo_getall('yzhd_sun_comment', array('user_id' => $user_info['id'],'uniacid'=>$_W['uniacid']));

        foreach ($comments as $ck => $cv) {
            $comments[$ck]['goods_info'] = pdo_get('yzhd_sun_order', array('out_trade_no' => $cv['order_id']));
        }
        $coupons = pdo_getall('yzhd_sun_user_coupon', array('uid' => $user_info['id'],'uniacid'=>$_W['uniacid']),'','','get_time DESC');
        foreach ($coupons as $cok => $cov) {
            $info = pdo_get('yzhd_sun_coupon', array('id' => $cov['cid']));
            $store = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$info['branch_id'],'stutes'=>1));
//            if ($info['expire_time'] < time()) continue;
            $coupons[$cok]['coupon_info'] = $info;
            $coupons[$cok]['store_name'] = $store['name'];
            $coupons[$cok]['logo'] = $store['logo'];
        }
        $reservations = pdo_getall('yzhd_sun_reservations', array('openid' => $openid));
        foreach ($reservations as $k => $v) {
            $reservations[$k]['branch_info'] = pdo_get('yzhd_sun_branch', array('id' => $v['branch_id']));
            $new_date = time($reservations[$k]['meals_date']);
            $reservations[$k]['meals_date'] = date('m月d日/H:i',$new_date);
        }
        $user_info['comment']['count'] = $comment_count;
        $user_info['comment']['list'] = $comments;
        $user_info['coupon']['count'] = $coupon_count;
        $user_info['coupon']['list'] = $coupons;
        $user_info['reservations']['count'] = $reservations_count;
        $user_info['reservations']['list'] = $reservations;
        $this->_returnData(0, '', $user_info);
    }


    public function doPageGetGoods()
    {
        global $_W, $_GPC;

        $branch_id = intval($_GPC['bid']);

        if (empty($branch_id)) $this->_returnData(1, '商家错误', []);

        $goods = pdo_getall('yzhd_sun_goods', array('branch_id' => $branch_id, 'state' => 2));
//		foreach ($goods as $key => $val) {
//			$goods[$key]['original_price'] = $goods[$key]['original_price'] ;
//			$goods[$key]['current_price'] = $goods[$key]['current_price'];
//			$goods[$key]['fans_price'] = $goods[$key]['fans_price'];
//		}

        if (empty($goods)) $this->_returnData(2, '该商家没有商品', []);

        $this->_returnData(0, 'ok', $goods);
    }

    //查询已经购买几件商品
//    public function doPageGetThisOrder(){
//        global $_GPC,$_W;
//        $gid = $_GPC['gid'];
//        $gnum = $_GPC['goods_num'];
//        $openid = $_GPC['openid'];
//        $buyType = $_GPC['buyType'];
//        $xg_num = $_GPC['xg_num'];
//        if($buyType==2){
//            $order = pdo_getall('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'good_id'=>$gid,'type'=>3),'good_num');
//            $new_num = 0;
//            foreach ($order as $k=>$v){
//                $new_num += $v['good_num'];
//            }
//            if($xg_num!=0){
//                if($xg_num < $gnum + $new_num){
//                    return $this->result(1,'该商品限购数量！');
//                }
//            }
//        }elseif($buyType==3||$buyType==4){
//            $gids = explode(',',rtrim($gid,','));
//            $gnums = explode(',',rtrim($gnum,','));
//            foreach ($gids as $k=>$v){
//                foreach ($gnums as $kk=>$vv){
//                    $order = pdo_getall('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'good_id'=>$gid,'type'=>1),'good_num');
//                    $new_num = 0;
//                    foreach ($order as $k=>$v){
//                        $new_num += $v['good_num'];
//                    }
//                    if($xg_num!=0){
//                        if($xg_num < $gnum + $new_num){
//                            return $this->result(1,'该商品限购数量！');
//                        }
//                    }
//                }
//            }
//        }elseif ($_GPC['buyType']== 'undefined' ||!$_GPC['buyType']){
//            $order = pdo_getall('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'good_id'=>$gid,'type'=>1),'good_num');
//            $new_num = 0;
//            foreach ($order as $k=>$v){
//                $new_num += $v['good_num'];
//            }
//            if($xg_num!=0){
//                if($xg_num < $gnum + $new_num){
//                    return $this->result(1,'该商品限购数量！');
//                }
//            }
//        }
//    }


    public function doPagePayGoods()
    {
        global $_W, $_GPC;
        $branch_id = intval($_GPC['bid']);
        $user_name = $_GPC['name'];
        $address = $_GPC['address'];
        $tel = $_GPC['tel'];
        $front_money = $_GPC['money'];
        $goods_num = $_GPC['goods_num'];
        if (empty($user_name)) $this->_returnData(-1, '收货人不能为空', []);
        if (empty($address)) $this->_returnData(-2, '收货人地址不能为空', []);
        if (! $tel ) $this->_returnData(-3, '电话错误', []);
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $_GPC['openid'],'uniacid'=>$_W['uniacid']));
        if (empty($user_info)) $this->_returnData(1, '用户不存在', []);

        if (! $branch_id) $this->_returnData(-11, '商家错误', []);

        $branch_info = pdo_get('yzhd_sun_branch', array('stutes' => 1,'id'=>$branch_id));

        if (empty($branch_info)) $this->_returnData(-12, '商家信息错误', []);
        if($_GPC['buyType']==2){
            $data['type']=3;
            $goods_info = pdo_get('yzhd_sun_goods_meal', array('id' => intval($_GPC['gid']), 'state' => 2,'uniacid'=>$_W['uniacid']));
            if (empty($goods_info)) $this->_returnData(2, '套餐不存在', []);
        }
        if($_GPC['buyType']==3){
            $data['type'] = 0;
            $goods_info = pdo_get('yzhd_sun_caipin', array('cid' => intval($_GPC['gid']), 'state' => 2,'uniacid'=>$_W['uniacid']));
            if (empty($goods_info)) $this->_returnData(2, '商品不存在', []);
        }

        if($_GPC['buyType']== 'undefined' ||!$_GPC['buyType']){
            $data['type'] = 1;
            $goods_info = pdo_get('yzhd_sun_goods', array('id' => intval($_GPC['gid']), 'state' => 2,'uniacid'=>$_W['uniacid']));
            if (empty($goods_info)) $this->_returnData(2, '商品不存在', []);
        }

        $coupon_id = intval($_GPC['yhqid']);
        if($coupon_id!=0){
            $mycoupon = pdo_get('yzhd_sun_user_coupon',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['openid'],'cid'=>$coupon_id));
            if(!$mycoupon){
                $this->_returnData(-2,'优惠券不存在！',[]);
            }
            if($mycoupon['use_num']>=$mycoupon['xl_frequency']){
                return $this->result(1,'优惠券次数已使用完','');
            }
            $coupon = pdo_get('yzhd_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$coupon_id,'state'=>2));
            if(!$coupon){
                $this->_returnData(-1,'优惠券不存在！',[]);
            }
        }
        if($_GPC['buyType']==4||$_GPC['buyType']=='4'){
            $data['type'] = 4;
            $imgs = rtrim($_GPC['imgs'],',');
            $gids = rtrim($_GPC['gid'],',');
            $gname = rtrim($_GPC['gname'],',');
            $gnumber = rtrim($_GPC['goods_num'],',');
            $gid = explode(',',rtrim($_GPC['gid'],','));
            foreach ($gid as $k=>$v){
                static $new_array = [];
                $new_array[]=pdo_get('yzhd_sun_caipin',array('uniacid'=>$_W['uniacid'],'cid'=>$v));
                pdo_delete('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'caipin_id'=>$v,'openid'=>$_GPC['openid']));
            }
            $data['good_id'] = $gids;
            $data['good_name'] = $gname;
            $data['good_img'] = $imgs;
            $data['good_num'] = $gnumber;

        }else{
            $data['good_id'] = $_GPC['gid'];
            $data['good_name'] = $goods_info['goods_name'];
            $data['good_img'] = $goods_info['pic'];
            $data['good_num'] = $goods_num;
        }
        $data['money'] = $front_money;
        $data['user_name'] = $user_name;
        $data['address'] = $address;
        $data['tel'] = $tel;
        $data['user_id'] = $user_info['id'];
        $data['openid'] = $_GPC['openid'];
        $data['branch_id'] = $branch_id;
        $data['uniacid'] = $_W['uniacid'];

        $id = $this->_createOrder($data);
        if($coupon_id!=0){
            $res =  pdo_update('yzhd_sun_user_coupon',array('use_openid'=>$_GPC['openid'],'use_time'=>time(),'use_num +='=>1),array('cid'=>$coupon_id,'openid'=>$_GPC['openid'],'uniacid'=>$_W['uniacid']));
        }
        echo json_encode($id);
    }

    //付款改变订单状态并且生成二维码
    public function doPagecheckOrder(){
        global $_GPC,$_W;
        $order_id = intval($_GPC['order_id']);
        $res = pdo_update('yzhd_sun_order',array('pay_time'=>time(),'state'=>3),array('id'=>$order_id));
        $order_info = pdo_get('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$order_id));
        if($order_info['type']==1){//0商品1代金券3套餐
            pdo_update('yzhd_sun_goods',array('goods_num +='=>$order_info['good_num'],'sp_num -='=>$order_info['good_num']),array('id'=>$order_info['good_id']));
        }elseif($order_info['type']==0){
            pdo_update('yzhd_sun_caipin',array('goods_num +='=>$order_info['good_num'],'sp_num -='=>$order_info['good_num']),array('cid'=>$order_info['good_id']));
        }elseif ($order_info['type']==3){
            pdo_update('yzhd_sun_goods_meal',array('goods_num +='=>$order_info['good_num'],'sp_num -='=>$order_info['good_num']),array('id'=>$order_info['good_id']));
        }elseif($order_info['type']==4){
            $good_num = explode(',',$order_info['good_num']);
            $good_id = explode(',',$order_info['good_id']);
            foreach ($good_id as $k=>$v){
                foreach ($good_num as $kk=>$vv){
                    if($k==$kk){
                        pdo_update('yzhd_sun_caipin',array('goods_num +='=>$vv,'sp_num -='=>$vv),array('cid'=>$v));
                    }
                }
            }
        }

        if($res){
            $order = pdo_get('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$order_id));
            $data['code'] = 'dj-' . md5(base64_encode(uniqid('youzi@#!$') . microtime())) . rand() . sha1(rand() . 'sahdkjahskjzxnc,mqjlwqepoqiwpoan,mzxcnk12p3901278@#$$!@#!@%' . microtime());
            require 'phpqrcode/phpqrcode.php';
            $data['order_id'] = $order_id;
            $data['uniacid'] = $_W['uniacid'];
            $data['goods_id'] = $order['good_id'];
            $errorCorrectionLevel = 'L';    //容错级别
            $matrixPointSize = 5;           //生成图片大小
            //我们给每个用户动态的创建一个文件夹
            $user_path=IA_ROOT."/attachment/qrcode/";
            //判断该用户文件夹是否已经有这个文件夹
            if(!file_exists($user_path)) {
                mkdir($user_path);
            }
            //判断该用户文件夹是否已经有这个文件夹
            if(!file_exists($user_path)) {
                mkdir($user_path);
            }
            $filename = 'attachment/qrcode/'.md5(microtime()).'.png';
            $path = IA_ROOT . '/' . $filename;
            QRcode::png($data['code'],$path , $errorCorrectionLevel, $matrixPointSize, 2);
            $data['qrcode'] = ltrim($filename,'attachment/');
            $res = pdo_insert('yzhd_sun_voucher', $data, array());
            echo json_encode($res);
            @require_once (IA_ROOT . '/framework/function/file.func.php');
            @$filename=ltrim($filename,'attachment/');
            @file_remote_upload($filename);
        }
    }



    public function doPageGetRecommendGoods()
    {
        global $_W, $_GPC;

        $goods_info = pdo_getall('yzhd_sun_goods', array('is_recommend' => 1, 'state' => 2,'uniacid'=>$_W['uniacid']),'','','create_time DESC');
        foreach($goods_info as $k=>$v){
            $goods_info[$k]['store_name'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['branch_id']),'name');
        }
        if (empty($goods_info)) $this->_returnData(1, '没有推荐商品', []);
        $this->_returnData(0, 'ok', $goods_info);
    }

    //获取商品（caipin）
    public function doPageGetRecommendCaipin(){
        global $_W,$_GPC;
        $goods_info = pdo_getall('yzhd_sun_caipin', array('is_recommend' => 1, 'state' => 2,'uniacid'=>$_W['uniacid']),'','','create_time DESC');
        foreach($goods_info as $k=>$v){
            $goods_info[$k]['store_name'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['branch_id']),'name');
            $goods_info[$k]['cate_name'] = pdo_getcolumn('yzhd_sun_category',array('uniacid'=>$_W['uniacid'],'cid'=>$v['cate_name']),'cname');
        }
        if (empty($goods_info)) $this->_returnData(1, '没有推荐商品', []);
        $this->_returnData(0, 'ok', $goods_info);
    }


    public function doPageUserISGetCoupon()
    {
        global $_W, $_GPC;

        $openid = $_GPC['openid'];
        $coupon_id = $_GPC['cid'];

        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1,'uniacid'=>$_W['uniacid']));

        if (empty($user_info)) $this->_returnData(1, '用户不存在', []);

        $coupon_info = pdo_get('yzhd_sun_coupon', array('id' => $coupon_id));

        if (empty($coupon_info)) $this->_returnData(2, '优惠券不存在', []);

        $user_coupon_info = pdo_get('yzhd_sun_user_coupon', array('uid' => $user_info['id'], 'cid' => $coupon_id,'del !='=>1));
        if($user_coupon_info){
            echo json_encode($user_coupon_info);
        }
//		if (empty($user_coupon_info)) $this->_returnData(0, '可以领取该优惠券', []);
//		$this->_returnData(-1, '用户已领取该优惠券', []);
    }

    public function doPagePayFansCard()
    {
        global $_W, $_GPC;

        $openid = $_GPC['openid'];
        $fans_card_id = intval($_GPC['fcard_id']);
        $user_name = $_GPC['name'];
        $address = $_GPC['address'];
        $tel = $_GPC['tel'];
        $birth_date = $_GPC['birth_date'];
        $area = $_GPC['area'];

        if (empty($user_name)) $this->_returnData(1, '收货人不能为空', []);
        if (empty($address)) $this->_returnData(2, '收货人地址不能为空', []);
        if (! $tel || strlen($tel) !== 11) $this->_returnData(3, '电话错误', []);
        if (empty($birth_date) || ! strtotime($birth_date)) $this->_returnData(-3, '日期错误', []);
        if (empty($area)) $this->_returnData(-4, '地区错误', []);

        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1));

        if (empty($user_info)) $this->_returnData(4, '用户不存在', []);

        $fans_card_info = pdo_get('yzhd_sun_vip_card', array('uniacid' => $_W['uniacid']));

        if (empty($fans_card_info)) $this->_returnData(5, '粉丝卡不存在', []);

        $data['good_id'] = $fans_card_info['id'];
        $data['money'] = $fans_card_info['money'];
        $data['good_name'] = '粉丝卡';
        $data['user_name'] = $user_name;
        $data['address'] = $address;
        $data['tel'] = $tel;
        $data['user_id'] = $user_info['id'];
        $data['openid'] = $openid;
        $data['birth_date'] = $birth_date;
        $data['area'] = $area;
        $type = 2;
        $data['out_trade_no'] = $this->_createOrder($type, $data);
        $this->_callWXPay($data);

    }

    //付款改变会员状态
    public function doPagecheckUser(){
        global $_GPC,$_W;
        $openid =  $_GPC['openid'];
        $vipCard = pdo_get('yzhd_sun_vip_card',array('uniacid'=>$_W['uniacid']));
        $time = 60 * 60 * 24 * 30 * $vipCard['v_pay_num'];
        $res = pdo_update('yzhd_sun_user',array('vip_expire_time'=>time()+ $time,'vip_no'=>time(),'is_vip'=>1),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        echo json_encode($res);
    }

    public function doPageReservations()
    {
        global $_W, $_GPC;

        $person_num = $_GPC['person_num'];
        $meals_date = $_GPC['meals_date'];
        $meals_pos = $_GPC['meals_pos'];
        $branch_id = intval($_GPC['bid']);
        $name = $_GPC['name'];
        $tel = $_GPC['tel'];
        $mark = $_GPC['mark'];
        $openid = $_GPC['openid'];

        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1));

        if (empty($user_info)) $this->_returnData(-2, '用户不存在');
        if (! $branch_id) $this->_returnData(4, '商家错误', []);
        $branch_info = pdo_get('yzhd_sun_branch', array('id' => $branch_id, 'stutes' => 1));
        if (empty($branch_info)) $this->_returnData(-1, '商家信息错误', []);
        if (empty($person_num)) $this->_returnData(1, '用餐人数不能为空', []);
        if (empty($meals_date) || ! strtotime($meals_date)) $this->_returnData(2, '用餐时间错误', []);
        if (empty($meals_pos)) $this->_returnData(3, '用餐位置不能为空', []);
        if (empty($name)) $this->_returnData(5, '姓名不能为空', []);
        if (! $tel) $this->_returnData(6, '电话错误', []);

        $data['meals_person_num'] = $person_num;
        $data['meals_date'] = $meals_date;
        $data['meals_position'] = $meals_pos;
        $data['branch_id'] = $branch_id;
        $data['name'] = $name;
        $data['tel'] = $tel;
        $data['mark'] = $mark;
        $data['openid'] = $openid;
        $data['uniacid'] = $_W['uniacid'];
        $data['create_time'] = time();
        pdo_insert('yzhd_sun_reservations', $data);
        $this->_returnData(0, 'ok', []);
    }

    public function doPageComment()
    {
        global $_W, $_GPC;

        $branch_id = intval($_GPC['bid']);
        $msg = $_GPC['msg'];
        $score = intval($_GPC['score']);
        $openid = $_GPC['openid'];
        $order_id = $_GPC['order_id'];

        if (! $branch_id) $this->_returnData(1, '商家错误', []);
        $branch_info = pdo_get('yzhd_sun_branch', array('stutes' => 1, 'id' => $branch_id));
        if (empty($branch_info)) $this->_returnData(5, '商家信息错误', []);

        if (! $branch_info['is_open_comment']) $this->_returnData(-1, '该商家暂未开启评论', []);
//        if (empty($msg)) $this->_returnData(2, '留言不能为空', []);
        if (! $score) $this->_returnData(3, '评分错误', []);
        if (empty($openid)) $this->_returnData(4, '用户错误', []);
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1));
        if (empty($user_info)) $this->_returnData(6, '用户信息错误', []);

        $comment_info = pdo_get('yzhd_sun_comment', array('order_id' => $order_id, 'openid' => $openid));
        if (! empty($comment_info)) $this->_returnData(-9, '您已评论过', []);
        $order_info = pdo_get('yzhd_sun_order', array('openid' => $openid, 'out_trade_no' => $order_id,'state' => 4, 'branch_id' => $branch_id));
        if (empty($order_info)) $this->_returnData(7, '您不满足评论的条件', []);
        if(!$msg || $msg=='undefined' ){
            $data['msg'] = '此用户没有填写评价。';
        }else{
            $data['msg'] = $msg;
        }

        $data['score'] = $score;
        $data['comment_time'] = time();
        $data['user_id'] = $user_info['id'];
        $data['openid'] = $openid;
        $data['order_id'] = $order_id;
        $data['goods_name'] = $order_info['goods_name'];
        $data['branch_id'] = $branch_id;
        $data['uniacid'] = $_W['uniacid'];
        $res =  pdo_insert('yzhd_sun_comment', $data);
        if($res){
            pdo_update('yzhd_sun_order',array('state'=>5),array('out_trade_no'=>$order_id,'uniacid'=>$_W['uniacid']));
        }
        $this->_returnData(0, '评价成功！', $branch_info);
    }

    //获取后台各类数据
    public function doPageBranchMessage(){
        global $_W,$_GPC;
        $openid = $_GPC['openid'];
        $userid = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid),'id');
        $branchid = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'user_id'=>$userid),'id');
        $time=date("Y-m-d");
        //今日新增订单
        $sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzhd_sun_order')." where uniacid={$_W['uniacid']} and branch_id={$branchid}) a where time like '%{$time}%' ";
        $jrdd=count(pdo_fetchall($sql));
        //今日收入
        $sql2=" select a.* from (select  id,money,FROM_UNIXTIME(time) as time  from".tablename('yzhd_sun_order')." where uniacid={$_W['uniacid']} and branch_id={$branchid} and state not in (1)) a where time like '%{$time}%' ";
        $jrorder = pdo_fetchall($sql2);
        $money = '';
        foreach ($jrorder as $k=>$v){
            $money += $v['money'];
        }
        //今日收益
        $commission_cost = pdo_getcolumn('yzhd_sun_system',array('uniacid'=>$_W['uniacid']),'commission_cost');
        $commission_money = $money - (round($money * $commission_cost/100, 2));
        if($commission_money<0){
            $commission_money = 0;
        }
        //累计收益
        $sql3=" select a.* from (select  id,money,FROM_UNIXTIME(time) as time  from".tablename('yzhd_sun_order')." where uniacid={$_W['uniacid']} and branch_id={$branchid} and state not in (1)) a ";
        $all_order = pdo_fetchall($sql3);
        $all_money = '';
        foreach ($all_order as $k=>$v){
            $all_money += $v['money'];
        }
        $all_commission_money = $all_money - (round($all_money * $commission_cost/100, 2));
        if($all_commission_money<0){
            $all_commission_money = 0;
        }
        $sql4 = " select a.* from (select  id,look_time,FROM_UNIXTIME(look_time) as time  from" . tablename('yzhd_sun_user')." where uniacid={$_W['uniacid']} and openid=" . "'$openid'" . ") a where time like '%{$time}%' ";
        $jrlook=count(pdo_fetchall($sql4));
        $new_array = array(
            'jrdd' => $jrdd,
            'jrsr' => $money,
            'jrsy' => $commission_money,
            'ljsy' => $all_commission_money,
            'jrlook' => $jrlook,
        );
        return $this->result(0,'',$new_array);
    }

    //每日访问
    public function doPageUpdateLookTime(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $res = pdo_update('yzhd_sun_user',array('look_time'=>time()),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        echo json_encode($res);
    }

    //获取已核销订单
    public function doPageGetOrdered(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $currentStatus = $_GPC['currentStatus'];
        if($currentStatus==0){
            $condition = ' and (a.state=4 or a.state=5)';
        }else{
            $condition = ' and (a.state=2 or a.state=3)';
        }
        $user_id = pdo_getcolumn('yzhd_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']),'id');
        if (empty($user_id)) return $this->result(1,'用户信息错误','');
        //查询店铺ID
        $branch_id = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'user_id'=>$user_id),'id');
        if (empty($branch_id)) return $this->result(1,'店铺信息错误','');
        $sql = ' select a.out_trade_no,a.good_img,a.good_name,a.good_money,a.id,a.branch_id from ' . tablename('yzhd_sun_order') . ' a where a.uniacid='.$_W['uniacid'] . ' and a.branch_id=' . $branch_id . $condition;
        $order = pdo_fetchall($sql);
        foreach ($order as $k=>$v){
            $order[$k]['good_img'] = explode(',',$v['good_img']);
        }
        return $this->result(0,'',$order);
    }

    public function doPageGetOrder()
    {
        global $_W, $_GPC;

        $openid = $_GPC['openid'];
        $type = -1;

        $where = array();

        if (empty($openid)) $this->_returnData(1, '用户错误', []);
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1,'uniacid'=>$_W['uniacid']));
        if (empty($user_info)) $this->_returnData(2, '用户信息错误', []);
        $orders = pdo_getall('yzhd_sun_order', array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'del !='=>1),'','','time DESC');
        if (empty($orders)) $this->_returnData(3, '没有订单', []);
        foreach ($orders as $key => $val) {
            $orders[$key]['branch_info'] = pdo_get('yzhd_sun_branch', array('stutes' => 1,'uniacid'=>$_W['uniacid']));
            $orders[$key]['good_img'] = explode(',',$val['good_img']);
        }
        $this->_returnData(0, 'ok', $orders);
    }

    public function doPageGetOrderDetail()
    {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $order_id = intval($_GPC['order_id']);
        if(!$_GPC['boss_id'] || $_GPC['boss_id']=='undefined'){
            $where = array('id' => $order_id, 'openid' => $openid,'uniacid'=>$_W['uniacid']);
        }else{
            $where = array('id' => $order_id, 'uniacid'=>$_W['uniacid']);
        }
        if (empty($openid)) $this->_returnData(1, '用户错误');
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid));
        if (empty($user_info)) $this->_returnData(2, '用户信息错误');
        $order_info = pdo_get('yzhd_sun_order',$where);

        $order_info['good_img'] = explode(',',$order_info['good_img']);
        if( $order_info['complete_time']!=0){
            $order_info['complete_time'] = date('Y-m-d H:i:s',$order_info['complete_time']);
        }

//        $order_info['good_name'] = explode(',',$order_info['good_name']);
//        $order_info['good_num'] = explode(',',$order_info['good_num']);
        //$order_info['voucher_info'] = pdo_get('yzhd_sun_voucher', array('id' => $order_info['voucher_id']));
        $order_info['voucher_info'] = pdo_get('yzhd_sun_voucher', array('order_id' => $order_info['id'],'uniacid'=>$_W['uniacid']));
        if (empty($order_info)) $this->_returnData('3', '没有该订单信息');
        $this->_returnData(0, 'ok', $order_info);
    }


    public function doPageIWantPay()
    {
        global $_W, $_GPC;

        $order_id = $_GPC['order_id'];//2018061481181

        $openid = $_GPC['openid'];

        if (empty($openid)) $this->_returnData(1, '用户错误');
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid,'uniacid'=>$_W['uniacid']));
        if (empty($user_info)) $this->_returnData(2, '用户信息错误');
        $order_info = pdo_get('yzhd_sun_order', array('out_trade_no' => $order_id, 'openid' => $openid, 'state' => 1,'uniacid'=>$_W['uniacid']));

        if (empty($order_info)) $this->_returnData('3', '没有该订单信息');
        //if ($order_info['state'] !== 1) unset($order_info);
        $data['money'] = intval($order_info['money']);
        $data['openid'] = $openid;
        $data['out_trade_no'] = $order_info['out_trade_no'];
        $this->_callWXPay($data);
    }



    public function doPageGetMeals()
    {
        global $_W, $_GPC;

        $branch_id = $_GPC['bid'];

        if (! $branch_id) $this->_returnData(1, '商家错误');

        $branch_info = pdo_get('yzhd_sun_branch', array('id' => $branch_id, 'stutes' => 1));
        if (empty($branch_info)) $this->_returnData(2, '商家信息错误');

        $meals = pdo_getall('yzhd_sun_goods_meal', array('state' => 2, 'branch_id' => $branch_id,'uniacid'=>$_W['uniacid']));

        if (empty($meals)) $this->_returnData(3, '该商家没有套餐');

//		foreach ($meals as $key => $val) {
//			$meals_content = unserialize($val['meal_content']);
//			$meals[$key]['meal_content'] = $meals_content;
//			foreach ($meals[$key]['meal_content'] as $key2 => $val2) {
//				$meals[$key]['meal_content'][$key2] = explode(' ', $val2);
//			}
//		}
        $this->_returnData(0, 'ok', $meals);

    }
    public function doPageGetBranchDetail()
    {
        global $_W, $_GPC;

        $branch_id = intval($_GPC['bid']);

        if (! $branch_id) $this->_returnData(1, '商家错误');

        $branch_info = pdo_get('yzhd_sun_branch', array('id' => $branch_id, 'stutes' => 1));
        $branch_info['shop_time'] = $branch_info['start_time'] . ' - ' . $branch_info['end_time'];
        if (empty($branch_info)) $this->_returnData(2, '商家信息错误');
        $this->_returnData(0, 'ok', $branch_info);

    }

    public function doPageGetMealDetail()
    {
        global $_W, $_GPC;
//        $branch_id = $_GPC['bid'];
        $meal_id = $_GPC['meal_id'];
//        if (! $branch_id) $this->_returnData(1, '商家错误');

//        $branch_info = pdo_get('yzhd_sun_branch', array('id' => $branch_id, 'stutes' => 1));
//        if (empty($branch_info)) $this->_returnData(2, '商家信息错误');
        if (! $meal_id) $this->_returnData(3, '套餐错误');
        $meal_info = pdo_get('yzhd_sun_goods_meal', array('state' => 2,'id' => $meal_id));
        if (empty($meal_info)) $this->_returnData(4, '套餐信息错误');

        $this->_returnData(0, 'ok', $meal_info);
    }

    //商家订座管理
    public function doPageReverseMana(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $user = pdo_get('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        if(!$user){
            return $this->result(1,'用户信息错误，请退出后重新登录！','');
        }
        $branch = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'user_id'=>$user['id'],'stutes'=>1));
        if(!$branch){
            return $this->result(1,'店铺信息错误，请退出后重新登录！','');
        }
        $reverse = pdo_getall('yzhd_sun_reservations',array('uniacid'=>$_W['uniacid'],'branch_id'=>$branch['id']),'','','id DESC');
        if(!$reverse){
            return $this->result(0,'暂无订座信息','');
        }
        foreach ($reverse as $k=>$v){
            $reverse[$k]['branch_info'] = $branch;
            $new_date = strtotime($reverse[$k]['meals_date']);
            $reverse[$k]['meals_date'] = date('m月d日/H:i',$new_date);
            $reverse[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
        }


        return $this->result(0,'',$reverse);
    }

    //拒绝订座
    public function doPageReserveNot(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $res = pdo_update('yzhd_sun_reservations',array('status'=>2),array('id'=>$id,'uniacid'=>$_W['uniacid']));
        if($res){
            echo 1;
        }else{
            return $this->result(1,'拒绝失败！','');
        }
    }

    //确认订座
    public function doPageReserveYes(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $res = pdo_update('yzhd_sun_reservations',array('status'=>1),array('id'=>$id,'uniacid'=>$_W['uniacid']));
        if($res){
            echo 1;
        }else{
            return $this->result(1,'确认失败！','');
        }
    }

    //查询未支付订单支付时是否还有库存
    public function doPageIsStockGoods(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $openid = $_GPC['openid'];
        $order = pdo_get('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        if($order['type']==0){
            $goods = pdo_get('yzhd_sun_caipin',array('uniacid'=>$_W['uniacid'],'cid'=>$order['good_id']));
            //先查找已经购买了几件商品
            if($goods['xg_num']!=0){
                $sql = 'select a.good_id,a.good_num,a.type from ' . tablename('yzhd_sun_order') . 'a where uniacid=' . $_W['uniacid'] . " and (a.type=0 or a.type = 4) and a.openid='$openid'";
                $order_info = pdo_fetchall($sql);

                $new_array = array();
                foreach ($order_info as $k=>$v){
                    if(in_array($goods['cid'],explode(',',$v['good_id']))){
                        $new_array[] = $v;
                    }
                }

                foreach ($new_array as $k=>$v){
                    $new_array[$k]['good_id']  =  explode(',',$v['good_id']);
                    $new_array[$k]['good_num']  =  explode(',',$v['good_num']);
                }

                $new_buy_num = 0;
                foreach ($new_array[$k]['good_id'] as $k=>$v){
                    foreach ($new_array[$k]['good_num'] as $kk=>$vv){
                        if($k==$kk){
                            if($goods['cid']==$v){
                                $new_buy_num += $vv;
                            }
                        }
                    }
                }
                if($new_buy_num + $order['good_num'] > $goods['xg_num']){
                    return $this->result(1,'该商品限购数量为'.$goods['xg_num'],'');
                }
            }

            if($goods['sp_num']<$order['good_num']){
                return $this->result(1,'库存不足','');
            }else{
                echo 1;
            }
        }elseif ($order['type']==1){
            $goods = pdo_get('yzhd_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$order['good_id']));
            //先查找已经购买了几件商品
            if($goods['xg_num']!=0){
                $sql = 'select a.good_id,a.good_num,a.type from ' . tablename('yzhd_sun_order') . 'a where uniacid=' . $_W['uniacid'] . " and a.type=1 and a.openid='$openid'" . " and a.good_id=" . $goods['id'];;
                $order_info = pdo_fetchall($sql);
                $new_buy_num = 0;
                foreach ($order_info as $k=>$v){
                    $new_buy_num += $v['good_num'];
                }
                if($new_buy_num + $order['good_num'] > $goods['xg_num']){
                    return $this->result(1,'该商品限购数量为'.$goods['xg_num'],'');
                }
            }

            if($goods['sp_num']<$order['good_num']){
                return $this->result(1,'库存不足','');
            }else{
                echo 1;
            }
        }elseif ($order['type']==3){
            $goods = pdo_get('yzhd_sun_goods_meal',array('uniacid'=>$_W['uniacid'],'id'=>$order['good_id']));
            //先查找已经购买了几件商品
            if($goods['xg_num']!=0){
                $sql = 'select a.good_id,a.good_num,a.type from ' . tablename('yzhd_sun_order') . 'a where uniacid=' . $_W['uniacid'] . " and a.type=3  and a.openid='$openid'" . " and a.good_id=" . $goods['id'];
                $order_info = pdo_fetchall($sql);
                $new_buy_num = 0;
                foreach ($order_info as $k=>$v){
                    $new_buy_num += $v['good_num'];
                }
                if($new_buy_num + $order['good_num'] > $goods['xg_num']){
                    return $this->result(1,'该商品限购数量为'.$goods['xg_num'],'');
                }
            }

            if($goods['sp_num']<$order['good_num']){
                return $this->result(1,'库存不足','');
            }else{
                echo 1;
            }
        }elseif ($order['type']==4){
            $ids = explode(',',$order['good_id']);
            $nums = explode(',',$order['good_num']);
            foreach ($ids as $k=>$v){
                foreach ($nums as $kk=>$vv){
                    if($k==$kk){
                        $goods = pdo_get('yzhd_sun_caipin',array('uniacid'=>$_W['uniacid'],'cid'=>$v));
                        if($goods['xg_num']!=0){
                            $sql = 'select a.good_id,a.good_num,a.type from ' . tablename('yzhd_sun_order') . 'a where uniacid=' . $_W['uniacid'] . " and a.type=4 and a.openid='$openid'";
                            $order_info = pdo_fetchall($sql);

                            $new_array = array();
                            foreach ($order_info as $kkk=>$vvv){
                                if(in_array($goods['cid'],explode(',',$v))){
                                    $new_array[] = $vvv;
                                }
                            }
                            foreach ($new_array as $kkk=>$vvv){
                                $new_array[$kkk]['good_id']  =  explode(',',$vvv['good_id']);
                                $new_array[$kkk]['good_num']  =  explode(',',$vvv['good_num']);
                            }
                            $new_num =  $goods['xg_num'] - $vv ;
                            foreach ($new_array as $kkk=>$vvv){
                                foreach ($vvv['good_id'] as $kkkk=>$vvvv){
                                    foreach ($vvv['good_num'] as $kkkkk=>$vvvvv){
                                        if($kkkk==$kkkkk){
                                            if($goods['cid']==$vvvv){
                                                $new_num -= $vvvvv;
                                                if($new_num < 0){
                                                    return $this->result(1,'超出购买数量','');
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if($goods['sp_num']<$vv){
                            return $this->result(1,'库存不足','');
                        }

                    }
                }
            }
            echo 1;
        }

    }
    public function doPageNotifyPay()
    {
        global $_W,$_GPC;

        $xmlData = file_get_contents('php://input');
        $arrayData = xml2array($xmlData);


        $appData = pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
        $keys = $appData['wxkey'];

        ksort($arrayData, SORT_ASC);
        //$stringA = http_build_query($arrayData);
        $stringA = '';
        foreach ($arrayData as $key => $val) {
            if ($key == 'sign') continue;
            $stringA .= "&{$key}={$val}";
        }
        $stringA = ltrim($stringA, '&');
        $signTempStr = $stringA . '&key='.$keys;
        $signValue = strtoupper(md5($signTempStr));
        $openid = $arrayData['openid'];
        $total_fee = $arrayData['total_fee'];
        $arrayData['out_trade_no'] = substr($arrayData['out_trade_no'], 0, -4);
        $out_trade_no = $arrayData['out_trade_no'];

        $order_info = pdo_get('yzhd_sun_order', array('openid' => $openid, 'out_trade_no' => $out_trade_no, 'state' => 1));


        if (! empty($order_info) && intval($order_info['money']) === intval($total_fee)) {
            $arrayData['_order'] = $order_info;
            if ($order_info['type'] == 0) {
                $this->_ojbk('voucher', $arrayData);
            } elseif ($order_info['type'] == 2) {
                $this->_ojbk('fansCard', $arrayData);
            }
        }
    }

    private function _fansCardOK($data)
    {

        $pay_end_time = strtotime($data['time_end']);
        $card_info = pdo_get('yzhd_sun_vip_card', array('id' => $data['_order']['good_id']));
        $expire_time = intval($card_info['expire_time']) * 30 * 24 * 60 * 60;
        $full_time = $pay_end_time + $expire_time;
        $vip_no = rand(1000, 9000) . substr($pay_end_time, -4, 4);
        $vip_data['is_vip'] = 1;
        $vip_data['vip_expire_time'] = $full_time;
        $vip_data['vip_no'] = $vip_no;
        pdo_update('yzhd_sun_user', $vip_data, array('id' => $data['_order']['user_id'], 'is_vip' => 0, 'vip_no' => 0));
        $ins_data['openid'] = $data['_order']['openid'];
        $ins_data['out_trade_no'] = $data['_order']['out_trade_no'];
        $ins_data['vip_start_time'] = $data['_order']['time'];
        $ins_data['vip_start_date'] = date('Y-m-d', $data['_order']['time']);
        $ins_data['vip_end_time'] = $full_time;
        $ins_data['vip_end_date'] = date('Y-m-d', $full_time);
        pdo_insert('yzhd_sun_vips', $ins_data);

    }

    private function _voucherOK($data)
    {

        $voucher_data['goods_id'] = $data['_order']['good_id'];
        $voucher_data['order_id'] = $data['_order']['id'];
        $voucher_data['out_trade_no'] = $data['_order']['out_trade_no'];
        $voucher_data['openid'] = $data['openid'];


        $voucher_data['code'] = 'dj-' . md5(base64_encode(uniqid('youzi@#!$') . microtime())) . rand() . sha1(rand() . 'sahdkjahskjzxnc,mqjlwqepoqiwpoan,mzxcnk12p3901278@#$$!@#!@%' . microtime());
        require 'phpqrcode/phpqrcode.php';

        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = 5;           //生成图片大小
        $filename = 'attachment/qrcode/voucher/'.md5(microtime()).'.png';
        $path = IA_ROOT . '/' . $filename;
        QRcode::png($voucher_data['code'],$path , $errorCorrectionLevel, $matrixPointSize, 2);
        $voucher_data['qrcode'] = $filename;

        pdo_insert('yzhd_sun_voucher', $voucher_data);
        $voucher_id = pdo_insertid();
        pdo_update('yzhd_sun_order', array('voucher_id' => $voucher_id), array('id' => $data['_order']['id'], 'voucher_id' => 0));
        @require_once (IA_ROOT . '/framework/function/file.func.php');
//        @$filename=$filename;
        @file_remote_upload($filename);
    }

    private function _updateOrderPayStatus($data)
    {
        $up_data['state'] = 3;
        $up_data['pay_time'] = $data['time_end'];

        pdo_update('yzhd_sun_order', $up_data, array('id' => $data['_order']['id'], 'state' => 1));
    }

    private function _ojbk($action, $data)
    {

        $methodName = "_{$action}OK";
        if (method_exists($this, $methodName)) {
            $this->_updateOrderPayStatus($data);
            call_user_func(array($this, $methodName), $data);
        }
    }


    public function doPageGetComments()
    {
        global $_W, $_GPC;

        $branch_id = intval($_GPC['bid']);

        if (! $branch_id) $this->_returnData(1, '商家错误');
        $branch_info = pdo_get('yzhd_sun_branch', array('id' => $branch_id, 'stutes' => 1));
        if (empty($branch_info)) $this->_returnData(-1, '商家不存在');

        $comments = pdo_getall('yzhd_sun_comment', array('branch_id' => $branch_id),'','','comment_time DESC');
        foreach ($comments as $key => $val) {
            $comments[$key]['user_info'] = pdo_get('yzhd_sun_user', array('openid' => $val['openid']));
        }
        $this->_returnData(0, 'ok', $comments);
    }

    public function doPageGetPlatformInfo()
    {
        global $_W,$_GPC;
        $info = pdo_get('yzhd_sun_system', array('uniacid'=>$_W['uniacid']));
        $data['tel'] = $info['platform_tel'];
        $data['addr'] = $info['platform_address'];
        $data['logo'] = $info['platform_logo'];
        $data['content'] = $info['platform_content'];
        $data['chat'] = $info['platform_chat'];
        $data['ad'] = unserialize($info['platform_ad']);
        $this->_returnData(0, 'ok', $data);

    }



    public function doPageRecommendGoodsMeal(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $goods_id = intval($_GPC['gid']);
        if (! $goods_id) $this->_returnData(1, '商品错误');
        $goods_info = pdo_get('yzhd_sun_goods_meal', array('id' => $goods_id, 'state' => 2));
        if (empty($goods_info)) $this->_returnData(-1, '商品不存在');

        if (empty($openid)) $this->_returnData(2, '用户错误');
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1,'uniacid'=>$_W['uniacid']));
        if (empty($user_info)) $this->_returnData(3, '用户不存在');
        $recommend = pdo_get('yzhd_sun_user_recommend_goods',array('uniacid'=>$_W['uniacid'],'buy_type'=>2,'openid'=>$openid,'goods_id'=>$goods_id));
        if($recommend){
            $this->_returnData(-1,'已经推荐过该商品！','');
        }else{
            $data['openid'] = $openid;
            $data['uniacid'] = $_W['uniacid'];
            $data['goods_id'] = $goods_id;
            $data['recommend_time'] = time();
            $data['img'] = $user_info['img'];
            $data['buy_type'] = 2;
            pdo_insert('yzhd_sun_user_recommend_goods',$data);
        }
        $res  = pdo_update('yzhd_sun_goods_meal',array('fictitious_share +='=>1),array('id'=>$goods_id));
        $this->_returnData(0, 'ok', array('num' => $goods_info['fictitious_share'] + 1));
    }

    public function doPageRecommendGoods()
    {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $goods_id = intval($_GPC['gid']);
        $buyType = $_GPC['buyType'];

        if (! $goods_id) $this->_returnData(1, '商品错误');
        if($buyType==3){
            $data['buy_type']=3;
            $goods_info = pdo_get('yzhd_sun_caipin', array('cid' => $goods_id, 'state' => 2));
        }elseif($buyType==2){
            $data['buy_type']=2;
            $goods_info = pdo_get('yzhd_sun_goods_meal', array('id' => $goods_id, 'state' => 2));
        }
        else{
            $data['buy_type']=1;
            $goods_info = pdo_get('yzhd_sun_goods', array('id' => $goods_id, 'state' => 2));
        }

        if (empty($goods_info)) $this->_returnData(-1, '商品不存在');

        if (empty($openid)) $this->_returnData(2, '用户错误');
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1,'uniacid'=>$_W['uniacid']));
        if (empty($user_info)) $this->_returnData(3, '用户不存在');
        $user_exist_recommend = pdo_get('yzhd_sun_user_recommend_goods', array('openid' => $openid, 'goods_id' => $goods_id,'uniacid'=>$_W['uniacid'],'buy_type'=>$data['buy_type']));
        if (! empty($user_exist_recommend)) $this->_returnData(4, '您已推荐过', array('num' => $goods_info['recommend_num']));
        $data['openid'] = $openid;
        $data['goods_id'] = $goods_id;
        $data['recommend_time'] = time();
        $data['img'] = $user_info['img'];
        $data['uniacid'] = $_W['uniacid'];
        pdo_insert('yzhd_sun_user_recommend_goods', $data);
        $recommend_num = $goods_info['recommend_num'] + 1;
        if($buyType==3){
            pdo_update('yzhd_sun_caipin', array('recommend_num' => $recommend_num), array('cid' => $goods_id, 'recommend_num' => $goods_info['recommend_num']));
        }elseif($buyType==2){
            pdo_update('yzhd_sun_goods_meal', array('recommend_num' => $recommend_num), array('id' => $goods_id, 'recommend_num' => $goods_info['recommend_num']));
        }else{
            pdo_update('yzhd_sun_goods', array('recommend_num' => $recommend_num), array('id' => $goods_id, 'recommend_num' => $goods_info['recommend_num']));
        }
        $this->_returnData(0, '分享成功', array('num' => $recommend_num));
    }

    public function doPageRecommendBranch()
    {
        global $_W, $_GPC;

        $openid = $_GPC['openid'];
        $branch_id = intval($_GPC['bid']);

        if (! $branch_id) $this->_returnData(1, '商家错误');

        $branch_info = pdo_get('yzhd_sun_branch', array('id' => $branch_id, 'stutes' => 1));

        if (empty($branch_info)) $this->_returnData(-1, '店铺不存在');

        if (empty($openid)) $this->_returnData(2, '用户错误');
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1));
        if (empty($user_info)) $this->_returnData(3, '用户不存在');
        $user_exist_recommend = pdo_get('yzhd_sun_user_recommend_branch', array('openid' => $openid, 'branch_id' => $branch_id));
        if (! empty($user_exist_recommend)) $this->_returnData(4, '您已推荐过', array('num' => $branch_info['recommend_num']));
        $data['openid'] = $openid;
        $data['branch_id'] = $branch_id;
        $data['recommend_time'] = time();
        $data['img'] = $user_info['img'];
        pdo_insert('yzhd_sun_user_recommend_branch', $data);
        $recommend_num = $branch_info['recommend_num'] + 1;
        pdo_update('yzhd_sun_branch', array('recommend_num' => $recommend_num), array('id' => $branch_id, 'recommend_num' => $branch_info['recommend_num']));
        $this->_returnData(0, 'ok', array('num' => $recommend_num));
    }

    public function doPageRecommendBranchUsers()
    {
        global $_W, $_GPC;

        $branch_id = intval($_GPC['bid']);

        if (! $branch_id) $this->_returnData(1, '商家错误');

        $branch_info = pdo_get('yzhd_sun_branch', array('id' => $branch_id, 'stutes' => 1));

        if (empty($branch_info)) $this->_returnData(-1, '店铺不存在');

        $list = pdo_getall('yzhd_sun_user_recommend_branch', array('branch_id' => $branch_id));
        $users = array();
        foreach ($list as $key => $val) {
            $user = pdo_get('yzhd_sun_user', array('openid' => $val['openid']));
            $users[] = $user;
        }
        $users = $this->_arraySequence($users, 'id');
        $users = array_slice($users, 0, 5);
        $this->_returnData(0, 'ok', array('num' => count($users), 'users' => $users));

    }


    public function doPageRecommendGoodsUsers()
    {
        global $_W, $_GPC;

        $goods_id = intval($_GPC['gid']);
        $buyType = $_GPC['buyType'];
        if (! $goods_id) $this->_returnData(1, '商品错误');
        if($buyType==3){
            $type = 3;
            $goods_info = pdo_get('yzhd_sun_caipin', array('cid' => $goods_id, 'state' => 2));
        }elseif ($buyType==2){
            $type = 2;
            $goods_info = pdo_get('yzhd_sun_goods_meal', array('id' => $goods_id, 'state' => 2));
        }else{
            $type = 1;
            $goods_info = pdo_get('yzhd_sun_goods', array('id' => $goods_id, 'state' => 2));
        }

        if (empty($goods_info)) $this->_returnData(-1, '商品不存在');

        $list = pdo_getall('yzhd_sun_user_recommend_goods', array('goods_id' => $goods_id,'buy_type'=>$type));
        $users = array();
        foreach ($list as $key => $val) {
            $user = pdo_get('yzhd_sun_user', array('openid' => $val['openid'],'uniacid'=>$_W['uniacid']));
            $users[] = $user;
        }
//		$users = $this->_arraySequence($users, 'id');
        $users = array_slice($users, 0, 5);
        $this->_returnData(0, 'ok', array('num' => count($users), 'users' => $users));
    }


    /**
     * 求两个已知经纬度之间的距离,单位为米
     *
     * @param lng1 $ ,lng2 经度
     * @param lat1 $ ,lat2 纬度
     * @return float 距离，单位米
     */
    function getdistance($lng1, $lat1, $lng2, $lat2) {
        // 将角度转为弧度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;
    }

    //获取最多推荐商家
    public function doPageGetMaxRecommend(){
        global $_GPC,$_W;
        $lng = $_GPC['lng'];
        $lat = $_GPC['lat'];
        $sql = 'SELECT * FROM ' . tablename('yzhd_sun_branch') . ' WHERE ' . 'uniacid= ' .$_W['uniacid'] . '  AND ' . ' stutes=1 ' . ' ORDER BY recommend_num DESC ';
        $data = pdo_fetchall($sql);
        foreach ($data as $k=>$v){
            $data[$k]['distance'] = round(($this->getdistance($lat,$lng,$v['lat'],$v['lng']))/1000,1);
        }
        $this->_returnData(0, 'ok', $data);
    }

    public function doPageGetMinmumBranch()
    {
        global $_W, $_GPC;
        $lng = $_GPC['lng'];
        $lat = $_GPC['lat'];
        $sql = 'SELECT * FROM ' . tablename('yzhd_sun_branch') . ' WHERE ' . 'uniacid= ' .$_W['uniacid'] . '  AND ' . ' stutes=1 ';
        $data = pdo_fetchall($sql);
        foreach ($data as $k=>$v){
            $data[$k]['distance'] = round(($this->getdistance($lat,$lng,$v['lat'],$v['lng']))/1000,1);
        }
        $a = [];

        foreach ($data as $k=>$v){
            $a[] = $v['distance'];
        }
        array_multisort($a,SORT_ASC,$data);


        $this->_returnData(0, 'ok', $data);
//		$branchs = $this->doPageGetBranch(true);
//		//$branchs = array_slice($branchs, 0, 4);
//		$this->_returnData(0, 'ok', $branchs);
    }

    //购买商品模板消息
    public function doPageBuyMessage()
    {
        global $_W, $_GPC;


        function getaccess_token($_W)
        {
            $res = pdo_get('yzhd_sun_system', array('uniacid' => $_W['uniacid']));
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

        //设置与发送模板信息

        function set_msg($_W, $_GPC)
        {

            $prepay_id = trim($_GPC['prepay_id'],'prepay_id=');
            $access_token = getaccess_token($_W);
            $buytype = $_GPC['buyType'];
            if($buytype==3){
                $goods = pdo_get('yzhd_sun_caipin',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['gid']));
            }elseif($buytype==2){
                $goods = pdo_get('yzhd_sun_goods_meal',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['gid']));
            }elseif($buytype==4){
                $goods['goods_name'] = rtrim($_GPC['gname'],',');
            }else{
                $goods = pdo_get('yzhd_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['gid']));
            }
            if(!$goods){
                $goods['goods_name'] = 'Goods';
            }
            $res2 = pdo_get('yzhd_sun_sms', array('uniacid' => $_W['uniacid']));
            $store_name = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['bid']));
            $formwork = '{
                 "touser": "' . $_GET["openid"] . '",
                 "template_id": "' . $res2["tid1"] . '",
                 "page":"yzhd_sun/pages/index/index",
                 "form_id":"' . $prepay_id . '",
                 "data": {
                   "keyword1": {
                     "value": "' . $goods['goods_name'] . '",
                     "color": "#173177"
                   },
                   "keyword2": {
                     "value":"' .  $_GPC['money']. '",
                     "color": "#173177"
                   },
                   "keyword3": {
                     "value": "' . $store_name['name'] . '",
                     "color": "#173177"
                   },
                   "keyword4": {
                     "value": "' . date('Y-m-d H:i:s',time()) . '",
                     "color": "#173177"
                   }
                 }   
               }';
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formwork);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        echo set_msg($_W, $_GPC);
    }


    public function doPageGetBranchCategory()
    {
        global $_W, $_GPC;

        $branch_id = intval($_GPC['bid']);
        if (! $branch_id) $this->_returnData(1, '商家错误');
        $branch_info = pdo_get('yzhd_sun_branch', array('id' => $branch_id, 'stutes' => 1,'uniacid'=>$_W['uniacid']));
        if (empty($branch_info)) $this->_returnData(2, '商家不存在');
        $categorys = pdo_getall('yzhd_sun_category', array('uniacid' => $_W['uniacid']));
        $openid = $_GPC['openid'];

        foreach ($categorys as $key => $val) {
//            $sql = ' SELECT * FROM ' . tablename('yzhd_sun_caipin') . ' c ' . ' JOIN ' . tablename('yzhd_sun_shopcart') . ' s ' . ' ON ' . ' c.cid=s.caipin_id ' . ' WHERE ' . ' c.cate_name=' . $val['cid'] . ' AND ' . ' c.uniacid= ' . $_W['uniacid'] . ' AND ' . ' s.openid= ' . "'$openid'" . ' AND ' . ' c.state=2 ' . ' AND ' . ' c.branch_id= ' . $branch_info['id'];
            $categorys[$key]['goods_list'] = pdo_getall('yzhd_sun_caipin', array('cate_name' => $val['cid'],'uniacid'=>$_W['uniacid'],'state'=>2,'branch_id'=>$branch_info['id']));
            if(!$categorys[$key]['goods_list']) unset($categorys[$key]);
        }
//        $shopcart = pdo_getall('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        //重构数组，将对象转为数组
        foreach ($categorys as $k=>$v){
            static $a = [];
            $a[] = $categorys[$k];
        }
        foreach ($a as $k=>$v){
            foreach ($a[$k]['goods_list'] as $kk=>$vv){
                $shopcart = pdo_get('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'caipin_id'=>$vv['cid']));
//                return $this->result(0,'',$shopcart);
                if($shopcart){
//                    if($shopcart['caipin_id'] == $vv['cid']){
                    $a[$k]['goods_list'][$kk]['number'] = $shopcart['number'];
//                    }
                    if($shopcart['create_time']* 3600 * 24 < time()){
                        pdo_delete('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'id'=>$shopcart['id']));
                    }
                }else{
                    $a[$k]['goods_list'][$kk]['number'] = 0;
                }
            }
        }
        $this->_returnData(0, 'ok', $a);
    }

    //获取购物车数据
    public function doPageGetShopCart(){
        global $_W,$_GPC;
        $openid = $_GPC['openid'];
        $bid = $_GPC['bid'];
        $res = pdo_getall('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'bid'=>$bid,'openid'=>$openid));
        foreach ($res as $k=>$v){
            static $price = 0;
            $price = $price += $v['price'];
        }
        $new_array = [
            'allprice' => $price,
            'info' => $res,
        ];
        return $this->result(0,'',$new_array);
    }

    //添加购物车
    public function doPageAddShopCartNum(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $cnumber = intval($_GPC['cnumber']);
        $id = intval($_GPC['id']);
        $cname = $_GPC['cname'];
        $price = $_GPC['price'];
        if(!$openid){
            return $this->result(1,'用户信息错误','');
        }
        $caipin = pdo_get('yzhd_sun_caipin',array('uniacid'=>$_W['uniacid'],'cid'=>$id));
        if($caipin['sp_num']<$cnumber){
            return $this->result(1,'库存不足','');
        }
        if($caipin['xg_num']!=0){
            $sql = 'select a.good_id,a.good_num,a.type from ' . tablename('yzhd_sun_order') . 'a where uniacid=' . $_W['uniacid'] . " and (a.type=0 or a.type=4) and a.openid='$openid'";
            $order = pdo_fetchall($sql);

            $new_array = array();
            foreach ($order as $k=>$v){
                if(in_array($caipin['cid'],explode(',',$v['good_id']))){
                    $new_array[] = $v;
                }
            }
            foreach ($new_array as $k=>$v){
                $new_array[$k]['good_id']  =  explode(',',$v['good_id']);
                $new_array[$k]['good_num']  =  explode(',',$v['good_num']);
            }
            $new_num = 0;
            foreach ($new_array as $k=>$v){
                foreach ($v['good_id'] as $kk=>$vv){
                    foreach ($v['good_num'] as $kkk=>$vvv){
                        if($kk==$kkk){
                            if($caipin['cid']==$vv){
                               $new_num += $vvv;
                            }
                        }
                    }
                }
            }
            if($caipin['xg_num'] < $cnumber + $new_num){//2<
                return $this->result(1,'该商品总限购数量' . $caipin['xg_num'],'');
            }
        }
        //根据ID查找该商品是否已经在购物车
        $shopcart = pdo_get('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'caipin_id'=>$id,'openid'=>$openid));
        if(!$shopcart){
            $data = array(
                'number' => 1,
                'price' => $price,
                'gname' => $cname,
                'caipin_id' => $id,
                'openid' => $openid,
                'uniacid' =>$_W['uniacid'],
                'create_time' => time(),
                'bid' => $_GPC['bid'],
                'img' => $caipin['pic'],
            );
            $res = pdo_insert('yzhd_sun_shopcart',$data);
        }else{
            pdo_update('yzhd_sun_shopcart',array('number +='=>1,'price +='=>$price),array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'caipin_id'=>$id));
        }
        return $this->result(0,'',$res);
    }


    //减购物车
    public function doPageReduceShopCartNum(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $id = intval($_GPC['id']);
        $price = $_GPC['price'];
        if(!$openid){
            return $this->result(1,'用户信息错误','');
        }
        //根据ID查找该商品是否已经在购物车
        $shopcart = pdo_get('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'caipin_id'=>$id,'openid'=>$openid));
        if(!$shopcart){
            return $this->result(1,'该商品购物不在购物车里','');
        }else{
            pdo_update('yzhd_sun_shopcart',array('number -='=>1,'price -='=>$price),array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'caipin_id'=>$id));
        }
        $shopcart2 = pdo_get('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'caipin_id'=>$id,'openid'=>$openid));
        if($shopcart2['number']<=0){
            $res =  pdo_delete('yzhd_sun_shopcart',array('caipin_id'=>$id,'openid'=>$openid,'uniacid'=>$_W['uniacid']));
        }
        return $this->result(0,'',$res);
    }

    //购物车详情的加
    public function doPageShopJia(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $openid = $_GPC['openid'];
        $shopcart = pdo_get('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $caipin = pdo_get('yzhd_sun_caipin',array('uniacid'=>$_W['uniacid'],'cid'=>$shopcart['caipin_id']));
        if($caipin['sp_num'] < $shopcart['number']){
            return $this->result(1,'库存不足','');
        }
        if($caipin['xg_num']!=0){
            $sql = 'select a.good_id,a.good_num,a.type from ' . tablename('yzhd_sun_order') . 'a where uniacid=' . $_W['uniacid'] . " and (a.type=0 or a.type=4 and a.openid='$openid')";
            $order = pdo_fetchall($sql);
            $new_array = array();
            foreach ($order as $k=>$v){
                if(in_array($caipin['cid'],explode(',',$v['good_id']))){
                    $new_array[] = $v;
                }
            }
            foreach ($new_array as $k=>$v){
                $new_array[$k]['good_id']  =  explode(',',$v['good_id']);
                $new_array[$k]['good_num']  =  explode(',',$v['good_num']);
            }
            $new_num = 0;
            foreach ($new_array as $k=>$v){
                foreach ($v['good_id'] as $kk=>$vv){
                    foreach ($v['good_num'] as $kkk=>$vvv){
                        if($kk==$kkk){
                            if($caipin['cid']==$vv){
                                $new_num += $vvv;
                            }
                        }
                    }
                }
            }
            if($caipin['xg_num'] <= $shopcart['number']  + $new_num){//2<
                return $this->result(1,'该商品总限购数量' . $caipin['xg_num'],'');
            }
        }
        $price = $shopcart['price'] / $shopcart['number'];
        $res = pdo_update('yzhd_sun_shopcart',array('number +='=>1,'price +='=>$price),array('uniacid'=>$_W['uniacid'],'id'=>$id));
        return $this->result(0,'',$res);
    }
    //购物车详情的减
    public function doPageShopJian(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $shopcart = pdo_get('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $price = $shopcart['price'] / $shopcart['number'];
        $res = pdo_update('yzhd_sun_shopcart',array('number -='=>1,'price -='=>$price),array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $shopcart2 = pdo_get('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        if($shopcart2['number']<=0){
            $res = pdo_delete('yzhd_sun_shopcart',array('id'=>$id,'uniacid'=>$_W['uniacid']));
        }
        return $this->result(0,'',$res);
    }

    //清空购物车
    public function doPageDeleteCart(){
        global $_GPC,$_W;
        $bid = intval($_GPC['bid']);
        $res = pdo_delete('yzhd_sun_shopcart',array('uniacid'=>$_W['uniacid'],'bid'=>$bid));
        return $this->result(0,'',$res);
    }
    /**
     * 生成小程序码
     *
     */
    //小程序码
    public function doPageGetwxCode(){
        global $_W, $_GPC;

        $access_token = $this->getaccess_token();
        $scene = $_GPC["scene"];
        $page = $_GPC["page"];
        $width = $_GPC["width"]?$_GPC["width"]:430;
        $auto_color = $_GPC["auto_color"]?$_GPC["auto_color"]:false;
        $line_color = $_GPC["line_color"]?$_GPC["line_color"]:'{"r":"0","g":"0","b":"0"}';
        $is_hyaline = $_GPC["is_hyaline"]?$_GPC["is_hyaline"]:false;

        //$url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token;

        //$data='{"scene":"'.$scene.'","page":"'.$page.'","width":"'.$width.'","is_hyaline":"'.$is_hyaline.'"}';
        //$data["scene"] = $scene;
        $data["path"] = $page;
        $data["width"] = $width;
        //$data["auto_color"] = $auto_color;
        //$data["line_color"] = $line_color;
        //$data["is_hyaline"] = $is_hyaline;
        //$data["is_hyaline"] = $is_hyaline;
        // $data ='{
        //     "scene": "'.$scene.'",
        //     "page": "'.$page.'",
        //     "width": "'.$width.'",
        //     "is_hyaline": "'.$is_hyaline.'"
        // }';
        $json_data = json_encode($data);
        //echo $json_data;exit;

        $return = $this->request_post($url,$json_data);
        //将生成的小程序码存入相应文件夹下
        $imgname = time().rand(10000,99999).'.jpg';
        @require_once (IA_ROOT . '/framework/function/file.func.php');
        @$filename=ltrim($imgname,'attachment/');
        @file_remote_upload($filename);
        //echo json_encode($return);exit;
        file_put_contents("../attachment/".$imgname,$return);
        echo json_encode($imgname);
    }

    //删除小程序码
    public function doPageDelCtxImg(){
        global $_GPC,$_W;
        $wxcode = $_GPC['wxcode'];
        $filename = '../attachment/'.$wxcode;
        if(file_exists($filename)){
            $info ='删除成功';
            unlink($filename);
        }else{
            $info ='没找到:'.$filename;
        }
        echo $info;
    }


    public function getaccess_token(){
        global $_W, $_GPC;
        $res=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
        $appid=$res['appid'];
        $secret=$res['appsecret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data,true);
        return $data['access_token'];
    }

    public function request_post($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $tmpInfo = curl_exec($ch);
        $error = curl_errno($ch);
        curl_close($ch);
        if ($error) {
            return false;
        }else{
            return $tmpInfo;
        }
    }

//    public function doPageGetVipUsers()
//    {
//        global $_W, $_GPC;
//
//        $vip_users = pdo_getall('yzhd_sun_vips', array(), array(), '', array('id' => 'desc'));
//        foreach ($vip_users as $key => $val) {
//            $vip_users[$key]['user_info'] = pdo_get('yzhd_sun_user', array('openid' => $val['openid']));
//        }
//        $vip_users = array_slice($vip_users, 0, 5);
//        $this->_returnData(0, 'ok', $vip_users);
//    }

    public function doPageGetVipUsers()
    {
        global $_W, $_GPC;

        $vip_users = pdo_getall('yzhd_sun_user_vipcard', array('uniacid'=>$_W['uniacid']), array(), '', array('id' => 'desc'));
        foreach ($vip_users as $key => $val) {
            $vip_users[$key]['user_info'] = pdo_get('yzhd_sun_user', array('openid' => $val['uid']));
        }
        $vip_users = array_slice($vip_users, 0, 5);
        $this->_returnData(0, 'ok', $vip_users);
    }


    /**
     * 输出json格式的数据
     * @param status int
     * @param data array
     * @return void
     */
    private function _returnData($status = 0, $msg = '',  $data = [])
    {
        $return_data['status'] = $status;
        $return_data['msg'] = $msg;
        $return_data['data'] = $data;
        die(json_encode($return_data));
    }

    private function _returnSquarePoint($lng, $lat,$distance = '5')
    {
        $earthdata=6371;//地球半径，平均半径为6371km
        $dlng =  2 * asin(sin($distance / (2 * $earthdata)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
        $dlat = $distance/$earthdata;
        $dlat = rad2deg($dlat);
        $arr=array(
            'left_top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
            'right_top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
            'left_bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
            'right_bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
        );
        return $arr;
    }

    private function _createOrder($data = array())
    {
        $data['out_trade_no'] = date('Ymd', time()) . $data['user_id'] . substr(microtime(), -4, 4);
        $data['money'] = $data['money'];
        $data['order_num'] = $data['out_trade_no'];
        $data['time'] = time();
        $data['state'] = 1;
        $data['good_money'] = $data['money'];
        pdo_insert('yzhd_sun_order', $data);
        $id = pdo_insertid();
        return $id;
    }

    private function _arraySequence($array, $field, $sort = 'SORT_DESC')
    {
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        array_multisort($arrSort[$field], constant($sort), $array);
        return $array;
    }
    // END
//判断是否管理员进入
    public function doPageComeInBackstage(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        if(!$openid){
            return $this->result(1,'用户信息错误','');
        }
        $user = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['openid']),'id');
        if(!$user){
            return $this->result(1,'请授权登录','');
        }
        $branch = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'user_id'=>$user,'stutes'=>1));
        if(!$branch){
            $auth = pdo_get('yzhd_sun_auth',array('uniacid'=>$_W['uniacid'],'uid'=>$user));
            if(!$auth){
                return $this->result(1,'该入口仅限商家进入','');
            }else{
                return $this->result(0,'',$auth);
            }
        }else{
            $auth = pdo_get('yzhd_sun_auth',array('uniacid'=>$_W['uniacid'],'uid'=>$user,'bid'=>$branch['id']));
            if(!$auth){
                $data = array(
                    'bid'=>$branch['id'],
                    'uid'=>$user,
                    'auth'=>1,
                    'uniacid'=>$_W['uniacid'],
                    'create_time'=>time(),
                );
                $res = pdo_insert('yzhd_sun_auth',$data);
                return $this->result(1,'因该功能更新，如果您是已入驻商家，重新点击进入即可！','');
            }else{
                return $this->result(0,'',$auth);
            }
        }
    }
    //查找核销员
    public function doPageLookUpQrcode(){
        global $_W,$_GPC;
        $uid = intval($_GPC['uid']);
        $user = pdo_get('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$uid));
        if(!$user){
            return $this->result(1,'该用户不存在，请重新输入','');
        }
        return $this->result(0,'',$user);
    }

    //添加多个核销员
    public function doPageAddQrcodeUser(){
        global $_GPC,$_W;
        $uid = $_GPC['uid'];
        $openid = $_GPC['openid'];
        $boss = pdo_get('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        $waiter = pdo_get('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$uid));
        if(!$boss || !$waiter){
            return $this->result(1,'用户信息错误','');
        }
        $store = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'user_id'=>$boss['id']));
        if(!$store){
            return $this->result(1,'您不是商家无法添加核销员','');
        }
        $user_info = pdo_get('yzhd_sun_auth',array('uniacid'=>$_W['uniacid'],'uid'=>$uid));
        if($user_info){
            return $this->result(1,'该用户已经是核销员，无法重复添加！','');
        }
        $data = array(
            'bid'=>$store['id'],
            'uid'=>$waiter['id'],
            'auth'=>2,
            'uniacid'=>$_W['uniacid'],
            'create_time'=>time(),
        );
        $res = pdo_insert('yzhd_sun_auth',$data);
        return $this->result(0,'',$res);
    }


    //查找已经是该商家的核销员
    public function doPageMarketing(){
        global $_W,$_GPC;
        $user = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['openid']),'id');
        if(!$user){
            return $this->result(1,'请授权登录','');
        }
        $branch = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'user_id'=>$user,'stutes'=>1));
        if(!$branch){
            return $this->result(1,'商家信息错误，请重新登录！','');
        }else{
            $auth = pdo_getall('yzhd_sun_auth',array('uniacid'=>$_W['uniacid'],'bid'=>$branch['id'],'auth'=>2));

            foreach ($auth as $k=>$v){
                static $a = [];
                $userinfo = pdo_get('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$v['uid']));
                $userinfo['createtime'] = date('Y-m-d H:i:s',$v['create_time']);
                $a[] = $userinfo;

            }
            return $this->result(0,'',$a);
        }
    }

    //删除核销员
    public function doPageDelMarketing(){
        global $_GPC,$_W;
        $id = $_GPC['uid'];
        $user = pdo_get('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        if(!$user){
            return $this->result(1,'用户信息错误！导致无法删除','');
        }
        $res = pdo_delete('yzhd_sun_auth',array('uniacid'=>$_W['uniacid'],'uid'=>$user['id']));
        return $this->result(0,'',$res);
    }

    /**
     * 粉丝卡
     */
    //**************************************start*************************************
    //获取粉丝卡内容
    public function doPageGetFansCard()
    {
        global $_W, $_GPC;
        $card_info = pdo_get('yzhd_sun_vipcard', array('uniacid'=>$_W['uniacid']));
        echo json_encode($card_info);
    }

    //查询是否已经购买粉丝卡
    public function doPageIsVip(){
        global $_W,$_GPC;
        $openid = $_GPC['openid'];
        $user = pdo_get('yzhd_sun_user_vipcard',array('uid'=>$openid,'uniacid'=>$_W['uniacid'],'status'=>0,'dq_time >='=>time()));
        if($user){
            $user['dq_time'] = date('Y-m-d',$user['dq_time']);
            echo json_encode($user);
        }else{
            echo 2;
        }
    }

    //获取粉丝卡类型
    public function doPageVipType(){
        global $_GPC,$_W;
        $vip_card_type = pdo_getall('yzhd_sun_vip',array('uniacid'=>$_W['uniacid'],'status'=>1));
        echo json_encode($vip_card_type);
    }

    //用户购买粉丝卡
    public function doPageBuyVipCard(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $username = $_GPC['username'];
        $tel = $_GPC['tel'];
        if(!$username || !$tel){
            return $this->result(1,'请输入用户名或联系电话！','');
        }
        if(!$openid){
            return $this->result(1,'用户信息错误！','');
        }
        $vip_info = pdo_get('yzhd_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        if(!$vip_info){
            return $this->result(1,'该会员卡类型不存在','');
        }
        $total_fee = $vip_info['price'];
        include IA_ROOT . '/addons/yzhd_sun/wxpay.php';
        $res = pdo_get('yzhd_sun_system', array('uniacid' => $_W['uniacid']));
        $appid = $res['appid'];
        $mch_id = $res['mchid'];
        $key = $res['wxkey'];
        $out_trade_no = $mch_id . time();
        if (empty($total_fee)) {//货款为0时
            $body = "payorder";
            $total_fee = floatval(99 * 100);
        } else {
            $body = "payorder";
            $total_fee = floatval($total_fee * 100);
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
        $return = $weixinpay->pay();
        echo json_encode($return);

    }

    //购买会员卡支付成功
    public function doPageBuySuccess(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $username = $_GPC['username'];
        $tel = $_GPC['tel'];
        if(!$username || !$tel){
            return $this->result(1,'请输入用户名或联系电话！','');
        }
        if(!$openid){
            return $this->result(1,'用户信息错误！','');
        }
        $vip_info = pdo_get('yzhd_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        if(!$vip_info){
            return $this->result(1,'该会员卡类型不存在','');
        }
        $time = 24 * 60 * 60 * $vip_info['day'];
        //查询是否已购买过
        $result = pdo_get('yzhd_sun_user_vipcard',array('uniacid'=>$_W['uniacid'],'uid'=>$openid));
        $data = array(
            'vipcard_id'=>$_GPC['id'],
            'card_number' => date('Ym',time()) . rand(1000,9999),
            'buy_time'=>time(),
            'status'=>0,
            'dq_time'=>time() + $time,
            'username'=>$_GPC['username'],
            'tel'=>$_GPC['tel'],
        );
        if($result){
            //已经购买
            $res = pdo_update('yzhd_sun_user_vipcard',$data,array('uid'=>$openid,'uniacid'=>$_W['uniacid']));
        }else{//未购买过
            $data['uid'] = $openid;
            $data['uniacid']=$_W['uniacid'];
            pdo_update('yzhd_sun_vip_card',array('v_pay_num +='=>1),array('uniacid'=>$_W['uniacid']));
            $res = pdo_insert('yzhd_sun_user_vipcard',$data);
        }
        $user_id = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid']),'id');
        $order['user_id'] = $user_id;
        $order['user_name'] = $_GPC['username'];
        $order['tel'] = $_GPC['tel'];
        $order['user_name'] = $_GPC['username'];
        $order['good_name'] = '粉丝卡';
        $order['order_num'] = date('YmdHis') . rand(1000,9999);
        $order['out_trade_no'] = $order['order_num'];
        $order['uniacid'] = $_W['uniacid'];
        $order['type'] = 2;
        $order['money'] = $vip_info['price'];
        $order['good_money'] = $vip_info['price'];
        $order['state'] = 3;
        $order['openid'] = $openid;
        pdo_insert('yzhd_sun_order',$order);
        echo json_encode($res);
    }

    //激活会员卡
    public function doPageActiveCode(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $uid = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid),'id');
        $code = $_GPC['code'];
        //先查找出对应的会员卡激活码
        $vipCode = pdo_get('yzhd_sun_vipcode',array('uniacid'=>$_W['uniacid'],'vc_code'=>$code));
        if($vipCode){
            //对应会员卡类型
            $vipcard = pdo_get('yzhd_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$vipCode['vipid']));
            $time = time() + ($vipcard['day'] * 24 * 60 * 60);//对应的激活码可获得的天数
            $vipCode['starttime'] = strtotime($vipCode['vc_starttime']);
            $vipCode['endtime'] = strtotime($vipCode['vc_endtime']);
            if($vipCode['vc_isuse']==1){
                return $this->result(1,'该激活码已使用过，请重新输入激活码！','');
            }
            if($vipCode['starttime']>time()){
                return $this->result(1,'该激活码未到使用时间，请重新输入激活码！','');
            }
            if($vipCode['endtime']<time()){
                return $this->result(1,'该激活码已过期，请重新输入激活码！','');
            }
            //判断是否已经购买过会员卡
            $userInfo = pdo_get('yzhd_sun_user_vipcard',array('uniacid'=>$_W['uniacid'],'uid'=>$_GPC['openid']));
            if($userInfo){//已经购买
                //判断是否已经到期
                if($userInfo['dq_time']<time()){//已经到期
                    $res = pdo_update('yzhd_sun_user_vipcard',array('dq_time'=>$time,'status'=>0),array('uniacid'=>$_W['uniacid'],'id'=>$userInfo['id']));
                    if($res){
                        $result =  pdo_update('yzhd_sun_vipcode',array('vc_isuse'=>1,'uid'=>$uid),array('uniacid'=>$_W['uniacid'],'id'=>$vipCode['id']));
                    }
                }else{
                    //未到期
                    $times = $vipcard['day'] * 24 * 60 * 60;//对应的激活码可获得的天数
                    $res = pdo_update('yzhd_sun_user_vipcard',array('dq_time +='=>$times),array('uniacid'=>$_W['uniacid'],'id'=>$userInfo['id']));
                    if($res){
                        $result = pdo_update('yzhd_sun_vipcode',array('vc_isuse'=>1,'uid'=>$uid),array('uniacid'=>$_W['uniacid'],'id'=>$vipCode['id']));
                    }
                }
                return $this->result(0, '', $result);
            }else{
                //未购买过会员卡
                $data = array(
                    'uid' => $openid,
                    'vipcard_id' => $vipCode['vipid'],
                    'card_number' => date('Ym',time()) . rand(1000,9999),
                    'buy_time' => time(),
                    'uniacid' => $_W['uniacid'],
                    'status'=>0,
                    'dq_time'=>$time,
                    'username'=>$_GPC['username'],
                    'tel'=>$_GPC['tel'],
                );
                $res = pdo_insert('yzhd_sun_user_vipcard', $data);
                pdo_update('yzhd_sun_vipcode',array('vc_isuse'=>1,'uid'=>$uid),array('uniacid'=>$_W['uniacid'],'id'=>$vipCode['id']));
                return $this->result(0, '', $res);
            }
        }else{
            return $this->result(1,'请输入正确的激活码！','');
        }

    }

    //可提现金额
    public function doPagePutForward(){
        global $_W,$_GPC;
        $openid = $_GPC['openid'];
        //先查找商家ID
        $userid = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid),'id');
        $store = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'user_id'=>$userid));
        if($store){
            //查询该商家账号下金额
            return $this->result(0,'',$store);
        }else{
            return $this->result(0,'没有商家',$store);
        }
    }

    //提现操作
    public function doPageInputStoreMoney(){
        global $_GPC,$_W;
        $system = pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
        $person = $system['tx_sxf']*0.01;//手续费
        $openid = $_GPC['openid'];
        $accountnumber = $_GPC['accountnumber'];
        $comaccountnumber = $_GPC['comaccountnumber'];
        $putmoney = $_GPC['putmoney'];
        $username = $_GPC['username'];
        $canbeInput = $_GPC['canbeInput'];
        if(!$accountnumber||!$comaccountnumber || !$putmoney || !$username){
            return $this->result(1,'请填写完整信息！','');
        }
        if($accountnumber!=$comaccountnumber){
            return $this->result(1,'输入的微信号不一致！','');
        }
        //先查找商家ID
        $userid = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid),'id');
        $store = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'user_id'=>$userid));
        if($store){
            //查询该商家账号下金额
            if($canbeInput > $store['canbeput']){
                return $this->result(1,'提现金额大于可提现金额！','');
            }else{
                $data = array(
                    'name' => $username,
                    'username'=> $accountnumber,
                    'type' => 2,
                    'time' => time(),
                    'state' => 1,
                    'tx_cost' => $putmoney,
                    'sj_cost' => $putmoney - ($putmoney * $person) - ($putmoney * $system['commission_cost']*0.01),
                    'user_id' => $userid,
                    'uniacid' => $_W['uniacid'],
                    'store_id' => $store['id'],
                    'method' => 2,
                );
                $res = pdo_insert('yzhd_sun_withdrawal',$data);
                if($res){
                    $result =  pdo_update('yzhd_sun_branch',array('canbeput -='=>$putmoney,'putprice +=' => $putmoney),array('uniacid'=>$_W['uniacid'],'id'=>$store['id']));
                }else{
                    return $this->result(1,'信息提交失败，请重新提交！','');
                }
                return $this->result(0,'',$result);
            }
        }else{
            return $this->result(1,'系统错误！','');
        }
    }

    //**************************************end*************************************
    /*
     * 获取微信支付的数据
     *
     */
    public function doPageOrderarr()
    {
        global $_GPC,$_W;

        $total_fee = $_GPC['price'];
        include IA_ROOT . '/addons/yzhd_sun/wxpay.php';
        $res = pdo_get('yzhd_sun_system', array('uniacid' => $_W['uniacid']));
        $appid = $res['appid'];
        $openid = $_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
        $mch_id = $res['mchid'];
        $key = $res['wxkey'];
        $out_trade_no = $mch_id . time();
        if (empty($total_fee)) {//货款为0时
            $body = "payorder";
            $total_fee = floatval(99 * 100);
        } else {
            $body = "payorder";
            $total_fee = floatval($total_fee * 100);
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
        $return = $weixinpay->pay();
        echo json_encode($return);

    }
    //二维码核销商品订单
    public function doPageWriteOffOrder(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        if (empty($openid)) $this->_returnData(1, '用户错误');
        $code = $_GPC['code'];
        if (empty($code)) $this->_returnData(2, '券码错误');
        $code_type = substr($code,0,2);
        if($code_type=='dj'){
            $voucher = pdo_get('yzhd_sun_voucher',array('uniacid'=>$_W['uniacid'],'code'=>$code));
            if(!$voucher){
                return $this->result(1,'该二维码不存在或已被删除','');
            }
            $order = pdo_get('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$voucher['order_id']));
            $order['good_img'] = explode(',',$order['good_img']);
            if(!$order){
                return $this->result(1,'该订单不存在或已被删除','');
            }
            return $this->result(0,'0',$order);
        }elseif ($code_type=='cp'){
            $sql = ' SELECT * FROM ' . tablename('yzhd_sun_coupon') . ' a ' . ' JOIN ' . tablename('yzhd_sun_user_coupon') . ' b ' . ' ON ' . ' a.id=b.cid ' . ' WHERE ' . ' b.uniacid=' . $_W['uniacid'] . ' AND ' . ' b.code=' . "'$code'";
            $coupon = pdo_fetch($sql);
            if(!$coupon){
                return $this->result(1,'该优惠券不存在','');
            }
            if($coupon['expire_date']<date(time())){
                return $this->result(1,'该优惠券已过期','');
            }
            return $this->result(0,'1',$coupon);
        }else{
            return $this->result(1,'该二维码不存在！','');
        }
    }

    //确认核销
    public function doPageWriteOffSure(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $userinfo = pdo_get('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        if(!$userinfo){
            return $this->result(1,'用户不存在','');
        }
        $auth = pdo_get('yzhd_sun_auth',array('uniacid'=>$_W['uniacid'],'uid'=>$userinfo['id']));
        if(!$auth){
            return $this->result(1,'您无权核销该订单','');
        }
        $branch = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$auth['bid']));
        $order_id = $_GPC['order_id'];
        $code_type = intval($_GPC['code_type']);
        if($code_type==0){
            $orderinfo = pdo_get('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$order_id));
            if($orderinfo['branch_id']!=$branch['id']){
                return $this->result(1,'您无权核销该订单','');
            }
            if(!$orderinfo){
                return $this->result(1,'该订单号不存在','');
            }
            if($orderinfo['state']==4 ||$orderinfo['state']==5){
                return $this->result(1,'该订单已完成！','');
            }
            if($orderinfo['state']==3){
                $res = pdo_update('yzhd_sun_order',array('state'=>4,'complete_time'=>time(),'writer'=>$userinfo['name']),array('id'=>$order_id));
                if($res){
                    $result = pdo_update('yzhd_sun_branch',array('allprice +='=>$orderinfo['money'],'canbeput +='=>$orderinfo['money']),array('id'=>$orderinfo['branch_id']));
                }else{
                    return $this->result(1,'核销失败！','');
                }
                return $this->result(0,'',$result);
            }else{
                return $this->result(1,'核销信息错误，请核对信息后重试！','');
            }
        }elseif($code_type==1){
            $user_coupon = pdo_get('yzhd_sun_user_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$order_id));
            $coupon = pdo_get('yzhd_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$user_coupon['cid']));
            if($user_coupon['use_num'] >=  $user_coupon['xl_frequency']){
                return $this->result(1,'该优惠券次数已使用完！','');
            }
            if($coupon['branch_id'] != $branch['id']){
                return $this->result(1,'您无权核销该优惠券','');
            }
            $res = pdo_update('yzhd_sun_user_coupon',array('use_time'=>time(),'use_num +='=>1),array('id'=>$order_id));
            return $this->result(0,'',$res);
        }else{
            return $this->result(1,'系统信息错误！','');
        }

    }


    //二维码核销
    public function doPageUseQrcode()
    {
        global $_W, $_GPC;

        $openid = $_GPC['openid'];
        if (empty($openid)) $this->_returnData(1, '用户错误');
        $code = $_GPC['code'];
        if (empty($code)) $this->_returnData(2, '券码错误');
        $code_type = substr($code,0,2);
        if($code_type=='cp'){
            $user_coupon = pdo_get('yzhd_sun_user_coupon',array('uniacid'=>$_W['uniacid'],'code'=>$code));
            $userid = $user_coupon['openid'];
            $coupon = pdo_get('yzhd_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$user_coupon['cid']));
            if(!$coupon){
                return $this->result(1,'该优惠券不存在或已删除！','');
            }
        }
        if($user_coupon){
            if($user_coupon['is_use']!=0){
                return $this->result(1,'该优惠券已使用！','');
            }
        }
        $user_info = pdo_get('yzhd_sun_user', array('openid' => $openid, 'state' => 1,'uniacid'=>$_W['uniacid']));
        if (empty($user_info)) $this->_returnData(3, '用户信息错误');
        $type = $this->_getQrcodeType($code);//获取券码的类型 cp=coupon dj=代金券

        if (! $type) $this->_returnData(4, '券码格式错误');//_returnData是封装了json输出
        $result = $this->_checkQrcode($type, array('openid' => $userid, 'code' => $code));//把券码类型 各种参数传给_checkQrcode 由_checkQrcode统一执行

        if ($result) {
            $this->_returnData(0, '使用券码成功');
        }
        $this->_returnData(-1, '使用券码失败');
    }

    private function _getQrcodeType($code)
    {
        if (empty($code) || strlen($code) <= 2) return false;//如果是空或者长度<2直接返回false
        $char = substr($code, 0, 2);//类型一定是前两位
        return $char;	//返回类型
    }

    private function _checkQrcode($type, $data)
    {
        $types = array('dj', 'cp');//允许的券码类型
        //echo $type;exit;
        if (! in_array($type, $types)) return false;//如果不是允许的券码类型 直接返回

        $method_name = "_{$type}Qrcode";//拼接方法名称

        if (! method_exists($this, $method_name)) return false;//检测方法是否存在

        return call_user_func(array($this, $method_name), $data);	//调用方法 并且传参 举个例子 $type = dj $method_name = _djQrcode 最后这一句就相当于 $this->_djQrcode($data) 调用这个方法并且传参 只不过这里的调用是动态的 方法名不是写死的
    }

    private function _djQrcode($data)
    {
        //这里很简单 先查找是不是存在该代金券 不存在直接false 存在更新状态
        $where['code'] = $data['code'];
        $where['is_use'] = 0;
        $where['openid'] = $data['openid'];
        $info = pdo_get('yzhd_sun_voucher', $where);
        if (empty($info)) return false;
        $up_data['is_use'] = 1;
        $up_data['use_time'] = time();
        $up_data['use_openid'] = $data['openid'];
        $this->_order2ok($info['out_trade_no']);//因为代金券跟订单关联 当扫码核销后 订单应该是已完成 所以也要更新订单的状态
        return $this->_qrcodeStatus('dj', $up_data, $where);	//更新券码的相关状态

    }

    private function _cpQrcode($data)
    {

        $where['code'] = $data['code'];
        $where['is_use'] = 0;
        $where['openid'] = $data['openid'];
        $info = pdo_get('yzhd_sun_user_coupon', $where);
        //print_r($info);exit;
        if (empty($info)) return false;
        $up_data['is_use'] = 1;
        $up_data['use_time'] = time();
        $up_data['use_openid'] = $data['openid'];
        return $this->_qrcodeStatus('cp', $up_data, $where);
    }

    private function _qrcodeStatus($type, $data, $where)
    {
        $table_name = '';
        switch ($type) {
            case 'dj':
                $table_name = 'yzhd_sun_voucher';
                break;
            case 'cp':
                $table_name = 'yzhd_sun_user_coupon';
                break;
        }
        return pdo_update($table_name, $data, $where);
    }

    private function _order2ok($out_trade_no)
    {
        //。。。
        $data['state'] = 4;
        $where['out_trade_no'] = $out_trade_no;
        $where['type'] = 0;
        return pdo_update('yzhd_sun_order', $data, $where);
    }




}
