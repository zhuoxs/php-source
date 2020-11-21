<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
    //    修改
    case "edit":
        $info=pdo_get('yzhyk_sun_storeactivity',array('id'=>$_GPC['id']));
//        $info['begin_time'] = date('Y-m-d H:i:s',strtotime($info['begin_time']));
//        $info['end_time'] = date('Y-m-d H:i:s',strtotime($info['begin_time']));

        $sql = "";
        $sql .= "select t1.*,t2.name,t2.shopprice as old_price from ".tablename('yzhyk_sun_storeactivitygoods')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.storeactivity_id = {$_GPC['id']} ";
        $list = pdo_fetchall($sql);
        include $this->template('web/storeactivity/edit');
        break;
    case "delete":
        $storeactivity = pdo_get("yzhyk_sun_storeactivity",array('id'=>$_GPC['id']));
        pdo_query("delete from ".tablename('yzhyk_sun_storeactivitygoods')." where activity_id = {$storeactivity['activity_id']} and store_id = {$storeactivity['store_id']}");
        $ret=pdo_delete("yzhyk_sun_storeactivity",array('id'=>$_GPC['id']));

        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'删除失败',
            ));
        }
        break;
//    批量新增
    case "batchadd":
        $ids = explode(',',$_GPC['ids']);
        $store_ids = explode(',',$_GPC['store_ids']);
        $storeactivity = new storeactivity();
        foreach ($ids as $id) {
            foreach ($store_ids as $store_id) {
                $storeactivity->insert_activity($store_id,$id);
            }
        }
        echo json_encode(array(
            'code'=>0,
        ));
        break;
//    数据查询
    case "query":
        $where = [];
        if($_GPC['key']){
            $where[] ="(t3.name LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['store_id']){
            $where[] ="t1.store_id = ".$_GPC['store_id'];
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.store_id = ".$_SESSION['admin']['store_id'];
        }
        $this->query2($where);
        break;
    //    保存-新增、修改
    case "save":
        $data['name'] = $_GPC['name'];
        $data['begin_time'] = $_GPC['begin_time'];
        $data['end_time'] = $_GPC['end_time'];

        $goodses = json_decode(htmlspecialchars_decode($_GPC['data']));
        $data['goodses'] = $goodses;
        $ret = $this->save($data);
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'保存失败'
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
