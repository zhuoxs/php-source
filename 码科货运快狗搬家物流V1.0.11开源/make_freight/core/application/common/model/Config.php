<?php

namespace app\common\model;

use think\Model;

/**
 * 配置模型
 */
class Config extends Model
{

    // 表名,不含前缀
    protected $name = 'config';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;
    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    // 追加属性
    protected $append = [
    ];


    /*
     * $params array 修改或添加的参数
     * $field  array 修改或添加的字段
     * return  boole
     */
    public function editConfig($params,$field){

        $params = array_filter(array_intersect_key($params, array_flip( $field ) ) );

        $field          = implode(',',$field);
        $where['name']  = ['in',$field];


        $res    = self::where($where)->where('uniacid',$GLOBALS['fuid'])->select();

        $update_data = [];

        if($res){
            //更新表配置
            $num    = null;
            foreach($res as $k=>$v){

                if( isset($params[ $v['name'] ]) ){
                    //如果提交的值和数据的值相同则不更新
                    if($params[ $v['name'] ] !== $v['value']){
                        $num += self::where('name',$v['name' ])->where('uniacid',$GLOBALS['fuid'])->update([ 'value'=>$params[ $v['name'] ]  ]);
//                        $v['value'] = $params[ $v['name'] ];
//                        $update_data[] = $v;

                    }
                    unset($params[ $v['name'] ]);
                }
            }
//            if($update_data){
//
//                $update_data = collection($update_data)->toArray();
//                $num         = self::isUpdate()->saveAll($update_data);
//                dump(collection($num)->toArray());die;
//            }
        }





        //新增表的配置
        $insert_data = [];
        if($params){
            foreach($params as $k=>$v){
                $insert_data[] = ['name'=>$k,'value'=>$v,'uniacid'=>$GLOBALS['fuid']];
            }

            $ins = self::saveAll($insert_data);
        }


        if( !empty($num) || !empty($ins) ){
            return true;
        }else{
            return false;
        }

    }






    /**
     * 本地上传配置信息
     * @return array
     */
    public static function upload()
    {
        $uploadcfg = config('upload');

        $upload = [
            'cdnurl'    => $uploadcfg['cdnurl'],
            'uploadurl' => $uploadcfg['uploadurl'],
            'bucket'    => 'local',
            'maxsize'   => $uploadcfg['maxsize'],
            'mimetype'  => $uploadcfg['mimetype'],
            'multipart' => [],
            'multiple'  => $uploadcfg['multiple'],
        ];
        return $upload;
    }

}
