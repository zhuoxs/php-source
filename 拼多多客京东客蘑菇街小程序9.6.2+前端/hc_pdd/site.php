<?php
/**
 * 会创拼团模块微站定义
 *
 * @author huichuang
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
require_once IA_ROOT."/addons/hc_pdd/inc/model.class.php";
require_once IA_ROOT."/addons/hc_pdd/inc/api.class.php";  
class Hc_pddModuleSite extends WeModuleSite {

    public function getToken(){
        global $_GPC, $_W;
        $account = pdo_get('account_wxapp', array('uniacid' => $_W['uniacid']));
        $appid = $account['key'];
        $appsecret = $account['secret'];
        $file = file_get_contents("../addons/hc_pdd/access_token".$_W['uniacid'].".json",true);
        $result = json_decode($file,true);
        if(time() > $result['expires'] or empty($file)){
            $data = array();
            $data['access_token'] = $this->getNewToken($appid,$appsecret);
            $data['expires']=time()+7000;
            $jsonStr =  json_encode($data);
            $fp = fopen("../addons/hc_pdd/access_token".$_W['uniacid'].".json", "w");
            fwrite($fp, $jsonStr);
            fclose($fp);
            return $data['access_token'];
        }else{
            return $result['access_token'];
        }
    }

    public function getNewToken($appid,$appsecret){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $access_token_Arr = $this->https_request($url);
        return $access_token_Arr['access_token'];
    }

    public function https_request($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $out = curl_exec($ch);
        curl_close($ch);
        return  json_decode($out,true);
    }

    //查询京东客商品列表
    public function doWebtest(){
        global $_GPC, $_W;
        $account = pdo_get('account_wxapp', array('uniacid' => $_W['uniacid']));
        $appid = $account['key'];
        $appsecret = $account['secret'];
        $token = $this->getToken();
        $account_api = WeAccount::create();
        $token2 = $account_api->getAccessToken();
        var_dump($token);
        echo "</br>";
        var_dump($token2);

    }

	
    public function MakeSign($params,$signkey)
    {
        $string = '';
        //签名步骤一：按字典序排序参数
        ksort($params);
        foreach ($params as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $string .= $k.$v;
            }
        }
        $string = trim($string, "&");
        //签名步骤二：在string后加入KEY
        $string = $signkey.$string.$signkey;
        //签名步骤三：MD5加密或者HMAC-SHA256
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    public function doMobileplay()
    {
        global $_GPC, $_W;
        $weid = $_W['uniacid'];
        $type = $_GPC['type'];
        //标题
        $basic['tastefont'] = '马上赢口红';
        $basic['passfont'] ='点击我的口红领取';
        $game['number'][0] = empty($game['number'][0])?6:$game['number'][0];
        $game['number'][1] = empty($game['number'][1])?8:$game['number'][1];
        $game['number'][2] = empty($game['number'][2])?12:$game['number'][2];
        
        $game['speed'][0] = empty($game['speed'][0])?'0.02':$game['speed'][0];
        $game['speed'][1] = empty($game['speed'][1])?'0.03':$game['speed'][1];
        $game['speed'][2] = empty($game['speed'][2])?'0.09':$game['speed'][2];

        $game['usetime'][0] = empty($game['usetime'][0])?20:$game['usetime'][0];
        $game['usetime'][1] = empty($game['usetime'][1])?30:$game['usetime'][1];
        $game['usetime'][2] = empty($game['usetime'][2])?40:$game['usetime'][2];

        if(empty($game['bgm'])){
            $game['bgm'] = $_W['siteroot'].'addons/hc_pdd/public/audio/bg_audio.mp3';
        }
        if(empty($game['insert'])){
            $game['insert'] = $_W['siteroot'].'addons/hc_pdd/public/audio/insert_audio.mp3';
        }
        if(empty($game['collision'])){
            $game['collision'] = $_W['siteroot'].'addons/hc_pdd/public/audio/collision_audio.mp3';
        }
        if(empty($game['passbgm'])){
            $game['passbgm'] = $_W['siteroot'].'addons/hc_pdd/public/audio/success_audio.mp3';
        }
        if(empty($game['succbgm'])){
            $game['succbgm'] = $_W['siteroot'].'addons/hc_pdd/public/audio/gameSuccess_audio.mp3';
        }
        if(empty($game['times'])){
            $game['times'] = $_W['siteroot'].'addons/hc_pdd/public/audio/Countdown_10s_audio.mp3';
        }
        if(empty($game['failbgm'])){
            $game['failbgm'] = $_W['siteroot'].'addons/hc_pdd/public/audio/gameFail_audio.mp3';
        }
        if(empty($game['split'])){
            $game['split'] = $_W['siteroot'].'addons/hc_pdd/public/audio/split_audio.mp3';
        }
        if(empty($game['gamebg'])){
            $game['gamebg'] = $_W['siteroot'].'addons/hc_pdd/public/img/bg.jpg';
        }
        if(empty($game['timesbg'])){

            $game['timesbg'] = $_W['siteroot'].'addons/hc_pdd/public/img/timebox_bg.png';
            $game['tchua'] = $_W['siteroot'].'addons/hc_pdd/public/img/tchua.png';
            $game['y1'] = $_W['siteroot'].'addons/hc_pdd/public/img/y1.png';
            $game['y2'] = $_W['siteroot'].'addons/hc_pdd/public/img/y2.png';

        }
        if(empty($game['customspass'])){

            $game['customspass'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/level_1_main.jpg';

            $game['customspass'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/level_2_mains.jpg';

            $game['customspass'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/level_3_mains.jpg';

        }
        if(empty($game['passicon'])){

            $game['passicon'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_1_active.png';

            $game['passicon'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_2.png';

            $game['passicon'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_2_active.png';

            $game['passicon'][3] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_3.png';

            $game['passicon'][4] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_3_active.png';

            $game['passicon'][5] = $_W['siteroot'].'addons/hc_pdd/public/img/level_3.png';

        }

        if(empty($game['first'])){

            $game['first'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_1_gray.png';

            $game['first'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_1.png';

            $game['first'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/Lipstick_1.png';

        }

        if(empty($game['first_dial'])){

            $game['first_dial'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_1.png';

            $game['first_dial'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_1_split_left.png';

            $game['first_dial'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_1_split_right.png';

        }



        if(empty($game['second'])){

            $game['second'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_2_gray.png';

            $game['second'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_2.png';

            $game['second'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/Lipstick_2.png';

        }

        if(empty($game['second_dial'])){

            $game['second_dial'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_2.png';

            $game['second_dial'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_2_split_right.png';

            $game['second_dial'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_2_split_left.png';

        }



        if(empty($game['third'])){

            $game['third'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_3_gray.png';

            $game['third'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_3.png';

            $game['third'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/Lipstick_3.png';

        }

        if(empty($game['third_dial'])){

            $game['third_dial'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_3.png';

            $game['third_dial'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_3_split_left.png';

            $game['third_dial'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_3_split_right.png';

        }

        foreach ($game as $key => $val) {

            if(is_array($val)){

                foreach ($val as $k => $v) {

                    if(strpos($v,'images') !== false || strpos($v,'audios') !== false || strpos($v,'videos') !== false){

                        $game[$key][$k] = tomedia($v);

                    }

                } 

            }else{

                if(strpos($val,'images') !== false || strpos($val,'audios') !== false || strpos($val,'videos') !== false){

                    $game[$key] = tomedia($val);

                }

            }

        }
        include $this->template('play');
    }


    public function utf8_to_unicode_str($utf8)
    {
        $return = '';

        for ($i = 0; $i < mb_strlen($utf8); $i++) {

            $char = mb_substr($utf8, $i, 1);

            // 3字节是汉字，不转换，4字节才是 emoji
            if (strlen($char) > 3) {
                $char = trim(json_encode($char), '"');
            }
            $return .= $char;
        }
        return $return;
    }

    public function juhecurl($url,$params=false,$ispost=0){
    
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if($ispost)
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
        
}

    public function orderlist($page){
     
        global $_W,$_GPC;
        $_GPC['i'] = $_W['uniacid'];
        //$sort = $_POST['sort'];
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        //$p_id      = '1000318_15130197';
        $client_secret = $set['client_secret'];
        $client_id = $set['client_id'];
        $data_type = 'JSON';        
        $start_update_time = '1522512000';   //总订单
        $end_update_time =time();       
        $timestamp = time();
        //$page = 1;
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'page'.$page.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'page' => $page,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list'];

        return $result;
	}

    public function allorderlist($page,$starttime,$endtime){
     
        global $_W,$_GPC;
        $_GPC['i'] = $_W['uniacid'];
        //$sort = $_POST['sort'];
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        //$p_id      = '1000318_15130197';
        $client_secret = $set['client_secret'];
        $client_id = $set['client_id'];
        $data_type = 'JSON';        
        $start_update_time = $starttime;   //总订单
        $end_update_time = $endtime;       
        $timestamp = time();
        //$page = 1;
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'page'.$page.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'page' => $page,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list'];

        return $result;
    }

   public function ordercount($p_id,$status)
    {
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        //$p_id      = '1000318_15130197';
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        if($status == 1){
            $start_update_time =time()-86400;    //过去24小时
            $end_update_time =time();
        }elseif($status == 0)
        {
            $start_update_time =time()-172800;   //过去48小时
            $end_update_time =time();
        }else{
        	$start_update_time = '1522512000';   //总订单
            $end_update_time =time();
        }       
        $timestamp = time();
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'p_id'.$p_id.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'p_id' => $p_id,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['total_count']; 

        return $result;
    }
    public function ordermoney($p_id)
    {
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        //$p_id      = '1000318_15130197';
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';        
        $start_update_time = '1522512000';   //总订单
        $end_update_time =time();       
        $timestamp = time();
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'p_id'.$p_id.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'p_id' => $p_id,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list']; 

        
        $sum = array_sum(array_column($result, 'promotion_amount'))/100;
        //var_dump($sum);
        return $sum;
    }

    public function Ordermoneydetail($p_id)
    {
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        //$p_id      = '1000318_15130197';
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';        
        $start_update_time = '1522512000';   //总订单
        $end_update_time =time();       
        $timestamp = time();
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'p_id'.$p_id.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'p_id' => $p_id,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list']; 


        	return $result;

        
        //return $result;
    }

	public function doWebtestimg(){
        //ob_end_clean();
        //ob_clean();
        global $_W,$_GPC;        
        $dst_path = $_W['siteroot']."addons/hc_pdd/1.png";//背景图
        $qr_path = $_W['siteroot']."addons/hc_pdd/erweima.png";//小程序码
        //$qr_path = $this->GetQrcode($goods_id,$user_id);//小程序码
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $qr = imagecreatefromstring(file_get_contents($qr_path));       
        //获取水印图片的宽高
        list($qr_w, $qr_h) = getimagesize($qr_path);
        $new_x = 150;
        $new_y = 150;
        $image_p = imagecreatetruecolor($new_x, $new_y); //设置缩略图
        imagecopyresampled($image_p, $qr, 0, 0, 0, 0, $new_x, $new_y, $qr_w, $qr_h);
        imagecopymerge($dst,$image_p,144,560,0,0,$new_x,$new_y,100);
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
        case 1://GIF
           header('Content-Type: image/gif');
           imagegif($dst);
           break;
        case 2://JPG
           header('Content-Type: image/jpeg');
           imagejpeg($dst);
           break;
        case 3://PNG
           header('Content-Type: image/png');          
           imagepng($dst);
           break;
        default:
           break;
        }
        
        /*$filename = dirname(__FILE__)."/template/poster/poster.jpg";
        imagepng($dst,$filename);
        imagedestroy($dst);*/
	} 



 

	/**
	 * 优惠券搜索
	 * @return [type] [description]
	 */
	public function doWebSo() {
        global $_GPC, $_W;
        $sort_type = $_POST['rankno'];
        if(empty($sort_type)){
            $sort_type = '0';
        }
        $keyword = $_GPC['keyword'];
        if(empty($keyword)){
            $keyword = '';
        }
        //$page=1+$pageNum;
        $page = max(intval($_GPC['page']), 1);
        $pagesize = 20;

        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.search';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'keyword'.$keyword.'page'.$page.'page_size20sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_coupontrue'.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);

        //echo $sign;
        $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'keyword'   => $keyword,
            'client_id' => $client_id,
            'page'      => $page,
            'page_size' => '20',
            'sort_type' => $sort_type,
            'with_coupon' => 'true',
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['goods_search_response']['goods_list'];

        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            $list[$k]['commission']       = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']/100000),2);//佣金
        }

        $total = $arr['goods_search_response']['total_count'];
        //$total = intval($total / 20) + 1;
        $pager = pagination($total, $page, $pagesize);

       // var_dump($total);

		include $this->template('so');
}

	
	public function doWebAdv() {
		global $_W,$_GPC;
		$where['uniacid'] = $_W['uniacid'];

		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

		$list = pdo_getslice('hcpdd_adv',$where,array($pageindex, $pagesize),$total,array(),'','displayorder asc');
		$page = pagination($total, $pageindex, $pagesize);

		//var_dump($list);

		include $this->template('adv');
	}
	
	public function doWebAdv_post() {
		global $_W,$_GPC;
		$id = $_GPC['id'];

		if($_GPC['act']=='add'){
			$data['uniacid'] = $_W['uniacid'];
			empty($_GPC['displayorder'])?'':$data['displayorder'] = $_GPC['displayorder'];
			empty($_GPC['advname'])?'':$data['advname'] = $_GPC['advname'];
			empty($_GPC['link'])?'':$data['link'] = $_GPC['link'];
			empty($_GPC['thumb'])?'':$data['thumb'] = $_GPC['thumb'];
			empty($_GPC['enabled'])?'':$data['enabled'] = $_GPC['enabled'];
            empty($_GPC['jump'])?'':$data['jump'] = $_GPC['jump'];
            empty($_GPC['xcxpath'])?'':$data['xcxpath'] = $_GPC['xcxpath'];
            empty($_GPC['xcxappid'])?'':$data['xcxappid'] = $_GPC['xcxappid'];
            empty($_GPC['diypic'])?'':$data['diypic'] = $_GPC['diypic'];

			$result = pdo_insert('hcpdd_adv', $data);
			
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('adv'));
			}
		}

		if($_GPC['act']=='edit'){
			$data['uniacid'] = $_W['uniacid'];
			$data['displayorder'] = $_GPC['displayorder'];
			$data['advname'] = $_GPC['advname'];
			$data['link'] = $_GPC['link'];
			$data['thumb'] = $_GPC['thumb'];
			$data['enabled'] = $_GPC['enabled'];
            $data['jump'] = $_GPC['jump'];
            $data['xcxpath'] = $_GPC['xcxpath'];
            $data['xcxappid'] = $_GPC['xcxappid'];
            $data['diypic'] = $_GPC['diypic'];

			$result = pdo_update('hcpdd_adv', $data, array('id'=>$_GPC['id']));
			
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('adv'));
			}
		}

		if($_GPC['act']=='del'){
			$result = pdo_delete('hcpdd_adv', array('id'=>$_GPC['id']));
			
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('adv'));
			}
		}
		if($_GPC['act']=='display'){
			$result = pdo_update('hcpdd_adv',array('displayorder'=>$_GPC['displayorder']),array('id'=>$_GPC['id']));
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('adv'));
			}
		}
		$info = pdo_get('hcpdd_adv',array('id'=>$id));

		include $this->template('adv_post');
	}
     /**
	 * 分类列表
	 * @return $list
	 */
	public function doWebNav() {
		global $_W,$_GPC;

		$list = pdo_getslice('hcpdd_nav',array('parentid'=>0,'uniacid' => $_W['uniacid']));
		foreach ($list as $key => $value) {
			$second = pdo_getall('hcpdd_nav', array('parentid'=>$value['id'],'uniacid' => $_W['uniacid']));
			$list[$key]['children'] = $second;
			unset($second);
		}
		include $this->template('nav');
	}
	//京东分类接口
    public function doWebJdgoodslist(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));

        $model = new moguapiModel();
        //$app_key = $info['jdappkey'];
        //$AppSecret = $info['jdsecretkey'];

        $list = $model->jdapi_getcatelist(0,0);

        var_dump($list);

    }
	public function doWebNav_post() {
		global $_W,$_GPC;
		$id = $_GPC['id'];

		if($_GPC['act']=='add'){
			$data['uniacid'] = $_W['uniacid']; 
			empty($_GPC['parentid'])?'':$data['parentid'] = $_GPC['parentid'];
			empty($_GPC['name'])?'':$data['name'] = $_GPC['name'];
			empty($_GPC['icon'])?'':$data['icon'] = $_GPC['icon'];
			empty($_GPC['cateid'])?'':$data['cateid'] = $_GPC['cateid'];
			empty($_GPC['jdcateid'])?'':$data['jdcateid'] = $_GPC['jdcateid'];
			empty($_GPC['tpl'])?'':$data['tpl'] = $_GPC['tpl'];
			empty($_GPC['url'])?'':$data['url'] = $_GPC['url'];
			empty($_GPC['displayorder'])?'':$data['displayorder'] = $_GPC['displayorder'];
			empty($_GPC['status'])?'':$data['status'] = $_GPC['status'];
            empty($_GPC['jump'])?'':$data['jump'] = $_GPC['jump'];

			$result = pdo_insert('hcpdd_nav', $data);
			
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('nav'));
			}
		}

		if($_GPC['act']=='edit'){

			$data['uniacid'] = $_W['uniacid']; 
			empty($_GPC['parentid'])?'':$data['parentid'] = $_GPC['parentid'];
			empty($_GPC['name'])?'':$data['name'] = $_GPC['name'];
			empty($_GPC['icon'])?'':$data['icon'] = $_GPC['icon'];
			empty($_GPC['cateid'])?'':$data['cateid'] = $_GPC['cateid'];
			empty($_GPC['jdcateid'])?'':$data['jdcateid'] = $_GPC['jdcateid'];
			empty($_GPC['tpl'])?'':$data['tpl'] = $_GPC['tpl'];
			empty($_GPC['url'])?'':$data['url'] = $_GPC['url'];
			empty($_GPC['displayorder'])?'':$data['displayorder'] = $_GPC['displayorder'];
			$data['status'] = $_GPC['status'];
            $data['jump'] = $_GPC['jump'];


			$result = pdo_update('hcpdd_nav', $data, array('id' => $_GPC['id']));
			if (!empty($result)) {
			    message('更新成功',$this->createWebUrl('nav'));
			}else{
			message('操作失败');
			}
		}

		if($_GPC['act']=='del'){
			$result = pdo_delete('hcpdd_nav', array('id'=>$_GPC['id']));
			
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('nav'));
			}
		}
		if($_GPC['act']=='display'){
			$result = pdo_update('hcpdd_nav',array('displayorder'=>$_GPC['displayorder']),array('id'=>$_GPC['id']));
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('nav'));
			}
		}
        if($_GPC['act']=='delete'){
            $result = pdo_delete('hcpdd_nav', array('uniacid'=>$_W['uniacid']));
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('nav'));
            }
        }
        if($_GPC['act']=='auto'){
            $data1['uniacid'] = $_W['uniacid'];
            $data1['parentid'] = 0;
            $data1['name'] = '美食';
            $data1['cateid'] = 6398;
            $data1['jdcateid'] = 1320;
            $data1['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/meishi.png";;
            $data1['displayorder'] = 1;
            $data1['status'] = 1;
            $data1['jump'] = 0;

            $data2['uniacid'] = $_W['uniacid'];
            $data2['parentid'] = 0;
            $data2['name'] = '母婴';
            $data2['cateid'] = 14966;
            $data2['jdcateid'] = 1319;
            $data2['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/muying.png";;
            $data2['displayorder'] = 2;
            $data2['status'] = 1;
            $data2['jump'] = 0;

            $data3['uniacid'] = $_W['uniacid'];
            $data3['parentid'] = 0;
            $data3['name'] = '水果';
            $data3['cateid'] = 8172;
            $data3['jdcateid'] = 1320;
            $data3['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/shuiguo.png";;
            $data3['displayorder'] = 3;
            $data3['status'] = 1;
            $data3['jump'] = 0;

            $data4['uniacid'] = $_W['uniacid'];
            $data4['parentid'] = 0;
            $data4['name'] = '女装';
            $data4['cateid'] = 210;
            $data4['jdcateid'] = 1315;
            $data4['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/nvzhuang.png";;
            $data4['displayorder'] = 4;
            $data4['status'] = 1;
            $data4['jump'] = 0;

            $data5['uniacid'] = $_W['uniacid'];
            $data5['parentid'] = 0;
            $data5['name'] = '百货';
            $data5['cateid'] = 16989;
            $data5['jdcateid'] = 1620;
            $data5['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/baihuo.png";;
            $data5['displayorder'] = 5;
            $data5['status'] = 1;
            $data5['jump'] = 0;

            $data6['uniacid'] = $_W['uniacid'];
            $data6['parentid'] = 0;
            $data6['name'] = '美妆';
            $data6['cateid'] = 1464;
            $data6['jdcateid'] = 1316;
            $data6['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/meizhuang.png";;
            $data6['displayorder'] = 6;
            $data6['status'] = 1;
            $data6['jump'] = 0;

            $data7['uniacid'] = $_W['uniacid'];
            $data7['parentid'] = 0;
            $data7['name'] = '电器';
            $data7['cateid'] = 6128;
            $data7['jdcateid'] = 737;
            $data7['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/dianqi.png";;
            $data7['displayorder'] = 7;
            $data7['status'] = 1;
            $data7['jump'] = 0;

            $data8['uniacid'] = $_W['uniacid'];
            $data8['parentid'] = 0;
            $data8['name'] = '男装';
            $data8['cateid'] = 239;
            $data8['jdcateid'] = 1315;
            $data8['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/nanzhuang.png";;
            $data8['displayorder'] = 8;
            $data8['status'] = 1;
            $data8['jump'] = 0;

            $data9['uniacid'] = $_W['uniacid'];
            $data9['parentid'] = 0;
            $data9['name'] = '家纺';
            $data9['cateid'] = 9319;
            $data9['jdcateid'] = 15248;
            $data9['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/jiafang.png";;
            $data9['displayorder'] = 9;
            $data9['status'] = 1;
            $data9['jump'] = 0;

            $data10['uniacid'] = $_W['uniacid'];
            $data10['parentid'] = 0;
            $data10['name'] = '鞋包';
            $data10['cateid'] = 11686;
            $data10['jdcateid'] = 11729;
            $data10['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/xiebao.png";;
            $data10['displayorder'] = 10;
            $data10['status'] = 1;
            $data10['jump'] = 0;

            $data11['uniacid'] = $_W['uniacid'];
            $data11['parentid'] = 0;
            $data11['name'] = '运动';
            $data11['cateid'] = 11685;
            $data11['jdcateid'] = 1318;
            $data11['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/yundong.png";;
            $data11['displayorder'] = 11;
            $data11['status'] = 1;
            $data11['jump'] = 0;

            $data12['uniacid'] = $_W['uniacid'];
            $data12['parentid'] = 0;
            $data12['name'] = '文具';
            $data12['cateid'] = 2629;
            $data12['jdcateid'] = 670;
            $data12['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/wenju.png";;
            $data12['displayorder'] = 12;
            $data12['status'] = 1;
            $data12['jump'] = 0;

            $data13['uniacid'] = $_W['uniacid'];
            $data13['parentid'] = 0;
            $data13['name'] = '汽车';
            $data13['cateid'] = 7639;
            $data13['jdcateid'] = 6728;
            $data13['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/qiche.png";;
            $data13['displayorder'] = 13;
            $data13['status'] = 1;
            $data13['jump'] = 0;

            $data14['uniacid'] = $_W['uniacid'];
            $data14['parentid'] = 0;
            $data14['name'] = '家装';
            $data14['cateid'] = 9318;
            $data14['jdcateid'] = 9855;
            $data14['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/jiazhuang.png";;
            $data14['displayorder'] = 14;
            $data14['status'] = 1;
            $data14['jump'] = 0;

            $data15['uniacid'] = $_W['uniacid'];
            $data15['parentid'] = 0;
            $data15['name'] = '办公';
            $data15['cateid'] = 2603;
            $data15['jdcateid'] = 670;
            $data15['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/bangong.png";;
            $data15['displayorder'] = 15;
            $data15['status'] = 1;
            $data15['jump'] = 0;

            $data16['uniacid'] = $_W['uniacid'];
            $data16['parentid'] = 0;
            $data16['name'] = '数码';
            $data16['cateid'] = 2933;
            $data16['jdcateid'] = 652;
            $data16['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/shuma.png";;
            $data16['displayorder'] = 16;
            $data16['status'] = 1;
            $data16['jump'] = 0;

            $data17['uniacid'] = $_W['uniacid'];
            $data17['parentid'] = 0;
            $data17['name'] = '发圈';
            $data17['cateid'] = 0;
            $data17['jdcateid'] = 0;
            $data17['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/faquan.png";;
            $data17['displayorder'] = 17;
            $data17['status'] = 1;
            $data17['jump'] = 1;

            $data18['uniacid'] = $_W['uniacid'];
            $data18['parentid'] = 0;
            $data18['name'] = '代理';
            $data18['cateid'] = 0;
            $data18['jdcateid'] = 0;
            $data18['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/daili.png";;
            $data18['displayorder'] = 18;
            $data18['status'] = 1;
            $data18['jump'] = 2;

            $data19['uniacid'] = $_W['uniacid'];
            $data19['parentid'] = 0;
            $data19['name'] = '红包树';
            $data19['cateid'] = 0;
            $data19['jdcateid'] = 0;
            $data19['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/hongbaoshu.png";;
            $data19['displayorder'] = 19;
            $data19['status'] = 1;
            $data19['jump'] = 3;

            $data20['uniacid'] = $_W['uniacid'];
            $data20['parentid'] = 0;
            $data20['name'] = '领红包';
            $data20['cateid'] = 0;
            $data20['jdcateid'] = 0;
            $data20['icon'] = $_W['siteroot']."addons/hc_pdd/template/img/hongbao.png";;
            $data20['displayorder'] = 20;
            $data20['status'] = 1;
            $data20['jump'] = 4;

            $result = pdo_insert('hcpdd_nav', $data1);
            $result = pdo_insert('hcpdd_nav', $data2);
            $result = pdo_insert('hcpdd_nav', $data3);
            $result = pdo_insert('hcpdd_nav', $data4);
            $result = pdo_insert('hcpdd_nav', $data5);
            $result = pdo_insert('hcpdd_nav', $data6);
            $result = pdo_insert('hcpdd_nav', $data7);
            $result = pdo_insert('hcpdd_nav', $data8);
            $result = pdo_insert('hcpdd_nav', $data9);
            $result = pdo_insert('hcpdd_nav', $data10);
            $result = pdo_insert('hcpdd_nav', $data11);
            $result = pdo_insert('hcpdd_nav', $data12);
            $result = pdo_insert('hcpdd_nav', $data13);
            $result = pdo_insert('hcpdd_nav', $data14);
            $result = pdo_insert('hcpdd_nav', $data15);
            $result = pdo_insert('hcpdd_nav', $data16);
            $result = pdo_insert('hcpdd_nav', $data17);
            $result = pdo_insert('hcpdd_nav', $data18);
            $result = pdo_insert('hcpdd_nav', $data19);
            $result = pdo_insert('hcpdd_nav', $data20);
            if(!empty($result)){
                message('操作成功',$this->createWebUrl('nav'));
            }
        }
		$category = pdo_getall('hcpdd_nav',array('parentid'=>0,'status'=>1));
		$info = pdo_get('hcpdd_nav',array('id'=>$id));

		include $this->template('nav_post');
	}
    //系统设置
    public function doWebSetting(){

    	global $_W,$_GPC;
		if($_GPC['act']=='add'){
			$data['uniacid'] = $_W['uniacid'];
			
			$data['contact'] = $_GPC['contact'];
			$data['contact_qr'] = $_GPC['contact_qr'];
			$data['share_icon'] = $_GPC['share_icon'];
			$data['loginbg'] = $_GPC['loginbg'];
			$data['sohead'] = $_GPC['sohead'];
            $data['pddsobg'] = $_GPC['pddsobg'];
            $data['jdsobg'] = $_GPC['jdsobg'];
			$data['bg_pic'] = $_GPC['bg_pic'];
			$data['title'] = $_GPC['title'];
			$data['enable'] = $_GPC['enable'];
			$data['shenhe'] = $_GPC['shenhe'];
			$data['is_index'] = $_GPC['is_index'];
            $data['contactway'] = $_GPC['contactway'];
            $data['wtype'] = $_GPC['wtype'];
            $data['tx_money'] = $_GPC['tx_money'];
            $data['tx_intro'] = $_GPC['tx_intro'];
            $data['zzappid'] = trim($_GPC['zzappid']);
            $data['getmobile'] = $_GPC['getmobile'];
            
			
			$ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
			if(!empty($ishave)){
				$result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
			}else{
				$result = pdo_insert('hcpdd_set', $data);
			}
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('setting'));
			}
		}
		$info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        if(empty($info['bg_pic'])){
            $info['bg_pic'] = $_W['siteroot']."addons/hc_pdd/template/img/centertop.png";
        }
        if(empty($info['pddsobg'])){
            $info['pddsobg'] = $_W['siteroot']."addons/hc_pdd/template/img/pddsobg.png";
        }
        if(empty($info['jdsobg'])){
            $info['jdsobg'] = $_W['siteroot']."addons/hc_pdd/template/img/jdsobg.png";
        }
        if(empty($info['sohead'])){
            $info['sohead'] = $_W['siteroot']."addons/hc_pdd/template/img/sohead.png";
        }
		include $this->template('setting');
    }
    //系统设置
    public function doWebTop(){

        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            $data['top'] = trim($_GPC['top']);
            $data['goodtop'] = trim($_GPC['goodtop']);
    
            $ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_set', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('top'));
            }
        }
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        include $this->template('top');
    }
    //蘑菇街设置
    public function doWebMoguset(){

        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            $data['client_id'] = trim($_GPC['client_id']);
            $data['client_secret'] = trim($_GPC['client_secret']);
            $data['app_key'] = trim($_GPC['app_key']);
            $data['app_secret'] = trim($_GPC['app_secret']);
            $data['access_token'] = trim($_GPC['access_token']);
            $data['is_mogu'] = $_GPC['is_mogu'];
            $data['mogurate'] = $_GPC['mogurate'];
            $data['mogudailirate'] = $_GPC['mogudailirate'];
            $data['moguzongjianrate'] = $_GPC['moguzongjianrate'];
            $data['uid'] = $_GPC['uid'];

            $data['is_jd'] = $_GPC['is_jd'];
            $data['unionId'] = $_GPC['unionId'];
            //$data['jdappkey'] = $_GPC['jdappkey'];
            //$data['jdsecretkey'] = $_GPC['jdsecretkey'];
            $data['siteid'] = $_GPC['siteid'];
            $data['jdkey'] = $_GPC['jdkey'];
            $data['jdrate'] = $_GPC['jdrate'];
            $data['jddailirate'] = $_GPC['jddailirate'];
            $data['jdzongjianrate'] = $_GPC['jdzongjianrate'];
  
            $ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_set', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('moguset'));
            }
        }
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        $info['url'] = "https://oauth.mogujie.com/authorize?response_type=code&app_key=".$info['app_key']."&redirect_uri=http://we10.66bbn.com/addons/hc_pdd/callback.php";
        include $this->template('moguset');
    }
    //自定义文字
    public function doWebDiyname(){

        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            /*empty($_GPC['client_id'])?'':$data['client_id'] = $_GPC['client_id'];*/
            $data['head_color'] = $_GPC['head_color'];
            $data['search_color'] = $_GPC['search_color'];
            $data['tixianb_color'] = $_GPC['tixianb_color'];
            $data['tixiant_color'] = $_GPC['tixiant_color'];
            $data['share'] = $_GPC['share'];
            $data['sharecolor'] = $_GPC['sharecolor'];
            $data['self'] = $_GPC['self'];
            $data['selfcolor'] = $_GPC['selfcolor'];
            $data['huiyuan'] = $_GPC['huiyuan'];
            $data['indexpic'] = $_GPC['indexpic'];
            $data['indextitle'] = $_GPC['indextitle'];
            $data['zeroshare'] = $_GPC['zeroshare'];
            $data['zerobuy'] = $_GPC['zerobuy'];
            
            $ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_set', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('diyname'));
            }
        }
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        include $this->template('diyname');
    }

    //展示位管理
    public function doWebShow(){

    	global $_W,$_GPC;
		if($_GPC['act']=='add'){
			$data['uniacid'] = $_W['uniacid'];
			/*empty($_GPC['show1'])?'':$data['show1'] = $_GPC['show1'];
			empty($_GPC['show2'])?'':$data['show2'] = $_GPC['show2'];
			empty($_GPC['show3'])?'':$data['show3'] = $_GPC['show3'];
			empty($_GPC['show4'])?'':$data['show4'] = $_GPC['show4'];
			empty($_GPC['show5'])?'':$data['show5'] = $_GPC['show5'];*/

			$data['show1'] = $_GPC['show1'];
			$data['show2'] = $_GPC['show2'];
			$data['show3'] = $_GPC['show3'];
			$data['show4'] = $_GPC['show4'];
			$data['show5'] = $_GPC['show5'];

            $data['rexiao1'] = $_GPC['rexiao1'];
            $data['rexiao2'] = $_GPC['rexiao2'];
            $data['baoyou1'] = $_GPC['baoyou1'];
            $data['baoyou2'] = $_GPC['baoyou2'];
            $data['youhui1'] = $_GPC['youhui1'];
            $data['youhui2'] = $_GPC['youhui2'];
			
			$ishave = pdo_get('hcpdd_show', array('uniacid' => $_W['uniacid']));
			if(!empty($ishave)){
				$result = pdo_update('hcpdd_show', $data ,array('uniacid'=>$_W['uniacid']));
			}else{
				$result = pdo_insert('hcpdd_show', $data);
			}
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('show'));
			}
		}
		$info = pdo_get('hcpdd_show', array('uniacid' => $_W['uniacid']));
        if(empty($info['rexiao1'])){
            $info['rexiao1'] = '实时热销榜';
        }
        if(empty($info['rexiao2'])){
            $info['rexiao2'] = '看看大家都在买什么';
        }
        if(empty($info['baoyou1'])){
            $info['baoyou1'] = '9.9包邮';
        }
        if(empty($info['baoyou2'])){
            $info['baoyou2'] = '全民疯抢，低价包邮';
        }
        if(empty($info['youhui1'])){
            $info['youhui1'] = '品牌优惠';
        }
        if(empty($info['youhui2'])){
            $info['youhui2'] = '大牌保障，尊享品质';
        }
		include $this->template('show');
    }
    //主题推荐
    public function doWebTheme(){

    	global $_W,$_GPC;
		if($_GPC['act']=='add'){
			$data['uniacid'] = $_W['uniacid'];
			$data['name'] = $_GPC['name'];
			$data['banner'] = $_GPC['banner'];
			$data['mainpic'] = $_GPC['mainpic'];
			$data['goods'] = $_GPC['goods'];
			//$data['enabled'] = $_GPC['enabled'];
            $data['jump'] = $_GPC['jump'];
            $data['zhuti_color'] = $_GPC['zhuti_color'];
			
			$ishave = pdo_get('hcpdd_theme', array('uniacid' => $_W['uniacid']));
			if(!empty($ishave)){
				$result = pdo_update('hcpdd_theme', $data ,array('uniacid'=>$_W['uniacid']));
			}else{
				$result = pdo_insert('hcpdd_theme', $data);
			}
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('theme'));
			}
		}
		$info = pdo_get('hcpdd_theme', array('uniacid' => $_W['uniacid']));
        if(empty($info['zhuti_color'])){
            $info['zhuti_color'] = "#8600ff";
        }
        if(empty($info['banner'])){
            $info['banner'] = $_W['siteroot']."addons/hc_pdd/template/img/resou.png";
        }
		include $this->template('theme');
    }

    //发圈设置
    public function doWebCopy_set(){

        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            $data['copy_writer'] = $_GPC['copy_writer'];
            $data['copy_headpic'] = $_GPC['copy_headpic'];
            $data['sptj'] = $_GPC['sptj'];
            $data['scyx'] = $_GPC['scyx'];
            $data['xsbf'] = $_GPC['xsbf'];
            
            $ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_set', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('copy_set'));
            }
        }
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        include $this->template('copy_set');
    }

    //红包树
    public function doWebTree(){

        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            $data['is_tree'] = $_GPC['is_tree'];
            $data['tree_way'] = $_GPC['tree_way'];
            $data['min_treemoney'] = $_GPC['min_treemoney'];
            $data['max_treemoney'] = $_GPC['max_treemoney'];
            $data['min_treetxmoney'] = $_GPC['min_treetxmoney'];
            $data['tree_pic'] = $_GPC['tree_pic'];
            $data['tree_pic2'] = $_GPC['tree_pic2'];
            $data['treesharetitle'] = $_GPC['treesharetitle'];
            $data['treesharepic'] = $_GPC['treesharepic'];
            $data['treeadultid'] = $_GPC['treeadultid'];
            $data['treewith_pic'] = $_GPC['treewith_pic'];
            $data['treeinfo'] = $_GPC['treeinfo'];
            $data['treeposter'] = $_GPC['treeposter'];
            
            $ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_set', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('tree'));
            }
        }
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        if(empty($info['tree_pic'])){
           $info['tree_pic'] = $_W['siteroot']."addons/hc_pdd/template/img/open.png";
        }
        if(empty($info['tree_pic2'])){
           $info['tree_pic2'] = $_W['siteroot']."addons/hc_pdd/template/img/open2.png";
        }
        if(empty($info['treewith_pic'])){
           $info['treewith_pic'] = $_W['siteroot']."addons/hc_pdd/template/img/treewith.png";
        }
        if(empty($info['treeposter'])){
           $info['treeposter'] = $_W['siteroot']."addons/hc_pdd/tree.png";
        }
        if(empty($info['tree_way'])){
            $info['tree_way'] = 0;
        }
        include $this->template('tree');
    }

    //红包树记录
    public function doWebTreelog(){
        global $_W,$_GPC;

        $where['uniacid'] = $_W['uniacid'];
        
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

        $list = pdo_getslice('hcpdd_treelog',$where,array($pageindex, $pagesize),$total,array(),'','id desc');
        $page = pagination($total, $pageindex, $pagesize);

        //$list = pdo_getall('hcstep_bushulog',array('uniacid'=>$_W['uniacid']));
        
        foreach ($list as $k => $v) {
           $fuser = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'user_id'=>$v['user_id']));
           $suser = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'user_id'=>$v['son_id']));
           $list[$k]['fhead_pic'] = $fuser['head_pic'];
           $list[$k]['fnick_name'] = $fuser['nick_name'];
           $list[$k]['shead_pic'] = $suser['head_pic'];
           $list[$k]['snick_name'] = $suser['nick_name'];
           $list[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }        

        include $this->template('treelog');
    }

    //赢口红
    public function doWebKouhong(){

        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            $data['is_kouhong'] = $_GPC['is_kouhong'];
            $data['kouhong_pic'] = $_GPC['kouhong_pic'];
            $data['kouhong_sharetitle'] = $_GPC['kouhong_sharetitle'];
            $data['kouhong_sharepic'] = $_GPC['kouhong_sharepic'];
            $data['kouhong_ids'] = trim($_GPC['kouhong_ids']);
            $data['kouhong_color'] = $_GPC['kouhong_color'];
            
            $ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_set', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('kouhong'));
            }
        }
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        if(empty($info['kouhong_pic'])){
           $info['kouhong_pic'] = $_W['siteroot']."addons/hc_pdd/template/img/kouhong.png";
        }
        if(empty($info['kouhong_color'])){
           $info['kouhong_color'] = "#ff0080";
        }
        include $this->template('kouhong');
    }

    //红包树记录
    public function doWebKouhonglog(){
        global $_W,$_GPC;

        $where['uniacid'] = $_W['uniacid'];
        
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

        $list = pdo_getslice('hcpdd_kouhonglog',$where,array($pageindex, $pagesize),$total,array(),'','id desc');
        $page = pagination($total, $pageindex, $pagesize);

        //$list = pdo_getall('hcstep_bushulog',array('uniacid'=>$_W['uniacid']));
        
        foreach ($list as $k => $v) {
           $user = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'user_id'=>$v['user_id']));
           $list[$k]['head_pic'] = $user['head_pic'];
           $list[$k]['time'] = date('Y-m-d H:i:s',$v['createtime']);
           $list[$k]['nick_name'] = $user['nick_name'];
           if(!empty($v['invite_id'])){
              $list[$k]['invite'] = explode(",",$v['invite_id']);
              foreach ($list[$k]['invite'] as $key => $value) {
                  $user2 = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'user_id'=>$value));
                  $list[$k]['aaa'][$key]['head_pic'] = $user2['head_pic'];
                  $list[$k]['aaa'][$key]['nick_name'] = $user2['nick_name'];
              }
           }else{
              $list[$k]['invite'] = '';
           }
           
        }     

        include $this->template('kouhonglog');
    }

    //红包树记录
    public function doWebKouhongwin(){
        global $_W,$_GPC;

        $where['uniacid'] = $_W['uniacid'];
        $where['status'] = 1;
        
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

        $list = pdo_getslice('hcpdd_kouhonglog',$where,array($pageindex, $pagesize),$total,array(),'','id desc');
        $page = pagination($total, $pageindex, $pagesize);

        include $this->template('kouhongwin');
    }

    ///生成推广位
    public function CreatePid(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.pid.generate';
        $number = '1';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'number'.$number.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);

        $data = array (
            'type' => urlencode('pdd.ddk.goods.pid.generate'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'number'    => $number,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['p_id_generate_response']['p_id_list'][0];
        $pid = $result['p_id'];
       
        return $pid;
    }
	//查询商品详情
	public function Gooddetail(){
        global $_W,$_GPC;
		$info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
		$client_secret = $info['client_secret'];
		$client_id = $info['client_id'];
		$data_type = 'JSON';
		$timestamp = time();
		$type = 'pdd.ddk.goods.pid.generate';
		$number = '1';
		$signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'number'.$number.'timestamp'.$timestamp.'type'.$type.$client_secret;
		$sign = md5($signold);
		$sign = strtoupper($sign);

		$data = array (
			'type' => urlencode('pdd.ddk.goods.pid.generate'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'client_id' => 'baaeb91ce4534f329d775bfe38d33a37',
            'number'    => $number,
            'sign' => $sign
        );
		$url = 'http://gw-api.pinduoduo.com/api/router';
		load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['p_id_generate_response']['p_id_list'][0];
        $pid = $result['p_id'];
       
        return $pid;
	} 
	//推广位管理
	public function doWebMember(){
        global $_W,$_GPC;
        $op = $_GPC['op'];
        if ($op == 'del') {
			$id = $_GPC['id'];
			$item = pdo_get('hcpdd_users',array('user_id'=>$id,'uniacid'=>$_W['uniacid']));
			if(empty($item)){
				message('操作失败',$this->createWebUrl('member'),'error');
			}
			if(pdo_delete('hcpdd_users',array('user_id'=>$id,'uniacid'=>$_W['uniacid'])) === false) message('操作失败',referer(),'error');
			else message('操作成功',$this->createWebUrl('member'),'success');
		}
        
        $keyword = $_GPC['keyword'];        
	    if(!empty($_GPC['keyword'])){
			$where['nick_name LIKE'] = '%'.$keyword.'%';
		}
		$where['uniacid'] = $_W['uniacid'];
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

		$list = pdo_getslice('hcpdd_users',$where,array($pageindex, $pagesize),$total,array(),'','user_id desc');
		$page = pagination($total, $pageindex, $pagesize);
       include $this->template('member');      
	} 
    //订单管理
	public function doWebOrders(){
        global $_W,$_GPC;
        //获取会员pid列表$list
		//$list = pdo_getall('hcpdd_users',array('uniacid'=>$_W['uniacid']));
        //获取多多客应用密钥
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $cset = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];     
        //同步订单
        if($_GPC['act'] == 'refresh'){
            $data_type = 'JSON';   
            $start_update_time = strtotime($_GPC['starttime'],time());
            $end_update_time = strtotime($_GPC['endtime'],time());     
            //$start_update_time = '1522512000';   //总订单
            //$end_update_time =time();       
            $timestamp = time();
            $page = 1;
            $type = 'pdd.ddk.order.list.increment.get';
            $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'page'.$page.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
            $sign = md5($signold);
            //echo $signold;
            $sign = strtoupper($sign);
            $data = array(
                'type' => urlencode('pdd.ddk.order.list.increment.get'),
                'data_type' => 'JSON',
                'page' => $page,
                'start_update_time' => $start_update_time,
                'end_update_time' => $end_update_time,
                'timestamp' => urlencode($timestamp),
                'client_id' => $client_id,
                'sign' => $sign
            );
            $url = 'http://gw-api.pinduoduo.com/api/router';
            load()->func('communication');
            $response = ihttp_post($url,$data);
            $arr = json_decode($response['content'],true);
            $result = $arr['order_list_get_response']['order_list'];
            $total_count = $arr['order_list_get_response']['total_count'];
            $pagecount = ceil($total_count/100);
            
            //获取全部订单
            for ($x=1; $x<=$pagecount; $x++) {            
                $list[] = $this->allorderlist($x,$start_update_time,$end_update_time);
            }
            //筛选全部订单（除去未支付）
            foreach ($list as $k => $v) {
                foreach ($list[$k] as $key => $value) {
                    if($value['order_status'] != -1 ){
                        $listall[] = $value;
                    }     
                }
            }
            foreach ($listall as $k => $v) {
                $res = pdo_get('hcpdd_allorder',array('uniacid'=>$_W['uniacid'],'order_sn'=>$v['order_sn']));
                if(empty($res)){
//                    $data = $v;
                    $data1['order_sn'] = $v['order_sn'];
                    $data1['goods_id'] = $v['goods_id'];
                    $data1['goods_name'] = $v['goods_name'];
                    $data1['goods_thumbnail_url'] = $v['goods_thumbnail_url'];
                    $data1['goods_quantity'] = $v['goods_quantity'];
                    $data1['goods_price'] = $v['goods_price'];
                    $data1['order_amount'] = $v['order_amount'];
                    $data1['order_create_time'] = $v['order_create_time'];
                    $data1['order_settle_time'] = $v['order_settle_time'];
                    $data1['order_verify_time'] = $v['order_verify_time'];
                    $data1['order_receive_time'] = $v['order_receive_time'];
                    $data1['order_pay_time'] = $v['order_pay_time'];
                    $data1['promotion_rate'] = $v['promotion_rate'];
                    $data1['promotion_amount'] = $v['promotion_amount'];
                    $data1['batch_no'] = $v['batch_no'];
                    $data1['order_status'] = $v['order_status'];
                    $data1['order_status_desc'] = $v['order_status_desc'];
                    $data1['verify_time'] = $v['verify_time'];
                    $data1['order_group_success_time'] = $v['order_group_success_time'];
                    $data1['order_modify_at'] = $v['order_modify_at'];
                    $data1['status'] = $v['status'];
                    $data1['type'] = $v['type'];
                    $data1['group_id'] = $v['group_id'];
                    $data1['auth_duo_id'] = $v['auth_duo_id'];
                    $data1['custom_parameters'] = $v['custom_parameters'];
                    $data1['p_id'] = $v['p_id'];
                    $data1['duo_coupon_amount'] = $v['duo_coupon_amount'];
                    $data1['zs_duo_id'] = $v['zs_duo_id'];
                    $data1['match_channel'] = $v['match_channel'];
                    $data1['order_id'] = $v['order_id'];
                    $data1['cpa_new'] = $v['cpa_new'];
                    $user = pdo_get('hcpdd_users',array('pid'=>$data1['p_id']));
                    $data1['is_daili'] = $user['is_daili'];
                    $data1['uniacid'] = $_W['uniacid'];
                    if($user['is_daili'] == 0){
                        $data1['commission'] = $v['promotion_amount']/100 * $info['moneyrate'];
                    }elseif($user['is_daili'] == 1){
                        $data1['commission'] = $v['promotion_amount']/100 * $info['daili_moneyrate'];
                    }else{
                        $data1['commission'] = $v['promotion_amount']/100 * $info['zongjian_moneyrate'];
                    }
                    //生成分销订单
                    $com['uniacid'] = $_W['uniacid'];
                    $com['pid'] = $data1['p_id'];
                    $com['order_sn'] = $data1['order_sn'];
                    $com['fee'] = $data1['commission'];
                    $com['status'] = 0;
                    $com['addtime'] = time();
                    $com['goodsname'] = $v['goods_name'];
                    if($user['fatherid']>0){
                        $father1 = pdo_get('hcpdd_users',array('user_id'=>$user['fatherid']));
                        $com['user_id'] = $father1['user_id'];
                        $com['is_daili'] = $father1['is_daili'];
                        $com['level'] = 1;
                        if($father1['is_daili'] == 1){
                            $com['fx_rate'] = $cset['commission1'];
                            $com['fx_commission'] = $com['fee'] * $cset['commission1'] /100;
                        }
                        if($father1['is_daili'] == 2){
                            $com['fx_rate'] = $cset['zongjian_commission1'];
                            $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission1'] /100;
                        }
                        pdo_insert('hcpdd_pddcommission',$com);
                        $this->getfxmessage($father1['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'拼多多订单');

                        if($father1['fatherid']>0){
                            $father2 = pdo_get('hcpdd_users',array('user_id'=>$father1['fatherid']));
                            $com['user_id'] = $father2['user_id'];
                            $com['is_daili'] = $father2['is_daili'];
                            $com['level'] = 2;
                            if($father2['is_daili'] == 1){
                                $com['fx_rate'] = $cset['commission2'];
                                $com['fx_commission'] = $com['fee'] * $cset['commission2'] /100;
                            }
                            if($father2['is_daili'] == 2){
                                $com['fx_rate'] = $cset['zongjian_commission2'];
                                $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission2'] /100;
                            }
                            pdo_insert('hcpdd_pddcommission',$com);
                            $this->getfxmessage($father2['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'拼多多订单');

                            if($father2['fatherid']>0){
                                $father3 = pdo_get('hcpdd_users',array('user_id'=>$father2['fatherid']));
                                $com['user_id'] = $father3['user_id'];
                                $com['is_daili'] = $father3['is_daili'];
                                $com['level'] = 3;
                                if($father3['is_daili'] == 1){
                                    $com['fx_rate'] = $cset['commission3'];
                                    $com['fx_commission'] = $com['fee'] * $cset['commission3'] /100;
                                }
                                if($father3['is_daili'] == 2){
                                    $com['fx_rate'] = $cset['zongjian_commission3'];
                                    $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission3'] /100;
                                }
                                pdo_insert('hcpdd_pddcommission',$com);
                                $this->getfxmessage($father3['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'拼多多订单');
                            }
                        }
                    }
                    //生成分销订单结束
                    $data1['fafang'] = 0;
                    $data1['cfafang'] = 0;
                    $data1['status'] = null;

                    $fff[]= pdo_insert('hcpdd_allorder',$data1);
                }elseif($res['order_status'] != $v['order_status']){
//                    $data = $v;
                    $data1['order_sn'] = $v['order_sn'];
                    $data1['goods_id'] = $v['goods_id'];
                    $data1['goods_name'] = $v['goods_name'];
                    $data1['goods_thumbnail_url'] = $v['goods_thumbnail_url'];
                    $data1['goods_quantity'] = $v['goods_quantity'];
                    $data1['goods_price'] = $v['goods_price'];
                    $data1['order_amount'] = $v['order_amount'];
                    $data1['order_create_time'] = $v['order_create_time'];
                    $data1['order_settle_time'] = $v['order_settle_time'];
                    $data1['order_verify_time'] = $v['order_verify_time'];
                    $data1['order_receive_time'] = $v['order_receive_time'];
                    $data1['order_pay_time'] = $v['order_pay_time'];
                    $data1['promotion_rate'] = $v['promotion_rate'];
                    $data1['promotion_amount'] = $v['promotion_amount'];
                    $data1['batch_no'] = $v['batch_no'];
                    $data1['order_status'] = $v['order_status'];
                    $data1['order_status_desc'] = $v['order_status_desc'];
                    $data1['verify_time'] = $v['verify_time'];
                    $data1['order_group_success_time'] = $v['order_group_success_time'];
                    $data1['order_modify_at'] = $v['order_modify_at'];
                    $data1['status'] = $v['status'];
                    $data1['type'] = $v['type'];
                    $data1['group_id'] = $v['group_id'];
                    $data1['auth_duo_id'] = $v['auth_duo_id'];
                    $data1['custom_parameters'] = $v['custom_parameters'];
                    $data1['p_id'] = $v['p_id'];
                    $data1['duo_coupon_amount'] = $v['duo_coupon_amount'];
                    $data1['zs_duo_id'] = $v['zs_duo_id'];
                    $data1['match_channel'] = $v['match_channel'];
                    $data1['order_id'] = $v['order_id'];
                    $data1['cpa_new'] = $v['cpa_new'];

                    $data1['uniacid'] = $_W['uniacid'];
                    if($v['order_status'] == -1 or $v['order_status'] == 4 or $v['order_status'] == 8){
                        $data1['commission'] = 0;
                        $com['status'] = 3;
                        pdo_update('hcpdd_pddcommission',$com, array('uniacid'=>$_W['uniacid'],'order_sn' =>$data1['order_sn']));
                    }
                    $fff[]= pdo_update('hcpdd_allorder',$data1, array('uniacid'=>$_W['uniacid'],'order_sn' =>$data1['order_sn']));
                }else{
                    $cao = 1;
                }           
            }
            if(empty($fff)){
                message('同步成功，没有新订单',$this->createWebUrl('orders'),'success');
            }else{
                message('同步成功',$this->createWebUrl('orders'),'success');
            }
        }        

            $pid  = $_GPC['pid'];
            $order_status = $_GPC['order_status'];
            if(empty($order_status) and !empty($pid)){
                $where['uniacid'] = $_W['uniacid'];
                $where['p_id'] = $pid;
            }
            if(!empty($order_status) and empty($pid)){
                $where['uniacid'] = $_W['uniacid'];
                $where['order_status'] = $order_status;
            }
            if(!empty($order_status) and !empty($pid)){
                $where['uniacid'] = $_W['uniacid'];
                $where['order_status'] = $order_status;
                $where['p_id'] = $pid;
            }
            if(empty($order_status) and empty($pid)){
                $where['uniacid'] = $_W['uniacid'];
            }
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 50;

            $result = pdo_getslice('hcpdd_allorder',$where,array($pageindex, $pagesize),$total,array(),'','order_pay_time desc');
            $page = pagination($total, $pageindex, $pagesize);

            foreach ($result as $k => $v) {
                $data = pdo_get('hcpdd_users',array('pid'=>$v['p_id'],'uniacid'=>$_W['uniacid']));
                $son = pdo_get('hcpdd_son',array('son_pid'=>$v['p_id'],'uniacid'=>$_W['uniacid']));
                $result[$k]['nick_name']         = $data['nick_name'];
                $result[$k]['roleid']            = $data['is_daili'];
                $result[$k]['order_create_time'] = date('Y-m-d',$v['order_create_time']);//订单生成时间
                $result[$k]['order_pay_time']    = date('Y-m-d',$v['order_pay_time']);      //支付时间
                $result[$k]['promotion_rate']    = $v['promotion_rate']/10;   //佣金比例，百分比
                $result[$k]['promotion_amount']  = $v['promotion_amount']/100;           //佣金

                $rate = pdo_getall('hcpdd_moneyrate', array('uniacid' =>$_W['uniacid']), array() , '','edittime DESC');
                $first = pdo_getcolumn('hcpdd_moneyrate', array('uniacid' =>$_W['uniacid']), 'min(edittime)'); 
                $frate = pdo_get('hcpdd_moneyrate',array('uniacid'=>$_W['uniacid'],'edittime'=>$first));
                foreach ($rate as $key => $value) {
                        $info['zongjian_moneyrate'] = $frate['zongjian_moneyrate'];
                        $info['daili_moneyrate'] = $frate['daili_moneyrate'];
                        $info['moneyrate'] = $frate['moneyrate'];
                    if($v['order_create_time'] > $value['edittime']){
                        $info['zongjian_moneyrate'] = $value['zongjian_moneyrate'];
                        $info['daili_moneyrate'] = $value['daili_moneyrate'];
                        $info['moneyrate'] = $value['moneyrate'];
                        break;
                    }
                }              
                $dailitime  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_W['uniacid'],'uid'=>$data['user_id'],'fid'=>0),array('paytime'));
                $zongjiantime  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_W['uniacid'],'uid'=>$data['user_id'],'fid'=>1),array('paytime'));

                if($data['is_daili'] == 0){
                    $result[$k]['user_promotion_amount'] = $v['promotion_amount']/100*$info['moneyrate'];//用户的
                }elseif($data['is_daili'] == 1){
                    if($v['order_create_time'] < $dailitime){
                           $result[$k]['user_promotion_amount']  = round(($v['promotion_amount']/100*$info['moneyrate']),2);      //佣金
                        }else{
                           $result[$k]['user_promotion_amount']  = round(($v['promotion_amount']/100*$info['daili_moneyrate']),2);      //佣金 
                        }
                }else{
                    if($v['order_create_time'] < $zongjiantime and $v['order_create_time'] > $dailitime){
                           $result[$k]['user_promotion_amount']  = round(($v['promotion_amount']/100*$info['daili_moneyrate']),2);   //佣金  
                        }elseif($v['order_create_time'] < $dailitime){
                           $result[$k]['user_promotion_amount']  = round(($v['promotion_amount']/100*$info['moneyrate']),2);   //佣金
                        }else{
                           $result[$k]['user_promotion_amount']  = round(($v['promotion_amount']/100*$info['zongjian_moneyrate']),2);   //佣金 
                        }
                }
                if($son){
                    $result[$k]['user_promotion_amount'] = $v['promotion_amount']/100*$son['son_rate'];//子程序的
                    $result[$k]['roleid']            = 3;
                }           
                $result[$k]['order_amount']      = $v['order_amount']/100;               //订单价格
            }
       
        $url = $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&m=hc_pdd&do=auto';

       include $this->template('orders');      
	} 

    //蘑菇街订单管理
    public function doWebMoguorders(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $cset = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];       
        //同步订单
        if($_GPC['act'] == 'refresh'){
            $model = new moguapiModel();
            $access_token = $info['access_token'];
            $app_key = $info['app_key'];
            $AppSecret = $info['app_secret'];

            $start = date('Ymd',strtotime($_GPC['starttime'],time()));//订单创建时间   
            $end = date('Ymd',strtotime($_GPC['endtime'],time()));//订单创建时间
            $orderInfoQuery = json_encode(array('start'=>$start,'end'=>$end,'page'=>1,'pagesize'=>200));
            
            $list = $model->moguapi_getorders($access_token,$app_key,$AppSecret,$orderInfoQuery);
            //筛选全部订单（除去未支付）
            foreach ($list as $k => $v) {
                    if($v['paymentStatus'] != 10000 ){
                        $listall[] = $v;  
                }
            }
            //var_dump($listall);
            foreach ($listall as $k => $v){
                $res = pdo_get('hcpdd_moguorders',array('uniacid'=>$_W['uniacid'],'orderNo'=>$v['orderNo']));
                if(empty($res)){
                    $data = $v;
                    $data['uniacid'] = $_W['uniacid'];
                    $data['products'] = json_encode($data['products']);
                    $user = pdo_get('hcpdd_users',array('gid'=>$data['groupId']));
                    $data['is_daili'] = $user['is_daili'];
                    if($user['is_daili'] == 0){
                        $data['commission'] = $v['expense'] * $info['mogurate'];
                    }elseif($user['is_daili'] == 1){
                        $data['commission'] = $v['expense'] * $info['mogudailirate'];
                    }else{
                        $data['commission'] = $v['expense'] * $info['moguzongjianrate'];
                    }
                    
                    //生成分销订单
                    $com['uniacid'] = $_W['uniacid'];
                    $com['groupId'] = $data['groupId'];
                    $com['orderNo'] = $data['orderNo'];
                    $com['fee'] = $data['commission'];
                    $com['status'] = 0;
                    $com['addtime'] = time();
                    $com['goodsname'] = $v['products'][0]['name'];
                    if($user['fatherid']>0){
                        $father1 = pdo_get('hcpdd_users',array('user_id'=>$user['fatherid']));
                        $com['user_id'] = $father1['user_id'];
                        $com['is_daili'] = $father1['is_daili'];
                        $com['level'] = 1;
                        if($father1['is_daili'] == 1){
                            $com['fx_rate'] = $cset['commission1'];
                            $com['fx_commission'] = $com['fee'] * $cset['commission1'] /100;
                        }
                        if($father1['is_daili'] == 2){
                            $com['fx_rate'] = $cset['zongjian_commission1'];
                            $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission1'] /100;
                        }
                        pdo_insert('hcpdd_mogucommission',$com);
                        $this->getfxmessage($father1['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'蘑菇街订单');

                        if($father1['fatherid']>0){
                            $father2 = pdo_get('hcpdd_users',array('user_id'=>$father1['fatherid']));
                            $com['user_id'] = $father2['user_id'];
                            $com['is_daili'] = $father2['is_daili'];
                            $com['level'] = 2;
                            if($father2['is_daili'] == 1){
                                $com['fx_rate'] = $cset['commission2'];
                                $com['fx_commission'] = $com['fee'] * $cset['commission2'] /100;
                            }
                            if($father2['is_daili'] == 2){
                                $com['fx_rate'] = $cset['zongjian_commission2'];
                                $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission2'] /100;
                            }
                            pdo_insert('hcpdd_mogucommission',$com);
                            $this->getfxmessage($father2['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'蘑菇街订单');

                            if($father2['fatherid']>0){
                                $father3 = pdo_get('hcpdd_users',array('user_id'=>$father2['fatherid']));
                                $com['user_id'] = $father3['user_id'];
                                $com['is_daili'] = $father3['is_daili'];
                                $com['level'] = 3;
                                if($father3['is_daili'] == 1){
                                    $com['fx_rate'] = $cset['commission3'];
                                    $com['fx_commission'] = $com['fee'] * $cset['commission3'] /100;
                                }
                                if($father3['is_daili'] == 2){
                                    $com['fx_rate'] = $cset['zongjian_commission3'];
                                    $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission3'] /100;
                                }
                                pdo_insert('hcpdd_mogucommission',$com);
                                $this->getfxmessage($father3['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'蘑菇街订单');
                            }
                        }
                    }
                    //生成分销订单结束

                    $fff[]= pdo_insert('hcpdd_moguorders',$data);
                }elseif($res['paymentStatus'] != $v['paymentStatus'] or $res['orderStatus'] != $v['orderStatus']){
                    $data = $v;
                    $data['uniacid'] = $_W['uniacid'];
                    $data['products'] = json_encode($data['products']);
                    if($v['paymentStatus'] == 10000 or $v['paymentStatus'] == 30000 or $v['paymentStatus'] == 90000 or $v['paymentStatus'] == 95000){
                        $data['commission'] = 0;
                        $com['status'] = 3;
                        pdo_update('hcpdd_mogucommission',$com, array('uniacid'=>$_W['uniacid'],'orderNo' =>$data['orderNo']));
                    }
                    $fff[]= pdo_update('hcpdd_moguorders',$data, array('orderNo' =>$data['orderNo']));
                }else{
                    $cao = 1;
                }           
            }

            //var_dump($fff);
            if(empty($fff)){
                message('同步成功，没有新订单',$this->createWebUrl('moguorders'),'success');
            }else{
                message('同步成功',$this->createWebUrl('moguorders'),'success');
            }
        }
        
        $groupId  = $_GPC['groupId'];
        $order_status = $_GPC['order_status'];
        if(empty($order_status) and !empty($groupId)){
            $where['groupId'] = $groupId;
        }
        if(!empty($order_status) and empty($groupId)){
            $where['paymentStatus'] = $order_status; 
            if($order_status == '66'){
                $where['fafang'] = 1;
                $where['orderStatus'] = 80000; 
                $where['paymentStatus'] = 45000;
            }      
        }
        if(!empty($order_status) and !empty($groupId)){
            $where['paymentStatus'] = $order_status;
            $where['groupId'] = $groupId;
            if($order_status == '66'){
                $where['fafang'] = 1;
                $where['orderStatus'] = 80000;
                $where['paymentStatus'] = 45000;
            }
        }

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 50;
        $where['uniacid'] = $_W['uniacid'];


        $result = pdo_getslice('hcpdd_moguorders',$where,array($pageindex, $pagesize),$total,array(),'','orderTime desc');
        foreach ($result as $k => $v) {
            $user = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'gid'=>$v['groupId']));
            $result[$k]['nick_name'] = $user['nick_name'];
            $result[$k]['is_daili'] = $user['is_daili'];
            $result[$k]['orderTime'] = date("Y-m-d : h:i",$v['orderTime']);
            $result[$k]['products'] = json_decode($v['products'],true);
            if($result[$k]['products'][0]['orderStatus'] == "20000"){
                $result[$k]['products'][0]['orderStatus'] = "订单已支付";
            }
            if($result[$k]['products'][0]['orderStatus'] == "30000"){
                $result[$k]['products'][0]['orderStatus'] = "订单已退款";
            }
            if($result[$k]['products'][0]['orderStatus'] == "40000"){
                $result[$k]['products'][0]['orderStatus'] = "订单已完成";
            }
            if($result[$k]['products'][0]['orderStatus'] == "45000"){
                $result[$k]['products'][0]['orderStatus'] = "订单最终完成(超过退款期)";
                if($v['orderStatus'] == 80000 and $v['fafang'] ==0){
                    $result[$k]['products'][0]['orderStatus'] = "订单最终完成(佣金已结算)";
                }
                if($v['orderStatus'] == 80000 and $v['fafang'] ==1){
                    $result[$k]['products'][0]['orderStatus'] = "订单最终完成(佣金已发放)";
                }
                if($v['orderStatus'] == 80000 and $v['fafang'] ==2){
                    $result[$k]['products'][0]['orderStatus'] = "订单最终完成(佣金发放失败)";
                }
            }
            if($result[$k]['products'][0]['orderStatus'] == "90000"){
                $result[$k]['products'][0]['orderStatus'] = "订单已取消";
            }
            if($result[$k]['products'][0]['orderStatus'] == "95000"){
                $result[$k]['products'][0]['orderStatus'] = "订单被风控";
            }
            $result[$k]['products'][0]['expense'] = $result[$k]['products'][0]['expense']/100;
            if($user['is_daili'] == 0){
                $result[$k]['commission']   = round($result[$k]['products'][0]['expense']*$info['mogurate'],2);
            }elseif($user['is_daili'] == 1){
                $result[$k]['commission']   = round($result[$k]['products'][0]['expense']*$info['mogudailirate'],2);//
            }else{
                $result[$k]['commission']   = round($result[$k]['products'][0]['expense']*$info['moguzongjianrate'],2);//
            } 
        }
        $page = pagination($total, $pageindex, $pagesize); 
        $url = $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&m=hc_pdd&do=moguauto';  

        include $this->template('moguorders');      
    } 

    //京东订单管理
    public function doWebJdorders(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $cset = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
        //同步订单
        if($_GPC['act'] == 'refresh'){
            $model = new moguapiModel();
            //$app_key = $info['jdappkey'];
            //$AppSecret = $info['jdsecretkey'];
            $key = $info['jdkey'];

            $start = date('Ymd',strtotime($_GPC['starttime'],time()));//订单创建时间

            $hour = array('0'=>'00','1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','21'=>'21','22'=>'22','23'=>'23');
            foreach ($hour as $kk => $value) {
                $time = $start.$value;
                $list = $model->jdapi_getorders($time,$key);
//                var_dump($list);die;
                if(empty($list)){
                    $list = $model->jdapi_getorders2($time,$key);
                }
                if(empty($list)){
                    $list = $model->jdapi_getorders3($time,$key);
                }
                if(!empty($list)){
                    //筛选全部订单（除去待付款）
                    foreach ($list as $k => $v) {
                            if($v['validCode'] > 15 ){
                                $listall[] = $v;  
                        }
                    }
                    foreach ($listall as $k => $v){
                        $res = pdo_get('hcpdd_jdorders',array('uniacid'=>$_W['uniacid'],'orderId'=>$v['orderId']));
                        if(empty($res)){
                            $data = $v;
                            $data['uniacid'] = $_W['uniacid'];
                            $data['skuList'] = json_encode($data['skuList']);
                            $data['positionId'] = $v['skuList'][0]['positionId'];
                            $user = pdo_get('hcpdd_users',array('positionId'=>$data['positionId']));
                            $data['is_daili'] = $user['is_daili'];
                            if($user['is_daili'] == 0){
                                $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jdrate'];
                            }elseif($user['is_daili'] == 1){
                                $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jddailirate'];
                            }else{
                                $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jdzongjianrate'];
                            } 
                            //生成分销订单
                            $com['uniacid'] = $_W['uniacid'];
                            $com['positionId'] = $data['positionId'];
                            $com['orderId'] = $data['orderId'];
                            $com['fee'] = $data['commission'];
                            $com['status'] = 0;
                            $com['addtime'] = time();
                            $com['goodsname'] = $v['skuList'][0]['skuName'];
                            if($user['fatherid']>0){
                                $father1 = pdo_get('hcpdd_users',array('user_id'=>$user['fatherid']));
                                $com['user_id'] = $father1['user_id'];
                                $com['is_daili'] = $father1['is_daili'];
                                $com['level'] = 1;
                                if($father1['is_daili'] == 1){
                                    $com['fx_rate'] = $cset['commission1'];
                                    $com['fx_commission'] = $com['fee'] * $cset['commission1'] /100;
                                }
                                if($father1['is_daili'] == 2){
                                    $com['fx_rate'] = $cset['zongjian_commission1'];
                                    $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission1'] /100;
                                }
                                pdo_insert('hcpdd_jdcommission',$com);
                                $this->getfxmessage($father1['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'京东订单');

                                if($father1['fatherid']>0){
                                    $father2 = pdo_get('hcpdd_users',array('user_id'=>$father1['fatherid']));
                                    $com['user_id'] = $father2['user_id'];
                                    $com['is_daili'] = $father2['is_daili'];
                                    $com['level'] = 2;
                                    if($father2['is_daili'] == 1){
                                        $com['fx_rate'] = $cset['commission2'];
                                        $com['fx_commission'] = $com['fee'] * $cset['commission2'] /100;
                                    }
                                    if($father2['is_daili'] == 2){
                                        $com['fx_rate'] = $cset['zongjian_commission2'];
                                        $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission2'] /100;
                                    }
                                    pdo_insert('hcpdd_jdcommission',$com);
                                    $this->getfxmessage($father2['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'京东订单');

                                    if($father2['fatherid']>0){
                                        $father3 = pdo_get('hcpdd_users',array('user_id'=>$father2['fatherid']));
                                        $com['user_id'] = $father3['user_id'];
                                        $com['is_daili'] = $father3['is_daili'];
                                        $com['level'] = 3;
                                        if($father3['is_daili'] == 1){
                                            $com['fx_rate'] = $cset['commission3'];
                                            $com['fx_commission'] = $com['fee'] * $cset['commission3'] /100;
                                        }
                                        if($father3['is_daili'] == 2){
                                            $com['fx_rate'] = $cset['zongjian_commission3'];
                                            $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission3'] /100;
                                        }
                                        pdo_insert('hcpdd_jdcommission',$com);
                                        $this->getfxmessage($father3['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'京东订单');
                                    }
                                }
                            }
                            //京东生成分销订单结束
                            unset($user);        
                            $fff[]= pdo_insert('hcpdd_jdorders',$data);
                        }elseif($res['validCode'] != $v['validCode']){
                            $data = $v;
                            $data['uniacid'] = $_W['uniacid'];
                            $data['skuList'] = json_encode($data['skuList']);
                            $data['positionId'] = $v['skuList'][0]['positionId'];
                            if($v['validCode'] < 16){
                                $data['commission'] = 0;
                                $com['status'] = 3;
                                pdo_update('hcpdd_jdcommission',$com, array('uniacid'=>$_W['uniacid'],'orderId' =>$data['orderId']));
                            }
                            $fff[]= pdo_update('hcpdd_jdorders',$data, array('uniacid'=>$_W['uniacid'],'orderId' =>$data['orderId']));
                        }else{
                            $cao = 1;
                        }           
                    }
                }

            }

            //var_dump($fff);exit;
            
            if(empty($fff)){
                message('同步成功，没有新订单',$this->createWebUrl('jdorders'),'success');
            }else{
                message('同步成功',$this->createWebUrl('jdorders'),'success');
            }
        }

        $positionId  = $_GPC['positionId'];
        $order_status = $_GPC['order_status'];
        if(empty($order_status) and !empty($positionId)){
            $where['positionId'] = $positionId;
        }
        if(!empty($order_status) and empty($positionId)){
            $where['validCode'] = $order_status; 
            if($order_status == '66'){
                $where['fafang'] = 1;
                $where['validCode'] = 18; 
            }      
        }
        if(!empty($order_status) and !empty($positionId)){
            $where['validCode'] = $order_status;
            $where['positionId'] = $positionId;
            if($order_status == '66'){
                $where['fafang'] = 1;
                $where['validCode'] = 18;
            }
        }

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 50;
        $where['uniacid'] = $_W['uniacid'];

        $result = pdo_getslice('hcpdd_jdorders',$where,array($pageindex, $pagesize),$total,array(),'','orderTime desc');
        foreach ($result as $k => $v) {
            $user = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'positionId'=>$v['positionId']));
            $result[$k]['nick_name'] = $user['nick_name'];
            //$result[$k]['is_daili'] = $user['is_daili'];
            $result[$k]['orderTime'] = date("Y-m-d : H:i",$v['orderTime']/1000);
            $result[$k]['skuList'] = json_decode($v['skuList'],true);
            $result[$k]['skuList'] = $result[$k]['skuList'][0];
            if($result[$k]['validCode'] < 16){
                $result[$k]['validCode'] = "无效订单";
            }
            if($result[$k]['validCode'] == 16){
                $result[$k]['validCode'] = "已支付";
            }
            if($result[$k]['validCode'] == 17){
                $result[$k]['validCode'] = "已完成";
            }
            if($result[$k]['validCode'] == 18){
                $result[$k]['validCode'] = "已结算";
                if($v['fafang'] == 1){
                    $result[$k]['validCode'] = "已发放";
                }
            }
            
            /*if($user['is_daili'] == 0){
                $result[$k]['commission']   = round($result[$k]['skuList']['estimateFee']*$info['jdrate'],2);
            }elseif($user['is_daili'] == 1){
                $result[$k]['commission']   = round($result[$k]['skuList']['estimateFee']*$info['jddailirate'],2);//
            }else{
                $result[$k]['commission']   = round($result[$k]['skuList']['estimateFee']*$info['jdzongjianrate'],2);//
            }*/ 
        }
        
        $page = pagination($total, $pageindex, $pagesize); 
        $url = $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&m=hc_pdd&do=Jdauto';  

        include $this->template('jdorders');      
    }
    //发放京东佣金
    public function doWebsendjdmoney(){
        global $_W, $_GPC;
        /*$info = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));*/
        $list = pdo_getall('hcpdd_jdorders', array('uniacid' =>$_W['uniacid'],'fafang'=>0,'validCode'=>18,'positionId !='=>0));
        foreach ($list as $k => $v) {
            //if($v['fafang'] == 0){
                $res = pdo_get('hcpdd_users',array('positionId'=>$v['positionId'],'uniacid' =>$_W['uniacid']));
                if(!empty($res)){
                    /*if($res['is_daili'] == 0){
                    $money = $v['promotion_amount']/100*$set['moneyrate'];//用户的
                    }elseif($res['is_daili'] == 1){
                        $money = $v['promotion_amount']/100*$set['daili_moneyrate'];//代理的
                    }else{
                        $money = $v['promotion_amount']/100*$set['zongjian_moneyrate'];//总监的
                    }*/
                    $nowmoney = $res['money'] + $v['commission'];
                    $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney), array('positionId'=>$v['positionId'],'uniacid' =>$_W['uniacid']));
                    $zhuangtai = pdo_update('hcpdd_jdorders',array('fafang' => 1), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));

                }else{
                    $zhuangtai = pdo_update('hcpdd_jdorders',array('fafang' => 2), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));
                }
            //}
        }

        if ($faqian){
            message('发放成功',$this->createWebUrl('jdorders'),'success');
        }else{
            message('没有可发放的订单',$this->createWebUrl('jdorders'),'success');
        }

    }

    //发放京东佣金
    public function doWebsendmogumoney(){
        global $_W, $_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $list = pdo_getall('hcpdd_moguorders', array('uniacid' =>$_W['uniacid'],'fafang'=>0,'orderStatus'=>80000,'groupId !='=>0));
        foreach ($list as $k => $v) {
            //if($v['fafang'] == 0){
                $user = pdo_get('hcpdd_users',array('gid'=>$v['groupId'],'uniacid' =>$_W['uniacid']));
                if(!empty($user)){
                    if($user['is_daili'] == 0){
                        $money   = round($v['expense']*$info['mogurate'],2);
                    }elseif($user['is_daili'] == 1){
                        $money   = round($v['expense']*$info['mogudailirate'],2);//
                    }else{
                        $money   = round($v['expense']*$info['moguzongjianrate'],2);//
                    }
                    $nowmoney = $user['money'] + $money;
                    $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney), array('gid'=>$v['groupId'],'uniacid' =>$_W['uniacid']));
                    $zhuangtai = pdo_update('hcpdd_moguorders',array('fafang' => 1), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));

                }else{
                    $zhuangtai = pdo_update('hcpdd_moguorders',array('fafang' => 2), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));
                }
            //}
        }

        if ($faqian){
            message('发放成功',$this->createWebUrl('moguorders'),'success');
        }else{
            message('没有可发放的订单',$this->createWebUrl('moguorders'),'success');
        }

    }

    public function doMobileAuto(){
        
        global $_W,$_GPC;
        $ccc = pdo_get('hcpdd_allorder', array('uniacid'=>$_W['uniacid']), array('MAX(order_modify_at)'));
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $cset = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';   
        $start_update_time = $ccc[0];  //最后更新时间的一单到现在时间的一单
        $end_update_time = time();
        if(($end_update_time - $start_update_time) >= 86000){
            $start_update_time = $end_update_time - 86000;  
        }    
      
        $timestamp = time();
        $page = 1;
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'page'.$page.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array(
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'page' => $page,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list'];
        $total_count = $arr['order_list_get_response']['total_count'];
        $pagecount = ceil($total_count/100);
        
        //获取全部订单
        for ($x=1; $x<=$pagecount; $x++) {            
            $list[] = $this->allorderlist($x,$start_update_time,$end_update_time);
        }
        //筛选全部订单（除去未支付）
        foreach ($list as $k => $v) {
            foreach ($list[$k] as $key => $value) {
                if($value['order_status'] != -1 ){
                    $listall[] = $value;
                }     
            }
        }
        foreach ($listall as $k => $v) {
            $res = pdo_get('hcpdd_allorder',array('uniacid'=>$_W['uniacid'],'order_sn'=>$v['order_sn']));
            if(empty($res)){
//                    $data = $v;
                $data1['order_sn'] = $v['order_sn'];
                $data1['goods_id'] = $v['goods_id'];
                $data1['goods_name'] = $v['goods_name'];
                $data1['goods_thumbnail_url'] = $v['goods_thumbnail_url'];
                $data1['goods_quantity'] = $v['goods_quantity'];
                $data1['goods_price'] = $v['goods_price'];
                $data1['order_amount'] = $v['order_amount'];
                $data1['order_create_time'] = $v['order_create_time'];
                $data1['order_settle_time'] = $v['order_settle_time'];
                $data1['order_verify_time'] = $v['order_verify_time'];
                $data1['order_receive_time'] = $v['order_receive_time'];
                $data1['order_pay_time'] = $v['order_pay_time'];
                $data1['promotion_rate'] = $v['promotion_rate'];
                $data1['promotion_amount'] = $v['promotion_amount'];
                $data1['batch_no'] = $v['batch_no'];
                $data1['order_status'] = $v['order_status'];
                $data1['order_status_desc'] = $v['order_status_desc'];
                $data1['verify_time'] = $v['verify_time'];
                $data1['order_group_success_time'] = $v['order_group_success_time'];
                $data1['order_modify_at'] = $v['order_modify_at'];
                $data1['status'] = $v['status'];
                $data1['type'] = $v['type'];
                $data1['group_id'] = $v['group_id'];
                $data1['auth_duo_id'] = $v['auth_duo_id'];
                $data1['custom_parameters'] = $v['custom_parameters'];
                $data1['p_id'] = $v['p_id'];
                $data1['duo_coupon_amount'] = $v['duo_coupon_amount'];
                $data1['zs_duo_id'] = $v['zs_duo_id'];
                $data1['match_channel'] = $v['match_channel'];
                $data1['order_id'] = $v['order_id'];
                $data1['cpa_new'] = $v['cpa_new'];
                $user = pdo_get('hcpdd_users',array('pid'=>$data1['p_id']));
                $data1['is_daili'] = $user['is_daili'];
                $data1['uniacid'] = $_W['uniacid'];
                if($user['is_daili'] == 0){
                    $data1['commission'] = $v['promotion_amount']/100 * $info['moneyrate'];
                }elseif($user['is_daili'] == 1){
                    $data1['commission'] = $v['promotion_amount']/100 * $info['daili_moneyrate'];
                }else{
                    $data1['commission'] = $v['promotion_amount']/100 * $info['zongjian_moneyrate'];
                }
                //生成分销订单
                $com['uniacid'] = $_W['uniacid'];
                $com['pid'] = $data1['p_id'];
                $com['order_sn'] = $data1['order_sn'];
                $com['fee'] = $data1['commission'];
                $com['status'] = 0;
                $com['addtime'] = time();
                $com['goodsname'] = $v['goods_name'];
                if($user['fatherid']>0){
                    $father1 = pdo_get('hcpdd_users',array('user_id'=>$user['fatherid']));
                    $com['user_id'] = $father1['user_id'];
                    $com['is_daili'] = $father1['is_daili'];
                    $com['level'] = 1;
                    if($father1['is_daili'] == 1){
                        $com['fx_rate'] = $cset['commission1'];
                        $com['fx_commission'] = $com['fee'] * $cset['commission1'] /100;
                    }
                    if($father1['is_daili'] == 2){
                        $com['fx_rate'] = $cset['zongjian_commission1'];
                        $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission1'] /100;
                    }
                    pdo_insert('hcpdd_pddcommission',$com);
                    $this->getfxmessage($father1['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'拼多多订单');

                    if($father1['fatherid']>0){
                        $father2 = pdo_get('hcpdd_users',array('user_id'=>$father1['fatherid']));
                        $com['user_id'] = $father2['user_id'];
                        $com['is_daili'] = $father2['is_daili'];
                        $com['level'] = 2;
                        if($father2['is_daili'] == 1){
                            $com['fx_rate'] = $cset['commission2'];
                            $com['fx_commission'] = $com['fee'] * $cset['commission2'] /100;
                        }
                        if($father2['is_daili'] == 2){
                            $com['fx_rate'] = $cset['zongjian_commission2'];
                            $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission2'] /100;
                        }
                        pdo_insert('hcpdd_pddcommission',$com);
                        $this->getfxmessage($father2['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'拼多多订单');

                        if($father2['fatherid']>0){
                            $father3 = pdo_get('hcpdd_users',array('user_id'=>$father2['fatherid']));
                            $com['user_id'] = $father3['user_id'];
                            $com['is_daili'] = $father3['is_daili'];
                            $com['level'] = 3;
                            if($father3['is_daili'] == 1){
                                $com['fx_rate'] = $cset['commission3'];
                                $com['fx_commission'] = $com['fee'] * $cset['commission3'] /100;
                            }
                            if($father3['is_daili'] == 2){
                                $com['fx_rate'] = $cset['zongjian_commission3'];
                                $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission3'] /100;
                            }
                            pdo_insert('hcpdd_pddcommission',$com);
                            $this->getfxmessage($father3['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'拼多多订单');
                        }
                    }
                }
                //生成分销订单结束
                $data1['fafang'] = 0;
                $data1['cfafang'] = 0;
                $data1['status'] = null;

                $fff[]= pdo_insert('hcpdd_allorder',$data1);
            }elseif($res['order_status'] != $v['order_status']){
//                    $data = $v;
                $data1['order_sn'] = $v['order_sn'];
                $data1['goods_id'] = $v['goods_id'];
                $data1['goods_name'] = $v['goods_name'];
                $data1['goods_thumbnail_url'] = $v['goods_thumbnail_url'];
                $data1['goods_quantity'] = $v['goods_quantity'];
                $data1['goods_price'] = $v['goods_price'];
                $data1['order_amount'] = $v['order_amount'];
                $data1['order_create_time'] = $v['order_create_time'];
                $data1['order_settle_time'] = $v['order_settle_time'];
                $data1['order_verify_time'] = $v['order_verify_time'];
                $data1['order_receive_time'] = $v['order_receive_time'];
                $data1['order_pay_time'] = $v['order_pay_time'];
                $data1['promotion_rate'] = $v['promotion_rate'];
                $data1['promotion_amount'] = $v['promotion_amount'];
                $data1['batch_no'] = $v['batch_no'];
                $data1['order_status'] = $v['order_status'];
                $data1['order_status_desc'] = $v['order_status_desc'];
                $data1['verify_time'] = $v['verify_time'];
                $data1['order_group_success_time'] = $v['order_group_success_time'];
                $data1['order_modify_at'] = $v['order_modify_at'];
                $data1['status'] = $v['status'];
                $data1['type'] = $v['type'];
                $data1['group_id'] = $v['group_id'];
                $data1['auth_duo_id'] = $v['auth_duo_id'];
                $data1['custom_parameters'] = $v['custom_parameters'];
                $data1['p_id'] = $v['p_id'];
                $data1['duo_coupon_amount'] = $v['duo_coupon_amount'];
                $data1['zs_duo_id'] = $v['zs_duo_id'];
                $data1['match_channel'] = $v['match_channel'];
                $data1['order_id'] = $v['order_id'];
                $data1['cpa_new'] = $v['cpa_new'];

                $data1['uniacid'] = $_W['uniacid'];
                if($v['order_status'] == -1 or $v['order_status'] == 4 or $v['order_status'] == 8){
                    $data1['commission'] = 0;
                    $com['status'] = 3;
                    pdo_update('hcpdd_pddcommission',$com, array('uniacid'=>$_W['uniacid'],'order_sn' =>$data1['order_sn']));
                }
                $fff[]= pdo_update('hcpdd_allorder',$data1, array('uniacid'=>$_W['uniacid'],'order_sn' =>$data1['order_sn']));
            }else{
                $cao = 1;
            }
        }
        /*if(empty($fff)){
            message('同步成功，没有新订单',$this->createWebUrl('orders'),'success');
        }else{
            message('同步成功',$this->createWebUrl('orders'),'success');
        }*/
    }
    //蘑菇街定时任务
    public function doMobileMoguauto(){
        
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));    
        $model = new moguapiModel();
        $access_token = $info['access_token'];
        $app_key = $info['app_key'];
        $AppSecret = $info['app_secret'];

        $yesterday = time() - 3600*24;

        $start = date('Ymd',$yesterday);//订单创建时间   
        $end = date('Ymd',time());//订单创建时间
        $orderInfoQuery = json_encode(array('start'=>$start,'end'=>$end,'page'=>1,'pagesize'=>200));
        
        $list = $model->moguapi_getorders($access_token,$app_key,$AppSecret,$orderInfoQuery);
        //筛选全部订单（除去未支付）
        foreach ($list as $k => $v) {
                if($v['paymentStatus'] != 10000 ){
                    $listall[] = $v;  
            }
        }
        //var_dump($listall);
        foreach ($listall as $k => $v){
            $res = pdo_get('hcpdd_moguorders',array('uniacid'=>$_W['uniacid'],'orderNo'=>$v['orderNo']));
            if(empty($res)){
                $data = $v;
                $data['uniacid'] = $_W['uniacid'];
                $data['products'] = json_encode($data['products']);
                //$data['fafang'] = 0;
                //生成分销订单
                $com['uniacid'] = $_W['uniacid'];
                $com['groupId'] = $data['groupId'];
                $com['orderNo'] = $data['orderNo'];
                $com['fee'] = $data['commission'];
                $com['status'] = 0;
                $com['addtime'] = time();
                $com['goodsname'] = $v['products'][0]['name'];
                if($user['fatherid']>0){
                    $father1 = pdo_get('hcpdd_users',array('user_id'=>$user['fatherid']));
                    $com['user_id'] = $father1['user_id'];
                    $com['is_daili'] = $father1['is_daili'];
                    $com['level'] = 1;
                    if($father1['is_daili'] == 1){
                        $com['fx_rate'] = $cset['commission1'];
                        $com['fx_commission'] = $com['fee'] * $cset['commission1'] /100;
                    }
                    if($father1['is_daili'] == 2){
                        $com['fx_rate'] = $cset['zongjian_commission1'];
                        $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission1'] /100;
                    }
                    pdo_insert('hcpdd_mogucommission',$com);
                    $this->getfxmessage($father1['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'蘑菇街订单');

                    if($father1['fatherid']>0){
                        $father2 = pdo_get('hcpdd_users',array('user_id'=>$father1['fatherid']));
                        $com['user_id'] = $father2['user_id'];
                        $com['is_daili'] = $father2['is_daili'];
                        $com['level'] = 2;
                        if($father2['is_daili'] == 1){
                            $com['fx_rate'] = $cset['commission2'];
                            $com['fx_commission'] = $com['fee'] * $cset['commission2'] /100;
                        }
                        if($father2['is_daili'] == 2){
                            $com['fx_rate'] = $cset['zongjian_commission2'];
                            $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission2'] /100;
                        }
                        pdo_insert('hcpdd_mogucommission',$com);
                        $this->getfxmessage($father2['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'蘑菇街订单');

                        if($father2['fatherid']>0){
                            $father3 = pdo_get('hcpdd_users',array('user_id'=>$father2['fatherid']));
                            $com['user_id'] = $father3['user_id'];
                            $com['is_daili'] = $father3['is_daili'];
                            $com['level'] = 3;
                            if($father3['is_daili'] == 1){
                                $com['fx_rate'] = $cset['commission3'];
                                $com['fx_commission'] = $com['fee'] * $cset['commission3'] /100;
                            }
                            if($father3['is_daili'] == 2){
                                $com['fx_rate'] = $cset['zongjian_commission3'];
                                $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission3'] /100;
                            }
                            pdo_insert('hcpdd_mogucommission',$com);
                            $this->getfxmessage($father3['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'蘑菇街订单');
                        }
                    }
                }
                //生成分销订单结束
                $fff[]= pdo_insert('hcpdd_moguorders',$data);
            }elseif($res['paymentStatus'] != $v['paymentStatus'] or $res['orderStatus'] != $v['orderStatus']){
                $data = $v;
                $data['uniacid'] = $_W['uniacid'];
                $data['products'] = json_encode($data['products']);
                if($v['paymentStatus'] == 10000 or $v['paymentStatus'] == 30000 or $v['paymentStatus'] == 90000 or $v['paymentStatus'] == 95000){
                    $data['commission'] = 0;
                    $com['status'] = 3;
                    pdo_update('hcpdd_mogucommission',$com, array('uniacid'=>$_W['uniacid'],'orderNo' =>$data['orderNo']));
                }
                $fff[]= pdo_update('hcpdd_moguorders',$data, array('orderNo' =>$data['orderNo']));
            }else{
                $cao = 1;
            }           
        }

    }

    //蘑菇街定时任务
    public function doMobileJdauto(){
        
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid'])); 
        $cset = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));       
        //同步订单
        $model = new moguapiModel();
        //$app_key = $info['jdappkey'];
        //$AppSecret = $info['jdsecretkey'];
        $key = $info['jdkey'];

        $time = date('YmdH',time());  //小时级
        $list = $model->jdapi_getorders($time,$key);
        if(empty($list)){
            $list = $model->jdapi_getorders2($time,$key);
        }
        if(empty($list)){
            $list = $model->jdapi_getorders3($time,$key);
        }
        /*if(!empty($list)){
            //筛选全部订单（除去待付款）
            foreach ($list as $k => $v) {
                    if($v['validCode'] > 15 ){
                        $listall[] = $v;  
                }
            }
            foreach ($listall as $k => $v){
                $res = pdo_get('hcpdd_jdorders',array('uniacid'=>$_W['uniacid'],'orderId'=>$v['orderId']));
                if(empty($res)){
                    $data = $v;
                    $data['uniacid'] = $_W['uniacid'];
                    $data['skuList'] = json_encode($data['skuList']);
                    $data['positionId'] = $v['skuList'][0]['positionId'];
                    $user = pdo_get('hcpdd_users',array('positionId'=>$data['positionId']));
                    $data['is_daili'] = $user['is_daili'];
                    if($user['is_daili'] == 0){
                        $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jdrate'];
                    }elseif($user['is_daili'] == 1){
                        $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jddailirate'];
                    }else{
                        $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jdzongjianrate'];
                    }   
                    unset($user);    
                    $fff[]= pdo_insert('hcpdd_jdorders',$data);
                }elseif($res['validCode'] != $v['validCode']){
                    $data = $v;
                    $data['uniacid'] = $_W['uniacid'];
                    $data['skuList'] = json_encode($data['skuList']);
                    $data['positionId'] = $v['skuList'][0]['positionId'];
                    if($v['validCode'] < 16){
                        $data['commission'] =0;
                    }
                    $fff[]= pdo_update('hcpdd_jdorders',$data, array('orderId' =>$data['orderId']));
                }else{
                    $cao = 1;
                }           
            }
        }*/
        if(!empty($list)){
                    //筛选全部订单（除去待付款）
                    foreach ($list as $k => $v) {
                            if($v['validCode'] > 15 ){
                                $listall[] = $v;  
                        }
                    }
                    foreach ($listall as $k => $v){
                        $res = pdo_get('hcpdd_jdorders',array('uniacid'=>$_W['uniacid'],'orderId'=>$v['orderId']));
                        if(empty($res)){
                            $data = $v;
                            $data['uniacid'] = $_W['uniacid'];
                            $data['skuList'] = json_encode($data['skuList']);
                            $data['positionId'] = $v['skuList'][0]['positionId'];
                            $user = pdo_get('hcpdd_users',array('positionId'=>$data['positionId']));
                            $data['is_daili'] = $user['is_daili'];
                            if($user['is_daili'] == 0){
                                $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jdrate'];
                            }elseif($user['is_daili'] == 1){
                                $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jddailirate'];
                            }else{
                                $data['commission'] = $v['skuList'][0]['estimateFee'] * $info['jdzongjianrate'];
                            } 
                            //生成分销订单
                            $com['uniacid'] = $_W['uniacid'];
                            $com['positionId'] = $data['positionId'];
                            $com['orderId'] = $data['orderId'];
                            $com['fee'] = $data['commission'];
                            $com['status'] = 0;
                            $com['addtime'] = time();
                            $com['goodsname'] = $v['skuList'][0]['skuName'];
                            if($user['fatherid']>0){
                                $father1 = pdo_get('hcpdd_users',array('user_id'=>$user['fatherid']));
                                $com['user_id'] = $father1['user_id'];
                                $com['is_daili'] = $father1['is_daili'];
                                $com['level'] = 1;
                                if($father1['is_daili'] == 1){
                                    $com['fx_rate'] = $cset['commission1'];
                                    $com['fx_commission'] = $com['fee'] * $cset['commission1'] /100;
                                }
                                if($father1['is_daili'] == 2){
                                    $com['fx_rate'] = $cset['zongjian_commission1'];
                                    $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission1'] /100;
                                }
                                pdo_insert('hcpdd_jdcommission',$com);
                                $this->getfxmessage($father1['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'京东订单');

                                if($father1['fatherid']>0){
                                    $father2 = pdo_get('hcpdd_users',array('user_id'=>$father1['fatherid']));
                                    $com['user_id'] = $father2['user_id'];
                                    $com['is_daili'] = $father2['is_daili'];
                                    $com['level'] = 2;
                                    if($father2['is_daili'] == 1){
                                        $com['fx_rate'] = $cset['commission2'];
                                        $com['fx_commission'] = $com['fee'] * $cset['commission2'] /100;
                                    }
                                    if($father2['is_daili'] == 2){
                                        $com['fx_rate'] = $cset['zongjian_commission2'];
                                        $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission2'] /100;
                                    }
                                    pdo_insert('hcpdd_jdcommission',$com);
                                    $this->getfxmessage($father2['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'京东订单');

                                    if($father2['fatherid']>0){
                                        $father3 = pdo_get('hcpdd_users',array('user_id'=>$father2['fatherid']));
                                        $com['user_id'] = $father3['user_id'];
                                        $com['is_daili'] = $father3['is_daili'];
                                        $com['level'] = 3;
                                        if($father3['is_daili'] == 1){
                                            $com['fx_rate'] = $cset['commission3'];
                                            $com['fx_commission'] = $com['fee'] * $cset['commission3'] /100;
                                        }
                                        if($father3['is_daili'] == 2){
                                            $com['fx_rate'] = $cset['zongjian_commission3'];
                                            $com['fx_commission'] = $com['fee'] * $cset['zongjian_commission3'] /100;
                                        }
                                        pdo_insert('hcpdd_jdcommission',$com);
                                        $this->getfxmessage($father3['user_id'],$user['nick_name'],$com['goodsname'],$com['fx_commission'],'京东订单');
                                    }
                                }
                            }
                            //京东生成分销订单结束
                            unset($user);        
                            $fff[]= pdo_insert('hcpdd_jdorders',$data);
                        }elseif($res['validCode'] != $v['validCode']){
                            $data = $v;
                            $data['uniacid'] = $_W['uniacid'];
                            $data['skuList'] = json_encode($data['skuList']);
                            $data['positionId'] = $v['skuList'][0]['positionId'];
                            if($v['validCode'] < 16){
                                $data['commission'] = 0;
                                $com['status'] = 3;
                                pdo_update('hcpdd_jdcommission',$com, array('uniacid'=>$_W['uniacid'],'orderId' =>$data['orderId']));
                            }
                            $fff[]= pdo_update('hcpdd_jdorders',$data, array('uniacid'=>$_W['uniacid'],'orderId' =>$data['orderId']));
                        }else{
                            $cao = 1;
                        }           
                    }
                }

        
    }

    //京东订单管理
    public function doWebCommission_jdorder(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid'])); 
        $cset = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));       
        

        /*$positionId  = $_GPC['positionId'];
        $order_status = $_GPC['order_status'];
        if(empty($order_status) and !empty($positionId)){
            $where['positionId'] = $positionId;
        }
        if(!empty($order_status) and empty($positionId)){
            $where['validCode'] = $order_status; 
            if($order_status == '66'){
                $where['fafang'] = 1;
                $where['validCode'] = 18; 
            }      
        }
        if(!empty($order_status) and !empty($positionId)){
            $where['validCode'] = $order_status;
            $where['positionId'] = $positionId;
            if($order_status == '66'){
                $where['fafang'] = 1;
                $where['validCode'] = 18;
            }
        }
        */
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 20;
        $where['uniacid'] = $_W['uniacid'];

        $result = pdo_getslice('hcpdd_jdcommission',$where,array($pageindex, $pagesize),$total,array(),'','addtime desc');
        foreach ($result as $k => $v) {
            $user = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'positionId'=>$v['positionId']));
            $father = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'user_id'=>$v['user_id']));
            $result[$k]['nick_name'] = $user['nick_name'];
            $result[$k]['father'] = $father['nick_name'];
            //$result[$k]['is_daili'] = $user['is_daili'];
            $result[$k]['addtime'] = date("Y-m-d : H:i",$v['addtime']);


        }
        
        $page = pagination($total, $pageindex, $pagesize);  

        include $this->template('commission_jdorder');      
    }

    //京东订单管理
    public function doWebCommission_moguorder(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid'])); 
        $cset = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));       
        

        /*$positionId  = $_GPC['positionId'];
        $order_status = $_GPC['order_status'];
        if(empty($order_status) and !empty($positionId)){
            $where['positionId'] = $positionId;
        }
        if(!empty($order_status) and empty($positionId)){
            $where['validCode'] = $order_status; 
            if($order_status == '66'){
                $where['fafang'] = 1;
                $where['validCode'] = 18; 
            }      
        }
        if(!empty($order_status) and !empty($positionId)){
            $where['validCode'] = $order_status;
            $where['positionId'] = $positionId;
            if($order_status == '66'){
                $where['fafang'] = 1;
                $where['validCode'] = 18;
            }
        }
        */
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 20;
        $where['uniacid'] = $_W['uniacid'];

        $result = pdo_getslice('hcpdd_mogucommission',$where,array($pageindex, $pagesize),$total,array(),'','addtime desc');
        foreach ($result as $k => $v) {
            $user = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'gid'=>$v['groupId']));
            $father = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'user_id'=>$v['user_id']));
            $result[$k]['nick_name'] = $user['nick_name'];
            $result[$k]['father'] = $father['nick_name'];
            //$result[$k]['is_daili'] = $user['is_daili'];
            $result[$k]['addtime'] = date("Y-m-d : H:i",$v['addtime']);
        }
        
        $page = pagination($total, $pageindex, $pagesize); 

        include $this->template('commission_moguorder');      
    }

	public function doWebPromotion(){
		global $_W,$_GPC;
		$op = empty($_GPC['op'])?'display':$_GPC['op'];
		$weid = $_W['uniacid'];
		if($op == 'display'){
			
			$pageindex = max(1, intval($_GPC['page']));
	        $pagesize = 10;
	        $where['weid'] = $weid;
			if(!empty($_GPC['keyword'])){
				$where['nickname like'] = '%'.$_GPC['keyword'].'%';
			}

			$list = pdo_getslice('hcknowme_user',$where,array($pageindex, $pagesize),$total,array() ,'','id desc');
			$page = pagination($total, $pageindex, $pagesize);

			foreach ($list as &$v){
				$v['found'] = pdo_getcolumn('hcknowme_order',array('mid'=>$v['id'],'status >'=>0),'count(*)');
				$v['attend'] = pdo_getcolumn('hcknowme_log',array('mid'=>$v['id']),'count(*)');
			}
			unset($v);

			$today = strtotime(date('Y-m-d'));
			$now = time();
			$today_mem = pdo_getcolumn('hcknowme_user',array('weid'=>$_W['uniacid'],'createtime >='=>$today,'createtime <='=>$now),'count(*)');
			$all_mem = pdo_getcolumn('hcknowme_user',array('weid'=>$_W['uniacid']),'count(*)');
			$all_credit = pdo_getcolumn('hcknowme_user',array('weid'=>$_W['uniacid']),'sum(credit)');
		}
		elseif ($op == 'del') {
			$id = $_GPC['id'];
			$item = pdo_get('hcknowme_user',array('id'=>$id,'weid'=>$_W['uniacid']));
			if(empty($item)){
				message('操作失败',$this->createWebUrl('user'),'error');
			}
			if(pdo_delete('hcknowme_user',array('id'=>$id,'weid'=>$_W['uniacid'])) === false) message('操作失败',referer(),'error');
			else message('操作成功',$this->createWebUrl('user'),'success');
		}
		
		elseif($op == 'status'){
			$id = $_GPC['id'];
			$status = pdo_getcolumn("hcknowme_user",array('id'=>$id,'weid'=>$_W['uniacid']),'status');
			if(empty($status)){
				$st['status'] = 1;
			}else{
				$st['status'] = 0;
			}
			pdo_update('hcknowme_user',$st,array('id'=>$id,'weid'=>$_W['uniacid']));
			die('1');
		}

		include $this->template('promotion'); 
	}
    //提现管理
	public function doWebWithdrawal(){

        global $_W, $_GPC;
        $data = pdo_getall('hcpdd_tixian', array('uniacid' =>$_W['uniacid']), array() , '','id DESC');
        foreach ($data as $k=>$v){
           $res = pdo_get('hcpdd_users',array('user_id'=>$v['user_id']));
           $data[$k]['nick_name'] = $res['nick_name'];
           $data[$k]['head_pic'] = $res['head_pic'];          
        }
        $list = $data;
        //var_dump($list);
		include $this->template('withdrawal');


	}
    //提现审核
    public function doWebEditwithdrawal()
    {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $status = $_POST['status'];
        //一条提现申请记录
        $res = pdo_get('hcpdd_tixian',array('id'=>$id));
        if($_GPC['act']=='edit'){       	
            //一条用户信息
            $data = pdo_get('hcpdd_users',array('user_id'=>$res['user_id']));
            if($status == 0){
        	   $update = array(
                    'status' => $status
                    );
        	   $aaa = pdo_update('hcpdd_tixian',$update, array('id' =>$id));

        	   $gengxin = array(
                     'finishmoney' => $data['finishmoney']+$res['money'],
                     //'money'       => $data['money'] - $res['money'],
                     'waitmoney'   => $data['waitmoney'] - $res['money']
        		);
        	   $bbb = pdo_update('hcpdd_users',$gengxin, array('user_id' =>$res['user_id'])); 
        	   if (!empty($bbb)){
               message('操作成功',$this->createWebUrl('withdrawal'));
        }                   	
        }

        }
        
        include $this->template('editwithdrawal');
        
    }
    //角色升级
    public function doWebEditlevel()
    {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $level = $_POST['level'];
        //一条提现申请记录
        $res = pdo_get('hcpdd_users',array('user_id'=>$id));
        if($_GPC['act']=='edit'){           
            //一条用户信息
            $data = pdo_get('hcpdd_users',array('user_id'=>$res['user_id']));
            if($level == 0){
               $update = array(
                    'is_daili' => '1'
                    );
               $bbb = pdo_update('hcpdd_users',$update, array('user_id' =>$id)); 
               if (!empty($bbb)){
               message('操作成功',$this->createWebUrl('member'));
               }                       
            }
            if($level == 1){
               $update = array(
                    'is_daili' => '2'
                    );
               $bbb = pdo_update('hcpdd_users',$update, array('user_id' =>$id));  
               if (!empty($bbb)){
               message('操作成功',$this->createWebUrl('member'));
               }                       
            }

        }
        
        include $this->template('editlevel');
        
    }

    //上级管理
    public function doWebEditpid()
    {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $fatherid = $_POST['fatherid'];
        $res = pdo_get('hcpdd_users',array('user_id'=>$id));
        if($_GPC['act']=='edit'){
            //是否存在此上级用户
            if ($fatherid == 0){
                $update = array(
                    'fatherid' => 0
                );
            }elseif ($fatherid == $id){
                message('上级用户ID输入错误',$this->createWebUrl('editpid',array('id'=>$id)));
            }else{
                $fid_res = pdo_get('hcpdd_users',array('user_id'=>$fatherid));
                if (empty($fid_res)){
                    message('此上级用户不存在',$this->createWebUrl('editpid',array('id'=>$id)));
                }else{
                    $update = array(
                        'fatherid' => $fatherid
                    );

                }
            }
            $bbb = pdo_update('hcpdd_users',$update, array('user_id' =>$id));
            if (!empty($bbb)){
                message('操作成功',$this->createWebUrl('member'));
            }

        }
        include $this->template('editpid');

    }

    //公告管理
	public function doWebNotice() {
		global $_W,$_GPC;

		$where['uniacid'] = $_W['uniacid'];
		
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

		$list = pdo_getslice('hcpdd_notice',$where,array($pageindex, $pagesize),$total,array(),'','displayorder asc');
		foreach($list as $key=>$val){
			$list[$key]['createtime'] = date('Y-m-d H:i',$val['createtime']);
		}
		$page = pagination($total, $pageindex, $pagesize);

		include $this->template('notice');
	}


   //添加公告
	public function doWebNotice_post() {
		global $_W,$_GPC;
		$id = $_GPC['id'];

		if($_GPC['act']=='add'){
			$data['uniacid'] = $_W['uniacid'];
			$data['createtime'] = time();
			empty($_GPC['title'])?'':$data['title'] = $_GPC['title'];
			empty($_GPC['content'])?'':$data['content'] = $_GPC['content'];
			empty($_GPC['enabled'])?'':$data['enabled'] = $_GPC['enabled'];

			$result = pdo_insert('hcpdd_notice', $data);
			
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('notice'));
			}
		}

		if($_GPC['act']=='edit'){
			$data['uniacid'] = $_W['uniacid'];
			$data['createtime'] = time();
			empty($_GPC['title'])?'':$data['title'] = $_GPC['title'];
			empty($_GPC['content'])?'':$data['content'] = $_GPC['content'];
			$data['enabled'] = $_GPC['enabled'];

			$result = pdo_update('hcpdd_notice', $data, array('id'=>$_GPC['id']));
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('notice'));
			}
		}

		if($_GPC['act']=='del'){
			$result = pdo_delete('hcpdd_notice', array('id'=>$_GPC['id']));
			
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('notice'));
			}
		}
		$info = pdo_get('hcpdd_notice',array('id'=>$id));

		include $this->template('notice_post');
	}

    //推荐管理
    public function doWebTuijian() {
        global $_W,$_GPC;

        $where['uniacid'] = $_W['uniacid'];
        
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

        $list = pdo_getslice('hcpdd_tuijian',$where,array($pageindex, $pagesize),$total,array(),'','displayorder asc');
        foreach($list as $k=>$v){
            if($v['jump'] == 0){
                $list[$k]['jump'] = '全部';
            }elseif($v['jump'] == 1){
                $list[$k]['jump'] = '蘑菇街';
            }elseif($v['jump'] == 2){
                $list[$k]['jump'] = '爆品';
            }elseif($v['jump'] == 3){
                $list[$k]['jump'] = '高佣';
            }elseif($v['jump'] == 4){
                $list[$k]['jump'] = '9.9包邮';
            }elseif($v['jump'] == 5){
                $list[$k]['jump'] = '品牌优惠';
            }elseif($v['jump'] == 6){
                $list[$k]['jump'] = '排行榜';
            }elseif($v['jump'] == 7){
                $list[$k]['jump'] = '京东爆品';
            }
        }
        $page = pagination($total, $pageindex, $pagesize);

        include $this->template('tuijian');
    }


   //添加推荐
    public function doWebTuijian_post() {
        global $_W,$_GPC;
        $id = $_GPC['id'];

        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            $data['displayorder'] = $_GPC['displayorder'];
            $data['jump'] = $_GPC['jump'];
            $data['toppic'] = $_GPC['toppic'];
            $data['title'] = $_GPC['title'];
            $data['title2'] = $_GPC['title2'];
            $data['titlecolor'] = $_GPC['titlecolor'];
        
            $result = pdo_insert('hcpdd_tuijian', $data);
            
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('tuijian'));
            }
        }

        if($_GPC['act']=='auto'){
            $data1['uniacid'] = $_W['uniacid'];
            $data1['displayorder'] = 1;
            $data1['jump'] = 0;
            $data1['title'] = '全部';
            $data1['title2'] = '猜你喜欢';
            $data1['toppic'] = $_W['siteroot']."addons/hc_pdd/template/img/all.jpg";
            $data1['titlecolor'] = '#cc0000';

            $data2['uniacid'] = $_W['uniacid'];
            $data2['displayorder'] = 2;
            $data2['jump'] = 1;
            $data2['title'] = '蘑菇街';
            $data2['title2'] = '美丽女装';
            $data2['toppic'] = $_W['siteroot']."addons/hc_pdd/template/img/mogu.jpg";
            $data2['titlecolor'] = '#fa8ac1';

            $data3['uniacid'] = $_W['uniacid'];
            $data3['displayorder'] = 3;
            $data3['jump'] = 2;
            $data3['title'] = '爆品';
            $data3['title2'] = '今日爆款';
            $data3['toppic'] = $_W['siteroot']."addons/hc_pdd/template/img/baokuan.jpg";
            $data3['titlecolor'] = '#434343';

            $data4['uniacid'] = $_W['uniacid'];
            $data4['displayorder'] = 4;
            $data4['jump'] = 3;
            $data4['title'] = '高佣';
            $data4['title2'] = '好卖好赚';
            $data4['toppic'] = $_W['siteroot']."addons/hc_pdd/template/img/gaoyong.jpg";
            $data4['titlecolor'] = '#ff9900';

            $data5['uniacid'] = $_W['uniacid'];
            $data5['displayorder'] = 5;
            $data5['jump'] = 4;
            $data5['title'] = '9.9包邮';
            $data5['title2'] = '限时优惠';
            $data5['toppic'] = $_W['siteroot']."addons/hc_pdd/template/img/99.jpg";
            $data5['titlecolor'] = '#93c47d';

            $data6['uniacid'] = $_W['uniacid'];
            $data6['displayorder'] = 6;
            $data6['jump'] = 5;
            $data6['title'] = '品牌优惠';
            $data6['title2'] = '知名品牌';
            $data6['toppic'] = $_W['siteroot']."addons/hc_pdd/template/img/pinpai.jpg";
            $data6['titlecolor'] = '#3d85c6';

            $data7['uniacid'] = $_W['uniacid'];
            $data7['displayorder'] = 7;
            $data7['jump'] = 6;
            $data7['title'] = '排行榜';
            $data7['title2'] = '实时更新';
            $data7['toppic'] = $_W['siteroot']."addons/hc_pdd/template/img/paihang.jpg";
            $data7['titlecolor'] = '#9900ff';

            $data8['uniacid'] = $_W['uniacid'];
            $data8['displayorder'] = 8;
            $data8['jump'] = 7;
            $data8['title'] = '京东爆品';
            $data8['title2'] = '就要省钱';
            $data8['toppic'] = $_W['siteroot']."addons/hc_pdd/template/img/jd.jpg";
            $data8['titlecolor'] = '#ff0000';
        
            $result = pdo_insert('hcpdd_tuijian', $data1);
            $result = pdo_insert('hcpdd_tuijian', $data2);
            $result = pdo_insert('hcpdd_tuijian', $data3);
            $result = pdo_insert('hcpdd_tuijian', $data4);
            $result = pdo_insert('hcpdd_tuijian', $data5);
            $result = pdo_insert('hcpdd_tuijian', $data6);
            $result = pdo_insert('hcpdd_tuijian', $data7);
            $result = pdo_insert('hcpdd_tuijian', $data8);
            
            if(!empty($result)){
                message('操作成功',$this->createWebUrl('tuijian'));
            }
        }

        if($_GPC['act']=='edit'){
            $data['uniacid'] = $_W['uniacid'];
            $data['displayorder'] = $_GPC['displayorder'];
            $data['jump'] = $_GPC['jump'];
            $data['toppic'] = $_GPC['toppic'];
            $data['title'] = $_GPC['title'];
            $data['title2'] = $_GPC['title2'];
            $data['titlecolor'] = $_GPC['titlecolor'];

            $result = pdo_update('hcpdd_tuijian', $data, array('id'=>$_GPC['id']));
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('tuijian'));
            }
        }

        if($_GPC['act']=='del'){
            $result = pdo_delete('hcpdd_tuijian', array('id'=>$_GPC['id']));
            
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('tuijian'));
            }
        }

        if($_GPC['act']=='display'){
            $result = pdo_update('hcpdd_tuijian',array('displayorder'=>$_GPC['displayorder']),array('id'=>$_GPC['id']));
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('tuijian'));
            }
        }
        $info = pdo_get('hcpdd_tuijian',array('id'=>$id));
        $info['toppic1'] = $_W['siteroot']."addons/hc_pdd/template/img/all.jpg";
        $info['toppic2'] = $_W['siteroot']."addons/hc_pdd/template/img/mogu.jpg";
        $info['toppic3'] = $_W['siteroot']."addons/hc_pdd/template/img/baokuan.jpg";
        $info['toppic4'] = $_W['siteroot']."addons/hc_pdd/template/img/gaoyong.jpg";
        $info['toppic5'] = $_W['siteroot']."addons/hc_pdd/template/img/99.jpg";
        $info['toppic6'] = $_W['siteroot']."addons/hc_pdd/template/img/pinpai.jpg";
        $info['toppic7'] = $_W['siteroot']."addons/hc_pdd/template/img/paihang.jpg";
        $info['toppic8'] = $_W['siteroot']."addons/hc_pdd/template/img/jd.jpg";

        include $this->template('tuijian_post');
    }

    //发圈素材
    public function doWebCopy() {
        global $_W,$_GPC;

        $where['uniacid'] = $_W['uniacid'];
        
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

        $list = pdo_getslice('hcpdd_copy',$where,array($pageindex, $pagesize),$total,array(),'','createtime desc');
        foreach($list as $key=>$val){
            $list[$key]['createtime'] = date('Y-m-d H:i',$val['createtime']);
            $list[$key]['copy_text'] = json_decode($val['copy_text']);
        }
        $page = pagination($total, $pageindex, $pagesize);

        include $this->template('copy');
    }


   //添加公告
    public function doWebCopy_post() {
        global $_W,$_GPC;
        $id = $_GPC['id'];

        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            $data['createtime'] = time();
            empty($_GPC['copy_img'])?'':$data['copy_img'] = $_GPC['copy_img'];
            empty($_GPC['copy_type'])?'':$data['copy_type'] = $_GPC['copy_type'];
            empty($_GPC['copy_goodsid'])?'':$data['copy_goodsid'] = $_GPC['copy_goodsid'];
            $data['copy_text'] = json_encode($_GPC['copy_text']);

            $result = pdo_insert('hcpdd_copy', $data);
            
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('copy'));
            }
        }

        if($_GPC['act']=='edit'){
            $data['uniacid'] = $_W['uniacid'];
            $data['createtime'] = time();
            $data['copy_img'] = $_GPC['copy_img'];
            $data['copy_type'] = $_GPC['copy_type'];
            $data['copy_goodsid'] = $_GPC['copy_goodsid'];
            $data['copy_text'] = json_encode($_GPC['copy_text']);

            $result = pdo_update('hcpdd_copy', $data, array('id'=>$_GPC['id']));
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('copy'));
            }
        }

        if($_GPC['act']=='del'){
            $result = pdo_delete('hcpdd_copy', array('id'=>$_GPC['id']));
            
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('copy'));
            }
        }
        $info = pdo_get('hcpdd_copy',array('id'=>$id));
        $info['copy_text'] = json_decode($info['copy_text']);
        include $this->template('copy_post');
    }
	

    function api_notice_increment($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function doWebCommission_set(){
        global $_W,$_GPC;
		if($_GPC['act']=='add'){
			$data['uniacid'] = $_W['uniacid'];
			/*empty($_GPC['client_id'])?'':$data['client_id'] = $_GPC['client_id'];*/
			$data['fx_level'] = $_GPC['fx_level'];
			$data['is_shoufei'] = $_GPC['is_shoufei'];
			$data['commission1'] = $_GPC['commission1'];
			$data['commission2'] = $_GPC['commission2'];
			$data['commission3'] = $_GPC['commission3'];
			$data['zongjian_commission1'] = $_GPC['zongjian_commission1'];
			$data['zongjian_commission2'] = $_GPC['zongjian_commission2'];
			$data['zongjian_commission3'] = $_GPC['zongjian_commission3'];
			$data['tx_money'] = $_GPC['tx_money'];
			$data['tx_rate'] = $_GPC['tx_rate'];
			$data['dailifei'] = $_GPC['dailifei'];
			$data['zongjianfei'] = $_GPC['zongjianfei'];
			$data['agreement'] = $_GPC['agreement'];
			$data['invite_agreement'] = $_GPC['invite_agreement'];
			$data['zongjian_agreement'] = $_GPC['zongjian_agreement'];
			$data['daili'] = $_GPC['daili'];
			$data['yunyingzongjian'] = $_GPC['yunyingzongjian'];
			$data['yongjin'] = $_GPC['yongjin'];
			$data['yiji'] = $_GPC['yiji'];
			$data['erji'] = $_GPC['erji'];
			$data['sanji'] = $_GPC['sanji'];
			$data['invite_title'] = $_GPC['invite_title'];
			$data['invite_pic'] = $_GPC['invite_pic'];
            $data['invite_bg'] = $_GPC['invite_bg'];
            //$data['guize_bg'] = $_GPC['guize_bg'];
            $data['inviteposter1'] = $_GPC['inviteposter1'];
            $data['inviteposter2'] = $_GPC['inviteposter2'];
            $data['inviteposter3'] = $_GPC['inviteposter3'];
            $data['dailisum'] = $_GPC['dailisum'];
            $data['zongjiansum'] = $_GPC['zongjiansum'];
            $data['shengdaili'] = $_GPC['shengdaili'];
            $data['shengzongjian'] = $_GPC['shengzongjian'];
			
			$ishave = pdo_get('hcpdd_cset', array('uniacid' => $_W['uniacid']));
			if(!empty($ishave)){
				$result = pdo_update('hcpdd_cset', $data ,array('uniacid'=>$_W['uniacid']));
			}else{
				$result = pdo_insert('hcpdd_cset', $data);
			}
			if (!empty($result)) {
			    message('操作成功',$this->createWebUrl('commission_set'));
			}
		}
		$info = pdo_get('hcpdd_cset', array('uniacid' => $_W['uniacid']));
        if(empty($info['shengdaili'])){
           $info['shengdaili'] = $_W['siteroot']."addons/hc_pdd/template/img/shengdaili.png";
        }
        if(empty($info['shengzongjian'])){
           $info['shengzongjian'] = $_W['siteroot']."addons/hc_pdd/template/img/shengzongjian.png";
        }

    	include $this->template('commission_set');
    }

    public function doWebCommission_daili(){
        global $_W,$_GPC;
        
        $keyword = $_GPC['keyword'];        
	    if(!empty($_GPC['keyword'])){
			$where['nick_name LIKE'] = '%'.$keyword.'%';
		}
		$where['uniacid'] = $_W['uniacid'];
		$where['is_daili'] = 1;
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

		$list = pdo_getslice('hcpdd_users',$where,array($pageindex, $pagesize),$total,array(),'','user_id desc');
		foreach ($list as $k => $v) {
			$list[$k]['fathername'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('nick_name')); 
			$list[$k]['fatherpic'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('head_pic'));
		}
		$page = pagination($total, $pageindex, $pagesize);
        //var_dump($list);
        include $this->template('commission_daili');
    }

    public function doWebCommission_zongjian(){
        global $_W,$_GPC;
        
        $keyword = $_GPC['keyword'];        
	    if(!empty($_GPC['keyword'])){
			$where['nick_name LIKE'] = '%'.$keyword.'%';
		}
		$where['uniacid'] = $_W['uniacid'];
		$where['is_daili'] = 2;
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

		$list = pdo_getslice('hcpdd_users',$where,array($pageindex, $pagesize),$total,array(),'','user_id desc');
		foreach ($list as $k => $v) {
			$list[$k]['fathername'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('nick_name')); 
			$list[$k]['fatherpic'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('head_pic'));
		}
		$page = pagination($total, $pageindex, $pagesize);
        //var_dump($list);
        include $this->template('commission_zongjian');
    }

    public function doWebCommission_order(){
        global $_W,$_GPC;
        
        $keyword = $_GPC['keyword'];        
	    if(!empty($_GPC['keyword'])){
			$where['ordersn LIKE'] = '%'.$keyword.'%';
		}
		$where['weid'] = $_W['uniacid'];
        $where['status'] = 1;
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

		$list = pdo_getslice('hcpdd_orders',$where,array($pageindex, $pagesize),$total,array(),'','id desc');
		foreach ($list as $k => $v) {
			$list[$k]['paytime'] = date('Y-m-d H:i',$v['paytime']);
			$list[$k]['head_pic'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['uid']),array('head_pic'));
			$list[$k]['nick_name'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['uid']),array('nick_name'));
		}
		$page = pagination($total, $pageindex, $pagesize);
        //var_dump($list);
        include $this->template('commission_order');
    }
    //佣金提现管理
	public function doWebCommission_withdraw(){

        global $_W, $_GPC;
        $data = pdo_getall('hcpdd_tixian', array('uniacid' =>$_W['uniacid']), array() , '','id DESC');
        foreach ($data as $k=>$v){
           $res = pdo_get('hcpdd_users',array('user_id'=>$v['user_id']));
           $data[$k]['nick_name'] = $res['nick_name'];
           $data[$k]['head_pic'] = $res['head_pic'];          
        }
        $list = $data;
        //var_dump($list);
		include $this->template('commission_withdraw');
	}

	public function doWebMyteam(){

     global $_W,$_GPC;
     //各种设置
     $info = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
     //$set = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));    
     $_POST['user_id'] = $_GPC['user_id'];

     $user = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'user_id'=>$_GPC['user_id']));
     //一级下线
     $son1_daili = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
     $son1_huiyuan = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));
     $son1 = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_W['uniacid']));
     //二级下线    
     foreach ($son1_daili as $k => $v) {
        $son2_daili[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
        $son2_huiyuan[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));       
        $son2[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_W['uniacid']));

            /*foreach ($son2_daili[$k] as $key => $value) {
            $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
            $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));
            $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid']));
            }*/
     }
  //一级下线
     $pid1 = array_column($son1, 'pid');
  //二级下线
     foreach ($son2 as $k => $v) {
     	foreach ($son2[$k] as $key => $value) {
     		$pid2[] = $value['pid'];
     	}  	 
     }
     foreach ($son2_daili as $k => $v) {
        foreach ($son2_daili[$k] as $key => $value) {
            $userid2[] = $value;
        }    
     }
  //三级下线
     foreach ($userid2 as $key => $value) {
            $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
            $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));
            $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid']));
    }     
   //三级下线  
     foreach ($son3 as $k => $v) {
     	foreach ($son3[$k] as $key => $value) {
     		$pid3[] = $value['pid'];
     	}  	 
     }
     //一级
     foreach ($pid1 as $k => $v) {
     	$list1[] = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'pid'=>$v));
     }
     foreach ($list1 as $k => $v) {
			$list1[$k]['fathername'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('nick_name')); 
			$list1[$k]['fatherpic'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('head_pic'));
	 }
	 //二级
     foreach ($pid2 as $k => $v) {
     	$list2[] = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'pid'=>$v));
     }
     foreach ($list2 as $k => $v) {
			$list2[$k]['fathername'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('nick_name')); 
			$list2[$k]['fatherpic'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('head_pic'));
	 }
	 //三级
     foreach ($pid3 as $k => $v) {
     	$list3[] = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'pid'=>$v));
     }
     foreach ($list3 as $k => $v) {
			$list3[$k]['fathername'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('nick_name')); 
			$list3[$k]['fatherpic'] = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['fatherid']),array('head_pic'));
	 }

	 $cpid1 = count($pid1);
	 $cpid2 = count($pid2);
	 $cpid3 = count($pid3);
	 if($info['fx_level'] == 1){
	 	$cpid = $cpid1;
	 }
	 if($info['fx_level'] == 2){
	 	$cpid = $cpid1+$cpid2;
	 }
	 if($info['fx_level'] == 3){
	 	$cpid = $cpid1+$cpid2+$cpid3;
	 }

    // var_dump($pid2);
     include $this->template('myteam');
	}

	public function doWebMyteam_orders(){
	 global $_W,$_GPC;
     //各种设置
     $info = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
     $user = pdo_get('hcpdd_users',array('uniacid'=>$_W['uniacid'],'user_id'=>$_GPC['user_id']));
     $set = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid'])); 

     //$listallall = pdo_getall('hcpdd_allorder', array('uniacid' => $_W['uniacid']));
     $listall = pdo_getall('hcpdd_allorder', array('uniacid' => $_W['uniacid'],'order_status >=' =>0,'order_status <'=>4));
     //筛选有效订单
        /*foreach ($listallall as $key => $value) {
            if($value['order_status'] >= 0 and $value['order_status']<4 ){
                $listall[] = $value;
            }     
        }*/
    //var_dump($listallall);

     //一级下线
     $son1_daili = pdo_getall('hcpdd_users', array('fatherid' =>$_GPC['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
     $son1_huiyuan = pdo_getall('hcpdd_users', array('fatherid' =>$_GPC['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));
     $son1 = pdo_getall('hcpdd_users', array('fatherid' =>$_GPC['user_id'],'uniacid' =>$_W['uniacid']));
     //二级下线    
     foreach ($son1_daili as $k => $v) {
        $son2_daili[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
        $son2_huiyuan[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));       
        $son2[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_W['uniacid']));

            /*foreach ($son2_daili[$k] as $key => $value) {
            $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
            $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));
            $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid']));
            }*/
     }

          //一级下线
             $pid1 = array_column($son1, 'pid');
             //var_dump($pid1);
          //二级下线
            foreach ($son2 as $k => $v) {
                foreach ($son2[$k] as $key => $value) {
                    $pid2[] = $value['pid'];
                }    
             }
            foreach ($son2_daili as $k => $v) {
                foreach ($son2_daili[$k] as $key => $value) {
                    $userid2[] = $value;
                }    
            }
            //三级下线
            foreach ($userid2 as $key => $value) {
                    $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
                    $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));
                    $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid']));
            } 
             
           //三级下线    
             foreach ($son3 as $k => $v) {
                foreach ($son3[$k] as $key => $value) {
                    $pid3[] = $value['pid'];
                }    
             }          

           foreach ($listall as $key => $value) {
               if(in_array($value['p_id'],$pid1)){
                $order1[] = $value;
               }
               if(in_array($value['p_id'],$pid2)){
                $order2[] = $value;
               }
               if(in_array($value['p_id'],$pid3)){
                $order3[] = $value;
               }
               if($value['p_id'] == $user['pid']){
                $listlist[] = $value;
               }
           }
           //var_dump($pid3);
           $order_count1 = count($order1);
           $order_count2 = count($order2);
           $order_count3 = count($order3);
  
  /*//一级下线订单
     $pid1 = array_column($son1, 'pid');
     foreach ($pid1 as $k => $v) {
        $res = $this->Ordermoneydetail($v);
        if(!empty($res)){
        	//$corder1[] = $this->Ordermoneydetail($v);
            $corder1[] = $res;
        }    	
     }
     foreach ($corder1 as $k => $v) {
     	foreach ($corder1[$k] as $key => $value) {
     		$order1[] = $value;

     	}  	 
     }
     //筛选有效订单
     foreach ($order1 as $k => $v) {
        if($v['order_status'] >= 0){
            $order11[]=$v;
        }
     }
     $order1 = $order11;
     $order_count1 = count($order1);
     //$money_count1 = array_sum(array_column($order1, 'promotion_amount'))/100;   //一级下线佣金总和
  //二级下线订单
     foreach ($son2 as $k => $v) {
     	foreach ($son2[$k] as $key => $value) {
     		$pid2[] = $value['pid'];
     	}  	 
     }
     foreach ($pid2 as $k => $v) {
        $res = $this->Ordermoneydetail($v);
        if(!empty($res)){
        	//$corder2[] = $this->Ordermoneydetail($v);
            $corder2[] = $res;
        }    	
     }
     foreach ($corder2 as $k => $v) {
     	foreach ($corder2[$k] as $key => $value) {
     		$order2[] = $value;
     	}  	 
     }
     //筛选有效订单
     foreach ($order2 as $k => $v) {
        if($v['order_status'] >= 0){
            $order22[]=$v;
        }
     }
     $order2 = $order22;
     $order_count2 = count($order2);
     //$money_count2 = array_sum(array_column($order2, 'promotion_amount'))/100;   //一级下线佣金总和     
   //三级下线订单    
     foreach ($son3 as $k => $v) {
     	foreach ($son3[$k] as $key => $value) {
     		$pid3[] = $value['pid'];
     	}  	 
     }
     foreach ($pid3 as $k => $v) {
        $res = $this->Ordermoneydetail($v);
        if(!empty($res)){
        	//$corder3[] = $this->Ordermoneydetail($v);
            $corder3[] = $res;
        }    	
     }
     foreach ($corder3 as $k => $v) {
     	foreach ($corder3[$k] as $key => $value) {
     		$order3[] = $value;
     	}  	 
     }
     //筛选有效订单
     foreach ($order3 as $k => $v) {
        if($v['order_status'] >= 0){
            $order33[]=$v;
        }
     }
     $order3 = $order33;
     $order_count3 = count($order3);
     //$money_count3 = array_sum(array_column($order3, 'promotion_amount'))/100;   //一级下线佣金总和*/

     //各级各角色佣金比例
     if($user['is_daili'] == 1){
     	$rate1 = $info['commission1'];
     	$rate2 = $info['commission2'];
     	$rate3 = $info['commission3'];
     }
     if($user['is_daili'] == 2){
     	$rate1 = $info['zongjian_commission1'];
     	$rate2 = $info['zongjian_commission2'];
     	$rate3 = $info['zongjian_commission3'];
     	$time  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_W['uniacid'],'uid'=>$_GPC['user_id'],'fid'=>1),array('paytime'));
     } 

     //各级下线佣金明细
     if($user['is_daili'] == 1){
         foreach ($order1 as $k => $v) {
             $aaa = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('is_daili'));
             if($aaa == 0){
               $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate']; 
               $order1[$k]['ctype'] = '代理推会员';
             }elseif($aaa == 1){
               $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate']; 
               $order1[$k]['ctype'] = '代理推代理';
             }else{
               $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate']; 
               $order1[$k]['ctype'] = '代理推总监';
             }             
             $order1[$k]['rate'] = $rate1;            
             $order1[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order1[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('nick_name'));
         }
         foreach ($order2 as $k => $v) {
             $bbb = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('is_daili'));
             if($bbb == 0){
               $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate']; 
               $order2[$k]['ctype'] = '代理推会员';
             }elseif($bbb == 1){
               $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate']; 
               $order2[$k]['ctype'] = '代理推代理';
             }else{
               $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate']; 
               $order2[$k]['ctype'] = '代理推总监';
             }
             $order2[$k]['rate'] = $rate2;            
             $order2[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order2[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('nick_name'));
         }
         foreach ($order3 as $k => $v) {
             $ccc = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('is_daili'));
             if($ccc == 0){
               $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate']; 
               $order3[$k]['ctype'] = '代理推会员';
             }elseif($ccc == 1){
               $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate']; 
               $order3[$k]['ctype'] = '代理推代理';
             }else{
               $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate']; 
               $order3[$k]['ctype'] = '代理推总监';
             }
             $order3[$k]['rate'] = $rate3;            
             $order3[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order3[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('nick_name'));
         } 
    }
//运营总监各级下线佣金明细
     if($user['is_daili'] == 2){
        foreach ($order1 as $k => $v) {
             $ddd = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('is_daili'));             
             if($order1[$k]['order_modify_at'] > $time){
                    $order1[$k]['rate'] = $rate1;
                    if($ddd == 0){
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate'];
                        $order1[$k]['ctype'] = '总监推会员';
                    }elseif($ddd == 1){
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate'];
                        $order1[$k]['ctype'] = '总监推代理';
                    }else{
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate'];
                        $order1[$k]['ctype'] = '总监推总监';
                    }                
             }else{
                    $order1[$k]['rate'] = $info['commission1'];
                    if($ddd == 0){
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['moneyrate'];
                        $order1[$k]['ctype'] = '代理推会员';
                    }elseif($ddd == 1){
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['daili_moneyrate'];
                        $order1[$k]['ctype'] = '代理推代理';
                    }else{
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['zongjian_moneyrate'];
                        $order1[$k]['ctype'] = '代理推总监';
                    }
             }
             $order1[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order1[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('nick_name'));
         }
         foreach ($order2 as $k => $v) {
             $eee = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('is_daili'));             
             if($order2[$k]['order_modify_at'] > $time){
                    $order2[$k]['rate'] = $rate2;
                    if($eee == 0){
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate'];
                        $order2[$k]['ctype'] = '总监推会员';
                    }elseif($eee == 1){
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate'];
                        $order2[$k]['ctype'] = '总监推代理';
                    }else{
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate'];
                        $order2[$k]['ctype'] = '总监推总监';
                    }                
             }else{
                    $order2[$k]['rate'] = $info['commission2'];
                    if($eee == 0){
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['moneyrate'];
                        $order2[$k]['ctype'] = '代理推会员';
                    }elseif($eee == 1){
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['daili_moneyrate'];
                        $order2[$k]['ctype'] = '代理推代理';
                    }else{
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['zongjian_moneyrate'];
                        $order2[$k]['ctype'] = '代理推总监';
                    }
             }
             $order2[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order2[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('nick_name'));
         }
         foreach ($order3 as $k => $v) {
             $fff = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('is_daili'));             
             if($order3[$k]['order_modify_at'] > $time){
                    $order3[$k]['rate'] = $rate3;
                    if($fff == 0){
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate'];
                        $order3[$k]['ctype'] = '总监推会员';
                    }elseif($fff == 1){
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate'];
                        $order3[$k]['ctype'] = '总监推代理';
                    }else{
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate'];
                        $order3[$k]['ctype'] = '总监推总监';
                    }                
             }else{
                    $order3[$k]['rate'] = $info['commission3'];
                    if($fff == 0){
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['moneyrate'];
                        $order3[$k]['ctype'] = '代理推会员';
                    }elseif($fff == 1){
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['daili_moneyrate'];
                        $order3[$k]['ctype'] = '代理推代理';
                    }else{
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['zongjian_moneyrate'];
                        $order3[$k]['ctype'] = '代理推总监';
                    }
             }
             $order3[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order3[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']),array('nick_name'));
         }
     }  
 
     
     if($info['fx_level'] == 1){
     	$order_count = $order_count1;
     }
     if($info['fx_level'] == 2){
     	$order_count = $order_count1+$order_count2;
     }
     if($info['fx_level'] == 3){
     	$order_count = $order_count1+$order_count2+$order_count3;
     }

     //各级下线佣金额
     $money_count1 = array_sum(array_column($order1, 'ticheng'));   //一级下线佣金总和
     $money_count2 = array_sum(array_column($order2, 'ticheng'));   //二级下线佣金总和
     $money_count3 = array_sum(array_column($order3, 'ticheng'));   //三级下线佣金总和
     $money_count= $money_count1 + $money_count2 + $money_count3;
     //var_dump($money_count);
     include $this->template('myteam_orders');
	}

    public function doWebPlugin(){
        global $_W, $_GPC;
        $img1 = $_W['siteroot']."addons/hc_pdd/soft2.png";
        $img2 = $_W['siteroot']."addons/hc_pdd/soft1.png";
        include $this->template('plugin');
    }
    ///微信企业付款提现
    public function doWebWith()
    {
        global $_W, $_GPC;
        $pindex = max(intval($_GPC['page']), 1);
        $psize = 10;
        $status=$_GPC['status'];
        $condition = "";

            if(empty($status)){
                $list=pdo_getslice('hcpdd_with', array('uniacid'=>$_W['uniacid']), array($pindex,$psize) , $total , array() , '' , array('status asc','id desc'));
            }else{
                if($status==2){
                    $stact=0;
                }else{
                    $stact=1;
                }
                $list=pdo_getslice('hcpdd_with', array('uniacid'=>$_W['uniacid'],'status'=>$stact), array($pindex,$psize) , $total , array() , '' , array('status asc','id desc'));
            }

        for($i=0;$i<count($list);$i++){
            $user=pdo_get('hcpdd_users', array('user_id' => $list[$i]['user_id']));
            $list[$i]['nickname']=$user['nick_name'];
            $list[$i]['avatar']=$user['head_pic'];
        }
        $pager = pagination($total, $pindex, $psize);


        include $this->template("with");
    }
    public function doWebTixian() {
        global $_W,$_GPC;
        //这个操作被定义用来呈现 管理中心导航菜单
        if($_GPC['op']=='send'){
            $tixian=pdo_get('hcpdd_with',array('id'=>$_GPC['id']));
            $user=pdo_get('hcpdd_users', array('user_id' => $tixian['user_id']));
            $wxchat='';
            $data['openid']=$user['open_id'];
            $data['userid']=1;
            $data['refundid']=time();
            $data['money']=$tixian['money'];
            $aa=$this->wxbuild($data, $wxchat);
            if($aa['result_code']=='SUCCESS'){
                $gengxin = array(
                     'finishmoney' => $user['finishmoney']+$data['money'],
                     //'money'       => $data['money'] - $res['money'],
                     'waitmoney'   => $user['waitmoney'] - $data['money']
                );
                pdo_update('hcpdd_users',$gengxin, array('user_id' =>$user['user_id']));
                pdo_update('hcpdd_with', array('status' => 1,'partner_trade_no'=>$aa['payment_no'],'pay_time'=>time()), array('id'=>$_GPC['id']));
                message('发放成功',$this->createWebUrl('with'),'success');
            }else{
                pdo_update('hcpdd_with', array('partner_trade_no'=>$aa['0']), array('id'=>$_GPC['id']));
            }
        }
        if($_GPC['op']=='del'){
            pdo_delete('hcpdd_with', array('id'=>$_GPC['id']));
        }
        include $this->doWebWith();
    }
    ///微信企业付款提现
    public function doWebTreewith()
    {
        global $_W, $_GPC;
        $pindex = max(intval($_GPC['page']), 1);
        $psize = 10;
        $status=$_GPC['status'];
        $condition = "";

            if(empty($status)){
                $list=pdo_getslice('hcpdd_treewith', array('uniacid'=>$_W['uniacid']), array($pindex,$psize) , $total , array() , '' , array('status asc','id desc'));
            }else{
                if($status==2){
                    $stact=0;
                }else{
                    $stact=1;
                }
                $list=pdo_getslice('hcpdd_treewith', array('uniacid'=>$_W['uniacid'],'status'=>$stact), array($pindex,$psize) , $total , array() , '' , array('status asc','id desc'));
            }

        for($i=0;$i<count($list);$i++){
            $user=pdo_get('hcpdd_users', array('user_id' => $list[$i]['user_id']));
            $list[$i]['nickname']=$user['nick_name'];
            $list[$i]['avatar']=$user['head_pic'];
        }
        $pager = pagination($total, $pindex, $psize);


        include $this->template("treewith");
    }
    public function doWebTreetixian() {
        global $_W,$_GPC;
        //这个操作被定义用来呈现 管理中心导航菜单
        if($_GPC['op']=='send'){
            $tixian=pdo_get('hcpdd_treewith',array('id'=>$_GPC['id']));
            $user=pdo_get('hcpdd_users', array('user_id' => $tixian['user_id']));
            $wxchat='';
            $data['openid']=$user['open_id'];
            $data['userid']=1;
            $data['refundid']=time();
            $data['money']=$tixian['money'];
            $aa=$this->wxbuild($data, $wxchat);
            if($aa['result_code']=='SUCCESS'){
                /*$gengxin = array(
                     'finishmoney' => $user['finishmoney']+$data['money'],
                     //'money'       => $data['money'] - $res['money'],
                     'waitmoney'   => $user['waitmoney'] - $data['money']
                );
                pdo_update('hcpdd_users',$gengxin, array('user_id' =>$user['user_id']));*/
                pdo_update('hcpdd_treewith', array('status' => 1,'partner_trade_no'=>$aa['payment_no'],'pay_time'=>time()), array('id'=>$_GPC['id']));
                message('发放成功',$this->createWebUrl('treewith'),'success');
            }else{
                pdo_update('hcpdd_treewith', array('partner_trade_no'=>$aa['0']), array('id'=>$_GPC['id']));
            }
        }
        if($_GPC['op']=='del'){
            pdo_delete('hcpdd_treewith', array('id'=>$_GPC['id']));
        }
        include $this->doWebTreewith();
    }

    ///红包树支付宝提现
    public function doWebTreewithzfb()
    {
        global $_W, $_GPC;
        $pindex = max(intval($_GPC['page']), 1);
        $psize = 10;
        $list=pdo_getslice('hcpdd_treewithzfb', array('uniacid'=>$_W['uniacid']), array($pindex,$psize) , $total , array() , '' , array('status asc','id desc'));
        for($i=0;$i<count($list);$i++){
            $user=pdo_get('hcpdd_users', array('user_id' => $list[$i]['user_id']));
            $list[$i]['nickname']=$user['nick_name'];
            $list[$i]['avatar']=$user['head_pic'];
        }
        $pager = pagination($total, $pindex, $psize);


        include $this->template("treewithzfb");
    }
    public function doWebTreetixianzfb() {
        global $_W,$_GPC;
        //这个操作被定义用来呈现 管理中心导航菜单
        if($_GPC['op']=='send'){
            $tixian = pdo_get('hcpdd_treewithzfb',array('id'=>$_GPC['id']));
            $user = pdo_get('hcpdd_users', array('user_id' => $tixian['user_id']));
            $res = pdo_update('hcpdd_treewithzfb', array('status' => 1,'paytime'=>time()), array('id'=>$_GPC['id']));
            if($res){
                message('修改状态成功',$this->createWebUrl('treewithzfb'),'success');
            }else{
                message('修改状态操作失败',$this->createWebUrl('treewithzfb'),'error');
            }
        }
        if($_GPC['op']=='del'){
            pdo_delete('hcpdd_treewithzfb', array('id'=>$_GPC['id']));
        }
        include $this->doWebTreewithzfb();
    }
    public function wxbuild($data, $wxchat){
        global $_GPC, $_W;
        $account = pdo_get('account_wxapp', array('uniacid' => $_W['uniacid']));
        $wxapp = pdo_get('uni_settings', array('uniacid' => $_W['uniacid']));
        $payment = unserialize($wxapp['payment']);
        $mch_id = $payment['wechat']['mchid'];;
        $signkey = $payment['wechat']['signkey'];//支付密钥
        $payurl = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $appid = $account['key'];
        $mchid = $mch_id;
        //判断有没有CA证书及支付信息
        if(empty($wxchat['api_cert']) || empty($wxchat['api_key']) || empty($wxchat['api_ca']) || empty($wxchat['appid']) || empty($wxchat['mchid'])){
            $wxchat['appid'] = $appid;
            $wxchat['mchid'] = $mchid;
            $wxchat['api_cert'] = dirname(__FILE__).'/cert/apiclient_cert'.$_W['uniacid'].'.pem';
            $wxchat['api_key'] = dirname(__FILE__).'/cert/apiclient_key'.$_W['uniacid'].'.pem';
            //$wxchat['api_ca'] = dirname(__FILE__).'/cert/rootca'.$_W['uniacid'].'.pem';
        }
        $webdata = array(
            'mch_appid' => $wxchat['appid'],
            'mchid'    => $wxchat['mchid'],
            'nonce_str' => rand(1,88888888).time(),
            'partner_trade_no'  => $data['refundid'], //商户丁单号，需要唯一
            'openid'    => $data['openid'],
            'check_name'=> 'NO_CHECK', //OPTION_CHECK不强制校验真实姓名, FORCE_CHECK：强制 NO_CHECK：
            'amount'    => $data['money'] * 100, //付款金额单位为分
            'desc'      => empty($data['desc'])? '佣金收入' : $data['desc'],
            'spbill_create_ip' => $this->getip(),
        );
        foreach ($webdata as $k => $v) {
            $tarr[] =$k.'='.$v;
        }
        sort($tarr);
        $sign = implode($tarr, '&');
        $sign .= '&key='.$signkey;
        $webdata['sign']=strtoupper(md5($sign));
        $wget = $this->array2xml($webdata);
        $res = $this->http_post($payurl, $wget, $wxchat);
        if(!$res){
            return array('status'=>1, 'msg'=>"Can't connect the server" );
        }
        $content = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
        if(strval($content->return_code) == 'FAIL'){
            return array('status'=>1, 'msg'=>strval($content->return_msg));
        }
        if(strval($content->result_code) == 'FAIL'){
            return array('status'=>1, 'msg'=>strval($content->err_code),':'.strval($content->err_code_des));
        }
        $rdata = array(
            'mch_appid'        => strval($content->mch_appid),
            'mchid'            => strval($content->mchid),
            'device_info'      => strval($content->device_info),
            'nonce_str'        => strval($content->nonce_str),
            'result_code'      => strval($content->result_code),
            'partner_trade_no' => strval($content->partner_trade_no),
            'payment_no'      => strval($content->payment_no),
            'payment_time'    => strval($content->payment_time),
        );
        return $rdata;
    }
    public function http_post($url, $param, $wxchat) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if (is_string($param)) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        if($wxchat){
            curl_setopt($oCurl,CURLOPT_SSLCERT,$wxchat['api_cert']);
            curl_setopt($oCurl,CURLOPT_SSLKEY,$wxchat['api_key']);
            curl_setopt($oCurl,CURLOPT_CAINFO,$wxchat['api_ca']);
        }
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        } 
    }

    /**
     * 将一个数组转换为 XML 结构的字符串
     * @param array $arr 要转换的数组
     * @param int $level 节点层级, 1 为 Root.
     * @return string XML 结构的字符串
     */
    public function array2xml($arr, $level = 1) {
        $s = $level == 1 ? "<xml>" : '';
        foreach($arr as $tagname => $value) {
            if (is_numeric($tagname)) {
                $tagname = $value['TagName'];
                unset($value['TagName']);
            }
            if(!is_array($value)) {
                $s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
            } else {
                $s .= "<{$tagname}>" . $this->array2xml($value, $level + 1)."</{$tagname}>";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
        return $level == 1 ? $s."</xml>" : $s;
    }
    public function getip() {
        static $ip = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }

    public function doWebpayset(){
        global $_W, $_GPC;
        if(!empty($_GPC['cert'])){
                file_put_contents(dirname(__FILE__)."/cert/apiclient_cert".$_W['uniacid'].".pem",$_GPC['cert']);
            }
        if(!empty($_GPC['key'])){
                file_put_contents(dirname(__FILE__)."/cert/apiclient_key".$_W['uniacid'].".pem",$_GPC['key']);
            }
        /*if(!empty($_GPC['rootca'])){
                file_put_contents(dirname(__FILE__)."/cert/rootca".$_W['uniacid'].".pem",$_GPC['rootca']);
            }*/
        include $this->template("payset");
    }

    public function doWebFinishorders(){

        global $_W, $_GPC;
        $_GPC['i'] = $_W['uniacid'];
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));

        if($_GPC['op'] == 'refresh'){            
            /*$client_secret = $set['client_secret'];
            $client_id = $set['client_id'];
            $data_type = 'JSON';        
            $start_update_time = '1522512000';   //总订单
            $end_update_time =time();       
            $timestamp = time();
            $page = 1;
            $type = 'pdd.ddk.order.list.increment.get';
            $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'page'.$page.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
            $sign = md5($signold);
            //echo $signold;
            $sign = strtoupper($sign);
            $data = array (
                'type' => urlencode('pdd.ddk.order.list.increment.get'),
                'data_type' => 'JSON',
                'page' => $page,
                'start_update_time' => $start_update_time,
                'end_update_time' => $end_update_time,
                'timestamp' => urlencode($timestamp),
                'client_id' => $client_id,
                'sign' => $sign
            );
            $url = 'http://gw-api.pinduoduo.com/api/router';
            load()->func('communication');
            $response = ihttp_post($url,$data);
            $arr = json_decode($response['content'],true);
            $result = $arr['order_list_get_response']['order_list'];
            $total_count = $arr['order_list_get_response']['total_count'];
            $pagecount = ceil($total_count/100);
            
            //获取全部订单
            for ($x=1; $x<=$pagecount; $x++) {            
                $list[] = $this->orderlist($x);
            }
            //筛选已结算订单
            foreach ($list as $k => $v) {
                foreach ($list[$k] as $key => $value) {
                    if($value['order_status'] == 5 ){
                        $listall[] = $value;
                    }     
                }
            }*/
            //allorders 表中提取已结算订单
            $listall = pdo_getall('hcpdd_allorder', array('uniacid' =>$_W['uniacid'],'order_status' =>5));

            foreach ($listall as $k => $v) {
                $res = pdo_get('hcpdd_finishorders',array('uniacid'=>$_W['uniacid'],'order_sn'=>$v['order_sn']));
                if(empty($res)){
                    $data = $v;
                    $data['uniacid'] = $_W['uniacid'];
                    $data['fafang'] = 0;
//                    var_dump($data);die;
                    $fff[]= pdo_insert('hcpdd_finishorders',$data);
                }
            }
            if(empty($fff)){
                message('同步成功，没有新订单',$this->createWebUrl('finishorders'),'success');
            }else{
                message('同步成功',$this->createWebUrl('finishorders'),'success');
            }
        
        }

        $where['uniacid'] = $_W['uniacid'];
        
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 50;

        $orderlist = pdo_getslice('hcpdd_finishorders',$where,array($pageindex, $pagesize),$total,array(),'','order_pay_time desc');
        $page = pagination($total, $pageindex, $pagesize);
        
        //$orderlist = pdo_getall('hcpdd_finishorders', array('uniacid' =>$_GPC['i']));
        foreach ($orderlist as $k => $v) {
                $jieguo = pdo_get('hcpdd_users',array('pid'=>$v['p_id']));
                $orderlist[$k]['nick_name']         = $jieguo['nick_name'];
                $orderlist[$k]['roleid']            = $jieguo['is_daili'];
                $orderlist[$k]['order_create_time'] = date('Y-m-d',$v['order_create_time']);//订单生成时间
                $orderlist[$k]['order_pay_time']    = date('Y-m-d',$v['order_pay_time']);      //支付时间
                $orderlist[$k]['promotion_rate']    = $v['promotion_rate']/10;   //佣金比例，百分比
                $orderlist[$k]['promotion_amount']  = $v['promotion_amount']/100;           //佣金
                if($jieguo['is_daili'] == 0){
                    $orderlist[$k]['user_promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];//用户的
                }elseif($jieguo['is_daili'] == 1){
                    $orderlist[$k]['user_promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];//代理的
                }else{
                    $orderlist[$k]['user_promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];//总监的
                }
                
                $orderlist[$k]['order_amount']      = $v['order_amount']/100;               //订单价格
        }


        include $this->template("finishorders");
    }



    public function doWebsendmoney(){
        global $_W, $_GPC;
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $list = pdo_getall('hcpdd_finishorders', array('uniacid' =>$_W['uniacid'],'fafang'=>0));
        foreach ($list as $k => $v) {
            //if($v['fafang'] == 0){
                $res = pdo_get('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']));
                if(!empty($res)){
                    if($res['is_daili'] == 0){
                    $money = $v['promotion_amount']/100*$set['moneyrate'];//用户的
                    }elseif($res['is_daili'] == 1){
                        $money = $v['promotion_amount']/100*$set['daili_moneyrate'];//代理的
                    }else{
                        $money = $v['promotion_amount']/100*$set['zongjian_moneyrate'];//总监的
                    }
                    $nowmoney = $res['money'] + $money;
                    $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney), array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']));
                    $zhuangtai = pdo_update('hcpdd_finishorders',array('fafang' => 1), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));

                }else{
                    $zhuangtai = pdo_update('hcpdd_finishorders',array('fafang' => 2), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));
                }
            //}
        }

        if ($faqian){
            message('发放成功',$this->createWebUrl('finishorders'),'success');
        }else{
            message('没有可发放的订单',$this->createWebUrl('finishorders'),'success');
        }

    }
    public function doWebsendsonmoney(){
        global $_W, $_GPC;
        $son = pdo_getall('hcpdd_son', array('uniacid' =>$_W['uniacid']));
        foreach ($son as $k => $v) {
            $list = pdo_getall('hcpdd_finishorders', array('uniacid' =>$_W['uniacid'],'p_id'=>$v['son_pid']));
            if(!empty($list)){
                foreach ($list as $key => $value) {              
                if($value['fafang'] == 0){ 
                        $user = pdo_get('hcpdd_son',array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));               
                        $money = $value['promotion_amount']/100*$v['son_rate'];//用户的                    
                        $nowmoney = $user['money'] + $money;
                        $faqian[] = pdo_update('hcpdd_son',array('money' => $nowmoney), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));
                        $zhuangtai = pdo_update('hcpdd_finishorders',array('fafang' => 3), array('id'=>$value['id'],'uniacid' =>$_W['uniacid']));
                    }
                }   
            }      
        }
        //var_dump($son);
        if ($faqian){
            message('发放成功',$this->createWebUrl('son_withdrawal'),'success');
        }else{
            message('没有可发放的订单',$this->createWebUrl('son_withdrawal'),'success');
        }
        //echo 111;

    }
    //发放分销佣金
    public function doWebsendcommission(){
        global $_W, $_GPC;
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_W['uniacid']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));
        $list = pdo_getall('hcpdd_finishorders', array('uniacid' =>$_W['uniacid'],'fafang'=>1));
        
        if($info['fx_level'] == 1){
            
            foreach ($list as $k => $v) {
                $res = pdo_get('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']));
                if(!empty($res['fatherid']) and $res['fatherid'] <> 0){
                    $yiji = pdo_get('hcpdd_users',array('user_id'=>$res['fatherid'],'uniacid' =>$_W['uniacid']));
                     
                
                if($res['is_daili'] == 0){
                    $money = $v['promotion_amount']/100*$set['moneyrate'];//用户的
                }elseif($res['is_daili'] == 1){
                    $money = $v['promotion_amount']/100*$set['daili_moneyrate'];//代理的
                }else{
                    $money = $v['promotion_amount']/100*$set['zongjian_moneyrate'];//总监的
                }

                if($yiji['is_daili'] == 1){
                     $commission1 = $money/100*$info['commission1'];
                }
                if($yiji['is_daili'] == 2){
                     $commission1 = $money/100*$info['zongjian_commission1'];
                }

                $nowmoney = $yiji['money'] + $commission1;
                $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney), array('user_id'=>$yiji['user_id'],'uniacid' =>$_W['uniacid']));
                $zhuangtai = pdo_update('hcpdd_finishorders',array('fafang' => 5), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));          
                }
                }

        }elseif($info['fx_level'] == 2){

            foreach ($list as $k => $v) {
                $res = pdo_get('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']));
                if(!empty($res['fatherid']) and $res['fatherid'] <> 0){
                    $yiji = pdo_get('hcpdd_users',array('user_id'=>$res['fatherid'],'uniacid' =>$_W['uniacid']));
                    $erji = pdo_get('hcpdd_users',array('user_id'=>$yiji['fatherid'],'uniacid' =>$_W['uniacid'])); 
                
                if($res['is_daili'] == 0){
                    $money = $v['promotion_amount']/100*$set['moneyrate'];//用户的
                }elseif($res['is_daili'] == 1){
                    $money = $v['promotion_amount']/100*$set['daili_moneyrate'];//代理的
                }else{
                    $money = $v['promotion_amount']/100*$set['zongjian_moneyrate'];//总监的
                }

                if($yiji['is_daili'] == 1){
                     $commission1 = $money/100*$info['commission1'];
                }
                if($yiji['is_daili'] == 2){
                     $commission1 = $money/100*$info['zongjian_commission1'];
                }
                if($erji['is_daili'] == 1){
                     $commission2 = $money/100*$info['commission2'];
                }
                if($erji['is_daili'] == 2){
                     $commission2 = $money/100*$info['zongjian_commission2'];
                }

                $nowmoney1 = $yiji['money'] + $commission1;
                $nowmoney2 = $erji['money'] + $commission2;
                $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney1), array('user_id'=>$yiji['user_id'],'uniacid' =>$_W['uniacid']));
                $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney2), array('user_id'=>$erji['user_id'],'uniacid' =>$_W['uniacid']));
                $zhuangtai = pdo_update('hcpdd_finishorders',array('fafang' => 5), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));          
                }
                }

        }elseif($info['fx_level'] == 3){

            foreach ($list as $k => $v) {
                $res = pdo_get('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_W['uniacid']));
                if(!empty($res['fatherid']) and $res['fatherid'] <> 0){
                    $yiji = pdo_get('hcpdd_users',array('user_id'=>$res['fatherid'],'uniacid' =>$_W['uniacid']));
                    $erji = pdo_get('hcpdd_users',array('user_id'=>$yiji['fatherid'],'uniacid' =>$_W['uniacid'])); 
                    $sanji = pdo_get('hcpdd_users',array('user_id'=>$erji['fatherid'],'uniacid' =>$_W['uniacid']));
                
                if($res['is_daili'] == 0){
                    $money = $v['promotion_amount']/100*$set['moneyrate'];//用户的
                }elseif($res['is_daili'] == 1){
                    $money = $v['promotion_amount']/100*$set['daili_moneyrate'];//代理的
                }else{
                    $money = $v['promotion_amount']/100*$set['zongjian_moneyrate'];//总监的
                }

                if($yiji['is_daili'] == 1){
                     $commission1 = $money/100*$info['commission1'];
                }
                if($yiji['is_daili'] == 2){
                     $commission1 = $money/100*$info['zongjian_commission1'];
                }
                if($erji['is_daili'] == 1){
                     $commission2 = $money/100*$info['commission2'];
                }
                if($erji['is_daili'] == 2){
                     $commission2 = $money/100*$info['zongjian_commission2'];
                }
                if($erji['is_daili'] == 1){
                     $commission3 = $money/100*$info['commission3'];
                }
                if($erji['is_daili'] == 2){
                     $commission3 = $money/100*$info['zongjian_commission3'];
                }

                $nowmoney1 = $yiji['money'] + $commission1;
                $nowmoney2 = $erji['money'] + $commission2;
                $nowmoney3 = $sanji['money'] + $commission3;
                $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney1), array('user_id'=>$yiji['user_id'],'uniacid' =>$_W['uniacid']));
                $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney2), array('user_id'=>$erji['user_id'],'uniacid' =>$_W['uniacid']));
                $faqian[] = pdo_update('hcpdd_users',array('money' => $nowmoney3), array('user_id'=>$sanji['user_id'],'uniacid' =>$_W['uniacid']));
                $zhuangtai = pdo_update('hcpdd_finishorders',array('fafang' => 5), array('id'=>$v['id'],'uniacid' =>$_W['uniacid']));          
                }
                }

        }else{
            message('系统未开启分销',$this->createWebUrl('finishorders'),'success');
        }

        if ($faqian){
            message('发放成功',$this->createWebUrl('finishorders'),'success');
        }else{
            message('没有可发放的订单',$this->createWebUrl('finishorders'),'success');
        }

    }

    public function doWebSon() {
        global $_W,$_GPC;
        $where['uniacid'] = $_W['uniacid'];
        
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;

        $list = pdo_getslice('hcpdd_son',$where,array($pageindex, $pagesize),$total,array(),'','id asc');
        $page = pagination($total, $pageindex, $pagesize);

        //var_dump($list);

        include $this->template('son');
    }
    
    public function doWebSon_post() {
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_W['uniacid']));

        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            $data['son_uniacid'] = $_GPC['son_uniacid'];
            $data['son_rate'] = $_GPC['son_rate'];
            $data['son_pid'] = $_GPC['son_pid'];
            $data['son_positionId'] = $_GPC['son_positionId'];
            $data['son_gid'] = $_GPC['son_gid'];
            $data['beizhu'] = $_GPC['beizhu'];

            $son['father_uniacid'] = $_W['uniacid'];
            $son['uniacid'] = $_GPC['son_uniacid'];

            $result = pdo_insert('hcpdd_son', $data); 

            $res = pdo_get('hcpddson_set',array('uniacid'=>$data['son_uniacid']));
            if(!empty($res)){
                $aaa = pdo_update('hcpddson_set', $son ,array('uniacid'=>$son['uniacid'])); 
            }else{
                $bbb = pdo_insert('hcpddson_set', $son);
            }
                 
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('son'));
            }
        }

        if($_GPC['act']=='edit'){
            $data['uniacid'] = $_W['uniacid'];
            $data['son_uniacid'] = $_GPC['son_uniacid'];
            $data['son_rate'] = $_GPC['son_rate'];
            $data['son_pid'] = $_GPC['son_pid'];
            $data['son_positionId'] = $_GPC['son_positionId'];
            $data['son_gid'] = $_GPC['son_gid'];
            $data['beizhu'] = $_GPC['beizhu'];

            $result = pdo_update('hcpdd_son', $data, array('id'=>$_GPC['id']));
            
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('son'));
            }
        }

        if($_GPC['act']=='del'){

            $result = pdo_delete('hcpdd_son', array('id'=>$_GPC['id']));   
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('son'));
            }
        }
        $info = pdo_get('hcpdd_son',array('id'=>$id));
        include $this->template('son_post');
    }

    public function doWebSon_withdrawal(){

        global $_W, $_GPC;
        $data = pdo_getall('hcpdd_ctixian', array(), array() , '','id DESC');
        $list = $data;
        foreach ($list as $k => $v) {
            $list[$k]['payment_time'] = date('Y-m-d',$v['payment_time']);
        }
        include $this->template('son_withdrawal');

    }

    //提现审核
    public function doWebEditsonwithdrawal()
    {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $status = $_POST['status'];
        //一条提现申请记录
        $res = pdo_get('hcpdd_ctixian',array('id'=>$id));
        if($_GPC['act']=='edit'){           
            //一条用户信息
            $data = pdo_get('hcpdd_son',array('son_uniacid'=>$res['son_uniacid']));
            if($res['status'] == 1){
               $update = array(
                    'status' => $status
                    );
               $aaa = pdo_update('hcpdd_ctixian',$update, array('id' =>$id));

               $gengxin = array(
                     'finishmoney' => $data['finishmoney']+$res['money'],
                     //'money'       => $data['money'] - $res['money'],
                     'waitmoney'   => $data['waitmoney'] - $res['money']
                );
               $bbb = pdo_update('hcpdd_son',$gengxin, array('son_uniacid' =>$res['son_uniacid'])); 
               if (!empty($bbb)){
               message('操作成功',$this->createWebUrl('son_withdrawal'));
        }                       
        }

        }
        
        include $this->template('editsonwithdrawal');
        
    }

    public function doWebmoneyrate(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            /*empty($_GPC['client_id'])?'':$data['client_id'] = $_GPC['client_id'];*/
            $data['moneyrate'] = $_GPC['moneyrate'];
            $data['daili_moneyrate'] = $_GPC['daili_moneyrate'];
            $data['zongjian_moneyrate'] = $_GPC['zongjian_moneyrate'];
            $data['edittime'] = time();            
            $result = pdo_insert('hcpdd_moneyrate', $data);
            $res = pdo_update('hcpdd_set',array('moneyrate'=>$_GPC['moneyrate'],'daili_moneyrate'=>$_GPC['daili_moneyrate'],'zongjian_moneyrate'=>$_GPC['zongjian_moneyrate']),array('uniacid'=>$_W['uniacid']));
            if (!empty($res)) {
                message('操作成功',$this->createWebUrl('moneyrate'));
            }
        }else{
            $aaa['uniacid'] = $_W['uniacid'];
            $aaa['moneyrate'] = $info['moneyrate'];
            $aaa['daili_moneyrate'] = $info['daili_moneyrate'];
            $aaa['zongjian_moneyrate'] = $info['zongjian_moneyrate'];
            $aaa['edittime'] = time();
            pdo_insert('hcpdd_moneyrate', $aaa);
        }       
        include $this->template('moneyrate');
    }

    public function doWebexportDayInner(){
        global $_W,$_GPC;
        $innerdata = pdo_getall('hcpdd_users',array('uniacid'=>$_W['uniacid']));
        foreach ($innerdata as $v) {
            if($v['mobile']){               
              $list[] = $v['mobile'];
            }
        }
        $table = '';
        $table .= "<table>
            <thead>
                <tr>
                    <th class='name'>手机号</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($list as $v) {
               $table .= "<tr>
                    <td class='name'>".$v."</td>
                </tr>";            
        }
        $table .= "</tbody>
        </table>";
//通过header头控制输出excel表格
        header("Pragma: public");  
        header("Expires: 0");  
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");  
        header("Content-Type:application/force-download");  
        header("Content-Type:application/vnd.ms-execl");  
        header("Content-Type:application/octet-stream");  
        header("Content-Type:application/download");;  
        header('Content-Disposition:attachment;filename="用户手机号.xls"');  
        header("Content-Transfer-Encoding:binary");          
        echo $table;
    }
    //红包功能
    public function doWebhongbao(){
        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            /*empty($_GPC['client_id'])?'':$data['client_id'] = $_GPC['client_id'];*/
            $data['is_open'] = $_GPC['is_open'];
            $data['firstmoney'] = $_GPC['firstmoney'];
            $data['zhuanfamoney'] = $_GPC['zhuanfamoney'];
            $data['open_bg'] = $_GPC['open_bg'];
            $data['shareinfo'] = $_GPC['shareinfo'];
            $data['sharetitle'] = $_GPC['sharetitle'];
            $data['fenxiangtitle'] = $_GPC['fenxiangtitle'];
            $data['fenxiangpic'] = $_GPC['fenxiangpic'];
            $data['hb_day'] = $_GPC['hb_day'];
            
            $ishave = pdo_get('hcpdd_hongbao', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_hongbao', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_hongbao', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('hongbao'));
            }
        }
        $info = pdo_get('hcpdd_hongbao', array('uniacid' => $_W['uniacid']));
        include $this->template('hongbao');
    }

    //推荐基础设置
    public function doWebTuijianset(){
        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            /*empty($_GPC['client_id'])?'':$data['client_id'] = $_GPC['client_id'];*/
            $data['tuijian_type'] = $_GPC['tuijian_type'];
            
            $ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_set', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('tuijianset'));
            }
        }
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        include $this->template('tuijianset');
    }

    //骗审功能
    public function doWebshenhe(){
        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['version'] = $_GPC['version'];
            
            $ishave = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_set', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_set', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('shenhe'));
            }
        }
        $info = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid']));
        include $this->template('shenhe');
    }

    public function doWebShenheset()
    {
        global $_W,$_GPC;
        $ishave1 = pdo_get('hcpdd_shenheset', array('uniacid' => $_W['uniacid']));
        if(empty($ishave1)){
            $data['uniacid'] = $_W['uniacid'];
            pdo_insert('hcpdd_shenheset',$data);
        }
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            /*empty($_GPC['client_id'])?'':$data['client_id'] = $_GPC['client_id'];*/
            $data['notice'] = $_GPC['notice'];
            $data['banner1'] = $_GPC['banner1'];
            $data['banner2'] = $_GPC['banner2'];
            $data['banner3'] = $_GPC['banner3'];

            $data['goodsname1'] = $_GPC['goodsname1'];
            $data['goodsname2'] = $_GPC['goodsname2'];
            $data['goodsname3'] = $_GPC['goodsname3'];
            $data['goodsname4'] = $_GPC['goodsname4'];
            $data['goodsname5'] = $_GPC['goodsname5'];
            $data['goodsname6'] = $_GPC['goodsname6'];
            $data['goodsname7'] = $_GPC['goodsname7'];
            $data['goodsname8'] = $_GPC['goodsname8'];
            $data['goodsname9'] = $_GPC['goodsname9'];

            $data['goodsprice1'] = $_GPC['goodsprice1'];
            $data['goodsprice2'] = $_GPC['goodsprice2'];
            $data['goodsprice3'] = $_GPC['goodsprice3'];
            $data['goodsprice4'] = $_GPC['goodsprice4'];
            $data['goodsprice5'] = $_GPC['goodsprice5'];
            $data['goodsprice6'] = $_GPC['goodsprice6'];
            $data['goodsprice7'] = $_GPC['goodsprice7'];
            $data['goodsprice8'] = $_GPC['goodsprice8'];
            $data['goodsprice9'] = $_GPC['goodsprice9'];

            $data['goodspic1'] = $_GPC['goodspic1'];
            $data['goodspic2'] = $_GPC['goodspic2'];
            $data['goodspic3'] = $_GPC['goodspic3'];
            $data['goodspic4'] = $_GPC['goodspic4'];
            $data['goodspic5'] = $_GPC['goodspic5'];
            $data['goodspic6'] = $_GPC['goodspic6'];
            $data['goodspic7'] = $_GPC['goodspic7'];
            $data['goodspic8'] = $_GPC['goodspic8'];
            $data['goodspic9'] = $_GPC['goodspic9'];

            
            $ishave = pdo_get('hcpdd_shenheset', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_shenheset', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_shenheset', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('shenheset'));
            }
        }
        $info = pdo_get('hcpdd_shenheset', array('uniacid' => $_W['uniacid']));
        include $this->template('shenheset');
    }


    public function doWebAddshenhe()
    {
        global $_W, $_GPC;
        //这个操作被定义用来呈现 管理中心导航菜单
        if (!empty($_GPC['name'])) {
            $data['name'] = $_GPC['name'];
            $data['uniacid'] = $_W['uniacid'];
            $data['sort'] = $_GPC['sort'];
            $data['stact'] = $_GPC['stact'];
            $data['img'] = $_GPC['img'];
            $data['content'] = $_GPC['content'];
            $data['time'] = date("Y-m-d");
            pdo_insert('hcpdd_shenhe', $data);
        }
        include $this->template("addshenhe");
    }

    
    public function doWebEditshenhe()
    {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        if (!empty($_GPC['name'])) {
            $data['name'] = $_GPC['name'];
            $data['uniacid'] = $_W['uniacid'];
            $data['sort'] = $_GPC['sort'];
            $data['stact'] = $_GPC['stact'];
            $data['img'] = $_GPC['img'];
            $data['content'] = $_GPC['content'];
            pdo_update('hcpdd_shenhe', $data, array('id' => $id));
        }
        $shenhe = pdo_get('hcpdd_shenhe', array('id' => $id));
        include $this->template("editshenhe");
    }

    public function doWebDeleteshenhe()
    {
        global $_W, $_GPC;
        pdo_delete('hcpdd_shenhe', array('id' => $_GPC['id']));
        $pindex = max(intval($_GPC['page']), 1);
        $psize = 20;
        $shenhe = pdo_getslice('hcpdd_shenhe', array('uniacid' => $_W['uniacid']), array($pindex, $psize), $total, array(), '', array('sort desc'));
        for ($i = 0; $i < count($shenhe); $i++) {
            if ($shenhe[$i]['stact'] == 0) {
                $shenhe[$i]['stact'] = '不显示';
            } else {
                $shenhe[$i]['stact'] = '显示';
            }
        }
        $pager = pagination($total, $pindex, $psize);
        include $this->template("shenheset");
    } 

    //模板消息
    public function doWebMessage()
    {
        global $_W,$_GPC;
        if($_GPC['act']=='add'){
            $data['uniacid'] = $_W['uniacid'];
            /*empty($_GPC['client_id'])?'':$data['client_id'] = $_GPC['client_id'];*/           
            $data['hongbao_msgid'] = $_GPC['hongbao_msgid'];
            $data['fenxiao_msgid'] = $_GPC['fenxiao_msgid'];
            $data['msgid'] = $_GPC['msgid'];
            $data['keyword1'] = $_GPC['keyword1'];
            $data['keyword2'] = $_GPC['keyword2'];
            $data['keyword3'] = $_GPC['keyword3'];
            
            $ishave = pdo_get('hcpdd_message', array('uniacid' => $_W['uniacid']));
            if(!empty($ishave)){
                $result = pdo_update('hcpdd_message', $data ,array('uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('hcpdd_message', $data);
            }
            if (!empty($result)) {
                message('操作成功',$this->createWebUrl('message'));
            }
        }
        $setup = pdo_get('hcpdd_message', array('uniacid' => $_W['uniacid']));
        include $this->template('message');
    }

    public function doWebMsg(){
        ob_end_clean();
        global $_GPC, $_W;
        $users=pdo_getall('hcpdd_users', array('uniacid' => $_W['uniacid']));
        for($i=0;$i<count($users);$i++){
            $formid=pdo_getall('hcpdd_formid', array('user_id' => $users[$i]['user_id'],'status'=>0), array() , '',array('id DESC') , array());
            if(!empty($formid[0])){
                $aa=$this->getMessage($formid[0]);
            }
        }
        echo "发送成功，请关闭";
    }

    public function getMessage($formid) {
        global $_GPC, $_W;
        $user=pdo_get('hcpdd_users', array('user_id' => $formid['user_id']));
        $setup = pdo_get('hcpdd_message', array('uniacid' => $_W['uniacid']));      
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$this->wx_get_token();
        $data['touser']=$user['open_id'];
        $data['template_id']=$setup['msgid'];
        //$setup=json_decode($setup,true);
        $data['form_id']=$formid['formid'];
        $data['page']='hc_pdd/pages/index/index';
        $data['data']['keyword1']['value']=$setup['keyword1'];
        $data['data']['keyword1']['color']='#173177';
        $data['data']['keyword2']['value']=$setup['keyword2'];
        $data['data']['keyword2']['color']='#173177';
        $data['data']['keyword3']['value']=$setup['keyword3'];
        $data['data']['keyword3']['color']='#000000';
        $json = json_encode($data);
        $dete=$this->api_notice_increment($url,$json);
        pdo_update('hcpdd_formid', array('status' => 1), array('id' => $formid['id']));
        return $dete;
    }

    public function getfxmessage($user_id,$key1,$key2,$key4,$key5){
        global $_GPC, $_W;
        $setup = pdo_get('hcpdd_message', array('uniacid' => $_GPC['i']));
        $formidall=pdo_getall('hcpdd_formid', array('user_id' => $user_id,'status'=>0), array() , '',array('id desc') , array());
        $formid=$formidall[0];
        //$setup = pdo_get('dati_setup', array('uniacid' => $_W['uniacid']));
        //$setup['msgstr']=json_decode($setup['msgstr'],true);
        $user=pdo_get('hcpdd_users', array('user_id' => $user_id));
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$this->wx_get_token();
        $data['touser']=$user['open_id'];
        $data['template_id']=$setup['fenxiao_msgid'];
        $data['form_id']=$formid['formid'];
        $data['page']='hc_pdd/pages/index/index';
        $data['data']['keyword1']['value'] = $key1; //下单人
        $data['data']['keyword1']['color'] = '#173177';
        $data['data']['keyword2']['value'] = $key2; //商品名称
        $data['data']['keyword2']['color'] = '#173177';
        $data['data']['keyword3']['value'] = date("Y-m-d H:i",time()); //下单时间
        $data['data']['keyword3']['color'] = '#000000';
        $data['data']['keyword4']['value'] = $key4; //获得佣金
        $data['data']['keyword4']['color'] = '#173177';
        $data['data']['keyword5']['value'] = $key5;
        $data['data']['keyword5']['color'] = '#173177';
        $json = json_encode($data);
        $data=$this->api_notice_increment($url,$json);
        pdo_update('hcpdd_formid', array('status' => 1), array('id' => $formid['id']));
        //return $data;
    }

    function wx_get_token() {
        global $_GPC, $_W;
        /*$appid=$_W['account']['key'];
        $AppSecret=$_W['account']['secret'];
        $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$AppSecret);
        $res = json_decode($res, true);
        $token = $res['access_token'];*/
        $token = $this->getToken();
        return $token;
    }
}