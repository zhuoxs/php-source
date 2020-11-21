<?php
require_once "vendor/autoload.php";
use Workerman\Worker;

Worker::$pidFile        = 'workerman.pid';//方便监控WorkerMan进程状态
Worker::$stdoutFile     = 'stdout.log';//输出日志, 如echo，var_dump等
Worker::$logFile        = 'workerman.log';//workerman自身相关的日志

require_once "gateway.php";
require_once "register.php";
require_once "business.php";

Worker::runAll();