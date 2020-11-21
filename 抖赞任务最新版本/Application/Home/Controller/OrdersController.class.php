<?php
namespace Home\Controller;

use Common\Controller\HomeBaseController;

class ContributionController extends HomeBaseController{

    public function pay() {

        $post_id = intval(I('post_id'));
        if( $post_id > 0 ) {
            $pay_type = 1;//购买产品
        } else {
            $pay_type = 0;//充值
        }

        $price = I('price');
        if( !is_numeric($price) || !($price > 0) ) {
            $this->error('价格必须为数字，且大于0');
        }
        $price = $price * 100; //单位为分

        #充值记录
        $data = array();
        $order_no = $this->create_order_no();
        $data['order_no'] = $order_no;
        $data['post_id'] = $post_id;
        $data['pay_type'] = $pay_type;
        $data['uid'] = $this->user_id;
        $data['price'] = $price;
        $data['create_time'] = time();
        $data['is_pay'] = 0;
        $data['payment_id'] = 1;
        $insert_id = M('orders')->add($data);
        if( $insert_id ) {
            //跳转到微信支付
            header("Location: /wxpay/payapi/jsapi.php?out_trade_no={$order_no}&openid=".session('member.openid'));
            exit();
            //$this->redirect('Api/Weixinpay/pay',array('out_trade_no'=>$order_no));
        } else {
            $this->error('操作失败');
        }



        /*if( IS_POST ) {
            $chapter_id = intval(I('post.chapter_id'));
            $d = M('chapter')->field('id,post_id')->where(array('id'=>$chapter_id))->find();
            if( $d ) {
                $post_id = $d['post_id'];
            } else {
                $post_id = intval(I('post.post_id'));
            }
            if( !($post_id > 0) ) {
                $this->error('参数错误');
            }

            if( I('post.price') != '' ) {
                $price = I('post.price');
            } else {
                $price = I('post.sel_price');
            }
            if( !is_numeric($price) || !($price > 0) ) {
                $this->error('价格必须为数字，且大于0');
            }
            $price = $price * 100; //单位为分

            #记录捐款信息
            $data = array();
            $order_no = $this->create_order_no();
            $data['order_no'] = $order_no;
            $data['post_id'] = $post_id;
            $data['chapter_id'] = $chapter_id;
            $data['uid'] = $this->user_id;
            $data['msg'] = strip_tags(I('msg'));
            $data['price'] = $price;
            $data['create_time'] = time();
            $data['is_pay'] = 0;
            $data['payment_id'] = 1;
            $insert_id = M('contribution')->add($data);
            if( $insert_id ) {
                //跳转到微信支付
                header("Location: http://rucedupin.szwangyesheji.com/wxpay/payapi/jsapi.php?out_trade_no={$order_no}&openid=".session('member.openid'));
                exit();
                //$this->redirect('Api/Weixinpay/pay',array('out_trade_no'=>$order_no));
            } else {
                $this->error('操作失败');
            }
        } else {
            $chapter_id = intval(I('get.chapter_id'));
            $d = M('chapter')->field('id,post_id')->where(array('id'=>$chapter_id))->find();
            if( $d ) {
                $post_id = intval($d['post_id']);
            } else {
                $post_id = intval(I('get.post_id'));
            }
            if( !($post_id > 0) ) {
                $this->error('参数错误');
            }
            $data = M('posts')->find($post_id);
            $this->assign('data', $data);
            $this->assign('chapter_id', $chapter_id);
            $this->display();
        }*/
    }

    public function show_pay()
    {
        if( IS_POST ) {
            $chapter_id = intval(I('post.chapter_id'));
            $d = M('chapter')->field('id,post_id')->where(array('id'=>$chapter_id))->find();
            if( $d ) {
                $post_id = $d['post_id'];
            } else {
                $post_id = intval(I('post.post_id'));
            }
            if( !($post_id > 0) ) {
                $this->error('参数错误');
            }

            $price = I('post.price');
            if( !is_numeric($price) || !($price > 0) ) {
                $this->error('价格必须为数字，且大于0');
            }

            $this->redirect('pay',array('post_id'=>$post_id,'chapter_id'=>$chapter_id,'price'=>$price));
        } else {
            $chapter_id = intval(I('get.chapter_id'));
            $d = M('chapter')->field('id,post_id,name')->where(array('id'=>$chapter_id))->find();
            if( $d ) {
                $post_id = intval($d['post_id']);
            } else {
                $post_id = intval(I('get.post_id'));
            }
            if( !($post_id > 0) ) {
                $this->error('参数错误');
            }
            $data = M('posts')->find($post_id);
            $this->assign('data', $data);
            $this->assign('chapter_id', $chapter_id);
            $this->assign('chapter_name', $d['name']);
            $price = $data['price'];
            if( empty($price) ) $price = "2,5";
            $price = explode(',', $price);
            $this->assign('price', $price);
            $this->display();
        }
    }

    //生成订单号
    private function create_order_no() {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2016] . $this->user_id . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }
}

