<?php

namespace app\model;

use app\base\model\Base;

class Seckilltopic extends Base
{
    public function seckillmeetings()
    {
        return $this->hasMany('Seckillmeeting')->where('state',1);
    }
    public function seckilltopicclass()
    {
        return $this->hasOne('Seckilltopicclass','id','seckilltopicclass_id')->bind(array(
            'seckilltopicclass_name'=>'name',
        ));
    }
}
