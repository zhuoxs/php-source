<?php
class groupuser extends base{
	public $required_fields = array();
	public $unique = array();

    public function cancel($where){
        $group = new group();
        $grouporder = new grouporder();
        $user = new user();

        $w = array();
        foreach ($where as $key => $value) {
            $w[] = "$key=$value";
        }
        $list = $this->query($w)['data'];
        foreach ($list as $item) {
            $grouporder_data = $grouporder->query(array(
                'group_id='.$item['group_id'],
                'user_id='.$item['user_id'],
            ))['data'][0];
            if (!$grouporder_data){
                continue;
            }
            //用户退款
            $pay_data['pay_amount'] = $grouporder_data['pay_amount'];
            $pay_data['pay_type'] = $grouporder_data['pay_type'];
            $pay_data['amount'] = $grouporder_data['amount'];
            $pay_data['type'] = -6;
            $pay_data['user_id'] = $grouporder_data['user_id'];

            $res = $user->back($pay_data);
            if ($res['code']) {
                return $res;
            }
        }
        $group->out($where['group_id'],count($list));
        return $this->update(array('state'=>-1),$where);
    }

    public function insert($data){
        $data['state'] = 0;
        $ret = parent::insert($data);
        if ($ret['code'] == 0){
            $group_id = $data['group_id'];
            $group = new group();
            $ret = $group->join($group_id);
        }
        return $ret;
    }
}