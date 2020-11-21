<?php

namespace Encore\Admin\Grid\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid;

class PerPageSelector extends AbstractTool
{
    /**
     * @var string
     */
    protected $perPage;

    /**
     * @var string
     */
    protected $perPageName = '';

    /**
     * Create a new PerPageSelector instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;

        $this->initialize();
    }

    /**
     * Do initialize work.
     *
     * @return void
     */
    protected function initialize()
    {
        $this->perPageName = $this->grid->model()->getPerPageName();
        //dd($this->perPageName);
        $this->perPage = isset($_REQUEST[$this->perPageName]) ? $_REQUEST[$this->perPageName]
            : $this->grid->perPage;
    }

    /**
     * Get options for selector.
     *
     * @return static
     */
    public function getOptions()
    {
        return collect($this->grid->perPages)
            ->push($this->grid->perPage)
            ->push($this->perPage)
            ->unique()
            ->sort();
    }


    // baseUrl
    private function getBaseUrl($uri = '')
    {
        $baseUrl = (isset($_SERVER['HTTPS']) && 'off' != $_SERVER['HTTPS']) ? 'https://' : 'http://';
        $baseUrl .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
        //$baseUrl .= isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : dirname(getenv('SCRIPT_NAME'));
        return $baseUrl;
    }

    private function getPathInfo()
    {
        return $_SERVER['SCRIPT_NAME'];
    }

    /**
     * Get url without filter queryString.
     *
     * @return string
     */
    protected function url()
    {
       /* //return "##";
        $columns = [];

        foreach ($this->filters as $filter) {
            $columns[] = $filter->getColumn();
        }

        $query = $_REQUEST;
        array_forget($query, $columns);*/
        $query = $_REQUEST;
       // $query[$this->perPageName] = $this->perPage;

        $question = '/' == $this->getBaseUrl().$this->getPathInfo() ? '/?' : '?';

        return $this->getBaseUrl().$this->getPathInfo().$question.http_build_query($query);
    }

    /**
     * Render PerPageSelector。
     *
     * @return string
     */
    public function render()
    {
        Admin::script($this->script());

        $options = $this->getOptions()->map(function ($option) {
            $selected = ($option == $this->perPage) ? 'selected' : '';
            $url = $this->url();
            $url .=sprintf("&%s=%s",$this->perPageName,$option);
            //$url = app('request')->fullUrlWithQuery([$this->perPageName => $option]);

            return "<option value=\"$url\" $selected>$option</option>";
        })->implode("\r\n");

        $show = trans('admin.show');
        $entries = trans('admin.entries');

        return <<<EOT

<label class="control-label pull-right" style="margin-right: 10px; font-weight: 100;">

        <small>$show</small>&nbsp;
        <select class="input-sm grid-per-pager" name="per-page">
            $options
        </select>
        &nbsp;<small>$entries</small>
    </label>

EOT;
    }

    /**
     * Script of PerPageSelector.
     *
     * @return string
     */
    protected function script()
    {
        return <<<'EOT'

$('.grid-per-pager').on("change", function(e) {
    $.pjax({url: this.value, container: '#pjax-container'});
});

EOT;
    }
}
