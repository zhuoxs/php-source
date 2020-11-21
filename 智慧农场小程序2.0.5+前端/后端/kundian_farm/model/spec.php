<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 14:33
 */
defined("IN_IA")or exit("Access Denied");
class Spec_KundianFarmModel{
    private $model_name='';
    public $goods_spec='cqkundian_farm_goods_spec';
    public $spec_value='cqkundian_farm_spec_value';
    public function __construct($model_name){
        $this->model_name=$model_name;
    }

    public function getEditSpecItem($goods_id,$uniacid){
        $request=array();
        switch ($this->model_name){
            case 'animal':
                //根据商品获取规格值
                $editSpecVal=pdo_getAll('cqkundian_farm_animal_spec',array('uniacid'=>$uniacid,'aid'=>$goods_id));
                //根据规格项id获取规格值
                $spec_id=array();
                for($i=0;$i<count($editSpecVal);$i++){
                    $specItem=pdo_getAll('cqkundian_farm_animal_spec_value',array('uniacid'=>$uniacid,'spec_id'=>$editSpecVal[$i]['id']));
                    $editSpecVal[$i]['specValue']=$specItem;
                    $spec_id[]=$editSpecVal[$i]['id'];
                }
                $returnStr=$this->getSpecSku($spec_id,$uniacid);

                $newSkuSpec=$returnStr['newSkuSpec'];
                $goodsSpecVal=array();
                for($j=1;$j<=count($newSkuSpec);$j++){
                    $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_animal_sku',array('sku_name'=>$newSkuSpec[$j],'aid'=>$goods_id,'uniacid'=>$uniacid));
                }
                break;
            case 'goods':
                //根据商品获取规格值
                $editSpecVal=pdo_getall('cqkundian_farm_spec',array('uniacid'=>$uniacid,'goods_id'=>$goods_id));
                //根据规格项id获取规格值
                $spec_id=array();
                for($i=0;$i<count($editSpecVal);$i++){
                    $specItem=pdo_getall('cqkundian_farm_spec_value',array('uniacid'=>$uniacid,'spec_id'=>$editSpecVal[$i]['id']));
                    $editSpecVal[$i]['specValue']=$specItem;
                    $spec_id[]=$editSpecVal[$i]['id'];
                }
                $returnStr=$this->getSpecSku($spec_id,$uniacid);

                $newSkuSpec=$returnStr['newSkuSpec'];
                $goodsSpecVal=array();
                for($j=1;$j<=count($newSkuSpec);$j++){
                    $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                }
                break;
            case 'group':
                //根据商品获取规格值
                $editSpecVal=pdo_getall('cqkundian_farm_group_spec',array('uniacid'=>$uniacid,'goods_id'=>$goods_id));
                //根据规格项id获取规格值
                $spec_id=array();
                for($i=0;$i<count($editSpecVal);$i++){
                    $specItem=pdo_getall('cqkundian_farm_group_spec_value',array('uniacid'=>$uniacid,'spec_id'=>$editSpecVal[$i]['id']));
                    $editSpecVal[$i]['specValue']=$specItem;
                    $spec_id[]=$editSpecVal[$i]['id'];
                }
                $returnStr=$this->getSpecSku($spec_id,$uniacid);

                $newSkuSpec=$returnStr['newSkuSpec'];
                $goodsSpecVal=array();
                for($j=1;$j<=count($newSkuSpec);$j++){
                    $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_group_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                }
                break;
            case 'integral':
                $editSpecVal=pdo_getall('cqkundian_farm_integral_spec',array('uniacid'=>$uniacid,'goods_id'=>$goods_id));
                //根据规格项id获取规格值
                $spec_id=array();
                for($i=0;$i<count($editSpecVal);$i++){
                    $specItem=pdo_getall('cqkundian_farm_integral_spec_value',array('uniacid'=>$uniacid,'spec_id'=>$editSpecVal[$i]['id']));
                    $editSpecVal[$i]['specValue']=$specItem;
                    $spec_id[]=$editSpecVal[$i]['id'];
                }
                $returnStr=$this->getSpecSku($spec_id,$uniacid);

                $newSkuSpec=$returnStr['newSkuSpec'];
                $goodsSpecVal=array();
                for($j=1;$j<=count($newSkuSpec);$j++){
                    $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_integral_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                }
                break;
        }

        $request['specVal']=$editSpecVal;
        $request['specItem']= $returnStr['specItem'];
        $request['newSkuSpec']=$returnStr['newSkuSpec'];
        $request['skuSpec']=$returnStr['skuSpec'];
        $request['goodsSpecVal']=$goodsSpecVal;

        return $request;
    }

