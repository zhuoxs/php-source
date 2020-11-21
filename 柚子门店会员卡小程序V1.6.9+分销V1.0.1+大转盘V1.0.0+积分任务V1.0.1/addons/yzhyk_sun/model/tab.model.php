<?php
class tab extends base{
	public $required_fields = array('name','title','pic','pic_s','page');
	public $unique = array('name','title');
	public $order = 'tab_index';
}