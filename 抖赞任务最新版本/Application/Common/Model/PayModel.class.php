<?php
namespace Common\Model;

class PayModel extends BaseModel{
    /**
     * 支付成功
     * @param $order_id
     */
    public function pay_order_success($order_id) {

    }

    /**
     * 升级VIP成功后的处理逻辑
     * @param $order_id 订单号
     * @param $platform 渠道
     * @param $platform_no 渠道单号
     */
    public function pay_vip_success($order_id,$platform,$platform_no) {

        $recharge = M('recharge')->find($order_id);
        if( empty($recharge) || $recharge['is_pay'] == 1 ) {
            return ;
        }

        //记录支付记录
        $data = array();
        $data['type'] = 1;//购买VIP
        $data['order_id'] = $order_id;
        $data['order_no'] = $recharge['order_no'];
        $data['member_id'] = $recharge['member_id'];
        $data['price'] = $recharge['price'];
        $data['create_time'] = time();
        $data['payment_type'] = $platform;
        $data['platform_no'] = $platform_no;
        M('pay')->add($data);

        //等级信息
        $member_level = LevelModel::get_member_level();


        //用户基本信息
        $member_data = M('member')->field('id,username,phone,p1,p2,p3,level')->where(array('id'=>$recharge['member_id']))->find();
        /*if( $member_data['level'] > 0 ) {
            //如果用户已经升过级，不再给返利 只升级会员 直接返回
            $res = M('member')->where(array('id'=>$recharge['member_id']))->setField('level', $recharge['level']);
            if( $res ) {
                //发送信息
                $member_level = LevelModel::get_member_level();
                $noticeModel = new NoticeModel();
                $msg = sprintf(sp_cfg('vip_msg'),$member_level[$recharge['level']]['name']);
                $noticeModel->addNotice($recharge['member_id'], $msg, true, $member_data['phone']);
            }
            return ;
        }*/

        //更新为已支付
        M('recharge')->where(array('id'=>$recharge['id']))->setField('is_pay',1);
        $rebate_price_1 = $member_level[$recharge['level']]['rebate_price_1']; //一级提成
        $rebate_price_2 = $member_level[$recharge['level']]['rebate_price_2']; //二级提成
        $rebate_price_3 = $member_level[$recharge['level']]['rebate_price_3']; //三级提成

        //升级用户为会员
        M('member')->where(array('id'=>$recharge['member_id']))->setField('level', $recharge['level']);

        //给直接上级返利
        if( $member_data['p1']>0 ) {
            if( $rebate_price_1>0 ) {
                $this->add_sale($order_id, $rebate_price_1, $member_data['p1'], 3, '推荐会员提成，来源用户'.$member_data['username'], $member_data['id'] );
            }
        }
        //二级返利
        if( $member_data['p2']>0 ) {
            if( $rebate_price_2>0 ) {
                $this->add_sale($order_id, $rebate_price_2, $member_data['p2'], 3, '推荐会员提成，来源用户'.$member_data['username'], $member_data['id'] );
            }
        }
        //三级返利
        if( $member_data['p3']>0 ) {
            if( $rebate_price_3>0 ) {
                $this->add_sale($order_id, $rebate_price_3, $member_data['p3'], 3, '推荐会员提成，来源用户'.$member_data['username'], $member_data['id'] );
            }
        }

        //信息提示
        $noticeModel = new NoticeModel();
        $msg = sprintf(sp_cfg('vip_msg'),$member_level[$recharge['level']]['name']);
        $noticeModel->addNotice($recharge['member_id'], "恭喜您，您的VIP等级已升级为{$msg}", true, $member_data['phone']);
    }

    /**
     * 给会员添加收益
     * @param $order_id
     * @param $price
     * @param $member_id
     * @param $type
     * @param $remark
     * @param int $from_member_id
     */
    private function add_sale($order_id,$price,$member_id,$type,$remark,$from_member_id=0)
    {
        $data['member_id'] = $member_id;
        $data['from_member_id'] = $from_member_id;
        $data['order_id'] = $order_id;
        $data['price'] = $price;
        $data['remark'] = $remark;
        $data['create_time'] = time();
        $data['type'] = $type;
        $result = M('sale_list')->add($data); //收益记录
        if( $result ) {
            //添加金额变动记录
            $model_member = new MemberModel();
            $model_member->incPrice($member_id,$price,$type,$remark,$result);
        } else {
            throw_exception('添加收益失败');
        }
    }
}
