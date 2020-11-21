<?php
namespace app\model;

use app\base\model\Base;
use think\Hook;
use think\Db;
use think\Loader;

class Pinorder extends Base
{
    /**
     * 获取购买次数
    */
    public function buyNum($goods_id,$user_id){
        $num=$this->where(['goods_id'=>$goods_id,'user_id'=>$user_id,'is_del'=>0])->count();
        return $num;
    }
    /**
     * 单购/团长支付成功回调
     */
    public function notify($data){
        $attach=json_decode($data['attach'],true);
        $oid=$attach['oid'];
        //修改订单信息
        $orderinfo=$this->get(['id'=>$oid]);
        if($orderinfo['heads_id']>0){
            $log['order_status']=1;
        }else{
            $log['order_status']=2;
        }
        $log['out_trade_no']=$data['out_trade_no'];
        $log['transaction_id']=$data['transaction_id'];
        $log['is_pay']=1;
        $log['pay_type']=1;
        $log['pay_time']=time();
//        $this->where(['id'=>$oid])->update($log);
        $orderinfo->save($log);
        //修改团长信息
        //删除支付任务
        $task=new Task();
        $task->where(['type'=>'pinpay','value'=>$oid])->delete();
        if($orderinfo['is_head']>0){
            $goodsinfo=Pingoods::get(['id'=>$orderinfo['goods_id']]);
            $exper=$goodsinfo['group_time']*60*60+time();
//            $exper= $goodsinfo['group_time']*60+time();
            if($orderinfo['heads_id']>0){
                $head=new Pinheads();
                $head->save(['status'=>1,'expire_time'=>$exper],['id'=>$orderinfo['heads_id']]);
                //添加成团倒计时任务
                $task=array(
                    'uniacid'=>$orderinfo['uniacid'],
                    'type'=>'pinopen',
                    'state'=>0,
                    'level'=>1,
                    'value'=>$oid,
                    'create_time'=>time(),
                    'execute_time'=>$exper-5,
                    'execute_times'=>1
                );
                //新增开团数
                $goodsinfo->setInc('group_num');
                $goodsinfo->setInc('group_xnnum');
                Db::name('task')->insert($task);
//                $this->timingTask(2,$oid);
            }
        }

        echo 'SUCCESS';
    }
    /**
     * 团员支付成功回调
    */
    public function joinNotify($data){
        $attach=json_decode($data['attach'],true);
        $oid=$attach['oid'];
        //修改订单信息
        $log['out_trade_no']=$data['out_trade_no'];
        $log['transaction_id']=$data['transaction_id'];
        $log['order_status']=1;
        $log['is_pay']=1;
        $log['pay_type']=1;
        $log['pay_time']=time();
        $this->where(['id'=>$oid])->update($log);
        //判断人数 ，是否拼团成功
        $heads=new Pinheads();

        $orderinfo=Db::name('pinorder')->where(['id'=>$oid])->find();
        $heads->checkNum($orderinfo['heads_id'],$oid);
//        $heads_id=$orderinfo['heads_id'];
//        $ord=new Pinorder();
//        $nowmun=$ord->allpayNum($heads_id);
//        $headsinfo=self::get($heads_id);
//        $headsinfo=  Db::name('pinheads')->where(['id'=>$heads_id])->find();
//
//        Db::name('baowen')->insert(['xml'=>$nowmun.'ssss'.$headsinfo['groupnum']]);
////        var_dump($nowmun,$headsinfo['groupnum']);exit;
//        if($nowmun==$headsinfo['groupnum']){
//            //删除成团倒计时任务
//            $task=new Task();
//            $task->where(['type'=>'pinopen','value'=>$oid])->delete();
//            Db::name('baowen')->insert(['xml'=>111]);
//            //拼团成功
//            Db::name('pinheads')->where(['id'=>$heads_id])->update(['status'=>2]);
////            $this->save(['status'=>2],['id'=>$heads_id]);
//            //修改订单成团状态
////            $ord->save(['order_status'=>2],['heads_id'=>$heads_id]);
//            Db::name('pinorder')->where(['heads_id'=>$heads_id])->update(['order_status'=>2]);
//        }else{
//            Db::name('baowen')->insert(['xml'=>222]);
//        }

        //删除任务
        $task=new Task();
        $task->where(['type'=>'pinpay','value'=>$oid])->delete();
        echo 'SUCCESS';
    }
    /**
     * 团员列表
    */
    public function grouplist($heads_id){
        global $_W;
        $list=$this->where(['uniacid'=>$_W['uniacid'],'heads_id'=>$heads_id,'is_del'=>0])->order(['is_head'=>'desc','create_time'=>'asc'])->select();
        foreach ($list as $key =>$value){
            $list[$key]['userinfo']=User::get(['id'=>$value['user_id']]);
        }
        return $list;
    }
    /**
     * 获取团员总人数
    */
    public function allNum($heads_id){
        global $_W;
        $num=$this->where(['uniacid'=>$_W['uniacid'],'heads_id'=>$heads_id,'is_del'=>0])->field('id')->count();
        return $num;
    }
    /**
     * 获取已支付团员总人数
     */
    public function allpayNum($heads_id){
        global $_W;
        $num=$this->where(['heads_id'=>$heads_id,'is_del'=>0,'is_pay'=>1])->field('id')->count();
        return $num;
    }
    /**
     * 添加计时任务
    */
    public function timingTask($type,$oid){
        $orderinfo=$this->mfind(['id'=>$oid]);
        //1.支付倒计时
        if($type==1){
            $task=array(
                'uniacid'=>$orderinfo['uniacid'],
                'type'=>'pinpay',
                'state'=>0,
                'level'=>1,
                'value'=>$oid,
                'create_time'=>time(),
                'execute_time'=>$orderinfo['expire_time']-5,
                'execute_times'=>1
            );
        }elseif ($type==2){
            //2.开团倒计时
            $head=new Pinheads();
            $headinfo=$head->mfind(['id'=>$orderinfo['heads_id']]);
            $task=array(
                'uniacid'=>$orderinfo['uniacid'],
                'type'=>'pinopen',
                'state'=>0,
                'level'=>1,
                'value'=>$oid,
                'create_time'=>time(),
                'execute_time'=>$headinfo['expire_time']-5,
                'execute_times'=>1
            );
        }
//        Db::name('task')->insert($task);
        $mod=new Task();
        $mod->allowField(true)->save($task);
    }
    /**
     * 支付过期
    */
    public  function payOverdue($value){
        $oid=intval($value);
        $orderinfo=$this->mfind(['id'=>$oid,'is_del'=>0]);
        if($orderinfo['is_pay']==0){
            //返回库存，销量
            $goods=new Pingoods();
            $goods->updateNum($orderinfo['goods_id'],$orderinfo['num'],$orderinfo['attr_ids']);
            //删除订单
//            $this->save(['is_del'=>1],['id'=>$oid]);
            $pinorder = Pinorder::get($oid);
            $pinorder->save(['is_del'=>1]); 
            return true ;
        }else{
            return true ;
        }
    }
    /**
     * 拼团过期
    */
    public function openOverdue($value){
        $oid=intval($value);
        $heads=new Pinheads();
        $headsinfo=$heads->mfind(['oid'=>$oid]);
        if($headsinfo['status']==1){
            $heads->save(['status'=>3],['id'=>$headsinfo['id']]);
            //退款、返库存、减销量
            $orderinfo=$this->mfind(['id'=>$oid]);
            $pin=new Pingoods();
            $pin->updateNum($orderinfo['goods_id'],$orderinfo['num'],$orderinfo['attr_ids']);
            //减少开团数量
            $pin->where('id',$orderinfo['goods_id'])->setDec('group_num');
            $pin->where('id',$orderinfo['goods_id'])->setDec('group_xnnum');
            //获取所有已支付订单列表
            $paylist=$this->where(['uniacid'=>$orderinfo['uniacid'],'heads_id'=>$orderinfo['heads_id'],'is_del'=>0,'is_pay'=>1])->select();
            foreach ($paylist as $key =>$value){
                $value->is_del=1;
                $value->save();
                $refund=new Pinrefund();
                $refund->refund($value->id);
            }
            return true;
        }else{
            return true;
        }
    }

