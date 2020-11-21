<?php
namespace Common\Model;
use Common\Model\BaseModel;

class CommissionModel extends BaseModel{
    /**
     * 佣金
     * @param $total_price
     * @param int $rank 0我的提成   1我的上级提成   2我上级的上级提成
     * @param int $p1  当不存在上级时提成都归此用户
     * @param int $p2
     * @return mixed
     */
    public function getCommission ($total_price,$rank=0,$p1,$p2=0)
    {
        if( $p1 > 0 ) {
            if( $rank == 0 ) {
                $commission = floatval(sp_cfg('commission'));
                if( $commission > 1 ) $commission = 0;
                $percentage = $commission;
            } elseif ($rank == 1) {
                $commission1 = floatval(sp_cfg('commission1'));
                if( $commission1 > 1 ) $commission1 = 0;
                $percentage = $commission1;
            } elseif ($rank == 2) {
                $commission2 = floatval(sp_cfg('commission2'));

                if( $commission2 > 1 ) $commission2 = 0;
                $percentage = $commission2;
            } else {
                $percentage = 0;
            }
        } elseif( $rank == 0 ) {
            $commission = floatval(sp_cfg('all_commission'));
            if( $commission > 1 ) $commission = 0;
            $percentage = $commission;
        } else {
            $percentage = 0;
        }

        $ret = $total_price * $percentage;

        return $ret;
    }

    /**
     * 添加佣金记录
     * @param $member_id
     * @param $apply_id
     * @param $apply_table_name  apply_step, apply_step_xd, posts_apply
     * @param $price
     * @param $rank
     * @param $remark
     * @return mixed
     */
    public function addCommission($member_id, $apply_id, $apply_table_name, $price, $rank, $remark)
    {
        //$check = M('commission')->where(array('member_id'=>$member_id,'posts_apply_id'=>$posts_apply_id))->find();
        if( !($price > 0) ) return false;
        $data['member_id'] = $member_id;
        $data['apply_id'] = $apply_id;
        $data['apply_table_name'] = $apply_table_name;
        $data['price'] = $price;
        $data['rank'] = $rank;
        $data['create_time'] = time();
        $res = M('commission')->add($data);
        if( $res ) {
            $memberModel = new MemberModel();
            $memberModel->incPrice($member_id, $price, 1, "{$remark}");

            //发送通知
            $noticeModel = new NoticeModel();
            $noticeModel->addNotice($member_id, $remark);
        }
        return $res;
    }

}
