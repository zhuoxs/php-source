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
            $where[] ="t1.name LIKE '%{$_GPC['key']}%'";
        }
        if($_GPC['role_id']){
            $where[] ="t1.role_id = {$_GPC['role_id']}";
        }
        $this->query2($where);
        exit();
//    保存-新增、修改
    case "save":
        $data['name'] = $_GPC['name'];
        $data['memo'] = $_GPC['memo'];
        $data['role_id'] = $_GPC['role_id'];

        $this->save($data);
        break;

    case "select":
        $admin = $_SESSION['admin'];
        if($admin['code']=="admin"){
            $sql = "select id,name as text,CONCAT(id,name) as keywords from ".tablename('yzhyk_sun_role')." where uniacid = $uniacid";
        }else{
            $sql = "";
            $sql .= "select t2.id,t2.name as text,CONCAT(t2.id,t2.name) as keywords ";
            $sql .= "from ".tablename('yzhyk_sun_userrole')." t1 ";
            $sql .= "left join ".tablename('yzhyk_sun_role')." t2 on t2.role_id = t1.role_id ";
            $sql .= "where t1.user_id = {$admin['id']} and uniacid = $uniacid ";
            if(isset($admin['store_id']) && $admin['store_id'] != null){
                $sql .= "and t1.store_id = ".$admin['store_id'];
            }
        }
        // var_dump($sql);
        $list = pdo_fetchall($sql);
        echo json_encode($list);
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
