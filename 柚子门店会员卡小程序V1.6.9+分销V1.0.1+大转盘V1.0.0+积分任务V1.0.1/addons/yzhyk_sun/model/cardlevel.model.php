<?php
class cardlevel extends base{
	public $required_fields = array('name','discount','amount');
	public $unique = array('name');
	public $order = 'amount';
}