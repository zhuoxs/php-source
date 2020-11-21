<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/11
 * Time: 9:56
 */
defined("IN_IA")or exit("Access Denied");
class Goods_KundianFarmModel{
    public $tableName='cqkundian_farm_goods';
    public $integral_goods='cqkundian_farm_integral_goods';
    public $goods_type='cqkundian_farm_goods_type';
    public $integral_goods_type='cqkundian_farm_integral_goods_type';
    public $goods_trace_type='cqkundian_farm_goods_trace_type';
    public $goods_trace='cqkundian_farm_goods_trace';
    public $freight_rule='cqkundian_farm_freight_rule';
    public $goods_fumier='cqkundian_farm_goods_fumier';
    public $goods_insec='cqkundian_farm_goods_insec';
    public $shop_order='cqkundian_farm_shop_order';
    public $group_goods='cqkundian_farm_group_goods';
    protected $modelName='';
    public function __construct($tableName='cqkundian_farm_goods',$modelName){
        $this->tableName=$tableName;
        $this->modelName=$modelName;
    }

    public function getGoodsCount($cond){
        $all=pdo_getall($this->tableName,$cond);
        return count($all);
    }

    /**
     * 联合查询商品信息和分类信息
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return mixed
     */
    public function getGoodsList($cond=[],$pageIndex='',$pageSize=''){
        $query=load()->object('query');
        if(!empty($pageIndex) && !empty($pageSize)){
            return $query->from($this->tableName, 'a')
                ->leftjoin($this->goods_type, 'b')->on('a.type_id', 'b.id')
                ->select('a.*','b.type_name')
                ->where($cond)->orderby('rank asc')->page($pageIndex,$pageSize)->getall();

        }
        return $query->from($this->tableName, 'a')
            ->leftjoin($this->goods_type, 'b')->on('a.type_id', 'b.id')
            ->select('a.*','b.type_name')->orderby('rank asc')
            ->where($cond)->getall();

    }

    public function getIntegralGoods($cond=[],$pageIndex='',$pageSize=''){
        $query=load()->object('query');
        if(!empty($pageIndex) && !empty($pageSize)){
            return $query->from($this->integral_goods, 'a')
                ->leftjoin($this->integral_goods_type, 'b')->on('a.type_id', 'b.id')
                ->select('a.*','b.type_name')
                ->where($cond)->page($pageIndex,$pageSize)->getall();

        }
        return $query->from($this->tableName, 'a')
            ->leftjoin($this->integral_goods_type, 'b')->on('a.type_id', 'b.id')
            ->select('a.*','b.type_name')
            ->where($cond)->getall();
    }

    /** 插入商品分类信息*/
    public function addGoodsType($data){
        global $_W;
        $insertData=array(
            'type_name'=>trim($data['type_name']),
            'rank'=>trim($data['rank']),
            'icon'=>trim(tomedia($data['icon'])),
            'status'=>trim($data['status']),
            'uniacid'=>$_W['uniacid'],
        );
        if(empty($data['id'])){
            $insertData['create_time']=time();
            return pdo_insert($this->goods_type,$insertData);
        }
        return pdo_update($this->goods_type,$insertData,['id'=>$data['id']]);
    }

    /** 更新积分分类信息*/
    public function addIntegralType($data){
        global $_W;
        $insertData=array(
            'type_name'=>trim($data['type_name']),
            'rank'=>trim($data['rank']),
            'icon'=>trim(tomedia($data['icon'])),
            'status'=>trim($data['status']),
            'uniacid'=>$_W['uniacid'],
        );
        if(empty($data['id'])){
            $insertData['create_time']=time();
            return pdo_insert($this->integral_goods_type,$insertData);
        }
        return pdo_update($this->integral_goods_type,$insertData,['id'=>$data['id']]);
    }

