<?php
namespace app\validate;

use think\Validate;

/**
 * 用户验证器
 * @package application\common\validate
 */
class member extends Validate
{
    protected $rule = [
        'username|用户名' => 'require|unique:member',
        'email|邮箱'     => 'require|unique:member|checkEmail:thinkphp',
        'tel|手机号码'  => 'require|unique:member',
        'password|密码'  => 'length:6,20',
    ];
    //定义验证提示
    protected $message = [
        'email.require'=>"邮箱不能为空",
        'unique.require'=>"用户名不能为空",
        'password.length'  => '密码长度6-20位',
    ];

    //定义验证场景
    protected $scene = [
        'email_register'  =>  [ 'username','email','password'],
        'tel_register'  =>  [  'username','tel','password'],
        'mobile_register'  =>  [  'username','tel','password'],
        'username_register'  =>  [ 'username','password'],
    ];

    /**
     * 检查邮箱
     * @author frs
     * @return stirng|array
     */
    protected function checkEmail($value, $rule, $data)
    {
        if (!preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $data['email'])) {
            return '请输入正确的邮箱地址！';
        }
        return true;
    }


}