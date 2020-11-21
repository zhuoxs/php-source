<?php
defined('IN_IA') or exit('Access Denied');
//通知患者医生已经回复
global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $lng = $_GPC['jingdu'];
        $lat = $_GPC['latitude'];
        $distance = 20;//范围（单位千米）
        define('EARTH_RADIUS', 6371);//地球半径，平均半径为6371km
        $dlng = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
        $dlat = $distance/EARTH_RADIUS;
        $dlat = rad2deg($dlat);
        $squares = array('left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
                'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
                'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
                'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
                );
        $newlat = $squares['right-bottom']['lat'];
        $newlattop = $squares['left-top']['lat'];
        $newlng = $squares['right-bottom']['lng'];
        $newlngtop = $squares['left-top']['lng'];
     
        $op = $_GPC['op'];
        if ($op == 'display') {
            $zjlist = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " as zj left join " . tablename("hyb_yl_addresshospitai") . " as k on zj.nksid=k.id where zj.uniacid='{$uniacid}' and k.lat<>0 and k.lat>'{$newlat}' and k.lat<{$newlattop} and k.lng>'{$newlngtop}' and k.lng<'{$newlng}'  and zj.z_yy_sheng = 1 order by zj.sord asc", array(":uniacid" => $uniacid));
            foreach ($zjlist as & $value) {
                $value['z_thumbs'] = $_W['attachurl'] . $value['z_thumbs'];
                $value['url'] = unserialize($value['url']);
                $value['z_zhenzhi'] = explode(',', $value['z_zhenzhi']);
            }
            return $this->result(0, "success", $zjlist);
        }
        if ($op == 'post') {
            $zid = $_GPC['zid'];
            $zjlist = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . "as a left join".tablename("hyb_yl_addresshospitai")."as b on b.id=a.nksid where a.uniacid='{$uniacid}' and a.z_yy_sheng = 1 and a.zid='{$zid}'");
            $zjlist['z_thumbs'] = $_W['attachurl'] . $zjlist['z_thumbs'];
            $zjlist['z_zhenzhi'] =explode(',', $zjlist['z_zhenzhi'] );
            return $this->result(0, "success", $zjlist);
        }
