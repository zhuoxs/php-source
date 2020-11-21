<?php
class admin extends base{
	public $required_fields = array('name','code','password');
	public $unique = array('name','code');

	// 通过 id 删除数据
	public function delete_by_id($id){
		$res = parent::delete_by_id($id);
		$userrole = new userrole();
		$userrole->delete(array('user_id'=>$id));
		return $res;
	}
}