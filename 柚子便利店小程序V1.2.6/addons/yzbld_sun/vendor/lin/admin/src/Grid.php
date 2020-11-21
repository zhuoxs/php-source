<?php

namespace Encore\Admin;

use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Displayers\RowSelector;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Grid\Row;
use Encore\Admin\Grid\Tools;
use Encore\Admin\Model as EloquentModel;
use Illuminate\Support\Collection;
use Encore\Admin\Grid\Column;
use Encore\Admin\Pagination\DbPaginator;

class Grid
{
    /**
     * @var Grid\Model
     */
    protected $model;

    /**
     * Collection of all grid columns.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $columns;

    /**
     * Collection of table columns.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $dbColumns;

    /**
     * Collection of all data rows.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $rows;

    /**
     * Rows callable fucntion.
     *
     * @var \Closure
     */
    protected $rowsCallback;

    /**
     * All column names of the grid.
     *
     * @var array
     */
    public $columnNames = [];

    /**
     * Grid builder.
     *
     * @var \Closure
     */
    protected $builder;

    /**
     * Mark if the grid is builded.
     *
     * @var bool
     */
    protected $builded = false;

    /**
     * All variables in grid view.
     *
     * @var array
     */
    protected $variables = [];

    /**
     * The grid Filter.
     *
     * @var \Encore\Admin\Grid\Filter
     */
    protected $filter;

    /**
     * Resource path of the grid.
     *
     * @var
     */
    protected $resourcePath;

    /**
     * Default primary key name.
     *
     * @var string
     */
    protected $keyName = 'id';

    /**
     * Export driver.
     *
     * @var string
     */
    protected $exporter;

    /**
     * View for grid to render.
     *
     * @var string
     */
    protected $view = 'grid/table';

    /**
     * Per-page options.
     *
     * @var array
     */
    public $perPages = [10, 20, 30, 50, 100];

    /**
     * Default items count per-page.
     *
     * @var int
     */
    public $perPage = 20;

    /**
     * Header tools.
     *
     * @var Tools
     */
    public $tools;

    /**
     * Callback for grid actions.
     *
     * @var Closure
     */
    protected $actionsCallback;

    /**
     * Options for grid.
     *
     * @var array
     */
    protected $options = [
        'usePagination' => true,
        'useFilter' => true,
        'useExporter' => true,
        'useActions' => true,
        'useRowSelector' => true,
        'allowCreate' => true,
    ];

    /**
     * @var
     */
    protected $footer;

    /**
     * @var DbPaginator
     */
    //protected $dbPaginator;

    /**
     * Create a new grid instance.
     *
     * @param Eloquent $model
     * @param Closure  $builder
     */
    public function __construct(EloquentModel $model, \Closure $builder)
    {
        $this->keyName = 'id';
        $this->model = new \Encore\Admin\Grid\Model($model);
        $this->columns = new Collection();
        $this->rows = new Collection();
        $this->builder = $builder;

        //$this->dbPaginator = new DbPaginator($this);

        $this->setupTools();

        $this->setupFilter($this->resource());
        //$this->setupExporter();
    }

    /**
     * Set the grid filter.
     *
     * @param Closure $callback
     */
    public function filter(\Closure $callback)
    {
        call_user_func($callback, $this->filter);
    }


    /**
     * Register column displayers.
     */
    public static function registerColumnDisplayer()
    {
        $map = [
            'editable' => \Encore\Admin\Grid\Displayers\Editable::class,
            'switch' => \Encore\Admin\Grid\Displayers\SwitchDisplay::class,
            'switchGroup' => \Encore\Admin\Grid\Displayers\SwitchGroup::class,
            'select' => \Encore\Admin\Grid\Displayers\Select::class,
            'image' => \Encore\Admin\Grid\Displayers\Image::class,
            'label' => \Encore\Admin\Grid\Displayers\Label::class,
            'button' => \Encore\Admin\Grid\Displayers\Button::class,
            'link' => \Encore\Admin\Grid\Displayers\Link::class,
            'badge' => \Encore\Admin\Grid\Displayers\Badge::class,
            'progressBar' => \Encore\Admin\Grid\Displayers\ProgressBar::class,
            'radio' => \Encore\Admin\Grid\Displayers\Radio::class,
            'checkbox' => \Encore\Admin\Grid\Displayers\Checkbox::class,
            'orderable' => \Encore\Admin\Grid\Displayers\Orderable::class,
        ];

        foreach ($map as $abstract => $class) {
            Column::extend($abstract, $class);
        }
    }

