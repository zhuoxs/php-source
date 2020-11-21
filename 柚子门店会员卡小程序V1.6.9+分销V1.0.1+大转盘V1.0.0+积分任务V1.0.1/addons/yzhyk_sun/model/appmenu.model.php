<?php
class appmenu extends base{
	public $required_fields = array('name','pic','page');
	public $unique = array('name');
	public $order = 'appmenu_index';
}