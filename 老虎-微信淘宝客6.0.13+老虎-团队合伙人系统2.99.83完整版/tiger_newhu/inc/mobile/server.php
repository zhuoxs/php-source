<?php

header("Content-type: text/html; charset=utf-8");
$table = new swoole_table(131072);
$table->column('nickname', swoole_table::TYPE_STRING, 300);       //1,2,4,8
$table->column('appid', swoole_table::TYPE_STRING, 64);
//$table->column('num', swoole_table::TYPE_FLOAT);
$table->create();

//创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new swoole_websocket_server("0.0.0.0", 9502);
$ws->table = $table;
//设置
$ws->set(array(
    'worker_num' => 8,
    'task_max_request' => 30, //task进程最大运行次数
    'daemonize' => 1, //后台运行
    'log_file' => dirname(__FILE__) . '/log.txt'
));

$ws->on('WorkerStart', function ($ws, $worker_id) {
    global $argv;
    if ($worker_id >= $server->setting['worker_num']) {
        swoole_set_process_name("php {$argv[0]} task_zhibo");
    } else {
        swoole_set_process_name("php {$argv[0]} worker_zhibo");
    }
});
//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {
    
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {
    // echo "Message: {$frame->data}\n";
    //$arr = json_de($frame->data);
    $arr =json_decode($frame->data, 1);;
    if ($arr['action'] == "bind") {
        $ws->table->set($frame->fd, array('appid' => $arr['data'], 'nickname' => $arr['nickname']));
        return;
    } elseif ($arr['action'] == "danmu") {
        $appidArr = $ws->table->get($frame->fd);
        $nickname = urldecode($appidArr['nickname']);
        foreach ($ws->table as $key => $value) {
            if ($value['appid'] == $appidArr['appid']) {
                $arr_send = array('action' => 'danmu', 'user_nick' => $nickname, 'msg' => $arr['data']);
                //$json_Send = json_en($arr_send);
                $json_Send =json_encode($arr_send, JSON_UNESCAPED_UNICODE);
                $ws->push($key, $json_Send);
            }
        }
    } elseif ($arr['action'] == "close" and $arr['token'] == "123456") {
        $ws->shutdown();
    }
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    $appidArr = $ws->table->get($fd);
//    if (count($appidArr) > 0) {
//        sql_query("UPDATE  ims_tiger_newhu_admin  SET  online_num = online_num+1 WHERE  appid ='{$appidArr['appid']}'");
//    }
    $ws->table->del($fd);
    // echo "client-{$fd} is closed\n";
});

$ws->start();

