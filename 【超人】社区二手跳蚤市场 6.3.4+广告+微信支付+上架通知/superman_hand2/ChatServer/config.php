<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
require_once __DIR__.'/../class/util.class.php';
if (!SupermanHandUtil::isBindPort(7272)) { //default
    define('SUPERMAN_HAND2_GATEWAY_PORT', 7272);
    define('SUPERMAN_HAND2_REGISTER_PORT', 1236);
    define('SUPERMAN_HAND2_GATEWAY_START_PORT', 2300);
} else if (!SupermanHandUtil::isBindPort(7372)) {
    define('SUPERMAN_HAND2_GATEWAY_PORT', 7372);
    define('SUPERMAN_HAND2_REGISTER_PORT', 1336);
    define('SUPERMAN_HAND2_GATEWAY_START_PORT', 2400);
} else {
    define('SUPERMAN_HAND2_GATEWAY_PORT', 7472);
    define('SUPERMAN_HAND2_REGISTER_PORT', 1436);
    define('SUPERMAN_HAND2_GATEWAY_START_PORT', 2500);
}

// stop
if (isset($argv[1]) && $argv[1] == 'stop') {
    $chat_port_file = __DIR__.'/chat_port.php';
    if (file_exists($chat_port_file)) {
        @unlink($chat_port_file);
    }
}

if (strtolower(substr(PHP_OS, 0, 3)) != 'win') {
    // force wss
    for ($i=0; $i<$argc; $i++) {
        if ($argv[$i] == 'wss') {
            define('SUPERMAN_HAND2_WSS', true);
            break;
        } else if ($argv[$i] == 'no_wss') {
            define('SUPERMAN_HAND2_NO_WSS', true);
            break;
        }
    }
}
