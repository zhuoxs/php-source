<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('wnjz_sun_system',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){
    $data['poster_font']=$_GPC['poster_font'];
    $data['poster_img']=$_GPC['poster_img'];
    $data['uniacid'] = $_W['uniacid'];
    if ($_GPC['id'] == '') {
        $res = pdo_insert('wnjz_sun_system', $data);
        if ($res) {
            message('添加成功', $this->createWebUrl('poster', array()), 'success');
        } else {
            message('添加失败', '', 'error');
        }
    } else {
        $res = pdo_update('wnjz_sun_system', $data, array('id' => $_GPC['id']));
        if ($res) {
            message('编辑成功', $this->createWebUrl('poster', array()), 'success');
        } else {
            message('编辑失败', '', 'error');
        }
    }
}
include $this->template('web/poster');