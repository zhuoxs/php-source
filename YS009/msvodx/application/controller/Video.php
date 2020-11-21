<?php
/**
 * 视频控制器类
 */

namespace app\controller;

use think\Db;
use think\Request;


class Video extends BaseController
{
    protected function _initialize()
    {
        $this->assign('page_title', '视频');
        $this->assign('navTopTitle', '视频');
        $this->assign('curFooterNavIndex', 2);   //底部导航选中的序号
    }

    //兼容index直入列表页
    public function index(Request $request)
    {
        $this->redirect('lists');
    }

    //视频列表页
    public function lists(Request $request)
    {
        $class_sublist = array();
        $sub_cid = empty($request->param('sub_cid')) ? 0 : $request->param('sub_cid');
        $cid = $request->get('cid');
        if (!isset($cid)) {
            $cid = empty($request->param('cid')) ? 0 : $request->param('cid');
            if (!empty($cid)) {
                $menu = db::name('class')->where(array('id' => $cid))->find();
                if (!empty($menu['pid'])) {
                    $sub_cid = $cid;
                    $cid = $menu['pid'];
                }
            }
        }
        $tag_id = empty($request->param('tag_id')) ? 0 : $request->param('tag_id');
        $class_list = Db::name('class')->where(array('status' => 1, 'type' => 1, 'pid' => 0))->field('id,name')->select();
        $tag_list = Db::name('tag')->where(array('status' => 1, 'type' => 1))->select();
        $where = "status = 1 and is_check=1 and pid = 0 ";
        if (!empty($cid)) {
            $class_sublist = Db::name('class')->where(array('status' => 1, 'type' => 1, 'pid' => $cid))->field('id,name')->select();
            $this->assign('sub_cid', $sub_cid);

            if (empty($sub_cid)) {
                if (empty($class_sublist)) {
                    $where .= " and class = $cid";
                } else {
                    $param = array(
                        'db' => 'class',
                        'where' => array('status' => 1, 'type' => 1, 'pid' => $cid),
                        'field' => 'id',
                    );
                    $sub_array = get_field_values($param);
                    $where .= " and (class = $cid or class in (" . implode(',', $sub_array) . "))";
                }
            } else {
                $where .= " and class = $sub_cid";
            }

        }
        if (!empty($tag_id)) {
//            $where .= " and tag = $tag_id";
            $where .= " and FIND_IN_SET( $tag_id, tag)";
        }

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
        $video_list = Db::name('video')->where($where)->field('id,title,click,good,thumbnail,play_time,reco,update_time,gold,type')->order($order)->paginate(20, false, array('query' => $request->get()));
        $pages = $video_list->render();
        $this->assign('cid', $cid);
        $this->assign('tag_id', $tag_id);
        $this->assign('class_list', $class_list);
        $this->assign('class_sublist', $class_sublist);
        $this->assign('tag_list', $tag_list);
        $this->assign('orderCode', $orderCode);
        $this->assign('count', $count);
        $this->assign('video_list', $video_list);
        $this->assign('pages', $pages);
        $this->assign('tag_list', $tag_list);
        $this->assign('page_title', '视频列表');
        $this->assign('navTopTitle', '视频列表');
        return view();
    }

