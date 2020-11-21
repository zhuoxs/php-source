<?php
class group extends base{
	public $required_fields = array();
	public $unique = array();
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'storegroupgoods',
            'on'=>array(
                'id'=>'storegroupgoods_id',
            ),
            'columns'=>array(
//                'name'=>'name',
            ),
        ),
        array(
            'as'=>'t3',
            'table'=>'store',
            'on'=>array(
                'id'=>'t2.store_id',
            ),
            'columns'=>array(
                'name'=>'store_name',
            ),
        ),
        array(
            'as'=>'t4',
            'table'=>'user',
            'on'=>array(
                'id'=>'user_id',
            ),
            'columns'=>array(
                'name'=>'user_name',
            ),
        ),
        array(
            'as'=>'t5',
            'table'=>'groupgoods',
            'on'=>array(
                'id'=>'groupgoods_id',
            ),
            'columns'=>array(
                'num'=>'num2',
                'title'=>'name',
            ),
        ),
    );
    public function insert($data){
        $data['state'] = 0;
        $data['num'] = 0;

        $ret = parent::insert($data);

        $task_model = new task();
//        添加砍价过期时间检查任务
        $task_model->insert([
            'type' => 'checkOutdateGroup',
            'value' => $ret['data'],
            'execute_time' => ($data['end_time']?:0)+10,
        ]);

        return $ret;
    }
    //    参团
    public function join($id, $num = 1){
        $data = array();
        $data['num +='] = $num;
        $group_data = $this->get_data_by_id($id);

//        判断是否超过有效期
        if ($group_data['end_time'] < time()){
            throw new ZhyException("该团已失效");
        }

        //判断拼团活动数量
        $storegroupgoods = new storegroupgoods();
        $storegroupgoods->out($group_data['storegroupgoods_id']);

        $groupgoods = new groupgoods();
        $groupgoods_data = $groupgoods->get_data_by_id($group_data['groupgoods_id']);
//        判断是否满团
        if ($groupgoods_data['num'] - $group_data['num'] == $num){

//            修改团购状态
            $data['state'] = 1;
//            写入商城订单
            $grouporder = new grouporder();
            $grouporder_list = $grouporder->query(array("group_id=$id"));
            $order = new order();
            $ordergoods = new ordergoods();
            foreach ($grouporder_list['data'] as $order_data) {
                $data_goods['id'] = $groupgoods_data['goods_id'];
                $data_goods['title'] = $order_data['goods_name'];
                $data_goods['price'] = $order_data['goods_price'];
                $data_goods['src'] = $order_data['goods_img'];
                $data_goods['num'] = $order_data['num'];

                unset($order_data['goods_id']);
                unset($order_data['goods_name']);
                unset($order_data['goods_price']);
                unset($order_data['goods_img']);
                unset($order_data['num']);
                unset($order_data['group_id']);
                unset($order_data['id']);
                $order_data['state'] = 20;
                $order_data['order_type'] = 2;
                $order_data['goodses'] = array($data_goods);
                $ret = $order->insert($order_data);
            }
        }
        return $this->update_by_id($data,$id);
    }
    public function out($id, $num = 1){
        if ($num == 0){
            return true;
        }
        return $this->update_by_id(array('num -='=>$num),$id);
    }
    public function cancel($id){
        $groupuser = new groupuser();
        $groupuser->cancel(array('group_id'=>$id));

        $group_data = $this->get_data_by_id($id);
        //增加拼团活动数量
        $storegroupgoods = new storegroupgoods();
        $storegroupgoods->int($group_data['storegroupgoods_id']);

        return $this->update_by_id(array('state'=>-1),$id);
    }
//    public function clear(){
//        $list = $this->query2(array(
//            't1.end_time < '.time(),
//            't1.state=0'
//        ))['data'];
//        foreach ($list as $item) {
//            $this->cancel($item['id']);
//        }
//    }
    public function checkOutdate($id){
        $data = $this->get_data_by_id($id);
        if ($data['state'] == 0){
            $this->cancel($id);
        }
        return true;
    }
}