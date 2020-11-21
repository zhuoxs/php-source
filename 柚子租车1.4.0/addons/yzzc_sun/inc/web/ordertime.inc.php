<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/25
 * Time: 16:17
 */

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$carnum = $_GPC['carnum'];

$carname = pdo_get('yzzc_sun_goods',array('uniacid'=>$_W['uniacid'],'carnum'=>$carnum),array('name','carnum'));
// var_dump($carname);
$where="uniacid =".$_W['uniacid']." and carnum = "."'$carnum'";


$type=$_GPC['type']?$_GPC['type']:'all';
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzzc_sun_ordertime where ".$where." ORDER BY end_time DESC,start_time DESC LIMIT ".(($page-1) * $size).','.$size;
// var_dump($sql);

$list = pdo_fetchall($sql);
if($list){
    foreach ($list as $key =>$value){
        $list[$key]['start_time']=date('Y-m-d H:i:s',$value['start_time']);
        $list[$key]['end_time']=date('Y-m-d H:i:s',$value['end_time']);
    }
    $total=pdo_fetchcolumn("select count(*) from ims_yzzc_sun_ordertime where ".$where);
    $pager = pagination($total, $page, $size);
}
// var_dump($list);
if($_GPC['op']=='add'){
    $carnum=$_GPC['carnum'];
    $data['start_time']=strtotime($_GPC['start_time']);
    $data['end_time']=strtotime($_GPC['end_time']);
    $data['carnum']=$_GPC['carnum'];
    $data['uniacid']=$_W['uniacid'];
    if(strtotime($_GPC['start_time'])>=strtotime($_GPC['end_time'])){
        message('添加失败！开始时间不得大于结束时间！','','error');
    }
    // var_dump($data);
    //全部占用时间
    $allorder=pdo_fetchall('select * from '.tablename('yzzc_sun_ordertime')." where uniacid = ".$_W['uniacid']." and carnum = '$carnum'");
    // var_dump($allorder);die;
    if($allorder){
        //遍历
        foreach ($allorder as $key => $value) {
            $start_time=$value['start_time'];
            $end_time=$value['end_time'];
            $starttime=date('Y-m-d H:i:s',$start_time);
            $endtime=date('Y-m-d H:i:s',$end_time);
            $stime= strtotime($_GPC['start_time']);
            $etime= strtotime($_GPC['end_time']);
            if($stime<$start_time&&$etime>$end_time&&$start_time<$etime&&$stime<$end_time){
                message('添加失败！您选择的时间已存在占用时间,时间为：'.$starttime.'--'.$endtime,'','error');
            }
            //    自开 < 订开 < 自结 < 订结
            elseif ($stime<$start_time&&$end_time>$etime&&$start_time<$etime&&$stime<$end_time){
                message('添加失败！您选择的时间已存在占用时间,时间为：'.$starttime.'--'.$endtime,'','error');
            }
            //    订开 < 自开 < 订结 < 自结
            elseif ($start_time<$stime&&$etime>$end_time&&$start_time<$etime&&$stime<$end_time){
                message('添加失败！您选择的时间已存在占用时间,时间为：'.$starttime.'--'.$endtime,'','error');
            }
            //    订开 < 自开 < 自结 < 订结
            elseif ($start_time<$stime&&$end_time>$etime&&$start_time<$etime&&$stime<$end_time){
                message('添加失败！您选择的时间已存在占用时间,时间为：'.$starttime.'--'.$endtime,'','error');
            }


        }
        $res=pdo_insert('yzzc_sun_ordertime',$data);
    }else{
        $res=pdo_insert('yzzc_sun_ordertime',$data);
    }
    if($res){
        message('添加成功！', $this->createWebUrl('ordertime',array('carnum'=>$_GPC['carnum'])), 'success');

    }else{
        message('添加失败！','','error');

    }
}
if($_GPC['op']=='delete'){
    $ordertime=pdo_get('yzzc_sun_ordertime',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
    $order=pdo_get('yzzc_sun_order',array('uniacid'=>$_W['uniacid'],'carnum'=>$_GPC['carnum'],'start_time'=>$ordertime['start_time'],'end_time'=>$ordertime['end_time']));
    // var_dump()
    if($order){
        message('删除失败,当前占用时间为订单添加的时间，无法删除！','','error');

    }else{
        $res=pdo_delete('yzzc_sun_ordertime',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('删除成功！', $this->createWebUrl('ordertime',array('carnum'=>$_GPC['carnum'])), 'success');
        }else{
            message('删除失败！','','error');
        }
    }
    
}


include $this->template('web/ordertime');