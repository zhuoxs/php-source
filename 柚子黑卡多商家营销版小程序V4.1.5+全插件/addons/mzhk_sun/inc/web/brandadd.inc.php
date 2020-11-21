<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
// //禁用错误报告
// error_reporting(0);
// //报告运行时错误
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
// //报告所有错误
// error_reporting(E_ALL);

if($_GPC['op']=='search'){
    $name=$_GPC['name'];
    $where=" WHERE uniacid=".$_W['uniacid'];
    $sql="select openid,name as uname,img from " . tablename("mzhk_sun_user") ." ".$where." and name like'%".$name."%' ";
    $list=pdo_fetchall($sql);
    echo json_encode($list);
    exit();
}

//获取分类
$sclist=pdo_getall('mzhk_sun_storecate',array('uniacid'=>$_W['uniacid']));

//获取腾讯地图key
if(pdo_fieldexists('mzhk_sun_system', 'is_open_server')) {
	$developkey=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']),array('developkey','is_open_server','is_open_server_submch'));
}else{
	$developkey=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']),array('developkey'));
}

$key = $developkey['developkey'];

//获取商圈
$arealist=pdo_getall('mzhk_sun_area',array('uniacid'=>$_W['uniacid'],'status'=>1));

//
$info=pdo_get('mzhk_sun_brand',array('bid'=>$_GPC['bid'],'uniacid'=>$_W['uniacid']));
$group=unserialize($info['group']);

