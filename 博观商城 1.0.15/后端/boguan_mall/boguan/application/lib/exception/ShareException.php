<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-7-12
 * Time: 17:18
 */

namespace app\lib\exception;


class ShareException extends BaseException
{
    //http状态码
    public $code = 200;
    //错误具体信息
    public $msg = '请求失败，请检查参数！';
    //自定义状态码
    public $errorcode = 10001;

}