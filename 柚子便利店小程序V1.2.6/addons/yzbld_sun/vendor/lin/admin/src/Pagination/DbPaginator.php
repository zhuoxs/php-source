<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 13:53
 */

namespace Encore\Admin\Pagination;


use Encore\Admin\Pagination\LengthAwarePaginator;
use Encore\Admin\Template;

class DbPaginator extends LengthAwarePaginator
{

    public function render($template = null, $data = [])
    {
        $template = is_null($template) ? "pagination": $template;
        $data  = array_merge($data, [
            'elements' => $this->elements(),
            "onFirstPage"=>$this->onFirstPage(),
            "previousPageUrl"=>$this->previousPageUrl(),
            "hasMorePages"=>$this->hasMorePages(),
            "nextPageUrl"=>$this->nextPageUrl(),
            "currentPage"=>$this->currentPage(),
        ]);
        return Template::view($template,
            $data
        );
    }

   /* public function elements()
    {
       return [
           "1","2",["3"=>"#"]
       ];
    }*/
}