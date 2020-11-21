<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Web_Take extends Web_Base
{
    /**
     * 提现列表
     */
    public function takeList(){
        global $_W,$_GPC;

        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $list=pdo_fetchall("select ortl.*,orm.`nickname`,orm.`money` as balance from ".tablename('ox_reclaim_take_log')." ortl LEFT JOIN ".tablename('ox_reclaim_member')." orm ON ortl.uid = orm.uid where ortl.`uniacid`= {$_W['uniacid']}  order by ortl.status asc,ortl.id asc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_take_log')."  where `uniacid`= {$_W['uniacid']}   ");

        $aut_state = array('0'=>'未审核','1'=>'已通过','2'=>'已驳回');
        $aut_color = array('0'=>'#FFD39B','1'=>'#5cc691','2'=>'#e55957');
        $type_name = ['1'=>'支付宝','2'=>'微信'];
//        foreach ($list as &$v){
//            $user_info = pdo_get('ox_reclaim_member',['uid'=>$v['uid']]);
//            $v['shengyu'] = $user_info['money'];
//        }
        unset($v);
        $pager = pagination2($total, $pindex, $psize);
        $i=($pindex - 1) * $psize+1;

        include $this->template();
    }

    /*
     * 提现处理
     */
    public function describe(){
        global $_W,$_GPC;

        $id= $_GPC['id'];
        if($_W['ispost'])
        {
            $detail = pdo_get('ox_reclaim_take_log',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['id']]);
            if(empty($detail) || $detail['status'] !='0' ){
                $this->success('数据错误','',2);
            }

            //修改订单状态
            pdo()->begin();
            $data['status'] = 1;
            $res = pdo_update('ox_reclaim_take_log',$data,['uniacid'=>$_W['uniacid'],'id'=>$id]);

            if(!$res){
                $this->success('修改失败','',2);
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

                $this->success('修改成功','',2);
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
                    $this->success('企业付款：'.$res['msg'],'',2);
                }else{
                    //发送模板消息
                    pdo()->commit();
                    $data = [
                        'uid' => $detail['uid'],   //uid
                        'mes_id' => 3,
                        'page' => '/pages/me/index',
                        'keyword' => ['已通过',$detail['money'],date('Y-m-d H:i',$detail['create_time']),'到账会有延迟，以实际到账时间为准']
                    ];
                    $result = Messageapp::Instance()->send($data);
                    $this->success('修改成功','',2);
                }
            }

        }
    }
    /*
     * 提现处理--驳回
     */
    public function bohui(){
        global $_W,$_GPC;

        $id= $_GPC['id'];
        if($_W['ispost'])
        {
            $detail = pdo_get('ox_reclaim_take_log',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['id']]);
            if(empty($detail) || $detail['status'] !='0' ){
                $this->result(0,'数据错误');
            }
            if(empty($_GPC['describe'])){
                $this->result(0,'请输入驳回原因');
            }
            //修改订单状态
            pdo()->begin();
            $data = array(
                'status'=>2,
                'describe'=>$_GPC['describe'],
            );
            $res = pdo_update('ox_reclaim_take_log',$data,[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['id']]);
            if(!$res){
                $this->result(0,'驳回失败');
            }
            $ceshi = new Basis();
            $money = $detail['money'];    //变动可用资金
            $uid = $detail['uid'];       //用户uid
            $parame = array(
                'from_uid'=>0,  //来源用户-可不填写
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

                $this->result(1,'驳回成功');
            }else{
                pdo()->rollback();
                $this->result(0,$result['msg']);
            }
        }
    }
}

?>