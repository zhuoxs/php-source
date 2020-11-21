<?php

namespace Encore\Admin\Widgets;


use Encore\Admin\Renderable;
use Encore\Admin\Template;

class Collapse extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'widgets/collapse';

    /**
     * @var array
     */
    protected $items = [];

    /**
     * Collapse constructor.
     */
    public function __construct()
    {
        $this->id('accordion-'.uniqid());
        $this->class('box-group');
        $this->style('margin-bottom: 20px');
    }

    /**
     * Add item.
     *
     * @param string $title
     * @param string $content
     *
     * @return $this
     */
    public function add($title, $content)
    {
        $this->items[] = [
            'title'   => $title,
            'content' => $content,
        ];

        return $this;
    }

    protected function variables()
    {
        return [
            'id'         => $this->id,
            'items'      => $this->items,
            'attributes' => $this->formatAttributes(),
        ];
    }

    /**
     * Render Collapse.
     *
     * @return string
     */
    public function render()
    {
        return Template::view($this->view, $this->variables());
    }
}
