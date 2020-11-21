<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Article;

class Comment extends \We7Table {
	protected $tableName = 'article_comment';
	protected $primaryKey = 'id';
	protected $field = array(
		'articleid',
		'parentid',
		'uid',
		'content',
		'is_like',
		'is_reply',
		'like_num',
		'createtime',
	);
	protected $default = array(
		'articleid' => '',
		'parentid' => 0,
		'uid' => '',
		'content' => '',
		'is_like' => 2,
		'is_reply' => 2,
		'like_num' => 0,
		'createtime' => '',
	);

	public function getById($comment_id) {
		return $this->where('id' ,$comment_id)->get();
	}

	public function addComment($comment) {
		if (!empty($comment['parentid'])) {
			$result = $this->where('id', $comment['parentid'])->fill('is_reply', 1)->save();
			if ($result === false) {
				return false;
			}
		}
		$comment['createtime'] = TIMESTAMP;
		$comment['is_like'] = 2;
		return $this->fill($comment)->save();
	}

	public function hasLiked($articleid, $comment_id) {
		global $_W;
		$liked = $this->where(array('articleid' => $articleid, 'parentid' => $comment_id, 'is_like' => 1, 'uid' => $_W['uid']))->getcolumn('id');
		return boolval($liked);
	}

	public function likeComment($uid, $articleid, $comment_id) {
		$like_num = $this->where('id', $comment_id)->getcolumn('like_num');
		$result = $this->where('id', $comment_id)->fill('like_num', $like_num + 1)->save();
		if ($result === false) {
			return false;
		}
		$this->fill(array(
			'uid' => $uid,
			'articleid' => $articleid,
			'parentid' => $comment_id,
			'is_like' => 1,
			'is_reply' => 1,
			'like_num' => 0,
			'content' => '',
			'createtime' => TIMESTAMP,
		));
		return $this->save();
	}

	public function getComments($articleid, $pageindex, $pagesize = 15, $order = 'id') {
		$comments = $this->where('articleid', $articleid)
			->where('parentid', 0)
			->where('is_like', 2)
			->orderby($order, 'DESC')
			->page($pageindex, $pagesize)
			->getall('id');
		$total = $this->getLastQueryTotal();

		if (!empty($comments)) {
			$this->extendUserinfo($comments);
			foreach ($comments as $k => &$comment) {
				$comment['createtime'] = date('Y-m-d H:i', $comment['createtime']);
			}
		}
		return array('list' => $comments, 'total' => $total);
	}

	public function extendUserinfo(&$comments) {
		if (empty($comments)) {
			return true;
		}
		$uids = array();
		foreach ($comments as $comment) {
			$uids[$comment['uid']] = $comment['uid'];
		}
		if (!empty($uids)) {
			$users = $this->getQuery()
				->select('u.uid, u.username, p.realname, p.nickname, p.avatar, p.mobile')
				->from('users', 'u')
				->leftjoin('users_profile', 'p')
				->on(array('u.uid' => 'p.uid'))
				->where('u.uid', $uids)
				->getall('uid');

			foreach ($comments as &$comment) {
				if (!empty($users[$comment['uid']])) {
					$comment = array_merge($comment, $users[$comment['uid']]);
				}
			}
		}
		return true;
	}
}