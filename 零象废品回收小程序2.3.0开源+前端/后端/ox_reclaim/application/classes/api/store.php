<?php

if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Api_Store extends WeModuleWxapp
{
    public function index(){
        global $_GPC, $_W;
        $params = [
            'uid' => $_GPC['uid'],
        ];
        $user = pdo_get('ox_reclaim_member',$params);
        return $this->result(0, '', array('user'=>$user));
    }
    /*
     * 订单列表
     */
    public function orderList(){
        global $_GPC, $_W;
        $where = [
            "uniacid" => $_W['uniacid'],
            "cycle"=>0
        ];
        if($_GPC['status'] == '3'){
            $where['status >'] = 1;
        }
        elseif ($_GPC['status'] != '9'){
            $where['status'] = $_GPC['status'];
        }

        if($_GPC['status'] == '1'){
            $where['admin_uid'] = $_GPC['uid'];
        }

        $pageSize = 8;
        $pageCur = $_GPC['page'] ?: 1;
        $list = pdo_getall('ox_reclaim_order',$where,'','',['id desc'],[$pageCur,$pageSize]);

        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $list[$k]['end_time'] = date('Y-m-d H:i',$v['end_time']);
            $list[$k]['go_time'] = date('Y-m-d H:i',$v['go_time']);
            if(!empty($v['admin_uid'])){
                $member = pdo_get('ox_reclaim_member',array('uid'=>$v['admin_uid']));
                $list[$k]['admin_name'] = $member['name']==''? $member['nickname'] : $member['name'];
            }else{
                $list[$k]['admin_name'] = '未接单';
            }
        }
        return $this->result(0, '', ['list'=>$list]);
    }

    /**
     * 订单详情
     */
    public function orderDetail(){
        global $_GPC, $_W;

        $detail = pdo_get('ox_reclaim_order',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id']]);
        $imgs = pdo_getall('ox_reclaim_image',['order_id'=>$_GPC['order_id'],'type'=>1],['id','img']);
        $detail['create_time'] = date('Y-m-d H:i',$detail['create_time']);
        $detail['go_time'] = date('Y-m-d H:i',$detail['go_time']);
        foreach ($imgs as $k => $v){
            $imgs[$k]['img'] = tomedia($v['img']);
        }
        if(!empty($detail['admin_uid'])){
            $member = pdo_get('ox_reclaim_member',array('uid'=>$detail['admin_uid']));
            $detail['admin_name'] = $member['name']==''? $member['nickname'] : $member['name'];
        }else{
            $detail['admin_name'] = '未接单';
        }
        $type = pdo_getall('ox_reclaim_type',array("uniacid" => $_W['uniacid']));
        $result = [
            'detail' => $detail,
            'imgs' => $imgs,
            'prevImgs' => array_column($imgs,'img'),
            'type'=>$type
        ];
        return $this->result(0, '', $result);
    }
    /*
     * 修改订单类型
     */
    public function order_type(){
        global $_GPC, $_W;
        $type_info = pdo_get('ox_reclaim_type',array("uniacid" => $_W['uniacid'],'id'=>$_GPC['type']));
        $res = pdo_update('ox_reclaim_order',['type_name'=>$type_info['name']],[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id']]);
        if($res){
            return $this->result(0, '', $type_info);
        }else{
            return $this->result(200, $result['msg'], $detail);
        }
    }

    /*
     * 订单支付
     */
    public function order_pay_one(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_reclaim_order',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id']]);
        if(empty($detail) || $detail['status'] !='1' ){
            return $this->result(1, '数据错误', $detail);
        }
        if($_GPC['amount']<0 || empty($_GPC['amount'])){
            return $this->result(1, '支付金额错误', $detail);
        }
        //修改订单状态
        pdo()->begin();
        $data = array(
            'status'=>3,
            'end_time'=>time(),
            'amount'=>$_GPC['amount'],
            'admin_uid'=>$_GPC['uid']
        );
        $res = pdo_update('ox_reclaim_order',$data,[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id']]);
        if(!$res){
            pdo()->rollback();
            return $this->result(1, '订单修改失败', $detail);
        }

        //处理线下
        $pay_log = array(
            'order_id'=>$_GPC['order_id'],
            'pay_uid'=>$_GPC['uid'],
            'uniacid'=>$_W['uniacid'],
            'o_sn'=>$detail['o_sn'],
            'account'=>$_GPC['amount'],
            'integral'=>floor($_GPC['amount']),
            'create_time'=>time(),
            'pay_type'=>0
        );
        if($_GPC['xianxia']==1){
            //线下
            $money = 0;
            $pay_log['pay_type'] = 1;
        }else{
            $money = $_GPC['amount'];
        }
        //插入记录
        $res = pdo_insert('ox_reclaim_order_pay',$pay_log);
        if(!$res){
            pdo()->rollback();
            return $this->result(1, '添加记录失败', $detail);
        }

        $ceshi = new Basis();
        //$money = $_GPC['amount'];    //变动可用资金
        $uid = $detail['uid'];       //用户uid
        $parame = array(
            'from_uid'=>$_GPC['uid'],  //来源用户-可不填写
            'type'=>1, //类型 0接单 1完工 2提现 3提现驳回
            'from_id'=>$_GPC['order_id'],   //来源id 订单id或提现表id(非小程序form_id)
            'from_table'=>'ox_reclaim_order', //来源表名，不带ims_
            'desc'=>'订单完成增加余额',
            'integral'=>floor($_GPC['amount'])
        );
        $result = $ceshi->money_change($money,$uid,$parame,1);
        if(!$result['code']){
            pdo()->rollback();
            return $this->result(200, $result['msg'], $detail);
        }


        //扣除接单员余额
        if($_GPC['xianxia']!=1){
            $money = (-1)*$_GPC['amount'];    //变动可用资金
            $uid = $_GPC['uid'];       //用户uid
            $parame = array(
                'from_uid'=>$_GPC['uid'],  //来源用户-可不填写
                'type'=>6, //类型 0接单 1完工 2提现 3提现驳回
                'from_id'=>$_GPC['order_id'],   //来源id 订单id或提现表id(非小程序form_id)
                'from_table'=>'ox_reclaim_order', //来源表名，不带ims_
                'desc'=>'支付订单完成扣除余额',
                'integral'=>0
            );
            $result = $ceshi->money_change($money,$uid,$parame,1);
        }else{
            $result['code'] = true;
        }

        if($result['code']){
            pdo()->commit();

            //发送模板消息
            //接单成功提醒 'type'=>4
            $template_info = pdo_get('ox_reclaim_uniform_template',array('uniacid'=>$_W['uniacid'],'type'=>5));
            $data = [
                'uid' => $detail['uid'],   //uid
                'mes_id' => 5,
                'page' => '/pages/order/index',
                'keyword' => [$_GPC['amount'].'元','已完成',$template_info['remark']]
            ];
            $result = Messageapp::Instance()->send($data);

            return $this->result(0, '', $detail);
        }else{
            pdo()->rollback();
            return $this->result(200, $result['msg'], $detail);
        }

    }
    /*
     * 接单提交
     */
    public function order_jiedan_one(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_reclaim_order',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id']]);
        if(empty($detail) || $detail['status'] !='0' ){
            return $this->result(1, '数据错误', $detail);
        }
        $data = array(
            'status'=>1,
            'admin_uid'=>$_GPC['uid']
        );
        $res = pdo_update('ox_reclaim_order',$data,[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id']]);
        if(!$res){
            return $this->result(1, '订单修改失败', $detail);
        }else{

            //发送模板消息
            //查询基础数据 -- 接单人
            $member = pdo_get('ox_reclaim_member',array('uid'=>$_GPC['uid']));
            $member['admin_name'] = $member['name']==''? $member['nickname'] : $member['name'];
            //接单成功提醒 'type'=>4
            $template_info = pdo_get('ox_reclaim_uniform_template',array('uniacid'=>$_W['uniacid'],'type'=>4));
            $data = [
                'uid' => $detail['uid'],   //uid
                'mes_id' => 4,
                'page' => '/pages/order/index',
                'keyword' => [$member['admin_name'],$member['phone'],$template_info['remark']]
            ];
            $result = Messageapp::Instance()->send($data);

            return $this->result(0, '', $detail);
        }
    }
    /*
     * 订单支付_周期
     */
    public function order_pay(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_reclaim_order',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id']]);
        if(empty($detail) || $detail['cycle'] =='0' ){
            return $this->result(1, '数据错误', $detail);
        }
        if($_GPC['amount']<0 || empty($_GPC['amount'])){
            return $this->result(1, '支付金额错误', $detail);
        }
        //修改订单状态
        pdo()->begin();
        $data = array(
            "uniacid" => $_W['uniacid'],
            'uid'=>$detail['uid'],
            'order_id'=>$detail['id'],
            'account'=>$_GPC['amount'],
            'create_time'=>time(),
            'admin_uid'=>$_GPC['uid']
        );
        $res = pdo_insert('ox_reclaim_cycle',$data);
        $pay_id = pdo_insertid();
        if(!$res){
            pdo()->rollback();
            return $this->result(1, '订单修改失败', $detail);
        }
        pdo_update('ox_reclaim_order',['last_time' => $_SERVER['REQUEST_TIME']],[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id']]);

        //处理线下
        $pay_log = array(
            'order_id'=>$_GPC['order_id'],
            'pay_uid'=>$_GPC['uid'],
            'uniacid'=>$_W['uniacid'],
            'o_sn'=>$detail['o_sn'],
            'account'=>$_GPC['amount'],
            'integral'=>floor($_GPC['amount']),
            'create_time'=>time(),
            'pay_type'=>0
        );
        if($_GPC['xianxia']==1){
            //线下
            $money = 0;
            $pay_log['pay_type'] = 1;
        }else{
            $money = $_GPC['amount'];
        }
        //插入记录
        $res = pdo_insert('ox_reclaim_order_pay',$pay_log);
        if(!$res){
            pdo()->rollback();
            return $this->result(1, '添加记录失败', $detail);
        }

        $ceshi = new Basis();
        //$money = $_GPC['amount'];    //变动可用资金
        $uid = $detail['uid'];       //用户uid
        $parame = array(
            'from_uid'=>$_GPC['uid'],  //来源用户-可不填写
            'type'=>1, //类型 0接单 1完工 2提现 3提现驳回
            'from_id'=>$pay_id,   //来源id 订单id或提现表id(非小程序form_id)
            'from_table'=>'ox_reclaim_cycle', //来源表名，不带ims_
            'desc'=>'周期订单完成增加余额',
            'integral'=>floor($_GPC['amount'])
        );
        $result = $ceshi->money_change($money,$uid,$parame,1);
        if(!$result['code']){
            pdo()->rollback();
            return $this->result(200, $result['msg'], $detail);
        }

        //扣除接单员余额
        if($_GPC['xianxia']!=1){
            $money = (-1)*$_GPC['amount'];    //变动可用资金
            $uid = $_GPC['uid'];       //用户uid
            $parame = array(
                'from_uid'=>$_GPC['uid'],  //来源用户-可不填写
                'type'=>6, //类型 0接单 1完工 2提现 3提现驳回
                'from_id'=>$_GPC['order_id'],   //来源id 订单id或提现表id(非小程序form_id)
                'from_table'=>'ox_reclaim_order', //来源表名，不带ims_
                'desc'=>'支付订单完成扣除余额',
                'integral'=>0
            );
            $result = $ceshi->money_change($money,$uid,$parame,1);
        }else{
            $result['code'] = true;
        }

        if($result['code']){
            pdo()->commit();
            return $this->result(0, '', $detail);
        }else{
            pdo()->rollback();
            return $this->result(200, $result['msg'], $detail);
        }

    }

    /*
     * 提现列表
     */
    public function takeList(){
        global $_GPC, $_W;
        $where = [
            "uniacid" => $_W['uniacid'],
        ];
        if($_GPC['status'] != '9'){
            $where['status'] = $_GPC['status'];
        }

        $pageSize = 8;
        $pageCur = $_GPC['page'] ?: 1;
        $list = pdo_getall('ox_reclaim_take_log',$where,'','',['status asc'],[$pageCur,$pageSize]);

        foreach ($list as $k => $v){
            $user_info = pdo_get('ox_reclaim_member',array('uid'=>$v['uid']));
            $list[$k]['avatar'] = $user_info['avatar'];
            $list[$k]['nickname'] = $user_info['nickname'];
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
        }
        return $this->result(0, '', ['list'=>$list]);
    }

    /**
     * 提现详情
     */
    public function takeDetail(){
        global $_GPC, $_W;

        $detail = pdo_get('ox_reclaim_take_log',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['id']]);
        $user = pdo_get('ox_reclaim_member',['uid'=>$detail['uid']]);
        $detail['create_time'] = date('Y-m-d H:i',$detail['create_time']);

        $result = [
            'detail' => $detail,
            'user' => $user,
        ];
        return $this->result(0, '', $result);
    }
    /*
     * 提现驳回
     */
    public function take_bohui(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_reclaim_take_log',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['id']]);
        if(empty($detail) || $detail['status'] !='0' ){
            return $this->result(1, '数据错误', $detail);
        }
        if(empty($_GPC['describe'])){
            return $this->result(1, '请输入驳回原因', $detail);
        }
        //修改订单状态
        pdo()->begin();
        $data = array(
            'status'=>2,
            'describe'=>$_GPC['describe'],
            'admin_uid'=>$_GPC['uid']
        );
        $res = pdo_update('ox_reclaim_take_log',$data,[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['id']]);
        if(!$res){
            return $this->result(1, '驳回失败', $detail);
        }
        $ceshi = new Basis();
        $money = $detail['money'];    //变动可用资金
        $uid = $detail['uid'];       //用户uid
        $parame = array(
            'from_uid'=>$_GPC['uid'],  //来源用户-可不填写
            'type'=>3, //类型 0接单 1完工 2提现 3提现驳回
            'from_id'=>$detail['id'],   //来源id 订单id或提现表id(非小程序form_id)
            'from_table'=>'ox_reclaim_take_log', //来源表名，不带ims_
            'desc'=>'提现驳回，返还余额'
        );
        $result = $ceshi->money_change($money,$uid,$parame,1);
        if($result['code']){
            pdo()->commit();
            //发送模板消息
            $data = [
                'uid' => $detail['uid'],   //uid
                'mes_id' => 3,
                'page' => '/pages/me/index',
                'keyword' => ['未通过',$detail['money'],date('Y-m-d H:i',$detail['create_time']),$_GPC['describe']]
            ];
            $result = Messageapp::Instance()->send($data);
            return $this->result(0, '', $detail);
        }else{
            pdo()->rollback();
            return $this->result(200, $result['msg'], $detail);
        }

    }
    /*
     * 提现通过
     */
    public function take_tongguo(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_reclaim_take_log',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['id']]);
        if(empty($detail) || $detail['status'] !='0' ){
            return $this->result(1, '数据错误', $detail);
        }

        //修改订单状态
        pdo()->begin();
        $data = array(
            'status'=>1,
            'admin_uid'=>$_GPC['uid']
        );
        $res = pdo_update('ox_reclaim_take_log',$data,[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['id']]);
        if(!$res){
            return $this->result(1, '修改失败', $detail);
        }
        if($detail['type']==1){
            //支付宝提现
            pdo()->commit();

            //发送模板消息
            $data = [
                'uid' => $detail['uid'],   //uid
                'mes_id' => 3,
                'page' => '/pages/me/index',
                'keyword' => ['已通过',$detail['money'],date('Y-m-d H:i',$detail['create_time']),'到账会有延迟，以实际到账时间为准']
            ];
            $result = Messageapp::Instance()->send($data);

            return $this->result(0, '', $detail);
        }else{
            //请求微信端，企业付款到零钱
            $setting = uni_setting_load('payment', $_W['uniacid']);
            $refund_setting = $setting['payment']['wechat_refund'];

            $cert = authcode($refund_setting['cert'], 'DECODE');
            $key = authcode($refund_setting['key'], 'DECODE');

            file_put_contents(ATTACHMENT_ROOT . $_W['uniacid'] . 'apiclient_cert.pem', $cert);
            file_put_contents(ATTACHMENT_ROOT . $_W['uniacid'] . 'apiclient_key.pem', $key);

            $paykey = $setting['payment']['wechat']['signkey'];

            //获取用户openid
            $fans_info = pdo_get('mc_mapping_fans',array('uid'=>$detail['uid']));


            $params = array(
                'openid' =>$fans_info['openid'],
                'payAmount'=>$detail['money'],
                'outTradeNo'=>time().'tk'.$detail['id'],
                'apiclient_cert'=>ATTACHMENT_ROOT . $_W['uniacid'] . 'apiclient_cert.pem',
                'apiclient_key'=>ATTACHMENT_ROOT . $_W['uniacid'] . 'apiclient_key.pem',
                'money_desc'=>'余额提现',
            );
            $wx_pay = new wxpay();
            $res =  $wx_pay->wx_date($setting['payment']['wechat']['mchid'], $_W['account']['key'], $setting['payment']['wechat']['signkey'], $params);
            if(!$res['code'])
            {
                pdo()->rollback();
                return $this->result(200, '企业付款：'.$res['msg'], $detail);
            }else{
                pdo()->commit();
                //发送模板消息
                $data = [
                    'uid' => $detail['uid'],   //uid
                    'mes_id' => 3,
                    'page' => '/pages/me/index',
                    'keyword' => ['已通过',$detail['money'],date('Y-m-d H:i',$detail['create_time']),'到账会有延迟，以实际到账时间为准']
                ];
                $result = Messageapp::Instance()->send($data);

                return $this->result(0, '', $detail);
            }
        }

    }

}