    //视频播放页
    public function play(Request $request)
    {

        $videoId = $request->param('id/d', 0);
        if (!$videoId) return $this->error('查看的视频不存在或已被删除.');

        $collect_info = '收藏';
        if (isCollected('video', $videoId)) $collect_info = '已收藏';
        $this->assign('collect_info', $collect_info);

        //获取当前id视频信息，并浏览量++
        $videoModel = model('video')->get($videoId);
        if (!$videoModel) return $this->error('您要查看的视频不存在!');


        Db::name('video')->where("id=$videoId")->setInc('click');
        #file_put_contents("e:/1.log",'click:'.$videoModel->click."\r\n----------\r\n",FILE_APPEND);

        $videoInfo = $videoModel->toArray();
        if(empty($videoInfo) ){
            return $this->error('视频不存在或已被删除！');
        }
        if($videoInfo['status'] !=1 ){
            return $this->error('视频已被下架！');
        }
        if($videoInfo['is_check'] !=1 ){
            return $this->error('视频未通过审核！');
        }

        //click add
        $videoModel->click++;
        $videoModel->save();

        //视频集处理逻辑
        if (isset($videoInfo['type']) && $videoInfo['type'] == 1 || $videoInfo['pid'] > 0) {
            $where = ['pid' => $videoInfo['id']];
            if ($videoInfo['pid'] > 0) $where = ['pid' => $videoInfo['pid']];

            $videoSet = Db::name('video')
                ->where($where)
                ->order('sort asc')
                ->select();
            if ($videoSet) {
                $this->assign('videoSet', $videoSet);
                //如果是视频集，那么进入后自动将第一个子视频的信息做为默认视频信息 @dreamer
                if ($videoInfo['type'] == 1) {
                    $videoInfo = $videoSet[0];
                    $this->assign('videoInfo', $videoInfo);
                }
            }
        }

        //获取视频作者
        $member_info = Db::name('member')->where(['id' => $videoInfo['user_id']])->field('nickname,headimgurl')->find();
        empty($member_info) ? $videoInfo['member'] = '管理员' : $videoInfo['member'] = $member_info['nickname'];
        empty($member_info) ? $videoInfo['headimgurl'] = '/static/images/user_dafault_headimg.jpg' : $videoInfo['headimgurl'] = $member_info['headimgurl'];


        //获取视频分类
        $class = Db::name('class')->where(['id' => $videoInfo['class']])->field('name,id')->find();
        if (empty($class)) {
            $videoInfo['classname'] = '未分类';
            $videoInfo['classid'] = '0';
        } else {
            $videoInfo['classname'] = $class['name'];
            $videoInfo['classid'] = $class['id'];
        }
        //获取视频标签
        if (empty($videoInfo['tag'])) {
            $videoInfo['tag'] = 0;
        }
        $tag_list = Db::name('tag')->where("id in({$videoInfo['tag']})")->select();
        $videoInfo['taglist'] = $tag_list;
        $this->assign('videoInfo', $videoInfo);
        //统计该视频的打赏
        $gratuity = Db::name('gratuity_record')->where(['content_type' => 1, 'content_id' => $videoId])->select();
        $count = Db::name('gratuity_record')->where(['content_type' => 1, 'content_id' => $videoId])->field(" count(distinct user_id) as count ")->find();
        $count_price = 0;
        foreach ($gratuity as $k => $v) {
            $json_relust = json_decode($v['gift_info']);
            $count_price = $json_relust->price + $count_price;
        }


        //获取推荐数据
        $params = array(
            'type' => 'video',
            'cid' => $videoInfo['class'],
        );
        $recom_list = get_recom_data($params);
        $this->assign('recom_list', $recom_list);

        //播放相关配置信息加载
        $adSetting = get_config_by_group('video');
        $this->assign('adSetting', $adSetting);
        $this->assign('web_title', $videoInfo['title'] . "_视频播放");

        //当前用户是否点赞过
        $this->assign('count', $count['count']);
        $this->assign('count_price', $count_price);
        $this->assign('isGooded', isGooded('video', $videoInfo['id']));
        $this->assign('isCollected', isCollected('video', $videoInfo['id']));



        $this->assign('page_title', $videoInfo['title']);
        $this->assign('navTopTitle', '视频观看');

        return $this->fetch();
    }

    //视频搜索页
    public function search(Request $request)
    {

        return $this->fetch();
    }

