<?php
namespace Common\Model;
use Common\Model\BaseModel;

class PhonecodeModel extends BaseModel{
    /**
     * 记住手机验证码
     * @param $type
     * @param $phone
     * @param $code
     */
    public static function set_phone_code($type, $phone, $code)
    {
        session($type . '_phone_code', $phone . $code);
    }

    /**
     * 获取已经设置的手机验证码
     * @param $type
     * @return mixed
     */
    public static function get_phone_code($type)
    {
        return session($type . '_phone_code');
    }

    /**
     * 验证短时验证码是否正确
     * @param $type
     * @param $phone
     * @param $code
     * @return bool
     */
    public static function check_phone_code($type, $phone, $code)
    {
        $o_code = self::get_phone_code($type);
        if( $o_code != $phone.$code ) {
            return false;
        } else {
            return true;
        }
    }
}
