<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\MemberModel;
use Common\Model\NoticeModel;
use Common\Model\PayModel;

class PayController extends AdminBaseController{

    public function index() {
        $payment_type = array(
            'wxpay' => '微信',
            'alipay' => '支付宝',
            'admin' => '线下充值',
        );

        $start_date = I('get.start_date');
        $end_date = I('get.end_date');
        $map = array();

        if( I('get.payment_type')!='' ) $map['a.payment_type'] = I('get.payment_type');
        if( I('get.platform_no')!='' ) $map['a.platform_no'] = I('get.platform_no');

        //搜索时间
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( a.create_time >= {$start_date} and a.create_time < {$end_date} )";
        }

        $model = M('pay');
        $count = $model->alias('a')->where($map)->count();
        $page = sp_get_page($count, 20);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;

        //总金额
        $total_price = $model->alias('a')->where($map)->sum('price');
        $this->assign('total_price',$total_price);

        $list = $model->alias('a')->join(C('DB_PREFIX').'member as c on a.member_id = c.id','left')
            ->where($map)
            ->field('a.*,c.username,c.nickname')
            ->order('a.id desc')->limit("$firstRow , $listRows")
            ->select();
        foreach( $list as &$_list ) {
            $_list['payment_type_text'] = $payment_type[$_list['payment_type']];
        }
        $this->assign('list',$list);
        $this->assign("Page", $page->show());
        $this->assign('payment_type',$payment_type);
        $this->assign('get',$_GET);
        $this->display();
    }

    //会员财务流水
    public function price_log() {
        $type_text = array(
            '1' => '任务奖励',
            '2' => '下级提成',
            '3' => '推荐提成',
            '98' => '管理员后台充值',
            '99' => '提现失败退回余额',
            '100' => '申请提现',
            '101' => '管理员后台减额',
        );
        $type = I('get.type');
        $member_id = I('get.member_id');
        $start_date = I('get.start_date');
        $end_date = I('get.end_date');

        $map = array();

        if( $type != '' ) $map['a.type'] = $type;
        if( $member_id != '' ) $map['a.member_id'] = $member_id;

        //搜索时间
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( a.create_time >= {$start_date} and a.create_time < {$end_date} )";
        }

        $model = M('member_price_log')->alias('a');
        $count = $model->where($map)->count();
        $page = sp_get_page($count, 20);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;

        $list = M('member_price_log')->alias('a')->join(C('DB_PREFIX').'member as c on a.member_id = c.id','left')
            ->where($map)
            ->field('a.*,c.username,c.nickname,c.phone,c.bank_name,c.bank_user,c.bank_number')
            ->order('a.id desc')->limit("$firstRow , $listRows")
            ->select();
        foreach( $list as &$_list ) {
            $_list['type_text'] = $type_text[$_list['type']];
        }
        $this->assign('list',$list);
        $this->assign("Page", $page->show());
        $this->assign('type_text',$type_text);
        $this->assign('get',$_GET);

        //总佣金
        if( empty($type) ) {
            $map['a.type'] = array('lt',10);
        }
        $total_price = M('member_price_log')->alias('a')->where($map)->sum('price');
        $this->assign('total_price',$total_price);

        $this->display();
    }

    /**
     * 提现
     */
    public function tixian() {
        $TIXIAN_STATUS = C('TIXIAN_STATUS');

        $status = I('get.status');
        $start_date = I('get.start_date');
        $end_date = I('get.end_date');

        $map = array();

        if( $status != '' ) $map['a.status'] = $status;

        //搜索时间
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( a.create_time >= {$start_date} and a.create_time < {$end_date} )";
        }

        $model = M('member_tixian')->alias('a');
        $count = $model->where($map)->count();
        $page = sp_get_page($count, 20);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;

        //总金额
        $total['price'] = M('member_tixian')->alias('a')->where($map)->sum('price');
        $total['actual_price'] = M('member_tixian')->alias('a')->where($map)->sum('actual_price');
        $total['charge_price'] = $total['price'] - $total['actual_price'];
        $this->assign('total',$total);

        $list = M('member_tixian')->alias('a')->join(C('DB_PREFIX').'member as c on a.member_id = c.id','left')
            ->where($map)
            ->field('a.*,c.nickname,c.phone,c.bank_name,c.bank_user,c.bank_number')
            ->order('a.id desc')->limit("$firstRow , $listRows")
            ->select();
        foreach( $list as &$_list ) {
            $_list['status_text'] = $TIXIAN_STATUS[$_list['status']];
            /*$price = abs($_list['price']);
            $_list['price'] = $price;
            $_list['charge'] = sp_cfg('charge');
            $_list['actual_price'] = $price - $price * sp_cfg('charge')/100;*/
        }
        $this->assign('list',$list);
        $this->assign("Page", $page->show());
        $this->assign('tixian_status',$TIXIAN_STATUS);
        $this->assign('get',$_GET);

        //各状态数量
        $status_num = M('member_tixian')->field('count(id) as total,status')->group('status')->select();
        $status_num_arr = array();
        foreach( $status_num as $k=>$v ) {
            $status_num_arr[$v['status']] = $v['total'];
        }
        $this->assign('status_num_arr',$status_num_arr);

        $this->display();
    }

    /**
     * 提现记录
     */
    /*public function tixian() {
        $TIXIAN_STATUS = C('TIXIAN_STATUS');

        $tixian_status = I('get.tixian_status');
        $start_date = I('get.start_date');
        $end_date = I('get.end_date');

        $map = array();
        $map['a.type'] = 2;

        if( $tixian_status != '' ) $map['a.tixian_status'] = $tixian_status;

        //搜索时间
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( a.create_time >= {$start_date} and a.create_time < {$end_date} )";
        }

        $model = M('member_price_log')->alias('a');
        $count = $model->where($map)->count();
        $page = sp_get_page($count, 20);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;

        $list = M('member_price_log')->alias('a')->join(C('DB_PREFIX').'member as c on a.member_id = c.id','left')
                        ->where($map)
                        ->field('a.*,c.nickname,c.phone,c.bank_name,c.bank_user,c.bank_number')
                        ->order('a.id desc')->limit("$firstRow , $listRows")
                        ->select();
        foreach( $list as &$_list ) {
            $_list['status_text'] = $TIXIAN_STATUS[$_list['tixian_status']];
            $price = abs($_list['price']);
            $_list['price'] = $price;
            $_list['charge'] = sp_cfg('charge');
            $_list['actual_price'] = $price - $price * sp_cfg('charge')/100;
        }
        $this->assign('list',$list);
        $this->assign('tixian_status',$TIXIAN_STATUS);
        $this->assign('get',$_GET);
        $this->display();
    }*/

    /**
     * 提现审核操作
     */
    public function tixian_do()
    {
        if( IS_POST ) {
            $id = intval(I('post.id'));
            $status = intval(I('post.status'));

            $data['id'] = $id;
            /*$data['tixian_status'] = $tixian_status;
            $data['admin_remark'] = I('post.admin_remark');
            $result = M('member_price_log')->save($data);*/

            $data['status'] = $status;
            $data['admin_remark'] = I('post.admin_remark');
            $data['update_time'] = time();
            $result = M('member_tixian')->save($data);
            if( $result ) {

                //如果什么都不修改算修改失败，所以更新时间最后更新
                //M('member_price_log')->where(array('id'=>$id))->setField('update_time', time());

                //余额处理
                if( $status == -1 || $status == 1 ) {
                    $memberModel = new MemberModel();
                    $memberModel->txShenHe($id, $status);

                    $_data = M('member_tixian')->find($id);
                    $old_date = date('Y-m-d', $_data['create_time']);
                    $price = abs($_data['price']);
                    $noticeModel = new NoticeModel();

                    $admin_remark = I('post.admin_remark');
                    $msg = array(
                        '-1' => "很抱歉，您于{$old_date}申请提现{$price}元未能通过审核。[原因：$admin_remark]",
                        '1' => "您于{$old_date}申请提现{$price}元已通过审核。"
                    );
                    $noticeModel->addNotice($_data['member_id'], $msg[$status]);
                }

                $this->success ('操作成功!');
            } else {
                $this->error ('操作失败!');
            }
        }
    }

    private function pay_status()
    {
        $status_text = array(
            '0' => '待处理',
            '1' => '审核通过',
            '-1' => '审核不通过'
        );
        return $status_text;
    }

    public function pay_screenshot()
    {
        $status_text = $this->pay_status();
        $status = I('get.status');
        $start_date = I('get.start_date');
        $end_date = I('get.end_date');

        $map = array();

        if( $status != '' ) $map['a.status'] = $status;

        //搜索时间
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( a.create_time >= {$start_date} and a.create_time < {$end_date} )";
        }

        $model = M('recharge_screenshot')->alias('a');
        $count = $model->where($map)->count();
        $page = sp_get_page($count, 20);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;

        $list = M('recharge_screenshot')->alias('a')->join(C('DB_PREFIX').'member as c on a.member_id = c.id','left')
            ->where($map)
            ->field('a.*,c.username,c.phone,c.bank_name,c.bank_user,c.bank_number')
            ->order('a.id desc')->limit("$firstRow , $listRows")
            ->select();
        foreach( $list as &$_list ) {
            $_list['status_text'] = $status_text[$_list['status']];
            $_list['price'] = M('recharge')->where(array('order_no'=>$_list['order_no']))->getField('price');
        }
        $this->assign('list',$list);
        $this->assign("Page", $page->show());
        $this->assign('status_text',$status_text);
        $this->assign('get',$_GET);
        $this->display();
    }

    /**
     * 添加、编辑操作
     */
    public function pay_screenshot_handle() {
        if( IS_POST ) {
            $id = I('post.id');
            $screenshot_data = M('recharge_screenshot')->where(array('id'=>$id))->find();
            $old_status =  $screenshot_data['status'];
            $order_no = $screenshot_data['order_no'];
            if( $old_status == 1 ) {
                $this->error('审核已通过，不可再修改');
            }
            $status = intval(I('post.status'));

            $data = array();
            $data['id'] = $id;
            if( $status != '' ) $data['status'] = $status;
            $data['update_time'] = time();

            if (M ('recharge_screenshot')->save ($data) !== false) {

                /*--------------返利逻辑------------*/
                if( $status == 1 ) {
                    $_data = M('recharge')->where(array('order_no'=>$order_no))->find();
                    $pay_model = new PayModel();
                    $pay_model->pay_vip_success($_data['id'],'admin',$id);
                }
                /*--------------//返利逻辑------------*/

                $this->success ('编辑成功!');
            } else {
                $this->error ('编辑失败!');
            }
        } else {
            $id = I('id');
            $recharge_data = M('recharge_screenshot')->find($id);
            $recharge_data['username'] = M('member')->where(array('id'=>$recharge_data['member_id']))->getField('username');
            $pay_status = $this->pay_status();
            $this->assign("pay_status", $pay_status);
            $recharge_data['status_text'] = $pay_status[$recharge_data['status']];
            $this->assign("info", $recharge_data);

            $this->display();
        }
    }
}