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
        // if($_GPC['order_type']){
        //     $where[] = "t1.order_type = {$_GPC['order_type']}";
        // }
        $where_sql = count($where)>0?"WHERE ".implode(' and ',$where):"";

        $order_sql = "";
        if($_GPC['orderfield']){
            $order_sql = " ORDER BY ".$_GPC['orderfield'].(strtolower($_GPC['ordertype'])=="desc"?" DESC":"");
        }

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['limit']?:10;
        $limt_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

        $sql = "";
        $sql .= "select t1.*,t2.name,t3.name as store_name from ".tablename('yzhyk_sun_orderapp')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t3 on t3.id = t1.store_id ";
        $sql .= $where_sql.$order_sql.$limt_sql;

        $list = pdo_fetchall($sql,$data);
        $sql = "";
        $sql .= "select count(*) from ".tablename('yzhyk_sun_orderapp')." t1 ";
        $sql .= "left join ".tablename('yzhyk_sun_user')." t2 on t2.id = t1.user_id ";
        $sql .= "left join ".tablename('yzhyk_sun_store')." t3 on t3.id = t1.store_id ";
        $total=pdo_fetchcolumn($sql.$where_sql,$data);

        $sql = "";
        $sql .= "select sum(t1.amount) as amount,sum(t1.pay_amount) as pay_amount from ".tablename('yzhyk_sun_orderapp')." t1 ";
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
        $sql .= "select t1.*,t2.name as store_name,t3.name as user_name from ".tablename('yzhyk_sun_orderapp')." t1 left join ".tablename('yzhyk_sun_store')." t2 on t2.id = t1.store_id left join ".tablename('yzhyk_sun_user')." t3 on t3.id = t1.user_id ";
        $sql .= "where t1.id = {$_GPC['id']} ";
        $ret = pdo_fetchall($sql);
        $info = $ret[0];
        $sql = "";
        $sql .= "select t1.* from ".tablename('yzhyk_sun_orderappgoods')." t1 ";
        $sql .= "where t1.order_id = {$_GPC['id']} ";

        $list = pdo_fetchall($sql);
        include $this->template('web/orderapp/see');
        break;

//    保存-新增、修改
    case "save":
        if($_GPC['name']){
            $rst=pdo_get('yzhyk_sun_orderapp',array('name'=>$_GPC['name'],'id !='=>$_GPC['id']));
            if($rst){
                message('商品名称已存在,请更换','','error');
            }
        }
        if($_GPC['barcode']){
            $rst=pdo_get('yzhyk_sun_orderapp',array('barcode'=>$_GPC['barcode'],'id !='=>$_GPC['id']));
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
            $res = pdo_update('yzhyk_sun_orderapp', $data, array('id' => $_GPC['id']));
            $opt_name = '编辑';
        }else{
            $res = pdo_insert('yzhyk_sun_orderapp', $data);
            $opt_name = '新增';
        }

        if($res){
            message($opt_name.'成功',$this->createWebUrl('orderapp',array()),'success');
        }else{
            message($opt_name.'失败','','error');
        }
        break;
//    核销
    case "send":
        $ret=pdo_update("yzhyk_sun_orderapp",['state'=>'30'],array('id'=>$_GPC['id']));
        $is_offline=0;
        $order = pdo_get('yzhyk_sun_orderapp',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id'],'state'=>30));
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
            $distribution->ordertype = 4;
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
                'msg'=>'核销失败',
            ));
        }
        break;
//    批量核销
    case "batchsend":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $ret=pdo_update("yzhyk_sun_orderapp",['state'=>'30'],array('id'=>$ids,'state'=>20));
        $is_offline=0;
        
        foreach ($ids as $key => $value) {
            $order = pdo_get('yzhyk_sun_orderapp',array('uniacid'=>$_W['uniacid'],'id'=>$value,'state'=>30));
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
                $distribution->ordertype = 4;
                // $distribution->computecommission();
                //========计算分销佣金 E===========
                //直接结算
                $distribution->settlecommission();
            }
        }
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'核销失败',
            ));
        }
        break;
    //    批量打印
    case "batchprint":
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $order = new orderapp();

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
    //    批量打印
    case "batchprint2":
        include_once '/../../class/Feie.php';
        $ids = $_GPC['ids'];
        $ids = explode(',',$ids);
        $order = new orderapp();
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
        if (function_exists('getMoney')) {
            function getMoney($money,$len = 7,$num = 2){
                $money = sprintf("%.{$num}f",$money);
                for ($i = 1;$i<= $len;$i++){
                    $money = ' '.$money;
                }
                return substr($money,-1*$len);
            }
        }
        
        if (function_exists('getName')) {
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
            $order_data = $order->get_data_by_id($id);
            $store_data = $store->get_data_by_id($order_data['store_id']);
            $user_data = $user->get_data_by_id($order_data['user_id']);
            if (!$store_data['feie_user']){
                continue;
            }
            $feie = new Feie($store_data['feie_user'],$store_data['feie_ukey'],$store_data['feie_sn']);
//            $feie = new Feie('1020526528@qq.com','jJWJu6rSIv2dsBun','918513936');

            $print_info = "";
            // $print_info .= '<CB>打印测试</CB><BR>';
//            自提
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
            foreach ($order_data['goodses'] as $goods) {
                $print_info .= getName($goods['goods_name'])
                    .'<RIGHT>'
                    .getMoney($goods['goods_price'])
                    .getMoney($goods['num'],4,0)
                    .getMoney($goods['goods_price']*$goods['num'])
                    .'</RIGHT><BR>';
            }
            foreach ($order_data['goodses'] as $goods) {
                $print_info .= getName($goods['goods_name'])
                    .'<RIGHT>'
                    .getMoney($goods['goods_price'])
                    .getMoney($goods['num'],4,0)
                    .getMoney($goods['goods_price']*$goods['num'])
                    .'</RIGHT><BR>';
            }
            foreach ($order_data['goodses'] as $goods) {
                $print_info .= getName($goods['goods_name'])
                    .'<RIGHT>'
                    .getMoney($goods['goods_price'])
                    .getMoney($goods['num'],4,0)
                    .getMoney($goods['goods_price']*$goods['num'])
                    .'</RIGHT><BR>';
            }
            $print_info .= '--------------------------------<BR>';
            $print_info .= '合计：'.$order_data['amount'].'<BR>';
            $print_info .= '单号：'.$order_data['order_number'].'<BR>';
            $print_info .= '日期：'.date("Y-m-d H:i:s",strtotime($order_data['time'])).'<BR>';

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
