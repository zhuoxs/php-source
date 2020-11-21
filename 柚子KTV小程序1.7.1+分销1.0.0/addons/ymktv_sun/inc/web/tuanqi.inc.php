<?php
global $_GPC, $_W;

//issubmit=1时为提交 空为初始化
if($_GPC['isgoods'] == 1 && empty($_GPC['istuanqi'])) {
    if ($_GPC['imgs']) {
        $data['imgs'] = trim($_GPC['imgs'],',');
    } else {
        $data['imgs'] = '';
    }
    $data['min_thumbnail'] = $_GPC['min_thumbnail'];
    $data['build_id'] = rtrim($_GPC['build_id'],',');
    $data['uniacid'] = $_GPC['__uniacid'];
    $data['goods_name'] = $_GPC['goods_name'];
    $data['goods_cost'] = $_GPC['goods_cost'];
    $data['goods_price'] = $_GPC['goods_price'];
    $data['gocar'] = $_GPC['gocar'];
    $data['pre_type'] = $_GPC['pre_type'] = '跟团游'; //预定类型默认为跟团游
    $data['goods_volume'] = $_GPC['goods_volume'];
    $data['spec_name'] = $_GPC['spec_name'];
    $data['spec_value'] = $_GPC['spec_value'];
    $data['type_id'] = $_GPC['type_id'];
    $data['freight'] = $_GPC['freight'];
    $data['delivery'] = $_GPC['delivery'];
    $data['quality'] = $_GPC['quality'];
    $data['goods_details'] = htmlspecialchars_decode($_GPC['goods_details']);
    $data['free'] = $_GPC['free'];
    $data['all_day'] = $_GPC['all_day'];
    $data['service'] = $_GPC['service'];
    $data['refund'] = $_GPC['refund'];
    $data['weeks'] = $_GPC['weeks'];
    $data['time'] = date("Y-m-d H:i:s");
    $data['special'] = htmlspecialchars_decode($_GPC['special']);
    $data['journey'] = htmlspecialchars_decode($_GPC['journey']);
    $data['cost_detail'] = htmlspecialchars_decode($_GPC['cost_detail']);
    $data['bookings'] = htmlspecialchars_decode($_GPC['bookings']);
    $data['travel_type'] = $_GPC['travel_type'];
    $data['start_place'] = $_GPC['start_place'];
    $data['end_place'] = $_GPC['end_place'];
    $data['start_num'] = $_GPC['start_num'];
    $data['ly_date'] = $_GPC['ly_date'];
    $data['preferential'] = $_GPC['preferential'];
    $data['start_date'] = $_GPC['start_date'];  //出发时间
    $data['back_date'] = $_GPC['back_date'];    //返回时间
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
    $gid = $_GPC['gid'];
    if(empty($gid)){
       $res = pdo_insert('fyly_sun_goods',$data);
       $gid = pdo_insertid();
    }else{
       $res= pdo_update('fyly_sun_goods',$data,array('uniacid'=>$_W['uniacid'],'id'=>$gid));
    }
    echo $gid;

}else if($_GPC['istuanqi'] == 1 && empty($_GPC['isgoods'])) {

    $year = $_GPC['year'];
    $newdata = $_GPC['data'];
    $number = count($newdata);
    $oldnumber = count(pdo_getall('fyly_sun_tuanqi', array('uniacid' => $_W['uniacid'], 'year' => $year, 'month' => $newdata[0]['month'], 'gid' => $_GPC['gid'])));
    $count = 0;
    // 保存数据
    $gid = $_GPC['gid'];
    foreach ($newdata as $k => $v) {
        $insertdata = [
            'year' => $year,
            'month' => $v['month'],
            'price' => $v['price'],
            'stock' => $v['stock'],
            'day' => $v['day'],
            'uniacid' => $_W['uniacid'],
            'gid' => $gid,
        ];
        if ($number != $oldnumber) {
            $res = pdo_insert('fyly_sun_tuanqi', $insertdata);
            if ($res) {
                $count += 1;
            }
        } else {
            $res = pdo_update('fyly_sun_tuanqi', $insertdata, array('uniacid' => $_W['uniacid'], 'year' => $year, 'month' => $v['month'], 'day' => $v['day'], 'gid' => $gid));
        }
    }
    echo 1;
}else{
    // 获取年份数据
    $year = $_GPC['year'];
   // $all = pdo_getall('fyly_sun_tuanqi', ['uniacid' => $_W['uniacid'], 'year' => $year,'gid'=>$_GPC['gid']]);
    $data = getdata($year);
    foreach ($data as $k => $v) {
        $data[$k] = getdetail($year, $k, $v);
    }
    echo json_encode($data);
}

//获得每月的天数
    function getdays($year, $month)
    {
        $days = daysInmonth($year, $month);
        $days = array_fill(1, $days, 0);
        foreach ($days as $k => $v) {
            unset($days[$k]);
            $days[$k]['number'] = $k;
        }
        return $days;
    }

    //获得每年的月数
    function getdata($year)
    {
        global $_GPC, $_W;
        $month = array_fill(1, 12, 0);
        foreach ($month as $k => $v) {
            unset($month[$k]);
            $month[$k] = getdays($year, $k);
        }
        return $month;
    }

    //获得日期对应的库存以及价格
    function getdetail($year, $month, $days)
    {
        global $_W, $_GPC;
        //获取数据
        if(!empty($_GPC['gid'])){
            $data = pdo_getall('fyly_sun_tuanqi', ['uniacid' => $_W['uniacid'], 'year' => $year, 'month' => $month,'gid'=>$_GPC['gid']]);
        }else{
            $data = pdo_getall('fyly_sun_tuanqi', ['uniacid' => $_W['uniacid'], 'year' => $year, 'month' => $month]);
            foreach ($data as $k=>$v){
                $data[$k]['price'] = 0;
                $data[$k]['stock'] = 0;
            }
        }

//p($data);
//获取库存数据
        $ids = '';
        foreach ($data as $k => $v) {
            $ids .= $v['id'] . ',';
        }
        $ids = trim($ids, ',');

        if (!empty($ids)) {
            $sql = 'select * from ' . tablename('fyly_sun_tuanqi_log') . ' where buy_id in (' . $ids . ')';
            $stockdata = pdo_fetchall($sql);
        } else {
            $stockdata = [];
        }

        foreach ($data as $k => $v) {
            foreach ($stockdata as $kk => $vv) {
                if ($v['id'] == $vv['buy_id']) {
                    $data[$k]['stock'] -= $vv['number'];
                }
            }
        }
//p($data);
        foreach ($days as $k => $v) {
            $days[$k]['price'] = $days[$k]['stock'] = 0;
            foreach ($data as $kk => $vv) {
                if ($v['number'] == $vv['day']) {
                    $days[$k]['price'] = $vv['price'];
                    $days[$k]['stock'] = $vv['stock'];
                }
            }
        }
        return $days;
    }



    //计算每月天数方法
    function daysInmonth($year = '', $month = '')
    {
        if (empty($year)) $year = date('Y');
        if (empty($month)) $month = date('m');
        if (in_array($month, array(1, 3, 5, 7, 8, '01', '03', '05', '07', '08', 10, 12))) {
            $text = '31';        //月大
        } elseif ($month == 2 || $month == '02') {
            if (($year % 400 == 0) || (($year % 4 == 0) && ($year % 100 !== 0))) {   //判断是否是闰年
                $text = '29';        //闰年2月
            } else {
                $text = '28';        //平年2月
            }
        } else {
            $text = '30';            //月小
        }

        return $text;
    }
