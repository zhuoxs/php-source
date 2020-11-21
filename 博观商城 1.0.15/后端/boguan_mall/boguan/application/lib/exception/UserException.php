<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-26
 * Time: 16:29
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code= 401;
    public $msg= '用户不存在';
    public $errorcode= 60000;

}