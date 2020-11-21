<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 10:01
 */

namespace Encore\Admin\Grid;


use Encore\Admin\Grid;
use Illuminate\Contracts\Support\Arrayable;

class Column
{
    /**
     * @var Grid
     */
    protected $grid;

    /**
     * Name of column.
     *
     * @var string
     */
    protected $name;

    /**
     * Label of column.
     *
     * @var string
     */
    protected $label;

    /**
     * Original value of column.
     *
     * @var mixed
     */
    protected $original;

    /**
     * Is column sortable.
     *
     * @var bool
     */
    protected $sortable = false;

    /**
     * Sort arguments.
     *
     * @var array
     */
    protected $sort;

    /**
     * Attributes of column.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Relation name.
     *
     * @var bool
     */
    protected $relation = false;

    /**
     * Relation column.
     *
     * @var string
     */
    protected $relationColumn;

    /**
     * Original grid data.
     *
     * @var array
     */
    protected static $originalGridData = [];

    /**
     * @var []Closure
     */
    protected $displayCallbacks = [];

    /**
     * Displayers for grid column.
     *
     * @var array
     */
    public static $displayers = [];

    /**
     * Defined columns.
     *
     * @var array
     */
    public static $defined = [];

    /**
     * @var array
     */
    protected static $htmlAttributes = [];

    /**
     * @var
     */
    protected static $model;

    const SELECT_COLUMN_NAME = '__row_selector__';

    /**
     * @param string $name
     * @param string $label
     */
    public function __construct($name, $label)
    {
        $this->name = $name;

        $this->label = $this->formatLabel($label);
    }

    /**
     * Format label.
     *
     * @param $label
     *
     * @return mixed
     */
    protected function formatLabel($label)
    {
        $label = $label ?: ucfirst($this->name);

        return str_replace(['.', '_'], ' ', $label);
    }

    /**
     * Get label of the column.
     *
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }


    /**
     * Set grid instance for column.
     *
     * @param Grid $grid
     */
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;

