<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\OrdersModel;


class OrdersController extends AdminBaseController{

    /**
     * 列表
     */
    public function index() {
        $model_order = new OrdersModel();
        $pay_status = C('PAY_STATUS');
        $status_all = C('STATUS_ALL');

        $map = $this->_search();

        /*'0' => '取消订单',
        '1' => '待支付',
        '2' => '待发货',
        '3' => '已发货',
        '4' => '已完成'*/
        $stat = I('get.stat');
        if( $stat == 0 && $stat != '' ){
            $map['status'] = 0;
        }
        if( $stat == 1 ){
            $map['status'] = 1;
            $map['pay_status'] = 0;
        }
        if( $stat == 2 ){
            $map['status'] = 1;
            $map['pay_status'] = 1;
            $map['shipping_status'] = 0;
        }
        if( $stat == 3 ){
            $map['status'] = 1;
            $map['pay_status'] = 1;
            $map['shipping_status'] = 1;
        }
        if( $stat == 4 ){
            $map['status'] = 1;
            $map['pay_status'] = 1;
            $map['shipping_status'] = 2;
        }

        if( I('get.order_no') != '' ) $map['order_no'] = array('like','%'.I('get.order_no').'%');

        //列表数据
        $list = $this->_list ('orders', $map );
        foreach( $list as &$_list ) {
            $_list['nickname'] = M('member')->where(array('id'=>$_list['member_id']))->getField('nickname');
            $_list['pay_status_text'] = $pay_status[$_list['pay_status']];
            $_list['status_text'] = $model_order->get_status_text($_list['status'], $_list['pay_status']);
        }
        $this->assign('list',$list);
        $this->assign('get',$_GET);
        $this->assign('status_all',$status_all);

        $this->assign('shipping_status',array('0'=>'未发货','1'=>'发货'));

        //物流方式
        $shipping_list = C('SHIPPING');
        $this->assign('shipping_list',$shipping_list);

        $this->display();
    }

    public function show()
    {
        $model_order = new OrdersModel();

        $id = I('get.id');
        $data = M('orders')->find($id);
        if( $data['pay_status'] == 1 && $data['payment_type'] != 'balance' ) {
            $pay_data = M('pay')->where(array('order_no'=>$data['order_no']))->find();
            if( !$pay_data ) {
                $pay_data['create_time'] = $data['pay_time'];
                $pay_data['price'] = $data['online_pay_price'];
                $pay_data['platform_no'] = $data['platform_no'];
            }
            $this->assign('pay_data',$pay_data);
        }
        $data['goods_thumb'] = M('goods')->where(array('id'=>$data['goods_id']))->getField('thumb');
        $data['status_text'] = $model_order->get_status_text($data['status'], $data['pay_status']);
        $this->assign('data',$data);

        $this->assign('shipping_status',array('0'=>'未发货','1'=>'发货'));
        //物流方式
        $shipping_list = C('SHIPPING');
        $this->assign('shipping_list',$shipping_list);

        $this->display();
    }

    /**
     * 更新物流状态
     */
    public function shipping_status()
    {
        $id = I('post.id');
        $shipping_status = I('post.shipping_status');
        $shipping_name = I('post.shipping_name');
        $shipping_no = I('post.shipping_no');

        $data['shipping_status'] = $shipping_status;
        $data['shipping_time'] = time();
        $data['shipping_name'] = $shipping_name;
        $data['shipping_no'] = $shipping_no;
        $data['id'] = $id;
        if( $shipping_status == 1 ) {
            if( $shipping_no == '' ) {
                $this->error ('请完善物流信息');
            }
        }
        $result = M('orders')->save($data);
        if( $result ) {
            $this->success('操作成功');
        } else {
            $this->error ('操作失败!');
        }
    }
}