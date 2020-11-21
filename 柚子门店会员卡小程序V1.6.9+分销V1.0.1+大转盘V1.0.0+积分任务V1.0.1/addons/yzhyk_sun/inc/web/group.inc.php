<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
//    数据查询
    case "query":
        $where = [];
        $where[] = "t1.uniacid = $uniacid";
        if($_GPC['key']){
            $where[] ="t2.name LIKE '%{$_GPC['key']}%'";
        }
        if($_GPC['store_id']){
            $where[] ="t2.store_id = ".$_GPC['store_id'];
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t2.store_id = ".$_SESSION['admin']['store_id'];
        }
        $this->query2($where);
        break;
    //    批量发货
    case "batchfinish":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);

        $group = new group();
        $groupgoods = new groupgoods();
        foreach ($ids as $id) {
            $group_data = $group->get_data_by_id($id);
            $groupgoods_data = $groupgoods->get_data_by_id($group_data['groupgoods_id']);
            $group->join($id,$groupgoods_data['num']-$group_data['num']);
        }

        echo json_encode(array(
            'code'=>0,
        ));
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
