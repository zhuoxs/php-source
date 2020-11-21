<?php
defined('IN_IA') or exit('Access Denied');

class Diy_WeliamController {
	/**
	 * Comment: 进入公众号页面列表
	 * Author: zzw
	 */
	public function pagelist() {
		global $_W, $_GPC;
		$pageClass = 1;
		//判断是添加公众号页面 还是小程序页面 1=公众号页面   2=小程序页面
		$pageName = $_GPC['page_name'];
		$pindex = max(1, intval($_GPC['page']));
		$data = Diy::pageList($pageName, $pindex, $pageClass);

		$backUrl = "diypage/diy/pagelist";
		//返回地址
		$modalUrl = 'pagelist';
		$list = $data['list'];
		$pager = $data['pager'];

		include  wl_template('diypage/info');
	}

	/**
	 * Comment: 进入公众号菜单列表
	 * Author: zzw
	 */
	public function menulist() {
		global $_W, $_GPC;
		$menuClass = 1;
		//1=公众号菜单   2=小程序菜单
		$name = $_GPC['name'];
		$pindex = max(1, intval($_GPC['page']));
		$data = Diy::menuList($name, $pindex, $menuClass);

		$edit = "diypage/diy/menuEdit";
		//编辑的地址
		$modalUrl = 'menulist';
		$list = $data['list'];
		$pager = $data['pager'];

		include  wl_template('diypage/info');
	}

	/**
	 * Comment: 进入公众号菜单编辑页面
	 * Author: zzw
	 */
	public function menuEdit() {
		global $_W, $_GPC;
		$backUrl = "diypage/diy/menulist";
		//返回地址
		$modalUrl = 'menuEdit';
		$menuClass = intval($_GPC['menu_class']);
		$id = intval($_GPC['id']);
		$menu = Diy::getMenu($id);

		include  wl_template('diypage/info');
	}

	/**
	 * Comment: 进入公众号广告列表
	 * Author: zzw
	 */
	public function advlist() {
		global $_W, $_GPC;
		$name = $_GPC['name'];
		$pindex = max(1, intval($_GPC['page']));
		$advClass = 1;
		//1=公众号广告   2=小程序广告
		$data = Diy::advList($name, $pindex, $advClass);

		$edit = "diypage/diy/advEdit";
		//编辑的地址
		$modalUrl = 'advlist';
		$list = $data['list'];
		$pager = $data['pager'];

		include  wl_template('diypage/info');
	}

	/**
	 * Comment: 进入公众号广告编辑页面
	 * Author: zzw
	 */
	public function advEdit() {
		global $_W, $_GPC;
		$id = intval($_GPC['id']);
		$advClass = $_GPC['adv_class'];
		$backUrl = "diypage/diy/advlist";
		//返回地址
		$modalUrl = 'advEdit';
		if (!empty($id)) {
			$advs = Diy::getAdv($id);
		}

		include  wl_template('diypage/info');
	}

	/**
	 * Comment: 进入公众号模板列表
	 * Author: zzw
	 */
	public function templist() {
		global $_W, $_GPC;
		#1、获取参数信息
		$cate = $_GPC['cate'];
		$tempName = $_GPC['temp_name'];
		$pindex = max(1, intval($_GPC['page']));
		$backUrl = "diypage/diy/templist";
		//返回地址
		$modalUrl = 'templist';
		$pageClass = 1;
		// 1=公众号模板   2=小程序模板
		$data = Diy::tempList($cate, $tempName, $pindex, $pageClass);

		$list = $data['list'];
		$pager = $data['pager'];
		$allpagetype = $data['allpagetype'];
		$category = $data['category'];

		include  wl_template('diypage/info');
	}

	/**
	 * Comment: 进入公众号模板分类管理页面
	 * Author: zzw
	 */
	public function catelist() {
		global $_W, $_GPC;
		$pageClass = 1;
		// 1=公众号模板分类   2=小程序模板分类
		$pindex = max(1, intval($_GPC['page']));
		$keyword = trim($_GPC['keyword']);
		$modalUrl = 'catelist';
		$data = Diy::cateList($pindex, $keyword, $pageClass);

		$list = $data['list'];
		$pager = $data['pager'];

		include  wl_template('diypage/info');
	}

}
