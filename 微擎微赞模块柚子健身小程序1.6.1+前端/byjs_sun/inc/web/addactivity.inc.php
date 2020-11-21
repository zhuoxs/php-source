<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('byjs_sun_activity',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$id = $_GPC['id'];
if (!empty($id)) {
    $item = pdo_fetch("SELECT *  FROM " . tablename('byjs_sun_activity') . " WHERE id = :id", array(':id' => $id));

}

if(checksubmit('submit')){


    $data = array(

        'uniacid' => $_W['uniacid'],
        'name'=>$_GPC['name'],
        'prize_title'=>$_GPC['prize_title'],
        'rule' => ihtmlspecialchars($_GPC['rule']),
        'endtime' => $_GPC['endtime'],
        'fw_num' => $_GPC['fw_num'],
        'fxq_num' => $_GPC['fxq_num'],
        'fxq_maxnum' => $_GPC['fxq_maxnum'],
        'fxhy_num'=>$_GPC['fxhy_num'],
        'fxhy_maxnum' => $_GPC['fxhy_maxnum'],
        'img'=>$_GPC['img'],

    );
    if (!empty($id)) {

        pdo_update('byjs_sun_activity', $data, array('id' => $id,'uniacid'=>$_W['uniacid']));
    } else {
        pdo_insert('byjs_sun_activity', $data);

    }
    message('更新成功！', $this->createWebUrl('activity'), 'success');
}
include $this->template('web/addactivity');