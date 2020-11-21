<?php
global $_W, $_GPC;
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$tpl = dir(IA_ROOT . '/addons/weisrc_dish/template/mobile/');
$tpl->handle;
$templates = array();
while ($entry = $tpl->read()) {
    if (preg_match("/^[a-zA-Z0-9]+$/", $entry) && $entry != 'common' && $entry != 'photo') {
        array_push($templates, $entry);
    }
}
$tpl->close();
$template = pdo_fetch("SELECT * FROM " . tablename($this->table_template) . " WHERE weid = :weid", array(':weid' => $_W['uniacid']));

if (empty($template)) {
    $templatename = 'style1';
} else {
    $templatename = $template['template_name'];
}

if (!empty($_GPC['templatename'])) {

    $data = array(
        'weid' => $_W['uniacid'],
        'template_name' => trim($_GPC['templatename']),
    );

    if (empty($template)) {
        pdo_insert($this->table_template, $data);
    } else {
        pdo_update($this->table_template, $data, array('weid' => $_W['uniacid']));
    }
    message('操作成功', $this->createWebUrl('template'), 'success');
}
include $this->template('web/template');