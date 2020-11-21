<?php

namespace App\Http\Controllers;

use App\Model\DisBanner;
use App\Model\Goods;
use App\Model\GoodsClass;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class DisBannerController extends Controller
{
    protected $header = '配送轮播图';

    public function grid()
    {
        return $this->admin->grid(DisBanner::class, function (Grid $grid) {
            $grid->model()->ordered();
            $grid->column('id', 'id');
            $grid->column('title', '标题');
            $grid->column('main_image', '图片')->image(null, 150, 70);
            $grid->column('action_type', '链接类型')->display(function ($action_type){
                return Controller::getActionType($action_type);
            });
            $grid->column('action', '链接')->display(function ($action) {
                return Controller::getAction($this->action_type,$action);
            });
            $grid->column('is_enable', '显示?')->switch($this->getStateList());
            $grid->column('order', '排序')->orderable();
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(DisBanner::class, function (Form $form) use ($id) {
            $form->text('title', '标题')->addRequired();
            $form->image('main_image', '图片')->help("建议尺寸:750*320");
            $form->select('action_type', '链接类型')
                ->options(['基本', '商品',"商品分类"])->setDefault(0)
                ->load('action',
                    Url::generate('api', 'getActionList'));
            if (null == $id) {
                $options = config('actions');
            } else {
                $action_type = DisBanner::instance()->find($id)->action_type;
                if($action_type == 0)
                {
                    $options = config('actions');
                }
                else if($action_type == 1)
                {
                    $options = Goods::instance()->where('is_enable', true)->pluck('name', 'id');
                }
                else
                {
                    $options = GoodsClass::instance()
                        ->where('is_enable', true)
                        ->where("parent_id",0)
                        ->pluck('title', 'id');
                }
            }
            $form->select('action', '链接')->options($options);
            $form->switch('is_enable', '显示?')
                ->states($this->getStateList())->setDefault(true);
        });
    }
}
