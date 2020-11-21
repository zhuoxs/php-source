<?php

namespace App\Http\Controllers;

use App\Model\City;
use App\Model\County;
use App\Model\Province;
use App\Model\Store;
use App\Model\SystemInfo;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class StoreController extends Controller
{
    protected $header = '门店';

    public function grid()
    {
        return $this->admin->grid(Store::class, function (Grid $grid) {
            $grid->model()->orderBy("id","desc");
            $grid->column('id', 'id');
            $grid->column('name', '名称');
            $grid->column('address', '地址');
            $grid->column('main_image', '店铺图')->image(null, 250, 100);
            $grid->column('is_enable', '启用?')->switch($this->getStateList());
            //  $grid->disablePagination();
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(Store::class, function (Form $form) use ($id) {
            $form->tab('基本信息', function (Form $form) {
                $form->text('name', '名称')->rules('required');

                $form->select('province_id', '省份')->options(
                    (new Province())->pluck('name', 'id')
                )->load('city_id', Url::generate('address', 'city'))->rules('required');

                $form->select('city_id', '市区')
                    ->options(function ($city_id) use ($form) {
                        $province_id = $form->model()->province_id;

                        return (new City())->where('province_id', $province_id)->pluck('name', 'id');
                    }
                    )
                    ->load('county_id', Url::generate('address', 'county'))->rules('required');

                $form->select('county_id', '县')
                    ->options(function ($county_id) use ($form) {
                        $city_id = $form->model()->city_id;

                        return (new County())->where('city_id', $city_id)->pluck('name', 'id');
                    }
                    )
                    ->rules('required');

                $form->text('address', '门店地址')->rules('required');
                $script = <<<EOT
    console.log("button click");
   if($('.province_id').select2('data').length == 0 
   || $('.city_id').select2('data').length == 0 
   || $('.county_id').select2('data').length == 0 
   || $('.address').val().length == 0 )
   {
   console.log("地址不能为空");
   return ;
   }
var province = $('.province_id').select2('data')[0].text;
var city = $('.city_id').select2('data')[0].text;
var county = $('.county_id').select2('data')[0].text;
var address = $('.address').val();

address = province + city + county + address;
console.log(address);
geocoder = new qq.maps.Geocoder();
geocoder.getLocation(address);
//设置服务请求成功的回调函数
geocoder.setComplete(function(result) {
    g_map.setCenter(result.detail.location);
    g_marker.setPosition(result.detail.location);
});
//若服务请求失败，则运行以下函数
geocoder.setError(function() {
    alert("出错了，请输入正确的地址！！！");
});
EOT;
                $systemInfo = SystemInfo::instance()->first();
                $map_key = $systemInfo->map_key;
                $systemInfo_url = Url::show('system_info',$systemInfo->id);

                $help = "若没配置腾讯地图请求,请<a href='".$systemInfo_url."'>配置key</a>";
                $form->button('button', '定位')->on('click', $script);

                $form->map('latitude', 'longitude', '地图',$map_key)->help($help);
                $form->switch('is_enable', '启用?')
                    ->states($this->getStateList())->setDefault(true);
                $form->number('dis_amount_limit', '免配送费的消费金额');
                $form->number('min_consume', '最低消费金额');
                $form->switch('auto_dis', '自动外派配送?')
                    ->states($this->getStateList())->setDefault(false)
                    ->help("启用时,用户需送货上门的订单支付后,该订单会自动进入配送订单列表.默认不启用.");
                $form->number('min_dist_amount', '自动外派最低配送费')
                    ->help("当用户订单达到免配送费的金额时,自动外派配送费为该金额.");
            })->tab('详细信息', function (Form $form) {
                $form->text('phone', '电话');
                $form->email('email', '邮箱');
                $form->image('main_image', '店铺图')->help('建议尺寸:750*375');
                $form->editor('content', '详情');
            })->tab('打印配置', function (Form $form) {
                $form->switch('enable_printer', '启用打印?')
                    ->states($this->getStateList())->setDefault(false);
                $form->text('printer_user', '注册账号')->help("飞鹅云后台注册账号");
                $form->text('printer_ukey', 'UKEY')->help("飞鹅云注册账号后生成的UKEY");
                $form->text('printer_sn', '打印机编号')->help("打印机编号");
            })->tab('营业时间', function (Form $form) use($id){
                $open_start = "00:00:00";
                $open_end = "00:00:00";
                if($id != null){
                    $obj = Store::instance()->find($id);
                    if(!is_null($obj->open_start)){
                        $open_start = date("H:i:s",strtotime($obj->open_start));
                        $open_end = date("H:i:s",strtotime($obj->open_end));
                    }

                }
                //$form->time("open_start","开始时间")->setFormat("HH:mm")->value($open_start);
                //$form->time("open_end","结束时间")->setFormat("HH:mm")->value($open_end)->help("用户只能在营业时间内下单");

                $form->timeRange('open_start','open_end','营业时间')
                    ->setFormat("HH:mm")->value(["start"=>$open_start,"end"=>$open_end])
                    ->help("用户只能在营业时间内下单");
            })->saving(function (Form $form) use($id){
                //debug("start:".$form->open_start.",end:".$form->open_end);
                if(strlen($form->open_start) > 0){
                    $form->open_start = "2018-01-01 ".$form->open_start.":00";
                    $form->open_end = "2018-01-01 ".$form->open_end.":00";
                }

            });
        });
    }
}
