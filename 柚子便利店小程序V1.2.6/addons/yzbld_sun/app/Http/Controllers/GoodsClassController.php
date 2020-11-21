<?php

namespace App\Http\Controllers;

use App\Model\GoodsClass;
use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Url;
use Encore\Admin\Widgets\Box;

class GoodsClassController extends Controller
{
    protected $header = '商品分类';

    public function index()
    {
        return $this->admin->content(function (Content $content) {
            $content->header($this->header);
            $content->description('列表');

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(Url::store('goods_class'));
                    $form->disablePjax();
                    $form->text('title', '名称')->addRequired();
                    $form->select('parent_id', '父类')->options(
                        GoodsClass::selectOptions())->addRequired();
                    $form->text('remark', '备注');

                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });
            });
        });
    }

    public function treeView()
    {
        return GoodsClass::tree(function (Tree $tree) {
            $tree->branch(function ($branch) {
                $str = sprintf('%s', $branch['title']);

                return $str;
            });
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(GoodsClass::class, function (Form $form) use ($id) {
            $form->text('title', '名称')->addRequired();
            $form->select('parent_id', '父类')->options(
                GoodsClass::selectOptions())->addRequired();
            $form->text('remark', '备注');
            /* $form->number('order', '排序')->setDefault(
                 GoodsClass::instance()->max('order') + 1
             )->help("数字越小，排序靠前");*/
        });
    }
}
