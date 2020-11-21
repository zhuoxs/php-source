<?php
/*
 * 虚拟卡密种类管理
 * [增删改查]
*/
defined('IN_IA') or exit('Access Denied');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'passwdTypeManager';
if ($operation == 'passwdTypeAdd') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename('wg_fenxiao_passwd_type') . " WHERE id =:id and weid=:uniacid limit 1", array(
            ':id' => $id,
            ':uniacid' => $_W['uniacid']
        ));
        
    }
    if (checksubmit('passwdTypeAdd')) {
    	if (empty($_GPC['name'])) {
    	    message('请填写种类名称');
    	}
        $data = array(
            'weid' => $_W['uniacid'],
            'name'=>trim($_GPC['name'])
        );
        if (!empty($id)) {
            pdo_update('wg_fenxiao_passwd_type', $data, array('id' => $id, 'weid' => $_W['uniacid']));
            message('修改成功',$this->createWebUrl('passwdtype',array('op'=>'passwdTypeAdd','id'=>$id)),'success');
        } else {
            pdo_insert('wg_fenxiao_passwd_type', $data);
            $id = pdo_insertid();
            message('新增成功',$this->createWebUrl('passwdtype',array('op'=>'passwdTypeAdd','id'=>$id)),'success');
        } 
    }
}elseif ($operation == 'passwdTypeManager') {
   $list = pdo_fetchall("SELECT * FROM " . tablename('wg_fenxiao_passwd_type') . " WHERE `weid`=:weid ORDER BY id asc",array(':weid'=>$_W['uniacid']));

    foreach($list as &$it) {
        $it['use'] = pdo_count('wg_fenxiao_passwds',[
            'type' => $it['id'],
            'status >' => 0
        ]);
        $it['unused'] = pdo_count('wg_fenxiao_passwds',[
            'type' => $it['id'],
            'status' => 0
        ]);
    }
}elseif ($operation == 'passwdTypeDel') {
   $id  = intval($_GPC['id']);
   pdo_delete('wg_fenxiao_passwd_type', array('id' => $id, 'weid' => $_W['uniacid']));
   message('删除成功','referer','success');
}
include $this->template('passwdtype');