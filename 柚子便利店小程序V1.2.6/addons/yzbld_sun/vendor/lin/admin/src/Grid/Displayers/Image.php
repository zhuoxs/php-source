<?php

namespace Encore\Admin\Grid\Displayers;


use Encore\Admin\Config;
use Illuminate\Contracts\Support\Arrayable;

class Image extends AbstractDisplayer
{
    public function display($server = '', $width = 200, $height = 200)
    {
          if ($this->value instanceof Arrayable) {
              $this->value = $this->value->toArray();
          }

        return collect((array) $this->value)->filter()->map(function ($path) use ($server, $width, $height) {
              if (isValidUrl($path)) {
                  $src = $path;
              } elseif ($server) {
                  $src = $server.$path;
              } else {
                  $src = Config::get("uploadUrl","/").$path;
              }


            return "<img src='$src' style='max-width:{$width}px;max-height:{$height}px' class='img img-thumbnail' />";
        })->implode('&nbsp;');
    }
}
