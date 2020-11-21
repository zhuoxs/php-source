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
namespace app\admin\validate;

use think\Validate;

/**
 * 配置验证器
 * @package app\admin\validate
 */
class AdminConfig extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|配置标识' => 'require|unique:admin_config',
        'title|配置标题' => 'require',
        'type|配置类型'    => 'require',
    ];

    //定义验证提示
    // protected $message = [
    //     'name.require' => '请选择所属模块',
    //     'title.require'    => '请选择所属菜单',
    //     'type.require'    => '菜单链接已存在',
    // ];
}
