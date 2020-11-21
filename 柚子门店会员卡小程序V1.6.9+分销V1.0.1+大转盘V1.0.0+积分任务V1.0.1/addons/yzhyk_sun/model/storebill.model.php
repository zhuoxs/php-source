<?php
class storebill extends base{
	public $required_fields = array();
	public $unique = array();
//	public $auto_update_time = true;

    public function insert($data){
        $res = parent::insert($data);
        if ($res['code']) {
            return $res;
        }

        $store_model = new store();
        $store = $store_model->get_data_by_id($data['store_id']);
        $store_model->update_by_id(['balance'=>$store['balance']+$data['balance']],$data['store_id']);

        return $res;
    }
}