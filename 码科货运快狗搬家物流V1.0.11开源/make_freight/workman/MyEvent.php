<?php

use GatewayWorker\Lib\Gateway;


class MyEvent
{

    public static function onMessage($client_id, $message){
        $data = json_decode($message,true);
        if(!isset($data['heart'])){
            echo date("Y-m-d H:i:s");
            var_dump($message);
        }

        if(isset($data['type']) && strtolower($data['type']) == 'binduid'){
            self::bindUid($client_id,$data);
        }
        Gateway::sendToClient($client_id,$message);
    }

    public static function onWebSocketConnect($client_id, $data)
    {

    }

    public static function onConnect($client_id)
    {

    }

    protected static function bindUid($client_id,$data){
        if( !isset($data['uid']) || empty($data['uid']) ){
            return false;
        }
        Gateway::bindUid($client_id,$data['uid']);
    }

}