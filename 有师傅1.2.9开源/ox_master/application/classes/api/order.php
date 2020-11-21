<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Api_Order extends WeModuleWxapp
{
    public function create(){
        global $_GPC, $_W;
        $params = [
            "formid" => $_GPC['formid'],
            "o_sn" => order_sn(),
            "address"=> $_GPC['address'],
            "uid"=> $_GPC['uid'],
            "address_detail"=> $_GPC['address_detail'],
            "mapy"=> $_GPC['mapy'],
            "mapx"=> $_GPC['mapx'],
            "phone"=> $_GPC['phone'],
            "type_name"=> $_GPC['type_name'],
            "remark"=> $_GPC['remark'],
            "uniacid" => $_W['uniacid'],
            "status" => 0,
            "create_time" => $_SERVER['REQUEST_TIME']
        ];
        pdo_insert('ox_master_order',$params);
        $order_id = pdo_insertid();
        if($_GPC['imgs']){
            $imgs = json_decode(htmlspecialchars_decode($_GPC['imgs']),1);
            $data = [
                'order_id' => $order_id,
                'uniacid'=> $_W['uniacid'],
                'type' => 1,
                'create_time' => $_SERVER['REQUEST_TIME']
            ];
            foreach ($imgs as $k => $v){
                $data['img_patch'] = $v['short'];
                pdo_insert('ox_master_image',$data);
            }

        }
        return $this->result(0, '', '');
    }
    /**
     * 删除订单
     */
    public function deleteOrder(){
        global $_GPC, $_W;

        //添加formid
        $base = new Basis();
        $base->add_form_id($_GPC['uid'],$_GPC['formid']);

        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
            "id" => $_GPC['orderid']
        ];
        pdo_delete('ox_master_order',$params);
        $list = $this->orderList();
        return $this->result(0, '删除成功', $list);
    }
    /**
     * 取消订单
     */
    public  function cancel(){
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
            "id" => $_GPC['orderid']
        ];
        pdo_update('ox_master_order',['status' => 2],$params);
        $list = $this->orderList();
        return $this->result(0, '确认成功', $list);
    }
    /**
     * 确认订单
     */
    public function confirm(){
        global $_GPC, $_W;
        $basis = new Basis();

        //添加formid
        $basis->add_form_id($_GPC['uid'],$_GPC['formid']);
        
        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
            "id" => $_GPC['orderid']
        ];
        $result = pdo_update('ox_master_order',['status' => 3],$params);
        $price = pdo_getcolumn('ox_master_order',array('id'=> $_GPC['orderid']),'sure_price');
        $uid = pdo_getcolumn('ox_master_order',array('id'=> $_GPC['orderid']),'repair_uid');

        if($result){
            //把金钱加到余额
            $money = $price;    //变动可用资金
            $lock_money = -1 * $price;//变动冻结资金
            $uid = $uid;//师傅id
            $parame = array(
                'from_uid'=>4,  //来源用户-可不填写
                'type'=>0, //类型 0接单 1完工 2提现 3到账(无实际作用,可不设置)
                'from_id'=> $_GPC['orderid'],   //来源id 订单id或提现表id(非小程序form_id)
                'from_table'=>'ox_master_bidding', //来源表名，不带ims_
                'desc'=>'订单确认，订单id:'.$uid
            );
            $basis->money_change($money,$lock_money,$uid,$parame);

            //发送模板消息
            $order_info = pdo_get('ox_master_order',['uniacid' => $_W['uniacid'], 'id' => $_GPC['orderid']]);
            $data = [
                'uid' => $uid,   //uid
                'mes_id' => 6,
                'page' => '/pages/me/index',
                'keyword' => [$order_info['o_sn'],'请前往会员中心查看',$price.'元']
            ];
            Message::Instance()->send($data);
        }
        $list = $this->orderList();
        return $this->result(0, '更新成功', $list);
    }
    /**
     * 订单列表
     */
    public function orderList(){
        global $_GPC, $_W;

        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
        ];
        if($_GPC['status'] == '1' || $_GPC['status'] == '3'){
            $params['pay_status'] = 1;
        }else{
            $params['pay_status'] = 0;
        }

        if($_GPC['status'] == 2 ){
            $params['status'] = array('2','4');
            unset($params['pay_status']);
        }elseif($_GPC['status'] == 3){
            $params['status'] = array('3','5');
            unset($params['pay_status']);
        }else{
            $params['status'] = $_GPC['status'];
        }
        $pageSize = 4;
        $pageCur = $_GPC['page'] ?: 1;
        $list = pdo_getall('ox_master_order',$params,'','',['id desc'],[$pageCur,$pageSize]);

        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
            //判断有几人参与竞标
            $sql = ' select count(id) as num from ' .tablename('ox_master_bidding').' where uniacid = '.$_W['uniacid'].' and order_id = '.$v['id'].' and status = 1';
            $num = pdo_fetch($sql);
            $list[$k]['num'] = $num['num'];
        }
        return $this->result(0, '', $list);
    }
    /**
     * 订单详情
     */
    public function orderDetail(){
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
        ];
        $detail = pdo_get('ox_master_order',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id'],'uid'=>$_GPC['uid']]);
        $repairDetail = pdo_get('ox_master_store',[ "uniacid" => $_W['uniacid'],'uid'=>$detail['repair_uid']]);
        if($repairDetail){
            $detail['repair_name'] = $repairDetail['name'];
            $detail['repair_phone'] = $repairDetail['phone'];
        }
        $imgs = pdo_getall('ox_master_image',['order_id'=>$_GPC['order_id']],['id','img_patch']);
        $appraise = pdo_get('ox_master_appraise',["uniacid" => $_W['uniacid'],'order_id'=>$_GPC['order_id']]);
        $detail['create_time'] = date('Y-m-d H:i',$detail['create_time']);
        $detail['go_time'] = date('Y-m-d H:i',$detail['go_time']);
        $detail['level'] =$appraise['level'];
        $detail['appraiseDetail'] =$appraise['detail'];
        foreach ($imgs as $k => $v){
            $imgs[$k]['img_patch'] = tomedia($v['img_patch']);
        }
        //查出竞标师傅
        $repair_data = array();
        $repair = pdo_getall('ox_master_bidding',array("uniacid" => $_W['uniacid'],"order_id" => $_GPC['order_id']));
        if(!empty($repair))foreach($repair as $k=>$v){
            $repair_data[$k] = pdo_get('ox_master_store',[ "uniacid" => $_W['uniacid'],'uid'=>$v['reapir_uid']]);
        }

        $result = [
            'detail' => $detail,
            'imgs' => $imgs,
            'prevImgs' => array_column($imgs,'img_patch'),
            'repairData' => $repair_data
        ];

        return $this->result(0, '', $result);
    }
    /**
     * 评价
     */
    public function appraise(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_master_order',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id'],'uid'=>$_GPC['uid']]);
        if($detail && $detail['appraise'] == 1){
            return $this->result(1, '该订单已评价', '');
        }
        $params = [
            "uniacid" => $_W['uniacid'],
            "uid" => $_GPC['uid'],
            "reapir_uid" => $detail['repair_uid'],
            "order_id" => $detail['id'],
            "detail" => $_GPC['detail'],
            "level" => $_GPC['level'],
            "formid" => $_GPC['formid'],
            "create_time" => $_SERVER['REQUEST_TIME'],
        ];
        pdo_insert('ox_master_appraise',$params);
        pdo_update('ox_master_order',['appraise' => 1],["uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id'],'uid'=>$_GPC['uid']]);
        return $this->result(0, '', '');
    }
}