<?php

namespace App\Http\Controllers;

use App\Model\SecKillActivity;
use App\Model\Store;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class SecKillActivityController extends Controller
{
    protected $header = '每日秒杀';

    public function grid()
    {
        return $this->admin->grid(SecKillActivity::class, function (Grid $grid) {
            $grid->column('id');
            $grid->column('store_id', '门店')->display(function ($store_id) {
                return Store::instance()->find($store_id)->name;
            });
            $grid->column('name', '活动名称');
            $grid->column('begin_at', '开始时间')->display(function ($begin_at) {
                return date('Y-m-d', strtotime($begin_at));
            });
            $grid->column('end_at', '结束时间')->display(function ($end_at) {
                return date('Y-m-d', strtotime($end_at));
            });
            $grid->column('status', '状态')->display(function ($status) {
                return 0 == $status ? '未投放' : '已投放';
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                // 获取当前行主键值
                $id = $actions->getKey();
                $status = SecKillActivity::instance()->find($id)->status;
                if($status == 0)
                {
                    $url =  Url::generate('sec_kill_activity','changeStatus',
                        ["id"=>$id,"status"=>1]);
                    $actions->append('&nbsp;&nbsp;&nbsp;<a href="'.$url.'">投放活动</a>');

                }
                else
                {
                   /* $actions->disableEdit();
                    $actions->disableDelete();*/
                    $url =  Url::generate('sec_kill_activity','changeStatus',
                        ["id"=>$id,"status"=>0]);
                    $actions->append('&nbsp;&nbsp;&nbsp;<a href="'.$url.'">关闭活动</a>');

                }
            });
        });
    }

    public function form($id = null)
    {
        //dd(SecKillActivity::instance()->find(2)->times);
        return $this->admin->form(SecKillActivity::class, function (Form $form) use ($id) {
            $form->text('name', '活动名称')->rules('required');

            $form->select('store_id', '门店')->options(
                Store::instance()->pluck('name', 'id')
            );
            $form->datetimeRange('begin_at', 'end_at', '活动时间')->setFormat('YYYY-MM-DD HH:mm');
            for ($i=1; $i <= 24; ++$i) {
                $options[$i] = sprintf("%02d", $i);
            }
            $form->multipleSelect("times","有效时钟")->options($options);
            $form->text('remark', '备注');
        });
    }

    public function changeStatus()
    {
        $id = $_REQUEST["id"];
        $status = $_REQUEST["status"];
        $activity = SecKillActivity::instance()->find($id);
        $activity->status = $status;
        $activity->save();
        if($status == 0){
            admin_toastr('已关闭活动');
        }
        else{
            admin_toastr('已投放活动');

        }
        return redirect(Url::index("sec_kill_activity"));

    }
}
