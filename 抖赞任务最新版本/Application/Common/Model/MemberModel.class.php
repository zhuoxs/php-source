<?php
namespace Common\Model;

use Common\Model\BaseModel;
use Org\Net\Wechat;

/**
 * 用户模型
 */
class MemberModel extends BaseModel
{

    //获取微信openid
    public function wx_login($redirect_uri)
    {
        $config = C('WEIXINPAY_CONFIG');
        $wx_info = session('wx_info');
        if( !empty($wx_info['openid']) && $wx_info['subscribe'] === 1 ) {
            $openid = $wx_info['openid'];
            $member = $this->getMemberDataByOpenid($openid);
            if( empty( $member ) ) {
                session('wx_info', $wx_info);
            } else {
                //直接登陆
                session('member', $member);
            }
        } else {

            $options = array (
                'token' => '', // 填写你设定的key
                'encodingaeskey' => '', // 填写加密用的EncodingAESKey
                'appid' => $config ["APPID"], // 填写高级调用功能的app id
                'appsecret' => $config ["APPSECRET"], // 填写高级调用功能的密钥
                'partnerid' => '', // 财付通商户身份标识
                'partnerkey' => '', // 财付通商户权限密钥Key
                'paysignkey' => ''  // 商户签名密钥Key
            );

            $weObj = new Wechat($options);
            $info = $weObj->getOauthAccessToken();
            if (!$info) {
                //$callback = 'http://' . $_SERVER ['SERVER_NAME']. U("Home/Wechat/getOpenid",$_GET);
                //$callback = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                $url = $weObj->getOauthRedirect($redirect_uri, '', 'snsapi_userinfo'); //snsapi_userinfo  snsapi_base
                header("Location: $url");
                exit();
            } else {
                $openid = $info['openid'];
            }

            //获取是否已经关注
            $wx_info_base = $weObj->getUserInfo($openid);

            //用户头像昵称等基本信息
            $wx_info = $weObj->getOauthUserinfo($info['access_token'], $info['openid']);

            cookie('wx_info', $wx_info);
            session('wx_info', $wx_info);

            $member = $this->getMemberDataByOpenid($openid);
            if (!empty($member)) {
                //直接登陆

                M('member')->where(array('id'=>$member['id']))->setField('last_login_time', time());
                session('member', $member);
            } else {
                //自动注册
                $data = array();
                $data['openid'] = $wx_info['openid'];
                $data['nickname'] = $wx_info['nickname'];
                $data['head_img'] = $wx_info['headimgurl'];
                $data['sex'] = $wx_info['sex'];
                $data['country'] = $wx_info['country'];
                $data['province'] = $wx_info['province'];
                $data['city'] = $wx_info['city'];
                $data['last_login_time'] = time();

                //是否是推荐人推荐
                $smid = session('smid');
                if (!empty($smid)) {
                    $parent_pids = M('member')->where(array('id' => $smid))->getField('pids');
                    $pids = !empty($parent_pids) ? $parent_pids.','.$smid : $smid;
                    //取10层关系
                    $pids = explode(',', $pids);
                    $pids = array_slice($pids, -10);
                    $pids = implode(',',$pids);
                    $data['pids'] = $pids;
                    $data['pid'] = intval($smid);
                }

                M('member')->add($data);
            }

            /*if ($wx_info_base['subscribe'] !== 1) {
                $follow_url = U('Public/follow_weixin');
                header("Location: $follow_url");
                exit();
            }*/

        }
    }

    /**
     * 通过OPENID获取用户信息
     * @param $openid
     * @return mixed
     */
    public function getMemberDataByOpenid($openid)
    {
        $user_data = $this->where(array('openid' => $openid))->find();
        return $user_data;
    }

    /**
     * 通过ID获取用户信息
     * @param $uid
     * @return mixed
     */
    public function getMemberDataById($uid)
    {
        $user_data = $this->where(array('id' => $uid))->find();
        return $user_data;
    }

    /**
     * 更新会员余额
     * @param $member_id
     * @param $price
     * @param int $type
     * @param string $remark
     * @return bool
     */
    public function incPrice($member_id, $price, $type=0, $remark = '', $no='')
    {
        if( !($price>0) ) {
            return false;
        }
        $res = M('member')->where(array('id' => $member_id))->setInc('price', $price);
        if ($res) {

            //更新总收入 当提现失败返回余额时不加进累计收入
            if( $type != 99 ) {
                M('member')->where(array('id' => $member_id))->setInc('total_price', $price);
            }

            //添加日志
            $this->price_log($member_id, $price, $type, $remark, $no);
        }
        return $res;
    }

    /**
     * 提现
     * @param $member_id
     * @param $price 单位元
     * @param int $type
     * @param string $remark
     * @return bool
     */
    public function decPrice($member_id, $price, $type=2, $remark = '提现')
    {
        $res = M('member')->where(array('id' => $member_id))->setDec('price', $price);
        if ($res) {
            //添加日志
            $price = 0 - $price;
            $this->price_log($member_id, $price, $type, $remark);
        }
        return $res;
    }

    /**
     * 提现审核
     */
    public function txShenHe($tixian_id, $tixian_status)
    {
        $data = M('member_tixian')->find($tixian_id);
        $price = $data['price'];

        if( $tixian_status == -1 ) {
            //审核不通过 将钱返回余额
            if( $price > 0 ) {
                $this->incPrice($data['member_id'], $price, 99, '提现失败，金额返回余额');
                return true;
            }
        } elseif( $tixian_status == 1 ) {
            //审核通过 更新用户中心提现总额
            M('member')->where(array('id' => $data['member_id']))->setInc('tixian_price', $price);
            return true;
        } else {
            return false;
        }

    }

    /**
     * 价格变化日志
     * @param $member_id
     * @param $price
     * @param int $type 0充值 1提成收入 2提现 3消费 4其他
     * @param string $remark
     */
    private function price_log($member_id, $price, $type=0, $remark = '', $no='')
    {
        $data['member_id'] = $member_id;
        $data['price'] = $price;
        $data['remark'] = $remark;
        $data['create_time'] = time();
        $data['type'] = $type;
        $data['no'] = $no;
        M('member_price_log')->add($data);
    }

}