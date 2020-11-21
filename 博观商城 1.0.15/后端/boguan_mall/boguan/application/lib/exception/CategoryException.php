<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-23
 * Time: 17:10
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    //http状态码
    public $code = 404;
    //错误具体信息
    public $msg = '请求的分类不存在，请检查参数！';
    //自定义状态码
    public $errorcode = 10001;
}