<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-24
 * Time: 15:43
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    //http状态码
    public $code = 401;
    //错误具体信息
    public $msg = 'Token已过期或无效';
    //自定义状态码
    public $errorcode = 10001;
}