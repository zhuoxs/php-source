<?php 


global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$cateid = $_GPC['cateid'];
$chid = $_GPC['chid'];
$list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type ='indexad' ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));












return include self::template('web/Base/indexad');