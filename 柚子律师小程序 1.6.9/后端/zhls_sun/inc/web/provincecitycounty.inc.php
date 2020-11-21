<?php
global $_GPC, $_W;

switch ($_GPC['op']){
    case "provinceselect":
        $data = pdo_fetchall("select id,name as text from ".tablename('zhls_sun_province'));
        echo json_encode($data);
        break;
    case "cityselect":
        $province_id = $_GPC['province_id'];
        $data = pdo_fetchall("select id,name as text from ".tablename('zhls_sun_city')." where province_id = $province_id");
        echo json_encode($data);
        break;
    case "countyselect":
        $city_id = $_GPC['city_id'];
        $data = pdo_fetchall("select id,name as text from ".tablename('zhls_sun_county')." where city_id = $city_id");
        echo json_encode($data);
        break;
}