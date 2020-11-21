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
 * 等级验证器
 * @package app\common\validate
 */
class AdminMemberLevel extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|等级名称' => 'require|unique:admin_member_level',
        'status|状态设置'  => 'require|in:0,1',
    ];

    //定义验证提示
    protected $message = [
        'name.require' => '请填写等级名称',
        'name.unique' => '等级名称已存在',
        'status.require'    => '请设置等级状态',
    ];
}
