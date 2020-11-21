<?php
namespace Common\Controller;
use Common\Model\MemberModel;
use Think\Controller;
/**
 * Base基类控制器
 */
class BaseController extends Controller{

    public function _initialize(){

    }


    /**
     * 用户ID
     * @return int
     */
    public function get_member_id()
    {
        $member = session('member');
        if( isset($member['id']) && $member['id'] > 0 ) {
            return $member['id'];
        } else {
            return 0;
        }
    }

    /**
     * 用户名称
     * @return int
     */
    public function get_member_name()
    {
        $member = session('member');
        if( isset($member['nickname']) ) {
            return $member['nickname'];
        } else {
            return '';
        }
    }

    /**
     * 用户名称
     * @return int
     */
    public function get_member_headimg()
    {
        $member = session('member');
        if( isset($member['head_img']) ) {
            return $member['head_img'];
        } else {
            return '';
        }
    }

    /**
     * 检测用户是否登陆
     */
    public function is_login()
    {
        /*$member = session('member');
        if( !($this->get_member_id() > 0) ) {
            //微信登陆
            if( is_wechat() ) {
                $wx = new MemberModel();
                $redirect_uri = U(MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME,$_GET,'',true);
                $wx->wx_login($redirect_uri);
            }
        }*/

        if( !($this->get_member_id() > 0) ) {
            return false;
        } else {
            return true;
        }
    }
}
