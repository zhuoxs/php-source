<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Web_Order extends Web_Base
{
    /**
     * 单次回收列表
     */
    public function orderList(){
        global $_GPC, $_W;
        $status = ['未接单', '已接单', '已取消', '已完成'];
        $query = "";
        if($_GPC['keyword']){
            $query = " AND (name like '%{$_GPC['keyword']}%' or  phone like '%{$_GPC['keyword']}%' or o_sn like '%{$_GPC['keyword']}%')";
        }
        $pageSize = 20;
        $_GPC['page'] = $_GPC['page'] ?: 1;
        $pageCur = ($_GPC['page']-1) * $pageSize;
        $sql = "SELECT *  FROM ".tablename('ox_reclaim_order')." WHERE uniacid = {$_W['uniacid']}  AND cycle = 0 {$query} ORDER BY id DESC LIMIT {$pageCur},{$pageSize}";
        $list = pdo_fetchall($sql);
        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
            if(!empty($v['admin_uid'])){
                $member = pdo_get('ox_reclaim_member',array('uid'=>$v['admin_uid']));
                $list[$k]['admin_name'] = $member['name']==''? $member['nickname'] : $member['name'];
            }else{
                $list[$k]['admin_name'] = '未接单';
            }
        }
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_order')."  where `uniacid`= {$_W['uniacid']}  and cycle = 0 {$query}  ");
        $pager = pagination2($total, $pageCur, $pageSize);
        include $this->template();
    }

    /**
     * 周期回收列表
     */
    public function cycleList(){
        global $_GPC, $_W;
        $status = ['未接单', '已接单', '已取消', '已完成'];
        $query = "";
        if($_GPC['keyword']){
            $query = " AND (name like '%{$_GPC['keyword']}%' or  phone like '%{$_GPC['keyword']}%' or o_sn like '%{$_GPC['keyword']}%')";
        }
        $pageSize = 20;
        $_GPC['page'] = $_GPC['page'] ?: 1;
        $pageCur = ($_GPC['page']-1) * $pageSize;
        $sql = "SELECT * ,((({$_SERVER['REQUEST_TIME']} - last_time)/86400)-cycle) AS days FROM ".tablename('ox_reclaim_order')." WHERE uniacid = {$_W['uniacid']}  AND cycle > 0 {$query} ORDER BY days DESC LIMIT {$pageCur},{$pageSize}";
        $list = pdo_fetchall($sql);
        foreach ($list as $k => $v){
            $list[$k]['days'] = ceil($v['days']);
        }
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_order')."  where `uniacid`= {$_W['uniacid']}  and cycle > 0  {$query} ");
        $pager = pagination2($total, $pageCur, $pageSize);
        include $this->template();
    }

    /**
     * 取消订单
     */
    public function cancel(){
        global $_GPC, $_W;
        pdo_update('ox_reclaim_order',['status'=>2],['uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']]);
        $this->success('取消成功','',2);
    }


}

?>