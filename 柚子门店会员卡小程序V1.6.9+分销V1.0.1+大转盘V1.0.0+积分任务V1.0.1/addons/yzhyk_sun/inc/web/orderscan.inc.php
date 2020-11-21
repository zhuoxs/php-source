<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    数据查询
    case "query":
        $where = [];
        $where[] = "t1.uniacid = $uniacid";
        if($_GPC['key']){
            $where[] ="(t2.name LIKE  concat('%', :name,'%') or t1.order_number LIKE  concat('%', :name,'%'))";
            $data[':name']=$_GPC['key'];
        }
        if($_GPC['store_id']){
            $where[] ="t1.store_id = :store_id";
            $data[':store_id']=$_GPC['store_id'];
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.store_id = ".$_SESSION['admin']['store_id'];
        }
        $where_sql = count($where)>0?"WHERE ".implode(' and ',$where):"";

        $order_sql = "";
        if($_GPC['orderfield']){
            $order_sql = " ORDER BY ".$_GPC['orderfield'].(strtolower($_GPC['ordertype'])=="desc"?" DESC":"");
        }

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
        $sql = "";

        $sql .= "select t1.*,t2.name as user_name,t3.name as store_name from ".tablename('yzhyk_sun_orderscan')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t3 on t3.id = t1.store_id ";
        $sql .= $where_sql.$order_sql.$limt_sql;

        $list = pdo_fetchall($sql,$data);

        $sql = "";
        $sql .= "select count(*) from ".tablename('yzhyk_sun_orderscan')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t3 on t3.id = t1.store_id ";
        $total=pdo_fetchcolumn($sql.$where_sql,$data);

        $sql = "";
        $sql .= "select sum(t1.amount) as amount,sum(t1.pay_amount) as pay_amount from  ".tablename('yzhyk_sun_orderscan')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t3 on t3.id = t1.store_id ";

        $total_column = pdo_fetch($sql.$where_sql,$data);

        echo json_encode([
            'code'=>0,
            'count'=>$total,
            'data'=>$list,
            'msg'=>'',
            'foot'=>array('store_name'=>'合计','amount'=>$total_column['amount'],'pay_amount'=>$total_column['pay_amount']),
        ]);
        exit();
//    查看
    case "see":
        $sql = "";
        $sql .= "select t1.*,t2.name as store_name,t3.name as user_name from ".tablename('yzhyk_sun_orderscan')." t1 left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id left join ".tablename('yzhyk_sun_user')." t3 on t3.id = t1.user_id ";
        $sql .= "where t1.id = {$_GPC['id']} ";
        $ret = pdo_fetchall($sql);
        $info = $ret[0];
        $sql = "";
        $sql .= "select t1.* from ".tablename('yzhyk_sun_orderscangoods')." t1 ";
        $sql .= "where t1.orderscan_id = {$_GPC['id']} ";

        $list = pdo_fetchall($sql);
        include $this->template('web/orderscan/see');
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
