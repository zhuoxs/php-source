<?php 
/**
 * [weliam] Copyright (c) 2016/3/26
 * 商城首页自定义控制器
 */
defined('IN_IA') or exit('Access Denied');
wl_load()->model('setting');

$ops = array('display');

$op = in_array($op, array('design', 'display')) ? $op : 'display';
if ($op == 'display') {
		$page = tgsetting_read('home');
		if(empty($page) || $_GPC['status'] == 'reset'){
			$page = array(array('sort'=>'search','name'=>'搜索区'),array('sort'=>"adv",'name'=>'幻灯片'),array('sort'=>"notice",'name'=>'公告区'),array('sort'=>"nav",'name'=>'导航区'),array('sort'=>'cube','name'=>'魔方区'),array('sort'=>'banner','name'=>'广告区'),array('sort'=>'goods','name'=>'推荐商品'));
		}else{
			foreach ($page as $key => $value) {
				switch ($value['sort']) {
					case 'search':
						$page[$key]['name'] = '搜索区';
						break;
					case 'adv':
						$page[$key]['name'] = '幻灯片';
						break;
					case 'notice':
						$page[$key]['name'] = '公告区';
						break;
					case 'nav':
						$page[$key]['name'] = '导航区';
						break;
					case 'cube':
						$page[$key]['name'] = '魔方区';
						break;
					case 'banner':
						$page[$key]['name'] = '广告区';
						break;
					case 'goods':
						$page[$key]['name'] = '推荐商品';
						break;
					default:
						break;
				}
			}
		}

		if(checksubmit()){
			$page_sort = $_GPC['sort'];
			$page_sort_on = $_GPC['on'];
			$pageedit = array();
			for($i=0;$i<count($page_sort);$i++){
				$pageedit[$i]['sort'] = $page_sort[$i];
				if(in_array($page_sort[$i], $page_sort_on)){
					$pageedit[$i]['on'] = 1;
				}else{
					$pageedit[$i]['on'] = 0;
				}
			}
			tgsetting_save($pageedit, 'home');
			message('页面保存成功.', web_url('store/home'), 'success');
		}
		include wl_template('store/home');
}
