<?php

/**

 * 柚子门店微商城小程序模块微站定义

 *

 * @author sun

 * @url 

 */

defined('IN_IA') or exit('Access Denied');
global $_W;
require 'inc/func/core.php';
include IA_ROOT."/addons/".$_W['current_module']['name']."/func/func.php";

class yzcyk_sunModuleSite extends Core {


    public function doWebsetting()
    {
        global $_GPC, $_W;
        $settype = intval($_GPC["settype"]);
        $todo = $_GPC["todo"];
        $tid = $_GPC["tid"];
        $urlarray = array();
        $urlarray["settype"] = $settype;
        if($settype==3){
            if (checksubmit()) {
                $data = array();
                $data_first = $_GPC["indata"];
                $code = $data_first["code"];
                if(empty($code)){
                    message('请输入激活码进行激活!', $this->createWebUrl('setting',$urlarray), 'error');
                }
                $ip_arr = gethostbynamel($_SERVER['HTTP_HOST']);
                $ip = $ip_arr?$ip_arr[0]:0;
                $toactive = encryptcode("35bcr/gGmbqRZmM3gx9efUySl+Z0XHe+7qtHS412VSPG9dGuTbxFC4IcCo4KjVQt", 'D','',0) . '/toactive.php?c=1&p=27&k='.$code.'&i='.$ip.'&u=' . $_SERVER['HTTP_HOST'];
                $toactive = tocurl($toactive,10);
                $toactive = trim($toactive, "\xEF\xBB\xBF");//去除bom头
                $json_toactive = json_decode($toactive,true);

                if($json_toactive["code"]===0){
                    $input_data = array();
                    $input_data["we7.cc"] = md5("we7_key");
                    $input_data["keyid"] = $json_toactive["data"]["id"];
                    $input_data["domain"] = $json_toactive["data"]["domain"];
                    $input_data["ip"] = $json_toactive["data"]["ip"];
                    $input_data["loca_ip"] = "127.0.0.1";
                    $input_data["pid"] = $json_toactive["data"]["pid"];
                    $input_data["time"] = time();
                    $input_data_s = serialize($input_data);
                    $input_data_s = encryptcode($input_data_s, 'E','',0);
                    $res = pdo_update('yzcyk_sun_acode', array("code"=>$input_data_s), array('id' =>3));
                    if(!$res){
                        $res = pdo_insert('yzcyk_sun_acode', array("code"=>$input_data_s,"id"=>3,"time"=>time()));
                    }
                    message('激活成功!', $this->createWebUrl('permission'), '');
                }else{
                    message('激活失败!', $this->createWebUrl('permission'), 'error');
                }
            }
        }
        include $this->template('web/setting');
    }
//修改区域
	public function doMobileUpdArea() {
		global $_W,$_GPC;
        if($_GPC['num']){
           $data['num']=$_GPC['num']; 
        }
        $res=pdo_update('yzcyk_sun_area',$data,array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzcyk_sun_ad',$data,array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzcyk_sun_type',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   
    }

//全部删除二级信息分类
public function doMobileAllDelete(){
    global $_W, $_GPC;
            $res=pdo_delete('yzcyk_sun_type2',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('type2',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//全部删除二级商家分类
public function doMobileDeleteType2(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_storetype2',array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzcyk_sun_storetype',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   
    }


    //查询帖子二级分类
    public function doMobileGetInformationType() {
        global $_W,$_GPC;
     $type2=pdo_getall('yzcyk_sun_type2',array('type_id'=>$_GPC['id']));
     echo json_encode( $type2);

    }

public function doMobileAlldeleteinfo(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_information',array('id'=>$_GPC['id']));
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
               $res= pdo_update('yzcyk_sun_type2',array('state'=>2),array('id'=>$v['id']));         
            }

            if($v['type']==2){
                $res=pdo_update('yzcyk_sun_type2',array('state'=>1),array('id'=>$v['id']));
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
               $res= pdo_update('yzcyk_sun_storetype2',array('state'=>2),array('id'=>$v['id']));         
            }

            if($v['type']==2){
                $res=pdo_update('yzcyk_sun_storetype2',array('state'=>1),array('id'=>$v['id']));
            }

        }
    }
    
}

//帖子批量通过
public function doMobileAdoptInfo(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_information',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//帖子批量拒绝
public function doMobileRejectInfo(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_information',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//资讯批量删除
public function doMobileAlldeleteZx(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_zx',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('删除失败','','error');
        }
}


//资讯批量通过
public function doMobileAdoptZx(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_zx',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//资讯批量拒绝
public function doMobileRejectZx(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_zx',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//拼车批量删除
public function doMobileAlldeleteCar(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_car',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//拼车批量通过
public function doMobileAdoptCar(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_car',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//拼车批量拒绝
public function doMobileRejectCar(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_car',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}


//黄页批量通过
public function doMobileAdoptHy(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_yellowstore',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//黄页批量拒绝
public function doMobileRejectHy(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_yellowstore',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//活动批量删除
    public function doMobileDeleteActivity(){
        global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_activity',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('activity',array()),'success');
        }else{
            message('删除失败','','error');
        }
    }

//活动批量通过
    public function doMobileAdoptActivity(){
        global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_activity',array('state'=>2,'tg_time'=>time()),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('activity',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }

//活动批量拒绝
    public function doMobileRejectActivity(){
        global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_activity',array('state'=>3,'jj_time'=>time()),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('activity',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }

    //故事批量删除
    public function doMobileDeleteStory(){
        global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_story',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('story',array()),'success');
        }else{
            message('删除失败','','error');
        }
    }

//故事批量通过
    public function doMobileAdoptStory(){
        global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_story',array('state'=>2,'tg_time'=>time()),array('id'=>$_GPC['id']));

        if($res){
            message('操作成功',$this->createWebUrl('story',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }

//故事批量拒绝
    public function doMobileRejectStory(){
        global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_story',array('state'=>3,'jj_time'=>time()),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('story',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }

//获取专家
public function doMobileGetalbum(){
	global $_W, $_GPC;
	$album=pdo_getall('yzcyk_sun_story_album',array('uniacid'=>$_W['uniacid'],'category_id'=>$_GPC['category_id']));
	echo json_encode($album);

}

//商家批量删除
public function doMobileDeleteStore(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_store',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家批量通过
public function doMobileAdoptStore(){
     global $_W, $_GPC;
    $store=pdo_getall('yzcyk_sun_store',array('id'=>$_GPC['id']));
    foreach($store as $val){
        if($val['storelimit_id']>0){
           $storelimit=pdo_get('yzcyk_sun_storelimit',array('id'=>$val['storelimit_id']));
           $store_rz_record=pdo_get('yzcyk_sun_store_rz_record',array('uniacid'=>$_W['uniacid'],'openid'=>$val['openid'],'store_id'=>$val['id'],'order_id'=>$val['order_id']));
           if(!$store_rz_record){
               if(empty($val['rz_time'])){
                   $rz_time=time();
               }else{
                   $rz_time=$store['rz_time'];
               }
               if($val['rz_end_time']>time()){
                   $rz_end_time=$val['rz_end_time']+$storelimit['lt_day']*60*60*24;
               }else{
                   $rz_end_time=time()+$storelimit['lt_day']*60*60*24;
               }
               pdo_update('yzcyk_sun_store',array('rz_time'=>$rz_time,'rz_end_time'=>$rz_end_time));
               //增加记录
               $store_rz_record=array(
                   'uniacid'=>$_W['uniacid'],
                   'openid'=>$val['openid'],
                   'store_id'=>$val['id'],
                   'begin_time'=>$rz_time,
                   'end_time'=>$rz_end_time,
                   'storelimit_id'=>$val['storelimit_id'],
                   'num'=>$storelimit['lt_day'],
                   'order_id'=>$val['order_id'],
                   'add_time'=>time(),
               );
               pdo_insert('yzcyk_sun_store_rz_record',$store_rz_record);
           }
        }else{
            if(!$val['rz_time']){
                pdo_update('yzcyk_sun_store',array('rz_time'=>time()),array('id'=>$val['id']));
            }
        }
    }
        $res=pdo_update('yzcyk_sun_store',array('state'=>2,'rz_status'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家批量拒绝
public function doMobileRejectStore(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_store',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//动态批量删除
    public function doMobileDeleteDynamic(){
        global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_dynamic',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('dynamic',array()),'success');
        }else{
            message('删除失败','','error');
        }
    }
//动态批量通过
    public function doMobileAdoptDynamic(){
        global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_dynamic',array('is_status'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('dynamic',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
//动态批量拒绝
    public function doMobileRejectDynamic(){
        global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_dynamic',array('is_status'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('dynamic',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }

//商品批量删除
public function doMobileDeleteGoods(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_goods',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商品批量通过
public function doMobileAdoptGoods(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_goods',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商品批量拒绝
public function doMobileRejectGoods(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_goods',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}



//信息分类批量删除
public function doMobileDeleteType(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_type',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//信息分类批量启用
public function doMobileQyType(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_type',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//信息分类批量禁用
public function doMobileJyType(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_type',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家分类批量删除
public function doMobileDeleteStoreType(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcyk_sun_storetype',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家分类批量启用
public function doMobileQyStoreType(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_storetype',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家分类批量禁用
public function doMobileJyStoreType(){
     global $_W, $_GPC;
        $res=pdo_update('yzcyk_sun_storetype',array('state'=>2),array('id'=>$_GPC['id']));
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
$sjuser=pdo_getall('yzcyk_sun_store',array('uniacid'=>$_W['uniacid']),'user_id');
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
$sql =" select id,name from ".tablename('yzcyk_sun_user')." where uniacid={$_W['uniacid']}  and id not in ({$string}) and  name like '%{$_GPC['keywords']}%'";  
}else{
 $sql =" select id,name from ".tablename('yzcyk_sun_user')." where uniacid={$_W['uniacid']}   and  name like '%{$_GPC['keywords']}%'";     
}

$user=pdo_fetchall($sql);
//$user=pdo_getall('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));*/
$sql =" select id,name from ".tablename('yzcyk_sun_user')." where uniacid={$_W['uniacid']}  and id not in (select user_id  from" .tablename('yzcyk_sun_store')."where uniacid={$_W['uniacid']}) and  name like '%{$_GPC['keywords']}%'";  
$user=pdo_fetchall($sql);

return json_encode($user);
}

//查找城市
public function doMobileFindCity(){
global $_W, $_GPC;
$sql =" select DISTINCT cityname from ".tablename('yzcyk_sun_hotcity')." where uniacid={$_W['uniacid']}   and  cityname like '%{$_GPC['keywords']}%'";  
$city=pdo_fetchall($sql);
return json_encode($city);

}



//资讯评论批量删除
public function doMobileDeleteZxAssess(){
    global $_W, $_GPC;
    $res=pdo_delete('yzcyk_sun_zx_assess',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('zxpinglun',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

//帖子分类列表

public function doMobileTypeList(){
    global $_W, $_GPC;
    $type=pdo_getall('yzcyk_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
    $type2=pdo_getall('yzcyk_sun_type2',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
    foreach($type as $key => $value){
         $data=$this->getSon($value['id'],$type2);
         $type[$key]['ej']=$data;

    }
    return json_encode($type);

}

//一级分类详情
public function doMobilePTypeInfo(){
    global $_W, $_GPC;
    $res=pdo_get('yzcyk_sun_type',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
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
        $res=pdo_insert('yzcyk_sun_type',$data);        
    }else{
        $res = pdo_update('yzcyk_sun_type', $data, array('id' => $_GPC['id']));
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
    $res= pdo_get('yzcyk_sun_type2',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
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
        $res=pdo_insert('yzcyk_sun_type2',$data);
    }else{
        $res = pdo_update('yzcyk_sun_type2', $data, array('id' => $_GPC['id']));
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
    $res=pdo_getall('yzcyk_sun_label',array('type2_id'=>$_GPC['type2_id']));
    echo json_encode($res);

}


//删除标签
public function doMobileDelTag(){
    global $_W, $_GPC;
    $res=pdo_delete('yzcyk_sun_label',array('id'=>$_GPC['tag_id']));
    if($res){
        echo '1';
    }else{
        echo '2';
    }
}

//修改标签
public function doMobileUpdTag(){
      global $_W, $_GPC;
    $res=pdo_update('yzcyk_sun_label',array('label_name'=>$_GPC['label_name']),array('id'=>$_GPC['tag_id']));
    if($res){
        echo '1';
    }else{
        echo '2';
    }
}








}