<?php

namespace app\model;


use think\cache\driver\Redis;

class Panicattrsetting extends Base
{
    //获取选完规格后商品信息
    public function getGoodsAttrInfo($gid,$attr_ids){
        global $_W;
        $cond=array(
            'uniacid'=>$_W['uniacid'],
            'goods_id'=>$gid,
            'attr_ids'=>$attr_ids
        );
        $data=$this->where($cond)->find();
        return $data;
    }
    public function getAttrInfo($pid,$attr_ids){
        global $_W;
        $pid = intval($pid);
        $data = $this->where(array('goods_id' => $pid,'attr_ids'=>$attr_ids,'uniacid'=>$_W['uniacid']))->find();
        return $data;
    }
    public function delRedisAttr($redis,$attr_ids){
        $redis->rm('hpanicattrinfo' . $attr_ids);
    }
}
