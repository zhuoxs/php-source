<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-27
 * Time: 15:18
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code= 404;
    public $msg='订单不存在，请检查ID';
    public $errorcode= 80000;

}