<?php
defined('IN_IA') or exit('Access Denied');

class Category_WeliamController{
	/*
	 * 商户分类列表
	 */
	public function index(){
		global $_W,$_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 100;	         
		$categoryes = Store::getAllCategory($pindex-1,$psize,0);
		$categorys = $categoryes['data'];
		
		$pager = pagination($categoryes['count'], $pindex, $psize);
		if(!empty($categorys)){
			foreach($categorys as $key=>$value){
				$childrens = Store::getAllCategory(0,100,$value['id']);
				$categorys[$key]['children'] = $childrens['data'];
			}
		}
		include wl_template('store/categoryIndex');
	}

	public function Edit(){ 
		global $_W,$_GPC;
		if(checksubmit('submit')){
			$category = $_GPC['category'];
			if(!empty($_GPC['parentid'])){
				$category['parentid'] =intval($_GPC['parentid']);
				$category['visible_level']=2;
			}else{
				$category['parentid'] =0;
				$category['visible_level']=1;
			}
			$category['name'] = trim($category['name']);
			$category['displayorder'] = intval($category['displayorder']);
			$category['enabled'] = intval($_GPC['enabled']);
			//判断时候有值进行改状态
			if(!empty($category['abroad']))
            {
                $category['abroad'] = $category['abroad'];
                $category['state'] = 1;
            } 
            else
            {
                $category['abroad'] = $category['abroad'];
                $category['state'] = 0;
            }

			if(!empty($_GPC['id'])){
				if(Store::categoryEdit($category,$_GPC['id'])) wl_message('保存成功',web_url('store/category/index'),'success');
			}else{
				if(Store::categoryEdit($category)) wl_message('保存成功',web_url('store/category/index'),'success');
			}
			wl_message('保存失败',referer(),'error');
		}
		if(!empty($_GPC['id'])) 
		$category = Store::getSingleCategory($_GPC['id']);
		include wl_template('store/categoryEdit');
	}
	
	public function Delete(){
		global $_W,$_GPC;
		if(Store::categoryDelete($_GPC['id'])) wl_message('删除成功',web_url('store/category/index'),'success');
		wl_message('删除失败',referer(),'error');
		
	}
   
    
	public function getCategory(){
		global $_W,$_GPC;
		if(!empty($_GPC['parentid'])){
			$categoryes = Store::getAllCategory(0,100,$_GPC['parentid']);
		}else{
			$categoryes = Store::getAllCategory();
		}
		$categorys = $categoryes['data'];
		die(json_encode(array('status'=>1,'data'=>$categorys,'msg'=>'')));
	}
}
