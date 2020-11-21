<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\CategoryModel;


class FeedbackController extends AdminBaseController{

    public function index() {

        $start_date = I('get.start_date');
        $end_date = I('get.end_date');
        $status = I('get.status');

        $map = array();
        if( $status != '' ) $map['a.status'] = $status;

        //搜索时间
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( a.create_time >= {$start_date} and a.create_time < {$end_date} )";
        }

        $model = M('feedback')->alias('a');
        $count = $model->where($map)->count();
        $page = sp_get_page($count, 20);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;

        $list = M('feedback')->alias('a')->join(C('DB_PREFIX').'member as c on a.member_id = c.id','left')
            ->where($map)
            ->field('a.*,c.nickname,c.phone')
            ->order('a.id desc')->limit("$firstRow , $listRows")
            ->select();
        $this->assign('list',$list);
        $this->assign('get',$_GET);
        $this->display();
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
        $res = M('feedback')->save($data);
        if( $res ) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

}