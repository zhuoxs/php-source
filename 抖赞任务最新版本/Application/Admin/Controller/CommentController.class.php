<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\CategoryModel;


class CommentController extends AdminBaseController{

    /**
     * 列表
     */
    public function index() {
        $map = $this->_search();
        $goods_id = I('get.goods_id');
        if( !empty($goods_id) ) $map['goods_id'] = $goods_id;

        $model = M(CONTROLLER_NAME);
        if (! empty ( $model )) {
            $this->_list ( CONTROLLER_NAME, $map );
        }
        $this->assign ( 'goods_id', $goods_id );
        $this->display();
    }


    public function handle() {
        $model = M ( CONTROLLER_NAME );
        if( IS_POST ) {
            $data = I('post.');
            foreach($data as $key=>$val){
                if(is_array($val)){
                    $data[$key] = implode(',', $val);
                }
            }

            $id = $data[$model->getPk ()];
            if( isset($data['content']) ) $data['content'] = I('content','',false);
            $data['status'] = 1;
            if( !($id > 0) ) {
                $data['create_time'] = time();
                if ( $model->add ($data) ) {
                    $this->success ('新增成功!');
                } else {
                    $this->error ('新增失败!');
                }
            } else {
                if ($model->save ($data) !== false) {
                    $this->success ('编辑成功!',U('index',array('goods_id'=>$data['goods_id'])));
                } else {
                    $this->error ('编辑失败!');
                }
            }
        } else {
            $goods_id = I('get.goods_id');
            $data = I('get.');
            $id = intval($data[$model->getPk()]);
            if( $id > 0) {
                $info = $model->find ( $id );
                $this->assign ( 'info', $info );
                $goods_id = $info['goods_id'];
            }
            $this->assign ( 'goods_id', $goods_id );
            $this->display ();
        }
    }

    /*public function add(){
        $group_data['name'] = I('post.name');
        $group_id = M('goods_group')->add($group_data); //新添加的组ID

        if( $group_id ) {
            //产品名称
            $product_name = I('post.name');
            //产品图片
            $product_img = I('post.img');
            //编号 array
            $product_number = I('post.number');

            $number_array = explode(PHP_EOL, $product_number);
            foreach( $number_array as $v ) {
                $data = array();
                $data['name'] = $product_name;
                $data['product_img'] = $product_img;
                $data['number'] = $v; //商品编号
                $data['group_id'] = $group_id; //共同组ID
                M('product')->add($data);
            }
        }
    }*/

}