    public function goods(){
        return $this->hasOne('Pingoods','id','goods_id')->bind(
            [
                'goods_name'=>'name',
                'goods_pic'=>'pic'
            ]
        );
    }
    //核销显示
    public function goods2(){
        return $this->hasOne('Pingoods','id','goods_id')->bind(
            [
                'goods_name'=>'name',
                'pic' => 'pic'
            ]
        );
    }
    //增加钩子，模仿社区团购
    protected static function init(){
        parent::init();
        self::beforeUpdate(function($model){
            if($model->id){
                $pingorder = self::get($model->id);
                //自提收货
                if(($pingorder->order_status==3 && $model->order_status == 5)||($pingorder->order_status==4 && $model->order_status == 5)){
                    Hook::listen('on_pingorder_receive', $model);
                }
                //成团
                if (($pingorder->order_status == 1 && $model->order_status == 2) || ($pingorder->order_status == 0 && $model->order_status == 2)) {
                    Hook::listen('on_pinorder_pay',$model);
                }
                //到货
                if($pingorder->order_status==3 && $model->order_status == 4){
                    Hook::listen('on_leader_receive', $model);
                }
            }
        });
    }
    public function user(){
        return $this->hasOne('User','id','user_id');
    }
    public function goodsinfo(){
        return $this->hasOne('Pingoods','id','goods_id');
    }
    public function leader(){
        return $this->hasOne('Leader','id','leader_id')->bind([
            'leader_name'=>'name',
            'leader_community'=>'community',
            'leader_address'=>'address',
            'leader_user_id'=>'user_id',
            'leader_tel'=>'tel',
            'leader_longitude'=>'longitude',
            'leader_latitude'=>'latitude',
        ]);
    }

