<?php
class AdminorderdetailController extends MobileBaseController{
    public $size = 10;

    public function init()
    {
        parent::init();
        if(!$this->admin) {
            message('页面出错',$this->createMobileUrl('member'));
        }
    }

    public function index() {

        $id = intval($this->GPC['id']);
        $sql = 'SELECT 
a.username,a.mobile,o.id,o.weid,
o.ordersn,o.remark,o.memberid,o.orderprice,o.paytype,o.jifen,o.transid,o.createtime,a.province,a.city,a.district,a.address,o.status,o.parent1,o.parent2,o.parent3,o.remark,o.commision1,o.commision2,o.commision3,o.total,o.yunfei,m.nickname,m.openid,o.expresscom,o.expresssn,o.fahuotime,o.shouhuotime FROM ' . tablename('wg_fenxiao_order') . ' as o LEFT JOIN ' . tablename('wg_fenxiao_member') . ' AS m ON o.memberid=m.id LEFT JOIN ' . tablename('wg_fenxiao_member_address') . ' AS a ON o.addressid=a.id where o.id=:id and o.weid=:weid';
        $item = pdo_fetch($sql, array(':id'=>$id,':weid'=>$this->W['uniacid']));

        //订单详情

        $detail = $this->OrderDetailModel->getList([
            'order_id' => $id
        ],'*');
        $item['goodsname'] = $detail[0]['title'];
        if (empty($item)) {
            message("抱歉，订单不存在!", referer(), "error");
        }
        //发货
        if (checksubmit('confirmsend')) {
            $this->_confirmsend($id, $item);
        }
        //取消发货
        if (checksubmit('cancelsend')) {
            $this->_cancelsend($id, $item);
        }
        //订单取消
        if (checksubmit('cancelorder')) {
            $this->_cancelorder($item);
        }

        //完成订单
        if (checksubmit('doneorder')) {
            $this->_doneorder($id);
        }

        if(!empty($item['parent1']) || !empty($item['parent2']) || !empty($item['parent3']) ){
            $membernicknames = $this->MemberModel->getList(
                ['id' => [$item['parent1'],$item['parent2'],$item['parent1']]],['id','nickname']
            );
            foreach ($membernicknames as $key => $value) {
                if($item['parent1'] == $value['id']){
                    $item['parent1'] = $value['nickname'];
                }elseif ($item['parent2'] == $value['id']) {
                    $item['parent2'] = $value['nickname'];
                }elseif ($item['parent3'] == $value['id']) {
                    $item['parent3'] = $value['nickname'];
                }
            }
        }

        $item['status']= self::$ORDER_STATUS[$item['status']];
        $data['item'] = $item;
        $data['detail'] = $detail;
        $this->assign($data);
        $this->display();
    }

    private function _cancelorder($item) {
        pdo_begin();
        $update_order = pdo_update('wg_fenxiao_order', array('status' => '-1'), array('id' => $item['id']));
        if( ($item['parent1'] && $item['commision1'] > 0) ||
            ($item['parent2'] && $item['commision2'] > 0) ||
            ($item['parent3'] && $item['commision3'] > 0)
        ) {
            $update_commission = pdo_update(
                'wg_fenxiao_commission',
                array(
                    'status'       => 2,
                    'fahuoshijian' => 0,
                    'update_time'  => time(),
                ),
                array('ordersn' => $item['ordersn'])
            );
        } else {
            $update_commission = true;
        }


        if($update_order && $update_commission) {
            pdo_commit();
        }else {
            pdo_rollback();
        }

        if($update_order && $update_commission){

            //$this->editIsAgent($item['memberid'], $_W['uniacid']);
            //2.发送去掉定单通知
            if(!empty($this->module['config']['quxiaodingdan'])){
                //发给自己
                $this->site->sendQuXiaoFaHuo($this->module['config']['quxiaodingdan'],$this->W['uniacid'],$item);
            }

            //发给三级 减少积分
            $this->_quxiaoSanji($item);
            //3.取消下级人数 todo
            if($this->module['config']['xiajirenshu'] > 0){
                if($item['xiaji_one_dingdan'] == 1){
                    $jifen = $this->module['config']['xiajirenshu']+0;

                    //$this->xiajirenshu_quxiao($jifen,$item);
                }
            }
        }
        $this->ajaxReturn(0,'取消订单成功');
    }

    private function _doneorder($id) {
        pdo_update('wg_fenxiao_order', array('status' => '3'), array('id' => $id));
        $this->ajaxReturn(0,'确认收货');
    }

