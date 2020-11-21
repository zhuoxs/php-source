<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$icon = tomedia('./addons/weisrc_dish/icon.jpg');

$lat = trim($_GPC['lat']);
$lng = trim($_GPC['lng']);
if (!empty($lat) && !empty($lng)) {
    setcookie($this->_lat, $lat, TIMESTAMP + 3600 * 12);
    setcookie($this->_lng, $lng, TIMESTAMP + 3600 * 12);
} else {
    if (isset($_COOKIE[$this->_lat])) {
        $lat = $_COOKIE[$this->_lat];
        $lng = $_COOKIE[$this->_lng];
    }
}
if (empty($lat) || empty($lng)) {
    message('还未定位');
}

$list = pdo_fetchall("SELECT *,(lat-:lat) * (lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename($this->table_stores) . " where weid = :weid and is_show=1 ORDER BY dist, displayorder DESC,id DESC", array(':weid' => $weid, ':lat' => $lat, ':lng' => $lng));

$maps = array();
foreach ($list as $key => $value) {
    $maps[] = array(
        'url' => $this->createMobileUrl('detail', array('id' => $value['id']), true),
        'title' => $value['title'],
        'content' => $value['address'],
        'mobile' => $value['tel'],
        'img' => tomedia($value['logo']),
        'dist' => $this->getDistance($value['lat'], $value['lng'], $lat, $lng) . '千米',
        'oname' => "商家详情",
        'imageOffset' => array('width' => 0, 'height' => 3),
        'position' => array('lat' => $value['lat'], 'lng' => $value['lng'])
    );
}
$json_maps = json_encode($maps);
include $this->template($this->cur_tpl . '/map');