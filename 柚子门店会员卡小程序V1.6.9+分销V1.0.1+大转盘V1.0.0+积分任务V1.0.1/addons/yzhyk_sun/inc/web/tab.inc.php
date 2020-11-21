<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
//    数据查询
    case "query":
        $where = [];
        if($_GPC['key']) {
            $where[] = "(name LIKE '%{$_GPC['key']}%' or title LIKE '%{$_GPC['key']}%')";
        }
        $this->query2($where);
        exit();
    case "save":
        $data['name'] = $_GPC['name'];
        $data['title'] = $_GPC['title'];
        $data['tab_index'] = $_GPC['tab_index'];
        $data['pic'] = $_GPC['pic'];
        $data['pic_s'] = $_GPC['pic_s'];
        $data['page'] = $_GPC['page'];
        $data['uniacid'] = $_GPC['uniacid']?:$uniacid;

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
