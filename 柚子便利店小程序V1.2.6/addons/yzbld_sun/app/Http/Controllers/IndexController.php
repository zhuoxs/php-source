<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 15:52.
 */

namespace App\Http\Controllers;

use App\Model\Announcement;
use App\Model\Banner;
use App\Model\BottomTab;
use App\Model\DisBanner;
use App\Model\Goods;
use App\Model\Nav;
use App\Model\Order;
use App\Model\Store;
use App\Model\SystemInfo;
use App\Model\User;
use Encore\Admin\Layout\Content;
use Encore\Admin\Url;
use Encore\Admin\Widgets\InfoBox;

class IndexController extends Controller
{
    protected $header = '首页';

    private function getTodayOrder()
    {
        $count = \App\Model\Order::instance()
            ->where("status",[20,30,40])
            ->where("date(pay_at)",date('Y-m-d'))
            ->count();
        return $count;
    }
    private function getNoDisOrder()
    {
        $count = \App\Model\DisOrder::instance()
            ->where("status",10)
            ->where("date(created_at)",date('Y-m-d'))
            ->count();
        return $count;
    }
    private function getDisOrder()
    {
        $count = \App\Model\DisOrder::instance()
            ->where("status",20)
            ->where("date(receive_at)",date('Y-m-d'))
            ->count();
        return $count;
    }

    private function getTodaySales()
    {
        $sum = \App\Model\Order::instance()
            ->where("status",[20,30,40])
            ->where("date(pay_at)",date('Y-m-d'))
            ->sum('pay_amount');
        return $sum;
    }
    private function getYesterdaySales()
    {
        $sum = \App\Model\Order::instance()
            ->where("status",[20,30,40])
            ->where("date(pay_at)",date('Y-m-d',strtotime('-1 days')))
            ->sum('pay_amount');
        return $sum;
    }
    private function getAllSales()
    {
        $sum = \App\Model\Order::instance()
            ->where("status",[20,30,40])
            ->sum('pay_amount');
        return $sum;
    }

    public function index()
    {


        $data = ["todayOrder"=>$this->getTodayOrder(),//今日订单数:(已发货+已完成)
                    "noDisOrder"=>$this->getNoDisOrder(),//待接单:(外派,未接单的)
                    "DisOrder"=>$this->getDisOrder(),//代配送:(正在配送的数量)

                    "todaySales"=>$this->getTodaySales(), //今日销售额
                    "yesterdaySales"=>$this->getYesterdaySales(), //昨日销售额
                    "allSales"=>$this->getAllSales(), //总销售额
        ];
        return $this->admin->content(function (Content $content) use($data){
            $content->header('平台数据');
            $content->description('');
            $content->row(function ($row) use($data){
                $html = <<<EOT
                <style>
                li {list-style-type:none;}
           .yg9_content{padding:0px;}
    .yg9_content>li>.col-md-12{
        height: 130px;
        box-shadow: 0px 0px 8px rgba(0,0,0,0.1);
        border-radius: 6px;
        overflow: hidden;
        margin: 10px 0;
    }    
    .yg9_content>li:nth-child(1)>.col-md-12{
        background-color: #32CC7F;
        color: white;
    }
    .yg9_content>li:nth-child(2)>.col-md-12{
        background-color: #f17c67;
        color: white;
    }
    .yg9_content>li:nth-child(3)>.col-md-12{
        background-color: #99CC33;
        color: white;
    }
    .yg9_content>li:nth-child(4)>.col-md-12{
        background-color: #6C6FBF;
        color: #fff;
    }
    .yg9_content>li:nth-child(5)>.col-md-12{
        background-color: #a958b9;
        color: #fff;
    }
    .tmoney{font-size: 26px;margin-top: 30px;text-align: center;}
    .today{font-size: 14px;text-align: center;}
</style>
    <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">订单</h3>
  </div>
  <div class="panel-body">
    <ul class="col-md-12 yg9_content" style="margin-bottom: 10px;">
                <li class="col-md-3" style="width: 250px;">
                    <div class="col-md-12">

                        <p class="tmoney">{$data["todayOrder"]}</p>
                        <p class="today">今日订单数</p>

                    </div>
                </li>
                <li class="col-md-3" style="width: 250px;">
                    <div class="col-md-12">

                        <p class="tmoney">{$data["noDisOrder"]}</p>
                        <p class="today">待接单</p>

                    </div>
                </li>
                <li class="col-md-3" style="width: 250px;">
                    <div class="col-md-12">

                        <p class="tmoney">{$data["DisOrder"]}</p>
                        <p class="today">待配送</p>

                    </div>
                </li>
            </ul>
  </div>
</div>
EOT;
                $row->column(6, $html);


                $html = <<<EOT
    <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">数据概况信息</h3>
  </div>
  <div class="panel-body">
    <ul class="col-md-12 yg9_content" style="margin-bottom: 10px;">
                <li class="col-md-3" style="width: 250px;">
                    <div class="col-md-12">

                        <p class="tmoney">¥&nbsp;{$data["todaySales"]}</p>
                        <p class="today">今日销售额</p>

                    </div>
                </li>
                <li class="col-md-3" style="width: 250px;">
                    <div class="col-md-12">

                        <p class="tmoney">¥&nbsp;{$data["yesterdaySales"]}</p>
                        <p class="today">昨日销售额</p>

                    </div>
                </li>
                <li class="col-md-3" style="width: 250px;">
                    <div class="col-md-12">

                        <p class="tmoney">¥&nbsp;{$data["allSales"]}</p>
                        <p class="today">总销售额</p>

                    </div>
                </li>
            </ul>
  </div>
</div>
EOT;
                $row->column(6, $html);
                /*$row->column(3, new InfoBox('门店数', 'book', 'aqua',
                    Url::index('store'), (new Store())->count()));
                $row->column(3, new InfoBox('商品数', 'file', 'green',
                    Url::index('goods'), (new Goods())->count()));
                $row->column(3, new InfoBox('会员数', 'users', 'yellow',
                    Url::index('user'), (new User())->count()));
                $row->column(3, new InfoBox('订单数', 'shopping-cart', 'red',
                    Url::index('order'), (new Order())->count()));*/
            });


        });
    }

    /**
     * 处理编辑器的上传图片
     */
    public function upload()
    {


        $targets = [];
        foreach ($_FILES as $key => $file) {
            //$targets[] = "/attachment/images/". $this->saveFile($file["name"], $file["tmp_name"]);
            $storage = \App\Lib\Storage::instance();
            if($storage->isEnable()){
                $pos = strrpos($file["name"], ".");
                $filename = md5(uniqid()) . '.' . substr($file["name"], $pos + 1);
                $res = $storage->upload($file["tmp_name"],$filename);
                if(!$res){
                    return exit("云存储失败,请检查配置参数");
                }
                $targets[] =  $storage->getUploadUrl().$filename;
            }else{
                $targets[] = "/attachment/images/". $this->saveFile($file["name"], $file["tmp_name"]);

            }
        }
        return exit(json_encode([
            "errno" => 0,
            "data" => $targets
        ]));
    }


    /**
     * 保存图片
     *
     * @param $name
     * @param $tmpFile
     * @return string
     */
    public function saveFile($name, $tmpFile)
    {
        $pos = strrpos($name, ".");
        $filename = md5(uniqid()) . '.' . substr($name, $pos + 1);
        $uploadFile = config("upload.file") . $filename;
        move_uploaded_file($tmpFile, $uploadFile);
        return $filename;
    }
}
