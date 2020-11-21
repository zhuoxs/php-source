<?php
/**
 * User: YangXinlan
 * DateTime: 2019/1/17 15:36
 */
namespace app\model;




class Panicladder extends Base
{
    //判断当前可用阶梯购信息
    public function useLadder($pid,$num){
        $model=new Panicladder();
        $list=$model->where(['goods_id'=>$pid])->order(['panic_num'=>'asc'])->select();
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