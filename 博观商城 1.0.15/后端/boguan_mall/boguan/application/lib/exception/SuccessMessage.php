<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-26
 * Time: 16:44
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code= 201;
    public $msg= 'ok';
    public $errorCode= 1;

}