<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-24
 * Time: 14:22
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    //http状态码
    public $code = 400;
    //错误具体信息
    public $msg = '微信服务器调用接口失败';
    //自定义状态码
    public $errorcode = 999;

}