<?php
namespace app\admin\controller;
use app\base\controller\Admin;
use app\model\Ad;
use app\model\Goods;
use app\model\Leader;
use app\model\Menugroup;
use app\model\Order;
use app\model\Ordergoods;
use app\model\Payrecord;
use app\model\Store;
use app\model\System;
use app\model\Task;
use app\model\User;
use think\Config;
use think\Db;
use think\Hook;
use think\Log;

class Index extends Admin
{
//    框架页面
    public function index()
    {
//        Log::record('sssssss','callback');
//
//        $a = Hook::get();
//        echo json_encode($a);exit;
//
//        $order = new Ordergoods();
//        echo $order->getAttr('order_id');
//        exit();

//        $order = Order::get(692);
////        echo json_encode($order);exit;
//        $task = new Task();
//        $task->onOrderPay($order);
//        exit;

        // $check = new \EB042D8DD30DD982EF27DF80492D786B();
        // $ret = $check->B52AF623E29C91E28D727BA5B05812F3();
        // if (!$ret){
        //     header('location:'.adminurl('auth'));
        // }


//        获取用户信息
        $admin = $this->check_login();
        $this->view->admin = $admin;

//        系统设置信息
        $setting = System::get_curr();
        $this->view->setting = $setting;

//        获取菜单数据
//        todo 到时要根据用户的角色过滤菜单
        $menugroup = new Menugroup();
        $menugroup->fill_order_limit(true,false);
        if ($_SESSION['admin']['store_id']){
            $menugroup->where('store_show',1);
        }
        $menugroup_list = $menugroup->with('menus')->where('state',1)->select();
//        echo json_encode($menugroup_list);exit;
        $this->view->menugroup = $menugroup_list;
        return view();
    }

//    登录页面
    public function login()
    {
        return view();
    }
//    首页面板
    public function home(){
        global $_W;
        $this->view->_W = $_W;
//        商户商品数据
        $store_id = $_SESSION['admin']['store_id'];
        if ($store_id){
            $store = Store::get($store_id);
            $store->goods_count = Goods::where('store_id',$store_id)
                ->where('check_state',2)
                ->where('state',1)
                ->count();
            $store->sale_count = Ordergoods::where('store_id',$store_id)
                ->where('state',5)
                ->sum('num');
            $this->view->store = $store;
        }
//          TODO::用户数据
        $user_model = new User();
        $user = [];
        $user['count'] = $user_model->count();
        $user['today_count'] = $user_model->where("TO_DAYS(NOW()) - TO_DAYS( FROM_UNIXTIME(create_time)) = 0")->count();
        $user['yesterday_count'] = $user_model->where("TO_DAYS(NOW()) - TO_DAYS( FROM_UNIXTIME(create_time)) = 1")->count();
        $user['month_count'] = $user_model->where("DATE_FORMAT(NOW(),'%Y%m') - DATE_FORMAT( FROM_UNIXTIME(create_time),'%Y%m') = 0")->count();
        $this->view->user = $user;

//        TODO::用户消费排行
        $this->view->user_order = Ordergoods::hasWhere('user')
            ->where('store_id',$_SESSION['admin']['store_id'])
            ->whereIn('state',[2,3,4,5])
            ->with('user')
            ->group('user_id')
            ->field('user_id,sum(amount) as amount')
            ->order('amount desc')
            ->limit(6)
            ->select();
//        todo::最近 7 天销售数据
        $list = Db::query("
            select DATE_FORMAT(d,'%m-%d') as d,sum(t1.goods_num) as goods_count,sum(total_price) as amount_sum
            from (
                select t1.d,coalesce(t2.num,0)as goods_num,coalesce(t2.pay_amount,0)as total_price
                from(
                    select DATE_SUB(curdate(),INTERVAL 0 DAY) as d
                    union all
                    select DATE_SUB(curdate(),INTERVAL 1 DAY) as d
                    union all
                    select DATE_SUB(curdate(),INTERVAL 2 DAY) as d
                    union all
                    select DATE_SUB(curdate(),INTERVAL 3 DAY) as d
                    union all
                    select DATE_SUB(curdate(),INTERVAL 4 DAY) as d
                    union all
                    select DATE_SUB(curdate(),INTERVAL 5 DAY) as d
                    union all
                    select DATE_SUB(curdate(),INTERVAL 6 DAY) as d
                )t1
                left join ".tablename('sqtg_sun_ordergoods')." t2 
                    on t2.state in(2,3,4,5) and FROM_UNIXTIME(t2.create_time,'%y-%m-%d') = t1.d
                    and t2.store_id = {$store_id}
                    and t2.uniacid = {$_W['uniacid']}
            )t1
            GROUP BY DATE_FORMAT(d,'%m-%d')
            order by DATE_FORMAT(d,'%m-%d')
        ");
        $days = [];
        $goods_counts = [];
        $amount_sums = [];
        foreach ($list as $item) {
            $days[] = $item['d'];
            $goods_counts[] = $item['goods_count'];
            $amount_sums[] = $item['amount_sum'];
        }
        $this->view->saledata7 = [
            'days' => $days,
            'goods_counts' => $goods_counts,
            'amount_sums' => $amount_sums,
        ];

        $leader_ids = Leader::where('')->column('id');
//        todo::订单数据
        $this->view->saledata8= [
            'dfk'=>Ordergoods::where('store_id',$_SESSION['admin']['store_id'])
                ->where('state',1)
                ->whereIn('leader_id',$leader_ids)
                ->count('distinct order_id'),
            'dfh'=>Ordergoods::where('store_id',$_SESSION['admin']['store_id'])
                ->where('state',2)
                ->whereIn('leader_id',$leader_ids)
                ->count('distinct order_id'),
            'dzt'=>Ordergoods::where('store_id',$_SESSION['admin']['store_id'])
                ->where('state',4)
                ->whereIn('leader_id',$leader_ids)
                ->count('distinct order_id'),
        ];
        return view();
    }
    /**
     * 销售数据
    */
    public function saleData(){
        $day = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
        $time1=strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
        $time2=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
        $time3=strtotime(date("Y-m"));//当月
        $time4=strtotime(date("Y-m-d",strtotime("-7 day")));//获取7天前凌晨的时间戳
        $time5=strtotime(date("Y-m-d",strtotime("-30 day")));//获取30天前凌晨的时间戳

        $type=input('post.type',1);
        //1.今天 2.昨天 3.七天 4.30天
        switch ($type){
            case 1:
                $where['create_time']=['egt',$day];
                break;
            case 2:
                $where['create_time']=[['egt',$time2],['lt',$day]];
                break;
            case 3:
                $where['create_time']=['egt',$time4];
                break;
            case 4:
                $where['create_time']=['egt',$time5];
                break;
        }
        $where['state']=['in',[2,3,4,5]];
        $where['store_id'] = $_SESSION['admin']['store_id'];
        //成交量
        $date['salenum']=intval(Ordergoods::where($where)->sum('num'));
        //成交额
        $date['salemoney']=sprintf("%.2f",Ordergoods::where($where)->sum('pay_amount'));

        //平均
        $arr = Ordergoods::where($where)->group('order_id')->field('sum(pay_amount) as pay_amount')->column('pay_amount');
        $date['avesalemoney']=0;
        if (count($arr)){
            $date['avesalemoney']=sprintf("%.2f",array_sum($arr)/count($arr));
        }
        return [
            'code'=>0,
            'data'=>$date,
            'msg'=>'success',
        ];
    }
    public function goodsSale(){
        global $_W;
        $day = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
        $time1=strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
        $time2=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
        $time3=strtotime(date("Y-m"));//当月
        $time4=strtotime(date("Y-m-d",strtotime("-7 day")));//获取7天前凌晨的时间戳
        $time5=strtotime(date("Y-m-d",strtotime("-30 day")));//获取30天前凌晨的时间戳
        $type=input('post.type',1);
        //1.今天 2.昨天 3.七天 4.30天
        switch ($type){
            case 1:
                $where['create_time']=['egt',$day];
                break;
            case 2:
                $where['create_time']=[['egt',$time2],['lt',$day]];
                break;
            case 3:
                $where['create_time']=['egt',$time4];
                break;
            case 4:
                $where['create_time']=['egt',$time5];
                break;
        }
        $where['state']=['in',[2,3,4,5]];
        $where['store_id'] = $_SESSION['admin']['store_id'];

        $goodsale = Ordergoods::where($where)
            ->group('goods_name')
            ->field('goods_name,sum(num) as num')
            ->order('num desc')
            ->limit(5)
            ->select();
        return [
            'code'=>0,
            'data'=>$goodsale,
            'msg'=>'success',
        ];
    }

    public function leaderOrder(){
        $time_day = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $time_month = mktime(0,0,0,date('m'),1,date('Y'));
        $time_year = mktime(0,0,0,1,1,date('Y'));

        $type=input('post.type',1);
        //1.本日 2.本月 3.本年
        switch ($type){
            case 1:
                $where['create_time']=['>=',$time_day];
                break;
            case 2:
                $where['create_time']=['>=',$time_month];
                break;
            case 3:
                $where['create_time']=['>=',$time_year];
                break;
        }
        $where['state']=['in',[5]];
        $where['store_id'] = $_SESSION['admin']['store_id'];

        $goodsale = Ordergoods::where($where)
            ->group('leader_id')
            ->field('leader_id,sum(amount) as amount')
            ->order('amount desc num desc')
            ->limit(5)
            ->with('leader')
            ->select();
        return [
            'code'=>0,
            'data'=>$goodsale,
            'msg'=>'success',
        ];
    }

//    授权
    // public function auth(){
    //     global $_W;
    //     $check = new \EB042D8DD30DD982EF27DF80492D786B();
    //     $ret = $check->B52AF623E29C91E28D727BA5B05812F3();
    //     $this->view->_W = $_W;
    //     if ($ret){
    //         header('location:'.adminurl('index'));
    //     }

    //     return view();
    // }
    public function save(){
        $code = input('request.code');
        if(empty($code)){
            return array(
                'code'=>1,
                'msg'=>'请输入激活码进行激活',
            );
        }

        $ip_arr = gethostbynamel($_SERVER['HTTP_HOST']);
        $ip = $ip_arr?$ip_arr[0]:0;
        $toactive = encryptcode("35bcr/gGmbqRZmM3gx9efUySl+Z0XHe+7qtHS412VSPG9dGuTbxFC4IcCo4KjVQt", 'D','',0) . '/toactive.php?c=1&p=17&k='.$code.'&i='.$ip.'&u=' . $_SERVER['HTTP_HOST'];
        $toactive = tocurl($toactive,10);
        $toactive = trim($toactive, "\xEF\xBB\xBF");//去除bom头
        $json_toactive = json_decode($toactive,true);

        if($json_toactive["code"]===0){
            $input_data = array();
            $input_data["we7.cc"] = md5("we7_key");
            $input_data["keyid"] = $json_toactive["data"]["id"];
            $input_data["domain"] = $json_toactive["data"]["domain"];
            $input_data["ip"] = $json_toactive["data"]["ip"];
            $input_data["loca_ip"] = "127.0.0.1";
            $input_data["pid"] = $json_toactive["data"]["pid"];
            $input_data["domain_str"] = $json_toactive["data"]["domain_str"];
            $input_data["time"] = time();
            $input_data_s = serialize($input_data);
            $input_data_s = encryptcode($input_data_s, 'E','',0);
            $res = pdo_update('sqtg_sun_acode', array("code"=>$input_data_s), array('id' =>1));
            if(!$res){
                $res = pdo_insert('sqtg_sun_acode', array("code"=>$input_data_s,"id"=>1,"time"=>time()));
            }
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'激活失败',
            );
        }
    }
    public function test(){
        echo json_encode(Config::get('database'));
    }
    public function testpaycallback(){
        $xml = '<xml><appid><![CDATA[wx6564db913fdb5f17]]></appid>
<attach><![CDATA[{"payrecord_id":"793"}]]></attach>
<bank_type><![CDATA[COMM_CREDIT]]></bank_type>
<cash_fee><![CDATA[100]]></cash_fee>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[N]]></is_subscribe>
<mch_id><![CDATA[1521879401]]></mch_id>
<nonce_str><![CDATA[bmwcq4naaxnp85nnxegiv7rrtz0s63mw]]></nonce_str>
<openid><![CDATA[oUfto5K8T84ewbLwCIqS4eQwxwks]]></openid>
<out_trade_no><![CDATA[201901071301097269]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[249FDEF980FF620D192E636AB892B472]]></sign>
<time_end><![CDATA[20190107130115]]></time_end>
<total_fee>100</total_fee>
<trade_type><![CDATA[JSAPI]]></trade_type>
<transaction_id><![CDATA[4200000216201901073323766381]]></transaction_id>
</xml>';//要发送的xml

        $url = 'http://admin.szweijubao.net/addons/sqtg_sun/public/notify.php';//接收XML地址

        $header = 'Content-type: text/xml';//定义content-type为xml
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//设置链接
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置HTTP头
        curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);//POST数据
        $response = curl_exec($ch);//接收返回信息
        if(curl_errno($ch)){//出错则显示错误信息
            print curl_error($ch);
        }
        curl_close($ch); //关闭curl链接
        echo $response;//显示返回信息
    }
}
