<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}

class Web_Datas extends Web_Base
{
    /**
     * 数据统计页
     */
    public function index(){
        global $_W,$_GPC;


        $where = '';
        $m_where = '';
        $date = $_GPC['data'];
        if(!empty($_GPC['data']['start'])){
            $where .= "and  end_time > ".strtotime($_GPC['data']['start'])." and  end_time<".strtotime($_GPC['data']['end'])." ";
            $m_where .= "and  o.end_time > ".strtotime($_GPC['data']['start'])." and  o.end_time<".strtotime($_GPC['data']['end'])." ";
        }

        $sql = "SELECT id,type_name,count(id) as all_num,sum(amount) as all_money  FROM ".tablename('ox_reclaim_order')." WHERE uniacid = {$_W['uniacid']} and status=3 {$where} group by type_name ORDER BY all_money DESC ";
        $type_list = pdo_fetchall($sql);

        $all_num = $all_money = 0;
        foreach ($type_list as $k=>$v){
            $type_list[$k]['type_name'] = trim($v['type_name'])==''? '无名称':$v['type_name'];
            $all_num += $v['all_num'];
            $all_money += $v['all_money'];
        }
//        $sql = "select m.*,count(o.id) as all_num,sum(o.amount) as all_money from ".tablename('ox_reclaim_member')." as m left join ".tablename('ox_reclaim_order')." as o on m.uid = o.admin_uid"
//            ."  where m.`uniacid`= {$_W['uniacid']} and m.black=0 and m.jiedan=1 and o.status=3  group by o.admin_uid  order by all_money desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}";
        $sql = "select m.*,count(o.id) as all_num,sum(o.amount) as all_money from ".tablename('ox_reclaim_member')." as m left join ".tablename('ox_reclaim_order')." as o on m.uid = o.admin_uid"
           ."  where m.`uniacid`= {$_W['uniacid']} and m.black=0 and m.jiedan=1 and o.status=3 {$m_where} group by o.admin_uid  order by all_money desc ";
        $list = pdo_fetchall($sql);


        include $this->template();
    }



}

?>