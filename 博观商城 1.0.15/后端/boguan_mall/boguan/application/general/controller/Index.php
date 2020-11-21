<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2019-4-10
 * Time: 10:44
 */

namespace app\general\controller;


class Index extends Base
{

    public function index(){

    }

    public function success()
    {
        return $this->fetch();
    }
    public function error()
    {
        return $this->fetch();
    }
}