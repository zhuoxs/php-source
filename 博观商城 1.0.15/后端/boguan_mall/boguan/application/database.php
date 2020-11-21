<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
defined('IN_IA') or define('IN_IA', true);

$we7_config = __DIR__ . '/../../../../data/config.php';

error_reporting(E_ERROR);

if (file_exists($we7_config)) {
    require __DIR__ . '/../../../../data/config.php';
    if (!isset($config['db']['master']))
        $config['db']['master'] = [];

    if (empty($config['db']['master']['host']))
        $hostname = $config['db']['master']['host'];

    if (empty($config['db']['master']['port']))
        $hostport = $config['db']['master']['port'];

    if (empty($config['db']['master']['database']))
        $database = $config['db']['master']['database'];

    if (empty($config['db']['master']['username']))
        $username = $config['db']['master']['username'];

    if (empty($config['db']['master']['password']))
        $password = $config['db']['master']['password'];

}
//var_dump($config['db']['master']['username']);

return $cfg= [
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => $config['db']['master']['host'],
    // 数据库名
    'database'        => $config['db']['master']['database'],
    // 用户名
    'username'        => $config['db']['master']['username'],
    // 密码
    'password'        => $config['db']['master']['password'],
    // 端口
    'hostport'        => $config['db']['master']['port'],
    // 连接dsn
    ///'dsn'             => 'mysql:host=' . $hostname . ';port=' . $hostport . ';dbname=' . $database,
    // 数据库连接参数
    'params'          => [],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
    // 数据库表前缀
    'prefix'          => 'bg_',
    // 数据库调试模式
    'debug'           => true,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 是否严格检查字段是否存在
    'fields_strict'   => true,
    // 数据集返回类型
    'resultset_type'  => 'collection',
    // 自动写入时间戳字段
    'auto_timestamp'  => false,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
];
