<?php
/*
 * 智能挪车模块
 */
defined('IN_IA') or exit('Access Denied');
define('table', 'beta_car_');
define('uniacid', $_W['uniacid']);
define('openid', $_W['fans']['openid']);
require_once IA_ROOT. "/addons/beta_car/plugin/hwsdk/axmobile.php";
class Beta_carModuleSite extends WeModuleSite {
    public  function  __construct(){
        global $_GPC,$_W;
        if($_W['container']=='wechat'){
            load()->model('mc');
            $user_info = mc_oauth_userinfo($_W['uniacid']);
            if($_GPC['do']=='qrcode' or $_GPC['do']=='bind'){
                $sql = "SELECT a.openid,b.id FROM ".tablename(table.'car').'AS a left join '.tablename(table.'user').'AS b on a.uniacid=b.uniacid and a.openid=b.openid where a.sn='."'".$_GPC['sign']."'";
                $user = pdo_fetch($sql);
                $indata = array('reid'=>$user['id'],'uniacid'=>uniacid,'openid'=>$user_info['openid'],'nickname'=>$user_info['nickname'],'headimg'=>$user_info['headimgurl']);
            }else{
                $indata = array('uniacid'=>uniacid,'openid'=>$user_info['openid'],'nickname'=>$user_info['nickname'],'headimg'=>$user_info['headimgurl']);
            }
            $user = pdo_get(table.'user',array('uniacid'=>uniacid,'openid'=>$user_info['openid']));
            if(empty($user)){
                pdo_insert(table.'user',$indata);
            }
        }
    }

    public function doMobilecoordinate_switchf(){//腾讯转百度坐标转换

        global $_GPC,$_W;
        $json =  file_get_contents('http://api.map.baidu.com/geoconv/v1/?coords='.$_GPC[y].','.$_GPC[x].'&from=1&to=5&ak=F51571495f717ff1194de02366bb8da9');
        echo $json;
    }
    public function payResult($params){
        if ($params['result'] == 'success' && $params['from'] == 'notify') {
            $log = pdo_get(table.'pay',array('order_id'=>$params['tid']));
            if($log['type']=='order'){
                //线上购买订单处理
                $result = pdo_update(table.'order',array('status'=>'1'),array('order_id'=>$params['tid']));
                $cash = pdo_get(table.'unisetting',array('uniacid'=>uniacid));
                if($cash['fw_set']=='1'){
                    if(!empty($result)){
                        $orderinfo = pdo_get(table.'order',array('order_id'=>$params['tid']));
                        $userinfo = pdo_get(table.'user',array('id'=>$orderinfo['userid']));
                        if(!empty($userinfo['reid'])){
                            //上级钱包加钱
                            if(empty($cash)){
                                $u_c = "50";
                            }else{
                                $u_c = $cash['cash'];
                            }
                            $shop = pdo_get(table.'setting',array('uniacid'=>uniacid));
                            $cash_r = $shop['shop']*($u_c/100);
                            $res = pdo_update(table.'user',array('cash +='=>$cash_r),array('id'=>$userinfo['reid']));
                            if(!empty($res)){
                                //站长日志
                                $data = array(
                                    'userid'=>  $userinfo['reid'],
                                    'uniacid'=>uniacid,
                                    'money' =>$cash_r,
                                    'note' => '推荐用户【'.$userinfo['nickname'].'】下单分成',
                                    'time' => time()
                                );
                                pdo_insert(table.'user_log',$data);
                            }
                        }
                    }
                }
            }elseif ($log['type']=='weizhang'){
                //违章包月订单处理
                $res = pdo_get(table.'wzts',array('uniacid'=>uniacid,'sn'=>$log['sn']));
                if(!empty($res)){
                    if($res['status']=='2'){
                        $data = array(
                            'endtime'=>strtotime("+1 month",time()),
                            'status'=>'1',
                            'next_time'=>time()
                        );
                    }else{
                        $data = array(
                            'endtime'=>strtotime("+1 month",$res['endtime']),
                            'status'=>'1',
                            'next_time'=>time()
                        );
                    }
                    $result =pdo_update(table.'wzts',$data,array('uniacid'=>uniacid,'sn'=>$log['sn']));
                }else{
                    $data = array(
                        'order_id'=>$log['order_id'],
                        'uniacid'=>uniacid,
                        'user_id'=>$log['user_id'],
                        'paytime'=>time(),
                        'sn'=>$log['sn'],
                        'endtime'=>strtotime("+1 month"),
                        'status'=>'1',
                        'next_time'=>time()
                    );
                    $result =pdo_insert(table.'wzts',$data);
                }
                //$setting = json_decode(pdo_get(table.'zengzhi',array('uniacid'=>uniacid),'weizhang')['weizhang'],true);
            }elseif($log['type']=='yinsi'){
                $uid = $log['user_id'];
                //获取套餐包
                $taocan =  pdo_get(table . 'yinsi_shop',array('id'=>$log['sn']));
                if(!empty($taocan)){
                    $remain_time = $taocan['remain_time'];
                    //增加时间
                    $res = pdo_query("UPDATE ims_". table ."user SET remain_time = remain_time + :time WHERE id = :uid and uniacid = :uniacid", array(':time' => $remain_time, ':uid' => $uid,':uniacid'=>uniacid));
                    //写入日志
                    if(!empty($res)){
                        $data['user_id'] = $uid;
                        $data['type'] = 1;
                        $data['taocan_name'] = $taocan['name'];
                        $data['taocan_time'] = $remain_time;
                        $data['uniacid'] = uniacid;
                        $data['time'] = time();
                        pdo_insert(table . 'alicall_log',$data);
                    }
//                    file_put_contents(IA_ROOT. '/addons/beta_car/test.txt',print_r(pdo_debug(),true));
                }

            }
        }
    }

