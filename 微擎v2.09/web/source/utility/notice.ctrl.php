<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if(empty($_W['uid'])) {
	exit('uid not exist');
}

$new_id = pdo_fetchcolumn('SELECT notice_id FROM' . tablename('article_unread_notice') . ' WHERE uid = :uid ORDER BY notice_id DESC LIMIT 1', array(':uid' => $_W['uid']));
$new_id = intval($new_id);
$notices = pdo_fetchall('SELECT id FROM ' . tablename('article_notice') . ' WHERE is_display = 1 AND id > :id', array(':id' => $new_id));
if(!empty($notices)) {
	foreach($notices as &$notice) {
		$insert = array(
			'uid' => $_W['uid'],
			'notice_id' => $notice['id'],
			'is_new' => 1,
		);
		pdo_insert('article_unread_notice', $insert);
	}
}
$total = 0;
$notreads = array();
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename('article_unread_notice') . ' WHERE uid = :uid AND is_new = 1', array(':uid' => $_W['uid']));
$categorys = pdo_fetchall('SELECT id,title FROM ' . tablename('article_category') . ' WHERE type = :type', array(':type' => 'notice'), 'id');
if($total > 0) {
	$notreads = pdo_fetchall('SELECT id,title,createtime,cateid FROM ' . tablename('article_notice') . ' WHERE is_display = 1 AND id IN (SELECT notice_id FROM '. tablename('article_unread_notice') . ' WHERE uid = :uid AND is_new = 1) ORDER BY displayorder DESC, id DESC LIMIT 5', array(':uid' => $_W['uid']), 'id');
	foreach($notreads as &$notread) {
		$notread['catename'] = $categorys[$notread['cateid']]['title'];
		$notread['is_new'] = 1;
	}
}
if($total < 5) {
	$limit = 5 - $total;
	$notices = pdo_fetchall('SELECT id,title,createtime,cateid FROM ' . tablename('article_notice') . ' WHERE is_display = 1 ORDER BY displayorder DESC, id DESC LIMIT ' . $limit, array(), 'id');
	foreach($notices as &$notice) {
		$notice['catename'] = $categorys[$notice['cateid']]['title'];
		$notice['is_new'] = 0;
	}
}
$notices = array_merge($notreads, $notices);
$html = '';
if(!empty($notices)) {
	foreach($notices as $row) {
		$class = 'new';
		if(!$row['is_new']) {
			$class = 'old';
		}
		$html .= '<li>' .
					'<a href="'.url('article/notice-show/detail', array('id' => $row['id'])).'" target="_blank" class="clearfix">' .
						'<div><i class="fa fa-circle ' . $class . '"></i></div>' .
						'<div>' .
							'<h3>' . $row['title'] . '</h3>' .
							'<div class="date">' . date('Y-m-d', $row['createtime']) . '</div>' .
						'</div>' .
						'<div><span class="label label-info">'. $row['catename'] .'</span></div>' .
					'</a>' .
				'</li>';
	}
}
$data = array(
	'total' => $total,
	'notices' => $html
);
exit(json_encode($data));
