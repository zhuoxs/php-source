<?php
namespace app\admin\controller;

use think\Controller;

class Error extends Controller{
    public function _empty(){
        $this->redirect('index/index');
    }
}