    public function userOrder(){
        return $this->hasOne('User','id','user_id')->bind([
            'user_name'=>'name',
            'user_tel'=>'tel',
            'openid',
        ]);
    }

    public function adminPrint($order_ids){
        foreach ($order_ids as $order_id) {
            $content=$this->getOrderPrintContent($order_id,$_SESSION['admin']['store_id']);
            $this->prints($_SESSION['admin']['store_id'],2,$content);
        }
    }

    //获取订单打印内容
    public function getOrderPrintContent($order_id,$store_id)
    {
        $system = System::get_curr();
        $orderinfo = '<CB>' . $system['pt_name'] . '</CB><BR>';
        $orderinfo .= '序号   数量    金额<BR>';
//        $order = Pinorder::get($order_id,['user','leader']);
        $order_detail = Pinorder::with(['userOrder','leader','goods'])->where('id',$order_id)
            ->where('store_id',$store_id)
            ->find();
        $amount = 0;
        $pay_amount = 0;
        $delivery_amount = 0;
//        foreach ($order_detail as $key => $val) {
//        if(in_array($order_detail['order_status'],[1,6])){
//            continue;
//        }
        $orderinfo .= strval(0 + 1) . "      " . $order_detail['num'] . "      " . $order_detail['order_amount'] . '<BR>';
        $orderinfo .= $order_detail['goods_name'] .'<BR>';
        $amount += $order_detail['order_amount'];
        $pay_amount += $order_detail['order_amount'];
        $delivery_amount += $order_detail['distribution'];
//        }
        $orderinfo .= '----------------------------------------------------------------<BR>';
        $orderinfo .= '商品总金额:' . "￥" . $amount . '<BR><BR>';

        $orderinfo .= '用户 姓名:' . $order_detail['user_name'] . '<BR>';
        $orderinfo .= '用户 电话:' . $order_detail['user_tel'] . '<BR><BR>';

        $orderinfo .= '团长 姓名:' . $order_detail['leader_name'] . '<BR>';
        $orderinfo .= '团长 电话:' . $order_detail['leader_tel'] . '<BR>';
        $orderinfo .= '团长 小区:' . $order_detail['leader_community'] . '<BR>';
        $orderinfo .= '团长 地址:' . $order_detail['leader_address'] . '<BR>';

        $orderinfo.= '----------------------------------------------------------------<BR>';

        if ($order_detail['sincetype'] == 1){
            $orderinfo.= '联 系 人:'."".($order_detail['name']).'<BR>';
            $orderinfo.= '联系电话:'."".($order_detail['phone']).'<BR>';
            $orderinfo.= '地   址:'."".($order_detail['province'].$order_detail['city'].$order_detail['area'].$order_detail['address']).'<BR>';
            $orderinfo.= '配 送 费:'."".($delivery_amount).'<BR>';
            $orderinfo.= '----------------------------------------------------------------<BR>';

//            $pay_amount += $delivery_amount;
        }

        $orderinfo.= '<C><L><BOLD>'.'合计:'."".$pay_amount.'</BOLD></L></C><BR>';
        $orderinfo.= '优   惠:'."".($order_detail['coupon_money']).'<BR>';
        $orderinfo.= '订单编号:'."".$order_detail['order_num'].'<BR>';
        $orderinfo.= '下单时间:'."".$order_detail['create_time'].'<BR>';
        return $orderinfo;
    }

