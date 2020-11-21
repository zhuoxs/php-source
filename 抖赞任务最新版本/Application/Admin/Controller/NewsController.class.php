<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\CategoryModel;

/**
 * 广告
 */
class NewsController extends AdminBaseController{

    private $cate;

    public function _initialize(){
        parent::_initialize();
        $this->cate = C('NEWS_CATE');
        $this->assign('cate', $this->cate);
    }

    /**
     * 列表
     */
    public function index() {
        $map = $this->_search();
        //列表数据
        $list = $this->_list ('news', $map );
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
        $model = M ('news');
        if( IS_POST ) {
            $data = I('post.');
            foreach($data as $key=>$val){
                if(is_array($val)){
                    $data[$key] = implode(',', $val);
                }
            }

            $id = $data[$model->getPk ()];
            if( isset($data['content']) ) $data['content'] = I('content','',false);
            if( !($id > 0) ) {
                $data['create_time'] = time();
                if ( $model->add ($data) ) {
                    $this->success ('新增成功!', U('index'));
                } else {
                    $this->error ('新增失败!');
                }
            } else {
                if ($model->save ($data) !== false) {
                    $this->success ('编辑成功!', U('index'));
                } else {
                    $this->error ('编辑失败!');
                }
            }
        } else {
            $data = I('get.');
            $id = intval($data[$model->getPk()]);
            if( $id > 0) {
                $info = $model->find ( $id );
                $this->assign ( 'info', $info );
            }
            $this->display ();
        }
    }

    /**
     * 删除
     */
    public function delete() {
        $model = M ('news');
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