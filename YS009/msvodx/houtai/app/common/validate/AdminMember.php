<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------
namespace app\common\validate;

use think\Validate;

/**
 * 用户验证器
 * @package app\admin\validate
 */
class AdminMember extends Validate
{
    //定义验证规则
    /*
     * protected $rule = [
        'username|用户名' => 'checkUsername:thinkphp|unique:admin_member',
        'email|邮箱'     => 'checkEmail:thinkphp|email|unique:admin_member',
        'password|密码'  => 'length:6,20',
        'mobile|手机号'   => 'checkMobile:thinkphp|unique:admin_member',
    ];*/
    protected $rule = [
        'username|用户名' => 'require|checkUsername:thinkphp',
        'email|邮箱'     => 'require|checkEmail:thinkphp',
        'password|密码'  => 'length:6,20',
        'tel|手机号'   => 'require|checkMobile:thinkphp',
    ];
    //定义验证提示
    protected $message = [
        'username.require'=>"用户名不能为空",
        'username.unique'=>"用户名已经存在",
        'password.length'  => '密码长度6-20位',
    ];

    //定义验证场景
    protected $scene = [
        //无token验证登录
        'add'  =>  ['username','password'],
        'edit'  =>  [ 'password' ],
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

    /**
     * 检查用户名
     * @author frs
     * @return stirng|array
     */
    protected function checkUsername($value, $rule, $data)
    {
        $myDb=x_connect_webdatabase();
        $info  = $myDb->name('member')->where(array('username'=>$data['username']))->field('id')->find();
        if(!empty($info['id'])) {
            return '该用户名已经存在！';
        }
        return true;
    }

    /**
     * 检查手机号
     * @author frs
     * @return stirng|array
     */
    protected function checkMobile($value, $rule, $data)
    {
        if (!preg_match("/^1[34578]\d{9}$/", $data['tel'])) {
            return '手机号格式错误！';
        }
        return true;
    }
}
