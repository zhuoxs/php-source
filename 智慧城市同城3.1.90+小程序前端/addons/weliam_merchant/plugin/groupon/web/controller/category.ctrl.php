<?php
defined('IN_IA') or exit('Access Denied');

class Category_WeliamController {

	public function index() {
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' aid=:aid and uniacid=:uniacid ';
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= 'and name like \'%' . $keyword . '%\' ';
		}

		$base = Setting::agentsetting_read('groupon');
		if ($base['catelevel'] == 1) {
			$list = pdo_fetchall('select id,thumb,sort, `name` from ' . tablename('wlmerchant_groupon_category') . ' where parentid = 0 and' . $condition . ' order by sort desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':aid' => intval($_W['aid']),':uniacid' => $_W['uniacid']));
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wlmerchant_groupon_category') . ' where parentid = 0 and' . $condition, array(':aid' => intval($_W['aid']), ':uniacid' => $_W['uniacid']));
			foreach ($list as $key => &$value) {
				$value['child'] = pdo_getall('wlmerchant_groupon_category', array('parentid' => $value['id']),'','','sort DESC');
			}
		}else{
			$list = pdo_fetchall('select id,thumb,sort, `name` from ' . tablename('wlmerchant_groupon_category') . ' where' . $condition . ' order by sort desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':aid' => intval($_W['aid']),':uniacid' => $_W['uniacid']));
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wlmerchant_groupon_category') . ' where ' . $condition, array(':aid' => intval($_W['aid']), ':uniacid' => $_W['uniacid']));
		}
		$pager = pagination($total, $pindex, $psize);

		include wl_template('grouponcate/category');
	}

	public function delete() {
		global $_W,$_GPC;

		if ($_W['ispost']) {
			$id = intval($_GPC['id']);
			if (empty($id)) {
				show_json(0, '参数错误，请刷新重试！');
			}

			$item = pdo_fetch('SELECT id, name, uniacid FROM ' . tablename('wlmerchant_groupon_category') . ' WHERE id=:id and aid=:aid and uniacid=:uniacid ', array(':aid' => intval($_W['aid']),':uniacid' => $_W['uniacid'],':id' => $id));

			if (!empty($item)) {
				pdo_delete('wlmerchant_groupon_category', array('id' => $id,'aid' => intval($_W['aid'])));
			}

			show_json(1);
		}
	}

	public function add() {
		global $_W,$_GPC;
		$id = intval($_GPC['id']);
		$parentid = intval($_GPC['parentid']);
		if ($_W['ispost']) {
			$name = trim($_GPC['name']);
			$thumb = trim($_GPC['thumb']);
			$sort = intval($_GPC['sort']);
			if(empty($name)){
				show_json(0, '分类名称为空！');
			}
			if($id){
				pdo_update('wlmerchant_groupon_category', array('name' => $name,'thumb'=>$thumb,'sort'=>$sort), array('id' => $id,'aid' => intval($_W['aid'])));
			}else {
				pdo_insert('wlmerchant_groupon_category', array('name' => $name,'thumb'=>$thumb,'sort'=>$sort,'parentid'=>$parentid,'uniacid' => $_W['uniacid'],'aid' => intval($_W['aid'])));
			}
			show_json(1);
		}
		$item = pdo_fetch('SELECT * FROM ' . tablename('wlmerchant_groupon_category') . ' WHERE id=:id and aid=:aid and uniacid=:uniacid ', array(':aid' => intval($_W['aid']),':uniacid' => $_W['uniacid'],':id' => $id));
		$pitem = pdo_fetch('SELECT id, name FROM ' . tablename('wlmerchant_groupon_category') . ' WHERE id=:id and aid=:aid and uniacid=:uniacid ', array(':aid' => intval($_W['aid']),':uniacid' => $_W['uniacid'],':id' => $parentid));
		
		include wl_template('grouponcate/catemodal');
	}

	public function edit() {
		global $_W,$_GPC;
		$id = intval($_GPC['id']);
		$name = trim($_GPC['value']);
		$item = pdo_fetch('SELECT id, name, uniacid FROM ' . tablename('wlmerchant_groupon_category') . ' WHERE id=:id and aid=:aid and uniacid=:uniacid ', array(':aid' => intval($_W['aid']),':uniacid' => $_W['uniacid'],':id' => $id));

		if (!empty($item)) {
			pdo_update('wlmerchant_groupon_category', array('name' => $name), array('id' => $id,'aid' => intval($_W['aid'])));
			show_json(1, '分类修改成功');
		} else {
			show_json(0, '分类不存在,请刷新页面重试！');
		}
	}
	
	public function synccate() {
		global $_W,$_GPC;
		$item = pdo_getall('wlmerchant_category_store', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'parentid' => 0));
		foreach ($item as $key => $value) {
			pdo_insert('wlmerchant_groupon_category', array('name'=>$value['name'],'thumb'=>$value['thumb'],'sort'=>$value['displayorder'],'uniacid' => $_W['uniacid'],'aid' => intval($_W['aid'])));
			$pid = pdo_insertid();
			
			$citem = pdo_getall('wlmerchant_category_store', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'parentid' => $value['id']));
			foreach ($citem as $ckey => $cvalue) {
				pdo_insert('wlmerchant_groupon_category', array('name'=>$cvalue['name'],'thumb'=>$cvalue['thumb'],'sort'=>$cvalue['displayorder'],'parentid'=>$pid,'uniacid' => $_W['uniacid'],'aid' => intval($_W['aid'])));
			}
		}
		show_json(1, '分类同步成功');
	}
	
	public function specialindex() {
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		
		$condition = ' and aid=:aid and uniacid=:uniacid ';
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' and title like \'%' . $keyword . '%\' ';
		}

		$list = pdo_fetchall('select id,`title` from ' . tablename('wlmerchant_rush_special') . ' where 1 ' . $condition . ' order by id desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':aid' => intval($_W['aid']),':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wlmerchant_rush_special') . ' where aid=:aid and uniacid=:uniacid ', array(':aid' => intval($_W['aid']), ':uniacid' => $_W['uniacid']));
		$pager = pagination($total, $pindex, $psize);	
		
		
		include wl_template('grouponcate/specialindex');
	}
	
	public function sptitleedit(){
		global $_W,$_GPC;
		$id = intval($_GPC['id']);
		$title = trim($_GPC['value']);
		$res = pdo_update('wlmerchant_rush_special',array('title'=>$title),array('id' => $id));
		if($res){
			show_json(1, '修改成功');
		}else {
			show_json(0, '修改失败,请刷新页面重试！');
		}
	}
	
	public function specialdelete() {
		global $_W,$_GPC;
		if ($_W['ispost']) {
			$id = intval($_GPC['id']);
			if (empty($id)) {
				show_json(0, '参数错误，请刷新重试！');
			}else {
				$res = pdo_delete('wlmerchant_rush_special', array('id' => $id,'aid' => intval($_W['aid'])));
			}
			if($res){
				show_json(1);
			}else {
				show_json(0, '删除失败,请刷新页面重试！');
			}
		}
	}
	
	public function specialedit(){
		global $_W,$_GPC;
		$id = intval($_GPC['id']);
		if($id){
			$special = pdo_get('wlmerchant_rush_special',array('id' => $id));
		}
		if (checksubmit('submit')){
			$special = $_GPC['special'];
			if(empty($special['title'])) wl_message('请填写专题标题');
			if(empty($special['share_title'])) wl_message('请填写分享标题');
			if(empty($special['share_desc'])) wl_message('请填写分享描述');
			if(empty($special['thumb'])) wl_message('请上传专题图片');
			$special['rule'] = htmlspecialchars_decode($special['rule']);
			
			
			if($id){
				$res = pdo_update('wlmerchant_rush_special',$special,array('id' => $id));
			}else{
				$special['uniacid'] = $_W['uniacid'];
				$special['aid'] = $_W['aid'];
				$special['createtime'] = time();
				$res = pdo_insert('wlmerchant_rush_special',$special);
			}
			if($res){
				wl_message('保存成功！',web_url('rush/category/specialindex'),'success');
			}else{
				wl_message('保存失败，请重试');
			}
		}
		include wl_template('grouponcate/specialedit');
	}

}
?>
