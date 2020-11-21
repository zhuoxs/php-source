<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
    case"display":
        //在售商品数量
        $sql = "";
        $sql = "select count(DISTINCT(goods_id)) as num from ".tablename('yzhyk_sun_storegoods')." where stock > 0 and uniacid = $uniacid ";
        if($_SESSION['admin']['store_id']){
            $sql .= " and store_id = ".$_SESSION['admin']['store_id'];
        }
        $sale_goods_count = pdo_fetchcolumn($sql);

        //推荐商品数量
        $sql = "";
        $sql = "select count(DISTINCT(goods_id)) as num from ".tablename('yzhyk_sun_storegoods')." where stock > 0 and ishot = 1 and uniacid = $uniacid ";
        if($_SESSION['admin']['store_id']){
            $sql .= " and store_id = ".$_SESSION['admin']['store_id'];
        }
        $hot_goods_count = pdo_fetchcolumn($sql);

        //门店数量
        $sql = "";
        $sql = "select count(*) as num from ".tablename('yzhyk_sun_store')." where uniacid = $uniacid ";
        if($_SESSION['admin']['store_id']){
            $sql .= " and id = ".$_SESSION['admin']['store_id'];
        }
        $store_count = pdo_fetchcolumn($sql);

        //本日销售额
        $sql = "";
        $sql = "select count(*) as num from ".tablename('yzhyk_sun_user')." where uniacid = $uniacid ";
        $user_count = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .="select sum(amount) as amount ";
        $sql .="from ( ";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_order')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') ";
        $sql .="    and state in (20,30,40) ";
        $sql .="    and uniacid = $uniacid ";
        $sql .="    union all";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_orderscan')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') ";
        $sql .="    and uniacid = $uniacid ";
        $sql .="    union all";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_orderonline')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') ";
        $sql .="    and uniacid = $uniacid ";
        $sql .=") as t ";
        if($_SESSION['admin']['store_id']){
            $sql .= " where t.store_id = ".$_SESSION['admin']['store_id'];
        }

        $day_sum = pdo_fetchcolumn($sql);
        $day_sum = $day_sum?:"0.00";

        //本月销售额
        $sql = "";
        $sql = "select count(*) as num from ".tablename('yzhyk_sun_user')." where uniacid = $uniacid ";
        $user_count = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .="select sum(amount) as amount ";
        $sql .="from ( ";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_order')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m') ";
        $sql .="    and state in (20,30,40) ";
        $sql .="    and uniacid = $uniacid ";
        $sql .="    union all";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_orderscan')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m') ";
        $sql .="    and uniacid = $uniacid ";
        $sql .="    union all";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_orderonline')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m') ";
        $sql .="    and uniacid = $uniacid ";
        $sql .=") as t ";
        if($_SESSION['admin']['store_id']){
            $sql .= " where t.store_id = ".$_SESSION['admin']['store_id'];
        }

        $month_sum = pdo_fetchcolumn($sql);
        $month_sum = $month_sum?:"0.00";

        //本年销售额
        $sql = "";
        $sql = "select count(*) as num from ".tablename('yzhyk_sun_user')." where uniacid = $uniacid ";
        $user_count = pdo_fetchcolumn($sql);

        $sql = "";
        $sql .="select sum(amount) as amount ";
        $sql .="from ( ";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_order')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y') = DATE_FORMAT(NOW(),'%Y') ";
        $sql .="    and state in (20,30,40) ";
        $sql .="    and uniacid = $uniacid ";
        $sql .="    union all";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_orderscan')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y') = DATE_FORMAT(NOW(),'%Y') ";
        $sql .="    and uniacid = $uniacid ";
        $sql .="    union all";
        $sql .="    select store_id,amount ";
        $sql .="    from ".tablename('yzhyk_sun_orderonline')." ";
        $sql .="    where FROM_UNIXTIME(time,'%Y') = DATE_FORMAT(NOW(),'%Y') ";
        $sql .="    and uniacid = $uniacid ";
        $sql .=") as t ";
        if($_SESSION['admin']['store_id']){
            $sql .= " where t.store_id = ".$_SESSION['admin']['store_id'];
        }
        // var_dump($sql);
        $year_sum = pdo_fetchcolumn($sql);
        $year_sum = $year_sum?:"0.00";

        include $this->template('web/index/display');
        break;
//    调用公共的方法
    default:
        $fun_name = $_GPC['op'];
        if(method_exists($this,$fun_name)){
            $this->{$fun_name}();
        }else{
            $this->display();
        }
}
