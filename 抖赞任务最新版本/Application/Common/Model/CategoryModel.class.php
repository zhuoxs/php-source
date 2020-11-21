<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 分类操作model
 */
class CategoryModel extends BaseModel{

	/**
	 * 删除数据
	 * @param	array	$map	where语句数组形式
	 * @return	boolean			操作是否成功
	 */
	public function deleteData($map){
		$count=$this
			->where(array('pid'=>$map['id']))
			->count();
		if($count!=0){
			return false;
		}
		$this->where(array($map))->delete();
		return true;
	}

	/**
	 * 获取全部分类
	 * @param  string $type tree获取树形结构 level获取层级结构
	 * @return array       	结构数据
	 */
	public function getTreeData($type='tree',$order=''){
		// 判断是否需要排序
		if(empty($order)){
			$data=$this->select();
		}else{
			$data=$this->order('order_number is null,'.$order)->select();
		}
		// 获取树形或者结构数据
		if($type=='tree'){
			$data=\Org\Nx\Data::tree($data,'name','id','pid');
		}elseif($type="level"){
			$data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;','id');
		}
		// p($data);die;
		return $data;
	}

    public static function get_list_val_key() {
        $list = M('category')->field('id,name')->select();
        $new_arr = array();
        foreach( $list as $v ) {
            $new_arr[$v['id']] = $v['name'];
        }
        return $new_arr;
    }
}
