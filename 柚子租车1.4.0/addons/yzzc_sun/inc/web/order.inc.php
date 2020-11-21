<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/25
 * Time: 16:17
 */

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

$where="uniacid =".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where="uniacid =".$_W['uniacid']." and ordernum LIKE  '%$op%'";
}
$status = 6;
if($_GPC['type']){
    $status = $_GPC['status'];

    if($_GPC['type']=='all'){
        $where="uniacid =".$_W['uniacid'];
    }else{
        $where="uniacid =".$_W['uniacid']." and status =" .$_GPC['status'];

    }
}

if($_GPC['istui']!=null){

    $istui=$_GPC['istui'];
    $refund=$_GPC['refund'];
    $where .=" and  istui =".$_GPC['istui'];

}
if($_GPC['del']=='del'){

    $isdel=$_GPC['isdel'];
    $del=$_GPC['del'];
    $where .=" and display = 0";

}
//var_dump($where);exit;
// $where .=" and display = 1" ;
//var_dump($where);exit;
$type=$_GPC['type']?$_GPC['type']:'all';
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzzc_sun_order where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
//var_dump($sql);exit;
$list = pdo_fetchall($sql);
if($list){
    foreach ($list as $key =>$value){
        $list[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
        if($value['paytime']){
            $list[$key]['paytime']=date('Y-m-d H:i:s',$value['paytime']);
        }
        $list[$key]['start_time']=date('Y-m-d H:i:s',$value['start_time']);
        $list[$key]['end_time']=date('Y-m-d H:i:s',$value['end_time']);
        if($value['usetime']){
            $list[$key]['usetime']=date('Y-m-d H:i:s',$value['usetime']);
        }
        if($value['return_time']){
            $list[$key]['return_time']=date('Y-m-d H:i:s',$value['return_time']);
        }
        $list[$key]['carname']=pdo_get('yzzc_sun_goods',array('id'=>$value['cid']),array('name'))['name'];
        $list[$key]['shopname']=pdo_get('yzzc_sun_branch',array('id'=>$value['start_shop']),array('name'))['name'];
        $list[$key]['nickname']=pdo_get('yzzc_sun_user',array('id'=>$value['uid']),array('user_name'))['user_name'];
    }
    $total=pdo_fetchcolumn("select count(*) from ims_yzzc_sun_order where ".$where);
    $pager = pagination($total, $page, $size);
}


if($_GPC['op']=='delete'){
    $order=pdo_get('yzzc_sun_order',array('id'=>$_GPC['oid']),array('status'));
//    var_dump($_GPC['oid']);exit;
    // if($order['status']<3){
    //     message('该订单还未完成不可删除','','error');
    // }
    $res=pdo_update('yzzc_sun_order',array('display'=>0,'status'=>7),array('id'=>$_GPC['oid']));
    if($res){
        message('删除成功！', $this->createWebUrl('order'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
/*还车*/
if($_GPC['op']=='cancel'){
    $order=pdo_get('yzzc_sun_order',array('id'=>$_GPC['id']));
    if($order['status']==1){
        $res=pdo_update('yzzc_sun_order',array('status'=>4),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
           // pdo_update('yzzc_sun_goods',array('status'=>1),array('id'=>$order['cid'],'uniacid'=>$_W['uniacid']));
            message('取消成功！', $this->createWebUrl('order'), 'success');
        }else{
            message('取消失败！','','error');
        }
    }else{
        message('当前车辆无法取消！','','error');
    }

}
if($_GPC['op']=='update'){
    $order=pdo_get('yzzc_sun_order',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($order['status']==1){
        $res=pdo_update('yzzc_sun_order',array('prepay_money'=>$_GPC['prepay_money']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
           // pdo_update('yzzc_sun_goods',array('status'=>1),array('id'=>$order['cid'],'uniacid'=>$_W['uniacid']));
            message('修改成功！', $this->createWebUrl('order'), 'success');
        }else{
            message('修改失败！','','error');
        }
    }else{
        message('当前订单无法修改！','','error');
    }

}
/*还车*/
if($_GPC['op']=='return'){
    $order=pdo_get('yzzc_sun_order',array('id'=>$_GPC['id']));
    if($order['status']==3){
        $res=pdo_update('yzzc_sun_order',array('status'=>0,'return_time'=>time()),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            $res1=pdo_delete('yzzc_sun_ordertime',array('carnum'=>$order['carnum'],'start_time'=>$order['start_time'],'uniacid'=>$_W['uniacid'],'end_time'=>$order['end_time']));

           // pdo_update('yzzc_sun_goods',array('status'=>1),array('id'=>$order['cid'],'uniacid'=>$_W['uniacid']));
            message('还车成功！', $this->createWebUrl('order'), 'success');
        }else{
            message('还车失败！','','error');
        }
    }else{
        message('当前车辆无法还车！','','error');
    }

}
if($_GPC['op']=='refund'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $refund = intval($_GPC['refund']);
    if($refund==3){
        $ress = pdo_update('yzzc_sun_order',array("istui"=>3),array('id'=>$id,'uniacid'=>$uniacid));
        if($ress){
            message('拒绝成功！', $this->createWebUrl('order'), 'success');
        }else{
            message('拒绝失败！','','error');
        }
    }
    $tuimoney=pdo_get('yzzc_sun_order_set',array('uniacid'=>$_W['uniacid']),array('tuimoney'))['tuimoney'];
    if($tuimoney){
        $tuimoney=$tuimoney/100;
    }else{
        $tuimoney=1;
    }
    // var_dump($tuimoney);
    // //获取订单信息
    $order = pdo_get('yzzc_sun_order',array('uniacid'=>$uniacid,'id'=>$id),array('ordernum',"prepay_money","out_trade_no","out_refund_no","cid",'uid','carnum','start_time','end_time'));

    // $price= $order['prepay_money'] * 100 * $tuimoney ; 
    $Total_fee= $order['prepay_money'] * 100;
    $Refund_fee = $Total_fee*$tuimoney ;
    if($Refund_fee<1){
        $Refund_fee = 1;
    }
    // var_dump($Total_fee);
    // var_dump($tuimoney);
    // var_dump($Refund_fee);
    //退款操作
    include_once IA_ROOT . '/addons/yzzc_sun/cert/WxPay.Api.php';
    load()->model('account');
    load()->func('communication');
    //获取appid和appkey
    $res=pdo_get('yzzc_sun_system',array('uniacid'=>$uniacid));
    $appid=$res['appid'];
    $wxkey=$res['wxkey'];
    $mchid=$res['mchid'];
    $path_cert = IA_ROOT . "/attachment/".$res['apiclient_cert'];
    $path_key = IA_ROOT . "/attachment/".$res['apiclient_key'];
    $out_trade_no=$order['out_trade_no'];
    // $fee = $price;
    $out_refund_no = $order['out_refund_no']?$order['out_trade_no']:$mchid.rand(100,999).time().rand(1000,9999);
    $WxPayApi = new WxPayApi();
    $input = new WxPayRefund();
    $input->SetAppid($appid);
    $input->SetMch_id($mchid);
    $input->SetOp_user_id($mchid);
    $input->SetRefund_fee($Refund_fee);
    $input->SetTotal_fee($Total_fee);
    $input->SetOut_refund_no($out_refund_no);
    $input->SetOut_trade_no($out_trade_no);
    $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $wxkey);
    
    // var_dump($result);
    // var_dump($mchid);
    // var_dump($fee);
    // var_dump($out_refund_no);
    // var_dump($out_trade_no);
    // die;
    if ($result['result_code'] == 'SUCCESS') {//退款成功

        pdo_delete('yzzc_sun_ordertime',array('carnum'=>$order['carnum'],'start_time'=>$order['start_time'],'uniacid'=>$_W['uniacid'],'end_time'=>$order['end_time']));

        pdo_update('yzzc_sun_order',array("istui "=>2,'status'=>5,"out_refund_no "=>$out_refund_no),array('id'=>$id,'uniacid'=>$uniacid));

        message('退款成功！', $this->createWebUrl('order'), 'success');
    }else{
        pdo_update('yzzc_sun_order',array("istui "=>3,"out_refund_no "=>$out_refund_no),array('id'=>$id,'uniacid'=>$uniacid));

        message('退款失败！微信'.$result["err_code_des"],'','error');
  
    }
}
//导出
if($_GPC['op']=='exportorder'){
    $where = ' where uniacid = '.$_W['uniacid'] .' and display = 1';
    if($_GPC['status']!=6&&$_GPC['status']){
        $where .= " and status = ".$_GPC['status'];
    }
    $sql = "SELECT * FROM ims_yzzc_sun_order ".$where." ORDER BY id DESC";
    // var_dump($sql);die;
    $orderlist = pdo_fetchall($sql);
    // $select_sql =$sql." order by a.order_id desc,a.id asc ";
    // $orderlist=pdo_fetchall($select_sql,$data);
    $export_title_str = "订单号,订单类型,门店名称（门店id）,车辆名称（车辆id）（车牌号）,租车开始时间,租车结束时间,天数,微信名（用户id）,定金,下单时间,付款时间,单价 / 手续费 / 基础服务费,积分抵现 / 优惠券抵现,是否选择尊享服务（价钱）,取车方式,取车名称/手机,取车时间,还车时间,订单状态";
    $export_title = explode(',',$export_title_str);
    $export_list = array(); 
    $status = array("已完成","待支付","已支付","已取车","已取消","已退款");
    $refund = array("否","退款申请中","已退款","拒绝退款");
    $i=1;
    foreach ($orderlist as $k => $v){

        $export_list[$k]["ordernum"] = $v["ordernum"]."\t";
        $export_list[$k]["type"] = $v["type"]==1?'短租订单'."\t":'长租订单'."\t";
        $export_list[$k]["shopname"] = pdo_get('yzzc_sun_branch',array('id'=>$v['start_shop']),array('name'))['name']."(".$v['start_shop'].")"."\t";
        $export_list[$k]["carname"] = pdo_get('yzzc_sun_goods',array('id'=>$v['cid']),array('name'))['name']."(".$v['cid'].")"."(".$v['carnum'].")"."\t";
        $export_list[$k]["start_time"] = date("Y-m-d H:i:s",$v["start_time"])."\t";
        $export_list[$k]["end_time"] = date("Y-m-d H:i:s",$v["end_time"])."\t";
        $export_list[$k]["day"] = $v["day"]."\t";
        $export_list[$k]["nickname"] = pdo_get('yzzc_sun_user',array('id'=>$v['uid']),array('user_name'))['user_name']."\t";
        $export_list[$k]["prepay_money"] = $v["prepay_money"];
        $export_list[$k]["createtime"] = date("Y-m-d H:i:s",$v["createtime"])."\t";
        $export_list[$k]["paytime"] = $v["paytime"]?date("Y-m-d H:i:s",$v["paytime"])."\t":" ";
        $export_list[$k]["money"] = "￥".$v['money'] ."/ ￥".$v['fee'] ."/ ￥".$v['service_fee'];
        $export_list[$k]["integral"] = $v['integral']."积分抵￥".$v['integral_money']."/ ￥".$v['coupon_money'];
        $export_list[$k]["zx"] = $v["open_zx_service"]==1?"开启（￥".$v['zx_service_fee']."）":"关闭";
        $export_list[$k]["gettype"] = $v["gettype"]==1?"到店自取":"送车上门";
        $export_list[$k]["name"] = $v['username'] ."/ ".$v['tel'];
        $export_list[$k]["usetime"] = $v["usetime"]?date("Y-m-d H:i:s",$v["usetime"])."\t":" ";
        $export_list[$k]["return_time"] = $v["return_time"]?date("Y-m-d H:i:s",$v["return_time"])."\t":" ";

        $export_list[$k]["status"] = $status[$v["status"]];

        $i++;
    } 
    $exporttitle = "租车订单";

    exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
    exit;
}
//导出方法
/** 
* @creator Jimmy 
* @data 2018/1/05 
* @desc 数据导出到excel(csv文件) 
* @param $filename 导出的csv文件名称 如'test-'.date("Y年m月j日").'.csv'
* @param array $tileArray 所有列名称 
* @param array $dataArray 所有列数据 
*/
function exportToExcel($filename, $tileArray=array(), $dataArray=array()){  
    ini_set('memory_limit','512M');
    ini_set('max_execution_time',0);
    ob_end_clean();
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=".$filename);
    $fp=fopen('php://output','w');
    fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))  
    fputcsv($fp,$tileArray);
    $index = 0;  
    foreach ($dataArray as $item) {  
        $index++;  
        fputcsv($fp,$item);  
    }  

    ob_flush();  
    flush();  
    ob_end_clean();  
}
include $this->template('web/order');