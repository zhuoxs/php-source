<?php

/**

 * 小程序模块微站定义

 *

 * @author

 * @url 

 */

defined('IN_IA') or exit('Access Denied');
define('APP_PATH', __DIR__.'/app/');
require_once __DIR__."/vendor/autoload.php";

require 'inc/func/core.php';
require 'inc/func/func.php';

class Ymmf_sunModuleSite extends Core {

    public function __call($name, $arguments){
        global $_GPC;
        $do = strtolower(substr($name, 5));
        $classname = isset($_GPC['ctrl'])&&$_GPC['ctrl']?$_GPC['ctrl']:'';

        //========兼容使用======
        $menumatch = include APP_PATH.'/admin/menumatch.php';
        if(empty($classname)){
            if(array_key_exists($do,$menumatch)){
                $classname = $menumatch[$do];
            }
        }
        //========兼容使用======

        $class = 'app\\admin\\controller\\'.$classname.'Class';

        $hasmethod = false;
        if (class_exists($class)){
            $obj = new $class();
            if(method_exists($obj,$do)){
                $obj->$do();
                $hasmethod = true;
            }
        }
        //========兼容使用======
        if(!$hasmethod){
            $file = __DIR__ . "/inc/web/" . $do . ".inc.php";
            if (file_exists($file)) {
                require $file;//兼容inc
            } elseif (method_exists($this, $name)) {
                $this->$name();//兼容本类
            } else {
                exit('404');
            }
        }
        //========兼容使用======
//        core\Bootstrap::run($name,$arguments);
    }

    public function doWebNotify($data){
        global $_W;
        $attach = $data['attach'];
        $transaction_id = $data['transaction_id'];
        if($attach){
            $attach_arr = json_decode($attach,true);
            $_W['uniacid'] = $uniacid = $attach_arr["uniacid"];
            $ordertype = $attach_arr["ordertype"];//0默认抢购，1拼团，5砍价，3集卡，4普通，6免单
        }else{
            die('FAIL');
        }

        $isprint = false;
        $issms = false;

        $out_trade_no = $data['out_trade_no'];
        //获取订单数据
        if($ordertype==1){//普通
            $orderinfo = pdo_get('ymmf_sun_order', array('out_trade_no' => $out_trade_no,'uniacid' => $uniacid,'state' => 10));

//            file_put_contents('notify.txt', "-----",FILE_APPEND);
//            file_put_contents('notify.txt', print_r($orderinfo, true),FILE_APPEND);

            if($orderinfo){
                $datas = array();
                $datas['state'] = 20;
                $datas['pay_time'] = time();
                $datas['notify_msg'] = serialize($data);
                $datas['transaction_id'] = $transaction_id;
                $order = pdo_update('ymmf_sun_order', $datas, array('id' => $orderinfo['id'], 'uniacid' => $uniacid));
//
//                file_put_contents('notify.txt', "-----",FILE_APPEND);
//                file_put_contents('notify.txt', print_r($datas, true),FILE_APPEND);

                if($order){
                    pdo_update('ymmf_sun_hairers',array("appoint +="=>1),array('id'=>$orderinfo['hair_id'],'uniacid'=>$uniacid));

                    $visitor = array(
                        'uniacid'=>$_W['uniacid'],
                        'uid'=>$orderinfo['user_id'],
                        'time'=>date('Y-m-d',time())
                    );
                    pdo_insert('ymmf_sun_visitor',$visitor);

                    //========计算分销佣金 S===========
                    include_once IA_ROOT . '/addons/ymmf_sun/inc/func/distribution.php';
                    $distribution = new Distribution();
                    $distribution->order_id = $orderinfo['id'];
                    $distribution->money = $orderinfo['money'];
                    $distribution->userid = $orderinfo['user_id'];
                    $distribution->ordertype = 1;
                    $distribution->computecommission();
                    //========计算分销佣金 E===========
                }
            }
            $isprint = true;
            $issms = true;
        }elseif($ordertype==2){//砍价
            $orderinfo = pdo_get('ymmf_sun_kjorder', array('out_trade_no' => $out_trade_no,'uniacid' => $uniacid,'status' => 2));
            if($orderinfo){
                //获取订单信息
                $datas['status'] = 3;
                $datas['pay_time'] = time();
                $datas['notify_msg'] = serialize($data);
                $datas['transaction_id'] = $transaction_id;
                $order = pdo_update('ymmf_sun_kjorder', $datas, array('id' => $orderinfo['id']));

                //修改砍价状态
                $status['status'] = 2;
                $user_bargain = pdo_update('ymmf_sun_user_bargain',$status,array('uniacid'=>$uniacid,'mch_id'=>0,'gid'=>$orderinfo['gid'],'openid'=>$orderinfo['openid']));
            }
        }

        //打印订单
        if($isprint){
            // 获取平台打印
            $print = pdo_get('ymmf_sun_printing',array('uniacid'=>$_W['uniacid']));
            if($print['is_open']==1){
                //打印机
                $this->feiePrintter($orderinfo,$ordertype,$uniacid);
            }
        }

        //短信接口
        if($issms){
            // 调用短信接口
            // 平台数据
            $sms = pdo_get('ymmf_sun_sms',array('uniacid'=>$_W['uniacid']));
            if($sms['is_open']==1){
                // 个人号码
                $mobile = pdo_getcolumn('ymmf_sun_hairers',array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['hair_id']),'mobile');
                $phone = [
                    0=>$sms['mobile'],
                    1=>$mobile
                ];
                foreach ($phone as $k=>$v){
                    $this->Shortmessage($v);
                }
            }
        }

