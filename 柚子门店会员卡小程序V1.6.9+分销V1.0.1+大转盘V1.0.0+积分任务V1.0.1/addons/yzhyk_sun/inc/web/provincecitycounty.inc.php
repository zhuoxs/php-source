<?php
global $_GPC, $_W;

//    根据 op 执行不同操作
switch($_GPC['op']){

    case "provinceselect":
        $sql = "select id,name as text,CONCAT(id,name) as keywords from ".tablename('yzhyk_sun_province');

        $list = pdo_fetchall($sql);
        echo json_encode($list);
        break;
    case "cityselect":
        $province_id = $_GPC['province_id'];
        $where = " where province_id = $province_id";

        $sql = "select id,name as text,CONCAT(id,name) as keywords from ".tablename('yzhyk_sun_city');


        $list = pdo_fetchall($sql.$where);
        echo json_encode($list);
        break;
    case "countyselect":
        $city_id = $_GPC['city_id'];
        $where = " where city_id = $city_id";

        $sql = "select id,name as text,CONCAT(id,name) as keywords from ".tablename('yzhyk_sun_county');

        $list = pdo_fetchall($sql.$where);
        echo json_encode($list);
        break;

}
