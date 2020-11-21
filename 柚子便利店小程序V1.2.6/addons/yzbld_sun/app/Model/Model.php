<?php

namespace App\Model;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Model.
 */
class Model extends BaseModel
{
    /**
     * @var bool
     */
    protected $timestamps = true;

    protected  $json_field = [];

    /**
     * @return string
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->attributes[$this->getKeyName()];
    }

    /**
     * @return array|null
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $field
     * @param $value
     */
    public function setAttribute($field, $value)
    {
        if (is_array($value)) {
            $this->attributes[$field] = json_encode($value);
        } else {
            $this->attributes[$field] = $value;
        }
    }

    /**
     * @param $key
     */
    public function __get($key)
    {
        if (isset($this->attributes[$key])) {
            if(in_array($key,$this->json_field))
            {
                $value = json_decode($this->attributes[$key],true);
            }
            else
            {
                $value = $this->attributes[$key];
            }

            return $value;
        }

        return null;
    }

    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    /**
     * @return array|null
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @return Model
     */
    public function find($id, $columns = ['*'])
    {
        return $this->where($this->getKeyName(), $id)->first($columns);
    }

    /**
     * @param $id
     *
     * @return Model
     */
    public function findOrFail($id)
    {
        return $this->find($id);
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (isset($this->attributes['id'])) {
            return $this->update($this->getAttributes(), $this->attributes['id']);
        } else {
            $this->insert_event();
            $attributes = $this->getAttributes();
            if ($this->timestamps) {
                $date = date('Y-m-d H:i:s');
                $attributes = array_merge($attributes, [
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
            if ($this->withUniacid) {
                $attributes = array_merge($attributes, [
                    'uniacid' => $this->getUniacid(),
                ]);
            }

            return $this->insert($attributes);
        }
    }

    /*  public function create($data)
      {

      }*/

    /**
     * @param $data
     * @param $id
     *
     * @return bool
     */
    public function update($data, $id)
    {
        $result = pdo_update($this->table, $data, array('id' => $id));

        return !empty($result);
    }

    /**
     * @return bool
     */
    public function delete()
    {
        if (isset($this->attributes['id'])) {
            $result = pdo_delete($this->table, ['id' => $this->attributes['id']]);
            if (!empty($result)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $column
     * @param null $key
     *
     * @return Collection
     */
    public function pluck($column, $key = null)
    {
        $columns = is_null($key) ? [$column] : [$column, $key];

        $result = $this->get($columns);

        return new Collection(Arr::pluck($result->toArray(), $column, $key));
    }

    public static function instance()
    {
        return new static();
    }

    public function insert_event()
    {
    }

    public function increment($field)
    {
        $data = $this->get(['id', $field]);
        foreach ($data as $item) {
            ++$item->$field;
            $item->save();
        }

        return true;
    }

    public function decrement($field)
    {
        $data = $this->get(['id', $field]);
        foreach ($data as $item) {
            --$item->$field;
            $item->save();
        }

        return true;
    }


}
