<?php
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Category;

class Ccategory extends Api
{
//    获取平台分类
    public function getCategorys(){
        global $_W;
        $cat = new Category();
        $list = $cat->with('categorys')
            ->where('state',1)
            ->where('store_id',0)
            ->where('parent_id',0)
            ->select();

        $level = 1;
        foreach ($list as $item) {
            if (count($item['categorys'])){
                $level = 2;
                foreach ($item['categorys'] as $category) {
                    if (count($category['childs'])){
                        $level = 3;
                        break;
                    }
                }
                if ($level == 3){
                    break;
                }
            }
        }
        success_json($list,['img_root'=>$_W['attachurl'],'level'=>$level]);
    }
//    获取商户分类
//    传入：
//          store_id:商户id
    public function getStoreCategorys(){
        $cat = new Category();
        $list = $cat->with('childs')
            ->where('state',1)
            ->where('parent_id',0)
            ->where('store_id',input('request.store_id',0))
            ->select();

        success_withimg_json($list);
    }
    //获得商品分类
    public function index(Category $model){
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $query->where('state',1);
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->select();

        success_withimg_json($list,['couunt'=>$model->where($query)->count()]);
    }
}
