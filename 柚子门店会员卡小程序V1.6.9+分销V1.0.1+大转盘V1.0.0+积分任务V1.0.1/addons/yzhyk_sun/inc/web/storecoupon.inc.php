<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
    case "batchadd":
        $ids = explode(',', $_GPC['ids']);
        $store_ids = explode(',', $_GPC['store_ids']);
        $storecoupon = new storecoupon();
        foreach ($ids as $id) {
            foreach ($store_ids as $store_id) {
                $data = array();
                $data['coupon_id'] = $id;
                $data['store_id'] = $store_id;
                $storecoupon->insert($data);
            }
        }

        echo json_encode([
            "code"=>0,
            "msg"=>"添加成功！",
        ]);
        break;
//    数据查询
    case "query":
        $where = [];
        $where[] = "t1.uniacid = $uniacid";
        if($_GPC['key']){
            $where[] ="(t2.name LIKE '%{$_GPC['key']}%' or t2.code LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['store_id']){
            $where[] ="t1.store_id = ".$_GPC['store_id'];
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.store_id = ".$_SESSION['admin']['store_id'];
        }
        $this->query2($where);
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
