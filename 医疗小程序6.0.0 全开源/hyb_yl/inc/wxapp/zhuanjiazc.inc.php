<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$zid = $_GPC['zid'];
$nksid = $_REQUEST['nksid'];
$docjwd = pdo_get('hyb_yl_addresshospitai',array('id'=>$hosid),array('lat','lng'));

$lat = $docjwd['lat'];
$lng = $docjwd['lng'];
$data['uniacid'] = $_W['uniacid'];
$data['zjshenfenz'] = $_GPC['zjshenfenz'];
$data['openid'] = $_REQUEST['openid'];
$data['z_name'] = $_REQUEST['z_name'];
$data['nksname'] = $_GPC['nksname'];
$data['z_content'] = $_REQUEST['z_content'];
$data['hosid'] = $_REQUEST['hosid'];
$data['nksid'] = $_REQUEST['nksid'];
$data['z_zhicheng'] = $_REQUEST['z_zhicheng'];
$data['z_sex'] = $_REQUEST['z_sex'];
$data['z_yiyuan'] = $_REQUEST['z_yiyuan'];
$data['z_zhenzhi'] = $_GPC['z_zhenzhi'];
$data['zgzimgurl1back'] = $_GPC['zgzimgurl1back'];
$data['zgzimgurl2back'] = $_GPC['zgzimgurl2back'];
$data['zczimgurlback'] = $_GPC['zczimgurlback'];
$data['sfzimgurl1back'] = $_GPC['sfzimgurl1back'];
$data['sfzimgurl2back'] = $_GPC['sfzimgurl2back'];
$data['gzzimgurlback'] = $_GPC['gzzimgurlback'];
$data['zkbianhao'] = $_GPC['zkbianhao'];
$data['sfzbianhao'] = $_GPC['sfzbianhao'];
$data['z_thumbs'] = $_GPC['z_thumbs'];
$data['lat1'] = $lat;
$data['lng1'] = $lng;

if (!empty($zid)) {
	//var_dump('12313');
    $res = pdo_update("hyb_yl_zhuanjia", $data, array("zid" => $zid, "uniacid" => $uniacid));
} else {
	//var_dump('11111');
    $res = pdo_insert("hyb_yl_zhuanjia", $data);
   
}
return $this->result(0, 'success', $res);
