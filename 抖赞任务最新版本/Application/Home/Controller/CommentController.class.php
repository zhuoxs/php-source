<?php
namespace Home\Controller;

use Common\Controller\HomeBaseController;
use Common\Model\CommentModel;

class CommentController extends HomeBaseController{

    /**
     * 添加评论
     */
    public function add()
    {
        if( IS_POST ) {
            $post_id = I('post.post_id');
            $content = I('post.content');
            $reply_uid = intval(I('post.reply_uid'));
            $reply_nickname = I('post.reply_nickname');
            $reply_comment_id = intval(I('post.reply_comment_id'));
            $reply_content = I('post.reply_content');
            if( !($post_id > 0) ) {
                $this->error('参数错误');
            }
            if( $content == '' ) {
                $this->error('请输入评论内容');
            }

            //回复内容
            if( $reply_uid > 0 && $reply_comment_id > 0 ) {
                $content = $content . " //@" . $reply_nickname . ":" . $reply_content;
            }
            $data['post_id'] = $post_id;
            $data['uid'] = $this->user_id;
            $data['content'] = $content;
            $data['reply_comment_id'] = $reply_comment_id;
            $data['reply_uid'] = $reply_uid;
            $data['create_time'] = time();
            $res = M('comment')->add($data);
            if($res) {
                //$this->success('评论成功');

                //被回复人消息 +1
                if( $reply_uid > 0 && $reply_comment_id > 0 ) {
                    M('member')->where(array('id'=>$reply_uid))->setInc('notice_num');
                }

                $this->ajaxReturn(array('status'=>1,'info'=>'评论成功','content'=>$content));
            } else {
                $this->error('评论失败');
            }
        } else {
            $this->display();
        }
    }

    /**
     * 评论列表
     */
    public function ajax_comment_list()
    {
        $post_id = I('post_id');
        $page = intval(I('page'));
        $start  = $page*10;
        $comment_list = CommentModel::get_comment_list($post_id, "{$start},10");
        echo json_encode($comment_list);
    }
}

