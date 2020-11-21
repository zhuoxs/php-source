<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
//    数据查询
    case "query":
        $where = [];
        $where[] = "t1.uniacid = $uniacid";
        if($_GPC['key']){
            $where[] ="(t2.name LIKE concat('%', :name,'%') or t1.order_number like '%{$_GPC['key']}%')";
            $data[':name']=$_GPC['key'];
        }
        if($_GPC['store_id']){
            $where[] ="t1.store_id = :store_id";
            $data[':store_id']=$_GPC['store_id'];
        }
        if($_SESSION['admin']['store_id']){
            $where[] = "t1.store_id = ".$_SESSION['admin']['store_id'];
        }
        if($_GPC['order_type']){
            $where[] = "t1.order_type = {$_GPC['order_type']}";
        }
        $where_sql = count($where)>0?"WHERE ".implode(' and ',$where):"";

        $order_sql = "";
        if($_GPC['orderfield']){
            $order_sql = " ORDER BY ".$_GPC['orderfield'].(strtolower($_GPC['ordertype'])=="desc"?" DESC":"");
        }

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t1.*,t2.name,t3.name as store_name from ".tablename('yzhyk_sun_order')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t3 on t3.id = t1.store_id ";
        $sql .= $where_sql.$order_sql.$limt_sql;

        $list = pdo_fetchall($sql,$data);
        $sql = "";
        $sql .= "select count(*) from ".tablename('yzhyk_sun_order')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t3 on t3.id = t1.store_id ";
        $total=pdo_fetchcolumn($sql.$where_sql,$data);

        $sql = "";
        $sql .= "select sum(t1.amount) as amount,sum(t1.pay_amount) as pay_amount from ".tablename('yzhyk_sun_order')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t3 on t3.id = t1.store_id ";

        $total_column = pdo_fetch($sql.$where_sql,$data);

        echo json_encode([
            'code'=>0,
            'count'=>$total,
            'data'=>$list,
            'msg'=>'',
             'foot'=>array('store_name'=>'合计','amount'=>$total_column['amount'],'pay_amount'=>$total_column['pay_amount']),
        ]);
        exit();
//    查看
    case "see":
        $sql = "";
        $sql .= "select t1.*,t2.name as store_name,t3.name as user_name from ".tablename('yzhyk_sun_order')." t1 left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id left join ".tablename('yzhyk_sun_user')." t3 on t3.id = t1.user_id ";
        $sql .= "where t1.id = {$_GPC['id']} ";
        $ret = pdo_fetchall($sql);
        $info = $ret[0];
        $sql = "";
        $sql .= "select t1.* from ".tablename('yzhyk_sun_ordergoods')." t1 ";
        $sql .= "where t1.order_id = {$_GPC['id']} ";

        $list = pdo_fetchall($sql);
        include $this->template('web/order/see');
        break;

//    保存-新增、修改
    case "save":
        if($_GPC['name']){
            $rst=pdo_get('yzhyk_sun_order',array('name'=>$_GPC['name'],'id !='=>$_GPC['id']));
            if($rst){
                message('商品名称已存在,请更换','','error');
            }
        }
        if($_GPC['barcode']){
            $rst=pdo_get('yzhyk_sun_order',array('barcode'=>$_GPC['barcode'],'id !='=>$_GPC['id']));
            if($rst){
                message('商品条形码已存在,请更换','','error');
            }
        }

        $data['name'] = $_GPC['name'];
        $data['code'] = $_GPC['code'];
        $data['barcode'] = $_GPC['barcode'];
        $data['std'] = $_GPC['std'];
        $data['root_id'] = $_GPC['root_id'];
        $data['class_id'] = $_GPC['class_id'];
        $data['marketprice'] = $_GPC['marketprice']?:$_GPC['shopprice'];
        $data['shopprice'] = $_GPC['shopprice'];
        $data['uniacid'] = $_GPC['uniacid']?:$uniacid;

        if($_GPC['id']){
            $res = pdo_update('yzhyk_sun_order', $data, array('id' => $_GPC['id']));
            $opt_name = '编辑';
        }else{
            $res = pdo_insert('yzhyk_sun_order', $data);
            $opt_name = '新增';
        }

        if($res){
            message($opt_name.'成功',$this->createWebUrl('order',array()),'success');
        }else{
            message($opt_name.'失败','','error');
        }
        break;
