<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('byjs_sun_bargain',array('uniacid' => $_W['uniacid']));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$condition = ' WHERE `uniacid` = :uniacid ';
$params = array(':uniacid' => $_W['uniacid']);

if (!empty($_GPC['keyword'])) {
    $condition .= ' AND `title` LIKE :title';
    $params[':title'] = '%' . trim($_GPC['keyword']) . '%';
}


$sql = 'SELECT COUNT(*) FROM ' . tablename('byjs_sun_bargain') .$condition ;

$total = pdo_fetchcolumn($sql, $params);

if (!empty($total)) {
    $sql = 'SELECT * FROM  ' . tablename('byjs_sun_bargain') .$condition.' ORDER BY  `selftime`  DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
    $list = pdo_fetchall($sql, $params);
    if($list)
    {

        foreach($list as $k=>$v)
        {
            //获得人数
            $huode = pdo_getall('byjs_sun_gift_order',array('pid'=>$v['id'],'uniacid'=>$_W['uniacid']));
            $huodenum = count($huode);
            //参与人数
            $part_num = pdo_getall('byjs_sun_user_active',array('active_id'=>$v['id'],'uniacid'=>$_W['uniacid']));
            $a = [];
            foreach ($part_num as $kk=>$vv){
                $a[$vv['uid']] = $vv;
            }
            $partnum = count($a);

            $condition = ' WHERE `pid` = '.$v['id'].' AND `uniacid` = :uniacid AND `num` <  '.$v['num'];
            $sql = 'SELECT id ,uid,pid FROM  ' . tablename('byjs_sun_activerecord') .$condition;

            $active_record = pdo_fetchall($sql, $params);
            $list[$k]['active_record'] = $partnum;

            //礼品数
            $condition = ' WHERE `uniacid` = :uniacid AND `pid` =  '.$v['id'];
            $sql = 'SELECT id FROM  ' . tablename('byjs_sun_gift') .$condition;

            $coupon_list = pdo_fetchall($sql, $params);
            $coupon_count = count($coupon_list);
            //echo $coupon_count;
            $get_count = 0;
            if($active_record)
            {
                foreach($active_record as $k2=>$v)
                {
                    $condition = ' WHERE `uniacid` = :uniacid AND `uid` = '.$v['uid'].' AND  `pid` =  '.$v['pid'];
                    $sql = 'SELECT id FROM  ' . tablename('byjs_sun_gift_order') .$condition;
                    //echo $sql;
                    $coupon_order_list = pdo_fetchall($sql, $params);
                    $coupon_order_count = count($coupon_order_list);
                    //echo $coupon_order_count;
                    if($coupon_order_count>=$coupon_count)
                    {
                        $get_count++;
                    }
                }
            }
            $list[$k]['get_count'] = $huodenum;
        }
    }
    $pager = pagination($total, $pindex, $psize);
}
if($operation == 'done'){
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename('byjs_sun_bargain') . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，订单不存在或是已经被删除！');
    }
    $status= intval($_GPC['status']);
    if($status == 1)
    {
        $condition = ' WHERE `uniacid` = :uniacid AND `status` =:status ';
        $params = array(':uniacid' => $_W['uniacid'],':status'=>$status);
        $active = pdo_fetch("SELECT id FROM " . tablename('byjs_sun_bargain') .$condition , $params);

        pdo_update('byjs_sun_bargain', array('status'=>$status), array('id' => $id));

        message('活动开启成功！', referer(), 'success');

    }else{
        pdo_update('byjs_sun_bargain', array('status'=>$status), array('id' => $id));

        message('活动关闭成功！', referer(), 'success');

    }
}
if($operation == 'delete'){
    $id = intval($_GPC['id']);

    $res = pdo_delete('byjs_sun_bargain',array('id'=>$id));
    if($res){
        message('删除成功！',referer(), 'success');
    }else{
        message('删除失败！');
    }
}

include $this->template('web/bargainlist');