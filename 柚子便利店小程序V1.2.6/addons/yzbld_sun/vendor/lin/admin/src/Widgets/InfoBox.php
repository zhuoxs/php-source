<?php

namespace Encore\Admin\Widgets;

use Encore\Admin\Renderable;
use Encore\Admin\Template;

class InfoBox extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'widgets/info-box';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * InfoBox constructor.
     *
     * @param string $name
     * @param string $icon
     * @param string $color
     * @param string $link
     * @param string $info
     */
    public function __construct($name, $icon, $color, $link, $info)
    {
        $this->data = [
            'name' => $name,
            'icon' => $icon,
            'link' => $link,
            'info' => $info,
        ];

        $this->class("small-box bg-$color");
    }

    /**
     * @return string
     */
    public function render()
    {
        $variables = array_merge($this->data, ['attributes' => $this->formatAttributes()]);

        return Template::view($this->view,$variables);
    }
}
