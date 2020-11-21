<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;
use Common\Model\LevelModel;

class TaskController extends HomeBaseController{
    public function index()
    {
        //完成任务动态
        $finish_task_apply_list = M('member_price_log')->alias('a')
            ->join(C('DB_PREFIX').'member as b on a.member_id = b.id','left')
            ->where(array('a.type'=>array('elt',3)))
            ->field('a.*,b.username')
            ->limit(20)->select();
        foreach($finish_task_apply_list as &$_list) {
            $username = sp_substr_cut($_list['username']);
            $price = floatval($_list['price']);
            if( $_list['type'] == 1 ) {
                $_list['text'] = "恭喜{$username}获得任务奖励{$price}元。";
            }elseif( $_list['type'] == 2 ) {
                $_list['text'] = "恭喜{$username}获得下级返佣奖励{$price}元。";
            }elseif( $_list['type'] == 3 ) {
                $_list['text'] = "恭喜{$username}获得{$price}元推荐奖励。";
            }
        }
      
        $list = M('page')->field('id,title,create_time')->order('sort asc,id asc')->limit(1000)->select();
        $this->assign('list', $list);
      
      
        $this->assign('finish_task_apply_list',$finish_task_apply_list);
        $this->assign('title','任务中心');
        $this->display();
    }

    public function lists_sub()
    {
        $level_title = C('TASK_LEVEL');
        $level = I('get.level');

        //供应信息
        $task_list['type_0'] = M('task')->where(array('type'=>0,'status'=>1,'level'=>$level))->limit(1000)->order('id desc')->select();
        //需求信息
        $task_list['type_1'] = M('task')->where(array('type'=>1,'status'=>1,'level'=>$level))->limit(1000)->order('id desc')->select();
        $this->assign('task_list',$task_list);
        $this->assign('title', $level!='' ? $level_title[$level] : '任务大厅');



        $this->display();
    }
  
    public function lists_lb()
    {
        
        $level = I('get.lb');

        //供应信息
        $task_list['type_0'] = M('task')->where(array('type'=>0,'status'=>1,'tasklb'=>$level))->limit(1000)->order('id desc')->select();
        //需求信息
        $task_list['type_1'] = M('task')->where(array('type'=>1,'status'=>1,'tasklb'=>$level))->limit(1000)->order('id desc')->select();
        $this->assign('task_list',$task_list);
      	$lb = $level == 1 ? '抖音' :'快手';
        $this->assign('title', $lb.'-任务大厅');

        $this->display();
    }

  
  

    public function lists()
    {
        $map = array();
        $level = I('get.level');
        if( !empty($cid) ) {
            $map['level'] = $level;
        }
        $type = I('get.type');
        if( $type!='' ) $map['type'] = $type;
        $this->_list('task',$map);

        if( $type==0 ) {
            $title = "发布的供应信息";
        } elseif($type==1 ) {
            $title = "发布的需求信息";
        } else {
            $title = "任务大厅";
        }
        $this->assign('title',$title);
        $this->display();
    }

    public function show()
    {
        $id = intval(I('get.id'));
        $show = M('task')->find($id);
        $this->assign('show', $show);

        //检测是否已领取
        $member_id = $this->get_member_id();
        $check_apply = M('task_apply')->where(array('task_id'=>$id,'member_id'=>$member_id))->find();


        if( $show['end_time'] > time() ) {
            if( empty($check_apply) ) {
                if( $show['apply_num'] < $show['max_num'] ) {
                    $btn_status = 1;
                    $status_text = "领取任务";
                } else {
                    $btn_status = 0;
                    $status_text = "任务名额已满";
                }
            } else {
                $btn_status = 0;
                $status_text = "已领取，点击提交";
            }
        } else {
            $btn_status = 0;
            $status_text = "任务已过期";
        }
        $this->assign('btn_status', $btn_status);
        $this->assign('status_text', $status_text);
        $this->assign('member_client_info', session('member_client_info'));
        $this->display();
    }

