<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 评论model
 */
class CommentModel extends BaseModel{
    /**
     * 评论
     * @param $post_id
     * @param $limit
     * @return mixed
     */
    public static function get_comment_list($post_id, $limit)
    {
        $map['a.post_id'] = $post_id;
        $list = M('comment')->alias('a')
            ->field('a.*,b.nickname,b.head_img')
            ->join(C('DB_PREFIX').'member b on b.id = a.uid')
            ->where($map)
            ->order('a.id desc')->limit($limit)->select();
        foreach($list as &$_list) {
            if(empty($_list['nickname'])) {
                $_list['nickname'] = '如侧用户' . $_list['uid'];
            }
        }
        return $list;
    }

    /**
     * 获取文章评论数
     * @param $post_id
     * @return float
     */
    public static function get_comment_count($post_id) {
        $count = M('comment')->where(array('post_id'=>$post_id))->count();
        return floatval($count);
    }
}
