<?php

namespace Encore\Admin\Widgets\Chart;

use Encore\Admin\Admin;
use Encore\Admin\Renderable;
use Encore\Admin\Template;
use Encore\Admin\Widgets\Widget;

class Chart extends Widget implements Renderable
{
    protected $elementId = '';

    protected $options = [];

    protected $data = [];

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function makeElementId()
    {
        return 'chart_'.str_replace('.', '', uniqid('', true));
    }

    public static function color($color = '')
    {
        $colors = ['#dd4b39', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'];

        return $color ? $color : $colors[array_rand($colors)];

        //sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function options($options = [])
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @param $data
     *
     * @deprecated
     */
    public function data($data)
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        $this->data = $data;
    }

    public function render()
    {
        $this->elementId = $this->makeElementId();

        Admin::script($this->script());

        return Template::view("widgets/chart",['id' => $this->elementId]);

        //return view('admin::widgets.chart', ['id' => $this->elementId])->render();
    }
}
