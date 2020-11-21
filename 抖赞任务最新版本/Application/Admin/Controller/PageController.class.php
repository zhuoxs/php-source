<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\CategoryModel;


class PageController extends AdminBaseController{

    private $cate;

    public function _initialize(){
        parent::_initialize();
        //$this->cate = C('PAGE_CATE');
        $this->assign('cate', $this->cate);
    }

    /**
     * 列表
     */
    public function index() {
        $map = $this->_search();

        //列表数据
        $list = $this->_list ('page', $map,'','sort asc,id asc');
        foreach( $list as &$_list ) {
            $_list['cate_name'] = $this->cate[$_list['cid']];
        }
        $this->assign('list',$list);
        $this->assign('get',$_GET);

        $this->display();
    }

    /**
     * 添加、编辑操作
     */
    public function handle() {
        $model = M ('page');
        if( IS_POST ) {
            $data = I('post.');
            $data['recommend'] = intval(I('post.recommend'));
            $id = $data[$model->getPk ()];
            if( isset($data['content']) ) $data['content'] = I('content','',false);
            if( !($id > 0) ) {
                $time = time();
                $data['create_time'] = $time;
                $data['update_time'] = $time;
                if ( $model->add ($data) ) {
                    $this->success ('新增成功!', U('index'));
                } else {
                    $this->error ('新增失败!');
                }
            } else {
                $data['update_time'] = time();
                if ($model->save ($data) !== false) {
                    $this->success ('编辑成功!', U('index'));
                } else {
                    $this->error ('编辑失败!');
                }
            }
        } else {
            $id = I('get.id');
            $info = $model->find ( $id );
            $this->assign ( 'info', $info );
            $this->display ();
        }
    }

    /**
     * 更新状态
     */
    public function update_status()
    {
        $id = I('id');
        $status = I('status');
        $field = I('field');
        $data['id'] = $id;
        $data['update_time'] = time();
        $data[$field] = $status;
        $res = M('page')->save($data);
        if( $res ) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 删除
     */
    public function delete() {
        $model = M ('page');
        $data = I('get.');
        $pk = $model->getPk();
        $id = intval($data[$pk]);
        $map[$pk] = array ('eq', $id );
        $result = $model->where($map)->delete();
        if( $result ) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}