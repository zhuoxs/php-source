<?php
class goods extends base{
	public $required_fields = array('name','code');
	public $unique = array('name','code');
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'goodsclass',
            'on'=>array(
                'id'=>'class_id',
            ),
            'columns'=>array(
                'name'=>'class_name',
            ),
        ),
        array(
            'as'=>'t3',
            'table'=>'goodsclass',
            'on'=>array(
                'id'=>'root_id',
            ),
            'columns'=>array(
                'name'=>'root_name',
            ),
        ),
    );

	public function get_data_by_id($id = 0){
		$info = parent::get_data_by_id($id);
		$info['pics'] = json_decode($info['pics']);
		return $info;
	}
}