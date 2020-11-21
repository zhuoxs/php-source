<?php

/**

 * -微圈小程序模块微站定义

 *

 * @author 厦门科技

 * @url 

 */

defined('IN_IA') or exit('Access Denied');

require 'inc/func/core.php';

class yzzc_sunModuleSite extends Core {


    public function doWebNotify($data){
        global $_W,$_GPC;
        $attach = $data['attach'];
        //载入日志函数
        // load()->func('logging');
        //     //记录文本日志
        // logging_run(1, 'trace','test123456');
        if($attach){
            $attach_arr = explode("@@@",$attach);
            if(sizeof($attach_arr)==2){
                $_W['uniacid'] = $uniacid = intval($attach_arr[0]);
                $oid = intval($attach_arr[1]);
            }else{
                die('FAIL');
            }
        }else{
            die('FAIL');
        }
        $orderget=pdo_get('yzzc_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$oid,'status'=>1));
        
        if($orderget){
            $res=pdo_update('yzzc_sun_order',array('ispay'=>1,'paytime'=>time(),'status'=>2),array('uniacid'=>$_W['uniacid'],'id'=>$oid));

            $data1['start_time']=$orderget['start_time'];
            $data1['end_time']=$orderget['end_time'];
            $data1['carnum']=$orderget['carnum'];
            // $data['status']=1;
            $data1['uniacid']=$_W['uniacid'];
            pdo_insert('yzzc_sun_ordertime',$data1);
            //发短信
            $set=pdo_get('yzzc_sun_msg_set',array('uniacid'=>$_W['uniacid']));
            if($set['open']==1){
                $shop = pdo_get('yzzc_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$orderget['start_shop']));
                $mobile=$shop['shop_tel'];
                if($set['type']==1){
                    
                    $this->SendYtxSms($set['buy_template'],$set,$mobile);
                }elseif($set['type']==2){
                    include_once IA_ROOT . '/addons/yzzc_sun/api/aliyun-dysms/sendSms.php';
                    set_time_limit(0);
                    header('Content-Type: text/plain; charset=utf-8');
                    $sendid =$set["dayu_templatecode"];
                    if($sendid!=""){
                        $return = sendSms($set["dayu_accesskey"], $set["dayu_accesskeysecret"],$mobile, $set["dayu_signname"],$sendid);
                        // echo json_encode($return);
                    }
                }
            }
            
            //添加支付日志
            //返现
            $integral=pdo_get('yzzc_sun_integralset',array('uniacid'=>$_W['uniacid']),array('full','cost_score'));
            if($integral['cost_score']>0){
                $fanscore=floor($orderget['total_money']*$integral['cost_score']/$integral['full']);
                $this->scoreAct($orderget['uid'],3,$fanscore);
            }
            if($res){
                die('SUCCESS');
            }else{
                die('FAIL');
            }
        }else{
            die('FAIL');

        }
        die('SUCCESS');
            
    }
    //TODO::253云通信
    public function SendYtxSms($msg,$sms=array(),$mobile=''){
        $postArr = array (
            'account'  => $sms["api_account"],
            'password' => $sms["api_psw"],
            'msg' => urlencode($msg),
            'phone' => $mobile,
            'report' => 'true',
        );
        $url = "http://smssh1.253.com/msg/send/json";
        $result = $this->curlPost($url, $postArr);
        return $result;
    }
    /**
     * 积分操作
    */
    function scoreAct($uid,$type=1,$score=0){
        global $_W;
        $data['uniacid']=$_W['uniacid'];
        $data['uid']=$uid;
        $data['type']=$type;
        $data['score']=$score;
        $data['createtime']=time();
//        var_dump($data);exit;
        pdo_insert('yzzc_sun_integral_log',$data);
        //修改总积分
        if($score>0){
            pdo_update('yzzc_sun_user',array('all_integral +='=>$data['score']),array('id'=>$data['uid']));
        }
        //修改现有积分
        pdo_update('yzzc_sun_user',array('now_integral +='=>$data['score']),array('id'=>$data['uid']));
//        exit;
    }
    public function doMobilefindorder(){
        global $_W,$_GPC;
        $time=time();
        $findtime=pdo_get('yzzc_sun_system',array('uniacid'=>$_W['uniacid']));
                // var_dump(1);
                // var_dump($findtime['findtime']);die;

        if(!$findtime['findtime']){
            pdo_update('yzzc_sun_system',array('findtime'=>$time),array('uniacid'=>$_W['uniacid']));
        }else{
            if($findtime['findtime']<$time){
                // var_dump($findtime['findtime']);
                // $order=conut(pdo_getall('yzzc_sun_order',array('uniacid'=>$_W['uniacid'],'paytime >'=>$findtime['findtime'])));
                $order= count(pdo_fetchall('select id from '.tablename('yzzc_sun_order').' where uniacid = '.$_W['uniacid']." and paytime > ".$findtime['findtime']));
                // var_dump(pdo_fetchall('select id from '.tablename('yzzc_sun_order').' where uniacid = '.$_W['uniacid']." and paytime > ".$findtime['findtime']));
                pdo_update('yzzc_sun_system',array('findtime'=>$time),array('uniacid'=>$_W['uniacid']));
                echo json_encode($order);
            }
        }
    }
//修改区域
	public function doMobileUpdArea() {
		global $_W,$_GPC;
        if($_GPC['num']){
           $data['num']=$_GPC['num']; 
        }
        $res=pdo_update('yzzc_sun_area',$data,array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzzc_sun_ad',$data,array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzzc_sun_type',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   
    }

//全部删除二级信息分类
public function doMobileAllDelete(){
    global $_W, $_GPC;
            $res=pdo_delete('yzzc_sun_type2',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('type2',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//全部删除二级商家分类
public function doMobileDeleteType2(){
    global $_W, $_GPC;
        $res=pdo_delete('yzzc_sun_storetype2',array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzzc_sun_storetype',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   
    }


    //查询帖子二级分类
    public function doMobileGetInformationType() {
        global $_W,$_GPC;
     $type2=pdo_getall('yzzc_sun_type2',array('type_id'=>$_GPC['id']));
     echo json_encode( $type2);

    }

public function doMobileAlldeleteinfo(){
    global $_W, $_GPC;
        $res=pdo_delete('yzzc_sun_information',array('id'=>$_GPC['id']));
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
               $res= pdo_update('yzzc_sun_type2',array('state'=>2),array('id'=>$v['id']));
            }

            if($v['type']==2){
                $res=pdo_update('yzzc_sun_type2',array('state'=>1),array('id'=>$v['id']));
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
               $res= pdo_update('yzzc_sun_storetype2',array('state'=>2),array('id'=>$v['id']));
            }

            if($v['type']==2){
                $res=pdo_update('yzzc_sun_storetype2',array('state'=>1),array('id'=>$v['id']));
            }

        }
    }
    
}

//帖子批量通过
public function doMobileAdoptInfo(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_information',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//帖子批量拒绝
public function doMobileRejectInfo(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_information',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//资讯批量删除
public function doMobileAlldeleteZx(){
    global $_W, $_GPC;
        $res=pdo_delete('yzzc_sun_selected',array('seid'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('删除失败','','error');
        }
}


//资讯批量通过
public function doMobileAdoptZx(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_zx',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//资讯批量拒绝
public function doMobileRejectZx(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_zx',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//拼车批量删除
public function doMobileAlldeleteCar(){
    global $_W, $_GPC;
        $res=pdo_delete('yzzc_sun_car',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//拼车批量通过
public function doMobileAdoptCar(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_car',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//拼车批量拒绝
public function doMobileRejectCar(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_car',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}


//黄页批量通过
public function doMobileAdoptHy(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_yellowstore',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//黄页批量拒绝
public function doMobileRejectHy(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_yellowstore',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家批量删除
public function doMobileDeleteStore(){
    global $_W, $_GPC;
        $res=pdo_delete('yzzc_sun_store',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家批量通过
public function doMobileAdoptStore(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_store',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家批量拒绝
public function doMobileRejectStore(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_store',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}


//商品批量删除
public function doMobileDeleteGoods(){
    global $_W, $_GPC;
        $res=pdo_delete('wyzc_sun_goods',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商品批量通过
public function doMobileAdoptGoods(){
     global $_W, $_GPC;
        $res=pdo_update('wyzc_sun_goods',array('status'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商品批量拒绝
public function doMobileRejectGoods(){
     global $_W, $_GPC;
        $res=pdo_update('wyzc_sun_goods',array('status'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}



//信息分类批量删除
public function doMobileDeleteType(){
    global $_W, $_GPC;
        $res=pdo_delete('yzzc_sun_type',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//信息分类批量启用
public function doMobileQyType(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_type',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//信息分类批量禁用
public function doMobileJyType(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_type',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家分类批量删除
public function doMobileDeleteStoreType(){
    global $_W, $_GPC;
        $res=pdo_delete('yzzc_sun_storetype',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家分类批量启用
public function doMobileQyStoreType(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_storetype',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家分类批量禁用
public function doMobileJyStoreType(){
     global $_W, $_GPC;
        $res=pdo_update('yzzc_sun_storetype',array('state'=>2),array('id'=>$_GPC['id']));
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
$sjuser=pdo_getall('yzzc_sun_store',array('uniacid'=>$_W['uniacid']),'user_id');
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
$sql =" select id,name from ".tablename('yzzc_sun_user')." where uniacid={$_W['uniacid']}  and id not in ({$string}) and  name like '%{$_GPC['keywords']}%'";
}else{
 $sql =" select id,name from ".tablename('yzzc_sun_user')." where uniacid={$_W['uniacid']}   and  name like '%{$_GPC['keywords']}%'";
}

$user=pdo_fetchall($sql);
//$user=pdo_getall('yzzc_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));*/
$sql =" select id,name from ".tablename('yzzc_sun_user')." where uniacid={$_W['uniacid']}  and id not in (select user_id  from" .tablename('yzzc_sun_store')."where uniacid={$_W['uniacid']}) and  name like '%{$_GPC['keywords']}%'";
$user=pdo_fetchall($sql);

return json_encode($user);
}

//查找城市
public function doMobileFindCity(){
global $_W, $_GPC;
$sql =" select DISTINCT cityname from ".tablename('yzzc_sun_hotcity')." where uniacid={$_W['uniacid']}   and  cityname like '%{$_GPC['keywords']}%'";
$city=pdo_fetchall($sql);
return json_encode($city);

}



//资讯评论批量删除
public function doMobileDeleteZxAssess(){
    global $_W, $_GPC;
    $res=pdo_delete('yzzc_sun_zx_assess',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('zxpinglun',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

//帖子分类列表

public function doMobileTypeList(){
    global $_W, $_GPC;
    $type=pdo_getall('yzzc_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
    $type2=pdo_getall('yzzc_sun_type2',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
    foreach($type as $key => $value){
         $data=$this->getSon($value['id'],$type2);
         $type[$key]['ej']=$data;

    }
    return json_encode($type);

}

//一级分类详情
public function doMobilePTypeInfo(){
    global $_W, $_GPC;
    $res=pdo_get('yzzc_sun_type',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
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
        $res=pdo_insert('yzzc_sun_type',$data);
    }else{
        $res = pdo_update('yzzc_sun_type', $data, array('id' => $_GPC['id']));
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
    $res= pdo_get('yzzc_sun_type2',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
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
        $res=pdo_insert('yzzc_sun_type2',$data);
    }else{
        $res = pdo_update('yzzc_sun_type2', $data, array('id' => $_GPC['id']));
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
    $res=pdo_getall('yzzc_sun_label',array('type2_id'=>$_GPC['type2_id']));
    echo json_encode($res);

}


//删除标签
public function doMobileDelTag(){
    global $_W, $_GPC;
    $res=pdo_delete('yzzc_sun_label',array('id'=>$_GPC['tag_id']));
    if($res){
        echo '1';
    }else{
        echo '2';
    }
}

//修改标签
public function doMobileUpdTag(){
      global $_W, $_GPC;
    $res=pdo_update('yzzc_sun_label',array('label_name'=>$_GPC['label_name']),array('id'=>$_GPC['tag_id']));
    if($res){
        echo '1';
    }else{
        echo '2';
    }
}








}