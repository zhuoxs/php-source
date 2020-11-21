<?php
namespace Common\Model;
/**
 * 章节操作model
 */
class ContributionModel extends BaseModel{

	/**
	 * 判断章节是否需要打赏或者已经打赏过
	 * @param $chapter_id
	 * @param $is_set_price
	 * @return bool
	 */
	public static function has_contribution($chapter_id, $is_set_price) {
		$user_id = session('member.id');
		if( $is_set_price == 1 ) {
			//需打赏
			$map['chapter_id'] = $chapter_id;
			$map['uid'] = $user_id;
			$map['is_pay'] = 1;
			$data = M('contribution')->field('id')->where($map)->find();
			if($data) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

    /**
     * 判断文章是否需要打赏或者已经打赏过
     * @param $post_id
     * @param $is_set_price
     * @return bool
     */
    public static function has_contribution_post($post_id, $is_set_price) {
        $user_id = session('member.id');
        if( $is_set_price == 1 ) {
            //需打赏
            $map['post_id'] = $post_id;
            $map['uid'] = $user_id;
            $map['is_pay'] = 1;
            $data = M('contribution')->field('id')->where($map)->find();
            if($data) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * 根据post_id 获取打赏记录
     * @param $post_id
     * @param string $limit
     * @return mixed
     */
    public static function get_contribution_by_post_id($post_id, $limit = '')
    {
        $map['is_pay'] = 1;
        $map['post_id'] = $post_id;
        $list = M('contribution')->alias('a')
            ->field('a.*,b.id as uid,b.nickname,b.head_img')
            ->join(C('DB_PREFIX').'member b on b.id = a.uid', 'LEFT')
            ->where($map)
            ->order('a.id desc')
            ->limit($limit)->select();
        foreach( $list as &$_list ) {
            if( $_list['nickname'] == '' ) $_list['nickname'] = "如侧用户" . $_list['uid'];
        }
        return $list;
    }

    /**
     * 打赏次数统计
     * @param $post_id
     * @return mixed
     */
    public static function get_contribution_by_post_id_count($post_id)
    {
        $map['is_pay'] = 1;
        $map['post_id'] = $post_id;
        $count = M('contribution')->where($map)->count();
        return $count;
    }

    /**
     * 根据chapter_id 获取打赏记录
     * @param $chapter_id
     * @param string $limit
     * @return mixed
     */
    public static function get_contribution_by_chapter_id($chapter_id, $limit = '')
    {
        $map['is_pay'] = 1;
        $map['chapter_id'] = $chapter_id;
        $list = M('contribution')->alias('a')
            ->field('a.*,b.id as uid,b.nickname,b.head_img')
            ->join(C('DB_PREFIX').'member b on b.id = a.uid', 'LEFT')
            ->where($map)
            ->order('a.id desc')
            ->limit($limit)->select();
        foreach( $list as &$_list ) {
            if( $_list['nickname'] == '' ) $_list['nickname'] = "如侧用户" . $_list['uid'];
        }
        return $list;
    }

    /**
     * 打赏次数统计
     * @param $chapter_id
     * @return mixed
     */
    public static function get_contribution_by_chapter_id_id_count($chapter_id)
    {
        $map['is_pay'] = 1;
        $map['chapter_id'] = $chapter_id;
        $count = M('contribution')->where($map)->count();
        return $count;
    }
}