    /**
     * Disable all actions.
     *
     * @return $this
     */
    public function disableActions()
    {
        return $this->option('useActions', false);
    }

    /**
     * Alias for method `disableCreateButton`.
     *
     * @return $this
     *
     * @deprecated
     */
    public function disableCreation()
    {
        return $this->disableCreateButton();
    }

    /**
     * Remove create button on grid.
     *
     * @return $this
     */
    public function disableCreateButton()
    {
        return $this->option('allowCreate', false);
    }

    /**
     * If allow creation.
     *
     * @return bool
     */
    public function allowCreation()
    {
        return $this->option('allowCreate');
    }

    /**
     * Disable grid filter.
     *
     * @return $this
     */
    public function disableFilter()
    {
        $this->option('useFilter', false);

        return $this;
    }

    /**
     * Get the string contents of the grid view.
     *
     * @return string
     */
    public function __toString()
    {
        try{
            $str = $this->render();
            return $str;
        }
        catch (\Exception $e){
            var_dump($e);
            exit();
        }
    }

    /**
     * Add column to Grid.
     *
     * @param string $name
     * @param string $label
     *
     * @return Column
     */
    public function column($name, $label = '')
    {
        $column = $this->addColumn($name, $label);

        return $column;
    }

    /**
     * Add column to grid.
     *
     * @param string $column
     * @param string $label
     *
     * @return Column
     */
    protected function addColumn($column = '', $label = '')
    {
        $column = new Column($column, $label);
        $column->setGrid($this);

        return $this->columns[] = $column;
    }

    /**
     * Batch add column to grid.
     *
     * @example
     * 1.$grid->columns(['name' => 'Name', 'email' => 'Email' ...]);
     * 2.$grid->columns('name', 'email' ...)
     *
     * @param array $columns
     *
     * @return Collection|null
     */
    public function columns($columns = [])
    {
        if (0 == func_num_args()) {
            return $this->columns;
        }

        if (1 == func_num_args() && is_array($columns)) {
            foreach ($columns as $column => $label) {
                $this->column($column, $label);
            }

            return;
        }

        foreach (func_get_args() as $column) {
            $this->column($column);
        }
    }

    /**
     * Set grid row callback function.
     *
     * @param Closure $callable
     *
     * @return Collection|null
     */
    public function rows(Closure $callable = null)
    {
        if (is_null($callable)) {
            return $this->rows;
        }

        $this->rowsCallback = $callable;
    }


    /**
     *
     */
    public function setupTools()
    {
        $this->tools = new Tools($this);
    }


    /**
     * Get all variables will used in grid view.
     *
     * @return array
     */
    protected function variables()
    {
        $this->variables['grid'] = $this;

        return $this->variables;
    }

    /**
     * @return array
     */
    public function processFilter()
    {
        call_user_func($this->builder, $this); //执行闭包的代码

        return $this->filter->execute();
    }


    /**
     * Set per-page options.
     *
     * @param array $perPages
     */
    public function perPages(array $perPages)
    {
        $this->perPages = $perPages;
    }

    /**
     * Get or set option for grid.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this|mixed
     */
    public function option($key, $value = null)
    {
        if (is_null($value)) {
            return $this->options[$key];
        }

        $this->options[$key] = $value;

        return $this;
    }



    /**
     * Add `actions` column for grid.
     */
    protected function appendActionsColumn()
    {
        if (!$this->option('useActions')) {
            return;
        }

        $grid = $this;
        $callback = $this->actionsCallback;
        $column = $this->addColumn('__actions__', '操作');

        $column->display(function ($value) use ($grid, $column, $callback) {
            $actions = new Actions($value, $grid, $column, $this);

            return $actions->display($callback);
        });
    }

    
    /**
     * Prepend checkbox column for grid.
     *
     * @return void
     */
    protected function prependRowSelectorColumn()
    {
        if (!$this->option('useRowSelector')) {
            return;
        }

        $grid = $this;

        $column = new Column(Column::SELECT_COLUMN_NAME, ' ');
        $column->setGrid($this);

        $column->display(function ($value) use ($grid, $column) {
            $actions = new RowSelector($value, $grid, $column, $this);

            return $actions->display();
        });

        $this->columns->prepend($column);
    }


