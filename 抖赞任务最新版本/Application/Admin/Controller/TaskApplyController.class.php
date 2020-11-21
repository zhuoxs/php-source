<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\CategoryModel;
use Common\Model\MemberModel;

/**
 * 申请
 */
class TaskApplyController extends AdminBaseController{
    /**
     * 列表
     */
    public function index() {
        $apply_status = C('APPLY_STATUS');
        $task_level = C('TASK_LEVEL');
        $status = I('get.status');
        $start_date = I('get.start_date');
        $end_date = I('get.end_date');
        $map = array();
        if( $status != '' ) $map['a.status'] = $status;

        //搜索时间
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( a.create_time >= {$start_date} and a.create_time < {$end_date} )";
        }

        //$map['status'] = 0;
        $model = M('task_apply')->alias('a');
        $count = $model->where($map)->count();
        $page = sp_get_page($count, 100);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;

        $list = $model->alias('a')
            ->join(C('DB_PREFIX').'task as b on a.task_id = b.id','left')
            ->join(C('DB_PREFIX').'member as c on a.member_id = c.id','left')
            ->where($map)
            ->field('a.*,b.title,b.level,b.type,c.username,c.phone')
            ->order('a.id desc')->limit("$firstRow , $listRows")
            ->select();
        foreach( $list as &$_list ) {
            $_list['status_text'] = $apply_status[$_list['status']];
            $_list['level_text'] = $task_level[$_list['level']];
        }

        $this->assign("Page", $page->show());
        $this->assign("list", $list);
        $this->assign('count', $count);

        $this->assign('get', $_GET);
        $this->display();
    }

    /**
     * 添加、编辑操作
     */
    public function handle() {
        if( IS_POST ) {
            $id = I('post.id');
            $old_status = M('task_apply')->where(array('id'=>$id))->getField('status');
            if( $old_status == 2 ) {
                $this->error('审核已通过，不可再修改');
            }
            $status = intval(I('post.status'));
            $admin_remark = I('post.admin_remark');
            $data = array();
            $data['id'] = $id;
            if( $status != '' ) $data['status'] = $status;
            $data['admin_remark'] = $admin_remark;
            $data['shenhe_time'] = time();
            //$data['update_time'] = time();

            if (M ('task_apply')->save ($data) !== false) {

                /*--------------返利逻辑------------*/
                if( $status == 2 ) {
                    $this->add_task_price($id);
                }
                /*--------------//返利逻辑------------*/

                $this->success ('编辑成功!');
            } else {
                $this->error ('编辑失败!');
            }
        } else {
            $id = I('id');
            $apply_data = M('task_apply')->find($id);
            $task_id = $apply_data['task_id'];
            $apply_data['task_title'] = M('task')->where(array('id'=>$task_id))->getField('title');
            $apply_data['username'] = M('member')->where(array('id'=>$apply_data['member_id']))->getField('username');
            $apply_status = C('APPLY_STATUS');
            $apply_data['apply_status'] = $apply_status[$apply_data['status']];
            $this->assign("info", $apply_data);

            $this->display();
        }
    }

    /**
     * 批量设置任务状态
     */
    public function batch_set_task_apply_status()
    {
        $ids = I('post.id');
        if( empty($ids) ) {
            $this->error('请选择要审核的任务');
        }
        $status = intval(I('post.status'));
        if( $status==2 || $status==-1 ) {
            foreach( $ids as $id ) {
                $res = M('task_apply')->where(array('id'=>$id))->setField('status', $status);
                if( $res && $status==2 ) {
                    $this->add_task_price($id);
                }
            }
            $this->success('操作成功');
        }
    }

    /**
     * 任务提成
     * @param $id
     */
    private function add_task_price($id) {
        $_data = M('task_apply')->where(array('id'=>$id))->find();
        //$model_member = new MemberModel();

        //任务人收入
        $this->add_sale($id, $_data['price'], $_data['member_id'], 1, '任务收入' );
        //$model_member->incPrice($_data['member_id'],$_data['price'],1,'任务收入',$id);

        $member_data = M('member')->field('id,username,level,p1,p2,p3')->where(array('id'=>$_data['member_id']))->find();

        //是否开启等级高低返佣规则
        $open_level_rule = intval(sp_cfg('open_level_rule'));

        //给直接上级返利
        if( $member_data['p1']>0 ) {
            $bfb_1 = floatval(sp_cfg('bfb_1'));
            if( $bfb_1>0 ) {
                $price_1 = $_data['price'] * $bfb_1/100;
                $price_1 = sprintf("%.2f", $price_1);
                if( $open_level_rule==1 ) {
                    $p1_level = M('member')->where(array('id'=>$member_data['p1']))->getField('level');
                    if( $p1_level>=$member_data['level'] ) {
                        $this->add_sale($id, $price_1, $member_data['p1'], 2, '一级提成，来源用户'.$member_data['username'], $member_data['id'] );
                    }
                } else {
                    $this->add_sale($id, $price_1, $member_data['p1'], 2, '一级提成，来源用户'.$member_data['username'], $member_data['id'] );
                }
            }
        }

        //二级返利
        if( $member_data['p2']>0 ) {
            $bfb_2 = floatval(sp_cfg('bfb_2'));
            if( $bfb_2>0 ) {
                $price_2 = $_data['price'] * $bfb_2/100;
                $price_2 = sprintf("%.2f", $price_2);
                if( $open_level_rule==1 ) {
                    $p2_level = M('member')->where(array('id'=>$member_data['p2']))->getField('level');
                    if(  $p2_level>=$member_data['level'] ) {
                        $this->add_sale($id, $price_2, $member_data['p2'], 2, '二级提成，来源用户'.$member_data['username'], $member_data['id'] );
                    }
                } else {
                    $this->add_sale($id, $price_2, $member_data['p2'], 2, '二级提成，来源用户'.$member_data['username'], $member_data['id'] );
                }
            }
        }

        //三级返利
        if( $member_data['p3']>0 ) {
            $p3_level = M('member')->where(array('id'=>$member_data['p3']))->getField('level');
            $ji_3 = intval(sp_cfg('ji_3'));
            if( ($ji_3==0) || ($ji_3==2 && $p3_level>=2 ) ) {
                $bfb_3 = floatval(sp_cfg('bfb_3'));
                if( $bfb_3>0 ) {
                    $price_3 = $_data['price'] * $bfb_3/100;
                    $price_3 = sprintf("%.2f", $price_3);
                    if( $open_level_rule==1 ) {
                        if( $p3_level>=$member_data['level']  ) {
                            $this->add_sale($id, $price_3, $member_data['p3'], 2, '三级提成，来源用户'.$member_data['username'], $member_data['id'] );
                        }
                    } else {
                        $this->add_sale($id, $price_3, $member_data['p3'], 2, '三级提成，来源用户'.$member_data['username'], $member_data['id'] );
                    }
                }
            }
        }
    }

    private function add_sale($apply_id,$price,$member_id,$type,$remark,$from_member_id=0)
    {
        //添加直销收入记录
        $data['member_id'] = $member_id;
        $data['from_member_id'] = $from_member_id;
        $data['order_id'] = $apply_id;
        $data['price'] = $price;
        $data['remark'] = $remark;
        $data['create_time'] = time();
        $data['type'] = $type;
        $result = M('sale_list')->add($data);
        if( $result ) {
            //添加金额变动记录
            $model_member = new MemberModel();
            $model_member->incPrice($member_id,$price,$type,$remark,$result);
        } else {
            throw_exception('添加收益失败');
        }
    }
}