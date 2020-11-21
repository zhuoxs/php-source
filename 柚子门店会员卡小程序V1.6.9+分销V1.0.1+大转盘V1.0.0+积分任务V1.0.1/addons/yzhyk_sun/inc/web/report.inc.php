<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
//    盘点表
    case "query":
        $where = [];
        $where[] = "t1.uniacid = $uniacid";
        if($_GPC['key']){
            $where[] ="t1.goods_name LIKE  concat('%', :name,'%')";
            $data[':name']=$_GPC['key'];
        }
        if($_GPC['store_id']){
            $where[] ="t1.store_id = :store_id";
            $data[':store_id']=$_GPC['store_id'];
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.store_id = ".$_SESSION['admin']['store_id'];
        }
        if($_GPC['begin_time']){
            $where[] ="t1.time >= ".strtotime($_GPC['begin_time']);
        }
        if($_GPC['end_time']){
            $where[] ="t1.time <= ".strtotime($_GPC['end_time']);
        }

        $where_sql = count($where)>0?"WHERE ".implode(' and ',$where)." ":"";

        $order_sql = "";
        if($_GPC['orderfield']){
            $order_sql = " ORDER BY ".$_GPC['orderfield'].(strtolower($_GPC['ordertype'])=="desc"?" DESC":"");
        }

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t2.name as store_name,t1.goods_name,sum(num) as num, sum(num * goods_price) as amount ";
        $sql .= "from ".tablename('yzhyk_sun_vstoregoods')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";

        $group_sql = "group by store_name,goods_name ";

        $sql .= $where_sql.$group_sql.$order_sql.$limt_sql;

        $list = pdo_fetchall($sql,$data);

        $sql = "";
        $sql .= "select count(*) ";
        $sql .= "from( ";
        $sql .= "    select DISTINCT name,goods_name ";
        $sql .= "    from ".tablename('yzhyk_sun_vstoregoods')." t1 ";
        $sql .= "    left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";
        $sql .= $where_sql;
        $sql .= ")t ";

        $total=pdo_fetchcolumn($sql,$data);

        $sql = "";
        $sql .= "select sum(num) as num,sum(num*goods_price) as amount from ".tablename('yzhyk_sun_vstoregoods')." t1 ";

        $total_column = pdo_fetch($sql.$where_sql,$data);

        echo json_encode([
            'code'=>0,
            'count'=>$total,
            'data'=>$list,
            'msg'=>'',
            'foot'=>array('store_name'=>'合计','num'=>$total_column['num'],'amount'=>$total_column['amount']),
        ]);
        exit();
    case "csv":
        $where = [];
        $where[] = "t1.uniacid = $uniacid";
        if($_GPC['key']){
            $where[] ="t1.goods_name LIKE  concat('%', :name,'%')";
            $data[':name']=$_GPC['key'];
        }
        if($_GPC['store_id']){
            $where[] ="t1.store_id = :store_id";
            $data[':store_id']=$_GPC['store_id'];
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.store_id = ".$_SESSION['admin']['store_id'];
        }
        if($_GPC['begin_time']){
            $where[] ="t1.time >= ".strtotime($_GPC['begin_time']);
        }
        if($_GPC['end_time']){
            $where[] ="t1.time <= ".strtotime($_GPC['end_time']);
        }

        $where_sql = count($where)>0?"WHERE ".implode(' and ',$where)." ":"";

        $sql = "";
        $sql .= "select t2.name as store_name,t1.goods_name,sum(num) as num, sum(num * goods_price) as amount ";
        $sql .= "from ".tablename('yzhyk_sun_vstoregoods')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id ";

        $group_sql = "group by store_name,goods_name ";

        $sql .= $where_sql.$group_sql;

        $list = pdo_fetchall($sql,$data);

        $sql = "";
        $sql .= "select sum(num) as num,sum(num*goods_price) as amount from ".tablename('yzhyk_sun_vstoregoods')." t1 ";

        $total_column = pdo_fetch($sql.$where_sql,$data);
        $list[] = array(
            'store_name'=>'合计',
            'goods_name'=>'',
            'num'=>$total_column['num']?:0,
            'amount'=>$total_column['amount']?:"0.00",
        );

        $this->toCSV('盘点表'.date('ymdhis').'.csv',['门店','品名','数量','总额'],$list);
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
