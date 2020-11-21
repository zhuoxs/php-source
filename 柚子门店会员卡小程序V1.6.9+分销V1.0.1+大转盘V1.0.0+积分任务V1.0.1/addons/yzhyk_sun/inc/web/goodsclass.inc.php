<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
//    获取根分类
    case "rootselect":
        $sql = "select id,name as text,CONCAT(code,name) as keywords from ".tablename('yzhyk_sun_goodsclass')." where isdel != 1 and level != 1 and uniacid = $uniacid";
        $list = pdo_fetchall($sql,$data);
        echo json_encode($list);
        break;
//    获取分类
    case "classselect":
        $root_id = $_GPC['rootid'];
        if($root_id){
            $sql = "select id,name as text,CONCAT(code,name) as keywords from ".tablename('yzhyk_sun_goodsclass')." where isdel != 1 and level = 1 and root_id = $root_id and uniacid = $uniacid";
        }else{
            $sql = "select id,name as text,CONCAT(code,name) as keywords from ".tablename('yzhyk_sun_goodsclass')." where isdel != 1 and uniacid = $uniacid";
        }

        $list = pdo_fetchall($sql,$data);
        // var_dump($list);
        echo json_encode($list);
        break;
    //    获取是否预约

//    数据查询
    case "query":
        $where = [];
        $where[] = 't1.isdel != 1';
        if($_GPC['key']){
            $where[] ="(t1.name LIKE '%{$_GPC['key']}%' or t1.code LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['root_id']){
            $where[] ="t1.root_id = {$_GPC['root_id']}";
        }
        $this->query2($where);
        break;
//    保存-新增、修改
    case "save":
        $data['name'] = $_GPC['name'];
        $data['code'] = $_GPC['code'];
        $data['root_id'] = $_GPC['root_id'];
        $data['level'] = $_GPC['root_id']?1:0;
        $data['index'] = $_GPC['index']?:0;

        $this->save($data);
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
