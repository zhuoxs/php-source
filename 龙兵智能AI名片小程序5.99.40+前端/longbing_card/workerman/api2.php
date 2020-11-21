<?php
use Workerman\Worker;
use Workerman\Lib\Timer;
require_once __DIR__ . '/Autoloader.php';
require_once __DIR__ . '/mysql/src/Connection.php';
//require_once __DIR__ . '/../config.php';
// 心跳间隔55秒
define('HEARTBEAT_TIME', 55);

define('IN_IA', 'tmp');
include_once '../../../data/config.php';
$workman_server = '0.0.0.0';
$workman_port = 2345;
if (!empty($config) && isset($config['setting'])
    && isset($config['setting']['workerman'])
    && isset($config['setting']['workerman']['server'])
    && $config['setting']['workerman']['server']) {
    $workman_server = $config['setting']['workerman']['server'];
}
if (!empty($config) && isset($config['setting'])
    && isset($config['setting']['workerman'])
    && isset($config['setting']['workerman']['port'])
    && $config['setting']['workerman']['port']) {
    $workman_port = $config['setting']['workerman']['port'];
}

// 初始化一个worker容器，监听2345端口
$worker = new Worker('websocket://0.0.0.0:2345');
//$worker = new Worker('websocket://' . $workman_server . ':' . $workman_port);
// ====这里进程数必须必须必须设置为1====
$worker->count = 1;
// 新增加一个属性，用来保存uid到connection的映射(uid是用户id或者客户端唯一标识)
$worker->uidConnections = array();

$worker->onWorkerStart = function($worker)
{
    // 将db实例存储在全局变量中(也可以存储在某类的静态成员中)
    global $db;
//    $db = new \Workerman\MySQL\Connection(WM_HOST, WM_PORT, WM_USER, WM_PASSWORD, WM_DBNAME, WM_CHARSET);
    $config = file('../../../data/config.php');
    $host = '';
    $username = '';
    $password = '';
    $port = '';
    $database = '';
    $tablepre = '';
    if (!empty($config))
    {
        foreach ($config as $k => $v)
        {
            if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'host'))
            {
                $arr = explode("'", $v);
                $host = $arr[count($arr) - 2];
            }
            if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'username'))
            {
                $arr = explode("'", $v);
                $username = $arr[count($arr) - 2];
            }
            if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'password'))
            {
                $arr = explode("'", $v);
                $password = $arr[count($arr) - 2];
            }
            if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'port'))
            {
                $arr = explode("'", $v);
                $port = $arr[count($arr) - 2];
            }
            if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'database'))
            {
                $arr = explode("'", $v);
                $database = $arr[count($arr) - 2];
            }
            if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'tablepre'))
            {
                $arr = explode("'", $v);
                $tablepre = $arr[count($arr) - 2];
            }
        }



        if ($host == '')
        {
            foreach ($config as $k => $v)
            {
                if (strpos($v, 'db') && strpos($v, 'host'))
                {
                    $arr = explode("'", $v);
                    $host = $arr[count($arr) - 2];
                }
                if (strpos($v, 'db') && strpos($v, 'username'))
                {
                    $arr = explode("'", $v);
                    $username = $arr[count($arr) - 2];
                }
                if (strpos($v, 'db') && strpos($v, 'password'))
                {
                    $arr = explode("'", $v);
                    $password = $arr[count($arr) - 2];
                }
                if (strpos($v, 'db') && strpos($v, 'port'))
                {
                    $arr = explode("'", $v);
                    $port = $arr[count($arr) - 2];
                }
                if (strpos($v, 'db') && strpos($v, 'database'))
                {
                    $arr = explode("'", $v);
                    $database = $arr[count($arr) - 2];
                }
                if (strpos($v, 'db') && strpos($v, 'tablepre'))
                {
                    $arr = explode("'", $v);
                    $tablepre = $arr[count($arr) - 2];
                }
            }
        }


    }
    $db = new \Workerman\MySQL\Connection($host, $port, $username, $password, $database, 'utf8mb4');

    Timer::add(1, function()use($worker){
        $time_now = time();
        foreach($worker->connections as $connection) {
            // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
            if (empty($connection->lastMessageTime)) {
                $connection->lastMessageTime = $time_now;
                continue;
            }
            // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
            if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
                $connection->close();
            }
        }
    });
};

// 客户端练上来时，即完成TCP三次握手后的回调
$worker->onConnect = function($connection) {
    /**
     * 客户端websocket握手时的回调onWebSocketConnect
     * 在onWebSocketConnect回调中获得nginx通过http头中的X_REAL_IP值
     */
    $connection->onWebSocketConnect = function($connection){
        /**
         * connection对象本没有realIP属性，这里给connection对象动态添加个realIP属性
         * 记住php对象是可以动态添加属性的，你也可以用自己喜欢的属性名
         */
        $connection->realIP = $_SERVER['HTTP_X_REAL_IP'];
    };
};

