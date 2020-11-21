<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/1/26 0026
 * Time: 下午 3:36
 */
defined('IN_IA') or exit('Access Denied');
require_once ROOT_PATH.'model/public.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/spec.php';
require_once ROOT_PATH_FARM_PT.'model/goods.php';
class Pt_Goods{
    protected $that='';
    protected $uniacid='';
    static $pt_goods='';
    static $common='';
    static $spec='';
    public function __construct($that){
        global $_W,$_GPC;
        checklogin();
        $this->that=$that;
        $this->uniacid=$_W['uniacid'];
        self::$pt_goods=new Pt_GoodsModel($this->uniacid);
        self::$common=new Common_KundianFarmModel();
        self::$spec=new Spec_KundianFarmModel('');
    }

    /** 拼团分类列表 */
    public function typeList($request){
        $public=new Public_KundianFarmModel(self::$pt_goods->pt_type,$this->uniacid);
        $page=$request['page'] ? $request['page'] :1 ;
        $data['pager']=pagination($public->getCount(),$page,10);
        $data['list']=$public->getTableList([],$page,10,'rank asc');
        $this->that->doWebCommon("web/goods/typeList",$data);
    }

    /** 拼团分类新增、编辑 */
    public function typeEdit($request){
        $public=new Public_KundianFarmModel(self::$pt_goods->pt_type,$this->uniacid);
        if($request['id']){
            $data['list']=$public->getTableById($request['id']);
        }

        if($_SERVER['REQUEST_METHOD'] && !strcasecmp($_SERVER['REQUEST_METHOD'],'post')){
            $res=self::$pt_goods->addType($request['formData']);
            $url=url('site/entry/admin',['m'=>$request['m'],'op'=>'typeList','action'=>$request['action']]);
            echo $res ? json_encode(['code'=>0,'msg'=>'保存成功','redirect'=>$url]) : json_encode(['code'=>-1,'msg'=>'保存失败']);die;
        }
        $this->that->doWebCommon("web/goods/typeEdit",$data);
    }

    /** 删除组团商品分类信息 */
    public function deleteTypeList($request){
        if(!empty($request['id'])){
            $public=new Public_KundianFarmModel(self::$pt_goods->pt_type,$this->uniacid);
            $res=$public->deleteTable(['id'=>$request['id']]);
            echo $res ? json_encode(['code'=>'0','msg'=>'删除成功']) : json_encode(['code'=>-1,'msg'=>'删除失败']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'传入id不合法']);die;
    }


    /** 商品列表 */
    public function goodsList($request){
        $public=new Public_KundianFarmModel(self::$pt_goods->pt_goods,$this->uniacid);
        $condition['uniacid']=$this->uniacid;
        if(!empty($request['goods_name'])){
            $condition['goods_name LIKE']='%'.$request['goods_name'].'%';
        }
        $count=$public->getCount($condition);
        $page=$request['page'] ? $request['page'] : 1;
        $data['pager']=pagination($count,$page,10);
        $data['list']=self::$pt_goods->getGoodsList($condition,$page,10);
        $this->that->doWebCommon("web/goods/goodsList",$data);
    }

