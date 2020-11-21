<?php

namespace app\base\model;

use think\Model;
use ZhyException;

class Base extends Model
{
    public $required_fields = array();//必填字段
    public $unique = array();//唯一分组
    protected $autoWriteTimestamp = true;
    public $order = '';//默认排序
    public $has_uniacid = true;//是否有 uniacid 字段
    public $where = '';//默认条件

    protected static function init()
    {
        //新增前-验证必填
        self::beforeInsert(function ($model){
            $model->check_required($model);
        });
        //新增前-验证唯一
        self::beforeInsert(function ($model){
            $model->check_unique($model);
        });
        //新增前-添加 uniacid 字段
        self::beforeInsert(function ($model){
            global $_W;
            if ($model->has_uniacid){
                $model->uniacid = $_W['uniacid'];
            }
        });
    }
    //填充排序与分页规则
    public function fill_order_limit($order= true,$limit= true){
        if ($limit) {
            //分页
            $page = input('request.page')?input('request.page'):1;
            $limit = input('request.limit')?input('request.limit'):10;
            if($page){
                $this->limit($limit)->page($page);
            }
        }
        if ($order) {
            //排序
            $order = input('request.orderfield');
            if($order){
                $this->order($order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
            //默认排序规则
            }elseif ($this->order){
                $orders = explode(',',$this->order);
                $order_arr = [];
                foreach ($orders as $order) {
                    $temp = explode(' ',$order);
                    $order_arr[$temp[0]] = isset($temp[1])?strtoupper($temp[1]):'ASC';
                }
                $this->order($order_arr);
            }
        }
        return $this;
    }
    // 验证必填
    protected function check_required($data){
        if ($this->required_fields != array()) {
            foreach ($this->required_fields as $field) {
                if (!(isset($data[$field]) && $data[$field] != null)) {
                    throw new ZhyException("[ $field ]字段不能为空");
                }
            }
        }
    }
    // 验证唯一
    protected function check_unique($data){
        if ($this->unique != array()) {
            foreach ($this->unique as $item) {
                $where = array();
                // 组合
                if (is_array($item)) {
                    foreach ($item as $value) {
                        $where[$value] = $data[$value];
                    }
                    $item = implode(',', $item);
                    $msg = "[ $item ]字段组合唯一";
                }else{
                    $where[$item] = $data[$item];
                    $msg = "[ $item ]字段唯一";
                }
                if ($data['id']) {
                    $where['id'] = ['<>',$data['id']];
                }
                $info = self::get($where);
                if($info){
                    throw new ZhyException($msg);
                }
            }
        }
    }
    protected function scopeIsUsed($query)
    {
        $query->where('state',1);
    }
    // 定义全局的查询范围
    protected function base($query)
    {
        global $_W;
        if($this->has_uniacid && $_W && isset($_W['uniacid']) && $_W['uniacid']){
            $query->where($query->getTable().'.uniacid',$_W['uniacid']);
        }
    }
    /**
     * 获取列表
    */
    public function mlist($where=array(),$order=array(),$page=1,$length=10,$field=''){
        if(!empty($where)){
            if(!empty($order)) {
                if($field!='') {
                    $data=$this->where($where)->order($order)->field($field)->page($page,$length)->select();
                }else {
                    $data=$this->where($where)->order($order)->page($page,$length)->select();
                }
            }else {
                if($field!='') {
                    $data=$this->where($where)->field($field)->page($page,$length)->select();
                }else {
                    $data=$this->where($where)->page($page,$length)->select();
                }
            }
            return json_decode(json_encode($data),true);
        }
        return -1;
    }
    /**
     * 获取单个详情
    */
    public function mfind($where,$field=''){
        if($field!='') {
            $info=$this->where($where)->field($field)->find();
        }else{
            $info=$this->where($where)->find();
        }
        return json_decode($info,true);
    }
}
