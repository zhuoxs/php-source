<?php
class groupgoods extends base{
	public $required_fields = array();
	public $unique = array();
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'goods',
            'on'=>array(
                'id'=>'goods_id',
            ),
            'columns'=>array(
                'name'=>'name',
            ),
        ),
    );
    public function insert($data){
        //补充图片信息
        $goods = new goods();
        $goods_data = $goods->get_data_by_id($data['goods_id']);

        if(!$data['pics'] || $data['pics'] == 'null'){
            $data['pics'] = json_encode($goods_data['pics']);
        }
        if(!$data['pic']){
            $data['pic'] = $goods_data['pic'];
        }
        if(!$data['content']){
            $data['content'] = $goods_data['content'];
        }

        return parent::insert($data);
    }
}