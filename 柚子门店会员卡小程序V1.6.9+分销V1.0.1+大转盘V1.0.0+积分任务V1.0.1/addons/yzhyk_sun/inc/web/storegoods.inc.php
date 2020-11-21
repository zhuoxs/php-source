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
        $ret=pdo_update("yzhyk_sun_storegoods",['ishot'=>1],array('id'=>$ids));
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
        $ret=pdo_update("yzhyk_sun_storegoods",['ishot'=>0],array('id'=>$ids));
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
        $ids = explode(',',$ids);
        $store_ids = $_GPC['store_ids'];
        $store_ids = explode(',',$store_ids);

        $storegoods_model = new storegoods();

        foreach ($ids as $id) {
            foreach ($store_ids as $store_id) {
                $data = array();
                $data['store_id'] = $store_id;
                $data['goods_id'] = $id;
                try{
                    $storegoods_model->insert($data);
                }catch (ZhyException $exception){
                    
                }
            }
        }

//        $sql = "";
//        $sql .= "insert into ".tablename('yzhyk_sun_storegoods')."(store_id,goods_id,uniacid,shop_price) ";
//        $sql .= "select t2.id as store_id,t1.id,$uniacid as uniacid,t1.shopprice ";
//        $sql .= "from ".tablename('yzhyk_sun_goods')." t1 ";
//        $sql .= "inner join ".tablename('yzhyk_sun_store')." t2 on t2.id in ($store_ids) and t1.id in ($ids) ";
//        $ret = pdo_query($sql);
//        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
//        }else{
//            echo json_encode(array(
//                'code'=>1,
//                'msg'=>'修改失败',
//            ));
//        }
        break;
//    批量修改库存
    case "batchstock":
        $ids = $_GPC['ids'];
        $stock = $_GPC['stock'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_storegoods",['stock'=>$stock],array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'修改失败',
            ));
        }
        break;
//    批量修改销售价
    case "batchprice":
        $ids = $_GPC['ids'];
        $price = $_GPC['price'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_storegoods",['shop_price'=>$price],array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'修改失败',
            ));
        }
        break;
//    数据查询
    case "query":
        $where = [];
        if($_GPC['key']){
            $where[] ="(t2.name LIKE '%{$_GPC['key']}%' or t2.code LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['class_id']){
            $where[] ="(t2.root_id = {$_GPC['class_id']} or t2.class_id = {$_GPC['class_id']})";
        }
        if($_GPC['store_id']){
            $where[] ="t1.store_id = {$_GPC['store_id']}";
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.store_id = ".$_SESSION['admin']['store_id'];
        }
        $this->query2($where);
        break;
//    保存-新增、修改
    case "save":
        $data['stock'] = $_GPC['stock'];
        $data['shop_price'] = $_GPC['shop_price'];
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
