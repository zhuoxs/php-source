<?php
defined('IN_IA') or exit('Access Denied');

class Diypage{
    /**
     * Comment: 信息验证
     * Author: zzw
     */
    public function verify($id,$type){
        global $_W,$_GPC;
        $result = array(
            'id'        => $id,
            'type'      => $type,
        );
        //进行数据判断 获取对应的数据信息
        if ($id <= 0) {
            //添加基本页面进行的操作
            if (!empty($type)) {
                //类型存在 获取页面类型信息
                $getpagetype = self::getPageType($type);
                $result['pagetype'] = $getpagetype['pagetype'];
            }
        } else if ($id > 0) {
            //获取页面数据
            $info = pdo_get(PDO_NAME."diypage",array('id'=>$id),array('id','data'));
            $info['data'] = base64_decode($info['data']);
            $result['data'] = json_decode($info['data']);
            $getpagetype = self::getPageType($type);
            $result['pagetype'] = $getpagetype['pagetype'];
        }
        return $result;
    }
	
}