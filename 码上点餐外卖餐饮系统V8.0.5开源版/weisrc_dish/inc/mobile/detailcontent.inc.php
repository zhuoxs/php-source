<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$id = intval($_GPC['id']);

$item = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC", array(':weid' => $weid, ':id' => $id));
$title = $item['title'];

if (empty($item)) {
    message('店面不存在！');
}

include $this->template($this->cur_tpl . '/detailcontent');