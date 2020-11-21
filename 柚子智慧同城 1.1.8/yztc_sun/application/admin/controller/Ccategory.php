<?php
namespace app\admin\controller;


use app\model\Category;
use app\model\Goods;

class Ccategory extends Base
{
    //    新增页
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model;
        $info->parent_id = input('request.parent_id',0);
        $info->parent_name = input('request.parent_name');
        $this->view->info = $info;
        return view('edit');
    }
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id,"category");
        $this->view->info = $info;
        return view('edit');
    }
//    复制编辑页
    public function copy(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id,"category");
        unset($info->id);
        $this->view->info = $info;
        return view('edit');
    }

//    获取平台分类
    public function get_list_platform(){
        $model = $this->model;

        //条件
        $query = function ($query){
            $query->where('store_id',0);
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $parent_id = input('get.parent_id');
            if ($parent_id){
                $query->where('parent_id',"$parent_id");
            }
        };

        //排序、分页
//        $model->fill_order_limit();

        $list = $model->with('category')->where($query)->order('parent_id asc,index asc')->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
//    获取商家分类
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //$query->where('store_id',$_SESSION['admin']['store_id']);
            $query->where('store_id',0);
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $parent_id = input('get.parent_id');
            if ($parent_id){
                $query->where('parent_id',"$parent_id");
            }
        };

        //排序、分页
//        $model->fill_order_limit();

        $list = $model->with('category')->where($query)->order('parent_id asc,index asc')->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function select_root(){
        $model = $this->model;
        $model->field("id,name as text");
        $list = $model->where('state',1)->select();
        return $list;
    }
    public function select(){
        $parent_id = input('get.parent_id');
        $model = $this->model;
        $model->field("id,name as text");
        if ($parent_id){
            $model->where('parent_id',$parent_id);
        }
        $list = $model->where('state',1)->select();
        return $list;
    }
//    数据保存（新增、编辑）
    public function save(){
        $info = $this->model;

//        判断同一父级下面是否有相同的子集
        $cat_model = new Category();
        $cats = $cat_model
            ->where('parent_id',input("post.parent_id"))
            ->where('name',input("post.name"))
            ->where('id',['<>',input("post.id",0)])
            ->select();
        if (count($cats)){
            throw new \ZhyException('相同父类下不能存在相同的子分类');
        }

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }

        $data = input('post.');
        if (!$data['store_id']){
            //$data['store_id'] = $_SESSION['admin']['store_id'];
        }

        $ret = $info->allowField(true)->save($data);

        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    public function delete(){
        $ids = input('post.ids');
        $ids_new = explode(',',$ids);

        $goods_model = new Goods();
        $cat_model = new Category();

        foreach ($ids_new as $id) {
            $cat_list = $cat_model->where('parent_id',$id)->select();
            if (count($cat_list)){
                $cat = $cat_model->where('id',$id)->find();
                throw new \ZhyException('分类 ['.$cat->name.'] 下有 '.count($cat_list).' 个分类,不能删除');
            }

            $goods_list = $goods_model->where('cat_id',$id)->select();
            if (count($goods_list)){
                $cat = $cat_model->where('id',$id)->find();
                throw new \ZhyException('分类 ['.$cat->name.'] 下有 '.count($goods_list).' 个商品,不能删除');
            }
        }

        $ret = $this->model->destroy($ids);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$ret,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败',
            );
        }
    }
}