    /**
     * 添加规格选项
     * @param $insertData
     * @return mixed
     */
    public function addSkuItem($insertData){
        switch ($this->model_name){
            case 'animal':
                $res=pdo_insert('cqkundian_farm_animal_spec',$insertData);
                break;
            case 'goods':
                $res=pdo_insert('cqkundian_farm_spec',$insertData);
                break;
            case 'group':
                $res=pdo_insert('cqkundian_farm_group_spec',$insertData);
                break;
            case 'integral':
                $res=pdo_insert('cqkundian_farm_integral_spec',$insertData);
                break;
        }
        $spec_id=pdo_insertid();
        return $spec_id;
    }

    /**
     * 获取规格的组合值，当前选中的规格项，规格值对应的详细信息
     * @param  [array] $spec_id [规格项id]
     * @param  [int] $uniacid [当前小程序id]
     * @return [array]          [array]
     */
    public function getSpecSku($spec_id,$uniacid){
        sort($spec_id);  //将数组排序
        $returnStr=array();
        $arr=array();
        $skuSpec=array();
        switch ($this->model_name){
            case 'animal':
                $specItem=pdo_getall("cqkundian_farm_animal_spec",array('id in'=>$spec_id,'uniacid'=>$uniacid));
                for($i=0;$i<count($specItem);$i++) {
                    $spec_where['spec_id'] = $specItem[$i]['id'];  //所有的规格项
                    $spec_where['uniacid']=$uniacid;
                    $specValue = pdo_getall('cqkundian_farm_animal_spec_value', $spec_where, 'id');
                    for ($j = 0; $j < count($specValue); $j++) {
                        $arr[$specItem[$i]['id']][] = $specValue[$j]['id'];
                    }
                }
                //得到组合后的SKU数组
                $newSpec=$this->ok($arr);
                for($i=1;$i<count($newSpec)+1;$i++){
                    $new_spec_arr=explode(",",$newSpec[$i]);
                    $skuSpec[$i-1]=pdo_getall('cqkundian_farm_animal_spec_value',array('id in'=>$new_spec_arr,'uniacid'=>$uniacid));
                }
                break;
            case 'goods':
                $specItem=pdo_getall("cqkundian_farm_spec",array('id in'=>$spec_id,'uniacid'=>$uniacid));
                for($i=0;$i<count($specItem);$i++) {
                    $spec_where['spec_id'] = $specItem[$i]['id'];  //所有的规格项
                    $spec_where['uniacid']=$uniacid;
                    $specValue = pdo_getall('cqkundian_farm_spec_value', $spec_where, 'id','','id desc');
                    for ($j = 0; $j < count($specValue); $j++) {
                        $arr[$specItem[$i]['id']][] = $specValue[$j]['id'];
                    }
                }
                //得到组合后的SKU数组
                $newSpec=$this->ok($arr);
                for($i=1;$i<count($newSpec)+1;$i++){
                    $new_spec_arr=explode(",",$newSpec[$i]);
                    $skuSpec[$i-1]=pdo_getall('cqkundian_farm_spec_value',array('id in'=>$new_spec_arr,'uniacid'=>$uniacid));
                }
                break;
            case 'group':
                $specItem=pdo_getall("cqkundian_farm_group_spec",array('id in'=>$spec_id,'uniacid'=>$uniacid));
                $arr=array();
                for($i=0;$i<count($specItem);$i++) {
                    $spec_where['spec_id'] = $specItem[$i]['id'];  //所有的规格项
                    $spec_where['uniacid']=$uniacid;
                    $specValue = pdo_getall('cqkundian_farm_group_spec_value', $spec_where, 'id','','id desc');
                    for ($j = 0; $j < count($specValue); $j++) {
                        $arr[$specItem[$i]['id']][] = $specValue[$j]['id'];
                    }
                }
                //得到组合后的SKU数组
                $newSpec=$this->ok($arr);
                for($i=1;$i<count($newSpec)+1;$i++){
                    $new_spec_arr=explode(",",$newSpec[$i]);
                    $skuSpec[$i-1]=pdo_getall('cqkundian_farm_group_spec_value',array('id in'=>$new_spec_arr,'uniacid'=>$uniacid));
                }
                break;
            case 'integral':
                $specItem=pdo_getall("cqkundian_farm_integral_spec",array('id in'=>$spec_id,'uniacid'=>$uniacid));
                $arr=array();
                for($i=0;$i<count($specItem);$i++) {
                    $spec_where['spec_id'] = $specItem[$i]['id'];  //所有的规格项
                    $spec_where['uniacid']=$uniacid;
                    $specValue = pdo_getall('cqkundian_farm_integral_spec_value', $spec_where, 'id');
                    for ($j = 0; $j < count($specValue); $j++) {
                        $arr[$specItem[$i]['id']][] = $specValue[$j]['id'];
                    }
                }
                //得到组合后的SKU数组
                $newSpec=$this->ok($arr);
                for($i=1;$i<count($newSpec)+1;$i++){
                    $new_spec_arr=explode(",",$newSpec[$i]);
                    $skuSpec[$i-1]=pdo_getall('cqkundian_farm_integral_spec_value',array('id in'=>$new_spec_arr,'uniacid'=>$uniacid));
                }
                break;
        }
        $returnStr['specItem']=$specItem;
        $returnStr['newSkuSpec']=$newSpec;
        $returnStr['skuSpec']=$skuSpec;
        return $returnStr;
    }

