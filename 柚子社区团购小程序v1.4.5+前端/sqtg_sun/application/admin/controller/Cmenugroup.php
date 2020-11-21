<?php
namespace app\admin\controller;

use app\base\controller\Admin;

class Cmenugroup extends Admin
{
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model;
        $info->index = 999;
        $this->view->info = $info;
        return view('edit');
    }
}
