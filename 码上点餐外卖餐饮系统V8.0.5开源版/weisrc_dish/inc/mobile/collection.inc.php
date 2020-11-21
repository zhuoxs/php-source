<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'collection';

$id = intval($_GPC['id']);

$restlist = pdo_fetchall("SELECT a.* FROM " . tablename($this->table_stores) . " a INNER JOIN " . tablename($this->table_collection) . " b ON a.id = b.storeid where  a.weid = :weid and is_show=1 and b.from_user=:from_user ORDER BY a.displayorder DESC, a.id DESC", array(':weid' => $weid, ':from_user' => $from_user));

include $this->template($this->cur_tpl . '/collection');