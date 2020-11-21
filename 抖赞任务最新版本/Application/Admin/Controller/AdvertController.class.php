<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\CategoryModel;

/**
 * 广告
 */
class AdvertController extends AdminBaseController{

    private static $cate = array(
        '1' => '首页Banner',
        '2' => '首页icon',
        '3' => '首页中部横幅广告',
    );

    public function _initialize(){
        parent::_initialize();
        $this->assign('cate', self::$cate);
    }

    /**
     * 列表
     */
    public function index() {
        $map = $this->_search();
        $cid = I('get.cid');
        if( $cid!='' ) $map['cid'] = $cid;
        //列表数据
        $list = $this->_list ('advert', $map,'','cid asc,sort asc,id asc',100 );
        foreach( $list as &$_list ) {
            $_list['cate_name'] = self::$cate[$_list['cid']];
        }
        $this->assign('list',$list);
        $this->assign('get',$_GET);
        $this->display();
    }

    /**
     * 添加、编辑操作
     */
    public function handle() {
        $model = M ('advert');
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
                    $this->redirect('index');
                    //$this->success ('编辑成功!', U('index'));
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
        $model = M ('advert');
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