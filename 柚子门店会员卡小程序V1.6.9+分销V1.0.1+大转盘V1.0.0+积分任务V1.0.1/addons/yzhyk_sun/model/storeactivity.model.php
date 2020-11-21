<?php
class storeactivity extends base{
	public $required_fields = array();
	public $unique = array(array('store_id','activity_id'));
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'store',
            'on'=>array(
                'id'=>'store_id',
            ),
            'columns'=>array(
                'name'=>'store_name',
            ),
        ),
    );
    public function insert_activity($store_id, $activity_id){
        $activity = new activity();
        $data = $activity->get_data_by_id($activity_id);
        unset($data['id']);
        $data['activity_id']=$activity_id;
        $data['store_id'] = $store_id;
        $res = $this->insert($data);
        $id = $res['data'];

        $activitygoods = new activitygoods();
        $storeactivitygoods = new storeactivitygoods();
        $list = $activitygoods->query(array("activity_id = $activity_id"))['data'];
        foreach ($list as $item) {
            unset($item['id']);
            $item['stock'] = $item['limit'];
            $item['storeactivity_id'] = $id;
            $item['store_id'] = $store_id;
            $storeactivitygoods->insert($item);
        }
    }


    public function insert($data){
        $goodses = $data['goodses'];
        unset($data['goodses']);

        $res = parent::insert($data);
        if ($res['code']) {
            return $res;
        }

        $storeactivitygoods = new storeactivitygoods();

        foreach ($goodses as $goods) {
            $new_goods = array();
            $new_goods['storeactivity_id'] = $res['data'];
            $new_goods['goods_id'] = $goods->goods_id;
            $new_goods['price'] = $goods->price;
            $new_goods['limit'] = $goods->limit;
            $new_goods['stock'] = $goods->stock;

            $storeactivitygoods->insert($new_goods);
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

        $storeactivitygoods = new storeactivitygoods();
        $storeactivitygoods->delete(array('storeactivity_id'=>$id));

        foreach ($goodses as $goods) {
            $new_goods = array();
            $new_goods['storeactivity_id'] = $id;
            $new_goods['activity_id'] = $goods->activity_id;
            $new_goods['goods_id'] = $goods->goods_id;
            $new_goods['price'] = $goods->price;
            $new_goods['limit'] = $goods->limit;
            $new_goods['stock'] = $goods->stock;

            $storeactivitygoods->insert($new_goods);
        }
        return $res;
    }
}