    /**
     * 删除规格项
     * @param $id
     * @param $spec_id_str
     * @param $uniacid
     * @return array
     */
    public function deleteSkuItem($id,$spec_id_str,$uniacid){
        $spec_id_str=explode('_', $spec_id_str);
        $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
        $returnStr['code']=1;
        switch ($this->model_name){
            case 'animal':
                $res=pdo_delete('cqkundian_farm_animal_spec',array('uniacid'=>$uniacid,'id'=>$id));
                break;
            case 'goods':
                $res=pdo_delete('cqkundian_farm_spec',array('uniacid'=>$uniacid,'id'=>$id));
                break;
            case 'group':
                $res=pdo_delete('cqkundian_farm_group_spec',array('uniacid'=>$uniacid,'id'=>$id));
                break;
            case 'integral':
                $res=pdo_delete('cqkundian_farm_integral_spec',array('uniacid'=>$uniacid,'id'=>$id));
                break;
        }

        return $res ? $returnStr : array('code'=>2);
    }

    /**
     * 添加规格值
     * @param $spec_id
     * @param $goods_id
     * @param $spec_id_str
     * @param $value
     * @param $uniacid
     * @return array
     */
    public function addSkuVal($spec_id,$goods_id,$spec_id_str,$value,$uniacid){
        $spec_id_str=explode('_', $spec_id_str);
        $insertData=array(
            'uniacid'=>$uniacid,
            'spec_id'=>$spec_id,
            'spec_value'=>$value,
        );
        switch ($this->model_name){
            case 'animal':
                $res=pdo_insert('cqkundian_farm_animal_spec_value',$insertData);  //插入数据
                $spec_val_id=pdo_insertid();
                $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
                if(!empty($is_type)){  //编辑
                    $aid=$goods_id;
                    $newSkuSpec=$returnStr['newSkuSpec'];
                    $goodsSpecVal=array();
                    for($j=1;$j<=count($newSkuSpec);$j++){
                        $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_animal_sku',array('sku_name'=>$newSkuSpec[$j],'aid'=>$aid,'uniacid'=>$uniacid));
                    }
                    $returnStr['goodsSpecVal']=$goodsSpecVal;
                }
                break;
            case 'goods':
                $res=pdo_insert('cqkundian_farm_spec_value',$insertData);  //插入数据
                $spec_val_id=pdo_insertid();
                $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
                if(!empty($_GPC['is_type'])){  //编辑
                    $newSkuSpec=$returnStr['newSkuSpec'];
                    $goodsSpecVal=array();
                    for($j=1;$j<=count($newSkuSpec);$j++){
                        $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                    }
                }
                break;
            case 'group':
                $res=pdo_insert('cqkundian_farm_group_spec_value',$insertData);  //插入数据
                $spec_val_id=pdo_insertid();
                $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
                if(!empty($_GPC['is_type'])){  //编辑
                    $newSkuSpec=$returnStr['newSkuSpec'];
                    $goodsSpecVal=array();
                    for($j=1;$j<=count($newSkuSpec);$j++){
                        $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_group_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                    }
                }
                break;
            case 'integral':
                $res=pdo_insert('cqkundian_farm_integral_spec_value',$insertData);  //插入数据
                $spec_val_id=pdo_insertid();
                $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
                if(!empty($_GPC['is_type'])){  //编辑
                    $goods_id=$_GPC['goods_id'];
                    $newSkuSpec=$returnStr['newSkuSpec'];
                    $goodsSpecVal=array();
                    for($j=1;$j<=count($newSkuSpec);$j++){
                        $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_integral_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                    }
                }
                break;
        }
        $returnStr['goodsSpecVal']=$goodsSpecVal;
        $returnStr['spec_val_id']=$spec_val_id;
        $returnStr['code']=1;

        return $returnStr;
    }

