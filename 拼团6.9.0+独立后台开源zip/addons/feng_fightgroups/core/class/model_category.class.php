<?php 

// +----------------------------------------------------------------------
// | Copyright (c) 2015-2020.
// +----------------------------------------------------------------------
// | Describe: 商品分类
// +----------------------------------------------------------------------
// | Author: weliam<937991452@qq.com>
// +----------------------------------------------------------------------
class model_category
{
	/** 
 	* 获取单条分类数据 
 	* 
 	* @access static
 	* @name getSingleCategory 
 	* @param $id      缓存标志 
 	* @param $select  查询参数 
 	* @param $where   查询条件 
 	* @return array 
 	*/  
	static function getSingleCategory($id,$select,$where){
		$id = intval($id);
//		return Util::getDataByCacheFirst('category',$id,array('Util','getSingelData'),array($select,'tg_category',$where));
		return Util::getSingelData($select,'tg_category',$where=array('id'=>$id));
		//需删除缓存
	}
	/** 
 	* 获取所有分类数据 
 	* 
 	* @access static
 	* @name getNumCategory 
 	* @return array 
 	*/  
	static function getNumCategory(){
		global $_W;
		if($_SESSION['role_id']) $where = array('parentid'=>0,'&open&'=>1);
		else $where = array('parentid'=>0);
		$allParentCategory = Util::getNumData('*','tg_category',$where,'id desc',0,0,0);
		foreach($allParentCategory[0] as $key=>$value){
			$category_childs = pdo_fetchall("SELECT id,name FROM " . tablename('tg_category') . " WHERE uniacid = {$_W['uniacid']} and parentid={$value['id']} and enabled=1 ORDER BY displayorder DESC");
			$childs[$value['id']] = $category_childs;
		}
		return array($allParentCategory[0],$childs);
		//需删除缓存
	}
	/** 
 	* 删除分类数据 
 	* 
 	* @access static
 	* @name getNumCategory 
 	* @return array 
 	*/  
	static function deleteCategory($id){
		$id = intval($id);
		$res = pdo_delete('tg_category',array('id'=>$id));
		Util::deleteCache('category',$id);
		Util::deleteCache('category','allCategory');		
		return $res;
	}	
	
	
}