<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
$phone =$_GPC['phone'];
$zid =$_GPC['zid'];
$my_id =$_GPC['my_id'];
$sed =$_GPC['sed'];
$mzid =$_GPC['mzid'];

$qyyisheng = pdo_get("hyb_yl_zhuanjia",array('zid'=>$mzid,'uniacid'=>$uniacid));
$doct =$qyyisheng['z_name'];
$zzyisheng = pdo_fetch("SELECT * FROM".tablename("hyb_yl_addresshospitai")." as a left join ".tablename("hyb_yl_zhuanjia")."as b on b.nksid=a.id where a.uniacid='{$uniacid}' and zid='{$zid}'");
$host =$zzyisheng["z_yiyuan"];
$ksname= $zzyisheng["nksname"];
if($sed ==1){

  //查询患者信息hyb_yl_collect
  $huanze = pdo_get("hyb_yl_myinfors",array('uniacid'=>$uniacid,'my_id'=>$my_id));
  $openid =$huanze['openid'];
  $data =array(
    'goods_id'=>$zid
    );
  //更新患者的签约医生
  $res = pdo_update("hyb_yl_collect",$data,array('goods_id'=>$mzid,'openid'=>$openid));
  if($res){
     //发送短信
      require_once  dirname(__DIR__) . '/SignatureHelper.php';
      $aliduanxin = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_duanxin") . "WHERE uniacid = '{$uniacid}' ", array("uniacid" => $uniacid));
        if ($aliduanxin['stadus'] == 1) {
            $accessKeyId = $aliduanxin['key'];
            $accessKeySecret = $aliduanxin['scret'];
            $params["PhoneNumbers"] = $phone;
            $params["SignName"] = $aliduanxin['qianming'];
            $params["TemplateCode"] = $aliduanxin['zztz'];
            $myname = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_myinfors") . "WHERE uniacid = '{$uniacid}' and  my_id ='{$my_id}'", array("uniacid" => $uniacid));
            $name = $myname['myname'];
            $params['TemplateParam'] = Array(
              'name' => $name, 
              'doct' => $doct, 
              'host' => $host, 
              'ksname' => $ksname,
              'newdoc' => $newdoc
              );
           //var_dump($my_id,$zid,$name,$phoneNum,$doctor,$ksname,$params['TemplateParam']);
            if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
                $params["TemplateParam"] = json_encode($params["TemplateParam"]);
            }
            $helper = new SignatureHelper();
            $content = $helper->request($accessKeyId, $accessKeySecret, "dysmsapi.aliyuncs.com", array_merge($params, array("RegionId" => "cn-hangzhou", "Action" => "SendSms", "Version" => "2017-05-25",)));
        }
        echo json_encode($res);
  }else{
    echo '0';
  }
       
}else{

  //查询患者信息hyb_yl_collect
  $huanze = pdo_get("hyb_yl_myinfors",array('uniacid'=>$uniacid,'my_id'=>$my_id));


  $openid =$huanze['openid'];
  $data =array(
    'goods_id'=>$zid
    );
  //更新患者的签约医生
  $res = pdo_update("hyb_yl_collect",$data,array('goods_id'=>$mzid,'openid'=>$openid));
  echo json_encode($res);
}