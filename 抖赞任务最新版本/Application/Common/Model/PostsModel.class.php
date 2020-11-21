<?php
namespace Common\Model;
use Common\Model\BaseModel;
class PostsModel extends BaseModel{

    //是否收藏
    public static function has_fav($post_id, $member_id)
    {
        $res = M('posts_fav')->where(array('post_id'=>$post_id,'uid'=>$member_id))->find();
        return $res ? 1 : 0;
    }
}
