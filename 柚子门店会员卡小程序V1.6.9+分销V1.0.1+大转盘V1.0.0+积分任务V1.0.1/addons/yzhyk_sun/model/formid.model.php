<?php
class formid extends base{
	public $required_fields = array('user_id','form_id');
	public $unique = array();
	public $order = 'time';

	public function insert($data){
		$data['time'] = time() + (6*24*60*60);
		return parent::insert($data);
	}

	public function get_data_by_user_id($id){
	    $time = time();
        $this->delete(array('time <'=>$time));
        $form = pdo_get($this->get_table_name(),array('user_id'=>$id));
        if ($form){
            $this->delete_by_id($form['id']);
        }
        return $form;
    }
}