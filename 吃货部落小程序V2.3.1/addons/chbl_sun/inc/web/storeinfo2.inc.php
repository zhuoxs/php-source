<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

// $sql = 'select id,name from ' . tablename('chbl_sun_user') . " where uniacid=".$_W['uniacid']." limit 2";
// $user = pdo_fetchall($sql);

//获取腾讯地图key
$developkey=pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']),array('qqkey'));
$key = $developkey['qqkey'];

$info = pdo_get('chbl_sun_store_active',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

//省份
    $sql = "select c.id,c.name from " . tablename('chbl_sun_province') . ' c left join ' . tablename('chbl_sun_county_city') . ' cc on c.id = cc.province_id where uniacid = ' . $_W['uniacid'];
    $province = pdo_fetchall($sql);
    $provinces = array();
    foreach ($province as $k => $v) {
        if (!in_array($v, $provinces)) {
            $provinces[] = $v;
        }
    }
//城市
$condition = empty($info['province_id']) ? '' : ' and cc.province_id =  ' . $info['province_id'];
    $sql = "select c.id,c.name from " . tablename('chbl_sun_city') . ' c left join ' . tablename('chbl_sun_county_city') . ' cc on c.id = cc.city_id where uniacid = ' . $_W['uniacid'] . $condition;
    $city = pdo_fetchall($sql);
    $citys = array();
    foreach ($city as $k => $v) {
        if (!in_array($v, $citys)) {
            $citys[] = $v;
        }
    }
//区域
$conditions = empty($info['city_id']) ? '' : ' and cc.city_id =  ' . $info['city_id'];
$sql = "select c.id,c.name from " . tablename('chbl_sun_county') . ' c left join ' . tablename('chbl_sun_county_city'). ' cc on c.id=cc.county_id' . ' where uniacid=' . $_W['uniacid'] . $conditions;
$county = pdo_fetchall($sql);
$countys = array();
foreach ($county as $k=>$v){
    if(!in_array($v,$countys)){
        $countys[] = $v;
    }
}
    if ($_GPC['op'] == 'province') {
        $sql = "SELECT c.id,c.name FROM " . tablename('chbl_sun_city') . " c left join " . tablename('chbl_sun_county_city') . " cc on c.id = cc.city_id where cc.province_id=" . $_GPC['province_id'];
        $array = pdo_fetchall($sql);
        $new_array = array();
        foreach ($array as $k => $v) {
            if (!in_array($v, $new_array)) {
                $new_array[] = $v;
            }
        }
        echo json_encode($new_array);
        die;
    }

if($_GPC['op']=='city'){
    $sql = "SELECT c.id,c.name FROM ". tablename('chbl_sun_county') . " c left join " . tablename('chbl_sun_county_city') .  " cc on c.id = cc.county_id where cc.city_id=".$_GPC['city_id'];
    $city_array = pdo_fetchall($sql);
    $new_city_array = array();
    foreach ($city_array as $k=>$v){
        if(!in_array($v,$new_city_array)){
            $new_city_array[]= $v;
        }
    }
    echo json_encode($new_city_array);
    die;
}
if($info['imgs']){
    if(strpos($info['imgs'],',')){
        $imgs= explode(',',$info['imgs']);
    }else{
        $imgs=array(
            0=>$info['imgs']
        );
    }
}
if($info['coordinates']){
    $coordinates = explode(',',$info['coordinates']);
    $info['lat'] = $coordinates[0];
    $info['lng'] = $coordinates[1];
}
if($info['store_details']){
    if(strpos($info['store_details'],',')){
        $store_details= explode(',',$info['store_details']);
    }else{
        $store_details=array(
            0=>$info['store_details']
        );
    }
}
//
function i_array_column($input, $columnKey, $indexKey=null){
    if(!function_exists('array_column')){
        $columnKeyIsNumber  = (is_numeric($columnKey))?true:false;
        $indexKeyIsNull            = (is_null($indexKey))?true :false;
        $indexKeyIsNumber     = (is_numeric($indexKey))?true:false;
        $result = array();
        foreach((array)$input as $key=>$row){
            if($columnKeyIsNumber){
                $tmp= array_slice($row, $columnKey, 1);
                $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null;
            }else{
                $tmp= isset($row[$columnKey])?$row[$columnKey]:null;
            }
            if(!$indexKeyIsNull){
                if($indexKeyIsNumber){
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key))?current($key):null;
                    $key = is_null($key)?0:$key;
                }else{
                    $key = isset($row[$indexKey])?$row[$indexKey]:0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }else{
        return array_column($input, $columnKey, $indexKey);
    }
}

$system=pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']));
$time=24*60*60*7;//一周
$time1=24*30*60*60;//一个月
$time2=24*91*60*60;//三个月
$time3=24*182*60*60;//半年
$time4=24*365*60*60;//一年

if(checksubmit('submit')){
    $data['store_commission']=$_GPC['store_commission'];
    $data['discount']=$_GPC['discount'];
    $data['user_name']=$_GPC['user_name'];
    $data['password']=$_GPC['password'];
    $data['store_name']=$_GPC['store_name'];
    $data['tel']=$_GPC['tel'];
    $data['user_id']=intval($_GPC['user_id']);
    $data['address']=$_GPC['address'];
    $data['time_type']=$_GPC['time_type'];
    $data['coordinates']=$_GPC['lat'] .','.$_GPC['lng'];
    $data['rz_time'] = time();
    $data['active_type']=$_GPC['active_type'];
    $data['uniacid']=$_W['uniacid'];
    $data['state']=2;
    $data['time_over']=2;
    $data['province_id'] = $_GPC['province_id'];
    $data['city_id'] = $_GPC['city_id'];
    $data['county_id'] = $_GPC['county_id'];
    $data['detail'] = $_GPC['detail'];
    if(!$data['province_id'] || !$data['city_id'] || !$data['county_id']){
        message('请填写所属城市','','error');
    }
    if(strlen($data['discount'])>4){
        message('会员折扣保留两位小数');
    };
    if($data['discount']>1 || $data['discount']<=0){
        message('请设置正确的会员折扣');
    }
    if($_GPC['imgs']){
        $data['imgs']=implode(",",$_GPC['imgs']);
    }else{
        $data['imgs']='';
    }
    if($_GPC['store_details']){
        $data['store_details']=implode(",",$_GPC['store_details']);
    }else{
        $data['store_details']='';
    }
    $data['introduce']=$_GPC['introduce'];
//            $data['store_details']=$_GPC['store_details'];
    $data['start_time']=$_GPC['start_time'];
    $data['end_time']=$_GPC['end_time'];
    if($_GPC["sj_ruzhu"]==1){
        if($_GPC['time_type']==1){
            $data['dq_time']=time()+$time;
        }
        if($_GPC['time_type']==2){
            $data['dq_time']=time()+$time1;
        }
        if($_GPC['time_type']==3){
            $data['dq_time']=time()+$time2;
        }
        if($_GPC['time_type']==4){
            $data['dq_time']=time()+$time3;
        }
        if($_GPC['time_type']==5){
            $data['dq_time']=time()+$time4;
        }
    }
    if($data['user_id']<=0){
        message('请选择所属用户');
    }
    if(!$data['store_name']){
        message('请填写商家名称');
    }
    if(!$data['tel']){
        message('请填写商家电话');
    }
    if(!$data['address']){
        message('请填写商家地址');
    }
     if($_GPC['id']==''){
        $res = pdo_insert('chbl_sun_store_active', $data);
        if($res){
            message('新增成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('新增失败','','error');
        }
    }else{
        $res = pdo_update('chbl_sun_store_active', $data,array('id'=>$_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('store',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/storeinfo2');