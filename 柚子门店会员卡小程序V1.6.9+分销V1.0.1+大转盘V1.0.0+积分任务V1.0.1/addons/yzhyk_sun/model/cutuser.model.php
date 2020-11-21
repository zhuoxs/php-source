<?php
class cutuser extends base{
	public $required_fields = array();
	public $unique = array(array('user_id','cut_id'));
    public function insert($data){
        $data['time'] = time();

//        判断是否已经砍过价
        $cutuser_list = $this->query(array(
            "cut_id = {$data['cut_id']}",
            "user_id = {$data['user_id']}",
        ));
        if ($cutuser_list['count']) {
            throw new ZhyException('您已经帮该好友砍过价了');
        }

        $cut = new cut();
        $cut_data = $cut->get_data_by_id($data['cut_id']);
        if ($cut_data['num'] == $cut_data['cut_num']) {
            throw new ZhyException('您的朋友已经砍到最低价');
        }
        // 砍价，获取随机金额
        function getRandMoney($total,$num){
            if ($num == 1) {
                return $total;
            }
            $cut_money2 = $total - $num * 0.01;

            $cuts = [];
            for ($ddd=0; $ddd < max(1,$num/2); $ddd++) {
                $cuts[] = rand(1,$num);
            }

            // 本次砍价金额
            $cut = round(min($cuts)/$num*rand(1,10000)/10000*$cut_money2,2)+ 0.01;

            return $cut;
        }

        $data['cut_price'] = getRandMoney($cut_data['shop_price'] - $cut_data['cut_price'] - $cut_data['price'], $cut_data['num'] - $cut_data['cut_num']);

        $cut->update_by_id(array(
            'cut_price +='=>$data['cut_price'],
            'cut_num +='=>1,
            ),$data['cut_id']);
        parent::insert($data);
        return $data['cut_price'];
    }
}