<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;

class UserController extends HomeBaseController{

    /**
     * 个人中心首页
     */
    public function index()
    {
        $data = M('member')->find($this->user_id);
        if( empty($data['intro']) ) $data['intro'] = '去完善个人信息..';
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 编辑个人资料
     */
    public function edit_info()
    {
        if( IS_POST ) {
            $nickname = I('post.nickname');
            if( empty($nickname) ) {
                $this->error('昵称不能为空');
            }
            $data['id'] = $this->user_id;
            $data['nickname'] = $nickname;
            $data['intro'] = I('post.intro');
            $data['head_img'] = I('post.head_img');
            $res = M('member')->save($data);
            $this->redirect('index');
        } else {
            $data = M('member')->find($this->user_id);
            $this->assign('data', $data);

            //头像列表
            $tx_list = array();
            for( $i = 1; $i <= 20; $i++ ) {

            }

            $this->display();
        }

    }

    /**
     * 书签 - 中长篇小说章节阅读记录
     */
    public function read_list()
    {
        $map['a.uid'] = $this->user_id;
        $list = M('chapter_read')->alias('a')
            ->field('a.*,b.title as post_title,c.name as chapter_title')
            ->join(C('DB_PREFIX').'posts b on b.id = a.post_id', 'LEFT')
            ->join(C('DB_PREFIX').'chapter c on c.id = a.chapter_id', 'LEFT')
            ->where($map)
            ->order('a.read_time desc')
            ->limit(100)->select();
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 收藏列表
     */
    public function fav_list()
    {
        $map['a.uid'] = $this->user_id;
        $list = M('posts_fav')->alias('a')
            ->field('a.*,b.title,b.info')
            ->join(C('DB_PREFIX').'posts b on b.id = a.post_id', 'LEFT')
            ->where($map)
            ->order('a.id desc')
            ->limit(100)->select();
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 评论列表
     */
    public function comment_list()
    {
        $map['a.uid'] = $this->user_id;
        $list = M('comment')->alias('a')
            ->field('a.*,b.title')
            ->join(C('DB_PREFIX').'posts b on b.id = a.post_id', 'LEFT')
            ->where($map)
            ->order('a.id desc')
            ->limit(100)->select();
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 被回复评论列表
     */
    public function reply_comment_list()
    {
        $map['a.reply_uid'] = $this->user_id;
        $list = M('comment')->alias('a')
            ->field('a.*,b.title')
            ->join(C('DB_PREFIX').'posts b on b.id = a.post_id', 'LEFT')
            ->where($map)
            ->order('a.id desc')
            ->limit(100)->select();

        //更新新消息条数为0
        M('member')->where(array('id'=>$this->user_id))->setField('notice_num', 0);

        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 打赏记录
     */
    public function contribution_list()
    {
        $map['a.uid'] = $this->user_id;
        $map['a.is_pay'] = 1;
        $list = M('contribution')->alias('a')
            ->field('a.*,b.title,c.name as chapter_name')
            ->join(C('DB_PREFIX').'posts b on b.id = a.post_id', 'LEFT')
            ->join(C('DB_PREFIX').'chapter c on c.id = a.chapter_id', 'LEFT')
            ->where($map)
            ->order('a.id desc')
            ->limit(100)->select();
        $this->assign('list', $list);
        $this->display();
    }
}