    /** 添加肥料使用记录 */
    public function addFumier($data){
        global $_W;
        $updateData=array(
            'name'=>$data['name'],
            'area'=>$data['area'],
            'consommation'=>$data['consommation'],
            'uniacid'=>$_W['uniacid'],
            'trace_id'=>$data['trace_id'],
            'use_time'=>strtotime($data['use_time']),
        );
        if(empty($data['id'])){
            return pdo_insert($this->goods_fumier,$updateData);
        }
        return pdo_update($this->goods_fumier,$updateData,array('uniacid'=>$_W['uniacid'],'id'=>$data['id']));
    }

    /** 添加农药使用记录*/
    public function addInsec($data){
        global $_W;
        $updateData=array(
            'name'=>$data['name'],
            'area'=>$data['area'],
            'consommation'=>$data['consommation'],
            'uniacid'=>$_W['uniacid'],
            'trace_id'=>$data['trace_id'],
            'use_time'=>strtotime($data['use_time']),
        );
        if(empty($data['id'])){
            return pdo_insert($this->goods_insec,$updateData);
        }
        return pdo_update($this->goods_insec,$updateData,array('uniacid'=>$_W['uniacid'],'id'=>$data['id']));
    }

    //---old---------------


    /**
     * 根据ID查询商品信息
     * @param $id
     * @param $uniacid
     * @return bool
     */
    public function getGoodsById($id,$uniacid){
        $list=pdo_get($this->tableName,array('id'=>$id,'uniacid'=>$uniacid));
        if($list['goods_slide']){
            $list['goods_slide']=unserialize($list['goods_slide']);  //反序列化商品轮播图
        }
        if($list['send_goods_desc']){
            $list['send_goods_desc']=unserialize($list['send_goods_desc']);
            $list['send_goods_desc']=implode("\n",$list['send_goods_desc']);
        }
        return $list;
    }

