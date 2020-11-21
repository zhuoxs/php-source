<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item = pdo_get('ymktv_sun_wineset',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['wine_num'] = $_GPC['wine_num'];
    $data['day_num'] = $_GPC['day_num'];
    $data['details'] = html_entity_decode($_GPC['details']);
    if ($_GPC['id'] == '') {
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('ymktv_sun_wineset', $data);
        if ($res) {
            message('保存成功', $this->createWebUrl('keepwine', array()), 'success');
        } else {
            message('保存失败', '', 'error');
        }
    } else {
        $res = pdo_update('ymktv_sun_wineset', $data, array('id' => $_GPC['id']));
        if ($res) {
            message('保存成功', $this->createWebUrl('keepwine', array()), 'success');
        } else {
            message('保存失败', '', 'error');
        }
    }
    }
include $this->template('web/keepwine');