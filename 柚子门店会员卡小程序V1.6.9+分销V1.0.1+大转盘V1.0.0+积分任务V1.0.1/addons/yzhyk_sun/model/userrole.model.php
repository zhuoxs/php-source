<?php
class userrole extends base{
	public $required_fields = array('user_id','role_id');
	public $unique = array();
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'admin',
            'on'=>array(
                'id'=>'user_id',
            ),
            'columns'=>array(
                'name'=>'user_name',
            ),
        ),
        array(
            'as'=>'t3',
            'table'=>'role',
            'on'=>array(
                'id'=>'role_id',
            ),
            'columns'=>array(
                'name'=>'role_name',
            ),
        ),
        array(
            'as'=>'t4',
            'table'=>'store',
            'on'=>array(
                'id'=>'store_id',
            ),
            'columns'=>array(
                'name'=>'store_name',
            ),
        ),
    );
}