<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\CategoryModel;


class GoodsController extends AdminBaseController{


    public function _initialize(){
        parent::_initialize();
    }

    /**
     * 列表
     */
    public function index() {
        $map = $this->_search();
        $keyword = I('get.keyword');
        $status = I('get.status');
        $recommend = I('get.recommend');
        if( intval(I('get.cid')) > 0 ) $map['cid'] = intval(I('get.cid'));
        if( !empty($keyword) ) $map['title'] = array('like', "%".$keyword."%");

        if( $status != '' ) $map['status'] = $status;

        if( $recommend != '' ) $map['recommend'] = $recommend;

        //列表数据
        $list = $this->_list ('goods', $map, '','sort asc, id desc' );

        //分类名称
        $cate = CategoryModel::get_list_val_key();
        foreach( $list as &$_list ) {
            $_list['category_name'] = $cate[$_list['cid']];
            if( $_list['member_id'] > 0 ) {
                $_list['add_user'] = M('member')->where(array('id'=>$_list['member_id']))->getField('nickname');
            } else {
                $_list['add_user'] = '管理员';
            }

            if( $_list['status'] == 0 ) {
                $_list['status_text'] = '未审核';
            } elseif ( $_list['status'] == 1 ) {
                $_list['status_text'] = '已审核';
            } elseif( $_list['status'] == -1 ) {
                $_list['status_text'] = '审核不通过';
            }

            //评论数
            $_list['comment_count'] = M('comment')->where(array('goods_id'=>$_list['id']))->count();
        }
        $this->assign('list',$list);

        $category_list = D('Category')->getTreeData('tree','order_number,id');
        $this->assign ( 'category_list', $category_list );

        $this->assign('get',$_GET);
        $this->display();
    }

    /**
     * 添加、编辑操作
     */
    public function handle() {
        $model = M ('goods');
        if( IS_POST ) {
            $data = I('post.');//所有表单信息
            // print_r($data);die;
            foreach($data as $key=>$val){
                if(is_array($val)){
                    $data[$key] = implode(',', $val);
                }
            }

            $city_id = $data['city_id'];//市id
            /*if( !($city_id > 0) ) {
                $this->error ('请选择城市!');
            }*/
            $city_name = M('province_city_area')->where(array('id'=>$city_id))->getField('name');
            $data['city_name'] = $city_name;//市名称
            $data['city_char'] = sp_getfirstchar($city_name);//获取汉字的首字母

            $data['recommend'] = intval($data['recommend']);

            $id = $data['id'];
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
            $cid = I('get.cid');
            $id = intval($data[$model->getPk()]);
            if( $id > 0) {
                $info = $model->find ( $id );
                if( $cid != '' ) {
                    $info['cid'] = I('get.cid');
                }
            } else {
                $info['cid'] = $cid;
            }
            $this->assign ( 'info', $info );

            //分类模板
            if( $cid > 0 ) {
                $tpl = M('category')->where(array('id'=>$cid))->getField('tpl');
            } elseif( isset($info['cid']) ) {
                $tpl = M('category')->where(array('id'=>$info['cid']))->getField('tpl');
            } else {
                $tpl = '';
            }

            $category_list = D('Category')->getTreeData('tree','order_number,id');
            //unset($category_list[C('VIDEO_CATE_ID')]);
            $this->assign ( 'category_list', $category_list );

            $this->display ($tpl);
        }
    }

    public function update_status()
    {
        $id = intval(I('post.id'));
        $status = intval(I('post.status'));
        $data['id'] = $id;
        $data['status'] = $status;
        $result = M('goods')->save($data);
        if( $result ) {
            $this->success('更新成功');
        } else {
            $this->error('更新失败');
        }
    }
}