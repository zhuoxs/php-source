<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Web_Pay extends Web_Base
{
    /**
     * 财务列表
     * @author cheng.liu
     * @date 2019/3/8
     */
    public function payList()
    {
        global $_GPC, $_W;

        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;
        $query = '';
        if ($_GPC['p_sn']) {
            $query .= " and (pay_sn = '{$_GPC['p_sn']}' ) ";
        }
        if (isset($_GPC['status']) && $_GPC['status'] != '') {
            $query .= " and (status = {$_GPC['status']} ) ";
        }
        if ($_GPC['date']) {
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }

        $list = pdo_fetchall("select * from " . tablename('ox_master_finance') . "  where `uniacid`= {$_W['uniacid']}  {$query} order by id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}");
        $total = pdo_fetchcolumn("select count(*) from " . tablename('ox_master_finance') . "  where `uniacid`= {$_W['uniacid']} {$query}  ");

        $total = intval($total);
        foreach ($list as $k => &$v) {

            if($v['type'] == 0){
                $v['pay_type'] = '微信';
            }else{
                $v['pay_type'] = '其他';
            }

            if($v['status'] == 0){
                $status = '未支付';
            }elseif($v['status'] == 1){
                $status = '支付成功';
            }elseif($v['status'] == 2){
                $status = '已退款';
            }
            else{
                $status = '支付失败';
            }

            $v['status'] = $status;
        }
        $result = [
            'list' => $list,
            'total' => $total
        ];
        return $this->result('0', 'sufcc', $result);
    }

    /**
     * 提现列表
     * @author cheng.liu
     * @date 2019/3/8
     */
    public function tixianList()
    {
        global $_GPC, $_W;

        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;
        $query = '';
        if ($_GPC['p_sn']) {
            $query .= " and (pay_sn = '{$_GPC['p_sn']}' ) ";
        }
        if (isset($_GPC['status']) && $_GPC['status'] != '') {
            $query .= " and (status = {$_GPC['status']} ) ";
        }
        if ($_GPC['date']) {
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }

        $list = pdo_fetchall("select * from " . tablename('ox_master_take_log') . "  where `uniacid`= {$_W['uniacid']}  {$query} order by id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}");
        $total = pdo_fetchcolumn("select count(*) from " . tablename('ox_master_take_log') . "  where `uniacid`= {$_W['uniacid']} {$query}  ");
        $total = count($list);
        foreach ($list as $k => $v) {
            $uid =$v['uid'];
            $user_name_data = pdo_fetch("select nickname from ".tablename('mc_mapping_fans')." where `uniacid`= {$_W['uniacid']} and uid='{$uid}'");
            $list[$k]['nickname']=$user_name_data['nickname'];
            $list[$k]['create_time']=date("Y-m-d H:i:s" , $v['create_time']);
        }
        $result = [
            'list' => $list,
            'total' => $total
        ];
        return $this->result('0', 'sufcc', $result);

    }

    /**
     * 申请退款列表
     */
    public function refundlist()
    {
        global $_GPC, $_W;

        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;
        $query = '';
        if ($_GPC['p_sn']) {
            $query .= " and (pay_sn = '{$_GPC['p_sn']}' ) ";
        }
        if (isset($_GPC['status']) && $_GPC['status'] != '') {
            $query .= " and (status = {$_GPC['status']} ) ";
        }
        if ($_GPC['date']) {
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }

        $list = pdo_fetchall("select * from " . tablename('ox_master_refund') . "  where `uniacid`= {$_W['uniacid']}  {$query} order by id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}");
        $total = pdo_fetchcolumn("select count(*) from " . tablename('ox_master_refund') . "  where `uniacid`= {$_W['uniacid']} {$query}  ");
        $total = count($list);
        foreach ($list as $k => $v) {
            //用户名
            $uid =$v['uid'];
            $user_name_data = pdo_fetch("select nickname from ".tablename('mc_mapping_fans')." where  uid='{$uid}'");
            $list[$k]['user_name']=$user_name_data['nickname'];
            //师傅名称
            $rid = $v['rid'];
            $shifu_name_data = pdo_fetch("select * from ".tablename('ox_master_store')." where `uniacid`= {$_W['uniacid']} and uid='{$rid}'");
            $list[$k]['shifu_name']=$shifu_name_data['name'];
            $list[$k]['create_time']=date("Y-m-d H:i:s" , $v['create_time']);
        }
        $result = [
            'list' => $list,
            'total' => $total
        ];
        return $this->result('0', 'sufcc', $result);

    }

    /**
     * 单个审核提现
     */
    public function shenhetx()
    {
        $res=1;
        global $_GPC, $_W;
        $id = $_GPC['id']; //订单ID
        $type = $_GPC['type']; //1：通过 2：驳回 3：线下
        $take_info = pdo_fetch("select * from ".tablename('ox_master_take_log')." where id='{$id}' and status='0' and uniacid='{$_W['uniacid']}'");

        if(empty($take_info)){
            return $this->result('-1', '数据错误', $take_info);
        }
        if($type==1){
            //审核通过-处理
            pdo()->begin();
            //修改订单状态
            $danhao = date('ymdHis',time()).'A'.$_GPC['id'].'z';

            $res = pdo_update('ox_master_take_log',['status'=>1,'outTradeNo'=>$danhao],['uniacid'=>$_W['uniacid'],'id'=>$id]);
            if(!$res){
                pdo()->rollback();
                return $this->result('-1', '修改数据失败', $res);
            }
            //扣除用户冻结资金
            $basis= new Basis();
            $money = 0;    //变动可用资金
            $lock_money = (-1)* $take_info['money'];//变动冻结资金
            $uid = $take_info['uid'];       //用户uid
            $parame = array(
                'from_uid'=>$take_info['uid'],  //来源用户-可不填写
                'type'=>3, //类型 0接单 1完工 2提现 3到账(无实际作用,可不设置)
                'from_id'=>$id,   //来源id 订单id或提现表id(非小程序form_id)
                'from_table'=>'ox_master_take_log', //来源表名，不带ims_
                'desc'=>'提现成功扣除冻结余额',
            );
            $result = $basis->money_change($money,$lock_money,$uid,$parame,1);
            if(!$result['code']){
                pdo()->rollback();
                return $this->result(-1,  $result['msg'], $result);
            }
            //请求微信端，企业付款到零钱
            $setting = uni_setting_load('payment', $_W['uniacid']);
            $refund_setting = $setting['payment']['wechat_refund'];

            $cert = authcode($refund_setting['cert'], 'DECODE');
            $key = authcode($refund_setting['key'], 'DECODE');

            file_put_contents(ATTACHMENT_ROOT . $_W['uniacid'] . 'apiclient_cert.pem', $cert);
            file_put_contents(ATTACHMENT_ROOT . $_W['uniacid'] . 'apiclient_key.pem', $key);

            $paykey = $setting['payment']['wechat']['signkey'];

            //获取用户openid
            $fans_info = pdo_get('mc_mapping_fans',array('uid'=>$take_info['uid']));


            $params = array(
                'openid' =>$fans_info['openid'],
                'payAmount'=>$take_info['arrival_money'],
                'outTradeNo'=>$danhao,
                'apiclient_cert'=>ATTACHMENT_ROOT . $_W['uniacid'] . 'apiclient_cert.pem',
                'apiclient_key'=>ATTACHMENT_ROOT . $_W['uniacid'] . 'apiclient_key.pem',
                'money_desc'=>'余额提现',
            );
            $wx_pay = new wxpay();
            $res =  $wx_pay->wx_date($setting['payment']['wechat']['mchid'], $_W['account']['key'], $setting['payment']['wechat']['signkey'], $params);
            if(!$res['code'])
            {
                pdo()->rollback();
                $this->result(-1,'企业付款：'.$res['msg'],$res);
            }
            pdo()->commit();

            //发送模板消息
            $data = [
                'uid' => $take_info['uid'],   //uid
                'mes_id' => 7,
                'page' => '/pages/me/index',
                'keyword' => [$take_info['money'],'已通过','到账会有延迟，请注意查收']
            ];
            $result = Message::Instance()->send($data);

            return $this->result(0, '提现处理成功', $res);

        }else if ($type==2){
            //审核驳回-处理
            pdo()->begin();
            //修改订单状态
            $res = pdo_update('ox_master_take_log',['status'=>2,'order_describe'=>$_GPC['order_describe']],['uniacid'=>$_W['uniacid'],'id'=>$id]);
            if(!$res){
                pdo()->rollback();
                return $this->result('-1', '修改数据失败', $res);
            }
            //扣除用户冻结资金
            $basis= new Basis();
            $money = $take_info['money'];    //变动可用资金
            $lock_money = (-1)* $take_info['money'];//变动冻结资金
            $uid = $take_info['uid'];       //用户uid
            $parame = array(
                'from_uid'=>$take_info['uid'],  //来源用户-可不填写
                'type'=>4, //类型 0接单 1完工 2提现 3到账(无实际作用,可不设置)
                'from_id'=>$id,   //来源id 订单id或提现表id(非小程序form_id)
                'from_table'=>'ox_master_take_log', //来源表名，不带ims_
                'desc'=>'提现驳回，退回余额',
            );
            $result = $basis->money_change($money,$lock_money,$uid,$parame,1);
            if(!$result['code']){
                pdo()->rollback();
                return $this->result(-1,  $result['msg'], $result);
            }
            pdo()->commit();

            //发送模板消息
            $data = [
                'uid' => $take_info['uid'],   //uid
                'mes_id' => 7,
                'page' => '/pages/me/index',
                'keyword' => [$take_info['money'],'已拒绝',$_GPC['order_describe']]
            ];
            $result = Message::Instance()->send($data);
            return $this->result(0, '驳回处理成功', $result);
        }else{
            //审核通过-线下处理
            pdo()->begin();
            //修改订单状态
            $danhao = date('ymdHis',time()).'A'.$_GPC['id'].'z';

            $res = pdo_update('ox_master_take_log',['status'=>1,'outTradeNo'=>$danhao],['uniacid'=>$_W['uniacid'],'id'=>$id]);
            if(!$res){
                pdo()->rollback();
                return $this->result('-1', '修改数据失败', $res);
            }
            //扣除用户冻结资金
            $basis= new Basis();
            $money = 0;    //变动可用资金
            $lock_money = (-1)* $take_info['money'];//变动冻结资金
            $uid = $take_info['uid'];       //用户uid
            $parame = array(
                'from_uid'=>$take_info['uid'],  //来源用户-可不填写
                'type'=>3, //类型 0接单 1完工 2提现 3到账(无实际作用,可不设置)
                'from_id'=>$id,   //来源id 订单id或提现表id(非小程序form_id)
                'from_table'=>'ox_master_take_log', //来源表名，不带ims_
                'desc'=>'提现成功扣除冻结余额',
            );
            $result = $basis->money_change($money,$lock_money,$uid,$parame,1);
            if(!$result['code']){
                pdo()->rollback();
                return $this->result(-1,  $result['msg'], $result);
            }else{
                pdo()->commit();
                return $this->result(0, '提现处理成功', $res);
            }
        }
    }




    public function allShenhetx()
    {
        global $_GPC, $_W;
        echo "<pre>";
        print_r($_GPC["ids"]);
        die();



    }







}