    public function editGoods($request){
        $url=url('site/entry/admin', array('m' => $request['m'],'op'=>'goodsList','action'=>'goods'));
        $data['typeData']=pdo_getall('cqkundian_farm_pt_type',['uniacid'=>$this->uniacid]);
        $data['freight']=pdo_getall('cqkundian_farm_freight_rule',['uniacid'=>$this->uniacid],'','','status desc');
        $public=new Public_KundianFarmModel(self::$pt_goods->pt_goods,$this->uniacid);
        if(!empty($request['id'])){
            $goodsData=$public->getTableById($request['id']);
            $goodsData['slide_src']=unserialize($goodsData['slide_src']);
            $data['list']=$goodsData;
        }

        if($_SERVER['REQUEST_METHOD'] && !strcasecmp($_SERVER['REQUEST_METHOD'],'post')){
            $formData=$request['formData'];

            $specData=json_decode($_POST['specData']);
            $specSku=json_decode($_POST['specSku']);
            $x=0;
            while($formData["slide_src[$x"]) {
                $goods_slide[]=tomedia($formData["slide_src[$x"]);
                $x++;
            }
            $insertGoods=[
                'goods_name'=>$formData['goods_name'],
                'goods_desc'=>$formData['goods_desc'],
                'type_id'=>$formData['type_id'],
                'pt_price'=>$formData['pt_price'],
                'pt_count'=>$formData['pt_count'],
                'pt_time'=>$formData['pt_time'],
                'limit_time'=>strtotime($formData['limit_time']),
                'price'=>$formData['price'],
                'sale_count'=>$formData['sale_count'],
                'cover'=>tomedia($formData['cover']),
                'video_src'=>tomedia($formData['video_src']),
                'is_put_away'=>$formData['is_put_away'],
                'rank'=>$formData['rank'],
                'count'=>$formData['count'],
                'is_open_sku'=>$formData['is_open_sku'],
                'is_alone_buy'=>$formData['is_alone_buy'],
                'freight'=>$formData['freight'],
                'piece_free_shipping'=>$formData['piece_free_shipping'],
                'quota_free_shipping'=>$formData['quota_free_shipping'],
                'weight'=>$formData['weight'],
                'content'=>$formData['content'],
                'server_content'=>$formData['server_content'],
                'uniacid'=>$this->uniacid,
                'slide_src'=>serialize($goods_slide),
            ];

            //插入商品信息
            if(!empty($formData['goods_id'])){
                $goods_id=$formData['goods_id'];
                if($formData['is_open_sku']==1){
                    //更新规格信息
                    $specData=self::$common->objectToArray($specData);
                    foreach ($specData as $key => $val ){
                        pdo_update('cqkundian_farm_pt_spec',['goods_id'=>$goods_id],['id'=>$val['spec_id'],'uniacid'=>$this->uniacid]);
                    }
                    $specSku=self::$common->objectToArray($specSku);
                    $newSpec=[];
                    $attr = [];
                    foreach ($specSku as $key => $value){
                        $sku_name=[];
                        foreach ($value['sku'] as $k => $v){
                            $sku_name[]=$v['id'];
                        }
                        $newSpec[]=implode(',',$sku_name);
                        $spec_value=[
                            'sku_name'=>implode(',',$sku_name),
                            'count'=>$value['count'],
                            'spec_num'=>$value['spec_num'],
                            'price'=>$value['price'],
                            'pt_price'=>$value['pt_price'],
                            'spec_src'=>$value['spec_src'],
                        ];
                        $attr[]=$spec_value;
                    }
                    $insertGoods['sku']=serialize($attr);
                }
                $goodsRes=pdo_update('cqkundian_farm_pt_goods',$insertGoods,['id'=>$formData['goods_id'],'uniacid'=>$this->uniacid]);
                $goods_id=$formData['goods_id'];
                echo $goods_id ? json_encode(['code'=>0,'msg'=>'保存成功','redirect'=>$url]) : json_encode(['code'=>-1,'msg'=>'保存失败']);die;
            }
            if($formData['is_open_sku']==1) {
                $specSku = self::$common->objectToArray($specSku);
                $attr = [];
                foreach ($specSku as $key => $value) {
                    $sku_name = [];
                    foreach ($value['sku'] as $k => $v) {
                        $sku_name[] = $v['id'];
                    }
                    $spec_value = [
                        'sku_name' => implode(',', $sku_name),
                        'count' => $value['count'],
                        'spec_num' => $value['spec_num'],
                        'price' => $value['price'],
                        'pt_price' => $value['pt_price'],
                        'spec_src' => $value['spec_src'],
                    ];
                    $attr[] = $spec_value;
                }
                $insertGoods['sku'] = serialize($attr);
            }
            $goodsRes=pdo_insert('cqkundian_farm_pt_goods',$insertGoods);
            $goods_id=pdo_insertid();  //商品id

            if($formData['is_open_sku']==1){
                //更新规格信息
                $specData=self::$common->objectToArray($specData);
                foreach ($specData as $key => $val ){
                    pdo_update('cqkundian_farm_pt_spec',['goods_id'=>$goods_id],['id'=>$val['spec_id'],'uniacid'=>$this->uniacid]);
                }
            }
            echo $goods_id ? json_encode(['code'=>0,'msg'=>'保存成功','redirect'=>$url]) : json_encode(['code'=>-1,'msg'=>'保存失败']);die;
        }

        $this->that->doWebCommon("web/goods/editGoods",$data);
    }

    /** 添加组团商品规格项 */
    public function addPtSpec($request){
        pdo_insert('cqkundian_farm_pt_spec',['name'=>$request['name'],'uniacid'=>$this->uniacid]);
        $spec_id=pdo_insertid();
        echo json_encode(['spec_id'=>$spec_id]);die;
    }

