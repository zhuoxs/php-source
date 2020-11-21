<?php

namespace app\controller;

use think\Db;
use think\Request;

class Homepage extends BaseController
{
    private $uid = 0;
    private $userinfo;

    public function __construct(Request $request = null)
    {

        parent::__construct($request);

        $uid = $request->param('uid/d', 0)?$request->param('uid/d', 0):session('homepage_uid');
        if ($uid <= 0) $this->error('错误的访问！', '/');
        $uinfo = Db::name('member')->where('id', '=', $uid)->cache(false, 120)->find();
        if (!$uinfo) $this->error('您要访问的会员不存在！', '/');
        $this->uid = $uid;
        session('homepage_uid',$uid);
        if(empty($uinfo['nickname'])) $uinfo['nickname']='无名氏';
        $this->userinfo = $uinfo;

        $this->assign('page_title', $uinfo['nickname'] . '的个人主页');
        $this->assign('navTopTitle', $uinfo['nickname'] . '的个人主页');

        $this->assign('shareHomepageUrl',$request->domain()."/{$uid}"); //分享链接地址
        $this->assign('userVideoTotal',Db::name('video')->where(array('user_id'=>$uid,'status'=>1,'is_check'=>1,'pid'=>0))->count());    //会员视频总数
        $this->assign('userAtlasTotal',Db::name('atlas')->where(array('user_id'=>$uid,'status'=>1,'is_check'=>1))->count());    //会员图册总数
        $this->assign('userNovelTotal',Db::name('novel')->where(array('user_id'=>$uid,'status'=>1,'is_check'=>1))->count());    //会员资讯总数

        $this->assign('userinfo',$uinfo);

    }

    /** 会员首页 */
    public function index()
    {
        //find current user's video/atlas/novel
        $videoList = Db::name('video')->where(array('user_id' => $this->uid, 'is_check' => 1, 'status' => 1, 'pid' => 0))
            ->order('add_time DESC')->limit(20)->select();
        $this->assign('videoList', $videoList);

        $atlasList = Db::name('atlas')->where(array('user_id' => $this->uid, 'is_check' => 1, 'status' => 1))
            ->order('add_time DESC')->limit(20)->select();
        $this->assign('atlasList', $atlasList);

        $novelList = Db::name('novel')->where(array('user_id' => $this->uid, 'is_check' => 1, 'status' => 1))
            ->order('add_time DESC')->limit(20)->select();
        foreach($novelList as $k =>$v){
         $novelList[$k]['tag'] = explode(",",$v['tag']);
        }
        $this->assign('novelList', $novelList);
        $tags_list = db::name('tag')->where('status = 1')->column('name','id');
        $this->assign('tags_list', $tags_list);
        return $this->fetch();
    }

    /** 视频页 */
    public function videoPage(Request $request)
    {

        $where = "user_id=" . $this->uid . " and status = 1 and is_check=1 and pid = 0 ";
        $orderCode = $request->get('orderCode');
        if (!isset($orderCode)) $orderCode = empty($request->param('orderCode')) ? 'lastTime' : $request->param('orderCode');
        switch ($orderCode) {
            case 'lastTime':
                $order = "update_time desc";
                break;
            case 'lastTimeASC':
                $order = "update_time asc";
                break;
            case 'hot':
                $order = "click desc";
                break;
            case 'hotASC':
                $order = "click asc";
                break;
            case 'reco':
                $order = "reco desc";
                break;
            case 'recoASC':
                $order = "reco asc";
                break;
            default:
                $order = "update_time desc";
                break;
        }
        $order = empty($order) ? 'id desc' : $order;
        $count = Db::name('video')->where($where)->count();
        $video_list = Db::name('video')->where($where)->field('id,title,click,good,thumbnail,play_time,reco,update_time,gold,type')
            ->order($order)->paginate(20, false, array('query' => $request->get()));
        $pages = $video_list->render();
        $this->assign('pages', $pages);
        $this->assign('count', $count);
        $this->assign('orderCode', $orderCode);
        $this->assign('video_list', $video_list);
        $this->assign('page_title', $this->userinfo['nickname'] . '的视频');
        $this->assign('navTopTitle', $this->userinfo['nickname'] . '的视频');

        return $this->fetch();
    }


    /** 图册页 */
    public function imgPage(Request $request)
    {
        $orderCode = $request->get('orderCode');
        if (!isset($orderCode)) $orderCode = empty($request->param('orderCode')) ? 'lastTime' : $request->param('orderCode');
        switch ($orderCode) {
            case 'lastTime':
                $order = "update_time desc";
                break;
            case 'lastTimeASC':
                $order = "update_time asc";
                break;
            case 'hot':
                $order = "click desc";
                break;
            case 'hotASC':
                $order = "click asc";
                break;
            case 'reco':
                $order = "reco desc";
                break;
            case 'recoASC':
                $order = "reco asc";
                break;
            default:
                $order = "update_time desc";
                break;
        }
        $order = empty($order) ? 'id desc' : $order;
        $where = "user_id=" . $this->uid . " and status = 1 and is_check=1 ";

        $count = Db::name('atlas')->where($where)->count();
        $list = Db::name('atlas')->where($where)->field('id,title,cover,click,gold,good,update_time')
            ->order($order)->paginate(20, false, array('query' => $request->get()));
        $pages = $list->render();
        $this->assign('pages', $pages);
        $this->assign('orderCode', $orderCode);
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('page_title', $this->userinfo['nickname'] . '的图册');
        $this->assign('navTopTitle', $this->userinfo['nickname'] . '的图册');

        return $this->fetch();
    }


    /** 资讯页 */
    public function infoPage(Request $request)
    {
        $where = "user_id=" . $this->uid . " AND status = 1 and is_check=1 ";
        $orderCode = $request->get('orderCode');
        if (!isset($orderCode)) $orderCode = empty($request->param('orderCode')) ? 'lastTime' : $request->param('orderCode');
        switch ($orderCode) {
            case 'lastTime':
                $order = "update_time desc";
                break;
            case 'lastTimeASC':
                $order = "update_time asc";
                break;
            case 'hot':
                $order = "click desc";
                break;
            case 'hotASC':
                $order = "click asc";
                break;
            case 'reco':
                $order = "reco desc";
                break;
            case 'recoASC':
                $order = "reco asc";
                break;
            default:
                $order = "update_time desc";
                break;
        }
        $order = empty($order) ? 'id desc' : $order;

        $tag = [];
        $list = Db::name('novel')->where($where)->field('id,title,click,good,gold,thumbnail,tag,short_info,update_time')
            ->order($order)->paginate(10, false, array('query' => $request->get()));
        foreach ($list as $k => $v) {
            $tag[$v['id']] = explode(",", $v['tag']);
        }
        //获取推荐数据
        $pages = $list->render();
        $tags_list = db::name('tag')->where('status = 1')->column('name','id');
        $this->assign('tags_list', $tags_list);
        $this->assign('pages', $pages);
        $this->assign('list', $list);
        $this->assign('tag', $tag);
        $this->assign('orderCode', $orderCode);
        $this->assign('page_title', $this->userinfo['nickname'] . '的资讯');
        $this->assign('navTopTitle', $this->userinfo['nickname'] . '的资讯');

        return $this->fetch();
    }


}
