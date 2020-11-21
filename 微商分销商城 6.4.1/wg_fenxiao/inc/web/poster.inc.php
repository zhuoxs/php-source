<?php
/*
 * 推广二维码管理
 * [增删改查]
*/
defined('IN_IA') or exit('Access Denied');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'posterManager';
if ($operation == 'posterAdd') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename('wg_fenxiao_poster') . " WHERE id =:id and weid=:uniacid limit 1", array(
            ':id' => $id,
            ':uniacid' => $_W['uniacid']
        ));
        if (!empty($item)) {
            $data = json_decode(str_replace('&quot;', "'", $item['data']) , true);
        }
    }else{
        $item['isdefault'] = 1;
    }
    if (checksubmit('submit')) {
        $data = array(
            'weid' => $_W['uniacid'],
            'title' => trim($_GPC['title']) ,
            'isdefault' => intval($_GPC['isdefault']),
            'bg' => trim($_GPC['bg']),
            'data' => htmlspecialchars_decode($_GPC['data']) ,
            'waittext'=>trim($_GPC['waittext']),
            'notext'=>trim($_GPC['notext']),
            'isopen'=>intval($_GPC['isopen']),
            'createtime'=>time()
        );
        if (!empty($id)) {
            pdo_update('wg_fenxiao_poster', $data, array('id' => $id, 'weid' => $_W['uniacid']));
            message('修改成功',$this->createWebUrl('poster',array('op'=>'posterAdd','id'=>$id)),'success');
        } else {
            pdo_insert('wg_fenxiao_poster', $data);
            $id = pdo_insertid();
            message('新增成功',$this->createWebUrl('poster',array('op'=>'posterAdd','id'=>$id)),'success');
        } 
    }
}elseif ($operation == 'posterManager') {
   $list = pdo_fetchall("SELECT * FROM " . tablename('wg_fenxiao_poster') . " WHERE `weid`=:weid ORDER BY isdefault desc",array(':weid'=>$_W['uniacid']));
}elseif ($operation == 'posterDel') {
   $id  = intval($_GPC['id']);
   pdo_delete('wg_fenxiao_poster', array('id' => $id, 'weid' => $_W['uniacid']));
   message('删除成功','referer','success');
}
include $this->template('poster');
