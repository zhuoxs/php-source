<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('chbl_sun_groups',array('uniacid' => $_W['uniacid']));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$condition = ' WHERE `uniacid` = :uniacid ';
$params = array(':uniacid' => $_W['uniacid']);

if (!empty($_GPC['keyword'])) {
    $condition .= ' AND `title` LIKE :title';
    $params[':title'] = '%' . trim($_GPC['keyword']) . '%';
}

$sql = 'SELECT COUNT(*) FROM ' . tablename('chbl_sun_groups') .$condition ;

$total = pdo_fetchcolumn($sql, $params);

if (!empty($total)) {
    $sql = 'SELECT * FROM  ' . tablename('chbl_sun_groups') .$condition.' ORDER BY  `selftime`  DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
    $list = pdo_fetchall($sql, $params);
    foreach ($list as $k=>$v){
        if($list[$k]['store_id']==0){
            $list[$k]['store_name'] = '暂无店铺信息';
        }else{
            $list[$k]['store_name'] = pdo_getcolumn('chbl_sun_store_active',array('uniacid'=>$_W['uniacid'],'id'=>$v['store_id']),'store_name');
        }
    }
//    if($list)
//    {
//
//        foreach($list as $k=>$v)
//        {
//            //获得人数
//            $huode = pdo_getall('chbl_sun_gift_order',array('pid'=>$v['id'],'uniacid'=>$_W['uniacid']));
//            $huodenum = count($huode);
//            //参与人数
//            $part_num = pdo_getall('chbl_sun_user_active',array('active_id'=>$v['id'],'uniacid'=>$_W['uniacid']));
//            $a = [];
//            foreach ($part_num as $kk=>$vv){
//                $a[$vv['uid']] = $vv;
//            }
//            $partnum = count($a);
//
//            $condition = ' WHERE `pid` = '.$v['id'].' AND `uniacid` = :uniacid AND `num` <  '.$v['num'];
//            $sql = 'SELECT id ,uid,pid FROM  ' . tablename('chbl_sun_activerecord') .$condition;
//
//            $active_record = pdo_fetchall($sql, $params);
//            $list[$k]['active_record'] = $partnum;
//
//            //礼品数
//            $condition = ' WHERE `uniacid` = :uniacid AND `pid` =  '.$v['id'];
//            $sql = 'SELECT id FROM  ' . tablename('chbl_sun_gift') .$condition;
//
//            $coupon_list = pdo_fetchall($sql, $params);
//            $coupon_count = count($coupon_list);
//            //echo $coupon_count;
//            $get_count = 0;
//            if($active_record)
//            {
//                foreach($active_record as $k2=>$v)
//                {
//                    $condition = ' WHERE `uniacid` = :uniacid AND `uid` = '.$v['uid'].' AND  `pid` =  '.$v['pid'];
//                    $sql = 'SELECT id FROM  ' . tablename('chbl_sun_gift_order') .$condition;
//                    //echo $sql;
//                    $coupon_order_list = pdo_fetchall($sql, $params);
//                    $coupon_order_count = count($coupon_order_list);
//                    //echo $coupon_order_count;
//                    if($coupon_order_count>=$coupon_count)
//                    {
//                        $get_count++;
//                    }
//                }
//            }
//            $list[$k]['get_count'] = $huodenum;
//        }
//    }
    $pager = pagination($total, $pindex, $psize);
}
if($operation == 'done'){
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename('chbl_sun_groups') . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，订单不存在或是已经被删除！');
    }
    $status= intval($_GPC['status']);
    if($status == 1)
    {
        $condition = ' WHERE `uniacid` = :uniacid AND `status` =:status ';
        $params = array(':uniacid' => $_W['uniacid'],':status'=>$status);
        $active = pdo_fetch("SELECT id FROM " . tablename('chbl_sun_groups') .$condition , $params);

        pdo_update('chbl_sun_groups', array('status'=>$status), array('id' => $id));

        message('活动开启成功！', referer(), 'success');

    }else{
        pdo_update('chbl_sun_groups', array('status'=>$status), array('id' => $id));

        message('活动关闭成功！', referer(), 'success');

    }
}
if($operation == 'delete'){
    $id = intval($_GPC['id']);

    $res = pdo_delete('chbl_sun_groups',array('id'=>$id));
    if($res){
        message('删除成功！',referer(), 'success');
    }else{
        message('删除失败！');
    }
}

include $this->template('web/groups');