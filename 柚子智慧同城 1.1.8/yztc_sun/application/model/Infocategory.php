<?php

namespace app\model;
use traits\model\SoftDelete;

class Infocategory extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    //判断帖子类别id有没有二级分类
    public function isSecondInfocategory($id){
        $data=$this->where(['state'=>1,'is_del'=>0,'parent_id'=>$id])->find();
        if($data){
            return true;
        }else{
            return false;
        }
    }

    protected function base($query)
    {
        $field = $this->getDeleteTimeField(true);
        $query = $field ? $query->useSoftDelete($field) : $query;
        $query = parent::base($query);
        return $query;
    }

    public function category(){
        return $this->hasOne('Infocategory','id','parent_id')->bind(array(
            'parent_name'=>'name',
        ));
    }
    public function categorys()
    {
        return $this->hasMany('Infocategory','parent_id','id')
            ->where('state',1)
            ->with('childs');
    }
    public function childs()
    {
        return $this->hasMany('Infocategory','parent_id','id')
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
