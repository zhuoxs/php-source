<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-7-17
 * Time: 16:27
 */

namespace app\lib\exception;


class CashException extends BaseException
{
    public $code= 400;
    public $msg='申请提现失败';
    public $errorcode= 10000;

}