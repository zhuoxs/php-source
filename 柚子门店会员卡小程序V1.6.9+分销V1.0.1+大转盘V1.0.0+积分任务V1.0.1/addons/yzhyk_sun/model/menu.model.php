<?php
class menu extends base{
	public $required_fields = array('name');
	public $unique = array(array('name','menu_id'));
	public $has_uniacid = false;
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'menu',
            'on'=>array(
                'id'=>'menu_id',
            ),
            'columns'=>array(
                'name'=>'menu_name',
            ),
        ),
    );
}