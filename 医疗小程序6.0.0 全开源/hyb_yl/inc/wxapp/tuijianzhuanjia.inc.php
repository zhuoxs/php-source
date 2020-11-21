<?php
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$lat1 = $_GPC['lat'];
$lon1 = $_GPC['lng'];


$zjlist = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " as zj left join " . tablename("hyb_yl_addresshospitai") . " as k on zj.nksid=k.id where zj.uniacid='{$uniacid}'  and zj.z_yy_sheng = 1 AND zj.z_yy_type=1 order by zj.sord asc", array(":uniacid" => $uniacid));
  foreach ($zjlist as & $value) {
      $lat2 = $value['lat1'];
      $lon2 = $value['lng1'];
      $value['juli']=distance($lat1, $lon1, $lat2, $lon2);
      $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
      $value['url'] = unserialize($value['url']);
  }
  return $this->result(0, "success", $zjlist); 


  function distance($lat1, $lon1, $lat2,$lon2,$radius = 6378.137)
{
    $rad = floatval(M_PI / 180.0);

    $lat1 = floatval($lat1) * $rad;
    $lon1 = floatval($lon1) * $rad;
    $lat2 = floatval($lat2) * $rad;
    $lon2 = floatval($lon2) * $rad;

    $theta = $lon2 - $lon1;

    $dist = acos(sin($lat1) * sin($lat2) +
                cos($lat1) * cos($lat2) * cos($theta)
            );

    if ($dist < 0 ) {
        $dist += M_PI;
    }

    return $dist = $dist * $radius;
}