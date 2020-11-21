<?php

namespace app\model;
use traits\model\SoftDelete;

class Category extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    protected function base($query)
    {
        $field = $this->getDeleteTimeField(true);
        $query = $field ? $query->useSoftDelete($field) : $query;
        $query = parent::base($query);
        return $query;
    }

    public function category(){
        return $this->hasOne('Category','id','parent_id')->bind(array(
            'parent_name'=>'name',
        ));
    }
    public function categorys()
    {
        return $this->hasMany('Category','parent_id','id')
            ->where('state',1)
            ->with('childs');
    }
    public function childs()
    {
        return $this->hasMany('Category','parent_id','id')
            ->where('state',1);
    }
    public function goodses()
    {
        return $this->hasMany('Goods','cat_id','id')
            ->where('state',1)
            ->where('lid',1)
            ->where('check_status = 2 or store_id = 0')
//            ->where('store_id',0)
            ->order('is_recommend','desc')
            ->limit(6);
    }
    public function fastgoodses()
    {
        return $this->hasMany('Goods','cat_id','id')
            ->where('state',1)
            ->where('check_status = 2 or store_id = 0')
            ->where('stock',['>',0])
            ->where('is_quick',1);
    }
}
