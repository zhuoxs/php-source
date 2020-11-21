<?php
class activity extends base{
	public $required_fields = array('name', 'begin_time', 'end_time');
	public $unique = array();
	public $auto_update_time = true;

	public function delete_by_id($id){
		$activitygoods = new activitygoods();
		$activitygoods->delete(array('activity_id = '.$id));
		
		$res = parent::delete_by_id($id);
		return $res;
	}

    public function insert($data){
        $goodses = $data['goodses'];
        unset($data['goodses']);

        $res = parent::insert($data);
        if ($res['code']) {
            return $res;
        }

        $activitygoods = new activitygoods();

        foreach ($goodses as $goods) {
            $new_goods = array();
            $new_goods['activity_id'] = $res['data'];
            $new_goods['goods_id'] = $goods->goods_id;
            $new_goods['price'] = $goods->price;
            $new_goods['limit'] = $goods->limit;

            $activitygoods->insert($new_goods);
        }
        return $res;
    }

    public function update_by_id($data, $id){
        $goodses = $data['goodses'];
        unset($data['goodses']);

        $res = parent::update_by_id($data, $id);
        if ($res['code']) {
            return $res;
        }

        $activitygoods = new activitygoods();
        $activitygoods->delete(array('activity_id'=>$id));

        foreach ($goodses as $goods) {
            $new_goods = array();
            $new_goods['activity_id'] = $id;
            $new_goods['goods_id'] = $goods->goods_id;
            $new_goods['price'] = $goods->price;
            $new_goods['limit'] = $goods->limit;

            $activitygoods->insert($new_goods);
        }
        return $res;
    }
}