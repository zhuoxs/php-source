<?php

namespace app\controller;

use think\Controller;
use think\Request;

class Error extends Controller
{

    public function index(Request $request)
    {
        $this->redirect('/');
        $this->fetch();
    }

    public function _empty(){
        $this->redirect('/');
    }

    /** 站点已关闭 */
    public function siteClose(){
        $this->error('站点正在维护中……',null,'',100);
    }

    /** 手机站关闭 */
    public function wapClose(){
        $this->error('手机站未开启，请访问PC端网站.',null,'',100);
    }

}