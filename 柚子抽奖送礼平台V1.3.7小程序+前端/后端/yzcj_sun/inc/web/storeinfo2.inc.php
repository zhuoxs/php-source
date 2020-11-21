<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzcj_sun_sponsorship',array('sid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

//查出已是商家用户
$sjuser=pdo_getall('yzcj_sun_sponsorship',array('uniacid'=>$_W['uniacid'],'status'=>'2'),'uid');

//二维数组转一维
$yuser=_array_column($sjuser,'uid');


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

foreach( $yuser as $k=>$v) {
	if($info['uid'] == $v) unset($yuser[$k]);
}
//用户
$user=pdo_getall('yzcj_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));
//赞助期限
$in=pdo_getall('yzcj_sun_in',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){

	$data['sname']=$_GPC['company_name'];
	$data['address']=$_GPC['company_address'];
    $data['phone']=$_GPC['link_tel'];
    $data['wx']=$_GPC['wx'];
	$data['synopsis']=$_GPC['synopsis'];
    $data['logo']=$_GPC['logo'];
    $data['ewm_logo']=$_GPC['ewm_logo'];
	$data['pwd']=md5('123456');
    $data['content']=html_entity_decode($_GPC['content']);
    $data['uid']=$_GPC['uid'];
    $data['day']=$_GPC['day'];
    $data['uniacid']=$_W['uniacid'];
    // p($_GPC['sid']);die;
    if($_GPC['sid']==''){
    	$data['time']=0;
    	$data['endtime']=0;
    	$data['status']=1;
        $res = pdo_insert('yzcj_sun_sponsorship', $data);
        if($res){
            message('编辑成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('编辑失败','','error');
        }
        
    }else{
        $store=pdo_get('yzcj_sun_sponsorship',array('uniacid'=>$_W['uniacid'],'sid'=>$_GPC['sid']));
        if($_GPC['day']!=$store['day']){
            $time=24*60*60*$_GPC['day'];
            $starttime=strtotime($store['time']);
            $data['endtime']=date("Y-m-d H:i:s",$starttime+$time);
        }

        $res=pdo_update('yzcj_sun_sponsorship',$data,array('sid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
             message('编辑成功！', $this->createWebUrl('store'), 'success');
        }else{
             message('编辑失败！','','error');
        }

    }
}
		
include $this->template('web/storeinfo2');