<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/26 0026
 * Time: 下午 5:05
 */

defined("IN_IA")or exit("Access denied");
class VetController{
    protected $uniacid = '';
    public function __construct(){
        global $_W, $_GPC;
        $this->uniacid = $_GPC['uniacid'];
    }

    public function getVetData(){
        $request=array();
        $vetData=pdo_getall('cqkundian_farm_vet',array('uniacid'=>$this->uniacid,'status'=>1));
        for ($i=0;$i<count($vetData);$i++){
            $vetData[$i]['certificate']=unserialize($vetData[$i]['certificate']);
        }
        $request['vetData']=$vetData;

        //判断是否开启了兽医板块
        $setCon=array(
            'ikey'=>array('vet_icon','vet_banner','vet_title','vet_english_title','is_open_vet'),
            'uniacid'=>$this->uniacid,
        );
        $setData=pdo_getall('cqkundian_farm_set',$setCon);
        $setDataList=array();
        foreach ($setData as $key => $value) {
            $setDataList[$value['ikey']]=$value['value'];
        }
        $request['setData']=$setDataList;
        echo json_encode($request);die;
    }
}

