<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['id']){
    $sql = ' SELECT * FROM ' . tablename('ymktv_sun_type') . ' t ' . 'JOIN ' . tablename('ymktv_sun_goods') . ' g ' . ' ON ' . ' g.type_id=t.id' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'] . ' AND ' . ' g.id='.$_GPC['id'];
    $info = pdo_fetch($sql);
    $info['subscribe_duration'] = explode(',',$info['subscribe_duration']);
    $spec = pdo_getall('ymktv_sun_specprice',array('uniacid'=>$_W['uniacid'],'gid'=>$_GPC['id']));
}else{
    $info = [];
}

$type = pdo_getall('ymktv_sun_type',array('uniacid'=>$_W['uniacid']));
$servies = pdo_getall('ymktv_sun_servies',array('uniacid'=>$_W['uniacid']));
// 分店数据
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));

if ($info['imgs']) {
    if (strpos($info['imgs'], ',')) {
        $imgs = explode(',', $info['imgs']);
    } else {
        $imgs = array(
            0 => $info['imgs']
        );
    }
}
if ($info['lb_imgs']) {
    if (strpos($info['lb_imgs'], ',')) {
        $lb_imgs = explode(',', $info['lb_imgs']);
    } else {
        $lb_imgs = array(
            0 => $info['lb_imgs']
        );
    }
}
if($info['build_id']){
    $build_id = explode(',',$info['build_id']);
}
if($info['sb_sid']){
    $sid = explode(',',$info['sb_sid']);
    $sids = [];
    foreach ($build_id as $k=>$v){
        foreach ($sid as $kk=>$vv){
            if($k==$kk){
                $sids[$v]=$vv;
            }
        }
    }
}
if (checksubmit('submit')) {
//    p($_GPC);die;
    if ($_GPC['imgs']) {
        $data['imgs'] = implode(",", $_GPC['imgs']);
    } else {
        $data['imgs'] = '';
    }
    $data['build_id'] = implode(',',$_GPC['build_id']);
    $data['sb_sid'] = implode(',',$_GPC['sb_sid']);
    $room_num = pdo_get('ymktv_sun_goods',array('uniacid'=>$_W['uniacid'],'room_num'=>$_GPC['room_num']));
    $data['uniacid'] = $_W['uniacid'];
    $data['room_num'] = $_GPC['room_num'];     //包间号
    $data['goods_name'] = $_GPC['goods_name']; //包间宣传名
    $data['goods_cost'] = $_GPC['goods_cost'];
    $data['goods_price'] = $_GPC['goods_price'];
    $data['goods_valb'] = $_GPC['goods_valb'];
    $data['goods_valc'] = $_GPC['goods_valc'];
    $data['type_id'] = $_GPC['type_id'];          //包间大小
    $data['goods_details'] = htmlspecialchars_decode($_GPC['goods_details']);  //包间详情
    $data['time'] = date("Y-m-d H:i:s");
//    $data['subscribe_time'] = $_GPC['subscribe_time'];
    $data['subscribe_duration'] = $_GPC['subscribe_duration'];
    $data['s_sid'] = $_GPC['s_sid'];
    $data['date_dc'] = $_GPC['date_dc'];
    $data['sort'] = $_GPC['sort'];
    if($_GPC['subscribe_duration']){
        $data['subscribe_duration'] = implode(',',$_GPC['subscribe_duration']);
    }else{
        message('请选择可预约时间！');
    }
    //  $data['preferential'] = $_GPC['preferential'];
    //商品缩略图小图
    if ($_GPC['thumbnail']) {
        $data['thumbnail'] = $_GPC['thumbnail'];
    } else {
        $data['thumbnail'] = '';
    }
    //商品缩略图大图
    if ($_GPC['big_thumbnail']) {
        $data['big_thumbnail'] = $_GPC['big_thumbnail'];
    } else {
        $data['big_thumbnail'] = '';
    }
    if ($_GPC['id'] == '' || $_GPC['id'] == null) {
        if($room_num){
            message('该房间号已存在！');
        }
        $res = pdo_insert('ymktv_sun_goods', $data);
        $gid = pdo_getcolumn('ymktv_sun_goods',array('time'=>date("Y-m-d H:i:s")),'id');
        if($res){
            $newData = [];
            foreach ($_GPC['price'] as $k=>$v){
                foreach ($_GPC['subscribe_duration'] as $kk=>$vv){
                    if($k==$kk){
                        $newData = [
                            'gid'=>$gid,
                            'price'=>$v,
                            'spec'=>$vv,
                            'uniacid'=>$_W['uniacid']
                        ];
                        if($newData['price']){
                            pdo_insert('ymktv_sun_specprice',$newData);
                        }else{
                            message('请输入对应时段价格！');
                        }

                    }
                }
            }
        }
    } else {
        $res = pdo_update('ymktv_sun_goods', $data, array('id' => $_GPC['id']));
        if($res){
            pdo_delete('ymktv_sun_specprice',array('gid'=>$_GPC['id']));
            $newData = [];
            foreach ($_GPC['price'] as $k=>$v){
                foreach ($_GPC['subscribe_duration'] as $kk=>$vv){
                    if($k==$kk){
                        $newData = [
                            'gid'=>$_GPC['id'],
                            'price'=>$v,
                            'spec'=>$vv,
                            'uniacid'=>$_W['uniacid']
                        ];
                        if($newData['price']){
                            pdo_insert('ymktv_sun_specprice',$newData);
                        }else{
                            message('请输入对应时段价格！');
                        }
                    }
                }

            }
        }
    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('goods', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/goodsinfo');