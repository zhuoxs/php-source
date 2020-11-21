<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];

//根据 op 执行不同操作
switch($_GPC['op']){
    case "save":
        $data['name'] = $_GPC['name'];
        $data['appmenu_index'] = $_GPC['appmenu_index'];
        $data['pic'] = $_GPC['pic'];
        $data['page'] = $_GPC['page'];

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
