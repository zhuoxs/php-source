<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\LevelModel;
use Common\Model\MemberModel;
use Common\Model\NoticeModel;
use Common\Model\PayModel;
use Common\Model\SmsModel;
use Think\Model;

/**
 * 用户
 */
class MemberController extends AdminBaseController{

    /**
     * 列表
     */
    public function index() {
        $model = M('member');
        $model_level = new LevelModel();
        $member_count = $model->count();

        $member_level = LevelModel::get_member_level();
        $member_level_count = array();
        foreach( $member_level as $v ) {
            $_map = array();
            $_map['level'] = $v['level'];
            $member_level_count[$v['level']]['level'] = $v['level'];
            $member_level_count[$v['level']]['name'] = $v['name'];
            $member_level_count[$v['level']]['count'] = $model->where($_map)->count();
        }

        $map = $this->_search();
        if( I('get.level') != '' ) {
            $map['level'] = I('get.level');
        }
        if( I('get.id') != '' ) $map['id'] = I('get.id');

        $province = I('get.province');
        $city = I('get.city');
        $area = I('get.area');
        if( !empty($province) ) $map['province_id'] = $province;
        if( !empty($city) ) $map['city_id'] = $city;
        if( !empty($area) ) $map['area_id'] = $area;



        //搜索时间
        $start_date = I('get.start_date');
        $end_date = I('get.end_date');
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( create_time >= {$start_date} and create_time < {$end_date} )";
        }

        //列表数据
        $list = $this->_list ('member', $map, '', '', 30 );

        foreach($list as &$_list) {
            $member_id = $_list['id'];
            $_list['level_name'] = $member_level[$_list['level']]['name'];
            $_list['team_num'] = M('member')->where("p1=$member_id or p2=$member_id or p3=$member_id")->count();
        }
        $this->assign('list',$list);
        $this->assign('get',$_GET);

        $this->assign('member_count',$member_count);
        $this->assign('member_level_count',$member_level_count);

        //会员等级
        $member_level = LevelModel::get_member_level();
        unset($member_level[0]);
        unset($member_level[3]);
        $this->assign ( 'member_level', $member_level );

