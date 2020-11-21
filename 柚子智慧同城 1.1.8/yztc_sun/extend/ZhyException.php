<?php
use think\Exception;

class ZhyException extends Exception {
    function __construct($message = "", $code = 1, Throwable $previous = null)
    {
        echo json_encode(array(
            'code'=>$code,
            'msg'=>$message,
        ));
        exit;
    }
}