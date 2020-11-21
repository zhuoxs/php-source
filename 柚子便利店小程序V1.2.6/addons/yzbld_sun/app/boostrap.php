<?php
namespace App;

use App\Http\Extensions\Column\ExpandRow;
use Encore\Admin\Grid\Column;

\Encore\Admin\Session::start();
\Encore\Admin\Admin::bootstrap();
//\Encore\Admin\Form::extend("dateCycle",\App\Http\Extensions\Form\DateCycle::class);
Column::extend('expand', ExpandRow::class);