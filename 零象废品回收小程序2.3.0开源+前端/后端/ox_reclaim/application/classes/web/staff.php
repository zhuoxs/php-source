<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}

class Web_Staff extends Web_Base
{
    /**
     * 接单员列表
     */
    public function adminList(){
        global $_W,$_GPC;

        $where = '';
        $keyword = $_GPC['keyword'];
        if(!empty($keyword)){
            $where .= "and ( nickname like '%".$keyword."%' or phone='".$keyword."' )";
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_member')."  where `uniacid`= {$_W['uniacid']} and black=0 and jiedan=1 {$where}  order by money asc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_member')."  where `uniacid`= {$_W['uniacid']}  and black=0 and jiedan=1  {$where}  ");


        $pager = pagination2($total, $pindex, $psize);
        $i=($pindex - 1) * $psize+1;

        include $this->template();
    }
    /**
     * 修改接单员
     */
    public function admin_edit()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        load()->func('tpl');
        $result=pdo_fetch("SELECT * FROM ".tablename('ox_reclaim_member')." where `uniacid`={$_W['uniacid']} and id={$_GPC['id']} and jiedan=1 limit 1");
        if($_W['ispost']){
            $data=$_GPC['data'];
            $res=pdo_update('ox_reclaim_member',$data,array('uniacid'=>$uniacid,'id'=>$_GPC['id']));

            if(!empty($res)){
                $this->success('修改成功','staff/adminList');
            }else{
                $this->success('修改失败','staff/adminList');
            }
        }
        include $this->template();
    }

    /**
     * 回收记录
     */
    public function logList(){
        global $_W,$_GPC;
        $paytype = ['线上','线下'];
        $query = "";
        if($_GPC['uid']){
            $query .= " AND orop.pay_uid ={$_GPC['uid']} ";
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $sql ="SELECT orop.*,orm.`nickname`,orm.`name` 
                FROM ".tablename('ox_reclaim_order_pay')." orop LEFT JOIN ims_ox_reclaim_member orm ON orop.`pay_uid`=orm.`uid` 
                WHERE orop.uniacid={$_W['uniacid']} {$query}
                ORDER BY orop.id DESC LIMIT ". ($pindex - 1) * $psize . ",{$psize}";
        $list = pdo_fetchall($sql);
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_order_pay')."  where `uniacid`= {$_W['uniacid']}  ");
        $pager = pagination2($total, $pindex, $psize);
        include $this->template();
    }


}

?>