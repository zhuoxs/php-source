<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    个性化定义
    case "query":
        $where = [];
        if($_GPC['key']){
            $where[] ="(t1.title LIKE '%{$_GPC['key']}%' or t2.name LIKE '%{$_GPC['key']}%' or t2.code LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['class_id']){
            $where[] ="(t2.root_id = {$_GPC['class_id']} or t2.class_id = {$_GPC['class_id']})";
        }
        $this->query2($where);
        exit();
    case "save":
        $data['goods_id'] = $_GPC['goods_id'];
        $data['goods_name'] = $_GPC['goods_name'];
        $data['title'] = $_GPC['title'];
        $data['price'] = $_GPC['price'];
        $data['stock'] = $_GPC['stock'];
        $data['num'] = $_GPC['num'];
        $data['begin_time'] = $_GPC['begin_time'];
        $data['end_time'] = $_GPC['end_time'];
        $data['useful_hour'] = $_GPC['useful_hour'];
        $data['pics'] = json_encode($_GPC['pics']);
        $data['pic'] = $_GPC['pic'];
        $data['content'] = $_GPC['content'];

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