// 当有客户端发来消息时执行的回调函数
$worker->onMessage = function($connection, $data)
{
    global $worker, $db;

    $connection->lastMessageTime = time();

    $config = file('../../../data/config.php');

    $tablepre = '';
    if (!empty($config))
    {
        foreach ($config as $k => $v)
        {
            if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'tablepre'))
            {
                $arr = explode("'", $v);
                $tablepre = $arr[count($arr) - 2];
            }
        }

        if ($tablepre == '')
        {
            foreach ($config as $k => $v)
            {
                if (strpos($v, 'db') && strpos($v, 'tablepre'))
                {
                    $arr = explode("'", $v);
                    $tablepre = $arr[count($arr) - 2];
                }
            }
        }
    }


    $data2 = $data;
    $data = json_decode($data, true);

    if (isset($data['ping'])) {
        $connection->send('pong');

        $list = $db->query("SELECT * FROM `" . $tablepre ."longbing_card_message` WHERE target_id={$data['user_id']} && user_id = {$data['target_id']} && status = 1");

        if (is_array($list) && !empty($list)) {
            foreach ($list as $k => $v) {

                $msg = [
                    'errno' => 0,
                    'message' => '接收成功_1',
                    'data' => $v['content'],
                    'type' => $v['message_type'],
                    'data2'=> $v
                ];
                $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
                $connection->send($msg);
                $db->query("UPDATE `" . $tablepre . "longbing_card_message` SET status = 2 WHERE id = {$v['id']}");
            }
        }

        return false;
    }

    $data2 = array();
    if (isset($data['goods_id'])) {
        $goods_info = $db->query("SELECT * FROM `" . $tablepre ."longbing_card_goods` WHERE id={$data['goods_id']}");
        $data['content'] = '您好！我想咨询下商品：' . $goods_info[0]['name'] . '的相关信息。';
        $data['type'] = 'text';
//        $data2['content'] = tomedia($goods_info['cover']);
//        $data2['type'] = 'image';
    }

    if (!isset($data['user_id']) || !isset($data['target_id']) || !isset($data['content']) || !isset($data['uniacid'])) {
        $msg = [
            'errno' => -1,
//          'message' => '请传入必要参数' .$data['user_id'] .'-'.$data['target_id'] .'-'.$data['content'] .'-'.$data['uniacid'],
            'message' => $data2,
            'data' => []
        ];
        $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
        $connection->send($msg);
        return false;
    }

    $user_id = $data['user_id'];
    $target_id = $data['target_id'];
    $content = $data['content'];
    $uniacid = $data['uniacid'];
    $type = $data['type'];


//    $check_user_id = $db->query("SELECT * FROM `" . $tablepre . "longbing_card_user` WHERE id={$user_id}");
//
//    $check_target_id = $db->query("SELECT * FROM `" . $tablepre . "longbing_card_user` WHERE id={$target_id}");
//
//    if (empty($check_target_id) || empty($check_user_id)) {
//        $msg = [
//            'errno' => -1,
//            'message' => '未找到用户信息',
//            'data' => []
//        ];
//        $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
//        $connection->send($msg);
//        return false;
//    }

    $check1 = $db->query("SELECT * FROM `" . $tablepre . "longbing_card_chat` WHERE user_id={$user_id} && target_id = {$target_id}");


    if (empty($check1)) {

        $check2 = $db->query("SELECT * FROM `" . $tablepre . "longbing_card_chat` WHERE user_id={$target_id} && target_id = {$user_id}");

        if (empty($check2)) {
            $insert_id = $db->insert($tablepre . 'longbing_card_chat')->cols(array(
                    'user_id'=>$user_id,
                    'target_id'=>$target_id,
                    'uniacid'=>$uniacid,
                    'create_time'=>time(),
                    'update_time'=>time(),
                )
            )->query();
            $chat_id = $insert_id;
        } else {
            $chat_id = $check2[0]['id'];
        }
    } else {
        $chat_id = $check1[0]['id'];
    }

    if (!$chat_id) {
        $msg = [
            'errno' => -1,
            'message' => '系统错误',
            'data' => []
        ];
        $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
        $connection->send($msg);
        return false;
    }


    //jingshuixian
    $install_data = array(
        'chat_id'=>$chat_id,
        'user_id'=>$user_id,
        'target_id'=>$target_id,
        'content'=>$content,
        'uniacid'=>$uniacid,
        'message_type'=>$type,
        'create_time'=>time(),
        'update_time'=>time(),
    );

    $insert_id = $db->insert($tablepre . 'longbing_card_message')->cols($install_data)->query();

//    if (!empty($data2))
//    {
//        $install_data = array(
//            'chat_id'=>$chat_id,
//            'user_id'=>$user_id,
//            'target_id'=>$target_id,
//            'content'=>$data2['content'],
//            'uniacid'=>$uniacid,
//            'message_type'=>'image',
//            'create_time'=>time(),
//            'update_time'=>time(),
//        );
//
//        $db->insert($tablepre . 'longbing_card_message')->cols($install_data)->query();
//    }


    if (!$insert_id) {
        $msg = [
            'errno' => -1,
            'message' => '系统错误!',
            'data' => []
        ];
        $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
        $connection->send($msg);
        return false;
    }else{
        $install_data['id'] = $insert_id ;
    }

    // 判断当前客户端是否已经验证,即是否设置了uid
    if(!isset($connection->uid))
    {
        // 没验证的话把第一个包当做uid（这里为了方便演示，没做真正的验证）
        $connection->uid = $user_id;
        /* 保存uid到connection的映射，这样可以方便的通过uid查找connection，
         * 实现针对特定uid推送数据
         */
        $worker->uidConnections[$connection->uid] = $connection;
//        $connection->send('login success, your uid is ' . $connection->uid);
    }

