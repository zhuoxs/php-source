<?php
/**
 * 商城分类页面
 */
defined('IN_IA') or exit('Access Denied');

//0.title
$title = '商品分类';
//1.获取分类
$sql = 'SELECT * FROM ' . tablename('wg_fenxiao_category') . ' WHERE `weid` = :weid AND enabled=1 ORDER BY `parentid`, `displayorder` DESC';
$category = pdo_fetchall($sql, array(
    ':weid' => $_W['uniacid']
) , 'id');
if (!empty($category)) {
    $parent = $children = array();
    
    foreach ($category as $cid => $cate) {
        if (!empty($cate['parentid'])) {
            $children[$cate['parentid']][] = $cate;
        } else {
            $parent[$cate['id']] = $cate;
        }
    }
}
include $this->template('category');
