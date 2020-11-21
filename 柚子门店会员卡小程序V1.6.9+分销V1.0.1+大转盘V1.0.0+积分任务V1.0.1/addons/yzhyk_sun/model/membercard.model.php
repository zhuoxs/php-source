<?php
class membercard extends base{
	public $required_fields = array('name','days','amount');
	public $unique = array('name');
	public $order = 'amount';
}