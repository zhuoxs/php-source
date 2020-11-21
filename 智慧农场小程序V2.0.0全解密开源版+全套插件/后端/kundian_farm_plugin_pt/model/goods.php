<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/1/26 0026
 * Time: 下午 4:21
 */
defined("IN_IA") or exit('Access Denied');
class Pt_GoodsModel{
    public $uniacid='';
    public $pt_type='cqkundian_farm_pt_type';
    public $pt_goods='cqkundian_farm_pt_goods';
    public $pt_comment='cqkundian_farm_pt_comment';

    public function __construct($uniacid=''){
        global $_W;
        $this->uniacid=$_W['uniacid'];
        if(!empty($uniacid)){
            $this->uniacid;
        }
    }

    /** 添加、编辑组团商品分类*/
    public function addType($request){
        $update=[
            'type_name'=>$request['type_name'],
            'cover'=>tomedia($request['cover']),
            'status'=>$request['status'],
            'rank'=>$request['rank'],
            'uniacid'=>$this->uniacid,
        ];
        if(!empty($request['id'])){
            return pdo_update($this->pt_type,$update,['id'=>$request['id'],'uniacid'=>$this->uniacid]);
        }
        $update['create_time']=time();
        return pdo_insert($this->pt_type,$update);
    }

    /**
     * 获取商品列表信息
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return mixed
     */
    public function getGoodsList($cond=[],$pageIndex='',$pageSize=''){
        $query=load()->object('query');
        if(empty($cond['uniacid'])){
            $cond['uniacid']=$this->uniacid;
        }
        $goodsList=$query->from($this->pt_goods,'a')->leftjoin($this->pt_type,'b')
            ->on('a.type_id','b.id')->select('a.*','b.type_name')->where($cond)->orderby('rank asc')->page($pageIndex,$pageSize)->getall();
        for ($i=0;$i<count($goodsList);$i++){
            $goodsList[$i]['diff_price']=$goodsList[$i]['price']-$goodsList[$i]['pt_price'];
        }
        return $goodsList;
    }
    
}