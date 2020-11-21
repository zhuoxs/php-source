<?php
class storeactivitygoods extends base{
	public $required_fields = array();
	public $unique = array(array('store_id','goods_id','activity_id'));
    public $relations = array(
//        array(
//            'as'=>'t2',
//            'table'=>'goods',
//            'on'=>array(
//                'id'=>'goods_id',
//            ),
//            'columns'=>array(
//                'name'=>'name',
//            ),
//        ),
        array(
            'as'=>'t3',
            'table'=>'store',
            'on'=>array(
                'id'=>'store_id',
            ),
            'columns'=>array(
                'name'=>'store_name',
            ),
        ),
//        array(
//            'as'=>'t4',
//            'table'=>'goodsclass',
//            'on'=>array(
//                'id'=>'t2.class_id',
//            ),
//            'columns'=>array(
//                'name'=>'class_name',
//            ),
//        ),
//        array(
//            'as'=>'t5',
//            'table'=>'goodsclass',
//            'on'=>array(
//                'id'=>'t2.root_id',
//            ),
//            'columns'=>array(
//                'name'=>'root_name',
//            ),
//        ),
    );
    public function out($store_id, $goods_id, $activity_id, $num= 1){
        $storeactivity = new storeactivity();
        $storeactivity_data = $storeactivity->query2(array(
            'store_id = '.$store_id,
            'activity_id = '.$activity_id,
        ))['data'][0];


        //判断门店商品库存、并修改库存
        $data = $this->query2(array(
            'storeactivity_id = '.$storeactivity_data['id'],
            'goods_id = '.$goods_id,
        ))['data'][0];
        if($data['stock'] < $num){
            throw new ZhyException("商品[{$data['name']}]活动库存不足");
        }
        return $this->update_by_id(array('stock -='=>$num),$data['id']);
    }
}