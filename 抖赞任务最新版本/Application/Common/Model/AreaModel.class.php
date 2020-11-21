<?php
namespace Common\Model;
use Think\Model;

/**
 * Pid型的树形结构的分类模型 - 数据对象模型
 * @author Dav
 */
class AreaModel extends Model
{
	/**
	 * 当指定pid时，查询该父分类的所有子分类；否则查询所有分类
	 * @param integer $pid 父分类ID
	 * @param string $field 显示的字段，默认为空
	 * @return array 相应的分类列表
	 */
	public function getCategoryList($pid = -1, $field = '')
	{
		$map = array();
		$pid != -1 && $map['pid'] = $pid;
		empty($field) && $field = 'area_id, title, pid';
		$data = $this->field($field)->where($map)->order('`sort` ASC')->select();
		
		return $data;
	}

	/**
	 * 获取指定父分类的树形结构
	 * @return integer $pid 父分类ID
	 * @return array 指定父分类的树形结构
	 */
	public function getNetworkList($pid = 0)
	{
		// 子分类树形结构
		if($pid != 0) {
			return $this->_MakeTree($pid);
		}
		// 全部分类树形结构
		$list = S('category_cache_area');
		if(!$list) {
			set_time_limit(0);
			$list = $this->_MakeTree($pid);
			S('category_cache_area', $list, 8400000);
		}

		return $list;
	}
	
	/**
	 * 递归形成树形结构
	 * @param integer $pid 父分类ID
	 * @param integer $level 等级
	 * @return array 树形结构
	 */
	private function _MakeTree($pid, $level = 0)
	{
		$result = $this->where('pid='.$pid)->order('sort ASC')->select();
		if($result) {
			foreach($result as $key => $value) {
				$id = $value['area_id'];
				$list[$id]['id'] = $value['area_id'];
				$list[$id]['pid'] = $value['pid'];
				$list[$id]['title'] = $value['title'];
				$list[$id]['level'] = $level;
				$list[$id]['child'] = $this->_MakeTree($value['area_id'], $level + 1);
			}
		}

		return $list;
	}

	
}