//    发货
    case "send":
        $ret=pdo_update("yzhyk_sun_order",['state'=>'30'],array('id'=>$_GPC['id']));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'发货失败',
            ));
        }
        break;
//    批量发货
    case "batchsend":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_order",['state'=>'30'],array('id'=>$ids,'state'=>'20'));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'发货失败',
            ));
        }
        break;
//    完成
    case "btnCom":
        $ret=pdo_update("yzhyk_sun_order",['state'=>'40'],array('id'=>$_GPC['id'],'state'=>'30'));
        $is_offline=0;
        $order = pdo_get('yzhyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id'],'state'=>40));
        if($order['pay_type']=='余额'){
            $distributionset = pdo_get('yzhyk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array("is_offline"));
            if($distributionset['is_offline']==1){
                $is_offline=1;
            }
        }else{
            $is_offline=1;
        }
        if($is_offline==1){

            //========计算分销佣金 S===========
            include_once IA_ROOT . '/addons/yzhyk_sun/inc/func/distribution.php';
            $distribution = new Distribution();
            $distribution->order_id = $order['id'];
            // $distribution->money = $order['pay_amount'];
            // $distribution->userid = pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$order['user_id']))['openid'];
            $distribution->ordertype = $order['order_type'];
            // $distribution->computecommission();
            //========计算分销佣金 E===========
            //直接结算
            $distribution->settlecommission();
        }
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'操作失败',
            ));
        }
        break;
