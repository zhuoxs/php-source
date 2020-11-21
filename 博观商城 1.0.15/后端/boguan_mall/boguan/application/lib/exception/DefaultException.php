<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-7-19
 * Time: 14:51
 */

namespace app\lib\exception;


class DefaultException extends BaseException
{
    public $code= 400;
    public $msg= 'Default exception';
    public $errorCode= 10000;

}