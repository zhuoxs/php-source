<?php

namespace App\Http\Controllers;

use App\Model\SystemInfo;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class TechController extends Controller
{
    protected $header = '技术支持';

    public function grid()
    {
        return $this->admin->grid(SystemInfo::class, function (Grid $grid) {
            $grid->column('id', 'id');
            $grid->disablePagination();
        });
    }

    public function form($id = null)
    {

        return $this->admin->form(SystemInfo::class, function (Form $form) use ($id) {
            $form->text('tech_title', '技术支持名称');
            $form->text('tech_phone', '技术支持电话');
            $form->image('tech_img', '技术支持图标')->help('建议尺寸:64*64');
            $form->switch('tech_is_show', '技术支持是否显示?')
                ->states($this->getStateList())->setDefault(true);
            $form->tools(function (Form\Tools $tools){
                $tools->disableBackButton();
            });
            $form->setAction(Url::update('tech', $id));
            $form->saved(function (Form $form) use($id){
                admin_toastr(trans('admin.update_succeeded'));
                return redirect(Url::show('tech', $id));
            });
        });
    }
}