//    批量完成
    case "complete":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_order",['state'=>'40'],array('id'=>$ids,'state'=>'30'));
        // var_dump($ids);
            // $distributionset = pdo_get('yzhyk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array("is_offline"));
        $is_offline=0;
        
        foreach ($ids as $key => $value) {
            $order = pdo_get('yzhyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$value,'state'=>40));
            if($order['pay_type']=='余额'){
                $distributionset = pdo_get('yzhyk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array("is_offline"));
                if($distributionset['is_offline']==1){
                    $is_offline=1;
                }
            }else{
                $is_offline=1;
            }
            if($is_offline==1){

                //========计算分销佣金 S===========
                include_once IA_ROOT . '/addons/yzhyk_sun/inc/func/distribution.php';
                $distribution = new Distribution();
                $distribution->order_id = $order['id'];
                // $distribution->money = $order['pay_amount'];
                // $distribution->userid = pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$order['user_id']))['openid'];
                $distribution->ordertype = $order['order_type'];
                // $distribution->computecommission();
                //========计算分销佣金 E===========
                //直接结算
                $distribution->settlecommission();
            }
        }
        // die;
        
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'操作失败',
            ));
        }
        break;
    //    批量打印
    case "batchprint":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $order = new order();

        //失败次数
        $error_count = 0;
        $error = "";
        foreach ($ids as $id) {
            $ret = $order->fe_print($id);
            if ($ret['code']){
                $error_count ++;
                $error .= $ret['msg'].';';
            }
        }
        if (!$error_count){
            echo json_encode(array('code'=>0));
        }else{
            echo json_encode(array('code'=>1,'msg'=>$error_count.'条记录打印失败：'.$error));
        }

        break;
    //退款
    case 'refund':
        $id = intval($_GPC['id']);
        $uniacid = $_W['uniacid'];
        $state = intval($_GPC['state']);
        if($state==3){
            $ress = pdo_update('yzhyk_sun_order',array("istui"=>3),array('id'=>$id,'uniacid'=>$uniacid));
            if($ress){
                echo json_encode(array(
                    'code'=>0,
                ));
            }else{
                echo json_encode(array(
                    'code'=>1,
                    'msg'=>'操作失败',
                ));
            }
        }

        //获取订单信息
        $order = pdo_get('yzhyk_sun_order',array('uniacid'=>$uniacid,'id'=>$id),array("pay_amount","out_trade_no","out_refund_no"));
        // var_dump($order);
        //退款操作
        include_once IA_ROOT . '/addons/yzhyk_sun/cert/WxPay.Api.php';
        load()->model('account');
        load()->func('communication');
        //获取appid和appkey
        $res=pdo_get('yzhyk_sun_system',array('uniacid'=>$uniacid));
        $appid=$res['appid'];
        $wxkey=$res['wxkey'];
        $mchid=$res['mchid'];
        $path_cert = IA_ROOT . "/addons/yzhyk_sun/cert/".$res['apiclient_cert'];
        $path_key = IA_ROOT . "/addons/yzhyk_sun/cert/".$res['apiclient_key'];
        $out_trade_no=$order['out_trade_no'];
        $fee = $order['pay_amount'] * 100;
        $out_refund_no = $order['out_refund_no']?$order['out_trade_no']:$mchid.rand(100,999).time().rand(1000,9999);
        $WxPayApi = new WxPayApi();
        $input = new WxPayRefund();
        $input->SetAppid($appid);
        $input->SetMch_id($mchid);
        $input->SetOp_user_id($mchid);
        $input->SetRefund_fee($fee);
        $input->SetTotal_fee($fee);
        $input->SetOut_refund_no($out_refund_no);
        $input->SetOut_trade_no($out_trade_no);
        $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $wxkey);
        
        // var_dump($input);
        // var_dump($result);

        // die;
        if ($result['result_code'] == 'SUCCESS') {//退款成功
            pdo_update('yzhyk_sun_order',array("istui "=>2,"out_refund_no "=>$out_refund_no,'state'=>60),array('id'=>$id,'uniacid'=>$uniacid));
            $ordergoods=pdo_getall('yzhyk_sun_ordergoods',array('uniacid'=>$_W['uniacid'],'order_id'=>$id));
            foreach ($ordergoods as $key => $value) {
                pdo_update('yzhyk_sun_storegoods',array('stock +='=>$value['num']),array('goods_id'=>$value['goods_id'],'uniacid'=>$_W['uniacid']));
            }
            echo json_encode(array(
                    'code'=>0,
                ));
            // message('退款成功！', $this->createWebUrl('ordercoupon'), 'success');
        }else{
            pdo_update('yzhyk_sun_order',array("istui "=>3,"out_refund_no "=>$out_refund_no),array('id'=>$id,'uniacid'=>$uniacid));

            // message('退款失败！微信'.$result["err_code_des"],'','error');
            echo json_encode(array(
                    'code'=>1,
                    'msg'=>'退款失败！微信'.$result["err_code_des"],
                ));
      
        }
    break;
    //    批量打印
    case "batchprint2":
        include_once '/../../class/Feie.php';
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $order = new order();
        $store = new store();
        $user = new user();

        // function getMoney($money,$len = 7,$num = 2){
        //     $money = sprintf("%.{$num}f",$money);
        //     for ($i = 1;$i<= $len;$i++){
        //         $money = ' '.$money;
        //     }
        //     return substr($money,-1*$len);
        // }
        // function getName($name,$len = 6){
        //     if(strlen($name)>= $len*3){
        //         return $name;
        //     }

        //     for ($i = 1;$i<= $len;$i++){
        //         $name .= '　';
        //     }
        //     return substr($name,0,$len*3);
        // }
        if (!function_exists('getMoney')) {
            function getMoney($money,$len = 7,$num = 2){
                $money = sprintf("%.{$num}f",$money);
                for ($i = 1;$i<= $len;$i++){
                    $money = ' '.$money;
                }
                return substr($money,-1*$len);
            }
        }
        
        if (!function_exists('getName')) {
            function getName($name,$len = 6){
                if(strlen($name)>= $len*3){
                    return $name;
                }

                for ($i = 1;$i<= $len;$i++){
                    $name .= '　';
                }
                return substr($name,0,$len*3);
            }
        }
        //失败次数
        $error_count = 0;
        $error = "";
        foreach ($ids as $id) {
            // p($id);
            // $order_data = $order->get_data_by_id($id);
            $order_data=pdo_get('yzhyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$id));
            $goodses=pdo_getall('yzhyk_sun_ordergoods',array('uniacid'=>$_W['uniacid'],'order_id'=>$id));
            $store_data = $store->get_data_by_id($order_data['store_id']);
            $user_data = $user->get_data_by_id($order_data['user_id']);
            // p($order_data);
            // p($goodses);
            // p($store_data);
            // p($user_data);
            if (!$store_data['feie_user']){
                continue;
            }
            $feie = new Feie($store_data['feie_user'],$store_data['feie_ukey'],$store_data['feie_sn']);

            $print_info = "";
            // $print_info .= '<CB>打印测试</CB><BR>';
            //自提
            if ($order_data['distribution_type'] == 1){
                $print_info .= '<CB>门店自提单</CB><BR>';
                $print_info .= '提货人：'.$user_data['name'].'<BR>';
                $print_info .= '联系电话：'.$order_data['take_tel'].'<BR>';
                $print_info .= '提货时间：'.$order_data['take_time'].'<BR>';
            }else{
                //门店配送
                $print_info .= '<CB>门店配送单</CB><BR>';
                $print_info .= '收货人：'.$user_data['name'].'<BR>';
                $print_info .= '联系电话：'.$user_data['tel'].'<BR>';
                $print_info .= '地址：'.$order_data['province'].$order_data['city'].$order_data['county'].'<BR>';
                $print_info .= $order_data['address'].'<BR>';
            }
            $print_info .= '名称　　　　　 <RIGHT>单价 数量  金额</RIGHT><BR>';
            $print_info .= '--------------------------------<BR>';
            // p($print_info);
            foreach ($goodses as $goods) {
                $print_info .= getName($goods['goods_name'])
                    .'<RIGHT>'
                    .getMoney($goods['goods_price'])
                    .getMoney($goods['num'],4,0)
                    .getMoney($goods['goods_price']*$goods['num'])
                    .'</RIGHT><BR>';
            }
            // foreach ($order_data['goodses'] as $goods) {
            //     $print_info .= getName($goods['goods_name'])
            //         .'<RIGHT>'
            //         .getMoney($goods['goods_price'])
            //         .getMoney($goods['num'],4,0)
            //         .getMoney($goods['goods_price']*$goods['num'])
            //         .'</RIGHT><BR>';
            // }
            // foreach ($order_data['goodses'] as $goods) {
            //     $print_info .= getName($goods['goods_name'])
            //         .'<RIGHT>'
            //         .getMoney($goods['goods_price'])
            //         .getMoney($goods['num'],4,0)
            //         .getMoney($goods['goods_price']*$goods['num'])
            //         .'</RIGHT><BR>';
            // }
            $print_info .= '--------------------------------<BR>';
            $print_info .= '合计：'.$order_data['amount'].'<BR>';
            $print_info .= '单号：'.$order_data['order_number'].'<BR>';
            $print_info .= '日期：'.date("Y-m-d H:i:s",$order_data['time']).'<BR>';
            
            // p($print_info);
            $ret = $feie->print_fe($print_info);
            if ($ret['code']){
                $error_count ++;
                $error .= $ret['msg'].';';
            }
        }
        if (!$error_count){
            echo json_encode(array('code'=>0));
        }else{
            echo json_encode(array('code'=>1,'msg'=>$error_count.'条记录打印失败：'.$error));
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
