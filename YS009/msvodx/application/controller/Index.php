<?php
namespace app\controller;

use think\Db;
use think\Request;
class Index extends BaseController
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('curFooterNavIndex',1);   //底部导航选中的序号
    }

    public function demo()
    {

        //-----------------模板说明---------------start-----------------------------------------------------------

        //说明：模板渲染直接用view(),会自动渲染至  /public/tpl/default下对应的模板  $dreamer 2017/11/21

        //-----------------模板说明---------------end-------------------------------------------------------------

        $demoRs=Db::name('admin_config')->select();


        return view('',['data'=>['a'=>1,'b'=>2]]);

    }

    public function index(){
        //给模版给以一个当前时间戳的值
        $this->assign('demo_time',$this->request->time());
        $resourceLimit=get_config('homepage_resource_num')?(int)get_config('homepage_resource_num'):8;

        header("content-type:text|html;charset=utf-8");
        //焦点图
        $banner = Db::name('banner')->where(array('status'=>1))->field('url,images_url,target,info')->order('sort asc')->select();
        //推荐视频
        $recom_list =  Db::name('video')->where(array('status'=>1,'reco'=>array('neq','0'),'is_check'=>1, 'pid' => 0 ))->order('reco desc,update_time desc')->field('id,title,click,good,thumbnail,play_time,gold,update_time')->limit($resourceLimit)->select();
        //最热视频
        $hot_list =  Db::name('video')->where(array('status'=>1,'is_check'=>1, 'pid' => 0))->order('click desc')->field('id,title,click,good,thumbnail,play_time,gold,update_time')->limit($resourceLimit)->select();
        //最新视频
        $new_list =  Db::name('video')->where(array('status'=>1,'is_check'=>1, 'pid' => 0))->order('update_time desc')->field('id,title,click,good,thumbnail,play_time,update_time,gold,update_time')->limit($resourceLimit)->select();
        //获取分类数据
        $list_data =  Db::name('class')->where(array('status'=>1,'home_dispay'=>1))->order('sort asc')->field('id,name,type')->select();
        $notice = Db::name('notice')->where(array('status'=>1,'out_time'=>array('gt',time())))->order('sort asc')->field('id,title,type,url,content')->select();
        $video_list = $image_list = $novel_list = array();
        foreach ($list_data as $k=>$v){
            $where =array(
                'status' =>1,
                'class' =>$v['id'],
                'is_check'=>1
            );
            switch ($v['type'])
            {
                case 1:
                    $db = Db::name('video');
                    $where['pid'] = 0;
                    $field = 'id,title,click,good,thumbnail,play_time,gold,update_time';
                    $v['list'] = $db->where($where)->field($field)->order('update_time desc')->limit($resourceLimit)->select();
                    $video_list[] = $v;
                    break;
                case 2:
                    $db = Db::name('atlas');
                    $field = 'id,title,click,good,cover,update_time,gold,update_time';
                    $v['list'] = $db->where($where)->field($field)->order('update_time desc')->limit($resourceLimit)->select();
                    $image_list[] = $v;
                    break;
                case 3:
                    $db = Db::name('novel');
                    $field = 'id,title,click,good,update_time,gold,update_time,thumbnail';
                    $v['list'] = $db->where($where)->field($field)->order('update_time desc')->limit($resourceLimit)->select();
                    $novel_list[] = $v;
                    break;
            }
        }
        $this->assign('page_title', '高清视频');
        $this->assign('navTopTitle', '高清视频');
        $this->assign('notice', $notice);
        $this->assign('banner', $banner);
        $this->assign('recom_list', $recom_list);
        $this->assign('hot_list', $hot_list);
        $this->assign('new_list', $new_list);
        $this->assign('video_list', $video_list);
        $this->assign('image_list', $image_list);
        $this->assign('novel_list', $novel_list);
        return view();
    }

     //视频试看完成提示页
     public function prompt(Request $request){
         $project_id=$request->param('id');
         $user_id=session('member_id');
         if(intval($user_id)<=0){
          $msg='试看结束！  登录后您将享受更多的权益！';
          $buttom='登录';
          $url='javascript:history.go(-1);';
         }else{
            $info =Db::name('video')->where(['id'=>$project_id])->find();
            $menber_info =get_member_info($user_id);
            if($menber_info['isVip']){
                $this->redirect('video/play',['id'=>$project_id]);
            }elseif(intval($info['gold'])>intval($menber_info['money'])){
                $msg='试看结束！ 您金币不足，请充值后观看完整版！';
                $buttom='充值';
                $url=url('system_pay/recharge',['type'=>1]);    //type eq 1 is gold ,else val is vip
            }elseif(!$menber_info['isVip']){
                $msg='试看结束！ 升级VIP后可免费观看全站资源！';
                $buttom='升级VIP';
                $url=url('system_pay/recharge');
            }
         }
         $this->assign('url',$url);
         $this->assign('buttom',$buttom);
         $this->assign('msg',$msg);
         $this->assign('page_title', '温馨提示');
         $this->assign('navTopTitle', '温馨提示');
         return $this->fetch();
     }

     //提示页
     public function remind(){
         return $this->fetch();
     }

    //登录
    public function login(Request $request)
    {
        if(check_is_login() == 1 ) $this->redirect('member/member');
        $header=request()->header();
        if(isset($header['referer'])){
            $refererUrl = ($header['referer'] == url('member/seek_pwd', array('status' => 1))) ? url('member/member') : $header['referer'] ;
        }else{
            $refererUrl=url('member/member');
        }
        $this->assign('refererUrl',$refererUrl);
        $this->assign('page_title', '会员登陆');
        $this->assign('navTopTitle', '会员登陆');
        return view();
    }

    //注册
    public function register(Request $request)
    {
        if(check_is_login() == 1 ) $this->redirect('member/member');
        $this->assign('page_title', '注册会员');
        $this->assign('navTopTitle', '注册会员');
        return view();
    }


}
