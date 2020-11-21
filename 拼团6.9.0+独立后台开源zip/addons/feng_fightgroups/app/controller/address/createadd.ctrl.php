<?php
defined('IN_IA') or exit('Access Denied');
wl_load()->model('address');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

session_start();
if(!empty($_GPC['goodsid'])) $goodsid = $_SESSION['goodsid'] = $_GPC['goodsid'];
$goodsid = $_SESSION['goodsid'];
$tuanid = $_GPC['tuanid'];
$pagetitle = !empty($config['tginfo']['sname']) ? '编辑收货地址 - '.$config['tginfo']['sname'] : '编辑收货地址';

if($goodsid){
	$bakurl = app_url('order/orderconfirm',array('id'=>$goodsid,'tuan_id'=>$tuanid));
}else{
	$bakurl = app_url('address/addmanage');
}

$id = $_GPC['id'];
$weid = $_W['uniacid'];
$openid = $_W['openid'];

if ($op == 'display') {
    if($id){
        $addres = address_get_by_id($id);
    }  	
	include wl_template('address/createadd');
}

if ($op == 'addwechat'){
	$shareAddress = shareAddress();
	include wl_template('address/createadd');
}

if ($op == 'post') {
	$citys = explode(" ", $_GPC['citys']); 
    if(!empty($id)){
        $status = address_get_by_id($id);
        $data=array(
            'openid'           => $openid,
            'uniacid'          => $weid,
            'cname'            => $_GPC['myname'],
            'tel'              => $_GPC['myphone'],
            'province'         => $citys[0],
            'city'             => $citys[1],
            'county'           => $citys[2],
            'detailed_address' => $_GPC['detailed'],
            'type'             => $_GPC['type'],
            'addtime'          => time()
        );
        if(pdo_update('tg_address',$data,array('id' => $id))){ 
        	wl_json(1);
        }else{   
            wl_json(0,'收货地址编辑失败!');
        }
    }else{
        $data1=array(
            'openid' => $openid,
            'uniacid'=> $weid,
            'cname'            => $_GPC['myname'],
            'tel'              => $_GPC['myphone'],
            'province'         => $citys[0],
            'city'             => $citys[1],
            'county'           => $citys[2],
            'detailed_address' => $_GPC['detailed'],
            'type'             => $_GPC['type'],
            'addtime'          => time(),
            'status'           => '1'
    	);
    	
    	$moren = address_get_by_params("status = 1 and openid = '{$openid}'");
    	pdo_update('tg_address',array('status' => 0),array('id' => $moren['id']));
        if(pdo_insert('tg_address',$data1)){
        	wl_json(1);
        }else{                      
            wl_json(0,'收货地址编辑失败!');
        }                 
    }   
}

if ($op == 'deletes'){
	if($id){
        if(pdo_delete('tg_address',array('id' => $id ))){
            wl_json(1);
        }else{
            wl_json(0,'收货地址删除失败!');
        }        
    }else{
        wl_json(0,'缺少地址id参数');
    }
}
