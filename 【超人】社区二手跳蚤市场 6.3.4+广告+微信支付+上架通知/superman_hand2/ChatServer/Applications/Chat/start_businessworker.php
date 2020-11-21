<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;
if (strpos(strtolower(PHP_OS), 'win') === 0) {
    require_once __DIR__ . '/../../config.php';
}
//分布式部署
if(file_exists(__DIR__ . '/../../multIp_config.php')){
    require_once __DIR__ . '/../../multIp_config.php';
}
require_once __DIR__ . '/../../vendor/autoload.php';

// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = 'ChatBusinessWorker';
// bussinessWorker进程数量
$worker->count = 4;
// 服务注册地址
if (defined('REGISTER_IP')) {
    $worker->registerAddress = REGISTER_IP.':'.SUPERMAN_HAND2_REGISTER_PORT;
} else {
    $worker->registerAddress = '127.0.0.1:'.SUPERMAN_HAND2_REGISTER_PORT;
}
// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}