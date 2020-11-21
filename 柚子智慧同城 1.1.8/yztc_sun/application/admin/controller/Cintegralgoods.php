<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 16:09
 */
namespace app\admin\controller;


use app\model\Integralcategory;
use app\model\Integralgoods;
use app\model\Integralorder;
use app\model\Integralrecord;
use app\model\Postagerules;
use app\model\Shop;

class Cintegralgoods extends Base{
    /**
     * 积分商品列表
     */
    public function goodslist(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('goodslist');
    }
    public function get_goods_list(){
        global $_W;
        $model =new Integralgoods();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=1;
        //关键字搜索
        $key = input('get.key');
        if ($key){
            $where['name']=['like',"%$key%"];
        }
        $cat_id = input('get.cat_id');
        if ($cat_id){
            $where['cat_id']=$cat_id;
        }
        $order['create_time']='desc';
        $list = $model->where($where)->order($order)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 所有分类
     */
    public function allcategory(){
        $model = new Integralcategory();
        $model->field("id,name as text");
        $list = $model->where('state',1)->select();
        return $list;
    }
    /**
     * 所有商品
     */
    public function allgoods(){
        $model = new Integralgoods();
        $model->field("id,name as text");
        $list = $model->where('is_del',1)->select();
        return $list;
    }
    /**
     * 运费模板
     */
    public function postagerules(){
        $model = new Postagerules();
        $model->field("id,name as text");
        $list = $model->where('state',1)->select();
        return $list;
    }
    /**
     * 新增、编辑积分商品
     */
    //    新增页
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $pmodel = new Postagerules();
        $pmodel->field("id,name");
        $plist = $pmodel->where('state',1)->select();
        $this->view->plist=$plist;
        return view('edit');
    }
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model =new Integralgoods();
        $id=input('get.id');
        $pmodel = new Postagerules();
        $pmodel->field("id,name");
        $plist = $pmodel->where('state',1)->select();
//        var_dump($plist);exit;
        $this->view->plist=$plist;
        if($id){
            $info =$model->get_info($id);
            $info['pics'] = json_decode($info['pics']);
            $this->view->info=$info;

        }
        return view('edit');
    }
    public function save(){
        global $_W;
        $info=new Integralgoods();
        $id = input('post.id');
        if ($id){
            $info = $info->get_info($id);
        }
        $data = input('post.');
        $data['pics']=input('post.pics/a');
        $data['pics'] = json_encode($data['pics']);
        $data['uniacid'] = $_W['uniacid'];
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
    /**
     * 删除
     */
    public function deletegoods(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['is_del'=>0]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败',
            );
        }
    }

    /**
     * 订单列表
     */
    public function orderlist(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('orderlist');
    }
    public function get_order_list(){
        global $_W;
        $model =new Integralorder();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
//        $where['goods_id']=input('get.id');
        //关键字搜索
        $key = input('get.key');
        if ($key){
            $where['out_trade_no']=['like',"%$key%"];
        }
        $goods_id = input('get.goods_id');
        if ($goods_id){
            $where['goods_id']=$goods_id;
        }
        $type=input('get.type');
        if($type>0){
            $where['order_status']=$type-0-1;
        }
        $order['id']='desc';
//        var_dump($where);exit;
        $list = $model->where($where)->order($order)->select();
        foreach ($list as $key =>$value){
            $list[$key]['dh_time']=date('Y-m-d H:i:s',$value['dh_time']);
            $goods=new Integralgoods();
            $list[$key]['gname']=$goods->mfind(['id'=>$value['goods_id']],'name')['name'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 查看订单详情
    */
    public function see(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model =new Integralorder();
        $id=input('get.id');
        if($id){
            $info =$model->get_orderinfo($id);
            $info['username'] = \app\model\User::get(['id'=>$info['user_id']])['name'];
            $info['gname'] = Integralgoods::get(['id'=>$info['goods_id']])['name'];
            $info['dh_time'] = date('Y-m-d H:i:s',$info['dh_time']);
            $info['pay_status'] =$info['pay_status']?'已支付':'未支付';
            $info['pay_time'] = $info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
            $info['fahuo_time'] = $info['fahuo_time']?date('Y-m-d H:i:s',$info['fahuo_time']):'';
            $info['queren_time'] = $info['queren_time']?date('Y-m-d H:i:s',$info['queren_time']):'';
            $info['address']=$info['province'].$info['city'].$info['area'].$info['address'];
            $info['mdaddress']=Shop::get(['id'=>$info['store_id']])['name'];
            $this->view->info=$info;

        }
        return view('see');
    }
    /**
     * 发货
    */
    public function send(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model =new Integralorder();
        $id=input('get.id');
        if($id){
            $info =$model->get_orderinfo($id);
            $info['username'] = \app\model\User::get(['id'=>$info['user_id']])['name'];
            $info['gname'] = Integralgoods::get(['id'=>$info['goods_id']])['name'];
            $info['dh_time'] = date('Y-m-d H:i:s',$info['dh_time']);
            $info['pay_status'] =$info['pay_status']?'已支付':'未支付';
            $info['pay_time'] = $info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
            $info['fahuo_time'] = $info['fahuo_time']?date('Y-m-d H:i:s',$info['fahuo_time']):'';

            $this->view->info=$info;

        }
        return view('send');
    }
    public function savesend(){
        $oid=input('post.id');
        if($oid){
            $order=new Integralorder();
            $orderinfo=$order->get_orderinfo($oid);
            if($orderinfo['order_status']==1){
                if($orderinfo['sincetype']==1){
                    $data['express_delivery']=input('post.express_delivery');
                    $data['express_orderformid']=input('post.express_orderformid');
                    $data['order_status']=2;
                }else{
                    $data['order_status']=3;
                    $data['queren_time']=time();
                }
                $data['fahuo_time']=time();
                $res=$order->allowField(true)->save($data,['id'=>$oid]);
                if($res){
                    return array(
                        'code'=>0,
                    );
                }else{
                    return array(
                        'code'=>1,
                        'msg'=>'失败',
                    );
                }
            }else{
                return array(
                    'code'=>1,
                    'msg'=>'订单还未付款',
                );
            }

        }
    }
}