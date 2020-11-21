<?php
/**
 * 宣传模块
 */
namespace app\controller;

use think\Request;
use think\Db;

class Share extends BaseController {

    protected function _initialize()
    {
        parent::_initialize();
    }

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->assign('page_title', '宣传');
        $this->assign('navTopTitle', '宣传');
        $this->assign('curFooterNavIndex',3);   //底部导航选中的序号
    }

    /* 手机宣传页 */
    public function index(Request $request){
        $memberId=session('member_id');
        if($memberId<=0) return $this->error('请登陆后操作!',url('index/login'));

        if(!$request->isMobile()) $this->redirect('member/member');

        $_config=get_config_by_group('base');
        $shareConfig['propaganda_reward']=$_config['propaganda_reward'];    //奖励金币个数
        $shareConfig['share_num']=$_config['share_num'];                    //每天分享有效次数

        $this->assign('shareConfig',$shareConfig);

        $memberInfo=Db::name('member')->field('money,nickname')->where("id=$memberId")->find();
        $this->assign('memberInfo',$memberInfo);

        return $this->fetch();
    }


    /**
     * 分享
     * @author frs
     * @return mixed
     */
    public function share(Request $request)
    {
        $member_id=session('member_id');
        $number = $request->param('number');
        if ($member_id!= $number) {
            $propaganda_reward = get_config('propaganda_reward');
            if ($propaganda_reward) {
                $today = strtotime(date('Y-m-d'));
                $tomorrow = $today + (24 * 3600 - 1);
                $ip = $_SERVER["REMOTE_ADDR"];
                $where = "user_id = $number  and (share_time between $today and $tomorrow)";
                $count = db::name('share_log')->where($where)->buildSql();
                //die($count);
                $share_num = get_config('share_num');
                if ($count >= $share_num) {
                    $this->redirect(url('index/index'));
                }
                $where .= " and to_ip = '$ip'";
                $log = db::name('share_log')->where($where)->find();
                if (empty($log)) {
                    $data = array(
                        'user_id' => $number,
                        'to_ip' => $ip,
                        'share_time' => time()
                    );
                    session('share', $number);
                    db::name('share_log')->insert($data);
                    $gold_log_data = array(
                        'user_id' => $number,
                        'gold' => $propaganda_reward,
                        'module' =>'share',
                        'explain'=>'分享奖励'
                    );
                    write_gold_log($gold_log_data);
                    db::name('member')->where(array('id' => $number))->setInc('money', $propaganda_reward);
                }
            }
        }
        $this->redirect('/');
    }
}