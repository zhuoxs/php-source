<?php
class system extends base{
    public function get_current(){
        global $_W;
        $info = pdo_get($this->get_table_name(),array('uniacid'=>$_W['uniacid']));
        return $info;
    }
}