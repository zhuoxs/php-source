<?php
class storegroupgoods extends base{
	public $required_fields = array();
	public $unique = array(array('store_id','groupgoods_id'));
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
        array(
            'as'=>'t3',
            'table'=>'groupgoods',
            'on'=>array(
                'id'=>'groupgoods_id',
            ),
            'columns'=>array(
                'goods_name'=>'goods_name',
                'title'=>'title',
                'begin_time'=>'begin_time',
                'end_time'=>'end_time',
            ),
        ),
    );
    public function out($id, $num= 1){
        //判断门店商品库存、并修改库存
        $data = $this->get_data_by_id($id);
        if($data['stock'] < $num){
            throw new ZhyException("团购数量不足");
        }
        return $this->update_by_id(array('stock -='=>$num),$data['id']);
    }
    public function int($id, $num= 1){
        return $this->update_by_id(array('stock +='=>$num),$id);
    }
}