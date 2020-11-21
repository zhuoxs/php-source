<?php

namespace app\model;

use app\base\model\Base;

class Seckillmeeting extends Base
{
    public function seckillgoods()
    {
        return $this->hasMany('Seckillgoods')->where('state',1);
    }
    public function seckilltopic()
    {
        return $this->hasOne('Seckilltopic','id','seckilltopic_id')->bind(array(
            'seckilltopic_name'=>'name',
        ));
    }
}
