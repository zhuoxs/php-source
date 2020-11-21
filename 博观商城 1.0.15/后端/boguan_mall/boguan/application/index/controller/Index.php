<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {

       //return $this->redirect(url('boguan/index/index'));
       // echo 'You can\'t get in here';
        return $this->fetch();
    }
}
