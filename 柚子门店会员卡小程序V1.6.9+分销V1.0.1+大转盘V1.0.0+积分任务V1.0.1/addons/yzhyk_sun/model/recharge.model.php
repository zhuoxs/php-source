<?php
class recharge extends base{
	public $required_fields = array('money');
	public $unique = array();
	public $order = 'money';
}