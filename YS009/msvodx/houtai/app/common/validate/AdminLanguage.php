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
 * 语言包验证器
 * @package app\common\validate
 */
class AdminLanguage extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|语言名称' => 'require|unique:admin_language',
        'code|语言代码'  => 'require|unique:admin_language',
    ];

    //定义验证提示
    protected $message = [
        'name.require' => '语言名称不允许为空',
        'name.unique' => '语言名称已存在',
        'code.require' => '语言代码不允许为空',
        'code.unique' => '语言代码已存在',
    ];
}
