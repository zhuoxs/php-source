<?php
/**
* 全网VIP视频在线免费看模块微站定义
*
* @author cyl
* @url http://bbs.we7.cc/
*/
session_start();
header("Access-Control-Allow-Origin: *");
defined('IN_IA') or exit('Access Denied');
include IA_ROOT . "/addons/super_mov/model.php";
class Super_movModuleSite extends WeModuleSite {
public function __construct(){      
    global $_W, $_GPC;             
    load()->model('mc');   
    $session_id = session_id(); 
    $account_api = WeAccount::create(); 
    $setting = uni_setting($_W['uniacid']);
    $settings = $_W['current_module']['config'];   
    if ($settings['is_open'] == 1 && !strexists($_W['siteurl'], 'web')) {
        message($settings['reason'],'','error');  
    }
    if ($settings['sealing_url']) {
        if (strexists($settings['sealing_url'] , $_SERVER['HTTP_HOST']) && !strexists($_W['siteurl'], 'web')) {
            header("HTTP/1.1 404 Not Found");  
            header("Status: 404 Not Found");    
            exit;  
        }
    }    
    // if (strexists($_W['siteurl'], 'super_mov') && $_GPC['do'] != 'notify_wx' && $_GPC['do'] != 'jspay' && $_GPC['do'] != 'codepaynotify_url' && $_GPC['do'] !='jspayreturn'  && $_GPC['do'] != 'codepayreturn'  && $_GPC['do'] != 'pay' && $_GPC['do'] != 'Blypay'  && $_GPC['do'] != 'gerenpay'   && $_GPC['do'] != 'partner' && $_GPC['do'] != 'credit' && !strexists($_W['siteurl'], 'web')) {   
    //     header("HTTP/1.1 404 Not Found");  
    //     header("Status: 404 Not Found");   
    //     exit;  
    // }
    if (pdo_tableexists('cyl_video_pc_site') && !$settings['weixin_h5']) {
        $wxpay = $setting['payment']['wechat'];     
        $this->wxpay = array(
            'appid' => $_W['account']['key'],
            'mch_id' => $wxpay['mchid'],
            'key' => $wxpay['apikey'],
            'notify_url' => $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&do=notify_wx&m=super_mov',
        );    
    }
    $data = array(  
            'uniacid' => $_W['uniacid'],
            'openid' => $_W['openid'] ? $_W['openid'] : $_GPC['phone'],            
            'nickname' => $_W['fans']['nickname'], 
            'avatar' => $_W['fans']['avatar'],
            'time' => TIMESTAMP, 
            'ip' => $_W['clientip'], 
            'old_time' => TIMESTAMP
    );
    if (empty($_W['fans']['nickname']) && $_W['oauth_account']['level'] == 4) { 
        $fans = mc_oauth_userinfo(); 
    }
    if($_W['account']['level'] == 4 && is_weixin()) { 
        $data['uid'] = $_W['fans']['uid'];
        $data['nickname'] = $_W['fans']['nickname'];
        $data['avatar'] = $_W['fans']['avatar'];
    }elseif ($_W['oauth_account']['level'] == 4 && is_weixin()) {
        $data['avatar'] = $fans['avatar'];
        $data['nickname'] = $fans['nickname'];
    }
    if ($_GPC['guanzhu'] == 1) {
        isetcookie('is_guanzhu',$_GPC['guanzhu'],3600*24*24);         
    }    
    if (pdo_tableexists('cyl_video_pc_site') && !is_weixin() ) {
        $_W['openid'] = $_GPC['phone'];
        // $online = pdo_get('cyl_vip_video_member_online',array('openid'=>$_W['openid'],'session_id'=>$session_id));
        $member = member($_W['openid'],'is_weixin');
        $data['openid'] = $member['openid'];
        if ($member['nickname'] || $member['avatar']) {
            $_W['openid'] = $member['openid'];
            $member = member($_W['openid']);
            $data['avatar'] = $member['avatar'];
            $data['nickname'] = $member['nickname'];
            $data['openid'] = $member['openid'];
            $data['uid'] = $member['uid'];
        }
    }else{
        $member = member($_W['openid']); 
        if(!$member && pdo_tableexists('cyl_video_pc_site') && $_W['account']['level'] != 4 && $_GPC['phone'] && $_W['oauth_account']['level'] != 4 ){
        	// var_dump($_GPC['phone']);
            $_W['openid'] = $_GPC['phone'];
            $data['openid'] = $_W['openid'];
            $data['phone'] = $_GPC['phone'];
            $member = member($_W['openid']);
        }
    }
    if ($member['is_pay'] == 3 && $member) {
        message('您已禁止访问！');  
    }    
    if ($_W['openid'] && !is_weixin()){
        // pdo_insert('cyl_vip_video_member_online', array('openid'=>$_W['openid'],'session_id'=>$session_id));
    }   
    if ($_W['openid']) { 
        if ($member) {
            unset($data['time']);
            $setting = setting();
            if ($setting['member']) {
                $data['site_name'] = $setting['member']['site_name'];
            }  
            pdo_update('cyl_vip_video_member', $data,array('id'=>$member['id'])); 
        }else{
            if (is_weixin() && $_W['account']['level'] == 4 || is_weixin() && $_W['oauth_account']['level'] == 4 ) { 
               pdo_insert('cyl_vip_video_member', $data);
            }
        }
    }

    if (pdo_tableexists('cyl_video_pc_site') && $_GPC['do'] != 'jspay' && $_GPC['do'] !='jspayreturn' && $_W['do'] != 'codepaynotify_url' && $_W['os'] != 'mobile' && !is_weixin() && !strexists($_W['siteurl'], 'web')) { 
        
        if ($_GPC['mov'] == 'detail') {           
            $url = $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&op='.$_GPC['op'].'&url='.$_GPC['url'].'&d_id='.$_GPC['d_id'].'&do=detail&m=cyl_video_pc'; 
        }else{
             $url = $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&do=index&m=cyl_video_pc'; 
        }
        header("location:".$url);   
    }  

}
protected function payconfig($no, $fee, $body) {
    global $_W; 
    $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    $data['appid'] =  $this->wxpay['appid'];
    $data['mch_id'] = $this->wxpay['mch_id'];           //商户号
    $data['device_info'] = 'WEB';
    $data['nonce_str'] = $this->createNoncestr();
    $data['body'] = $body;
    $data['out_trade_no'] = $no;               //订单号
    $data['total_fee'] = $fee;                 //金额
    //$data['spbill_create_ip'] = $_SERVER["REMOTE_ADDR"];  //ip地址
    $data['notify_url'] = $this->wxpay['notify_url'];  //回调地址不能带参数 
    $data['return_url'] = $this->wxpay['notify_url'];  //返回地址不能带参数 (占时不需要放开)
    $data['trade_type'] = 'MWEB';
    $data['spbill_create_ip'] = $_W['clientip'];
    $data['scene_info'] = '{"h5_info":{"type":"Wap","wap_url":"{$_W[siteroot]}","wap_name": "VIP"}}';
    $data['sign'] = $this->MakeSign($data);
    //var_dump($data);
    $xml = $this->ToXml($data);
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    //设置header
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    //要求结果为字符串且输出到屏幕上
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_POST, TRUE); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $xml); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    $tmpInfo = curl_exec($curl); // 执行操作
    curl_close($curl); // 关闭CURL会话
    $arr = $this->FromXml($tmpInfo);
    return $arr;
}

/**
 *    作用：产生随机字符串，不长于32位
 */
