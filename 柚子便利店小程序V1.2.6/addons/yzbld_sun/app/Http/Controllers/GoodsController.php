<?php

namespace App\Http\Controllers;

use App\Model\Goods;
use App\Model\GoodsClass;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class GoodsController extends Controller
{
    protected $header = '商品';

    public function grid()
    {
        return $this->admin->grid(Goods::class, function (Grid $grid) {
            $grid->model()->ordered();
            $grid->column('id', 'id');
            $grid->column('name', '名称');
            $grid->column('goods_class_id', '分类')->display(function ($goods_class_id) {
                return GoodsClass::instance()->find($goods_class_id)->title;
            });
            $grid->column('specification', '规格');
            $grid->column('shop_price', '商城价')->display(function ($shop_price) {
                return '<b>￥</b>'.$shop_price;
            });
            $grid->column('main_image', '商品图')->image(null, 100, 100);
            $grid->column('order', '排序')->orderable();
            $grid->column('is_enable', '上架?')->switch($this->getStateList());
            $grid->filter(function (Grid\Filter $filter){
                $filter->disableIdFilter();
                $filter->like("name","名称")->placeholder("模糊搜索");
            });
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(Goods::class, function (Form $form) use ($id) {
            $form->text('name', '名称')->addRequired();

            $form->select('goods_class_id', '分类')->options(
                GoodsClass::selectOptions()
            )->addRequired();
            $form->text('code', '编号');
            $form->text('barcode', '条形码');
            $form->text('specification', '规格');
            $form->currency('shop_price', '商城价')->addRequired();
            $form->image('main_image', '商品图')->help('建议尺寸:400*400');
            $form->multipleImage('images', '轮播图')->removable()->help('可以上传多图;建议尺寸:750*420');
            $form->editor('content', '详情')->addRequired();
            $form->switch('is_enable', '上架?')
                ->states($this->getStateList())->setDefault(true);
        });
    }
}
