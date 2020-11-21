<?php
defined('IN_IA') or define('IN_IA', true);

$config = call_user_func(function () {

    $config = [];

    require __DIR__ . '/../../../../../data/config.php';

    return $config['db']['master'];

});

return array(
    'DB_TYPE'               =>  'mysqli',            // 数据库类型
    'DB_HOST'               =>  $config['host'],     // 服务器地址
    'DB_NAME'               =>  $config['database'], // 数据库名
    'DB_USER'               =>  $config['username'], // 用户名
    'DB_PWD'                =>  $config['password'], // 密码
    'DB_PORT'               =>  '3306',              // 端口
    'DB_PREFIX'             =>  'yb_pc_',               // 数据库表前缀
    'DB_CHARSET'            =>  'utf8mb4',           // 数据库字符集
);
?>