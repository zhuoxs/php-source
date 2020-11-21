<?php

namespace App\Http\Controllers;

use App\Http\Extensions\Tools\StoreSelect;
use App\Model\Goods;
use App\Model\Store;
use App\Model\StoreGoods;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Url;

class StoreGoodsController extends Controller
{
    protected $header = '门店商品';

    public function grid()
    {
        return $this->admin->grid(StoreGoods::class, function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');
            $store_id = isset($_REQUEST['store_id']) ? $_REQUEST['store_id'] :
                0;
            if (0 == intval($store_id)) {
                unset($_REQUEST['store_id']);
            }
            $keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] :
                "";

            if(empty($keyword)){

            }else{
                $goods_id_list = Goods::instance()->where("name","like","%$keyword%")
                    ->pluck("id")->toArray();
                $grid->model()->where("goods_id","in",$goods_id_list);
            }



            $grid->column('id');
            $grid->column('store_id', '门店')->display(function ($store_id) {
                return Store::instance()->find($store_id)->name;
            });
            $grid->column('goods_id', '商品')->display(function ($goods_id) {
                return Goods::instance()->find($goods_id)->name;
            });
            $grid->column('shop_price', '商城价')->editable();
            $grid->column('stock', '库存')->display(function ($stock){
                return $stock == -1 ? "不限" :$stock;
            })->sortable();

            $grid->column('is_new', '新品推荐?')->switch($this->getStateList());
            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();

                $filter->equal('store_id', '门店')->select(
                    Store::instance()->pluck('name', 'id')->toArray());


            });
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(new StoreSelect());
                $url = Url::generate("store_goods","batchAdd");
                $tools->append("<a class='btn btn-info' no-pjax href='".$url."' style='margin-left: 10px'><i class='fa fa-plus'></i>批量添加</a>");
                $html = <<<HTML
<form class="form-inline"  METHOD="get" style="display: inline-block;
    margin-left: 10px;">
 <div class="input-group">
      <input type="text" class="form-control" id="keyword" name="keyword" value="" placeholder="商品模糊搜索">
      <span class="input-group-btn">
        <button class="btn btn-success" type="button" onclick="query_goods()">搜索</button>
      </span>
</form>
<script>
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
// 替换参数
function replaceUrlParamVal(url, paramName, replaceWith) {
    var re = eval('/('+ paramName+'=)([^&]*)/gi');
    var nUrl = url.replace(re,paramName+'='+replaceWith);
    return nUrl;
}
var keyword=getQueryVariable("keyword");
document.getElementById("keyword").value =keyword ? decodeURI(keyword) : "";
function query_goods()
{
   var url = window.location.href;
   if(getQueryVariable("keyword")){
          url = replaceUrlParamVal(url,"keyword",document.getElementById("keyword").value);
   }else{
          url = url +  "&keyword=" + document.getElementById("keyword").value;
   }
   window.location.href = url;
}
</script>
HTML;
                $tools->append($html);
            });
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(StoreGoods::class, function (Form $form) use ($id) {
            $form->select('store_id', '门店')->options(
                Store::instance()->pluck('name', 'id'))->addRequired();
            $form->select('goods_id', '商品')->options(
                Goods::instance()->where('is_enable', true)->pluck('name', 'id'))->addRequired();
            $form->currency('shop_price', '商城价')->addRequired();
            $form->number('stock', '库存量')->setDefault(-1)->help("-1表示不限");
            $form->switch('is_new', '新品推荐?')
                ->states($this->getStateList())->setDefault(true);
        });
    }

    public function batchAdd()
    {
        return $this->admin->content(function (Content $content) {
            $content->header("批量添加");
            $content->description('');

            $content->body($this->batchAdd_form());
        });
    }

    public function batchAdd_form($id = null)
    {
        return $this->admin->form(StoreGoods::class, function (Form $form) use ($id) {
            $form->select('store_id', '门店')->options(
                Store::instance()->pluck('name', 'id'))->addRequired();
            $form->multipleSelect('goods_id', '商品')->options(
                Goods::instance()->where('is_enable', true)->pluck('name', 'id'))
                ->help("可以多选,商品价格将以商品库中为准.批量添加后可单个再修改")->addRequired();
            $form->number('stock', '库存量')->setDefault(-1)->help("-1表示不限");
            $form->switch('is_new', '新品推荐?')
                ->states($this->getStateList())->setDefault(true);
            $form->setAction(Url::generate('store_goods','batch_store'));
            $form->saving(function (Form $form){
               $store_id = $form->store_id;
               $stock = $form->stock;
               $is_new = $form->is_new;
                $arr = $form->goods_id;
                foreach ($arr as $item){

                    if(!empty($item)){
                        $have = StoreGoods::instance()
                            ->where("store_id",$store_id)
                            ->where("goods_id",$item)
                            ->first();
                        if(!$have){
                            $store_goods = StoreGoods::instance();
                            $store_goods->store_id  = $store_id;
                            $store_goods->goods_id = $item;
                            $store_goods->shop_price = Goods::instance()->find($item)->shop_price;
                            $store_goods->is_new = $is_new == "on" ? 1 : 0;
                            $store_goods->stock = $stock;
                            $store_goods->save();
                        }

                    }

                }
                $url = Url::index("store_goods");
                return redirect($url);
            });
        });

    }

    /**
     * @return mixed
     */
    public function batch_store()
    {
        return $this->batchAdd_form($_REQUEST["id"])->store();
    }

}
