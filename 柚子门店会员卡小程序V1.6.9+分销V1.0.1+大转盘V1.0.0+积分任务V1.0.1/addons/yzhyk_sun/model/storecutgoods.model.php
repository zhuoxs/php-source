<?php
class storecutgoods extends base{
	public $required_fields = array();
	public $unique = array(array('store_id','cutgoods_id'));
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
            'table'=>'cutgoods',
            'on'=>array(
                'id'=>'cutgoods_id',
            ),
            'columns'=>array(
                'goods_name'=>'goods_name',
                'title'=>'title',
                'begin_time'=>'begin_time',
                'end_time'=>'end_time',
            ),
        ),
    );
    public function out($storecutgoods_id, $num= 1){
        //判断门店商品库存、并修改库存
        $data = $this->query2(array(
            't1.id = '.$storecutgoods_id,
        ))['data'][0];
        if($data['stock'] < $num){
            throw new ZhyException("商品[{$data['goods_name']}]活动数量不足");
        }
        return $this->update_by_id(array('stock -='=>$num),$storecutgoods_id);
    }
    public function in($storecutgoods_id, $num= 1){
        return $this->update_by_id(array('stock +='=>$num),$storecutgoods_id);
    }
}