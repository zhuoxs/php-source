<?php
namespace App\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
class GoodsClass extends Model
{
    use OrderTrait;
    use ModelTree, AdminBuilder;

}