public function createNoncestr($length = 32) {
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 *    作用：产生随机字符串，不长于32位
 */
public function randomkeys($length) {
    $pattern = '1234567890123456789012345678905678901234';
    $key = null;
    for ($i = 0; $i < $length; $i++) {
        $key .= $pattern{mt_rand(0, 30)};    //生成php随机数
    }
    return $key;
}

/**
 * 将xml转为array
 * @param string $xml
 * @throws WxPayException
 */
public function FromXml($xml) {
    //将XML转为array
    return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}

/**
 * 输出xml字符
 * @throws WxPayException
 * */
public function ToXml($arr) {
    $xml = "<xml>";
    foreach ($arr as $key => $val) {
        if (is_numeric($val)) {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
    }
    $xml .= "</xml>";
    return $xml;
}

/**
 * 生成签名
 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
 */
protected function MakeSign($arr) {
    //签名步骤一：按字典序排序参数
    global $_W; 
    $setting = uni_setting($_W['uniacid']);
    $wxpay = $setting['payment']['wechat'];
    ksort($arr);
    $string = $this->ToUrlParams($arr);
    //签名步骤二：在string后加入KEY
    $string = $string . "&key=" . $this->wxpay['key'];
    //签名步骤三：MD5加密
    $string = md5($string);
    //签名步骤四：所有字符转为大写
    $result = strtoupper($string);
    return $result;
}

/**
 * 格式化参数格式化成url参数
 */
protected function ToUrlParams($arr) {
    $buff = "";
    foreach ($arr as $k => $v) {
        if ($k != "sign" && $v != "" && !is_array($v)) {
            $buff .= $k . "=" . $v . "&";
        }
    }
    $buff = trim($buff, "&");
    return $buff;
}

public function get_client_ip() {
    $cip = 'unknown';
    if ($_SERVER['REMOTE_ADDR']) {
        $cip = $_SERVER['REMOTE_ADDR'];
    } elseif (getenv('REMOTE_ADDR')) {
        $cip = getenv('REMOTE_ADDR');
    }
    return$cip;
}

//判断是不是在微信浏览器中
public function is_weixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}
//http://www.sucaihuo.com/H5/notify_wx
public function doMobileNotify_wx() { 
    global $_W, $_GPC;
    $op = $_GPC['op'];
    $settings = $this->module['config'];  
    $acc = WeAccount::create();    
    if (pdo_tableexists('cyl_video_pc_site') && !is_weixin() ) {
        $openid = $_GPC['phone'];
        $member = member($openid,'is_weixin');
        if ($member['nickname']) {
            $openid = $member['openid'];
            $member = member($openid);
        }
    }else{
        $openid = $_W['openid'];
        $member = member($openid);
    }
    $tid = $_GPC['tid'];
    $order_id = $_GPC['order_id']; 
    $order = pdo_get('cyl_vip_video_order', array('uniacid'=>$_W['uniacid'],'id'=>$order_id,'openid'=>$member['openid'])); 
    if(!$order){
         message('订单不是你的！'); 
    } 
    if ($op == 'success') {
        $res = $this->queryOrder($tid,2);
        if ($res['trade_state'] == 'SUCCESS') {            
                pdo_update('cyl_vip_video_order', array('status'=>1), array('tid' => $tid)); 
                if ($member['end_time']) {  
                    $day = $order['day'];               
                    pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
                    $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time'])); 
                }else{
                    $day = $order['day'];
                    pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
                    $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
                }  
                if($_W['account']['level'] == 4 && $settings['tpl_id']) {
                    if ($order['desc']) {
                        $data = array(
                            'first' => array(
                                'value' => '您好,'.$member['nickname'],
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => '感谢打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,                 
                            'remark' => array(
                                'value' => '感谢您的打赏！', 
                                'color' => '#ff510'
                            ) ,
                        );
                        $url = link_url('member');
                        $acc->sendTplNotice($order['openid'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                        $data = array(
                            'first' => array(
                                'value' => $member['nickname'].'打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => '感谢打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,                    
                            'remark' => array(
                                'value' => '打赏金额【'.$order['fee'].'】元，请进入后台查看',
                                'color' => '#ff510'
                            ) ,
                        );
                        $acc->sendTplNotice($settings['kf_id'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                    }else{
                        $data = array(
                            'first' => array(
                                'value' => '您好,'.$member['nickname'],
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => $params['tid'],
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => '支付成功',
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,    
                            'keyword4' => array(
                                'value' => $_W['uniaccount']['name'],
                                'color' => '#ff510'
                            ) ,  
                            'keyword5' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,              
                            'remark' => array(
                                'value' => '到期时间：'.$time.'',
                                'color' => '#ff510'
                            ) ,
                        ); 
                        $url = link_url('member');
                        $acc->sendTplNotice($order['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                        $data = array(
                            'first' => array(
                                'value' => $member['nickname'].'开通了'.$day.'天会员',
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => $params['tid'],
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => '支付成功',
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,    
                            'keyword4' => array(
                                'value' => $_W['uniaccount']['name'],
                                'color' => '#ff510'
                            ) ,  
                            'keyword5' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,              
                            'remark' => array(
                                'value' => '会员到期时间'.$time.'请进入后台查看',
                                'color' => '#ff510'
                            ) ,
                        );
                        $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');   
                    }
                }
                message('您已支付成功！', link_url('member') , 'success');
        }else{
             message('支付失败！'.$res['trade_state_desc'],$this->createMobileUrl('notify_wx',array('tid'=>$tid,'order_id'=>$order_id)),'error'); 
        }
    }
    include $this->template('notify_wx'); 
}
public function doMobileBanner() {
    global $_W, $_GPC;
    $acc = WeAccount::create(); 
    $member = member('oWMyitz2_pkYqo3CWYD2ra5yswRo'); 
    $settings = $this->module['config'];    
    $data = array(
            'first' => array(
                'value' => '您好,'.$member['nickname'].'您的会员已到期',
                'color' => '#ff510'
            ) ,
            'keyword1' => array(
                'value' => '会员到期',
                'color' => '#ff510'
            ) ,
            'keyword2' => array(
                'value' => date('Y-m-d H:i:s',$member['end_time']),
                'color' => '#ff510'
            ) ,                   
            'remark' => array(
                'value' => '欢迎继续使用',
                'color' => '#ff510'
            ) ,
        );
    $url = link_url('member');
    $acc->sendTplNotice('oWMyitz2_pkYqo3CWYD2ra5yswRo', $settings['due_id'], $data, $url, $topcolor = '#FF683F');
}
public function doMobileDiscover() { 
    global $_W, $_GPC;
    $settings = $this->module['config'];
    if ($settings['is_pc'] == 2 && is_weixin()) {       
        $url = link_url('index'); 
        Header("Location: ".$url);
        exit();  
    }
    $setting = setting();
    $setting = $setting['member']; 
    $settings = $this->module['config'];
    if ($setting) {
        $setting = iunserializer($setting['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    } 
    $acc = WeAccount::create();     
    $member = member($_W['openid']); 
    $jilu = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video')." WHERE uniacid = :uniacid AND openid = :openid ORDER BY id DESC LIMIT 10", array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));
    $num = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND openid = :openid ", array(
            ':uniacid' => $_W['uniacid'],
            ':openid' => $member['openid']               
            ));    
    $acc = WeAccount::create();
    $info = $acc->fansQueryInfo($_W['openid']);  
     $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');            
    $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['do']), array() , '' , 'sort DESC , id DESC');
    $record = pdo_fetch("SELECT * FROM ".tablename('cyl_vip_video')." WHERE uniacid = :uniacid AND openid = :openid ORDER BY id DESC", array(':uniacid' => $_W['uniacid'],':openid'=>$member['openid']));

    if ($settings['ziyuan'] == 2) {
        $type = mac_category();
    }  
    if (TIMESTAMP > $member['end_time'] && $member['is_pay'] == 1) {
        pdo_update('cyl_vip_video_member',array('end_time'=>null,'is_pay'=>0),array('openid'=>$member['openid']));
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'].'您的会员已到期',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员到期',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => date('Y-m-d H:i:s',$member['end_time']),
                    'color' => '#ff510'
                ) ,                   
                'remark' => array(
                    'value' => '欢迎继续使用',
                    'color' => '#ff510'
                ) ,
            );
        $url = link_url('member');
        $acc->sendTplNotice($member['openid'], $settings['due_id'], $data, $url, $topcolor = '#FF683F');
    }
    if (checksubmit()) {
        $url = $_GPC['url'];
        $c=explode('m.v.qq',$url);      
        if(count($c)>1){
            $url = 'https://v.qq'.$c['1']; 
        }
        if(!isUrl($url)) message('输入的网页地址错误，请重新输入,检查是否含有http://');
        if ($num >= $settings['free_num'] && $member['is_pay'] == 0) {
            message('您的免费观看次数已用完，请点击确定开通会员，无限制观看',link_url('member',array('op'=>'open')),'error'); 
        }    
        $video = pdo_get('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid'],'video_url'=>$url)); 
        if(!$url) message('请输入链接'); 
        if($video) message('这个视频您之前提交过了，点击确定跳转继续观看',link_url('index',array('mov'=>'detail','url'=>$url,'index'=>1)),'success');
        $res = pdo_insert('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid'],'uid'=>$_W['fans']['uid'],'title'=>$title,'video_url'=>$url,'time'=>TIMESTAMP,'share'=>$_GPC['share'],'index'=>1));
        $video_url = link_url('index',array('mov'=>'detail','url'=>$url,'index'=>1));               
        Header("Location: ".$video_url);
        exit();
    }
    include $this->template('discover'); 
}   
public function doMobileDetail() {         
    global $_W, $_GPC;
    $op = $_GPC['op'];
    $id = $_GPC['id'];  
    $acc = WeAccount::create(); 
    $password = $_COOKIE['password'];   
    $info = $acc->fansQueryInfo($_W['openid']);      
    $settings = $this->module['config'];
    if ($settings['is_pc'] == 2 && is_weixin()) {       
        $url = link_url('index'); 
        Header("Location: ".$url);
        exit();  
    }
    if (pdo_tableexists('cyl_video_pc_site') && !is_weixin()) {
        $openid = $_GPC['phone'];
        $member = member($openid,'is_weixin');
        if ($member['nickname']) {
            $openid = $member['openid'];
            $member = member($openid);
        }
    }elseif(pdo_tableexists('cyl_video_pc_site') && is_weixin() && $_W['oauth_account']['level'] < 4 ){
        $openid = $_GPC['phone'];
        $member = member($openid,'is_weixin');
        if ($member['nickname']) {
            $openid = $member['openid'];
            $member = member($openid);
        }
    }else{
        $openid = $_W['openid'];
        $member = member($openid);
    }    
    if (pdo_tableexists('cyl_video_pc_site') && $member['is_pay'] == 0 && !is_weixin() && !$openid) {
        $openid = $_W['clientip'];
    } 
    if (pdo_tableexists('cyl_video_pc_site') && $member['is_pay'] == 0 && is_weixin() && !$openid && $_W['oauth_account']['level'] < 4) {
        $openid = $_W['clientip'];
    }
    if (TIMESTAMP > $member['end_time'] && $member['is_pay'] == 1) {
        pdo_update('cyl_vip_video_member',array('end_time'=>null,'is_pay'=>0),array('openid'=>$member['openid']));
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'].'您的会员已到期',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员到期',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => date('Y-m-d H:i:s',$member['end_time']),
                    'color' => '#ff510'
                ) ,                   
                'remark' => array(
                    'value' => '欢迎继续使用',
                    'color' => '#ff510'
                ) ,
            );
        $url = link_url('member');
        $acc->sendTplNotice($member['openid'], $settings['due_id'], $data, $url, $topcolor = '#FF683F');
    }        
    $ad = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid = :uniacid  AND status = 0 ORDER BY rand() DESC LIMIT 1",array(':uniacid'=>$_W['uniacid']),'id');
    if (TIMESTAMP > $ad['end_time']) {
        pdo_update('cyl_vip_video_ad',array('status'=>1),array('id'=>$ad['id']));
    } 
    if (!pdo_tableexists('cyl_video_pc_site')) {
        if(!is_weixin()){ 
            message('暂时只支持微信,请使用微信观看视频');  
        } 
    }   
    if ($settings['is_pc'] == 1) {
        if(!is_weixin()){ 
            message('暂时只支持微信,请使用微信观看视频');  
        }  
    }
    
    //if (!$openid) message('暂时只支持微信,请使用微信观看视频'); 
    $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['do']), array() , '' , 'sort DESC , id DESC');
     $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');
    $url = $_GPC['url'];
    $yurl = $_GPC['url'];
    if ($settings['everyday_free_num'] == 1) {
        $num = pdo_fetchcolumn("SELECT COUNT(*),time FROM " . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND openid = :openid AND time >= :firsttime AND time <= :lasttime ", array(':uniacid' => $_W['uniacid'],':openid' => $openid,':firsttime'=>strtotime(date('Y-m-d 00:00:00')),':lasttime'=>strtotime(date('Y-m-d 23:59:59'))));
    }else{
        $num = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND openid = :openid ", array(':uniacid' => $_W['uniacid'],':openid' => $openid));
    }
    if ($num >= $settings['free_num'] && $member['is_pay'] == 0) {
        message($settings['warn_font'] ? $settings['warn_font'] : '您的免费观看次数已用完，请点击确定开通会员，无限制观看',link_url('member',array('op'=>'open')),'error'); 
    } 
    $jilu = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video')." WHERE uniacid = :uniacid AND openid = :openid ORDER BY id DESC LIMIT 10", array(':uniacid'=>$_W['uniacid'],':openid'=>$openid));
    $video_id = $_GPC['url'] ? $_GPC['url'] : $id;
    $comment = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_message')." WHERE uniacid = :uniacid AND video_id = :video_id AND status = 1 ORDER BY id DESC LIMIT 10", array(':uniacid'=>$_W['uniacid'],':video_id'=>$video_id)); 
    $shoucang = pdo_get('cyl_vip_video',array('uniacid' => $_W['uniacid'],'yvideo_url' => $video_id,'openid' => $openid,'type' => 'shoucang'            
    )); 
    if ($id) {        
        $content = pdo_fetch("SELECT * FROM ".tablename('cyl_vip_video_manage')." WHERE id=:id",array(':id'=>$id));
        if (checksubmit('submit')) {
            if ($_GPC['password'] == $content['password']) {
                setcookie("password",$_GPC['password'],time()+2*7*24*3600);
                $url = $this->createMobileUrl('detail',array('id'=>$id));
                Header("Location: ".$url);
            }else{
                message('密码不正确，请重新输入','','error');
            }           
        }
        $click = $content['click'];
        $juji = iunserializer($content['video_url']);
        if (count($juji) < 2) {
            $url = $juji['0']['link'];
        }else{
            $url = $_GPC['url'];
            if (!$url) {
                $url = $juji['0']['link'];
            }
        }
        $is_charge = pdo_get('cyl_vip_video_order',array('uniacid'=>$_W['uniacid'],'video_id'=>$id));
        $is_vip = is_vip($id,'id');         
        pdo_update('cyl_vip_video_manage', array('click +=' => 1), array('id' => $id));                 
    }elseif ($op == 'yule' || $op == 'gaoxiao') {
        $url = kan360($url);        
        $content['title'] = $url['title'];      
        $content['thumb'] = $url['thumb'];      
        $url = $url['mp4'];
        // $tuijian = pc_caiji_detail_tuijian($url);
    }else{          
        if ($settings['ziyuan'] == 1) {  
           
            $link = $content['site']; 
            
            if (count($link) > 1) {

                $url = $link['1'];
                $site_title = $link['1'];
            }else{
                $site_title = $link['0'];
            }     
            $playurl = $content['playurl'];
            if ($op == 'dianying') {
                $url = explode("$",$playurl);
                $url = $url['1'];
            }
            if ($op == 'dianshi' || $op == 'dongman') {
                $jishu = $_GPC['jishu'];
                $url_m3u8 = array();
                $url_list = explode("#",$playurl);                    
                foreach ($url_list as $key => $v) {
                   $value = explode("$",$v);
                   $key = $value['0'];
                   $url_m3u8[$key] = array($key,$value['1']);
                } 
                $juji = $url_m3u8;
                if ($jishu) {
                    $url = $url_m3u8[$jishu]['1'];  
                }else{
                    $first_val = reset($url_m3u8);                        
                    $url = $first_val['1'];
                } 
            } 
            if ($op == 'zongyi') {
                $jishu = $_GPC['jishu'];
                $url_m3u8 = array();
                $url_list = explode("#",$playurl);                    
                foreach ($url_list as $key => $v) {
                   $value = explode("$",$v);
                   $key = $value['0'];
                   $url_m3u8[$key] = array($key,$value['1']);
                } 
                $juji = $url_m3u8;
                if ($jishu) {
                    $url = $url_m3u8[$jishu]['1'];  
                }else{
                    $first_val = reset($url_m3u8);                        
                    $url = $first_val['1'];
                } 
            }
        }else{
            $url_time = cache_load('pc_caiji_detail:'.$url);        
            if ((TIMESTAMP - $url_time) > 86400 ) {
                $content = pc_caiji_detail($url,$op);
                $tuijian = pc_caiji_detail_tuijian($url);       
                $daoyan = pc_caiji_detail_daoyan($url); 
                cache_write('pc_caiji_detail:'.$url, TIMESTAMP);                
                cache_write('content:'.$url, $content);  
                cache_write('tuijian:'.$url, $tuijian);  
                cache_write('daoyan:'.$url, $daoyan); 
            }else{
                $content = cache_load('content:'.$url); 
                $tuijian = cache_load('tuijian:'.$url); 
                $daoyan = cache_load('daoyan:'.$url);               
            }       
            $site = site(); 
            $content = $content['0'];   
            $vip_url = $_W['siteurl'];     
            $is_vip = is_vip($vip_url,'url');
            if ($op == 'dianying') {                 
                if ((TIMESTAMP - $url_time) > 86400 ) {
                    $link = caiji_url($url);
                    cache_write('caiji_url:'.$url, $link);
                }else{
                    $link = cache_load('caiji_url:'.$url);
                }           
                if ($_GPC['link']) {
                    $url = $_GPC['link'];
                }else{
                    if (strpos($link['0']['link'], 'qq') && count($link) > 1 && !$settings['tengxun']) {
                        $url = $link['1']['link'];
                        $site_title = $link['1']['title'];
                    }else{
                        $url = $link['0']['link'];
                    }               
                }               
            }
            if ($op == 'dianshi') {             
                $link = dianshi_url($url);
                if ($_GPC['site']) {
                    $site = array_keys($site,$_GPC['site']);  
                }else{
                    if (count($link) > 1) {
                        if (strexists($link['0'], '腾讯') || strexists($link['0'], '华数TV') && !$settings['tengxun']) {
                          $site_title = $link['1'];
                        }elseif (strexists($site_title, '腾讯') || strexists($site_title, '华数TV') ) { 
                          $site_title = $link['2'];
                        }else{
                          $site_title = $link['0'];
                        }            
                    }else{
                        $site_title = $link['0'];
                    }
                    $site = array_keys($site,str_replace('(付费)','',$site_title));
                }      
                $juji = juji_url($_GPC['url'],$site);      
                if ($_GPC['link']) {
                  $url = $_GPC['link'];
                }else{        
                  $url = $juji['0']['link'];         
                } 
            } 
            
            if ($op == 'dongman') {
                $link = dianshi_url($url);
                if ($_GPC['site']) {
                    $site = array_keys($site,$_GPC['site']);  
                }else{
                    if (count($link) > 1) {
                        if (strexists($link['0'], '腾讯') || strexists($link['0'], '华数TV') && !$settings['tengxun']) {
                          $site_title = $link['1'];
                        }elseif (strexists($site_title, '腾讯') || strexists($site_title, '华数TV') ) { 
                          $site_title = $link['2'];
                        }else{
                          $site_title = $link['0'];
                        }            
                    }else{
                        $site_title = $link['0'];
                    }
                    $site = array_keys($site,str_replace('(付费)','',$site_title));
                } 
                $juji = dongman_url($url,$site);
                if ($_GPC['link']) {
                    $url = $_GPC['link'];
                }else{
                    $url = $juji['0']['link'];
                } 
            }
            if ($op == 'zongyi') {
                $link = zongyi_url($url);               
                if ($_GPC['site']) {
                    $site = array_keys($site,$_GPC['site']);  
                }else{
                    if (strexists($link['0']['title'], '腾讯') && count($link) > 1 && !$settings['tengxun']) {                    
                        $site_title = $link['1']['title'];
                    }else{
                        $site_title = $link['0']['title'];
                    }
                    $site = array_keys($site,str_replace('(付费)','',$site_title));
                } 
                $year = $_GPC['year'];
                if ($year) {
                    $ss = '/([\x80-\xff]*)/i';
                    $year = preg_replace($ss,'',$year);
                    $juji = zongyi_juji_url($url,$site,$year);      
                }else{                  
                    $juji = zongyi_juji_url($url,$site);
                }           
                $year = zongyi_year_url($url);
                // var_dump($year); 
                if (!$_GPC['year']) {
                    $_GPC['year'] = $year['0']['date'];
                }           
                if ($_GPC['link']) {
                    $url = $_GPC['link'];
                }else{
                    $url = $juji['0']['link'];
                }
            }
        }
        $click = pdo_fetchcolumn('SELECT * FROM ' . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND yvideo_url = :yvideo_url ",array(':uniacid'=>$_W['uniacid'],':yvideo_url'=>$yurl));             
    }       
    $video = pdo_get('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'video_url'=>$url));
    if (!$video) {
        if ($id) {
            pdo_insert('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'title'=>$content['title'],'video_url'=>$url,'video_id'=>$id,'type'=>$op,'time'=>TIMESTAMP,'share'=>$_GPC['jishu']));
        }else{              
            pdo_insert('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'title'=>$content['title'],'video_url'=>$url,'yvideo_url'=>$yurl,'type'=>$op,'time'=>TIMESTAMP,'share'=>$_GPC['jishu']));
        }
    }   
    if ($settings['api']) {     
        if (strexists($url,'zhilian')) {
                $url = explode('&type=zhilian',$url);               
                $api = $url['0'];
        }elseif (strexists($url,'baidu')) {
            
            $api = $settings['baidu_api'].$url; 
        }else{
            $api = $settings['api'].$url.'&link='.$_GPC['link']; 
        }
    }else{
        if ($id) {          
            if (strexists($url,'zhilian')) {
                $url = explode('&type=zhilian',$url);               
                $api = $url['0'];
            }elseif ($settings['baidu_api'] && strexists($url,'baidu')) {
                $api = $settings['baidu_api'].$url;
            }else{
                $api = 'https://cyl.go8goo.com/vip/api.php?url='.$url.'&link='.$_GPC['link'];
            }
        }else{
            $api = 'https://cyl.go8goo.com/vip/vip.php?url='.$url.'&link='.$_GPC['link']; 
        }
    }           
    if ($_GPC['index'] == 1) {
        $id = $_GPC['id'];
        $data = array(
            'uniacid' => $_W['uniacid'], 
            'id' => $id,
        );
        $item = pdo_get('cyl_vip_video', $data);                 
        include $this->template('news/detail'); 
        exit();
    }       
    include $this->template('news/detail'); 
}
public function doMobileSearch() {
    global $_W, $_GPC;
    $acc = WeAccount::create(); 
    $setting = setting();
      
    $setting = $setting['member']; 
    $settings = $this->module['config'];
    if ($settings['ziyuan'] == 2) {
        $type = mac_category();
    }    
    if ($setting) {
        $setting = iunserializer($setting['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    }
    if ($_GPC['do'] == 'search' && !$_GPC['eid']) {
        $modules_bindings = pdo_get('modules_bindings', array('do' => $_GPC['do'],'module'=>$_GPC['m'])); 
        $url = $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&eid='.$modules_bindings['eid'];
        Header("Location: ".$url);
        exit(); 
    }
    if ($settings['is_pc'] == 2 && is_weixin()) {       
        $url = link_url('index'); 
        Header("Location: ".$url);
        exit();  
    }       
    $member = member($_W['openid']); 
    $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['do']), array() , '' , 'sort DESC , id DESC');
     $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');
    if (TIMESTAMP > $member['end_time'] && $member['is_pay'] == 1) {
        pdo_update('cyl_vip_video_member',array('end_time'=>null,'is_pay'=>0),array('openid'=>$member['openid']));
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'].'您的会员已到期',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员到期',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => date('Y-m-d H:i:s',$member['end_time']),
                    'color' => '#ff510'
                ) ,                   
                'remark' => array(
                    'value' => '欢迎继续使用',
                    'color' => '#ff510'
                ) ,
            );
        $url = link_url('member');
        $acc->sendTplNotice($member['openid'], $settings['due_id'], $data, $url, $topcolor = '#FF683F');
    }
    $where = ' WHERE uniacid = :uniacid AND display != 1 ';
    $params[':uniacid'] = $_W['uniacid'];
    $sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY id DESC LIMIT 50';         
    $video = pdo_fetchall($sql, $params, 'id');             
    $op = $_GPC['op'] ? $_GPC['op'] : 'search';
    $key = $_GPC['key'];

    if ($key) { 
        $where = ' WHERE uniacid = :uniacid ';          
        $where .= ' AND title LIKE :title ';
        $params[':uniacid'] = $_W['uniacid'];   
        $params[':title'] = "%".$_GPC['key']."%";             
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY id DESC ';         
        $search = pdo_fetchall($sql, $params, 'id');
        if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) { 
            $url = m3u8();
            $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
            $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&key=".$key;
            $response = ihttp_get($url); 
            $list = json_decode($response['content'],true);
        }elseif ($settings['ziyuan'] == 2) {                 
            $list = mac_list(array('key'=>$key));                
        }else{                      
            $list = caiji_list($key);
        } 
        
    }
    if (count($list) == 1 ) {
        if (strexists($list['0']['img'], 'tu')) {
            $list['0']['img'] = MODULE_URL . $list['0']['img'];                    
        }  
    }else{
        foreach ($list as $key => &$value) {
            if (strexists($value['img'], 'tu')) {
                $value['img'] = MODULE_URL . $value['img'];                    
            }                
        }
    }
    
    if ($op == 'json') {
        $url = 'https://video.360kan.com/suggest.php?ac=richsug&kw='.$_GPC['kw'];
        $url = ihttp_get($url);    
        $content = json_decode($url['content'],true);            
        $url =  $content['data']['suglist']; 
        $data = json_encode($url);
        echo $data;
        exit();
    }
    if (checksubmit()) {
        if ($settings['is_qiupian_members'] == 1 && $member['is_pay'] == 0 ) {
            message('只有会员才能求片！','','error');
        }
        $forum = pdo_getall('cyl_vip_video_forum', array('uniacid' => $_W['uniacid'],'openid' => $member['openid'],), array() , '' , 'id DESC');
        $title = $_GPC['title'];
        $data = array(
            'uniacid' => $_W['uniacid'],
            'time' => TIMESTAMP,
            'openid' => $member['openid'],            
            'title' => $title, 
        );      
        $forum_time = TIMESTAMP - $forum['0']['time'];
        if (!$title) {
            message('请输入片名','','error');
        }
        if ($forum_time < 3600 * 24) {
           message('每天只能一次求片！！','','error');
        }
        
        $res = pdo_insert('cyl_vip_video_forum', $data);
        if ($res) {
            $data = array(
                'first' => array(
                    'value' => '会员,'.$member['nickname'].'求片提醒',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '片名：'.$title,
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => '求片提醒',
                    'color' => '#ff510'
                ) ,                   
                'remark' => array(
                    'value' => '请进入后台查看',
                    'color' => '#ff510'
                ) ,
            );
            $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data,  $topcolor = '#FF683F');
            message('求片成功','','success');  
        }
        
    }    
    include $this->template('search'); 
}   
public function doMobileGetLocation() {
    global $_W, $_GPC;      
    $settings = $this->module['config'];
    $url="http://api.map.baidu.com/geocoder?location=".$_GPC['latitude'].",".$_GPC['longitude']."&output=json&key=28bcdd84fae25699606ffad27f8da77b";
    $str=file_get_contents($url);
    $res=json_decode($str,true);    
    $city = $res['result']['addressComponent']['city']; 
    if (strpos($settings['area'], $city)){  
        echo "1";   
    }else{      
        $label = 'warn';
        $msg = '您的地区限制观看';
         include $this->template('message'); 
    }

}   
public function doMobileClean() {
    global $_W, $_GPC;      
    $res = pdo_delete('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']));
    echo "清空成功";
    exit();      
}
public function doMobileShare() {
    global $_W, $_GPC;      
    
}
public function doMobileLogin() {
    global $_W, $_GPC;     
    $settings = $this->module['config'];  
    $op = $_GPC['op'] ? $_GPC['op'] : 'login'; 
    $member = member($_W['openid']);   
    
    include $this->template('login');
}
public function doMobileBangding() { 
    global $_W, $_GPC;
    $op = $_GPC['op'];
    if(!pdo_tableexists('cyl_video_pc_site')){
        exit();
    }
    $weixin_member = member($_W['openid']); 
    $settings = $this->module['config'];
    if (checksubmit()) {                
        $data = $_GPC['data'];
        $data['password'] = md5($data['password']);
        $data['uniacid'] = $_W['uniacid'];        
        if (!$data['phone']) {
          message('请填写手机号','','error');
        }
        if (!$data['password']) {
          message('请填写密码','','error');
        }
        $member = pdo_get('cyl_vip_video_member', $data); 
        if ($weixin_member['phone']) {
            message('绑定失败,您的手机号已绑定过或者您的微信已绑定过手机号！','','error'); 
        }
        if ($member) {  
            $data['openid'] = $_W['openid'];
            if ($member['is_pay'] == 1) {
                $end_time = $member['end_time'] - TIMESTAMP;
                $data['end_time'] = $weixin_member['end_time'] + $end_time;
                if ($weixin_member['is_pay'] == 1) {
                    $end_time = $member['end_time'] - TIMESTAMP;
                    $data['end_time'] = $weixin_member['end_time'] + $end_time;
                }else{
                    $data['is_pay'] = 1;
                    $data['end_time'] = $member['end_time']; 
                }
            }
            pdo_update('cyl_vip_video_member',$data,array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid'])); 
            pdo_delete('cyl_vip_video_member',array('id'=>$member['id']));         
            message('绑定成功',link_url('member'),'success');
        }else{
            message('绑定失败,请输入正确的手机号和密码！','','error'); 
        }
    } 
    if ($op == 'jiechu') {
          pdo_update('cyl_vip_video_member',array('phone'=>'','password'=>''),array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid']));
          message('解除绑定成功',link_url('member'),'success'); 
    }
    include $this->template('bangding'); 
}
public function doMobileMember() {
    global $_W, $_GPC;          
    load()->model('mc');    
    $session_id = session_id();  
    $acc = WeAccount::create();       
    $setting = setting();   
    $site_name = $setting['member']; 
    $settings = $this->module['config'];  
    if ($setting['member']['card']) {
        $settings['card'] = $setting['member']['card'];
        $settings['pay_settings'] = 1;
        $settingss = iunserializer($site_name['setting']);
        $settings['site_title'] = $settingss['site_title'];
        $settings['copyright'] = $settingss['copyright'];
    } 
    if ($settings['is_pc'] == 2 && is_weixin() && $_GPC['do'] != 'member') {        
        $url = link_url('index'); 
        Header("Location: ".$url);
        exit();  
    }  
    $op = $_GPC['op'] ? $_GPC['op'] : 'member';
    if (!is_weixin() && pdo_tableexists('cyl_video_pc_site') && $_GPC['phone']) {
        $_W['openid'] = $_GPC['phone'];
    }   
    if (pdo_tableexists('cyl_video_pc_site') && !is_weixin() && $_W['oauth_account']['level'] == 4) {
        $openid = $_GPC['phone'];
        $member = member($openid,'is_weixin');        
        if ($member['nickname']) {
            $openid = $member['openid'];
            $member = member($openid);
        }
    }elseif(pdo_tableexists('cyl_video_pc_site') && is_weixin() && $_W['oauth_account']['level'] < 4 ){
        $openid = $_GPC['phone'];
        $member = member($openid,'is_weixin');
        if ($member['nickname']) {
            $openid = $member['openid'];
            $member = member($openid);
        }
    }else{
        $openid = $_W['openid'];
        $member = member($openid);
    }    
    if (TIMESTAMP > $member['end_time'] && $member['is_pay'] == 1) {
        pdo_update('cyl_vip_video_member',array('end_time'=>null,'is_pay'=>0),array('openid'=>$member['openid']));
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'].'您的会员已到期',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员到期',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => date('Y-m-d H:i:s',$member['end_time']),
                    'color' => '#ff510'
                ) ,                   
                'remark' => array(
                    'value' => '欢迎继续使用',
                    'color' => '#ff510'
                ) ,
            );
        $url = link_url('member');
        $acc->sendTplNotice($member['openid'], $settings['due_id'], $data, $url, $topcolor = '#FF683F');
    }
    if($_W['oauth_account']['level'] < 4 || !is_weixin()) {
        if (!pdo_tableexists('cyl_video_pc_site')) {
           checkauth();
        }elseif(!$member && !$member['openid'] && $op != 'login' && $op != 'create' && $op != 'check' ){
           isetcookie('phone',''); 
           message('您还未登陆，即将跳转!',link_url('member',array('op'=>'login')),'success');    
        }       
    }
    $credit = mc_credit_fetch($member['uid']); 
    if ($op == 'open') {
        $day = $_GPC['day'];
        $fee = $_GPC['card_fee'];
        $day = $_GPC['card_day'];
        $jifen = $_GPC['card_credit'];
        if (checksubmit('credit')) {
            $fee = $jifen;                      
            if ($fee > $credit['credit1']) {
                message('积分不足','','error');
            }
            if (empty($fee)) {
                message('管理员未设置积分，请使用微信支付兑换','','error');
            }
            $data = array(
                'uniacid' => $_W['uniacid'],
                'openid' => $member['openid'],
                'uid' => $member['uid'],
                'tid' => '积分兑换',
                'fee' => $fee,              
                'status' => 1,
                'day' => $day,
                'time' => TIMESTAMP
            );      
            if (pdo_tableexists('cyl_agent_site_member')) {
                $url="http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
                preg_match("#http://(.*?)\.#i",$url,$match);
                $site_name = $match['1'];
                $site_name = pdo_get('cyl_agent_site_member',array('site_name'=>$site_name));
                if ($site_name) {
                   $data['site_name'] = $match['1'];
                } 
            }           
            pdo_insert('cyl_vip_video_order',$data);
            mc_credit_update($member['uid'], 'credit1', -$fee, array($member['uid'], '视频会员开通-'.$fee.'积分','super_mov'));
            if ($member['openid']) {
                if ($member['end_time']) { 
                    pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
                    $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time']));
                }else{                      
                    pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
                    $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
                } 
            }
            if($settings['tpl_id']) {
                $data = array(
                        'first' => array(
                            'value' => '您好,'.$member['nickname'],
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => $params['tid'],
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => '支付成功',
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',TIMESTAMP),
                            'color' => '#ff510'
                        ) ,    
                        'keyword4' => array(
                            'value' => $_W['uniaccount']['name'],
                            'color' => '#ff510'
                        ) ,  
                        'keyword5' => array(
                            'value' => $fee.'积分',
                            'color' => '#ff510'
                        ) ,              
                        'remark' => array(
                            'value' => '到期时间：'.$time.'',
                            'color' => '#ff510'
                        ) ,
                    ); 
                    $url = link_url('member');
                    $acc->sendTplNotice($data['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                    $data = array(
                        'first' => array(
                            'value' => $member['nickname'].'开通了'.$day.'天会员',
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => $params['tid'],
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => '支付成功',
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',TIMESTAMP),
                            'color' => '#ff510'
                        ) ,    
                        'keyword4' => array(
                            'value' => $_W['uniaccount']['name'],
                            'color' => '#ff510'
                        ) ,  
                        'keyword5' => array(
                            'value' => $fee.'积分',
                            'color' => '#ff510'
                        ) ,              
                        'remark' => array(
                            'value' => '会员到期时间'.$time.'请进入后台查看',
                            'color' => '#ff510'
                        ) ,
                    );
                    $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');   
                
            }
            message('会员兑换成功',link_url('member'),'success');
        }
        if (checksubmit('submit')) {
            $url = link_url('member',array('op'=>'pay','day'=>$day));               
            Header("Location: ".$url); 
            exit();
        }
    }
    if ($op == 'my') {          
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
        );
        $list = pdo_getall('cyl_vip_video', $data, array() , '' , 'id DESC'); 
    }
    if ($op == 'shoucang') {            
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
            'type' => 'shoucang', 
        );
        $list = pdo_getall('cyl_vip_video', $data, array() , '' , 'id DESC'); 
    }
    if ($op == 'out_login') {    
       isetcookie('phone','');
       message('退出成功',link_url('member',array('op'=>'login')),'success');
    }
    if ($op == 'card') {
         if (checksubmit()) {               
            $data = array(
                'uniacid' => $_W['uniacid'],
                'pwd' => trim($_GPC['card']),                  
            );
            $card = pdo_get('cyl_vip_video_keyword_id', $data, array() , '' , 'id DESC');
            if (!$card) {
                message('兑换码无效','','error');  
            }elseif ($card['status']) {
                message('兑换码已使用','','error');   
            }else{
                $res = pdo_update('cyl_vip_video_keyword_id', array('status'=>1,'openid'=>$member['openid']), array('id'=>$card['id']));                    
                if($res){
                    if ($member['openid']) {
                        if ($member['end_time']) { 
                            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$card['day']." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
                            $time = date('Y-m-d H:i:s',strtotime("+".$card['day']." days",$member['end_time']));
                        }else{                      
                            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$card['day']." days")), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
                            $time = date('Y-m-d H:i:s',strtotime("+".$card['day']." days"));
                        }
                    } 
                    if($settings['tpl_id']) {
                        $data = array(
                            'first' => array(
                                'value' => '您好,'.$member['nickname'].'开通了'.$card['day'].'天会员',
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => '会员开通',
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => '开通提醒',
                                'color' => '#ff510'
                            ) ,                    
                            'remark' => array(
                                'value' => '卡密兑换'.$card['day'].'天,到期时间'.$time,
                                'color' => '#ff510'
                            ) ,
                        );
                        $url = link_url('member');
                        $acc->sendTplNotice($member['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                        $data = array(
                            'first' => array(
                                'value' => $member['nickname'].'开通了'.$card['day'].'天会员',
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => '会员开通',
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => '开通提醒',
                                'color' => '#ff510'
                            ) ,                    
                            'remark' => array(
                                'value' => '卡密兑换'.$card['day'].'天，到期时间'.$time.'请进入后台查看',
                                'color' => '#ff510'
                            ) ,
                        );                  
                        $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                    }
                    $data = array(
                        'uniacid' => $_W['uniacid'],
                        'openid' => $member['openid'],
                        'uid' => $uid,
                        'tid' => '卡密兑换',
                        'fee' => '',                
                        'status' => 1,
                        'day' => $card['day'],
                        'time' => TIMESTAMP
                    );                  
                    pdo_insert('cyl_vip_video_order',$data);
                    message('兑换成功',link_url('member'),'success');
                }
            }
        }
    }
    if ($op == 'order') {           
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
        );
        $list = pdo_getall('cyl_vip_video_order', $data, array() , '' , 'id DESC'); 
    }
    if ($op == 'login') {
        if (checksubmit()) {                
            $data = $_GPC['data'];
            $data['password'] = md5($data['password']);
            $data['uniacid'] = $_W['uniacid'];
            if (!$data['phone']) {
              message('请填写手机号','','error');
            }
            if (!$data['password']) {
              message('请填写密码','','error');
            }
            $member = pdo_get('cyl_vip_video_member', $data); 
            if ($member) {
                $data['old_time'] = TIMESTAMP;
                isetcookie('phone',$member['phone'],3600*24*24); 
                pdo_update('cyl_vip_video_member', $data,array('id'=>$member['id']));
                // pdo_delete('cyl_vip_video_member_online',array('id'=>$online_all['0']['id']));
                message('登陆成功',link_url('member'),'success');
            }else{
                message('登陆失败,请输入正确的手机号和密码！','','success');
            }
        }
        include $this->template('login'); 
        exit();      
    }
    if ($op == 'ad') {
        $phone = $_GPC['phone'];
        $code = $_GPC['v_code'];
        if (checksubmit()) {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'phone' => $phone,
                'time' => TIMESTAMP, 
                'old_time' => TIMESTAMP,
                'password' => md5($_GPC['password']),
                'openid' => $phone,
            );
        } 
    }
    if ($op == 'create') {
        $phone = $_GPC['phone'];
        $code = $_GPC['v_code'];
        $member = pdo_get('cyl_vip_video_member', array('phone'=>$phone,'uniacid'=>$_W['uniacid']));
        if ($member) {            
            message('手机号已注册，请直接登录','','error');
        }
        if (checksubmit()) {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'phone' => $phone,
                'time' => TIMESTAMP, 
                'old_time' => TIMESTAMP,
                'password' => md5($_GPC['password']),
                'openid' => $phone,
            );
            if (is_weixin() && $_W['oauth_account']['level'] == 4) {
                $data['openid'] = $_W['openid'];
            }
            if (!$_GPC['phone']) {
              message('请填写注册的手机号','','error');
            }
            if (!$_GPC['password']) {
              message('请填写密码','','error');
            } 
            if (!$_GPC['password1']) {
              message('请填写确认密码','','error');
            } 
            if ($_GPC['password'] != $_GPC['password1']) {
                 message('确认密码不正确','','error');
            }
            if ($settings['sms'] != 3) {
               if (!$_GPC['code']) {
                  message('请填写验证码','','error');
                } 
                if ($_GPC['code'] != $code) {
                     message('验证码不正确','','error');
                }
            } 
            if($member && is_weixin()) {
                $res = pdo_update('cyl_vip_video_member', $data,array('id'=>$member['id'])); 
            }else{
                $res = pdo_insert('cyl_vip_video_member', $data);
            }            
            $id = pdo_insertid(); 
            if ($res) {
                if (is_weixin() && $_W['oauth_account']['level'] < 4) {
                    isetcookie('phone',$phone,3600*24*24); 
                }
                message('注册成功',link_url('member'),'success');
            }

        } 
        include $this->template('login'); 
        exit();   
    }
    if ($op == 'check') {
        $phone = $_GPC['phone'];
        $member = pdo_get('cyl_vip_video_member', array('phone'=>$phone,'uniacid'=>$_W['uniacid']));
        if ($member) {
            echo "手机号已注册，请直接登录";
            exit();            
        }
        $settings = $this->module['config'];
        if ($settings['sms'] == 1) {
            $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
            $code = mt_rand(1000,9999); 
            $smsConf = array(
                'key'   => $settings['juheappkey'], //您申请的APPKEY
                'mobile'    => $phone, //接受短信的用户手机号码
                'tpl_id'    => $settings['smstpl_id'], //您申请的短信模板ID，根据实际情况修改
                'tpl_value' =>'#code#='.$code //您设置的模板变量，根据实际情况修改
            );   
            $content = juhecurl($sendUrl,$smsConf,1); //请求发送短信    
            if($content){
                $result = json_decode($content,true);
                $error_code = $result['error_code'];
                if($error_code == 0){
                    //状态为0，说明短信发送成功
                    isetcookie('v_code',$code,1800); 
                    echo "短信发送成功";
                }else{
                    //状态非0，说明失败
                    $msg = $result['reason'];
                    echo "短信发送失败(".$error_code.")：".$msg;
                }
            }else{
                //返回内容异常，以下可根据业务逻辑自行修改
                echo "请求发送短信失败";
            }
        }
        if ($settings['sms'] == 2) {
            $appkey = $settings['jisuappkey'];//你的appkey
            $code = mt_rand(1000,9999); 
            $mobile = $phone;//手机号 超过1024请用POST
            $content = $settings['jisusmstpl_id'];//utf8
            $content = str_replace("@", $code, $content);
            $url = "http://api.jisuapi.com/sms/send?appkey=".$appkey."&mobile=".$mobile."&content=".$content;
            $result = curlOpen($url);
            $jsonarr = json_decode($result, true);
            if($jsonarr['status'] != 0)
            {
                echo "短信发送失败".$jsonarr['msg'];
                exit();
            }
            $result = $jsonarr['result'];
            isetcookie('v_code',$code,1800); 
            echo "短信发送成功";
        } 
        exit(); 
       
    }     
    if ($op == 'pay') {
        $_W['page']['title'] = '会员支付';
        $acc = WeAccount::create();  
        $settings = $this->module['config']; 
        $card = iunserializer($settings['card']);
        if ($setting['member']['card']) {
            $card = iunserializer($setting['member']['card']);
            $card = $card['card'];
        }
        foreach ($card as $value) {
            $card_day = $value['card_day'];
            $new_card[$card_day] = array(
                'card_day' => $value['card_day'],
                'card_fee' => $value['card_fee'],
            );
        }
        $day = $_GPC['day'];
        $id = $_GPC['id'];  
        $video_id = $_GPC['video_id'];  
        if (is_weixin()) {
           if(empty($member['openid'])){message('非法进入');}  
        }   
        $new_card = $new_card[$day]; 
        if ($new_card) {
            $amount = $new_card['card_fee'];     
        }else{
            $amount = $settings['fee']*$day;
        }     
        if ($id) {
            $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE id = :id", array(':id' => $id));
            if ($member['openid'] != $order['openid']) {
                message('非法进入');
            }
            $day = $order['day'];
            $snid = $order['tid'];
            $amount = $order['fee'];     
        }else{
            $snid = date('YmdHis') . str_pad(mt_rand(1, 99999),6, '0', STR_PAD_LEFT);
        }   
        if ($_GPC['type'] == 'shang') {
            $amount = $_GPC['fee']; 
        }
        if ($_GPC['type'] == 'charge') { 
            $video = pdo_get('cyl_vip_video_manage',array('id'=>$video_id));
            $amount = $video['charge']; 
        }
        if($amount < 0.01) {
            message('支付错误, 金额小于0.01'); 
        }        
        if ($_GPC['type'] == 'shang') {        
            
            $data = array(
                'uniacid' => $_W['uniacid'],
                'openid' => $member['openid'],
                'uid' => $member['uid'],
                'tid' => $snid,
                'fee' => $amount,               
                'status' => 0,
                'day' => $day,      
                'time' => TIMESTAMP
            );
            $data['desc'] = '视频打赏';
            $title = '视频打赏';
        }elseif ($_GPC['type'] == 'charge') { 
            $data = array(
                'uniacid' => $_W['uniacid'],
                'openid' => $member['openid'],
                'uid' => $member['uid'],
                'tid' => $snid,
                'fee' => $amount,               
                'video_id' => $video_id,               
                'status' => 0,
                'time' => TIMESTAMP
            );
            $data['desc'] = '视频收费';
            $title = '视频收费';
        }else{
            $data = array(
                'uniacid' => $_W['uniacid'],
                'openid' => $member['openid'],
                'uid' => $member['uid'],
                'tid' => $snid,
                'fee' => $amount,               
                'status' => 0,
                'day' => $day,      
                'time' => TIMESTAMP
            );
            $title = '会员开通';
        }
        if ($setting['member']['site_name']) {
               $data['site_name'] = $setting['member']['site_name']; 
        }
        if ($id) {
            pdo_update('cyl_vip_video_order',$data,array('id'=>$id));
        }else{
            pdo_insert('cyl_vip_video_order',$data);
            $id = pdo_insertid();
        }
        $params = array(
            'id' => $id,
            'tid' => $snid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码20位
            'ordersn' => $snid,  //收银台中显示的订单号
            'title' => $title,          //收银台中显示的标题
            'fee' => $amount,      //收银台中显示需要支付的金额,只能大于 0
            'user' => $member['uid'],     //付款用户, 付款的用户名(选填项) 
        );
        if ($settings['payment'] == 4) {
            $this->codepay($params);
        }elseif ($settings['payment'] == 2) {
            $data = array(
                'mchid'        => $settings['appkey'],
                'body'         => $title,
                'total_fee'    => $amount * 100,
                'out_trade_no' => $snid,
                'hide' => 1, 
                'notify_url'=> $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&do=jspay&m=super_mov',
                'callback_url'=> $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&tid='.$id.'&do=jspayreturn&m=super_mov',
            );
            $key = $settings['secret_key'];
            $data['sign'] = sign($data, $key); 
            $url = 'https://payjs.cn/api/cashier?' . http_build_query($data);
            header("Location:".$url);  
            // exit();
            // $result = ihttp_post($url, $data);
            // $result = json_decode($result['content'],true);
            // $this->pay($result);
        }else{
            $this->pay($params);
        }
        exit(); 
    }
    if ($op == 'share') {
        $acc = WeAccount::create(); 
        $settings = $this->module['config'];
        $member = member($_W['openid']);  
        $uid = $member['uid'];  
        $day = $settings['share_day'];   
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
            'uid' => $uid,
            'time' => TIMESTAMP
        );  
        if ($settings['is_credit'] == 1) {
            $share = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cyl_vip_video_share')." WHERE uniacid = :uniacid AND openid = :openid ", array(':uniacid' => $_W['uniacid'],':openid'=>$_W['openid'])); 
            if ($share >=  $settings['share_click']) {      
                exit();
            } 
        }
        if ($settings['is_credit'] == 2) {
            $share = pdo_fetch("SELECT * FROM ".tablename('cyl_vip_video_share')." WHERE uniacid = :uniacid AND openid = :openid ORDER BY id DESC", array(':uniacid' => $_W['uniacid'],':openid'=>$_W['openid']));
            if (date('Y-m-d') == date('Y-m-d',$share['time'])) {        
                exit();
            } 
        }
        pdo_insert('cyl_vip_video_share',$data);
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $_W['openid'],
            'uid' => $uid,
            'tid' => '分享营销',
            'fee' => $fee,              
            'status' => 1,
            'day' => $day,
            'time' => TIMESTAMP
        );                  
        pdo_insert('cyl_vip_video_order',$data);
        if ($member['end_time']) { 
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('openid' => $data['openid'],'uniacid'=>$data['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time']));
        }else{                      
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('openid' => $data['openid'],'uniacid'=>$data['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
        } 
        if($settings['tpl_id']) {
            $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'].'获得'.$day.'天会员',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员开通',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => '开通提醒',
                    'color' => '#ff510'
                ) ,                    
                'remark' => array(
                    'value' => '到期时间'.$time,
                    'color' => '#ff510'
                ) ,
            );
            $url = link_url('member');
            $acc->sendTplNotice($member['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
            $data = array(
                'first' => array(
                    'value' => $member['nickname'].'恭喜！开通了'.$day.'天会员',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员开通',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => '开通提醒',
                    'color' => '#ff510'
                ) ,                    
                'remark' => array(
                    'value' => '到期时间'.$time.'请进入后台查看',
                    'color' => '#ff510'
                ) ,
            );                  
            $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
        }
        exit();      
    }  
    include $this->template('news/member'); 
} 
public function doMobileTv() {
    global $_W, $_GPC;
    $setting = setting();      
    $setting = $setting['member']; 
    $settings = $this->module['config'];
    if ($settings['ziyuan'] == 2) {
        $type = mac_category();
    }    
    if ($setting) {
        $setting = iunserializer($setting['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    }  
    if ($_GPC['do'] == 'tv' && !$_GPC['eid']) { 
        $modules_bindings = pdo_get('modules_bindings', array('do' => $_GPC['do'],'module'=>$_GPC['m']));        
        $url = $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&eid='.$modules_bindings['eid'];
        if ($_GPC['op']) {
           $url .= '&op='.$_GPC['op'];
        }
        Header("Location: ".$url);
        exit(); 
    }
    if ($settings['is_pc'] == 2 && is_weixin()) {       
        $url = link_url('index'); 
        Header("Location: ".$url);
        exit();  
    }   
    if ($settings['ziyuan'] == 2) {
        $type = mac_category();
    }  
    $url = $_GPC['url'];    
    $response = ihttp_get('http://api.diligulu.cc/iptv/tv_m3u8.xml');
    $xml = $response['content'];
    $data = xml2array($xml);    
    $data = $data['class'];
    $jilu = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video')." WHERE uniacid = :uniacid AND openid = :openid ORDER BY id DESC LIMIT 10", array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));
    $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');        
    include $this->template('tv'); 
}
public function doMobileXiaopin() {
    global $_W, $_GPC;
    $ch = curl_init();
    $setting = setting();
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';
    $setting = $setting['member']; 
    $settings = $this->module['config'];
    if ($settings['ziyuan'] == 2) {
        $type = mac_category();
    }    
    if ($setting) {
        $setting = iunserializer($setting['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    } 
    if ($settings['ziyuan'] == 2) {
        $type = mac_category();
    } 
    if ($op == 'frame') {
        // $url = $_GPC['url'];
        // $url = parse_url($url);
        // $url = 'http://m.v.baidu.com'.$url['path'];

        // $html = ihttp_request($url, '', array('CURLOPT_REFERER' => 'http://m.v.baidu.com'));

        // $html = explode('source: {"mp4":"',$html['content']);
        // $html = explode('","ori',$html['1']);
        // // var_dump($html);
        // $html = $html['0'];
    } 
    if ($op == 'json') {
        $max_cursor = $_GPC['max_cursor'] ? $_GPC['max_cursor'] : 1;
        $list = xiaopin($max_cursor);
        exit(json_encode($list));
    }
    // var_dump($_GPC['do']);    
    include $this->template('news/dy'); 
}
public function doMobileDy(){
    global $_W, $_GPC;
    $settings = $this->module['config']; 
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';
    if ($op == 'frame') {
        $url = $_GPC['url'];
        // $url = 'https://aweme.snssdk.com/aweme/v1/playwm/?video_id=v0200fbd0000bcmt68jrm1nf66mhedb0&line=0';
        // $url = 'https://aweme.snssdk.com/aweme/v1/playwm/?video_id=v0200fbd0000bcmt68jrm1nf66mhedb0&line=0';
        // $data=get_curl($url); 
        // var_dump($data);
    }
    if ($op == 'json') { 
        if($_GPC['action']=='getjs'){
            @header('Content-Type: application/javascript; charset=UTF-8');
            $userid=str_replace('/ 复制此链接，打开【抖音短视频】，直接观看视频！','',$_GPC['userid']);
            if(strpos($userid,'//')!==false){
                $data=get_curl($userid,0,0,0,0,'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1',0,0,1);
                $json=getSubstr($data,"/index').init(",");");
                $json=str_replace('  "  "  "  "','',str_replace("'",'"',str_replace('  "  "  "  "  "  ','',str_replace(':','":',str_replace('  ','  "',$json)))));
                $arr=json_decode($json,true);
                $uid=(string)$arr['uid'];
            }else{
                $uid='70359904504';
            } 
            $data=get_curl('https://www.douyin.com/share/user/'.$uid,0,0,0,0,$_SERVER['HTTP_USER_AGENT'],0,0,1);
            $tac=getSubstr($data,"tac='","'</sc");
            $data=str_replace(array("\n","\r\n","  "),'',$data);
            $dytk=getSubstr($data,"dytk: '","'}");
            $file=str_replace('{$UA}',$_SERVER['HTTP_USER_AGENT'],file_get_contents(MODULE_URL . 'style/js/douyin_fuck.js'));
            $file=str_replace('{$uid}',$uid,$file);
            $file=str_replace('{$tac}',$tac,$file);
            $file=str_replace('{$dytk}',$dytk,$file);
            exit($file);
        }elseif($_GPC['action']=='getlist'){
            $uid=$_GPC['uid'];
            $dytk=$_GPC['dytk'];           
            $max_cursor = $_GPC['max_cursor'] ? $_GPC['max_cursor'] : 0;        
            $signature=$_GPC['signature'];
            $ua=$_SERVER['HTTP_USER_AGENT'];
            $data=get_curl('https://www.iesdouyin.com/aweme/v1/aweme/favorite/?user_id='.$uid.'&count=20&max_cursor='.$max_cursor.'&aid=1128&_signature='.$signature.'&dytk='.$dytk,0,0,0,0,$ua);
            // var_dump($data);
            $arr=json_decode($data,true);

            if($arr['aweme_list']){
                $code=0;
                $msg='获取成功';
            }else{
                $code=1;
                $msg='请求失败';
            }
            $list = array('code'=>$code,'data'=>$arr['aweme_list'],'max_cursor'=>$arr['max_cursor'],'has_more'=>$arr['has_more'],'msg'=>$msg,'url'=>'http://www.iesdouyin.com/aweme/v1/aweme/favorite/?user_id='.$uid.'&count=20&max_cursor='.$max_cursor.'&aid=1128&_signature='.$signature.'&dytk='.$dytk,'uid'=>$uid);
            // var_dump($list);
            exit(json_encode($list));
            // include $this->template('news/dy');
        } 
        // exit();
    }    
    include $this->template('news/dy');  
}
public function doMobileBoxoffice(){
    global $_W, $_GPC;
    $settings = $this->module['config']; 
    $jilu = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video')." WHERE uniacid = :uniacid AND openid = :openid ORDER BY id DESC LIMIT 10", array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));
     $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');      
    load()->func('communication'); 
    $data = ihttp_request('https://box.maoyan.com/promovie/api/box/second.json');
    $data = json_decode($data['content'],true); 
    $data = $data['data']; 
    include $this->template('news/boxoffice');  
}
public function doMobilePartner() {
    global $_W, $_GPC;
    $uniacid = pdo_get('account_wechats');
    $order =  pdo_get('cyl_vip_video_order',array('tid'=>$_GPC['out_trade_no']));
    $settings = pdo_get('uni_account_modules',array('uniacid'=>$order['uniacid'],'module'=>'super_mov'));
    $settings = iunserializer($settings['settings']); 
    $key = $settings['shop_key'];
    $data = array(
        'uniacid'=>$uniacid['uniacid'],
        'key'=>$key,
    ); 
    return json_encode($data);
}  

public function Codepay($params) {
    global $_W, $_GPC;
    $settings = $this->module['config'];
    $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE tid = :tid", array(
        ':tid' => $params['tid']
    ));
    $codepay_id =  $settings['codepay_appid'];//这里改成码支付ID
    $codepay_key = $settings['codepay_appkey']; //这是您的通讯密钥    
    $data = array(
        "id" => $codepay_id,//你的码支付ID
        "pay_id" => $order['tid'], //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
        "type" => 3,//1支付宝支付 3微信支付 2QQ钱包
        "price" => $order['fee'],//金额100元
        "param" => "",//自定义参数
        "notify_url"=>$_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&do=codepaynotify_url&m=super_mov',//通知地址 
        "return_url"=>$_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&do=codepayreturn&m=super_mov&tid='.$order['id'],//跳转地址
    ); //构造需要传递的参数

    ksort($data); //重新排序$data数组
    reset($data); //内部指针指向数组中的第一个元素
    $sign = ''; //初始化需要签名的字符为空
    $urls = ''; //初始化URL参数为空

    foreach ($data AS $key => $val) { //遍历需要传递的参数
        if ($val == ''||$key == 'sign') continue; //跳过这些不参数签名
        if ($sign != '') { //后面追加&拼接URL
            $sign .= "&";
            $urls .= "&";
        }
        $sign .= "$key=$val"; //拼接为url参数形式
        $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

    }
    $query = $urls . '&sign=' . md5($sign .$codepay_key); //创建订单所需的参数
    $url = "http://api2.fateqq.com:52888/creat_order/?".$query; //支付页面
    header("Location:".$url);  
}
public function doMobileJspay() {
    global $_W, $_GPC;
    $settings = $this->module['config'];
    $acc = WeAccount::create(); 
    $key = $settings['secret_key'];   
    $data = [
        'payjs_order_id' => $_GPC['payjs_order_id'],
    ];
    // 添加数据签名
    $data['sign'] = sign($data, $key);  
    $url = 'https://payjs.cn/api/check?' . http_build_query($data);
    $result = ihttp_post($url, $data);
    $result = json_decode($result['content'],true);
    $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE tid = :tid", array(
        ':tid' => $result['out_trade_no']
    ));
    if ($order['status'] == 1) {
    	exit('已支付');
    }
    if ($result['status'] != 1) {
    	exit('还未支付');
    }
    if ($_GPC['return_code'] == 1 && $result['status'] == 1) {            
            $member = pdo_get('cyl_vip_video_member', array('openid' => $order['openid'],'uniacid'=>$order['uniacid'])); 
            $setting = setting();
            //根据参数params中的result来判断支付是否成功
            pdo_update('cyl_vip_video_order', array('status'=>1), array('tid' => $order['tid']));  
            if ($member['end_time']) {  
                $day = $order['day'];               
                pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
                $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time']));
            }else{
                $day = $order['day'];
                pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
                $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
            }  
            if($_W['account']['level'] == 4 && $settings['tpl_id']) {
                if ($order['desc']) {
                    $data = array(
                        'first' => array(
                            'value' => '您好,'.$member['nickname'],
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => '感谢打赏'.$order['desc'],
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => $order['fee'],
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',$order['time']),
                            'color' => '#ff510'
                        ) ,                 
                        'remark' => array(
                            'value' => $order['desc'],  
                            'color' => '#ff510'
                        ) ,
                    );
                    $url = link_url('member');
                    $acc->sendTplNotice($order['openid'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                    $data = array(
                        'first' => array(
                            'value' => $member['nickname'].$order['desc'],
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => '感谢打赏',
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => $order['fee'],
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',$order['time']),
                            'color' => '#ff510'
                        ) ,                    
                        'remark' => array(
                            'value' => $order['desc'].'金额【'.$order['fee'].'】元，请进入后台查看',
                            'color' => '#ff510'
                        ) ,
                    );
                    $acc->sendTplNotice($settings['kf_id'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                }else{
                    $data = array(
                        'first' => array(
                            'value' => '您好,'.$member['nickname'],
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => $params['tid'],
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => '支付成功',
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',$order['time']),
                            'color' => '#ff510'
                        ) ,    
                        'keyword4' => array(
                            'value' => $_W['uniaccount']['name'],
                            'color' => '#ff510'
                        ) ,  
                        'keyword5' => array(
                            'value' => $order['fee'],
                            'color' => '#ff510'
                        ) ,              
                        'remark' => array(
                            'value' => '到期时间：'.$time,
                            'color' => '#ff510'
                        ) ,
                    ); 
                    $url = link_url('member');
                    $acc->sendTplNotice($order['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                    $data = array(
                        'first' => array(
                            'value' => $member['nickname'].'开通了'.$day.'天会员',
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => $params['tid'],
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => '支付成功',
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',$order['time']),
                            'color' => '#ff510'
                        ) ,    
                        'keyword4' => array(
                            'value' => $_W['uniaccount']['name'],
                            'color' => '#ff510'
                        ) ,  
                        'keyword5' => array(
                            'value' => $order['fee'],
                            'color' => '#ff510'
                        ) ,              
                        'remark' => array(
                            'value' => '会员到期时间'.$time.'请进入后台查看',
                            'color' => '#ff510'
                        ) ,
                    );
                    $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                } 
                exit('success');
            }
    }
          
} 
public function doMobileJspayreturn(){
    global $_W, $_GPC;
    // $id = $_GPC['tid'];
    message('您已支付成功！', link_url('member').'&site_name='.$order['site_name'] , 'success');
}
public function doMobileCodepaynotify_url() { 
    global $_W, $_GPC;
    $settings = $this->module['config'];
    ksort($_POST); //排序post参数
    reset($_POST); //内部指针指向数组中的第一个元素
    // var_dump($_GET);
    $codepay_key = $settings['codepay_appkey']; //这是您的密钥
    $sign = '';//初始化
    foreach ($_POST AS $key => $val) { //遍历POST参数
        if ($val == '' || $key == 'sign') continue; //跳过这些不签名
        if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
        $sign .= "$key=$val"; //拼接为url参数形式
    }
    if (!$_POST['pay_no'] || md5($sign . $codepay_key) != $_POST['sign']) { //不合法的数据
        exit('fail');  //返回失败 继续补单
    } else { //合法的数据
        //业务处理
        $pay_id = $_POST['pay_id']; //需要充值的ID 或订单号 或用户名
        $money = (float)$_POST['money']; //实际付款金额
        $price = (float)$_POST['price']; //订单的原价
        $param = $_POST['param']; //自定义参数
        $pay_no = $_POST['pay_no']; //流水号
        $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE tid = :tid", array(
            ':tid' => $pay_id
        ));
        $acc = WeAccount::create();
        $member = pdo_get('cyl_vip_video_member', array('openid' => $order['openid'],'uniacid'=>$order['uniacid']));
         //实例化消息类对象     
        $setting = setting();
        //根据参数params中的result来判断支付是否成功                
        pdo_update('cyl_vip_video_order', array('status'=>1), array('tid' => $order['tid']));  
        if ($member['end_time']) {  
            $day = $order['day'];               
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time']));
        }else{
            $day = $order['day'];
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
        }  
        if($_W['account']['level'] == 4 && $settings['tpl_id']) {
            if ($order['desc']) {
                $data = array(
                    'first' => array(
                        'value' => '您好,'.$member['nickname'],
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => '感谢打赏'.$order['desc'],
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => $order['fee'],
                        'color' => '#ff510'
                    ) ,   
                    'keyword3' => array(
                        'value' => date('Y-m-d H:i:s',$order['time']),
                        'color' => '#ff510'
                    ) ,                 
                    'remark' => array(
                        'value' => $order['desc'],  
                        'color' => '#ff510'
                    ) ,
                );
                $url = link_url('member');
                $acc->sendTplNotice($order['openid'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                $data = array(
                    'first' => array(
                        'value' => $member['nickname'].$order['desc'],
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => '感谢打赏',
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => $order['fee'],
                        'color' => '#ff510'
                    ) ,   
                    'keyword3' => array(
                        'value' => date('Y-m-d H:i:s',$order['time']),
                        'color' => '#ff510'
                    ) ,                    
                    'remark' => array(
                        'value' => $order['desc'].'金额【'.$order['fee'].'】元，请进入后台查看',
                        'color' => '#ff510'
                    ) ,
                );
                $acc->sendTplNotice($settings['kf_id'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
            }else{
                $data = array(
                    'first' => array(
                        'value' => '您好,'.$member['nickname'],
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => $params['tid'],
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => '支付成功',
                        'color' => '#ff510'
                    ) ,   
                    'keyword3' => array(
                        'value' => date('Y-m-d H:i:s',$order['time']),
                        'color' => '#ff510'
                    ) ,    
                    'keyword4' => array(
                        'value' => $_W['uniaccount']['name'],
                        'color' => '#ff510'
                    ) ,  
                    'keyword5' => array(
                        'value' => $order['fee'],
                        'color' => '#ff510'
                    ) ,              
                    'remark' => array(
                        'value' => '到期时间：'.$time,
                        'color' => '#ff510'
                    ) ,
                ); 
                $url = link_url('member');
                $acc->sendTplNotice($order['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                $data = array(
                    'first' => array(
                        'value' => $member['nickname'].'开通了'.$day.'天会员',
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => $params['tid'],
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => '支付成功',
                        'color' => '#ff510'
                    ) ,   
                    'keyword3' => array(
                        'value' => date('Y-m-d H:i:s',$order['time']),
                        'color' => '#ff510'
                    ) ,    
                    'keyword4' => array(
                        'value' => $_W['uniaccount']['name'],
                        'color' => '#ff510'
                    ) ,  
                    'keyword5' => array(
                        'value' => $order['fee'],
                        'color' => '#ff510'
                    ) ,              
                    'remark' => array(
                        'value' => '会员到期时间'.$time.'请进入后台查看',
                        'color' => '#ff510'
                    ) ,
                );
                $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
            }            
           
        }
        exit('success'); //返回成功 不要删除哦
    }
}
public function doMobileCodepayreturn() { 
    global $_W, $_GPC;
    $id = $_GPC['tid'];
    $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE id = :id", array(
        ':id' => $id
    ));
    if ($order['status'] == 1) {
       message('您已支付成功！', link_url('member').'&site_name='.$order['site_name'] , 'success');  
    }else{
       message('支付失败','','error');
    }
}
public function doMobileGerenpay() {
    global $_W, $_GPC;
    $settings = $this->module['config']; 
    $op = $_GPC['op'] ? $_GPC['op'] : 'pay';
    if ($op == 'return') {
        $acc = WeAccount::create(); 
        $tid = $_GPC['orderid'];
        $order_id = $_GPC['orderid']; 
        $order = pdo_get('cyl_vip_video_order', array('uniacid'=>$_W['uniacid'],'tid'=>$tid)); 
        if ($order['status'] == 1) {
            message('订单已经支付过了','','error');
        }
        pdo_update('cyl_vip_video_order', array('status'=>1), array('tid' => $tid));
        $openid = $order['openid'];
        $member = member($openid);
        if ($member['end_time']) {  
            $day = $order['day'];               
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time'])); 
        }else{
            $day = $order['day'];
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
        } 
        if($_W['account']['level'] == 4 && $settings['tpl_id']) {
                    if ($order['desc']) {
                        $data = array(
                            'first' => array(
                                'value' => '您好,'.$member['nickname'],
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => '感谢打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,                 
                            'remark' => array(
                                'value' => '感谢您的打赏！', 
                                'color' => '#ff510'
                            ) ,
                        );
                        $url = link_url('member');
                        $acc->sendTplNotice($order['openid'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                        $data = array(
                            'first' => array(
                                'value' => $member['nickname'].'打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => '感谢打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,                    
                            'remark' => array(
                                'value' => '打赏金额【'.$order['fee'].'】元，请进入后台查看',
                                'color' => '#ff510'
                            ) ,
                        );
                        $acc->sendTplNotice($settings['kf_id'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                    }else{
                        $data = array(
                            'first' => array(
                                'value' => '您好,'.$member['nickname'],
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => $params['tid'],
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => '支付成功',
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,    
                            'keyword4' => array(
                                'value' => $_W['uniaccount']['name'],
                                'color' => '#ff510'
                            ) ,  
                            'keyword5' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,              
                            'remark' => array(
                                'value' => '到期时间：'.$time.'',
                                'color' => '#ff510'
                            ) ,
                        ); 
                        $url = link_url('member');
                        $acc->sendTplNotice($order['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                        $data = array(
                            'first' => array(
                                'value' => $member['nickname'].'开通了'.$day.'天会员',
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => $params['tid'],
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => '支付成功',
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,    
                            'keyword4' => array(
                                'value' => $_W['uniaccount']['name'],
                                'color' => '#ff510'
                            ) ,  
                            'keyword5' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,              
                            'remark' => array(
                                'value' => '会员到期时间'.$time.'请进入后台查看',
                                'color' => '#ff510'
                            ) ,
                        );
                        $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');   
                    }
                } 
                if ($_W['os'] == 'windows' && !is_weixin()) {
                    $url = $_W['siteroot'] . 'app/index.php?i='.$order['uniacid'].'&c=entry&do=index&m=cyl_video_pc';
                    message('您已支付成功！', $url , 'success'); 
                }
                message('您已支付成功！', link_url('member') , 'success');
    }
    
}
public function doMobileBlypay(){
    global $_W, $_GPC;
    $op = $_GPC['op'] ? $_GPC['op'] : 'pay';
    $settings = $this->module['config']; 

    if ($op == 'pay') {
        if ($settings['payment'] == 2) {
            require_once(IA_ROOT . "/addons/super_mov/sdk/lib/epay_submit.class.php");
            $alipay_config['partner']       = $settings['shop_id'];
            //商户KEY
            $alipay_config['key']           = $settings['shop_key'];
            //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
            //签名方式 不需修改
            $alipay_config['sign_type']    = strtoupper('MD5');
            //字符编码格式 目前支持 gbk 或 utf-8
            $alipay_config['input_charset']= strtolower('utf-8');
            //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
            $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';
            $alipay_config['transport']    = $http_type;
            //支付API地址
            $alipay_config['apiurl']    = 'https://pay.blyzf.cn/';
            $notify_url =  $_W['siteroot'] . 'addons/super_mov/sdk/notify_url.php'; 
            //需http://格式的完整路径，不能加?id=123这类自定义参数
            //页面跳转同步通知页面路径
            $return_url = $_W['siteroot'] . 'addons/super_mov/sdk/return_url.php'; 
            //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        }
        if ($settings['payment'] == 3) {
            require_once(IA_ROOT . "/addons/super_mov/caihong/lib/epay_submit.class.php");
            $alipay_config['partner']       = $settings['caihong_id'];
            //商户KEY
            $alipay_config['key']           = $settings['caihong_key'];
            //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
            //签名方式 不需修改
            $alipay_config['sign_type']    = strtoupper('MD5');
            //字符编码格式 目前支持 gbk 或 utf-8
            $alipay_config['input_charset']= strtolower('utf-8');
            //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
            $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';
            $alipay_config['transport']    = $http_type;
            //支付API地址
            $alipay_config['apiurl']    = 'https://pay.v8jisu.cn/';
            $notify_url =  $_W['siteroot'] . 'addons/super_mov/caihong/notify_url.php'; 
            //需http://格式的完整路径，不能加?id=123这类自定义参数
            //页面跳转同步通知页面路径
            $return_url = $_W['siteroot'] . 'addons/super_mov/caihong/return_url.php'; 
            //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        } 
        
        //商户订单号
        $out_trade_no = $_GPC['WIDout_trade_no'];
        //商户网站订单系统中唯一订单号，必填
        //支付方式
        $type = $_GPC['type'];
        //商品名称
        $name = $_GPC['WIDsubject'];
        //付款金额
        $money = $_GPC['WIDtotal_fee'];
        //站点名称
        $sitename = $_W['account']['name'];
        $parameter = array(
            "pid" => trim($alipay_config['partner']),
            "uniacid" => $_W['uniacid'],
            "type" => $type,
            "notify_url"    => $notify_url,
            "return_url"    => $return_url,
            "out_trade_no"  => $out_trade_no,
            "name"  => $name,
            "money" => $money,
            "sitename"  => $sitename
        );
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter);
        echo $html_text;
        exit();
    }
    if ($op == 'return') {
        $acc = WeAccount::create(); 
        $tid = $_GPC['tid'];
        $order_id = $_GPC['order_id']; 
        $order = pdo_get('cyl_vip_video_order', array('uniacid'=>$_W['uniacid'],'tid'=>$tid)); 
        if ($order['status'] == 1) {
            message('订单已经支付过了','','error');
        }
        pdo_update('cyl_vip_video_order', array('status'=>1), array('tid' => $tid));
        $openid = $order['openid'];
        $member = member($openid);
        if ($member['end_time']) {  
            $day = $order['day'];               
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time'])); 
        }else{
            $day = $order['day'];
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
        } 
        if($_W['account']['level'] == 4 && $settings['tpl_id']) {
                    if ($order['desc']) {
                        $data = array(
                            'first' => array(
                                'value' => '您好,'.$member['nickname'],
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => '感谢打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,                 
                            'remark' => array(
                                'value' => '感谢您的打赏！', 
                                'color' => '#ff510'
                            ) ,
                        );
                        $url = link_url('member');
                        $acc->sendTplNotice($order['openid'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                        $data = array(
                            'first' => array(
                                'value' => $member['nickname'].'打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => '感谢打赏',
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,                    
                            'remark' => array(
                                'value' => '打赏金额【'.$order['fee'].'】元，请进入后台查看',
                                'color' => '#ff510'
                            ) ,
                        );
                        $acc->sendTplNotice($settings['kf_id'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                    }else{
                        $data = array(
                            'first' => array(
                                'value' => '您好,'.$member['nickname'],
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => $params['tid'],
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => '支付成功',
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,    
                            'keyword4' => array(
                                'value' => $_W['uniaccount']['name'],
                                'color' => '#ff510'
                            ) ,  
                            'keyword5' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,              
                            'remark' => array(
                                'value' => '到期时间：'.$time.'',
                                'color' => '#ff510'
                            ) ,
                        ); 
                        $url = link_url('member');
                        $acc->sendTplNotice($order['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                        $data = array(
                            'first' => array(
                                'value' => $member['nickname'].'开通了'.$day.'天会员',
                                'color' => '#ff510'
                            ) ,
                            'keyword1' => array(
                                'value' => $params['tid'],
                                'color' => '#ff510'
                            ) ,
                            'keyword2' => array(
                                'value' => '支付成功',
                                'color' => '#ff510'
                            ) ,   
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s',$order['time']),
                                'color' => '#ff510'
                            ) ,    
                            'keyword4' => array(
                                'value' => $_W['uniaccount']['name'],
                                'color' => '#ff510'
                            ) ,  
                            'keyword5' => array(
                                'value' => $order['fee'],
                                'color' => '#ff510'
                            ) ,              
                            'remark' => array(
                                'value' => '会员到期时间'.$time.'请进入后台查看',
                                'color' => '#ff510'
                            ) ,
                        );
                        $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');   
                    }
                } 
                if ($_W['os'] == 'windows' && !is_weixin()) {
                    $url = $_W['siteroot'] . 'app/index.php?i='.$order['uniacid'].'&c=entry&do=index&m=cyl_video_pc';
                    message('您已支付成功！', $url , 'success'); 
                }
                message('您已支付成功！', link_url('member') , 'success');
    }
}
// protected function pay($params = array() , $mine = array()) {
//     global $_W;
//     $settings = $this->module['config'];
//     $params['module'] = $this->module['name'];
//     $sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
//     $pars = array();
//     $pars[':uniacid'] = $_W['uniacid'];
//     $pars[':module'] = $params['module'];
//     $pars[':tid'] = $params['tid'];
//     $log = pdo_fetch($sql, $pars);
//     if(!empty($log) && $log['status'] == '1') {
//         itoast('这个订单已经支付成功, 不需要重复支付.', '', 'info');
//     }
//     $setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
//     if(!is_array($setting['payment'])) {
//         itoast('没有有效的支付方式, 请联系网站管理员.', '', 'error');
//     }
//     $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
//     if (empty($log)) {
//         $log = array(
//             'uniacid' => $_W['uniacid'],
//             'acid' => $_W['acid'],
//             'openid' => $_W['member']['uid'],
//             'module' => $this->module['name'],              'tid' => $params['tid'],
//             'fee' => $params['fee'],
//             'card_fee' => $params['fee'],
//             'status' => '0',
//             'is_usecard' => '0',
//         );
//         pdo_insert('core_paylog', $log);
//     } 
//     $pay = $setting['payment'];
//     foreach ($pay as &$value) {
//         $value['switch'] = $value['pay_switch'];
//     }
//     if (!is_weixin() && $settings['weixin_h5'] != 1 ) {  
//         $pays = $params['fee']; //获取需要支付的价格
//         #插入语句书写的地方
//         $conf = $this->payconfig($params['tid'], $pays * 100, '会员开通');
//         if (!$conf || $conf['return_code'] == 'FAIL')
//            exit("<script>alert('对不起，微信支付接口调用错误!" . $conf['return_msg'] . "');history.go(-1);</script>");
//         $conf['mweb_url'] = $conf['mweb_url'] . '&redirect_url=' . urlencode($this->wxpay['notify_url'].'&tid='.$params['tid'].'&order_id='.$params['id']); 
//         $url = $conf['mweb_url']; 
//     }else{
//         unset($value);
//         $pay['credit']['switch'] = false;
//         $pay['delivery']['switch'] = false;     
//         $url = url('mc/cash/wechat', array('params' => base64_encode(json_encode($params))));
//         header("Location: $url"); 
//         exit();
//     }
// }
// public function doMobilePay() {
//  global $_GPC,$_W;
//     $_W['page']['title'] = '会员支付';
//     $acc = WeAccount::create();  
//     $settings = $this->module['config'];
//     $member = member($_W['openid']);
//     $card = iunserializer($settings['card']);
//     foreach ($card as $value) {
//         $card_day = $value['card_day'];
//         $new_card[$card_day] = array(
//             'card_day' => $value['card_day'],
//             'card_fee' => $value['card_fee'],
//         );
//     }
//     $day = $_GPC['day'];
//     $id = $_GPC['id'];  
//     if (is_weixin()) {
//        if(empty($member['openid'])){message('非法进入');}  
//     }   
//     $new_card = $new_card[$day]; 
//     if ($new_card) {
//         $amount = $new_card['card_fee'];     
//     }else{
//         $amount = $settings['fee']*$day;
//     }     
//     if ($id) {
//         $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE id = :id", array(':id' => $id));
//         if ($member['openid'] != $order['openid']) {
//             message('非法进入');
//         }
//         $day = $order['day'];
//         $snid = $order['tid'];
//         $amount = $order['fee'];     
//     }else{
//         $snid = date('YmdHis') . str_pad(mt_rand(1, 99999),6, '0', STR_PAD_LEFT);
//     }   
//     if ($_GPC['type'] == 'shang') {
//         $amount = $_GPC['fee']; 
//     }
//     if($amount < 0.01) {
//         message('支付错误, 金额小于0.01');
//     }
//     $data = array(
//         'uniacid' => $_W['uniacid'],
//         'openid' => $member['openid'],
//         'uid' => $member['uid'],
//         'tid' => $snid,
//         'fee' => $amount,               
//         'status' => 0,
//         'day' => $day,      
//         'time' => TIMESTAMP
//     );
//     if ($_GPC['type'] == 'shang') {       
        
//         $data = array(
//             'uniacid' => $_W['uniacid'],
//             'openid' => $member['openid'],
//             'uid' => $member['uid'],
//             'tid' => $snid,
//             'fee' => $amount,               
//             'status' => 0,
//             'day' => $day,      
//             'time' => TIMESTAMP
//         );
//         $data['desc'] = '视频打赏';
//     }
//     if ($id) {
//         pdo_update('cyl_vip_video_order',$data,array('id'=>$id));
//     }else{
//         pdo_insert('cyl_vip_video_order',$data);
//         $id = pdo_insertid();
//     }       
//     if ($_GPC['op'] == 'shang') { 
//         $params = array(
//             'tid' => $snid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码20位
//             'ordersn' => 'SN'.$snid,  //收银台中显示的订单号
//             'title' => '视频打赏',          //收银台中显示的标题
//             'fee' => $amount,      //收银台中显示需要支付的金额,只能大于 0
//             'user' => $member['uid'],     //付款用户, 付款的用户名(选填项)
//         );      
//     }else{
//         $params = array(
//             'id' => $id,
//             'tid' => $snid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码20位
//             'ordersn' => 'SN'.$snid,  //收银台中显示的订单号
//             'title' => '开通会员',          //收银台中显示的标题
//             'fee' => $amount,      //收银台中显示需要支付的金额,只能大于 0
//             'user' => $member['uid'],     //付款用户, 付款的用户名(选填项)
//         );      
//     }
//     $this->pay($params); 
// }
public function payResult($params) {
    //一些业务代码
    global $_W, $_GPC;        
    $acc = WeAccount::create();       
    $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE tid = :tid", array(
        ':tid' => $params['tid']
    ));
    $member = pdo_get('cyl_vip_video_member', array('openid' => $order['openid'],'uniacid'=>$order['uniacid'])); 
     //实例化消息类对象         
    $settings = $this->module['config'];
    $setting = setting();
    //根据参数params中的result来判断支付是否成功
    if ($params['result'] == 'success' && $params['from'] == 'notify') {            
            pdo_update('cyl_vip_video_order', array('status'=>1), array('tid' => $order['tid']));  
            if ($member['end_time']) {  
                $day = $order['day'];               
                pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
                $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time']));
            }else{
                $day = $order['day'];
                pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$order['uniacid']));
                $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
            }  
            if($_W['account']['level'] == 4 && $settings['tpl_id']) {
                if ($order['desc']) {
                    $data = array(
                        'first' => array(
                            'value' => '您好,'.$member['nickname'],
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => '感谢打赏'.$order['desc'],
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => $order['fee'],
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',$order['time']),
                            'color' => '#ff510'
                        ) ,                 
                        'remark' => array(
                            'value' => $order['desc'],  
                            'color' => '#ff510'
                        ) ,
                    );
                    $url = link_url('member');
                    $acc->sendTplNotice($order['openid'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                    $data = array(
                        'first' => array(
                            'value' => $member['nickname'].$order['desc'],
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => '感谢打赏',
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => $order['fee'],
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',$order['time']),
                            'color' => '#ff510'
                        ) ,                    
                        'remark' => array(
                            'value' => $order['desc'].'金额【'.$order['fee'].'】元，请进入后台查看',
                            'color' => '#ff510'
                        ) ,
                    );
                    $acc->sendTplNotice($settings['kf_id'], $settings['exceptional_id'], $data, $url, $topcolor = '#FF683F');
                }else{
                    $data = array(
                        'first' => array(
                            'value' => '您好,'.$member['nickname'],
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => $params['tid'],
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => '支付成功',
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',$order['time']),
                            'color' => '#ff510'
                        ) ,    
                        'keyword4' => array(
                            'value' => $_W['uniaccount']['name'],
                            'color' => '#ff510'
                        ) ,  
                        'keyword5' => array(
                            'value' => $order['fee'],
                            'color' => '#ff510'
                        ) ,              
                        'remark' => array(
                            'value' => '到期时间：'.$time,
                            'color' => '#ff510'
                        ) ,
                    ); 
                    $url = link_url('member');
                    $acc->sendTplNotice($order['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                    $data = array(
                        'first' => array(
                            'value' => $member['nickname'].'开通了'.$day.'天会员',
                            'color' => '#ff510'
                        ) ,
                        'keyword1' => array(
                            'value' => $params['tid'],
                            'color' => '#ff510'
                        ) ,
                        'keyword2' => array(
                            'value' => '支付成功',
                            'color' => '#ff510'
                        ) ,   
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s',$order['time']),
                            'color' => '#ff510'
                        ) ,    
                        'keyword4' => array(
                            'value' => $_W['uniaccount']['name'],
                            'color' => '#ff510'
                        ) ,  
                        'keyword5' => array(
                            'value' => $order['fee'],
                            'color' => '#ff510'
                        ) ,              
                        'remark' => array(
                            'value' => '会员到期时间'.$time.'请进入后台查看',
                            'color' => '#ff510'
                        ) ,
                    );
                    $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                }            
               
            }
    }
    if (empty($params['result']) || $params['result'] != 'success') {
        //此处会处理一些支付失败的业务代码
    }
    //因为支付完成通知有两种方式 notify，return,notify为后台通知,return为前台通知，需要给用户展示提示信息
    //return做为通知是不稳定的，用户很可能直接关闭页面，所以状态变更以notify为准
    //如果消息是用户直接返回（非通知），则提示一个付款成功
    if ($params['from'] == 'return') {
        if ($params['result'] == 'success') {
            message('您已支付成功！', link_url('member',array('site_name'=>$order['site_name'])) , 'success');  
        }else {
            message('支付失败！', 'error');
        }
    }
}
public function doWebManage() {
    global $_W, $_GPC; 
    $acc = WeAccount::create();
    $settings = $this->module['config'];    
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';           
    $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':status'=>0), 'id'); 
    $parent = array();
    $children = array(); 
    if (!empty($category)) {
        $children = '';
        foreach ($category as $cid => $cate) {
            if (!empty($cate['parentid'])) {
                $children[$cate['parentid']] = $cate;
            } else {
                $parent[$cate['id']] = $cate;
            }
        }
    } 
    if ($op == 'list') {
        $pageindex = max(intval($_GPC['page']), 1); // 当前页码
        $pagesize = 20; // 设置分页大小
        $starttime = empty($_GPC['time']['start']) ? strtotime('-180 days') : strtotime($_GPC['time']['start']);
        $endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 86399 : strtotime($_GPC['time']['end']) + 86399;
        $where = ' WHERE uniacid = :uniacid AND time >= :starttime AND time <= :endtime';
        $params = array(
            ':uniacid'=>$_W['uniacid'],
            ':starttime' => $starttime,
            ':endtime' => $endtime
        );
        if ($_GPC['keyword']) {
            $where .= ' AND title LIKE :keyword OR title = :keyword '; 
            $params[':keyword'] = "%{$_GPC['keyword']}%";
        }
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_manage') . $where , $params);
        $pager = pagination($total, $pageindex, $pagesize);
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY sort DESC , time DESC , id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;          
        $list = pdo_fetchall($sql, $params, 'id');          
    }
    if ($op == 'record') {
        $pageindex = max(intval($_GPC['page']), 1); // 当前页码
        $pagesize = 20; // 设置分页大小
        $starttime = empty($_GPC['time']['start']) ? strtotime('-90 days') : strtotime($_GPC['time']['start']);
        $endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 86399 : strtotime($_GPC['time']['end']) + 86399;
        $where = ' WHERE uniacid = :uniacid AND time >= :starttime AND time <= :endtime AND length(title) <> 0 ';
        $params = array(
            ':uniacid'=>$_W['uniacid'],
            ':starttime' => $starttime,
            ':endtime' => $endtime
        );

        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video') . $where .' GROUP BY video_url ' , $params);
        $pager = pagination($total, $pageindex, $pagesize);
        $sql = ' SELECT *,count(video_url) as num FROM '.tablename('cyl_vip_video').$where.' GROUP BY video_url ORDER BY num DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize; 
        $list = pdo_fetchall($sql, $params, 'id');          
    }
    if ($op == 'single') {
        $pageindex = max(intval($_GPC['page']), 1); // 当前页码
        $pagesize = 20; // 设置分页大小
        $starttime = empty($_GPC['time']['start']) ? strtotime('-90 days') : strtotime($_GPC['time']['start']);
        $endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 86399 : strtotime($_GPC['time']['end']) + 86399;
        $where = ' WHERE uniacid = :uniacid AND time >= :starttime AND time <= :endtime AND length(title) <> 0 ';
        $params = array(
            ':uniacid'=>$_W['uniacid'],
            ':starttime' => $starttime,
            ':endtime' => $endtime
        );

        if ($_GET['openid']) {
            $where .= ' AND openid = :openid ';
            $params[':openid'] = $_GET['openid'];
        }       
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video') . $where , $params);
        $pager = pagination($total, $pageindex, $pagesize);
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video') . $where . ' ORDER BY id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;         
        $list = pdo_fetchall($sql, $params, 'id');
    }
    if ($op == 'comment') {
        $pageindex = max(intval($_GPC['page']), 1); // 当前页码
        $pagesize = 20; // 设置分页大小
        $starttime = empty($_GPC['time']['start']) ? strtotime('-90 days') : strtotime($_GPC['time']['start']);
        $endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 86399 : strtotime($_GPC['time']['end']) + 86399;
        $where = ' WHERE uniacid = :uniacid AND time >= :starttime AND time <= :endtime ';
        $params = array(
            ':uniacid'=>$_W['uniacid'],
            ':starttime' => $starttime,
            ':endtime' => $endtime
        );
        if ($_GPC['openid']) {
            $where .= ' AND openid = :openid ';
            $params[':openid'] = $_GPC['openid'];
        }
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_message') . $where , $params);
        $pager = pagination($total, $pageindex, $pagesize);
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video_message').$where.' ORDER BY id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;         
        $list = pdo_fetchall($sql, $params, 'id');          
    }
    if ($op == 'forum') {
        $pageindex = max(intval($_GPC['page']), 1); // 当前页码
        $pagesize = 20; // 设置分页大小
        $starttime = empty($_GPC['time']['start']) ? strtotime('-90 days') : strtotime($_GPC['time']['start']);
        $endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 86399 : strtotime($_GPC['time']['end']) + 86399;
        $where = ' WHERE uniacid = :uniacid AND time >= :starttime AND time <= :endtime ';
        $params = array(
            ':uniacid'=>$_W['uniacid'],
            ':starttime' => $starttime,
            ':endtime' => $endtime
        );
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_forum') . $where , $params);
        $pager = pagination($total, $pageindex, $pagesize);
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video_forum').$where.' ORDER BY id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;         
        $list = pdo_fetchall($sql, $params, 'id');          
    }
    if ($op == 'forum_huifu') {
        $id = $_GPC['id'];
        $forum = pdo_get('cyl_vip_video_forum', array('id' => $id));
        $member = member($forum['openid']);
        if (checksubmit()) {
            $res = pdo_update('cyl_vip_video_forum', array('video_url'=>$_GPC['video_url']) , array('id'=>$id));
            if ($res) {
                $data = array(
                    'first' => array(
                        'value' => '您好,'.$member['nickname'],
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => '您求的片子已经找到',
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => '求片提醒',
                        'color' => '#ff510'
                    ) ,                    
                    'remark' => array(
                        'value' => '感谢支持,点击详情直接观看', 
                        'color' => '#ff510'
                    ) ,
                );
                $url = $_GPC['video_url'];
                $acc->sendTplNotice($forum['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                message('发送成功',$this->createWebUrl('manage',array('op'=>'forum')),'success');
            }
        }
    }
    if ($op == 'forum_del') {
        $id = $_GPC['id'];
        $res = pdo_delete('cyl_vip_video_forum', array('id'=>$id));
        if($res){
            message('删除成功！',$this->createWebUrl('manage',array('op'=>'forum')),'success');
        }
    } 
    if ($op == 'clean') {
        $result = pdo_query("TRUNCATE ".tablename('cyl_vip_video'));
        message('清理成功！',$this->createWebUrl('manage'),'success');
    }
    if ($op == 'add') {
        $id = $_GPC['id'];
        if ($id) {              
            $item = pdo_get('cyl_vip_video_manage', array('id'=>$id)); 
            $pcate = $item['cid'];
            $ccate = $item['pid'];
        }               
        if (checksubmit()) {
            $data = $_GPC['data'];
            $data['cid'] = intval($_GPC['category']['parentid']);
            $data['pid'] = intval($_GPC['category']['childid']);    
            $data['thumb'] = $_GPC['thumb'];            
            $data['uniacid'] = $_W['uniacid'];          
            $data['time'] = TIMESTAMP;
            foreach($_GPC['link'] as $k => $v) {
            $v = trim($v);                
            if(empty($v)) continue;
                $video_url[] = array( 
                    'title' => $_GPC['title'][$k],                   
                    'link' => $v,        
                );                
            }       
            $data['video_url'] = iserializer($video_url); 
            $keyword = $data['keyword'];
            if (!empty($keyword)) {
                $rule['uniacid'] = $_W['uniacid'];
                $rule['name'] = '视频：' . $data['title'] . ' 自定义密码触发';
                $rule['module'] = 'reply';
                $rule['status'] = 1;
                $rule['containtype'] = 'basic,';
                $reply['uniacid'] = $_W['uniacid'];
                $reply['module'] = 'reply';
                $reply['content'] = $data['keyword'];
                $reply['type'] = 1;
                $reply['status'] = 1;               
            }       
                                    
            if ($item) {
                pdo_update('cyl_vip_video_manage',$data,array('id'=>$id));
                if (empty($keyword)) {
                    pdo_delete('rule', array('id' => $item['rid'], 'uniacid' => $_W['uniacid']));
                    pdo_delete('rule_keyword', array('rid' => $item['rid'], 'uniacid' => $_W['uniacid']));
                    pdo_delete('basic_reply', array('rid' => $item['rid']));
                    pdo_update('cyl_vip_video_manage',array('rid'=>''),array('id'=>$item['id']));
                }elseif($item['rid']){
                    pdo_update('rule', $rule,array('id'=>$item['rid']));
                    pdo_update('rule_keyword', $reply,array('rid'=>$item['rid']));
                    $reply_url =  link_url('index',array('mov'=>'detail','id'=>$item['id'],'pwd'=>$data['password'])); 
                    $li['content'] = '密码：'.$data['password'].'<br><a href="'.$reply_url.'">点击直达</a>';       
                    pdo_update('basic_reply', $li,array('rid'=>$item['rid']));                  
                }elseif($keyword){
                    pdo_insert('rule', $rule);
                    $rid = pdo_insertid();
                    $reply['rid'] = $rid;                   
                    pdo_insert('rule_keyword', $reply);
                    $li['rid'] = $rid;  
                    $reply_url =  link_url('index',array('mov'=>'detail','id'=>$item['id'],'pwd'=>$data['password'])); 
                    $li['content'] = '密码：'.$data['password'].'<br><a href="'.$reply_url.'">点击直达</a>';           
                    pdo_insert('basic_reply', $li);
                    pdo_update('cyl_vip_video_manage',array('rid'=>$rid),array('id'=>$id));
                }
            }else{              
                $res = pdo_insert('cyl_vip_video_manage', $data);
                $id = pdo_insertid();

                if (!empty($keyword)) {                 
                    pdo_insert('rule', $rule);
                    $rid = pdo_insertid();
                    $reply['rid'] = $rid;                   
                    pdo_insert('rule_keyword', $reply);
                    $li['rid'] = $rid;
                    $reply_url =  link_url('index',array('mov'=>'detail','id'=>$item['id'],'pwd'=>$data['password']));
                    $li['content'] = '密码：'.$data['password'].'<br><a href="'.$reply_url.'">点击直达</a>';                   
                    pdo_insert('basic_reply', $li);
                    pdo_update('cyl_vip_video_manage',array('rid'=>$rid),array('id'=>$id)); 
                }                   
            }               
            message('更新成功',$this->createWebUrl('manage'),'success');
        }           
    }
    if ($op == 'huoqu') {
        $url = $_GPC['url'];                 
        $data = yijiancaiji($url);
        // $data = $data['0'];
        echo json_encode($data);    
        exit(); 
    }
    if ($op == 'piliang') {
        $piliang = nl2br($_GPC['piliang']); 
        foreach ($data as $key => $value) {
                var_dump($value);
        }   
        include $this->template('piliang');     
        exit(); 
    }
    if ($op == 'delete') {
        $id = $_GPC['id'];
        $row = pdo_fetch("SELECT rid FROM ".tablename('cyl_vip_video_manage')." WHERE id = :id", array(':id' => $id));
        if (!empty($row['rid'])) {
            pdo_delete('rule', array('id' => $row['rid'], 'uniacid' => $_W['uniacid']));
            pdo_delete('rule_keyword', array('rid' => $row['rid'], 'uniacid' => $_W['uniacid']));
            pdo_delete('basic_reply', array('rid' => $row['rid']));
        }
        $res = pdo_delete('cyl_vip_video_manage', array('id'=>$id));        
        if($res){
            message('删除成功！',$this->createWebUrl('manage'),'success');
        }
    }
    if ($op == 'shenhe') {
        $id = $_GPC['id'];
        $res = pdo_update('cyl_vip_video_message',array('status'=>1), array('id'=>$id));
        if($res){
            message('审核成功！',$this->createWebUrl('manage',array('op'=>'comment')),'success');
        }
    }
    if ($op == 'comment_del') {
        $id = $_GPC['id'];
        $res = pdo_delete('cyl_vip_video_message', array('id'=>$id));
        if($res){
            message('删除成功！',$this->createWebUrl('manage',array('op'=>'comment')),'success');
        }
    }
    include $this->template('manage');   
}
public function doWebMember() {
    global $_W, $_GPC;
    $op = $_GPC['op'] ? $_GPC['op'] : 'member';
    if ($op == 'member') {
        $pageindex = max(intval($_GPC['page']), 1); // 当前页码
        $pagesize = 20; // 设置分页大小
        $starttime = empty($_GPC['time']['start']) ? strtotime('-90 days') : strtotime($_GPC['time']['start']);
        $endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 86399 : strtotime($_GPC['time']['end']) + 86399;
        $where = ' WHERE uniacid = :uniacid AND old_time >= :starttime AND old_time <= :endtime';
        $params = array(
            ':uniacid'=>$_W['uniacid'],
            ':starttime' => $starttime, 
            ':endtime' => $endtime
        );
        if ($_GPC['keyword']) {
            $where .= ' AND nickname LIKE :keyword OR phone LIKE :keyword '; 
            $params[':keyword'] = "%{$_GPC['keyword']}%"; 
        }
        if ($_GPC['is_pay']) {
            $where .= ' AND is_pay = :is_pay ';
            $params[':is_pay'] = "{$_GPC['is_pay']}";
        }
        if ($_GPC['is_pay'] == 2) {
            $where .= ' AND is_pay = :is_pay ';
            $params[':is_pay'] = 0;
        }
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_member') . $where , $params);
        $today_member = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_member') . $where , array(':uniacid'=>$_W['uniacid'],':starttime' => strtotime(date('Y-m-d')),':endtime' => TIMESTAMP));
        $today_click = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video') . ' WHERE uniacid = :uniacid AND time >= :starttime AND time <= :endtime  ' , $params);     
        $total_member = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_member') . " WHERE uniacid = :uniacid AND is_pay = :is_pay ",array(':uniacid'=>$_W['uniacid'],':is_pay'=>1));
        $pager = pagination($total, $pageindex, $pagesize);
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video_member').$where.' ORDER BY old_time DESC , id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;          
        $list = pdo_fetchall($sql, $params, 'id');
    } 
    if ($op == 'add') {
        $id = $_GPC['id'];
        if ($id) {              
            $item = pdo_get('cyl_vip_video_member', array('id'=>$id)); 
        }
        if (checksubmit()) {
            $data = $_GPC['data'];
            $data['uniacid'] = $_W['uniacid'];
            $data['time'] = TIMESTAMP; 
            if ($_GPC['password']) {
               $data['password'] = md5($_GPC['password']);
            }
            $data['avatar'] = $_GPC['avatar']; 
            $data['end_time'] = strtotime($_GPC['end_time']);
            if ($item) {
                $res = pdo_update('cyl_vip_video_member',$data,array('id'=>$id));
            }else{
                $res = pdo_insert('cyl_vip_video_member',$data); 
            }
            if ($res) {
                message('更新成功',$this->createWebUrl('member'),'success');
            }else{
                message($res); 
            }
            
        }
    }
    if ($op == 'delete') {
        $id = $_GPC['id'];
        pdo_delete('cyl_vip_video_member',array('id'=>$id));
        message('删除成功',$this->createWebUrl('member'),'success');
    }
    if ($op == 'blacklist') {
        $id = $_GPC['id'];
        pdo_update('cyl_vip_video_member',array('is_pay'=>3),array('id'=>$id));
        message('设置成功',$this->createWebUrl('member'),'success');
    }
    if ($op == 'blacklistopen') {
        $id = $_GPC['id'];
        pdo_update('cyl_vip_video_member',array('is_pay'=>''),array('id'=>$id));
        message('设置成功',$this->createWebUrl('member'),'success');
    }
    if ($op == 'phonehuifu') {
        $list = pdo_getall('cyl_vip_video_member',array('uniacid'=>$_W['uniacid']));
        foreach ($list as $key => $value) {            
            if (!$value['phone']) {
               pdo_update('cyl_vip_video_member',array('phone'=>$value['openid']),array('id'=>$value['id']));  
            }
        }
        message('手机恢复成功');        
    }
    if ($op == 'huifu') {
        $list = pdo_getall('cyl_vip_video_member',array('uniacid'=>$_W['uniacid']));
        foreach ($list as $key => $value) {            
            if (!$value['openid']) {
               pdo_update('cyl_vip_video_member',array('openid'=>$value['phone']),array('id'=>$value['id']));  
            }
        }
        message('openid恢复成功');        
    }
    if ($op == 'qingli') {
        $list = pdo_getall('cyl_vip_video_member',array('uniacid'=>$_W['uniacid']));
        foreach ($list as $key => $value) {
            if (!$value['openid'] && !$value['phone']) {
               pdo_delete('cyl_vip_video_member',array('id'=>$value['id'])); 
            }
        }
        message('清理成功');        
    }
    if ($op == 'chongzhi') {
        $list = pdo_getall('cyl_vip_video_member',array('uniacid'=>$_W['uniacid']));
        foreach ($list as $key => $value) {
            $order = pdo_get('cyl_vip_video_order',array('openid'=>$value['openid']));
            if (!$order) {
               pdo_update('cyl_vip_video_member',array('end_time'=>null,'is_pay'=>0),array('id'=>$value['id']));  
            }
        }
        message('清理成功');        
    }
    include $this->template('member'); 
}
public function doWebOrder() {
    global $_W, $_GPC;     
    $settings = $this->module['config'];        
    $starttime = empty($_GPC['time']['start']) ? strtotime('-90 days') : strtotime($_GPC['time']['start']);
    $endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 86399 : strtotime($_GPC['time']['end']) + 86399;
    $pindex = max(intval($_GPC['page']), 1); // 当前页码
    $psize = 20; // 设置分页大小
    $condition = ' WHERE uniacid=:uniacid AND time >= :starttime AND time <= :endtime ';        
    $params = array(
        ':uniacid'=>$_W['uniacid'],
        ':starttime' => $starttime,
        ':endtime' => $endtime
    );
    if ($_GPC['status']) {
       $condition .= ' AND status = :status '; 
       $params[':status'] = $_GPC['status'];
    }        
    $sql = ' SELECT * FROM '.tablename('cyl_vip_video_order') . $condition . ' ORDER BY id DESC LIMIT '.(($pindex -1) * $psize).','. $psize;
    $list = pdo_fetchall($sql, $params, 'id');        
    $total_amount = pdo_fetchcolumn('SELECT SUM(fee) as fee FROM ' . tablename('cyl_vip_video_order') . $condition . " AND status = 1 AND tid != '积分兑换' ",$params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_order') . $condition,$params);
    $pager = pagination($total, $pindex, $psize);        
    if ($op == 'qingli') {
           pdo_delete('cyl_vip_video_order',array('status'=>0,'uniacid'=>$_W['uniacid']));
           message('清理成功',$this->createWebUrl('order'),'success');
    }   
    if ($op == 'partner') {
        global $_W, $_GPC;        
        $order =  pdo_get('cyl_vip_video_order',array('tid'=>$_GPC['out_trade_no']));
        $settings = pdo_get('uni_account_modules',array('uniacid'=>$order['uniacid'],'module'=>'super_mov'));
        $settings = iunserializer($settings['settings']); 
        if ($settings['payment'] == 2) {
            $key = $settings['shop_key'];
        }
        if ($settings['payment'] == 3) {
            $key = $settings['caihong_key'];
        }
        
        $data = array(
            'uniacid'=>$order['uniacid'],
            'key'=>$key,
        ); 
        echo json_encode($data);
        exit();
    } 
    include $this->template('order');   
}
public function doWebHdp() {
    global $_W, $_GPC;
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';

    if($op == 'list'){        
        if(checksubmit('submit')){
            if(!empty($_GPC['sort'])){
                foreach($_GPC['sort'] as $key=>$d){
                    pdo_update('cyl_vip_video_hdp', array('sort'=>$d), array('id'=>$_GPC['id'][$key]));
                }
                message('批量更新排序成功！', $this->createWebUrl('hdp', array('op' => 'list')), 'success');
            }
        }
        $type = type();
        $list = pdo_fetchall("SELECT * FROM " . tablename('cyl_vip_video_hdp') . " WHERE uniacid =:uniacid $condition ORDER BY sort DESC,id DESC", array(":uniacid" => $_W['uniacid']));

    } elseif ($op == 'post'){
        $id = intval($_GPC['id']);
        $adv = pdo_fetch("select * from " . tablename('cyl_vip_video_hdp') . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $id, ":uniacid" => $_W['uniacid']));
        if(checksubmit('submit')){            
            $data = array(
                        'uniacid' => $_W['uniacid'],
                        'sort' => $_GPC['sort'],
                        'title' => $_GPC['title'],
                        'thumb' => $_GPC['thumb'], 
                        'type' => $_GPC['type'], 
                        'link' => $_GPC['link'],
                        'out_link' => $_GPC['out_link']
            );  
            $link = explode('http://www.360kan.com', $data['link']);                
            if (count($link) == 1) {
                $data['link'] = $data['link'];
            }else{
                $data['link'] = $link['1'];
            }                
            if (!empty($id)) {
                pdo_update('cyl_vip_video_hdp', $data, array('id' => $id));
            } else {
                pdo_insert('cyl_vip_video_hdp', $data);
                $id = pdo_insertid();
            }
            message('更新幻灯片成功！', $this->createWebUrl('hdp', array('op' => 'list')), 'success');
        }
        
    } elseif ($op == 'delete') {
        $id = intval($_GPC['id']);
        $adv = pdo_fetch("SELECT id  FROM " . tablename('cyl_vip_video_hdp') . " WHERE id = ".$id." AND uniacid=" . $_W['uniacid'] . "");
        if (empty($adv)) {
            message('抱歉，幻灯片不存在或是已经被删除！', $this->createWebUrl('hdp', array('op' => 'display')), 'error');
        }
        pdo_delete('cyl_vip_video_hdp', array('id' => $id));
        message('幻灯片删除成功！', $this->createWebUrl('hdp', array('op' => 'list')), 'success');
    }
    include $this->template('hdp'); 
}
public function doWebAd() { 
    global $_W, $_GPC;
    $ad = ad();
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';
    if($op == 'list'){ 
    $list = pdo_fetchall("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid=:uniacid $condition ORDER BY sort DESC,id DESC", array(":uniacid" => $_W['uniacid']));
    }elseif ($op == 'post'){
        $id = intval($_GPC['id']);
        $adv = pdo_fetch("select * from " . tablename('cyl_vip_video_ad') . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $id, ":uniacid" => $_W['uniacid']));
        if(checksubmit('submit')){            
            $data = array(
                        'uniacid' => $_W['uniacid'],
                        'sort' => $_GPC['sort'],                        
                        'title' => $_GPC['title'],                        
                        'thumb' => $_GPC['thumb'], 
                        'second' => $_GPC['second'],
                        'link' => $_GPC['link'],                        
                        'status' => $_GPC['status'],                        
                        'type' => $_GPC['type'],                        
                        'insert' => $_GPC['insert'],                        
            ); 
            $data['end_time'] = strtotime($_GPC['end_time']);  
            if (!empty($id)) {
                pdo_update('cyl_vip_video_ad', $data, array('id' => $id));
            } else {
                pdo_insert('cyl_vip_video_ad', $data);
                $id = pdo_insertid();
            }
            message('更新成功！', $this->createWebUrl('ad', array('op' => 'list')), 'success');
        }
        
    } elseif ($op == 'delete') {
        $id = intval($_GPC['id']);
        $adv = pdo_fetch("SELECT id  FROM " . tablename('cyl_vip_video_ad') . " WHERE id = ".$id." AND uniacid=" . $_W['uniacid'] . "");
        if (empty($adv)) {
            message('抱歉，不存在或是已经被删除！', $this->createWebUrl('hdp', array('op' => 'display')), 'error');
        }
        pdo_delete('cyl_vip_video_ad', array('id' => $id));
        message('删除成功！', $this->createWebUrl('ad', array('op' => 'list')), 'success');
    }
    include $this->template('ad'); 
}
public function doWebCmstongbu() {
    global $_W, $_GPC;
    $settings = $this->module['config'];
    $sett = pdo_getall('uni_account_modules',array('module'=>'super_mov'));
    foreach ($sett as $key => $value) {
        $v = iunserializer($value['settings']);
        $v['ziyuan'] = $settings['ziyuan'];
        $v['host'] = $settings['host'];
        $v['username'] = $settings['username'];
        $v['password'] = $settings['password'];
        $v['database'] = $settings['database'];
        // var_dump($v);
        pdo_update('uni_account_modules', array('settings'=>iserializer($v)), array('id'=>$value['id']));        
    }
   
    // exit();
    // pdo_delete('cyl_vip_video_share', array('uniacid' => $_W['uniacid']));
    message('同步完成','','success'); 
}
public function doWebCard() {
    global $_W, $_GPC;
    $op = $_GPC['op'] ? $_GPC['op'] : 'display';
    $id = $_GPC['id'];          
    $card = pdo_get('cyl_vip_video_keyword', array('id'=>$id), array() , '' , 'id DESC');       
    if ($op == 'display') {
        $pageindex = max(intval($_GPC['page']), 1); // 当前页码
        $pagesize = 20; // 设置分页大小           
        $where = ' WHERE uniacid = :uniacid ';
        $params = array(
            ':uniacid'=>$_W['uniacid'],             
        );          
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_keyword') . $where , $params);          
        $pager = pagination($total, $pageindex, $pagesize);
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video_keyword').$where.' ORDER BY id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;         
        $list = pdo_fetchall($sql, $params, 'id');              
    } 
    if ($op == 'post') {
        if (checksubmit('submit')) {                
            $data = $_GPC['data'];
            if (empty($data['card_id'])) { 
                message('抱歉，请输入卡密标识！');
            }
            $card_id = pdo_get('cyl_vip_video_keyword', array('card_id'=>$data['card_id']), array() , '' , 'id DESC'); 
            if ($card_id) {
                 message('抱歉，请输入卡密标识已存在，请重新换个！');
            }
            $data['uniacid'] = $_W['uniacid'];  
            $card = card($_GPC['weishu'],$data['num']);                 
            pdo_insert('cyl_vip_video_keyword', $data);
            $id = pdo_insertid();
            foreach ($card as $value) {                 
                pdo_insert('cyl_vip_video_keyword_id', array('card_id'=>$id,'pwd'=>$data['card_id'].$value,'uniacid'=>$_W['uniacid'],'day'=>$data['day']));
            }               
            message('生成成功！', $this->createWebUrl('card'), 'success'); 
        }
    }
    if ($op == 'delete') {
        $id = intval($_GPC['id']);          
        pdo_delete('cyl_vip_video_keyword_id', array('card_id' => $id));
        pdo_delete('cyl_vip_video_keyword', array('id' => $id));
        message('删除成功！', $this->createWebUrl('card'), 'success');
    }
    if ($op == 'card') {            
        $pageindex = max(intval($_GPC['page']), 1); // 当前页码
        $pagesize = 20; // 设置分页大小           
        $where = ' WHERE uniacid = :uniacid AND card_id = :card_id ';
        $params = array(
            ':uniacid'=>$_W['uniacid'],             
            ':card_id'=>$id,                
        );          
        if ($_GPC['pwd']) {
           $where .= ' AND pwd = :pwd ';
           $params[':pwd'] = $_GPC['pwd'];
        }
        $total = pdo_fetchcolumn('SELECT count(distinct pwd) FROM ' . tablename('cyl_vip_video_keyword_id') . $where , $params);            
        $ydh = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('cyl_vip_video_keyword_id') . $where . ' AND status = 1 ' , $params);            
        $pager = pagination($total, $pageindex, $pagesize);
        $sql = ' SELECT * , count(distinct pwd) FROM '.tablename('cyl_vip_video_keyword_id').$where.' GROUP BY pwd ORDER BY id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;
        $list = pdo_fetchall($sql, $params, 'id');
        if(checksubmit('export_submit', true)) {                
            $sql = "SELECT * , count(distinct pwd) FROM ".tablename('cyl_vip_video_keyword_id'). $where ." GROUP BY pwd ORDER BY id DESC";
            $listexcel = pdo_fetchall($sql,$params);
            $header = array(                    
                'card_id' => '卡密名称',                    
                'pwd' => '卡密密码',                    
                'nickname' => '会员',                     
                'status' => '使用状态',                 
            );              
            $keys = array_keys($header);            
            foreach($header as $li) {
                $html .= $li . "\t ";
            }
            $html .= "\n";
            if(!empty($listexcel)) {
                $size = ceil(count($listexcel) / 500);
                for($i = 0; $i < $size; $i++) {
                    $buffer = array_slice($listexcel, $i * 500, 500);
                    foreach($buffer as $row) {
                        $member =  member($row['openid']);
                        $row['card_id'] = $card['title'];
                        $row['nickname'] = $member['nickname'];
                        $row['status'] = $row['status'] ? '已兑换' : '未兑换';
                        foreach($keys as $key) {
                            $data[] = $row[$key];
                        }

                        $user[] = implode("\t ", $data) . "\t ";
                        unset($data);
                    }
                }
                $html .= implode("\n", $user);
            }
            
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");;
            header('Content-Disposition:attachment;filename="卡密.xls"');
            header("Content-Transfer-Encoding:binary");
            echo $html;
            exit();
        }   
    }
    include $this->template('card'); 
}
public function doWebClean() {
    global $_W, $_GPC;
    pdo_delete('cyl_vip_video_share', array('uniacid' => $_W['uniacid']));
    message('清理成功','','success'); 
}

public function array2url($params) {
    $str = '';
    $ignore = array('coupon_refund_fee', 'coupon_refund_count');
    foreach($params as $key => $val) {
        if((empty($val) || is_array($val)) && !in_array($key, $ignore)) {
            continue;
        }
        $str .= "{$key}={$val}&";
    }
    $str = trim($str, '&');
    return $str;
}
public function bulidSign($params) {
    unset($params['sign']);
    ksort($params);
    $string = $this->array2url($params);
    $string = $string . "&key={$this->wxpay['key']}";
    $string = md5($string);
    $result = strtoupper($string);
    return $result;
}
public function parseResult($result) {
    if(substr($result, 0 , 5) != "<xml>"){
        return $result;
    }
    $result = json_decode(json_encode(isimplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    if(!is_array($result)) {
        return error(-1, 'xml结构错误');
    }
    if((isset($result['return_code']) && $result['return_code'] != 'SUCCESS') || ($result['err_code'] == 'ERROR' && !empty($result['err_code_des']))) {
        $msg = empty($result['return_msg']) ? $result['err_code_des'] : $result['return_msg'];
        return error(-1, $msg);
    }
    if($this->bulidsign($result) != $result['sign']) {
        return error(-1, '验证签名出错');
    }
    return $result;
}
public function requestApi($url, $params, $extra = array()) {
    load()->func('communication');
    $xml = array2xml($params);
    $response = ihttp_request($url, $xml, $extra);
    if(is_error($response)) {
        return $response;
    }
    $result = $this->parseResult($response['content']);
    return $result;
}
public function queryOrder($id, $type = 1) {
    $params = array(
        'appid' => $this->wxpay['appid'],
        'mch_id' => $this->wxpay['mch_id'], 
        'nonce_str' =>  random(32),
    );
    if($type == 1) {
        $params['transaction_id'] = $id;
    } else {
        $params['out_trade_no'] = $id;
    } 

    $params['sign'] = $this->bulidSign($params);
    $result = $this->requestApi('https://api.mch.weixin.qq.com/pay/orderquery', $params);
    if(is_error($result)) {
        return $result;
    }
    if($result['result_code'] != 'SUCCESS') {
        return error(-1, $result['err_code_des']);
    }
    $result['total_fee'] = $result['total_fee'] / 100;      return $result;
}
public function doWebSms() {
    global $_GPC, $_W;
    $code = mt_rand(1000,9999);
    $res = sendsms($_GPC['phone'],$code);
    $res = json_decode($res,true);
    if($res['errmsg'] == 'OK'){ 
        message('成功，查看手机是否收到验证码，如收到说明设置完成');
    }else{
        message('失败问题：'.$res['Message']);
    }         
}

//新版本

public function getuid(){
    global $_W, $_GPC; 
    $settings = $this->module['config'];    
    $session = pdo_get('cyl_video_sessions',array('sid'=>$_W['session_id']));
    if ($session) {
        $member = pdo_get('mc_members',array('uid'=>$session['uid']));      
        $video_member = member($member['mobile'],'is_weixin');
        $data['openid'] = $member['openid'];
        if ($member['nickname'] || $member['avatar']) {
            $_W['openid'] = $member['openid'];
            $member = member($_W['openid']);
            $data['avatar'] = $member['avatar'];
            $data['nickname'] = $member['nickname'];
            $data['openid'] = $member['openid'];
            $data['uid'] = $member['uid'];
        }   
        $member = array_merge($member,$video_member); 
        $member['openid'] = $member['openid'];
    }else{
        $fans = pdo_get('mc_mapping_fans',array('openid'=>$_W['openid']));
        $member = pdo_get('mc_members',array('uid'=>$fans['uid']));  
        $video_member = member($fans['openid']);          
        $member = array_merge($video_member,$member);
        $member['openid'] = $fans['openid']; 
    }                     
    if ($_GPC['tiaoshi'] == 1) {
        $member = pdo_get('mc_members',array('uid'=>10));
        $fans = pdo_get('mc_mapping_fans',array('uid'=>10));
        $member['openid'] = $fans['openid'];
        $video_member = member($member['openid']);
        $member = array_merge($member,$video_member);
        $member['openid'] = $fans['openid'];
    }     
    $member['avatarUrl'] = $member['avatar'] ? $member['avatar'] : $_W['uniaccount']['logo'];
    $member['nickName'] = $member['nickname'] ? $member['nickname'] : $member['mobile'];  
    $member['uid'] = $member['uid']; 
    $member['credit1'] = $member['credit1'];
    $cyl_vip_video_history = pdo_get('cyl_vip_video_history',array('uid'=>$member['uid']),array('COUNT(*) AS count'));
    $member['historynum'] = $cyl_vip_video_history['count'];
    $cyl_vip_video_collection = pdo_get('cyl_vip_video_collection',array('uid'=>$member['uid']),array('COUNT(*) AS count'));
    $member['collectionnum'] = $cyl_vip_video_collection['count'];
    return $member;
}
public function doMobileFoot() {
    global $_W, $_GPC; 
    $settings = $this->module['config'];
    $data = array();
    $settings['tabBar_color'] = $settings['tabBar_color'] ? $settings['tabBar_color'] : '#ffffff';
    $data['foot'] = tabBar($settings);
    $data['tabBar_backgroundColor'] = $settings['tabBar_backgroundColor'] ? $settings['tabBar_backgroundColor'] : '#ea5455'; 
    result(0, 'success' ,$data);       
}
public function doMobileVersion() {
    global $_W, $_GPC; 
    $data = array('version'=>'1.0.3','wgtUrl'=>'https://sport.mtgjiaxiang.com/addons/super_mov/template/mobile/h5/static/__UNI__748811E.wgt','banben'=>2,'note'=>'重要更新提示');
    result(0, 'success' ,$data);       
}
public function doMobileSettings() {
    global $_W, $_GPC; 
    $setting = array();
    $settings = $this->module['config']; 
    $setting['logo'] = $_W['uniaccount']['logo'];   
    $setting['list'] = $settings['list'] ? $settings['list'] : '6';     
    $setting['theme'] = $settings['theme'];     
    $setting['frontColor'] = $settings['frontColor'];     
    $setting['headtheme'] = $settings['headtheme'];     
    $setting['site_title'] = $settings['site_title'];     
    $setting['subscribe_title'] = $settings['subscribe_title'];     
    $setting['share_title'] = $settings['share_title'];     
    $setting['share_desc'] = $settings['share_desc'];     
    $setting['index_gg'] = $settings['index_gg'];     
    $setting['copyright'] = $settings['copyright'];     
    $setting['pay_settings'] = $settings['pay_settings'];     
    $setting['free_num'] = $settings['free_num'];     
    $setting['warn_font'] = $settings['warn_font'];     
    $setting['shuoming'] = $settings['shuoming'];     
    $setting['share_thumb'] = tomedia($settings['share_thumb']);  
    $setting['ewm'] = tomedia($settings['ewm']);  
    $setting['card'] = iunserializer($settings['card']); 
    result(0, 'success' ,$setting);     
}
public function doMobileNavlist() {
    global $_W, $_GPC; 
    $data = category();
    $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');
    $parent = array(); 
    $children = array();
    if (!empty($category)) {
        $children = '';
        foreach ($category as $cid => $cate) {
            if (!empty($cate['parentid'])) {
                $children[$cate['parentid']][] = $cate;
            } else {
                $parent[$cate['id']] = $cate;
            }
        }
    }
    $data = array('list'=>$data,'category'=>$category); 
    result(0, 'success' ,$data);     
}
public function doMobileHdp() {
    global $_W, $_GPC; 
    $op = $_GPC['op'] ? $_GPC['op'] : 'index';
    $setting = setting();
    $site_name = $setting['member']; 
    $settings = $this->module['config'];
    if ($site_name['setting']) {
        $setting = iunserializer($site_name['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    }
    if ($site_name) {  
        $data = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op,'site_name'=>$site_name['site_name']), array() , '' , 'sort DESC , id DESC');
    }else{
        if (pdo_tableexists('cyl_agent_site_member')) {
            $data = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op,'site_name'=>''), array() , '' , 'sort DESC , id DESC'); 
        }else{
            $data = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op), array() , '' , 'sort DESC , id DESC'); 
        }
    }    
    foreach ($data as $key => &$value) {
        $value['thumb'] = tomedia($value['thumb']);
    }
    result(0, 'success' ,$data);     
}
public function doMobileNewsindex() {
    global $_W, $_GPC; 
    $json = array();
    $eid = $_GPC['eid'];
    $setting = setting();
    $site_name = $setting['member']; 
    $settings = $this->module['config'];
    if ($site_name['setting']) {
        $setting = iunserializer($site_name['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    }
    $op = $_GPC['op'] ? $_GPC['op'] : 'index';
    $acc = WeAccount::create();  
    $json['num'] = $settings['list'] ? $settings['list'] : 6;     
    $member = member($_W['openid']); 
    if (TIMESTAMP > $member['end_time'] && $member['is_pay'] == 1) {
        pdo_update('cyl_vip_video_member',array('end_time'=>null,'is_pay'=>0),array('openid'=>$member['openid']));
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'].'您的会员已到期',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员到期',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => date('Y-m-d H:i:s',$member['end_time']),
                    'color' => '#ff510'
                ) ,                   
                'remark' => array(
                    'value' => '欢迎继续使用',
                    'color' => '#ff510'
                ) ,
            );
        $url = link_url('member');
        $acc->sendTplNotice($member['openid'], $settings['due_id'], $data, $url, $topcolor = '#FF683F');
    }
    $ad = ad();
    foreach ($ad as $key => $value) { 
        if ($key == 'dianying' || $key == 'dianshi' || $key == 'zongyi' || $key == 'dongman' ) {
           $gg[$key] = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid = :uniacid AND type = :type  AND status = 0 ORDER BY rand() DESC LIMIT 1",array(':uniacid'=>$_W['uniacid'],':type'=>$key),'id');    
        }elseif ($key != 'dumiao') {
           $list_gg[$key] = pdo_fetchall("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid = :uniacid AND type = :type  AND status = 0 ORDER BY id DESC ",array(':uniacid'=>$_W['uniacid'],':type'=>$key),'insert');  
        }       
    }
    foreach ($gg as $key => $value) {                
        if ($value['end_time'] < TIMESTAMP ) {
            pdo_update('cyl_vip_video_ad', array('end_time' => '','status'=>1), array('id'=>$value['id']));
        } 
    }       
    foreach ($list_gg as $key => $value) {
        foreach ($value as $key => $value) {
            if ($value['end_time'] < TIMESTAMP ) {
                pdo_update('cyl_vip_video_ad', array('end_time' => '','status'=>1), array('id'=>$value['id']));
            }
        }
    } 
    if ($op == 'today' && $settings['ziyuan'] == 2) {       
        $type =mac_category();              
        $today = mac_list(array('op'=>'today','pageno'=>100));
    }elseif ($op == 'today' && $settings['ziyuan'] == 1) {
        $url = m3u8();
        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
        $url = $url . "?ip=".$ip."&op=today&pageno=100";
        $response = ihttp_get($url); 
        $today = json_decode($response['content'],true); 
        foreach ($today as $key => &$value) {
            if (strexists($value['img'], 'tu')) {
                $value['img'] = MODULE_URL . $value['img'];                
            }                
        }
    }elseif ($op == 'today' && $settings['ziyuan'] == 3) {
        $url = m3u8();
        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
        $url = $url . "?ziyuan=".$setings['ziyuan']."&ip=".$ip."&op=today&pageno=100";
        $response = ihttp_get($url); 
        $today = json_decode($response['content'],true); 
    }
    if ($settings['ziyuan'] == 2) {
            $type =mac_category();                 
            $today = mac_list(array('op'=>'today','pageno'=>20));
            $dianying = index_list('dianying',$settings['ziyuan']);
            
    }else{
        $time = cache_load('cyl_vip_video:time'.$_W['uniacid']); 
        if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) { 
            $url = m3u8();
            $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
            $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&op=today&pageno=20";
            $response = ihttp_get($url); 
            $today = json_decode($response['content'],true); 
        }
        if ((TIMESTAMP - $time) > 3600 ) {  
            if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) {
                $dianying = index_list('dianying',$settings['ziyuan'],$settings['dianying_rank'] ? $settings['dianying_rank'] : 'rankhot');
                $dianshi = index_list('dianshi',$settings['ziyuan'],'rankhot');
                $zongyi = index_list('zongyi',$settings['ziyuan'],$settings['zongyi_rank'] ? $settings['zongyi_rank'] : 'rankhot');
                $dongman = index_list('dongman',$settings['ziyuan'],$settings['dongman_rank'] ? $settings['dongman_rank'] : 'rankhot');  
            }else{
                $dianying = index_list($url,$settings['dianying_rank'] ? $settings['dianying_rank'] : 'rankhot','dianying',$settings['screen_name']);
                $dianshi = index_list($url,'rankhot','dianshi',$settings['screen_name']);
                $zongyi = index_list($url,$settings['zongyi_rank'] ? $settings['zongyi_rank'] : 'rankhot','zongyi',$settings['screen_name']);
                $dongman = index_list($url,$settings['dongman_rank'] ? $settings['dongman_rank'] : 'rankhot','dongman',$settings['screen_name']);                    
            }
            cache_write('cyl_vip_video:time'.$_W['uniacid'], TIMESTAMP);               
            cache_write('cyl_vip_video:dianying'.$_W['uniacid'], $dianying);  
            cache_write('cyl_vip_video:dianshi'.$_W['uniacid'], $dianshi);  
            cache_write('cyl_vip_video:zongyi'.$_W['uniacid'], $zongyi);   
            cache_write('cyl_vip_video:dongman'.$_W['uniacid'], $dongman);  
        }else{
            $dianying = cache_load('cyl_vip_video:dianying'.$_W['uniacid']);   
            $dianshi = cache_load('cyl_vip_video:dianshi'.$_W['uniacid']); 
            $zongyi = cache_load('cyl_vip_video:zongyi'.$_W['uniacid']);   
            $dongman = cache_load('cyl_vip_video:dongman'.$_W['uniacid']); 
            // var_dump($dongman);  
        }
        foreach ($today as $key => &$value) {
            if (strexists($value['img'], 'tu.php')) {
                $value['img'] = MODULE_URL . $value['img'];                    
            }elseif (strexists($value['img'], 'doubanio.com')) {
                $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
            }                     
        }
        foreach ($dianying as $key => &$value) {
            if (strexists($value['img'], 'tu.php')) {
                $value['img'] = MODULE_URL . $value['img'];                    
            }elseif (strexists($value['img'], 'doubanio.com')) {
                $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
            }             
        }
        foreach ($dianshi as $key => &$value) {
            if (strexists($value['img'], 'tu.php')) {
                $value['img'] = MODULE_URL . $value['img'];                    
            }elseif (strexists($value['img'], 'doubanio.com')) {
                $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
            }              
        }
        foreach ($zongyi as $key => &$value) {
            if (strexists($value['img'], 'tu.php')) {
                $value['img'] = MODULE_URL . $value['img'];                    
            }elseif (strexists($value['img'], 'doubanio.com')) {
                $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
            }              
        }
        foreach ($dongman as $key => &$value) {
            if (strexists($value['img'], 'tu.php')) {
                $value['img'] = MODULE_URL . $value['img'];                    
            }elseif (strexists($value['img'], 'doubanio.com')) {
                $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
            }              
        }
    }        
    foreach ($list_gg['dianying_list'] as  &$row){
        $row['out_link'] = $row['link'];
        $row['img'] = tomedia($row['thumb']);
        $row['hint'] = '广告';
    } 
    foreach($list_gg['dianying_list'] as $k=>$p){
      array_splice($dianying, $k-1, 0, array($p));
    } 

    foreach ($list_gg['dianshi_list'] as  &$row){
        $row['out_link'] = $row['link'];
        $row['img'] = tomedia($row['thumb']);
        $row['hint'] = '广告';
    } 
    foreach($list_gg['dianshi_list'] as $k=>$p){
      array_splice($dianshi, $k-1, 0, array($p));
    }

    foreach ($list_gg['zongyi_list'] as  &$row){
        $row['out_link'] = $row['link'];
        $row['img'] = tomedia($row['thumb']);
        $row['hint'] = '广告';
    } 
    foreach($list_gg['zongyi_list'] as $k=>$p){
      array_splice($zongyi, $k-1, 0, array($p));
    }

    foreach ($list_gg['dongman_list'] as  &$row){
        $row['out_link'] = $row['link'];
        $row['img'] = tomedia($row['thumb']);
        $row['hint'] = '广告';
    } 
    foreach($list_gg['dongman_list'] as $k=>$p){
      array_splice($dongman, $k-1, 0, array($p));
    }    
    $json['list'] = array(
        'today' => array(
            'title' => '今日更新',
            'list' => $today, 
        ),
        'dianying' => array(
            'title' => '电影',
            'list' => $dianying,
        ),
        'dianshi' => array(
            'title' => '电视剧',
            'list' => $dianshi,
        ),
        'zongyi' => array(
            'title' => '综艺',
            'list' => $zongyi,
        ),
        'dongman' => array(
            'title' => '动漫',
            'list' => $dongman,
        ),
    ); 
    $json['gg'] = $list_gg;
    result(0, 'success' ,$json);     
}
public function doMobileNewslist() { 
    global $_W, $_GPC;
    $op = $_GPC['id'];
    $settings = $this->module['config'];
    $setting = setting();
    $setting = $setting['member']; 
    $site_name = iunserializer($setting['setting']);
    if ($site_name) {
        $settings['logo'] = $site_name['logo'];
        $settings['subscribe_title'] = $site_name['subscribe_title'];
        $settings['index_gg'] = $site_name['index_gg'];
        $settings['copyright'] = $site_name['copyright'];
        $settings['guanzhu_ewm'] = $site_name['guanzhu_ewm'];  
    }
    if ($op > 0) {
        $where['uniacid'] = $_W['uniacid'];
        $where['cid'] = $op;
        $where['display !='] = 1;
        if ($_GPC['year'] > 0) {
            $where['pid'] = $_GPC['year'];       
        }   
        $data = pdo_getall('cyl_vip_video_manage', $where, array() , '' , 'sort DESC' ,'time DESC', 'id DESC');
        foreach ($data as $key => &$value) {
            $value['img'] = tomedia($value['thumb']);
        }
        $cat = pdo_getall('cyl_vip_video_category', array('uniacid'=>$_W['uniacid'],'parentid'=>$op), array() , '' , 'id DESC');                 
    }elseif($op == 'yule' || $op == 'gaoxiao'){         
        $data = kan360_list($op);                       
    }elseif ($settings['ziyuan'] == 2) {
        $type = mac_category();            
        $type_pid = $type['1'][$type_id_1];            
        $rank = $_GPC['rank'] ? $_GPC['rank'] : 'rankhot';  
        $year = $_GPC['year'];                  
        $type_id = $_GPC['type_id'];                  
        $area = $_GPC['area'];  
        $num = $_GPC['num'] ? $_GPC['num'] : 0;   
        $where = array('type_id_1'=>$type_id_1); 
        if (!$type_pid) {
           $where = array('type_id'=>$type_id_1);
        }
        if ($type_id) {
            $where['type_id'] = $type_id;
        } 
        if ($year) {
            $where['vod_year'] = $year;
        } 
        if ($area) {
            $where['vod_area'] = $area;
        }             
        $data = mac_list($where,$rank);            
    }elseif ($op == 'today' && $settings['ziyuan'] == 2) {      
        $type =mac_category();              
        $today = mac_list(array('op'=>'today','pageno'=>100));
    }elseif ($op == 'today' && $settings['ziyuan'] == 1) {
        $url = m3u8();
        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
        $url = $url . "?ip=".$ip."&op=today&pageno=100";
        $response = ihttp_get($url); 
        $data = json_decode($response['content'],true); 
        foreach ($data as $key => &$value) {
            if (strexists($value['img'], 'tu')) {
                $value['img'] = 'https://www.tv6.com/' . $value['img'];                
            }                
        }
    }else{ 
        $url = $_GPC['url'];
        $year = $_GPC['year'];                  
        $area = $_GPC['area'];                  
        $act = $_GPC['act'];                    
        $cat = $_GPC['cat'];                    
        $num = $_GPC['num'] ? $_GPC['num'] : 1;     
        $rank = $_GPC['rank'] ? $_GPC['rank'] : 'rankhot'; 
        if (!$settings['ziyuan']) {
            if ($_GPC['cat'] || $_GPC['act'] || $_GPC['year'] || $_GPC['area'] || $rank) {
                $url = "http://www.360kan.com/".$op."/list.php?rank=".$rank."&year=".$year."&area=".$area."&act=".$act."&cat=".$cat."&pageno=".$num;
            }else{
                $url = "http://www.360kan.com/".$op."/list.php?rank=".$rank."&cat=all&area=all&act=all&year=all&pageno=".$num;
            }
        }   
        $discover_time = cache_load('discover:time'.$op.$rank.$num.$_W['uniacid']); 
        $data = cache_load('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$num.$_W['uniacid']);                
        if (empty($data) || (TIMESTAMP - $discover_time) > 3600) {
            if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) {
                $cat = $_GPC['cat_id'];
                $url = m3u8();
                $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
                $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&op=".$op."&rank=".$rank."&year=".$year."&area=".$area."&act=".$act."&cat=".$cat."&pageno=".$num; 
                $response = ihttp_get($url); 
                $data = json_decode($response['content'],true);
            }else{
                $data = discover($url);     
            }                           
            cache_write('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$num.$_W['uniacid'],$data);
        }else{
            $data = cache_load('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$num.$_W['uniacid']);  
        }
        if ($op == 'dianying') {
            foreach ($list_gg['dianying_list'] as  &$row){
                $row['out_link'] = $row['link'];
            } 
            foreach($list_gg['dianying_list'] as $k=>$p){
              array_splice($data, $k-1, 0, array($p));
            } 
        }   
        
        if ($op == 'dianshi') {
            foreach ($list_gg['dianshi_list'] as  &$row){
                $row['out_link'] = $row['link'];
            } 
            foreach($list_gg['dianshi_list'] as $k=>$p){
              array_splice($data, $k-1, 0, array($p));
            }
        }
        if ($op == 'zongyi') {
            foreach ($list_gg['zongyi_list'] as  &$row){
                $row['out_link'] = $row['link'];
            }
            foreach($list_gg['zongyi_list'] as $k=>$p){
              array_splice($data, $k-1, 0, array($p));
            }
        } 
        if ($op == 'dongman') {
            foreach ($list_gg['dongman_list'] as  &$row){
                $row['out_link'] = $row['link'];
            } 
            foreach($list_gg['dongman_list'] as $k=>$p){
              array_splice($data, $k-1, 0, array($p));
            }
        } 
        foreach ($data as $key => &$value) {
            if (strexists($value['img'], 'tu')) {
                $value['img'] = MODULE_URL . $value['img'];                 
            }                
        }               
        if ((TIMESTAMP - $discover_time) > 86400) {
            if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) {
                $url = m3u8();
                $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
                $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&op=".$op."&do=1";
                $response = ihttp_get($url); 
                $category_list = json_decode($response['content'],true); 
                $cat =  $category_list['0'];  
                $area =  $category_list['1'];  
                $year = $category_list['2'];  
            }else{
                $category_list = category_list($url);
                $cat =  $category_list['0'];            
                $year = $category_list['1']; 
                $area = $category_list['2'];
                $star = $category_list['3'];
            }                   
            cache_write('discover:time'.$op.$rank.$_W['uniacid'], TIMESTAMP);                  
            cache_write('discover:cat'.$op.$rank.$_W['uniacid'], $cat);  
            cache_write('discover:year'.$op.$rank.$_W['uniacid'], $year);   
            cache_write('discover:area'.$op.$rank.$_W['uniacid'], $area);  
            cache_write('discover:star'.$op.$rank.$_W['uniacid'], $star);  
        }else{                  
            $cat = cache_load('discover:cat'.$op.$rank.$_W['uniacid']);    
            $year = cache_load('discover:year'.$op.$rank.$_W['uniacid']);
            $area = cache_load('discover:area'.$op.$rank.$_W['uniacid']);
            $star = cache_load('discover:star'.$op.$rank.$_W['uniacid']);
        }            
    }  
    $json = array();
    $json['list'] = $data;
    $json['cat'] = array(
        '0' => $cat,
        '1' => $year,
        '2' => $area,
    );
    $json['rank'] = array(
        array('key'=>'rankhot','title'=>'最近热映'),
        array('key'=>'createtime','title'=>'最近更新'),
        array('key'=>'rankpoint','title'=>'最受好评'),
    );
    result(0, 'success' ,$json);     
}
///////////////新///////////////睿///////////////社///////////////区///////////////
public function doMobilenewsSearch() {
    global $_W, $_GPC;
    $setting = setting();
    $setting = $setting['member']; 
    $settings = $this->module['config'];
    if ($settings['ziyuan'] == 2) {
        $type = mac_category();
    }    
    if ($setting) {
        $setting = iunserializer($setting['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    }
    $where = ' WHERE uniacid = :uniacid AND display != 1 ';
    $params[':uniacid'] = $_W['uniacid'];
    $sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY id DESC LIMIT 50';         
    $video = pdo_fetchall($sql, $params, 'id');             
    $op = $_GPC['op'] ? $_GPC['op'] : 'search';
    $key = $_GPC['key'];
    if ($key) { 
        $where = ' WHERE uniacid = :uniacid ';          
        $where .= ' AND title LIKE :title ';
        $params[':uniacid'] = $_W['uniacid'];   
        $params[':title'] = "%".$_GPC['key']."%";             
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY id DESC ';         
        $search = pdo_fetchall($sql, $params, 'id');
        if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) { 
            $url = m3u8();
            $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
            $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&key=".$key;
            $response = ihttp_get($url); 
            $list = json_decode($response['content'],true);
        }elseif ($settings['ziyuan'] == 2) {                 
            $list = mac_list(array('key'=>$key));                
        }else{                      
            $list = caiji_list($key);
        }
    }
    if (count($list) == 1 ) {
        if (strexists($list['0']['img'], 'tu')) {
            $list['0']['img'] = MODULE_URL . $list['0']['img'];                    
        }  
    }else{
        foreach ($list as $key => &$value) {
            if (strexists($value['img'], 'tu')) {
                $value['img'] = MODULE_URL . $value['img'];                    
            }                
        }
    }
    
    if ($op == 'json') {
        $url = 'https://video.360kan.com/suggest.php?ac=richsug&kw='.$_GPC['kw'];
        $url = ihttp_get($url);    
        $content = json_decode($url['content'],true);            
        $list =  $content['data']['suglist']; 
    }
    $list['list']  = $list;
    $list['videosite']  = videosite();
    result(0, 'success' ,$list);
}
public function doMobilenewsXiaopin() {
    global $_W, $_GPC;
    $ch = curl_init();
    $setting = setting();
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';
    if ($op == 'list') {
        $setting = $setting['member']; 
        $settings = $this->module['config'];
        if ($settings['ziyuan'] == 2) {
            $type = mac_category();
        }    
        if ($setting) {
            $setting = iunserializer($setting['setting']);
            $settings['site_title'] = $setting['site_title'];
            $settings['logo'] = $setting['logo'];
            $settings['subscribe_title'] = $setting['subscribe_title'];
            $settings['subscribe_url'] = $setting['subscribe_url'];
            $settings['index_gg'] = $setting['index_gg'];
            $settings['copyright'] = $setting['copyright'];
            $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
        }
        $max_cursor = $_GPC['num'];
        $list = xiaopin($max_cursor);
        foreach ($list as $key => &$value) {
            $value['img'] = $value['imgv_url'];
            $value['hint'] = $value['duration'];
        }
        result(0, 'success' ,$list);
    }
    if ($op == 'json') {
        $url = $_GPC['url'];
        $url = parse_url($url);
        $url = 'http://m.v.baidu.com'.$url['path'];

        $html = ihttp_request($url, '', array('CURLOPT_REFERER' => 'http://m.v.baidu.com'));

        $html = explode('source: {"mp4":"',$html['content']);
        $html = explode('","ori',$html['1']);
        $html = $html['0'];
        result(0, 'success' ,$html);
    }   
}
public function doMobilenewsTv() {
    global $_W, $_GPC;
    $list =  array();
    $cctv = cctv();
    $cntv = cntv();
    $wstv = wstv();
    $qttv = qttv();
    $list = array(
        'cctv'=>$cctv,
        // 'cntv'=>$cntv,
        'wstv'=>$wstv,
        'qttv'=>$qttv,
    );
    result(0, 'success' ,$list);   
}
public function doMobileNewsdetail() {
    global $_W, $_GPC; 
    $op = $_GPC['op'];
    $id = $_GPC['id'];
    $settings = $this->module['config'];
    $member = $this->getuid();
    $uid = $member['uid'];    
    $ad = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid = :uniacid AND type = 'dumiao'  AND status = 0 ORDER BY rand() DESC LIMIT 1",array(':uniacid'=>$_W['uniacid']),'id');
    if (TIMESTAMP > $ad['end_time']) {
        pdo_update('cyl_vip_video_ad',array('status'=>1),array('id'=>$ad['id']));
    }    
    if ($site_name) { 
        $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['mov'],'site_name'=>$setting['site_name']), array() , '' , 'sort DESC , id DESC');
    }else{
        if (pdo_tableexists('cyl_agent_site_member')) {
            $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['mov'],'site_name'=>''), array() , '' , 'sort DESC , id DESC'); 
        }else{
            $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['mov']), array() , '' , 'sort DESC , id DESC'); 
        }
    }
    $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');
    $url = $_GPC['url'];
    $yurl = $_GPC['url'];
    if ($setting['card']) {
        $setting_setting = iunserializer($setting['card']);
        $settings['everyday_free_num'] = $setting_setting['everyday_free_num'];
        $settings['free_num'] = $setting_setting['free_num'];
        $settings['warn_font'] = $setting_setting['warn_font']; 
    }    
    $content = pdo_fetch("SELECT * FROM ".tablename('cyl_vip_video_manage')." WHERE id=:id",array(':id'=>$_GPC['d_id'])); 
    if ($content['id']) {        
        if (checksubmit('submit')) {
            if ($_GPC['password'] == $content['password']) {
                setcookie("password",$_GPC['password'],time()+2*7*24*3600);
                $url = link_url('index',array('mov'=>'detail','id'=>$id));
                Header("Location: ".$url);
            }else{
                message('密码不正确，请重新输入','','error');
            }           
        }
        $click = $content['click']; 
        $juji = iunserializer($content['video_url']);
        foreach ($juji as $key => $value) {
            $juji[$key] = array(
                'url' => $value['link'],
                'name' => $value['title'],
                'from' => $value['title'],
                'nid' => $key,
            );
        }
        if (count($juji) < 2) {
            $url = $juji['0']['url'];
            $url = tomedia($url);
        }else{
            $url = $_GPC['url'];
            if (!$url) {
                $url = $juji['0']['url'];
                $url = tomedia($url);
            }
        }
        $is_charge = pdo_get('cyl_vip_video_order',array('uniacid'=>$_W['uniacid'],'video_id'=>$id));
        $is_vip = is_vip($content['id'],'id');
        pdo_update('cyl_vip_video_manage', array('click +=' => 1), array('id' => $id));                 
    }elseif ($op == 'yule' || $op == 'gaoxiao') {
        $url = kan360($url);        
        $content['title'] = $url['title'];      
        $content['thumb'] = $url['thumb'];      
        $url = $url['mp4'];
        // $tuijian = pc_caiji_detail_tuijian($url);
    }else{ 
        $site = array(); 
        $vip_url = $_W['siteurl'];     
        $is_vip = is_vip($vip_url,'url');
        $url_time = cache_load('pc_caiji_detail:'.$_GPC['d_id']); 
        if ((TIMESTAMP - $url_time) > 3600 ) {
            $url = m3u8();
            $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
            $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&id=".$_GPC['d_id'];
            $response = ihttp_get($url); 
            $content = json_decode($response['content'],true); 
            $tuijian = $content['tuijian'];  
            cache_write('pc_caiji_detail:'.$_GPC['d_id'], TIMESTAMP);                                 
            cache_write('content:'.$_GPC['d_id'], $content);  
            cache_write('tuijian:'.$_GPC['d_id'], $tuijian);  
        }else{
            $content = cache_load('content:'.$_GPC['d_id']);
            $tuijian = cache_load('tuijian:'.$_GPC['d_id']); 
        }       
        $content['title'] = $content['vod_name'];
        $content['star'] = $content['vod_score'];
        $content['year'] = $content['vod_year'];
        $content['area'] = $content['vod_area'];
        $content['actor'] = $content['vod_actor'];
        $content['desc'] = $content['vod_content'];
        $content['thumb'] = $content['vod_pic'];            
        if (strexists($content['thumb'], 'tu')) {
            $content['thumb'] = MODULE_URL . $content['thumb'];   
            $content['thumb'] = trim($content['thumb']);                  
        }         
        $play_list = $content['vod_play_list'];
        $site_list = array();
        foreach ($play_list as $key => $value) {
            $site_list[] = $value['sid'];
        }
        if ($_GPC['site']) {
            current($site_list);
            $site_title = $play_list[$_GPC['site']]['player_info']['des'];
        }else{
            $site_title = current($play_list);
            
            $site_title = $site_title['player_info']['des'];
        }
        $playurl = $content['playurl'];
        $jishu = $_GPC['jishu'];        
        if ($_GPC['site']) {
            $first_val = $play_list[$_GPC['site']];

        }else{
            $first_val = current($play_list);                
        } 
        if ($jishu) {
            $url = $first_val['urls'][$jishu]['url'];
        }else{
            $jishu = 1;
            $url = $first_val['urls'][$jishu]['url'];
        }
        $juji = $first_val['urls'];
        if ($first_val['urls']['1']['name'] == $first_val['url_count']) {
            $jishu_zidong = $jishu - 1;
        }else{
            $jishu_zidong = $jishu + 1;
        }           
        if (strexists($url,'27pan')) {
             $url = pan27($url);
        }
        foreach ($tuijian as $key => &$value) {
            if (strexists($value['vod_pic'], 'tu.php')) {
                $value['vod_pic'] = MODULE_URL . $value['vod_pic'];                    
            }                
        }
        if ($first_val['player_info']['des'] == '27') {
            $is_cdn = 'false';
        }   
        isetcookie ('shangci', $_W['siteurl']);
        isetcookie ('shangci_title', $content['title']);
        isetcookie ('shangci_jishu', $_GPC['jishu']);   
        $click = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND video_id = :video_id ",array(':uniacid'=>$_W['uniacid'],':video_id'=>$_GPC['d_id']));           
    }
    $json = array();
    // $url = 'http://wxsnsdy.tc.qq.com/105/20210/snsdyvideodownload?filekey=30280201010421301f0201690402534804102ca905ce620b1241b726bc41dcff44e00204012882540400&bizid=1023&hy=SH&fileparam=302c020101042530230204136ffd93020457e3c4ff02024ef202031e8d7f02030f42400204045a320a0201000400';
    $json['src'] = $url;
    $json['name'] = $content['vod_name'] ? $content['vod_name'] : $content['title'];
    $json['source'] = $content['vod_score'] ? $content['vod_score'] : $content['star'];
    $json['director'] = $content['vod_director'];
    $json['actor'] = $content['vod_actor']; 
    $json['area'] = $content['area']; 
    $json['esTags'] = $content['vod_class']; 
    $json['desc'] = $content['desc']; 
    $json['tuijian'] = $tuijian;      
    $json['jishu'] = $jishu;
    $json['juji'] = $juji;
    $json['site_title'] = $site_title;
    $json['ismember'] = $member['end_time'] > TIMESTAMP ? true : false;
    foreach ($play_list as $key => $value) {
       $newplay_list[] = $value;
    }
    $json['play_list'] = $newplay_list;
    result(0, 'success' ,$json);    
}
public function doMobilenewsHistory() {
    global $_W, $_GPC;
    $member = $this->getuid();
    $uid = $member['uid'];
    $d_id = $_GPC['d_id']; 
    if (!$uid) {
        result(0, '请先登陆',-1);
    } 
    $op = $_GPC['op'] ? $_GPC['op'] : 'post'; 
    if ($op == 'list') {
        $list = pdo_getall('cyl_vip_video_history',array('uid'=>$uid,'uniacid'=>$_W['uniacid']),array(),'',array('time DESC'));
        result(0, 'success',$list);
    } 
    if ($op == 'del') {
        $list = pdo_delete('cyl_vip_video_history',array('uid'=>$uid,'uniacid'=>$_W['uniacid']));
        result(0, 'success',$list);
    }   
    if ($op == 'post') {
        if ($uid) {
            $data = pdo_get('cyl_vip_video_history',array('uid'=>$uid,'d_id'=>$d_id));
            if ($data) {
                pdo_update('cyl_vip_video_history', array('jishu'=>$_GPC['jishu'],'time'=>TIMESTAMP),array('id'=>$data['id']));
            }else{
                pdo_insert('cyl_vip_video_history', array('uid'=>$uid,'d_id'=>$d_id,'uniacid'=>$_W['uniacid'],'title'=>$_GPC['title'],'time'=>TIMESTAMP));
            }
        }    
    }   
       
}
public function doMobileCollection() {
    global $_W, $_GPC;    
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';
    $member = $this->getuid();   
    $uid = $member['uid'];
    if (!$uid) {
        result(0, '请先登陆',-1);
    } 
    if ($op == 'list') {
        $list = pdo_getall('cyl_vip_video_collection',array('uid'=>$uid,'uniacid'=>$_W['uniacid']),array(),'',array('id DESC'));
        result(0, 'success',$list);
    }
    if ($op == 'collection') {
        $d_id = $_GPC['d_id']; 
        $collection = pdo_get('cyl_vip_video_collection',array('uid'=>$uid,'d_id'=>$d_id));
        if ($collection) {
            $result = pdo_delete('cyl_vip_video_collection', array('id'=>$collection['id']));
            if (!empty($result)) {            
                result(0, '取消收藏',array('isCollection'=>0));
            }else{
                result(-1, '收藏失败');
            }
        }else{
            $result = pdo_insert('cyl_vip_video_collection', array('uid'=>$uid,'d_id'=>$d_id,'uniacid'=>$_W['uniacid'],'title'=>$_GPC['title']));
            if (!empty($result)) {            
                result(0, '收藏成功',array('isCollection'=>1));
            }else{
                result(-1, '收藏失败');
            }
        }    
    } 
    if ($op == 'del') {
        $id = $_GPC['id'];
        $list = pdo_delete('cyl_vip_video_collection',array('uid'=>$uid,'uniacid'=>$_W['uniacid'],'id'=>$id)); 
        result(0, '清空成功');
    } 
    if ($op == 'get') {
        $d_id = $_GPC['d_id'];
        $collection = pdo_get('cyl_vip_video_collection',array('uid'=>$uid,'d_id'=>$d_id)); 
        result(0, '清空成功',$collection);
    }               
}
public function doMobilenewsMember() {
    global $_W, $_GPC; 
    $member = $this->getuid();        
    $data['avatarUrl'] = $member['avatar'] ? $member['avatar'] : $_W['uniaccount']['logo'];
    $data['nickName'] = $member['nickname'] ? $member['nickname'] : $member['mobile'];
    $data['member'] = $member;
    $data['uid'] = $member['uid'];
    $data['credit1'] = $member['credit1'];
    $data['end_time'] = date('Y-m-d H:i:s',$member['end_time']);
    $cyl_vip_video_history = pdo_get('cyl_vip_video_history',array('uid'=>$data['uid']),array('COUNT(*) AS count'));
    $data['historynum'] = $cyl_vip_video_history['count'];
    $cyl_vip_video_collection = pdo_get('cyl_vip_video_collection',array('uid'=>$data['uid']),array('COUNT(*) AS count'));
    $data['collectionnum'] = $cyl_vip_video_collection['count'];
    result(0, 'success' ,$data);    
}
public function doMobileOrder() {
    global $_W, $_GPC; 
    $member = $this->getuid(); 
    if (!$member['openid']) {
        result(-1, '未登陆'); 
    }      
    $data = array(
        'uniacid' => $_W['uniacid'],
        'openid' => $member['openid'],
    );
    $list = pdo_getall('cyl_vip_video_order', $data, array() , '' , 'id DESC'); 
    foreach ($list as $key => $value) {
        $list[$key] = array(
            'fee' => $value['fee'],
            'time' => date('Y-m-d H:i:s',$value['time']),
            'status' => $value['status'] ? '已支付' : '未支付',
            'day' => $value['day'],
        );
    }
    result(0, 'success' ,$list);    
}
public function doMobileCard() {
    global $_W, $_GPC; 
    $acc = WeAccount::create(); 
    $member = $this->getuid();
    $uid = $member['uid'];               
    $data = array(
        'uniacid' => $_W['uniacid'],
        'pwd' => trim($_GPC['card']),                  
    );
    $card = pdo_get('cyl_vip_video_keyword_id', $data, array() , '' , 'id DESC');
    if (!$card) {
        result(0, '兑换码无效','error');  
    }elseif ($card['status']) {
        result(0, '兑换码已使用','error');   
    }else{
        $res = pdo_update('cyl_vip_video_keyword_id', array('status'=>1,'openid'=>$member['openid']), array('id'=>$card['id']));                    
        if($res){
            if ($member['openid']) {
                if ($member['end_time']) { 
                    pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$card['day']." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
                    $time = date('Y-m-d H:i:s',strtotime("+".$card['day']." days",$member['end_time']));
                }else{                      
                    pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$card['day']." days")), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
                    $time = date('Y-m-d H:i:s',strtotime("+".$card['day']." days"));
                }
            } 
            if($settings['tpl_id']) {
                $data = array(
                    'first' => array(
                        'value' => '您好,'.$member['nickname'].'开通了'.$card['day'].'天会员',
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => '会员开通',
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => '开通提醒',
                        'color' => '#ff510'
                    ) ,                    
                    'remark' => array(
                        'value' => '卡密兑换'.$card['day'].'天,到期时间'.$time,
                        'color' => '#ff510'
                    ) ,
                );
                $url = link_url('member');
                $acc->sendTplNotice($member['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                $data = array(
                    'first' => array(
                        'value' => $member['nickname'].'开通了'.$card['day'].'天会员',
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => '会员开通',
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => '开通提醒',
                        'color' => '#ff510'
                    ) ,                    
                    'remark' => array(
                        'value' => '卡密兑换'.$card['day'].'天，到期时间'.$time.'请进入后台查看',
                        'color' => '#ff510'
                    ) ,
                );                  
                $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
            }
            $data = array(
                'uniacid' => $_W['uniacid'],
                'openid' => $member['openid'],
                'uid' => $uid,
                'tid' => '卡密兑换',
                'fee' => '',                
                'status' => 1,
                'day' => $card['day'],
                'time' => TIMESTAMP
            );                  
            pdo_insert('cyl_vip_video_order',$data);
            $member = $this->getuid();
            result(0, '兑换成功',$member);
        }
    }  
}
public function doMobileOpen(){
    global $_W, $_GPC; 
    $settings = $this->module['config']; 
    $acc = WeAccount::create(); 
    $member = $this->getuid();
    $uid = $member['uid'];             
    $credit = mc_credit_fetch($member['uid']);
    $card = iunserializer($settings['card']); 
    $card = $card[$_GPC['key']];
    $day = $card['day'];
    $fee = $card['card_fee'];
    $day = $card['card_day'];
    $jifen = $card['card_credit'];
    $fee = $jifen;                      
    if (!$card) {
        result(-1, '非法操作');
    }
    if ($fee > $credit['credit1']) {
        result(-1,'积分不足');
    }
    if (empty($fee)) {
        message('管理员未设置积分，请使用微信支付兑换','','error');
    }
    $data = array(
        'uniacid' => $_W['uniacid'],
        'openid' => $member['openid'],
        'uid' => $member['uid'],
        'tid' => '积分兑换',
        'fee' => $fee,              
        'status' => 1,
        'day' => $day,
        'time' => TIMESTAMP
    );           
    pdo_insert('cyl_vip_video_order',$data);
    mc_credit_update($member['uid'], 'credit1', -$fee, array($member['uid'], '视频会员开通-'.$fee.'积分','super_mov'));
    if ($member['openid']) {
        if ($member['end_time']) { 
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time']));
        }else{                      
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
        } 
    }
    if($settings['tpl_id']) {
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'],
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => $params['tid'],
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => '支付成功',
                    'color' => '#ff510'
                ) ,   
                'keyword3' => array(
                    'value' => date('Y-m-d H:i:s',TIMESTAMP),
                    'color' => '#ff510'
                ) ,    
                'keyword4' => array(
                    'value' => $_W['uniaccount']['name'],
                    'color' => '#ff510'
                ) ,  
                'keyword5' => array(
                    'value' => $fee.'积分',
                    'color' => '#ff510'
                ) ,              
                'remark' => array(
                    'value' => '到期时间：'.$time.'',
                    'color' => '#ff510'
                ) ,
            ); 
            $url = link_url('member');
            $acc->sendTplNotice($data['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
            $data = array(
                'first' => array(
                    'value' => $member['nickname'].'开通了'.$day.'天会员',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => $params['tid'],
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => '支付成功',
                    'color' => '#ff510'
                ) ,   
                'keyword3' => array(
                    'value' => date('Y-m-d H:i:s',TIMESTAMP),
                    'color' => '#ff510'
                ) ,    
                'keyword4' => array(
                    'value' => $_W['uniaccount']['name'],
                    'color' => '#ff510'
                ) ,  
                'keyword5' => array(
                    'value' => $fee.'积分',
                    'color' => '#ff510'
                ) ,              
                'remark' => array(
                    'value' => '会员到期时间'.$time.'请进入后台查看',
                    'color' => '#ff510'
                ) ,
            );
            $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');   
        
    }
    $member = $this->getuid();
    $member['end_time'] = date('Y-m-d H:i:s',$member['end_time']);
    result(0, '兑换成功',$member);
}
public function doMobileWeixin() {
    global $_W, $_GPC;  
    $setting = setting();   
    $site_name = $setting['member']; 
    $settings = $this->module['config'];  
    if ($setting['member']['card']) {
        $settings['card'] = $setting['member']['card'];
        $settings['pay_settings'] = 1;
        $settingss = iunserializer($site_name['setting']);
        $settings['site_title'] = $settingss['site_title'];
        $settings['copyright'] = $settingss['copyright'];
    } 
    $member = $this->getuid();
    $uid = $member['uid'];             
    $credit = mc_credit_fetch($member['uid']);
    $card = iunserializer($settings['card']);     
    if ($setting['member']['card']) {
        $card = iunserializer($setting['member']['card']);
        $card = $card['card'];
    }
    $card = $card[$_GPC['key']];
    $day = $card['day'];
    $fee = $card['card_fee'];
    $day = $card['card_day'];
    $jifen = $card['card_credit'];
    $amount = $fee;                      
    if (!$card) {
        result(-1, '非法操作');
    }
    $id = $_GPC['id'];  
    $video_id = $_GPC['video_id'];  
    if (is_weixin()) {
       if(empty($member['openid'])){message('非法进入');}  
    }    
    if ($id) {
        $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE id = :id", array(':id' => $id));
        if ($member['openid'] != $order['openid']) {
            result(-1, '非法进入');
        }
        $day = $order['day'];
        $snid = $order['tid'];
        $amount = $order['fee'];     
    }else{
        $snid = date('YmdHis') . str_pad(mt_rand(1, 99999),6, '0', STR_PAD_LEFT);
    }   
    if ($_GPC['type'] == 'shang') {
        $amount = $_GPC['fee']; 
    }
    if ($_GPC['type'] == 'charge') { 
        $video = pdo_get('cyl_vip_video_manage',array('id'=>$video_id));
        $amount = $video['charge']; 
    }
    if($amount < 0.01) {
        result(-1, '支付错误, 金额小于0.01'); 
    }        
    if ($_GPC['type'] == 'shang') {        
        
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
            'uid' => $member['uid'],
            'tid' => $snid,
            'fee' => $amount,               
            'status' => 0,
            'day' => $day,      
            'time' => TIMESTAMP
        );
        $data['desc'] = '视频打赏';
        $title = '视频打赏';
    }elseif ($_GPC['type'] == 'charge') { 
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
            'uid' => $member['uid'],
            'tid' => $snid,
            'fee' => $amount,               
            'video_id' => $video_id,               
            'status' => 0,
            'time' => TIMESTAMP
        );
        $data['desc'] = '视频收费';
        $title = '视频收费';
    }else{
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
            'uid' => $member['uid'],
            'tid' => $snid,
            'fee' => $amount,               
            'status' => 0,
            'day' => $day,      
            'time' => TIMESTAMP
        );
        $title = '会员开通';
    }
    if ($setting['member']['site_name']) {
           $data['site_name'] = $setting['member']['site_name']; 
    }
    if ($id) {
        pdo_update('cyl_vip_video_order',$data,array('id'=>$id));
    }else{
        pdo_insert('cyl_vip_video_order',$data);
        $id = pdo_insertid();
    }
    $params = array(
        'id' => $id,
        'tid' => $snid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码20位
        'ordersn' => $snid,  //收银台中显示的订单号
        'title' => $title,          //收银台中显示的标题
        'fee' => $amount,      //收银台中显示需要支付的金额,只能大于 0
        'user' => $member['uid'],     //付款用户, 付款的用户名(选填项) 
    );
    if ($settings['payment'] == 4) {
        $this->codepay($params);
    }elseif ($settings['payment'] == 2) {
        $data = array(
            'mchid'        => $settings['appkey'],
            'body'         => $title,
            'total_fee'    => $amount * 100,
            'out_trade_no' => $snid,
            'hide' => 1, 
            'notify_url'=> $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&do=jspay&m=super_mov',
            'callback_url'=> $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&tid='.$id.'&do=jspayreturn&m=super_mov',
        );
        $key = $settings['secret_key'];
        $data['sign'] = sign($data, $key); 
        $url = 'https://payjs.cn/api/cashier?' . http_build_query($data);
        header("Location:".$url);  
        // exit();
        // $result = ihttp_post($url, $data);
        // $result = json_decode($result['content'],true);
        // $this->pay($result);
    }else{
        $this->pay($params);
    }
    exit(); 
}
protected function pay($params = array() , $mine = array()) {
    global $_W;
    $settings = $this->module['config'];
    $params['module'] = $this->module['name'];
    $sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
    $pars = array();
    $pars[':uniacid'] = $_W['uniacid'];
    $pars[':module'] = $params['module'];
    $pars[':tid'] = $params['tid'];
    $log = pdo_fetch($sql, $pars);
    if(!empty($log) && $log['status'] == '1') {
        result(-1,'这个订单已经支付成功, 不需要重复支付.');
    }
    $setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
    if(!is_array($setting['payment'])) {
        result(-1,'没有有效的支付方式, 请联系网站管理员.');
    }
    $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
    if (empty($log)) {
        $log = array(
            'uniacid' => $_W['uniacid'],
            'acid' => $_W['acid'],
            'openid' => $_W['member']['uid'],
            'module' => $this->module['name'],              'tid' => $params['tid'],
            'fee' => $params['fee'],
            'card_fee' => $params['fee'],
            'status' => '0',
            'is_usecard' => '0',
        );
        pdo_insert('core_paylog', $log);
    } 
    $pay = $setting['payment'];
    foreach ($pay as &$value) {
        $value['switch'] = $value['pay_switch'];
    }    
    if (!is_weixin() && $settings['weixin_h5'] != 1 ) {  
        $pays = $params['fee']; //获取需要支付的价格
        #插入语句书写的地方
        $conf = $this->payconfig($params['tid'], $pays * 100, '会员开通');
        if (!$conf || $conf['return_code'] == 'FAIL')
            result(-1, '对不起，微信支付接口调用错误!' . $conf['return_msg']); 
          
        $conf['mweb_url'] = $conf['mweb_url'] . '&redirect_url=' . urlencode($this->wxpay['notify_url'].'&tid='.$params['tid'].'&order_id='.$params['id']); 
        $url = $conf['mweb_url']; 
    }else{
        unset($value);
        $pay['credit']['switch'] = false;
        $pay['delivery']['switch'] = false;     
        $url = url('mc/cash/wechat', array('params' => base64_encode(json_encode($params))));
        if ($settings['is_news'] == 1) {
        	header("location:" . $url);
        }else{
        	result(0,'即将跳转支付',$url); 
        }
        
        exit();
    }
}
public function doMobileRegister() {
    global $_W, $_GPC;  
    $openid = $_W['openid'];
    $sql = 'SELECT `uid` FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid';
    $pars = array();
    $pars[':uniacid'] = $_W['acid'];
    $code = trim($_GPC['code']);        
    $username = trim($_GPC['username']);
    $password = trim($_GPC['password']);
    load()->model('utility');
    if (!code_verify($_W['uniacid'], $username, $password)) {
        result(-1,'验证码错误');
    } else {
        pdo_delete('uni_verifycode', array('receiver' => $username));
    }
    $type = 'mobile';
    $sql .= ' AND `mobile`=:mobile';
    $pars[':mobile'] = $username;
    $user = pdo_fetch($sql, $pars);
    if(!empty($_W['openid'])) {
        $fan = mc_fansinfo($_W['openid']);
        if (!empty($fan)) {
            $map_fans = $fan['tag'];
        }
        if (empty($map_fans) && isset($_SESSION['userinfo'])) {
            $map_fans = iunserializer(base64_decode($_SESSION['userinfo']));
        }
    }
    $default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['acid']));
    $data = array(
        'uniacid' => $_W['acid'],
        'salt' => random(8),
        'groupid' => $default_groupid, 
        'createtime' => TIMESTAMP,
    );     
    $data['mobile'] = $type == 'mobile' ? $username : '';
    if (!empty($password)) {
        $data['password'] = md5($password . $data['salt'] . $_W['config']['setting']['authkey']);
    }
    if (empty($type)) {
        $data['mobile'] = $username;
    }
    if(!empty($map_fans)) {
        $data['nickname'] = strip_emoji($map_fans['nickname']);
        $data['gender'] = $map_fans['sex'];
        $data['residecity'] = $map_fans['city'] ? $map_fans['city'] . '市' : '';
        $data['resideprovince'] = $map_fans['province'] ? $map_fans['province'] . '省' : '';
        $data['nationality'] = $map_fans['country'];
        $data['avatar'] = $map_fans['headimgurl'];
    }
    if(!empty($user)) {
        pdo_update('mc_members', $data,array('mobile' => $username));           
    }else{
        pdo_insert('mc_members', $data);
        $user['uid'] = pdo_insertid();          
    }
    pdo_insert('cyl_video_sessions', array('sid' => $_W['session_id'], 'uniacid' => $_W['acid'], 'uid' => $user['uid']));

    $phone = $data['mobile'];
    $member = pdo_get('cyl_vip_video_member', array('phone'=>$phone,'uniacid'=>$_W['uniacid']));
    $data = array(
        'uniacid' => $_W['uniacid'],
        'phone' => $phone,
        'uid' => $user['uid'],
        'time' => TIMESTAMP, 
        'old_time' => TIMESTAMP,
        'password' => md5($_GPC['password']),
        'openid' => $phone,
    );
    if (is_weixin() && $_W['oauth_account']['level'] == 4) {
        $data['openid'] = $_W['openid'];
    }        
    if($member) {
        $res = pdo_update('cyl_vip_video_member', $data,array('id'=>$member['id'])); 
    }else{
        $res = pdo_insert('cyl_vip_video_member', $data);
    }            
    isetcookie('phone',$phone,3600*24*24);
    if (!empty($fan) && !empty($fan['fanid'])) {
        pdo_update('mc_mapping_fans', array('uid'=>$user['uid']), array('fanid'=>$fan['fanid'])); 
    }
    if($user['uid']) {
        result(0 ,'登陆成功！',array('sessionid' => $_W['session_id'], 'userinfo' => $user, 'openid' => $username));        
    } 
    result(0, 'success' ,$data);    
}
public function doMobileSms() {
    global $_GPC, $_W;
    load()->model('utility');
    pdo_delete('uni_verifycode', array('createtime <' => TIMESTAMP - 1800)); 
    $receiver = trim($_GPC['receiver']);
    $verifycode_table = table('uni_verifycode');

    $row = $verifycode_table->getByReceiverVerifycode($_W['uniacid'], $receiver, ''); 
    $record = array();
    $code = random(6, true);

    if(!empty($row)) {
        $failed_count = table('uni_verifycode')->getFailedCountByReceiver($receiver);
        if($row['total'] >= 5) {
            result(-1, '您的操作过于频繁,请稍后再试');
        }
        $record['total'] = $row['total'] + 1;
    } else {
        $record['uniacid'] = $_W['uniacid'];
        $record['receiver'] = $receiver;
        $record['total'] = 1;
    }
    $record['verifycode'] = $code;
    $record['createtime'] = TIMESTAMP;
    if(!empty($row)) {
        pdo_update('uni_verifycode', $record, array('id' => $row['id']));
    } else {
        pdo_insert('uni_verifycode', $record);
    }
    $res = sendsms($receiver,$code);
    $res = json_decode($res,true);
    if($res['errmsg'] == 'OK'){ 
        result(0, 'success',$res);   
    }else{
        result(-1, $res['Message']);
    }           
}
public function doMobileClearStorage() {
    global $_W, $_GPC;  
    $member = $this->getuid();     
    $result = pdo_delete('cyl_video_sessions', array('uid'=>$member['uid']));
    result(0, 'success');    
}
public function doMobileOpenid(){
    global $_W, $_GPC;
    load()->model('mc');
    $oauth = $_GPC['userInfo'];
    $openid = $_GPC['openid'];
    if (empty($openid) && !empty($_W['openid'])) {
        $openid = $_W['openid'];
    }
    if (!empty($openid)) {
        $fans = mc_fansinfo($openid,$_W['acid']);
        if (!empty($fans)) {
            result(0, '', array('sessionid' => $_W['session_id'], 'userinfo' => $fans));
        } else {
            result(1, 'openid不存在');
        }
    }
    $oauth = array(
        'openid' => $_GPC['openid1'], 
        'unionid' => $_GPC['unionid'], 
    );     
    if (!empty($oauth) && !is_error($oauth)) {
        $fans = mc_fansinfo($oauth['openid'],$_W['acid']);        
        if (empty($fans)) {
            $record = array(
                'openid' => $oauth['openid'],
                'unionid' => $oauth['unionid'],
                'uid' => 0,
                'acid' => $_W['acid'],
                'uniacid' => $_W['acid'],
                'salt' => random(8),
                'updatetime' => TIMESTAMP,
                'nickname' => '',
                'follow' => '1',
                'followtime' => TIMESTAMP,
                'unfollowtime' => 0,
                'tag' => '',
            );
            $email = md5($oauth['openid']).'@we7.cc';
            $email_exists_member = pdo_getcolumn('mc_members', array('email' => $email, 'uniacid' => $_W['acid']), 'uid');
            if (!empty($email_exists_member)) {
                $uid = $email_exists_member;
            } else {
                $default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['acid']));
                $data = array(
                    'uniacid' => $_W['acid'],
                    'email' => $email,
                    'salt' => random(8),
                    'groupid' => $default_groupid,
                    'createtime' => TIMESTAMP,
                    'password' => md5($message['from'] . $data['salt'] . $_W['config']['setting']['authkey']),
                    'nickname' => '',
                    'avatar' => '',
                    'gender' => '',
                    'nationality' => '',
                    'resideprovince' => '',
                    'residecity' => '',
                );
                pdo_insert('mc_members', $data);
                $uid = pdo_insertid();
            }
            $record['uid'] = $uid;
            $_SESSION['uid'] = $uid;
            pdo_insert('mc_mapping_fans', $record);
        } else {
            $userinfo = $fans['tag'];
            $uid = $fans['uid'];
        }
        if (empty($userinfo)) {
            $userinfo = array(
                'openid' => $oauth['openid'],
            );
        }
        result(0, '', array('sessionid' => $_W['session_id'], 'userinfo' => $fans, 'openid' => $oauth['openid']));
    } else {
        result(1, $oauth['errMsg']);
    }
}
public function doMobileUserinfo() {
    global $_W, $_GPC;  
    load()->model('mc');      
    $userinfo = array(
        'openId' => $_GPC['openId'], 
        'nickName' => $_GPC['nickName'], 
        'gender' => $_GPC['gender'], 
        'city' => $_GPC['city'], 
        'province' => $_GPC['province'], 
        'avatarUrl' => $_GPC['avatarUrl'], 
        'unionId' => $_GPC['unionid'], 
    );
    $userinfo['nickname'] = $userinfo['nickName'];
    $_SESSION['userinfo'] = base64_encode(iserializer($userinfo));
    $fans = mc_fansinfo($userinfo['openId']);
    $fans_update = array(
        'nickname' => $userinfo['nickName'],
        'unionid' => $userinfo['unionId'],
        'tag' => base64_encode(iserializer(array(
            'subscribe' => 1,
            'openid' => $userinfo['openId'],
            'nickname' => $userinfo['nickName'],
            'sex' => $userinfo['gender'],
            'language' => $userinfo['language'],
            'city' => $userinfo['city'],
            'province' => $userinfo['province'],
            'country' => $userinfo['country'],
            'headimgurl' => $userinfo['avatarUrl'],
        ))),
    );
    if (!empty($userinfo['unionId'])) {
        $union_fans = pdo_get('mc_mapping_fans', array('unionid' => $userinfo['unionId'], 'openid !=' => $userinfo['openId']));        
        if (!empty($union_fans['uid'])) {
            $fans_update['uid'] = $union_fans['uid'];           
        }else{
             $fans_update['uid'] = $fans['uid'];      
        }
    }
    
    
    $member = mc_fetch_one($fans['uid'],$_W['acid']);     
    if (!empty($member)) {
        pdo_update('mc_members', array('nickname' => $userinfo['nickName'], 'avatar' => $userinfo['avatarUrl'], 'gender' => $userinfo['gender']), array('uid' => $fans['uid']));
    }    
    pdo_update('mc_mapping_fans', $fans_update, array('fanid' => $fans['fanid']));
    pdo_insert('cyl_video_sessions', array('sid' => $_W['session_id'], 'uniacid' => $_W['acid'], 'uid' => $fans_update['uid']));
    unset($member['password']);
    unset($member['salt']);
    result(0, '', $member);
}
}