<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;

class NewsController extends HomeBaseController{
    public function index()
    {
        $cid = I('get.cid');
        if( !empty($cid) ) {
            $map['cid'] = $cid;
            $cate = C('NEWS_CATE');
            $title = $cate[$cid];
        } else {
            $title = "新闻动态";
        }
        $map = array();
        $this->_list('news',$map);
        $this->assign('title', $title);
        $this->display();
    }

    public function show()
    {
        $id = intval(I('get.id'));
        $show = M('news')->find($id);
        $this->assign('show', $show);
        $this->display();
    }
}

