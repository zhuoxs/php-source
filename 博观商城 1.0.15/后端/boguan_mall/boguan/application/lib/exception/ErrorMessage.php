<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-26
 * Time: 16:44
 */

namespace app\lib\exception;


class ErrorMessage extends BaseException
{
    public $code= 400;
    public $msg= 'fail';
    public $errorCode= 0;

}