    /**
     * @param $type
     * @param null $id
     * @return mixed
     */
    public function url($type, $id = null)
    {
        $model = explode('\\', $this->model->getModelClassName());
        //debug($model);
        $controller = uncamelize(end($model));
        $arg[] = $controller;
        if (null != $id) {
            $arg[] = $id;
        }

        return forward_static_call_array(array('Encore\\Admin\\Url', $type), $arg);
    }

    /**
     * @return string
     */
    public function resource()
    {
        $model = explode('\\', $this->model->getModelClassName());
        $controller = uncamelize(end($model));

        return $controller;
    }

    /**
     * Disable grid pagination.
     *
     * @return $this
     */
    public function disablePagination()
    {
        $this->option('usePagination', false);

        return $this;
    }





    /**
     * If this grid use pagination.
     *
     * @return bool
     */
    public function usePagination()
    {
        return $this->option('usePagination');
    }


    /**
     * Get Grid model.
     *
     * @return Model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getKeyName()
    {
        return $this->keyName;
    }
    /**
     * Set grid action callback.
     *
     * @param Closure $callback
     *
     * @return $this
     */
    public function actions(\Closure $callback)
    {
        $this->actionsCallback = $callback;

        return $this;
    }

    /**
     * Get the grid paginator.
     *
     * @return mixed
     */
    public function paginator()
    {
        return new Tools\Paginator($this);
    }

    /**
     * Paginate the grid.
     *
     * @param int $perPage
     *
     * @return void
     */
    public function paginate($perPage = 20)
    {
        $this->perPage = $perPage;

        $this->model()->paginate($perPage);
    }

    /**
     * Setup grid filter.
     */
    protected function setupFilter($controller)
    {
        $this->filter = new Filter($this->model(),$controller);
    }


    /**
     * Build the grid.
     */
    public function build()
    {
        if ($this->builded) {
            return;
        }

        $data = $this->processFilter();
        $this->prependRowSelectorColumn(); //添加行选择框
        $this->appendActionsColumn(); //添加行操作

        Column::setOriginalGridData($data);

        $this->columns->map(function (Column $column) use (&$data) {
            $data = $column->fill($data);

            $this->columnNames[] = $column->getName();
        });

        $this->buildRows($data);

        $this->builded = true;
    }

    /**
     * Build the grid rows.
     *
     * @param array $data
     */
    protected function buildRows(array $data)
    {
        $this->rows = collect($data)->map(function ($model, $number) {
            return new Row($number, $model);
        });

        if ($this->rowsCallback) {
            $this->rows->map($this->rowsCallback);
        }
    }

    /**
     * Render custom tools.
     *
     * @return string
     */
    public function renderHeaderTools()
    {
        return $this->tools->render();
    }

    /**
     * Render create button for grid.
     *
     * @return Tools\CreateButton
     */
    public function renderCreateButton()
    {
        return new Tools\CreateButton($this);
    }

    /**
     * @return string
     */
    public function renderFilter()
    {
        if (!$this->option('useFilter')) {
            return '';
        }

        return $this->filter->render();
    }

    /**
     * Get the string contents of the grid view.
     *
     * @return string
     */
    public function render()
    {
        try {
            $this->build();
        } catch (\Exception $e) {
            return dd($e);
        }
        $data = $this->variables();
        $columns_res = [];
        $columns = $this->columns();
        foreach ($columns as &$column){
            $columns_res[] = [
                "label"=>$column->getLabel(),
                "sorter"=>$column->sorter(),
            ];
        }
        $row_data = [];
        $rows = $this->rows();
        foreach ($rows as $row){
            $item = [];
            foreach ($this->columnNames as $name){
                $item[] = $row->column($name);
            }
            $row_data[] = $item;
        }
        $paginator = $this->paginator();

        $data = array_merge($data,[
            "filter"=>$this->renderFilter(),
            "createButton"=>$this->renderCreateButton(),
            "headerTools"=>$this->renderHeaderTools(),
            "columns"=>$columns_res,
            "row_data"=>$row_data,
            "paginator"=>$paginator
        ]);
        return Template::view($this->view, $data);
    }

    /**
     * Setup grid tools.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function tools(\Closure $callback)
    {
        call_user_func($callback, $this->tools);
    }
}
