<?php
namespace app\controller;


class Agent extends BaseController {


    /*  代理商首页 */
    public function index(){
        return $this->fetch();
    }
}