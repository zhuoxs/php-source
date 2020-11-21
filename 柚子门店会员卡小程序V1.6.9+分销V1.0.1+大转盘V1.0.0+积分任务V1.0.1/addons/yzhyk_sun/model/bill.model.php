<?php
class bill extends base{
	public $required_fields = array('user_id','balance');
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'user',
            'on'=>array(
                'id'=>'user_id',
            ),
            'columns'=>array(
                'name'=>'user_name',
            ),
        ),
    );
	public function insert($data){
		$data['time'] = time();
		return parent::insert($data);
	}
}