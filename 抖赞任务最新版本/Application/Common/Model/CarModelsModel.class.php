<?php
namespace Common\Model;
use Common\Model\BaseModel;

class CarModelsModel extends BaseModel
{
    /**
     * 车品牌
     * @return mixed
     */
    public function brand()
    {
        $cache_name = "CarModelsBrand";
        $list = S($cache_name);
        if( empty($list) ) {
            $list = $this->group('brand')->order('letter asc')->select();
            S($cache_name,$list,86400);
        }
        return $list;
    }

    /**
     * 车系
     * @param $brand
     * @return mixed
     */
    public function chexi($brand)
    {

        $cache_name = "CarModelsChexing_" . $brand;
        $list = S($cache_name);
        if( empty($list) ) {
            $map['brand'] = $brand;
            $list = $this->where($map)->group('chexi')->order('year desc')->select();
            S($cache_name,$list,30*60);
        }
        return $list;
    }

    /**
     * 型号
     * @param $brand
     * @param $chexi
     */
    public function name($brand,$chexi) {
        $map['brand'] = $brand;
        $map['chexi'] = $chexi;
        $list = $this->where($map)->order('year desc')->select();
        return $list;
    }
}