    /**
     * 删除规格值
     * @param $spec_val_id
     * @param $spec_id_str
     * @param $is_type
     * @param $goods_id
     * @param $uniacid
     * @param string $spec_id
     * @return array
     */
    public function deleteSkuVal($spec_val_id,$is_type,$goods_id,$spec_id_str,$uniacid,$spec_id=''){
        $spec_id_str=explode('_', $spec_id_str);  //当前规格项
        switch ($this->model_name){
            case 'animal':
                $res=pdo_delete("cqkundian_farm_animal_spec_value",array('id'=>$spec_val_id,'uniacid'=>$uniacid));
                $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
                if(!empty($is_type)){  //编辑
                    $aid=$goods_id;
                    $specValue=pdo_getall('cqkundian_farm_animal_spec',array('aid'=>$aid,'uniacid'=>$uniacid));//获取该商品的所有规格值
                    $newSkuSpec=$returnStr['newSkuSpec'];
                    $goodsSpecVal=array();
                    for($j=1;$j<=count($newSkuSpec);$j++){
                        $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_animal_sku',array('sku_name'=>$newSkuSpec[$j],'aid'=>$aid,'uniacid'=>$uniacid));
                    }
                    $delete_where['sku_name LIKE']="%".$spec_val_id.'%';
                    $delete_where['aid']=$aid;
                    $delete_where['uniacid']=$uniacid;
                    pdo_delete('cqkundian_farm_animal_sku',$delete_where);
                    $returnStr['goodsSpecVal']=$goodsSpecVal;
                }
                break;
            case 'goods':
                $res=pdo_delete("cqkundian_farm_spec_value",array('spec_id'=>$spec_id,'id'=>$spec_val_id,'uniacid'=>$uniacid));
                $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
                if(!empty($_GPC['is_type'])){  //编辑
                    $goods_id=$_GPC['goods_id'];
                    $specValue=pdo_getall('cqkundian_farm_goods_spec',array('goods_id'=>$goods_id,'uniacid'=>$uniacid));//获取该商品的所有规格值
                    $newSkuSpec=$returnStr['newSkuSpec'];
                    $goodsSpecVal=array();
                    for($j=1;$j<=count($newSkuSpec);$j++){
                        $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                    }
                    $delete_where['sku_name LIKE']="%".$spec_val_id.'%';
                    $delete_where['goods_id']=$goods_id;
                    $delete_where['uniacid']=$uniacid;
                    pdo_delete('cqkundian_farm_goods_spec',$delete_where);
                    $returnStr['goodsSpecVal']=$goodsSpecVal;
                }
                break;
            case 'group':
                $res=pdo_delete("cqkundian_farm_group_spec_value",array('spec_id'=>$spec_id,'id'=>$spec_val_id,'uniacid'=>$uniacid));
                $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
                if(!empty($_GPC['is_type'])){  //编辑
                    $goods_id=$_GPC['goods_id'];
                    $specValue=pdo_getall('cqkundian_farm_group_goods_spec',array('goods_id'=>$goods_id,'uniacid'=>$uniacid));//获取该商品的所有规格值
                    $newSkuSpec=$returnStr['newSkuSpec'];
                    $goodsSpecVal=array();
                    for($j=1;$j<=count($newSkuSpec);$j++){
                        $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_group_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                    }
                    $delete_where['sku_name LIKE']="%".$spec_val_id.'%';
                    $delete_where['goods_id']=$goods_id;
                    $delete_where['uniacid']=$uniacid;
                    pdo_delete('cqkundian_farm_group_goods_spec',$delete_where);
                    $returnStr['goodsSpecVal']=$goodsSpecVal;
                }
                break;
            case 'integral':
                $res=pdo_delete("cqkundian_farm_integral_spec_value",array('spec_id'=>$spec_id,'id'=>$spec_val_id,'uniacid'=>$uniacid));
                $returnStr=$this->getSpecSku($spec_id_str,$uniacid);
                if(!empty($_GPC['is_type'])){  //编辑
                    $goods_id=$_GPC['goods_id'];
                    $specValue=pdo_getall('cqkundian_farm_integral_goods_spec',array('goods_id'=>$goods_id,'uniacid'=>$uniacid));//获取该商品的所有规格值
                    $newSkuSpec=$returnStr['newSkuSpec'];
                    $goodsSpecVal=array();
                    for($j=1;$j<=count($newSkuSpec);$j++){
                        $goodsSpecVal[$j-1]=pdo_get('cqkundian_farm_integral_goods_spec',array('sku_name'=>$newSkuSpec[$j],'goods_id'=>$goods_id,'uniacid'=>$uniacid));
                    }
                    $delete_where['sku_name LIKE']="%".$spec_val_id.'%';
                    $delete_where['goods_id']=$goods_id;
                    $delete_where['uniacid']=$uniacid;
                    pdo_delete('cqkundian_farm_integral_goods_spec',$delete_where);
                    $returnStr['goodsSpecVal']=$goodsSpecVal;
                }
                break;
        }

        return $returnStr;
    }