    public function ok($msg='更新成功'){
        message($msg,'referer','success');
    }
    public function view($name){
        return  include $this->template($name);
    }


    public function dowebdashboard(){
        global $_GPC,$_W;
        include $this->template('web/dashboard');
    }
    public function mobileurl($url){
        return $this->createMobileUrl($url);
    }
    public function weburl($url){
        return $this->createWebUrl($url);
    }
    public function menu(){
        global $_GPC,$_W;
        $data = array(
//            "dashboard" => array(
//                'title' => '控制台',
//                'url' =>  $this->createWebUrl('dashboard'),
//                'icon' => 'la-dashboard',
//            ),
            "url" => array(
                'title' => '应用入口',
                'url' =>  $this->createWebUrl('url'),
                'icon' => 'la-chain',
            ),
            "setting" => array(
                'title' => '系统设置',
                'url' =>  $this->createWebUrl('setting'),
                'icon' => 'la-cogs',
            ),
            "unisetting" => array(
                'title' => '用户分佣设置',
                'url' =>  $this->createWebUrl('unisetting'),
                'icon' => 'la-diamond',
            ),
            "uni_tixian" => array(
                'title' => '用户提现',
                'url' =>  $this->createWebUrl('uni_tixian'),
                'icon' => 'la-rotate-right',
            ),"order" => array(
                'title' => '订单管理',
                'url' =>  $this->createWebUrl('order'),
                'icon' => 'la-area-chart',
            ),
            "user_list" => array(
                'title' => '用户列表',
                'url' =>  $this->createWebUrl('user_list'),
                'icon' => 'la-user',
            ),
            "car_list" => array(
                'title' => '车辆列表',
                'url' =>  $this->createWebUrl('car_list'),
                'icon' => 'la-automobile',
            ),
//            "car_list" => array(
//            'title' => '挪车记录',
//            'url' =>  $this->createWebUrl('car_location'),
//            'icon' => 'la-automobile',
//            ),
            "zengzhi" => array(
                'title' => '增值服务',
                'url' =>  $this->createWebUrl('zengzhi'),
                'icon' => 'la-money',
            ), "yinsi" => array(
                'title' => '隐私号码',
                'url' =>  $this->createWebUrl('yinsi'),
                'icon' => 'la-phone',
            ),"qudao" => array(
                'title' => '渠道管理',
                'url' =>  $this->createWebUrl('qudao'),
                'icon' => 'la-pinterest-square',
            ),"seller" => array(
                'title' => '合作商家管理',
                'url' =>  $this->createWebUrl('seller'),
                'icon' => 'la-certificate',
            ),"ad" => array(
                'title' => '广告管理',
                'url' =>  $this->createWebUrl('ad'),
                'icon' => 'la la-image',
            ),"nullqrcode" => array(
                'title' => '空码管理',
                'url' =>  $this->createWebUrl('nullqrcode'),
                'icon' => 'la-qrcode',
            ),
            "wzcode" => array(
                'title' => '违章激活码',
                'url' =>  $this->createWebUrl('wzcode'),
                'icon' => 'la-code-fork',
            )
        );
        foreach ($data as $k=>$row){
            if($_GPC['do']==$k) {
                $data[$k]['no'] = 'no';
            }
        }
        return $data;
    }