    /**
     * 待提交的任务
     */
    public function submission_task()
    {
        if( !$this->is_login() ) {
            $this->error("请先登录");
        }
        $member_id = $this->get_member_id();

        $map = array();
        $map['a.member_id'] = $member_id;
        $map['a.status'] = array('eq',0);
        $model = M('task_apply');
        $count = $model->alias('a')->where($map)->count();
        $page = sp_get_page_m($count, 10);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;

        $list = $model->alias('a')
            ->join(C('DB_PREFIX').'task as b on a.task_id = b.id','left')
            ->where($map)
            ->field('a.*,b.title')
            ->order('a.id desc')->limit("$firstRow , $listRows")
            ->select();

        $this->assign("Page", $page->show());
        $this->assign("list", $list);
        $this->assign('count', $count);

        $this->assign('title','选择提交的任务');
        $this->display();
    }

    //提交任务
    public function submission_task_do()
    {
        if( !$this->is_login() ) {
            $this->error("请先登录");
        }
        $member_id = $this->get_member_id();

        $id = I('id');
        $apply_data = M('task_apply')->find($id);
        if( $member_id != $apply_data['member_id'] ) {
            $this->error('没有权限');
        }
        if( $apply_data['status'] == 2 ) {
            $this->error('任务已完成，请勿重复提交');
        }

        if( IS_POST ) {
            $file = I('post.file');
            if( empty($file) ) {
                $this->error('请上传任务截图');
            }

            $data['id'] = $id;
            $data['file'] = $file;
            $data['update_time'] = time();
            $data['status'] = 1;//状态改为已提交
            $result = M('task_apply')->save($data);
            if($result) {
                $this->success('任务提交成功',U('submission_task'));
            } else {
                $this->error('任务提交失败');
            }
        } else {

            $task_id = $apply_data['task_id'];
            $apply_data['task_title'] = M('task')->where(array('id'=>$task_id))->getField('title');
            $apply_status = C('APPLY_STATUS');
            $apply_data['apply_status'] = $apply_status[$apply_data['status']];
            $this->assign("apply_data", $apply_data);

            $this->display();
        }
    }

    /**
     * 领取任务
     */
    public function get_task()
    {
        if( !$this->is_login() ) {
            $this->error("请先登录");
        }
        $member_id = $this->get_member_id();
        $id = intval(I('post.id'));
        if( !($id>0) ) {
            $this->error("参数错误");
        }
        $member_level = M('member')->where(array('id'=>$this->get_member_id()))->getField('level');
		
       
        $task_data = M('task')->field('level,price,max_num,apply_num,end_time')->where(array('id'=>$id))->find();

        if( $task_data['end_time']<time() ) {
            $this->error('该任务已过期');
        }

        $level_list = LevelModel::get_member_level();
        if( $member_level < $task_data['level'] ) {
            $this->error("您的会员等级不能领取{$level_list[$task_data['level']]['name']}的任务。");
        }

        //检测是否已领取
        $check_apply = M('task_apply')->where(array('task_id'=>$id,'member_id'=>$member_id))->find();
        if( $check_apply ) {
            $this->error('您已经领取过该任务了');
        }

        //检测名额
        if( $task_data['apply_num'] >= $task_data['max_num'] ) {
            $this->error("任务名额已满");
        }
      	
      	$task_limit =  M('level')->where(array('level'=>$member_level ))->getField('day_limit_task_num');
      	$today_time = strtotime(date("Ymd"));
      	$where = " create_time > $today_time and member_id=".($this->get_member_id())." ";
      	
        $task_limit_count = M('task_apply')->where( $where )->count();
      	if( $task_limit_count >= $task_limit && $task_limit > 0 )
        {
        	  $this->error('您当前的会员等级每天只能领取'.$task_limit.'个任务，您今日已经达到上限了哦！');
        }
      

        //写入数据
        $time = time();
        $data['task_id'] = $id;
        $data['member_id'] = $member_id;
        $data['price'] = $task_data['price'];
        $data['status'] = 0;
        $data['create_time'] = $time;
        $data['update_time'] = $time;
        $result = M('task_apply')->add($data);
        if( $result ) {
            M('task')->where(array('id'=>$id))->setInc('apply_num',1);
            $this->success('任务领取成功');
        } else {
            $this->error("领取失败");
        }
    }
}