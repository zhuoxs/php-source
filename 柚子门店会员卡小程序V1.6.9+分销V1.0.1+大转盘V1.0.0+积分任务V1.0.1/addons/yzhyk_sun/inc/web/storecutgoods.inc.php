<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    批量推荐
    case "batchhot":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_storecutgoods",['is_hot'=>1],array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'推荐失败',
            ));
        }
        break;
//    批量取消推荐
    case "batchnohot":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_storecutgoods",['is_hot'=>0],array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'取消推荐失败',
            ));
        }
        break;
//    批量新增
    case "batchadd":
        $ids = $_GPC['ids'];
        $store_ids = $_GPC['store_ids'];
        $sql = "";
        $sql .= "insert into ".tablename('yzhyk_sun_storecutgoods')."(store_id,cutgoods_id,stock,uniacid) ";
        $sql .= "select t2.id as store_id,t1.id,t1.stock,$uniacid as uniacid ";
        $sql .= "from ".tablename('yzhyk_sun_cutgoods')." t1 ";
        $sql .= "inner join ".tablename('yzhyk_sun_store')." t2 on t2.id in ($store_ids) and t1.id in ($ids) ";
        $ret = pdo_query($sql);

        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'添加失败',
            ));
        }
        break;
//    数据查询
    case "query":
        $where = [];
        $where[] = "t1.uniacid = $uniacid";
        if($_GPC['key']){
            $where[] ="(t3.goods_name LIKE '%{$_GPC['key']}%' or t3.title LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['store_id']){
            $where[] ="t1.store_id = ".$_GPC['store_id'];
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.store_id = ".$_SESSION['admin']['store_id'];
        }
        $this->query2($where);
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
