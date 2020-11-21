<?php
class goodsclass extends base{
	public $required_fields = array('name');
	public $unique = array('name');
    public $order = 'index';//默认排序
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'goodsclass',
            'on'=>array(
                'id'=>'root_id',
            ),
            'columns'=>array(
                'name'=>'root_name',
            ),
        ),
    );
}