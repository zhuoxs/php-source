<?php
namespace app\admin\controller;

use app\model\Config;
use app\model\Distributionset;
use app\model\Store;
use app\model\Storeopen;
use think\Db;

class Cstore extends Base
{
    public function get_list(){
        global $_W,$_GPC;

        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->where("check_status>1 or end_time>".time())->select();
        foreach ($list as &$item) {
            if ($item['pic']){
                $item['pic'] = $_W['attachurl']. $item['pic'];
            }
        }

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function save(){
        $modelName=input('modelName');
        if(isset($modelName)){

            $name = 'app\\model\\'.$modelName;
            $info =new $name;
        }else{
            $info = $this->model;
        }
        $storeModel= new Store();

        $cats = $storeModel->where('user_id',input("post.user_id"))
            ->where('id',['<>',input("post.id",0)])
            ->select();
        if (count($cats)){
            throw new \ZhyException('已存在该用户的店铺');
        }

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }else{
            $storeModel->check_version();
        }
        $data=input('post.');
        $data['banner'] = json_encode($data['banner']);
        $ret = $info->allowField(true)->save($data);
        if($ret){
            return array(
                'code'=>0,
                'data'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }

    public function setting(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $info['goods_insert_check'] = Config::get_value('goods_insert_check',0);
        $info['goods_update_check'] = Config::get_value('goods_update_check',0);
        $info['entering_switch'] = Config::get_value('entering_switch',0);
        $info['merchants_settled_in'] = Config::get_value('merchants_settled_in','');
      //  $info['mstore_switch'] = Config::get_value('mstore_switch',0);

        $this->view->info = $info;
        return view();
    }
    public function setting_save(){
        $info = new Config();

        $data = input('post.');

        $list = [];

        $list[] = Config::full_id('goods_insert_check',$data['goods_insert_check']);
        $list[] = Config::full_id('goods_update_check',$data['goods_update_check']);
        $list[] = Config::full_id('entering_switch',$data['entering_switch']);
        $list[] = Config::full_id('merchants_settled_in',$data['merchants_settled_in']);
      //  $list[] = Config::full_id('mstore_switch',$data['mstore_switch']);

        $ret = $info->allowField(true)->saveAll($list);

        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }

    public function selectrules(){
        $model = $this->model;
       // $model->where('store_id',$_SESSION['admin']['store_id']);
        $where['is_del']=0;
        $where['check_status']=2;
        $where['end_time']=['egt',time()];
        if ($_SESSION['admin']['store_id'] > 0) {
            $where['id']=$_SESSION['admin']['store_id'];
        }
        $model->where($where)->field("id,name as text");
        $list = $model->select();
        return $list;
    }

    //打回
    public function batchcheckedfail(){
        $ids = input("post.ids");
        $fail_reason = input("post.fail_reason");
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->where('check_status',1)->update(['check_status'=>3,'fail_reason'=>$fail_reason]);
        $ids=explode(',',$ids);
        foreach ($ids as $item){
             $store=Store::get($item);
             $storeopen_id=$store['storeopen_id'];
             $storeopen=Storeopen::get($storeopen_id);
             $addtime=$storeopen['day_num']*24*60*60;
             //减少过期时间
             $model->where(['id'=>$item])->setDec('end_time',$addtime);
            //增加退款记录
            $refund=array(
                'uniacid'=>$storeopen['uniacid'],
                'store_id'=>$storeopen['store_id'],
                'order_id'=>$storeopen['id'],
                'refund_type'=>1,
                'order_refund_no'=>date("YmdHis") .rand(11111, 99999),
                'type'=>2,
                'refund_price'=>$storeopen['price'],
                'create_time'=>time(),
                'refund_status'=>0,
            );
            Db::name('storeopen')->update(array('id'=>$storeopen_id,'refund_apply_status'=>1));
            Db::name('orderrefund')->insert($refund);
            $refund_id=Db::name('orderrefund')->getLastInsID();
            if($storeopen['price']>0){
                $xml=$this->getRefundXml($storeopen,$refund['order_refund_no']);
                $data=xml2array($xml);
                if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
                    Db::name('orderrefund')->update(array('id'=>$refund_id,'refund_status'=>1,'refund_time'=>time(),'xml'=>$xml));
                    Db::name('storeopen')->update(array('id'=>$storeopen_id,'refund_status'=>1,'refund_time'=>time()));
                }else{
                    Db::name('orderrefund')->update(array('id'=>$refund_id,'refund_status'=>2,'err_code'=>$data['err_code'],'err_code_dec'=>$data['err_code_des'],'xml'=>$xml));
                    Db::name('storeopen')->update(array('id'=>$storeopen_id,'refund_status'=>2));
                }
            }else{
                Db::name('orderrefund')->update(array('id'=>$refund_id,'refund_status'=>1,'refund_time'=>time()));
                Db::name('storeopen')->update(array('id'=>$storeopen_id,'refund_status'=>1,'refund_time'=>time()));
            }

        }
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'打回失败',
            );
        }
    }
    //获取微信退款报文信息
    private function getRefundXml($order,$out_refund_no){
        $system=Db::name('system')->where(array('uniacid'=>$order['uniacid']))->find();
        $data['appid'] =$system['appid'];
        $data['mch_id'] =$system['mchid'];
        $data['nonce_str']=createNoncestr();
        $data['out_trade_no']=$order['order_no'];
        $data['out_refund_no']=$out_refund_no;
        $data['total_fee']=intval($order['price']*100);
        $data['refund_fee']=intval($order['price']*100);
        $data['sign']=getSign($data,$system['wxkey']);
        $xml=postXmlCurl($data,$order['uniacid']);
        return $xml;
    }

    //    新增页
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info['map_key']=$this->getMapkey();
        $this->view->info=$info;
        $this->view->distributionset=Distributionset::get_curr();
        $modelName=input('modelName');
        if($modelName){
            $page='add'.$modelName;
            return view($page);
        }else{
            return view('edit');
        }
    }
//    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $modelName=ucwords(strtolower(input('modelName'))); ;
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $id = input('get.id');
        $info = $model->get($id);
        if(isset($info['pics'])){
            $info['pics']=json_decode($info['pics'],true);
        }
        if(isset($info['banner'])){
            $info['banner']=json_decode($info['banner'],true);
        }
        $info['map_key']=$this->getMapkey();
        $this->view->info = $info;
        $this->view->distributionset=Distributionset::get_curr();
        if($modelName){
            $page='add'.strtolower($modelName);
            return view($page);
        }else{
            return view('edit');
        }
    }

}
