<?php


return [
    // 视图输出字符串内容替换
    'view_replace_str'       => [
    		'__PUBLIC__'=> BG_URL.'addons/boguan_mall/boguan/public/index/',
           
    ],

    'default_return_type'    => 'html',

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => 'think',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
        //'expire' => 3600,
    ],

];
