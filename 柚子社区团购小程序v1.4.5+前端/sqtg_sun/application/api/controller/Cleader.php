<?php
namespace app\api\controller;
use app\base\controller\Api;
use app\model\Ad;
use app\model\Deliveryordergoods;
use app\model\Goods;
use app\model\Pingoods;
use app\model\Leader;
use app\model\Leaderbill;
use app\model\Leadergoods;
use app\model\Leaderpingoods;
use app\model\Leaderuser;
use app\model\Leaderwithdraw;
use app\model\Order;
use app\model\Ordergoods;
use app\model\Pinorder;
use app\model\Store;
use app\model\Storeleader;
use app\model\User;
use app\model\Usercode;
use app\model\Config;
use app\model\Pluginkey;
use \think\Db;
use think\Exception;
use think\Log;

class Cleader extends Api
{
//    获取附近团长列表
//    传入：
//          longitude:经度
//          latitude:纬度
//          page:第几页
//          limit:每页数据量
//          key:搜索关键字
    public function getNearLeaders(){
        global $_W;
        $key = input('request.key','');
        $longitude = input('request.longitude',0);
        $latitude = input('request.latitude',0);
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        $start = ($page-1)*$limit;
//        所有需要返回的分类id
        $list = Db::query("
            select t1.id,t1.name,t1.address,t2.img as pic,t1.community,t1.tel,t2.openid,t1.workday
            ,convert(acos(cos($latitude*pi()/180 )*cos(t1.latitude*pi()/180)*cos($longitude*pi()/180 -t1.longitude*pi()/180)+sin($latitude*pi()/180 )*sin(t1.latitude*pi()/180))*6370996.81,decimal)  as distance 
            from ".tablename('sqtg_sun_leader')." t1
            left join ".tablename('sqtg_sun_user')." t2 on t2.id = t1.user_id
            where t1.check_state = 2
            and t1.uniacid = {$_W['uniacid']}
            and (t1.name like '%$key%' or t1.community like '%$key%')
            order by distance
            limit $start,$limit
        ");

        $weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
        $week = $weekarray[date("w")];
        foreach ($list as &$item) {
//            隐藏手机部分信息
            $item['tel'] = substr($item['tel'],0,2).'******'.substr($item['tel'],8);

//            判断团长是否 working
            $item['is_work'] = false;
            if (in_array($week,explode(',',$item['workday']))){
                $item['is_work'] = true;
            }

            //判断团长是否有在售商品
            $query = function ($query) use($item){
                $store_ids = Storeleader::where('leader_id',$item['id'])->column('store_id');
                if (!count($store_ids)){
                    $query->where('1=2');
                    return;
                }

                $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch',0);
                if (!$leader_choosegoods_switch){
                    $query->whereIn('store_id',$store_ids);
                }else{
                    $query->where(function ($q)use($item,$store_ids){
                        $goods_ids = Leadergoods::where('leader_id',$item['id'])
                            ->whereIn('store_id',$store_ids)
                            ->column('goods_id');
                        if (!count($goods_ids)){
                            $q->where('1=2');
                        }else{
                            $q->whereIn('id',$goods_ids);
                        }
                        $q->whereOr('mandatory',1);
                    });

                }

                $query->where('state',1);
                $query->where('check_state = 2 or store_id = 0');

                $t = time();
                $query->where("begin_time <= $t and end_time >= $t");
            };

//        查询数据
            $num = Goods::where($query)->count();
            $item['has_goods'] = $num>0;
        }

        success_json($list);
    }
//    获取团长信息
//    传入：
//          longitude:经度
//          latitude:纬度
//          leader_id
    public function getLeader(){
        $longitude = input('request.longitude',0);
        $latitude = input('request.latitude',0);
        $leader_id = input('request.leader_id',0);

//        所有需要返回的分类id
        $list = Db::query("
            select t1.id,t1.name,t1.address,t2.img as pic,t1.community,t1.tel
            ,convert(acos(cos($latitude*pi()/180 )*cos(t1.latitude*pi()/180)*cos($longitude*pi()/180 -t1.longitude*pi()/180)+sin($latitude*pi()/180 )*sin(t1.latitude*pi()/180))*6370996.81,decimal)  as distance 
            from ".tablename('sqtg_sun_leader')." t1
            left join ".tablename('sqtg_sun_user')." t2 on t2.id = t1.user_id
            where t1.id = {$leader_id}
            order by distance
        ");
        success_json($list[0]);
    }

//    团长申请
    public function applyLeader(){
        global $_W;
        $data = input('request.');
        $data['check_state'] = 1;
        $data['fail_reason'] = '';

        $id = input('request.id');
        $leader_model = $id?Leader::get($id):new Leader();

        $ret = $leader_model->allowField(true)->save($data);

        if ($ret){
            success_json([
                'code'=>0,
                'data'=>$leader_model,
            ]);
        }else{
            error_json('保存失败，请重新提交申请');
        }

    }

//    获取我的团长信息
    public function getMyLeader(){
        $user_id = input('request.user_id');
        $data = Leader::get(['user_id'=>$user_id],'User');
        if ($data){
            $data['is_leader'] = 1;
        }else{
            $leader = Leaderuser::get(['user_id'=>$user_id]);
            $data = Leader::get($leader->leader_id,'User');
        }

        if ($data && $data['check_state'] == 2){
            $time1 = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
            $time2 = strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
            $data['today_sum'] = Leaderbill::where('leader_id',$data['id'])
                ->where('create_time',['>=',$time1])
                ->sum('money');
            $data['today_count'] = Order::where('leader_id',$data['id'])
                ->whereNotIn('state',[1,6])
                ->where('pay_time',['>=',$time1])
                ->count();
            $data['yesterday_sum'] = Leaderbill::where('leader_id',$data['id'])
                ->where('create_time',[['>=',$time2],['<',$time1]])
                ->sum('money');
            $data['yesterday_count'] = Order::where('leader_id',$data['id'])
                ->whereNotIn('state',[1,6])
                ->where('pay_time',[['>=',$time2],['<',$time1]])
                ->count();
            $data['total_sum'] = Leaderbill::where('leader_id',$data['id'])
//                ->where('create_time',['>=',$time1])
                ->sum('money');
            $data['total_count'] = Order::where('leader_id',$data['id'])
                ->whereNotIn('state',[1,6])
//                ->where('pay_time',['>=',$time2])
//                ->where('pay_time',['<',$time1])
                ->count();
            $data['withdraw_switch'] = Config::get_value('leader_withdraw_switch',0);

            $data['order_count']=[
                'state2' => Ordergoods::where('leader_id',$data->id)
                    ->where('state',2)
                    ->where('check_state <> 1')
                    ->count('distinct goods_id,batch_no'),
                'state3' => Ordergoods::where('leader_id',$data->id)
                    ->where('state',3)
                    ->where('check_state <> 1')
                    ->count('distinct goods_id,batch_no'),
                'state4' => Ordergoods::where('leader_id',$data->id)
                    ->where('state',4)
                    ->where('check_state <> 1')
                    ->count('distinct goods_id,batch_no'),
                'state5' => Ordergoods::where('leader_id',$data->id)
                    ->where('state',5)
                    ->count('distinct goods_id,batch_no'),
            ];

            $store_ids = Storeleader::where('leader_id',$data->id)->column('store_id');
            if (!count($store_ids)){
                $data['goodses'] = [
                    'count' => 0
                ];
            }else{
                $goods_ids = Goods::where('check_state',2)
                    ->where('state',1)
                    ->where('end_time','>',time())
                    ->where('begin_time','<=',time())
                    ->whereIn('store_id',$store_ids)
                    ->column('id');

//                $pingoods_ids = Pingoods::where('check_state',2)
//                    ->where('state',1)
//                    ->where('end_time','>',time())
//                    ->where('start_time','<=',time())
//                    ->whereIn('store_id',$store_ids)
//                    ->column('id');
                //
                $count = Goods::where('mandatory',1)
                    ->where('state', 1)
                    ->where('end_time', '>', time())
                    ->where('begin_time','<=',time())
                    ->count();
//                $pinCount = Pingoods::where('mandatory',1)
//                    ->where('state', 1)
//                    ->where('end_time', '>', time())
//                    ->where('start_time','<=',time())
//                    ->count();
                $mandatory_ids = Goods::where('mandatory',1)
                    ->where('state', 1)
                    ->where('end_time', '>', time())
                    ->where('begin_time','<=',time())
                    ->column('id');
                $data['goodses'] = [
                    'count' => Leadergoods::where('leader_id',$data->id)
                            ->whereIn('goods_id', $goods_ids)
                            ->whereNotIn('goods_id', $mandatory_ids)
                            ->count() + $count,
                    //拼团商品
//                    'pinCount'=>Leaderpingoods::where('leader_id',$data->id)
//                        ->whereIn('goods_id', $pingoods_ids)
//                        ->whereNotIn('goods_id', $mandatory_ids)
//                        ->count(),
//                    'sql'=>Leadergoods::getLastSql()
                    ];
            }

            $data['users'] = [
                'count' => Leaderuser::where('leader_id',$data->id)->count(),
            ];

            $data['choosegoods_switch'] = Config::get_value('leader_choosegoods_switch',0);
            if($data['choosegoods_switch'] == 0){
                $store_ids = Storeleader::where('leader_id',$data->id)->column('store_id');
                $goods_count = Goods::where('check_state', 2)
                    ->where('state', 1)
                    ->where('end_time', '>', time())
                    ->where('begin_time','<=',time())
//                    ->whereIn('store_id', $store_ids)
//                    ->whereOr('mandatory',1)
                    ->where(function($q)use($store_ids){
                        $q->whereIn('store_id', $store_ids)->whereOr('mandatory',1);
                    })
                    ->with('store')
                    ->page(input('request.page', 1))
                    ->limit(input('request.limit', 10))
                    ->count();
/*                $pingoods_count = Pingoods::where('check_state', 2)
                    ->where('state', 1)
                    ->where('end_time', '>', time())
                    ->where('start_time','<=',time())
//                    ->whereIn('store_id', $store_ids)
//                    ->whereOr('mandatory',1)
                    ->where(function($q)use($store_ids){
                        $q->whereIn('store_id', $store_ids)->whereOr('mandatory',1);
                    })
                    ->with('store')
                    ->page(input('request.page', 1))
                    ->limit(input('request.limit', 10))
                    ->count();*/
                $data['goodses'] = [
                    'count' =>$goods_count,
//                    'pinCount'=>$pingoods_count
                ];
            }

        }

        $detail = Config::get_value('leader_apply_detail');
        //        轮播图
        $swipers = Ad::where('state',1)
            ->where('type',8)
            ->select();

        $bgm = Config::get_value('leader_apply_bgm');

        success_withimg_json($data,['apply_detail'=>$detail,'apply_bgm'=>$bgm,'swipers'=>$swipers]);
    }
//    获取订单状态列表
    public function getOrderStates(){
        $data = [
            [
                'state'=>2,
                'text'=>'待配送',
            ],
            [
                'state'=>3,
                'text'=>'配送中',
            ],
            [
                'state'=>4,
                'text'=>'待自提',
            ],
            [
                'state'=>5,
                'text'=>'已完成',
            ],
        ];
        success_json($data);
    }
//    获取订单列表
    public function getOrders(){
        $where = [];
        $where['leader_id'] = input('request.leader_id',0);
        $state = input('request.state',0);
        if ($state){
            $where['state'] = $state;
//            if ($state == 4){
//                $where['check_state'] = ['<>',1];
//            }
        }

        $where['check_state'] = ['<>',1];

//        Db::query('set sql_mode = 0;');
        $sqlmode = Db::query("select @@global.sql_mode;");
//        print_r($sqlmode);
        if(strpos($sqlmode["@@global.sql_mode"],'ONLY_FULL_GROUP_BY') !== false){
            Db::query("set @@global.sql_mode=(select replace(@@global.sql_mode,'ONLY_FULL_GROUP_BY','')); ");
        }

        $list = Ordergoods::where($where)
//            ->where('state',['<>',-10])
//            ->group('goods_id,batch_no')
            ->page(input('request.page',1))
            ->limit(input('request.limit',10))
            ->order('create_time desc,id')
            ->field('goods_id,batch_no,delivery_type')
            ->distinct('goods_id,batch_no,delivery_type')
            ->select();

        foreach ($list as &$item) {
            $ordergoodses = Ordergoods::where('goods_id',$item['goods_id'])
                ->where('batch_no',$item['batch_no'])
                ->where('delivery_type',$item['delivery_type'])
                ->where($where)
                ->select();

//            $item = Goods::get($item['goods_id']);
            $item = $ordergoodses[0];
            $item['name'] = $item['goods_name'];
            $item['id'] = $item['goods_id'];

            $users = [];
            $attrs = [];
            $sum = 0;
            foreach ($ordergoodses as $ordergoods) {
                if(!in_array($ordergoods['user_id'],$users)){
                    $users[] = $ordergoods['user_id'];
                }
                $sum += $ordergoods['num'];
                if(!in_array($ordergoods['attr_ids'],array_keys($attrs))){
                    $attrs[$ordergoods['attr_ids']]=[
                        'attr_names'=>$ordergoods['attr_names']?:'无',
                        'num'=>$ordergoods['num'],
                    ];
                }else{
                    $attrs[$ordergoods['attr_ids']]['num'] += $ordergoods['num'];
                }
            }

            $item['userCount'] = count($users);
            $item['goodsSum'] = $sum;
            $item['attrs'] = $attrs;
            $item['state'] = $state;
        }

        success_withimg_json($list ?: []);
    }
//    获取团员列表
    public function getOrder(){
        $where = [];
        $where['leader_id'] = input('request.leader_id',0);
        $state = input('request.state',0);
        if ($state){
            $where['state'] = $state;
        }
        $where['check_state'] = ['<>',1];
        $goods_id = input('request.goods_id',0);
        if ($goods_id){
            $where['goods_id'] = $goods_id;
        }
        $batch_no = input('request.batch_no','');
        if ($batch_no){
            $where['batch_no'] = $batch_no;
        }
        $delivery_type = input('request.delivery_type',1);
        if ($delivery_type){
            $where['delivery_type'] = $delivery_type;
        }

//        查询数据
//        $goods = Goods::get($goods_id);

        $ordergoodses = Ordergoods::where('')
            ->where($where)
            ->select();

        $goods = json_decode(json_encode($ordergoodses[0]),1);
        $goods['name'] = $goods['goods_name'];
        $goods['id'] = $goods['goods_id'];

        $users = [];
        $attrs = [];
        $sum = 0;
        foreach ($ordergoodses as $ordergoods) {
            if(!in_array($ordergoods['user_id'],array_keys($users))){
                $user = User::get($ordergoods['user_id']);
                $users[$ordergoods['user_id']] = [
                    'user'=>$user,
                    'num'=>$ordergoods['num'],
                    'ordergoods_ids'=>$ordergoods['id'],
                ];
            }else{
                $users[$ordergoods['user_id']]['num'] += $ordergoods['num'];
                $users[$ordergoods['user_id']]['ordergoods_ids'] .= ','.$ordergoods['id'];
            }
            $sum += $ordergoods['num'];
            if(!in_array($ordergoods['attr_ids'],array_keys($attrs))){
                $attrs[$ordergoods['attr_ids']]=[
                    'attr_names'=>$ordergoods['attr_names'],
                    'num'=>$ordergoods['num'],
                ];
            }else{
                $attrs[$ordergoods['attr_ids']]['num'] += $ordergoods['num'];
            }
        }

        $goods['userCount'] = count($users);
        $goods['goodsSum'] = $sum;
        $goods['attrs'] = $attrs;
        $goods['state'] = $state;
        $goods['users'] = $users;
        success_withimg_json($goods);
    }
//    确认商家配送
    public function receiveGoodses(){
        $data = input('request.');

        $leader_id = $data['leader_id'];
        $goodses = $data['goodses'];
        $goodses = json_decode($goodses,true);

        foreach ($goodses as $goods) {
            $where = [
                'goods_id'=>$goods['goods_id'],
                'state'=>3,
            ];
            if ($goods['attr_ids']){
                $where['attr_ids'] = $goods['attr_ids'];
            }
//            更新用户订单商品状态
            $num = $goods['num'];
            $list = Ordergoods::where('leader_id',$leader_id)
                ->where($where)
                ->limit($num)
                ->order('create_time')
                ->select();


            foreach ($list as $item) {
                if ($item->num > $num){
                    continue;
                }
                $item->state = 4;
                $item->save();
                $num -= $item->num;
            }

//            更新商家配送单商品状态
/*            $delivery_num = $goods['num'];
            $where = [
                'goods_id'=>$goods['goods_id'],
            ];
            if ($goods['attr_ids']){
                $where['attr_ids'] = $goods['attr_ids'];
            }

            $list = Deliveryordergoods::where('leader_id',$leader_id)
                ->where($where)
                ->where('num > receive_num')
                ->limit($delivery_num)
                ->order('create_time')
                ->select();

            foreach ($list as $item) {
                if (!$delivery_num){
                    continue;
                }
                $n = $item->num - $item->receive_num;
                $min_num = min($n,$delivery_num);

                $item->receive_num += $min_num;
                $item->save();

                $delivery_num -= $min_num;
            }*/
        }

        success_json();
    }

    //    获取拼团团员列表
    public function getPinorders(){
        $query=function($query){
            $leader_id = input('post.leader_id');
            $order_status = input('post.state');
            $query->where('leader_id',$leader_id);
            $query->where('order_status',$order_status);
            $query->where('is_del',0);
        };
        $list = Pinorder::with('goods')
            ->where($query)
            ->page(input('request.page',1))
            ->limit(input('request.limit',10))
            ->select();
        success_withimg_json($list,['sql'=>Pinorder::getLastSql()]);
    }
//    确认拼团商家配送
    public function receivePingoodses(){
        $data = input('request.');

        $leader_id = $data['leader_id'];
        $id = $data['pinorder_id'];
        $pinOrders = Pinorder::where('id','in',$id)
            ->where('leader_id',$leader_id)
//            ->where('order_status',3)
            ->where(function($query){
                $query->where('order_status',3);
                $query->whereOr('order_status',4);
            })
            ->select();
        if(!$pinOrders){
            error_json('订单不存在');
        }
        foreach($pinOrders as $pinOrder){
            if($pinOrder->order_status == 3){
                $pinOrder->order_status = 4;
            }else if($pinOrder->order_status == 4){
                $pinOrder->order_status = 5;
            }
            $pinOrder->save();
        }
        success_json();
    }

//    获取用户商品列表(核销)
    public function getUserGoodses(){
        $code = input('request.code'); //有可能是用户id
        $leader_id = input('request.leader_id');
        $type = input('request.type',3);


//        $user = User::get($code);
        if(is_numeric($code)){
            $user = User::get($code);
        }else{
            $user = false;
        }
        if ($user){
            $user_id = $user['id'];
        }else{
            $usercode = Usercode::get(['code'=>$code,'end_time'=>['>=',time()]]);
            if (!$usercode){
                error_json('核销码过期，请提示用户刷新核销码');
            }
            $user_id = $usercode['user_id'];
        }


        $list = Ordergoods::where('leader_id',$leader_id)
            ->with('order')
            ->where('user_id',$user_id)
            ->where('state = 4 and check_state in (0,3)')
            ->select();
        $pinList = Pinorder::where('leader_id',$leader_id)
            ->with('goods2')
            ->where('user_id',$user_id)
            ->where('order_status',4)
            ->field('*,user_id,name as user_name,phone as tel,goods_id,order_num as order_no,order_amount as price')
            ->select();
        if($type==3){
            foreach($pinList as $pin){
                $list[]=$pin;
            }
        }else if($type==0){
//            foreach($pinList as $pin){
//                $list[]=$pin;
//            }
        }else if($type==1){
            $list = $pinList;
        }
        success_withimg_json($list);
    }

    //    获取用户商品列表(配送中)
    public function getSendingUserGoodses(){
        $code = input('request.code'); //有可能是用户id
        $leader_id = input('request.leader_id');
        $type = input('request.type',3);

        $user = User::get($code);
        if ($user){
            $user_id = $user['id'];
        }else{
            $usercode = Usercode::get(['code'=>$code,'end_time'=>['>=',time()]]);
            if (!$usercode){
                error_json('核销码过期，请提示用户刷新核销码');
            }
            $user_id = $usercode['user_id'];
        }


        $list = Ordergoods::where('leader_id',$leader_id)
            ->with('order')
            ->where('user_id',$user_id)
            ->where('state = 3 and check_state in (0,3)')
            ->select();
        $pinList = Pinorder::where('leader_id',$leader_id)
            ->with('goods2')
            ->where('user_id',$user_id)
            ->where('order_status',3)
            ->field('*,user_id,name as user_name,phone as tel,goods_id,order_num as order_no,order_amount as price')
            ->select();
        if($type==3){
            foreach($pinList as $pin){
                $list[]=$pin;
            }
        }else if($type==0){
//            foreach($pinList as $pin){
//                $list[]=$pin;
//            }
        }else if($type==1){
            $list = $pinList;
        }

        success_withimg_json($list);
    }
//    确认用户提取商品(核销)
    public function confirmUserGoodses(){
        $leader_id = input('request.leader_id');
        $ids = input('request.ids');
        $list = Ordergoods::where('id',['in',$ids])
            ->where("state = 4 or (state = 3 and delivery_type = 2)")
            ->whereIn('check_state',[0,3])
            ->where('leader_id',$leader_id)
            ->select();
        if(true){
            $pinList = Pinorder::where('id',['in',$ids])
                ->where("order_status = 4 or (order_status = 3 and sincetype = 1)")
                ->where('leader_id',$leader_id)
                ->select();
        }
        foreach($pinList as $pin){
            $list[] = $pin;
        }
        if (!count($list)){
            error_json('没找到可确认收货订单');
        }
        foreach ($list as $item) {

            if(!isset($item->order_status)){

                $item->state = 5;
            }else{
                $item->order_status = 5;
            }
            $item->save();
        }
        success_json();
    }

//    获取我的团长提现信息、平台提现设置
//    传入
//        user_id: 用户id
    public function getWithdrawInfo(){
        $user_id = input('request.user_id');
        $data = [];

        $leader = Leader::get(['user_id'=>$user_id]);

//        提现设置
        $data['withdraw_min'] = Config::get_value('leader_withdraw_min',0);

        $data['withdraw_type'] = Config::get_value('leader_withdraw_type','1');
        $data['withdraw_type'] = explode(',',$data['withdraw_type']);

        $data['withdraw_wechatrate'] = Config::get_value('leader_withdraw_wechatrate',0);
        $data['withdraw_alipayrate'] = Config::get_value('leader_withdraw_alipayrate',0);
        $data['withdraw_bankrate'] = Config::get_value('leader_withdraw_bankrate',0);
        $data['withdraw_platformrate'] = Config::get_value('leader_withdraw_platformrate',0);
        $data['money'] = $leader['money'];

        success_withimg_json($data);
    }

//    申请提现
    public function addWithdraw(){
        $data = input("request.");

        $leader = Leader::get(['user_id'=>$data['user_id']]);

        if ($leader['money']<$data['money']){
            error_json('您的可提现金额不足，请核对后重新提交');
        }

        $data['leader_id'] = $leader->id;
        $withdraw_model = new Leaderwithdraw();
        $ret = $withdraw_model->allowField(true)->save($data);

        if ($ret){
            success_json($withdraw_model['id']);
        }else{
            error_json('提交失败');
        }
    }
//    获取团长商品列表
//    传入
//        leader_id: 团长id
//        state: 状态、1在售、2可选 3全部
    public function getGoodses(){
        $leader_id = input('request.leader_id',0);

        $state = input('request.state',1);
        $list = [];

        $store_ids = Storeleader::where('leader_id',$leader_id)->column('store_id');
        if (count($store_ids)){
            if ($state == 1){
                $goods_ids = Leadergoods::where('leader_id',$leader_id)->column('goods_id');

                $list = Goods::where('check_state',2)
                    ->where('state',1)
                    ->where('end_time','>',time())
                    ->where('begin_time','<=',time())
                    ->whereIn('store_id',$store_ids)
//                    ->whereIn('id',$goods_ids)
//                    ->whereOr('mandatory',1)
                    ->where(function($query)use($goods_ids){
                        $query->whereIn('id',$goods_ids)->whereOr('mandatory',1);
                    })
                    ->with('store')
                    ->page(input('request.page',1))
                    ->limit(input('request.limit',10))
                    ->select();

                $leader_draw_type = Config::get_value('leader_draw_type',1);
                $leader_draw_rate = Config::get_value('leader_draw_rate',0);
                $leader_draw_money = Config::get_value('leader_draw_money',0);

                foreach ($list as &$item) {
                    $rate = 0;
                    $money = 0;

                    if ($item->leader_draw_type == 1){
                        $rate = $item->leader_draw_rate;
                    }elseif ($item->leader_draw_type == 2){
                        $money = $item->leader_draw_money;
                    }elseif ($item->store_leader_draw_type == 1){
                        $rate = $item->store_leader_draw_rate;
                    }elseif ($item->store_leader_draw_type == 2){
                        $money = $item->store_leader_draw_money;
                    }elseif ($leader_draw_type == 1){
                        $rate = $leader_draw_rate;
                    }elseif ($leader_draw_type == 2){
                        $money = $leader_draw_money;
                    }

                    $item->leader_money = sprintf("%.2f",$item->price*$rate/100 + $money);
                }
            }elseif($state==0){
                $goods_ids = Leadergoods::where('leader_id',$leader_id)->column('goods_id');

                $list = Goods::where('check_state',2)
                    ->where('state',1)
                    ->where('end_time','>',time())
                    ->where('begin_time','<=',time())
                    ->whereIn('store_id',$store_ids)
                    ->whereNotIn('id',$goods_ids)
                    ->where('mandatory',0)
                    ->with('store')
                    ->page(input('request.page',1))
                    ->limit(input('request.limit',10))
                    ->select();

                $leader_draw_type = Config::get_value('leader_draw_type',1);
                $leader_draw_rate = Config::get_value('leader_draw_rate',0);
                $leader_draw_money = Config::get_value('leader_draw_money',0);

                foreach ($list as &$item) {
                    $rate = 0;
                    $money = 0;

                    if ($item->leader_draw_type == 1){
                        $rate = $item->leader_draw_rate;
                    }elseif ($item->leader_draw_type == 2){
                        $money = $item->leader_draw_money;
                    }elseif ($item->store_leader_draw_type == 1){
                        $rate = $item->store_leader_draw_rate;
                    }elseif ($item->store_leader_draw_type == 2){
                        $money = $item->store_leader_draw_money;
                    }elseif ($leader_draw_type == 1){
                        $rate = $leader_draw_rate;
                    }elseif ($leader_draw_type == 2){
                        $money = $leader_draw_money;
                    }

                    $item->leader_money = sprintf("%.2f",$item->price*$rate/100 + $money);
                }
            }else{
//                $goods_ids = Leadergoods::where('leader_id',$leader_id)->column('goods_id');

                $list = Goods::where('check_state',2)
                    ->where('state',1)
                    ->where('end_time','>',time())
                    ->where('begin_time','<=',time())
                    ->where(function($q)use($store_ids){
                        $q->whereIn('store_id',$store_ids)->whereOr('mandatory',1);

                    })

                    ->with('store')
                    ->page(input('request.page',1))
                    ->limit(input('request.limit',10))
                    ->select();

                $leader_draw_type = Config::get_value('leader_draw_type',1);
                $leader_draw_rate = Config::get_value('leader_draw_rate',0);
                $leader_draw_money = Config::get_value('leader_draw_money',0);

                foreach ($list as &$item) {
                    $rate = 0;
                    $money = 0;

                    if ($item->leader_draw_type == 1){
                        $rate = $item->leader_draw_rate;
                    }elseif ($item->leader_draw_type == 2){
                        $money = $item->leader_draw_money;
                    }elseif ($item->store_leader_draw_type == 1){
                        $rate = $item->store_leader_draw_rate;
                    }elseif ($item->store_leader_draw_type == 2){
                        $money = $item->store_leader_draw_money;
                    }elseif ($leader_draw_type == 1){
                        $rate = $leader_draw_rate;
                    }elseif ($leader_draw_type == 2){
                        $money = $leader_draw_money;
                    }

                    $item->leader_money = sprintf("%.2f",$item->price*$rate/100 + $money);
                }
            }
        }


        success_withimg_json($list);
    }

    public function addGoods(){
        $leader_id = input('request.leader_id',0);
        $goods_ids = input('request.goods_ids','');

        $leader_goods_ids = Leadergoods::where('leader_id',$leader_id)->column('goods_id');
        $goodses = Goods::where('id','in',$goods_ids)
            ->whereNotIn('id',$leader_goods_ids)
            ->field('id,store_id')
            ->select();

        $num = 0;
        foreach ($goodses as $goods) {
            try{
                $ret = Leadergoods::create([
                    'leader_id'=>$leader_id,
                    'goods_id'=>$goods->id,
                    'store_id'=>$goods->store_id
                ]);
                if ($ret){
                    $num++;
                }
            }catch (Exception $e){}
        }
        if ($num){
            success_json('成功添加 '.$num.' 个');
        }
        error_json('添加失败');
    }
    public function deleteGoods(){
        $leader_id = input('request.leader_id',0);
        $goods_ids = input('request.goods_ids','');

        $ret = Leadergoods::where('leader_id',$leader_id)
            ->whereIn('goods_id',$goods_ids)
            ->delete();

        if ($ret){
            success_json('移除成功');
        }
        error_json('移除失败');
    }

//    拼团获得商品
//    传入
//        leader_id: 团长id
//        state: 状态、1在售、2可选 3全部
    public function getPingoodses(){
        $leader_id = input('request.leader_id',0);

        $state = input('request.state',1);
        $list = [];

        $store_ids = Storeleader::where('leader_id',$leader_id)->column('store_id');
        if (count($store_ids)){
            if ($state == 1){
                $goods_ids = Leaderpingoods::where('leader_id',$leader_id)->column('goods_id');

                $list = Pingoods::where('check_state',2)
                    ->where('state',1)
                    ->where('end_time','>',time())
                    ->where('start_time','<=',time())
                    ->whereIn('store_id',$store_ids)
//                    ->whereIn('id',$goods_ids)
//                    ->whereOr('mandatory',1)
                    ->where(function($query)use($goods_ids){
                        $query->whereIn('id',$goods_ids)->whereOr('mandatory',1);
                    })
                    ->where('is_del',0)
                    ->with('store')
                    ->page(input('request.page',1))
                    ->limit(input('request.limit',10))
                    ->select();

                $leader_draw_type = Config::get_value('leader_draw_type',1);
                $leader_draw_rate = Config::get_value('leader_draw_rate',0);
                $leader_draw_money = Config::get_value('leader_draw_money',0);

                foreach ($list as &$item) {
                    $rate = 0;
                    $money = 0;

                    if ($item->leader_draw_type == 1){
                        $rate = $item->leader_draw_rate;
                    }elseif ($item->leader_draw_type == 2){
                        $money = $item->leader_draw_money;
                    }elseif ($item->store_leader_draw_type == 1){
                        $rate = $item->store_leader_draw_rate;
                    }elseif ($item->store_leader_draw_type == 2){
                        $money = $item->store_leader_draw_money;
                    }elseif ($leader_draw_type == 1){
                        $rate = $leader_draw_rate;
                    }elseif ($leader_draw_type == 2){
                        $money = $leader_draw_money;
                    }

                    $item->leader_money = sprintf("%.2f",$item->price*$rate/100 + $money);
                }
            }elseif($state==0){
                $goods_ids = Leaderpingoods::where('leader_id',$leader_id)->column('goods_id');

                $list = Pingoods::where('check_state',2)
                    ->where('state',1)
                    ->where('end_time','>',time())
                    ->where('start_time','<=',time())
                    ->whereIn('store_id',$store_ids)
                    ->whereNotIn('id',$goods_ids)
                    ->where('is_del',0)
                    ->where('mandatory',0)
                    ->with('store')
                    ->page(input('request.page',1))
                    ->limit(input('request.limit',10))
                    ->select();

                $leader_draw_type = Config::get_value('leader_draw_type',1);
                $leader_draw_rate = Config::get_value('leader_draw_rate',0);
                $leader_draw_money = Config::get_value('leader_draw_money',0);

                foreach ($list as &$item) {
                    $rate = 0;
                    $money = 0;

                    if ($item->leader_draw_type == 1){
                        $rate = $item->leader_draw_rate;
                    }elseif ($item->leader_draw_type == 2){
                        $money = $item->leader_draw_money;
                    }elseif ($item->store_leader_draw_type == 1){
                        $rate = $item->store_leader_draw_rate;
                    }elseif ($item->store_leader_draw_type == 2){
                        $money = $item->store_leader_draw_money;
                    }elseif ($leader_draw_type == 1){
                        $rate = $leader_draw_rate;
                    }elseif ($leader_draw_type == 2){
                        $money = $leader_draw_money;
                    }

                    $item->leader_money = sprintf("%.2f",$item->price*$rate/100 + $money);
                }
            }else{
//                $goods_ids = Leadergoods::where('leader_id',$leader_id)->column('goods_id');

                $list = Pingoods::where('check_state',2)
                    ->where('state',1)
                    ->where('end_time','>',time())
                    ->where('start_time','<=',time())
//                    ->whereIn('store_id',$store_ids)
//                    ->whereOr('mandatory',1)
                    ->where(function($q) use($store_ids){
                        $q->whereIn('store_id',$store_ids)->whereOr('mandatory',1);
                    })
                    ->where('is_del',0)
                    ->with('store')
                    ->page(input('request.page',1))
                    ->limit(input('request.limit',10))
                    ->select();

                $leader_draw_type = Config::get_value('leader_draw_type',1);
                $leader_draw_rate = Config::get_value('leader_draw_rate',0);
                $leader_draw_money = Config::get_value('leader_draw_money',0);

                foreach ($list as &$item) {
                    $rate = 0;
                    $money = 0;

                    if ($item->leader_draw_type == 1){
                        $rate = $item->leader_draw_rate;
                    }elseif ($item->leader_draw_type == 2){
                        $money = $item->leader_draw_money;
                    }elseif ($item->store_leader_draw_type == 1){
                        $rate = $item->store_leader_draw_rate;
                    }elseif ($item->store_leader_draw_type == 2){
                        $money = $item->store_leader_draw_money;
                    }elseif ($leader_draw_type == 1){
                        $rate = $leader_draw_rate;
                    }elseif ($leader_draw_type == 2){
                        $money = $leader_draw_money;
                    }

                    $item->leader_money = sprintf("%.2f",$item->price*$rate/100 + $money);
                }
            }
        }


        success_withimg_json($list);
    }

    public function addPingoods(){
        $leader_id = input('request.leader_id',0);
        $goods_ids = input('request.goods_ids','');

        $leader_goods_ids = Leaderpingoods::where('leader_id',$leader_id)->column('goods_id');
        $goodses = Pingoods::where('id','in',$goods_ids)
            ->whereNotIn('id',$leader_goods_ids)
            ->field('id,store_id')
            ->select();

        $num = 0;
        foreach ($goodses as $goods) {
            try{
                $ret = Leaderpingoods::create([
                    'leader_id'=>$leader_id,
                    'goods_id'=>$goods->id,
                    'store_id'=>$goods->store_id
                ]);
                if ($ret){
                    $num++;
                }
            }catch (Exception $e){}
        }
        if ($num){
            success_json('成功添加 '.$num.' 个');
        }
        error_json('添加失败');
    }
    public function deletePingoods(){
        $leader_id = input('request.leader_id',0);
        $goods_ids = input('request.goods_ids','');

        $ret = Leaderpingoods::where('leader_id',$leader_id)
            ->whereIn('goods_id',$goods_ids)
            ->delete();

        if ($ret){
            success_json('移除成功');
        }
        error_json('移除失败');
    }

//    获取团长核销员列表
//    传入
//        leader_id: 团长id
    public function getMyUsers(){
        $leader_id = input('request.leader_id',0);

        $list = Leaderuser::where('leader_id',$leader_id)
            ->with('user')
            ->page(input('request.page',1))
            ->limit(input('request.limit',10))
            ->select();

        success_withimg_json($list);
    }
    public function getUsers(){
        $key= input('request.key','');

        $leader_user_ids = Leader::where('')->column('user_id');
        $store_user_ids = Store::where('')->column('user_id');
        $leaderuser_user_ids = Leaderuser::where('')->column('user_id');

        $list = User::where('id|name|tel',"$key")
            ->whereNotIn('id',$leader_user_ids)
//            ->whereNotIn('id',$store_user_ids)
            ->whereNotIn('id',$leaderuser_user_ids)
            ->limit(10)
            ->select();

        success_json($list);
    }
    public function addUser(){
        $leader_id = input('request.leader_id',0);
        $user_id = input('request.user_id',0);

        $ret = Leaderuser::create([
            'leader_id'=>$leader_id,
            'user_id'=>$user_id,
        ]);

        if ($ret){
            success_json('成功添加');
        }
        error_json('添加失败');
    }
    public function deleteUser(){
        $leaderuser_id = input('request.leaderuser_id',0);

        $ret = Leaderuser::destroy($leaderuser_id);

        if ($ret){
            success_json('移除成功');
        }
        error_json('移除失败');
    }

    public function getConfirmUsers(){
        $leader_id = input('request.leader_id');
        $key = input('request.key','');

        $list = Ordergoods::where('t1.leader_id',$leader_id)
            ->alias('t1')
            ->where('t1.state = 4')
            ->join('user t2','t2.id = t1.user_id')
            ->where('t2.name|t2.tel',['like',"%$key%"])
            ->field('t1.user_id,t2.name as user_name,t2.img,t2.tel')
            ->distinct('t1.user_id,t2.name,t2.img,t2.tel')
            ->select();
        $pinList = Pinorder::where('t1.leader_id',$leader_id)
            ->alias('t1')
            ->where('t1.order_status = 4')
            ->join('user t2','t2.id = t1.user_id')
            ->where('t2.name|t2.tel',['like',"%$key%"])
            ->field('t1.user_id,t2.name as user_name,t2.img,t2.tel')
            ->distinct('t1.user_id,t2.name,t2.img,t2.tel')
            ->select();
        $user_ids = [];
        foreach($list as $user){
            $user_ids[]=$user->user_id;
        }
        foreach($pinList as $pinUser){
            if(!in_array($pinUser->user_id,$user_ids)){
                $list[] = $pinUser;
            }
        }

        success_json($list);
    }

    public function getConfirmSendingUsers(){
        $leader_id = input('request.leader_id');
        $key = input('request.key','');

        $list = Ordergoods::where('t1.leader_id',$leader_id)
            ->alias('t1')
            ->where('t1.state = 3')
            ->join('user t2','t2.id = t1.user_id')
            ->where('t2.name|t2.tel',['like',"%$key%"])
            ->field('t1.user_id,t2.name as user_name,t2.img,t2.tel')
            ->distinct('t1.user_id,t2.name,t2.img,t2.tel')
            ->select();
        success_json($list);
    }

    public function getSendingUsers(){
        $leader_id = input('request.leader_id');
        $key = input('request.key','');

        $list = Ordergoods::where('t1.leader_id',$leader_id)
            ->alias('t1')
            ->where('t1.state = 3 and check_state in (0,3)')
            ->join('user t2','t2.id = t1.user_id')
            ->where('t2.name|t2.tel',['like',"%$key%"])
            ->field('t1.user_id,t2.name as user_name,t2.img,t2.tel')
            ->distinct('t1.user_id,t2.name,t2.img,t2.tel')
            ->select();
        $pinList = Pinorder::where('t1.leader_id',$leader_id)
            ->alias('t1')
            ->where('t1.order_status = 3')
            ->join('user t2','t2.id = t1.user_id')
            ->where('t2.name|t2.tel',['like',"%$key%"])
            ->field('t1.user_id,t2.name as user_name,t2.img,t2.tel')
            ->distinct('t1.user_id,t2.name,t2.img,t2.tel')
            ->select();
            $user_ids=[];
            foreach($list as $user){
                $user_ids[]=$user->user_id;
            }
            foreach($pinList as $pinUser){
                if(!in_array($pinUser->user_id,$user_ids)){
                    $list[]=$pinUser;
                }
            }
        success_json($list);
    }

    //获得销售商品
    /*
     * leader_id 团长id
     * state 0是普通商品 1是拼团商品
     *
     */
    public function goodsSelect(){

        //团长对应的店铺
        $key = input('post.key');
        $leader_id = input('request.leader_id',0);
        $store_ids = Storeleader::where('leader_id',$leader_id)->column('store_id');

        $page = input('post.page',1);
        $limit =input('post.limit',5);

        $list =[];
        $where=[];

        //是否开启团长选择商品
        $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch',0);

        if($leader_choosegoods_switch == 1){
            $where=function($query) use ($leader_id,$key){
                $goods_ids = Leadergoods::where('leader_id',$leader_id)->column('goods_id');
                $query->where(function($q)use($goods_ids){
                    $q->where('id','in',$goods_ids)->whereOr('mandatory',1);
                });
            };
        }
        $list = Goods::where('check_state',2)
            ->where('state',1)
            ->where('end_time','>',time())
            ->where('begin_time','<=',time())
            ->whereIn('store_id',$store_ids)
            ->where($where)
            ->where('name','like',"%$key%")
            ->with('store')
            ->page($page)
            ->limit($limit)
            ->select();
        foreach ($list as $key=>$goods){
            $list[$key]['pics'] = json_decode($goods['pics']);
        }
        $count = Goods::where('check_state',2)
            ->where('state',1)
            ->where('end_time','>',time())
            ->where('begin_time','<=',time())
            ->whereIn('store_id',$store_ids)
            ->where($where)
            ->where('name','like',"%$key%")
            ->count();
        success_withimg_json($list,['count'=>$count]);
    }
    public function pingoodsSelect(){

        //团长对应的店铺
        $key = input('post.key');
        $leader_id = input('request.leader_id',0);
        $store_ids = Storeleader::where('leader_id',$leader_id)->column('store_id');

        $page = input('post.page',1);
        $limit =input('post.limit');

        $list =[];
        $where=[];

        //是否开启团长选择商品
        $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch',0);

        if($leader_choosegoods_switch == 1){
            $where=function($query) use ($leader_id,$key){
                $goods_ids =Leaderpingoods::where('leader_id',$leader_id)->column('goods_id');
                $query->where(function($q)use($goods_ids){
                    $q->whereIn('id',$goods_ids)->whereOr('mandatory',1);
                });
                $query->where('name','like',"%$key%");
            };
        }
        $list = Pingoods::where('check_state',2)
            ->where('state',1)
            ->where('end_time','>',time())
            ->where('start_time','<=',time())
            ->whereIn('store_id',$store_ids)
//            ->whereNotIn('id',$goods_ids)
            ->where('is_del',0)
//            ->where('mandatory',0)
            ->where($where)
            ->where('name','like',"%$key%")
            ->with('store')
            ->page(input('request.page',1))
            ->limit(input('request.limit',10))
            ->select();
        foreach ($list as $key=>$goods){
            $list[$key]['pics'] = json_decode($goods['pics']);
        }
        $count = Pingoods::where('check_state',2)
            ->where('state',1)
            ->where('end_time','>',time())
            ->where('start_time','<=',time())
            ->whereIn('store_id',$store_ids)
//            ->whereNotIn('id',$goods_ids)
            ->where('is_del',0)
//            ->where('mandatory',0)
            ->where($where)
            ->where('name','like',"%$key%")
            ->count();
        success_withimg_json($list,['count'=>$count]);

    }

    public function leaderbill(){
        $leader_id = input('request.leader_id');
        $type = input('request.type');
        if($type == 1){
            $getModel = function ()use ($type){
                $model = new Leaderbill();
                $model->alias('t1')
                    ->join('leader t2','t1.leader_id = t2.id')
                    ->join('ordergoods t3','t3.id = t1.order_id')
                    ->join('user t4','t4.id = t3.user_id')
                    ->join('order t5','t5.id = t3.order_id');
                $model->where("t1.content","商城订单");

                $key = input('request.key','');
                if ($key){
                    $model->where('t2.name|t4.name|t3.goods_name|t5.order_no',['like',"%$key%"]);
                }
                $leader_id = input('request.leader_id',0);
                if ($leader_id){
                    $model->where('t1.leader_id',$leader_id);
                }
                $begin_time = input('get.begin_time','');
                if ($begin_time){
                    $model->where('t1.create_time >= ' . strtotime($begin_time));
                }

                $end_time = input('get.end_time','');
                if ($end_time){
                    $end_time = strtotime($end_time);
                    $model->where('t1.create_time <= ' . $end_time);
                }

                $model->order('t1.create_time desc,t1.id desc');

                return $model;
            };

            $model = $getModel();


            //分页
            $page = input('request.page',1);
            if($page){
                $limit = input('request.limit',10);
                $model->limit($limit)->page($page);
            }
            $model->field('t2.name as leader_name,t4.name as user_name,t1.*,t3.goods_name,t3.attr_names,t3.amount,t3.pay_amount,t5.order_no');
        }else{
            $getModel = function ()use ($type){
                $model = new Leaderbill();
                $model->alias('t1')
                    ->join('leader t2','t1.leader_id = t2.id')
                    ->join('pinorder t3','t3.id = t1.order_id')
                    ->join('user t4','t4.id = t3.user_id')
                    ->join('pingoods t5','t5.id=t3.goods_id');
                $model->where("t1.content","拼团订单");

                $key = input('request.key','');
//                if ($key){
//                    $model->where('t2.name|t4.name,['like',"%$key%"]);
//                }
                $leader_id = input('request.leader_id',0);
                if ($leader_id){
                    $model->where('t1.leader_id',$leader_id);
                }
                $begin_time = input('get.begin_time','');
                if ($begin_time){
                    $model->where('t1.create_time >= ' . strtotime($begin_time));
                }

                $end_time = input('get.end_time','');
                if ($end_time){
                    $end_time = strtotime($end_time);
                    $model->where('t1.create_time <= ' . $end_time);
                }

                $model->order('t1.create_time desc,t1.id desc');

                return $model;
            };

            $model = $getModel();


            //分页
            $page = input('request.page',1);
            if($page){
                $limit = input('request.limit',10);
                $model->limit($limit)->page($page);
            }
            $model->field('t2.name as leader_name,t4.name as user_name,t1.*,t5.name as goods_name,t3.attr_list  as attr_names,t3.order_amount-t3.distribution as amount,t3.order_amount as pay_amount,t3.order_num as order_no');
        }



        $list = $model->select();
//        $sql = $model->getLastSql();

        $model = $getModel();
        success_json($list,['count'=>$model->count()]);
    }
    public function test(){
        echo 'aa';
    }
}