<?php

namespace App\Http\Controllers;

use App\Model\Distribution;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class DistributionController extends Controller
{
    protected $header = '配送费';

    public function grid()
    {
        return $this->admin->grid(Distribution::class, function (Grid $grid) {
            $grid->column('id', 'id');
            $grid->column('range', '范围')->display(function () {
                if (0 == $this->end) {
                    return $this->start.'公里以上';
                }

                return $this->start.'公里 至 '.$this->end.'公里';
            });
            $grid->column('cost', '配送费')->display(function ($cost) {
                return '<b>￥</b>'.$cost;
            });
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(Distribution::class, function (Form $form) use ($id) {
            $form->number('start', '(距离公里)从');
            $form->number('end', '到')->help('0表示xx公里以上');
            $form->currency('cost', '配送费');
            $form->text('remark', '备注');
        });
    }
}
