<?php
global $_GPC, $_W;

//    根据 op 执行不同操作
switch($_GPC['op']){
//    保存-新增、修改
    case "save":
        $data['name'] = $_GPC['name'];
        $data['code'] = $_GPC['code'];
        $data['memo'] = $_GPC['memo'];
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
