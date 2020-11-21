<?php

namespace Encore\Admin\Grid\Tools;

use Encore\Admin\Grid;
use Encore\Admin\Pagination\LengthAwarePaginator;
/*use Illuminate\Support\Facades\Input;*/

class Paginator extends AbstractTool
{

    protected $paginator = null;

    /**
     * Create a new Paginator instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;

        $this->initPaginator();
    }

    /**
     * Initialize work for Paginator.
     *
     * @return void
     */
    protected function initPaginator()
    {
       // $this->paginator = $this->grid->dbPaginator();
        $this->paginator = $this->grid->model()->eloquent();

        if ($this->paginator instanceof LengthAwarePaginator) {
            $this->paginator->appends($_REQUEST);
        }
    }

    /**
     * Get Pagination links.
     *
     * @return string
     */
    protected function paginationLinks()
    {
        return $this->paginator->render('pagination');
    }

    /**
     * Get per-page selector.
     *
     * @return PerPageSelector
     */
    protected function perPageSelector()
    {
        return new PerPageSelector($this->grid);
    }


    protected function paginationRanger()
    {
        $parameters = [
            'first' => $this->paginator->firstItem(),
            'last'  => $this->paginator->lastItem(),
            'total' => $this->paginator->total(),
        ];

        $parameters = collect($parameters)->flatMap(function ($parameter, $key) {
            return [$key => "<b>$parameter</b>"];
        });

        return sprintf("从 %s 到 %s ，总共 %s 条",
            $parameters["first"],$parameters["last"],$parameters["total"]);
    }

    /**
     * Render Paginator.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->usePagination()) {
            return '';
        }

        //可以选择每页多少条功能暂时关闭
        return $this->paginationRanger().
            $this->paginationLinks().
            $this->perPageSelector();
    }
}
