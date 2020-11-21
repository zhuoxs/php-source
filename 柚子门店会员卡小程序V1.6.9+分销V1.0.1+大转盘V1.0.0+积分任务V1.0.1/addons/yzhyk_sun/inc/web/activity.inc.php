<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    删除
    case "delete":
        $activity = new activity();
        $ret = $activity->delete_by_id($_GPC['id']);
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'删除失败'
            ));
        }
        break;
//    批量删除
    case "batchdelete":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $activity = new activity();
        foreach ($ids as $id) {
            $ret = $activity->delete_by_id($id);
        }

        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'删除失败'
            ));
        }
        break;
//    修改
    case "edit":
        $info=pdo_get('yzhyk_sun_activity',array('id'=>$_GPC['id']));
//        $info['begin_time'] = date('Y-m-d H:i:s',strtotime($info['begin_time']));
//        $info['end_time'] = date('Y-m-d H:i:s',strtotime($info['begin_time']));

        $sql = "";
        $sql .= "select t1.*,t2.name,t2.shopprice as old_price from ".tablename('yzhyk_sun_activitygoods')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.activity_id = {$_GPC['id']} ";
        $list = pdo_fetchall($sql);
        include $this->template('web/activity/edit');
        break;
    //    查看
    case "see":
        $info=pdo_get('yzhyk_sun_activity',array('id'=>$_GPC['id']));
        $sql = "";
        $sql .= "select t1.*,t2.name,t2.shopprice as old_price from ".tablename('yzhyk_sun_activitygoods')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.activity_id = {$_GPC['id']} ";

        $list = pdo_fetchall($sql);
        // foreach ($list as $key => $value) {
        //     if()
        // }
        include $this->template('web/activity/see');
        break;
//    复制新增
    case "copy":
        $info=pdo_get('yzhyk_sun_activity',array('id'=>$_GPC['id']));
        unset($info['id']);

        $sql = "";
        $sql .= "select t1.*,t2.name,t2.shopprice as old_price from ".tablename('yzhyk_sun_activitygoods')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_goods')." t2 on t2.id = t1.goods_id ";
        $sql .= "where t1.activity_id = {$_GPC['id']} ";

        $list = pdo_fetchall($sql);
        foreach ($list as &$item) {
            unset($item['id']);
            unset($item['activity_id']);
        }
        include $this->template('web/activity/edit');
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
