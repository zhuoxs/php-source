<?php
class store extends base{
	public $required_fields = array('name');
	public $unique = array(array('uniacid','name'),array('uniacid','name','code'));
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'province',
            'on'=>array(
                'id'=>'province_id',
            ),
            'columns'=>array(
                'name'=>'province_name',
            ),
        ),
        array(
            'as'=>'t3',
            'table'=>'city',
            'on'=>array(
                'id'=>'city_id',
            ),
            'columns'=>array(
                'name'=>'city_name',
            ),
        ),
        array(
            'as'=>'t4',
            'table'=>'county',
            'on'=>array(
                'id'=>'county_id',
            ),
            'columns'=>array(
                'name'=>'county_name',
            ),
        ),
    );
	public function get_list_app($lat, $lng){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'] ?: $_SESSION['admin']['uniacid'];
        $sql = "";
        $sql .= "select *,convert(acos(cos($lat*pi()/180 )*cos(latitude*pi()/180)*cos($lng*pi()/180 -longitude*pi()/180)+sin($lat*pi()/180 )*sin(latitude*pi()/180))*6370996.81,decimal)  as distance from ".$this->get_full_table_name()." where uniacid = $uniacid order by distance ";

        $list = pdo_fetchall($sql);
        return array(
            'code'=>0,
            'data'=>$list,
        );
    }
}