<?php
class integral extends base{
	public $required_fields = array('user_id','integral');
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
		if ($data['integral'] <= 0){
		    return array(
		        'code'=>0,
            );
        }
//        修改用户积分
        $user_model = new user();
		$user_data = $user_model->get_data_by_id($data['user_id']);
        $user_model->update_by_id(array('integral'=>($user_data['integral']?:0)+$data['integral']),$data['user_id']);
		return parent::insert($data);
	}
}