    /**
     * 获取商品分类信息
     * @param $cond
     * @param bool $multiple
     * @return array|bool
     */
    public function getGoodsType($cond,$pageIndex='',$pageSize='',$order_by='rank asc',$multiple=true){
        switch ($this->modelName){
            case 'shop':
                if($multiple){
                    if(!empty($pageIndex) && !empty($pageSize)){
                        $list=pdo_getall('cqkundian_farm_goods_type',$cond,'','',$order_by,array($pageIndex,$pageSize));
                    }else{
                        $list=pdo_getall('cqkundian_farm_goods_type',$cond,'','',$order_by);
                    }

                }else{
                    $list=pdo_get('cqkundian_farm_goods_type',$cond);
                }

                break;
            case 'integral':
                if($multiple){
                    if(!empty($pageIndex) && !empty($pageSize)){
                        $list=pdo_getall('cqkundian_farm_integral_goods_type',$cond,'','',$order_by,array($pageIndex,$pageSize));
                    }else{
                        $list=pdo_getall('cqkundian_farm_integral_goods_type',$cond,'','',$order_by);
                    }

                }else{
                    $list=pdo_get('cqkundian_farm_integral_goods_type',$cond);
                }
                break;
        }

        return $list;
    }
    /**
     * 生成商品小程序码
     * @param $path
     * @param string $uniacid
     * @return bool|string
     * @throws Exception
     */
    public function getGoodsQrcode($path,$uniacid=''){
        global $_W;

        $temp_file=str_replace('\\','/',realpath(dirname(__FILE__).'/../')).'/resource/img/temp';
        if(!file_exists($temp_file)){
            mkdir($temp_file,0777,true);
        }

        $account_api = WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $params = array(
            'path' =>$path
        );
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/wxa/getwxacode?access_token={$access_token}");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        $response = curl_exec($ch);
        $filename = md5(uniqid()).'.jpeg';
        $tmp_file =IA_ROOT."/addons/kundian_farm/resource/img/temp/{$filename}";
        $result = file_put_contents($tmp_file, ob_get_contents());
        $check_result = json_decode(ob_get_contents(), true);
        curl_close($ch);
        ob_end_clean();
        if ($check_result['errcode']) {
            return false;
        }
        $filepath="kundian_farm/resource/img/temp/";


        $file['savepath'] =$filepath;
        $file['savename'] = $filename;
        $file['tmp_name'] = $tmp_file;
        $file['type'] = 'image/jpeg';
        $file['size'] = filesize($tmp_file);

        $img_url = $this->upload_local_file($filepath.$filename);
        if($img_url) {
            @unlink($tmp_file);
            if ($img_url) {
                return $img_url;
            } else {
                return false;
            }
        }else{
            global $_W;
            $local_img=$_W['siteroot']."/addons/kundian_farm/resource/img/temp/{$filename}";
            return $local_img;
        }
    }
    /**上传小程序码
     * @param $filename
     * @param string $auto_delete_local
     * @return bool|string
     * @throws Exception
     */
    public function upload_local_file($filename,$auto_delete_local='true'){
        global $_W;
        error_reporting(0);
        load()->library('qiniu');
        $auth = new Qiniu\Auth($_W['setting']['remote']['qiniu']['accesskey'], $_W['setting']['remote']['qiniu']['secretkey']);
        $config = new Qiniu\Config();
        $uploadmgr = new Qiniu\Storage\UploadManager($config);
        $putpolicy = Qiniu\base64_urlSafeEncode(json_encode(array(
            'scope' => $_W['setting']['remote']['qiniu']['bucket'] . ':' . $filename,
        )));
        $uploadtoken = $auth->uploadToken($_W['setting']['remote']['qiniu']['bucket'], $filename, 3600, $putpolicy);
        list($ret, $err) = $uploadmgr->putFile($uploadtoken, $filename, IA_ROOT . '/addons/' .$filename);
        if ($auto_delete_local) {
//        file_delete(IA_ROOT . '/addons/' .$filename);
        }
        $url=tomedia($filename);
        if ($err != null || $err !=NULL) {
//        return error(1, '远程附件上传失败，请检查配置并重新上传');
            return false;
        } else {
            return $url;
        }
    }

    /**
     * 获取商品的规格，以及规格对应的规格值信息
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public function getgoodsSpecItem($goodsid,$uniacid){
        switch ($this->modelName) {
            case 'shop':
                //获取商品规格信息
                $specItem = pdo_getall('cqkundian_farm_spec', array('goods_id' => $goodsid, 'uniacid' => $uniacid));
                //获取规格值信息
                for ($i = 0; $i < count($specItem); $i++) {
                    $specVal = pdo_getall('cqkundian_farm_spec_value', array('uniacid' => $uniacid, 'spec_id' => $specItem[$i]['id']));
                    $specItem[$i]['select_spec'] = 0;  //未选择
                    for ($j = 0; $j < count($specVal); $j++) {
                        $specVal[$j]['select_val'] = 0;
                        $specVal[$j]['is_count']=1;
                    }
                    $specItem[$i]['specVal'] = $specVal;
                }
                break;
        }
        return $specItem;
    }

    /**
     * 更新商品的销量信息
     * @param  [type] $order_id 订单编号
     * @param  [type] $uniacid  小程序唯一ID
     * @return [type]           [description]
     */
    public function updateSaleCount($order_id,$uniacid){
        $condition=array('order_id'=>$order_id,'uniacid'=>$uniacid);
        switch ($this->modelName){
            case 'shop':
                $orderDetail=pdo_getall('cqkundian_farm_shop_order_detail',$condition);
                for($i=0;$i<count($orderDetail);$i++){
                    $goods_where=array(
                        'id'=>$orderDetail[$i]['goods_id'],
                        'uniacid'=>$uniacid,
                    );
                    pdo_update($this->tableName,array('sale_count +='=>$orderDetail[$i]['count']),$goods_where);
                }
                break;
            case 'integral':    //积分兑换只存在一条订单详情信息
                $orderDetail=pdo_get('cqkundian_farm_integral_order_detail',$condition);
                $goods_where=array(
                    'id'=>$orderDetail['goods_id'],
                    'uniacid'=>$uniacid,
                );
                if($orderDetail['spec_id']!=0){ //存在规格信息
                    pdo_update('cqkundian_farm_integral_goods',array('sale_count +='=>$orderDetail['count']),$goods_where);
                    pdo_update('cqkundian_farm_integral_goods_spec',
                        array('count -='=>$orderDetail['count']),array('id'=>$orderDetail['spec_id'],'uniacid'=>$uniacid));
                }else{
                    pdo_update('cqkundian_farm_integral_goods',
                        array('sale_count +='=>$orderDetail['count'],'count -='=>$orderDetail['count']),$goods_where);
                }

                break;
        }
    }