    //打印
    public function prints($store_id,$print_type,$content){
        $printset= Printset::get(['store_id'=>0]);

        if($store_id==0){
            if(!$printset['prints_id']){
                return false;
            }
            $prints= Prints::get($printset['prints_id']);
            $type=$printset['print_type'];
        }else if($store_id>0){
            if($printset['print_merch']==0){
                return false;
            }
            $printset_mer=Printset::get(['store_id'=>$store_id]);
            if(!$printset_mer){
                return false;
            }
            if($printset_mer['print_merch']==0){
                return false;
            }
            $prints = Prints::get($printset_mer['prints_id']);
            $type = $printset_mer['print_type'];
        }

        if(strpos($type,strval($print_type))!==false){
            $param=array(
                'user'=>$prints['user'],
                'key'=>$prints['ukey'],
                'sn'=>$prints['sn'],
                'content'=>$content,
                'times'=>1,
            );
            $result=$this->setPrint($param);
            return $result;
        }else{
            return false;
        }
    }
    //打印
    public function setPrint($param){
        Loader::import('httpclient.HttpClient');
        define('USER', $param['user']);	//*必填*：飞鹅云后台注册账号
        define('UKEY', $param['key']);	//*必填*: 飞鹅云注册账号后生成的UKEY
        define('SN', $param['sn']);	    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
        //以下参数不需要修改
        define('IP','api.feieyun.cn');		//接口IP或域名
        define('PORT',80);					//接口IP端口
        define('PATH','/Api/Open/');		//接口路径
        define('STIME', time());			    //公共参数，请求时间
        define('SIG', sha1(USER.UKEY.STIME));   //公共参数，请求公钥
        $content = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printMsg',
            'sn'=>SN,
            'content'=>$param['content'],
            'times'=>$param['times']//打印次数
        );
        $client = new \HttpClient(IP,PORT);
        if(!$client->post(PATH,$content)){
            return 'error';
        }
        else{
            //服务器返回的JSON字符串，建议要当做日志记录起来
            return $client->getContent();
        }
    }
    public function onPinorderPay(&$model){
        $store_ids = Pinorder::where('id',$model->id)
            ->field('store_id')
            ->find();
        $content=$this->getOrderPrintContent($model->id,$store_ids->store_id);
        $this->prints($store_ids->store_id,2,$content);
    }

    public function pinheads(){
        return $this->hasOne("Pinheads",'id',"heads_id")->bind(
            [
                'order_expire_time'=>'expire_time',
                'header_status' => 'status'
            ]
        );
    }

    public function store(){
        return $this->hasOne('Store','id','store_id')->bind([
            'store_name'=>'name'
        ]);
    }

}