<?php
class cut extends base{
	public $required_fields = array();
	public $unique = array();

	public function insert($data){
        $data['state'] = 0;
        $data['cut_price'] = 0;
        $data['cut_num'] = 0;
        $storecutgoods = new storecutgoods();
//	    补充砍价信息
        if (!isset($data['num'])){
            $storecutgoods_data = $storecutgoods->get_data_by_id($data['storecutgoods_id']);

            $cutgoods = new cutgoods();
            $cutgoods_data = $cutgoods->get_data_by_id($storecutgoods_data['cutgoods_id']);

            $goods = new goods();
            $goods_data = $goods->get_data_by_id($cutgoods_data['goods_id']);

            $data['end_time'] = strtotime($cutgoods_data['end_time']);
            $time = time() + $cutgoods_data['useful_hour']*3600;
            if ($cutgoods_data['useful_hour'] && $data['end_time']>$time) {
                $data['end_time']=$time;
            }
            $data['num'] = $cutgoods_data['num'];
            $data['cutgoods_id'] = $storecutgoods_data['cutgoods_id'];
            $data['price'] = $cutgoods_data['price'];
            $data['shop_price'] = $goods_data['shopprice'];
        }

//        扣减砍价活动数量
        $storecutgoods->out($data['storecutgoods_id']);

        $res = parent::insert($data);
        $cut_id = $res['data'];

        $cutuser_data['cut_id'] = $cut_id;
        $cutuser_data['user_id'] = $data['user_id'];

        $cutuser = new cutuser();
        $price = $cutuser->insert($cutuser_data);

        $task_model = new task();
//        添加砍价过期时间检查任务
        $task_model->insert([
            'type' => 'checkOutdateCut',
            'value' => $cut_id,
            'execute_time' => ($data['end_time']?:0)+10,
        ]);

        return array(
            'cut_id'=>$cut_id,
            'cut_price'=>$price
        );
    }

	public function finish($id){
	    $res = $this->update_by_id(array('state'=>1),$id);
	    return $res;
    }

    public function delete_app($id){
        $res = $this->update_by_id(array('state'=>-10),$id);
        return $res;
    }

//    public function clear(){
//	    $list = $this->query2(array(
//	        'end_time < '.time(),
//            'state=0'
//        ))['data'];
//	    $storecutgoods = new storecutgoods();
//        foreach ($list as $item) {
//            $storecutgoods->in($item['storecutgoods_id']);
//            $this->update_by_id(array('state'=>-1),$item['id']);
//	    }
//    }

    public function checkOutdate($id){
	    $data = $this->get_data_by_id($id);
	    if ($data['state'] == 0){
            $storecutgoods = new storecutgoods();
            $storecutgoods->in($data['storecutgoods_id']);
            $this->update_by_id(array('state'=>-1),$id);
        }
        return true;
    }
}