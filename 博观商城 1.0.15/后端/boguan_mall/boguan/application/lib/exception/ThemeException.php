<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-23
 * Time: 14:19
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    //http状态码
    public $code = 400;
    //错误具体信息
    public $msg = '请求的Theme不存在！';
    //自定义状态码
    public $errorcode = 30000;

}