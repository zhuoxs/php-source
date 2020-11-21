<?php
namespace Common\Model;
/**
 * ModelName
 */
class LevelModel extends BaseModel{

    public static function get_member_level()
    {
        //$member_level = C('MEMBER_LEVEL');
        $member_level = M('level')->order('id asc')->select();
        foreach( $member_level as $key=>$val ) {
            $member_level[$key]['level'] = $key;
        }
        return $member_level;
    }

    /**
     * 获取等级名称
     * @param $level
     * @return mixed
     */
    public function get_level_name($level){
        $member_level = self::get_member_level();
        return $member_level[$level]['name'];
    }
}
