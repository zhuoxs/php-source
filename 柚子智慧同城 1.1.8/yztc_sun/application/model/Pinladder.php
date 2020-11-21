<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 17:47
 */
namespace app\model;


class Pinladder extends Base
{
    /**
     * 获取阶梯团列表
    */
    public function getLadderList($goods_id){
        $list=$this->where(['goods_id'=>$goods_id])->select();
        return $list;
    }
    /**
     * 判断当前可用阶梯购信息
     */
    public function useLadder($goods_id,$num){
        $model=new Pinladder();
        $list=$model->where(['goods_id'=>$goods_id])->order(['panic_num'=>'asc'])->select();
        $html=array();
//        foreach($list as $key => $value){
//            if($value['panic_num']<$num){
//                continue;// 当 $value为b时，跳出本次循环
//            }
//            if($value['panic_num']>$num){
//                $html.= $value;
//                break;// 当 $value为c时，终止循环
//            }
//            $html.= $value;
//        }
        for ($i=0; $i<count($list); $i++) {
            if($list[$i]['panic_num']>=$num){
                $html = $list[$i];
                break;
            }
        }
        return $html;
    }
}