    private function _cancelsend($id, $item) {
        pdo_begin();
        $update_order = pdo_update(
            'wg_fenxiao_order',
            array(
                'status' => 1,
            ),
            array('id' => $id)
        );
        if( ($item['parent1'] && $item['commision1'] > 0) ||
            ($item['parent2'] && $item['commision2'] > 0) ||
            ($item['parent3'] && $item['commision3'] > 0)
        ) {
            $update_commission = pdo_update(
                'wg_fenxiao_commission',
                array(
                    'fahuoshijian' => 0,
                    'update_time'  => time(),
                ),
                array('ordersn' => $item['ordersn'])
            );
        } else {
            $update_commission = true;
        }
        if($update_order && $update_commission) {
            pdo_commit();
        }else {
            pdo_rollback();
            $this->ajaxReturn(503,'取消发货失败');
        }

        $this->ajaxReturn(0,'取消发货成功');
    }

    private function _confirmsend($id, $item) {
        if (!empty($this->GPC['isexpress']) && empty($this->GPC['expresssn'])) {
            $this->ajaxReturn(503,'请输入订单号');
        }

        pdo_begin();
        $update_order = pdo_update(
            'wg_fenxiao_order',
            array(
                'status'     => 2,
                'expresscom' => $this->GPC['expresscom'],
                'expresssn'  => $this->GPC['expresssn'],
                'fahuotime'  => time()
            ),
            array('id' => $id)
        );
        if( ($item['parent1'] && $item['commision1'] > 0) ||
            ($item['parent2'] && $item['commision2'] > 0) ||
            ($item['parent3'] && $item['commision3'] > 0)
        ) {
            $update_commission = pdo_update(
                'wg_fenxiao_commission',
                array(
                    'fahuoshijian'  => time()
                ),
                array('ordersn' => $item['ordersn'])
            );
        } else {
            $update_commission = true;
        }
        if($update_order && $update_commission) {
            pdo_commit();
        }else {
            pdo_rollback();
            $this->ajaxReturn(503,'发货失败');
        }
        //
        //发货通知给用户
        if(!empty($this->module['config']['fahuotongzhi'])){
            $dizhiinfo = $item['username'].$item['mobile'].$item['province'].$item['city'].$item['district'].$item['address'];
            $this->site->fahuotongzhi($item['openid'],$this->W['uniacid'],$this->module['config']['fahuotongzhi'],$this->GPC['expresscom'],$this->GPC['expresssn'],$item['goodsname'],$item['total'],$dizhiinfo);
        }
        $this->ajaxReturn(503,'发货成功');
    }

    public function addmarket() {
        $id     = intval($_GET['id']);
        $market = trim($_GET['market']);
        $this->OrderDetailModel->update([
            'id' => $id
        ],[
            'remark' => $market
        ]);
        $this->ajaxReturn(0,'');
    }


    private function _quxiaoSanji($order) {
        //1.改变用户 单数，钱数
        pdo_update('wg_fenxiao_member', [
            'consume -=' => $order['orderprice'],
            'order_num -=' => 1
        ],
            [
                'id' => $order['memberid'],
                'order_num >=' => 1,
                'consume >='   => $order['orderprice']
            ]
        );

        if($order['jifen']) {
            $this->addJifen($order['memberid'], -$order['jifen'], '自己取消订单' . $order['ordersn'] . '减少积分' . $order['jifen'],[],$order['weid']);
        }

        $level = $this->site->configs['config']['level'];
        if($this->site->configs['config']['xiajijifen'] > 0 && $order['jifen']) {
            $parent1 = $order['parent1'];
            $jifen1  = intval($order['jifen'] * $this->site->configs['config']['xiajijifen']/100);
            $parent2 = $order['parent2'];
            $jifen2  = intval($jifen1 * $this->site->configs['config']['xiajijifen']/100);
            $parent3 = $order['parent3'];
            $jifen3  = intval($jifen2 * $this->site->configs['config']['xiajijifen']/100);

            if($parent2 && $jifen2 > 0 && $level > 1) {
                $this->addJifen($parent2, -$jifen2, '订单:'.$order['ordersn'],[],$order['weid']);
            }
            if($parent3 && $jifen3 > 0 && $level > 2) {
                $this->addJifen($parent3, -$jifen3, '订单:'.$order['ordersn'],[],$order['weid']);
            }

            if($parent1 && $jifen1 > 0 ) {
                $this->addJifen($parent1, -$jifen1, '订单:'.$order['ordersn'],[],$order['weid']);
            }
        }
    }
}