        $this->setModel($grid->model()->eloquent());
    }

    /**
     * Set model for column.
     *
     * @param $model
     */
    public function setModel($model)
    {
        if (is_null(static::$model) && ($model instanceof \Encore\Admin\Model)) {
            static::$model = $model->newInstance();
        }
    }

    /**
     * Set original data for column.
     *
     * @param array $input
     */
    public static function setOriginalGridData(array $input)
    {
        static::$originalGridData = $input;
    }

    /**
     * If has display callbacks.
     *
     * @return bool
     */
    protected function hasDisplayCallbacks()
    {
        return !empty($this->displayCallbacks);
    }

    /**
     * Call all of the "display" callbacks column.
     *
     * @param mixed $value
     * @param int   $key
     *
     * @return mixed
     */
    protected function callDisplayCallbacks($value, $key)
    {
        foreach ($this->displayCallbacks as $callback) {
            $callback = $this->bindOriginalRow($callback, $key);
            $value = call_user_func($callback, $value);
        }

        return $value;
    }

    /**
     * Set original grid data to column.
     *
     * @param Closure $callback
     * @param int     $key
     *
     * @return Closure
     */
    protected function bindOriginalRow(\Closure $callback, $key)
    {
        $originalRow = static::$originalGridData[$key];

        return $callback->bindTo(static::$model->newFromBuilder($originalRow));
    }
    /**
     * Fill all data to every column.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function fill(array $data)
    {
        foreach ($data as $key => &$row) {
            $this->original = $value = array_get($row, $this->name);

            //$value = $this->htmlEntityEncode($value);

            array_set($row, $this->name, $value);

           /* if ($this->isDefinedColumn()) {
                $this->useDefinedColumn();
            }
           */

            if ($this->hasDisplayCallbacks()) {
                $value = $this->callDisplayCallbacks($this->original, $key);
                array_set($row, $this->name, $value);
            }
        }

        return $data;
    }

    /**
     * Get name of this column.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add a display callback.
     *
     * @param Closure $callback
     *
     * @return $this
     */
    public function display(\Closure $callback)
    {
        $this->displayCallbacks[] = $callback;

        return $this;
    }

    /**
     * Passes through all unknown calls to builtin displayer or supported displayer.
     *
     * Allow fluent calls on the Column object.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return $this
     */
    public function __call($method, $arguments)
    {
        if ($this->isRelation() && !$this->relationColumn) {
            $this->name = "{$this->relation}.$method";
            $this->label = isset($arguments[0]) ? $arguments[0] : ucfirst($method);

            $this->relationColumn = $method;

            return $this;
        }

        return $this->resolveDisplayer($method, $arguments);
    }

    /**
     * If this column is relation column.
     *
     * @return bool
     */
    protected function isRelation()
    {
        return (bool) $this->relation;
    }

    /**
     * Find a displayer to display column.
     *
     * @param string $abstract
     * @param array  $arguments
     *
     * @return Column
     */
    protected function resolveDisplayer($abstract, $arguments)
    {

        if (array_key_exists($abstract, static::$displayers)) {
            return $this->callBuiltinDisplayer(static::$displayers[$abstract], $arguments);
        }

        return $this->callSupportDisplayer($abstract, $arguments);
    }

    /**
     * Call Builtin displayer.
     *
     * @param string $abstract
     * @param array  $arguments
     *
     * @return Column
     */
    protected function callBuiltinDisplayer($abstract, $arguments)
    {
        if ($abstract instanceof \Closure) {
            return $this->display(function ($value) use ($abstract, $arguments) {

                $arg[] = $this;
                $arg = array_merge($arg,array_merge([$value], $arguments));
               // dd($arg);
                return call_user_func_array([$abstract, 'call'], $arg);
                //return $abstract->call($this, array_merge([$value], $arguments));
            });
        }

        if (class_exists($abstract) && is_subclass_of($abstract, Grid\Displayers\AbstractDisplayer::class)) {
            $grid = $this->grid;
            $column = $this;
            return $this->display(function ($value) use ($abstract, $grid, $column, $arguments) {
                $displayer = new $abstract($value, $grid, $column, $this);

                return call_user_func_array([$displayer, 'display'], $arguments);
            });
        }
        return $this;
    }

    /**
     * Call Illuminate/Support displayer.
     *
     * @param string $abstract
     * @param array  $arguments
     *
     * @return Column
     */
    protected function callSupportDisplayer($abstract, $arguments)
    {
        return $this->display(function ($value) use ($abstract, $arguments) {
            if (is_array($value) || $value instanceof Arrayable) {
                return call_user_func_array([collect($value), $abstract], $arguments);
            }

            if (is_string($value)) {
                return call_user_func_array([Str::class, $abstract], array_merge([$value], $arguments));
            }

            return $value;
        });
    }

    /**
     * Extend column displayer.
     *
     * @param $name
     * @param $displayer
     */
    public static function extend($name, $displayer)
    {
        static::$displayers[$name] = $displayer;
    }

    /**
     * Mark this column as sortable.
     *
     * @return Column
     */
    public function sortable()
    {
        $this->sortable = true;

        return $this;
    }

    /**
     * Create the column sorter.
     *
     * @return string|void
     */
    public function sorter()
    {
        if (!$this->sortable) {
            return;
        }

        $icon = 'fa-sort';
        $type = 'desc';

        if ($this->isSorted()) {
            $type = $this->sort['type'] == 'desc' ? 'asc' : 'desc';
            $icon .= "-amount-{$this->sort['type']}";
        }

        $query = $_REQUEST;
        $sortName = $this->grid->model()->getSortName();
        $query = array_merge($query,
            [ $sortName."_column"=>$this->name,
            $sortName."_type"=>$type
            ]
        );

        $url = getBaseUrl().'?'.http_build_query($query);

        return "<a class=\"fa fa-fw $icon\" href=\"$url\"></a>";
    }
    /**
     * Determine if this column is currently sorted.
     *
     * @return bool
     */
    protected function isSorted()
    {
        $sortName =$this->grid->model()->getSortName();

        $this->sort = [];//Input::get($this->sortName, []);
        //dd($_REQUEST);
        if(isset($_REQUEST[$sortName."_column"]) && isset($_REQUEST[$sortName."_type"]))
        {
            $this->sort = [
                "column"=>$_REQUEST[$sortName."_column"],
                "type"=>$_REQUEST[$sortName."_type"],
            ];
        }

        if (empty($this->sort)) {
            return false;
        }

        return isset($this->sort['column']) && $this->sort['column'] == $this->name;
    }
}