        $this->display();
    }

    /**
     * 线下充值VIP
     */
    public function recharge()
    {
        $member_id = intval(I('post.member_id'));
        $level = intval(I('post.level'));
        $member_level = LevelModel::get_member_level();
        $price = $member_level[$level]['price'];
        if( !($member_id > 0) ) {
            $this->error('会员ID参数错误');
        }
        if( !($level > 0) ) {
            $this->error('请选择要升级的级别');
        }
        if( !($price > 0) ) {
            $this->error('价格参数错误');
        }

        $data = array();
        $order_no = 'VIP'.$this->create_order_no($member_id);
        $data['order_no'] = $order_no;
        $data['member_id'] = $member_id;
        $data['price'] = $price;
        $data['create_time'] = time();
        $data['is_pay'] = 0;
        $data['level'] = $level;
        $insert_id = M('recharge')->add($data);
        if( $insert_id ) {
            $pay_model = new PayModel();
            $pay_model->pay_vip_success($insert_id,'admin',session('user.username').date('YmdHis'));
            $this->success('充值成功');
        } else {
            $this->error('充值失败');
        }
    }
    //生成订单号
    private function create_order_no($member_id) {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2017] . $member_id . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    //充值余额
    public function chongzhi()
    {
        if( IS_POST ) {
            $member_id = intval(I('post.member_id'));
            $price = floatval(I('post.price'));
            //添加金额变动记录
            $model_member = new MemberModel();
            if( $price>0 ) {
                $mark = '管理员后台充值，管理员ID：'.session('user.id');
                $res = $model_member->incPrice($member_id,$price,98,$mark);
            } else {
                $mark = '管理员后台充值，管理员ID：'.session('user.id');
                $res = $model_member->decPrice($member_id,abs($price),101,$mark);
                M('member')->where(array('id' => $member_id))->setDec('total_price', abs($price));
            }

            if( $res ) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        }
    }

    public function level() {
        echo "";
    }


    /**
     * 地区分布图
     */
    public function area()
    {
        $role = I('get.role');
        $where = "1 = 1";
        if( $role != '' ) {
            $where .= " and role = $role";
        }
        $count = M('member')->where($where)->count();
        $model = new Model();
        $sql = "select province,count(id) as count from dt_member WHERE {$where} GROUP BY province";
        $data = $model->query($sql);

        $data_str = '';
        foreach( $data as &$_data ) {
            $bfb = round(($_data['count'] / $count), 2);
            $province = $_data['province'];
            $data_str .= "['{$province}', {$bfb}],";
        }

        $this->assign('data_str',$data_str);
        $this->assign('get',$_GET);
        $this->assign('count',$count);
        $this->display();
    }

    public function handle() {
        $model = M ('member');
        if( IS_POST ) {
            $id = intval(I('post.id'));
            if( !($id>0) ) {
                $this->error('参数错误');
            }
            $data = I('post.');
            if( !empty($data['password']) ) {
                $data['password'] = sp_encry($data['password']);
            } else {
                unset($data['password']);
            }
            if ($model->save ($data) !== false) {
                $this->success ('操作成功!');
            } else {
                $this->error ('操作失败!');
            }
        } else {
            $data = I('get.');
            $id = intval($data[$model->getPk()]);
            if( $id > 0) {
                $info = $model->find ( $id );
                $this->assign ( 'info', $info );
            }

            $member_level = LevelModel::get_member_level();
            $this->assign ( 'member_level', $member_level );

            $this->display ();
        }
    }

    //会员团队
    public function team_show() {
        $model = M ('member');
        $id = I('get.id');
        $info = $model->find ( $id );
        $this->assign ( 'info', $info );

        //一级
        $list1 = $model->field('id,nickname,head_img,create_time')
            ->where(array('p1'=>$id))
            ->order('id desc')
            ->select();
        $this->assign("list1", $list1);

        //二级
        $list2 = $model->field('id,nickname,head_img,create_time')
            ->where(array('p2'=>$id))
            ->order('id desc')
            ->select();
        $this->assign("list2", $list2);

        //三级
        $list3 = $model->field('id,nickname,head_img,create_time')
            ->where(array('p3'=>$id))
            ->order('id desc')
            ->select();
        $this->assign("list3", $list3);

        $this->display ();
    }

    /**
     * 调整用户pid
     *
    1	0	0	0
    2	1	0	0
    3	2	1	0
    4	3	2	1
    5	4	3	2
    6	5	4	3
    7	6	5	4
    8	7	6	5
    8_1	7	6	5
    8_2	7	6	5
    9	8	7	6
    9_1	8	7	6

    7调整到4旗下
    7	4	3	2
    8	7	4	3
    8_1	7	4	3
    8_2	7	4	3
    9	8	7	4
    9_1	8	7	4

     */
    public function set_pid() {

        if( IS_POST ) {
            $member_model = M('member');
            $pid = I('post.pid');
            $member_id = I('post.member_id');

            //pid的上一级
            $tid = $member_model->where(array('id'=>$pid))->getField('p1');
            $tid = intval($tid);

            $res = $member_model->where(array('id'=>$member_id))->setField('p1',$pid);
            if( $res ) {
                #p1的关系不用变

                //变动P2的关系
                $m1_list = $member_model->where(array('p1'=>$member_id))->select();
                foreach( $m1_list as $_list ) {
                    //更改p2关系
                    $member_model->save(array('id'=>$_list['id'],'p2'=>$pid));
                    //更改P3的关系
                    $member_model->save(array('id'=>$_list['id'],'p3'=>$tid));
                }

                //变动P3的关系
                $m2_list = $member_model->where(array('p2'=>$member_id))->select();
                foreach( $m2_list as $_list ) {
                    //更改p2关系
                    $member_model->save(array('id'=>$_list['id'],'p2'=>$member_id));

                    //更改p3关系
                    $member_model->save(array('id'=>$_list['id'],'p3'=>$pid));
                }
            }

            $this->success('操作成功');
        }

    }
}