<?php
namespace app\admin\controller;

use app\model\Infocomment;
use app\model\Infotoprecord;
use app\model\Infocategory;
use app\model\Info;
use app\model\User;
use think\Db;

class Cinfo extends Base
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
            $query->where('is_del',0);
            $query->where('is_show',1);
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->order('id desc')->select();
        foreach ($list as &$val){
            $user=User::get($val['user_id']);
            $val['nickname']=$user['nickname'];
            $val['topcat_id_z']=Infocategory::get($val['topcat_id'])['name'];
            $val['cat_id_z']=Infocategory::get($val['cat_id'])['name'];
            $val['check_time_z']=$val['check_time']?date('Y-m-d H:i',$val['check_time']):'';
            $val['top_status_z']=$val['top_status']?'已申请':'未申请';
            $val['pay_status_z']=$val['pay_status']?'已支付':'未支付';
            $val['topping_time_z']=$val['topping_time']?date('Y-m-d H:i',$val['topping_time']):'';
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

//数据保存（新增、编辑）
    public function save(){
        $info = $this->model;
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $data=input('post.');
        $data['pic'] = json_encode($data['pic']);
        $ret = $info->allowField(true)->save($data);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }

 //审核通过
    public function batchchecked(){
        $ids = input("post.ids");
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        foreach (explode(',',$ids) as $item){
            $info=Info::get($item);
            if($info['check_status']==1){
                if($info['pay_status']==1){
                    //修改置顶订单状态
                    (new Infotoprecord())->allowField(true)->save(['use_status'=>1,'check_status'=>2,'order_status'=>2,'check_time'=>time()],['id'=>$info['record_id']]);
                    //修改帖子审核、置顶状态
                    $order=Infotoprecord::get($info['record_id']);
                    $topping_time=(new Infotoprecord())->get_topping_time($info['topping_time'],$order['day_num']);
                    $sort_id=(new Infotoprecord())->get_sort_id();
                    $model->allowField(true)->save(['check_status'=>2,'check_time'=>time(),'topping_time'=>$topping_time,'sort_id'=>$sort_id],['id'=>$item]);
                }
            }
        }
        $ret = $model->where('id','in',$ids)->update(['check_status'=>2,'check_time'=>time()]);
     //   if($ret){
            return array(
                'code'=>0,
            );
      /*  }else{
            return array(
                'code'=>1,
                'msg'=>'审核失败',
            );
        }*/
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
        $ids=explode(',',$ids);
        foreach ($ids as $item){
            $info=Info::get($item);
            if($info['check_status']==1){
                if($info['pay_status']==1){
                    //修改订单失败状态
                    (new Infotoprecord())->allowField(true)->save(['use_status'=>1,'check_status'=>3,'order_status'=>3,'check_time'=>time()],['id'=>$info['record_id']]);
                   //修改帖子审核状态
                    $model->allowField(true)->save(['check_status'=>3,'check_time'=>time()],['id'=>$item]);
                    $record=Infotoprecord::get($info['record_id']);
                    if($record['order_amount']>0){
                        $this->refund($record);
                    }
                }
            }
        }
        $ret = $model->where('id','in',$ids)->update(['check_status'=>3,'fail_reason'=>$fail_reason]);
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
    public function refund($record){
        //增加退款记录
        $refund=array(
            'uniacid'=>$record['uniacid'],
            'record_id'=>$record['id'],
            'types'=>1,
            'refund_type'=>1,
            'order_refund_no'=>date("YmdHis") .rand(11111, 99999),
            'type'=>1,
            'refund_price'=>$record['order_amount'],
            'create_time'=>time(),
            'refund_status'=>0,
        );
        Db::name('inforefund')->insert($refund);
        $refund_id=Db::name('inforefund')->getLastInsID();
        if($record['order_amount']>0){
            $xml=$this->getRefundXml($record,$refund['order_refund_no']);
            $data=xml2array($xml);
            if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
                Db::name('inforefund')->update(array('id'=>$refund_id,'refund_status'=>1,'refund_time'=>time(),'xml'=>$xml));
                Db::name('infotoprecord')->update(array('id'=>$record['id'],'refund_status'=>1,'refund_time'=>time()));
            }else{
                Db::name('inforefund')->update(array('id'=>$refund_id,'refund_status'=>2,'err_code'=>$data['err_code'],'err_code_dec'=>$data['err_code_des'],'xml'=>$xml));
                Db::name('infotoprecord')->update(array('id'=>$record['id'],'refund_status'=>2));
            }
        }else{
            Db::name('inforefund')->update(array('id'=>$refund_id,'refund_status'=>1,'refund_time'=>time()));
            Db::name('infotoprecord')->update(array('id'=>$record['id'],'refund_status'=>1,'refund_time'=>time()));
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
        $data['total_fee']=intval($order['order_amount']*100);
        $data['refund_fee']=intval($order['order_amount']*100);
        $data['sign']=getSign($data,$system['wxkey']);
        $xml=postXmlCurl($data,$order['uniacid']);
        return $xml;
    }

    //新增页
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info['map_key']=$this->getMapkey();
        $this->view->info=$info;
        $modelName=input('modelName');
        if($modelName){
            $page='add'.$modelName;
            return view($page);
        }else{
            return view('edit');
        }
    }
    //编辑页
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
        $info['cat_name']=Infocategory::get($info['topcat_id'])['name'].'-'.Infocategory::get($info['cat_id'])['name'];
        if($info['check_status']==1){
            $info['check_status_z']='未审核';
        }else if($info['check_status']==2){
            $info['check_status_z']='审核通过';
        }else if($info['check_status']==3){
            $info['check_status_z']='审核失败';
        }
        $info['check_time_z']=$info['check_time']?date('Y-m-d H:i',$info['check_time']):'';
        $info['top_status_z']=$info['top_status']?'已申请':'未申请';
        $info['pay_status_z']=$info['pay_status']?'已支付':'未支付';
        $info['topping_time_z']=$info['topping_time']?date('Y-m-d H:i',$info['topping_time']):'';
        $info['pic'] = json_decode($info['pic']);
        $this->view->info = $info;
        if($modelName){
            $page='add'.strtolower($modelName);
            return view($page);
        }else{
            return view('edit');
        }
    }


    public function delete($is_del=0){
        $ids = input('post.ids');
        $model = $this->model;
        $ret = $model->where('id','in',$ids)->update(['is_del'=>1]);
        //删除帖子对于评论
        (new Infocomment())->where('info_id','in',$ids)->update(['is_del'=>1]);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$ret,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败',
            );
        }
    }

}
