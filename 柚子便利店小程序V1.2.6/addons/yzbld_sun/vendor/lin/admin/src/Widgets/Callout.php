<?php

namespace Encore\Admin\Widgets;

use Encore\Admin\Renderable;
use Encore\Admin\Template;

class Callout extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'widgets/callout';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var string
     */
    protected $style = 'danger';

    /**
     * Callout constructor.
     *
     * @param string $content
     * @param string $title
     * @param string $style
     */
    public function __construct($content, $title = '', $style = 'danger')
    {
        $this->content = (string) $content;

        $this->title = $title;

        $this->style($style);
    }

    /**
     * Add style to Callout.
     *
     * @param string $style
     *
     * @return $this
     */
    public function style($style = 'info')
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return array
     */
    protected function variables()
    {
        $this->class("callout callout-{$this->style}");

        return [
            'title'      => $this->title,
            'content'    => $this->content,
            'attributes' => $this->formatAttributes(),
        ];
    }

    /**
     * Render Callout.
     *
     * @return string
     */
    public function render()
    {
        return Template::view($this->view,$this->variables());

    }
}
