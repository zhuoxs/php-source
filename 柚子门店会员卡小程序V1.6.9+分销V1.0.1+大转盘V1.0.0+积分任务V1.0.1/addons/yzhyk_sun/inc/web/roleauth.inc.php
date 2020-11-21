<?php
global $_GPC, $_W;

//    根据 op 执行不同操作
switch($_GPC['op']){
//    数据查询
    case "display":
        $role_id = $_GPC['role_id'];

        $sql = "";
        $sql .="select distinct t1.name,t1.id,t1.menu_id,t2.button_id,t3.name as button_name,t4.id as menu_auth,t5.id as button_auth from ".tablename('yzhyk_sun_menu')." t1 ";
        $sql .="left join ".tablename('yzhyk_sun_menubutton')." t2 on t2.menu_id = t1.id ";
        $sql .="left join ".tablename('yzhyk_sun_button')." t3 on t3.id = t2.button_id ";
        $sql .="left join ".tablename('yzhyk_sun_roleauth')." t4 on t4.menu_id = t1.id and t4.role_id = $role_id and t4.button_id is null ";
        $sql .="left join ".tablename('yzhyk_sun_roleauth')." t5 on t5.menu_id = t1.id and t5.button_id = t2.button_id and t5.role_id = $role_id ";
        $sql .="order by t1.menu_id,t1.menu_index ";

        $list = pdo_fetchall($sql);
//echo $sql;exit();
        $new_list = [];
        foreach ($list as $item) {
            if(!$item['menu_id']){
                $new_list[$item['id']] = [
                    'name'=>$item['name'],
                    'id'=>$item['id'],
                    'menus'=>[],
                ];
            }else{
                if(!$new_list[$item['menu_id']]['menus'][$item['id']]){
                    $new_list[$item['menu_id']]['menus'][$item['id']] = [
                        'id'=>$item['id'],
                        'name'=>$item['name'],
                        'checked'=>!!$item['menu_auth'],
                        'btns'=>[
                            ['id'=>$item['button_id'],'name'=>$item['button_name'],'checked'=>!!$item['button_auth']],
                        ]
                    ];
                }else{
                    $new_list[$item['menu_id']]['menus'][$item['id']]['btns'][] =['id'=>$item['button_id'],'name'=>$item['button_name'],'checked'=>!!$item['button_auth']];
                }
            }
        }

        $list= $new_list;
        include $this->template('web/roleauth/display');
        break;
//    保存-新增、修改
    case "save":
        $role_id = $_GPC['role_id'];
        $auth = $_GPC['menu'];
        pdo_delete("yzhyk_sun_roleauth",array('role_id'=>$role_id));
        foreach ($auth as $menu_id =>$menu) {
            $data['role_id'] = $role_id;
            $data['menu_id'] = $menu_id;
            $res = pdo_insert('yzhyk_sun_roleauth', $data);
            if($menu !== "1"){
                foreach ($menu['btn'] as $btn_id=>$btn) {
                    $data['button_id'] = $btn_id;
                    $res = pdo_insert('yzhyk_sun_roleauth', $data);
                }
            }
        }

        if($res){
            echo json_encode(array(
                'code'=>0
            ));
        }else{
            throw new ZhyException('编辑失败');
        }
        break;

    case "select":
        $sql = "select id,name as text,CONCAT(id,name) as keywords from ".tablename('yzhyk_sun_role')."";

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
