<?php

namespace App\Http\Controllers;

use App\Http\Extensions\Tools\StoreSelect;
use App\Model\DisOrder;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\Store;
use App\Model\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Url;
use Encore\Admin\Widgets\Table;

class OrderController extends Controller
{
    protected $header = '订单';

    public function grid()
    {
        return $this->admin->grid(Order::class, function (Grid $grid) {
            $store_id = isset($_REQUEST['store_id']) ? $_REQUEST['store_id'] :
                0;
            if (0 == intval($store_id)) {
                unset($_REQUEST['store_id']);
                $grid->model()->orderBy("id","desc");
            } else {
                $grid->model()->orderBy("id","desc")->where('store_id', $store_id);
            }
            $grid->column('id', 'id');
            $grid->column('sn', '订单号');
           /* $grid->column('user_id', '用户')->display(function ($user_id) {
                return User::instance()->find($user_id)->name;
            });*/

            $grid->column('address',"收货信息")->display(function ($address){
               if(!empty($address)){
                   $address = json_decode($address,true);
                   $text = $address["userName"]."&nbsp;&nbsp;".$address["telNumber"]."<br>";
                   $text .= $address["countyName"].$address["detailInfo"];
                   return $text;
               }
               return $address;
            });
            $grid->column('store_id', '门店')->display(function ($store_id) {
                return (new Store())->find($store_id)->name;
            });

            $grid->column('status', '状态')->display(function ($status) {
                $status_list = [
                    -10 => '已删除',
                    10 => '待支付',
                    20 => '待发货',
                    30 => '待收货',
                    40 => '已完成',
                    50 => '已取消',
                ];
                $label_list = [
                    -10 => 'danger',
                    10 => 'info',
                    20 => 'primary',
                    30 => 'primary',
                    40 => 'success',
                    50 => 'warning',
                ];

                return "<span class='label label-".$label_list[$status]."'>".$status_list[$status]."</span>";//$status_list[$status];
            });
            $grid->column('amount', '总金额');
            $grid->column('distribution_type', '配送方式')->display(function ($distribution_type) {
                return 0 == $distribution_type ? '<span class="label label-primary">送货上门</span>' : '<span class="label label-success">自提</span>';
            });
            $grid->column("dis","派送")->display(function (){
                if($this->distribution_type ==0 && $this->status == 20)
                {
                    $count = DisOrder::instance()->where("order_sn",$this->sn)->count();
                    if($count == 0){
                        $url =  Url::setDoAndOp('order','dis_from',$this->id);
                        return '<a href="'.$url.'">外配</a>';
                    }
                    else{
                        return "已外派";
                    }

                }
                else
                {
                    return "";
                }

            });
            $grid->column('take_info', '自提信息')->display(function (){
                if($this->distribution_type ==1){
                    $str = sprintf("<i class='fa fa-clock-o'><span style='margin-left: 5px;'>%s</span></i><br>
<i class='fa fa-phone'><span style='margin-left: 5px;'>%s</span></i>",
                        $this->take_time,$this->take_tel);
                    return $str;
                }
                return "";

            });
            $grid->column("created_at","下单时间")->display(function ($created_at){
                return date('m-d H:i',strtotime($created_at));
            });
            $grid->column('remark', '备注');
            $grid->column('expand',"订单详情")->expand(function () {

                $order_sn =$this->sn;
                $order_sub = OrderGoods::instance()->where("order_sn",$order_sn)
                    ->get(["goods_name","num","goods_price","buy_type"])
                    ->toArray();
                foreach ($order_sub as &$item)
                {
                    $buy_type_list = ["","限时抢购","每日秒杀"];
                    $item["buy_type"] = $buy_type_list[$item["buy_type"]];
                }
                $header = ["商品名称","数量","金额","活动"];
                return new Table($header, $order_sub);

            }, '详情');

            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->tools(function (Grid\Tools $tools){
                $tools->disableBatchActions();
            });
            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();

                $filter->equal('store_id', '门店')->select(
                    Store::instance()->pluck('name', 'id')->toArray());
                $status_list = [
                    10 => '待支付',
                    20 => '待发货',
                    40 => '已完成',
                    50 => '已取消',
                ];
                $filter->equal('status', '状态')->select(
                    $status_list);
            });
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(new StoreSelect());
            });
            $grid->column('oprate','操作')->display(function(){
                if($this->status == 20){
                    $url =  Url::setDoAndOp('order','receive',$this->id);
                    return '<a href="'.$url.'">收货</a>';
                }else{
                    return "";
                }
            });
        });
    }

   /* public function form($id = null)
    {
        return $this->admin->form(Order::class, function (Form $form) use ($id) {
        });
    }*/

    public function dis_from_ex($id = null)
    {
        return $this->admin->form(Order::class, function (Form $form) use ($id) {

            $form->display('sn', '订单');
            $form->display('store_id', '门店')->with(function ($store_id){
                return Store::instance()->find($store_id)->name;
            });
            $form->display('address', '收货地址')->with(function ($address){

                if(!empty($address)){
                    $address = json_decode($address,true);
                    $text = $address["countyName"].$address["detailInfo"];
                    return $text;
                }
                return $address;
            });
            $form->currency('distribution_amount', '配送费')->help("默认为系统配送费");
            $form->setAction(Url::setDoAndOp('order','post_dis',$_REQUEST["id"]));
        });
    }

    /**
     * 编辑界面.
     * @return Content
     */
    public function dis_from()
    {
        $id = $_REQUEST["id"];
        return $this->admin->content(function (Content $content) use ($id) {
            $content->header("外派配送订单");
            $content->description('');

            $content->body($this->dis_from_ex($id)->edit($id));
        });
    }
    public function post_dis()
    {
        $id = $_REQUEST["id"];
        $dis_amount = $_REQUEST["distribution_amount"];
        $order = Order::instance()->find($id);

        $disOrder = DisOrder::instance()->where("order_sn",$order->sn)->first();
        if(!$disOrder)
        {
            $disOrder = DisOrder::instance();
            $disOrder->store_id = $order->store_id;
            $disOrder->dis_amount = $dis_amount;
            $disOrder->order_sn = $order->sn;
            $disOrder->save();
        }

       return redirect(Url::index('dis_order'));
    }
    /**
     * 收货界面
     */
    public function receive(){
        $id = $_REQUEST["id"];
        return $this->admin->content(function (Content $content) use ($id) {
            $content->header("用户确认收货");
            $content->description('');

            $content->body($this->receive_ex($id)->edit($id));
        });
    }
    public function receive_ex($id = null){
        return $this->admin->form(Order::class,function(Form $form)use($id){
            $form->display('sn','订单');
            $form->display('store_id','门店')->with(function($store_id){
                return Store::instance()->find($store_id)->name;
            });
            $form->display('address', '收货地址')->with(function ($address){

                if(!empty($address)){
                    $address = json_decode($address,true);
                    $text = $address["countyName"].$address["detailInfo"];
                    return $text;
                }
                return $address;
            });
            $form->setAction(Url::setDoAndOp('order','post_receive',$_REQUEST["id"]));
        });
    }
    public function post_receive(){
        $id = $_REQUEST["id"];
        $order = Order::instance()->find($id);
        if ($order&&$order->status !=40 ) {
            $order->status = 40;
            $order->save();
            $disorder = \App\Model\DisOrder::instance()->where("order_sn", $order->sn)
                ->first();
            if($disorder->order_sn){
                $disorder->status = 30;
                $disorder->save();
                $this->changeDisAmount($disorder->dis_user_id, 0, "配送进帐", $disorder->dis_amount, $order->sn);
            }
        }
        return redirect(Url::index('order'));
    }
    private function changeDisAmount($dis_user_id, $type, $name, $amount, $remark = "")
    {
        $dis_amount_log = \App\Model\DisAmountLog::instance();
        $dis_amount_log->dis_user_id = $dis_user_id;
        $dis_amount_log->type = $type;
        $dis_amount_log->name = $name;
        $dis_amount_log->amount = $amount;
        $dis_amount_log->remark = $remark;
        $dis_amount_log->save();
        $user = \App\Model\User::instance()->find($dis_user_id);
        $user->dis_amount += floatval($amount);
        $user->save();
    }
}
