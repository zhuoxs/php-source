<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    保存-新增、修改
    case "save":
        $data['name'] = $_GPC['name'];
        $data['discount'] = $_GPC['discount'];
        $data['amount'] = $_GPC['amount'];
        $data['price'] = $_GPC['price'];
        $data['note'] = $_GPC['note'];

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
