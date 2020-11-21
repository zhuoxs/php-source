<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    保存-新增、修改
    case "save":
        $data['name'] = $_GPC['name'];
        $data['begin_time'] = $_GPC['begin_time'];
        $data['end_time'] = $_GPC['end_time'];
        $data['use_amount'] = $_GPC['use_amount']?$_GPC['use_amount']:0;
        $data['amount'] = $_GPC['amount'];
        $data['days'] = $_GPC['days'];
        $data['num'] = $_GPC['num'];
        $data['isvip'] = $_GPC['isvip'];

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
