<?php
global $_GPC, $_W;

//    根据 op 执行不同操作
switch($_GPC['op']){

//    批量新增
    case "batchadd":
        $ids = $_GPC['ids'];
        $menu_id = $_GPC['menu_id'];
        $sql = "";
        $sql .= "insert into ".tablename('yzhyk_sun_menubutton')."(menu_id,button_id) ";
        $sql .= "select $menu_id as menu_id,id ";
        $sql .= "from ".tablename('yzhyk_sun_button')." ";
        $sql .= "where id in ($ids) ";
        $ret = pdo_run($sql);
        echo json_encode([
            "code"=>0,
            "msg"=>"添加成功！",
        ]);
        break;

//    数据查询
    case "query":
        $where = [];
        if($_GPC['key']){
            $where[] ="(t2.name LIKE '%{$_GPC['key']}%' or t3.name LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['menu_id']){
            $where[] ="t2.id = ".$_GPC['menu_id'];
        }
        if($_GPC['button_id']){
            $where[] ="t3.button_id = ".$_GPC['button_id'];
        }
        $this->query2($where);
        exit();
//    调用公共的方法
    default:
        $fun_name = $_GPC['op'];
        if(method_exists($this,$fun_name)){
            $this->{$fun_name}();
        }else{
            $this->display();
        }
}
