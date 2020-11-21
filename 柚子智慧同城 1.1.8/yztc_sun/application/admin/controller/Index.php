<?php
namespace app\admin\controller;

use app\model\Commonorder;
use app\model\Couponget;
use app\model\Menugroup;
use app\model\Order;
use app\model\Shop;
use app\model\System;
use app\model\User;
use think\Db;

class Index extends Base
{
//    框架页面
    public function index()
    {
        global $_W;
        $this->view->_W = $_W;
        $check = new \EB042D8DD30DD982EF27DF80492D786B();
        $ret = $check->B52AF623E29C91E28D727BA5B05812F3();
        if (!$ret){
//            header('location:'.adminurl('auth'));
        }
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
        $this->view->menugroup = $menugroup_list;
        if($_SESSION['admin']['store_id']>0){
          // var_dump(objecttoarray($menugroup_list));
          // exit;
        }
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
//        商户商品数据
//        $store_id = $_SESSION['admin']['store_id'];
//        if ($store_id){
//            $this->view->store = Store::get($store_id);
//        }
//          TODO::用户数据
        $user_model = new User();
        $user = [];
        $user['count'] = $user_model->count();
        $user['today_count'] = $user_model->where("TO_DAYS(NOW()) - TO_DAYS( FROM_UNIXTIME(create_time)) = 0")->count();
        $user['yesterday_count'] = $user_model->where("TO_DAYS(NOW()) - TO_DAYS( FROM_UNIXTIME(create_time)) = 1")->count();
        $user['month_count'] = $user_model->where("DATE_FORMAT(NOW(),'%Y%m') - DATE_FORMAT( FROM_UNIXTIME(create_time),'%Y%m') = 0")->count();
        $this->view->user = $user;
       //TODO::订单数据
        $order_model=new Commonorder();
        $order=array();
        if ($_SESSION['admin']['store_id'] > 0) {
            $whereord['store_id']=$_SESSION['admin']['store_id'];
        }
        $whereord['uniacid']=$_W['uniacid'];
        $order['wait_pay']=$order_model->where(['order_status'=>10])->where($whereord)->count();
        $order['wait_use']=$order_model->where(['order_status'=>20])->where($whereord)->count();
        $order['after_sale']=$order_model->where(['order_status '=>['between',[40,60]]])->where($whereord)->count();
        $this->view->order = $order;
        return view();
    }

    //TODO::销售数据
    public function saleData(){
        global $_W;
        $day = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
        $time1=strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
        $time2=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
        $time3=strtotime(date("Y-m-01"));//当月
        $time4=strtotime(date("Y-m-01",strtotime("-1 month")));//上月
        $time5=strtotime(date("Y-01-01"));//今年
        $order=new Commonorder();
        $type=input('post.type',1);
        //1.今日 2.昨日 3.本月 4.上月 5.今年
        switch ($type){
            case 1:
                $where['update_time']=['egt',$day];
                break;
            case 2:
                $where['update_time']=[['egt',$time2],['lt',$day]];
                break;
            case 3:
                $where['update_time']=['egt',$time3];
                break;
            case 4:
                $where['update_time']=[['egt',$time4],['lt',$time3]];
                break;
            case 5:
                $where['update_time']=['egt',$time5];
                break;
        }
        $where['uniacid']=$_W['uniacid'];
        $where['order_status'] =  array(['=',40],['=',60],'or');
        if ($_SESSION['admin']['store_id'] > 0) {
            $where['store_id']=$_SESSION['admin']['store_id'];
        }
        //成交量
        $date['salenum']=intval($order->where($where)->sum('num'));
        //成交额
        $date['salemoney']=sprintf("%.2f",$order->where($where)->sum('order_amount'));
        //平均
        $date['avesalemoney']=sprintf("%.2f",$order->where($where)->avg('order_amount'));
        return [
            'code'=>0,
            'data'=>$date,
            'msg'=>'success',
        ];
    }
//    public function goodsSale(){
//        global $_W;
//        $day = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
//        $time1=strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
//        $time2=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
//        $time3=strtotime(date("Y-m"));//当月
//        $time4=strtotime(date("Y-m-d",strtotime("-7 day")));//获取7天前凌晨的时间戳
//        $time5=strtotime(date("Y-m-d",strtotime("-30 day")));//获取30天前凌晨的时间戳
//        $type=input('post.type',1);
//        //1.今天 2.昨天 3.七天 4.30天
//        switch ($type){
//            case 1:
//                $where['a.create_time']=['egt',$day];
//                break;
//            case 2:
//                $where['a.create_time']=[['egt',$time2],['lt',$day]];
//                break;
//            case 3:
//                $where['a.create_time']=['egt',$time4];
//                break;
//            case 4:
//                $where['a.create_time']=['egt',$time5];
//                break;
//        }
//        $where['b.order_status']=3;
//        $where['a.uniacid']=$_W['uniacid'];
//        $where['b.store_id'] = $_SESSION['admin']['store_id'];
//        $goodsale=Db::name('orderdetail')->alias('a')->join('order b','a.order_id=b.id')
//            ->where($where)->field('a.gid,a.gname,sum(a.num) as salenum')->group('a.gid')->order(['salenum'=>'desc'])->limit(5)->select();
//        return [
//            'code'=>0,
//            'data'=>$goodsale,
//            'msg'=>'success',
//        ];
//    }

    public function auth(){
        $check = new \EB042D8DD30DD982EF27DF80492D786B();
        $ret = $check->B52AF623E29C91E28D727BA5B05812F3();
        if ($ret){
            header('location:'.adminurl('index'));
        }

        return view();
    }
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
        $toactive = encryptcode("35bcr/gGmbqRZmM3gx9efUySl+Z0XHe+7qtHS412VSPG9dGuTbxFC4IcCo4KjVQt", 'D','',0) . '/toactive.php?c=1&p=32&k='.$code.'&i='.$ip.'&u=' . $_SERVER['HTTP_HOST'];
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
            $res = pdo_update('yztc_sun_acode', array("code"=>$input_data_s), array('id' =>1));
            if(!$res){
                $res = pdo_insert('yztc_sun_acode', array("code"=>$input_data_s,"id"=>1,"time"=>time()));
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
}
