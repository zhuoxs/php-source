<?php

namespace App\Http\Controllers;

use App\Model\Announcement;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class AnnouncementController extends Controller
{
    protected $header = '公告';

    public function grid()
    {
        return $this->admin->grid(Announcement::class, function (Grid $grid) {
            $grid->model()->ordered();
            $grid->column('id', 'id');
            $grid->column('title', '标题');
            $grid->column("order","排序")->orderable();
            $grid->column('is_enable', '显示?')->switch($this->getStateList());
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(Announcement::class, function (Form $form) use ($id) {
            $form->text("title","标题")->addRequired();
            $form->switch('is_enable', '显示?')
                ->states($this->getStateList())->setDefault(true);
        });
    }
}
