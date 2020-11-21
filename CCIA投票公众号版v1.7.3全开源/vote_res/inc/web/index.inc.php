<?php

global $_W, $_GPC;
$do = trim($_GPC['do']);
if ($do == 'index') {
    if ($_W['ispost']) {
        $data = $_GPC['data'];
        if ($this->saveSet($data)) {
            show_json(1, '参数设置成功');
        } else {
            show_json(0, '设置未发生改变');
        }
    }
    $url = $_W['siteroot'] . 'app/' . ltrim($this->createMobileUrl('index'), './');
    $qrurl = $this->createQrcode($url);
    include $this->template('web/index');
}