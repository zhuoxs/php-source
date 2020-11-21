<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
        // var_dump($_GPC['isapp']);
        // var_dump($_GPC['op']);
// $isapp=$_GPC['isapp'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    个性化定义
    case "query":
        $where = [];
        $where[] = 't1.isdel != 1';
        if($_GPC['key']){
            $where[] ="(t1.name LIKE '%{$_GPC['key']}%' or t1.code LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['class_id']){
            $where[] ="(t1.root_id = {$_GPC['class_id']} or t1.class_id = {$_GPC['class_id']})";
        }
        if($_GPC['appointment_id']){
            $where[] ="(t1.isappointment = {$_GPC['appointment_id']} )";
        }
        $this->query2($where);
        break;
    // case "choose":
    //     $where = [];
    //     $where[] = 't1.isdel != 1';
    //     // $where[] = '( t1.isappointment = 0)';
    //     if($_GPC['key']){
    //         $where[] ="(t1.name LIKE '%{$_GPC['key']}%' or t1.code LIKE '%{$_GPC['key']}%')";
    //     }
    //     if($_GPC['class_id']){
    //         $where[] ="(t1.root_id = {$_GPC['class_id']} or t1.class_id = {$_GPC['class_id']})";
    //     }
    //     $this->query2($where);
    //     break;
    case "choose1":
        // var_dump($_GPC['op']);

        $where = [];
        $where[] = 't1.isdel != 1';
        if($_GPC['isapp']==0){
            $where[] = '( t1.isappointment = 0)';
        }
        if($_GPC['key']){
            $where[] ="(t1.name LIKE '%{$_GPC['key']}%' or t1.code LIKE '%{$_GPC['key']}%')";
        }
        if($_GPC['class_id']){
            $where[] ="(t1.root_id = {$_GPC['class_id']} or t1.class_id = {$_GPC['class_id']})";
        }
        // var_dump($where);die;
        $this->query2($where);
        break;
    case "save":

        $data['name'] = $_GPC['name'];
        $data['isappointment'] = $_GPC['isappointment'];
        $data['code'] = $_GPC['code'];
        $data['barcode'] = $_GPC['barcode'];
        $data['std'] = $_GPC['std'];
        $data['root_id'] = $_GPC['root_id'];
        $data['class_id'] = $_GPC['class_id'];
        $data['marketprice'] = $_GPC['marketprice']?:$_GPC['shopprice'];
        $data['shopprice'] = $_GPC['shopprice'];
        $data['pics'] = json_encode($_GPC['pics']);
        $data['pic'] = $_GPC['pic'];
        $data['content'] = $_GPC['content'];
        $data['index'] = $_GPC['index'];
        //判断如果为预约商品，则清空其所有营销活动
        if($_GPC['isappointment']==1&&$_GPC['id']){
            //清空抢购
            $activitygoods=pdo_delete('yzhyk_sun_activitygoods',array('uniacid'=>$_W['uniacid'],'goods_id'=>$_GPC['id']));
            $storeactivitygoods=pdo_delete('yzhyk_sun_storeactivitygoods',array('uniacid'=>$_W['uniacid'],'goods_id'=>$_GPC['id']));
            //清空砍价
            $cutgoods_id=pdo_get('yzhyk_sun_cutgoods',array('uniacid'=>$_W['uniacid'],'goods_id'=>$_GPC['id']),array('id'));
            if($cutgoods_id){
                $cutgoods=pdo_delete('yzhyk_sun_cutgoods',array('uniacid'=>$_W['uniacid'],'goods_id'=>$_GPC['id']));
                $storecutgoods=pdo_delete('yzhyk_sun_storecutgoods',array('uniacid'=>$_W['uniacid'],'cutgoods_id'=>$cutgoods_id['id']));
            }
            //清空组团
            $groupgoods_id=pdo_get('yzhyk_sun_groupgoods',array('uniacid'=>$_W['uniacid'],'goods_id'=>$_GPC['id']),array('id'));
            if($groupgoods_id){
                $groupgoods=pdo_delete('yzhyk_sun_groupgoods',array('uniacid'=>$_W['uniacid'],'goods_id'=>$_GPC['id']));
                $storegroupgoods=pdo_delete('yzhyk_sun_storegroupgoods',array('uniacid'=>$_W['uniacid'],'groupgoods_id'=>$groupgoods_id['id']));
            }
            
        }

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
