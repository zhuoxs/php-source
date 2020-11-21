<?php
namespace app\admin\controller;
use app\api\controller\Cwx;
use app\base\controller\Admin;
use app\model\Customize;
use app\model\Config;

class Csystem extends Admin
{
    public function smallapp(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('smallapp');
    }
    public function team(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('team');
    }
    public function platform(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $info['global_delivery_fee'] = Config::get_value('global_delivery_fee',0);
        $info['delivery_fee_merge'] = Config::get_value('delivery_fee_merge',0);
        $info['balance'] = Config::get_value('balance',0);
        $info['style'] = Config::get_value('style',1);
        $this->view->info = $info;
        return view('platform');
    }
    public function appstyle(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('appstyle');
    }
    public function down(){
        $url = input('post.url');
        if ($url){
            $name = input('post.name')?:(time().".mp4");

            ob_start();
            header( "Content-type:  application/octet-stream ");
            header( "Accept-Ranges:  bytes ");
            header( "Content-Disposition:  attachment;  filename= ".$name);
            header( "Accept-Length: " .readfile($url));
            exit;
        }

        return view('down');
    }
    public function upload(){
        global $_W;
        $file = $_FILES['file'];
//        验证文件格式
        if($file['type']!='application/octet-stream'){
            throw new \ZhyException('文件类型只能为pem格式');
        }
//        验证文件大小
        if($file['size']>2*1024*1024) {
            throw new \ZhyException('上传文件过大，不得超过2M');
        }

        //判断是否上传成功
        if(!is_uploaded_file($file['tmp_name'])) {
            throw new \ZhyException('上传失败');
        }

        //把文件转存到你希望的目录（不要使用copy函数）
        $uploaded_file=$file['tmp_name'];
        //我们给每个用户动态的创建一个文件夹
        $user_path=IA_ROOT."/addons/sqtg_sun/cert/";

        //判断该用户文件夹是否已经有这个文件夹
        if(!file_exists($user_path)) {
            mkdir($user_path);
        }
        $file_true_name=$file['name'];
        $file_true_name = rtrim($file_true_name,'.pem');
        $file_true_name = $file_true_name . '_' . $_W['uniacid'] . '.pem';
        $move_to_file=$user_path.$file_true_name;
        //echo "$uploaded_file   $move_to_file";
        if(!move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {
            throw new \ZhyException('上传失败');
        }
        $data = [];
        $data['src'] = $file_true_name;
        success_json($data);
    }
    public function save(){
        $info = $this->model;
        $data = input('post.');
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }

        //全局配送费
        $global_delivery_fee = input('post.global_delivery_fee');
        $config = Config::full_id('global_delivery_fee',$global_delivery_fee);
        $config_model = new Config($config);
        if(isset($config['id'])){
            $config_model->where('id',$config['id'])->update($config);
        }else{
            $config_model->save($config);
        }
        unset($data['global_delivery_fee']);

        //是否开启余额支付
        $balance = input('post.balance');
        $config = Config::full_id('balance',$balance);
        $config_model = new Config($config);
        if(isset($config['id'])){
            $config_model->where('id',$config['id'])->update($config);
        }else{
            $config_model->save($config);
        }
        unset($data['balance']);

        //使用的首页样式
        $style = input('post.style');
        $config = Config::full_id('style',$style);
        $config_model = new Config($config);
        if(isset($config['id'])){
            $config_model->where('id',$config['id'])->update($config);
        }else{
            $config_model->save($config);
        }
        unset($data['style']);

        //运费合并
        $delivery_fee_merge = input('post.delivery_fee_merge');
        $config = Config::full_id('delivery_fee_merge',$delivery_fee_merge);
        $config_model = new Config($config);
        if(isset($config['id'])){
            $config_model->where('id',$config['id'])->update($config);
        }else{
            $config_model->save($config);
        }
        unset($data['delivery_fee_merge']);

        $ret = $info->allowField(true)->save($data);
        if($ret!==false){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败'.json_encode($info->getLastSql()),
            );
        }
    }
    /**
     * 菜单图标自定义列表
    */
    public function menuicon(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('menuicon');
    }
    /**
     * 新增、编辑
     */
    public function addmenuicon(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $cus=new Customize();
        $id=input('get.id');
        if($id){
            $info =$cus->getMenu($id);
            $this->view->info = $info;
        }
        $this->view->linkurl =getWxAppUrl();
        return view('addmenuicon');
    }
    public function savemenuicon(){
        global $_W;
        $info=new Customize();
        $id = input('post.id');
        if ($id){
            $info = $info->getMenu($id);
        }
        $data = input('post.');
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
    public function get_menuicon_list(){
        global $_W;
        $model =new Customize();

        //排序、分页
        $model->fill_order_limit();
        //条件
//        $query = function ($query){
//            //关键字搜索
////            $key = input('get.key');
////            if ($key){
////                $query->where('name','like',"%$key%")->whereOr('control','like',"%$key%")->whereOr('action','like',"%$key%");
////            }
//            $query->where('type',2);
//
//        };

        $where['type']=2;
        $where['uniacid']=$_W['uniacid'];
        $list = $model->where($where)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 删除
    */
    public function deletem(){
        $ids = input('post.ids');
        $cus=new Customize();
        $ret = $cus->destroy($ids);
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
    public function updateapp()
    {
        if(function_exists("generate_update_app")){
            return generate_update_app();
        }else{
            return "系统更新模块加载失败!";
        }
    }
    public function page(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $this->view->pages = [
            [
                'name'=>'首页',
                'link'=>"sqtg_sun/pages/home/index/index",
                'parms'=>[
                    [
                        'name'=>'share_user_id',
                        'memo'=>'分享人的用户id',
                        'required'=>false,
                        'control'=>'cuser',
                        'controltext'=>'用户列表',
                    ],
                    [
                        'name'=>'l_id',
                        'memo'=>'分享人的选中的团长id',
                        'required'=>false,
                        'control'=>'cleader',
                        'controltext'=>'团长列表',
                    ],
                ]
            ],
            [
                'name'=>'购物车',
                'link'=>"sqtg_sun/pages/home/shopcar/shopcar",
            ],
            [
                'name'=>'我的',
                'link'=>"sqtg_sun/pages/home/my/my",
            ],
            [
                'name'=>'商品详情页',
                'link'=>"sqtg_sun/pages/zkx/pages/classifydetail/classifydetail",
                'parms'=>[
                    [
                        'name'=>'id',
                        'memo'=>'商品id',
                        'required'=>true,
                        'control'=>'cgoods',
                        'controltext'=>'商品列表',
                    ],
                    [
                        'name'=>'s_id',
                        'memo'=>'分享人的用户id',
                        'required'=>false,
                        'control'=>'cuser',
                        'controltext'=>'用户列表',
                    ],
                    [
                        'name'=>'l_id',
                        'memo'=>'分享人的选中的团长id',
                        'required'=>false,
                        'control'=>'cleader',
                        'controltext'=>'团长列表',
                    ],
                ]
            ],
//            [
//                'name'=>'登录',
//                'link'=>"sqtg_sun/pages/home/login/login",
//            ],
            [
                'name'=>'商家入驻',
                'link'=>"sqtg_sun/pages/zkx/pages/merchants/merchantenter/merchantenter",
            ],
            [
                'name'=>'商家中心',
                'link'=>"sqtg_sun/pages/zkx/pages/merchants/merchantcenter/merchantcenter",
            ],
//            [
//                'name'=>'商家提现',
//                'link'=>"sqtg_sun/pages/zkx/pages/merchants/withdrawal/withdrawal",
//                'parms'=>[
//                    [
//                        'name'=>'id',
//                        'memo'=>'商户id',
//                        'required'=>true,
//                    ],
//                ]
//            ],
            [
                'name'=>'团长申请',
                'link'=>"sqtg_sun/pages/zkx/pages/headapplication/headapplication",
            ],
            [
                'name'=>'团长后台',
                'link'=>"sqtg_sun/pages/zkx/pages/headcenter/headcenter",
            ],
            [
                'name'=>'团员订单',
                'link'=>"sqtg_sun/pages/zkx/pages/memberorder/memberorder",
                'parms'=>[
                    [
                        'name'=>'id',
                        'memo'=>'订单状态，2待配送，3配送中，4待自提，5已完成',
                        'required'=>false,
                    ],
                ]
            ],
//            [
//                'name'=>'团员订单详情',
//                'link'=>"sqtg_sun/pages/zkx/pages/memberorderdetail/memberorderdetail",
//                'parms'=>[
//                    [
//                        'name'=>'id',
//                        'memo'=>'订单id',
//                        'required'=>true,
//                    ],
//                ]
//            ],
//            [
//                'name'=>'商品核销',
//                'link'=>"sqtg_sun/pages/zkx/pages/verificationorder/verificationorder",
//            ],
            [
                'name'=>'团长提现',
                'link'=>"sqtg_sun/pages/zkx/pages/withdrawal/withdrawal",
            ],
//            [
//                'name'=>'手机填写',
//                'link'=>"sqtg_sun/pages/zkx/pages/setphonenum/setphonenum",
//            ],
            [
                'name'=>'团长商品选择',
                'link'=>"sqtg_sun/pages/zkx/pages/headgoods/headgoods",
            ],
            [
                'name'=>'添加核销员',
                'link'=>"sqtg_sun/pages/zkx/pages/verificationmember/verificationmember",
                'parms'=>[
                    [
                        'name'=>'leader_id',
                        'memo'=>'团长id',
                        'required'=>true,
                        'control'=>'cleader',
                        'controltext'=>'团长列表',
                    ],
                ]
            ],
            [
                'name'=>'团长选择',
                'link'=>"sqtg_sun/pages/zkx/pages/nearleaders/nearleaders",
            ],
//            [
//                'name'=>'下单页',
//                'link'=>"sqtg_sun/pages/zkx/pages/classifyorder/classifyorder",
//            ],
//            [
//                'name'=>'我的优惠券',
//                'link'=>"sqtg_sun/pages/zkx/pages/mycoupons/mycoupons",
//            ],
//            [
//                'name'=>'支付成功',
//                'link'=>"sqtg_sun/pages/zkx/pages/ordersuccess/ordersuccess",
//            ],
            [
                'name'=>'我的订单',
                'link'=>"sqtg_sun/pages/public/pages/myorder/myorder",
                'parms'=>[
                    [
                        'name'=>'id',
                        'memo'=>'订单状态，0全部，1待支付，2待配送，3配送中，4待自提，5已完成，6已取消',
                        'required'=>false,
                    ],
                ]
            ],
//            [
//                'name'=>'我的订单详情',
//                'link'=>"sqtg_sun/pages/zkx/pages/myorderdetail/myorderdetail",
//                'parms'=>[
//                    [
//                        'name'=>'id',
//                        'memo'=>'订单id',
//                        'required'=>true,
//                    ],
//                ]
//            ],
//            [
//                'name'=>'商品购买用户',
//                'link'=>"sqtg_sun/pages/zkx/pages/memberlist/memberlist",
//            ],
            [
                'name'=>'分销中心',
                'link'=>"sqtg_sun/pages/plugindistribution/distributioncenter/distributioncenter",
            ],
            [
                'name'=>'分销团队',
                'link'=>"sqtg_sun/pages/plugindistribution/withdrawalteam/withdrawalteam",
            ],
            [
                'name'=>'分销订单',
                'link'=>"sqtg_sun/pages/plugindistribution/orders/orders",
                'parms'=>[
                    [
                        'name'=>'id',
                        'memo'=>'订单状态，0全部，1待付款，2待配送，3配送中，4待自提，5已完成',
                        'required'=>false,
                    ],
                ]
            ],
            [
                'name'=>'分销佣金',
                'link'=>"sqtg_sun/pages/plugindistribution/commission/commission",
            ],
            [
                'name'=>'分销提现',
                'link'=>"sqtg_sun/pages/plugindistribution/withdrawal/withdrawal",
            ],
            [
                'name'=>'提现明细',
                'link'=>"sqtg_sun/pages/plugindistribution/withdrawallist/withdrawallist",
            ],
            [
                'name'=>'拼团列表',
                'link'=>"sqtg_sun/pages/plugin/spell/list/list",
            ],
            [
                'name'=>'拼团详情页面',
                'link'=>"sqtg_sun/pages/plugin/spell/info/info",
                'parms'=>[
                    [
                        'name'=>'id',
                        'memo'=>'商品id-团id-用户id-团长id ,若团id为0代表用户是自己点入该商品',
                        'required'=>true,
                    ],
                ]
            ],
        ];
        return view();
    }
    public function apiset(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $zny_auth=$this->getZnyAuth();
        $this->view->info = $info;
        $this->view->zny_auth = $zny_auth;
        return view('apiset');
    }
    public function getZnyAuth(){
        $info = $this->model->get_curr();
        if($info['zny_apid']&&$info['zny_apikey']){
            $url='https://api.znymall.cn/index.php?s=/api/Openapi/getApiInfo';
            $new=new Cwx();
            $data['apid']=$info['zny_apid'];
            $data['apikey']=$info['zny_apikey'];
            $res=$new ->https_request($url,$data);
            $return_data=json_decode($res,true);
            $zny_auth=0;
            if($return_data['code']==0){
                if($return_data['data']['shop_id']>0){
                    $zny_auth=1;
                }
                if($return_data['data']['uid']>0){
                    $zny_auth=2;
                }
            }
        }else{
            $zny_auth=-1;
        }
        return $zny_auth;
    }
}