    function getDistance($lat1, $lng1, $lat2, $lng2){
        $radLat1 = deg2rad($lat1);
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        if($s>=1000){
            $s= round(($s/1000),2).' 千米';
        }else{
            $s= round($s,2).' 米';
        }
        return $s;
    }
    //二维码生成 /*
    //$text 二维码内容
    //$name 二维码保存名称
    //$sn 二维码编号
    //
    //*/

    public function qrcode($text,$name,$sn){
        load()->library('qrcode');
        $path = MODULE_ROOT."/data/qrcode/";
        $path .= date('Ymd',time());
        if(!file_exists($path))//文件夹不存在，先生成文件夹
        {
            mkdir($path);
        }
        $QRDir =  MODULE_ROOT."/data/qrcode/".date('Ymd',time()).'/'.$name.".png"; //生成的图片路径
        $errorCorrectionLevel = 'H';//容错率
        $matrixPointSize = 50 ;//生成的图片的大小
        $margin = 2;
        $qrCode = new QRcode();
        $qrCode->png($text, $QRDir, $errorCorrectionLevel, $matrixPointSize, $margin);
        $this-> resizejpg($QRDir,560,560);
        $path_1 = MODULE_ROOT."/data/qrcode/car.png";
        $path_2 = $QRDir;
        $image_1 = imagecreatefrompng($path_1);
        $image_2 = imagecreatefrompng($path_2);
        $image_3 = imageCreatetruecolor(imagesx($image_1),imagesy($image_1));
        imagecopyresampled($image_3, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));
        imagecopymerge($image_3, $image_2, 315, 410,0, 0, imagesx($image_2), imagesy($image_2), 100);
        //合成带logo的二维码图片跟 模板图片--------------end
        //输出到本地文件夹
        //$fileName=md5(basename(MODULE_ROOT."/data/car.png").$url);
        $black = imagecolorallocate($image_3, 0, 0, 0);
        imagefttext($image_3, 30, 0, 421,1140, $black, MODULE_ROOT.'/data/qrcode/font.ttf', 'No.'.$sn);
        imagepng($image_3,$QRDir);
        imagedestroy($image_3);
        //返回生成的路径
        return date('Ymd',time()).'/'.$name.".png";
    }
    function resizejpg($imgsrc,$imgwidth,$imgheight)
    {
        $dir = $imgsrc;
        $arr = getimagesize($imgsrc);
        $imgWidth = $imgwidth;
        $imgHeight = $imgheight;
        $imgsrc = imagecreatefrompng($imgsrc);
        $image = imagecreatetruecolor($imgWidth, $imgHeight); //创建一个彩色的底图
        imagecopyresampled($image, $imgsrc, 0, 0, 0, 0,$imgWidth,$imgHeight,$arr[0], $arr[1]);
        imagepng($image, $dir);
        imagedestroy($image);
    }
    public function instert($table,$data){
        return pdo_insert(table.$table,$data);
    }
    public function update($table,$data,$zd){
        return pdo_update(table.$table,$data,$zd);
    }
    public function find($table,$conditino,$fields){
        return pdo_get(table.$table,$conditino,$fields);
    }
    public function select($table,$conditino,$fields){
        return pdo_getall(table.$table,$conditino,$fields);
    }
    public function check_wx($diemsg='请在微信客户端中打开链接'){
        global $_GPC,$_W;
        $isMobile = stripos($_W['script_name'], '/app/index.php');
        $isWeb = stripos($_W['script_name'], '/web/index.php');
        $isPay = stripos($_W['script_name'], '/payment/wechat/notify.php');
        if($_W['container']!='wechat'){
            if(!$isWeb){
                if($_W['script_name']!='/payment/wechat/notify.php' && $_GPC['do']!='wzts'){
                    exit("<!DOCTYPE html>\r\n                <html>\r\n                    <head>\r\n                        <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>\r\n                        <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>\r\n                    </head>\r\n                    <body>\r\n                    <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>" . $diemsg . "</h4></div></div></div>\r\n                    </body>\r\n                </html>");
                }
            }
        }
    }
    public function uid(){
        $user = pdo_get(table.'user',array('uniacid'=>uniacid,'openid'=>openid),['id']);
        return $user['id'];
    }
    public function domobilehuawei(){
//    $huawei = new huawei();
//    $huawei->APP_KEY = '231312312';
//    print_r($huawei->test());
    }

}