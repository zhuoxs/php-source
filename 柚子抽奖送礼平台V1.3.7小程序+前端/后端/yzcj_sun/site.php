<?php
/**
 * 本破解程序由资源邦提供
 * 资源邦www.wazyb.com
 * QQ:993424780  承接网站建设、公众号搭建、小程序建设、企业网站
 */

defined('IN_IA') or exit('Access Denied');

require 'inc/func/core.php';

class yzcj_sunModuleSite extends Core {

//修改区域
	public function doMobileUpdArea() {
		global $_W,$_GPC;
        if($_GPC['num']){
           $data['num']=$_GPC['num']; 
        }
        $res=pdo_update('yzcj_sun_area',$data,array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzcj_sun_ad',$data,array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzcj_sun_type',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   
    }

//全部删除二级信息分类
public function doMobileAllDelete(){
    global $_W, $_GPC;
            $res=pdo_delete('yzcj_sun_type2',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('type2',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//全部删除二级商家分类
public function doMobileDeleteType2(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcj_sun_storetype2',array('id'=>$_GPC['id']));
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
        $res=pdo_update('yzcj_sun_storetype',$data,array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }   
    }


    //查询帖子二级分类
    public function doMobileGetInformationType() {
        global $_W,$_GPC;
     $type2=pdo_getall('yzcj_sun_type2',array('type_id'=>$_GPC['id']));
     echo json_encode( $type2);

    }

public function doMobileAlldeleteinfo(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcj_sun_information',array('id'=>$_GPC['id']));
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
               $res= pdo_update('yzcj_sun_type2',array('state'=>2),array('id'=>$v['id']));
            }

            if($v['type']==2){
                $res=pdo_update('yzcj_sun_type2',array('state'=>1),array('id'=>$v['id']));
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
               $res= pdo_update('yzcj_sun_storetype2',array('state'=>2),array('id'=>$v['id']));
            }

            if($v['type']==2){
                $res=pdo_update('yzcj_sun_storetype2',array('state'=>1),array('id'=>$v['id']));
            }

        }
    }
    
}

//帖子批量通过
public function doMobileAdoptInfo(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_information',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//帖子批量拒绝
public function doMobileRejectInfo(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_information',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//资讯批量删除
public function doMobileAlldeleteZx(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcj_sun_circle',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//资讯批量通过
public function doMobileAdoptZx(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_circle',array('status'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//资讯批量拒绝
public function doMobileRejectZx(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_circle',array('status'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('zx',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//拼车批量删除
public function doMobileAlldeleteCar(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcj_sun_order',array('oid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('删除成功',$this->createWebUrl('order',array()),'success');
        }else{
            message('删除失败','','error');
        }
}
//订单批量发货
public function doMobileAllfhCar(){
    global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_order',array('status'=>6),array('oid'=>$_GPC['id'],'uniacid'=>$_W['uniacid'],'status'=>2));
        if($res){
            message('发货成功',$this->createWebUrl('order',array()),'success');
        }else{
            message('发货失败','','error');
        }
}
//订单批量收货
public function doMobileAllshCar(){
    global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_order',array('status'=>5),array('oid'=>$_GPC['id'],'uniacid'=>$_W['uniacid'],'status'=>6));
        if($res){
            message('收货成功',$this->createWebUrl('order',array()),'success');
        }else{
            message('发货失败','','error');
        }
}

//拼车批量通过
public function doMobileAdoptCar(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_car',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//拼车批量拒绝
public function doMobileRejectCar(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_car',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}


//黄页批量通过
public function doMobileAdoptHy(){
     global $_W, $_GPC;
        $rst=pdo_getall('yzcj_sun_sponsorship',array('sid'=>$_GPC['id']));

        $starttime=date("Y-m-d H:i:s",time());
        
        foreach ($rst as $key => $value) {
            $time=24*60*60*$value['day'];

            $endtime=date("Y-m-d H:i:s",time()+$time);
            $res=pdo_update('yzcj_sun_sponsorship',array('status'=>2,'time'=>$starttime,'endtime'=>$endtime),array('sid'=>$value['sid']));
        }
        if($res){
            message('操作成功',$this->createWebUrl('yellowstore',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//黄页批量拒绝
public function doMobileRejectHy(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_sponsorship',array('status'=>3),array('sid'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('yellowstore',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
// //发送请求
// public function doMobileAssociat(){
//     global $_W, $_GPC;
//     $rst=pdo_getall('yzcj_sun_user');
//     if($res){
//         message('操作成功',$this->createWebUrl('yellowstore',array()),'success');
//     }else{
//         message('操作失败','','error');
//     }
// }
//商家批量删除
public function doMobileDeleteStore(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcj_sun_store',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家批量通过
public function doMobileAdoptStore(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_store',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家批量拒绝
public function doMobileRejectStore(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_store',array('state'=>3),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('information',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//商品删除前提示
public function doMobileGoodsCount(){
    global $_W, $_GPC;
    $gid=$_GPC['gid'];
    $count=pdo_fetchcolumn("SELECT count(oid) FROM ".tablename('yzcj_sun_order')."where gid= $gid");
    echo json_encode($count);
}

//商品批量删除
public function doMobileDeleteGoods(){
    global $_W, $_GPC;
        $goods=pdo_get('yzcj_sun_goods',array('gid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($goods['cid']==2&&$goods['status']==2){
            $uid=$goods['uid'];
            $sid=$goods['sid'];
            $gname=$goods['gname'];
            $count=$goods['count'];

          if(!empty($uid)){
            //余额
            $money=pdo_get('yzcj_sun_user',array('id'=>$uid,'uniacid'=>$_W['uniacid']),'money')['money'];
            $nowmoney=$gname*$count+$money;
            $data1['money']=$nowmoney;
          }else{
            $uid=pdo_get('yzcj_sun_sponsorship',array('sid'=>$sid,'uniacid'=>$_W['uniacid'],'status'=>2),'uid')['uid'];
            //余额
            $money=pdo_get('yzcj_sun_user',array('id'=>$uid,'uniacid'=>$_W['uniacid']),'money')['money'];
            $nowmoney=$gname*$count+$money;
            $data1['money']=$nowmoney;
          }
          $result=pdo_update('yzcj_sun_user',$data1, array('id' =>$uid,'uniacid'=>$_W['uniacid']));
        }
        
        $res=pdo_delete('yzcj_sun_goods',array('gid'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商品批量通过
public function doMobileAdoptGoods(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_goods',array('status'=>2),array('gid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商品批量拒绝
public function doMobileRejectGoods(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_goods',array('status'=>3),array('gid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('goods',array()),'success');
        }else{
            message('操作失败','','error');
        }
}
//商品批量删除
public function doMobileDeleteGifts(){
    global $_W, $_GPC;
        
        $res=pdo_delete('yzcj_sun_gifts',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('删除成功',$this->createWebUrl('gifts',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商品批量通过
public function doMobileAdoptGifts(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_gifts',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('gifts',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商品批量拒绝
public function doMobileRejectGifts(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_gifts',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('gifts',array()),'success');
        }else{
            message('操作失败','','error');
        }
}


//信息分类批量删除
public function doMobileDeleteType(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcj_sun_type',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//信息分类批量启用
public function doMobileQyType(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_type',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//信息分类批量禁用
public function doMobileJyType(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_type',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家分类批量删除
public function doMobileDeleteStoreType(){
    global $_W, $_GPC;
        $res=pdo_delete('yzcj_sun_storetype',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('删除失败','','error');
        }
}

//商家分类批量启用
public function doMobileQyStoreType(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_storetype',array('state'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('操作失败','','error');
        }
}

//商家分类批量禁用
public function doMobileJyStoreType(){
     global $_W, $_GPC;
        $res=pdo_update('yzcj_sun_storetype',array('state'=>2),array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('storetype',array()),'success');
        }else{
            message('操作失败','','error');
        }
}



//查找用户
public function doMobileFindUser(){
    global $_W, $_GPC;
    //查出已是商家用户
    $sjuser=pdo_getall('yzcj_sun_sponsorship',array('uniacid'=>$_W['uniacid'],'status'=>'2'),'uid');
    //二维数组转一维
    $yuser=$this->_array_column($sjuser,'uid');
    
    foreach( $yuser as $k=>$v) {
        if($info['uid'] == $v) unset($yuser[$k]);
    }
    //用户
    $uidArr=pdo_getall('yzcj_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser),'id');
    $userArr=[];
    foreach ($uidArr as $key => $value) {
        
        $uid=$value['id'];
        $sql =" select id,name from ".tablename('yzcj_sun_user')." where uniacid={$_W['uniacid']}  and id ='$uid' and  name like '%{$_GPC['keywords']}%'";
        $user=pdo_fetch($sql);
        array_push($userArr,$user);
        
    }

    
    if(!empty($userArr)){
        $info = array(
            'num' => 10001,
            'msg' => $userArr
        );
        echo json_encode($info);
    }else{
        $info = array(
            'num' => 10002,
            'msg' => '没有该用户，或者该用户已被绑定！'
        );
        echo json_encode($info);
    }
}
//二维转一维数组
function _array_column(array $array, $column_key, $index_key=null){
        $result = [];
        foreach($array as $arr) {
            if(!is_array($arr)) continue;

            if(is_null($column_key)){
                $value = $arr;
            }else{
                $value = $arr[$column_key];
            }

            if(!is_null($index_key)){
                $key = $arr[$index_key];
                $result[$key] = $value;
            }else{
                $result[] = $value;
            }
        }
        return $result; 
    }
//查找赞助商
public function doMobileFindSponsor(){
    global $_W, $_GPC;

    //用户
    $sidArr=pdo_getall('yzcj_sun_sponsorship',array('uniacid'=>$_W['uniacid']),'sid');
    // p($sidArr);
    $SponArr=[];
    foreach ($sidArr as $key => $value) {
        
        $sid=$value['sid'];
        $sql =" select sid,sname from ".tablename('yzcj_sun_sponsorship')." where uniacid={$_W['uniacid']}  and sid ='$sid' and  sname like '%{$_GPC['keywords']}%' and status=2";
        $Sponsor=pdo_fetch($sql);
        array_push($SponArr,$Sponsor);
        
    }
    if(!empty($SponArr)){
        $info = array(
            'num' => 10001,
            'msg' => $SponArr
        );
        
    }else{
        $info = array(
            'num' => 10002,
            'msg' => '尚未添加此赞助商！'
        );
    }
    // p($SponArr);
    echo json_encode($info);
}
 //查找类型
 public function doMobileFindType(){
    global $_W, $_GPC;

    //类型
    $tidArr=pdo_getall('yzcj_sun_type',array('uniacid'=>$_W['uniacid']),'id');
    $typeArr=[];
    foreach ($tidArr as $key => $value) {
        
        $id=$value['id'];
        $sql =" select id,gname from ".tablename('yzcj_sun_type')." where uniacid={$_W['uniacid']}  and id ='$id' and  gname like '%{$_GPC['keywords']}%'";
        $type=pdo_fetch($sql);
        array_push($typeArr,$type);
        
    }
    if(!empty($typeArr)){
        $info = array(
            'num' => 10001,
            'msg' => $typeArr
        );
    }else{
        $info = array(
            'num' => 10002,
            'msg' => '尚未添加此赞助商！'
        );
    }
    // p($SponArr);
    echo json_encode($info);
 }
//查找用户
public function doMobileFindZuser(){
    global $_W, $_GPC;
    
    //用户
    $uidArr=pdo_getall('yzcj_sun_user',array('uniacid'=>$_W['uniacid']),'id');
    // var_dump($uidArr);
    $UserArr=[];
    foreach ($uidArr as $key => $value) {
        $uid=$value['id'];
        $sql =" select id,name from ".tablename('yzcj_sun_user')." where uniacid={$_W['uniacid']}  and id ='$uid' and  name like '%{$_GPC['keywords']}%'";
        $User=pdo_fetch($sql);
        array_push($UserArr,$User);
    }
    if(!empty($UserArr)){
        $info = array(
            'num' => 10001,
            'msg' => $UserArr
        );
        // echo json_encode($info);
    }else{
        $info = array(
            'num' => 10002,
            'msg' => '尚未添加此用户！'
        );
        
    }
    echo json_encode($info);
}
//查找城市
public function doMobileFindCity(){
global $_W, $_GPC;
$sql =" select DISTINCT cityname from ".tablename('yzcj_sun_hotcity')." where uniacid={$_W['uniacid']}   and  cityname like '%{$_GPC['keywords']}%'";
$city=pdo_fetchall($sql);
return json_encode($city);

}



//资讯评论批量删除
public function doMobileDeleteZxAssess(){
    global $_W, $_GPC;
    $res=pdo_delete('yzcj_sun_zx_assess',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('zxpinglun',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

//帖子分类列表

public function doMobileTypeList(){
    global $_W, $_GPC;
    $type=pdo_getall('yzcj_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
    $type2=pdo_getall('yzcj_sun_type2',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
    foreach($type as $key => $value){
         $data=$this->getSon($value['id'],$type2);
         $type[$key]['ej']=$data;

    }
    return json_encode($type);

}

//一级分类详情
public function doMobilePTypeInfo(){
    global $_W, $_GPC;
    $res=pdo_get('yzcj_sun_type',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
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
        $res=pdo_insert('yzcj_sun_type',$data);
    }else{
        $res = pdo_update('yzcj_sun_type', $data, array('id' => $_GPC['id']));
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
    $res= pdo_get('yzcj_sun_type2',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
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
        $res=pdo_insert('yzcj_sun_type2',$data);
    }else{
        $res = pdo_update('yzcj_sun_type2', $data, array('id' => $_GPC['id']));
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
    $res=pdo_getall('yzcj_sun_label',array('type2_id'=>$_GPC['type2_id']));
    echo json_encode($res);

}


//删除标签
public function doMobileDelTag(){
    global $_W, $_GPC;
    $res=pdo_delete('yzcj_sun_label',array('id'=>$_GPC['tag_id']));
    if($res){
        echo '1';
    }else{
        echo '2';
    }
}

//修改标签
public function doMobileUpdTag(){
      global $_W, $_GPC;
    $res=pdo_update('yzcj_sun_label',array('label_name'=>$_GPC['label_name']),array('id'=>$_GPC['tag_id']));
    if($res){
        echo '1';
    }else{
        echo '2';
    }
}








}