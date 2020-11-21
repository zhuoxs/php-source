<?php
class role extends base{
	public $required_fields = array('name');
	public $unique = array('name');
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'role',
            'on'=>array(
                'id'=>'role_id',
            ),
            'columns'=>array(
                'name'=>'role_name',
            ),
        ),
    );
	// 通过 id 删除数据
	public function delete_by_id($id){
		$res = parent::delete_by_id($id);
		$userrole = new userrole();
		$userrole->delete(array('role_id'=>$id));
		return $res;
	}
}