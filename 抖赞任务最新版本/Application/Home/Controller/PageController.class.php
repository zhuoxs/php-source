<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;
use Common\Model\ArticleModel;

class PageController extends HomeBaseController{

    public function index()
    {
        $list = M('page')->field('id,title,create_time')->order('sort asc,id asc')->select();
        $this->assign('title', '消息中心');
        $this->assign('list', $list);
        $this->display();
    }

    public function show()
    {
        $id = intval(I('get.id'));
        $show = M('page')->find($id);
        $this->assign('title', $show['title']);
        $this->assign('show', $show);
        $this->display();
    }
}

