<?php
class rechargecode extends base{
	public $required_fields = array('recharge_code','membercard_id');
	public $unique = array();
}