    /**
     * 更新商品库存信息
     * @param  [type] $orderid 订单编号
     * @param  [type] $uniacid 小程序唯一ID
     * @return [type]          [description]
     */
    public function updateGoodsCount($orderid,$uniacid){
        $orderDetail=pdo_get('cqkundian_farm_shop_order_detail',array('order_id'=>$orderid,'uniacid'=>$uniacid));
        if($orderDetail['spec_id']!=0){
            pdo_update('cqkundian_farm_goods_spec',array('count -='=>$orderDetail['count']),array('id'=>$orderDetail['spec_id'],'uniacid'=>$uniacid));
        }else{
            pdo_update($this->tableName,array('count -='=>$orderDetail['count']),array('id'=>$orderDetail['goods_id'],'uniacid'=>$uniacid));
        }
    }

    public function neatenGoodsSpec($goodsData,$spec_id,$uniacid){
        $specItem=pdo_getall('cqkundian_farm_spec',['goods_id'=>$goodsData['id'],'uniacid'=>$uniacid]);  //获取商品的规格项
        $specVal=pdo_get('cqkundian_farm_goods_spec',['id'=>$spec_id,'goods_id'=>$goodsData['id'],'uniacid'=>$uniacid]); //用户选择的规格
        //获取购买的sku名称
        $spec_id_arr = explode(',', $specVal['sku_name']);
        for ($i = 0; $i < count($spec_id_arr); $i++) {
            $spec_val = pdo_get('cqkundian_farm_spec_value', array('id' => $spec_id_arr[$i], 'uniacid' => $uniacid));
            for ($j = 0; $j < count($specItem); $j++) {
                if ($specItem[$j]['id'] == $spec_val['spec_id']) {
                    $specItem[$i]['spec_val'] = $spec_val['spec_value'];
                }
            }
        }
        $goodsData['specItem']=$specItem;
        $goodsData['specVal']=$specVal;
        return $goodsData;
    }

    public function calculationShipping($goodsData,$totalPrice,$count,$uniacid){
        $send_price =0;
        $condition=[
            'ikey'=>['frank_method','frank_jian','frank_yuan'],
            'uniacid'=>$uniacid,
        ];
        $nowList=pdo_getall(TABLE_PRE.'set',$condition);
        $set=[];
        foreach ($nowList as $key => $value) {
            $set[$value['ikey']]=$value['value'];
        }
        if($set['frank_method']==1){  //满件包邮
            if((int)$count >= (int)$set['frank_jian']){
                return 0;
            }
        }

        if($set['frank_method']==2){
            if($totalPrice >=$set['frank_yuan']){
                return 0;
            }
        }

        $freight=pdo_get('cqkundian_farm_freight_rule',array('uniacid'=>$uniacid,'id'=>$goodsData['freight']));
        if(!empty($freight)){
            if($goodsData['piece_free_shipping'] || $goodsData['quota_free_shipping']){
                if($goodsData['piece_free_shipping']){
                    if($count<$goodsData['piece_free_shipping']){   //如果当前购买数量小于单品满件包邮
                        if($goodsData['quota_free_shipping']){
                            if($goodsData['quota_free_shipping']>$totalPrice){
                                 $send_price=$this->getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
                            }
                        }else{
                            $send_price=$this->getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
                        }
                    }
                }else{
                    if($goodsData['quota_free_shipping']){
                        if($goodsData['quota_free_shipping']>$totalPrice){
                            $send_price=$this->getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
                        }
                    }else{
                        $send_price=$this->getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
                    }
                }
            }else{
                $send_price=$this->getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
            }
        }
         return $send_price;
    }

