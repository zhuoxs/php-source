<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/8/20
 * Time: 18:01
 */
include_once __DIR__.'/HttpClient.class.php';

class Feie
{
    public $ip = 'api.feieyun.cn';
    public $port = 80;
    public $path = '/Api/Open/';
    public $user = '';
    public $ukey = '';
    public $sn = '';
    public $time = 0;
    public $sig = '';

    public function __construct($user,$ukey,$sn)
    {
        $this->user = $user;
        $this->ukey = $ukey;
        $this->sn = $sn;
    }

    //打印
    function print_fe($orderInfo,$times =1){
        $time = time();
        $content = array(
            'user'=>$this->user,
            'stime'=>$time,
            'sig'=>sha1($this->user.$this->ukey.$time),
            'apiname'=>'Open_printMsg',

            'sn'=>$this->sn,
            'content'=>$orderInfo,
            'times'=>$times//打印次数
        );

        $client = new HttpClient($this->ip,$this->port);
        if(!$client->post($this->path,$content)){
            return array('code'=>1,'msg'=>'连接异常');
        }
        //服务器返回的JSON字符串，建议要当做日志记录起来
        $ret = $client->getContent();
        $ret = (array)json_decode($ret);
        if ($ret['msg'] != 'ok'){
            return array('code'=>1,'msg'=>$ret['msg']);
        }
        return array('code'=>0,'msg'=>'操作成功');

    }
}