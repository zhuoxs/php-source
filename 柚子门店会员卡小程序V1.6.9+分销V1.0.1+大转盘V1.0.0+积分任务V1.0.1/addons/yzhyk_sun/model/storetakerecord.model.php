<?php
class storetakerecord extends base{
	public $required_fields = array();
	public $unique = array();
//	public $auto_update_time = true;
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
            'table'=>'user',
            'on'=>array(
                'id'=>'user_id',
            ),
            'columns'=>array(
                'name'=>'user_name',
            ),
        ),
    );
    public function insert($data){
        $res = parent::insert($data);
        if ($res['code']) {
            return $res;
        }

        $store_model = new store();
        $store = $store_model->get_data_by_id($data['store_id']);
        $store_model->update_by_id(['balance'=>$store['balance']-$data['balance']],$data['store_id']);

//        判断是否免审
        $system_model = new system();
        $setting = $system_model->get_current();
        if($data['balance']<=$setting['withdraw_noapplymoney']){
            $this->check($res['data']);
        }

        return $res;
    }
    public function check($id){
        $res = $this->update_by_id(['state'=>2],$id);
//        微信为自动打款
        $this->taked($id);
        return $res;
    }
    public function uncheck($id,$reason){
        $data = $this->get_data_by_id($id);

        $store_model = new store();
        $store = $store_model->get_data_by_id($data['store_id']);
        $store_model->update_by_id(['balance'=>$store['balance']+$data['balance']],$data['store_id']);

        return $this->update_by_id(['state'=>-2,'fail_reason'=>$reason],$id);
    }
    public function taked($id){
        $system_model = new system();
        $setting = $system_model->get_current();

        $data = $this->get_data_by_id($id);

        $store_model = new store();
        $store = $store_model->get_data_by_id($data['store_id']);

        require_once __DIR__.'/../wxtake.php';
        $wxTake = new WeixinTake($setting['appid'],$store['openid'],$setting['mchid'],$setting['wxkey'],time(),($data['balance']-$data['paycommission'])*100);
        $ret = $wxTake->take();

        // echo json_encode($ret);exit;
        return $this->update_by_id(['state'=>3],$id);
    }
}