//获取微信号
$userlist=pdo_get('mzhk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$info['bind_openid']),array("name"));
$info["name"] = $userlist["name"];

//判断是否使用服务商的商家子账号
$is_server = 0;
if(pdo_fieldexists('mzhk_sun_system', 'is_open_server')) {
    if($developkey["is_open_server"]==1){
        if($developkey["is_open_server_submch"]==1){
            $is_server = 1;
            if(checksubmit('submit')){
                $data['sub_mch_id'] = $_GPC['sub_mch_id'];
            }
        }
    }
}

//判断是否开启线下付设置
$system = pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
$open_payment = $system['open_payment'];

//判断优惠券
$is_counps = $system['is_counp'];
$counps = pdo_getall('mzhk_sun_coupon',array('uniacid'=>$_W['uniacid'],'bid'=>$_GPC['bid']));
if($is_counps==1 && $counps){
	$is_counp = 1;
}


//获取店内设施
$sflist=pdo_getall('mzhk_sun_storefacility',array('uniacid'=>$_W['uniacid']));
$facility = $info["facility"]?explode(",",$info["facility"]):array();
foreach($sflist as $k=> $v){
    if(in_array($v["id"], $facility)){
        $sflist[$k]["check"] = 1;
    }
}

if($info['logo']){
    if(strpos($info['logo'],',')){
        $logo= explode(',',$info['logo']);
    }else{
        $logo=array(
            0=>$info['logo']
        );
    }
}

if(checksubmit('submit')){
  //p($_GPC);die;
    // var_dump("<pre>");

    
    if($_GPC['bname']==null) {
        message('请您填写品牌名称', '', 'error');
    }elseif($_GPC['content']==null){
        message('请您填写品牌详情','','error');
    }elseif($_GPC['logo']==null){
        message('请您写上传图片','','error');die;
    }elseif($_GPC['address']==null){
        message('请您写商家地址','','error');die;
    }elseif($_GPC['phone']==null){
        message('为了方便客户找到店铺，请您写联系方式','','error');die;
    }elseif($_GPC['loginname']=='' || $_GPC['loginpassword']==''){
        message('登陆账号和密码不能为空','','error');die;
    }elseif($_GPC['coordinates']==''){
        message('请定位地图，需要获取经纬度','','error');die;
    }

	//优惠券设置
	if($is_counp==1){
		$data['is_counp']  = $_GPC['is_counp'];
    	pdo_update('mzhk_sun_coupon', $data,array('uniacid'=>$_W['uniacid'],'bid'=>$_GPC['bid']));
	}


    $store = $_GPC['store_id'];
    $storearr = array();
    if(!empty($store)){
        $storearr = explode("$$$",$store);
    }
    $data['store_id'] = $storearr[0];
    $data['store_name'] = $storearr[1];

    $data['starttime']=$_GPC['starttime'];
    $data['endtime']=$_GPC['endtime'];

    $data['facility']=implode(",",$_GPC['facility']);

    //新增配送数据
    $data['deliveryfee']=$_GPC['deliveryfee'];
    $data['deliverytime']=$_GPC['deliverytime'];
    $data['deliveryaway']=$_GPC['deliveryaway'];

    $data['bind_openid'] = $_GPC['bind_openid'];
    $data['in_openid'] = $_GPC['bind_openid'];
    $data['loginname'] = $_GPC['loginname'];
    $data['loginpassword'] = $_GPC['loginpassword'];
	$data['brand_open'] = $_GPC['brand_open'];
	$data['time_open'] = $_GPC['time_open'];
	$data['open_payment'] = $_GPC['open_payment'];

    $coordinates = trim($_GPC['coordinates']);
    //p($coordinates);
    $coordinatesarr = explode(",",$coordinates);
    //p($coordinatesarr);
    $data['coordinates'] = trim($coordinates);
    $data['latitude'] = $coordinatesarr[0];//纬度
    $data['longitude'] = $coordinatesarr[1];//精度

    $data['sort'] = intval($_GPC['sort']);

    $data['enable_printer'] = intval($_GPC['enable_printer']);
	$data['backups_printer'] = intval($_GPC['backups_printer']);
    $data['printer_user'] = $_GPC['printer_user'];
    $data['printer_ukey'] = $_GPC['printer_ukey'];
    $data['printer_sn'] = $_GPC['printer_sn'];

    
    //p($data['longitude']);
    //exit;
    //$data['coordinates'] = $data['latitude'].",".$data['longitude'];

    //查看登陆账号是否唯一
    $loginname_old = trim($_GPC['loginname_old']);
    if(empty($loginname_old)){
        $checkinfo=pdo_get('mzhk_sun_brand',array('loginname'=>$_GPC['loginname'],'uniacid'=>$_W['uniacid']));
        if($checkinfo){
            message('登陆账号已经存在，请重新输入','','error');die;
        }
    }else{
        if($_GPC['loginname'] != $loginname_old){
            $checkinfo=pdo_get('mzhk_sun_brand',array('loginname'=>$_GPC['loginname'],'uniacid'=>$_W['uniacid']));
            if($checkinfo){
                message('登陆账号已经存在，请重新输入','','error');die;
            }
        }
    }

    $data['memdiscount'] = $_GPC['memdiscount'];
    $data['commission'] = intval($_GPC['commission']);

    $data['uname']=$_GPC['uname'];
    $data['uniacid']=$_W['uniacid'];
	$data['bname']=$_GPC['bname'];
    $data['phone']=$_GPC['phone'];
    $data['address']=$_GPC['address'];
	$data['status']=2;
    $data['img']=$_GPC['img'];
	$data['cimg']=$_GPC['cimg'];
    $data['price']=$_GPC['price'];
    $data['feature']=$_GPC['feature'];
    $data['type']=$_GPC['type'];
	$data['content']=html_entity_decode($_GPC['content']);
    $data['logo']=implode(",",$_GPC['logo']);
	$data['aid']=$_GPC['aid'];

	//配送设置
    $data['is_delivery'] = $_GPC['is_delivery'];
    // $data['delivery_start'] = $_GPC['delivery_start'];
    // $data['delivery_free'] = $_GPC['delivery_free'];
    $data['delivery_distance'] = $_GPC['delivery_distance'];
    // $data['delivery_price'] = $_GPC['delivery_price'];
    array_multisort(array_column($_GPC['group'],'delivery_distancesmall'),SORT_ASC,$_GPC['group']);
    $group = array_values($_GPC['group']);
    // var_dump('<pre>');
    // var_dump($_GPC['group']);
    // var_dump($group);
    // var_dump($group['0']['delivery_distancesmall']);
    // die;
    if($group['0']['delivery_distancesmall']||$group['0']['delivery_distancebig']||$group['0']['delivery_start']||$group['0']['delivery_free']||$group['0']['delivery_price']){
        
        foreach ($group as $k => $v) {

                if($v['delivery_distancesmall']>$v['delivery_distancebig']){
                    message('每行的最小距离不得大于最大距离！！', '', 'error');
                }
                if($v['delivery_distancesmall']==null||$v['delivery_distancebig']==null||$v['delivery_start']==null||$v['delivery_free']==null||$v['delivery_price']==null){
                    message('配送设置有缺少数据，请填写仔细！', '', 'error');
                }
                if($group[$k+1]['delivery_distancesmall']!=NULL){
                    // var_dump(1);
                    if($group[$k+1]['delivery_distancesmall']<$group[$k]['delivery_distancebig']){
                        message('下一行的最小距离不得小于前一行的最大距离！！', '', 'error');
                    }
                }
                if($v['delivery_distancebig']>$_GPC['delivery_distance']){
                    message('不得大于配送最大范围！！！', '', 'error');
                }
        }
        $data['group'] = serialize($group);
    }
    
   
	if(empty($_GPC['bid'])){
        $res = pdo_insert('mzhk_sun_brand', $data,array('uniacid'=>$_W['uniacid']));
        $bid = pdo_insertid();
        if($res){
            message('添加成功',$this->createWebUrl('brand',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('mzhk_sun_brand', $data, array('bid' => $_GPC['bid'],'uniacid'=>$_W['uniacid']));
    }
	if($res){
		message('修改成功',$this->createWebUrl('brand',array()),'success');
	}else{
		message('修改失败','','error');
	}
}

include $this->template('web/brandadd');