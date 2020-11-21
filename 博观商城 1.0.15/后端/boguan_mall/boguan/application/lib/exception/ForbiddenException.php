<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-27
 * Time: 10:16
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code= 403;
    public $msg= '权限不够';
    public $errorcode= 10001;

}