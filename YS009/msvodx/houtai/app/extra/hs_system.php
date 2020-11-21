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
/**
 * 系统扩展配置，非TP框架配置
 */
return [
    // +----------------------------------------------------------------------
    // | 系统相关设置
    // +----------------------------------------------------------------------
    // 系统数据表
    'tables'            => [
        'admin_config', 
        'admin_menu', 
        'admin_module', 
        'admin_role', 
        'admin_user',
        'admin_hook',
        'admin_hook_plugins',
        'admin_plugins',
        'admin_member',
        'admin_member_level',
    ],
    // 系统会员等级，此处只为声明配置，app/common/behavior/Base.php 里面赋值
    'member_level'      => [],
    // 系统设置分组
    'config_group'      => [
        'base'      => '基础',
        'sys'       => '系统',
        'upload'    => '上传',
        'develop'   => '开发',
        'databases'  => '数据库',
    ],
    // 系统标准模块
    'modules' => ['admin', 'common', 'index', 'install', 'hisiphp', 'plugin'],
    // 系统标准配置文件
    'config' => ['app', 'cache', 'cookie', 'database', 'log', 'queue', 'session', 'template', 'trace', 'hs_auth', 'hs_cloud', 'hs_system', 'hisiphp'],
];