    //异步通知视频入库
    public function syncAddVideo()
    {
        $attachmentConfig=get_config_by_group('attachment');
        $videoConfig=get_config_by_group('video');
        $videoConfig=array_merge($attachmentConfig,$videoConfig);

        //参数设置
        $config = array();
        $config['videoweb'] = $videoConfig['yzm_upload_url'];           //post domain
        $config['weburl'] =  $videoConfig['yzm_video_play_domain'];     //thumb domain
        $config['videourl'] =  $videoConfig['yzm_video_play_domain'];   //play domain
        $config['key'] =  $videoConfig['yzm_api_secretkey'];            //API密钥

        $config['istime'] = "1"; //是否开启时间转换 转码后默认时间格式为 秒 是否需要转换为 00:00:00 时间格式入库(0为不转换,1为转换)
        $config['issize'] = "1"; //是否开启文件大小转换 转码后默认时间格式为 byt 是否需要转换为 Gb Mb Kb形式(0为不转换,1为转换)
        $config['isurl'] = "0"; //是否开启url转码 即中文链接会进行转码后入库 (0为不转换,1为转换)
        //参数设置结束
        $task = file_get_contents("php://input");
        $logDir=dirname(__FILE__)."../../../syncAddVideo.log";
        file_put_contents($logDir,"\n".str_repeat('-*-',50).$task,FILE_APPEND);
        if ($task) {
            //logError('视频数据:'.$task);
            $arr=json_decode(str_replace('\\','/',$task),true);
            #file_put_contents($logDir,"\r\n".var_export($arr,1));

            $taskid = $arr['shareid']; //old: taskid
            if (!$taskid) {
                die;
            }
            //获取视频信息
            $json = file_get_contents($config['videoweb'] . "/api/gettask?id=" . $taskid . "&key=" . $config['key']);
            file_put_contents($logDir,"\r\n".$config['videoweb'] . "/api/gettask?id=" . $taskid . "&key=" . $config['key']."\r\n".$json,FILE_APPEND);
            //logError('视频对应数据:'.$json);
            if ($json) {
                #if ($json == "key error.") {
                if (!(stripos($json,'key error')===false)) {
                    file_put_contents($logDir,"\r\nAPI密钥错误\r\n",FILE_APPEND);
                    die;
                }
                $varr = json_decode($json, true);
                //print_r($varr);exit;
                $videotime = $config['istime'] ? secondsToHour($varr[0]['metadata']['time']) : $varr[0]['metadata']['time'];
                $videosize = $config['issize'] ? formatBytes($varr[0]['metadata']['length']) : $varr[0]['metadata']['length'];
                $videoresolution = $varr[0]['metadata']['resolution']; //视频原始分辨率
                $videopic = $varr[0]['output']['pic1'];
                $orgfile = $varr[0]['orgfile'];
                $rpath = addslashes(trim($varr[0]['rpath']));
                $videopic = str_replace($varr[0]['outdir'], $config['weburl'], $videopic);
                $videopic = str_replace('\\', '/', $videopic); //视频图片
                $videorpath = $varr[0]['rpath']; //播放地址
                $tarr = $arr = explode('.', $orgfile);
                $title = addslashes(trim($tarr[0]));
                if ($config['isurl']) {
                    $videorpath = str_replace('\\', '/', $videorpath);
                    $videorpath = urlencode($videorpath);
                    $videopic = urlencode($videopic);
                    $videopic = str_replace('%2F', '/', $videopic);
                    $videopic = str_replace('%3A', ':', $videopic);
                    $videopic = str_replace('+', ' ', $videopic);
                    $videorpath = str_replace('%2F', '/', $videorpath);
                    $videorpath = str_replace('+', ' ', $videorpath);
                }

                $videorpath = str_replace('\\', '/', $videorpath);

                //获取mp4的路径地址 "rpath":"\20170721\GR1ZtJBl"
                $rpath_arr = explode("/", $videorpath);
                $mp4_path = $config['videourl'] . $videorpath . "/mp4/" . end($rpath_arr) . ".mp4";

                //$videorpath=$config['videourl']."/".$videorpath."/index.m3u8";
                $videorpath = $config['videourl'] . $videorpath . "/index.m3u8";
                $share = $config['videourl'] . "/share/" . $taskid;

                $videoData = [
                    'title' => $title,
                    'url' => $videorpath,
                    'download_url' => $mp4_path,
                    'play_time' => $videotime,
                    'class' => $videoConfig['sync_add_video_classid'],
                    'thumbnail'=>$videopic,
                    'add_time'=>time(),
                    'update_time'=>time(),
                    'status'=>1
                ];

                if($videoConfig['sync_add_video_need_review']>0){
                    $videoData['is_check']=0;
                }else{
                    $videoData['is_check']=1;
                }

                file_put_contents($logDir,"\n".var_export($videoData,1),FILE_APPEND);
                Db::name('video')->insert($videoData);

            }else{
                file_put_contents($logDir,"\n".'非JSON!',FILE_APPEND);
            }
        }else{
            file_put_contents($logDir,"\n".'Hello MsvodX!',FILE_APPEND);
            die('Hello MsvodX!');
        }

    }

}