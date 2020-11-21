<?php

namespace Encore\Admin\Grid;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Filter\AbstractFilter;
use Encore\Admin\Grid\Filter\Presenter\Presenter;
use Encore\Admin\Template;
use Encore\Admin\Url;

/*use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;*/

/**
 * Class Filter.
 *
 * @method AbstractFilter equal($column, $label = '')
 * @method AbstractFilter notEqual($column, $label = '')
 * @method AbstractFilter like($column, $label = '')
 * @method AbstractFilter ilike($column, $label = '')
 * @method AbstractFilter gt($column, $label = '')
 * @method AbstractFilter lt($column, $label = '')
 * @method AbstractFilter between($column, $label = '')
 * @method AbstractFilter in($column, $label = '')
 * @method AbstractFilter notIn($column, $label = '')
 * @method AbstractFilter where($callback, $label)
 * @method AbstractFilter date($column, $label = '')
 * @method AbstractFilter day($column, $label = '')
 * @method AbstractFilter month($column, $label = '')
 * @method AbstractFilter year($column, $label = '')
 * @method AbstractFilter hidden($name, $value)
 */
class Filter
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $supports = [
        'equal', 'notEqual', 'ilike', 'like', 'gt', 'lt', 'between',
        'where', 'in', 'notIn', 'date', 'day', 'month', 'year', 'hidden',
    ];

    /**
     * If use id filter.
     *
     * @var bool
     */
    protected $useIdFilter = true;

    /**
     * Id filter was removed.
     *
     * @var bool
     */
    protected $idFilterRemoved = false;

    /**
     * Action of search form.
     *
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $view = 'filter/modal';

    /**
     * @var string
     */
    protected $filterModalId = 'filter-modal';

    protected $controller;

    public function __construct(Model $model, $controller)
    {
        $this->model = $model;

        $this->controller = $controller;

        $pk = $this->model->eloquent()->getKeyName();

        $this->equal($pk, strtoupper($pk));
    }

    /**
     * Set action of search form.
     *
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Set modalId of search form.
     *
     * @param string $filterModalId
     *
     * @return $this
     */
    public function setModalId($filterModalId)
    {
        $this->filterModalId = $filterModalId;

        return $this;
    }

    /**
     * Disable Id filter.
     */
    public function disableIdFilter()
    {
        $this->useIdFilter = false;
    }

    /**
     * Remove ID filter if needed.
     */
    public function removeIDFilterIfNeeded()
    {
        if (!$this->useIdFilter && !$this->idFilterRemoved) {
            array_shift($this->filters);
            $this->idFilterRemoved = true;
        }
    }

    /**
     * Get all conditions of the filters.
     *
     * @return array
     */
    public function conditions()
    {
        $inputs = array_dot(request());

        $inputs = array_filter($inputs, function ($input) {
            return '' !== $input && !is_null($input);
        });

        if (empty($inputs)) {
            return [];
        }

        $params = [];

        foreach ($inputs as $key => $value) {
            array_set($params, $key, $value);
        }

        $conditions = [];

        $this->removeIDFilterIfNeeded();

        foreach ($this->filters() as $filter) {
            $conditions[] = $filter->condition($params);
        }

        return array_filter($conditions);
    }

    /**
     * Add a filter to grid.
     *
     * @param AbstractFilter $filter
     *
     * @return AbstractFilter
     */
    protected function addFilter(AbstractFilter $filter)
    {
        $filter->setParent($this);

        return $this->filters[] = $filter;
    }

    /**
     * Use a custom filter.
     *
     * @param AbstractFilter $filter
     *
     * @return AbstractFilter
     */
    public function useFilter(AbstractFilter $filter)
    {
        return $this->addFilter($filter);
    }

    /**
     * Get all filters.
     *
     * @return AbstractFilter[]
     */
    public function filters()
    {
        return $this->filters;
    }

    /**
     * Execute the filter with conditions.
     *
     * @return array
     */
    public function execute()
    {
        return $this->model->addConditions($this->conditions())->buildData();
    }

    /**
     * @param callable $callback
     * @param int      $count
     *
     * @return bool
     */
    public function chunk(callable $callback, $count = 100)
    {
        return $this->model->addConditions($this->conditions())->chunk($callback, $count);
    }

    public function getAction()
    {
        return Url::index($this->controller);
    }

    public function render()
    {
        $this->removeIDFilterIfNeeded();

        if (empty($this->filters)) {
            return '';
        }

        $script = <<<'EOT'

$("#filter-modal .submit").click(function () {
    $("#filter-modal").modal('toggle');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
});

EOT;
        Admin::script($script);
        $filters =  [];
        if(!empty($this->filters)){
            foreach ($this->filters as $filter){
                $filters[] = $filter->render();
            }

        }

        $data = [
    'action' => $this->action ?: $this->urlWithoutFilters(),
    'filters' => $filters,
    'modalId' => $this->filterModalId,
    ];

        return Template::view($this->view, $data);
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
    protected function urlWithoutFilters()
    {
        //return "##";
        $columns = [];

        foreach ($this->filters as $filter) {
            $columns[] = $filter->getColumn();
        }

        $query = $_REQUEST;
        array_forget($query, $columns);

        $question = '/' == $this->getBaseUrl().$this->getPathInfo() ? '/?' : '?';

        return $this->getBaseUrl().$this->getPathInfo().$question.http_build_query($query);
    }

    /**
     * Generate a filter object and add to grid.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return AbstractFilter|$this
     */
    public function __call($method, $arguments)
    {
        if (in_array($method, $this->supports)) {
            $className = '\\Encore\\Admin\\Grid\\Filter\\'.ucfirst($method);
            $reflect  = new \ReflectionClass($className);
            $obj = $reflect->newInstanceArgs($arguments);
            return $this->addFilter($obj);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->render();
    }
}
