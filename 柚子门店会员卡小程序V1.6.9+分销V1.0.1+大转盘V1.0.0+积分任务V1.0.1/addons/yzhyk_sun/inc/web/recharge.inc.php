<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
    //    充值说明设置
    case "setting":
        $info =pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        include $this->template('web/recharge/setting');
        break;
    case "settingsave":
        $data['recharge_memo']=trim($_GPC['recharge_memo']);
        $data['recharge_pic']=trim($_GPC['recharge_pic']);
        $data['uniacid']=trim($_W['uniacid']);

        if($_GPC['id']==''){
            $res=pdo_insert('yzhyk_sun_system',$data,array('uniacid'=>$_W['uniacid']));
            if($res){
                message('添加成功',$this->createWebUrl('recharge',array('op'=>'setting')),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            if($res){
                message('编辑成功',$this->createWebUrl('recharge',array('op'=>'setting')),'success');
            }else{
                message('编辑失败','','error');
            }
        }
        break;
//    批量启用
    case "batchenable":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_recharge",['used'=>1],array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'启用失败',
            ));
        }
        break;
//    批量禁用
    case "batchunenable":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_recharge",['used'=>0],array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'禁用失败',
            ));
        }
        break;
//    数据查询
    case "query":
        $where = [];
        if($_GPC['key']){
            $where[] ="(money LIKE '%{$_GPC['key']}%' or give_money LIKE '%{$_GPC['key']}%')";
        }
        $this->query2($where);
        exit();

//    保存-新增、修改
    case "save":
        $data['money'] = $_GPC['money'];
        $data['give_money'] = $_GPC['give_money'];
        $data['uniacid'] = $_GPC['uniacid']?:$uniacid;

        if($_GPC['id']){
            $ret = pdo_update('yzhyk_sun_recharge', $data, array('id' => $_GPC['id']));
            $opt_name = '编辑';
        }else{
            $ret = pdo_insert('yzhyk_sun_recharge', $data);
            $opt_name = '新增';
        }

        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'新增失败',
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