    public function getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight){
        if($freight['charge_type']==1){     //按重量计算
            if($goodsData['weight']>$freight['first_piece']){
                $send_price+=$freight['first_price'];
                $send_price+=ceil((($goodsData['weight']*$count-$freight['first_piece'])/$freight['second_piece']))*$freight['second_price'];
            }else{
                $send_price=$freight['first_price'];
            }
        }else{
            if($count>$freight['first_piece']){
                $send_price+=$freight['first_price'];
                $send_price+=ceil((($count-$freight['first_piece'])/$freight['second_piece']))*$freight['second_price'];
            }else{
                $send_price=$freight['first_price'];
            }
        }
        return $send_price;
    }


    /**
     *  获取用户的评论信息
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return mixed
     */
    public function getCommentList($cond=[],$pageIndex='',$pageSize='',$order_by='create_time desc'){
        $query=load()->object('query');
        $where=$cond;
        $where['a.uniacid']=$cond['uniacid'];
        $where['b.uniacid']=$cond['uniacid'];
        if(empty($pageIndex) || empty($pageSize)){

            $list= $query->from('cqkundian_farm_comment', 'a')
                ->leftjoin('cqkundian_farm_user', 'b')->on('a.uid', 'b.uid')
                ->select('a.*','b.nickname','b.avatarurl')
                ->where($where)->orderby($order_by)->getall();
        }else{
            $list= $query->from('cqkundian_farm_comment', 'a')
                ->leftjoin('cqkundian_farm_user', 'b')->on('a.uid', 'b.uid')
                ->select('a.*','b.nickname','b.avatarurl')
                ->where($where)->page($pageIndex,$pageSize)->orderby($order_by)->getall();
        }
        if($list){
            require_once ROOT_PATH.'model/order.php';
            require_once ROOT_PATH.'model/common.php';
            $order=new Order_KundianFarmModel($cond['uniacid']);
            $common=new Common_KundianFarmModel('');
            for ($i=0;$i<count($list);$i++){
                $list[$i]['create_time']=date("Y-m-d",$list[$i]['create_time']);
                $list[$i]['src']=unserialize($list[$i]['src']);
                $orderDetail=pdo_get('cqkundian_farm_shop_order_detail',['order_id'=>$list[$i]['order_id'],'goods_id'=>$list[$i]['goods_id']]);
                $list[$i]['goods_name']=$orderDetail['goods_name'];
                $list[$i]['specStr']='';
                if($orderDetail['spec_id']){
                    $list[$i]['specStr']=$order->getSkuBySpecId($orderDetail['spec_id'],false);
                }

                $list[$i]['wx_nickname']=$common->substr_cut($list[$i]['nickname']);
            }
        }
        return $list;
    }

    /** 添加服务 */
    public function serviceAdd($d,$uniacid){
        $upData=[
            'name'=>$d['name'],
            'content'=>$d['content'],
            'rank'=>$d['rank'],
            'uniacid'=>$uniacid,
        ];
        if(empty($d['id'])){
            $upData['create_time']=time();
            return pdo_insert('cqkundian_farm_goods_service',$upData);
        }
        return pdo_update('cqkundian_farm_goods_service',$upData,['id'=>$d['id'],'uniacid'=>$uniacid]);
    }
}