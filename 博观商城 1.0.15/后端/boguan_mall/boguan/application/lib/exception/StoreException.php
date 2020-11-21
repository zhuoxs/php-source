<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-7-16
 * Time: 9:42
 */

namespace app\lib\exception;


class StoreException extends BaseException
{
    //http状态码
    public $code = 400;
    //错误具体信息
    public $msg = '请求失败，请检查参数！';
    //自定义状态码
    public $errorcode = 10001;

}