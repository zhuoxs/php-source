<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
//    数据查询
    case "query":
        $where = [];
        if($_GPC['key']){
            $where[] ="(t2.name LIKE '%{$_GPC['key']}%' or t3.name LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['role_id']){
            $where[] ="t3.role_id = {$_GPC['role_id']}";
        }
        if($_GPC['store_id']){
            $where[] ="t4.id = {$_GPC['store_id']}";
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.id = ".$_SESSION['admin']['store_id'];
        }
        if($_GPC['user_id']){
            $where[] ="t3.user_id = {$_GPC['user_id']}";
        }
        
        $this->query2($where);
        break;
//    保存-新增、修改
    case "save":
        $data['user_id'] = $_GPC['user_id'];
        $data['role_id'] = $_GPC['role_id'];
        $data['store_id'] = $_GPC['store_id'];
        $data['uniacid'] = $_GPC['uniacid']?:$uniacid;

        if($_GPC['id']){
            $ret = pdo_update('yzhyk_sun_userrole', $data, array('id' => $_GPC['id']));
            $opt_name = '编辑';
        }else{
            $ret = pdo_insert('yzhyk_sun_userrole', $data);
            $opt_name = '新增';
        }

        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'保存失败',
            ));
        }
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
