<?php

namespace app\model;

use app\base\model\Base;

class Seckilltopicplan extends Base
{
    public function seckilltopic()
    {
        return $this->hasOne('Seckilltopic','id','seckilltopic_id')->bind(array(
            'seckilltopic_name'=>'name',
        ));
    }
}