    /**
     * SKU组合计算
     * @param $CombinList
     * @return mixed
     */
    public function ok($CombinList) {
        $CombineCount = 1;
        foreach ($CombinList as $Key => $Value) {
            $CombineCount *= count($Value);
        }
        $RepeatTime = $CombineCount;
        foreach ($CombinList as $ClassNo => $StudentList) {
            $RepeatTime = $RepeatTime / count($StudentList);
            $StartPosition = 1;
            foreach ($StudentList as $Student) {
                $TempStartPosition = $StartPosition;
                $SpaceCount = $CombineCount / count($StudentList) / $RepeatTime;
                for ($J = 1; $J <= $SpaceCount; $J ++) {
                    for ($I = 0; $I < $RepeatTime; $I ++) {
                        $Result[$TempStartPosition + $I][$ClassNo] = $Student;
                    }
                    $TempStartPosition += $RepeatTime * count($StudentList);
                }
                $StartPosition += $RepeatTime;
            }
        }
        if($Result){
            foreach ($Result as $k => $v) {
                $Result[$k] = implode(',', $v);
            }
        }
        return $Result;
    }

    /**
     * 获取多规格SKU信息
     * @param $cond
     * @param bool $multi
     * @return array|bool
     */
    public function getSkuByCon($cond,$multi=false){
        switch ($this->model_name){
            case 'animal':
                if($multi){
                    $list=pdo_getall('cqkundian_farm_animal_sku',$cond);
                }else{
                    $list=pdo_get('cqkundian_farm_animal_sku',$cond);
                }
                break;
            case 'goods':
                break;
            case 'group':
                break;
            case 'integral':
                break;
        }

        return $list;
    }

    /**
     * 获取规格项信息
     * @param $con
     * @return array
     */
    public function getSpec($con){
        switch ($this->model_name){
            case 'animal':
                $list=pdo_getall('cqkundian_farm_animal_spec',$con);
                break;
            case 'goods':
                $list=pdo_getall('cqkundian_farm_goods_spec',$con);
                break;
            case 'group':
                break;
            case 'integral':
                $list=pdo_getall('cqkundian_farm_integral_goods_spec',$con);
                break;
        }

        return $list;
    }

    public function getSpecValue($con){
        switch ($this->model_name){
            case 'animal':
                $list=pdo_getall('cqkundian_farm_animal_spec_value',$con);
                break;
            case 'goods':
                break;
            case 'group':
                break;
            case 'integral':
                break;
        }
        return $list;
    }

    /**
     * 规格整理
     * @param $specItem
     * @param $spec_val
     * @return mixed
     */
    public function neatenSpecData($specItem,$spec_val){
        for($j=0;$j<count($specItem);$j++){
            for($m=0;$m<count($spec_val);$m++){
                if($specItem[$j]['id']==$spec_val[$m]['spec_id']){
                    $specItem[$j]['spec_value']=$spec_val[$m]['spec_value'];
                }
            }
        }
        return $specItem;
    }

    /**
     * 商品规格图片
     * @param $specData
     * @return array
     */
    public function getSpecSrc($specData){
        $spec_src=array();
        for($i=0;$i<count($specData);$i++){
            if($specData[$i]['spec_src']) {
                $spec_src[] = $specData[$i]['spec_src'];
            }
        }
        return $spec_src;
    }

}