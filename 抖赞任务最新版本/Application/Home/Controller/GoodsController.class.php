<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;
use Think\Db;

class GoodsController extends HomeBaseController{

    //商品列表
    public function index()
    {
        $map['status'] = 1;
        $list = M('goods')->where($map)->select();
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 显示商品内容
     */
    public function show()
    {
        $id = intval(I('get.id'));
        $data = M('goods')->find($id);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 我的积分
     */
    public function my()
    {
        $this->display();
    }

    /**
     * 兑换记录
     */
    public function exchange()
    {
        $this->display();
    }
}

