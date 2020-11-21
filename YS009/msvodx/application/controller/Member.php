<?php
/**
 * 个人中心控制器类
 */

namespace app\controller;

use app\model\Atlas;
use think\Controller;
use think\Db;
use think\Request;

class Member extends BaseController
{
    /**
     * 初始化方法
     */
    public $member_id;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->member_id = session('member_id');
        $this->assign('user_id', $this->member_id);
        $access_token = session('access_token');
        $noCheckAct=['seek_pwd','login','register'];
        $user_info =  db::name('member')->where(array('id'=>$this->member_id ,'access_token'=>$access_token))->find();
        if (!in_array(request()->action(),$noCheckAct)) {
            if (intval($this->member_id) <= 0) {
                if($request->isMobile()) $this->redirect('index/login');
                $this->error('请登录后再试', url('Index/index'), null, 5);
            }
            if(empty($user_info)){
                if($request->isMobile())  $this->error('该用户已在其他地方登录', url('Index/login'), null, 5);
                $this->error('该用户已在其他地方登录', url('Index/index'), null, 5);
            }
        }
        $this->assign('page_title', '个人中心');
        $this->assign('navTopTitle', '个人中心');
        $this->assign('curFooterNavIndex',4);   //底部导航选中的序号
    }

    //兼容index直入列表页
    public function index(Request $request)
    {

        return $this->redirect('member/member');
    }

    //会员中心、个人信息
    public function member(Request $request)
    {
        #$where = "id = $this->member_id";
        #$info = db::name('member')->where($where)->field('id,nickname,gid,tel,sex,headimgurl,email,money,is_agent,add_time,last_time,out_time')->find();
        $info = get_member_info($this->member_id);
        $info['tel_asterisk'] = substr($info['tel'], 0, 4) . "****" . substr($info['tel'], 8, 3);
        $this->assign('info', $info);
        $this->assign('page_title', '个人中心');
        $this->assign('current_left_menu', 'member');
        return view();
    }

    //会员中心、修改手机
    public function set_phone(Request $request)
    {
        $info = Db::name('member')->where(['id' => session('member_id')])->find();
        $info['tel_asterisk'] = substr($info['tel'], 0, 4) . "****" . substr($info['tel'], 8, 3);
        $this->assign('info', $info);
        $this->assign('page_title', '修改手机');
        $this->assign('navTopTitle', '修改手机');
        return view();
    }

    //会员中心、修改邮箱
    public function set_email(Request $request)
    {
        $memberInfo = Db::name('member')->where(['id' => session('member_id')])->find();
        $this->assign('memberInfo', $memberInfo);
        $this->assign('page_title', '修改邮箱');
        $this->assign('navTopTitle', '修改邮箱');
        return view();
    }

    //会员中心、我的收藏.视频
    public function collection_video(Request $request)
    {
        //获取我收藏的视频
        $video_info=Db::view('video_collection','id,video_id')
            ->view('video','good,click,title,play_time,thumbnail,reco','video_collection.video_id=video.id')
            ->where('video.status=1 and video.is_check=1 and video_collection.user_id='.session('member_id'))
            ->paginate(10);

        // 获取分页显示
        $page = $video_info->render();
        $this->assign('page', $page);
        $this->assign('video_info', $video_info);
        $this->assign('page_title', '视频收藏');
        $this->assign('navTopTitle', '视频收藏');
        $this->assign('current_left_menu', 'collection');
        return view();
    }

    //会员中心、我的收藏.资讯
    public function collection_novel(Request $request)
    {
        $tags_list = Db::name('tag')->where(array('status' => 1, 'type' => 3))->column('id,name');

        //获取我收藏的资讯

        $novel_info=Db::view('novel_collection','id,novel_id')
            ->view('novel','good,click,title,short_info,thumbnail,update_time,tag,gold','novel_collection.novel_id=novel.id')
            ->where('novel.status=1 and novel.is_check=1 and novel_collection.user_id='.session('member_id'))
            ->paginate(10);

        // 获取分页显示
        $tag = '';
        $page = $novel_info->render();
        foreach ($novel_info as $k => $v) {
            $tag[$v['id']] = explode(",", $v['tag']);
        }
        $this->assign('page', $page);
        $this->assign('tag', $tag);
        $this->assign('tags_list', $tags_list);
        $this->assign('novel_info', $novel_info);
        $this->assign('page_title', '资讯收藏');
        $this->assign('navTopTitle', '资讯收藏');
        $this->assign('current_left_menu', 'collection');
        return view();
    }

    //会员中心、我的收藏.图册
    public function collection_img(Request $request)
    {
        $member_id = session('member_id');
        if (intval($member_id) <= 0) {
            $this->error('请登录后再试');
        }
        //获取用户相册信息
        $imgs_atlas = Db::name('user_atlas')->where(['user_id' => $member_id])->order('add_time', 'desc')->paginate(10)->each(function ($item, $key) {
            $member_id = session('member_id');
            $imgs = Db::name('image_collection')->where(['atlas_id' => $item['id'], 'user_id' => $member_id])->order('collection_time', 'desc')->field('id,image_id,collection_time')->find();

            if (!empty($imgs)) {
                $imgs_url = Db::name('image')->where(['id' => $imgs['image_id'], 'status' => 1])->field('id,url')->find();
                if (!empty($imgs_url)) {
                    $item['first_img'] = $imgs_url['url'];
                }else{
                    $item['first_img'] = 'default'; //修复仅有一张图且已被删除时的Bug 2018/01/16 $dreamer
                }
            } else {
                $item['first_img'] = 'default';
            }
            return $item;
        });
        $page = $imgs_atlas->render();
        $this->assign('atlas_list', $imgs_atlas);
        $this->assign('page', $page);
        $this->assign('page_title', '收藏图册');
        $this->assign('navTopTitle', '收藏图册');
        $this->assign('current_left_menu', 'collection');
        return view();
    }

    //会员中心、我的收藏.图片详情
    public function collection_pic(Request $request)
    {
        $member_id = session('member_id');
        if (intval($member_id) <= 0) {
            $this->error('请登录后再试');
        }
        $imgid = $request->param('imgid/d');
        if (intval($imgid) <= 0) {
            $this->error('你的参数错误');
        }
        //获取相册信息
        $atlas_info = Db::name('user_atlas')->where(['user_id' => $member_id, 'id' => $imgid])->field('id,title,add_time')->find();
        //获取相册中相片信息
        $img_list = Db::view('image_collection', 'id,user_id,image_id,collection_time,atlas_id')
            ->view('image', 'title,url,status,add_time', 'image_collection.image_id=image.id and image.status=1')
            ->where(['user_id' => $member_id, 'atlas_id' => $imgid])
            ->paginate(20);

        $pages = $img_list->render();
        $this->assign('pages', $pages);
        $this->assign('atlas_info', $atlas_info);
        $this->assign('img_list', $img_list);
        $this->assign('page_title', $atlas_info['title']);
        $this->assign('navTopTitle', $atlas_info['title'].' - 我收藏的图片');
        $this->assign('current_left_menu', 'collection');
        return view();
    }

    //会员中心、我的视频
    public function video(Request $request)
    {
        $db = Db::name('video');
        $where = "user_id = $this->member_id";
        $order = 'update_time desc';
        $field = 'id,title,click,thumbnail,update_time,play_time,add_time,gold,is_check,status';
        $list = $db->where($where)->field($field)->order($order)->paginate(10);
        $pages = $list->render();
        $this->assign('list', $list);
        $this->assign('pages', $pages);
        $this->assign('user_id', $this->member_id);
        $this->assign('page_title', '我的视频');
        $this->assign('navTopTitle', '我的视频');
        $this->assign('current_left_menu', 'video');
        return view();
    }

    //会员中心、添加视频
    public function addVideo(Request $request)
    {
        if ($this->request->isPost()) {
            $data = $request->post();
            unset($data['file']);
            if (isset($data['tag'])) {
                $data['tag'] = implode(",", $data['tag']);
            } else {
                $data['tag'] = 0;
            }; //修复未选标签产生致命错误的bug $dreamer 20171220
            $data['add_time'] = time();
            $data['update_time'] = time();
            $data['user_id'] = $this->member_id;
            $rule = [
                'title|视频标题' => 'require',
                'thumbnail|视频缩略图' => 'require',
                'class|视频分类' => 'require',
                'url|视频地址' => 'require'
            ];
            $message = [
                'title.require' => "标题不能为空",
                'thumbnail.require' => '缩略图不能为空',
                'class.require' => '请选择视频分类',
                'url.require' => '请选择视频地址不为空'
            ];
            $result = $this->validate($data, $rule, $message);
            if ($result !== true) {
                if($request->isMobile()){
                    return $this->error($result);
                }else{
                    layerJump($result, 2, 3);
                    die;
                }
            }
            $data['is_check'] =  (get_config('resource_examine_on')  == 1) ?  0 : 1;
            db::name('video')->insert($data);
            if($request->isMobile()){
                return $this->success('添加成功',url('member/video'));
            }else{
                layerJump('添加成功', 1, 2);
            }
        } else {
            $class_list = get_resource_class(array('resourceType' => 1));
            $tag_list = db::name('tag')->where('type = 1 and status = 1')->select();
            $this->assign('tag_list', $tag_list);
            $this->assign('class_list', $class_list);
            $this->assign('page_title', '添加视频');
            $this->assign('navTopTitle', '添加视频');
            return view();
        }
    }

    //会员中心、编辑视频
    public function editVideo(Request $request)
    {
        $id = $request->param('id/d', 0);
        $where = "id = $id";
        if ($this->request->isPost()) {
            $data = $request->post();
            if (empty($data['play_time'])) $this->error('播放时间不正确！');
            unset($data['file']);
            if (isset($data['tag'])) {
                $data['tag'] = implode(",", $data['tag']);
            } else {
                $data['tag'] = 0;
            }; //修复未选标签产生致命错误的bug $dreamer 20171219
            $rule = [
                'title|视频标题' => 'require',
                'thumbnail|视频缩略图' => 'require',
                'class|视频分类' => 'require',
                'url|视频地址' => 'require'
            ];
            $message = [
                'title.require' => "标题不能为空",
                'thumbnail.require' => '缩略图不能为空',
                'class.require' => '请选择视频分类',
                'url.require' => '请选择视频地址不为空'
            ];
            $result = $this->validate($data, $rule, $message);
            if ($result !== true) {
                if($request->isMobile()){
                    return $this->error($result);
                }else{
                    layerJump($result, 2, 3);
                    die;
                }
            }
            if( db::name('video')->where($where)->update($data)){
                $data =  '';
                $data['update_time'] = time();
                $data['is_check'] = (get_config('video_reexamination') == 1) ? 0 : 1;
                db:: name('video')->where($where)->update($data);
            }
            if($request->isMobile()){
                return $this->success('编辑成功',url('member/video'));
            }else{
                layerJump('编辑成功', 1, 2);
            }
        } else {
            $tag_list = db::name('tag')->where('type = 1 and status = 1')->select();
            $class_list = get_resource_class(array('resourceType' => 1));
            $field = 'id,title,thumbnail,gold,tag,class,url,play_time';
            $info = db::name('video')->where($where)->field($field)->find();
            $info['tag'] = explode(",", $info['tag']);
            $this->assign('info', $info);
            $this->assign('tag_list', $tag_list);
            $this->assign('class_list', $class_list);
            $this->assign('page_title', '编辑视频');
            $this->assign('navTopTitle', '编辑视频');
            return view();
        }
    }

    //会员中心、我的资讯
    public function novel(Request $request)
    {
        $where = "user_id = $this->member_id";
        $order = 'update_time desc';
        $field = 'id,title,click,good,thumbnail,update_time,short_info,tag,status,is_check';
        $tag = "";
        $tags_list = Db::name('tag')->where(array('status' => 1, 'type' => 3))->column('id,name');
        $list = db::name('novel')->where($where)->field($field)->order($order)->paginate(10);
        foreach ($list as $k => $v) {
            $tag[$v['id']] = explode(",", $v['tag']);
        }
        $pages = $list->render();
        $this->assign('tag', $tag);
        $this->assign('list', $list);
        $this->assign('tags_list', $tags_list);
        $this->assign('pages', $pages);
        $this->assign('page_title', '我的资讯');
        $this->assign('navTopTitle', '我的资讯');
        $this->assign('current_left_menu', 'novel');
        return view();
    }

    //会员中心、编辑资讯
    public function addNovel(Request $request)
    {
        if ($this->request->isPost()) {
            $data = $request->post();
            $data['content'] = htmlspecialchars(trim($data['content']));
            if (isset($data['tag'])) {
                $data['tag'] = implode(",", $data['tag']);
            } else {
                $data['tag'] = 0;
            }; //修复未选标签产生致命错误的bug $dreamer 20171219
            //验证资讯信息
            $rule = [
                'title|资讯标题' => 'require',
                'content|资讯内容' => 'require',
                'class|资讯分类' => 'require',
                'thumbnail|资讯缩略图' => 'require'
            ];
            $message = [
                'title.require' => "标题不能为空",
                'content.require' => '资讯内容不能为空',
                'thumbnail.require' => '缩略图不能为空',
                'class.require' => '请选择资讯分类'
            ];
            $result = $this->validate($data, $rule, $message);
            if ($result !== true) {
                if($request->isMobile()){
                    return $this->error($result);
                }else{
                    layerJump($result, 2, 3);
                    die;
                }
            }
            $data['add_time'] = time();
            $data['update_time'] = time();
            $data['user_id'] = $this->member_id;
            $data['is_check'] =  (get_config('resource_examine_on')  == 1) ?  0 : 1;
            db::name('novel')->insert($data);
            if($request->isMobile()){
                return $this->success('添加成功',url('member/novel'));
            }else{
                layerJump('添加成功', 1, 2);
            }
        } else {
            $tag_list = db::name('tag')->where('type = 3 and status = 1')->select();
            $class_list = get_resource_class(array('resourceType' => 3));
            $this->assign('tag_list', $tag_list);
            $this->assign('class_list', $class_list);
            $this->assign('page_title', '添加资讯');
            $this->assign('navTopTitle', '添加资讯');
            return view();
        }

    }

    //会员中心、编辑资讯
    public function editNovel(Request $request)
    {
        $id = $request->param('id/d', 0);
        $where = "id = $id";
        if ($this->request->isPost()) {
            $data = $request->post();
            $data['content'] = htmlspecialchars(trim($data['content']));
            if (isset($data['tag'])) {
                $data['tag'] = implode(",", $data['tag']);
            } else {
                $data['tag'] = 0;
            }; //修复未选标签产生致命错误的bug $dreamer 20171220
            //验证资讯信息
            $rule = [
                'title|资讯标题' => 'require',
                'content|资讯内容' => 'require',
                'class|资讯分类' => 'require',
                'thumbnail|资讯缩略图' => 'require'
            ];
            $message = [
                'title.require' => "标题不能为空",
                'content.require' => '资讯内容不能为空',
                'thumbnail.require' => '缩略图不能为空',
                'class.require' => '请选择资讯分类'
            ];
            $result = $this->validate($data, $rule, $message);
            if ($result !== true) {
                if($request->isMobile()){
                    return $this->error($result);
                }else{
                    layerJump($result, 2, 3);
                    die;
                }
            }
            if(db::name('novel')->where($where)->update($data)) {
                $data =  '';
                $data['update_time'] = time();
                $data['is_check'] = (get_config('novel_reexamination') == 1) ? 0 : 1;
                db:: name('novel')->where($where)->update($data);
            }
            if($request->isMobile()){
                return $this->success('编辑成功',url('member/novel'));
            }else{
                layerJump('编辑成功', 1, 2);
            }
        } else {
            $tag_list = db::name('tag')->where('type = 3 and status = 1')->select();
            $class_list = get_resource_class(array('resourceType' => 3));
            $field = 'id,title,thumbnail,content,short_info,gold,tag,class';
            $info = db::name('novel')->where($where)->field($field)->find();
            $info['tag'] = explode(",", $info['tag']);
            $this->assign('info', $info);
            $this->assign('tag_list', $tag_list);
            $this->assign('class_list', $class_list);
            $this->assign('page_title', '编辑资讯');
            $this->assign('navTopTitle', '编辑资讯');
            return view();
        }

    }

    //个人中心创建相册
    public function addAtlas(Request $request)
    {
        if ($request->isPost()) {
            $imagedb = Db::name('atlas');
            //视频资料
            $imageinfo = $request->post('image/a');
            $tag = $request->post('tag/a', [0]);
            $imageinfo['tag'] = implode(',', $tag);
            $imageinfo['add_time'] = time();
            $imageinfo['update_time'] = time();
            $imageinfo['user_id'] = $this->member_id;
            $imageinfo['is_check'] =  (get_config('resource_examine_on')  == 1) ?  0 : 1;
            //验证视频信息
            $rule = [
                'title|图集标题' => 'require',
                'cover|图集封面' => 'require',
                'class|图集分类' => 'require'
            ];
            $message = [
                'title.require' => "标题不能为空",
                'cover.require' => '缩略图不能为空',
                'class.require' => '请选择视频分类',
            ];
            $result = $this->validate($imageinfo, $rule, $message);
            if ($result !== true) {
                if($request->isMobile()){
                    return $this->error($result);
                }else{
                    layerJump($result, 2, 3);
                    die;
                }
            }
            $insert = $imagedb->insert($imageinfo);
            if ($insert) {
                if($request->isMobile()){
                    return $this->Success('添加成功',url('member/img'));
                }else{
                    layerJump('添加成功', 1, 2);
                    die;
                }
            }
            if($request->isMobile()){
                return $this->error($result);
            }else{
                layerJump('添加失败', 2, 2);
                die;
            }
        }
        $tag = Db::name('tag');
        $class = Db::name('class');
        $tag_list = $tag->where(['type' => 2, 'status' => 1])->select();
        $classlist = $class->where(['type' => 2, 'pid' => 0])->select();
        foreach ($classlist as $k => $v) {
            $classlist[$k]['childs'] = $class->where(['pid' => $v['id']])->select();
        }

        $this->assign('classlist', $classlist);
        $this->assign('tag_list', $tag_list);
        $this->assign('page_title', '创建图集');
        $this->assign('navTopTitle', '创建图集');
        return view();
    }

    //会员中心我的图册编辑
    public function editAtlas(Request $request)
    {
        $atlasid = $request->param('atlasid/d', 0);
        if ($request->isPost()) {
            $imagedb = Db::name('atlas');
            //视频资料
            $imageinfo = $request->post('image/a');
            $tag = $request->post('tag/a');
            $imageinfo['tag'] = implode(',', $tag);
            //验证视频信息
            $rule = [
                'title|图集标题' => 'require',
                'cover|图集封面' => 'require',
                'class|图集分类' => 'require'
            ];
            $message = [
                'title.require' => "标题不能为空",
                'cover.require' => '缩略图不能为空',
                'class.require' => '请选择视频分类',
            ];
            $result = $this->validate($imageinfo, $rule, $message);
            if ($result !== true) {
                if($request->isMobile()){
                    return $this->error($result);
                }else{
                    layerJump($result, 2, 3);
                    die;
                }
            }
            $insert = $imagedb->where(['user_id' => $this->member_id, 'id' => $atlasid])->update($imageinfo);
            if ($insert) {
                $data =  '';
                $data['update_time'] = time();
                $data['is_check'] = (get_config('image_reexamination') == 1) ? 0 : 1;
                $imagedb->where(['user_id' => $this->member_id, 'id' => $atlasid])->update($data);
                if($request->isMobile()){
                    return $this->Success('编辑成功',url('member/img'));
                }else{
                    layerJump('修改成功', 1, 2);
                    die;
                }
            }
            if($request->isMobile()){
                return $this->error('数据没有变更');
            }else{
                layerJump('数据没有变更', 2, 2);
                die;
            }
        }
        $result = Db::name('atlas')->where(['id' => $atlasid, 'status' => 1])->find();
        $tag = Db::name('tag');
        $class = Db::name('class');
        $tag_list = $tag->where(['type' => 2, 'status' => 1])->select();
        $classlist = $class->where(['type' => 2, 'pid' => 0])->select();
        foreach ($classlist as $k => $v) {
            $classlist[$k]['childs'] = $class->where(['pid' => $v['id']])->select();
        }
        $result['tag'] = explode(',', $result['tag']);
        $this->assign('classlist', $classlist);
        $this->assign('tag_list', $tag_list);
        $this->assign('result', $result);
        $this->assign('page_title', '编辑图集');
        $this->assign('navTopTitle', '编辑图集');
        return view();

    }

    //会员中心、我的图片
    public function img(Request $request)
    {
        $user_id = $this->member_id;
        $order = 'update_time desc';
        $item = Db::name('atlas')->where(['user_id' => $user_id])->order($order)->paginate(20);
        $pages = $item->render();
        $this->assign('pages', $pages);
        $this->assign('atlas_list', $item);
        $this->assign('page_title', '我的图片');
        $this->assign('navTopTitle', '我的图片');
        $this->assign('current_left_menu', 'img');
        return view();
    }

    //会员中心、我的图片
    public function pic(Request $request)
    {
        $atlasid = $request->param('atlasid/d', 0);
        $order = 'add_time,id desc';
        if($atlasid<=0) return $this->error('您要查看的相册不存在！');

        $img_list = Db::name('image')->where(['atlas_id' => $atlasid])->order($order)->paginate(20);
        $page = $img_list->render();
        $this->assign('img_list', $img_list);
        $this->assign('atlasid', $atlasid);
        $this->assign('pages', $page);
        $this->assign('page_title', '我的图片');
        $this->assign('navTopTitle', '我的图片');
        $this->assign('current_left_menu', 'img');
        return view();
    }

    public function addimges(Request $request)
    {
        $atlasid = $request->param('atlasid/d', 0);
        $status = 0;
        $check = Db::name('atlas')->where(['id' => $atlasid])->find();
        if (!$check) {
            layerJump('上传图集已被删除', 2, 2);
            die;

        }
        if ($request->isPost()) {
            $img['atlas_id'] = $atlasid;
            $imgurl = $request->post('url/a');
            $img['title'] = '';
            $img['add_time'] = time();
            //验证视频信息
            $rule = [
                'atlas_id|图集id' => 'require',
            ];
            $message = [
                'atlas_id.require' => "图集id不能为空",
            ];
            $result = $this->validate($img, $rule, $message);
            if ($result !== true) {
                if($request->isMobile()){
                    return $this->error($result);
                }else{
                    layerJump($result, 2, 3);
                    die;
                }
            }
            if (empty($imgurl)) {
                if($request->isMobile()){
                    return $this->error('请上传图片后提交');
                }else{
                    layerJump('请上传图片后提交', 2, 3);
                    die;
                }
            }
            $imagedb = Db::name('image');
            foreach ($imgurl as $v) {
                $img['url'] = $v;
                $insert = $imagedb->insert($img);
                if ($insert) $status = 1;
                unset($img['url']);
            }

            if ($insert) {
                if($status == 1)  {
                    if(get_config('image_reexamination')) Db::name('atlas')->where(['id' => $atlasid])->update(array('is_check'=>0));
                }
                if($request->isMobile()){
                    return $this->Success('添加成功',url('member/pic',array('atlasid'=>$atlasid )));
                }else{
                    layerJump('修改成功', 1, 2);
                    die;
                }
            }
        }
        return view();
    }

       //会员中心、我的代理商
    public function agent(Request $request)
    {
        $domain_name = db::name('domain_cname_binding')->where(array('uid' => session('member_id')))->field('webhost,status')->find();
        if ($request->isPost()) {
            $data['agent_config'] = serialize($request->Post());
            db::name('member')->where(array('id' => session('member_id')))->update($data);
            if(empty($domain_name)){
                $data = array(
                    'uid' => session('member_id'),
                    'add_time' => time(),
                    'last_time' => time(),
                    'webhost' => $request->Post('domain_name'),
                );
                db::name('domain_cname_binding')->insert($data);
            }else{
                if($request->Post('domain_name') != $domain_name['webhost']){
                    $data = array(
                        'webhost' => $request->Post('domain_name'),
                        'last_time' => time(),
                        'status' =>0,
                    );
                    db::name('domain_cname_binding')->where(array('uid' => session('member_id')))->update($data);
                }
            }
            $this->success('保存成功！');
        } else {
            $list   =  array();
            $user_info = db::name('member')->where(array('id' => session('member_id')))->field('id,pid,is_agent,agent_config')->find();
            if ($user_info['is_agent'] != 1) {
                $apply = db::name('agent_apply')->where(array('user_id' => session('member_id')))->find();
                $status = empty($apply) ? 3 : $apply['status'];
                $this->assign('status', $status);
            } else {
                $agent_config = unserialize($user_info['agent_config']);
                $agent_config['domain_name'] = $domain_name;
                $this->assign('agent_config', $agent_config);
                $ids = session('member_id');
                for($i = 1;$i <= 3;$i++){
                    if(empty($ids)){
                        $list[$i] = array();
                    }else{
                        $map['pid'] = ['in', $ids];
                        $list[$i] =  Db::name('member')->where($map)->field('id,pid,username')->select();
                        $ids = array_column($list[$i], 'id');
                    }
                }
            }
            $pid = empty($user_info['pid']) ? 0 : $user_info['pid'];
            if(!empty($pid)){
                $puserinfo = db::name('member')->where(array('id'=>$user_info['pid']))->field('id,username')->find();
                $this->assign('puserinfo', $puserinfo);
            }
            $this->assign('list', $list);
            $this->assign('pid', $pid);
            $agentDomain = 'a' . $user_info['id'] . '.' . get_top_domain($request->host());
            $this->assign('agentDomain', $agentDomain);
            $this->assign('is_agent', $user_info['is_agent']);
            $this->assign('page_title', '代理商');
            $this->assign('navTopTitle', '代理商');
            $this->assign('current_left_menu', 'agent');
            return view();
        }
    }

    //会员中心、消费记录
    public function record_video(Request $request)
    {
        $user_id = $this->member_id;
        //视频观看记录
        $result = Db::view('video_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('video', 'title,class,id as video_id', 'video_watch_log.video_id=video.id')
            ->view('class', 'type,name', 'video.class=class.id')
            ->where(['type' => 1, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->paginate(15);
        $pages = $result->render();
        $this->assign('page_title', '视频消费记录');
        $this->assign('navTopTitle', '视频消费记录');
        $this->assign('result', $result);
        $this->assign('pages', $pages);
        $this->assign('current_left_menu', 'record');
        return view();
    }

    //会员中心、消费记录
    public function record_img(Request $request)
    {
        $user_id = $this->member_id;
        //视频观看记录
        $result = Db::view('atlas_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('atlas', 'title,class,id as atlas_id', 'atlas_watch_log.atlas_id=atlas.id')
            ->view('class', 'type,name', 'atlas.class=class.id')
            ->where(['type' => 2, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->paginate(15);
        $pages = $result->render();
        $this->assign('page_title', '图片消费记录');
        $this->assign('navTopTitle', '图片消费记录');
        $this->assign('result', $result);
        $this->assign('pages', $pages);
        $this->assign('current_left_menu', 'record');
        return view();
    }

    //会员中心、消费记录
    public function record_novel(Request $request)
    {
        $user_id = $this->member_id;
        //视频观看记录
        $result = Db::view('novel_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('novel', 'title,class,id as novel_id', 'novel_watch_log.novel_id=novel.id')
            ->view('class', 'type,name', 'novel.class=class.id')
            ->where(['type' => 3, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->paginate(15);
        $pages = $result->render();
        $this->assign('page_title', '资讯消费记录');
        $this->assign('navTopTitle', '资讯消费记录');
        $this->assign('result', $result);
        $this->assign('pages', $pages);
        $this->assign('current_left_menu', 'record');
        return view();
    }

    //会员中心、修改密码
    public function set_pwd(Request $request)
    {
        if ($request->isPost()) {
            $password = $request->post('password/s', '');
            $new = $request->post('new_password/s', '');
            $confirm = $request->post('confirm/s', '');

            if (!check_member_password(session('member_info')['username'], $password)) $this->error('原密码不正确！');
            if (strlen($new) < 6 || strlen($new) > 20) $this->error('新密码只能是6~20位字母或数字！');
            if ($new == $password) $this->error('新密码不能跟旧密码一致！');
            if ($new != $confirm) $this->error('两次密码不一致！');
            db::name('member')->where(array('id' => $this->member_id))->update(array('password' => encode_member_password($new)));
            $this->success('修改成功！', url('member/member'));
        } else {
            $this->assign('page_title', '修改密码');
            $this->assign('navTopTitle', '修改密码');
            return view();
        }
    }

    //会员中心、找回密码
    public function seek_pwd(Request $request)
    {
        $register_validate = empty(get_config('register_validate')) ? 0 : get_config('register_validate');
        $status = $request->param('status/d', 0);
        if ($request->isPost()) {
            $email = $request->post('email/s', '');
            $new = $request->post('new/s', '');
            $confirm = $request->post('confirm/s', '');
            if (strlen($new) < 6 || strlen($new) > 20) $this->error('新密码只能是6~20位字母或数字！');
            if ($new != $confirm) $this->error('两次密码不一致！');

            if($register_validate == 1){
                $where = array('email' => $email);
            }else{
                $where = array('tel' => $email);
            }
            db::name('member')->where($where)->update(array('password' => encode_member_password($new)));
            $url = url('member/seek_pwd', array('status' => 1));
            $this->redirect($url);
        } else {
            $this->assign('status', $status);
            $this->assign('register_validate', $register_validate);
            $this->assign('page_title', '找回密码');
            $this->assign('navTopTitle', '找回密码');
            return view();
        }


    }

    //会员中心、个人详情
    public function info(Request $request)
    {
        $user_id = session('member_id');
        $where = array('id'=>$user_id);
        if ($request->isPost()) {
            $data = $request->post();
            $data['sex'] = !empty($request->post('sex')) ? 1 : 2;
            db::name('member')->where($where)->update($data);
            $this->success('修改成功！', url('member/member'));
        } else {
            $field = 'nickname,headimgurl,sex,email';
            $info  = db::name('member')->where($where)->field($field)->find();
            $this->assign('info', $info);
            $this->assign('page_title', '个人信息');
            $this->assign('navTopTitle', '个人信息');
            return view();
        }
    }

    //会员中心、充值记录
    public function record_pay(Request $request)
    {
        $user_id =$this->member_id;
        $data_list=Db::name('order')->where(['user_id'=>$user_id])->order('add_time','desc')->paginate(20)->each(function($item, $key){
            if($item['buy_type'] == 2){
                $item['buy_vip_info']=json_decode($item['buy_vip_info'],true);
            }
            return $item;
        });
        $pages=$data_list->render();
        $this->assign('data_list',$data_list);
        $this->assign('pages',$pages);
        $this->assign('current_left_menu', 'record_pay');
        $this->assign('navTopTitle', '充值记录');
        return view();
    }
    //会员中心、提现
    public function get_out_pay(Request $request)
    {
        $user_id=$this->member_id;
        //获取用户金币数
        $menber_info=Db::name('member')->where(['id'=>$user_id])->find();
        //获取用户提现方式
        $momey_account=Db::name('draw_money_account')->where(['user_id'=>$user_id])->order('id','desc')->field('id,title')->select();
        //获取提现金币汇率
        $gold_exchange_rate=get_config('gold_exchange_rate');
        //获取提现提现最低限额
        $min_withdrawals=get_config('min_withdrawals');
        //当前可以提现多少钱
        $money=intval($menber_info['money']/$gold_exchange_rate);

        $this->assign('current_left_menu', 'get_out_pay');
        $this->assign('money',$money);
        $this->assign('menber_info',$menber_info);
        $this->assign('momey_account',$momey_account);
        $this->assign('gold_exchange_rate',$gold_exchange_rate);
        $this->assign('min_withdrawals',$min_withdrawals);
        $this->assign('page_title', '提现');
        $this->assign('navTopTitle', '提现');
        return view();
    }
    //会员中心、提现记录
    public function record_out_pay()
    {
        $user_id=$this->member_id;
        $log=Db::name('draw_money_log')->where(['user_id'=>$user_id])->order('add_time','desc')->paginate(20)->each(function($itme,$key){
            $itme['info']=json_decode($itme['info'],true);
            return $itme;
        });

        $pages=$log->render();
        $this->assign('list',$log);
        $this->assign('pages',$pages);
        $this->assign('current_left_menu', 'get_out_pay');
        $this->assign('page_title', '提现记录');
        $this->assign('navTopTitle', '提现记录');
        return view();
    }
    //会员中心、新增提现账户
    public function add_card()
    {

        $this->assign('page_title', '添加收款信息');
        $this->assign('navTopTitle', '添加收款信息');
        return view();
    }
    //会员中心、金币记录
    public function record_gold()
    {
        $user_id=$this->member_id;
        $list=Db::name('gold_log')->where(['user_id'=>$user_id])->order('add_time','desc')->paginate(20);
        $pages=$list->render();
        $this->assign('list',$list);
        $this->assign('pages',$pages);
        $this->assign('current_left_menu', 'record_gold');
        return view();
    }
    //会员中心、新增提现账户
    public function card_pwd()
    {
        $this->assign('page_title', '卡密充值');
        $this->assign('navTopTitle', '卡密充值');
        $this->assign('current_left_menu', 'card_pwd');
        return view();
    }

    //第三方登录绑定
    public function binding_third()
    {

        return view();
    }

}
