<?php

namespace Encore\Admin\Form\Field;

use Closure;
use Encore\Admin\Form\Field;

class Display extends Field
{
    protected $callback;

    public function with(Closure $callback)
    {
        $this->callback = $callback;
    }

    public function render()
    {
        if ($this->callback instanceof Closure) {

            $class = $this->callback->bindTo($this->form->model());
            $this->value = call_user_func($class,$this->value);
            //$this->value = $this->callback->call($this->form->model(), $this->value);
        }

        return parent::render();
    }
}
