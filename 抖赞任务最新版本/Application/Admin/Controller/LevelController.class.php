<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\LevelModel;

class LevelController extends AdminBaseController{
    /**
     * 列表
     */
    public function index() {
        $map = $this->_search();
        $model = M('level');
        $list = $model->order('id asc')->select();
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 添加、编辑操作
     */
    public function add() {
        $model = M('level');
        if( IS_POST ) {
            $data = I('post.');
            if ( $model->add ($data) ) {
                $this->success ('新增成功!');
            } else {
                $this->error ('新增失败!');
            }
        }
    }

    /**
     * 添加、编辑操作
     */
    public function edit() {
        $model = M('level');
        if( IS_POST ) {
            $data = I('post.');
            if ($model->save ($data) !== false) {
                $this->success ('编辑成功!');
            } else {
                $this->error ('编辑失败!');
            }
        }
    }
}
