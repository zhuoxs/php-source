<?php
namespace Common\Model;
/**
 * 消息
 */
class NoticeModel extends BaseModel{

    public function addNotice($member_id, $msg, $send_sms=false, $phone='')
    {
        $data['member_id'] = $member_id;
        $data['msg'] = $msg;
        $data['create_time'] = time();
        $data['has_view'] = 0;
        $res = M('notice')->add($data);

        if( $send_sms && is_phone($phone) ) {
            $sms = new SmsModel();
            $sms->send($phone,$msg,$err_msg);
        }

        return $res;
    }
}
