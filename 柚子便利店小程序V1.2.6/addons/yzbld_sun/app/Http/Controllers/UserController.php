<?php

namespace App\Http\Controllers;

use App\Model\Store;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use App\Model\User;
use Encore\Admin\Url;

class UserController extends Controller
{
    protected $header = '会员';

    public function grid()
    {
        return $this->admin->grid(User::class, function (Grid $grid) {
            $grid->model()->orderBy("id","desc");
            $grid->column('id', 'id');
            $grid->column('openid', 'openid');
            $grid->column('name', '昵称');
            $grid->column('email', '邮箱');
            $grid->column('phone', '手机号');
            $grid->column("amount","余额")->display(function ($amount){
                $url = Url::generate("recharge_log","create",["user_id"=>$this->id]);
                return $amount."<a href='$url'>充值</a>";
            })->sortable();
            $grid->column('is_distribution', '配送员?')->switch($this->getStateList());
            $options = Store::instance()->orderBy("id","asc")->pluck("name","id");
            $options->prepend("无",0);

            $grid->column('is_admin', '分店管理员')->editable('select', $options);
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->tools(function (Grid\Tools $tools){
                $tools->disableBatchActions();
            });
            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->like('name','昵称')->placeholder("支持模糊搜索");
                $filter->equal('is_distribution',"配送员?")->radio([
                    0 => '否',
                    1 => '是',
                ]);
            });
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(User::class, function (Form $form) use ($id) {
             $form->text('name','昵称');
             $form->email('email','邮箱');
             $form->text("phone","手机号");
             $form->image("avatar","头像");
             $form->select("gender","性别")->options([
                 0=>"男",1=>"女"
             ]);
            $form->switch('is_distribution', '配送员?')
                ->states($this->getStateList())->setDefault(true);

            $options = Store::instance()->orderBy("id","asc")->pluck("name","id");
            $options->prepend("无",0);
            $form->select("is_admin","分店管理员")->options($options);
        });
    }
}
