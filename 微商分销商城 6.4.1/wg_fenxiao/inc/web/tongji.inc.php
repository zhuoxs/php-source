<?php
/*
 * 订单统计
 * [增删改查]
*/
defined('IN_IA') or exit('Access Denied');
if (empty($starttime) || empty($endtime)) {
    $starttime = strtotime('-1 month');
    $endtime = TIMESTAMP;
}
//商品
$sql = 'SELECT id,goodsname FROM ' . tablename('wg_fenxiao_goods') . ' WHERE `weid` = :weid AND status=:status ORDER BY `id` ASC';
$goods = pdo_fetchall($sql, array(
    ':weid' => $_W['uniacid'],
    ':status' => 1
));
if (checksubmit('tongji')) {
    $timeleixing = intval($_GPC['timeleixing']);
    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']) + 86399;
        if ($timeleixing == 1) {
            $condition = " AND o.createtime >= :starttime AND o.createtime <= :endtime ";
        } elseif ($timeleixing == 2) {
            $condition = " AND o.zhifutime >= :starttime AND o.zhifutime <= :endtime ";
        }
        $paras[':starttime'] = $starttime;
        $paras[':endtime'] = $endtime;
    }
    $good_tongji = intval($_GPC['goods']);
    $orderstatus = intval($_GPC['orderstatus']);
    if($good_tongji >0){
        $condition .= "AND o.goodsid=".$good_tongji.' ';
    }

    $sql = "select count(*) as shu,sum(o.`orderprice`) as qian FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status >=:orderstatus ".$condition."AND weid=:weid";
    $paras[':weid'] = $_W['uniacid'];
    $paras[':orderstatus']= $orderstatus;

    $data = pdo_fetch($sql,$paras);
    //查询应发红包
    if($orderstatus == 3){
        $sqlzong = "select sum(o.`commision1`) as c1,sum(o.`commision2`) as c2,sum(o.`commision3`) as c3 FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status=3".$condition."AND weid=:weid";
        unset($paras[':orderstatus']);
        $hb_yingfa = pdo_fetch($sqlzong,$paras);
        $hb_yingfa = $hb_yingfa['c1']+$hb_yingfa['c2']+$hb_yingfa['c3'];//应发红包
        if(!empty($this->module['config']['nohongbao'])){
            $config_no_hongbao = str_replace('，', ',', $this->module['config']['nohongbao']);
            $bufahongbao_id = trim($config_no_hongbao,',');
        }else{
            $bufahongbao_id = 0;
        }
        $bufahongbao_id = '('. $bufahongbao_id .')';//不发红包
        $bufa1_sql = "select sum(o.`commision1`) as c1 FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status=3".$condition."AND o.weid=:weid AND o.parent1 in ".$bufahongbao_id;
        $bufa1 = pdo_fetch($bufa1_sql,$paras);
        $bufa2_sql = "select sum(o.`commision2`) as c2 FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status=3".$condition."AND o.weid=:weid AND o.parent2 in ".$bufahongbao_id;
        $bufa2 = pdo_fetch($bufa2_sql,$paras);
        $bufa3_sql = "select sum(o.`commision3`) as c3 FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status=3".$condition."AND o.weid=:weid AND o.parent3 in ".$bufahongbao_id;
        $bufa3 = pdo_fetch($bufa3_sql,$paras);
        $hb_quchu = $bufa1['c1']+$bufa2['c2']+$bufa3['c3'];
        $hb_shiji = $hb_yingfa -$hb_quchu;

        //红包已发
        $hongbao_yifa1_sql = "select sum(o.`commision1`) as c1 FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status=3".$condition."AND o.weid=:weid AND o.hongbao1>0";
        $hongbao_yifa1 = pdo_fetch($hongbao_yifa1_sql,$paras);
        $hongbao_yifa2_sql = "select sum(o.`commision2`) as c2 FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status=3".$condition."AND o.weid=:weid AND o.hongbao2>0";
        $hongbao_yifa2 = pdo_fetch($hongbao_yifa2_sql,$paras);
        $hongbao_yifa3_sql = "select sum(o.`commision3`) as c3 FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status=3".$condition."AND o.weid=:weid AND o.hongbao3>0";
        $hongbao_yifa3 = pdo_fetch($hongbao_yifa3_sql,$paras);
        $hongbao_yifa = $hongbao_yifa1['c1'] + $hongbao_yifa2['c2'] + $hongbao_yifa3['c3'];

        //失败红包里面
        $hongbao_shibai_sql = "select sum(s.`amount`) as zong FROM ".tablename('wg_fenxiao_hongbao_shibai')." AS s WHERE s.orderid in (select id FROM ".tablename('wg_fenxiao_order')." AS o WHERE o.status=3".$condition."AND o.weid=:weid AND (o.hongbao1=0 or o.hongbao2=0 or o.hongbao3=0)) AND s.weid=:weid";
        $hongbao_shibai = pdo_fetch($hongbao_shibai_sql,$paras);
        $hongbao_shibai = $hongbao_shibai['zong']+0;

    }
}
include $this->template('tongji');