//    file_put_contents('api.txt', 0 . PHP_EOL, FILE_APPEND);
//    mark($user_id, $target_id, $uniacid);
    sendMessageByUid($data['target_id'], $content, $connection, $uniacid, $insert_id, $tablepre, $install_data);

    return false;
    // 其它逻辑，针对某个uid发送 或者 全局广播
    // 假设消息格式为 uid:message 时是对 uid 发送 message
    // uid 为 all 时是全局广播
//    list($recv_uid, $message) = explode(':', $data);
    // 全局广播
    if($data['target_id'] == 'all')
    {
        broadcast($data['content']);
    }
    // 给特定uid发送
    else
    {
        sendMessageByUid($data['target_id'], $data['content']);
    }
};

// 当有客户端连接断开时
$worker->onClose = function($connection)
{
    global $worker;
    if(isset($connection->uid))
    {
        // 连接断开时删除映射
        unset($worker->uidConnections[$connection->uid]);
    }
};

// 向所有验证的用户推送数据
function broadcast($message)
{
    global $worker;
    foreach($worker->uidConnections as $connection)
    {
        $connection->send($message);
    }
}

// 针对uid推送数据
function sendMessageByUid($uid, $message, $con, $uniacid = 0 , $insert_id = 0 , $tablepre = '',$data2 = array())
{
    global $worker, $db;
    if(isset($worker->uidConnections[$uid]))
    {
        $connection = $worker->uidConnections[$uid];
        $msg = [
            'errno' => 0,
            'message' => '接收成功_2',
            'data' => $message ,
            'type' => $data2['message_type'],
            'data2'=> $data2
        ];
        $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
        $connection->send($msg);
        $msg = [
            'errno' => 0,
            'message' => '发送成功_2',
            'data' => []
        ];
        $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
        $con->send($msg);
        if ($insert_id) {

            $db->query("UPDATE `" . $tablepre . "longbing_card_message` SET status = 2 WHERE id = {$insert_id}");
        }
        return false;
    } else {

    }
    $msg = [
        'errno' => 0,
        'message' => '发送成功_1',
        'data' => []
    ];
    $msg = json_encode($msg, JSON_UNESCAPED_UNICODE);
    $con->send($msg);
}

function mark ($uid, $target_id, $uniacid) {
//    file_put_contents('api.txt', $uid . '-' . $target_id . '-' . $uniacid . PHP_EOL, FILE_APPEND);
    global $worker, $db;
//    $check_user = $db->select('*')
//        ->from('ims_longbing_card_user')
//        ->where('id= :id')
//        ->bindValues(array('id'=>$uid))
//        ->row();

    $check_user = $db->query("SELECT * FROM `ims_longbing_card_user` WHERE id={$uid}");
//    $check_user_tar = $db->select('*')
//        ->from('ims_longbing_card_user')
//        ->where('id= :id')
//        ->bindValues(array('id'=>$target_id))
//        ->row();
    $check_user_tar = $db->query("SELECT * FROM `ims_longbing_card_user` WHERE id={$target_id}");
//    file_put_contents('api.txt', 1, FILE_APPEND);
    if (empty($check_user) || empty($check_user_tar))
        return false;
//    file_put_contents('api.txt', 2, FILE_APPEND);
    if ($check_user['is_staff']) {
        $staff_id = $check_user['id'];
        $user_id = $check_user_tar['id'];
    } else {
        $staff_id = $check_user_tar['id'];
        $user_id = $check_user['id'];
    }

    $check = $db->select('*')
        ->from('ims_longbing_card_user_mark')
        ->where('user_id= :user_id AND staff_id= :staff_id')
        ->bindValues(array('user_id'=>$user_id, 'staff_id' => $staff_id))
        ->row();
    $check = $db->query("SELECT * FROM `ims_longbing_card_user_mark` WHERE user_id={$user_id} && staff_id = {$staff_id}");

    if (empty($check)) {

//        file_put_contents('api.txt', 4, FILE_APPEND);
        $insert_id = $db->insert('ims_longbing_card_user_mark')->cols(array(
                'user_id'=>$user_id,
                'staff_id'=>$staff_id,
                'uniacid'=>$uniacid,
                'mark'=>1,
                'create_time'=>time(),
                'update_time'=>time())
        )->query();
//        file_put_contents('api.txt', '$insert_id' . $insert_id, FILE_APPEND);
    }
    return true;
}


// 运行所有的worker（其实当前只定义了一个）
Worker::runAll();