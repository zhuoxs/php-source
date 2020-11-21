<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'detail';
$storeid = intval($_GPC['storeid']);

$store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC", array(':weid' => $weid, ':id' => $storeid));

if (empty($store)) {
    message('店面不存在！');
}

$feedbacklist = pdo_fetchall("SELECT a.*,f.nickname as nickname FROM " . tablename($this->table_feedback) . " a LEFT JOIN " .
    tablename($this->table_fans) . " f ON a.from_user=f.from_user AND a.weid=f.weid WHERE a.weid=:weid AND a.storeid=:storeid  ORDER by a.id DESC", array(':storeid' => $storeid, ':weid' => $weid));

include $this->template($this->cur_tpl . '/allfeedback');