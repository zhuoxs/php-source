<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\CategoryModel;

/**
 * 系统消息
 */
class NoticeController extends AdminBaseController{


    /**
     * 列表
     */
    public function index() {
        $map = $this->_search();
        $map['is_system'] = 1;
        $model = M(CONTROLLER_NAME);
        if (! empty ( $model )) {
            $this->_list ( CONTROLLER_NAME, $map );
        }
        $this->display();
    }

    /**
     * 添加、编辑操作
     */
    public function add() {
        if( IS_POST ) {
            $msg = I('post.msg');
            if( sp_len($msg) > 512 ) {
                $this->error('消息长度不能超过512个字符');
            }
            if( empty($msg) ){
                $this->error('消息不能为空');
            }
            $member_id = intval(I('post.member_id'));
            if( !($member_id > 0) ) {
                $data['is_system'] = 1;
                $data['role_type'] = I('post.role_type');
            }
            $data['msg'] = $msg;
            $data['create_time'] = time();
            $data['member_id'] = $member_id;

            $result = M('notice')->add($data);
            if( $result ) {
                $this->success('添加成功', U('index'));
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->display ();
        }
    }
}