        die('SUCCESS');
    }

    //打印相关
    private function feiePrintter($orderinfo,$ordertype,$uniacid){
        include_once IA_ROOT . '/addons/ymmf_sun/api/printer/printer.php';
        include_once IA_ROOT . '/addons/ymmf_sun/api/HttpClient.class.php';
        //=========订单打印 S==========
        //获取商家打印信息
        if($orderinfo["build_id"]>0){
            $printing = pdo_get('ymmf_sun_branch',array('id'=>$orderinfo['build_id']));
            $orderinfo['build_name'] = $printing['name'];
            $hair_name = pdo_getcolumn('ymmf_sun_hairers',array('id'=>$orderinfo['hair_id']),'hair_name');
            $orderinfo['hair_name'] = $hair_name;
            if($printing){
                $Printer = new \Printer();
                $Printer->wp_print($printing["user"], $printing["key"],$printing["sn"], $orderinfo);
            }
        }
        //=========订单打印 E==========
    }

    // 短信通知
    function Shortmessage($mobile)
    {
        global $_GPC,$_W;
        header('content-type:text/html;charset=utf-8');

        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
        // 获取短信模板数据
        $sms = pdo_get('ymmf_sun_sms',array('uniacid'=>$_W['uniacid']));

        $smsConf = array(
            'key'   => $sms['appkey'], //您申请的APPKEY
            'mobile'    => $mobile, //接受短信的用户手机号码
            'tpl_id'    => $sms['tpl_id'], //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>'#code#=1234&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
        );

        $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信

        if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){
                //状态为0，说明短信发送成功
                echo "短信发送成功,短信ID：".$result['result']['sid'];
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

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
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

//=============================================================================================

//修改区域
	public function doMobileUpdArea() {
		global $_W,$_GPC;
        if($_GPC['num']){
           $data['num']=$_GPC['num']; 
        }
        $res=pdo_update('ymmf_sun_area',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }	

	}
//修改广告
    public function doMobileUpdAd() {
        global $_W,$_GPC;
        if($_GPC['num']){
           $data['orderby']=$_GPC['num']; 
        }
        $res=pdo_update('ymmf_sun_ad',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   

    }
    //修改分类
    public function doMobileUpdType(){
        global $_W,$_GPC;
        if($_GPC['num']){
           $data['num']=$_GPC['num']; 
        }
         if($_GPC['money']){
           $data['money']=$_GPC['money']; 
        }
        $res=pdo_update('ymmf_sun_type',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   
    }

//全部删除二级信息分类
public function doMobileAllDelete(){
    global $_W, $_GPC;
            $res=pdo_delete('ymmf_sun_type2',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('type2',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//全部删除二级商家分类
public function doMobileDeleteType2(){
    global $_W, $_GPC;
        $res=pdo_delete('ymmf_sun_storetype2',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('storetype2',array()),'success');
        }else{
            message('删除失败','','error');
        }
}


  //修改商家分类（价格+顺序）
    public function doMobileUpdType2(){
        global $_W,$_GPC;
        if($_GPC['num']){
           $data['num']=$_GPC['num']; 
        }
         if($_GPC['money']){
           $data['money']=$_GPC['money']; 
        }
        $res=pdo_update('ymmf_sun_storetype',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   
    }


    //查询帖子二级分类
    public function doMobileGetInformationType() {
        global $_W,$_GPC;
     $type2=pdo_getall('ymmf_sun_type2',array('type_id'=>$_GPC['id']));
     echo json_encode( $type2);

    }

public function doMobileAlldeleteinfo(){
    global $_W, $_GPC;
        $res=pdo_delete('ymmf_sun_information',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//批量更新(二级信息分类)
public function doMobileAllUpdateInfo(){
    global $_W, $_GPC;
    $arr=$_GPC['arr'];
    if($arr){
        foreach($arr as $v){
            if($v['type']==1){               
               $res= pdo_update('ymmf_sun_type2',array('state'=>2),array('id'=>$v['id']));
            }

            if($v['type']==2){
                $res=pdo_update('ymmf_sun_type2',array('state'=>1),array('id'=>$v['id']));
            }

        }
    }
    
}

//批量更新(二级商家分类)
public function doMobileAllUpdateStore(){
    global $_W, $_GPC;
    $arr=$_GPC['arr'];
    if($arr){
        foreach($arr as $v){
            if($v['type']==1){               
               $res= pdo_update('ymmf_sun_storetype2',array('state'=>2),array('id'=>$v['id']));
            }

            if($v['type']==2){
                $res=pdo_update('ymmf_sun_storetype2',array('state'=>1),array('id'=>$v['id']));
            }

        }
    }
    
}

//帖子批量通过
public function doMobileAdoptInfo(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_information',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//帖子批量拒绝
public function doMobileRejectInfo(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_information',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//资讯批量删除
public function doMobileAlldeleteZx(){
    global $_W, $_GPC;
        $res=pdo_delete('ymmf_sun_zx',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('删除失败','','error');
        }
}


//资讯批量通过
public function doMobileAdoptZx(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_zx',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//资讯批量拒绝
public function doMobileRejectZx(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_zx',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//拼车批量删除
public function doMobileAlldeleteCar(){
    global $_W, $_GPC;
        $res=pdo_delete('ymmf_sun_car',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//拼车批量通过
public function doMobileAdoptCar(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_car',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//拼车批量拒绝
public function doMobileRejectCar(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_car',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}


//黄页批量通过
public function doMobileAdoptHy(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_yellowstore',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//黄页批量拒绝
public function doMobileRejectHy(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_yellowstore',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家批量删除
public function doMobileDeleteStore(){
    global $_W, $_GPC;
        $res=pdo_delete('ymmf_sun_store',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家批量通过
public function doMobileAdoptStore(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_store',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家批量拒绝
public function doMobileRejectStore(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_store',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//商品批量删除
    public function doMobileAddHairers(){
        global $_W, $_GPC;
        foreach ($_GPC['id'] as $k=>$v){
            $data = array(
                'build_id'=>$_GPC['build_id'],
                'hair_id'=>$v,
                'uniacid'=>$_W['uniacid']
            );
            $iscun = pdo_get('ymmf_sun_buildhair',array('uniacid'=>$_W['uniacid'],'hair_id'=>$v,'build_id'=>$_GPC['build_id']));
            if(!$iscun){
                $res = pdo_insert('ymmf_sun_buildhair',$data);
            }
        }
        if($res){
            message('保存成功',$this->createWebUrl('building',array()),'success');
        }else{
            message('保存失败','','error');
        }
    }

//商品批量删除
public function doMobileDeleteGoods(){
    global $_W, $_GPC;
        $res=pdo_delete('ymmf_sun_goods',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商品批量通过
public function doMobileAdoptGoods(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_goods',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商品批量拒绝
public function doMobileRejectGoods(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_goods',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}



//信息分类批量删除
public function doMobileDeleteType(){
    global $_W, $_GPC;
        $res=pdo_delete('ymmf_sun_type',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//信息分类批量启用
public function doMobileQyType(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_type',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//信息分类批量禁用
public function doMobileJyType(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_type',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家分类批量删除
public function doMobileDeleteStoreType(){
    global $_W, $_GPC;
        $res=pdo_delete('ymmf_sun_storetype',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家分类批量启用
public function doMobileQyStoreType(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_storetype',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家分类批量禁用
public function doMobileJyStoreType(){
     global $_W, $_GPC;
        $res=pdo_update('ymmf_sun_storetype',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('操作失败','','error');
        }
}



//查找用户
public function doMobileFindUser(){
global $_W, $_GPC;
/*    //查出已是商家用户
$sjuser=pdo_getall('ymmf_sun_store',array('uniacid'=>$_W['uniacid']),'user_id');
//二维数组转一维
$yuser=array_column($sjuser, 'user_id');
$string='';
if($yuser){
foreach($yuser as $v){
    $string.="'".$v."',";
}
$string=rtrim($string, ",");
}
//echo $string;
//用户
//
if($yuser){
$sql =" select id,name from ".tablename('ymmf_sun_user')." where uniacid={$_W['uniacid']}  and id not in ({$string}) and  name like '%{$_GPC['keywords']}%'";
}else{
 $sql =" select id,name from ".tablename('ymmf_sun_user')." where uniacid={$_W['uniacid']}   and  name like '%{$_GPC['keywords']}%'";
}

$user=pdo_fetchall($sql);
//$user=pdo_getall('ymmf_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));*/
$sql =" select id,name from ".tablename('ymmf_sun_user')." where uniacid={$_W['uniacid']}  and id not in (select user_id  from" .tablename('ymmf_sun_store')."where uniacid={$_W['uniacid']}) and  name like '%{$_GPC['keywords']}%'";
$user=pdo_fetchall($sql);

return json_encode($user);
}

//查找城市
public function doMobileFindCity(){
global $_W, $_GPC;
$sql =" select DISTINCT cityname from ".tablename('ymmf_sun_hotcity')." where uniacid={$_W['uniacid']}   and  cityname like '%{$_GPC['keywords']}%'";
$city=pdo_fetchall($sql);
return json_encode($city);

}



//资讯评论批量删除
public function doMobileDeleteZxAssess(){
    global $_W, $_GPC;
    $res=pdo_delete('ymmf_sun_zx_assess',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('zxpinglun',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

//帖子分类列表

public function doMobileTypeList(){
    global $_W, $_GPC;
    $type=pdo_getall('ymmf_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
    $type2=pdo_getall('ymmf_sun_type2',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
    foreach($type as $key => $value){
         $data=$this->getSon($value['id'],$type2);
         $type[$key]['ej']=$data;

    }
    return json_encode($type);

}

//一级分类详情
public function doMobilePTypeInfo(){
    global $_W, $_GPC;
    $res=pdo_get('ymmf_sun_type',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
    return json_encode($res);
}

//一级分类保存
public function doMobileSavePType(){
    global $_W, $_GPC;
    $data['img']=$_GPC['img'];
    $data['num']=$_GPC['num'];
    $data['type_name']=$_GPC['type_name'];
    $data['money']=$_GPC['money'];
    $data['state']=$_GPC['state'];
    $data['uniacid']=$_W['uniacid'];
    if($_GPC['id']==''){                
        $res=pdo_insert('ymmf_sun_type',$data);
    }else{
        $res = pdo_update('ymmf_sun_type', $data, array('id' => $_GPC['id']));
    }
    if($res){
       echo '1';
   }else{
       echo '2';
   }

}

//二级分类详情
public function doMobileSTypeInfo(){
    global $_W, $_GPC;
    $res= pdo_get('ymmf_sun_type2',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
    return json_encode($res);
}

//二级分类保存
public function doMobileSaveSType(){
    global $_W, $_GPC;
    $data['num']=$_GPC['num'];
    $data['type_id']=$_GPC['type_id'];
    $data['name']=$_GPC['name'];
    $data['state']=$_GPC['state'];
    $data['uniacid']=$_W['uniacid'];
    if($_GPC['id']==''){                
        $res=pdo_insert('ymmf_sun_type2',$data);
    }else{
        $res = pdo_update('ymmf_sun_type2', $data, array('id' => $_GPC['id']));
    }
    if($res){
       echo '1';
   }else{
       echo '2';
   }

}

//查看帖子标签

public  function doMobileQueryTag(){
    global $_W, $_GPC;
    $res=pdo_getall('ymmf_sun_label',array('type2_id'=>$_GPC['type2_id']));
    echo json_encode($res);

}


//删除标签
public function doMobileDelTag(){
    global $_W, $_GPC;
    $res=pdo_delete('ymmf_sun_label',array('id'=>$_GPC['tag_id']));
    if($res){
        echo '1';
    }else{
        echo '2';
    }
}

//修改标签
public function doMobileUpdTag(){
      global $_W, $_GPC;
    $res=pdo_update('ymmf_sun_label',array('label_name'=>$_GPC['label_name']),array('id'=>$_GPC['tag_id']));
    if($res){
        echo '1';
    }else{
        echo '2';
    }
}








}