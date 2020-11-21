<?php
class menubutton extends base{
	public $required_fields = array();
	public $unique = array();
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
        array(
            'as'=>'t3',
            'table'=>'button',
            'on'=>array(
                'id'=>'button_id',
            ),
            'columns'=>array(
                'name'=>'button_name',
            ),
        ),
    );
}