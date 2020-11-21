<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class Button extends Field
{
    protected $elementClass = ['btn-primary'];

    public function info()
    {
        $this->elementClass = ['btn-info'];

        return $this;
    }

    public function on($event, $callback)
    {
        $this->script = <<<EOT

        $('{$this->getElementClassSelector()}').on('$event', function() {
            $callback
        });

EOT;
    }
}