    /** 添加组团商品规格值 */
    public function addPtSpecValue($request){
        $insertData=[
            'spec_value'=>$request['name'],
            'spec_id'=>$request['spec_id'],
            'uniacid'=>$this->uniacid,
        ];
        pdo_insert('cqkundian_farm_pt_spec_value',$insertData);
        $valid=pdo_insertid();
        echo json_encode(['valid'=>$valid]);die;
    }

    /** 删除组团商品规格项 */
    public function deletePtSpec($request){
        $res=pdo_delete('cqkundian_farm_pt_spec',['id'=>$request['spec_id'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'删除成功']) : json_decode(['code'=>-1,'msg'=>'删除失败']);die;
    }

    /** 删除组团商品规格值 */
    public function deletePtSpecValue($request){
        $res=pdo_delete('cqkundian_farm_pt_spec_value',['id'=>$request['valid'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'删除成功']) : json_decode(['code'=>-1,'msg'=>'删除失败']);die;
    }

    /** 获取规格的组合信息 */
    public function getSpecSku($request){
        $specData=self::$common->objectToArray(json_decode($_POST['specData']));
        $arr=[];
        foreach ($specData as $key => $val ){
            foreach ($val['spec_value'] as $k => $v ){
                $arr[$val['spec_id']][]=$v['valid'];
            }
        }
        $ok=self::$spec->ok($arr);
        $newSpec=[];
        $goodsData=pdo_get('cqkundian_farm_pt_goods',['id'=>$request['goods_id'],'uniacid'=>$this->uniacid]);
        $sku=unserialize($goodsData['sku']);

        for($i=1;$i<count($ok)+1;$i++){
            $new_spec_arr=explode(",",$ok[$i]);
            $newSpec[$i-1]['sku']=pdo_getall('cqkundian_farm_pt_spec_value',['id in'=>$new_spec_arr,'uniacid'=>$this->uniacid]);
            $newSpec[$i-1]['count']=0;
            $newSpec[$i-1]['price']='';
            $newSpec[$i-1]['pt_price']='';
            $newSpec[$i-1]['spec_num']='';
            $newSpec[$i-1]['spec_src']='';

            for ($j=0;$j<count($sku);$j++){

                if($sku[$j]['sku_name']==$ok[$i]){
                    $newSpec[$i-1]['count']=$sku[$j]['count'];
                    $newSpec[$i-1]['price']=$sku[$j]['price'];
                    $newSpec[$i-1]['pt_price']=$sku[$j]['pt_price'];
                    $newSpec[$i-1]['spec_num']=$sku[$j]['spec_num'];
                    $newSpec[$i-1]['spec_src']=$sku[$j]['spec_src'];
                }
            }
        }
        echo json_encode($newSpec);die;
    }

    /** 编辑是获取商品规格详细信息 */
    public function getEditSpec($request){
        $goods_id=$request['goods_id'];
        $goodsData=pdo_get(self::$pt_goods->pt_goods,['uniacid'=>$this->uniacid,'id'=>$goods_id]);
        $goods_spec=pdo_getall('cqkundian_farm_pt_spec',['goods_id'=>$goods_id,'uniacid'=>$this->uniacid]);
        $specData=[];
        $arr=[];
        for ($i=0;$i<count($goods_spec);$i++){
            $specData[$i]['spec_id']=$goods_spec[$i]['id'];
            $specData[$i]['spec_item_name']=$goods_spec[$i]['name'];
            $specValue=pdo_getall('cqkundian_farm_pt_spec_value',['spec_id'=>$goods_spec[$i]['id'],'uniacid'=>$this->uniacid]);
            $spec_value=[];
            for ($j=0;$j<count($specValue);$j++){
                $spec_value[$j]['valid']=$specValue[$j]['id'];
                $spec_value[$j]['spec_value']=$specValue[$j]['spec_value'];
                $spec_value[$j]['spec_id']=$specValue[$j]['spec_id'];

                $arr[$goods_spec[$i]['id']][]=$specValue[$j]['id'];
            }
            $specData[$i]['spec_value']=$spec_value;
        }

        $ok=self::$spec->ok($arr);
        $newSpec=[];
        $sku=unserialize($goodsData['sku']);

        for($i=1;$i<count($ok)+1;$i++){
            $new_spec_arr=explode(",",$ok[$i]);
            $newSpec[$i-1]['sku']=pdo_getall('cqkundian_farm_pt_spec_value',array('id in'=>$new_spec_arr,'uniacid'=>$this->uniacid));
            $newSpec[$i-1]['count']='';
            $newSpec[$i-1]['price']='';
            $newSpec[$i-1]['pt_price']='';
            $newSpec[$i-1]['spec_num']='';
            $newSpec[$i-1]['spec_src']='';
            for ($j=0;$j<count($sku);$j++){
                if($sku[$j]['sku_name']==$ok[$i]){

                    $newSpec[$i-1]['count']=$sku[$j]['count'];
                    $newSpec[$i-1]['price']=$sku[$j]['price'];
                    $newSpec[$i-1]['pt_price']=$sku[$j]['pt_price'];
                    $newSpec[$i-1]['spec_num']=$sku[$j]['spec_num'];
                    $newSpec[$i-1]['spec_src']=$sku[$j]['spec_src'];
                }

            }
        }
        $request=['specData'=>$specData,'newSpec'=>$newSpec];
        echo json_encode($request);die;
    }

    /** 删除商品信息 */
    public function deleteGoods($request){
        if(!empty($request['id'])){
            $public=new Public_KundianFarmModel(self::$pt_goods->pt_goods,$this->uniacid);
            $res=$public->deleteTable(['id'=>$request['id']]);
            echo $res ? json_encode(['code'=>'0','msg'=>'删除成功']) : json_encode(['code'=>-1,'msg'=>'删除失败']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'传入id不合法']);die;
    }

    /** 快速修改商品上下架状态 */
    public function fastChangeGoods($request){
        $public=new Public_KundianFarmModel(self::$pt_goods->pt_goods,$this->uniacid);
        if(!empty($request['id'])){
            $res=$public->updateTable(['is_put_away'=>$request['status']],['id'=>$request['id'],'uniacid'=>$this->uniacid]);
            echo $res ? json_encode(['code'=>0,'msg'=>'更新成功']) : json_encode(['code'=>-1,'msg'=>'更新失败']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'传入id不合法']);die;
    }

    /** 批量删除商品、更新商品上下架信息 */
    public function batchChangeGoods($request){
        // $request['selectType']== 1 批量上架  2 批量下架  3 批量删除
        if(!empty($request['goods_id'])){
            $public=new Public_KundianFarmModel(self::$pt_goods->pt_goods,$this->uniacid);
            if($request['selectType']==1){
                $updateData['is_put_away']=1;
            }elseif ($request['selectType']==2){
                $updateData['is_put_away']=0;
            }elseif ($request['selectType']==3){
                $res=$public->deleteTable(['id in' => $request['goods_id']]);
                echo $res ? json_encode(['code' => 0, 'msg' => '删除成功']) : json_encode(['code' =>-1, 'msg' => '删除失败']);die;
            }
            $res=$public->updateTable($updateData,['id in' => $request['goods_id']]);
            echo $res ? json_encode(['code' => 0, 'msg' => '批量更新成功']) : json_encode(['code' =>-1, 'msg' => '批量更新失败或没有更新任何信息']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'请选择商品要进行批量操作的商品！']);die;
    }

    /** 生成商品二维码 */
    public function getGoodsQcode($request){
        require_once ROOT_PATH.'model/goods.php';
        $goods=new Goods_KundianFarmModel('','');
        $goods_id=$request['id'];
        $public=new Public_KundianFarmModel(self::$pt_goods->pt_goods,$this->uniacid);
        $goodsData=$public->getTableById($goods_id);
        $path="/kundian_farm/pages/shop/prodeteils/index?goodsid=" . $goods_id;
        if($goodsData['goods_qrcode']){
            $filesize = @getimagesize($goodsData['goods_qrcode']);
            if($filesize){
                echo json_encode(['goods_qrcode'=>$goodsData['goods_qrcode']]);die;
            }else{
                $goods_qrcode=$goods->getGoodsQrcode($path,$this->uniacid);
                $public->updateTable(['goods_qrcode'=>$goods_qrcode],['id'=>$goods_id]);
                echo json_encode(['goods_qrcode'=>$goods_qrcode]);die;
            }
        }
        $goods_qrcode=$goods->getGoodsQrcode($path,$this->uniacid);
        $public->updateTable(['goods_qrcode'=>$goods_qrcode],['id'=>$goods_id]);
        echo json_encode(['goods_qrcode'=>$goods_qrcode]);die;
    }
}
