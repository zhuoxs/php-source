<?php

namespace App\Model;
use Illuminate\Contracts\Support\Arrayable;

abstract class BaseModel extends \We7Table implements Arrayable,\Encore\Admin\Model
{
    /**
     * @var
     */
    public $query;
    /**
     * @var string
     */
    protected $table = "";
    /**
     * @var string
     */
    protected $prefix = "yzbld_sun_";


    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];


    /**
     * @var bool
     */
    protected $withUniacid = true;

    /**
     * @var null
     */
    public static $uniacid = null;

    /**
     * BaseModel constructor.
     * @param null $data
     */
    public function __construct($data = null)
    {
        if (PHP_SAPI != "cli") {
            $this->query = load()->object('query');
        }
        if(empty($this->table)){
            $class = get_called_class();
            $class = explode('\\',$class);
            $this->table = $this->prefix.uncamelize(pluralize(end($class)));
        }
        $this->query = $this->query->from($this->table);
        if($this->withUniacid)
        {
            $this->query = $this->query->where("uniacid",$this->getUniacid());
        }
        if($data != null)
        {
            $this->attributes = $data;
        }
    }


    /**
     * @param $data
     * @return BaseModel
     */
    public static function newFromBuilder($data)
    {
        return new static($data);
    }

    /**
     * @return null
     */
    public function getUniacid()
    {
        if(is_null(self::$uniacid)) {
            global $_W;
            self::$uniacid = $_W["uniacid"];
        }
        return self::$uniacid;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $method = $name;
        $this->query = call_user_func_array([$this->query,$method],$arguments);
        return $this;
    }


    /**
     * @param mixed 支持多个参数
     * @return $this
     */
    public function where()
    {
        if(func_num_args() != 3){
            $this->query = call_user_func_array([$this->query,"where"],func_get_args());
            return $this;
        }
        else
        {
            $arg[0] = func_get_arg(0)." ".func_get_arg(1);
            $arg[1] =func_get_arg(2);
            $this->query = call_user_func_array([$this->query,"where"],$arg);
            return $this;
        }
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function first($columns = ['*'])
    {

        if(count($columns) == 1 && $columns[0] == '*'){
            $res = $this->query->get();
            if($res)
            {
                $this->attributes = $res;
                return $this;
            }
            return false;

        }
        else
        {
            $res = $this->query->select($columns)->get();
            if($res)
            {
                $this->attributes = $res;
                return $this;
            }
            return false;
        }
    }


    /**
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function get($columns = ['*'])
    {

        return $this->all($columns);

    }

    /**
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function all($columns = ['*'])
    {
        if(count($columns) == 1 && $columns[0] == '*'){

            $data = $this->query->getall();
        }
        else
        {
           $data = $this->query->select($columns)->getall();
        }

        foreach ($data as $item)
        {
            $collect[] = static::newFromBuilder($item);
        }
        return collect($collect);
    }

    /**
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        $result = pdo_insert($this->table, $data);
        if (!empty($result)) {
            $id = pdo_insertid();
            return $id;
        }
        return false;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param null $page
     * @return Paginator
     */
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: ($_REQUEST[$pageName] ?: 1);

        $total = $this->getCountForPagination($columns);

        $results = $total ? $this->page($page, $perPage)->get($columns) : collect();

        return $this->paginator($results, $total, $perPage, $page, [
            'path' => '',
            'pageName' => $pageName,
        ]);
    }

    /**
     * @return mixed
     */
    public function getCountForPagination()
    {
        return $this->query->count();
    }

    /**
     * @param $items
     * @param $total
     * @param $perPage
     * @param null $currentPage
     * @param array $options
     * @return Paginator
     */
    public function paginator($items, $total, $perPage, $currentPage = null, array $options = [])
    {
        return (new Paginator($items, $total, $perPage, $currentPage,$options));
    }

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function min($column)
    {
        $res = $this->orderBy($column,"asc")->first([$column]);

        return $res ? $res->$column : 0;
    }

    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function max($column)
    {
        $res = $this->orderBy($column,"desc")->first([$column]);

        return $res ? $res->$column : 0;
    }
    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function count()
    {
       return $this->query->count();
    }

    public function sum($column)
    {
        $collection = $this->get([$column]);
        $res = 0;
        foreach ($collection as $item){
            $res += $item->$column;
        }
        return  $res;
    }

    public function orderBy($column,$direction = "asc")
    {
        $this->query = $this->query->orderby($column,$direction);
        return $this;
    }
}